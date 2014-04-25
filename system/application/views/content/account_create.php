    
    <hgroup>
      <h1>Registration form</h1>
      <?if($supplier_admin):?><h2>Supplier administrator account</h2><?endif?>
    </hgroup>
    
    <?if($supplier_admin):?>
    <p>Please register a new account to be the new supplier adminstrator account. After the new account has been created you will be redirected to the supplier application form.</p>
    <p>If you already have an account you'd like to use as the admin account please <a href="/account/login">login</a> with that account instead.</p>
    <?else:?>
    <p>Please use the following form to register a new account. If you already have an account, please <a href="/account/login">login</a> instead.</p>
    <?endif?>
    
    <div id="errors">
    <?foreach($record->error->all as $error):?>
      <?=$error?>
    <?endforeach?>
    </div>
    
    <form method="post">
      <section class="column"
        <label for="field_forename">Forename:</label><br/>
        <input type="text" id="field_forename" value="<?=$record->forename?>" name="forename" /><br/>
        
        <label for="field_surname">Surname:</label><br/>
        <input type="text" id="field_surname" value="<?=$record->surname?>" name="surname" /><br/>
        
        <label for="field_email_address">Email address:</label><br/>
        <input type="email" id="field_email_address" value="<?=$record->email_address?>" name="email_address" /><br/>
        
        <label for="field_password">Password:</label><br/>
        <input type="password" id="field_password" name="password" /><br/>
        
        <label for="field_confirm_password">Confirm password:</label><br/>
        <input type="password" id="field_confirm_password" name="confirm_password" /><br/>
      </section>
      
      <section class="column">
        <label for="field_address_1">Address line 1:</label><br/>
        <input type="text" id="field_address_1" value="<?=$record->address_1?>" name="address_1" /><br/>
        
        <label for="field_address_2">Address line 2 <small>(optional)</small>:</label><br/>
        <input type="text" id="field_address_2" value="<?=$record->address_2?>" name="address_2" /><br/>
        
        <label for="field_address_city">City <small>(optional)</small>:</label><br/>
        <input type="text" id="field_address_city" value="<?=$record->address_city?>" name="address_city" /><br/>
        
        <label for="field_address_county">County <small>(optional)</small>:</label><br/>
        <input type="text" id="field_address_county" value="<?=$record->address_county?>" name="address_county" /><br/>
        
        <label for="field_address_postcode">Postcode:</label><br/>
        <input type="text" id="field_address_postcode" value="<?=$record->address_postcode?>" name="address_postcode" /><br/>
        
        <label for="field_telephone">Contact telephone <small>(optional)</small>:</label><br/>
        <input type="text" id="field_telephone" value="<?=$record->telephone?>" name="telephone" /><br/>
        
        <label for="field_preferred_contact">Preferred contact method:</label><br/>
        <select id="field_preferred_contact" name="preferred_contact">
          <option value="email"<?if($record->preferred_contact == 'email'):?> selected="selected"<?endif?>>Email</option>
          <option value="telephone"<?if($record->preferred_contact == 'telephone'):?> selected="selected"<?endif?>>Telephone</option>
        </select>
      </section>
      
      <button type="submit">Create user and login</button>
    </form>
