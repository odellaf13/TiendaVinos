<div class="modal fade" id="modalcarrito" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <!--modal que he realizado para que muestre los productos que tiene el usuario añadidos a su carrito-->
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
                        //Consultamos a la BBDD cuales son los productos que tiene el usuario en la sesión actual
                        $username = $_SESSION["username"];
                        $consultaUsuario = mysqli_query($conexion, "SELECT usuario_id FROM usuario WHERE username = '$username'");
                        $filaUsuario = mysqli_fetch_assoc($consultaUsuario);

                        if ($filaUsuario) {
                            $usuario_id = $filaUsuario["usuario_id"];

                            // Obtener el pedido del usuario actual
                            $consultaPedido = mysqli_query($conexion, "SELECT pedido_id FROM pedido WHERE fk_usuario = $usuario_id AND estado = 'en trámite'");
                            $filaPedido = mysqli_fetch_assoc($consultaPedido);
//consultamos el id del pedido insertado
                            if ($filaPedido) {
                                $pedido_id = $filaPedido["pedido_id"];
                                //obtenemos los productos dl pedido del usuario
                                $consultaProductos = mysqli_query($conexion, "SELECT p.nombre, p.pvp, lp.cantidad FROM producto p JOIN linea_pedido lp ON p.producto_id = lp.fk_producto WHERE lp.fk_pedido = $pedido_id");

                                //se muestran y calculamos el total
                                while ($producto = mysqli_fetch_assoc($consultaProductos)) {
                                    //Mostraos en el modal, al clickar en el icono rojo
                                    echo "<li class='list-group-item d-flex justify-content-between lh-condensed'>";
                                    echo "<div class='col-6' style='text-align: left; color: #000000;'>";
                                    echo "<h6 class='my-0'>" . $producto["nombre"] . "</h6>";
                                    echo "<small class='text-muted'>Cantidad: " . $producto["cantidad"] . "</small>";
                                    echo "</div>";
                                    echo "<div class='col-6' style='text-align: right; color: #000000;'>";
                                    echo "<span class='text-muted'>" . $producto["pvp"] * $producto["cantidad"] . " €</span>";
                                    echo "</div>";
                                    echo "</li>";

                                    $total += $producto["pvp"] * $producto["cantidad"];
                                }
                            } else {
                                echo "<p>No hay productos añadidos en el carrito.</p>";
                            }
                        } else {
                            echo "Error al obtener el id del usuario.";
                        }
                        ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span style="text-align: left; color: #000000;">Total (Euros)</span>
                            <strong style="text-align: right; color: #000000;"><?php echo $total; ?> €</strong>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Seguir comprando</button>
                <a type="button" class="btn btn-secondary" href="borrarcarrito.php">Vaciar carrito</a>
            </div>
        </div>
    </div>
</div>