<div class="modal fade" id="modalcarrito" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Mi carrito</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="modal-body">
                    <div>
                        <div class="p-2">
                            <ul class="list-group mb-3">
                            <?php
if (isset($_SESSION["carrito"])) {
    $total = 0;
    foreach ($_SESSION["carrito"] as $producto) {
        if (!empty($producto)) {
?>
            <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div class="row col-12">
                    <div class="col-6 p-0" style="text-align: left; color: #000000;">
                        <?php if (isset($producto["stock"]) && isset($producto["nombre"])) : ?>
                            <h6 class="my-0">Cantidad: <?php echo $producto["stock"]; ?> : <?php echo $producto["nombre"]; ?></h6>
                        <?php endif; ?>
                    </div>
                    <div class="col-6 p-0" style="text-align: right; color: #000000;">
                        <?php if (isset($producto["pvp"]) && isset($producto["stock"])) : ?>
                            <span class="text-muted"><?php echo $producto["pvp"] * $producto["stock"]; ?> €</span>
                        <?php endif; ?>
                    </div>
                </div>
            </li>
<?php
            $total += isset($producto["pvp"]) && isset($producto["stock"]) ? $producto["pvp"] * $producto["stock"] : 0;
        }
    }
}
?>

                                <li class="list-group-item d-flex justify-content-between">
                                    <span style="text-align: left; color: #000000;"> Total (Euros) </span>
                                    <strong style="text-align: right; color: #000000;"><?php echo isset($total) ? $total : '0'; ?> € </strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <a type="button" class="btn btn-secondary" href="../borrarcarro.php">Vaciar el carrito</a>
                <a type="button" class="btn btn-secondary" href="Indexvistauser.php">Continuar el pedido</a>
            </div>
        </div>
    </div>
</div>

