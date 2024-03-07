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

        //Almacenamos el nombre del usuario en una variable sesión
        $_SESSION['username'] = $username;
        $_SESSION['rol'] = $row['rol']; //campo en base de datos llamado rol     
        
        
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