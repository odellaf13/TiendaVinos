<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mostrar Datos de Envío</title>
    <link rel="stylesheet" type="text/css" href="estilovistaadmin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>

<?php
include "../Conexion.php";
session_start();

if (isset($_SESSION["username"])) {
    $user = $_SESSION["username"];
    // Clases de bootstrap para centrar el botón de contenido y proporcionar un botón para cerrar la sesión
    echo '<div class="text-center d-flex flex-column align-items-center" style="margin-top: 20px;">
    <h3 class="text-secondary mb-3"><i class="bi bi-person-check" style="color: #3498db !important;"></i>
        Bienvenido/a, ' . $user . ', a la tienda de vinos selectos
    </h3>';

    // Botón de cierre de sesión
    echo '<a href="/TiendaVinos/phplogin/cerrarsesion.php" class="btn btn-danger">Cerrar Sesión</a></br></br>
    </div>';

    // Verificar si se ha enviado el formulario
    if (isset($_POST["verDatosEnvio"])) {
        // Consultar la base de datos para obtener los pedidos completados/para enviar
        $sql_pedidos = "SELECT pedido_id FROM pedido WHERE estado = 'completado/para enviar'";
        $resultado_pedidos = $conexion->query($sql_pedidos);

        if ($resultado_pedidos && $resultado_pedidos->num_rows > 0) { // Verificar si se encontraron pedidos
            // Mostrar el formulario para seleccionar un pedido
            echo '<div class="container">
                <h3 class="text-center">Selecciona el pedido para ver los datos de envío</h3>

                <form method="POST" action="mostrardatosenvio1.php">';
            
            // Crear una lista desplegable de pedidos
            echo '<div class="mb-3">
                    <label for="pedido" class="form-label">Selecciona el pedido:</label>
                    <select class="form-select" name="pedido" required>';

            while ($pedido = $resultado_pedidos->fetch_assoc()) { // Iterar sobre los resultados
                echo '<option value="' . $pedido['pedido_id'] . '">' . $pedido['pedido_id'] . '</option>';
            }

            echo '</select>
                  </div>
                  <button type="submit" class="btn btn-primary" name="verDatosEnvio">Ver Datos de Envío</button>
                  </form>
                  </div>';
        } else {
            // Si no hay pedidos completados/para enviar, mostrar un mensaje
            echo '<p class="text-center">No hay pedidos completados/para enviar.</p>';
        }
    } else {
        // Si no se ha enviado el formulario, mostrar un mensaje para iniciar la selección
        echo '<p class="text-center">Por favor, selecciona un pedido para ver los datos de envío.</p>';
    }
} else {
    // Si el usuario no está autenticado, mostrar un mensaje de error
    echo 'Fallo. Usuario no autentificado.';
}
?>

</body>
</html>
