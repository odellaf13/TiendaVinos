<?php
session_start();
include "../Conexion.php";
//Verificamos si se recibió la información del pedido y del producto a eliminar
    if (isset($_POST['pedido_id']) && isset($_POST['producto_id'])) {
    //Recogemos los datos del formulario con post
    $pedido_id = $_POST['pedido_id'];
    $producto_id = $_POST['producto_id'];

    //consulta sobre la cantidad del producto a eliminar
    $query_cantidad = "SELECT cantidad FROM linea_pedido WHERE fk_pedido = $pedido_id AND fk_producto = $producto_id";
    $resultado_cantidad = mysqli_query($conexion, $query_cantidad);
//hacemos un if para que entre si la cantidad es mayor a 0
    if ($resultado_cantidad && mysqli_num_rows($resultado_cantidad) > 0) {
        $fila_cantidad = mysqli_fetch_assoc($resultado_cantidad);
        $cantidad_eliminada = $fila_cantidad["cantidad"];

        //query para eliminar el producto del pedido en la base de datos
        $query_eliminar = "DELETE FROM linea_pedido WHERE fk_pedido = $pedido_id AND fk_producto = $producto_id";
        mysqli_query($conexion, $query_eliminar);

//recogemos la antidad eliminada y se la sumamos al stock para que vuelva a su estado anterior si no quiere el pedido el cliente
        $query_stock = "UPDATE producto SET stock = stock + $cantidad_eliminada WHERE producto_id = $producto_id";
        mysqli_query($conexion, $query_stock);

        //Se actualiza el pedido con un join a linea_pedido, para recoger la tabla cantidad
        $query_actualizar_total = "UPDATE pedido SET total = (SELECT SUM(p.pvp * lp.cantidad) FROM producto p JOIN linea_pedido lp ON p.producto_id = lp.fk_producto WHERE lp.fk_pedido = $pedido_id) WHERE pedido_id = $pedido_id";
        mysqli_query($conexion, $query_actualizar_total);
    //verificamos si linea_pedido está vacía y eliminamos el pedido si existe
        $query_verificar_vacio = "SELECT COUNT(*) AS count FROM linea_pedido WHERE fk_pedido = $pedido_id";
        $resultado_verificar_vacio = mysqli_query($conexion, $query_verificar_vacio);
        $fila_verificar_vacio = mysqli_fetch_assoc($resultado_verificar_vacio);
        $cantidad_productos_pedido = $fila_verificar_vacio["count"];

        if ($cantidad_productos_pedido == 0) {
            //Si linea_pedido está vacía, eliminar también los datos en la tabla pedido
            $query_eliminar_pedido = "DELETE FROM pedido WHERE pedido_id = $pedido_id";
            mysqli_query($conexion, $query_eliminar_pedido);
        }
        header("Location: /TiendaVinos/vistauser/indexpedidos.php");
        exit();
    } else {
        echo "Error: No se pudo recuperar la cantidad eliminada del producto.";
    }
} else {
    echo "Error: No se recibió la información necesaria.";
}
?>