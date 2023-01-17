<?php

namespace App\Models;

use CodeIgniter\Model;

class TagModel extends Model{
    /**
     * Called during initialization. Appends
     * our custom field to the module's model.
     */
    protected function initialize(){
        $this->table = 'tags';
        $this->primaryKey = 'id';
        $this->allowedFields[] = 'id';
        $this->allowedFields[] = 'label';
    }
}
