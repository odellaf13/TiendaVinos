<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Vista del usuario</title>
    <link rel="stylesheet" type="text/css" href="/TiendaVinos/productossinlogin/estilosearchsinlogin.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body id="body-combat">
<?php
include "../Conexion.php";
if (isset($_POST["buscar"])) {
    $busqueda = mysqli_query($conexion, "SELECT * FROM producto WHERE nombre LIKE '%" . $_POST["buscar"] . "%' OR pvp LIKE '%" . $_POST["buscar"] . "%' OR do LIKE '%" . $_POST["buscar"] . "%' OR descripcion LIKE '%" . $_POST["buscar"] . "%'");
    $numerosql = mysqli_num_rows($busqueda);

    echo "<p style='font-weight: bold; color:green;'><i class='mdi mdi-file-document'></i> $numerosql Resultados encontrados</p>";
}
?>

<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <h4 class="card-title">Buscador</h4>

            <form id="form2" name="form2" method="POST" action="buscadorsinlogin.php">
                <div class="col-12 row">    
                    <div class="col-11">
                        <label class="form-label">Nombre del producto a buscar</label>
                        <input type="text" class="form-control" id="buscar" name="buscar" value="<?php echo isset($_POST["buscar"]) ? $_POST["buscar"] : ''; ?>" />
                    </div>
                    <div class="col-1">
                        <input type="submit" class="btn btn-success" value="Ver" style="margin-top: 30px;">
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr style="background-color: #00695c; color:#FFFFFF;">
                            <th style=" text-align: center;"> Nombre </th>
                            <th style=" text-align: center;"> D.O </th>
                            <th style=" text-align: center;"> Descripción </th>
                            <th style=" text-align: center;"> Precio </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_POST["buscar"])) {
                            while ($rowsql = mysqli_fetch_assoc($busqueda)) {
                                //Llamar a los datos de búsqueda en la BBDD
                                echo "<tr>";
                                echo "<td style='text-align: center;'>" . $rowsql["nombre"] . "</td>";
                                echo "<td style='text-align: center;'>" . $rowsql["do"] . "</td>";
                                echo "<td style='text-align: center;'>" . $rowsql["descripcion"] . "</td>";
                                echo "<td style='text-align: center;'>" . $rowsql["pvp"] . "</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div></br>

<a href="/TiendaVinos/menuvistauser.php" class="btn btn-primary">Volver a inicio</a>
</body>
</html>
