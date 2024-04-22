<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Vista del usuario</title>
    <link rel="stylesheet" type="text/css" href="/TiendaVinos/productossinlogin/estilovistausersinlogin.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<?php
    include "../Conexion.php";
    //Voy a crear una función para construir la URL para poder filtar vinos por D.O
    function construirURLFiltrado($do) {
      $url = $_SERVER['PHP_SELF']; //url actual
      $parametros = $_GET; //con parámetros actuales
      if ($do !== null) 
      {
          $parametros['do'] = $do; //actualizamos el parámetro 'do' en la URL
      } else {
          unset($parametros['do']); //y si no, eliminamos 'do' de la URL si es null
      }

      $query = http_build_query($parametros); //se transforman los parámetros en una consulta
      if ($query) {
          $url .= '?' . $query; //se agrega la consulta a la url
      }
      return $url;
  }
  //creamos una función par aactivar el botón del do clickado
  function isActiveDO($siocurreDO) {
      if (!isset($_GET['do']) && $siocurreDO === null) {
          return 'active'; //Si no hay parámetros de D.O en la url anterior, es null y se activará TODOS
      }
      if (isset($_GET['do']) && $_GET['do'] === $siocurreDO) {
          return 'active'; //Si el parámetro do en la URL coincide con la D.O. actual, el botón se activará
      }
      return ''; //inactivo
  }
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
          <a class="nav-link active" aria-current="page" href="quienessomossinlogin.php">Quiénes somos</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Productos
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/TiendaVinos/productossinlogin/productossinlogin.php">Nuestros vinos</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
            <a class="dropdown-item" href="/TiendaVinos/productossinlogin/ofertassinlogin.php">Ofertas <i class="bi bi-percent"></i>
            </a>
        </li>
          </ul>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="contactanossinlogin.php">Contáctanos</a>
        </li>
      <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/TiendaVinos/phplogin/indexlogin.php">Iniciar sesión</a>
        </li></ul>
      <form class="d-flex" role="search" action="/TiendaVinos/productossinlogin/buscadorsinlogin.php">
        <button class="btn btn-outline-success" type="submit" action="/TiendaVinos/productossinlogin/buscadorsinlogin.php">Buscador</button>
      </form>
    </div>
  </div>
</nav></br>
<div class="text-center">
<a href="/TiendaVinos/menuvistauser.php" class="btn btn-primary">Volver al inicio</a>
</div></br>

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
      height: 475px;}
    .card-body {
        height: calc(100% - 110px); /*Resta el espacio ocupado por el precio, el nombre del vino y el botón de añadir*/
        overflow-y: auto; /*scroll vertical. Acúerdate, Óscar*/
    }
    .card-footer {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
    }
</style>

<div class="center mt-5">
    <div class="card pt-3 text-center">
        <p style="font-weight: bold; color: #0F6BB7; font-size: 22px;">Elige por D.O de vino:</p>
        <div class="container-fluid p-2" style="background-color: ghostwhite;">

        <?php
                //creamos una consulta a la base de datos basado en do, si existe en la url
                $dondeencontremos = '';
                if (isset($_GET["do"])) {
                    $do = $_GET["do"];
                    $dondeencontremos = "WHERE do = '$do'";
                }
                //creamos una consultaa la base de datos que se llam $busqueda y coja de producto, todos los do con whereClause
                $busqueda = mysqli_query($conexion, "SELECT * FROM producto $dondeencontremos");
                $numero = mysqli_num_rows($busqueda);
                ?>

            <h5 class="card-tittle">Resultados (<?php echo $numero; ?>)</h5>

            <div class="mb-3">
                    <a class="btn btn-primary <?php echo isActiveDO(null); ?>" href="<?php echo construirURLFiltrado(null); ?>">Todos</a>
                    <?php
                    //Obtenemos las D.O. de la BBDD
                    $sql = "SELECT DISTINCT do FROM producto";
                    $resultados = mysqli_query($conexion, $sql);
                    while ($row = mysqli_fetch_assoc($resultados)) {
                        $do = $row["do"]; //mientras, si se activa, vendrá do de la BBDD por línea a construirse, y se imprimirá en el div
                        
                        echo '<a class="btn btn-primary '.isActiveDO($do).'" href="'.construirURLFiltrado($do).'" style="margin-right: 5px;">'.$do.'</a>';
                    }
                    ?>
                </div></br>
              <!--agregamos 3 productos por línea-->
            <div class="row custom-row">
                <?php while ($resultado = mysqli_fetch_assoc($busqueda)) { ?>
                    <div class="col mb-4 custom-card">
                        <form id="formulariocarrito" onsubmit="return addToCart()"><!--marcamos una función al pinchar añadir carrito
                    que nos devuelva un mensaje de obligatoriedad  de inicio de sesión o que creemos un perfil de usuario-->
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
                                    <p class="card-text" style="max-height: 500px; overflow: hidden;"><?php echo $resultado["descripcion"]; ?></p>
                                    <div class="card-footer">
                                    <button class="btn btn-primary" type="submit"><i class="bi bi-cart-plus-fill"></i> Añadir al carrito</button>
                                </div>
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
                                <input name="cantidad" type="number" value="1" class="pl-2" min="1" required />
                            
                            </div>
                        </form>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script>
function addToCart() {
    alert("Necesita iniciar sesión para comenzar o continuar su compra anterior");
    window.location.href = '/TiendaVinos/productossinlogin/productossinlogin.php';
    return false;
}
</script>
</body>
</html>
