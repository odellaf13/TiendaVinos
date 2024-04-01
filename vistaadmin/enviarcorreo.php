<?php
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $fk_usuario = $_POST["fk_usuario"];
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];

    // Contenido del correo
    $asunto = "Incidencia en tu pedido";
    $mensaje = "Hola $nombre $apellidos,\n\n";
    $mensaje .= "Hemos detectado una incidencia con tu pedido. Por favor, contáctanos para resolverlo.\n\n";
    $mensaje .= "Detalles de envío:\n";
    $mensaje .= "Dirección: $direccion\n";
    $mensaje .= "Teléfono: $telefono\n";
    $mensaje .= "Correo: $correo\n\n";
    $mensaje .= "Gracias por tu comprensión.";

    // Destinatario del correo (aquí puedes cambiarlo al correo del usuario)
    $destinatario = $correo;

    // Enviar el correo
    if (mail($destinatario, $asunto, $mensaje)) {
        echo '<script>alert("Correo enviado correctamente.");</script>';
    } else {
        echo '<script>alert("Error al enviar el correo.");</script>';
    }
} else {
    echo "Acceso no autorizado.";
}
?>
