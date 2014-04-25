
    <hgroup>
      <h1>Order #<?=$order->id?></h1>
      <h2><?=$ci->current_user->forename?> <?=$ci->current_user->surname?></h2>
    </hgroup>
    
    <p>This page displays information for order number <?=$order->id?>. If you wish to see other orders you can return to the <a href="/account/orders">account orders page</a>.</p>
    
    <h2>Basic information</h2>
    
    <ul>
      <li><strong>Order number:</strong> <?=$order->id?></li>
      <li><strong>Order sent at:</strong> <?=$order->created_on?></li>
    </ul>
    
    <h2>Order items</h2>
    
    <table class="cart_items">
      <tr>
        <th class="name">Name</th>
        <th class="price">Est. price</th>
        <th class="qty">Quantity</th>
      </tr>
      
      <?foreach($order->order_item->get() as $item):?>
      <?$bulb = $item->energy_saving_bulb->get();?>
      <tr>
        <td class="name">
          <a href="/bulbs/information/energy_saving/<?=$bulb->id?>"><?=$bulb->name?></a>
        </td>
        <td class="price">
          &pound;<?=$item->lower_subtotal()?>
          <?if(isset($bulb->upper_price)):?>
            - &pound;<?=$item->upper_subtotal()?>
          <?endif?>
        </td>
        <td class="qty"><?=$item->quantity?></td>
      </tr>
      <?php endforeach ?>
      
      <tr>
        <td class="name"><strong>Estimated total:</strong></td>
        <td class="price">
          &pound;<?=$order->lower_total()?>
          <?if(intval($order->upper_total()) > intval($order->lower_total())):?>
            - &pound;<?=$order->upper_total()?>
          <?endif?>
        </td>
        <td class="qty"><?=$order->total_quantity()?></td>
      </tr>
    </table>
    
    <h2>Sent to suppliers</h2>
    
    <ul>
    <?$suppliers = $order->supplier->get();?>
    <?foreach($suppliers as $supplier):?>
      <li><?=$supplier->company_name?> [<?=$supplier->business_email?>] <a href="<?=$ci->config->site_url()?>supplier/information/<?=$supplier->id?>">more information</a></li>
    <?endforeach?>
    </ul>
