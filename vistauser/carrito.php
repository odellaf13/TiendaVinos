<?php
session_start();
include "../Conexion.php";

// Verificar si se recibió información del producto
if (isset($_POST["producto_id"])) {
    // Obtener la información del producto
    $producto_id = $_POST["producto_id"];
    $nombre = $_POST["nombre"];
    $pvp = $_POST["pvp"];
    $stock = $_POST["stock"];
    $do = $_POST["do"];
    $descripcion = $_POST["descripcion"];
    $url_imagen = $_POST["url_imagen"];
    $cantidad = $_POST["cantidad"];

    // Obtener el id del usuario actual
    $username = $_SESSION['username'];
    $consultaUsuario = mysqli_query($conexion, "SELECT usuario_id FROM usuario WHERE username = '$username'");
    $filaUsuario = mysqli_fetch_assoc($consultaUsuario);

    if ($filaUsuario) {
        $usuario_id = $filaUsuario['usuario_id'];

        // Verificar si ya existe un pedido pendiente para ese usuario
        $consultaPedido = mysqli_query($conexion, "SELECT pedido_id FROM pedido WHERE fk_usuario = $usuario_id");
        $filaPedido = mysqli_fetch_assoc($consultaPedido);

        if ($filaPedido) {
            // Si existe, obtener el id del pedido
            $pedido_id = $filaPedido['pedido_id'];
        } else {
            // Si no existe, crear un nuevo pedido
            $fecha = date('Y-m-d H:i:s');
            $query = "INSERT INTO pedido (fecha, total, fk_usuario) VALUES ('$fecha', 0, $usuario_id)";
            mysqli_query($conexion, $query);
            $pedido_id = mysqli_insert_id($conexion);
        }

        // Verificar si ya existe una línea de pedido para este producto en el pedido actual
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

        // Restar la cantidad al stock en la base de datos
        $query = "UPDATE producto SET stock = stock - $cantidad WHERE producto_id = $producto_id";
        mysqli_query($conexion, $query);

        // Actualizar el total en la tabla 'pedido'
        $query = "UPDATE pedido SET total = (SELECT SUM(p.pvp * lp.cantidad) FROM producto p JOIN linea_pedido lp ON p.producto_id = lp.fk_producto WHERE lp.fk_pedido = $pedido_id) WHERE pedido_id = $pedido_id";
        mysqli_query($conexion, $query);

        // Redireccionar a la página del carrito
        header("Location: /TiendaVinos/vistauser/Indexvistauser.php?exito=1");
        exit();
    } else {
        // Manejar el caso en el que no se pudo obtener el usuario_id
        echo "Error al obtener el usuario_id.";
    }
} else {
    // Manejar el caso en el que no se envió información del producto
    echo "Error: No se ha proporcionado información del producto.";
}
?>
