<?php require_once('Connections/conexion.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

function getUserLanguage() {  
       $idioma =substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2); 
       return $idioma;  
} 
  
mysql_select_db($database_conexion, $conexion);
$query_mos_config = "SELECT * FROM cmd_contacto WHERE con_id = 1";
$mos_config = mysql_query($query_mos_config, $conexion) or die(mysql_error());
$row_mos_config = mysql_fetch_assoc($mos_config);
$totalRows_mos_config = mysql_num_rows($mos_config);
///
$_Ses='';
$_Sen='';
$_Sed='';

if(isset($_POST['ordenar']))
{  
  $_SESSION["idioma"] = $_POST['ordenar'];
    ///
    if ($_SESSION["idioma"]== 'es') {
        $_Ses = 'selected';
    }
    if ($_SESSION["idioma"]== 'en'){
        $_Sen = 'selected';
    }
    if ($_SESSION["idioma"]== 'de'){
        $_Sed = 'selected';
    }
  /////
}
elseif (!@$_SESSION["idioma"]) { 
    
    $user_language = getUserLanguage();   //Almacenamos dicho idioma en una variable 

    switch ($user_language) {
    case 'es':
        $_SESSION["idioma"] = 'es';
        break;
    case 'en':
        $_SESSION["idioma"] = 'en';
        break;
    case 'de':
        $_SESSION["idioma"] = 'de';
        break;
    default:
        $_SESSION["idioma"] = 'es';
        break;
    }
} 

  //
    if ($_SESSION["idioma"]== 'es') {
        $_Ses = 'selected';
        $_flag = 'spain.png';
    }
    elseif ($_SESSION["idioma"]== 'en'){
        $_Sen = 'selected';
        $_flag = 'usa.png';
    }
    elseif ($_SESSION["idioma"]== 'de'){
        $_Sed = 'selected';
        $_flag = 'germany.png';
    }
    else 
    {
         $_Ses = 'selected';
    }
mysql_select_db($database_conexion, $conexion);
$query_mos_url = "SELECT * FROM cmd_url where url_idioma = '".$_SESSION["idioma"]."'";
$mos_url = mysql_query($query_mos_url, $conexion) or die(mysql_error());
$row_mos_url = mysql_fetch_assoc($mos_url);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>::: Pozuzo :::</title>
<!-- Stylesheets -->
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/revolution-slider.css" rel="stylesheet">
<link href="css/owl.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<!-- Responsive -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link href="css/responsive.css" rel="stylesheet">
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<!--[if lt IE 9]><script src="js/respond.js"></script><![endif]-->
</head>

