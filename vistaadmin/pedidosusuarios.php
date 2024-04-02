<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Index.php</title>
    <link rel="stylesheet" type="text/css" href="estilovistaadmin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>/*Voy a hacer un style para cuando cree la barra de estadística, poder ver las cantidades de los productos elegidos por losclientes*/
    .progress {
        position: relative;
        height: 25px;
    }
    .numberbarra {
        font-size: 14px; /*voy a colocar el número en la partecentral de la barra */
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }
    </style>
</head>

<body id="body">
<?php
include "../Conexion.php";
session_start();
if(isset($_SESSION["username"])) {
    $user = $_SESSION["username"];
    //clases de bootstrap para centrar el botón de contenido y proporcionar un boton para cerrar la sesión
    echo '<div class="text-center d-flex flex-column align-items-center" style="margin-top: 20px;">
    <h3 class="text-secondary mb-3"><i class="bi bi-person-check" style="color: #3498db !important;"></i>
        Bienvenido/a, ' . $user . ', a la tienda de vinos selectos
    </h3>';

    //botón de cierre sesión
    echo '<a href="/TiendaVinos/phplogin/cerrarsesion.php" class="btn btn-danger">Cerrar Sesión</a></br></br>
    </div>';
}

//Consultamos a la bbdd con join los pedidos que contengan el estado "completado/para enviar"
$sql_pedidos = "SELECT pedido.pedido_id, usuario.usuario_id, usuario.username, producto.nombre, pedido.total, linea_pedido.cantidad, producto.do, pedido.estado
                FROM pedido
                INNER JOIN linea_pedido ON pedido.pedido_id = linea_pedido.fk_pedido
                INNER JOIN producto ON linea_pedido.fk_producto = producto.producto_id
                INNER JOIN usuario ON pedido.fk_usuario = usuario.usuario_id
                WHERE pedido.estado = 'completado/para enviar'";

$resultado_pedidos = $conexion->query($sql_pedidos);

//iniciamos un array "en blanco" para que se asocie a los pedidos de la base de datos
$pedidos = [];

//buscamos en la bbdd los pedidos, y con un while, mientras que existan datos, se agregaran los resultados al array en blanco/$pedidos
if ($resultado_pedidos && $resultado_pedidos->num_rows > 0) {
    while ($pedido = $resultado_pedidos->fetch_assoc()) {
        $pedidos[] = $pedido;
    }
}

//Mostramos la tabla del pedido
if (!empty($pedidos)) {
    echo '<h3 class="text-center text-secondary">Pedidos de los usuarios</h3>';
    echo '<table class="table table-striped">';
    echo '<thead>
            <tr>
                <th>ID del Pedido</th>
                <th>ID del usuario</th>
                <th>Username</th>
                <th>Nombre del Producto</th>
                <th>Total</th>
                <th>Cantidad</th>
                <th>D.O</th>
                <th>Estado</th>
            </tr>
          </thead>';
    echo '<tbody>';

    //Si hubiera más de un pedido, mostramos los existentes con un foreach/para cada pedido
    foreach ($pedidos as $pedido) {
        echo '<tr>';
        echo '<td>' . $pedido['pedido_id'] . '</td>';
        echo '<td>' . $pedido['usuario_id'] . '</td>';
        echo '<td>' . $pedido['username'] . '</td>';
        echo '<td>' . $pedido['nombre'] . '</td>';
        echo '<td>' . $pedido['total'] . '</td>';
        echo '<td>' . $pedido['cantidad'] . '</td>';
        echo '<td>' . $pedido['do'] . '</td>';
        echo '<td>' . $pedido['estado'] . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '<form method="POST" action="mostrardatosenvio.php" class="text-center mt-3">';
    echo '<button class="btn btn-primary text-center mt-3" type="submit" name="verDatosEnvio">Ver datos de envío</button>';
    echo '</form>';

    //comenzamos el código del gráfico de barras con un div
    echo '<div class="container">';
    echo '<h3 class="text-center mt-4">Estadística de Pedidos de los usuarios</h3>';
    echo '<div class="row">';
    foreach ($pedidos as $pedido)//igual que antes, con un foreach, insertamos cada pedido de la bbdd en las barras estadísticas
     {
        echo '<div class="col-md-4">';
        echo '<div class="card mb-4">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $pedido["nombre"] . '</h5>';
        echo '<div class="progress" style="min-width: 150px;">';
        echo '<div class="progress-bar bg-primary" role="progressbar" style="width: ' . $pedido["cantidad"] . '%" aria-valuenow="' . $pedido["cantidad"] . '" aria-valuemin="0" aria-valuemax="100"></div>';
        echo '<span class="numberbarra">' . $pedido["cantidad"] . '</span>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
    //fin de la barra

} else {
    echo '<p class="text-center">No hay pedidos completados/para enviar.</p>';
}

?>
<div class="text-center mt-3">
<a href="/TiendaVinos/vistaadmin/Index.php" class="btn btn-primary">Inicio</a>
</div>
</body>
</html>
