
    <h1>Request new password</h1>
    
    <p>If you forgot your password, you can request a new password on this page. Enter the email address of your account below, and we will send you an email containing a link to change your password.</p>
    
    <div id="errors">
    <?foreach($record->error->all as $error):?>
      <?=$error?>
    <?endforeach?>
    </div>
    
    <form method="post">
      <label for="field_email_address">Email address:</label><br/>
      <input type="text" id="field_email_address" value="<?=$record->email_address?>" name="email_address" /><br/>
      <button type="submit">Request new password</button>
    </form>
    
    <p><a href="/account/login">Back to login form</a>.</p>


