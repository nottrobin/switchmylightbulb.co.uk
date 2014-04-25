
    <hgroup>
      <h1>Account summary</h1>
      <h2><?=$ci->current_user->forename?> <?=$ci->current_user->surname?></h2>
    </hgroup>
    
    <p>Welcome to the account summary page for the account: <?=$ci->current_user->email_address?>. Please choose one of the following options:</p>
    
    <ul>
      <li><a href="/account/change_password">Change your password</a></li>
      <li><a href="/account/information">View or change your account details</a></li>
      <li><a href="/account/orders">View your past orders</a></li>
    </ul>
