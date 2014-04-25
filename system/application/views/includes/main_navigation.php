
      <nav id="main">
        <ul>
          <li <?if(check_uri('')):?>class="active"<?endif?>><a href="/">Home</a></li>
          <li <?if(check_uri('bulbs/all')):?>class="active"<?endif?>><a href="/bulbs/all">All bulbs</a></li>
          <li <?if(check_uri('account/shopping_cart')):?>class="active"<?endif?>><a href="/account/shopping_cart">Shopping cart</a></li>
          <!--<?if(check_logged_in()):?><li <?if(check_uri('account/summary')):?>class="active"<?endif?>><a href="/account/summary">Account information</a></li><?endif?>-->
          <!--<li <?if(check_uri('supplier/apply')):?>class="active"<?endif?>><a href="/supplier/apply">Become a supplier</a></li>-->
          <li <?if(check_uri('page/controls')):?>class="active"<?endif?>><a href="/page/controls">Controls</a></li>
          <li <?if(check_uri('page/developments')):?>class="active"<?endif?>><a href="/page/developments">Developments</a></li>
        </ul>
      </nav>
