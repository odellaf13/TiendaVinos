<?php
session_start();
include "../Conexion.php";

//traemos el id del usuario a la sesión
$username = $_SESSION['username'];
$consultaUsuario = mysqli_query($conexion, "SELECT usuario_id FROM usuario WHERE username = '$username'");
$filaUsuario = mysqli_fetch_assoc($consultaUsuario);

if ($filaUsuario) {
    $usuario_id = $filaUsuario['usuario_id'];

    //buscamos el pedido asociado al id
    $consultaPedido = mysqli_query($conexion, "SELECT pedido_id FROM pedido WHERE fk_usuario = $usuario_id ORDER BY pedido_id DESC LIMIT 1");
    $filaPedido = mysqli_fetch_assoc($consultaPedido);

    if ($filaPedido) {
        $pedido_id = $filaPedido['pedido_id'];

        //queremos eliminar las lineas de pedido y pedido por filas cuando el usuario cierre sesión.
        $queryEliminarLineas = "DELETE FROM linea_pedido WHERE fk_pedido = $pedido_id";
        mysqli_query($conexion, $queryEliminarLineas);

        $queryEliminarPedido = "DELETE FROM pedido WHERE pedido_id = $pedido_id";
        mysqli_query($conexion, $queryEliminarPedido);
    }

    $_SESSION["carrito"] = array();
}

//Se destruye la sesión
session_destroy();

header("Location: /TiendaVinos/menuvistauser.php");
exit();
?>