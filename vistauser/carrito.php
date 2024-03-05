<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');

var_dump($_POST);


// Creamos el carrito si no existe o está vacío
if (!isset($_SESSION["carrito"]) || empty($_SESSION["carrito"])) {
    $_SESSION["carrito"] = array();
}

//empezamos el carrito
if (isset($_SESSION["carrito"]) || isset($_POST["producto_id"])) {
    if (isset($_SESSION["carrito"])) {
        $carrito = $_SESSION["carrito"]; // Cambio de $carritomio a $carrito para mantener consistencia
        if (isset($_POST["producto_id"])) {
            $producto_id = $_POST["producto_id"];
            $nombre = $_POST["nombre"];
            $pvp = $_POST["pvp"];
            $stock = $_POST["stock"];
            $do = $_POST["do"];
            $descripcion = $_POST["descripcion"];
            $url_imagen = $_POST["url_imagen"];
            $donde = -1; //índice que no de error

            if ($donde != -1) {
                $cuanto = $carrito[$donde]["stock"] + $stock;
                $carrito[$donde] = array("producto_id" => $producto_id, "nombre" => $nombre,
                    "pvp" => $pvp, "stock" => $stock, "do" => $do, "descripcion" => $descripcion, "url_imagen" => $url_imagen);
            } else {
                $carrito[] = array("producto_id" => $producto_id, "nombre" => $nombre,
                    "pvp" => $pvp, "stock" => $stock, "do" => $do, "descripcion" => $descripcion, "url_imagen" => $url_imagen);
            }
        }
    } else { //provocas que si carrito está vacío, te llene también los datos
        $carrito[] = array("producto_id" => $producto_id, "nombre" => $nombre,
            "pvp" => $pvp, "stock" => $stock, "do" => $do, "descripcion" => $descripcion, "url_imagen" => $url_imagen);
    }
    $_SESSION["carrito"] = $carrito; //estuviese o no vacío, le inyectamos los datos
    var_dump($_SESSION["carrito"]);
}

var_dump("Before redirection");

header("Location: /TiendaVinos/vistauser/Indexvistauser.php");
var_dump($_POST);  // Imprime los datos del formulario
ob_end_flush();
exit();
?>







