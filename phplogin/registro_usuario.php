<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>registro_usuario</title>
    <link rel="stylesheet" type="text/css" href="estiloregistro1.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

	
</head>

<body id="body">

    <div class="container">
    <form action="" method="POST" class="formulario">
    <h3 class="text-center text-secondary">Formulario de registro</h3>

    <?php
    include "../Conexion.php";
    include "controlador_registrousuario.php";
    ?>


<form>

    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label"></label>
    <input type="hidden" name="id">
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Nombre de usuario</label>
        <input type="text" class="form-control" name="nombre" />
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Contraseña</label>
        <input type="password" class="form-control" name="pass" />


    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label"></label>
    <input type="hidden" name="rol">
    </div>
    
        <div class="cuenta">
        <button type="submit" class="btn btn-primary" value="Registrar usuario" name="registro">Registrar usuario</button>
        <a href="indexlogin.php" class="btn btn-primary">Volver a inicio de sesión</a>

        </div>
    </div>
    
</form>
</body>

</html>