<?php
//conexión
include "../Conexion.php";

$id=$_GET["id"];

$sql=$conexion->query(" select * from producto where producto_id= $id ");

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>categoria_producto</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body>
<!--creamos un form que reciba los datos del controlador categoria_producto1 y los imprima desde la base de datos-->
<div class="container-fluid row">
<form class="col-4 mx-auto" method="POST">

<h3 class="text-center text-secondary">Ficha del Producto</h3>

<input type="hidden" name="id" value="<?= $_GET["id"] ?>">

<?php

include "categoria_producto1.php";

while ($datos = $sql->fetch_object()) { ?>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="<?= $datos->nombre ?>"/>
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">D.O</label>
                <input type="text" class="form-control" name="do" value="<?= $datos->do ?>"/>
            </div>

            <div class="form-group">
                <label for="exampleFormControlTextarea1">Descripcion</label>
                <textarea id="exampleFormControlTextarea1" class="form-control" name="descripcion" rows="10"><?= $datos->descripcion ?></textarea>
            </div>


            <?php

}

?>

<a href="/TiendaVinos/vistaadmin/Index.php" class="btn btn-primary">Inicio</a>
</form>

</body>
</html>