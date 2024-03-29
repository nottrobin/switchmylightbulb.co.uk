<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['post_controller_constructor'][] = array(
    'function' => 'read_notifications',
    'filename' => 'hook_functions.php',
    'filepath' => 'hooks',
);

// Load user data properly
$hook['post_controller_constructor'][] = array(
    'function' => 'check_logged_in',
    'filename' => 'general_helper.php',
    'filepath' => 'helpers',
);

$hook['post_controller_constructor'][] = array(
    'function' => 'setup_history',
    'filename' => 'history.php',
    'filepath' => 'hooks',
); 

$hook['post_controller'][] = array(
    'function' => 'push_history',
    'filename' => 'history.php',
    'filepath' => 'hooks',
);

/* End of file hooks.php */
/* Location: ./system/application/config/hooks.php */
