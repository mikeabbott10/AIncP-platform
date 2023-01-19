<?php
namespace App\Controllers;

use CodeIgniter\Database\Query;
use App\Models\SessionModel;
use App\Models\FilePathModel;
use CodeIgniter\Files\File;

class SessionsController extends BaseController{
    /**
     * show all sessions of one subject
     * @param subjId the id of the subject
     */
    public function index($subjId){
        if( ! $this->isUserSessionValid())
            return redirect()->route('/');
        return $this->showSubjectSessionsView($subjId);
    }

    /**
     * delete session
     * @param subjId the id of the subject
     * @param id the id of the session we want to remove
     */
    public function delete_session($subjId, $id=-1){
        if( ! $this->isUserSessionValid())
            return redirect()->route('/');

        $sessionModel = new SessionModel();
        $sessionModel->delete($id);
        
        return $this->showSubjectSessionsView($subjId);
    }

    /**
     * add session
     * @param subjId the id of the subject
     */
    public function add_session($subjId){
        if( ! $this->isUserSessionValid())
            return redirect()->route('/');

        $data['tags'] = $this->loadTags();
        if(!$data['tags'])
            return $this->showSubjectSessionsView($subjId, $data);
        
        $data['subject'] = $this->loadSubject($subjId);
        if(!$data['subject'])
            return $this->showSubjectSessionsView($subjId, $data);

        helper('form');
        return $this->showSubjectAddSessionView($subjId, $data);
    }

    /**
     * upload session data
     * @param subjId the id of the subject
     */
    public function upload_file($subjId){
        if( ! $this->isUserSessionValid())
            return redirect()->route('/');
        if (! $this->request->is('post')) {
            // The form is not submitted
            $data['errors'] = ['Error while submitting the form'];
            return $this->showSubjectSessionsView($subjId, $data);
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
            return $this->showSubjectSessionsView($subjId, $data);
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
            //$data['data'] = $this->getFileData($data['uploaded_fileinfo']->openFile());
            $data['data'] = [];
            $data['controller'] = $this;
            $data['data_file'] = $data['uploaded_fileinfo']->openFile();
            $data['file_id'] = $insertedRowId;

            $data['tags'] = $this->loadTags();
            if(!$data['tags']){
                return $this->showSubjectSessionsView($subjId, $data);
            }

            $data['subject'] = $this->loadSubject($subjId);
            if(!$data['subject']){
                return $this->showSubjectSessionsView($subjId, $data);
            }

            helper('form');
            return $this->showSubjectAddSessionView($subjId, $data);
        }

        $data['errors'] = 'The file has already been moved.';
        return $this->showSubjectSessionsView($subjId, $data);
    }

    /**
     * upload session data
     * @param subjId the id of the subject
     */
    public function upload_session_data($subjId){
        if( ! $this->isUserSessionValid())
            return redirect()->route('/');
        if (! $this->request->is('post')) {
            // The form is not submitted
            $data['errors'] = ['Error while submitting the form'];
            return $this->showSubjectSessionsView($subjId, $data);
        }

        // get data
        $post = $this->request->getPost([
            'file_id', 'start_time', 'end_time', 'tag_id', 'notes'
        ]);

        // Checks whether the submitted data passed the validation rules.
        if (! $this->validation->run($post, 'session_rules')) {
            // The validation fails, so returns the form.
            $data['errors'] = ['Error while submitting the form'];
            return $this->showSubjectSessionsView($subjId, $data);
        }

        // save new session
        $sessionModel = model(SessionModel::class);
        $sessionModel->save($post);
        
        return redirect()->to(base_url("/dashboard/subject/{$subjId}/session"));
        //return redirect()->route("dashboard/subject/{$subjId}/session"); // won't work here idk why
    }

    public function getFileDataChunk($splFile, $index){
        $plot = array();
        $end_index = $index + 50; // chunk is 50 rows
        $eof = false;
        while ($index<$end_index) {
            if($splFile->eof()){
                $eof = true;
                break;
            }
            $row = $splFile->fgetcsv();
            if(is_null($row[0]) || strcmp($row[0],'datetime')==0)
                continue;
            list($datetime, $x_D, $y_D, $z_D, $x_ND, $y_ND, $z_ND) = $row;
            $vec_D = $this->getVecMag($x_D, $y_D, $z_D);
            $vec_ND = $this->getVecMag($x_ND, $y_ND, $z_ND);
            $vecSum = $vec_D + $vec_ND;
            $AI = $vecSum==0 ? 0 : 100*($vec_D - $vec_ND)/($vecSum);
            $plot[] = ['x'=>$datetime, 'y'=>floor($AI)];
            $index++;
        }
        return ['plot'=>$plot, 'next_index'=>$index, 'eof'=>$eof];
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
