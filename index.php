<?php include('functions/functions.php');?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Synathina</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="stylesheet" href="css/styles.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,300,700&subset=latin,greek' rel='stylesheet' type='text/css'>
    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>

<body class="debug">

<header class="l-header">
  <?php include('_modules/nav_menu.html'); ?>
</header>
<?php include ('_modules/_dev_menu.html'); ?>
<div class="logo-container">
   <a href="" class="logo logo-athens" alt="Δήμος Αθηναίων">
   </a>
   <a href="" class="logo logo-synathina" alt="Συναθηνά">
   </a>
</div>
<main style="background-color: #fff">
  <?php

    $request = getRequest();

    $folder = getFolder();

    if($homepage){
      $request = 'homepage';
      $folder = '_templates';
    }

    if((@include $folder.'/'.$request.'.html') === false) {
      //include('_templates/404.html');
    }

  ?>
</main>
<footer></footer>

<script>
    //window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')
</script>
<script type="text/javascript" src="js/vendor/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="js/vendor/jquery.magnific-popup.min.js"></script>
<script src="js/vendor/jquery-ui.min.js"></script>
<script src="js/vendor/imagesloaded.pkgd.min.js"></script>
<script src="js/vendor/eventemitter2.js"></script>
<script src="js/_plugins.js"></script>

<?php if($homepage || $_REQUEST['tpl'] === 'homepage') { ?>

    <!-- IF in home page load application source files and dependecies -->
    <!-- Application Dependecies-->
    <script src="js/vendor/togeojson.js"></script>
    <script src="js/vendor/d3.min.js"></script>
    <script src="js/vendor/crossfilter.min.js"></script>
    <script src="js/vendor/dc.min.js"></script>
    <script src="js/vendor/d3.slider.js"></script>
    <script src=js/vendor/markerclusterer.js></script>

    <!-- Application -->
    <script src="js/app/filter.js"></script>
    <script src="js/app/ajax.js"></script>
    <script src="js/app/app.js"></script>
    <script src="js/app/categories.js"></script>
    <script src="js/app/window.js"></script>
    <script src="js/app/map.js"></script>
    <script src="js/app/areas.js"></script>
    <script src="js/app/activity.js"></script>
    <script src="js/ui.js"></script>
    <script src="js/app/cross.js"></script>
    <script src="js/app/slider.js"></script>

    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAn_Z73vSnRqhaPNt76B8e_156YxREMefU&callback=initMap&libraries=geometry">
    </script>
    
<?php } else { ?>
    <!-- ELSE load web site source files and dependecies -->
    <script type="text/javascript" src="js/vendor/dev_menu.js"></script>
    <script type="text/javascript" src="js/vendor/slick.min.js"></script>
    <script type="text/javascript" src="js/vendor/jquery.magnific-popup.min.js"></script>
    <script type="text/javascript" src="js/vendor/jquery.mousewheel.js"></script>
    <script type="text/javascript" src="js/vendor/jscrollpane.js"></script>
    
    <script src="js/site/main.js"></script>
    <script src="js/ui.js"></script>

<?php } ?>

</body>
</html>
