<?php require('header.php'); 
//initialize the session
//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$msje="";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

      /*$insertSQL = sprintf("INSERT INTO cmd_album (alb_titulo,  alb_tit_ingles, alb_tit_aleman,alb_activo) VALUES ( %s, %s, %s, %s)",
                           GetSQLValueString($_POST['alb_titulo'], "text"),
                           GetSQLValueString($_POST['alb_tit_ingles'], "text"),
                           GetSQLValueString($_POST['alb_tit_aleman'], "text"),
                           GetSQLValueString(isset($_POST['alb_activo']) ? "true" : "", "defined","1","0"));
                           */
      $insertSQL =  sprintf("UPDATE cmd_album SET alb_titulo=%s,  alb_tit_ingles=%s,alb_tit_aleman=%s, alb_tit_frances=%s, alb_tit_italiano=%s,  alb_activo = %s WHERE alb_id=%s",
                          GetSQLValueString($_POST['alb_titulo'], "text"),
                           GetSQLValueString($_POST['alb_tit_ingles'], "text"),
                           GetSQLValueString($_POST['alb_tit_aleman'], "text"),
                           GetSQLValueString($_POST['alb_tit_frances'], "text"),
                           GetSQLValueString($_POST['alb_tit_italiano'], "text"),
                           GetSQLValueString(isset($_POST['alb_activo']) ? "true" : "", "defined","1","0"),
                           GetSQLValueString($_POST['alb_id'], "int"));
  
      mysql_select_db($database_conexion, $conexion);
      $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());

      $insertGoTo = "album_editar.php";
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


$colname_mos_portada = "-1";
if (isset($_GET['id'])) {
  $colname_mos_portada = $_GET['id'];
}
mysql_select_db($database_conexion, $conexion);
$query_mos_portada = sprintf("SELECT * FROM cmd_album WHERE alb_id = %s", GetSQLValueString($colname_mos_portada, "int"));
$mos_portada = mysql_query($query_mos_portada, $conexion) or die(mysql_error());
$row_mos_portada = mysql_fetch_assoc($mos_portada);

?>

<section class="content">
<div class="row">     
    <div class="col-md-12"> 
        <?php echo $msje; ?>
        <div class="box box-primary">
        <!-- InstanceBeginEditable name="EditRegion1" -->
        <div class="box-header"> 
                        <h3 class="box-title"><i class="fa fa-briefcase"></i> Editar Album</h3></div>
                        <div class="box-body">
                        
             <div class="row">     
                <div class="col-md-8">
    <form method="post" name="form1" action="<?php echo $editFormAction; ?>" >
                 
                        <div class="form-group">Título Español:
                         <input type="text" name="alb_titulo" value="<?php echo htmlentities($row_mos_portada['alb_titulo'], ENT_COMPAT, 'UTF-8'); ?>" class="form-control" required>
                        </div>
                        <div class="form-group">Título Inglés: <input type="text" name="alb_tit_ingles" value="<?php echo htmlentities($row_mos_portada['alb_tit_ingles'], ENT_COMPAT, 'UTF-8'); ?>" class="form-control" required>
                        </div>
                        <div class="form-group">Título Alemán: <input type="text" name="alb_tit_aleman" value="<?php echo htmlentities($row_mos_portada['alb_tit_aleman'], ENT_COMPAT, 'UTF-8'); ?>" class="form-control" required>
                        </div>

                                                 <div class="form-group">Título Frances: <input type="text" name="alb_tit_frances" value="<?php echo htmlentities($row_mos_portada['alb_tit_frances'], ENT_COMPAT, 'UTF-8'); ?>" class="form-control" required>
                        </div>
                                                <div class="form-group">Título Italiano: <input type="text" name="alb_tit_italiano" value="<?php echo htmlentities($row_mos_portada['alb_tit_italiano'], ENT_COMPAT, 'UTF-8'); ?>" class="form-control" required>
                        </div> 



                        <div class="form-group">Estado: <input type="checkbox" name="alb_activo" <?php if (!(strcmp(htmlentities($row_mos_portada['alb_activo'], ENT_COMPAT, 'UTF-8'),1))) {echo "checked=\"checked\"";} ?>>
                        </div>
                       
                        <input type="submit" value="Guardar" class="btn btn-primary">
                        <a href="album.php" class="btn btn-default">Cancelar</a>
                        <input type="hidden" name="MM_insert" value="form1">
                        <input type="hidden" name="alb_id" value="<?php echo $row_mos_portada['alb_id']; ?>">

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