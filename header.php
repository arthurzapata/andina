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
///
$_Ses='';
$_Sen='';
$_Sed='';
$_Sfr='';
$_Sit='';

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
    //
    if ($_SESSION["idioma"]== 'fr'){
        $_Sfr = 'selected';
    }
    if ($_SESSION["idioma"]== 'it'){
        $_Sit = 'selected';
    }
    //
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
    case 'fr':
        $_SESSION["idioma"] = 'fr';
        break;
    case 'it':
        $_SESSION["idioma"] = 'it';
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
    //
    elseif ($_SESSION["idioma"]== 'fr'){
        $_Sfr = 'selected';
        $_flag = 'france.png';
    }
    elseif ($_SESSION["idioma"]== 'it'){
        $_Sit = 'selected';
        $_flag = 'italy.png';
    }
    //
    else 
    {
         $_Ses = 'selected';
    }
//echo @$_SESSION["idioma"]; //
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
 <style type="text/css">
/*.drop-down { 
 position: relative;  
 display: inline-block;    
 width: auto;       
 margin-top: 0;   
 font-family: verdana;    
 }      
 .drop-down select {   
 display: none;    
 }      
 .drop-down .select-list {   
 position: absolute;     
 top: 0;      
 left: 0;     
 z-index: 1;    
 margin-top: 40px;    
 padding: 0;         
 background-color:#fff; 
 }      
 .drop-down .select-list li {   
 display: none;      
 }    
 .drop-down .select-list li span {  
 display: inline-block;      
 min-height: 30px;        
 min-width: 280px;      
 width: 100%;        
 padding: 5px 15px 5px 35px;     
 background-color: #FFF#595959;     
 background-position: left 10px center;   
 background-repeat: no-repeat;       
 font-size: 16px;       
 text-align: left;       
 color: #595959;        
 
 box-sizing: border-box;     
 }     
 .drop-down .select-list li span:hover,  
 .drop-down .select-list li span:focus {     
opacity: 1;     
 } */

    </style>
<!--<script src="js/jquery-3.2.0.min.js"></script>-->
<script type="text/javascript">/*
    jQuery().ready(function() {  
jQuery('.drop-down').append('<div class="button"></div>');    
jQuery('.drop-down').append('<ul class="select-list"></ul>');    
jQuery('.drop-down select option').each(function() {  
var bg = jQuery(this).css('background-image');    
jQuery('.select-list').append('<li class="clsAnchor"><span value="' + jQuery(this).val() + '" class="' + jQuery(this).attr('class') + '" style=background-image:' + bg + '>' + jQuery(this).text() + '</span></li>');   
});    
jQuery('.drop-down .button').html('<span style=background-image:' + jQuery('.drop-down select').find(':selected').css('background-image') + '>' + jQuery('.drop-down select').find(':selected').text() + '</span>' + '<a href="javascript:void(0);" class="select-list-link">-- Seleccionar --</a>');   
jQuery('.drop-down ul li').each(function() {   
if (jQuery(this).find('span').text() == jQuery('.drop-down select').find(':selected').text()) {  
jQuery(this).addClass('active');       
}      
});     
jQuery('.drop-down .select-list span').on('click', function()
{          
var dd_text = jQuery(this).text();  
var dd_img = jQuery(this).css('background-image'); 
var dd_val = jQuery(this).attr('value');   
jQuery('.drop-down .button').html('<span style=background-image:' + dd_img + '>' + dd_text + '</span>' + '<a href="javascript:void(0);" class="select-list-link">-- Seleccionar --</a>');      
jQuery('.drop-down .select-list span').parent().removeClass('active');    
jQuery(this).parent().addClass('active');     
$('.drop-down select[name=ordenar]').val( dd_val ); 
$('.drop-down .select-list li').slideUp();     
});       
jQuery('.drop-down .button').on('click','a.select-list-link', function()
{      
jQuery('.drop-down ul li').slideToggle();  
});     
 End */       
});
</script>
</head>

<body>
<div class="page-wrapper">
 	
    <!-- Preloader -->
    <div class="preloader"></div>
 	
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
                          <!--<div class="drop-down">    -->
                          <select class="form-control"  name="ordenar" onchange="this.form.submit()">
                            <!-- <select name="ordenar" onchange="this.form.submit()">-->
                               <!--<option value="0">-- Idioma --</option>-->
                                <option value="es" style="background-image:url('images/flag/spain.png');" <?php echo $_Ses; ?>>Español</option>
                                <option value="en" style="background-image:url('images/flag/usa.png');" <?php echo $_Sen; ?>>Ingles</option>
                                <option value="de" style="background-image:url('images/flag/germany.png');" <?php echo $_Sed; ?>>Aleman</option>
                                <option value="fr" style="background-image:url('images/flag/france.png');" <?php echo $_Sfr; ?>>Frances</option>
                                <option value="it" style="background-image:url('images/flag/italy.png');" <?php echo $_Sit; ?>>Italiano</option>
                            </select>
                            
                            <!--</div>-->
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
        
        