<?php
// Verificar si se ha enviado el formulario de actualización
if (isset($_POST["actualizar"])) {
    // Incluir el archivo de conexión a la base de datos
    include "../Conexion.php";

    // Obtener los datos del formulario
    $username = $_POST["username"];
    $password = $_POST["password"];
    $correo = $_POST["correo"];

    // Verificar si se ha establecido la sesión del usuario
    session_start();
    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
        exit();
    }

    // Obtener el nombre de usuario de la sesión
    $username_session = $_SESSION["username"];

    // Consultar el usuario en la base de datos para obtener su ID
    $query = "SELECT usuario_id FROM usuario WHERE username = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $username_session);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Verificar si se obtuvieron resultados
    if ($resultado->num_rows > 0) {
        // Obtener el usuario
        $usuario = $resultado->fetch_assoc();
        $id_usuario = $usuario['usuario_id'];

        // Actualizar los datos del usuario en la base de datos
        $query_actualizar = "UPDATE usuario SET username = ?, password = ?, correo = ? WHERE usuario_id = ?";
        $stmt_actualizar = $conexion->prepare($query_actualizar);
        $stmt_actualizar->bind_param("sssi", $username, $password, $correo, $id_usuario);
        $stmt_actualizar->execute();

        // Verificar si la actualización fue exitosa
        if ($stmt_actualizar->affected_rows > 0) {
            // Redirigir de vuelta a perfilusuario.php
            header("Location: perfilusuario.php");
            exit();
        } else {
            echo '<div class="alert alert-danger" role="alert">Error al actualizar los datos del usuario.</div>';
        }

        // Cerrar la consulta preparada
        $stmt_actualizar->close();
    } else {
        echo '<div class="alert alert-danger" role="alert">Error: No se encontró el usuario en la base de datos.</div>';
    }

    // Cerrar la consulta preparada
    $stmt->close();
} else {
    // Si no se ha enviado el formulario, redirigir a algún lugar apropiado
    header("Location: alguna_pagina.php");
    exit();
}
?>
