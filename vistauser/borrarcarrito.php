<?php
session_start();
//vaciamos dándole a la sesión carrito un array de valor 0
if (isset($_SESSION["carrito"])) {
    $_SESSION["carrito"] = array();
}

header("Location: /TiendaVinos/vistauser/Indexvistauser.php");
exit();
?>