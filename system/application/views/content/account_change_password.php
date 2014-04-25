
    <h1>Change password</h1>
    
    <p>You may now create a new password for the account <strong><?=$record->email_address?></strong> using the form below:</p>
    
    <div id="errors">
    <?foreach($record->error->all as $error):?>
      <?=$error?>
    <?endforeach?>
    </div>
    
    <form method="post">
      <label for="field_password">New password:</label><br/>
      <input type="password" id="field_password" name="password" /><br/>
      <label for="field_confirm_password">Confirm new password:</label><br/>
      <input type="password" id="field_confirm_password" name="confirm_password" /><br/>
      <button type="submit">Create password</button>
    </form>
    
    <p>Back to <a href="/account/summary">account summary</a>.</p>

