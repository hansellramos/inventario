<?php

function redirect_if_not_login() {
    $CI = get_instance();
    if (!isset($CI->session->userdata['logged_in'])){
        $CI->session->set_flashdata('message', 'You need log in before');
        redirect('welcome/login');
    }
}

function redirect_if_login() {
    $CI = get_instance();
    if (isset($CI->session->userdata['logged_in'])){
        redirect('welcome/index');
    }
}

function redirect_if_not_admin() {
    $CI = get_instance();
    $user = $CI->session->userdata['logged_in'];
    if (!$user->is_admin) {
        $CI->session->set_flashdata('message', 'You are not an admin');
        redirect('welcome/index');
    }
}