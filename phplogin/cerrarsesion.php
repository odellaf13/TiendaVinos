<?php
session_start();

//con unset, se destruye solo la sesión actual sin eliminar los datos del pedido y los detalles del pedido
//es decir, solo le eliminan las variables de sesión usadas, sin eliminar el contenido.
unset($_SESSION["username"]);
unset($_SESSION["usuario_id"]);
unset($_SESSION["rol"]);

header("Location: /TiendaVinos/menuvistauser.php");
exit();
?>
