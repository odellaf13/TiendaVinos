<?php
session_start();
include "../Conexion.php";

// Verificar si se recibió la información del pedido y del producto a eliminar
if (isset($_POST['pedido_id']) && isset($_POST['producto_id'])) {
    // Obtener los datos del formulario
    $pedido_id = $_POST['pedido_id'];
    $producto_id = $_POST['producto_id'];

    // Obtener la cantidad del producto a eliminar
    $query_cantidad = "SELECT cantidad FROM linea_pedido WHERE fk_pedido = $pedido_id AND fk_producto = $producto_id";
    $resultado_cantidad = mysqli_query($conexion, $query_cantidad);

    if ($resultado_cantidad && mysqli_num_rows($resultado_cantidad) > 0) {
        $fila_cantidad = mysqli_fetch_assoc($resultado_cantidad);
        $cantidad_eliminada = $fila_cantidad["cantidad"];

        // Eliminar el producto del pedido en la base de datos
        $query_eliminar = "DELETE FROM linea_pedido WHERE fk_pedido = $pedido_id AND fk_producto = $producto_id";
        mysqli_query($conexion, $query_eliminar);

        // Devolver la cantidad eliminada al stock del producto
        $query_stock = "UPDATE producto SET stock = stock + $cantidad_eliminada WHERE producto_id = $producto_id";
        mysqli_query($conexion, $query_stock);

        // Actualizar el total del pedido
        $query_total = "SELECT SUM(p.pvp * lp.cantidad) AS total FROM producto p JOIN linea_pedido lp ON p.producto_id = lp.fk_producto WHERE lp.fk_pedido = $pedido_id";
        $resultado_total = mysqli_query($conexion, $query_total);
        $fila_total = mysqli_fetch_assoc($resultado_total);
        $nuevo_total = $fila_total["total"];

        // Actualizar el total del pedido en la base de datos
        $query_actualizar_total = "UPDATE pedido SET total = $nuevo_total WHERE pedido_id = $pedido_id";
        mysqli_query($conexion, $query_actualizar_total);

        // Verificar si el pedido está vacío y eliminarlo si es necesario
        $query_verificar_vacio = "SELECT COUNT(*) AS count FROM linea_pedido WHERE fk_pedido = $pedido_id";
        $resultado_verificar_vacio = mysqli_query($conexion, $query_verificar_vacio);
        $fila_verificar_vacio = mysqli_fetch_assoc($resultado_verificar_vacio);
        $cantidad_productos_pedido = $fila_verificar_vacio["count"];

        if ($cantidad_productos_pedido == 0) {
            $query_eliminar_pedido = "DELETE FROM pedido WHERE pedido_id = $pedido_id";
            mysqli_query($conexion, $query_eliminar_pedido);
        }

        // Redirigir de nuevo a la página de pedidos
        header("Location: /TiendaVinos/vistauser/indexpedidos.php");
        exit();
    } else {
        echo "Error: No se pudo recuperar la cantidad eliminada del producto.";
    }
} else {
    echo "Error: No se recibió la información necesaria.";
}
?>


