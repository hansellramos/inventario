<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products_model extends CI_Model {
    
    public $id;
    public $name;
    public $type;
    public $current_quantity;
    public $created;
    public $creator;
    public $modified;
    public $modifier;
    public $deleted;
    public $deleter;
    
    /**
     * This method is used to get all products from database
     * 
     * @return Array
     */
    public function get_all() {
        $this->db->select('products.id id, products.name name, type.name type, current_quantity');
        $this->db->from('products');
        $this->db->join('type', 'products.product_type = type.id');
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * This method is used to get all products from database
     * 
     * @return Array
     */
    public function one($id) {
        $this->db->where('id',$id);
        $query = $this->db->get('products');
        return $query->row();
    }
    
    /**
     * This method is used to insert an account in database 
     * 
     * @param Array $data
     */
    public function add($data) {
        $this->db->insert('products',$data);
        return $this->db->insert_id();
    }
    
    /**
     * This method is used to insert an account in database 
     * 
     * @param int $id
     * @param Array $data
     */
    public function update($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('products',$data);
    }    
}

