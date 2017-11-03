<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {
    
    public function index()
    {
        redirect_if_not_login();
        redirect_if_not_admin();
        
        $data['account'] = $account = $this->session->userdata['logged_in'];
        
        // get all sites
        $data['accounts'] = $this->accounts->get_all();        
        
        // flush data to view
        $this->load->view('accounts_list', $data);
    }
    
    /**
     * Index Page for this controller
     */
    public function add()
    {
        redirect_if_not_login();
        redirect_if_not_admin();
        
        $data = [];
        $data['account'] = $account = $this->session->userdata['logged_in'];        
        $data['redirect_time'] = $this->config->item('redirect_time');
        
        if ($this->input->method() == 'post') {
            
            $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[2]|max_length[200]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[2]|max_length[200]');
            $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[2]|max_length[200]');
            $this->form_validation->set_rules('lastname', 'Password', 'trim|required|min_length[2]|max_length[200]');
            
            if ($this->form_validation->run()) {
                
                $newData['username'] = $this->input->post('username');
                $newData['password'] = generate_password($this->input->post('password'));
                $newData['name'] = $this->input->post('name');
                $newData['lastname'] = $this->input->post('lastname');
                $newData['is_admin'] = $account->is_admin && $this->input->post('is_admin') ? 1 : 0;
                $newData['created'] = date('YmdHis');
                $this->accounts->add($newData);
                $this->session->set_flashdata('redirect', true);
                $this->session->set_flashdata('message', 'Info saved');
            }
        }
        
        // flush data to view
        $this->load->view('account_new', $data);
    }
    
}
