<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts_model extends CI_Model {
    
    public $id;
    public $username;
    public $password;
    public $name;
    public $lastname;
    public $created;
    
    /**
     * This method is used check account credentials
     * 
     * @return Array
     */
    public function login($username, $password) {
        $this->db->select('id');
        $this->db->from('accounts');
        $this->db->where('UPPER(username)', strtoupper($username));
        $this->db->where('password', md5(md5($password)));
        $this->db->limit(1);
        $query = $this->db->get();
        if (!$query->num_rows() == 1){ return false; }
        return $query->row()->id;
    }
    
    public function one($id) {
        $this->db->select('id, name, lastname, username, is_admin');
        $this->db->from('accounts');
        $this->db->where('id', $id);
        $this->db->limit(1);
        return $this->db->get()->row();
    }
    
    /**
     * This method is used to insert an account account in database 
     * 
     * @param Array $data
     */
    public function add($data) {
        $this->db->insert('accounts',$data);
    }
    
    /**
     * This method is used to get all accounts from database
     * 
     * @return Array
     */
    public function get_all() {
        $query = $this->db->get('accounts');
        return $query->result();
    }
    
}

