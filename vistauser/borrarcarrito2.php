<?php
session_start();
include "../Conexion.php";

if (isset($_GET['pedido_id'])) {
    $pedido_id = $_GET['pedido_id'];

    //recogemos la información del pedido antes de borrarlo
    $infoLineaPedido = mysqli_query($conexion, "SELECT * FROM linea_pedido WHERE fk_pedido = '$pedido_id'");
//almacenanamos el total de stock a restaurar
    $totalStockRestaurar = 0;
//hacemos un while para actualizar la infor de linea_pedido
    while ($linea = mysqli_fetch_assoc($infoLineaPedido)) {
        $fk_producto = $linea['fk_producto'];
        $cantidad = $linea['cantidad'];
        //Actualizamos el stock del producto
        $actualizarStock = mysqli_query($conexion, "UPDATE producto SET stock = stock + '$cantidad' WHERE producto_id = '$fk_producto'");
        if (!$actualizarStock) {
            //lanzamos un error si no se ha actualizado
            echo 'Error al actualizar el stock del producto.';
            exit();
        }
        //Sumamos la cantidad al total para restaurar el stock si el cliente no quiere el pedido
        $totalStockRestaurar += $cantidad;
    }
    //Borramos los datos de linea_pedido
    $borrarLineaPedido = mysqli_query($conexion, "DELETE FROM linea_pedido WHERE fk_pedido = '$pedido_id'");
    if (!$borrarLineaPedido) {
        //lanza error
        echo 'Error al borrar las entradas de linea_pedido.';
        exit();
    }
    //Borramos el pedido
    $borrarPedido = mysqli_query($conexion, "DELETE FROM pedido WHERE pedido_id = '$pedido_id'");

    if ($borrarPedido) {
        //actualizamos el carrito a 0 con un array en "blanco"
        $_SESSION["carrito"] = array();
        header("Location: /TiendaVinos/vistauser/Indexvistauser.php");
        exit();
    } else {
        echo 'Error al borrar el pedido.';
    }
} else {
    echo 'No se proporcionó un ID de pedido.';
}
?>
