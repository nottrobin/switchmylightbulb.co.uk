<?php

/**
 * Model containing energy saving bulbs
 */
class Model_energy_saving_bulb extends DataMapper {

    var $table = 'energy_saving_bulb';
    
    var $created_field = 'created_on';
    var $updated_field = 'updated_on';
    
    var $has_many = array(
        'cart_item' => array('class'=>'model_cart_item','other_field'=>'energy_saving_bulb'),
        'order_item' => array('class'=>'model_order_item','other_field'=>'energy_saving_bulb'),
        'non_energy_saving_bulb' => array('class' => 'model_non_energy_saving_bulb', 'other_field' => 'energy_saving_bulb'),
    );

    function quantity_in_cart() {
        $quantity = 0;
        $ci =& get_instance();
        if(!($this->exists() && isset($ci->cart))) {return $quantity;}
        
        if($item = $ci->cart->get_item_by_id($this->id)) {$quantity = $item['qty'];}
        
        return $quantity;
    }

}

/* End of file model_energy_saving_bulb.php */
/* Location: ./application/models/model_energy_saving_bulb.php */
