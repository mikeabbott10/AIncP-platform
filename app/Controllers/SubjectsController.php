<?php

namespace App\Controllers;
use App\Models\TagModel;
use App\Models\SubjectModel;

class SubjectsController extends BaseController{
    protected $helpers = ['form'];
    
    public function index(){
        if( ! $this->isUserSessionValid())
            return redirect()->route('/');
        $data['currentpage'] = 'Subjects';
        $data['subjects'] = $this->loadSubjects();
        return view('pages/dashboard/subject_overview', $data);
    }

    public function subject_card($id=-1){
        if( ! $this->isUserSessionValid())
            return redirect()->route('/');
        $data['currentpage'] = 'Subjects';
        if($id==-1)
            return redirect()->route('dashboard/subjects');

        $data['subject'] = $this->loadSubject($id);
        if(!$data['subject'])
            return redirect()->route('dashboard/subjects');

        $data['tags'] = $this->loadTags();
        if(!$data['tags'])
            return redirect()->route('dashboard/subjects');

        $data['errors'] = [];
        return view('pages/dashboard/subject_card', $data);
    }

    public function delete_subject($id=-1){
        if( ! $this->isUserSessionValid())
            return redirect()->route('/');
        $data['currentpage'] = 'Subjects';
        $subjectModel = new SubjectModel();
        $subjectModel->delete($id);
        return redirect()->route('dashboard/subjects');

    }

    public function add_subject(){
        if( ! $this->isUserSessionValid())
            return redirect()->route('/');
        $data['currentpage'] = 'Subjects';
        $data['tags'] = $this->loadTags();
        if(!$data['tags'])
            return redirect()->route('dashboard/subjects');

        $data['subject'] = $this->get_empty_subject(); 
        $data['errors'] = [];
        return view('pages/dashboard/subject_card', $data);
    }

    public function upload_subject_data($id=-1){
        if( ! $this->isUserSessionValid())
            return redirect()->route('/');
        $data['currentpage'] = 'Subjects';
        if (! $this->request->is('post')) {
            // The form is not submitted
            return redirect()->route('dashboard/subjects');
        }

        // get data
        $post = $this->request->getPost([
            'name', 'surname', 'code', 'gender', 
            'dominance', 'aha', 'macs', 'hemi'
        ]);

        // Checks whether the submitted data passed the validation rules.
        if (! $this->validation->run($post, 'subject_card_rules')) {
            // The validation fails, so returns the form.
            $data['subject'] = $this->get_empty_subject(); 
            $data['errors'] = ['Error while submitting the form'];
            return view('pages/dashboard/subject_card', $data);
        }

        // save new subject
        $model = model(SubjectModel::class);
        if($id!=-1)
            $post['ID'] = $id;
        $model->save($post);

        return redirect()->route('dashboard/subjects');
    }

    public function tag_data($id=-1){
        if( ! $this->isUserSessionValid() || $id==-1)
            return redirect()->route('/');
        $data['currentpage'] = 'Subjects';
        $data['subject'] = $this->loadSubject($id);
        if(!$data['subject'])
            return redirect()->route('dashboard/subjects');
        return view('pages/dashboard/tag_data', $data);
    }

    private function loadTags(){
        $tagsModel = new TagModel();
        return $tagsModel->findAll();
    }

    private function get_empty_subject(){
        return [
            'ID' => '',
            'name' => '',
            'surname' => '',
            'code' => '',
            'dominance' => '',
            'macs' => '',
            'aha' => '',
            'hemi' => '',
            'gender' => ''
        ];
    }
}
