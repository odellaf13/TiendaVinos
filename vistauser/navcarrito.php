<?php

if(isset($_SESSION["carrito"])){
        $carritomio=$_SESSION['carrito'];
    }
//contamos la cantidad de nuestro carrito

if (isset($_SESSION["carrito"])){
    for($i=0 ;$i<=count($carritomio)-1; $i ++) {
        if(isset($carritomio[$i])){
            if($carritomio[$i]!=NULL){
                if(!isset($carritomio["stock"])){$carritomio["stock"] = '0';}else{ $carritomio["stock"] = $carritomio["stock"];}
                $total_cantidad = $carritomio["stock"];
                $total_cantidad ++;
                if(!isset($totalcantidad)){$totalcantidad = '0';}else{ $totalcantidad = $totalcantidad;}
                $totalcantidad += $total_cantidad;
            }
        }
    }
}

if(!isset($totalcantidad)){$totalcantidad = '';}else{ $totalcantidad = $totalcantidad;}

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
                    <a class="nav-link" data-bs-toggle="modal" data-bs-target="#modalcarrito" style="color: red; cursor: pointer;"><i class="bi bi-cart-plus-fill"></i></a>
                </li>
            </ul>
        </div>
    </div>
</nav>

