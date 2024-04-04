<?php
session_start();
include "../Conexion.php";

if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["correo"])) {
    // Recibimos datos del POST
    $nombre = $_POST["username"];
    $pass = $_POST["password"];
    $correo = $_POST["correo"];

    // Consultar los pedidos asociados al usuario
    $stmt_pedidos = $conexion->prepare("SELECT id_pedido, estado FROM pedido WHERE fk_usuario = ?");
    $stmt_pedidos->bind_param("s", $nombre);
    $stmt_pedidos->execute();
    $result_pedidos = $stmt_pedidos->get_result();

    // Array para almacenar los IDs de pedidos completados o para enviar
    $pedidos_por_mantener = array();

    // Iterar sobre los pedidos y tomar acciones según su estado
    while ($pedido = $result_pedidos->fetch_assoc()) {
        $id_pedido = $pedido['id_pedido'];
        $estado_pedido = $pedido['estado'];

        // Si el pedido está en estado "completado" o "para enviar", mantenerlo en el array
        if ($estado_pedido === 'completado' || $estado_pedido === 'para enviar') {
            $pedidos_por_mantener[] = $id_pedido;
        }
    }

    // Eliminar los pedidos asociados al usuario
    $stmt_eliminar_pedidos = $conexion->prepare("DELETE FROM pedido WHERE fk_usuario = ?");
    $stmt_eliminar_pedidos->bind_param("s", $nombre);
    $stmt_eliminar_pedidos->execute();

    // Eliminar la cuenta de usuario
    $stmt_eliminar_usuario = $conexion->prepare("DELETE FROM usuario WHERE username = ? AND password = ? AND correo = ?");
    $stmt_eliminar_usuario->bind_param("sss", $nombre, $pass, $correo);
    $stmt_eliminar_usuario->execute();

    // Verificar si se afectaron filas y redirigir según corresponda
    if ($stmt_eliminar_usuario->affected_rows > 0) {
        // Redirigir a algún lugar
        header("Location: /TiendaVinos/menuvistauser.php");
        exit();
    } else {
        // Redirigir con un parámetro de error si es necesario
        header("Location: perfilusuario.php?error=delete");
        exit();
    }
} else {
    // Redirigir con un parámetro de error si faltan datos
    header("Location: perfilusuario.php?error=missing_data");
    exit();
}

// Una vez que la cuenta del usuario se haya eliminado, puedes tomar acciones adicionales
// para manejar los pedidos completados o para enviar que se mantienen
if (!empty($pedidos_por_mantener)) {
    // Iterar sobre los IDs de los pedidos por mantener
    foreach ($pedidos_por_mantener as $id_pedido) {
        // Realizar cualquier acción necesaria, como mantener las líneas de pedido y datos de envío
        // o cualquier otra operación específica para mantener registros históricos
    }
}
?>
