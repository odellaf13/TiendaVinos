<?php
session_start();
include "../Conexion.php";

// Verifica si el usuario ha iniciado sesión
if(isset($_SESSION["username"])) {
    //Obtenemos la información del producto
    if (isset($_POST["producto_id"])) {
        //Obtenemos la información del producto
        $producto_id = $_POST["producto_id"];
        $nombre = $_POST["nombre"];
        $pvp = $_POST["pvp"];
        $stock = $_POST["stock"];
        $do = $_POST["do"];
        $descripcion = $_POST["descripcion"];
        $url_imagen = $_POST["url_imagen"];
        $cantidad = $_POST["cantidad"];

        //Guardamos el id del usuario actual en la variable de sesión
        $username = $_SESSION["username"];
        $consultaUsuario = mysqli_query($conexion, "SELECT usuario_id FROM usuario WHERE username = '$username'");
        $filaUsuario = mysqli_fetch_assoc($consultaUsuario);

        if ($filaUsuario) {
            $usuario_id = $filaUsuario["usuario_id"];

            //Vemos si existe algún pedido en cola para el usuario
            $consultaPedido = mysqli_query($conexion, "SELECT pedido_id, estado FROM pedido WHERE fk_usuario = $usuario_id");
            $filaPedido = mysqli_fetch_assoc($consultaPedido);

            if ($filaPedido && $filaPedido["estado"] != 'completado/para enviar') {
                //Si existe un pedido pero no está completo, utilizar el pedido existente
                $pedido_id = $filaPedido["pedido_id"];
            } else {
                // Si no existe un pedido o el pedido existente está completo, crear un nuevo pedido
                $fecha = date('Y-m-d H:i:s');
                $query = "INSERT INTO pedido (fecha, total, fk_usuario) VALUES ('$fecha', 0, $usuario_id)";
                mysqli_query($conexion, $query);
                $pedido_id = mysqli_insert_id($conexion);
            }

            // Limpiar el carrito y el pedido (opcional)
            // unset($_SESSION["carrito"]);
            // unset($_SESSION["pedido"]);

            // Actualizar la variable de sesión username (opcional)
            $_SESSION["username"] = $_SESSION["username"];

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

            //Actualizamos el total en la tabla pedidos
            $query = "UPDATE pedido SET total = (SELECT SUM(p.pvp * lp.cantidad) FROM producto p JOIN linea_pedido lp ON p.producto_id = lp.fk_producto WHERE lp.fk_pedido = $pedido_id) WHERE pedido_id = $pedido_id";
            mysqli_query($conexion, $query);

            // Agregar producto al carrito (opcional)
            // $_SESSION["carrito"][] = array(
            //     "producto_id" => $producto_id,
            //     "nombre" => $nombre,
            //     "pvp" => $pvp,
            //     "stock" => $stock,
            //     "do" => $do,
            //     "descripcion" => $descripcion,
            //     "url_imagen" => $url_imagen,
            //     "cantidad" => $cantidad,
            // );
            // Redirigir a la página del carrito con mensaje de éxito
            header("Location: /TiendaVinos/vistauser/Indexvistauser.php?exito=1");
            exit();
        } else {
            echo "Error al obtener el id del usuario.";
        }
    } else {
        echo "Error: No se ha recibido la información del producto del formulario";
    }
} else {
    // Si el usuario no ha iniciado sesión, guarda la URL del carrito en la sesión para redireccionarlo después del inicio de sesión
    $_SESSION['redirect_url'] = '/TiendaVinos/vistauser/Indexvistauser.php';
    header("Location: /TiendaVinos/phplogin/indexlogin.php");
    exit();
}
?>