<body>
<div class="page-wrapper">
    
    <!-- Preloader 
    <div class="preloader"></div>-->
    
    <!-- Main Header -->
    <header class="main-header style-two">
        <!-- Header Top -->
        <div class="header-top">
            <div class="auto-container clearfix">
                
                <!-- Top Left -->
                <div class="top-left pull-right clearfix">
                    <div class="email pull-left">
                    <a href="mailto:<?php echo $row_mos_config['con_email'];?>"><span class="f-icon flaticon-email145"></span>
                        <?php echo $row_mos_config['con_email'];?></a>




                    </div>
                    <div class="phone pull-left"><a href="#"><span class="f-icon flaticon-phone325"></span> 
                        <?php echo $row_mos_config['con_telefono'];?></a>
                    </div>
                    <div class="phone pull-right">
                        <img src="images/flag/<?php echo $_flag; ?>">
                    </div>
                    <div class="phone pull-left">
                                                   <form method="post">
                                                    <select class="form-control" name="ordenar" onchange="this.form.submit()">
                                                   <!--   <option value="0">-- Idioma --</option>-->
                                                      <option value="es" <?php echo $_Ses; ?> >Español</option>
                                                      <option value="en" <?php echo $_Sen; ?>>Ingles</option>
                                                      <option value="de" <?php echo $_Sed; ?>>Aleman</option>
                                                    </select>
                                                    </form>
                    </div>
                </div>
                
            </div>
        </div>
        
        <!-- Search Box -->
        <div class="search-box toggle-box">
            <div class="auto-container clearfix">
                
                <!-- Search Form -->
                <div class="search-form">
                    <form method="post" action="index.php">
                        <div class="form-group">
                            <input type="search" name="search" value="" placeholder="Search">
                            <button class="search-submit" type="submit"><span class="f-icon flaticon-magnifying-glass16"></span></button>
                        </div>
                    </form>
                </div>
            
            </div>
        </div>
        
        <!-- Header Lower -->
        <div class="header-lower">
            <div class="auto-container clearfix">
                <!--Logo-->
                <div class="logo"><a href="index.php"><img src="images/logo-2.png" alt="Bulldozer" title="Bulldozer"></a></div>
                
                <!--Right Container-->
                <div class="right-cont clearfix">
                    
                    
                    <!-- Main Menu -->
                    <nav class="main-menu">
                        <div class="navbar-header">
                            <!-- Toggle Button -->      
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        
                        <div class="navbar-collapse collapse clearfix">                                                                                              
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="index.php"><?php echo $row_mos_url['url_inicio']; ?></a>
                                   
                                </li>
                                <li class="dropdown"><a href="nosotros.php"><?php echo $row_mos_url['url_nosotros']; ?></a>
                                   
                                </li>
                                <li class="dropdown"><a href="servicios.php"><?php echo $row_mos_url['url_servicios']; ?></a>
                                  
                                </li>
                                <li><a href="galeria.php"><?php echo $row_mos_url['url_galeria']; ?></a></li>
                                <li><a href="videos.php"><?php echo $row_mos_url['url_video']; ?></a></li>
                                 <li><a href="paquetes.php"><?php echo $row_mos_url['url_paquetes']; ?></a></li>
                                <li class="current dropdown"><a href="contacto.php"><?php echo $row_mos_url['url_contacto']; ?></a></li>
                                
                            </ul>
                            <div class="clearfix"></div>
        
                        </div>
                    </nav>
                    <!-- Main Menu End-->
                </div>
                
            </div>
            
        </div>
        
        
    </header>
    <!--We Are Best-->
      <section class="page-banner" style="background-image:url(images/background/page-banner-bg-2.jpg);">
    	<div class="auto-container text-center">
        	<h1><?php echo $row_mos_url['url_contacto']; ?></h1>
            <ul class="bread-crumb"><li><a href="index.php"><?php echo $row_mos_url['url_inicio']; ?></a></li> <li><?php echo $row_mos_url['url_contacto']; ?></li></ul>
        </div>
    </section>
    
 
 <section class="info-strip">
    	<div class="auto-container">
        	<div class="row clearfix">
            	
                <div class="col-md-4 col-sm-4 col-xs-12">
                	<div class="info-block text-center wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1000ms">
                    	<div class="icon hvr-radial-out"><span class="f-icon flaticon-pointing8"></span></div>
                        <h4><?php echo $row_mos_url['url_direccion']; ?></h4>
                        <p> <?php echo $row_mos_config['con_direccion'];?></p>
                    </div>
                </div>
                
                <div class="col-md-4 col-sm-4 col-xs-12">
                	<div class="info-block text-center wow fadeInUp" data-wow-delay="300ms" data-wow-duration="1000ms">
                    	<div class="icon hvr-radial-out"><span class="f-icon flaticon-email103"></span></div>
                        <h4><?php echo $row_mos_url['url_email']; ?></h4>
                        <p><a href="mailto:<?php echo $row_mos_config['con_email'];?>"> <?php echo $row_mos_config['con_email'];?></a>

