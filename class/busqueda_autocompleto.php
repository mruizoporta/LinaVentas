<?php
include('class.consultas.php');

if (isset($_GET['Busqueda_Marcas'])):

$filtro = $_GET["term"];
$Json = new Json;
$marca = $Json->BuscaMarcas($filtro);
echo json_encode($marca);

endif;

if (isset($_GET['Busqueda_Modelos'])):

$filtro = $_GET["term"];
$Json = new Json;
$modelo  = $Json->BuscaModelos($filtro);
echo  json_encode($modelo);

endif;

if (isset($_GET['Busqueda_Cliente'])):

$filtro = $_GET["term"];
$Json = new Json;
$clientes = $Json->BuscaClientes($filtro);
echo  json_encode($clientes);

endif;

if (isset($_GET['Busqueda_Producto_Barcode']) or isset($_POST['barcode'])):

$filtro = $_POST["barcode"];
$Json = new Json;
$producto = $Json->BuscaProductoBarCode($filtro);
echo json_encode($producto);

endif;

if (isset($_GET['Busqueda_Kardex_Producto']) or isset($_GET['Busqueda_Producto_Venta'])):

$filtro = $_GET["term"];
$Json = new Json;
$producto = $Json->BuscaProductoV($filtro);
echo json_encode($producto);

endif;

if (isset($_GET['Busqueda_Producto_Compra'])):

$filtro = $_GET["term"];
$Json = new Json;
$producto = $Json->BuscaProductoC($filtro);
echo json_encode($producto);

endif;

if (isset($_GET['Busqueda_Facturas'])):

$filtro = $_GET["term"];
$Json = new Json;
$facturas  = $Json->BuscaFactura($filtro);
echo json_encode($facturas);

endif;

?>  