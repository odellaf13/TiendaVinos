<?php
//conexión a la bbdd
$conexion = new mysqli("127.0.0.1:3307", "root", "", "tiendavinos");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8");

?>