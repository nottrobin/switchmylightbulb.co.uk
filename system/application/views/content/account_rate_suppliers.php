
    <h1>Rate suppliers</h1>
    
    <p>Here is a list of all suppliers that you have sent shopping carts to in the past. If you update your ratings of any of the suppliers, don't remember to click "update ratings".</p>
    
    <?if(isset($errors)):?>
    <div id="errors">
    <?foreach($errors as $error):?>
      <?=$error?>
    <?endforeach?>
    </div>
    <?endif?>
    
    <?if(empty($suppliers)):?>
    <p>Sorry, you have not sent a shopping cart to any suppliers yet.</p>
    <?else:?>
    <form id="rating_form" method="post">
      <script type="text/javascript">
        <!--
          jQuery(document).bind(
              'ready',
              function(evt) {
                  jQuery('button.rate_me').bind(
                      'click',
                      function(evt) {
                          evt.preventDefault();
                          var button = jQuery(this);
                          var regexp = /^rate_me\[(\d+)\]$/;
                          var result = regexp.exec(button.attr('name'));
                          var supplier_id = result[1];
                          var td = jQuery(button).parent('td');
                          
                          td.empty();
                          td.append('<input name="user_rating['+supplier_id+'] type="range" min="1" max="5" step="1" />');
                      }
                  );
              }
          );
        //-->
      </script>
      <table>
        <tr>
          <th>Supplier</th>
          <th>Used for orders</th>
          <th>Your rating (1 to 5)</th>
        </tr>
        <?foreach($suppliers as $supplier_id => $values):?>
        <tr>
          <td>
            <a href="/supplier/information/<?=$supplier_id?>"><?=$values['supplier']->company_name?></a>
            <small>(ave. rating: <?=$values['supplier']->average_rating()?>)</small>
          </td>
          <td>
            <ul>
            <?foreach($values['orders'] as $order):?>
              <li><a href="/account/order/<?=$order->id?>">Order <?=$order->id?></a></li>
            <?endforeach?>
            </ul>
          </td>
          <td>
            <? $rating = $values['supplier']->user_rating() ?>
            <?if($rating === false):?>
                Not yet rated - 
                <button
                  class="rate_me" name="rate_me[<?=$values['supplier']->id?>]"
                  type="submit">
                  rate now
                </button>
              </p>
            <?else:?>
              <input name="user_rating[<?=$values['supplier']->id?>]" type="range" min="1" max="5" step="1" value="<?=$rating?>" /><br/>
            <?endif?>
          </td>
        </tr>
        <?endforeach?>
      </table>
      <button type="submit">update ratings</button>
    </form>
    <?endif?>
    