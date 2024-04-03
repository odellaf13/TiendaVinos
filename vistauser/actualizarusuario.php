<?php
//se verifica si se envía correctamente el form actualizar
if (isset($_POST["actualizar"])) {
    include "../Conexion.php";
    //recogemos datos del formulario
    $username = $_POST["username"];
    $password = $_POST["password"];
    $correo = $_POST["correo"];
    session_start();
    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
        exit();
    }
    //Obtenemos el nombre del user de la sesión
    $username_session = $_SESSION["username"];
    //consulta para reclamar la id del usuario de la sesión
    $query = "SELECT usuario_id FROM usuario WHERE username = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $username_session);
    $stmt->execute();
    $resultado = $stmt->get_result();
//verificar resultads
    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        $id_usuario = $usuario["usuario_id"];

    //Ésta funcionalidad verifica si el username ha sido modificado
        if ($username != $username_session) {
            //hacemos una consulta para ver si el nuevo username está elegido o siendo usado
            $query_username = "SELECT usuario_id FROM usuario WHERE username = ?";
            $stmt_username = $conexion->prepare($query_username);
            $stmt_username->bind_param("s", $username);
            $stmt_username->execute();
            $resultado_username = $stmt_username->get_result();

            if ($resultado_username->num_rows > 0) {
                echo '<div class="alert alert-danger" role="alert">El nuevo nombre de usuario ya está en uso.</div>';
                exit();
            }
        }

        //Actualizamos los datos del usuario en la BBDD
        $queryupdate = "UPDATE usuario SET username = ?, password = ?, correo = ? WHERE usuario_id = ?";
        $stmt_actualizar = $conexion->prepare($queryupdate);
        $stmt_actualizar->bind_param("sssi", $username, $password, $correo, $id_usuario);
        $stmt_actualizar->execute();

    //Se verifica si tuvo éxito
        if ($stmt_actualizar->affected_rows > 0) {
            //Si username ha sido modificado, SE TIENE QUE ACTUALIZAR LA SESIÓN. OJO QUE PUEDE DAR PROBLEMAS SI NO SE HACE ESTO!!
            if ($username != $username_session) {
                $_SESSION["username"] = $username;
            }
            header("Location: perfilusuario.php");
            exit();
        } else {
            echo '<div class="alert alert-danger" role="alert">Error al actualizar los datos del usuario.</div>';
        }

        $stmt_actualizar->close();
    } else {
        echo '<div class="alert alert-danger" role="alert">Error: No se encontró el usuario en la base de datos.</div>';
    }
    $stmt->close();
} else {
    //si no se envía el formulario, redirigiremos a Indexvistauser.php mismo, para que se sepa que no se recibe por POST el form
    header("Location: Indexvistauser.php");
    exit();
}
?>
