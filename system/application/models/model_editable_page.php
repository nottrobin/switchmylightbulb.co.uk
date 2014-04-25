<?php

/**
 * Model containing orders
 */
class Model_editable_page extends DataMapper {
    // Table name
    var $table = 'editable_page';
    
    // Timestamp fields
    var $created_field = 'created_on';
    var $updated_field = 'updated_on';
    
    // Relationships
    var $has_many = array();
    var $has_one = array();
    
    var $validation = array(
        'title' => array(
            'label' => 'Title',
            'rules' => array('trim','required','xss_filter'),
        ),
        'content' => array(
            'label' => 'Page content',
            'rules' => array('required','xss_filter'),
        ),
        'html' => array(
            'label' => 'Content format',
            'rules' => array('oneof'=>array('0','1')),
        ),
    );
}

/* End of file model_order.php */
/* Location: ./application/models/model_order.php */
