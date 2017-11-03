<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * Index Page for this controller
     */
    public function index() {
        redirect_if_not_login();
        
        $data[] = [];
        $data['account'] = $account = $this->session->userdata['logged_in'];
        
        $data['last_track'] = 
                $this->tracks->get_last_track_open($account->name, $account->lastname);
        
        $this->load->view('welcome_index', $data);
    }

    /**
     * Index Page for this controller
     */
    public function login() {

        redirect_if_login();

        if ($this->input->method() == 'post') {

            $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[200]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]|max_length[200]');

            if ($this->form_validation->run() && ($id = $this->accounts->login(
                    $this->input->post('username'), $this->input->post('password')
                    ))
            ) {
                $this->session->set_userdata(
                        'logged_in', 
                        $this->accounts->one($id)
                    );
                redirect('welcome/index');
            } else {
                $this->session->set_flashdata('login_error', 'Invalid credentials');
            }
        }

        $data = [];
        $this->load->view('welcome_login', $data);
    }
    
    /**
     * Logout from app
     */
    public function logout() {
        $session_data = ['username' => ''];
        
        $this->session->unset_userdata('logged_in', $session_data);
        
        $this->session->set_flashdata('message', 'Successfully Logout');
        
        redirect_if_not_login();
    }

}
