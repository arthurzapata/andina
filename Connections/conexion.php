<?php

# FileName="Connection_php_mysql.htm"

# Type="MYSQL"

# HTTP="true"

$hostname_conexion = "localhost";

$database_conexion = "nov14lhd_pozuzo";
/*
$username_conexion = "nov14lhd";

$password_conexion = "XHtmJ7VfzyofpSS";

*/
$username_conexion = "root";

$password_conexion = "";

$conexion = mysql_connect($hostname_conexion, $username_conexion, $password_conexion) or trigger_error(mysql_error(),E_USER_ERROR);

mysql_query("SET NAMES 'UTF8'"); 



class conexion

{

	public static function db_connect()

	{

		$hostname_conexion = "localhost";

		$database_conexion = "nov14lhd_pozuzo";

	/*	$username_conexion = "nov14lhd";

		$password_conexion = "XHtmJ7VfzyofpSS";
*/
		$username_conexion = "root";

		$password_conexion = "";

		

		$mysqli= new mysqli($hostname_conexion ,$username_conexion,$password_conexion);

		$mysqli->select_db($database_conexion);

		mysql_query("SET NAMES 'UTF8'");

		return $mysqli;

	}



}

?>