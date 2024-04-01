<?php

if(!empty($_POST["botonaplicar"])) {

    if (!empty($_POST["id"]) and !empty($_POST["nombre"]) and !empty($_POST["pvp"]) and !empty($_POST["stock"]) and !empty($_POST["do"])
    and !empty($_POST["descripcion"])) {
        
        $id=$_POST["id"];

        $nombre=$_POST["nombre"];

        $pvp=$_POST["pvp"];

        $stock=$_POST["stock"];

        $do=$_POST["do"];

        $descripcion=$_POST["descripcion"];

        $sql=$conexion->query(" insert into producto(producto_id, nombre, pvp, stock, do, descripcion) values($id,'$nombre',$pvp, $stock, '$do', '$descripcion') ");

        if ($sql==1) {
             // Producto registrado correctamente, redirigir a Index.php
             echo '<script>
             setTimeout(function() {
                 window.location.href = "/TiendaVinos/vistaadmin/Index.php";
             }, 1000); // 1000 milisegundos = 1 segundo
           </script>';
           exit();
        } else {
            
            echo '<div class="alert alert-danger">Producto no registrado correctamente</div>';
        }
        

    }else{
        echo '<div class="alert alert-warning">Alguno de los campos están vacíos</div>';
    }

}

?>