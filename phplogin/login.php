<?php
include "../Conexion.php";

if(isset($_POST['submit'])){
    $username = $_POST["user"];
    $password = $_POST["pass"];
    $sql = "SELECT * FROM usuario WHERE username = '$username' AND password = '$password'";

    $result = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if ($row) {
        session_start();
        //Almacenamos el nombre del usuario y el rol en variables de sesión
        $_SESSION["username"] = $username;
        $_SESSION["rol"] = $row['rol']; // Campo en la base de datos llamado rol

        //Consultamos y almacenamos el id del usuario en la sesión iniciad
        $queryUsuario = mysqli_query($conexion, "SELECT usuario_id FROM usuario WHERE username = '$username'");
        if ($queryUsuario) {
            $usuario = mysqli_fetch_assoc($queryUsuario);
            $_SESSION['usuario_id'] = $usuario['usuario_id']; //se gaaurda el id para futuro pedido/compra
        }
        //Redirigimos al usuario según su rol
        if ($row['rol'] == 'admin') {
            header("Location: /TiendaVinos/Index.php"); //Vamos a Index como administrador
            exit();
        } else {
            header("Location: /TiendaVinos/vistauser/Indexvistauser.php");  //Vamos a la vista de Usuario
            exit();
        }
    } else {
        echo '<script>
        window.location.href = "indexlogin.php";
        alert("Usuario no registrado o contraseña no válida");
        </script>';
    }
}
?>

