<?php
include "Conexion.php";

// Este if verifica si se proporciona un ID y una cantidad a añadir
if (isset($_GET['id']) && isset($_GET['cantidad'])) {
    $producto_id = $_GET['id'];
    $cantidad = $_GET['cantidad'];

    // Obtener información del producto
    $consulta_producto = $conexion->query("SELECT nombre, stock FROM producto WHERE producto_id = $producto_id");
    $datos_producto = $consulta_producto->fetch_assoc();

    if ($datos_producto) {
        $nombre_producto = $datos_producto['nombre'];
        $stock_actual = $datos_producto['stock'];

        // Verificar si hay suficiente stock
        if ($stock_actual >= $cantidad) {
            // Calcula el nuevo stock después de añadir la cantidad
            $nuevo_stock = $stock_actual - $cantidad;

            // Actualiza el stock en la base de datos
            $actualizar_stock = $conexion->query("UPDATE producto SET stock = $nuevo_stock WHERE producto_id = $producto_id");

            if ($actualizar_stock) {
                // Añade el producto al carrito del usuario
                session_start();
                $_SESSION['carrito'][] = array(
                    'id' => $producto_id,
                    'nombre' => $nombre_producto,
                    'cantidad' => $cantidad
                );

                $_SESSION['mensaje'] = "Producto '$nombre_producto' añadido al carrito correctamente.";
            } else {
                $_SESSION['mensaje'] = "Error al actualizar el stock en la base de datos.";
            }
        } else {
            $_SESSION['mensaje'] = "No hay suficiente stock disponible para el producto '$nombre_producto'.";
        }
    } else {
        $_SESSION['mensaje'] = "Producto no encontrado.";
    }
} else {
    $_SESSION['mensaje'] = "ID del producto o cantidad no proporcionados.";
}

header("Location: Indexvistauser.php");
exit();
?>

