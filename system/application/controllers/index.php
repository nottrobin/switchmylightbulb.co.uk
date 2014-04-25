<?php

class Index extends Controller {

    function __construct() {
        parent::Controller();
    }
    
    function index() {
        $this->data['content_template'] = 'index.php';
        $this->data['title'] = 'Welcome';
        $this->load->view('main_wrapper',$this->data);
    }

}

/* End of file index.php */
/* Location: ./system/application/controllers/index.php */
