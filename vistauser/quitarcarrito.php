<?php
session_start();
include "Conexion.php";

// Este if verifica si se proporciona un ID a eliminar del carrito
if (isset($_GET['id'])) {
    $producto_id = $_GET['id'];

    // Busca el producto en el carrito
    $index = -1;

    if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $key => $producto) {
            if ($producto['id'] == $producto_id) {
                $index = $key;
                break;
            }
        }
    }

    if ($index !== -1) {
        // Recupera la cantidad del producto en el carrito
        $cantidad = $_SESSION['carrito'][$index]['cantidad'];

        // Actualiza el stock en la base de datos
        $consulta_stock = $conexion->query("SELECT stock FROM producto WHERE producto_id = $producto_id");
        $datos_stock = $consulta_stock->fetch_assoc();

        if ($datos_stock) {
            $stock_actual = $datos_stock['stock'];
            $nuevo_stock = $stock_actual + $cantidad;

            $actualizar_stock = $conexion->query("UPDATE producto SET stock = $nuevo_stock WHERE producto_id = $producto_id");

            if ($actualizar_stock) {
                // Elimina el producto del carrito
                unset($_SESSION['carrito'][$index]);
                $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexa el array

                echo "Producto eliminado del carrito correctamente. Stock actualizado en la base de datos.";
            } else {
                echo "Error al actualizar el stock en la base de datos.";
            }
        } else {
            echo "Error al obtener el stock del producto.";
        }
    } else {
        echo "Producto no encontrado en el carrito.";
    }
} else {
    echo "ID del producto no proporcionado.";
}

// Redirige de vuelta a Indexvistauser.php
header("Location: Indexvistauser.php");
exit();
?>
