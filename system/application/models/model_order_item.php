<?php

/**
 * Model containing items for orders
 */
class Model_order_item extends DataMapper {
    // Table name
    var $table = 'order_item';
    
    // Timestamp fields
    var $created_field = 'created_on';
    var $updated_field = 'updated_on';
    
    // Relationships
    var $has_one = array(
        'order' => array('class'=>'model_order','other_field'=>'order_item'),
        'energy_saving_bulb' => array('class'=>'model_energy_saving_bulb','other_field'=>'order_item'),
    );
    
    function lower_subtotal() {
        $bulb = $this->energy_saving_bulb->get();
        $subtotal = intval($bulb->lower_price) * $this->quantity;
        return number_format($subtotal,2);
    }
    
    function upper_subtotal() {
        $bulb = $this->energy_saving_bulb->get();
        if(isset($bulb->upper_price)) {$subtotal = intval($bulb->upper_price) * $this->quantity;}
        else {$subtotal = intval($bulb->lower_price) * $this->quantity;}
        return number_format($subtotal,2);
    }
}

/* End of file model_order_item.php */
/* Location: ./application/models/model_order_item.php */
