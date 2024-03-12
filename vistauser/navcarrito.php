<?php
// Inicializar totalcantidad
$totalcantidad = 0;

// Contamos la cantidad total de productos en el carrito
if (isset($_SESSION["username"])) {
    $username = $_SESSION['username'];
    $consultaUsuario = mysqli_query($conexion, "SELECT usuario_id FROM usuario WHERE username = '$username'");
    $filaUsuario = mysqli_fetch_assoc($consultaUsuario);

    if ($filaUsuario) {
        $usuario_id = $filaUsuario['usuario_id'];

        // Obtener la cantidad total del carrito desde la base de datos
        $consultaCantidad = mysqli_query($conexion, "SELECT SUM(lp.cantidad) as total_cantidad FROM linea_pedido lp JOIN pedido p ON lp.fk_pedido = p.pedido_id WHERE p.fk_usuario = $usuario_id");
        $filaCantidad = mysqli_fetch_assoc($consultaCantidad);

        if ($filaCantidad && $filaCantidad['total_cantidad']) {
            $totalcantidad = $filaCantidad['total_cantidad'];
        }
    }
}
?>

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #112956;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Mi tienda</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-shopping-cart"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="modal" data-bs-target="#modalcarrito" style="color: red; cursor: pointer;"><i class="bi bi-cart-plus-fill"></i>
                    <?php
                        echo "($totalcantidad)"; // Mostrar la cantidad total de productos en el carrito
                        ?>
                </a>
                </li>
            </ul>
        </div>
    </div>
</nav>