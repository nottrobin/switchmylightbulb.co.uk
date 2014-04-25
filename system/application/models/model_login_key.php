<?php

/**
 * Model containing unique keys for users who have forgotten their passwords
 */
class Model_login_key extends DataMapper {

    var $table = 'login_key';
    
    var $created_field = 'created_on';
    var $updated_field = 'updated_on';

    var $has_one = array(
        'user' => array('class'=>'model_user','other_field'=>'login_key')
    );
    
    function clear_expired($user_id = false) {
        // Clear all expired unique keys
        $this->where('expires <',date("Y-m-d G:i"))->get()->delete();
        if(isset($user_id)) {$this->clear_keys_for_user($user_id);}
    }
    
    function clear_keys_for_user($user_id) {
        $this->where('user_id',$user_id)->get()->delete();
    }
    
    // Create new unique key for this user
    function create_key($user_id) {
        // Clear existing keys
        $this->clear_expired($user_id);
        // Get expiry date for 24 hours' time
        $expires = date("Y-m-d G:i",mktime(date("H"),  date("i"), date("s"), date("m")  , date("d")+1, date("Y")));
        // Get a unique key
        $unique_key = sha1(uniqid());
        // Store new unique key
        $this->user_id = $user_id;
        $this->expires = $expires;
        $this->unique_key = $unique_key;
        if($this->save()) {
            return $unique_key;
        } else {
            return false;
        }
    }
    
    function delete_key($unique_key) {
        $this->where('unique_key',$unique_key)->get()->delete();
    }
    
    function login_with_key($unique_key) {
        $this->clear_expired();
        
        // Retrieve this key
        $this->where('unique_key',$unique_key)->get();
        
        // Check we have one
        if($this->exists()) {
            // Get user account
            $user = $this->user->get();
            // Login
            return $user->login_now();
        } else {
            // No login key, fail
            return false;
        }
    }
}

/* End of file model_login_key.php */
/* Location: ./application/models/model_login_key.php */
