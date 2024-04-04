<?php
session_start();
include "../Conexion.php";

if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["correo"])) {
    //Recibimos datos del POST
    $nombre = $_POST["username"];
    $pass = $_POST["password"];
    $correo = $_POST["correo"];

    //Se ejecuta la consulta para actualizar el estado del usuario a inactivo
    $stmt = $conexion->prepare("UPDATE usuario SET estado = 0 WHERE username = ? AND password = ? AND correo = ?");
    $stmt->bind_param("sss", $nombre, $pass, $correo);
    $stmt->execute();

    //Verificamos las filas afectadas y redirigimos a menuvistauser.php
    if ($stmt->affected_rows > 0) {
        //si se actualizó el estado del usuario correctamente, redirigir a menuvistauser.php sin loggeo
        header("Location: /TiendaVinos/menuvistauser.php");
        exit();
    } else {
        //Si no se pudo actualizar el estado, mostrar el mensaje en perfilusuario.php
        header("Location: perfilusuario.php?error=delete");
        exit();
    }
    $stmt->close();
} else {
    //Si faltan datos, mostrar el mensaje por datos
    header("Location: perfilusuario.php?error=datos");
    exit();
}
?>
