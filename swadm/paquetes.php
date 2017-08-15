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
        $tabla = 'cmd_noticia';
        break;
    case 'en':
         $lenguaje = 'Ingles';
         $tabla = 'cmd_noticia_en';
        break;
    case 'de':
         $lenguaje = 'Aleman';
         $tabla = 'cmd_noticia_de';
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
$query_mos_config = "SELECT * FROM cmd_inicio WHERE ini_idioma = '".$idioma."'";
$mos_config = mysql_query($query_mos_config, $conexion) or die(mysql_error());
$row_mos_config = mysql_fetch_assoc($mos_config);
$totalRows_mos_config = mysql_num_rows($mos_config);


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

 if($_FILES['ini_imagen']['tmp_name']!="") { //validamos que input file tenga imagen
      //array de archivos disponibles
      $archivos_disp_ar = array('jpg', 'jpeg', 'gif', 'png');
      //carpeta donde vamos a guardar la imagen
      $carpeta = '../images/main-slider/';
      //recibimos el campo de imagen
      $FOTO = $_FILES['ini_imagen']['tmp_name'];
      //guardamos el nombre original de la imagen en una variable
      $nombrebre_orig = $_FILES['ini_imagen']['name'];
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

  $updateSQL = sprintf("UPDATE cmd_inicio SET ini_inicio=%s, ini_bienvenida = %s,ini_imagen=%s WHERE ini_idioma=%s",
                        GetSQLValueString($_POST['ini_inicio'], "text"),
                        GetSQLValueString($_POST['ini_bienvenida'], "text"),
                        GetSQLValueString($nombre_nuevo, "text"),
                        GetSQLValueString($idioma, "text"));
  }
  else
  {
    $updateSQL = sprintf("UPDATE cmd_inicio SET ini_inicio=%s, ini_bienvenida = %s WHERE ini_idioma=%s",
                        GetSQLValueString($_POST['ini_inicio'], "text"),
                        GetSQLValueString($_POST['ini_bienvenida'], "text"),
                        GetSQLValueString($idioma, "text"));
  }
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());

  $updateGoTo = "inicio.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
  
  $msje = '<div class="alert alert-info">
                          <i class="fa fa-info"></i>
                          Registrado Correctamente !!
                      </div>';
  
}
////////////
$maxRows_mos_noticia = 10;

$pageNum_mos_noticia = 0;

if (isset($_GET['pageNum_mos_noticia'])) {

  $pageNum_mos_noticia = $_GET['pageNum_mos_noticia'];

}

$startRow_mos_noticia = $pageNum_mos_noticia * $maxRows_mos_noticia;



mysql_select_db($database_conexion, $conexion);


$query_mos_noticia = "SELECT * FROM ".$tabla." order by not_id desc";
$query_limit_mos_noticia = sprintf("%s LIMIT %d, %d", $query_mos_noticia, $startRow_mos_noticia, $maxRows_mos_noticia);
$mos_noticia = mysql_query($query_limit_mos_noticia, $conexion) or die(mysql_error());
$row_mos_noticia = mysql_fetch_assoc($mos_noticia);

if (isset($_GET['totalRows_mos_noticia'])) {

  $totalRows_mos_noticia = $_GET['totalRows_mos_noticia'];

} else {

  $all_mos_noticia = mysql_query($query_mos_noticia);

  $totalRows_mos_noticia = mysql_num_rows($all_mos_noticia);

}

$totalPages_mos_noticia = ceil($totalRows_mos_noticia/$maxRows_mos_noticia)-1;



$queryString_mos_noticia = "";

if (!empty($_SERVER['QUERY_STRING'])) {

  $params = explode("&", $_SERVER['QUERY_STRING']);

  $newParams = array();

  foreach ($params as $param) {

    if (stristr($param, "pageNum_mos_noticia") == false && 

        stristr($param, "totalRows_mos_noticia") == false) {

      array_push($newParams, $param);

    }

  }

  if (count($newParams) != 0) {

    $queryString_mos_noticia = "&" . htmlentities(implode("&", $newParams));

  }

}

