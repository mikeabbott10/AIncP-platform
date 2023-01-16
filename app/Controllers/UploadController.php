<?php
namespace App\Controllers;
use CodeIgniter\Files\File;
use App\Models\TagModel;

class UploadController extends BaseController{
    protected $helpers = ['form'];

    private function loadData(){
        $subjects = $this->loadSubjects();

        $tagsModel = new TagModel();
        $tags = $tagsModel->findAll();

        return [
            'subjects'=>$subjects,
            'tags'=>$tags
        ];
    }

    public function index(){
        if( ! $this->isUserSessionValid())
            return redirect()->route('/');
        $data['currentpage'] = 'Upload Subject Data';
        $data['errors'] = [];
        // get data from db
        $data_from_db = $this->loadData();
        $data['subjects'] = $data_from_db['subjects'];
        $data['tags'] = $data_from_db['tags'];
        return view('pages/dashboard/upload_data', $data);
    }

    public function upload(){
        if( ! $this->isUserSessionValid())
            return redirect()->route('/');
        
        $data['currentpage'] = 'Upload Subject Data';

        //$mimes = config(\Config\Mimes::class);
        //var_dump($mimes); does not work, it's an empty object

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
            return view('pages/dashboard/upload_data', $data);
        }

        $file = $this->request->getFile('data_file');

        if (! $file->hasMoved()) {
            // store file in writeable/uploads folder
            $filepath = WRITEPATH . 'uploads/' . $file->store();

            $data['uploaded_fileinfo'] = new File($filepath);
            // TODO push new file path to db
            return view('pages/dashboard/upload_success', $data);
        }

        $data['errors'] = 'The file has already been moved.';
        return view('pages/dashboard/upload_data', $data);
    }
}