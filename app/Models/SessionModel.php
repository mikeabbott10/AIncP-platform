<?php

namespace App\Models;

use CodeIgniter\Model;

class SessionModel extends Model{
    /**
     * Called during initialization. Appends
     * our custom field to the module's model.
     */
    protected function initialize(){
        $this->table = 'fileportions';
        $this->primaryKey = 'id';
        $this->allowedFields[] = 'file_id';
        $this->allowedFields[] = 'tag_id';
        $this->allowedFields[] = 'start_time';
        $this->allowedFields[] = 'end_time';
        $this->allowedFields[] = 'date';
    }
}
