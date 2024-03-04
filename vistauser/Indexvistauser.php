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
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>

<?php
        include "carrito.php";
        include "navcarrito.php";
        ?>
        <div class="center mt-5">

        <div class="card pt-3">
        <p style="font-weight:  bold; color: #0F6BB7; font-size: 22px;">Carrito de la compra</p>
                   <div class="container-fluid p-2" style="background-color: ghostwhite;">

                   <?php $busqueda=mysqli_query($conexion, "Select * from producto ");
                   $numero = mysqli_num_rows($busqueda); ?>

                   <h5 class="card-tittle">Resultados (<?php echo $numero; ?>)</h5>

                   <?php while ($resultado = mysqli_fetch_assoc($busqueda)) { ?>

                    <form id="formulario" name="formulario" method="POST" action="carrito.php">
                        <div class="blog-post ">
                      
                        <img src=" <?php echo $resultado["url_imagen"]; ?>">
                        <a class="category">
                            <?php echo $resultado["pvp"]; ?> €
                            </a>

                            <div class="text-content">
                                <input name="id" type="hidden" id="id" value="<?php echo $resultado["producto_id"]; ?>" />
                                <input name="nombre" type="hidden" id="nombre" value="<?php echo $resultado["nombre"]; ?>" />
                                <input name="pvp" type="hidden" id="pvp" value="<?php echo $resultado["pvp"]; ?>" />
                                <input name="stock" type="hidden" id="stock" value="<?php echo $resultado["stock"]; ?>" />
                                <input name="do" type="hidden" id="do" value="<?php echo $resultado["do"]; ?>" />
                                <input name="descripcion" type="hidden" id="descripcion" value="<?php echo $resultado["descripcion"]; ?>" />
                                <input name="url_imagen" type="hidden" id="url_imagen" value="<?php echo $resultado["url_imagen"]; ?>" />
                                <input name="cantidad" type="hidden" id="cantidad" value="1" class="pl-2" />
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $resultado["nombre"]; ?></h5>
                                        <p><?php echo $resultado["descripcion"]; ?></p>
                                        <button class="btn btn-primary" type="submit" ><i class="fas fa-shopping-cart"></i> Añadir al carrito</button>

                                    </div>
                            </div>
                        </div>
                    </form>
                    <?php   }  ?>
                
                </div>

        </div>

        </div>
      
    
</body>
</html>
