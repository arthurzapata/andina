<?php require_once('header.php'); ?>
<?php
$msje='';
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

 if($_FILES['por_imagen']['tmp_name']!="")  //validamos que input file tenga imagen
	{
  //array de archivos disponibles
  $archivos_disp_ar = array('jpg', 'jpeg', 'gif', 'png');
  //carpteta donde vamos a guardar la imagen
  $carpeta = '../images/main-slider/';
  //recibimos el campo de imagen
  $FOTO = $_FILES['cambiar']['tmp_name'];
  //guardamos el nombre original de la imagen en una variable
  $nombrebre_orig = $_FILES['cambiar']['name'];
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
  $updateSQL = sprintf("UPDATE cmd_portada SET por_nombre=%s, por_descripcion=%s, por_imagen=%s, por_idioma = %s WHERE por_id=%s",
                       GetSQLValueString($_POST['por_nombre'], "text"),
                       GetSQLValueString($_POST['por_descripcion'], "text"),
                       GetSQLValueString($nombre_nuevo, "text"),
                       GetSQLValueString($_SESSION['idioma'], "text"),
                       GetSQLValueString($_POST['por_id'], "int"));
	}
	else
	{
			$updateSQL = sprintf("UPDATE cmd_portada SET por_nombre=%s, por_descripcion=%s por_idioma = %s WHERE por_id=%s",
                       GetSQLValueString($_POST['por_nombre'], "text"),
                       GetSQLValueString($_POST['por_descripcion'], "text"),
                       GetSQLValueString($_SESSION['idioma'], "text"),
                       GetSQLValueString($_POST['por_id'], "int"));
	}
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());

  $updateGoTo = "portada.php";
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
$colname_mos_portada = "-1";
if (isset($_GET['id'])) {
  $colname_mos_portada = $_GET['id'];
}
mysql_select_db($database_conexion, $conexion);
$query_mos_portada = sprintf("SELECT * FROM cmd_portada WHERE por_id = %s", GetSQLValueString($colname_mos_portada, "int"));
$mos_portada = mysql_query($query_mos_portada, $conexion) or die(mysql_error());
$row_mos_portada = mysql_fetch_assoc($mos_portada);
$totalRows_mos_portada = mysql_num_rows($mos_portada);
?>
                <!-- Main content -->
<section class="content">
<div class="row">     
    <div class="col-md-12"> 
     <?php echo $msje; ?>
        <div class="box box-primary">
        <!-- InstanceBeginEditable name="EditRegion1" -->
        <div class="box-header">
        	 <h3 class="box-title"><i class="fa fa-briefcase"></i> Editar Portada</h3></div>
       <div class="box-body">
      		 <div class="row">
            	<div class="col-md-8">  
       
                    <form id="form1" method="post" name="form1" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data">
          
                        <div class="form-group">Portada:<input type="text" name="por_nombre" value="<?php echo htmlentities($row_mos_portada['por_nombre'], ENT_COMPAT, 'UTF-8'); ?>" class="form-control">
                        </div>
                        <div class="form-group">Descripción:<textarea class="form-control" name="por_descripcion" rows="4"><?php echo htmlentities($row_mos_portada['por_descripcion'], ENT_COMPAT, 'UTF-8'); ?></textarea>
                        </div>
                    
         <!-- <div class="row">
           <div class="col-md-4">                                
               <div class="form-group">Cambiar Imagen
                     <input id="checkbox" name="checkbox" type="checkbox" onclick="enable_text(this.checked)" value="" class="iradio_minimal">
               </div>                              
         	</div>  
         <div class="col-md-5">-->
            
            <div class="form-group">Imagen:
            	<input type="file" value="" name="por_imagen" id="por_imagen">
      			<!--<input type="hidden" name="pro_foto" value=" htmlentities($row_mos_producto['pro_foto'], ENT_COMPAT, 'utf-8'); ?>">-->
            </div>
      	
   </div>
   </div>
</div>
 <div class="box-footer">
                     	<input type="submit" value="Editar" class="btn btn-primary">
                        <a href="portada.php" class="btn btn-default">Cancelar</a>
                     	<input type="hidden" name="MM_update" value="form1">
                      	<input type="hidden" name="por_id" value="<?php echo $row_mos_portada['por_id']; ?>">
                    </form>
                    </div></div>
                  </div><!-- body -->
        <!-- InstanceEndEditable -->
    	</div><!-- /.primary-->
     </div><!-- /.col-->
</div> <!-- /.row -->
  				</section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

       
<?php require_once('footer.php'); ?>