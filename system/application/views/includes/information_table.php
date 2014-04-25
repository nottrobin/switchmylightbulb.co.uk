
<? // Set up variables
  $object   = $ci->data['object'];
  $editable = $ci->data['editable'];
  $fields   = $ci->data['fields'];
?>
  <?if($ci->data['editable']):?>
  <?// Include form if information is editable ?>
  <form name="update_information" method="post">
  <?endif?>
    <table class="record_information">
      <?// Add a row for each field ?>
      <?foreach($fields as $name => $values):?>
        <?// skip fields that shouldn't be included in "information" view ?>
        <?if(!(array_key_exists('show_in',$values) && in_array('information',$values['show_in']))) {continue;}?>
      <tr>
        <?// The label for the field ?>
        <th><?=$values['label']?></th>
        <?// The field value ?>
        <td>
          <?// Only use a form field information if information is editable and this field isn't 'static' ?>
          <?if($editable && !(isset($values['rules']) && in_array('static',$values['rules']))):?>
            <?switch($values['field_type']):
              case 'text':?><input type="text" name="<?=$name?>" value="<?=$object->{$name}?>" /><?break;?>
          <?case 'email':?><input type="email" name="<?=$name?>" value="<?=$object->{$name}?>" /><?break;?>
          <?case 'number':?><input type="number" name="<?=$name?>" value="<?=$object->{$name}?>" /><?break;?>
          <?case 'password':?><input type="password" name="<?=$name?>" value="<?=$object->{$name}?>" /><?break;?>
          <?case 'checkbox':?><input type="checkbox" name="<?=$name?>" value="1" <?if($object->{$name}=='1'):?>checked="checked"<?endif?> /><?break;?>
          
          <?case 'select':?>
            <?if(!isset($values['options'])) {continue;}?>
          <select name="<?=$name?>">
            <?foreach($values['options'] as $field_value => $label):?>
            <option value="<?=$field_value?>" <?if($object->{$name}==$field_value):?>selected="selected"<?endif?>>
              <?=$label?>
            </option>
            <?endforeach?>
          </select?>
          <?break;?>
          
          <?case 'radio':?>
          <?if(!isset($values['options'])) {continue;}?>
          <?foreach($values['options'] as $field_value => $label):?>
          <input id="field_<?=$field_value?>" type="radio" name="<?=$name?>" value="<?=$field_value?>" <?if($object->{$name}=='1'):?>checked="checked"<?endif?> />
          <label for="field_<?=$field_value?>"><?=$label?></label?><br/>
          <?endforeach?>
          <?break;?>
          <?endswitch?>
          <?else:?>
          <?// Otherwise just include the standard data?>
          <?=$object->{$name}?>
          <?endif?>
        </td>
      </tr>
      <?endforeach?>
    </table>
  <?if($ci->data['editable']):?>
    <button type="submit">save changes</button>
  </form>
  <?endif?>

