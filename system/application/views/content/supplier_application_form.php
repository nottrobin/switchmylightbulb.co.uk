
    <h1>Supplier application form</h1>
    
    <p>To apply to be included on this site as a supplier of light bulbs to the Westminster area please fill in the form below.</p>
    
    <h2>Admin account</h2>
    
    <p>Since you are logged in as <strong><?=$ci->current_user->email_address?></strong>, this account will become the admin account for the new supplier.</p>
    <p>To create a new admin account for your supplier, please <a href="/account/create/supplier_admin">create an account</a> before filling out this form.</p>
    
    <div id="errors">
      <?php echo validation_errors(); ?>
    </div>
    
    <form method="post">
      <section class="column">
        <label for="field_company_name">Company name:</label><br/>
        <input type="text" id="field_company_name" value="<?=set_value('company_name')?>" name="company_name" /><br/>
        
        <label for="field_description">Description:</label><br/>
        <input type="text" id="field_description" value="<?=set_value('description')?>" name="description" /><br/>
        
        <label for="field_business_email">
          Business email address<br/>
          <small>(customer wish lists will be send here):</small>
        </label><br/>
        <input type="email" id="field_business_email" value="<?=set_value('business_email')?>" name="business_email" /><br/>
        
        <label for="field_business_phone">Business telephone number</label><br/>
        <input type="tel" id="field_business_phone" value="<?=set_value('business_phone')?>" name="business_phone" /><br/>
      </section>
      
      <section class="column">
        <label for="field_address_line_1">Address line 1</label><br/>
        <input type="text" id="field_address_line_1" value="<?=set_value('address_line_1')?>" name="address_line_1" /><br/>
        
        <label for="field_address_line_2">Address line 2</label><br/>
        <input type="text" id="field_address_line_2" value="<?=set_value('address_line_2')?>" name="address_line_2" /><br/>
        
        <label for="field_address_city">City</label><br/>
        <input type="text" id="field_address_city" value="<?=set_value('address_city')?>" name="address_city" /><br/>
        
        <label for="field_address_county">County</label><br/>
        <input type="text" id="field_address_county" value="<?=set_value('address_county')?>" name="address_county" /><br/>
        
        <label for="field_address_postcode">Postcode</label><br/>
        <input type="text" id="field_address_postcode" value="<?=set_value('address_county')?>" name="address_postcode" /><br/>
      </section>
      
      <br/>
      <button type="submit">Create user and login</button>
    </form>