<a href="mailto:info@pozuzonuevoturismo.com">
                        info@pozuzonuevoturismo.com</a>

                        </p>
                    </div>
                </div>
                
                <div class="col-md-4 col-sm-4 col-xs-12">
                	<div class="info-block text-center wow fadeInUp" data-wow-delay="600ms" data-wow-duration="1000ms">
                    	<div class="icon hvr-radial-out"><span class="f-icon flaticon-telephone46"></span></div>
                        <h4><?php echo $row_mos_url['url_telefono']; ?></h4>
                        <p><?php echo $row_mos_config['con_telefono'];?>  -   <?php echo $row_mos_config['con_celular'];?></p>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    <section class="contact-us-area">
    	<div class="auto-container">
        	<div class="row clearfix">
            	
                 <!--Contact Form-->
            	<div class="col-md-7 col-sm-6 col-xs-12 contact-form wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1000ms">
                	<h2><?php echo $row_mos_url['url_formcontac']; ?></h2>
                    
                    <form id="contact-form" method="post" action="sendemail.php">
                        <div class="field-container clearfix">
                        	
                            <div class="form-group col-md-6 col-sm-12 col-xs-12">
                            	<input type="text"  name="username" value="" placeholder="<?php echo $row_mos_url['url_usuario']; ?>*" required>
                            </div>
                            
                            <div class="form-group col-md-6 col-sm-12 col-xs-12">
                            	<input type="email" name="email" value="" placeholder="<?php echo $row_mos_url['url_email']; ?>*" required>
                            </div>
                            
                            <div class="clearfix"></div>
                            
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            	<input type="text" name="subject" value="" placeholder="<?php echo $row_mos_url['url_subject']; ?>*" required>
                            </div>
                            
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            	<textarea name="message" placeholder="<?php echo $row_mos_url['url_mensaje']; ?>" required></textarea>
                            </div>
                            
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            	<button type="submit" name="submit-form" class="primary-btn hvr-bounce-to-left"><span class="btn-text"><?php echo $row_mos_url['url_enviarmsje']; ?></span> <strong class="icon"><span class="f-icon flaticon-letter110"></span></strong></button>
                            </div>
                            
                        </div>
                    </form>
                </div>
                
                 <!--Map Area-->
                <div class="col-md-5 col-sm-6 col-xs-12 map-area wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1000ms">
                	<h2><?php echo $row_mos_url['url_map']; ?></h2>
                    
                   <div class="our-location" id="map-locations"></div>
                </div>
            
            </div>
        </div>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDugcb9vchF8sqGZ4sFuqCruUTGayCPYHk&callback=initMap"
  type="text/javascript"></script>
<!--<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyDugcb9vchF8sqGZ4sFuqCruUTGayCPYHk&callback=initMap">
</script>-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<script type="text/javascript">
(function(){
function wpgmappity_maps_loaded() {
var latlng = new google.maps.LatLng(<?php echo htmlentities($row_mos_config['con_latitud'], ENT_COMPAT, 'UTF-8'); ?>, <?php echo htmlentities($row_mos_config['con_longitud'], ENT_COMPAT, 'UTF-8'); ?>);
var options = {
 center : latlng,
 mapTypeId: google.maps.MapTypeId.ROADMAP,
 zoomControl : true,
 zoomControlOptions :
 {
 style: google.maps.ZoomControlStyle.SMALL,
 position: google.maps.ControlPosition.TOP_LEFT
 },
 mapTypeControl : true,
 mapTypeControlOptions :
 {
 style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
 position: google.maps.ControlPosition.TOP_RIGHT
 },
 scaleControl : false,
 streetViewControl : false,
 navigationControl:true,
 panControl : false, zoom : 16
};
var wpgmappitymap = new google.maps.Map(document.getElementById('map-locations'), options);
var point0 = new google.maps.LatLng(<?php echo htmlentities($row_mos_config['con_latitud'], ENT_COMPAT, 'UTF-8'); ?>, <?php echo htmlentities($row_mos_config['con_longitud'], ENT_COMPAT, 'UTF-8'); ?>);
var marker0= new google.maps.Marker({
 position : point0,
 map : wpgmappitymap
 });
google.maps.event.addListener(marker0,'click',
 function() {
 var infowindow = new google.maps.InfoWindow(
 {content: 'Pozuzo'  });
 infowindow.open(wpgmappitymap,marker0);
 });
}
window.onload = function() {
 wpgmappity_maps_loaded();
};
})()
</script>   

<!--<script>
      function initMap() {
        // Create a map object and specify the DOM element for display.
        var map = new google.maps.Map(document.getElementById('wpgmappitymap'), {
          center: {lat: -34.397, lng: 150.644},
          scrollwheel: false,
          zoom: 8
        });
      }

    </script>    
<div align="center" style="width:100%;">
<div class="wpgmappity_container" id="wpgmappitymap" style="width:100%px; height:500px;"></div></div>

-->
    </section>
<?php include 'footer.php'; ?>


    