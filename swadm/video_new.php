<?php require('header.php'); 
//initialize the session
//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$msje="";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    	
      $insertSQL = sprintf("INSERT INTO cmd_video (vid_nombre, vid_url, vid_activo) VALUES (%s, %s, %s)",
                           GetSQLValueString($_POST['vid_nombre'], "text"),
                           GetSQLValueString($_POST['vid_url'], "text"),
                           GetSQLValueString(isset($_POST['vid_activo']) ? "true" : "", "defined","1","0"));

      mysql_select_db($database_conexion, $conexion);
      $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());

      $insertGoTo = "video.php";
      if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
      }
      header(sprintf("Location: %s", $insertGoTo));

        $msje = '<div class="alert alert-info">
                          <i class="fa fa-info"></i>
                          Registrado Correctamente !!
                      </div>';
   /* }
    else{
        $msje = '<div class="alert alert-danger">
                          <i class="fa fa-info"></i>
                          Seleccionar Imagen de Portada !!
                      </div>';
    }*/
}
?>

<section class="content">
<div class="row">     
    <div class="col-md-12"> 
        <?php echo $msje; ?>
        <div class="box box-primary">
        <!-- InstanceBeginEditable name="EditRegion1" -->
        <div class="box-header"> 
                  		<h3 class="box-title"><i class="fa fa-briefcase"></i> Nuevo Video</h3></div>
                        <div class="box-body">
                        
             <div class="row">     
    			<div class="col-md-8">
    <form method="post" name="form1" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data" >
                 
                        <div class="form-group">Nombre:
                         <input type="text" name="vid_nombre" value="" class="form-control" >
                        </div>
                        
                        <div class="form-group">Url: 
                             <input type="text" name="vid_url" value="" class="form-control" required>
                        </div>
                        <div class="form-group">Estado: <input type="checkbox" name="vid_activo" value="" checked>
                        </div>
                        <input type="submit" value="Guardar" class="btn btn-primary">
                        <a href="video.php" class="btn btn-default">Cancelar</a>
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