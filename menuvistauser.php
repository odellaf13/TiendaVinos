<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Vinos desde casa</title>
    <link rel="stylesheet" type="text/css" href="estilovistauser.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>

<?php
    session_start();
    include "Conexion.php";
?>
<nav class="navbar navbar-expand-lg" style="background-color: #e3f2fd;">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
    <img src="9d9d02d012924b04b7f1b2a98dc18f83.png" alt="logo" width="200px">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="vistauser/quienessomos.php">Quiénes somos</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Productos
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/TiendaVinos/productossinlogin/productossinlogin.php">Nuestros vinos</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="ofertas.php">Ofertas</a></li>
          </ul>
          <li class="nav-item">
          <a class="nav-link" href="/TiendaVinos/phplogin/indexlogin.php">Pedidos</a>

        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="productossinlogin/contactanossinlogin.php">Contáctanos</a>
        </li>
      </ul>
      <form class="d-flex" role="search" action="productossinlogin/buscadorsinlogin.php">
        <button class="btn btn-outline-success" type="submit" action="productossinlogin/buscadorsinlogin.php">Search</button>
      </form>
    </div>
  </div>
</nav>

</body>
</html>