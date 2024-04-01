
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
        // Consultar la base de datos para obtener los datos de envío
        $sql_datosenvio = "SELECT * FROM datosenvio";
        $resultado_datosenvio = $conexion->query($sql_datosenvio);

        if ($resultado_datosenvio && $resultado_datosenvio->num_rows > 0) {
            $datosenvio = $resultado_datosenvio->fetch_assoc();
            echo '<div class="container">
                    <h3 class="text-center">Datos de Envío del cliente</h3>
                    <form method="POST" action="enviarcorreo.php">
                    <div class="mb-3">
                    <label for="Usuario ID" class="form-label">Usuario ID</label>
                    <input type="text" class="form-control" id="fk_usuario" name="fk_usuario" value="' . $datosenvio['fk_usuario'] . '" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="' . $datosenvio['nombre'] . '" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" value="' . $datosenvio['apellidos'] . '" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección de envío</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" value="' . $datosenvio['direccion'] . '" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" value="' . $datosenvio['telefono'] . '" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo</label>
                            <input type="text" class="form-control" id="correo" name="correo" value="' . $datosenvio['correo'] . '" readonly>
                        </div>
                        <button type="submit" class="btn btn-primary" name="enviarCorreo">Enviar Correo</button>
                        <a href="pedidosusuarios.php" class="btn btn-secondary">Volver a Pedidos</a>


                    </form>
                  </div>';
        } else {
            echo '<p class="text-center">No hay datos de envío disponibles.</p>';
        }
    }
} else {
    echo 'Fallo. Usuario no autentificado.';
}
?>

</body>
</html>
