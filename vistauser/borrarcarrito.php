<?php
session_start();
//vaciamos dándole a la sesión carrito un array de valor 0
if (isset($_SESSION["carrito"])) {
    $_SESSION["carrito"] = array();
}
echo '<script>
    alert("Carrito vaciado correctamente");
    window.location.href = "/TiendaVinos/vistauser/Indexvistauser.php";
</script>';
exit();
?>