<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Session extends CI_Session {
    public $sess_persistant_cookie = true;
    
    function __construct($params = array()) {
        // Run the parent's cookie
        parent::CI_Session($params);
        
        // Set the persistant cookie parameter:
        $this->sess_persistant_cookie = (isset($params['sess_persistant_cookie'])) ? $params['sess_persistant_cookie'] : $this->CI->config->item('sess_persistant_cookie');
    }
    
    /**
     * Write the session cookie
     *
     * @access	public
     * @return	void
     */
    /* Exact copy of the original function except where it says //=== new === */
    function _set_cookie($cookie_data = NULL) {
        if (is_null($cookie_data))
        {
            $cookie_data = $this->userdata;
        }

        // Serialize the userdata for the cookie
        $cookie_data = $this->_serialize($cookie_data);

        if ($this->sess_encrypt_cookie == TRUE)
        {
            $cookie_data = $this->CI->encrypt->encode($cookie_data);
        }
        else
        {
            // if encryption is not used, we provide an md5 hash to prevent userside tampering
            $cookie_data = $cookie_data.md5($cookie_data.$this->encryption_key);
        }
        
        //=== new ===
        // Session or persistant cookie...
        $expire = ($this->sess_persistant_cookie) ? $this->sess_expiration + time() : 0;
        
        // Set the cookie
        $ci =& get_instance();
        $ci->load->helper('cookie');
        set_cookie(array(
            'name'      => $this->sess_cookie_name,
            'value'     => $cookie_data,
            'expire'    => $expire,
            'domain'    => $this->cookie_domain,
            'path'      => $this->cookie_path
        ));
        //=== end new ===
    }
}
