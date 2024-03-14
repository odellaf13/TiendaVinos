<?php
session_start();
include "../Conexion.php";

if (isset($_SESSION["username"])) {
    $username = $_SESSION['username'];
    $consultaUsuario = mysqli_query($conexion, "SELECT usuario_id FROM usuario WHERE username = '$username'");
    $filaUsuario = mysqli_fetch_assoc($consultaUsuario);

    if ($filaUsuario) {
        $usuario_id = $filaUsuario['usuario_id'];

        //igual que modalcarrito. Obtenemos el id del pedido actual de la sesión del usuario en la BBDD
        $consultaPedido = mysqli_query($conexion, "SELECT pedido_id FROM pedido WHERE fk_usuario = $usuario_id ORDER BY pedido_id DESC LIMIT 1");
        $filaPedido = mysqli_fetch_assoc($consultaPedido);

        if ($filaPedido) {
            $pedido_id = $filaPedido["pedido_id"];

            //vemos los productos del pedido del usuario
            $consultaProductos = mysqli_query($conexion, "SELECT p.producto_id, lp.cantidad FROM producto p JOIN linea_pedido lp ON p.producto_id = lp.fk_producto WHERE lp.fk_pedido = $pedido_id");

            while ($producto = mysqli_fetch_assoc($consultaProductos)) {
                $producto_id = $producto["producto_id"];
                $cantidad = $producto["cantidad"];

                //actualizamos el stock
                $queryStock = "UPDATE producto SET stock = stock + $cantidad WHERE producto_id = $producto_id";
                mysqli_query($conexion, $queryStock);
            }
        //Eliminamos las líneas de pedido y el pedido
        $queryEliminarLineas = "DELETE FROM linea_pedido WHERE fk_pedido = $pedido_id";
            mysqli_query($conexion, $queryEliminarLineas);

            $queryEliminarPedido = "DELETE FROM pedido WHERE pedido_id = $pedido_id";
            mysqli_query($conexion, $queryEliminarPedido);

            echo '<script>
                alert("Carrito vaciado correctamente");
                window.location.href = "/TiendaVinos/vistauser/Indexvistauser.php";
            </script>';
            exit();
        } else {
            echo '<script>
                alert("Error: No se encontró el pedido del usuario");
                window.location.href = "/TiendaVinos/vistauser/Indexvistauser.php";
            </script>';
            exit();
        }
    } else {
        echo '<script>
            alert("Error al obtener el id del usuario");
            window.location.href = "/TiendaVinos/vistauser/Indexvistauser.php";
        </script>';
        exit();
    }
} else {
    echo '<script>
        alert("Error: Sesión no iniciada");
        window.location.href = "/TiendaVinos/vistauser/Indexvistauser.php";
    </script>';
    exit();
}
?>
