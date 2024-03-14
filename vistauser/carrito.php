<?php
session_start();
include "../Conexion.php";

//Nos aseguramos que recibimos la información del producto por POST
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

    //Guardamos el id del usuario actual en la variable sessión
    $username = $_SESSION["username"];
    $consultaUsuario = mysqli_query($conexion, "SELECT usuario_id FROM usuario WHERE username = '$username'");
    $filaUsuario = mysqli_fetch_assoc($consultaUsuario);

    if ($filaUsuario) {
        $usuario_id = $filaUsuario['usuario_id'];

        //Vemos si existe algún pedido en cola para el user
        $consultaPedido = mysqli_query($conexion, "SELECT pedido_id FROM pedido WHERE fk_usuario = $usuario_id");
        $filaPedido = mysqli_fetch_assoc($consultaPedido);

        if ($filaPedido) {
            //Si existe, llamamos al id del pedido
            $pedido_id = $filaPedido['pedido_id'];
        } else {
            //Si no, se crea un nuevo pedido
            $fecha = date('Y-m-d H:i:s');
            $query = "INSERT INTO pedido (fecha, total, fk_usuario) VALUES ('$fecha', 0, $usuario_id)";
            mysqli_query($conexion, $query);
            $pedido_id = mysqli_insert_id($conexion);
        }

    //Igual. Nos aseguramos si ya existe una línea de pedido para este producto en el pedido actual
        $consultaExistencia = mysqli_query($conexion, "SELECT * FROM linea_pedido WHERE fk_pedido = $pedido_id AND fk_producto = $producto_id");
        $filaExistencia = mysqli_fetch_assoc($consultaExistencia);

        if ($filaExistencia) {
            //Si existiese, se actualiza la cantidad
            $cantidad += $filaExistencia["cantidad"];
            $query = "UPDATE linea_pedido SET cantidad = $cantidad WHERE fk_pedido = $pedido_id AND fk_producto = $producto_id";
        } else {
            //Si no existiese, iniciamos una nueva linea de pedido
            $query = "INSERT INTO linea_pedido (fk_pedido, fk_producto, cantidad) VALUES ($pedido_id, $producto_id, $cantidad)";
        }

        mysqli_query($conexion, $query);
        //Restamos la cantidad al stock original en la base de datos
        $query = "UPDATE producto SET stock = stock - $cantidad WHERE producto_id = $producto_id";
        mysqli_query($conexion, $query);

        //Actualizamo s el total en la tabla pedidos
        $query = "UPDATE pedido SET total = (SELECT SUM(p.pvp * lp.cantidad) FROM producto p JOIN linea_pedido lp ON p.producto_id = lp.fk_producto WHERE lp.fk_pedido = $pedido_id) WHERE pedido_id = $pedido_id";
        mysqli_query($conexion, $query);

        header("Location: /TiendaVinos/vistauser/Indexvistauser.php?exito=1");
        exit();
    } else {
        echo "Error al obtener el id del usuario.";
    }
} else {
    echo "Error: No se ha recibido la información del producto del formulario";
}
?>
