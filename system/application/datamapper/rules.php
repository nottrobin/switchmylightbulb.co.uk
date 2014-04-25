<?php

class DMZ_Rules {
    
    public function rule_validukpostcode($object,$field) {
        $label = $object->validation[$field]['label'];
        
        if(preg_match(
            '/((A[BL]|B[ABDHLNRST]?|C[ABFHMORTVW]|D[ADEGHLNTY]|E[HNX]?|F[KY]|G[LUY]?|H[ADGPRSUX]|I[GMPV]|JE|K[ATWY]|L[ADELNSU]?|M[EKL]?|N[EGNPRW]?|O[LX]|P[AEHLOR]|R[GHM]|S[AEGKLMNOPRSTY]?|T[ADFNQRSW]|UB|W[ADFNRSV]|YO|ZE)[1-9]?[0-9]|([E|N|NW|SE|SW|W]1|EC[1-4]|WC[12])[A-HJKMNPR-Y]|[SW|W]([1-9][0-9]|[2-9])|EC[1-9][0-9]) [0-9][ABD-HJLNP-UW-Z]{2}/',
            $object->{$field}
        )) {
            return true;
        } else {
            //$object->error->validukpostcode = $label . ' is not a valid UK postcode.';
            $object->error_message('validukpostcode','The ' . $label . ' field is not a valid UK postcode.');
        }
    }
    
    public function rule_oneof($object,$field,$options) {
        $label = $object->validation[$field]['label'];
        
        if(preg_match(
            '/^('.implode('|',$options).')$/i',
            $object->{$field}
        )) {
            return true;
        } else {
            $options_string = implode(',',$options);
            $object->error_message('oneof', 'The ' . $label . ' field must be one of: ' . $options_string);
        }
    }
    
    public function rule_static($object,$field) {
        $label = $object->validation[$field]['label'];
        
        $object->error_message('static','The ' . $label . ' field cannot be edited.');
    }
    
    public function rule_between($object,$field,$between) {
        $label = $object->validation[$field]['label'];
        
        if($object->{$field} < $between[0] || $object->{$field} > $between[1]) {
            $object->error_message('between','The ' . $label . ' field must be between ' . $between[0] . ' and ' . $between[1] . '.');
        } else {
            return true;
        }
    }
}