$queryString_mos_noticia = sprintf("&totalRows_mos_noticia=%d%s", $totalRows_mos_noticia, $queryString_mos_noticia);
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

                                

                                <div class="box-header">

                                    <h3 class="box-title">Gestor de Paquetes</h3>

                  				</div>

                                        

                                                                         

                  <div class="box-body">

    <div style="margin:0px 0px 10px 0px;">
    <?php if ($tabla == 'cmd_noticia') { ?>
      <a href="paquete_new.php" class="btn btn-primary">Nuevo</a>
      <?php } ?>
	</div>

    <div  class="box-body table-responsive no-padding">

	<table class="table table-hover">

  <tr>

    <td><div align="center"><strong>#</strong></div></td>

    <td><div align="center"><strong>Paquete</strong></div></td> 

    <!--<td><div align="center"><strong>Descripción</strong></div></td>

    <td><div align="center"><strong>Categoría</strong></div></td>-->

    <td><div align="center"><strong>Fecha</strong></div></td>

    <td><div align="center"><strong>Más Img</strong></div></td>    

    <td><div align="center"><strong>Estado</strong></div></td>

   

    <td colspan="3"><div align="center"><strong>Acciones</strong></div></td>

  </tr>

  <?php do { ?>

    <tr>

      <td><?php echo $row_mos_noticia['not_id']; ?></div></td>

      <td><?php echo $row_mos_noticia['not_titulo']; ?></div></td> 

      <!--<td>

	  	<?php /* if(strlen($row_mos_noticia['not_nota']) > 50)

					  {

						$texto = substr($row_mos_noticia['not_nota'], 0 , 200)." ... "; 

					  	 echo $texto;

					  }

					  else

					 		echo $row_mos_noticia['not_nota'];*/?>

      </td>

      <td><?php echo $row_mos_noticia['cat_nombre']; ?></td>-->

      <td><?php echo $row_mos_noticia['not_fechareg']; ?></td>

       <td><div align="center"><a href="imagen.php?id=<?php echo $row_mos_noticia['not_id']; ?>" class="fa fa-fw fa-eye" title="detalle fotos"></a></div></td>

      <td><a href="update_paquete.php?pk=<?php echo $row_mos_noticia['not_id']; ?>" title="Cambiar Estado">

        <button class="btn btn-<?php if($row_mos_noticia['not_activo']==0) echo 'danger'; else echo 'success'; ?>" type="button"></button>

      </a></td>

      <td><div align="center">

      <a rel="lightbox" href="../images/resource/<?php echo $row_mos_noticia['not_imagen']; ?>" title="Detalle Imagen"><img  class="example-image" src="../images/resource/<?php echo $row_mos_noticia['not_imagen']; ?>" width="24px" height="24px"></a>

      </div></td>

      <td>
      <a href="paquete_edit.php?id=<?php echo $row_mos_noticia['not_id']; ?>" title="Editar" class="hide-option"><button class="btn btn-primary btn-xs" type="button" data-toggle="tooltip" data-title="Editar" data-original-title="" title=""><i class="fa fa-edit"></i></button></a>

      </td>

      <td><a onClick="return confirm('¿Seguro que desea eliminar?')" href="paquete_delete.php?id=<?php echo $row_mos_noticia['not_id']; ?>" title="Eliminar" class="hide-option">  <button class="btn btn-primary btn-xs" type="button" data-toggle="tooltip" data-title="Editar" data-original-title="" title=""><i class="fa fa-trash-o"></i></button></a>

      </td>

    </tr>

    <?php } while ($row_mos_noticia = mysql_fetch_assoc($mos_noticia)); ?>

</table>

    </div>

                </div><!-- body -->

    </div><!-- /.primary-->

          </div><!-- /.col-->

    </div> <!-- /.row -->

     <ul class="pager" style="float:right">

        <li><?php if ($pageNum_mos_noticia > 0) { // Show if not first page ?>

            <a title="primero" href="<?php printf("%s?pageNum_mos_noticia=%d%s", $currentPage, 0, $queryString_mos_noticia); ?>"><i class="fa fa-step-backward"></i></a>

            <?php } // Show if not first page ?></li>

        <li><?php if ($pageNum_mos_noticia > 0) { // Show if not first page ?>

            <a title="anterior" href="<?php printf("%s?pageNum_mos_noticia=%d%s", $currentPage, max(0, $pageNum_mos_noticia - 1), $queryString_mos_noticia); ?>"><i class="fa fa-backward"></i></a>

            <?php } // Show if not first page ?></li>

        <li><?php if ($pageNum_mos_noticia < $totalPages_mos_noticia) { // Show if not last page ?>

            <a title="siguiente" href="<?php printf("%s?pageNum_mos_noticia=%d%s", $currentPage, min($totalPages_mos_noticia, $pageNum_mos_noticia + 1), $queryString_mos_noticia); ?>"><i class="fa fa-forward"></i></a>

            <?php } // Show if not last page ?></li>

        <li><?php if ($pageNum_mos_noticia < $totalPages_mos_noticia) { // Show if not last page ?>

            <a title="ultimo" href="<?php printf("%s?pageNum_mos_noticia=%d%s", $currentPage, $totalPages_mos_noticia, $queryString_mos_noticia); ?>"><i class="fa fa-step-forward"></i></a>

            <?php } // Show if not last page ?></li>

      </ul>

  				</section><!-- /.content -->

            </aside><!-- /.right-side -->

</div><!-- ./wrapper -->

        <!-- jQuery UI 1.10.3 -->

        <script src="js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>

        <script src="js/jquery.min.js" type="text/javascript"></script>

		<script src="js/lightbox.js" type="text/javascript"></script>

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

