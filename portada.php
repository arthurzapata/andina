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
$totalRows_mos_usuario = mysql_num_rows($mos_usuario);
//portada
$maxRows_mos_portada = 10;
$pageNum_mos_portada = 0;
if (isset($_GET['pageNum_mos_portada'])) {
  $pageNum_mos_portada = $_GET['pageNum_mos_portada'];
}
$startRow_mos_portada = $pageNum_mos_portada * $maxRows_mos_portada;

mysql_select_db($database_conexion, $conexion);
$query_mos_portada = "SELECT * FROM cmd_portada";
$query_limit_mos_portada = sprintf("%s LIMIT %d, %d", $query_mos_portada, $startRow_mos_portada, $maxRows_mos_portada);
$mos_portada = mysql_query($query_limit_mos_portada, $conexion) or die(mysql_error());
$row_mos_portada = mysql_fetch_assoc($mos_portada);
if(isset($_POST['buscar']))
{
	mysql_select_db($database_conexion, $conexion);
	$query_mos_portada = "SELECT * FROM cmd_portada where por_nombre like '%".$_POST['buscar']."%'";
	$query_limit_mos_portada = sprintf("%s LIMIT %d, %d", $query_mos_portada, $startRow_mos_portada, $maxRows_mos_portada);
	$mos_portada = mysql_query($query_limit_mos_portada, $conexion) or die(mysql_error());
	$row_mos_portada = mysql_fetch_assoc($mos_portada);
}

if (isset($_GET['totalRows_mos_portada'])) {
  $totalRows_mos_portada = $_GET['totalRows_mos_portada'];
} else {
  $all_mos_portada = mysql_query($query_mos_portada);
  $totalRows_mos_portada = mysql_num_rows($all_mos_portada);
}
$totalPages_mos_portada = ceil($totalRows_mos_portada/$maxRows_mos_portada)-1;

$queryString_mos_portada = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_mos_portada") == false && 
        stristr($param, "totalRows_mos_portada") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_mos_portada = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_mos_portada = sprintf("&totalRows_mos_portada=%d%s", $totalRows_mos_portada, $queryString_mos_portada);
?>
<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/index.dwt.php" codeOutsideHTMLIsLocked="false" -->
    <head>
        <meta charset="UTF-8">
        <!-- InstanceBeginEditable name="doctitle" -->
        <title>Panel de Administración</title><link rel="stylesheet" href="css/lightbox.css" media="screen">
        <!-- InstanceEndEditable -->
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
        <!-- InstanceBeginEditable name="head" -->
        <!-- InstanceEndEditable -->
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
                       
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $row_mos_usuario["personal"];?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="img/anonimo90.png" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo $row_mos_usuario["personal"];?>
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
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="img/anonimo90.png" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p><?php echo $row_mos_usuario["personal"];?> </p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Conectado</a>
                        </div>
                    </div>
                    <!-- search form
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Buscar..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form> -->
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
                                <i class="fa fa-th"></i> <span>Inicio</span>
                            </a>
                        </li>
               
                        <li class="treeview active">
                            <a href="#">
                                <i class="fa fa-bar-chart-o"></i>
                                <span>Mantenedores</span>
                                <i class="fa pull-right fa-angle-down"></i>
                            </a>
                            <ul class="treeview-menu" style="display: block;">
                                                            <li><a href="categoria.php" style="margin-left: 10px;">
                              	<i class="fa fa-angle-double-right"></i>Categoria</a>
                              </li>                
                          	                              <li><a href="marca.php" style="margin-left: 10px;">
                              	<i class="fa fa-angle-double-right"></i>Marca</a>
                              </li>                
                          	                              <li><a href="portada.php" style="margin-left: 10px;">
                              	<i class="fa fa-angle-double-right"></i>Portada</a>
                              </li>                
                          	                              <li><a href="producto.php" style="margin-left: 10px;">
                              	<i class="fa fa-angle-double-right"></i>Producto</a>
                              </li>                
                          	                              
                            </ul>
                        </li>
                        
                        <li class="treeview active">
                            <a href="#">
                                <i class="fa fa-laptop"></i>
                                <span>Procesos</span>
                                <i class="fa pull-right fa-angle-left"></i>
                            </a>
                            <ul class="treeview-menu" style="display: none;">
                                                           <li><a href="cliente.php" style="margin-left: 10px;">
                              	<i class="fa fa-angle-double-right"></i>Cliente</a>
                              </li>                
                          	                              <li><a href="pedido.php" style="margin-left: 10px;">
                              	<i class="fa fa-angle-double-right"></i>Pedido</a>
                              </li>                
                          	                             
                            </ul>
                        </li>
                        
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>Reportes</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                           <ul class="treeview-menu">
                              <li><a href="#>">
                              	<i class="fa fa-angle-double-right"></i></a>
                              </li>                
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-table"></i> <span>Seguridad</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                              <li><a href="">
                              	<i class="fa fa-angle-double-right"></i></a>
                              </li>                
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
                        <li><a href="#"><i class="fa fa-dashboard"></i> Bienvenidos</a></li>
                        <li class="active"></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
