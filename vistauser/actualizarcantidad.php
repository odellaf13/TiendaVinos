<?php
session_start();
include "../Conexion.php";

//Recogemos la información del formulario de indexpedidos.php
if (isset($_POST["pedido_id"]) && isset($_POST["producto_id"]) && isset($_POST["cantidad_actual"]) && isset($_POST["nuevacantidad"])) {
    $pedido_id = $_POST["pedido_id"];
    $producto_id = $_POST["producto_id"];
    $cantidad_actual = $_POST["cantidad_actual"];
    $nuevacantidad = $_POST["nuevacantidad"];
    //Verificar si la nueva cantidad es número
    if (is_numeric($nuevacantidad) && $nuevacantidad > 0) {
        //Calculamos la diferencia entre cantidades
        $diferencia_cantidad = $nuevacantidad - $cantidad_actual;

        //Se actualiza cantidad en linea_pedido
        $query_actualizarcantidad = "UPDATE linea_pedido SET cantidad = $nuevacantidad WHERE fk_pedido = $pedido_id AND fk_producto = $producto_id";
        mysqli_query($conexion, $query_actualizarcantidad);

        //y el stock del producto (si es más, se resta al stock, y si es menos, se suma al stock original)
        $query_actualizarstock = "UPDATE producto SET stock = stock - $diferencia_cantidad WHERE producto_id = $producto_id";
        mysqli_query($conexion, $query_actualizarstock);

    //Se vuelve a calcular el total del pedido con las nuevas cantidaes
        $query_total = "SELECT SUM(p.pvp * lp.cantidad) AS total FROM producto p JOIN linea_pedido lp ON p.producto_id = lp.fk_producto WHERE lp.fk_pedido = $pedido_id";
        $resultado_total = mysqli_query($conexion, $query_total);
        $fila_total = mysqli_fetch_assoc($resultado_total);
        $nuevototal = $fila_total["total"];

        //Se actualiza el nuevo total del pedido en la BBDD
        $query_actualizar_total = "UPDATE pedido SET total = $nuevototal WHERE pedido_id = $pedido_id";
        mysqli_query($conexion, $query_actualizar_total);

        header("Location: /TiendaVinos/vistauser/indexcarrito.php");
        exit();
    } else {
        echo "Error: La cantidad ingresada no es correcta";
    }
} else {
    echo "Error: No se recibió la información del formulario.";
}
?>


