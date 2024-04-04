<?php
// Iniciamos sesión
session_start();
include "../Conexion.php";

if(isset($_POST["submit"])){
    $username = $_POST["user"];
    $password = $_POST["pass"];
    $sql = "SELECT * FROM usuario WHERE username = ? AND password = ?";
    
    //Prepararamos la consulta sql
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
        //verificams si se encontró un usuario con las credenciales proporcionadas
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        //se mira si está activo o inactivo
        if ($row["estado"] == 1) {
            // Guardamos la información del usuario en la sesión
            $_SESSION["username"] = $row["username"];
            $_SESSION["usuario_id"] = $row["usuario_id"];
            $_SESSION["rol"] = $row["rol"];
            
            // Redirigir al usuario según su rol
            if ($row["rol"] == 'admin') {
                header("Location: /TiendaVinos/vistaadmin/Index.php"); //Vamos a Index como administrador
                exit();
            } else {
                // Consultamos los datos de los pedidos y los detalles del pedido del usuario
                // y los guardamos en sesión
                $queryPedido = mysqli_query($conexion, "SELECT * FROM pedido WHERE fk_usuario = '".$_SESSION['usuario_id']."'");
                $_SESSION["pedido"] = mysqli_fetch_assoc($queryPedido);

                $queryDetallesPedido = mysqli_query($conexion, "SELECT * FROM linea_pedido WHERE fk_pedido = '".$_SESSION['pedido']['pedido_id']."'");
                $_SESSION["detalles_pedido"] = mysqli_fetch_assoc($queryDetallesPedido);

                header("Location: /TiendaVinos/vistauser/Indexvistauser.php");  //Vamos a la vista de Usuario
                exit();
            }
        } else {
            //Usuario inactivo (cuenta eliminada de cara al usuario). Mostramos mensaje de error
            echo '<script>
            window.location.href = "indexlogin.php";
            alert("Usuario no registrado o contraseña no válida");
            </script>';
        }
    } else {
        //Usuario no registrado o contraseña no válida. Mostramos mensaje de error
        echo '<script>
        window.location.href = "indexlogin.php";
        alert("Usuario no registrado o contraseña no válida");
        </script>';
    }
}
?>
