<?php

namespace App\Controllers\Auth;
use CodeIgniter\Shield\Controllers\RegisterController;

class MyRegisterController extends RegisterController{
    public function registerView(){
        return view('messages/function_not_available');
    }
}
