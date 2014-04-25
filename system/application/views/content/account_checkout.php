    
    <hgroup>
      <h1>Checkout</h1>
      <h2>Send your shopping cart to suppliers</h2>
    </hgroup>
    
    <p>Please select the suppliers that you would like your shopping cart to be emailed to. They will email you back with a quote within 3-5 working days.</p>
    
    <h2>Suppliers</h2>
    
    <div id="errors">
<?=validation_errors()?>
    </div>
    
    <?if($records->result_count() == 0):?>
      <p>Sorry there are currently no suppliers registered with the system.</p>
    <?else:?>
    <form action="/account/checkout" method="post">
      <input type="hidden" name="user_id" value="<?=$ci->current_user->id?>" />
      <?foreach($records as $record):?>
      <input type="checkbox" value="<?=$record->id?>" id="field_supplier__<?=$record->id?>" name="suppliers[]" />
      <label for="field_supplier_<?=$record->id?>">
        <strong><?=$record->company_name?></strong>
        <!--| <small>(Rating: )</small>-->
        | <small><a href="/supplier/information/<?=$record->id?>">more information</a></small>
      </label>
      <br/>
      <?endforeach?>
      <button type="submit">Send shopping cart</button>
    </form>
    <?endif?>
