<div class="modal fade" id="modalcarrito" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Mi carrito</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="p-2">
                    <ul class="list-group mb-3">
                        <?php
                        $total = 0;
                        if (isset($_SESSION["carrito"])) {
                            foreach ($_SESSION["carrito"] as $producto) {
                                if (!empty($producto)) {
                                    ?>
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div class="col-6" style="text-align: left; color: #000000;">
                                            <h6 class="my-0"><?php echo $producto["nombre"]; ?></h6>
                                            <small class="text-muted">Cantidad: <?php echo $producto["stock"]; ?></small>
                                        </div>
                                        <div class="col-6" style="text-align: right; color: #000000;">
                                            <span class="text-muted"><?php echo $producto["pvp"] * $producto["stock"]; ?> €</span>
                                        </div>
                                    </li>
                                    <?php
                                    $total += $producto["pvp"] * $producto["stock"];
                                }
                            }
                        }
                        ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span style="text-align: left; color: #000000;">Total (Euros)</span>
                            <strong style="text-align: right; color: #000000;"><?php echo $total; ?> € </strong>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Seguir pedido</button>
                <a type="button" class="btn btn-secondary" href="borrarcarrito.php">Vaciar carrito</a>
            </div>
        </div>
    </div>
</div>




