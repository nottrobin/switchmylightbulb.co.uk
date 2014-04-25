<pre>
<?php //echo var_dump($ci->sent_cart) ?>
</pre>

        <hgroup>
          <h1>Cart sent</h1>
        </hgroup>
        
        <p>Your shopping cart was sent to the suppliers you requested. You should receive quotes from your selected suppliers within a few days.</p>
        <p>You have been sent an email containing the details of your order.</p>
        <p><small>(Your shopping cart has now been emptied.)</small></p>
        <h2>Suppliers</h2>
        <ul>
        <?foreach($ci->data['records'] as $supplier):?>
          <li><a href="<?=$ci->config->site_url()?>supplier/information/<?=$supplier->id?>"><strong><?=$supplier->company_name?></strong></a> [<?=$supplier->business_email?>]</li>
        <?endforeach?>
        </ul>
        
        <h2>Sent items</h2>
        <table class="cart_items">
          <tr>
            <th class="name">Name</th>
            <th class="price">Est. price</th>
            <th class="qty">Quantity</th>
          </tr>
          
          <?php foreach($ci->cart->contents() as $item): ?>
          <tr>
            <td class="name">
              <a href="<?=$ci->config->site_url()?>bulbs/information/energy_saving/<?=$item['id']?>"><?=$item['name']?></a>
            </td>
            <td class="price">
              &pound;<?=number_format($item['subtotal'],2)?>
              <?if(isset($item['upper_price']) && $item['upper_price'] > 0):?>
                - &pound;<?=number_format($ci->cart->upper_price_subtotal($item),2)?>
              <?endif?>
            </td>
            <td class="qty"><?=$item['qty']?></td>
          </tr>
          
          <?php endforeach ?>
          <tr>
            <td class="name"><strong>Estimated total:</strong></td>
            <td class="price">
              &pound;<?=number_format($ci->cart->total(),2)?>
              <?if(intval($ci->cart->upper_total()) > intval($ci->cart->total())):?>
                - &pound;<?=number_format($ci->cart->upper_total(),2)?>
              <?endif?>
            </td>
            <td class="qty"><?=$ci->cart->total_discrete_items()?></td>
          </tr>
        </table>
