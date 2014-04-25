<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Authentication {
    
    function authenticate($admin) {
        $CI = get_instance();
        
        if(!($CI->session->userdata('user') && $CI->session->userdata('user')->email_address && $CI->session->userdata('admin') == $admin)) {
            $CI->session->set_userdata('original_uri',$CI->uri->uri_string());
            redirect('/account/login','refresh');
        }
    }
}
