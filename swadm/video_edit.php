<?php require_once('header.php'); ?>
<?php
$msje='';
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

			$updateSQL = sprintf("UPDATE cmd_video SET vid_nombre=%s, vid_url=%s, vid_activo = %s WHERE vid_id=%s",
                       GetSQLValueString($_POST['vid_nombre'], "text"),
                       GetSQLValueString($_POST['vid_url'], "text"),
                       GetSQLValueString(isset($_POST['vid_activo']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['vid_id'], "int"));
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());

  $updateGoTo = "video.php";
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
$query_mos_portada = sprintf("SELECT * FROM cmd_video WHERE vid_id = %s", GetSQLValueString($colname_mos_portada, "int"));
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
        	 <h3 class="box-title"><i class="fa fa-briefcase"></i> Editar  Video</h3></div>
       <div class="box-body">
      		 <div class="row">
            	<div class="col-md-8">  
       
                    <form id="form1" method="post" name="form1" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data">
          
                        <div class="form-group">Nombre:
                        	<input type="text" name="vid_nombre" value="<?php echo htmlentities($row_mos_portada['vid_nombre'], ENT_COMPAT, 'UTF-8'); ?>" class="form-control">
                        </div>
                        
                        <div class="form-group">Url: 
                             <input type="text" name="vid_url" value="<?php echo htmlentities($row_mos_portada['vid_url'], ENT_COMPAT, 'UTF-8'); ?>" class="form-control" required>
                        </div>
                        <div class="form-group">Estado:
      <input type="checkbox" name="vid_activo" value="" <?php if($row_mos_portada['vid_activo'] == 1 ) echo 'checked'; else echo '';?>>
                        </div>
      	
   </div>
   </div>
</div>
 <div class="box-footer">
                     	<input type="submit" value="Editar" class="btn btn-primary">
                        <a href="video.php" class="btn btn-default">Cancelar</a>
                     	<input type="hidden" name="MM_update" value="form1">
                      	<input type="hidden" name="vid_id" value="<?php echo $row_mos_portada['vid_id']; ?>">
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