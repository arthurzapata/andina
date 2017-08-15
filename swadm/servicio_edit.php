<?php require_once('header.php'); ?>
<?php
$msje='';
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

			$updateSQL = sprintf("UPDATE cmd_servicios SET ser_descripcion=%s,ser_activo = %s,ser_idioma = %s WHERE ser_id=%s",
                       GetSQLValueString($_POST['ser_descripcion'], "text"),
                       GetSQLValueString(isset($_POST['ser_activo']) ? "true" : "", "defined","1","0"),
                        GetSQLValueString($_SESSION['idioma'], "text"),
                       GetSQLValueString($_POST['ser_id'], "int"));
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());

  $updateGoTo = "servicios.php";
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
$query_mos_portada = sprintf("SELECT * FROM cmd_servicios WHERE ser_id = %s", GetSQLValueString($colname_mos_portada, "int"));
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
        	 <h3 class="box-title"><i class="fa fa-briefcase"></i> Editar  Servicio</h3></div>
       <div class="box-body">
      		 <div class="row">
            	<div class="col-md-8">  
       
                    <form id="form1" method="post" name="form1" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data">
          
                        <div class="form-group">Servicio:
                        	<input type="text" name="ser_descripcion" value="<?php echo htmlentities($row_mos_portada['ser_descripcion'], ENT_COMPAT, 'UTF-8'); ?>" class="form-control">
                        </div>

                        <div class="form-group">Estado:
      <input type="checkbox" name="ser_activo" value="" <?php if($row_mos_portada['ser_activo'] == 1 ) echo 'checked'; else echo '';?>>
                        </div>
      	
   </div>
   </div>
</div>
 <div class="box-footer">
                     	<input type="submit" value="Editar" class="btn btn-primary">
                        <a href="servicios.php" class="btn btn-default">Cancelar</a>
                     	<input type="hidden" name="MM_update" value="form1">
                      	<input type="hidden" name="ser_id" value="<?php echo $row_mos_portada['ser_id']; ?>">
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