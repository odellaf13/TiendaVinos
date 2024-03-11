<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');

include "../Conexion.php";

//Creamos el carrito si no existe o si está vacío
if (!isset($_SESSION["carrito"]) || empty($_SESSION["carrito"])) {
    $_SESSION["carrito"] = array();
}
//Comenzamos el carrito y nos aseguramos que recibimos todos los datos del formulario
if (isset($_POST["producto_id"], $_POST["nombre"], $_POST["pvp"], $_POST["stock"], $_POST["do"], $_POST["descripcion"], $_POST["url_imagen"], $_POST["cantidad"])) {
    $producto_id = $_POST["producto_id"];
    $nombre = $_POST["nombre"];
    $pvp = $_POST["pvp"];
    $stock = $_POST["stock"];
    $do = $_POST["do"];
    $descripcion = $_POST["descripcion"];
    $url_imagen = $_POST["url_imagen"];
    $cantidad = $_POST["cantidad"];

    //nos aseguramos que cada producto está en el carrito
    $encontrado = false;
    foreach ($_SESSION["carrito"] as &$producto) {
        if ($producto["producto_id"] == $producto_id) {
            $nuevoStock = $producto["stock"] + $cantidad;
            //vemos si hay stock suficiente
            if ($nuevoStock <= 0) {
                //No hay suficiente stock disponible
                echo "No hay stock disponible del producto seleccionado.";
                exit();
            }
            $producto["stock"] = $nuevoStock;
            $encontrado = true;
            break;
        }
    }
    //Si no esta el stock en el carrito, lo añadimos
    if (!$encontrado) {
        if ($cantidad > 0 && $cantidad <= $stock) {
            $_SESSION["carrito"][] = array(
                "producto_id" => $producto_id,
                "nombre" => $nombre,
                "pvp" => $pvp,
                "stock" => $cantidad,
                "do" => $do,
                "descripcion" => $descripcion,
                "url_imagen" => $url_imagen
            );
        } else {
            // No hay suficiente stock disponible, mostrar mensaje y salir
            echo "No hay stock disponible del producto seleccionado.";
            exit();
        }
    }
    //Restamos la cantidad seleccionada por cliente al stock en la base de datos
    $query = "UPDATE producto SET stock = stock - $cantidad WHERE producto_id = $producto_id";
    mysqli_query($conexion, $query);
    //Se inserta el pedido en la base de datos
    $username = $_SESSION['username'];
    //pedimos el id de usuario con una consulta
    $consultaUsuario = mysqli_query($conexion, "SELECT usuario_id FROM usuario WHERE username = '$username'");
    $filaUsuario = mysqli_fetch_assoc($consultaUsuario);

    //verificamos si hemos obtenido el id
    if ($filaUsuario) {
        $usuario_id = $filaUsuario['usuario_id'];
        $fecha = date('Y-m-d H:i:s');
        //Calculamos  el total de los productos del carrito
        $total = 0;
        foreach ($_SESSION["carrito"] as $producto) {
            $total += $producto["pvp"] * $producto["cantidad"];
        }
        //Inserta el pedido en la tabla pedido de la BBDD
        $query = "INSERT INTO pedido (fecha, total, fk_usuario) VALUES ('$fecha', $total, $usuario_id)";
        mysqli_query($conexion, $query);

        //Llamamos a pedido_id para hacer linea_pedido
        $pedido_id = mysqli_insert_id($conexion);

        //insertamos pedido en linea_pedido
        foreach ($_SESSION["carrito"] as $producto) {
            $producto_id = $producto["producto_id"];
            $cantidad = $producto["stock"];

            //consulta para ver si existe linea_pedido
            $consultaExistencia = mysqli_query($conexion, "SELECT * FROM linea_pedido WHERE fk_pedido = $pedido_id AND fk_producto = $producto_id");
            $filaExistencia = mysqli_fetch_assoc($consultaExistencia);

            if ($filaExistencia) {
                //Si existe, se actualiza la cantidad a la catual
                $cantidad += $filaExistencia["cantidad"];
                $query = "UPDATE linea_pedido SET cantidad = $cantidad WHERE fk_pedido = $pedido_id AND fk_producto = $producto_id";
            } else {
                //Y si no existe, insertamos una nueva línea de pedido
                $query = "INSERT INTO linea_pedido (fk_pedido, fk_producto, cantidad) VALUES ($pedido_id, $producto_id, $cantidad)";
            }
            mysqli_query($conexion, $query);
        }

//Recalculamos el total con la información de la tabla linea_pedido
        $total = 0;
        $consultaLineasPedido = mysqli_query($conexion, "SELECT * FROM linea_pedido WHERE fk_pedido = $pedido_id");
        while ($lineaPedido = mysqli_fetch_assoc($consultaLineasPedido)) {
            $producto_id = $lineaPedido["fk_producto"];
            $cantidad = $lineaPedido["cantidad"];
            $consultaProducto = mysqli_query($conexion, "SELECT pvp FROM producto WHERE producto_id = $producto_id");
            $producto = mysqli_fetch_assoc($consultaProducto);
            $total += $producto["pvp"] * $cantidad;
        }
        //Actualizamos el total en pedido
        mysqli_query($conexion, "UPDATE pedido SET total = $total WHERE pedido_id = $pedido_id");

        header("Location: /TiendaVinos/vistauser/Indexvistauser.php");
        exit();
    } else {
    //Caso en el que no se pudo obtener el usuario_id
        echo "Error al obtener el usuario_id.";
    }
} else {
    //Si no se envió información del producto
    echo "Error: No se ha proporcionado información del producto.";
}
echo "Contenido de la variable de sesión después de actualizar: ";
print_r($_SESSION["carrito"]);
?>

