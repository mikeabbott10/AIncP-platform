<?php

namespace App\Models;

use CodeIgniter\Model;

class SessionModel extends Model{
    /**
     * Called during initialization. Appends
     * our custom field to the module's model.
     */
    protected function initialize(){
        $this->table = 'filepaths';
        $this->primaryKey = 'id';
        $this->allowedFields[] = 'path';
        $this->allowedFields[] = 'subj_id';
        $this->allowedFields[] = 'start_time';
        $this->allowedFields[] = 'end_time';
    }
}
