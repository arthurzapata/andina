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

	

  $logoutGoTo = "adm/login.php";

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
             case 'fr':
         $lenguaje = 'Frances';
         $tabla = 'cmd_noticia_fr';
        break;
    case 'it':
         $lenguaje = 'Italiano';
         $tabla = 'cmd_noticia_it';
        break;
    }
}
$msje = '';

$editFormAction = $_SERVER['PHP_SELF'];

if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);

}



if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

    	if($_FILES['not_imagen']['tmp_name']!="")  //validamos que input file tenga imagen
      {
        //array de archivos disponibles
        $archivos_disp_ar = array('jpg', 'jpeg', 'gif', 'png');
        //carpteta donde vamos a guardar la imagen
        $carpeta = '../images/resource/';

        //recibimos el campo de imagen

        $FOTO = $_FILES['not_imagen']['tmp_name'];

        //guardamos el nombre original de la imagen en una variable

        $nombrebre_orig = $_FILES['not_imagen']['name'];

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
	     $sContent=stripslashes($_POST['not_nota']);//remove slashes (/)

      $sContent=ereg_replace("'","''",$sContent);//fix SQL


       $updateSQL = sprintf("UPDATE ".$tabla." SET not_imagen=%s, not_titulo=%s, not_nota=%s, not_activo=%s,not_precio=%s,not_video=%s,not_tipovideo=%s, not_moneda=%s WHERE not_id=%s",
                           GetSQLValueString($nombre_nuevo, "text"),
                           GetSQLValueString($_POST['not_titulo'], "text"),
                           GetSQLValueString($_POST['not_nota'], "text"),
                           GetSQLValueString(isset($_POST['not_activo']) ? "true" : "", "defined","1","0"),
                           GetSQLValueString($_POST['not_precio'], "decimal"),
                           GetSQLValueString($_POST['not_video'], "text"),
                           GetSQLValueString($_POST['not_tipovideo'], "int"),
                           GetSQLValueString($_POST['not_moneda'], "text"),
                           GetSQLValueString($_POST['not_id'], "int"));

      mysql_select_db($database_conexion, $conexion);
      $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());


	 }
  else
  {
      $updateSQL = sprintf("UPDATE ".$tabla." SET  not_titulo=%s, not_nota=%s, not_activo=%s,not_precio=%s,not_video=%s,not_tipovideo=%s, not_moneda=%s WHERE not_id=%s",
                           GetSQLValueString($_POST['not_titulo'], "text"),
                           GetSQLValueString($_POST['not_nota'], "text"),
                           GetSQLValueString(isset($_POST['not_activo']) ? "true" : "", "defined","1","0"),
                           GetSQLValueString($_POST['not_precio'], "decimal"),
                           GetSQLValueString($_POST['not_video'], "text"),
                           GetSQLValueString($_POST['not_tipovideo'], "int"),
                           GetSQLValueString($_POST['not_moneda'], "text"),
                           GetSQLValueString($_POST['not_id'], "int"));

      mysql_select_db($database_conexion, $conexion);
      $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());

     
  } 
      $updateGoTo = "paquetes.php";
      if (isset($_SERVER['QUERY_STRING'])) {
        $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
        $updateGoTo .= $_SERVER['QUERY_STRING'];
      }
      header(sprintf("Location: %s", $updateGoTo));
}


$colname_mos_usuario = "-1";

if (isset($_SESSION['MM_Username'])) {

  $colname_mos_usuario = $_SESSION['MM_Username'];

}

mysql_select_db($database_conexion, $conexion);

$query_mos_usuario = sprintf("SELECT * FROM cmd_usuario WHERE usu_nombre = %s", GetSQLValueString($colname_mos_usuario, "text"));

$mos_usuario = mysql_query($query_mos_usuario, $conexion) or die(mysql_error());

$row_mos_usuario = mysql_fetch_assoc($mos_usuario);

$totalRows_mos_usuario = mysql_num_rows($mos_usuario);


$colname_mos_noticia = "-1";

if (isset($_GET['id'])) {

  $colname_mos_noticia = $_GET['id'];

}

mysql_select_db($database_conexion, $conexion);

$query_mos_noticia = sprintf("SELECT * FROM ".$tabla." WHERE not_id = %s", GetSQLValueString($colname_mos_noticia, "int"));

$mos_noticia = mysql_query($query_mos_noticia, $conexion) or die(mysql_error());

$row_mos_noticia = mysql_fetch_assoc($mos_noticia);

$totalRows_mos_noticia = mysql_num_rows($mos_noticia);

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


         <script src="scripts/innovaeditor.js"></script>
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

                    <div class="panel panel-default">

                        <div class="panel-heading">

                            <h3 class="box-title">Editar Paquete</h3>

                  			</div>

                             <div class="panel-body">

                               <form method="post" name="form1" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data">

                              

                               <!--    <div class= "form-group">Categoría:

                                    <select name="cat_id" class="form-control">

                                       <?php 

