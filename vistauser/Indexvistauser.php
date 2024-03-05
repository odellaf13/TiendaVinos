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
          <a class="nav-link" href="/TiendaVinos/phplogin/indexlogin.php">Pedidos</a>

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
    include "navcarrito.php";
    include "modalcarrito.php";
    ?>

<div class="center mt-5">
        <div class="card pt-3">
            <p style="font-weight: bold; color: #0F6BB7; font-size: 22px;">Carrito de la compra</p>
            <div class="container-fluid p-2" style="background-color: ghostwhite;">

                <?php
                $busqueda = mysqli_query($conexion, "SELECT * FROM producto ");
                $numero = mysqli_num_rows($busqueda);
                ?>

                <h5 class="card-tittle">Resultados (<?php echo $numero; ?>)</h5>

                <?php while ($resultado = mysqli_fetch_assoc($busqueda)) { ?>
                    <div class="blog-post">
                        <form id="formulariocarrito" method="POST" action="/TiendaVinos/vistauser/carrito.php" onsubmit="alert('Formulario enviado');">
                            <img src="<?php echo $resultado["url_imagen"]; ?>">
                            <a class="category">
                                <?php echo $resultado["pvp"]; ?> €
                            </a>

                            <div class="text-content">
                                <input name="id" type="hidden" value="<?php echo $resultado["producto_id"]; ?>" />
                                <input name="nombre" type="hidden" value="<?php echo $resultado["nombre"]; ?>" />
                                <input name="pvp" type="hidden" value="<?php echo $resultado["pvp"]; ?>" />
                                <input name="stock" type="hidden" value="<?php echo $resultado["stock"]; ?>" />
                                <input name="do" type="hidden" value="<?php echo $resultado["do"]; ?>" />
                                <input name="descripcion" type="hidden" value="<?php echo $resultado["descripcion"]; ?>" />
                                <input name="url_imagen" type="hidden" value="<?php echo $resultado["url_imagen"]; ?>" />
                                <input name="cantidad" type="hidden" value="1" class="pl-2" />
                                <button class="btn btn-primary" type="submit"><i class="bi bi-cart-plus-fill"></i>Añadir al carrito</button>
                            </div>
                                </form>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $resultado["nombre"]; ?></h5>
                                    <p><?php echo $resultado["descripcion"]; ?></p>
                                    <button class="btn btn-primary" type="submit"><i class="bi bi-cart-plus-fill"></i>Añadir al carrito</button>
                                </div>
                            
                        </div>
            </div>
        </div>
                        
                    
                <?php } ?>
</div>

</body>

</html>