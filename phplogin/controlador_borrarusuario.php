<?php
if (!empty($_POST["borrar"])) { //Verificamos que no se haya enviado el formulario vacío
    if (empty($_POST["nombre"]) || empty($_POST["pass"]) || empty($_POST["correo"])) {
        echo '<script>
        window.location.href = "borrarusuario.php";
        alert("Alguno(s) de los campos está sin completar")
        </script>';
    } else {
        $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : null;
        $pass = isset($_POST["pass"]) ? $_POST["pass"] : null;
        $correo = isset($_POST["correo"]) ? $_POST["correo"] : null;
        
        //ejecutamos la consulta para actualizar el estado del usuario a inactivo
        $stmt = $conexion->prepare("UPDATE usuario SET estado = 0 WHERE username = ? AND password = ? AND correo = ?");
        $stmt->bind_param("sss", $nombre, $pass, $correo);
        $stmt->execute();

        //Verificamos si se afectaron filas y redirigimos según el resultado
        if ($stmt->affected_rows > 0) {
            echo '<script>
            window.location.href = "/TiendaVinos/menuvistauser.php";
            alert("El usuario se eliminó correctamente");
            </script>';
        } else {
            echo '<script>
            window.location.href = "indexlogin.php";
            alert("El usuario no ha podido ser eliminado");
            </script>';
        }
        $stmt->close();
    }
}
?>
