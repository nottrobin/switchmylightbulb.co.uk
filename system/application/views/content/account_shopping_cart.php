
            <h1>Shopping cart</h1>
            
            <?php if($ci->cart->total_discrete_items() > 0): ?>
            
            <p>Following are the items in your shopping cart. You can edit the quantity of any of the items or <a href="/account/checkout">checkout</a> to send your shopping cart to suppliers and receive quotes.</p>
            
            <table class="cart_items">
              <tr>
                <th class="name">Name</th>
                <th class="price">Est. price</th>
                <th class="qty">Quantity</th>
                <th class="remove">&nbsp;</th>
              </tr>
              
              <?php foreach($ci->cart->contents() as $item): ?>
              <tr>
                <td class="name">
                  <a href="/bulbs/information/energy_saving/<?=$item['id']?>"><?=$item['name']?></a>
                </td>
                <td class="price">
                  &pound;<?=number_format($item['subtotal'],2)?>
                  <?if(isset($item['upper_price']) && $item['upper_price'] > 0):?>
                    - &pound;<?=number_format($ci->cart->upper_price_subtotal($item),2)?>
                  <?endif?>
                </td>
                <td class="qty">
                  <form action="/account/update_cart/<?=$item['id']?>" method="post">
                    <input type="number" min="0" step="1" name="quantity" value="<?=$item['qty']?>" size="2" />
                    <button type="submit">update</button>
                  </form>
                </td>
                <td class="remove">
                  <a href="/account/update_cart/<?=$item['id']?>/0">remove</a>
                </td>
              </tr>
              
              <?php endforeach ?>
              <tr>
                <td class="name"><strong>Total:</strong></td>
                <td class="price">
                  &pound;<?=number_format($ci->cart->total(),2)?>
                  <?if(intval($ci->cart->upper_total()) > intval($ci->cart->total())):?>
                    - &pound;<?=number_format($ci->cart->upper_total(),2)?>
                  <?endif?>
                </td>
                <td class="qty"><?=$ci->cart->total_discrete_items()?></td>
                <td class="remove">&nbsp;</td>
              </tr>
            </table>
            
            <p><a href="/account/checkout">Send shopping cart to suppliers</a></p>
            
            <?php else: ?>
            <p>You have not added any energy-saving light bulbs to your shopping cart.</p>
            <p>
              To add energy-saving light bulbs:
              <ul>
                <li>Find your regular light bulbs, either by searching in the search bar above, or by browsing through <a href="/bulbs/search/all_fields/everything">all bulbs in our database</a>.</li>
                <li>When you've found your regular light bulb, click "find replacements" to view a list of energy-saving replacement bulbs.</li>
                <li>Once you have found a suitable replacement, choose your quantity and click "add to cart".</li>
              </ul>
            </p>
            <?php endif // end basket items ?>
