<?php
if (!empty($_POST["borrar"])) {
    if (empty($_POST["nombre"]) or empty($_POST["pass"])) {
        echo '<script>
        window.location.href = "borrarusuario.php";
        alert("Alguno(s) de los campos está sin completar")
        </script>';
    } else {
        $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : null;
        $pass = isset($_POST["pass"]) ? $_POST["pass"] : null;

        // Utilizar consultas preparadas para evitar inyección SQL
        $stmt = $conexion->prepare("DELETE FROM usuario WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $nombre, $pass);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo '<script>
            window.location.href = "indexlogin.php";
            alert("El usuario se eliminó correctamente");
            </script>';
        } else {
            echo '<script>
            window.location.href = "indexlogin.php";
            alert("El usuario no ha podido ser eliminado");
            </script>';
        }

        // Cerrar la consulta preparada
        $stmt->close();
    }
}
?>


