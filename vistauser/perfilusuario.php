<?php
session_start();
// Verificamos si el usuario está identificado para utilizar su sesión
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
include "../Conexion.php";
// Almacenamos el nombre de usuario en la variable de sesión
$username = $_SESSION["username"];
// Consultamos el usuario en la base de datos para obtener su id
$query = "SELECT usuario_id FROM usuario WHERE username = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$resultados = $stmt->get_result();

// Verificamos si, tras la consulta, se obtuvieron resultados
if ($resultados->num_rows > 0) {
    // Cogemos el usuario
    $usuario = $resultados->fetch_assoc();
    $id_usuario = $usuario["usuario_id"];

    // Consultamos sus datos
    $query_datos = "SELECT * FROM usuario WHERE usuario_id = ?";
    $stmt_datos = $conexion->prepare($query_datos);
    $stmt_datos->bind_param("i", $id_usuario);
    $stmt_datos->execute();
    $resultadodatos = $stmt_datos->get_result();

    // Igual que antes, verificamos tras la consulta si se obtuvieron filas de datos
    if ($resultadodatos->num_rows > 0) {
        // Asignamos los datos del usuario a la variable $usuario
        $usuario = $resultadodatos->fetch_assoc();
    } else {
        echo '<div class="alert alert-danger" role="alert">No se encontraron datos del usuario.</div>';
        exit();
    }
    $stmt_datos->close();
} else {
    echo '<div class="alert alert-danger" role="alert">No se encuentra el usuario en la base de datos.</div>';
    exit();
}
$stmt->close();

// Esto es una verificación para saber si hubo errores en borrarusuario1.php, con el alert de lo que ocurre.
if (isset($_GET["error"])) {
    $error = $_GET["error"];
    if ($error === "delete") {

        echo '<div class="alert alert-danger" role="alert">Hubo un error al eliminar el usuario. Por favor, inténtalo de nuevo.</div>';
    } elseif ($error === "datos") {
        echo '<div class="alert alert-danger" role="alert">Falta de datos para eliminar el usuario. Por favor, inténtalo de nuevo.</div>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vista del usuario</title>
    <link rel="stylesheet" type="text/css" href="estilovistauser.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<nav class="navbar navbar-expand-lg" style="background-color: #e3f2fd;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="../9d9d02d012924b04b7f1b2a98dc18f83.png" alt="logo" width="200px">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="quienessomos.php">Quiénes somos</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Productos
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/TiendaVinos/vistauser/Indexvistauser.php">Nuestros vinos</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="/TiendaVinos/vistauser/ofertas.php">Ofertas <i class="bi bi-percent"></i>
                            </a>
                        </li>
                    </ul>
                    <li class="nav-item">
                        <a class="nav-link" href="/TiendaVinos/vistauser/indexcarrito.php">Mi carrito</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/TiendaVinos/vistauser/indexpedidos.php">Pedidos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="contactanos.php">
                            <i class="bi bi-headset"></i>&nbsp; Contáctanos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/TiendaVinos/vistauser/perfilusuario.php">Perfil de usuario</a>
                    </li>
            </ul>
            <form class="d-flex" role="search" action="buscador.php">
                <button class="btn btn-outline-success" type="submit" action="buscador.php">Search</button>
            </form>
        </div>
    </div>
</nav>
<body>

<div class="container mt-4">
    <h2>Perfil de usuario</h2>
    <form action="actualizarusuario.php" method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Nombre de usuario:</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $usuario["username"]; ?>">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña:</label>
            <input type="password" class="form-control" id="password" name="password" value="<?php echo $usuario["password"]; ?>">
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Email:</label>
            <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $usuario["correo"]; ?>">
        </div>
        <button type="submit" class="btn btn-primary" name="actualizar">Actualizar perfil</button>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmarBorrado">Eliminar cuenta</button>

        <a href="/TiendaVinos/vistauser/Indexvistauser.php" class="btn btn-primary">Volver a Productos</a>
    </form>
</div>

<!-- Formulario oculto para enviar datos a borrarusuario1.php -->
<form id="formborrarUsuario" action="borrarusuario1.php" method="POST">
    <input type="hidden" name="username" value="<?php echo $usuario["username"]; ?>">
    <input type="hidden" name="password" value="<?php echo $usuario["password"]; ?>">
    <input type="hidden" name="correo" value="<?php echo $usuario["correo"]; ?>">
</form>

<!-- Modal de confirmación para eliminar usuario -->
<div class="modal fade" id="confirmarBorrado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar tu cuenta?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <!-- Al hacer clic en este botón, se envían los datos al formulario oculto y luego se envía el formulario -->
                <button type="submit" class="btn btn-danger" form="formborrarUsuario">Eliminar cuenta</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>
