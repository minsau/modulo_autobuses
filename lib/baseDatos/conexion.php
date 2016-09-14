<?php


//se trabaja con la version 5.6 de php

$conexion = mysqli_connect("localhost", "root", "esasistemas", "autobuses");
if (mysqli_connect_errno()) {
    printf("Conexión fallida: %s\n", mysqli_connect_error());
    exit();
}else{
	//echo "Conexion realizada";
}
mysqli_query($conexion,"SET NAMES 'utf8'");


?>
