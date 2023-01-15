<?php
namespace App\Controllers;
use CodeIgniter\Files\File;
use App\Models\SubjectModel;

class UploadController extends BaseController{
    protected $helpers = ['form'];

    public function index(){
        if( ! $this->isUserSessionValid())
            return redirect()->route('/');
        $data['currentpage'] = 'Upload Subject Data';
        $data['errors'] = [];
        // get subjects from db
        $subjectsModel = new SubjectModel();
        $subjects = $subjectsModel->findAll();
        $data['subjects'] = $subjects;
        return view('pages/dashboard/upload_data', $data);
    }

    public function upload(){
        if( ! $this->isUserSessionValid())
            return redirect()->route('/');
        
        $data['currentpage'] = 'Upload Subject Data';

        //$mimes = config(\Config\Mimes::class);
        //var_dump($mimes); does not work

        $validationRule = [
            'userfile' => [
                'label' => 'CSV File',
                'rules' => [
                    'uploaded[userfile]',
                    'mime_in[userfile,'.implode (',', [
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
                    'max_size[userfile,100000]',// 100000kb max
                ],
            ],
        ];
        if (! $this->validate($validationRule)) {
            $data['errors'] = $this->validator->getErrors();
            return view('pages/dashboard/upload_data', $data);
        }
        

        $file = $this->request->getFile('userfile');

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