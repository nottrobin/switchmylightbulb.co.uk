<?php

class Account extends Controller {
    
    function __construct() {
        parent::Controller();
    }
    
    function index() {
        // need to redirect somewhere
        redirect('/account/shopping_cart');
    }
    
    function summary() {
        if(!check_logged_in()) {redirect('/account/login');}
        $this->data['content_template'] = 'account_summary.php';
        $this->load->view('main_wrapper', $this->data);
    }
    
    function login() {
        $this->history->exclude();
        
        // Prep user data
        $user = new Model_user();
        $user->email_address = $this->input->post('email_address');
        $user->password_hash = $this->input->post('password');
        
        // Try logging in
        if(!empty($_POST) && $user->login()) {
            // Registered and logged in
            // Load cart
            $user->load_cart();
            // Redirect the user back to their original page
            //~ $previous_page = $this->history->pop();
            //~ if(!$previous_page || $previous_page == ){$previous_page = '/';}
            redirect('/');
        } else {
            // Not logged in - display the login form
            $this->data['record'] = $user;
            $this->data['title'] = 'Login | ' . $this->config->item('site_name');
            $this->data['content_template'] = 'account_login.php';
            $this->load->view('main_wrapper',$this->data);
        }

        return true;
    }
    
    function logout() {
        // Don't include logout in the history
        $this->history->exclude();
        // Destroy our session - removing user data
        $this->session->sess_destroy();
        // Return to last page of history
        redirect($this->history->pop());
        return true;
    }
    
    function create($control = false) {
        $this->history->exclude();
        
        $supplier_admin = false;
        $checkout_redirect = false;
        if($control == 'supplier_admin') {$supplier_admin = true;}
        else if($control == 'checkout_redirect') {$checkout_redirect = true;}
        
        $user = new Model_user();
        $user->forename             = $this->input->post('forename');
        $user->surname              = $this->input->post('surname');
        $user->email_address        = $this->input->post('email_address');
        $user->password_hash        = $this->input->post('password');
        $user->confirm_password     = $this->input->post('confirm_password');
        $user->address_1            = $this->input->post('address_1');
        $user->address_2            = $this->input->post('address_2');
        $user->address_city         = $this->input->post('address_city');
        $user->address_county       = $this->input->post('address_county');
        $user->address_postcode     = $this->input->post('address_postcode');
        $user->telephone            = $this->input->post('telephone');
        $user->preferred_contact    = $this->input->post('preferred_contact');
        
        if(!empty($_POST) && $user->register()) {
            // Registered and logged in
            // Send notification email
            send_email('New account created!','account_created');
            // Redirect the user back to their original page
            if($control == 'checkout_redirect') {
                redirect('/account/checkout');
            } else if($control == 'supplier_admin') {
                redirect('/supplier/apply');
            } else {
                redirect($this->history->pop());
            }
        } else {
            $this->data['record'] = $user;
            $this->data['title'] = 'Create an account';
            $this->data['supplier_admin'] = $supplier_admin;
            $this->data['content_template'] = 'account_create.php';
            $this->load->view('main_wrapper',$this->data);
        }
        
        return true;
    }
    
    function request_new_password() {
        if(check_logged_in()) {redirect('/account/summary');}
        
        $user = new Model_user();
        
        if(!empty($_POST)) {
            $email = $this->input->post('email_address');
            
            $user->where('email_address',$email)->get();
            
            if($user->exists()) {
                // Store unique login information
                $login_key_model = new Model_login_key();
                $unique_key = $login_key_model->create_key($user->id);
                if($unique_key) {
                    $this->data['record'] = $user;
                    $this->data['unique_key'] = $unique_key;
                    
                    // Send email with instructions
                    send_email('New password requested','new_password_requested',$email);
                    
                    // Show confirmation message
                    $this->data['title'] = 'New password email sent';
                    $this->data['content_template'] = 'account_request_new_password_email_sent.php';
                    $this->load->view('main_wrapper',$this->data);
                    return true;
                } else {
                    show_error("Failed to save unique password key to database.");
                }
            } else {
                $user->error_message('invalid_email','The email address '. $email. ' does not exist in our database. Would you like to <a href="/account/create">create a new account</a>?');
            }
        }
        
        $this->data['record'] = $user;
        $this->data['title'] = 'Request new password';
        $this->data['content_template'] = 'account_request_new_password.php';
        $this->load->view('main_wrapper',$this->data);
    }
    
