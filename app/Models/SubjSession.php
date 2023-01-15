<?php
/* 
meccanismo adottato da CodeIgniter  
per evitare gli accessi diretti al file 
*/  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');  

namespace App\Entities;
use CodeIgniter\Entity\Entity;

Class SubjSession extends Entity{
    private $start_time;
    private $end_time;
    private $tag;

    public function __construct() { 
        $this->start_time = null;
        $this->end_time = null;
        $this->tag = null;
    }

    /**
     * Static constructor / factory
     */
    public static function create() {
        return new self();
    }
  
    /**
     * getters
     */
    public function get_start_time(){
        return $this->start_time;
    }

    public function get_end_time(){
        return $this->end_time;
    }

    public function get_tag(){
        return $this->tag;
    }

    /**
     * setters
     */
    public function set_start_time($value){
        $this->start_time = $value;
        return $this;
    }

    public function set_end_time($value){
        $this->end_time = $value;
        return $this;
    }

    public function set_tag($value){
        $this->tag = $value;
        return $this;
    }
    
}  
?>