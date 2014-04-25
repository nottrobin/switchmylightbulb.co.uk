<?php

class Admin extends Controller {
    function __construct() {
        parent::Controller();
        
        if(!check_logged_in(array('is_admin' => true))) {
            $this->session->set_flashdata('notification','You do not have permission to view this area - redirecting.');
            $this->history->push('/'.$this->uri->uri_string);
            if(check_logged_in()) {redirect('/account/summary');}
            else {redirect('/account/login');}
        }
    }
    
    // index - The default method for this controller.
    // Just redirects to the "login" method.
    function index() {
        $this->data['content_template'] = 'admin_index.php';
        $this->load->view('main_wrapper',$this->data);
    }
    
    function users() {
        $user = new Model_user();
        $user->get();
        
        $this->data['records'] = $user;
        $this->data['content_template'] = 'admin_users.php';
        $this->load->view('main_wrapper',$this->data);
    }
    
    // all - Display a list of all suppliers in the database
    function suppliers($page = 1) {
        $items_per_page = 15;
        
        $this->data['records'] = new Model_supplier();
        $this->data['records']->get_paged($page,$items_per_page);
        $this->data['pageable_uri'] = '/bulbs/all';
        $this->data['content_template'] = 'admin_suppliers.php';
        $this->load->view('main_wrapper',$this->data);
    }
    
    function add_user() {
    }
    
    function disable_enable_user($user_id) {
        $user = new Model_user($user_id);
        if(!$user->exists()) {show_error('This user does not exist!');}
        
        if($user->disabled) {$user->disabled = 0;}
        else {$user->disabled = 1;}
        $user->update_validate();
        
        redirect('/admin/users');
    }
    
    function update_admin() {
        if(empty($_POST)) {show_error('No data received');}
        $user_id = $this->input->post('user_id');
        $user = new Model_user($user_id);
        if(!$user->exists()) {show_error('That user does not exist');}
        if(!$this->input->post('admin')) {
            $user->admin = '0';
        } else {
            $user->admin = '1';
        }
        if($user->update_validate()) {
            $this->session->set_flashdata('notification','User admin status changed.');
        } else {
            $this->session->set_flashdata('notification','User admin status could not be updated.');
        }
        redirect('/account/information/'.$user_id);
    }
    
    function edit_page($page_id) {
        $page = new Model_editable_page($page_id);
        if(!$page->exists()) {show_error('Page does not exist.');}
        
        if(!empty($_POST)) {
            $page->title = $this->input->post('title');
            $page->content = $this->input->post('content');
            $page->html = $this->input->post('html');
            if($page->update_validate()) {
                $this->data['notification'] = 'Page changes saved successfully.';
            }
        }
        
        $this->data['record'] = $page;
        $this->data['content_template'] = 'admin_edit_page.php';
        $this->load->view('main_wrapper',$this->data);
    }
    
    function edit_pages() {
        $pages = new Model_editable_page();
        
        $this->data['records'] = $pages->get();
        $this->data['content_template'] = 'admin_edit_pages.php';
        $this->load->view('main_wrapper',$this->data);
    }
    
    function edit_user() {
    }
}

/* End of file admin.php */
/* Location: ./system/application/controllers/admin.php */
