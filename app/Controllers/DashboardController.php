<?php

namespace App\Controllers;

class DashboardController extends BaseController{
    public function subject($code=-1){
        if( ! $this->isUserSessionValid())
            return redirect()->route('/');
        $data['subject_code'] = $code;
        $data['currentpage'] = 'Subjects';
        return view('pages/dashboard/subject_overview', $data);
    }

}