    function change_password($unique_key = false) {
        $login_keys = new Model_login_key();
        
        // If we have a unique key, try to log in
        if(!empty($unique_key)) {
            if(!$login_keys->login_with_key($unique_key)) {
                $this->data['title'] = 'Change password - invalid key';
                $this->data['content_template'] = 'account_change_password_missing_key.php';
                $this->load->view('main_wrapper',$this->data);
                return false;
            }
        }
        
        // Check we're logged in
        if(!check_logged_in()) {redirect('/account/login');}
        
        $user = $this->current_user;
        
        // Setup form
        if(!empty($_POST)) {
            $user->password_hash = $this->input->post('password');
            $user->confirm_password = $this->input->post('confirm_password');
            
            if($user->update_validate()) {
                $this->session->set_flashdata('notification','Password successfully changed.');
                $login_keys->delete_key($unique_key);
                redirect('/account/summary');
            }
        }
        
        $this->data['record'] = $user;
        $this->data['content_template'] = 'account_change_password.php';
        $this->load->view('main_wrapper',$this->data);
    }
    
    function information($user_id = NULL) {
        if(!check_logged_in()) {redirect('/account/login');}
        
        $user = $this->current_user;
        
        if(isset($user_id) && $user_id != $this->current_user->id) {
            if($this->current_user->is_admin()) {$user = new Model_user($user_id);}
            else {show_error("You do not have permission to view this user's information.");}
        }
        if(!$user->exists()) {show_error('This user does not exist.');}
        
        if(!empty($_POST)) {
            if($user->update_from_post()) {$this->data['notification'] = 'Information updated';}
            else {$this->data['notification'] = 'Information <strong>could not be updated</strong>!';}
        }
        
        $this->data['record'] = $user;
        $this->data['content_template'] = 'account_information.php';
        $this->load->view('main_wrapper',$this->data);
    }
    
    function orders() {
        if(!check_logged_in()) {redirect('/account/login');}
        $this->data['orders'] = $this->current_user->order->get();
        $this->data['content_template'] = 'account_orders.php';
        $this->load->view('main_wrapper', $this->data);
    }
    
    function order($order_id) {
        if(!check_logged_in()) {redirect('/account/login');}
        $order = new Model_order($order_id);
        
        if(!$order->exists()) {show_error('Invalid order number.');}
        
        $this->data['order'] = $order;
        $this->data['title'] = 'Order information: ' . $order_id;
        $this->data['content_template'] = 'account_order.php';
        $this->load->view('main_wrapper',$this->data);
    }
    
    function rate_suppliers() {
        if(!check_logged_in()) {redirect('/account/login');}
        
        if(!empty($_POST)) {
            $user_ratings = $this->input->post('user_rating');
            $rate_me = $this->input->post('rate_me');
            if(!empty($rate_me)) {
                foreach($rate_me as $key => $value) {
                    $supplier = new Model_supplier($key);
                    if(!$supplier->exists()) {show_error('Cannot find supplier to enable rating');}
                    $supplier->set_user_rating(3);
                }
            } else if(isset($user_ratings)) {
                foreach($user_ratings as $key => $value) {
                    $supplier = new Model_supplier($key);
                    if(!$supplier->exists()) {show_error('Cannot find supplier to update rating');}
                    if($supplier->set_user_rating($value)) {
                        $this->data['notification'] = 'Supplier rating updated.';
                    }
                }
            }
        }
        
        $user = $this->current_user;
        $orders = $this->current_user->order->get();
        $rate_suppliers = array();
        foreach($orders as $order) {
            $suppliers = $order->suppliers->get();
            foreach($suppliers as $supplier) {
                $rate_suppliers[$supplier->id]['supplier'] = $supplier;
                $rate_suppliers[$supplier->id]['orders'][] = $order;
            }
        }
        
        $this->data['suppliers'] = $rate_suppliers;
        $this->data['title'] = 'Rate suppliers';
        $this->data['content_template'] = 'account_rate_suppliers.php';
        $this->load->view('main_wrapper',$this->data);
    }
    
