
          <article id="basket">
            <header>
              <h1>Shopping cart items</h1>
            </header>
            
            <section class="content">
              <?if($ci->cart->total_discrete_items() > 0 && !isset($cart_sent)): ?>
              
              <table>
                <tr>
                  <th class="qty">#</th>
                  <th class="name">Name</th>
                  <th class="price">Est. price</th>
                </tr>
                
                <?php foreach($ci->cart->contents() as $item): ?>
                <tr>
                  <td><?=$item['qty']?></td>
                  <td><a href="/bulbs/information/energy_saving/<?=$item['id']?>"><?=$item['name']?></a></td>
                  <td>
                    &pound;<?=number_format($item['subtotal'],2)?>
                    <?if(isset($item['upper_price']) && $item['upper_price'] > 0):?>
                      - &pound;<?=number_format($ci->cart->upper_price_subtotal($item),2)?>
                    <?endif?>
                  </td>
                </tr>
                
                <?php endforeach ?>
              </table>
              
              <p>
                <small>
                  <strong>Total:</strong>
                  &pound;<?=number_format($ci->cart->total(),2)?>
                  <?if(intval($ci->cart->upper_total()) > intval($ci->cart->total())):?>
                    - &pound;<?=number_format($ci->cart->upper_total(),2)?>
                  <?endif?>
                </small>
              </p>
              
              <p><a href="/account/shopping_cart">view shopping cart</a></p>
              <?php else: ?>
              <p>No items!</p>
              <?php endif // end basket items ?>
            </section>
          </article>
