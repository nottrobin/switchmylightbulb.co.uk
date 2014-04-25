
          <?if(check_logged_in()):?>
          <article id="account">
            <header>
              <h1>Logged in as</h1>
            </header>
            
            <section class="content">
              <p>
                <strong><?=$ci->current_user->forename?> <?=$ci->current_user->surname?></strong><br/>
                <small><?=$ci->current_user->email_address?></small><br/>
                <a href="/account/summary">view account</a>
              </p>
              <?$supplier = $ci->current_user->admin_of_supplier->get()?>
              <?if($supplier->exists()):?>
              <p>
                <strong>Admin of supplier</strong><br/>
                <small><a href="/supplier/information/<?=$supplier->id?>"><?=$supplier->company_name?></a></small>
              </p>
              <?endif?>
              <p><a href="/account/logout">logout</a></p>
            </section>
          </article>
          <?php else: ?>
          <article id="login">
            <header>
              <h1>Not logged in</h1>
            </header>
            
            <section class="content">
              <p><a href="/account/login">Login</a> or <a href="/account/create">create an account</a>.</p>
            </section>
          </article>
          <?php endif // end account block ?>
