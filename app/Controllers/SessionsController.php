<?php
namespace App\Controllers;

use CodeIgniter\Database\Query;
use App\Models\SessionModel;
use App\Models\FilePathModel;
use CodeIgniter\Files\File;
use DateTimeImmutable;

class SessionsController extends BaseController{
    /**
     * show all sessions of one subject
     * @param subjId the id of the subject
     */
    public function index($subjId){
        return $this->showSubjectSessionsView($subjId);
    }

    /**
     * delete session
     * @param subjId the id of the subject
     * @param id the id of the session we want to remove
     */
    public function delete_session($subjId, $id=-1){
        $sessionModel = new SessionModel();
        $sessionModel->delete($id);
        
        return redirect()->to(base_url("/dashboard/subject/{$subjId}/session"));
    }

    /**
     * add session
     * @param subjId the id of the subject
     */
    public function add_session($subjId){
        $data['tags'] = $this->loadTags();
        if(!$data['tags'])
            return redirect()->to(base_url("/dashboard/subject/{$subjId}/session"));
        
        $data['subject'] = $this->loadSubject($subjId);
        if(!$data['subject'])
            return redirect()->to(base_url("/dashboard/subject/{$subjId}/session"));

        helper('form');
        return $this->showSubjectAddSessionView($subjId, $data);
    }

    /**
     * upload session data
     * @param subjId the id of the subject
     */
    public function upload_file($subjId){
        if (! $this->request->is('post')) {
            // The form is not submitted
            $data['errors'] = ['Error while submitting the form'];
            return redirect()->to(base_url("/dashboard/subject/{$subjId}/session"));
        }

        $validationRule = [
            'data_file' => [
                'label' => 'CSV File',
                'rules' => [
                    'uploaded[data_file]',
                    'mime_in[data_file,'.implode (',', [
                        'text/csv',
                        'text/x-comma-separated-values',
                        'text/comma-separated-values',
                        'application/vnd.ms-excel',
                        'application/x-csv',
                        'text/x-csv',
                        'application/csv',
                        'application/excel',
                        'application/vnd.msexcel',
                        'text/plain',
                    ]).']',
                    'max_size[data_file,100000]',// 100000kb max
                ],
            ],
        ];

        if (! $this->validate($validationRule)) {
            $data['errors'] = $this->validator->getErrors();
            return redirect()->to(base_url("/dashboard/subject/{$subjId}/session"));
        }

        $file = $this->request->getFile('data_file');

        if (! $file->hasMoved()) {
            // store file in writeable/uploads folder
            $filepath = WRITEPATH . 'uploads/' . $file->store();

            $data['uploaded_fileinfo'] = new File($filepath);

            // push new file path to db
            $filepathModel = model(FilePathModel::class);
            $filepathModel->save([
                'path'=> $data['uploaded_fileinfo']->getFilename(),
                'subj_id'=>$subjId
            ]);
            $insertedRowId = $filepathModel->insertID();

            // redirect to new session with new file data
            $data['data'] = [];
            $data['controller'] = $this;
            $data['file_id'] = $insertedRowId;
            // update data file for this session
            $this->session->set('data_filepath', $filepath);

            $data['tags'] = $this->loadTags();
            if(!$data['tags']){
                return redirect()->to(base_url("/dashboard/subject/{$subjId}/session"));
            }

            $data['subject'] = $this->loadSubject($subjId);
            if(!$data['subject']){
                return redirect()->to(base_url("/dashboard/subject/{$subjId}/session"));
            }

            helper('form');
            return $this->showSubjectAddSessionView($subjId, $data);
        }

        $data['errors'] = 'The file has already been moved.';
        return redirect()->to(base_url("/dashboard/subject/{$subjId}/session"));
    }

    /**
     * upload session data
     * @param subjId the id of the subject
     */
    public function upload_session_data($subjId){
        if (! $this->request->is('post')) {
            // The form is not submitted
            $data['errors'] = ['Error while submitting the form'];
            return redirect()->to(base_url("/dashboard/subject/{$subjId}/session"));
        }

        // get data
        $post = $this->request->getPost([
            'file_id', 'start_time', 'end_time', 'tag_id', 'notes'
        ]);
        
        $post['start_time'] = date("Y-m-d H:i:s", substr($post['start_time'], 0, -3));
        $post['end_time'] = date("Y-m-d H:i:s", substr($post['end_time'], 0, -3));

        // Checks whether the submitted data passed the validation rules.
        if (! $this->validation->run($post, 'session_rules')) {
            // The validation fails, so returns the form.
            $data['errors'] = ['Error while submitting the form'];
            return redirect()->to(base_url("/dashboard/subject/{$subjId}/session"));
        }

        // save new session
        $sessionModel = model(SessionModel::class);
        $sessionModel->save($post);

        $this->session->remove('data_filepath');
        
        return redirect()->to(base_url("/dashboard/subject/{$subjId}/session"));
        //return redirect()->route("dashboard/subject/{$subjId}/session"); // won't work here idk why
    }

