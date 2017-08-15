<?php require('header.php'); 
//initialize the session
//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$msje="";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

    if($_FILES['por_imagen']['tmp_name']!="") { //validamos que input file tenga imagen
     	//array de archivos disponibles
      $archivos_disp_ar = array('jpg', 'jpeg', 'gif', 'png');
      //carpeta donde vamos a guardar la imagen
      $carpeta = '../images/main-slider/';
      //recibimos el campo de imagen
      $FOTO = $_FILES['por_imagen']['tmp_name'];
      //guardamos el nombre original de la imagen en una variable
      $nombrebre_orig = $_FILES['por_imagen']['name'];
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
    	
      $insertSQL = sprintf("INSERT INTO cmd_portada (por_nombre, por_descripcion, por_estado, por_imagen,por_idioma) VALUES ( %s, %s, %s, %s, %s)",
                           GetSQLValueString($_POST['por_nombre'], "text"),
                           GetSQLValueString($_POST['por_descripcion'], "text"),
                           GetSQLValueString(isset($_POST['por_estado']) ? "true" : "", "defined","1","0"),
                           GetSQLValueString($nombre_nuevo, "text"),
                           GetSQLValueString($_SESSION['idioma'], "text"));

      mysql_select_db($database_conexion, $conexion);
      $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());

      $insertGoTo = "portada.php";
      if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
      }
      header(sprintf("Location: %s", $insertGoTo));

        $msje = '<div class="alert alert-info">
                          <i class="fa fa-info"></i>
                          Registrado Correctamente !!
                      </div>';
    }
    else{
        $msje = '<div class="alert alert-danger">
                          <i class="fa fa-info"></i>
                          Seleccionar Imagen de Portada !!
                      </div>';
    }
}
?>

<section class="content">
<div class="row">     
    <div class="col-md-12"> 
        <?php echo $msje; ?>
        <div class="box box-primary">
        <!-- InstanceBeginEditable name="EditRegion1" -->
        <div class="box-header"> 
                  		<h3 class="box-title"><i class="fa fa-briefcase"></i> Nueva Portada</h3></div>
                        <div class="box-body">
                        
             <div class="row">     
    			<div class="col-md-8">
    <form method="post" name="form1" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data" >
                 
                        <div class="form-group">Portada: <input type="text" name="por_nombre" value="" class="form-control" required>
                        </div>
                        
                        <div class="form-group">Descripción: <textarea class="form-control" name="por_descripcion" rows="4"></textarea>
                        </div>
                        <div class="form-group">Estado: <input type="checkbox" name="por_estado" value="" checked>
                        </div>
                       
                        <div class="form-group">
                                   Imagen <!--(779 x 448 px):--> <input name="por_imagen" type="file">
                                </div>
                        <input type="submit" value="Guardar" class="btn btn-primary">
                        <a href="portada.php" class="btn btn-default">Cancelar</a>
                        <input type="hidden" name="MM_insert" value="form1">
                    </form>
                    </div>
                    </div>
             </div><!-- body -->
        <!-- InstanceEndEditable -->
    	</div><!-- /.primary-->
     </div><!-- /.col-->
</div> <!-- /.row -->
  				</section><!-- /.content -->
<?php require('footer.php'); ?>