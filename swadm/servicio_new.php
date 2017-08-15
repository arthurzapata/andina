<?php require('header.php'); 
//initialize the session
//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$msje="";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    	
      $insertSQL = sprintf("INSERT INTO cmd_servicios (ser_descripcion, ser_activo, ser_idioma) VALUES (%s, %s, %s)",
                           GetSQLValueString($_POST['ser_descripcion'], "text"),
                           GetSQLValueString(isset($_POST['ser_activo']) ? "true" : "", "defined","1","0"),
                           GetSQLValueString($_SESSION['idioma'], "text"));

      mysql_select_db($database_conexion, $conexion);
      $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());

      $insertGoTo = "servicios.php";
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
                  		<h3 class="box-title"><i class="fa fa-briefcase"></i> Nuevo Servicio</h3></div>
                        <div class="box-body">
                        
             <div class="row">     
    			<div class="col-md-12">
    <form method="post" name="form1" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data" >
                 
                        <div class="form-group">Servicio:
                         <input type="text" name="ser_descripcion" value="" class="form-control" >
                        </div>
                        <div class="form-group">Estado: <input type="checkbox" name="ser_activo" value="" checked>
                        </div>
                        <input type="submit" value="Guardar" class="btn btn-primary">
                        <a href="servicios.php" class="btn btn-default">Cancelar</a>
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