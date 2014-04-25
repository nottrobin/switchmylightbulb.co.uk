<?php

/**
 * Model containing orders
 */
class Model_order extends DataMapper {
    // Table name
    var $table = 'order';
    
    // Timestamp fields
    var $created_field = 'created_on';
    var $updated_field = 'updated_on';
    
    // Relationships
    var $has_many = array(
        'order_item' => array('class'=>'model_order_item','other_field'=>'order'),
        'supplier' => array('class'=>'model_supplier','other_field'=>'order'),
    );
    var $has_one = array(
        'user' => array('class'=>'model_user','other_field'=>'order'),
    );
    
    function add_item($bulb_id,$quantity) {
        $item = new Model_order_item();
        $item->energy_saving_bulb_id = $bulb_id;
        $item->quantity = $quantity;
        $item->order_id = $this->id;
        $item->save();
    }
    
    function add_supplier($supplier_id) {
        $supplier = new Model_supplier();
        $supplier->get_by_id($supplier_id);
        $this->save_supplier($supplier);
    }
    
    function lower_total() {
        $items = $this->order_item->get();
        $total = 0;
        foreach($items as $item) {
            $total += intval($item->lower_subtotal());
        }
        return number_format($total,2);
    }
    
    function upper_total() {
        $items = $this->order_item->get();
        $total = 0;
        foreach($items as $item) {
            $total += intval($item->upper_subtotal());
        }
        return number_format($total,2);
    }
    
    function total_quantity() {
        $items = $this->order_item->get();
        $quantity = 0;
        foreach($items as $item) {
            $quantity += $item->quantity;
        }
        return $quantity;
    }
}

/* End of file model_order.php */
/* Location: ./application/models/model_order.php */
