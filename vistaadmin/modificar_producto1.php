<?php
//controlador para modificar un producto en la tabla principal del admin, mediante post
if (!empty($_POST["botonaplicar"])) {

    if(!empty($_POST["nombre"]) and !empty($_POST["pvp"] and !empty($_POST["stock"])) and !empty($_POST["do"])
    and !empty($_POST["descripcion"])) {

        $id=$_POST["id"];
        $nombre=$_POST["nombre"];
        $pvp=$_POST["pvp"];
        $stock=$_POST["stock"];
        $do=$_POST["do"];
        $descripcion=$_POST["descripcion"];

        $sql=$conexion->query(" update producto set nombre= '$nombre', pvp= $pvp, stock= $stock, do= '$do',
        descripcion= '$descripcion' where producto_id= $id");

        if($sql==1) {
         header("Location: /TiendaVinos/vistaadmin/Index.php");

        }else {
        echo "<div class='alert-danger'>Error al modificar el producto</div>";
        }

        } else{
            echo "<div class='alert-warning'>Campos vacidos</div>";
    }
    
}

?>