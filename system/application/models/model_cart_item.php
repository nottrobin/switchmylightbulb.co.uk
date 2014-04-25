<?php

/**
 * Model containing information about cart items
 */
class Model_cart_item extends DataMapper {

    var $table = 'cart_item';
    
    var $created_field = 'created_on';
    var $updated_field = 'updated_on';

    var $has_one = array(
        'user' => array('class'=>'model_user', 'other_field'=>'cart_item'),
        'energy_saving_bulb' => array('class'=>'model_energy_saving_bulb', 'other_field'=>'cart_item')
    );
}

/* End of file model_cart_item.php */
/* Location: ./application/models/model_cart_item.php */
