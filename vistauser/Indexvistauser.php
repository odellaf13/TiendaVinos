<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vista del usuario</title>
    <link rel="stylesheet" type="text/css" href="estilovistauser.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<?php
    session_start();
    include "../Conexion.php";
?>
<nav class="navbar navbar-expand-lg" style="background-color: #e3f2fd;">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
    <img src="../9d9d02d012924b04b7f1b2a98dc18f83.png" alt="logo" width="200px">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="quienessomos.php">Quiénes somos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/TiendaVinos/vistauser/indexpedidos.php">Pedidos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="contactanos.php">Contáctanos</a>
        </li>
      </ul>
      <form class="d-flex" role="search" action="buscador.php">
        <button class="btn btn-outline-success" type="submit" action="buscador.php">Search</button>
      </form>
    </div>
  </div>
</nav>

<?php

if(isset($_SESSION['username'])) {
  $user = $_SESSION['username'];
    //clases de bootstrap para centrar el botón de contenido y proporcionar un boton para cerrar la sesión
    echo '<div class="text-center d-flex flex-column align-items-center" style="margin-top: 20px;">
    <h3 class="text-secondary mb-3"><i class="bi bi-person-check" style="color: #3498db !important;"></i>
        Bienvenido/a, ' . $user . ', a la tienda de vinos selectos
    </h3>';

    //botón de cierre sesión
    echo '<a href="cerrarsesion.php" class="btn btn-danger">Cerrar Sesión</a></br></br>
    </div>';  
}

?>
<?php
    include "navcarrito.php";
    include "modalcarrito.php";
    ?>
<style>
    .custom-row {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }
    .custom-card {
        flex: 0 0 calc(33.33% - 15px); /*Ajusta el ancho de las tarjetas según el número de columnas*/
        margin-bottom: 15px;
    }
    .card{
      height: 425px;
    }
</style>

<body>
    <div class="center mt-5">
        <div class="card pt-3">
            <p style="font-weight: bold; color: #0F6BB7; font-size: 22px;">Carrito de la compra</p>
            <div class="container-fluid p-2" style="background-color: ghostwhite;">

                <?php
                $busqueda = mysqli_query($conexion, "SELECT * FROM producto ");
                $numero = mysqli_num_rows($busqueda);
                ?>

                <h5 class="card-tittle">Resultados (<?php echo $numero; ?>)</h5>
                <!--agregamos 3 productos por línea-->
                <div class="row custom-row">
                    <?php while ($resultado = mysqli_fetch_assoc($busqueda)) { ?>
                        <div class="col mb-4 custom-card">
                            <form id="formulariocarrito" method="POST" action="carrito.php" onsubmit="alert('Producto añadido al carrito');" enctype="multipart/form-data">
                                <div class="card">
                                    <img src="<?php echo $resultado["url_imagen"]; ?>" class="card-img-top" style="max-width: 100%; max-height: 150px; object-fit: contain;">
                                    <div class="card-body">
                                        <a class="category" style="color: #008080; font-size: 1.2em; font-weight: bold;">
                                            <?php echo $resultado["pvp"]; ?> €
                                        </a>
                                        <h5 class="card-title"><?php echo $resultado["nombre"]; ?>
                                            <small class="text-muted"><strong>(<?php echo $resultado["do"]; ?>)</strong>
                                            </small>                              
                                        </h5>
                                        <p class="card-text" style="max-height: 120px; overflow: hidden;"><?php echo $resultado["descripcion"]; ?></p>
                                        <!--creamos un botón donde nada más clickar, hagamos que se verifique un formulario del stock, por si es 0 -->
                                        <button class="btn btn-primary" type="submit" onclick="return validarFormulario(<?php echo $resultado['stock']; ?>);">
                                        <i class="bi bi-cart-plus-fill"></i>Añadir al carrito
                                            </button>
                                    </div>
                                </div>
                                <input name="producto_id" type="hidden" value="<?php echo $resultado["producto_id"]; ?>" />
              
                                <div class="text-content">
                                    <input name="producto_id" type="hidden" value="<?php echo $resultado["producto_id"]; ?>" />
                                    <input name="nombre" type="hidden" value="<?php echo $resultado["nombre"]; ?>" />
                                    <input name="pvp" type="hidden" value="<?php echo $resultado["pvp"]; ?>" />
                                    <input name="stock" type="hidden" value="<?php echo $resultado["stock"]; ?>" />
                                    <input name="do" type="hidden" value="<?php echo $resultado["do"]; ?>" />
                                    <input name="descripcion" type="hidden" value="<?php echo $resultado["descripcion"]; ?>" />
                                    <input name="url_imagen" type="hidden" value="<?php echo $resultado["url_imagen"]; ?>" />
                                    <input name="cantidad" class="cantidadInput" type="number" value="1" class="pl-2" min="1" required />
                                
                                </div>
                            </form>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <script>
    function validarFormulario(stockDisponible) {
        //vemos la cantidad seleccionada
        var cantidadSeleccionada = parseInt(document.querySelector('.cantidadInput').value);

        //Hacemos con un if un cálculo de si la cantidad seleccionada es mayor al stock disponible (que será 0, si no hay productos)
        if (cantidadSeleccionada > stockDisponible) {
            alert('Lo sentimos. No hay stock disponible del producto');
            return false;
        }

        return true; //Si es verdadero, que es > a 0, se envía todo a carrito.php
    }
</script>

</body>

</html>
