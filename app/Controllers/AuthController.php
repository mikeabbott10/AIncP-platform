<?php

namespace App\Controllers;
use App\Models\UserModel;

class AuthController extends BaseController{
    public function index(){
        if( $this->isUserSessionValid() ) 
            return redirect()->route('dashboard');
        
        // check if it is a post request
        if($this->request->is('post')){
            // TODO: decommenta in produzione
            // if (! $this->request->isSecure()) {
            //     force_https();
            // }
            return $this->login();
            
        }
        return view('pages/login');
    }

    public function logout(){
        $ses_data = [
            'userid' => -1,
            'usercode' => -1,
            'isLoggedIn' => FALSE
        ];
        $this->session->set($ses_data);
        return redirect()->route('/');
    }

    private function login(){
        $userModel = new UserModel();
        $code = $this->request->getVar('uc');
        $password = $this->request->getVar('pw');
        
        $data = $userModel->where('code', $code)->first();
        
        if($data){
            $pass = $data['password'];
            $authenticatePassword = password_verify($password, $pass);
            if($authenticatePassword){
                $ses_data = [
                    'userid' => $data['ID'],
                    'usercode' => $data['code'],
                    'isLoggedIn' => TRUE
                ];
                $this->session->set($ses_data);
                return redirect()->route('dashboard');
            }else{
                $this->session->setFlashdata('msg', 'Password is incorrect.');
                return redirect()->route('/');
            }
        }else{
            $this->session->setFlashdata('msg', 'Code does not exist.');
            return redirect()->route('/');
        }
    }
}
