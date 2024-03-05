<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

var_dump("Inside carrito.php");
var_dump($_POST);
?>


<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();

var_dump("Before checking carrito session");
var_dump($_SESSION["carrito"]);

// Creamos el carrito si no existe o está vacío
if (!isset($_SESSION["carrito"]) || empty($_SESSION["carrito"])) {
    $_SESSION["carrito"] = array();
}

var_dump("After checking carrito session");
var_dump($_SESSION["carrito"]);

// Empezamos el carrito
if (isset($_POST["producto_id"])) {
    var_dump("Inside the condition for producto_id");

    // Obtén los datos del producto
    $producto_id = $_POST["producto_id"];
    $nombre = $_POST["nombre"];
    $pvp = $_POST["pvp"];
    $stock = $_POST["stock"];
    $do = $_POST["do"];
    $descripcion = $_POST["descripcion"];
    $url_imagen = $_POST["url_imagen"];

    // Mensajes de depuración para verificar los datos del producto
    var_dump("Producto ID: " . $producto_id);
    var_dump("Nombre: " . $nombre);
    var_dump("PVP: " . $pvp);
    var_dump("Stock: " . $stock);
    var_dump("DO: " . $do);
    var_dump("Descripción: " . $descripcion);
    var_dump("URL Imagen: " . $url_imagen);

    // Agrega el producto al carrito
    $carrito_producto = array(
        "producto_id" => $producto_id,
        "nombre" => $nombre,
        "pvp" => $pvp,
        "stock" => $stock,
        "do" => $do,
        "descripcion" => $descripcion,
        "url_imagen" => $url_imagen,
        "cantidad" => 1  // Puedes ajustar esto según tus necesidades
    );

    // Agrega el producto al carrito
    $_SESSION["carrito"][] = $carrito_producto;

    var_dump("After updating carrito session");
    var_dump($_SESSION["carrito"]);
}

var_dump("Before redirection");

header("Location: /TiendaVinos/vistauser/Indexvistauser.php");
ob_end_flush();
exit();
?>






