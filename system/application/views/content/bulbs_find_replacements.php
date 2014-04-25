    <hgroup>
        <h1>Energy saving replacement bulbs</h1>
        <h2>For <?=$record->name?></h2>
    </hgroup>
    
    
    <?php if($record->energy_saving_bulb->count() > 0): ?>
    <p>Following is a list of energy-saving replacement bulbs for <strong><?=$record->name?></strong>. Use the link on the left of each bulb to add it to your basket.</p>
    
    <table id="bulbs_list">
      <tr id="row_heading">
        <th class="col_name">Name</th>
        <th class="col_wattage">Wattage</th>
        <th class="col_voltage">Voltage</th>
        <th colspan="2">&nbsp;</th>
      </tr>
      <?php foreach($record->energy_saving_bulb as $bulb): ?>
      <tr>
        <td class="col_name"><?=$bulb->name?><?if($bulb->requires_adapter):?><sup>*</sup><?endif?></td>
        <td class="col_wattage"><?=$bulb->wattage?></td>
        <td class="col_voltage"><?=$bulb->voltage?></td>
        <td class="col_view"><a href="/bulbs/information/energy_saving/<?=$bulb->id?>">view</a></td>
        <td class="col_add_to_basket">
          <form action="/account/update_cart/<?=$bulb->id?>" method="post">
            <?$qty = $bulb->quantity_in_cart()?>
            <input type="number" min="0" step="1" name="quantity" value="<?=$qty?>" size="1" />
            <button type="submit">update cart</button>
          </form>
        </td>
      </tr>
      <?php endforeach ?>
    </table>
    
    <?if($includes_adapter):?>
      <p>
        <small>
          *: Bulb requires adapter to fit the same socket as the "<?=$record->name?>".
          The adater will be included in the order.
        </small>
      </p>
    <?endif?>
    
    <?php else:?>
    <p>There are currently no energy-saving replacement bulbs for <strong><?=$record->name?></strong>.</p>
    <?php endif?>
    