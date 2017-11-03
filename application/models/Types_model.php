<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Types_model extends CI_Model {
    
    public $id;
    public $family;
    public $name;
    
    /**
     * This method is used to get all types of given family from database
     * 
     * @return Array
     */
    public function get_all($family) {
        $this->db->where('family',$family);
        $query = $this->db->get('types');
        return $query->result();
    }
    
    /**
     * This method is used to get all products types from database
     * 
     * @return Array
     */
    public function get_all_product_types() {
        return $this->get_all('product_types');
    }  
}

