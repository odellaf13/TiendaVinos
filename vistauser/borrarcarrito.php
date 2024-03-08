<?php
session_start();
include "../Conexion.php";

if (isset($_SESSION["carrito"])) {
    //traerid del usuario actual
    $username = $_SESSION['username'];
    $consultaUsuario = mysqli_query($conexion, "SELECT usuario_id FROM usuario WHERE username = '$username'");
    $filaUsuario = mysqli_fetch_assoc($consultaUsuario);

    if ($filaUsuario) {
        $usuario_id = $filaUsuario['usuario_id'];
        //recuperar la sesión del carrito
        foreach ($_SESSION["carrito"] as $producto) {
            $producto_id = $producto["producto_id"];
            $cantidad = $producto["stock"];
            //hacemos update del stock actual en la BBDD
            $queryStock = "UPDATE producto SET stock = stock + $cantidad WHERE producto_id = $producto_id";
            mysqli_query($conexion, $queryStock);
        }
        //Se eliminan las líneas de pedido y el pedido del usuario
        $consultaPedido = mysqli_query($conexion, "SELECT pedido_id FROM pedido WHERE fk_usuario = $usuario_id ORDER BY pedido_id DESC LIMIT 1");
        $filaPedido = mysqli_fetch_assoc($consultaPedido);
//a cada fila
        if ($filaPedido) {
            $pedido_id = $filaPedido['pedido_id'];
            $queryEliminarLineas = "DELETE FROM linea_pedido WHERE fk_pedido = $pedido_id";
            mysqli_query($conexion, $queryEliminarLineas);

            $queryEliminarPedido = "DELETE FROM pedido WHERE pedido_id = $pedido_id";
            mysqli_query($conexion, $queryEliminarPedido);

            //vaciamos el carrito con el array en blanco()
            $_SESSION["carrito"] = array();

            echo '<script>
                alert("Carrito vaciado correctamente");
                window.location.href = "/TiendaVinos/vistauser/Indexvistauser.php";
            </script>';
            exit();
        } else {
            //errores por si no podemos encontrar el pedido del id
            echo '<script>
                alert("Error: No se encontró el pedido asociado al usuario");
                window.location.href = "/TiendaVinos/vistauser/Indexvistauser.php";
            </script>';
            exit();
        }
    } else {
        //por si no encontramos el id directamente
        echo '<script>
            alert("Error al obtener el usuario_id.");
            window.location.href = "/TiendaVinos/vistauser/Indexvistauser.php";
        </script>';
        exit();
    }
} else {
    //o si no hay carrito
    echo '<script>
        alert("Error: No hay productos en el carrito.");
        window.location.href = "/TiendaVinos/vistauser/Indexvistauser.php";
    </script>';
    exit();
}
?>