<?php
$servername = "127.0.0.1:3307";
$username = "root";
$password = "";
$db_name = "tiendavinos";
$conexion = new mysqli($servername, $username, $password, $db_name, 3307);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}


$conexion->set_charset("utf8");
?>
