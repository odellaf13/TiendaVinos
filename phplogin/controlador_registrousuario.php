<?php

if(!empty($_POST["registro"])) {
    if(empty($_POST["nombre"]) or empty($_POST["pass"]) or empty($_POST["correo"])){
        echo '<script>
        window.location.href = "registro_usuario.php";
        alert("Alguno(s) de los campos está sin completar")
        </script>';

    } else {
        // Obtén el último usuario_id existente
        $lastUserIdQuery = $conexion->query("SELECT MAX(usuario_id) AS lastUserId FROM usuario");
        $lastUserIdData = $lastUserIdQuery->fetch_assoc();
        $lastUserId = $lastUserIdData['lastUserId'];

        // Asigna un valor único para el nuevo usuario
        $newUserId = $lastUserId + 1;

        $nombre=$_POST["nombre"];
        $pass=$_POST["pass"];
        $rol= "user";
        $correo = $_POST["correo"];

        /*$sql=$conexion->query(" insert into usuario (usuario_id, username, password, rol) values('$id, '$nombre', '$pass', '$rol')");

        if ($sql==1) {
            echo '<div class="success">Usuario registrado correctamente</div>';

        } else{
           echo '<script>
            alert("Error al registrar")
            </script>';
            */

            $stmt = $conexion->prepare("INSERT INTO usuario (usuario_id, username, password, rol, correo) VALUES (?, ?, ?, ?, ?)");

            $stmt->bind_param("issss", $newUserId, $nombre, $pass, $rol, $correo);
            $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo '<div class="success">Usuario registrado correctamente</div>';
        } else {
            echo '<script>
            alert("Error al registrar")
            </script>';
        }

        $stmt->close();
        }
    
    
}

?>