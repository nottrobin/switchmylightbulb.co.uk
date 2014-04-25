<?php

/**
 * Model containing information about users
 */
class Model_user extends DataMapper {
    // Table name
    public $table = 'user';
    
    // Timestamp fields
    public $created_field = 'created_on';
    public $updated_field = 'updated_on';
    
    // Relationships
    public $has_many = array(
        'cart_item' => array('class'=>'model_cart_item','other_field'=>'user'),
        'login_key' => array('class'=>'model_login_key','other_field'=>'user'),
        'order' => array('class'=>'model_order','other_field'=>'user'),
        'supplier_rating' => array('class' => 'model_supplier_rating','other_field'=>'user'),
    );
    public $has_one = array(
        'admin_of_supplier' => array('class'=>'model_supplier','other_field'=>'admin'),
    );
    
    // Validation
    public $validation = array(
        'forename' => array(
            'label'         => 'Forename',
            'rules'         => array('trim','required','xss_filter'),
            'field_type'    => 'text',
            'show_in'       => array('list','information'),
        ),
        'surname' => array(
            'label'         => 'Surname',
            'rules'         => array('trim','required','xss_filter'),
            'field_type'    => 'text',
            'show_in'       => array('list','information'),
        ),
        'email_address' => array(
            'label'         => 'Email address',
            'rules'         => array('trim','required','valid_email','unique'),
            'field_type'    => 'email',
            'show_in'       => array('list','information'),
        ),
        'password_hash' => array(
            'label'         => 'Password',
            'rules'         => array('trim','required','sha1'),
            'field_type'    => 'password',
        ),
        'confirm_password' => array(
            'label'         => 'Confirm password',
            'rules'         => array('trim','required','sha1','matches' => 'password_hash'),
            'field_type'    => 'password',
        ),
        'address_1' => array(
            'label'         => 'Address line 1',
            'rules'         => array('trim','required','xss_filter'),
            'field_type'    => 'text',
            'show_in'       => array('information'),
        ),
        'address_2' => array(
            'label'         => 'Address line 2',
            'rules'         => array('trim','xss_filter'),
            'field_type'    => 'text',
            'show_in'       => array('information'),
        ),
        'address_city' => array(
            'label'         => 'City',
            'rules'         => array('trim','xss_filter'),
            'field_type'    => 'text',
            'show_in'       => array('information'),
        ),
        'address_county' => array(
            'label'         => 'County',
            'rules'         => array('trim','xss_filter'),
            'field_type'    => 'text',
            'show_in'       => array('information'),
        ),
        'address_postcode' => array(
            'label'         => 'Postcode',
            'rules'         => array('trim','required','validukpostcode','xss_filter'),
            'field_type'    => 'text',
            'show_in'       => array('information'),
        ),
        'telephone' => array(
            'label'         => 'Contact telephone number',
            'rules'         => array('trim','xss_filter'),
            'field_type'    => 'text',
            'show_in'       => array('information'),
        ),
        'preferred_contact' => array(
            'label'         => 'Preferred contact method',
            'rules'         => array('trim','oneof' => array('email','telephone'),'xss_filter'),
            'field_type'    => 'select',
            'options'       => array('email'=>'Email','telephone'=>'Telephone'),
            'show_in'       => array('information'),
        ),
        'created_on' => array(
            'label'         => 'Created on',
            'rules'         => array('static'),
            'show_in'       => array('information'),
        ),
        'updated_on' => array(
            'label'         => 'Created on',
            'rules'         => array('static'),
            'show_in'       => array('information'),
        ),
        'admin' => array(
            'label'         => 'Administrator',
            'rules'         => array('trim','oneof' => array('0','1'), 'xss_filter'),
            'field_type'    => 'checkbox',
        ),
    );
    
    function permission($type = 'view') {
        $ci =& get_instance();
        
        if (preg_match('/^(view|edit)$/',$type)) {
            if(
                $this->exists() && (
                    check_logged_in(array('user_id' => $this->id)) ||
                    check_logged_in(array('is_admin' => true))
                )
            ) {
                return true;
            }
        } else if($type == 'list') {
            return $this->exists() && check_logged_in() && $ci->current_user->is_admin();
        } else {
            return false;
        }
    }
    
    function login_now() {
        $ci =& get_instance();
        if($this->exists()) {
            // Check account isn't disabled
            if($this->disabled) {
                $this->error_message('disabled','Sorry, this account has been disabled.');
                return false;
            }
            
            $ci->session->set_userdata('current_user_id',$this->id);
            $ci->current_user = $this;

            if(check_logged_in()) {
                $ci->session->set_flashdata('notification','Logged in as <strong>'.$this->email_address.'</strong>.');
                return true;
            }
            else {return false;}
        } else {
            return false;
        }
    }
    
