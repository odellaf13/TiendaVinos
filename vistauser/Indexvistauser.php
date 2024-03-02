<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Index.php</title>
    <link rel="stylesheet" type="text/css" href="estilovistauser.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<script>function mostrarF(){

document.getElementById('ver_carrito').style.display = 'block';
}
</script>


<body id="body">

  
    <?php
    session_start();
    include "../Conexion.php";

    if(isset($_SESSION['username'])) {
        $user = $_SESSION['username'];
        echo '<div class="text-center d-flex flex-column align-items-center" style="margin-top: 20px;">
        <h3 class="text-secondary mb-3"><i class="bi bi-person-check" style="color: #3498db !important;"></i>
            Bienvenido/a, ' . $user . ', a la tienda de vinos selectos
        </h3>';
        echo '<a href="cerrarsesion.php" class="btn btn-danger">Cerrar Sesión</a>
        </div>';
    }

    if (isset($_SESSION['mensaje'])) {
        echo '<div class="alert alert-info">' . $_SESSION['mensaje'] . '</div>';
        unset($_SESSION['mensaje']); // Limpiar el mensaje después de mostrarlo
    }

    ?>

    <div class="container-fluid row">

        <div class="col-8 p-4 mx-auto">

        <table class="table table-success table-striped mx-auto">

                <thead>
                   <tr>
                        <th scope="col">Nombre del Producto</th>
                        <th scope="col">Precio/PVP</th>
                        <th scope="col">Stock</th>
                        <th scope="col">D.O</th>
            
                    </tr>
                </thead>

                <tbody>
                <?php


    include "../Conexion.php";

                    $sql = $conexion->query("SELECT * FROM producto");
                                if (!$sql) {
                                die("Error en la consulta: " . $conexion->error);
                                }

                   while ($datos = $sql->fetch_object()) { ?>

                            <tr>
                            <td><?= $datos->nombre ?></td>
                            <td><?= $datos->pvp ?></td>
                            <td><?= $datos->stock ?></td>
                            <td><?= $datos->do ?></td>
                            <td>

                            <a href="categoria_productouser.php?id=<?= $datos->producto_id ?>"><i class="bi bi-arrow-up-right-square-fill"></i>Ficha del producto</a>
                            <a href="añadir_carrito.php?id=<?= $datos->producto_id ?>&cantidad=1" class="btn-warning"><i class="bi bi-cart-plus-fill"></i>Añadir al carrito</a>
                            <a href="quitarcarrito.php?id=<?= $datos->producto_id ?>&cantidad=1" class="btn-warning"><i class="bi bi-cart-x-fill"></i>Eliminar del carrito</a>
                            

                            </td>
                    </tr> 
                    <?php
                   }
                    ?>
                </tbody>
                </table>

                
                
                <button class="btn btn-primary" onclick="mostrarF()">Ver carrito</button>

            </div>
        </div>
        <div class="container-fluid row">

        <form id="ver_carrito" class="col-3 mx-auto" method="POST" style="display: none;">
        <div class="mb-3">
        <h3>Carrito de la compra</h3>
        <?php
        //Verifica si el carrito existe en la sesión e inicializa
        if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
        }

        //Para obtener el carrito de la sesión
        $carrito = $_SESSION['carrito'];
        $sumatorioPorID = array();

    // Iterar sobre los productos en el carrito
    foreach ($carrito as $producto) {
        $idProducto = $producto['id'];
        $nombreProducto = $producto['nombre'];
        $cantidadProducto = $producto['cantidad'];

        // Si el ID del producto ya está en el array, sumar la cantidad
        if (isset($sumatorioPorID[$idProducto])) {
            $sumatorioPorID[$idProducto]['cantidad'] += $cantidadProducto;
        } else {
            // Si no existe, agregar una nueva entrada con el nombre
            $sumatorioPorID[$idProducto] = array(
                'nombre' => $nombreProducto,
                'cantidad' => $cantidadProducto
            );
        }
    }

    // Mostrar el sumatorio consolidado
    foreach ($sumatorioPorID as $productoSumado) {
        echo 'Nombre del Producto: ' . $productoSumado['nombre'] . ', Cantidad: ' . $productoSumado['cantidad'] . '<br>';
    }
    ?>
    </div>
    </div>
  
    </form>
    
</body>
</html>
