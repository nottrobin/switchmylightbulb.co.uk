    
    <?php // Get the title
    $page_title = '';
    if(isset($title)) {$page_title = $title . ' | ';}
    else if(isset($content_template)) {
        $page_title = ucfirst(str_replace('.php','',str_replace('_',' ',$content_template))) . ' | ';
    }
    $page_title .= $this->config->item('site_name');
    ?>
    
    <title><?=$page_title?></title>
    
    <meta charset="utf-8">
    
    <script type="text/javascript" src="/js/html5.js"></script>
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
