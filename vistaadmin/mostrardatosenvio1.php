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
    //Clases de bootstrap para centrar el botón de contenido y proporcionar un botón para cerrar la sesión
    echo '<div class="text-center d-flex flex-column align-items-center" style="margin-top: 20px;">
    <h3 class="text-secondary mb-3"><i class="bi bi-person-check" style="color: #3498db !important;"></i>
        Bienvenido/a, ' . $user . ', a la tienda de vinos selectos
    </h3>';

    echo '<a href="/TiendaVinos/phplogin/cerrarsesion.php" class="btn btn-danger">Cerrar Sesión</a></br></br>
    </div>';

    //Verificamos si se ha enviado el formulario y si se recibe
    if (isset($_POST["verDatosEnvio"])) {
        //obtenemos el ID del pedido seleccionado y se almacena
        $pedido_id = $_POST["pedido"];

        //ahora cogemos el id del envio con la fk del usuario, a través del pedido_id
        $sql_envio_id = "SELECT * FROM datosenvio WHERE fk_usuario = (SELECT fk_usuario FROM pedido WHERE pedido_id = $pedido_id)";
        $resultado_envio_id = $conexion->query($sql_envio_id);

        if ($resultado_envio_id && $resultado_envio_id->num_rows > 0) {
            $fila_envio_id = $resultado_envio_id->fetch_assoc();
            $envio_id = $fila_envio_id["envio_id"];
            //Consulta para sacar los datos de envío asociados al envio_id
            $sql_datosenvio = "SELECT * FROM datosenvio WHERE envio_id = $envio_id";
            $resultado_datosEnvio = $conexion->query($sql_datosenvio);
                //si resultados datos de envío es mayor a 0 en número de datos/líneas, me los insertas en el formulario
            if ($resultado_datosEnvio && $resultado_datosEnvio->num_rows > 0) {
                $datosenvio = $resultado_datosEnvio->fetch_assoc();
                echo '<div class="container">
                        <h3 class="text-center">Datos de Envío del cliente</h3>
                        <form method="POST" action="enviarcorreo.php">
                        <div class="mb-3">
                        <label for="Usuario ID" class="form-label">Usuario ID</label>
                        <input type="text" class="form-control" id="fk_usuario" name="fk_usuario" value="' . $datosenvio["fk_usuario"] . '" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="' . $datosenvio["nombre"] . '" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="apellidos" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos" value="' . $datosenvio["apellidos"] . '" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección de envío</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" value="' . $datosenvio["direccion"] . '" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" value="' . $datosenvio["telefono"] . '" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Email de contacto</label>
                                <input type="email" class="form-control" id="correo" name="correo" value="' . $datosenvio["correoenvio"] . '" readonly>
                            </div>
                            <a href="mailto:' . $datosenvio["correoenvio"] . '?subject=Asunto del correo&body=Cuerpo del mensaje" class="btn btn-primary" name="enviarCorreo">Enviar correo</a>
                            <a href="pedidosusuarios.php" class="btn btn-secondary">Volver a Pedidos</a>


                        </form>
                      </div>';
            } else {
                echo '<p class="text-center">No hay datos de envío disponibles para el pedido seleccionado.</p>';
            }
        }
    }
} else {
    echo 'Fallo. Usuario no autentificado.';
}
?>

</body>
</html>
