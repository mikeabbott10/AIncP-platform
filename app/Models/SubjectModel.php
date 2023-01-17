<?php

namespace App\Models;

use CodeIgniter\Model;
use stdClass;

class SubjectModel extends Model{
    /**
     * Called during initialization. Appends
     * our custom field to the module's model.
     */
    protected function initialize(){
        $this->table = 'subjects';
        $this->primaryKey = 'ID';
        $this->allowedFields[] = 'ID';
        $this->allowedFields[] = 'name';
        $this->allowedFields[] = 'surname';
        $this->allowedFields[] = 'code';
        $this->allowedFields[] = 'dominance';
        $this->allowedFields[] = 'macs';
        $this->allowedFields[] = 'aha';
        $this->allowedFields[] = 'hemi';
        $this->allowedFields[] = 'gender';
    }
}
