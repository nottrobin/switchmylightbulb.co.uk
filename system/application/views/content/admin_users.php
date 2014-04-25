
    <h1>List of users</h1>
    <table>
      <tr>
        <th>Forename</th>
        <th>Surname</th>
        <th>Email address</th>
        <th>Admin</th>
        <th>Disabled?</th>
        <th></th>
      </tr>
      <?php foreach($records as $user) {?>
      <tr>
        <td><?php echo $user->forename ?></td>
        <td><?php echo $user->surname ?></td>
        <td><?php echo $user->email_address ?></td>
        <td><?php if($user->admin) {echo 'yes';} else {echo 'no';} ?></td>
        <td><?if($user->disabled):?>disabled<?else:?>enabled<?endif?> [<a href="/admin/disable_enable_user/<?=$user->id?>">change</a>]</td>
        <td><a href="/account/information/<?php echo $user->id ?>">view/edit</a></td>
      </tr>
      <?php } ?>
    </table>
    <p>If you wish to add a new user, please do so by <a href="/account/create">creating a new account</a>.</p>
