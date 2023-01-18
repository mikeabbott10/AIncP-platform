<?php

namespace App\Controllers;
use App\Models\SubjectModel;

class SubjectsController extends BaseController{
    
    /**
     * show subjects table
     */
    public function index(){
        if( ! $this->isUserSessionValid())
            return redirect()->route('/');
        $data['currentpage'] = 'Subjects';
        $data['subjects'] = $this->loadSubjects();
        return view('pages/dashboard/subjects', $data);
    }

    /** show subject card
     * @param id
    */
    public function subject_card($id=-1){
        if( ! $this->isUserSessionValid())
            return redirect()->route('/');
        $data['currentpage'] = 'Subjects';
        if($id==-1)
            return redirect()->route('dashboard/subject');

        $data['subject'] = $this->loadSubject($id);
        if(!$data['subject'])
            return redirect()->route('dashboard/subject');

        $data['tags'] = $this->loadTags();
        if(!$data['tags'])
            return redirect()->route('dashboard/subject');

        helper('form');
        $data['errors'] = [];
        return view('pages/dashboard/subject_card', $data);
    }

    /**
     * delete subject
     * @param id
     */
    public function delete_subject($id=-1){
        if( ! $this->isUserSessionValid())
            return redirect()->route('/');
        $data['currentpage'] = 'Subjects';
        
        $subjectModel = new SubjectModel();
        $subjectModel->delete($id);
        return redirect()->route('dashboard/subject');
    }

    /**
     * add subject
     */
    public function add_subject(){
        if( ! $this->isUserSessionValid())
            return redirect()->route('/');
        $data['currentpage'] = 'Subjects';
        $data['tags'] = $this->loadTags();
        if(!$data['tags'])
            return redirect()->route('dashboard/subject');

        helper('form');
        $data['subject'] = $this->get_empty_subject(); 
        $data['errors'] = [];
        return view('pages/dashboard/subject_card', $data);
    }

    /**
     * upload subject data
     * @param id (optional)
     */
    public function upload_subject_data($id=-1){
        if( ! $this->isUserSessionValid())
            return redirect()->route('/');
        $data['currentpage'] = 'Subjects';
        if (! $this->request->is('post')) {
            // The form is not submitted
            return redirect()->route('dashboard/subject');
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
            $post['id'] = $id;
        $model->save($post);

        return redirect()->route('dashboard/subject');
    }

    private function get_empty_subject(){
        return [
            'id' => '',
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