    // checkout - send shopping cart to suppliers
    // ---
    function checkout() {
        // If nothing in cart, redirect to shopping cart for instructions on how to fill it
        if($this->cart->total_items() == 0) {
            $this->session->set_flashdata('notification','There is nothing in your cart. Please add some items before attempting to checkout.');
            redirect('/account/shopping_cart');
        }
        if(!check_logged_in()) {
            $this->session->set_flashdata('notification','Please register an account before checking out. Or if you already have an account, please <a href="/account/login">login</a>.');
            $this->history->push('/account/checkout');
            redirect('/account/create/checkout_redirect');
        }
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules(array(
            array('field'=>'suppliers[]','label'=>'Suppliers','rules'=>'required')
        ));
        $this->form_validation->set_message('required','Please select at least one supplier.');
        
        if($this->form_validation->run() == false) {
            // Load all suppliers from database
            $this->data['records'] = new Model_supplier();
            $this->data['records']->get();
            
            // Display checkout form
            $this->data['title'] = 'Checkout shopping cart';
            $this->data['content_template'] = 'account_checkout.php';
            $this->load->view('main_wrapper',$this->data);
        } else {
            // Send emails to suppliers
            $selected_suppliers = $this->form_validation->set_value('suppliers[]');
            
            // Create order in database
            $order = $this->current_user->create_order();
            
            // Add each item in turn
            foreach($this->cart->contents() as $item) {
                $order->add_item($item['id'],$item['qty']);
            }
            // Add each supplier in turn
            foreach($selected_suppliers as $supplier_id) {
                $order->add_supplier($supplier_id);
            }
            
            // Get suppliers from database
            $this->data['order'] = $order;
            $this->data['records'] = new Model_supplier();
            $this->data['records']->where_in('id',$selected_suppliers)->get();
            
            // Send email to all suppliers
            foreach($this->data['records'] as $supplier) {
                $this->data['supplier'] = $supplier;
                send_email('Bulb quote request - order #'.$order->id,'quote_request',$supplier->business_email);
            }
            
            // Send email to user
            send_email('Shopping cart sent to suppliers - order #'.$order->id,'cart_sent');
            // Show confirmation message
            $this->data['cart_sent'] = true;
            $this->data['title'] = 'Shopping cart sent to suppliers';
            $this->data['content_template'] = 'account_checkout_completed.php';
            $this->load->view('main_wrapper',$this->data);
            // Delete cart and database
            $this->cart->destroy();
            $this->current_user->delete_cart();
        }
    }
    
    // shopping_cart - Display the shopping cart page
    // ---
    function shopping_cart() {
        // Show the template
        $this->data['title'] = 'Shopping cart';
        $this->data['content_template'] = 'account_shopping_cart.php';
        $this->load->view('main_wrapper',$this->data);
    }
    
    // update_cart - change the quantity of an item in the cart.
    // Bulb_id is first argument. Quantity can either be second argument,
    // or can be submitted as POST data
    // ---
    function update_cart($bulb_id,$quantity = NULL) {
        // Find energy-saving bulb by ID
        $bulb = new Model_energy_saving_bulb();
        $bulb->get_by_id($bulb_id);
        
        // Display an error if we didn't find a bulb
        if($bulb->result_count() == 0) {show_error('Cannot add to cart - bulb ID '.$bulb_id.' not found in database.');}
        
        // Get quantity from the form
        if(!isset($quantity)) {
            // Setup form_validation rules
            $this->load->library('form_validation');
            $this->form_validation->set_rules(array(array('field'=>'quantity','label'=>'Quantity','rules'=>'trim|required|is_natural')));
            
            // Check for valid form data
            if($this->form_validation->run() == FALSE) {
                // set a notification explaining the error
                $this->session->set_flashdata('notification','Error adding bulb: '.form_error('quantity'));
            } else {$quantity = $this->form_validation->set_value('quantity');}
        }

        $message = '';
        
        // Check if this item is already in the cart
        if($item = $this->cart->get_item_by_id($bulb->id)) {
            // If so, update the quantity
            if($this->cart->update(array('rowid' => $item['rowid'], 'qty' => $quantity))) {
                if($quantity == 0) {
                    $message = 'Deleted bulb <strong>'.$bulb->name.'</strong> from cart.';
                } else {
                    $message = 'Updated quantity of <strong>'.$bulb->name.'</strong> to '.$quantity.'.';
                }
            } else {$message = 'Bulb <strong>'.$bulb->name.'</strong> could not be updated.';}
        } else {
            // Otherwise, insert new item into the cart
            if($this->cart->insert(
                array(
                   'id'             => $bulb->id,
                   'qty'            => $quantity,
                   'price'          => $bulb->lower_price,
                   'upper_price'    => $bulb->upper_price,
                   'name'           => $bulb->name,
                )
            )) {
                $message = 'Added bulb <strong>'.$bulb->name.'</strong> to basket.';
            } else {$message = 'Bulb <strong>'.$bulb->name.'</strong> could not be added to the cart.';}
        }
        
        // Store item in database under user
        if(check_logged_in()) {
            $this->current_user->add_update_cart_item($bulb_id,$quantity);
        }
        
        // Set the notification
        $this->session->set_flashdata('notification',$message);
        
        // Redirect back to original page or homepage
        redirect($this->history->pop());
    }
}
