<?php

class DMZ_Custommethods {

    public function update_validate($object) {
        if(!isset($object->stored->id)) {return false;}
        
        $object->validate();
        
        if($object->valid) {
            $this_object = $object;
            foreach($this_object->fields as $field_name) {
                $object->where('id',$this_object->id)->update($field_name,$this_object->{$field_name});
            }
            return true;
        } else {
            return false;
        }
    }
    
    public function generate_information_table($object,$editable = true) {
        $ci =& get_instance();
        
        // Check person has permission to view
        if( !(method_exists($object,'permission') &&  $object->permission('view') && $object->exists()) ) {return false;}
        // Set edit permission
        if(!$object->permission('edit')) {$editable = false;}
        
        $ci->data['fields'] = $object->validation;
        $ci->data['object'] = $object;
        $ci->data['editable'] = $editable;
        
        return get_include_contents('system/application/views/includes/information_table.php');
    }
    
    public function generate_list_table($object) {
        $ci =& get_instance();
        
        if( !(method_exists($object,'permission') &&  $object->permission('list') && $object->exists()) ) {return false;}
        
        $ci->data['fields'] = $object->validation;
        $ci->data['object'] = $object;
        
        return get_include_contents('system/application/views/includes/list_table.php');
    }
    
    public function update_from_post($object) {
        // Check for object, post data and permission
        if(empty($_POST)) {
            $object->error_message('no_post','No form data was received!');
            return false;
        }
        if(!$object->permission('edit')) {
            $object->error_message('permission','You do not have permission to update this record.');
            return false;
        }
        if(!$object->exists()) {
            $object->error_message('not_exists','The record does not exist.');
            return false;
        }
        
        $ci =& get_instance();
        
        $fields = $object->validation;
        
        foreach($fields as $name => $values) {
            // Skip non information fields or static fields
            if(
                !(array_key_exists('show_in',$values) && in_array('information',$values['show_in']))
                || (isset($values['rules']) && in_array('static',$values['rules']))
            ) {continue;}
            
            if(
                array_key_exists('field_type',$values) &&
                $values['field_type'] == 'checkbox' &&
                !$ci->input->post($name)
            ) {
                $object->{$name} = '0';
            } else {
                $object->{$name} = $ci->input->post($name);
            }
        }
        
        if($object->update_validate()) {
            return true;
        } else {
            return false;
        }
    }
}
