<?php require('header.php'); 
//portada
$maxRows_mos_portada = 10;
$pageNum_mos_portada = 0;
if (isset($_GET['pageNum_mos_portada'])) {
  $pageNum_mos_portada = $_GET['pageNum_mos_portada'];
}
$startRow_mos_portada = $pageNum_mos_portada * $maxRows_mos_portada;

mysql_select_db($database_conexion, $conexion);
$query_mos_portada = "SELECT * FROM cmd_servicios where ser_idioma ='".$_SESSION['idioma']."' order by 1 desc";
//$query_limit_mos_portada = sprintf("%s LIMIT %d, %d", $query_mos_portada, $startRow_mos_portada, $maxRows_mos_portada);
$mos_portada = mysql_query($query_mos_portada, $conexion) or die(mysql_error());
$row_mos_portada = mysql_fetch_assoc($mos_portada);

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
                <!-- Main content -->
                <section class="content">
<div class="row">     
    <div class="col-md-12"> 
        <div class="box box-primary">
        <!-- InstanceBeginEditable name="EditRegion1" -->
       <div class="box-header"> 
                  		<h3 class="box-title"><i class="fa fa-briefcase"></i> Servicios</h3></div>
                  <div class="box-body">
                  	<div class="row" style="margin-bottom:10px;">
                   		<div class="col-sm-6">
                        	<a class="btn btn-primary" href="servicio_new.php"><i class="fa fa-pencil"></i> Agregar</a>
						</div>
                		<!--<div class="col-sm-6 search-form">
                            <form name="formb" id="formb" action="" method="post" class="text-right">
                                  <div class="input-group">                                          
                                     <input type="text" name="buscar" class="form-control" placeholder="Buscar ...">
                                 <div class="input-group-btn">
                                 <button type="submit" name="q" class="btn btn btn-primary"><i class="fa fa-search"></i></button>
                                 </div>
                        </div>                                                     
                        </form>
                        </div>-->
                   </div>     
                		<div class="box-body table-responsive no-padding">
   <?php if ($totalRows_mos_portada !== 0) { 
						  
 // Show if recordset emptyxx ?>
  <table class="table table-bordered table-striped table-hover table-condensed tablesorter">
  <tr>
    <td><div align="center"><strong>#</strong></div></td>
    <td><div align="center"><strong>Servicio</strong></div></td> 
    <td><div align="center"><strong>Estado</strong></div></td>
    
   
    <td colspan="2"><div align="center"><strong>Acciones</strong></div></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><div align="center"><?php echo $row_mos_portada['ser_id']; ?></div></td>
      <td><div align="center"><?php echo $row_mos_portada['ser_descripcion']; ?></div></td> 
      <td><div align="center"><a href="update_servicio.php?pk=<?php echo $row_mos_portada['ser_id']; ?>" title="Cambiar Estado">
        <button class="btn btn-<?php if($row_mos_portada['ser_activo']==0) echo 'danger'; else echo 'success'; ?>" type="button"></button>
      </a></div>
      </td>
 
      <td><div align="center"><a href="servicio_edit.php?id=<?php echo $row_mos_portada['ser_id']; ?>" title="Editar" class="hide-option"><button class="btn btn-primary btn-xs" type="button" data-toggle="tooltip" data-title="Editar"><i class="fa fa-edit"></i></button></a></div></td>
      <td>
        <div align="center"><a onclick="return confirm('¿Seguro que desea eliminar?')" href="servicio_delete.php?id=<?php echo $row_mos_portada['ser_id']; ?>" title="Eliminar" class="hide-option">
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
<?php require('footer.php'); ?>