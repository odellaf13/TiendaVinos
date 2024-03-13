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
<body>
<?php
    session_start();
    include "../Conexion.php";
?>
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
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="indexpedidos.php">Pedidos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="contactanos.php">Contáctanos</a>
        </li>
      </ul>
      <form class="d-flex" role="search" action="buscador.php">
        <button class="btn btn-outline-success" type="submit" action="buscador.php">Search</button>
      </form>
    </div>
  </div>
</nav>

<?php
 if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    //consulta para saber el nombre del usuario y obtener el id
    $queryUsuario = mysqli_query($conexion, "SELECT usuario_id FROM usuario WHERE username = '$username'");

    if ($queryUsuario) {
        $usuario = mysqli_fetch_assoc($queryUsuario);
        $usuario_id = $usuario['usuario_id'];
        //si la consulta se hace, te saluda
        echo '<div class="text-center d-flex flex-column align-items-center" style="margin-top: 20px;">
            <h3 class="text-secondary mb-3"><i class="bi bi-person-check" style="color: #3498db !important;"></i>
                Bienvenido/a, ' . $username . ', a la tienda de vinos selectos
            </h3>';

        echo '<a href="cerrarsesion.php" class="btn btn-danger">Cerrar Sesión</a></br>
            </div>';




        
    } else {
        echo 'Error en la consulta de usuario';
    }
} else {
    echo 'Fallo.Usuario no autenticado.';
}
?>
<a href="/TiendaVinos/vistauser/indexpedidos.php" class="btn btn-primary">Volver a Pedidos</a>
</body>
</html>