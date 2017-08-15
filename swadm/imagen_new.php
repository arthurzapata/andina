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
	
  $logoutGoTo = "../login.php";
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

$colname_mos_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_mos_usuario = $_SESSION['MM_Username'];
}
mysql_select_db($database_conexion, $conexion);
$query_mos_usuario = sprintf("SELECT CONCAT(' ',IFNULL(e.col_nombres,''),' ',IFNULL(e.col_apellidos,'')) AS personal,e.col_foto,u.usu_nombre,u.per_id FROM cmd_usuario u INNER JOIN cmd_colaborador e ON u.col_id = e.col_id WHERE u.usu_nombre = %s", GetSQLValueString($colname_mos_usuario, "text"));
$mos_usuario = mysql_query($query_mos_usuario, $conexion) or die(mysql_error());
$row_mos_usuario = mysql_fetch_assoc($mos_usuario);
$totalRows_mos_usuario = mysql_num_rows($mos_usuario);$colname_mos_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_mos_usuario = $_SESSION['MM_Username'];
}
mysql_select_db($database_conexion, $conexion);
$query_mos_usuario = sprintf("SELECT CONCAT(' ',IFNULL(e.col_nombres,''),' ',IFNULL(e.col_apellidos,'')) AS personal,e.col_foto,u.usu_nombre,u.per_id FROM cmd_usuario u INNER JOIN cmd_colaborador e ON u.col_id = e.col_id WHERE u.usu_nombre = %s", GetSQLValueString($colname_mos_usuario, "text"));
$mos_usuario = mysql_query($query_mos_usuario, $conexion) or die(mysql_error());
$row_mos_usuario = mysql_fetch_assoc($mos_usuario);
$totalRows_mos_usuario = mysql_num_rows($mos_usuario);


mysql_select_db($database_conexion, $conexion);
$query_mos_mantenedores = "SELECT d.per_id, d.pag_id, p.pag_nombre, p.pag_link, p.pag_nivel, p.pag_estado FROM cmd_detallepagina AS d INNER JOIN cmd_pagina AS p ON p.pag_id = d.pag_id WHERE d.per_id =".$row_mos_usuario["per_id"]." AND p.pag_nivel= 1";
$mos_mantenedores = mysql_query($query_mos_mantenedores, $conexion) or die(mysql_error());
$row_mos_mantenedores = mysql_fetch_assoc($mos_mantenedores);
$totalRows_mos_mantenedores = mysql_num_rows($mos_mantenedores);

