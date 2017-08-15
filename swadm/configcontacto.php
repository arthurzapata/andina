<?php require_once('../Connections/conexion.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}
// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
    
  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
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
      $theValue = ($theValue != "") ? doubleval($theValue)  : "NULL";
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
$colname_mos_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_mos_usuario = $_SESSION['MM_Username'];
  $idioma = $_SESSION['idioma'];
  switch ($idioma) {
    case 'es':
        $lenguaje = 'Español';
        break;
    case 'en':
         $lenguaje = 'Ingles';
        break;
    case 'de':
         $lenguaje = 'Aleman';
        break;
    }
}
mysql_select_db($database_conexion, $conexion);
$query_mos_usuario = sprintf("SELECT * FROM cmd_usuario WHERE usu_nombre = %s", GetSQLValueString($colname_mos_usuario, "text"));
$mos_usuario = mysql_query($query_mos_usuario, $conexion) or die(mysql_error());
$row_mos_usuario = mysql_fetch_assoc($mos_usuario);
$totalRows_mos_usuario = mysql_num_rows($mos_usuario);
///////////////////


mysql_select_db($database_conexion, $conexion);
$query_mos_config = "SELECT * FROM cmd_contacto WHERE con_id = 1";
$mos_config = mysql_query($query_mos_config, $conexion) or die(mysql_error());
$row_mos_config = mysql_fetch_assoc($mos_config);
$totalRows_mos_config = mysql_num_rows($mos_config);


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {


  $updateSQL = sprintf("UPDATE cmd_contacto SET con_direccion=%s, con_email=%s, con_latitud=%s , con_longitud=%s, 
                        con_celular=%s , con_telefono=%s , con_facebook=%s, con_twiter=%s, con_url=%s, con_nombrewebsite = %s, con_cta = %s WHERE con_id=%s",
                       GetSQLValueString($_POST['con_direccion'], "text"),
                       GetSQLValueString($_POST['con_email'], "text"),
                       GetSQLValueString($_POST['con_latitud'], "text"),
                        GetSQLValueString($_POST['con_longitud'], "text"),
                        GetSQLValueString($_POST['con_celular'], "text"),
                        GetSQLValueString($_POST['con_telefono'], "text"),
                        GetSQLValueString($_POST['con_facebook'], "text"),
                        GetSQLValueString($_POST['con_twiter'], "text"),
                        GetSQLValueString($_POST['con_url'], "text"),
                        GetSQLValueString($_POST['con_nombrewebsite'], "text"),
                        GetSQLValueString($_POST['con_cta'], "text"),
                        GetSQLValueString($_POST['con_id'], "int"));
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());

  $updateGoTo = "configcontacto.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <!-- TemplateBeginEditable name="doctitle" -->
        <title>Panel de Administración</title>
        <!-- TemplateEndEditable -->
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="css/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- fullCalendar -->
        <link href="css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="css/jQueryUI/jquery-ui-1.10.3.custom.css">
        <link rel="stylesheet" type="text/css" href="css/jQueryUI/jquery-ui-1.10.3.custom.min.css">
        <link  type="text/css" rel="stylesheet" href="css/timepicker/bootstrap-timepicker.min.css" />
        <!-- TemplateBeginEditable name="head" -->
        <!-- TemplateEndEditable -->
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="index.php" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                Panel Administración
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!--ra-->
                       <li class="dropdown tasks-menu">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <?php echo $lenguaje;?>
                          </a>        
                        </li>
                       <!--ra-->
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $row_mos_usuario["usu_nombre"];?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="img/anonimo90.png" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo $row_mos_usuario["usu_nombre"];?>
                                        <!--<small>Member since Nov. 2012</small>-->
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                   <!-- <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>-->
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
 <div class="pull-left"> <a href="../index.php" onclick = "window.open ('../index.php'); return false"; class="btn btn-default btn-flat">Ver Tienda</a> </div>
                                    <div class="pull-right">
                                        <a href="<?php echo $logoutAction ?>" class="btn btn-default btn-flat">Salir</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
            <!-- div principal -->
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <?php include('menu.php'); ?>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        
                        <small>Panel de Administración</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Bienvenidos</a></li>
                        <li class="active"></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

