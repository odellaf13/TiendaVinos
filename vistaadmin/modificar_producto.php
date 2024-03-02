<?php
include "Conexion.php";
$id = $_GET["id"];

$sql = $conexion->query(" select * from producto where producto_id=$id ");


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>modificar_producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body>

    <form class="col-4 m-auto" method="POST">

        <h3 class="text-center text-secondary">Modificar Producto</h3>

        <input type="hidden" name="id" value="<?= $_GET["id"] ?>">

        <?php
        include "modificar_producto1.php";

        while ($datos = $sql->fetch_object()) { ?>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Nombre del Producto a modificar</label>
                <input type="text" class="form-control" name="nombre" value="<?= $datos->nombre ?>" />
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">PVP</label>
                <input type="text" class="form-control" name="pvp" value="<?= $datos->pvp ?>" />
            </div>


            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Stock</label>
                <input type="number" class="form-control" name="stock" value="<?= $datos->stock ?>">
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Denominación de Origen</label>
                <input type="text" class="form-control" name="do" value="<?= $datos->do ?>">
            </div>

            <style>
                /* Estilos para el contenedor del texto */
                /*   .custom-text-container {
        width: 100%;
    }*/

                /* Estilos para el textarea */
                /*  .custom-textarea {
        width: 100%;
        height: 250px; /* Altura del textarea según tus preferencias */
                /*font-size: 16px;
        /* Otros estilos según sea necesario */
                /*
    }*/
            </style>

            <div class="form-group">
                <label for="exampleFormControlTextarea1">Descripcion</label>
                <textarea id="exampleFormControlTextarea1" class="form-control" name="descripcion" rows="10"><?= $datos->descripcion ?></textarea>
            </div>


        <?php }

        ?>


        <button type="submit" class="btn btn-primary" name="botonaplicar" value="ok">Aplicar</button>

        <a href="/TiendaVinos/Index.php" class="btn btn-primary">Volver</a>

    </form>

</body>

</html>