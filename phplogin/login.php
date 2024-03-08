<?php
include "../Conexion.php";

    if(isset($_POST['submit'])){
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $sql = "select * from usuario where username = '$username' and password = '$password'";

    $result = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if ($row) {
        session_start();

        //el username y rol lo guardamos en la variable SESSION
        $_SESSION['username'] = $username;
        $_SESSION['rol'] = $row['rol']; //campo en base de datos llamado rol     
        
           //Se sinicializa el carrito a 0 ()
           $_SESSION['carrito'] = array();

           //Si el usuario tiene un carrito al cerrar sesión, nos aseguramos que lo pierda
           $usuario_id = $row['usuario_id'];
           $queryEliminarPedido = "DELETE FROM pedido WHERE fk_usuario = $usuario_id AND total = 0";
           mysqli_query($conexion, $queryEliminarPedido);

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