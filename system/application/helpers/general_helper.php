<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * CodeIgniter General Helpers
 */

// --------------------------------------------------------------------

/* load_user_data - Login helper
 * If we have a current_user_id, load the user data
 * Returns true if login data successfully loaded
 * False otherwise (e.g. not logged in) */
function check_logged_in($options = array()) {
    $ci =& get_instance();
    
    // Check we have our logged in user id
    if($user_id = $ci->session->userdata('current_user_id')) {
        // Load user data if we haven't already
        if(!isset($ci->current_user)) {
            $ci->current_user = new Model_user();
            $ci->current_user->get_by_id($user_id);
        }
        
        if($ci->current_user->exists()) {
            // If we were passed user_id, check it's the correct user
            if(!empty($options['user_id']) && $options['user_id'] != $ci->current_user->id) {return false;}
            // Check we're an admin if required
            if(!empty($options['is_admin']) && !$ci->current_user->is_admin()) {return false;}
            // Check we're a supplier admin
            if(!empty($options['is_supplier_admin'])) { 
                if($options['supplier_id']) {
                    if(!$ci->current_user->admin_of_supplier($options['supplier_id'])) {return false;}
                } else {
                    if(!$ci->current_user->admin_of_supplier()) {return false;}
                }
            }
            // Confirm we're logged in
            return true;
        }
    }
    
    // We're not logged in, or not as $user_id
    return false;
}

/* get_domain
 * Retrieve the domain name from the base URL */
function get_domain() {
    $ci =& get_instance();
    $base_url = $ci->config->site_url();
    //~ die($base_url);
    if(preg_match('/^http:\/\/([^\/]+)(?:\/|$)/i',$base_url,$matches)) {
        return $matches[1];
    } else {
        return false;
    }
}

/* check_uri
 * Check thge current uri matches the first argument */
function check_uri($uri) {
    $ci =& get_instance();
    if(!isset($ci->uri)) {$ci->load->library('uri');}
    if($ci->uri->uri_string() == $uri) {return true;}
    else {return false;}
}

/* get_include_contents
   Imports and returns the contents of an include file as a variable */
function get_include_contents($filename) {
    $ci =& get_instance();
    if (is_file($filename)) {
        ob_start();
        include $filename;
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }
    return false;
}

/* send_email
 * Sends an email address with the default options */
function send_email($subject,$template_name,$recipient = null) {
    $ci =& get_instance();
    
    // Load email library
    if(!isset($ci->email)) {
        $ci->load->library('email');
        // Set config options
        $config['charset'] = 'utf-8';
        $config['mailtype'] = 'html';
        $ci->email->initialize($config);
    }
    
    // Check we have a recipient
    if(!isset($recipient)) {$recipient = $ci->current_user->email_address;}
    
    // Set up email fields
    $ci->email->from('noreply@'.get_domain(), 'Light bulb finder');
    $ci->email->to($recipient);
    $ci->email->subject($subject);
    $ci->email->message(get_include_contents('system/application/emails/'.$template_name.'.html'));
    $ci->email->set_alt_message(get_include_contents('system/application/emails/'.$template_name.'.txt'));
    
    if(!$ci->email->send()) {
        show_error($ci->email->print_debugger());
        return false;
    } else {
        return true;
    }
}

/* End of file general_helper.php */
/* Location: ./application/helpers/general_helper.php */
