
        <hgroup>
          <h1>Bulb information</h1>
          <h2><?=$record->name?></h2>
        </hgroup>
        
        <p>Following is all the on the bulb <strong><?=$record->name?></strong> in our database:</p>
        
        <?if($bulb_type == 'non_energy_saving'):?>
        <p><a href="/bulbs/find_replacements/<?=$record->id?>">See energy-saving replacements</a> for this bulb.</p>
        <?elseif($bulb_type == 'energy_saving'):?>
        <?$qty = $record->quantity_in_cart()?>
        <form action="/account/update_cart" method="post">
          <p>
            Quantity of this bulb in your shopping cart:
            <input type="number" min="0" step="1" name="quantity" value="<?=$qty?>" size="1" />
            <button type="submit">Update cart</button>
          </p>
        </form>
        <?endif?>
        
        <table>
          <?foreach($record->stored as $field => $value):?>
          <tr>
            <th><?=$field?></th>
            <td><?=$value?></td>
          </tr>
          <?endforeach?>
        </table>

