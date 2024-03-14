<?php
// Inicia la sesión
session_start();

// Destruye solo la sesión actual sin eliminar los datos del pedido y los detalles del pedido
// Eliminamos solo las variables de sesión relacionadas con la autenticación
unset($_SESSION["username"]);
unset($_SESSION["usuario_id"]);
unset($_SESSION["rol"]);

// Redirige al usuario a la página de inicio de sesión
header("Location: /TiendaVinos/phplogin/indexlogin.php");
exit();
?>
