<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Cart extends CI_Cart {

    function __construct() {
        parent::CI_Cart();
    }
    
    /**
     * Get the total number of discrete items in the cart
     *
     * Unlike total_items - which gets the number of "entries" in the cart, 
     * but not the actual total number of individual items,
     * this method gives the sum of all $item['qty']s.
     *
     * @access  public
     * @return  integer
     */
    function total_discrete_items() {
        $total = 0;
        foreach($this->contents() as $item) {
            $total += intval($item['qty']);
        }
        return $total;
    }
    
    /* upper_price_subtotal - Helper function for cart.
     * Multiply 'upper_price' by 'qty' */
    function upper_price_subtotal($item) {
        return ($item['upper_price'] * $item['qty']);
    }
    
    /* get_cart_upper_total - Helper function for cart.
     * Adds up all the upper_prices of cart items, returns the total */
    function upper_total() {
        $total = 0;
        foreach($this->contents() as $item) {
            (isset($item['upper_price'])) ? $upper_price = $item['upper_price'] : $upper_price = $item['price'];
            $total += ($upper_price * $item['qty']);
        }
        
        return $total;
    }
    
    // get_row_id - helper function for "update_cart"
    // Uses a bulb_id to get the row_id of an item already in the cart
    // Otherwise returns 'false'
    // ---
    function get_item_by_id($bulb_id) {
        $the_item = false;
        foreach($this->contents() as $item) {
            if($item['id'] == $bulb_id) {$the_item = $item;}
        }
        return $the_item;
    }
}

/* End of file MY_Cart.php */
/* Location: ./system/libraries/application/MY_Cart.php */