<div class="row">     
    <div class="col-md-12"> 
        <div class="box box-primary">
        <!-- TemplateBeginEditable name="EditRegion1" -->
        
 <div class="box-header">
               <h3 class="box-title"><i class="fa fa-briefcase"></i> Contacto Configuración</h3></div>
        <div class="box-body">
          
           <div class="row">     
                <div class="col-md-8">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" >
     <div class="form-group">
        Direccion o Lugar:
      <input type="text" name="con_direccion" value="<?php echo htmlentities($row_mos_config['con_direccion'], ENT_COMPAT, 'UTF-8'); ?>" class="form-control" required />
     </div>
      <div class="form-group">
        Email Contacto:
      <input type="text" name="con_email" value="<?php echo htmlentities($row_mos_config['con_email'], ENT_COMPAT, 'UTF-8'); ?>" class="form-control" required />
     </div>
      <div class="row">
            <div class="col-lg-6">
            <div  class="form-group">
           Latitud:
             <input type="text" name="con_latitud" value="<?php echo htmlentities($row_mos_config['con_latitud'], ENT_COMPAT, 'UTF-8'); ?>"  class="form-control"/></div></div>
            <div class="col-lg-6">
             <div  class="form-group">
             Longitud:
             <input type="text" name="con_longitud" value="<?php echo htmlentities($row_mos_config['con_longitud'], ENT_COMPAT, 'UTF-8'); ?>" class="form-control"/></div></div>
     </div>
      <div class="row">
            <div class="col-lg-6">
            <div  class="form-group">
           Celular:
             <input type="text" name="con_celular" value="<?php echo htmlentities($row_mos_config['con_celular'], ENT_COMPAT, 'UTF-8'); ?>"  class="form-control"/></div></div>
            <div class="col-lg-6">
             <div  class="form-group">
             Teléfono:
             <input type="text" name="con_telefono" value="<?php echo htmlentities($row_mos_config['con_telefono'], ENT_COMPAT, 'UTF-8'); ?>" class="form-control"/></div></div>
     </div>
     <div class="row">
            <div class="col-lg-6">
            <div  class="form-group">
           Url Website:
             <input type="text" name="con_url" value="<?php echo htmlentities($row_mos_config['con_url'], ENT_COMPAT, 'UTF-8'); ?>"  class="form-control" placeholder="http://www.zsolutions.com"/></div></div>
            <div class="col-lg-6">
             <div  class="form-group">
             Nombre Empresa:
             <input type="text" name="con_nombrewebsite" value="<?php echo htmlentities($row_mos_config['con_nombrewebsite'], ENT_COMPAT, 'UTF-8'); ?>" class="form-control"/></div></div>
     </div>
     
      <div class="row">
            <div class="col-lg-6">
            <div  class="form-group">
           Facebook:
             <input type="text" name="con_facebook" value="<?php echo htmlentities($row_mos_config['con_facebook'], ENT_COMPAT, 'UTF-8'); ?>"  class="form-control" placeholder="Ejm:  https://www.facebook.com/lheowebglobal" /></div></div>
            <div class="col-lg-6">
             <div  class="form-group">
             Canal de Youtube:
             <input type="text" placeholder="Ejm: http://www.youtube.com/" name="con_twiter" value="<?php echo htmlentities($row_mos_config['con_twiter'], ENT_COMPAT, 'UTF-8'); ?>" class="form-control"/></div></div>
     </div>
     
      <div class="row">
            <div class="col-lg-6">
            <div  class="form-group">
           Canal de Vimeo:
             <input type="text" name="con_google" value="<?php echo htmlentities($row_mos_config['con_google'], ENT_COMPAT, 'UTF-8'); ?>"  class="form-control" placeholder="" /></div></div>
            <div class="col-lg-6">
             <div  class="form-group">
            Instagram:
             <input type="text" placeholder="" name="con_instagram" value="<?php echo htmlentities($row_mos_config['con_instagram'], ENT_COMPAT, 'UTF-8'); ?>" class="form-control"/></div></div>
     </div>
     <div class="row">
            <div class="col-lg-12">
            <div  class="form-group">
           Cuentas Bancarias:
                <textarea name="con_cta" rows="3" class="form-control"><?php echo htmlentities($row_mos_config['con_cta'], ENT_COMPAT, 'utf-8'); ?></textarea></div>

           </div> 
     </div>
   
   <input type="submit" value="Guardar" class="btn btn-primary"/>
  
    <input type="hidden" name="MM_update" value="form1">
    <input type="hidden" name="con_id" value="<?php echo $row_mos_config['con_id']; ?>">

  <a href="index.php" class="btn btn-default">Cancelar</a>  
   </div>
</form>
 </div> </div>
</div><!-- body -->


        <!-- TemplateEndEditable -->
        </div><!-- /.primary-->
     </div><!-- /.col-->
</div> <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->
        
        <!-- jQuery 2.0.2  -->
        <script src="js/jquery.min.js" type="text/javascript"></script>
        <script src="js/lightbox.js"></script>
        <!-- jQuery UI 1.10.3
        <script src="js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- Morris.js charts -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="js/plugins/morris/morris.min.js" type="text/javascript"></script>
        <!-- Sparkline -->
        <script src="js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <!-- jvectormap -->
        <script src="js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
        <!-- fullCalendar -->
        <script src="js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <!-- jQuery Knob Chart -->
        <script src="js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
        <!-- daterangepicker -->
        <script src="js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
       <script src="js/AdminLTE/dashboard.js" type="text/javascript"></script>   
    </body>
</html>