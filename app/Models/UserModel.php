<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{
    /**
     * Called during initialization. Appends
     * our custom field to the module's model.
     */
    protected function initialize(){
        $this->table = 'users';
        $this->primaryKey = 'ID';
        $this->allowedFields[] = 'ID';
        $this->allowedFields[] = 'code';
        $this->allowedFields[] = 'password';
    }
}