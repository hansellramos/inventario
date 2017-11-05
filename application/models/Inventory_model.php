<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory_model extends CI_Model {
    
    public $id;
    public $product;
    public $in;
    public $out;
    public $current_quantity;
    public $created;
    public $creator;
    
    /**
     * This method is used to insert a product movement in database 
     * 
     * @param Array $data
     */
    public function add($data) {
        $this->db->insert('inventory',$data);
    }
    
}

