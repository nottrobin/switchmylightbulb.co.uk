<?php

/**
 * Model containing information about users
 */
class Model_supplier extends DataMapper {

    var $table = 'supplier';
    
    var $created_field = 'created_on';
    var $updated_field = 'updated_on';
    
    var $has_many = array(
        'admin' => array('class' => 'model_user','other_field'=>'admin_of_supplier'),
        'order' => array('class' => 'model_order','other_field'=>'supplier'),
        'rating' => array('class' => 'model_supplier_rating','other_field'=>'supplier')
    );
    
    // Validation
    public $validation = array(
        'company_name' => array(
            'label'         => 'Company name',
            'rules'         => array('trim','required','xss_filter'),
            'field_type'    => 'text',
            'show_in'       => array('list','information'),
        ),
        'description' => array(
            'label'         => 'Description',
            'rules'         => array('trim','required','xss_filter'),
            'field_type'    => 'text',
            'show_in'       => array('list','information'),
        ),
        'business_email' => array(
            'label'         => 'Contact email',
            'rules'         => array('trim','required','xss_filter'),
            'field_type'    => 'email',
            'show_in'       => array('information'),
        ),
        'business_phone' => array(
            'label'         => 'Contact telephone',
            'rules'         => array('trim','xss_filter'),
            'field_type'    => 'text',
            'show_in'       => array('information'),
        ),
        'address_line_1' => array(
            'label'         => 'Address line 1',
            'rules'         => array('trim','xss_filter'),
            'field_type'    => 'text',
            'show_in'       => array('information'),
        ),
        'address_line_2' => array(
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
            'rules'         => array('trim','xss_filter'),
            'field_type'    => 'text',
            'show_in'       => array('information'),
        ),
        'created_on' => array(
            'label'         => 'Created on',
            'rules'         => array('static'),
            'show_in'       => array('information'),
        ),
        'updated_on' => array(
            'label'         => 'Updated on',
            'rules'         => array('static'),
            'show_in'       => array('information'),
        ),
        
    );
    
    function average_rating() {
        if(!$this->exists()) {return false;}
        
        $ratings = $this->rating->get();
        
        if(!$ratings->exists()) {return false;}
        
        $total_rating = 0;
        foreach($ratings as $rating) {
            $total_rating += $rating->rating;
        }
        
        return $total_rating / $ratings->result_count();
    }
    
    function user_rating() {
        $ci =& get_instance();
        if(!(check_logged_in() && $this->exists())) {return false;}
        
        $rating = new Model_supplier_rating();
        $rating->where(array(
            'supplier_id'   => $this->id,
            'user_id'       => $ci->current_user->id
        ))->get();
        
        if($rating->exists()) {
            return $rating->rating;
        } else {
            return false;
        }
    }
    
    function set_user_rating($user_rating) {
        $ci =& get_instance();
        if(!(check_logged_in() && $this->exists())) {return false;}
        
        $rating = new Model_supplier_rating();
        $rating->where(array(
            'supplier_id'   => $this->id,
            'user_id'       => $ci->current_user->id
        ))->get();

        if($rating->exists()) {
            $rating->rating = $user_rating;
            if($rating->update_validate()) {return true;}
            else {
                foreach($rating->error->all as $error) {
                    $ci->data['errors'][] = $error;
                }
            }
        } else {
            $rating->supplier_id = $this->id;
            $rating->user_id = $ci->current_user->id;
            $rating->rating = $user_rating;
            $rating->validate();
            if($rating->valid) {
                if($rating->save()) {return true;}
            } else {
                foreach($rating->error->all as $error) {
                    $ci->data['errors'][] = $error;
                }
            }
        }
        
        return false;
    }
    
    function permission($type = 'view') {
        $ci =& get_instance();
        
        switch ($type) {
            case 'view': return true;
            case 'edit': 
                return (
                    check_logged_in() && 
                    $this->exists() && 
                    (
                        $this->id == $ci->current_user->admin_of_supplier_id ||
                        $ci->current_user->is_admin()
                    )
                );
            case 'list': return true;
        }
    }
}

/* End of file model_user.php */
/* Location: ./application/models/model_user.php */
