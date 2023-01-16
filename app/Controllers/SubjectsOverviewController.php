<?php

namespace App\Controllers;

class SubjectsOverviewController extends BaseController{
    public function subject($code=-1){
        if( ! $this->isUserSessionValid())
            return redirect()->route('/');
        $data['subjects'] = $this->loadSubjects();
        $data['subject_code'] = $code;
        $data['currentpage'] = 'Subjects';
        return view('pages/dashboard/subject_overview', $data);
    }
}
