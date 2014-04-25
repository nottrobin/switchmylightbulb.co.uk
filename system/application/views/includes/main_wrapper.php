<!DOCTYPE html>

<html>
  <head>
    <title><?= isset($title) ? $title : ucfirst(str_replace('.php','',str_replace('_',' ',$content_template))) ?> | Light bulb finder</title>
    
    <meta charset="utf-8">
    
    <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type="text/javascript" src="/js/jquery.pngFix.pack.js"></script>
    <script type="text/javascript">
      <!--
        jQuery(document).bind(
            'ready',
            function() {
                // Fix PNGs for <=IE6
                jQuery(document).pngFix();
            }
        );
      //-->
    </script>
    
    <?if(isset($fancybox) && $fancybox):?>
    <script type="text/javascript" src="/js/jquery.fancybox-1.3.1.pack.js"></script>
    <link rel="stylesheet" href="/css/jquery.fancybox-1.3.1.css" />
    <?endif?>
    
    <link rel="stylesheet" href="/css/main.css" />
    <link rel="stylesheet" href="/css/widthfix.css" />
  </head>
  
  <body>
    <div id="top"></div>
    
    <div id="container">
      <header>
        <h1>Light bulb finder</h1>
      </header>
      
      <?php include('main_navigation.php') ?>
      
      <?php include('search.php') ?>
      
      <section id="content">
        <section id="central">
          <?php if(isset($notification)) { ?>
            <section id="notifications">
              <ul>
                <li><?php echo $notification ?></li>
              </ul>
            </section>
          <?php } // end notifications block ?>
          
          <section id="main">
            <?php
              if(isset($content)) {echo $content;}
              if(isset($content_template)) {include($content_template);}
            ?>
          </section>
        </section>
        
        <?php include('page_navigation.php') ?>
        
        <?php include('postblock.php') ?>
      </section>
      
      <footer>&copy; Copyright bulb people 2010</footer>
    </div>
    
    <div id="bottom"></div>
  </body>
</html>
