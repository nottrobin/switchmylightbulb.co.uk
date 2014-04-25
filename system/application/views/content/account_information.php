
        <hgroup>
          <h1>User information</h1>
          <h2><?=$record->forename?> <?=$record->surname?></h2>
        </hgroup>
        
        <p>Following is all the information we have for the user <strong><?=$record->forename?> <?=$record->surname?></strong> in our database. If you edit any of this information remember to save any changes.</p>
        <p>Do you want to <a href="/account/change_password">change your password</a>.</p>
        
        <div id="errors">
        <?foreach($record->error->all as $error):?>
          <?=$error?>
        <?endforeach?>
        </div>
        
        <?=$record->generate_information_table()?>
        
        <?if(check_logged_in(array('is_admin' => true))):?>
        <form name="admin_form" action="/admin/update_admin" method="post">
          <input type="hidden" name="user_id" value="<?=$record->id?>" />
          <table class="record_information">
            <tr>
              <th>Administrator</th>
              <td><input type="checkbox" name="admin" value="1" <?if($record->admin == '1'):?>checked="checked"<?endif?> /></td>
            </tr>
          </table>
          <button type="submit">update admin</button>
        </form>
        <?endif?>
        
        <?if($record->admin_of_supplier()):?>
        <p>This user is an administrator of the supplier <a href="/supplier/information/<?=$record->admin_of_supplier_id?>"><strong><?=$record->admin_of_supplier->get()->company_name?></strong></a>.</p>
        <?endif?>
        
        <?if(check_logged_in(array('is_admin' => true))):?>
        <p>Back to <a href="/admin/users">user list</a></p>
        <?endif?>
        
        <p>Back to <a href="/account/summary">account summary</a>.</p>

