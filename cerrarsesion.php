<?php

// Inicia la sesión
session_start();

// Destruye todas las variables de sesión
session_destroy();

// Redirige al usuario a la página de inicio de sesión
header("Location: /TiendaVinos/phplogin/indexlogin.php");
exit();

?>