;

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	//array de archivos disponibles
  $archivos_disp_ar = array('jpg', 'jpeg', 'gif', 'png');
  //carpteta donde vamos a guardar la imagen
  $carpeta = '../imagenes/';
  //recibimos el campo de imagen
  $FOTO = $_FILES['img_nombre']['tmp_name'];
  //guardamos el nombre original de la imagen en una variable
  $nombrebre_orig = $_FILES['img_nombre']['name'];
  //el proximo codigo es para ver que extension es la imagen
  $array_nombre = explode('.',$nombrebre_orig);
  $cuenta_arr_nombre = count($array_nombre);
  $extension = strtolower($array_nombre[--$cuenta_arr_nombre]);
  
  //validamos la extension
  if(!in_array($extension, $archivos_disp_ar)) $error2 = "Este tipo de archivo no es permitido";
  
  if(empty($error2)){
  
	  //creamos nuevo nombre para que tenga nombre unico
	  $nombre_nuevo = time().'_'.rand(0,100).'.'.$extension;
	  //nombre nuevo con la carpeta
	  $nombre_nuevo_con_carpeta = $carpeta.$nombre_nuevo;
	  //por fin movemos el archivo a la carpeta de imagenes
	  $mover_archivos = move_uploaded_file($FOTO , $nombre_nuevo_con_carpeta);
	  //de damos permisos 777
	  chmod($nombre_nuevo_con_carpeta,0777);
	  }
  $insertSQL = sprintf("INSERT INTO cmd_imagen (img_nombre, img_activo, pro_id) VALUES (%s, %s, %s)",
                       GetSQLValueString($nombre_nuevo,"text"),
                       GetSQLValueString(isset($_POST['img_activo']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['pro_id'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());

  $insertGoTo = "imagen.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conexion, $conexion);
$query_mos_imagen = "SELECT * FROM cmd_imagen";
$mos_imagen = mysql_query($query_mos_imagen, $conexion) or die(mysql_error());
$row_mos_imagen = mysql_fetch_assoc($mos_imagen);
$totalRows_mos_imagen = mysql_num_rows($mos_imagen);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
        <title>CMD | MENU</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'         name='viewport'>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="css/morris/morris.css" rel="stylesheet" type="text/css" />
        <link href="css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <link href="css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
        <link href="css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <link href="css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
</head>

<body class="skin-blue">
<body class="skin-blue">
<header class="header">
            <a href="index.php" class="logo">CMD
            </a>
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                       
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $row_mos_usuario["personal"];?>
<i class="caret"></i></span> </a>
<ul class="dropdown-menu">
  <!-- User image -->
  <li class="user-header bg-light-blue"> <img src="img/<?php echo $row_mos_usuario["col_foto"];?>" class="img-circle" alt="User Image" />
    <p> <?php echo $row_mos_usuario["personal"];?>
      <!--<small>Member since Nov. 2012</small>-->
    </p>
  </li>
  <!-- Menu Body -->
  <li class="user-body">
  </li>
  <!-- Menu Footer-->
  <li class="user-footer">
    <div class="pull-left"> <a href="../index.php" onclick = "window.open ('../index.php'); return false"; class="btn btn-default btn-flat">Ver Tienda</a> </div>
    <div class="pull-right"> <a href="<?php echo $logoutAction ?>" class="btn btn-default btn-flat">Salir</a> </div>
  </li>
</ul>
</li>
</ul>
</div>
</nav>
</header>
<div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="img/<?php echo $row_mos_usuario["col_foto"];?> " class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p><?php echo $row_mos_usuario["personal"];?> </p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Conectado</a>
                        </div>
                    </div>
                    <!-- search form -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Buscar..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                  <!--      <li class="active">
                            <a href="index.php">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>-->
                        <li>
                            <a href="index.php">
                                <i class="fa fa-th"></i> <span>Inicio</span> <!--<small class="badge pull-right bg-green">new</small>-->
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-bar-chart-o"></i>
                                <span>Mantenedores</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                              <?php do { ?>
                              <li><a href="<?php echo $row_mos_mantenedores['pag_link'];?>">
                              	<i class="fa fa-angle-double-right"></i><?php echo $row_mos_mantenedores['pag_nombre']; ?></a>
                              </li>                
                          	<?php } while ($row_mos_mantenedores = mysql_fetch_assoc($mos_mantenedores)); ?>
                              
                            </ul>
                        </li>
                        
                       
 
                        
                    </ul>
                </section>
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
                        <li><a href="#"><i class="fa fa-dashboard"></i> Mantenedores</a></li>
                        <li class="active">Nueva Imagen</li>
                    </ol>
                </section>
                 <section class="content">
                <div class="row">
                
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="box-title">Nueva Imagen</h3>
                  			</div>

                        <div class="panel-body">
<form method="post" name="form1" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data">
<div class="form-group">Imagen:
     <input type="file" name="img_nombre" value="" ></div>
  <div class="form-group"> Estado:
    <input type="checkbox" name="img_activo" value="" checked></div>
    
  <div class="form-group">  Producto:
     <input type="text" name="pro_id" value="" class="form-control"></div>
   
     <input type="submit" value="Guardar" class="btn btn-primary">
  <input type="hidden" name="MM_insert" value="form1">
  <a href="imagen.php" class="btn btn-default">Cancelar</a> 
</form>
</div><!-- body -->
                    </div><!-- /.primary-->
                </div><!-- /.col-->
</div> <!-- /.row -->


  				</section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div>
         <script src="js/jquery.min.js" type="text/javascript"></script>
        <!-- jQuery UI 1.10.3 -->
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
<?php
mysql_free_result($mos_imagen);

mysql_free_result($mos_seguridad);

mysql_free_result($mos_reportes);

mysql_free_result($mos_procesos);

mysql_free_result($mos_mantenedores);

mysql_free_result($mos_usuario);
?>
