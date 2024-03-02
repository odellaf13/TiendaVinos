<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Index.php</title>
    <link rel="stylesheet" type="text/css" href="estilovistaadmin.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>


<body id="body">

    <script>

    function eliminar(){

        var respuesta= confirm("¿Deseas eliminar el producto?");

        return respuesta;
    }

    function mostrarF(){

    document.getElementById('nuevoProducto').style.display = 'block';
    }

    function cerrarF(){

    document.getElementById('nuevoProducto').style.display = 'none';
    }

    </script>

  

    <?php

    include "Conexion.php";

    session_start();


    include "vistaadmin/controladoreliminarproducto.php";

    if(isset($_SESSION['username'])) {
        $user = $_SESSION['username'];
          //clases de bootstrap para centrar el botón de contenido y proporcionar un boton para cerrar la sesión
          echo '<div class="text-center d-flex flex-column align-items-center" style="margin-top: 20px;">
          <h3 class="text-secondary mb-3"><i class="bi bi-person-check" style="color: #3498db !important;"></i>
              Bienvenido/a, ' . $user . ', a la tienda de vinos selectos
          </h3>';
  
          //botón de cierre sesión
          echo '<a href="cerrarsesion.php" class="btn btn-danger">Cerrar Sesión</a>
          </div>';
  
  
    }

    ?>


    <div class="container-fluid row">

        <div class="col-8 p-4 mx-auto">

        <table class="table table-success table-striped mx-auto">

                <thead>
                   <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre del Producto</th>
                        <th scope="col">Precio/PVP</th>
                        <th scope="col">Stock</th>
                        <th scope="col">D.O</th>
            
                    </tr>
                </thead>

                <tbody>
                <?php


                    include "Conexion.php";

                    $sql = $conexion->query("SELECT * FROM producto");
                                if (!$sql) {
                                die("Error en la consulta: " . $conexion->error);
                                }

                   while ($datos = $sql->fetch_object()) { ?>

                            <tr>
                            <td><?= $datos->producto_id ?></td>
                            <td><?= $datos->nombre ?></td>
                            <td><?= $datos->pvp ?></td>
                            <td><?= $datos->stock ?></td>
                            <td><?= $datos->do ?></td>
                            <td>

                            <a href="vistaadmin/categoria_producto.php?id=<?= $datos->producto_id ?>"><i class="bi bi-arrow-up-right-square-fill"></i>Ficha del producto</a>
                            <a href="vistaadmin/modificar_producto.php?id=<?= $datos->producto_id ?>" class="btn-warning"><i class="bi bi-pencil-square"></i>Editar</a>
                            <a onclick="return eliminar()" href="Index.php?id=<?= $datos->producto_id ?>" class="btn-danger"><i class="bi bi-trash3-fill"></i>Eliminar</a>
                        </td>
                    </tr> 
                    <?php
                   }
                    ?>
</tbody>
                </table>




        <button class="btn btn-primary" onclick="mostrarF()">Nuevo producto</button>
            </div>
        </div>

        <div class="container-fluid row">

        <form id="nuevoProducto" class="col-3 mx-auto" method="POST" style="display: none;">

        <h3 class="text-center text-secondary">Registrar Producto</h3>

        <?php

        include "vistaadmin/registro_producto.php";

        ?>

                <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">ID</label>
                <input type="number" class="form-control" name="id" />
                </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Nombre del Producto</label>
                <input type="text" class="form-control" name="nombre" />
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">PVP</label>
                <input type="number" class="form-control" name="pvp" />
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Stock</label>
                <input type="number" class="form-control" name="stock" />
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">D.O</label>
                <input type="text" class="form-control" name="do" />
            </div>

            <div class="form-group">
                <label for="exampleFormControlTextarea1">Descripcion</label>
                <textarea id="exampleFormControlTextarea1" class="form-control" name="descripcion" rows="10"></textarea>
            </div>


            <button type="submit" class="btn btn-primary" name="botonaplicar" value="ok">Aplicar</button>
            <button class="btn btn-primary" onclick="cerrarF()">Cancelar</button>

        </form>
                </div>

</body>
</html>