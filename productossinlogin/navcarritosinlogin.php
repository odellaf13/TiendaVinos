<?php
if(isset($_SESSION["carrito"])) {
    $carritomio = $_SESSION['carrito'];
    $total_cantidad = 0;

    // Contamos la cantidad de productos en el carrito
    foreach ($carritomio as $producto) {
        if (isset($producto["stock"])) {
            $total_cantidad += $producto["stock"];
        }
    }

    if (!isset($totalcantidad)) {
        $totalcantidad = 0;
    }

    $totalcantidad += $total_cantidad;
}

if (!isset($totalcantidad)) {
    $totalcantidad = 0;
}
?>

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #112956;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Mi tienda</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-shopping-cart"></i>
            <?php if ($totalcantidad > 0): ?>
                <span class="badge bg-danger"><?php echo $totalcantidad; ?></span>
            <?php endif; ?>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="modal" data-bs-target="#modalcarrito" style="color: red; cursor: pointer;"><i class="bi bi-cart-plus-fill"></i></a>
                </li>
            </ul>
        </div>
    </div>
</nav>

