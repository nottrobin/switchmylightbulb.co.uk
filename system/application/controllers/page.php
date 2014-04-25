<?php

class Page extends Controller {

    function __construct() {
        parent::Controller();
    }
    
    function editable($page_name = null) {
        if(!isset($page_name)) {show_error('No page name included.');}
        if(!$this->show_editable_page($page_name)) {show_error('Unknown page name.');}
    }
    
    /* editable pages */
    private function show_editable_page($page_name) {
        $ci =& get_instance();
        $editable_page = new Model_editable_page();
        $editable_page->where('name',$page_name)->get();
        if(!$editable_page->exists()) {return false;}

        $ci->data['title'] = $editable_page->title . ' | ' . $ci->config->item('site_name');
        $ci->data['editable_page'] = $editable_page;
        $ci->data['content_template'] = 'page_editable.php';
        $ci->load->view('main_wrapper',$ci->data);
        return true;
    }

}

/* End of file index.php */
/* Location: ./system/application/controllers/index.php */
