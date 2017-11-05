<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
    
    public function index()
    {
        redirect_if_not_login();
        
        // get all products
        $data['products'] = $this->products->get_all();
        $data['account'] = $account = $this->session->userdata['logged_in'];
        
        // flush data to view
        $this->load->view('product_list', $data);
    }
    
    /**
     * Index Page for this controller
     */
    public function add()
    {
        redirect_if_not_login();
        
        //Current logged account
        $data['account'] = $account = $this->session->userdata['logged_in'];
        
        $data['product_types'] = $this->types->get_all_product_types();
        
        if ($this->input->method() == 'post') { 
            $product_data['name'] = $name = $this->input->post('name');
            $product_data['product_type'] = $product_type = $this->input->post('product_type');
            $product_data['current_quantity'] = $current_quantity = $this->input->post('current_quantity');
            $currentDate = time();
            $product_data['created'] = $product_data['modified'] = $currentDate;
            $product_data['creator'] = $product_data['modifier'] = $account->id;
            $this->products->add($product_data);
            $this->session->set_flashdata('redirect',true);
            $this->session->set_flashdata('message'
                    , "Producto guardado, Nombre: {$name}");
        }
        
        $data['redirect_time'] = $this->config->item('redirect_time');
        
        // flush data to view
        $this->load->view('product_edit', $data);
    }
    
    public function edit($product_id) {
        
        //Current logged account
        redirect_if_not_login();
        
        $data['account'] = $account = $this->session->userdata['logged_in'];
        
        $data['product'] = $product = $this->products->one($product_id);
        $data['product_types'] = $this->types->get_all_product_types();
        
        if ($this->input->method() == 'post') { 
            $product_data = [];
            if ($this->input->post('name')){
                $product_data['name'] = $name = $this->input->post('name');
            } else {
                $product_data['name'] = $name = $product->name;
            }
            if ($this->input->post('product_type')) {
                $product_data['product_type'] = $product_type = $this->input->post('product_type');
            }
            if ($this->input->post('current_quantity')) {
                $product_data['current_quantity'] = $product_type = $this->input->post('current_quantity');
            }
            $product_data['modified'] = time();
            $product_data['modifier'] = $account->id;
            
            
            $this->products->update($product_id, $product_data);
            $this->session->set_flashdata('redirect',true);
            $this->session->set_flashdata('message'
                    , "Producto guardado, Nombre: {$name}");
        }
        
        $data['redirect_time'] = $this->config->item('redirect_time');
        
        // flush data to view
        $this->load->view('product_edit', $data);
        
    }
    
}
