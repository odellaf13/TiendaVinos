<?php

    if(!empty($_POST["nombre"]) and !empty($_POST["do"])and !empty($_POST["descripcion"])) {

        $id=$_POST["id"];
        $nombre=$_POST["nombre"];
        $pvp=$_POST["pvp"];
        $cantidad=$_POST["stock"];
        $do=$_POST["do"];
        $descripcion=$_POST["descripcion"];

        $sql=$conexion->query(" select from producto where nombre= '$nombre', do ='$do', descripcion= '$descripcion' where producto_id= $id");

        if($sql==1) {
         header("location:Index.php");

        }else {
        echo "<div class='alert-danger'>Error al visualizar la ficha del producto</div>";
        }

}

?>