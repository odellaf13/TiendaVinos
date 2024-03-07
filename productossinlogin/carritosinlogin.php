<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');

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

    // Buscamos si el producto ya está en el carrito
    $donde = -1;
    foreach ($_SESSION["carrito"] as $key => $producto) {
        if ($producto["producto_id"] == $producto_id) {
            $donde = $key;
            break;
        }
    }

    if ($donde != -1) {
        // Si ya existe, actualizamos la cantidad
        $carrito[$donde]["stock"] += $stock;
    } else {
        // Si no existe, lo agregamos al carrito
        $carrito[] = array(
            "producto_id" => $producto_id,
            "nombre" => $nombre,
            "pvp" => $pvp,
            "stock" => $stock,
            "do" => $do,
            "descripcion" => $descripcion,
            "url_imagen" => $url_imagen
        );
    }

    $_SESSION["carrito"] = $carrito;
}

header("Location: /TiendaVinos/productossinlogin/productossinlogin.php");
exit();
?>







