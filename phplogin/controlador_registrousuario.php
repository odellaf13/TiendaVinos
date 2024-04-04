<?php

if (!empty($_POST["registro"])) {
    if (empty($_POST["nombre"]) || empty($_POST["pass"]) || empty($_POST["correo"])) {
        echo '<script>
        window.location.href = "registro_usuario.php";
        alert("Alguno(s) de los campos está sin completar")
        </script>';
    } else {
        $nombre = $_POST["nombre"];
        $pass = $_POST["pass"];
        $rol = "user";
        $correo = $_POST["correo"];
        $estadoactivo = 1; //lo insertamos como estado activo al usuario

        //Si existiese uno inactivo con el mismo username o correo, se le pasa a activo
            $stmtverificar = $conexion->prepare("SELECT usuario_id FROM usuario WHERE username = ? OR correo = ?");
        $stmtverificar->bind_param("ss", $nombre, $correo);
        $stmtverificar->execute();
        $stmtverificar->store_result();

        if ($stmtverificar->num_rows > 0) {
            //actualización del estado si ya existe
            $stmt_actualizar = $conexion->prepare("UPDATE usuario SET estado = ? WHERE username = ? OR correo = ?");
            $stmt_actualizar->bind_param("iss", $estadoactivo, $nombre, $correo);
            $stmt_actualizar->execute();

            echo '<div class="success">La cuenta ha sido reactivada correctamente.</div>';
        } else {
            //y si no existe, se le crea una cuenta nueva/registra todo nuevo.
            $stmt_insertar = $conexion->prepare("INSERT INTO usuario (username, password, rol, correo, estado) VALUES (?, ?, ?, ?, ?)");
            $stmt_insertar->bind_param("ssssi", $nombre, $pass, $rol, $correo, $estadoactivo);
            $stmt_insertar->execute();

            if ($stmt_insertar->affected_rows > 0) {
                echo '<div class="success">Usuario registrado correctamente</div>';
            } else {
                echo '<script>
                alert("Error al registrar el usuario")
                </script>';
            }
            $stmt_insertar->close();
        }
        $stmtverificar->close();
    }
}

?>
