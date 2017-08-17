<?php require_once('../Connections/conexion.php'); ?>

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
if ((isset($_GET['pk'])) && ($_GET['pk'] != "")) {

$pk = $_GET['pk'];

mysql_select_db($database_conexion, $conexion);
$query_mos_doc = "select par_imagen from cmd_partners WHERE par_id = $pk";
$mos_doc = mysql_query($query_mos_doc, $conexion) or die(mysql_error());
$row_mos_doc = mysql_fetch_assoc($mos_doc);
$totalRows_mos_doc = mysql_num_rows($mos_doc);
$foto = $row_mos_doc['par_imagen']; 
$pro_id= $row_mos_doc['par_id'];


$deleteSQL = sprintf("DELETE FROM cmd_partners WHERE par_id=%s", GetSQLValueString($_GET['pk'], "int"));
$Result1 = mysql_query($deleteSQL, $conexion) or die(mysql_error());
//
  $directorio = "../images/clients/";
  unlink($directorio.$foto);//borrar archivo
  //
$deleteGoTo = "partners.php?id=$pro_id";

  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
?>