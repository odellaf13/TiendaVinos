<?php
include "../Conexion.php";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Document</title>
    <link rel="stylesheet" type="text/css" href="estiloregistro.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</head>

<body id="body">  

<div id="form">

    <h1>Inicio de sesión</h1>
    <form name= "form" action="login.php" onsubmit="return isvalid()" method="POST">
        <label>Nombre de usuario: </label>
        <input type="text" id="user" name="user"></br></br>
        <label>Contraseña</label>
        <input type="password" id="pass" name="pass"></br></br>
        <input type="submit" id="btn" value="Login" name="submit"/>

        <a href="registro_usuario.php" class="btn btn-primary">¿Aún no te has registrado?</a></br></br>

        <a href="borrarusuario.php" class= "btn btn-primary">Borrar usuario</a>
    </form>


</div>


<script>
    function isvalid(){
        var user = document.form.user.value;
        var pass= document.form.pass.value;

        if(user.length== "" && pass.length== ""){
            aler("Campo usuario y contraseña vacíos");

            return false
        }
        
        else {
            
            if(user.length== ""){
            alert("Campo usuario vacío");
            return false
             }
             if(user.length== ""){
            alert("Campo contraseña vacío");
            return false
             }
        }
    
    }
</script>

</body>
</html>