<div class="row">     
    <div class="col-md-12"> 
        <div class="box box-primary">
        <!-- InstanceBeginEditable name="EditRegion1" -->
       <div class="box-header"> 
                  		<h3 class="box-title"><i class="fa fa-briefcase"></i> Portada</h3></div>
                  <div class="box-body">
                  	<div class="row" style="margin-bottom:10px;">
                   		<div class="col-sm-6">
                        	<a class="btn btn-primary" href="portada_new.php"><i class="fa fa-pencil"></i> Agregar</a>
						</div>
                		<div class="col-sm-6 search-form">
                            <form name="formb" id="formb" action="" method="post" class="text-right">
                                  <div class="input-group">                                          
                                     <input type="text" name="buscar" class="form-control" placeholder="Buscar ...">
                                 <div class="input-group-btn">
                                 <button type="submit" name="q" class="btn btn btn-primary"><i class="fa fa-search"></i></button>
                                 </div>
                        </div>                                                     
                        </form>
                        </div>
                   </div>     
                		<div class="box-body table-responsive no-padding">
   <?php if ($totalRows_mos_portada !== 0) { 
						  
 // Show if recordset emptyxx ?>
  <table class="table table-bordered table-striped table-hover table-condensed tablesorter">
  <tr>
    <td><div align="center"><strong>#</strong></div></td>
    <td><div align="center"><strong>Portada</strong></div></td> 
    <td><div align="center"><strong>Descripción</strong></div></td>
    <td><div align="center"><strong>Estado</strong></div></td>
    <td><div align="center"><strong>Imagen</strong></div></td>
   
    <td colspan="2"><div align="center"><strong>Acciones</strong></div></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><div align="center"><?php echo $row_mos_portada['por_id']; ?></div></td>
      <td><div align="center"><?php echo $row_mos_portada['por_nombre']; ?></div></td> 
      <td><div align="center"><?php echo $row_mos_portada['por_descripcion']; ?></div></td>
      <td><div align="center"><a href="update_estado.php?pk=<?php echo $row_mos_portada['por_id']; ?>" title="Cambiar Estado">
        <button class="btn btn-<?php if($row_mos_portada['por_estado']==0) echo 'danger'; else echo 'success'; ?>" type="button"></button>
      </a></div></td>
      <td><div align="center">
      <a rel="lightbox" href="../imagenes/<?php echo $row_mos_portada['por_imagen']; ?>"><img  class="example-image" src="../imagenes/<?php echo $row_mos_portada['por_imagen']; ?>" width="24px" height="24px"></a>
      </div></td>
      <td><div align="center"><a href="portada_edit.php?id=<?php echo $row_mos_portada['por_id']; ?>" title="Editar" class="hide-option"><button class="btn btn-primary btn-xs" type="button" data-toggle="tooltip" data-title="Editar"><i class="fa fa-edit"></i></button></a></div></td>
      <td>
        <div align="center"><a onclick="return confirm('¿Seguro que desea eliminar?')" href="portada_delete.php?id=<?php echo $row_mos_portada['por_id']; ?>" title="Eliminar" class="hide-option">
                <button class="btn btn-primary btn-xs" type="button" data-toggle="tooltip" data-title="Eliminar"><i class="fa fa-trash-o"></i></button>
              </a></div>
      </td>
    </tr>
    <?php } while ($row_mos_portada = mysql_fetch_assoc($mos_portada)); ?>
<tr>
    	<td colspan="7">
        <div class="row">
        		<div class="col-md-6">
        <table>
        	<tr>
            <td>
<?php if ($pageNum_mos_portada > 0) { // Show if not first page ?>
        <a title="Primero" href="<?php printf("%s?pageNum_mos_portada=%d%s", $currentPage, 0, $queryString_mos_portada); ?>"> <button class="btn btn-default btn-sm" type="button"><i class="fa fa-step-backward" data-toggle="tooltip" data-title="Primero"></i></button></a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_mos_portada > 0) { // Show if not first page ?>
        <a title="Anterior" href="<?php printf("%s?pageNum_mos_portada=%d%s", $currentPage, max(0, $pageNum_mos_portada - 1), $queryString_mos_portada); ?>"><button class="btn btn-default btn-sm" type="button" data-toggle="tooltip" data-title="Anterior"><i class="fa fa-backward"></i></button></a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_mos_portada < $totalPages_mos_portada) { // Show if not last page ?>
        <a title="Siguiente" href="<?php printf("%s?pageNum_mos_portada=%d%s", $currentPage, min($totalPages_mos_portada, $pageNum_mos_portada + 1), $queryString_mos_portada); ?>"><button class="btn btn-default btn-sm" type="button" data-toggle="tooltip" data-title="Siguiente"><i class="fa fa-forward"></i></button></a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_mos_portada < $totalPages_mos_portada) { // Show if not last page ?>
        <a title="Ultimo" href="<?php printf("%s?pageNum_mos_portada=%d%s", $currentPage, $totalPages_mos_portada, $queryString_mos_portada); ?>"><button class="btn btn-default btn-sm" type="button" data-toggle="tooltip" data-title="Ultimo"><i class="fa fa-fast-forward"></i></button></a>
        <?php } // Show if not last page ?></td>
      <!-- prueba-->
      
      			</tr>
			</table>
            </div>
            
            <div class="col-md-6 text-right">
      Registros <?php echo ($startRow_mos_portada + 1) ?> a <?php echo min($startRow_mos_portada + $maxRows_mos_portada, $totalRows_mos_portada) ?> de <?php echo $totalRows_mos_portada ?>
      		</div>
       </div>
            
        </td>
      </tr>
  </table>
  <?php 
  } // Show if recordset empty
  else 
  { 
  echo '<br>';
  echo '<div class="alert alert-info alert-dismissable">
         <i class="fa fa-info"></i>
		 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
             <b>Alerta !</b> Ningun registro encontrado !!
        </div>';
	}
   ?>
                        </div>
        <!-- InstanceEndEditable -->
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
<!-- InstanceEnd --></html>