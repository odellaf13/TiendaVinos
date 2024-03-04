<?php
session_start();

//empezamos el carrito

if(isset($_SESSION['carrito']) || isset($_POST['producto_id'])){
    if(isset($_SESSION['carrito'])){
        $carritomio=$_SESSION['carrito'];
        if(isset($_POST['producto_id'])){
            $producto_id=$_POST['producto_id'];
            $nombre=$_POST['nombre'];
            $pvp=$_POST['pvp'];
            $stock=$_POST['stock'];
            $do=$_POST['do'];
            $descripcion=$_POST['descripcion'];
            $url_imagen=$_POST['url_imagen'];
            $donde=-1; //índice que no de error

            if($donde != -1){
                $cuanto=$carritomio[$donde]['stock'] + $stock;
                $carritomio[$donde]=array("producto_id"=>$producto_id, "nombre"=>$nombre,
                "pvp"=>$pvp, "stock"=>$stock, "do"=>$do, "descripcion"=>$descripcion, "url_imagen"=>$url_imagen);
            } else{
                $carritomio[]=array("producto_id"=>$producto_id, "nombre"=>$nombre,
                "pvp"=>$pvp, "stock"=>$stock, "do"=>$do, "descripcion"=>$descripcion, "url_imagen"=>$url_imagen);
            }
        }
    }else{ //provocas que si carritomio está vacío, te llene también los datos
        $carritomio[]=array("producto_id"=>$producto_id, "nombre"=>$nombre,
        "pvp"=>$pvp, "stock"=>$stock, "do"=>$do, "descripcion"=>$descripcion, "url_imagen"=>$url_imagen);
    }
    $_SESSION['carrito']=$carritomio; //estuviese o no vacío, le inyectamos los datos

}
header("Location: /Indexvistauser.php");
?>