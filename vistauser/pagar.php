<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include "../Conexion.php";
require("../fpdf.php");

//Verificamos si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Recibimos los datos del formulario
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];
    $usuario_id = $_SESSION["usuario_id"]; //coger el id del usuario de la sesión

    //Insertarmos los datos de envío en la base de datos
    $insertardatosEnvio = mysqli_prepare($conexion, "INSERT INTO datosenvio (fk_usuario, nombre, apellidos, direccion, telefono) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($insertardatosEnvio, "issss", $usuario_id, $nombre, $apellidos, $direccion, $telefono);
    mysqli_stmt_execute($insertardatosEnvio);

    //Verificamos si se han insertado los datos correctamente
    if (mysqli_stmt_affected_rows($insertardatosEnvio) > 0) {
       //Se actualiza el estado del pedido a completado/para enviar
       $pedido_id = $_POST["pedido_id"]; //Obtenemos el ID del pedido
       $actualizarEstado = mysqli_prepare($conexion, "UPDATE pedido SET estado = 'completado/para enviar' WHERE pedido_id = ?");
       mysqli_stmt_bind_param($actualizarEstado, "i", $pedido_id);
       mysqli_stmt_execute($actualizarEstado);

        
        //Consulta para obtener el nombre del producto, la cantidad y el total de la factura
        $consulta = "SELECT p.nombre, lp.cantidad, SUM(p.pvp * lp.cantidad) AS total FROM linea_pedido lp INNER JOIN producto p ON lp.fk_producto = p.producto_id WHERE lp.fk_pedido = ?";
        $resultado = mysqli_prepare($conexion, $consulta);
        mysqli_stmt_bind_param($resultado, "i", $pedido_id);
        mysqli_stmt_execute($resultado);
        mysqli_stmt_bind_result($resultado, $nombre_producto, $cantidad_producto, $total_factura);
        
        //Generamos una factura en PDF con FPDF (FPDF es una clase escrita en PHP que permite generar documentos PDF directamente desde PHP, es decir, sin usar la biblioteca PDFlib)
        class PDF extends FPDF
        {
            function __construct()
            {
                parent::__construct();
                $this->SetAutoPageBreak(true, 15);
                $this->SetFont('Arial', '', 12);
                $this->SetLeftMargin(10);
                $this->SetRightMargin(10);
            }
            //Cabecera del PDF
            function Header()
            {
                $this->SetX(10);//ajustes para separar la celda, logo, étc
                $this->SetY(10);
                //Logo
                $this->Image('9d9d02d012924b04b7f1b2a98dc18f83.png', 10, 8, 33);
                //Título
                $this->SetY(10);
                $this->SetX(60); // Ajusta según tu diseño
                $this->Cell(30, 10, 'Factura', 1, 0, 'C');
                //Salto de línea
                $this->Ln(20);
            }
            //comienza el pie de página
            function Footer()
            {
            //Posición: a 1,5 cm del final
                $this->SetY(-15);
                //fuente
                $this->SetFont('Arial', 'I', 8);
                //numeración de página
                $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
            }

            //hacemos una función para agregar los datos de envío a la factura
            function AddFacturaData($nombre, $apellidos, $direccion, $productos, $total_factura)
            {
                $this->SetFont('Arial', '', 12);
                $this->SetY(50);
                $this->Cell(0, 10, 'Nombre: ' . mb_convert_encoding($nombre, 'UTF-8', 'UTF-8') . ' ' . mb_convert_encoding($apellidos, 'UTF-8', 'UTF-8'), 0, 1);
                $this->Cell(0, 10, 'Dirección: ' . mb_convert_encoding($direccion, 'UTF-8', 'UTF-8'), 0, 1);
                $this->Ln();
                $this->SetFont('Arial', 'B', 12);
                $this->Cell(0, 10, 'Productos:', 0, 1);
                $this->SetFont('Arial', '', 12);
                foreach ($productos as $producto) {
                    $this->Cell(0, 10, mb_convert_encoding($producto['nombre'], 'UTF-8', 'UTF-8') . ' - Cantidad: ' . $producto['cantidad'], 0, 1);
                }
                $this->Ln();
                $this->SetFont('Arial', 'B', 12);
                $this->Cell(0, 10, 'Total de la factura: ' . mb_convert_encoding($total_factura, 'UTF-8', 'UTF-8'), 0, 1);
            }
        }

        //Creación del objeto de la clase heredada
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        
        //almacenamos los datos de los productos en un array
        $productos = array();
        while (mysqli_stmt_fetch($resultado)) {
            $productos[] = array('nombre' => $nombre_producto, 'cantidad' => $cantidad_producto);
        }

        //se llama a la función y que se genere
        $pdf->AddFacturaData($nombre, $apellidos, $direccion, $productos, $total_factura);

        //generamos un nombre de archivo.php
        $nombre_archivo = 'factura_' . date('YmdHis') . '.pdf';
        //aquí es donde se guarda, en el servidor
        $pdf->Output('F', $nombre_archivo);

        //redirigiremos al usuario a Indexvistauser.php después de unos segundos
        echo '<script>alert("Pago procesado con éxito. Se ha generado la factura.");</script>';
        echo '<script>window.open("' . $nombre_archivo . '", "_blank");</script>';

        echo '<script>setTimeout(function(){ window.location.href = "/TiendaVinos/vistauser/Indexvistauser.php"; }, 3000);</script>';
        exit();
    } else {
        echo "Error al procesar el pago. Inténtelo de nuevo. Gracias";
    }
    mysqli_stmt_close($insertardatosEnvio); //se cierra insertardatosEnvio de la BBDD
} else {
    //Si no se envía el formulario por error, redirigimos
    header("Location: indexpagar.php");
    exit;
}
?>
