
    <hgroup>
      <h1>Account orders</h1>
      <h2><?=$ci->current_user->forename?> <?=$ci->current_user->surname?></h2>
    </hgroup>
    
    <p>Below is a list of all orders made so far from the account: <?=$ci->current_user->email_address?>. You can rate suppliers, or view supplier information.</p>
    
    <ul>
      <?foreach($orders as $order):?>
      <? 
        $items = $order->order_item->get() ;
        $suppliers = $order->supplier->get();
      ?>
      <li>
        <strong><a href="/account/order/<?=$order->id?>">Order number <?=$order->id?></a></strong>
        <small>
          (<?=$items->result_count()?> bulb type(s),
          sent to <?=$suppliers->result_count()?> supplier(s)
          at <?=$order->created_on?>)
        </small>
      </li>
      <?endforeach?>
    </ul>
    
