<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
    
    public function index()
    {
        redirect_if_not_login();
        
        // get all sites
        $data['products'] = $this->products->get_all();
        
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
        
        if ($this->input->method() == 'post') { 
            $product_data['name'] = $name = $this->input->post('name');
            $product_data['product_type'] = $product_type = $this->input->post('product_type');
            $product_data['current_quantity'] = $current_quantity = $this->input->post('current_quantity');
            $currentDate = date('YmdHis');
            $product_data['created'] = $currentDate;
            $product_data['modified'] = $currentDate;
            $this->product->add($product_data);
            $this->session->set_flashdata('redirect',true);
            $this->session->set_flashdata('message'
                    , "Producto guardado, Nombre: {$name}, Referencia: {$product_type}");
        }
        
        $data['redirect_time'] = $this->config->item('redirect_time');
        
        // flush data to view
        $this->load->view('track_edit', $data);
    }
    
}