    function login() {
        $ci =& get_instance();
        
        // Check we have some data
        if(empty($this->email_address) && empty($this->password_hash)) {return false;}
        
        $email = $this->email_address;
        
        // Check email address exists
        if(!$this->valid_account($email)) {
            $this->error_message(
                'email_missing',
                'The email address <strong>'.$email.'</strong> is not registered. <a href="/account/create">Create a new account</a> with this email address?'
            );
            return false;
        }
        
        // Try to retrieve user
        $this->validate()->get();
        
        // Check whether we retrieved a user or not
        if($this->exists()) {
            return $this->login_now();
        } else {
            $this->email_address = $email;
            $this->error_message('invalid_password','The user could not be logged in. Try a different password.');
            return false;
        }
    }
    
    function register() {
        $ci =& get_instance();
        
        $this->validate();
        if($this->valid) {
            $this->save();
            if(!$this->login()) {show_error('Could not log in newly created user!');}
            $ci->session->set_flashdata('notification','User <strong>'.$this->email_address.'</strong> created and logged in.');
            return true;
        } else {
            return false;
        }
    }
    
    function valid_account($email) {
        $user = new Model_user();
        if($user->where('email_address',$email)->get()->result_count() == 1) {
            return true;
        } else {
            return false;
        }
    }
    
    function admin_of_supplier($options = array()) {
        if(!$this->exists()) {return false;}
        if($options['supplier_id'] && $options['supplier_id'] == $this->admin_of_supplier_id) {return true;}
        if(!$options['supplier_id'] && $this->admin_of_supplier_id) {return $this->admin_of_supplier_id;}
        
        return false;
    }
    
    function is_admin() {
        return ($this->exists() && $this->admin == '1');
    }
    
    // Cart functions
    // ===
    
    // load_cart - if there are items in the shopping cart, store them in database under $this user
    // otherwise attempt to load cart with this user's items from the database
    function load_cart() {
        $ci =& get_instance();
        // Check if we have a cart
        if(count($ci->cart->contents()) > 0) {
            // If so store it in database under user
            $this->store_cart();
        } else {
            // If not, load cart from database
            foreach($this->cart_item->get() as $cart_item) {
                $bulb = $cart_item->energy_saving_bulb->get();
                $ci->cart->insert(array(
                    'id'            => $bulb->id,
                    'qty'            => $cart_item->quantity,
                    'price'          => $bulb->lower_price,
                    'upper_price'    => $bulb->upper_price,
                    'name'           => $bulb->name,
                ));
            }
        }
    }
    
    // store_cart - store the current cart's items in the database under this user
    function store_cart() {
        $ci =& get_instance();
        
        // Delete previous cart items from DB
        $this->delete_cart();
        
        // Add each item in turn to the database
        foreach($ci->cart->contents() as $item) {
            if($this->add_cart_item($item['id'],$item['qty'])) {continue;}
            else {return false;}
        }
        return true;
    }
    
    // add_update_cart_item - if user's cart already has this item, update the quantity. Otherwise, add it.
    function add_update_cart_item($bulb_id,$quantity) {
        if($quantity == 0) {$this->delete_cart_item($bulb_id);}
        else {
            // Add/update item
            if($this->cart_item->where('energy_saving_bulb_id',$bulb_id)->get()->result_count() == 0) {
                $this->add_cart_item($bulb_id,$quantity);
            } else {
                $this->update_cart_item($bulb_id,$quantity);
            }
        }
    }
    
    // update_cart_item - Update the quantity of an item in the user's cart
    function update_cart_item($bulb_id,$quantity) {
        $this->cart_item->where('energy_saving_bulb_id',$bulb_id)->update('quantity',$quantity);
    }
    
    // add_cart_item - add a new item to the user's cart items
    function add_cart_item($bulb_id,$quantity) {
        $cart_item = new Model_cart_item();
        $cart_item->energy_saving_bulb_id = $bulb_id;
        $cart_item->quantity = $quantity;
        $cart_item->user_id = $this->id;
        $cart_item->save();
    }
    
    // delete_cart_item - delete a single item from the cart
    function delete_cart_item($bulb_id) {
        if($this->cart_item->where('energy_saving_bulb_id',$bulb_id)->get()->delete()) {
            return true;
        } else {
            return false;
        }
    }
    
    // delete_cart - delete all $this user's cart items
    function delete_cart() {
        if($this->cart_item->get()->delete_all()) {
            return true;
        } else {
            return false;
        }
    }
    
    function create_order() {
        $order = new Model_order();
        $order->user_id = $this->id;
        $order->save();
        return $order;
    }
}

/* End of file model_user.php */
/* Location: ./application/models/model_user.php */
