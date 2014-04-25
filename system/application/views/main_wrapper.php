<!DOCTYPE html>

<?php 
    /* Get the codeigniter object */
    $ci = $this;
    if(!(isset($this->config) && get_class($this->config) == 'CI_Config')) {
        $ci =& get_instance();
    }
?>

<html>
  <head>
<?php include('includes/head.php') ?>
  </head>
  
  <body>
    <div id="top"></div>
    
    <div id="container">
      <header id="main">
        <h1>Light bulb finder</h1>
      </header>
      
<?php include('includes/main_navigation.php') ?>
      
<?php include('includes/search.php') ?>
    
      <section id="content">
        <section id="central">
          
<?php include('includes/notifications.php') ?>
          
          <section id="main">
<?php
  /*  This is where the main page content goes */
  if(isset($content)) {echo $content;}
  if(isset($content_template)) {include('content/' . $content_template);}
?>
<?php include('includes/padding.php') ?>
          </section>
          
<?php include('includes/page_navigation.php') ?>

        </section>
        
<?php include('includes/postblock.php') ?>
      </section>
    
      <footer>
        <nav>
          <h2>Westminster council</h2>
          <ul>
            <li><a href="http://www.westminster.gov.uk/">Homepage</a></li>
            <li><a href="http://www.westminster.gov.uk/services/environment/greencity/carbonalliance/">Westminster carbon alliance</a></li>
          </ul>
        </nav>
        <nav>
          <h2>Suppliers</h2>
          <ul>
            <li><a href="/supplier/apply">Apply to become a supplier</a></li>
          </ul>
        </nav>
      </footer>
      
      <section id="copy">
        <p>&copy; Copyright Westminster City Council 2010</p>
      </section>
    </div>
    
    <div id="bottom"></div>
  </body>
</html>
