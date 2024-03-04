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



<script>function mostrarF(){

document.getElementById('ver_carrito').style.display = 'block';
}
</script>


<body id="body">

  
    <?php
    include "../Conexion.php";

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
                            <a href="/TiendaVinos/phplogin/indexlogin.php" class="btn-warning"><i class="bi bi-cart-plus-fill"></i>Añadir al carrito</a>
                            

                            </td>
                    </tr> 
                    <?php
                   }
                    ?>
                </tbody>
                </table>

                <a href="/TiendaVinos/menuvistauser.php" class="btn btn-primary">Volver a menú</a></br></br>
                

            </div>
        </div>

       
    </form>
    
</body>
</html>
