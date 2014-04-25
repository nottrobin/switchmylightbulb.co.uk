<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function read_notifications() {
    $ci =& get_instance();
    
    $ci->data = array();
    if($ci->session->flashdata('notification')) {
        $ci->data['notification'] = $ci->session->flashdata('notification');
    }
}

function pass_user_data() {
    $ci =& get_instance();
    
    check_logged_in();
}