do {  

?>

                                       <option value="<?php echo $row_mos_categoria['cat_id']?>" <?php if (!(strcmp($row_mos_categoria['cat_id'], htmlentities($row_mos_noticia['cat_id'], ENT_COMPAT, 'UTF-8')))) {echo "SELECTED";} ?>><?php echo $row_mos_categoria['cat_nombre']?></option>

                                       <?php

} while ($row_mos_categoria = mysql_fetch_assoc($mos_categoria));

?>

                                     </select>

                                   </div>-->

                                   <div class= "form-group">Título:

                                    <input type="text" name="not_titulo" value="<?php echo htmlentities($row_mos_noticia['not_titulo'], ENT_COMPAT, 'UTF-8'); ?>" class="form-control">

                                   </div>

                                   <div class= "form-group">Nota:

                                    <textarea name="not_nota" id="not_nota" class="form-control">

                                          <?php

  function encodeHTML($sHTML)

    {

    $sHTML=ereg_replace("&","&amp;",$sHTML);

    $sHTML=ereg_replace("<","&lt;",$sHTML);

    $sHTML=ereg_replace(">","&gt;",$sHTML);

    return $sHTML;

    }

	echo $row_mos_noticia['not_nota'];

  if(isset($_POST['not_nota']))

    {

    $sContent=stripslashes($_POST['not_nota']); /*** remove (/) slashes ***/

    echo encodeHTML($sContent);

    }

  ?>

  

            </textarea>

                <script>

    var oEdit1 = new InnovaEditor("oEdit1");

    oEdit1.width="100%";

    oEdit1.height="200";

    oEdit1.toolbarMode = 2;

	oEdit1.mode="XHTMLBody"; 

	oEdit1.cmdAssetManager = "modalDialogShow('assetmanager/assetmanager.php',640,465)"; //Command to open the Asset Manager add-on.	

    oEdit1.REPLACE("not_nota");//Specify the id of the textarea here

  </script>

                                   </div>

                                                                    
                                  <div class="form-group">Portada:
                                        <input name="not_imagen" id="not_imagen" type="file">
                                  </div>
                                  <div class="row">
  <div class="col-md-6">
      <div class="form-group">Precio:
          <input name="not_precio" id="not_precio" type="text" class="form-control" value="<?php echo htmlentities($row_mos_noticia['not_precio'], ENT_COMPAT, 'UTF-8'); ?>">
      </div>
  </div>
  <div class="col-md-6">
       <div class="form-group">Moneda:
        <select name="not_moneda" id="not_moneda" class="form-control" value="<?php echo htmlentities($row_mos_noticia['not_moneda'], ENT_COMPAT, 'UTF-8'); ?>">
              <option value="€" <?php if (!(strcmp("€", htmlentities($row_mos_noticia['not_moneda'], ENT_COMPAT, 'UTF-8')))) {echo "SELECTED";} ?>>€</option>  
              <option value="S/" <?php if (!(strcmp("S/", htmlentities($row_mos_noticia['not_moneda'], ENT_COMPAT, 'UTF-8')))) {echo "SELECTED";} ?>>S/</option>  
              <option value="$" <?php if (!(strcmp("$", htmlentities($row_mos_noticia['not_moneda'], ENT_COMPAT, 'UTF-8')))) {echo "SELECTED";} ?>>$</option>  
             
          </select>

          
       </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
      <div class="form-group">Tipo Video:
          
           <select name="not_tipovideo" id="not_tipovideo" class="form-control" value="<?php echo htmlentities($row_mos_noticia['not_tipovideo'], ENT_COMPAT, 'UTF-8'); ?>">
              <option value="1" <?php if (!(strcmp("1", htmlentities($row_mos_noticia['not_tipovideo'], ENT_COMPAT, 'UTF-8')))) {echo "SELECTED";} ?>>Youtube</option>  
              <option value="2" <?php if (!(strcmp("2", htmlentities($row_mos_noticia['not_tipovideo'], ENT_COMPAT, 'UTF-8')))) {echo "SELECTED";} ?>>Vimeo</option>  
          </select>
      </div>
  </div>
  <div class="col-md-6">
       <div class="form-group">Video Url:
          <input name="not_video" id="not_video" type="text" class="form-control" value="<?php echo htmlentities($row_mos_noticia['not_video'], ENT_COMPAT, 'UTF-8'); ?>">
       </div>
  </div>
</div>
                                   <div class= "form-group">Activo:

                                    <input type="checkbox" name="not_activo" value=""  <?php if (!(strcmp(htmlentities($row_mos_noticia['not_activo'], ENT_COMPAT, 'UTF-8'),1))) {echo "checked=\"checked\"";} ?>>

                                   </div>

                                   <div class= "form-group">

                                    <input type="submit" value="Editar" class="btn btn-primary">

                                    <a href="paquetes.php" class="btn btn-default">Cancelar</a>

                                   </div>

                              

                                 <input type="hidden" name="MM_update" value="form1">

                                 <input type="hidden" name="not_id" value="<?php echo $row_mos_noticia['not_id']; ?>">

                               </form>

                               <p>&nbsp;</p>

                             </div>

                             <!-- body -->

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