    public function get_plot_data($subjId, $start_time=-1, $end_time=-1){
        // retrieve file from session
        if(!$this->session->has('data_filepath'))
           return redirect()->route('dashboard');

        $file = new File($this->session->get('data_filepath'));
        $file = $file->openFile();
        
        if($start_time<0 || $end_time<0){
            $start_index = 0;
            $file->seek($file->getSize());
            $end_index = $file->key();
        }else{
            [$start_index, $end_index] = $this->convertTimeToIndexes($file, $start_time, $end_time);
        }

        echo json_encode($this->getFileDataChunk($file, $start_index, $end_index));
        return; 
    }

    private function getFileDataChunk($splFile, $start_index, $end_index){
        $plot = array();
        $max_number_of_rendered_points = 500;

        $splFile->seek($splFile->getSize());
        if($splFile->key() < $start_index || $start_index > $end_index || $splFile->key() < $end_index){
            // if unstable indexes, get the whole file
            $start_index = 0;
            $end_index = $splFile->key();
        }
        $splFile->rewind(); // rewind back to the first line

        
        // init iterations values
        $index = $start_index;
        $step_size = ceil(($end_index - $start_index) / $max_number_of_rendered_points);
        if($step_size<=0)
            $step_size=1;

        while ($index < $end_index) {
            if($splFile->eof()){
                break;
            }
            $splFile->seek($index);
            $row = $splFile->fgetcsv();
            if(strcmp($row[0], 'datetime')==0){
                $index += $step_size;
                continue;
            }
            list($datetime, $x_D, $y_D, $z_D, $x_ND, $y_ND, $z_ND) = $row;
            $vec_D = $this->getVecMag($x_D, $y_D, $z_D);
            $vec_ND = $this->getVecMag($x_ND, $y_ND, $z_ND);
            $vecSum = $vec_D + $vec_ND;
            $AI = $vecSum==0 ? 0 : 100*($vec_D - $vec_ND)/($vecSum);
            $t = DateTimeImmutable::createFromFormat("Y-m-d H:i:s", $datetime);
            if($t)
                $plot[] = [$t->format('U')*1000, floor($AI)];
            $index += $step_size;
        }
        return $plot;
    }

    private function convertTimeToIndexes($splFile, $start_time, $end_time){
        $splFile->rewind(); // rewind back to the first line
        $start_index = -1;
        $end_index = -1;
        $currentIndex = -1;
        while (true) {
            $currentIndex++;
            if($splFile->eof()){
                break;
            }
            $row = $splFile->fgetcsv();
            if(strcmp($row[0], 'datetime')==0){
                continue;
            }
            $datetime = $row[0];
            $t = DateTimeImmutable::createFromFormat("Y-m-d H:i:s", $datetime);
            if(!$t)
                continue;
            $datetime = $t->format('U')*1000;
            if($datetime < $start_time)
                continue;
            if($start_index < 0){
                $start_index = $currentIndex;
                continue;
            }
            if($datetime > $end_time){
                $end_index = $currentIndex;
                break;
            }
        }
        if($end_time < 0)
            $end_time = $currentIndex-1;
        
        $splFile->rewind(); // rewind back to the first line
        return [$start_index, $end_index];
    }

    private function getVecMag($x,$y,$z){
        return sqrt(pow(intval($x), 2) + pow(intval($y), 2) + pow(intval($z), 2));
    }

    private function loadSessionsFromSubject($id){
        // Prepare the Query
        $pQuery = $this->db->prepare(static function ($db) {
            $sql = 'SELECT 
                fpo.id as id,
                fpo.start_time as start_time, fpo.end_time as end_time, 
                fpa.path as filepath, 
                t.label as tag,
                fpo.notes as notes
                FROM fileportions fpo 
                left outer join filepaths fpa on fpa.id = fpo.file_id 
                left outer join tags t on fpo.tag_id = t.id
                WHERE fpa.subj_id = ?';

            return (new Query($db))->setQuery($sql);
        });

        // Run the Query
        $results = $pQuery->execute($id);
        return $results->getResultArray();
    }

    private function showSubjectSessionsView($subjId, $data=[]){
        if(!isset($data['errors']))
            $data['errors'] = [];
        $data['currentpage'] = 'Subjects';
        $data['sessions'] = $this->loadSessionsFromSubject($subjId);
        $data['subject'] = $this->loadSubject($subjId);
        return view('pages/dashboard/sessions', $data);
    }

    private function showSubjectAddSessionView($subjId, $data=[]){
        if(!isset($data['errors']))
            $data['errors'] = [];
        $data['currentpage'] = 'Subjects';
        return view('pages/dashboard/new_session', $data);
    }
}
