<?php

/**
 * Model containing information about users
 */
class Model_supplier_rating extends DataMapper {

    var $table = 'supplier_rating';
    
    var $created_field = 'created_on';
    var $updated_field = 'updated_on';
    
    var $has_one = array(
        'supplier' => array('class' => 'model_supplier','other_field'=>'rating'),
        'user' => array('class' => 'model_user','other_field'=>'supplier_rating'),
    );
    
    public $validation = array(
        'rating' => array(
            'label' => 'Rating',
            'rules' => array('integer','between' => array(1,5)),
        ),
    );
}

/* End of file model_user.php */
/* Location: ./application/models/model_user.php */
