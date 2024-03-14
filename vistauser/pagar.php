<?php
session_start();
include "../Conexion.php";

//Verificamos si se ha enviado el formulario de pago (que no hay)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //recibimos los datos del formulario por POST
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $usuario_id = $_SESSION['usuario_id']; //Obtenemos el id del usuario guardado en la sesion

    //Insertamos los datos de envío en la base de datos
    $insertardatosEnvio = mysqli_prepare($conexion, "INSERT INTO datosenvio (fk_usuario, nombre, apellidos, direccion, telefono) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($insertardatosEnvio, "issss", $usuario_id, $nombre, $apellidos, $direccion, $telefono);
    mysqli_stmt_execute($insertardatosEnvio);

    //Vemos si se han insertado los datos correctamente
    if (mysqli_stmt_affected_rows($insertardatosEnvio) > 0) {
        echo "¡Pedido finalizado! Gracias por su compra.";
        header("refresh:3;url=Indexvistauser.php");
        exit();

    } else {
        echo "Error al procesar el pago. Inténtelo de nuevo. Gracias";
    }

    mysqli_stmt_close($insertardatosEnvio);
} else {
    //Si no envíael formulario de pago, redirigir al usuario a la página de indexpagar
    header("Location: indexpagar.php");
    exit;
}
?>
