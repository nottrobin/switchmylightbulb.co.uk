
    <h1>Login</h1>

    <?if(check_logged_in()):?>
    <p>You are already logged in as <strong><?=$ci->current_user->email_address?></strong>. Please <a href="/account/logout">logout</a> before trying to login again.</p>
    
    <?else:?>
    <p>Please use your email address and password to login. If you don't have an account please <a href="/account/create">create an account</a>.</p>
    
    <div id="errors">
    <?foreach($record->error->all as $error):?>
      <?=$error?>
    <?endforeach?>
    </div>
    
    <form method="post">
      <label for="field_email_address">Email address:</label><br/>
      <input type="email" id="field_email_address" value="<?=$record->email_address?>" name="email_address" /><br/>
      <label for="field_password">Password:</label><br/>
      <input type="password" id="field_password" name="password" /><br/>
      <br/>
      <button type="submit">Login</button>
    </form>
    <p><a href="/account/request_new_password">Request a new password</a>.</p>
    <p><a href="/account/create">Create an account</a>.</p>
    <?endif?>
