<?php
//controlador para inactivar al usuario en perfilusuario
session_start();
include "../Conexion.php";

if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["correo"])) {
    //Recibimos datos del POST
    $nombre = $_POST["username"];
    $pass = $_POST["password"];
    $correo = $_POST["correo"];

    //verificar si el usuario tiene un pedido en trámite o completado/para enviar
    $stmt_pedidos = $conexion->prepare("SELECT * FROM pedido WHERE fk_usuario = ? AND (estado = 'en trámite' OR estado = 'completado/para enviar')");
    $stmt_pedidos->bind_param("i", $_SESSION["usuario_id"]);
    $stmt_pedidos->execute();
    $resultados_pedidos = $stmt_pedidos->get_result();

    if ($resultados_pedidos->num_rows > 0) {
        //recorremos todos los pedidos para ver el estado
        while ($row_pedido = $resultados_pedidos->fetch_assoc()) {
            $pedido_id = $row_pedido["pedido_id"];
            $estado_pedido = $row_pedido["estado"];

            //Si está en trámite, eliminamos el pedido y devolvemos el stock original al producto, para no perder stockaje si alguien elimina su cuenta
        if ($estado_pedido === "en trámite") {
                //detalles detalles del pedido. Devolvemos stock al producto
                $stmt_detalles = $conexion->prepare("SELECT fk_producto, cantidad FROM linea_pedido WHERE fk_pedido = ?");
                $stmt_detalles->bind_param("i", $pedido_id);
                $stmt_detalles->execute();
                $result_detalles = $stmt_detalles->get_result();

                while ($detalle = $result_detalles->fetch_assoc()) {
                    $producto_id = $detalle["fk_producto"];
                    $cantidad = $detalle["cantidad"];
                    //se hace un update con el stock
                    $stmt_stock = $conexion->prepare("UPDATE producto SET stock = stock + ? WHERE producto_id = ?");
                    $stmt_stock->bind_param("ii", $cantidad, $producto_id);
                    $stmt_stock->execute();
                    $stmt_stock->close();//se ejecuta y se cierra
                }
                //Eliminamos linea_pedido también, aparte del pedido.
                $stmt_eliminar_detalles = $conexion->prepare("DELETE FROM linea_pedido WHERE fk_pedido = ?");
                $stmt_eliminar_detalles->bind_param("i", $pedido_id);
                $stmt_eliminar_detalles->execute();
                $stmt_eliminar_detalles->close();
            }

            //se ejecuta el delete
            if ($estado_pedido === "en trámite") {
                $stmt_eliminar_pedido = $conexion->prepare("DELETE FROM pedido WHERE pedido_id = ?");
                $stmt_eliminar_pedido->bind_param("i", $pedido_id);
                $stmt_eliminar_pedido->execute();
                $stmt_eliminar_pedido->close();
            }
        }
    }
    //actualización del usuario al estado inactivo, pero para él, eliminado
    $stmt_inactivo = $conexion->prepare("UPDATE usuario SET estado = 0 WHERE username = ? AND password = ? AND correo = ?");
    $stmt_inactivo->bind_param("sss", $nombre, $pass, $correo);
    $stmt_inactivo->execute();

    //verificar las filas afectadas y redirigir
    if ($stmt_inactivo->affected_rows > 0) {

          //quiero que el usuario vea un mnsaje de éxito
        $_SESSION["mensaje"] = "Perfil de usuario eliminado correctamente.";
        $stmt_inactivo->close();
        echo "<script>

                alert('Perfil de usuario eliminado correctamente.');
                window.location.href = '/TiendaVinos/menuvistauser.php';
              </script>";
         exit();
    } else {
        //Mostrar mensaje de error si no se pudo actualizar el estado
        $stmt_inactivo->close();
        header("Location: perfilusuario.php?error=delete");
        exit();
    }
} else {
        //mostrar mensaje de error si faltan datos
    header("Location: perfilusuario.php?error=datos");
    exit();
}
?>
