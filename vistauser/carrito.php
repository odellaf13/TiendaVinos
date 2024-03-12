<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
include "../Conexion.php";

// Creamos el carrito si no existe o está vacío
if (!isset($_SESSION["carrito"]) || empty($_SESSION["carrito"])) {
    $_SESSION["carrito"] = array();
}

// Empezamos el carrito
if (isset($_POST["producto_id"])) {
    $producto_id = $_POST["producto_id"];
    $nombre = $_POST["nombre"];
    $pvp = $_POST["pvp"];
    $stock = $_POST["stock"];
    $do = $_POST["do"];
    $descripcion = $_POST["descripcion"];
    $url_imagen = $_POST["url_imagen"];
    $cantidad = $_POST["cantidad"];

    // Verificamos si el producto ya está en el carrito
    $encontrado = false;
    foreach ($_SESSION["carrito"] as $producto) {
        if ($producto["producto_id"] == $producto_id) {
            $producto["stock"] += $cantidad;
            $encontrado = true;
            break;
        }
    }

    // Si no está en el carrito, lo añadimos
    if (!$encontrado) {
        $_SESSION["carrito"][] = array(
            "producto_id" => $producto_id,
            "nombre" => $nombre,
            "pvp" => $pvp,
            "stock" => $cantidad,
            "do" => $do,
            "descripcion" => $descripcion,
            "url_imagen" => $url_imagen
        );
    }

    // Restar la cantidad al stock en la base de datos
    $query = "UPDATE producto SET stock = stock - $cantidad WHERE producto_id = $producto_id";
    mysqli_query($conexion, $query);

    // Imprimir el valor de $stock para verificar
    echo "Stock a restar: $stock";

    // Insertar el pedido en la base de datos
    $username = $_SESSION['username'];

    // Consulta SQL para obtener el usuario_id basado en el nombre de usuario
    $consultaUsuario = mysqli_query($conexion, "SELECT usuario_id FROM usuario WHERE username = '$username'");
    $filaUsuario = mysqli_fetch_assoc($consultaUsuario);

    // Verificar si se encontró el usuario y obtener el usuario_id
    if ($filaUsuario) {
        $usuario_id = $filaUsuario['usuario_id'];
        $fecha = date('Y-m-d H:i:s');

        // Calcular el total sumando los productos en el carrito
        $total = 0;
        foreach ($_SESSION["carrito"] as $producto) {
            $total += $producto["pvp"] * $producto["cantidad"];
        }

        // Insertar el pedido en la tabla 'pedido'
        $query = "INSERT INTO pedido (fecha, total, fk_usuario) VALUES ('$fecha', $total, $usuario_id)";
        mysqli_query($conexion, $query);

        // Obtener el id del pedido recién insertado
        $pedido_id = mysqli_insert_id($conexion);

        // Insertar las líneas de pedido en la tabla 'linea_pedido'
        foreach ($_SESSION["carrito"] as $producto) {
            $producto_id = $producto["producto_id"];
            $cantidad = $producto["stock"];

            // Verificar si ya existe una línea de pedido para este producto
            $consultaExistencia = mysqli_query($conexion, "SELECT * FROM linea_pedido WHERE fk_pedido = $pedido_id AND fk_producto = $producto_id");
            $filaExistencia = mysqli_fetch_assoc($consultaExistencia);

            if ($filaExistencia) {
                // Si existe, actualiza la cantidad
                $cantidad += $filaExistencia["cantidad"];
                $query = "UPDATE linea_pedido SET cantidad = $cantidad WHERE fk_pedido = $pedido_id AND fk_producto = $producto_id";
            } else {
                // Si no existe, inserta una nueva línea de pedido
                $query = "INSERT INTO linea_pedido (fk_pedido, fk_producto, cantidad) VALUES ($pedido_id, $producto_id, $cantidad)";
            }

            mysqli_query($conexion, $query);
        }

        // Recalcular el total utilizando la información de la tabla 'linea_pedido'
        $total = 0;
        $consultaLineasPedido = mysqli_query($conexion, "SELECT * FROM linea_pedido WHERE fk_pedido = $pedido_id");
        while ($lineaPedido = mysqli_fetch_assoc($consultaLineasPedido)) {
            $producto_id = $lineaPedido["fk_producto"];
            $cantidad = $lineaPedido["cantidad"];
            $consultaProducto = mysqli_query($conexion, "SELECT pvp FROM producto WHERE producto_id = $producto_id");
            $producto = mysqli_fetch_assoc($consultaProducto);
            $total += $producto["pvp"] * $cantidad;
        }

        // Actualizar el total en la tabla 'pedido'
        mysqli_query($conexion, "UPDATE pedido SET total = $total WHERE pedido_id = $pedido_id");

        // Restablecer el carrito después de completar la compra

        // Redireccionar a la página del carrito
        header("Location: /TiendaVinos/vistauser/Indexvistauser.php");
        exit();
    } else {
        // Manejar el caso en el que no se pudo obtener el usuario_id
        echo "Error al obtener el usuario_id.";
    }
} else {
    // Manejar el caso en el que no se envió información del producto
    echo "Error: No se ha proporcionado información del producto.";
}

echo "Contenido de la variable de sesión después de actualizar: ";
print_r($_SESSION["carrito"]);
?>
