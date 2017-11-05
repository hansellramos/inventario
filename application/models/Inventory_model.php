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
    
    public function inventory_report() {
        $this->db->select("p.name, t.name product_type, r.product, r.year_week, group_concat(r.day_of_week, ',', r.outs ORDER BY r.day_of_week SEPARATOR ';') result");
        $this->db->from('inventory_report r');
        $this->db->join('products p', 'p.id = r.product');
        $this->db->join('types t', 'p.product_type = t.id');
        $this->db->group_by('r.product, r.year_week');
        $this->db->order_by('t.name asc,p.name asc');
        return $this->db->get()->result();
    }
    
}

