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
    <script>//voy a crear una función para validar si la cantidad es un número, y no un caracter o un símbolo
        function validarCantidad() {
            var cantidadInput = document.getElementById("nuevacantidad").value;
            if (isNaN(cantidadInput) || cantidadInput <= 0) {
                //Si la cantidad no es un número, o es menor/igual a cero, mostrar
                document.getElementById("errorCantidad").innerText = "La cantidad ingresada no es válida.";
                return false; //y se impide enviar el formulario
            }
            return true; //si no, se envía a actualizarcantidad.php
        }
    </script>
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

        $consultaPedidos = mysqli_query($conexion, "SELECT * FROM pedido WHERE fk_usuario = '$usuario_id'");

        //Verificaremos si hay pedidos, y si no, te manda al else donde te dirá que no existen pedidos.
        if (mysqli_num_rows($consultaPedidos) > 0) {
            echo '<div class="center mt-5">
                    <div class="card pt-3">
                        <p style="font-weight: bold; color: #0F6BB7; font-size: 22px;">Pedidos</p>
                        <div class="container-fluid p-2" style="background-color: ghostwhite;">';

            while ($pedido = mysqli_fetch_assoc($consultaPedidos)) {
                $pedido_id = $pedido['pedido_id'];
                $total = $pedido['total'];
                $fecha = $pedido['fecha'];

                $consultaLineaPedido = mysqli_query($conexion, "SELECT p.producto_id, p.nombre, lp.cantidad
                    FROM linea_pedido lp
                    JOIN producto p ON lp.fk_producto = p.producto_id
                    WHERE lp.fk_pedido = '$pedido_id'");
 //hacemos una consulta de linea_pedido
                if ($consultaLineaPedido) {
                    echo '<div class="mb-3">
                            <h5>Pedido ID: ' . $pedido_id . '</h5>
                            <p>Total: ' . $total . ' €</p>
                            <p>Fecha: ' . $fecha . '</p>';
                        //hacemos una consulta de linea_pedido
                    while ($linea = mysqli_fetch_assoc($consultaLineaPedido)) {
                        $nombre = $linea['nombre'];
                        $cantidad = $linea['cantidad'];
                        $producto_id = $linea['producto_id']; //llamamos también al id del producto
                        echo '<form action="actualizarcantidad.php" method="POST" onsubmit="return validarCantidad()">
                                <input type="hidden" name="pedido_id" value="' . $pedido_id . '">
                                <input type="hidden" name="producto_id" value="' . $producto_id . '">
                                <input type="hidden" name="cantidad_actual" value="' . $cantidad . '">
                                <p>Producto: ' . $nombre . ', Cantidad: <input type="text" name="nuevacantidad" id="nuevacantidad" value="' . $cantidad . '" style="width:50px;" class="align-middle text-center" size="1" maxlength="4"/> 
                                <button type="submit" class="btn btn-primary"><i class="bi bi-arrow-clockwise"></i></button></p>
                                <div id="errorCantidad" style="color: red;"></div>
                              </form>';
                            //creo tambien un form para poder eliminar el producto del pedido, o todos los productos del pedido
                        echo '<form action="eliminar_productopedido.php" method="POST">
                                <input type="hidden" name="pedido_id" value="' . $pedido_id . '">
                                <input type="hidden" name="producto_id" value="' . $producto_id . '">
                                <button type="submit" class="btn btn-danger">Eliminar</button></br></br>
                              </form>';
                    }
                    echo '<a href="borrarpedido.php?pedido_id=' . $pedido_id . '" class="btn btn-danger">Borrar Pedido</a>
                        <a href="pagar.php?pedido_id=' . $pedido_id . '" class="btn btn-success">Ir a Pagar</a>
                        </div>';
                } else {
                    echo 'Error en la consulta';
                }
            }

            echo '</div></div></div>';
        } else {
            echo '<div class="center mt-5">
                    <div class="card pt-3">
                        <p style="font-weight: bold; color: #0F6BB7; font-size: 22px;">Pedidos</p>
                        <div class="container-fluid p-2" style="background-color: ghostwhite;">
                            <p>No hay pedidos.</p>
                        </div>
                    </div>
                </div>';
        }
    } else {
        echo 'Error en la consulta de usuario';
    }
} else {
    echo 'Fallo.Usuario no autenticado.';
}
?>
<a href="/TiendaVinos/vistauser/Indexvistauser.php" class="btn btn-primary">Volver a inicio</a>
</body>
</html>

