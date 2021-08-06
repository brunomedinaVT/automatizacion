<?php
	//conexion con sql
	$mysql_servidor = "localhost";        //localhost
	$mysql_base = "puestos";     //nombre BD
	$mysql_usuario = "root";   //usuario BD
	$mysql_clave = "";        //contraseña BD
	
	
	$mysqli = new mysqli($mysql_servidor,$mysql_usuario,$mysql_clave,$mysql_base);
?>