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
          <a class="nav-link active" aria-current="page" href="contactanos.php">
            <i class="bi bi-headset"></i>&nbsp; Contáctanos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/TiendaVinos/vistauser/perfilusuario.php">Perfil de usuario</a>
        </li>
      </ul>
      <form class="d-flex" role="search" action="buscador.php">
        <button class="btn btn-outline-success" type="submit" action="buscador.php">Buscador</button>
      </form>
    </div>
  </div>
</nav>

<?php
if(isset($_SESSION["username"])) {
  $username = $_SESSION["username"];
  //consulta para saber el nombre del usuario y obtener el id
  $consultaUsuario = mysqli_query($conexion, "SELECT usuario_id FROM usuario WHERE username = '$username'");

  if ($consultaUsuario) {
      $usuario = mysqli_fetch_assoc($consultaUsuario);
      $usuario_id = $usuario["usuario_id"];
      //si la consulta se hace, te saluda
      echo '<div class="text-center d-flex flex-column align-items-center" style="margin-top: 20px;">
          <h3 class="text-secondary mb-3"><i class="bi bi-person-check" style="color: #3498db !important;"></i>
              Bienvenido/a, ' . $username . ', a la tienda de vinos selectos
          </h3>';

          echo '<a href="/TiendaVinos/phplogin/cerrarsesion.php" class="btn btn-danger">Cerrar Sesión</a></br></br>
          </div>';
    //Consulta de pedidos completados/para enviar en la bbdd
    $consultaPedidos = mysqli_query($conexion, "SELECT * FROM pedido WHERE fk_usuario = '$usuario_id' AND estado = 'completado/para enviar'");
      //se localizan datos de Pedidos y Linea_pedido, y se insertan en un form
    if ($consultaPedidos && mysqli_num_rows($consultaPedidos) > 0) {
        echo '<div class="center mt-5">';
        while ($pedido = mysqli_fetch_assoc($consultaPedidos)) {
            $pedido_id = $pedido["pedido_id"];
            $total = $pedido["total"];
            $fecha = $pedido["fecha"];

            $consultaLineaPedido = mysqli_query($conexion, "SELECT p.producto_id, p.nombre, p.pvp, lp.cantidad
                    FROM linea_pedido lp
                JOIN producto p ON lp.fk_producto = p.producto_id
                WHERE lp.fk_pedido = '$pedido_id'");

            if ($consultaLineaPedido) {
                echo '<div class="card mb-3" style="max-width: 600px; margin: 0 auto; border: 2px solid #ccc; box-shadow: 2px 2px 20px 2px rgba(0,0,0,0.2);">
                        <div style="background-color: ghostwhite; padding: 10px;">
                            <p style="font-weight: bold; color: #0F6BB7; font-size: 22px;">
                                <i class="bi bi-card-list" style="font-size: 2em; margin-right: 10px;"></i>Mis pedidos completados</p>
                            <div class="container-fluid p-2" style="background-color: ghostwhite;">';
                            echo '<p>Fecha: ' . $fecha . '</p>';
                            while ($linea = mysqli_fetch_assoc($consultaLineaPedido)) {
                                $nombre = $linea["nombre"];
                                $cantidad = $linea["cantidad"];
                                $pvp = $linea["pvp"];
                                $producto_id = $linea['producto_id'];
                                echo '<p>Producto: <span style="font-weight: bold;">' . $nombre . '</span> (Precio por cada botella: ' . $pvp . ' €)</p>
                                      <p>Cantidad: ' . $cantidad . '</p>';
                                echo '<hr style="border-top: solid #007bff;">';
                            }
                            echo '<div style="margin-top: 10px;">
                                    <p style="font-weight: bold;">Total de todos los productos: ' . $total . ' € <i class="bi bi-receipt" style="font-size: 4em;"></i></p>
                                </div>';
                echo '</div></div></div>';
            } else {
                echo 'Error en la consulta';
            }
        }
        echo '</div>';
    } else {
      echo '<div class="center mt-5">';
      echo '<div class="card pt-3" style="max-width: 600px; margin: 0 auto; border: 2px solid #ccc; box-shadow: 2px 2px 20px 2px rgba(0,0,0,0.2);">
              <div style="background-color: ghostwhite; padding: 10px;">
                  <p style="font-weight: bold; color: #0F6BB7; font-size: 22px;">
                      <i class="bi bi-card-list" style="font-size: 2em; margin-right: 10px;"></i>Mis pedidos completados</p>
                  <div class="container-fluid p-2" style="background-color: ghostwhite;">';
                  echo '<p>No hay pedidos completados/para enviar.</p>';
      echo '</div></div></div>';
      echo '</div>';
    }
    echo '</div></div></div>';

} else {
    echo 'Fallo. Usuario no autentificado.';
}
}
?>
<div class="text-center mt-3">
<a href="/TiendaVinos/vistauser/Indexvistauser.php" class="btn btn-primary">Volver a Productos</a>
</body>
</html>