<?php
session_start();
include "../Conexion.php";

if (isset($_GET['pedido_id'])) {
    $pedido_id = $_GET['pedido_id'];

    // Obtener información del pedido antes de borrarlo
    $infoPedido = mysqli_query($conexion, "SELECT * FROM pedido WHERE pedido_id = '$pedido_id'");
    $pedido = mysqli_fetch_assoc($infoPedido);

    $borrarLineaPedido = mysqli_query($conexion, "DELETE FROM linea_pedido WHERE fk_pedido = '$pedido_id'");
    if (!$borrarLineaPedido) {
        // Manejar el error en la eliminación de las entradas de linea_pedido
        echo 'Error al borrar las entradas de linea_pedido.';
        exit();
    }
    // Borrar el pedido
    $borrarPedido = mysqli_query($conexion, "DELETE FROM pedido WHERE pedido_id = '$pedido_id'");

    if ($borrarPedido) {
        // Devolver stock original del producto en linea_pedido
        $infoLineaPedido = mysqli_query($conexion, "SELECT * FROM linea_pedido WHERE fk_pedido = '$pedido_id'");
        while ($linea = mysqli_fetch_assoc($infoLineaPedido)) {
            $fk_producto = $linea['fk_producto'];
            $cantidad = $linea['cantidad'];

            // Actualizar el stock del producto
            $actualizarStock = mysqli_query($conexion, "UPDATE producto SET stock = stock + '$cantidad' WHERE producto_id = '$fk_producto'");
            
            if (!$actualizarStock) {
                // Manejar el error en la actualización del stock
                echo 'Error al actualizar el stock del producto.';
                exit();
            }
        }

        // Redirigir o mostrar un mensaje de éxito
        header("Location: /TiendaVinos/vistauser/Indexvistauser.php");
        exit();
    } else {
        // Manejar el error en la eliminación del pedido
        echo 'Error al borrar el pedido.';
    }
} else {
    // Manejar el caso en el que no se proporciona un pedido_id
    echo 'No se proporcionó un ID de pedido.';
}
?>