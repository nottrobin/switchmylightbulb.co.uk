
        <hgroup>
          <h1>Supplier information</h1>
          <h2><?=$record->company_name?></h2>
        </hgroup>
        
        <p>Following is all the information we have for the supplier <strong><?=$record->company_name?></strong> in our database:</p>
        
        <div id="errors">
        <?foreach($record->error->all as $error):?>
          <?=$error?>
        <?endforeach?>
        </div>
        
        <?=$record->generate_information_table();?>
        
        <p><strong>Supplier administrators</strong></p>
        
        <?if($admins->exists()):?>
        <ul>
          <?foreach($admins as $admin):?>
          <li><a href="/account/information/<?=$admin->id?>"><?=$admin->forename?> <?=$admin->surname?></a></li>
          <?endforeach?>
        </ul>
        <?else:?>
        <p>No administrators!</p>
        <?endif?>
        
        <?if(check_logged_in(array('is_admin' => true))):?>
        <p>Back to <a href="/admin/suppliers">supplier list</a></p>
        <?endif?>
        
        <hr/>
        
        <p>To send your shopping cart to this supplier for a quote select them from the <a href="/account/checkout">checkout</a> page.</p>
        
