<?php require_once('Connections/conexion.php'); 

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
      $theValue = ($theValue != "") ? doubleval($theValue)  : "NULL";
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
/*
mysql_select_db($database_conexion, $conexion);
$query_mos_por = "truncate table cmd_archivos";
$mos_por = mysql_query($query_mos_por, $conexion) or die(mysql_error());
$row_mos_por = mysql_fetch_assoc($mos_por);
*/
//$directorio = opendir("."); //ruta actual
$directorio = opendir("images/resource/galeri"); //ruta actual
while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
{
    if (is_dir($archivo))//verificamos si es o no un directorio
    {
        echo "[".$archivo . "]<br />"; //de ser un directorio lo envolvemos entre corchetes
    }
    else
    {
        echo $archivo . "<br />";
        //
        $insertSQL = sprintf("INSERT INTO cmd_archivos ( imagen ) VALUES ( %s) ", GetSQLValueString($archivo,"text"));
        mysql_select_db($database_conexion, $conexion);
        $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
        //    
    }
}

////////////
mysql_select_db($database_conexion, $conexion);
/*$query_mos_portada = "select imagen from cmd_archivos c 
where imagen not in ( SELECT c.imagen FROM cmd_archivos c inner join cmd_fotos f on rtrim(c.imagen) = f.fot_nombre)";*/
$query_mos_portada = "select imagen from cmd_archivos c 
where imagen not in ( SELECT c.imagen FROM cmd_archivos c inner join cmd_fotos f on c.imagen = f.fot_nombre inner join cmd_album a on f.alb_id = a.alb_id where a.alb_activo = 1 )";

$mos_portada = mysql_query($query_mos_portada, $conexion) or die(mysql_error());
$row_mos_portada = mysql_fetch_assoc($mos_portada);

$directorio = "images/resource/galeri/";
echo '================================Borrados===============================' ;
do 
{ 
    $foto = $row_mos_portada['imagen'];
    echo $foto;
    unlink($directorio.$foto);//borrar archivo
} 
while ($row_mos_portada = mysql_fetch_assoc($mos_portada)); 

echo '================================Borrar los archivos q no estan en mi BD===============================' ;
echo 'Proceso completado mi perrija tierna !!' ; 
echo '================================TU MARISCAL ARTHUR===============================' ;

?>