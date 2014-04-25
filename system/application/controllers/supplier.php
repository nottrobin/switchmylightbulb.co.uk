<?php

class Supplier extends Controller {

    function __construct() {
        parent::Controller();
    }
    
    // index - default method
    // if logged in and supplier admin, redirect to supplier page
    // otherwise, redirect to "apply" page
    function index() {
        if(check_logged_in(array('is_supplier_admin' => true))) {
            $this->session->set_flashdata('notification','You are a supplier admin. Redirected "/supplier" to your supplier information page.');
            // Get supplier information
            redirect('/supplier/information/'.$this->current_user->admin_of_supplier_id);
        } else {
            $this->session->set_flashdata('notification','Redirected "/supplier" to "/supplier/apply" (supplier application form).');
            // Apply to become a supplier
            redirect('/supplier/apply/');
        }
    }
    
    // information - Display information about a supplier
    function information($supplier_id = null) {
        // Get supplier
        $supplier = new Model_supplier($supplier_id);
        
        // Check we got a supplier
        if(!$supplier->exists()) {show_error('Cannot retrieve supplier.');}
        
        if(!empty($_POST)) {
            if($supplier->update_from_post()) {$this->data['notification'] = 'Information updated';}
            else {$supplier->data['notification'] = 'Information <strong>could not be updated</strong>!';}
        }
        
        $this->data['record'] = $supplier;
        $this->data['admins'] = $supplier->admin->get();
        $this->data['content_template'] = 'supplier_information.php';
        $this->load->view('main_wrapper',$this->data);
    }
    
    // apply - show the application form for suppliers
    function apply() {
        $this->history->push('/supplier/apply');
        
        // Check we're logged in or go to registration page
        if(!check_logged_in()) {redirect('/account/create/supplier_admin');}
        
        // Check we aren't already linked to a supplier
        if($supplier_id = $this->current_user->admin_of_supplier()) {
            $this->session->set_flashdata(
                'notification',
                'The account <strong>'
                .$this->current_user->email_address.
                '</strong> is already the admin of the supplier <strong>'
                .$this->current_user->admin_of_supplier->get()->company_name.
                '</strong> and cannot register another supplier. To apply to register another supplier please <a href="/account/create/supplier_admin">create another admin account</a>.'
            );
            redirect('/supplier/information/'.$supplier_id);
        }
        
        $this->load->library('form_validation');
        
        // Load supplier model
        $this->data['record'] = new Model_supplier();
        
        // Setup validation rules
        $this->form_validation->set_rules(
            array(
                array('field'=>'company_name','label'=>'Company name','rules'=>'trim|required|xss_clean'),
                array('field'=>'description','label'=>'Description','rules'=>'trim|required||xss_clean'),
                array('field'=>'business_email','label'=>'Business email address','rules'=>'trim|required|valid_email|callback_business_email_unique'),
                array('field'=>'business_phone','label'=>'Business telephone number','rules'=>'trim|xss_clean'),
                array('field'=>'address_line_1','label'=>'Address line 1','rules'=>'trim|xss_clean'),
                array('field'=>'address_line_2','label'=>'Address line 2','rules'=>'trim|xss_clean'),
                array('field'=>'address_city','label'=>'City','rules'=>'trim|xss_clean'),
                array('field'=>'address_county','label'=>'County','rules'=>'trim|xss_clean'),
                array('field'=>'address_postcode','label'=>'Postcode','rules'=>'trim|xss_clean'),
            )
        );
        
        // Check if we have valid regstration form data
        if($this->form_validation->run() == FALSE) {
            // If not, show the registration form
            $this->data['content_template'] = 'supplier_application_form.php';
            $this->load->view('main_wrapper',$this->data);
        } else {
            // If we do
            // Load information into model
            $this->data['record']->company_name = $this->form_validation->set_value('company_name');
            $this->data['record']->description = $this->form_validation->set_value('description');
            $this->data['record']->business_email = $this->form_validation->set_value('business_email');
            $this->data['record']->business_phone = $this->form_validation->set_value('business_phone');
            $this->data['record']->address_line_1 = $this->form_validation->set_value('address_line_1');
            $this->data['record']->address_line_2 = $this->form_validation->set_value('address_line_2');
            $this->data['record']->address_city = $this->form_validation->set_value('address_city');
            $this->data['record']->address_county = $this->form_validation->set_value('address_county');
            $this->data['record']->address_postcode = $this->form_validation->set_value('address_postcode');
            
            // Attempt to store in database
            if($this->data['record']->save()) {
                // Also set current user as admin
                $user = new Model_user();
                $user->where(array('id'=>$this->current_user->id))->update(array('admin_of_supplier_id'=>$this->data['record']->id));
                
                // On success
                // Write session data to log the user in
                $this->session->set_userdata(array('current_user_id' => $this->current_user->id));
                $this->session->set_flashdata('notification',"Supplier created successfully!");
                
                // Redirect to the supplier information page
                redirect('/supplier/information/'.$this->data['record']->id,'refresh');
            } else {
                // On failure, notify the user
                $this->session->set_flashdata('notification',"error: could not create user");
                
                // Reload the registration form
                redirect('/account/create','refresh');
            }
        }
    }
    
    // Helper functions
    // ================
    
    // business_email_unique - Helper function for form_validation
    // Check the email address doesn't already exist in supplier database.
    function business_email_unique($email) {
        // Set error message
        $this->form_validation->set_message('business_email_unique', 'The email address %s already exists in our database. Have you already registered as the supplier <a href="/supplier/information/'.$this->data['record']->id.'">'.$this->data['record']->company_name.'?');
        
        // Find a supplier with this email addess
        $this->data['record']->where('business_email', $email)->get();
        // If supplier exists, return false, otherwise true
        if($this->data['record']->result_count() > 0) {return false;}
        else {return true;}
    }
}

/* End of file index.php */
/* Location: ./system/application/controllers/index.php */
