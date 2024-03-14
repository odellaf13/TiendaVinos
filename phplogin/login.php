<?php
//iniciamos sesión
session_start();
include "../Conexion.php";

if(isset($_POST['submit'])){
    $username = $_POST["user"];
    $password = $_POST["pass"];
    $sql = "SELECT * FROM usuario WHERE username = '$username' AND password = '$password'";

    $result = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if ($row) {
        //Guardamos la información del usuario en la sesión
        $_SESSION["username"] = $row["username"];
        $_SESSION["usuario_id"] = $row["usuario_id"];
        $_SESSION["rol"] = $row["rol"];

        //Redirigimos al usuario según su rol
        if ($row['rol'] == 'admin') {
            header("Location: /TiendaVinos/Index.php"); //Vamos a Index como administrador
            exit();
        } else {
            //Consultamos los datos de los pedidos y los detalles del pedido del usuario
            //y los guardamos en sesión
            $queryPedido = mysqli_query($conexion, "SELECT * FROM pedido WHERE fk_usuario = '".$_SESSION['usuario_id']."'");
            $_SESSION['pedido'] = mysqli_fetch_assoc($queryPedido);

            $queryDetallesPedido = mysqli_query($conexion, "SELECT * FROM linea_pedido WHERE fk_pedido = '".$_SESSION['pedido']['pedido_id']."'");
            $_SESSION['detalles_pedido'] = mysqli_fetch_assoc($queryDetallesPedido);

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



