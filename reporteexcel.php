<?php
require_once("class/class.php");
    if (isset($_SESSION['acceso'])) {
       if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero" || $_SESSION["acceso"]=="vendedor") {

$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = ($imp == "" ? "Impuesto" : $imp[0]['nomimpuesto']);
$valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

$conf = new Login();
$conf = $conf->ConfiguracionPorId();

$tipo = decrypt($_GET['tipo']);
$documento = decrypt($_GET['documento']);
$extension = $documento == 'EXCEL' ? '.xls' : '.doc';

switch($tipo)
  {

############################### MODULO DE CONFIGURACIONES ###############################

case 'PROVINCIAS': 

$archivo = str_replace(" ", "_","LISTADO DE PAISES");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DEL PAIS</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarProvincias();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $reg[$i]['id_provincia']; ?></td>
           <td><?php echo $reg[$i]['provincia']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'DEPARTAMENTOS': 

$archivo = str_replace(" ", "_","LISTADO DE DEPARTAMENTOS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DEL PAIS</th>
           <th>NOMBRE DE DEPARTAMENTO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarDepartamentos();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['provincia']; ?></td>
           <td><?php echo $reg[$i]['departamento']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'DOCUMENTOS': 

$archivo = str_replace(" ", "_","LISTADO DE DOCUMENTOS TRIBUTARIOS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE DOCUMENTO</th>
           <th>DESCRIPCIÓN DE DOCUMENTO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarDocumentos();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['documento']; ?></td>
           <td><?php echo $reg[$i]['descripcion']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'TIPOMONEDA': 

$archivo = str_replace(" ", "_","LISTADO DE TIPOS DE MONEDA");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE MONEDA</th>
           <th>SIGLAS</th>
           <th>SIMBOLO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarTipoMoneda();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['moneda']; ?></td>
           <td><?php echo $reg[$i]['siglas']; ?></td>
           <td><?php echo $reg[$i]['simbolo']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'TIPOCAMBIO': 

$archivo = str_replace(" ", "_","LISTADO DE TIPO DE CAMBIO");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>DESCRIPCIÓN DE CAMBIO</th>
           <th>MONTO DE CAMBIO</th>
           <th>TIPO DE MONEDA</th>
           <th>FECHA DE INGRESO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarTipoCambio();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['descripcioncambio']; ?></td>
           <td><?php echo number_format($reg[$i]['montocambio'], 2, '.', ','); ?></td>
           <td><?php echo $reg[$i]['moneda'].":".$reg[$i]['siglas']; ?></td>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechacambio'])); ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'MEDIOSPAGOS': 

$archivo = str_replace(" ", "_","LISTADO DE MEDIOS DE PAGOS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE MEDIO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarMediosPagos();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['mediopago']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'IMPUESTOS': 

$archivo = str_replace(" ", "_","LISTADO DE IMPUESTOS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE IMPUESTO</th>
           <th>VALOR(%)</th>
           <th>STATUS</th>
           <th>REGISTRO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarImpuestos();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nomimpuesto']; ?></td>
           <td><?php echo number_format($reg[$i]['valorimpuesto'], 2, '.', ',') ?></td>
           <td><?php echo $reg[$i]['statusimpuesto']; ?></td>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaimpuesto'])); ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'FAMILIAS': 

$archivo = str_replace(" ", "_","LISTADO DE FAMILIAS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE FAMILIA</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarFamilias();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nomfamilia']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'SUBFAMILIAS': 

$archivo = str_replace(" ", "_","LISTADO DE SUBFAMILIAS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE FAMILIA</th>
           <th>NOMBRE DE SUB-FAMILIA</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarSubfamilias();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nomfamilia']; ?></td>
           <td><?php echo $reg[$i]['nomsubfamilia']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'MARCAS': 

$archivo = str_replace(" ", "_","LISTADO DE MARCAS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE MARCA</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarMarcas();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nommarca']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'MODELOS': 

$archivo = str_replace(" ", "_","LISTADO DE MODELOS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE MARCA</th>
           <th>NOMBRE DE MODELO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarModelos();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nommarca']; ?></td>
           <td><?php echo $reg[$i]['nommodelo']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'PRESENTACIONES': 

$archivo = str_replace(" ", "_","LISTADO DE PRESENTACIONES");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE PRESENTACIONES</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarPresentaciones();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nompresentacion']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'COLORES': 

$archivo = str_replace(" ", "_","LISTADO DE COLORES");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE COLOR</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarColores();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nomcolor']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'ORIGENES': 

$archivo = str_replace(" ", "_","LISTADO DE ORIGENES");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE ORIGEN</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarOrigenes();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nomorigen']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

############################### MODULO DE CONFIGURACIONES ###############################








############################### MODULO DE SUCURSALES ###############################

case 'SUCURSALES': 

$archivo = str_replace(" ", "_","LISTADO DE SUCURSALES");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE DOCUMENTO</th>
           <th>RAZÓN SOCIAL</th>
<?php if ($documento == "EXCEL") { ?>
           <th>PAIS</th>
           <th>DEPARTAMENTO</th>
           <th>DIRECCIÓN</th>
<?php } ?>
           <th>CORREO ELECTRONICO</th>
           <th>Nº DE TELÉFONO</th>
<?php if ($documento == "EXCEL") { ?>
           <th>Nº DE ACTIVIDAD</th>
           <th>Nº DE INICIO DE VENTA</th>
           <th>FECHA DE AUTORIZACIÓN</th>
           <th>LLEVA CONTABILIDAD</th>
           <th>DESCUENTO GLOBAL</th>
           <th>Nº DOC. ENCARGADO</th>
<?php } ?>
           <th>NOMBRE DE ENCARGADO</th>
<?php if ($documento == "EXCEL") { ?>
           <th>Nº DE TELÉFONO ENCARGADO</th>
<?php } ?>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarSucursales();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['cuitsucursal']; ?></td>
           <td><?php echo $reg[$i]['nomsucursal']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['id_provincia'] == '0' ? "*********" : $reg[$i]['provincia']; ?></td>
           <td><?php echo $reg[$i]['id_departamento'] == '0' ? "*********" : $reg[$i]['departamento']; ?></td>
           <td><?php echo $reg[$i]['direcsucursal']; ?></td>
<?php } ?>
          <td><?php echo $reg[$i]['correosucursal']; ?></td>
          <td><?php echo $reg[$i]['tlfsucursal']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['nroactividadsucursal']; ?></td>
           <td><?php echo $reg[$i]['iniciofactura']; ?></td>
<td><?php echo $reg[$i]['fechaautorsucursal'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechaautorsucursal'])); ?></td>
           <td><?php echo $reg[$i]['llevacontabilidad']; ?></td>
           <td><?php echo number_format($reg[$i]['descsucursal'], 2, '.', ','); ?></td>
           <td><?php echo $reg[$i]['dniencargado']; ?></td>
<?php } ?>
          <td><?php echo $reg[$i]['nomencargado']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['tlfencargado'] == '' ? "*********" : $reg[$i]['tlfencargado']; ?></td>
<?php } ?>
         </tr>
        <?php } } ?>
</table>
<?php
break;

############################### MODULO DE SUCURSALES ###############################








############################### MODULO DE USUARIOS ###############################

case 'USUARIOS': 

$tra = new Login();
$reg = $tra->ListarUsuarios();

if ($_SESSION['acceso'] == "administradorG") {
$archivo = str_replace(" ", "_","LISTADO DE USUARIOS");
} else {
$archivo = str_replace(" ", "_","LISTADO DE USUARIOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE DOCUMENTO</th>
           <th>NOMBRES Y APELLIDOS</th>
<?php if ($documento == "EXCEL") { ?>
           <th>SEXO</th>
           <th>CORREO ELECTRONICO</th>
<?php } ?>
           <th>USUARIO</th>
           <th>NIVEL</th>
           <th>STATUS</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['dni']; ?></td>
           <td><?php echo $reg[$i]['nombres']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['sexo']; ?></td>
           <td><?php echo $reg[$i]['email']; ?></td>
<?php } ?>
           <td><?php echo $reg[$i]['usuario']; ?></td>
           <td><?php echo $reg[$i]['nivel']; ?></td>
           <td><?php echo $status = ( $reg[$i]['status'] == 1 ? "ACTIVO" : "INACTIVO"); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td><strong><?php echo $reg[$i]['nomsucursal'] == '' ? "*********" : $reg[$i]['nomsucursal']; ?></strong></td><?php } ?>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'LOGS': 

$archivo = str_replace(" ", "_","LISTADO LOGS DE ACCESO");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>IP EQUIPO</th>
           <th>TIEMPO DE ENTRADA</th>
           <th>NAVEGADOR DE ACCESO</th>
           <th>PÁGINAS DE ACCESO</th>
           <th>USUARIOS</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarLogs();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['ip']; ?></td>
           <td><?php echo $reg[$i]['tiempo']; ?></td>
           <td><?php echo $reg[$i]['detalles']; ?></td>
           <td><?php echo $reg[$i]['paginas']; ?></td>
           <td><?php echo $reg[$i]['usuario']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

############################### MODULO DE USUARIOS ###############################














############################### MODULO DE CLIENTES ###############################

case 'CLIENTES': 

$archivo = str_replace(" ", "_","LISTADO DE CLIENTES");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>TIPO DE DOCUMENTO</th>
           <th>Nº DE DOCUMENTO</th>
           <th>NOMBRES Y APELLIDOS</th>
           <th>Nº DE TELÉFONO</th>
<?php if ($documento == "EXCEL") { ?>
           <th>PAIS</th>
           <th>DEPARTAMENTO</th>
           <th>DIRECCIÓN DOMICILIARIA</th>
           <th>CORREO ELECTRONICO</th>
<?php } ?>
           <th>TIPO CLIENTE</th>
           <th>LIMITE DE CRÉDITO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarClientes();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr align="center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['documcliente'] == '0' ? "*********" : $reg[$i]['documento']; ?></td>
           <td><?php echo $reg[$i]['dnicliente']; ?></td>
           <td><?php echo $reg[$i]['nomcliente']; ?></td>
           <td><?php echo $reg[$i]['tlfcliente'] == '' ? "*********" : $reg[$i]['tlfcliente']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['id_provincia'] == '0' ? "*********" : $reg[$i]['provincia']; ?></td>
           <td><?php echo $reg[$i]['id_departamento'] == '0' ? "*********" : $reg[$i]['departamento']; ?></td>
           <td><?php echo $reg[$i]['direccliente']; ?></td>
           <td><?php echo $reg[$i]['emailcliente'] == '' ? "*********" : $reg[$i]['emailcliente']; ?></td>
<?php } ?>
           <td><?php echo $reg[$i]['tipocliente']; ?></td>
           <td><?php echo number_format($reg[$i]['limitecredito'], 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

############################### MODULO DE CLIENTES ###################################










################################ MODULO DE PROVEEDORES #################################

case 'PROVEDORES': 

$archivo = str_replace(" ", "_","LISTADO DE PROVEDORES");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>TIPO DE DOCUMENTO</th>
           <th>Nº DE DOCUMENTO</th>
           <th>NOMBRE DE PROVEEDOR</th>
           <th>Nº DE TELÉFONO</th>
<?php if ($documento == "EXCEL") { ?>
           <th>PROVINCIA</th>
           <th>DEPARTAMENTO</th>
           <th>DIRECCIÓN DOMICILIARIA</th>
           <th>CORREO ELECTRONICO</th>
<?php } ?>
           <th>VENDEDOR</th>
           <th>Nº DE TELÉFONO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarProveedores();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr align="center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['documproveedor'] == '0' ? "*********" : $reg[$i]['documento']; ?></td>
           <td><?php echo $reg[$i]['cuitproveedor']; ?></td>
           <td><?php echo $reg[$i]['nomproveedor']; ?></td>
           <td><?php echo $reg[$i]['tlfproveedor'] == '' ? "*********" : $reg[$i]['tlfproveedor']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['id_provincia'] == '0' ? "*********" : $reg[$i]['provincia']; ?></td>
           <td><?php echo $reg[$i]['id_departamento'] == '0' ? "*********" : $reg[$i]['departamento']; ?></td>
           <td><?php echo $reg[$i]['direcproveedor']; ?></td>
           <td><?php echo $reg[$i]['emailproveedor'] == '' ? "*********" : $reg[$i]['emailproveedor']; ?></td>
<?php } ?>
           <td><?php echo $reg[$i]['vendedor']; ?></td>
           <td><?php echo $reg[$i]['tlfvendedor']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'PEDIDOS':

$tra = new Login();
$reg = $tra->ListarPedidos(); 

if ($_SESSION['acceso'] == "administradorG") {
$archivo = str_replace(" ", "_","LISTADO DE PEDIDOS");
} else {
$archivo = str_replace(" ", "_","LISTADO DE PEDIDOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE PEDIDO</th>
           <th>DESCRIPCIÓN DE PROVEEDOR</th>
           <th>OBSERVACIONES</th>
           <th>Nº DE ARTICULOS</th>
           <th>FECHA DE PEDIDO</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codfactura']; ?></td>
           <td><?php echo $reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']; ?></td>
           <td><?php echo $reg[$i]['observacionpedido']; ?></td>
           <td><?php echo $reg[$i]['articulos']; ?></td>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechapedido'])); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td><strong><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></strong></td><?php } ?>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'PEDIDOSXPROVEEDOR':

$tra = new Login();
$reg = $tra->BuscarPedidosxProveedor(); 

$archivo = str_replace(" ", "_","LISTADO DE PEDIDOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal'])." Y PROVEEDOR ".$reg[0]['cuitproveedor'].": ".$reg[0]['nomproveedor'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE PEDIDO</th>
           <th>OBSERVACIONES</th>
           <th>Nº DE ARTICULOS</th>
           <th>FECHA DE PEDIDO</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codfactura']; ?></td>
           <td><?php echo $reg[$i]['observacionpedido']; ?></td>
           <td><?php echo $reg[$i]['articulos']; ?></td>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechapedido'])); ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

############################### MODULO DE PROVEEDORES ###############################














############################### MODULO DE PRODUCTOS ###############################
case 'PRODUCTOS':

$tra = new Login();
$reg = $tra->ListarProductos();

$archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS EN (SUCURSAL ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE PRODUCTO</th>
<?php if ($documento == "EXCEL") { ?>
           <th>FABRICANTE</th>
           <th>FAMILIA</th>
           <th>SUBFAMILIA</th>
<?php } ?>
           <th>MARCA</th>
           <th>MODELO</th>
<?php if ($documento == "EXCEL") { ?>
           <th>PRESENTACIÓN</th>
           <th>COLOR</th>
           <th>ORIGEN</th>
           <th>AÑO</th>
           <th>Nº DE PARTE</th>
           <th>LOTE</th>
           <th>PESO</th>
<?php } ?>
           <th>PRECIO COMPRA</th>
           <th>PRECIO MENOR</th>
           <th>PRECIO MAYOR</th>
           <th>PRECIO PÚBLICO</th>
           <th>EXISTENCIA</th>
<?php if ($documento == "EXCEL") { ?>
           <th>STOCK ÓPTIMO</th>
           <th>STOCK MEDIO</th>
           <th>STOCK MINIMO</th>
<?php } ?>
           <th><?php echo $impuesto; ?></th>
           <th>DESC</th>
<?php if ($documento == "EXCEL") { ?>
           <th>CÓDIGO DE BARRA</th>
           <th>FECHA DE ELABORACIÓN</th>
           <th>FECHA DE EXP. ÓPTIMO</th>
           <th>FECHA DE EXP. MEDIO</th>
           <th>FECHA DE EXP. MINIMO</th>
           <th>PROVEEDOR</th>
<?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalCompra=0;
$TotalMenor=0;
$TotalMayor=0;
$TotalPublico=0;
$TotalMonedaMenor=0;
$TotalMonedaMayor=0;
$TotalMonedaPublico=0;
$TotalArticulos=0;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$simbolo2 = ($reg[$i]['simbolo2'] == "" ? "" : "<strong>".$reg[$i]['simbolo2']."</strong>");
$TotalCompra+=$reg[$i]['preciocompra'];
$TotalMenor+=$reg[$i]['precioxmenor']-$reg[$i]['descproducto']/100;
$TotalMayor+=$reg[$i]['precioxmayor']-$reg[$i]['descproducto']/100;
$TotalPublico+=$reg[$i]['precioxpublico']-$reg[$i]['descproducto']/100;
$TotalMonedaMenor+=$reg[$i]['precioxmenor']/$reg[$i]['montocambio']-$reg[$i]['descproducto']/100;
$TotalMonedaMayor+=$reg[$i]['precioxmayor']/$reg[$i]['montocambio']-$reg[$i]['descproducto']/100;
$TotalMonedaPublico+=$reg[$i]['precioxpublico']/$reg[$i]['montocambio']-$reg[$i]['descproducto']/100;
$TotalArticulos+=$reg[$i]['existencia'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codproducto']; ?></td>
           <td><?php echo $reg[$i]['producto']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['fabricante'] == '' ? "*********" : $reg[$i]['fabricante']; ?></td>
           <td><?php echo $reg[$i]['codfamilia'] == '0' ? "*********" : $reg[$i]['nomfamilia']; ?></td>
           <td><?php echo $reg[$i]['codsubfamilia'] == '0' ? "*********" : $reg[$i]['nomsubfamilia']; ?></td>
<?php } ?>
           <td><?php echo $reg[$i]['nommarca']; ?></td>
           <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*********" : $reg[$i]['nommodelo']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['codpresentacion'] == '' ? "*********" : $reg[$i]['nompresentacion']; ?></td>
           <td><?php echo $reg[$i]['codcolor'] == '0' ? "*********" : $reg[$i]['nomcolor']; ?></td>
           <td><?php echo $reg[$i]['codorigen'] == '0' ? "*********" : $reg[$i]['nomorigen']; ?></td>
           <td><?php echo $reg[$i]['year'] == '' ? "*********" : $reg[$i]['year']; ?></td>
           <td><?php echo $reg[$i]['nroparte'] == '' ? "*********" : $reg[$i]['nroparte']; ?></td>
           <td><?php echo $reg[$i]['lote'] == '' || $reg[$i]['lote'] == '0' ? "*********" : $reg[$i]['lote']; ?></td>
           <td><?php echo $reg[$i]['peso'] == '' ? "*********" : $reg[$i]['peso']; ?></td>
<?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
           
           <td><?php echo $simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ','); ?> (<?php echo $reg[$i]['codmoneda2'] == '0' ? "*****" : $simbolo2.number_format($reg[$i]['precioxmenor']/$reg[$i]['montocambio'], 2, '.', ','); ?>)</td>
           
           <td><?php echo $simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ','); ?> (<?php echo $reg[$i]['codmoneda2'] == '0' ? "*****" : $simbolo2.number_format($reg[$i]['precioxmayor']/$reg[$i]['montocambio'], 2, '.', ','); ?>)</td>
           
           <td><?php echo $simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','); ?> (<?php echo $reg[$i]['codmoneda2'] == '0' ? "*****" : $simbolo2.number_format($reg[$i]['precioxpublico']/$reg[$i]['montocambio'], 2, '.', ','); ?>)</td>
           
           <td><?php echo $reg[$i]['existencia']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['stockoptimo'] == '0' ? "*********" : $reg[$i]['stockoptimo']; ?></td>
           <td><?php echo $reg[$i]['stockmedio'] == '0' ? "*********" : $reg[$i]['stockmedio']; ?></td>
           <td><?php echo $reg[$i]['stockminimo'] == '0' ? "*********" : $reg[$i]['stockminimo']; ?></td>
<?php } ?>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['codigobarra'] == '' ? "*********" : $reg[$i]['codigobarra']; ?></td>
  <td><?php echo $reg[$i]['fechaelaboracion'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechaelaboracion'])); ?></td>
  <td><?php echo $reg[$i]['fechaoptimo'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechaoptimo'])); ?></td>
  <td><?php echo $reg[$i]['fechamedio'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechamedio'])); ?></td>
  <td><?php echo $reg[$i]['fechaminimo'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechaminimo'])); ?></td>
           <td><?php echo $reg[$i]['nomproveedor']; ?></td>
<?php } ?>
         </tr>
        <?php } ?>
         <tr>
  <?php if ($documento == "EXCEL") { ?>
           <td colspan="15"></td>
  <?php } else { ?>
           <td colspan="5"></td>
  <?php } ?>
<td><strong><?php echo $simbolo.number_format($TotalCompra, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalMenor, 2, '.', ','); ?> (<?php echo $simbolo2.number_format($TotalMonedaMenor, 2, '.', ','); ?>)</strong></td>
<td><strong><?php echo $simbolo.number_format($TotalMayor, 2, '.', ','); ?> (<?php echo $simbolo2.number_format($TotalMonedaMayor, 2, '.', ','); ?>)</strong></td>
<td><strong><?php echo $simbolo.number_format($TotalPublico, 2, '.', ','); ?> (<?php echo $simbolo2.number_format($TotalMonedaPublico, 2, '.', ','); ?>)</strong></td>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
<?php if ($documento == "EXCEL") { ?>
<td colspan="9"></td>
<?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'PRODUCTOSCSV':

$tra = new Login();
$reg = $tra->ListarProductos();

$archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS EN (SUCURSAL ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
?>
         <tr class="even_row">
           <td><?php echo $reg[$i]['codproducto']; ?></td>
           <td><?php echo $reg[$i]['producto']; ?></td>
           <td><?php echo $reg[$i]['fabricante']; ?></td>
           <td><?php echo $reg[$i]['codfamilia'] == '0' ? "0" : $reg[$i]['codfamilia']; ?></td>
           <td><?php echo $reg[$i]['codsubfamilia'] == '0' ? "0" : $reg[$i]['codsubfamilia']; ?></td>
           <td><?php echo $reg[$i]['codmarca'] == '0' ? "0" : $reg[$i]['codmarca']; ?></td>
           <td><?php echo $reg[$i]['codmodelo'] == '0' ? "0" : $reg[$i]['codmodelo']; ?></td>
           <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "0" : $reg[$i]['codpresentacion']; ?></td>
           <td><?php echo $reg[$i]['codcolor'] == '0' ? "0" : $reg[$i]['codcolor']; ?></td>
           <td><?php echo $reg[$i]['codorigen'] == '0' ? "0" : $reg[$i]['codorigen']; ?></td>
           <td><?php echo $reg[$i]['year']; ?></td>
           <td><?php echo $reg[$i]['nroparte']; ?></td>
           <td><?php echo $reg[$i]['lote']; ?></td>
           <td><?php echo $reg[$i]['peso']; ?></td>
           <td><?php echo number_format($reg[$i]['preciocompra'], 2, '.', ''); ?></td>
           <td><?php echo number_format($reg[$i]['precioxmenor'], 2, '.', ''); ?></td>
           <td><?php echo number_format($reg[$i]['precioxmayor'], 2, '.', ''); ?></td>
           <td><?php echo number_format($reg[$i]['precioxpublico'], 2, '.', ''); ?></td>
           <td><?php echo $reg[$i]['existencia']; ?></td>
           <td><?php echo $reg[$i]['stockoptimo'] == '0' ? "0" : $reg[$i]['stockoptimo']; ?></td>
           <td><?php echo $reg[$i]['stockmedio'] == '0' ? "0" : $reg[$i]['stockmedio']; ?></td>
           <td><?php echo $reg[$i]['stockminimo'] == '0' ? "0" : $reg[$i]['stockminimo']; ?></td>
          <td><?php echo $reg[$i]['ivaproducto']; ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
           <td><?php echo $reg[$i]['codigobarra']; ?></td>
  <td><?php echo $reg[$i]['fechaelaboracion'] == '0000-00-00' ? "0000-00-00" : date("d-m-Y",strtotime($reg[$i]['fechaelaboracion'])); ?></td>
  <td><?php echo $reg[$i]['fechaoptimo'] == '0000-00-00' ? "0000-00-00" : date("d-m-Y",strtotime($reg[$i]['fechaoptimo'])); ?></td>
  <td><?php echo $reg[$i]['fechamedio'] == '0000-00-00' ? "0000-00-00" : date("d-m-Y",strtotime($reg[$i]['fechamedio'])); ?></td>
  <td><?php echo $reg[$i]['fechaminimo'] == '0000-00-00' ? "0000-00-00" : date("d-m-Y",strtotime($reg[$i]['fechaminimo'])); ?></td>
           <td><?php echo $reg[$i]['codproveedor']; ?></td>
           <td><?php echo $reg[$i]['stockteorico']; ?></td>
           <td><?php echo $reg[$i]['motivoajuste']; ?></td>
           <td><?php echo $reg[$i]['codsucursal']; ?></td>
         </tr>
        <?php }  } ?>
</table>
<?php
break;

case 'PRODUCTOSXSUCURSALES':

$tra = new Login();
$reg = $tra->ListarProductos();   

$archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS EN (SUCURSAL ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE PRODUCTO</th>
<?php if ($documento == "EXCEL") { ?>
           <th>FABRICANTE</th>
           <th>FAMILIA</th>
           <th>SUBFAMILIA</th>
<?php } ?>
           <th>MARCA</th>
           <th>MODELO</th>
<?php if ($documento == "EXCEL") { ?>
           <th>PRESENTACIÓN</th>
           <th>COLOR</th>
           <th>ORIGEN</th>
           <th>AÑO</th>
           <th>Nº DE PARTE</th>
           <th>LOTE</th>
           <th>PESO</th>
<?php } ?>
           <th>PRECIO COMPRA</th>
           <th>PRECIO MENOR (<?php echo $reg[0]['codmoneda2'] == '' ? "*****" : "PRECIO ".$reg[0]['siglas2']; ?>)</th>
           <th>PRECIO MAYOR (<?php echo $reg[0]['codmoneda2'] == '' ? "*****" : "PRECIO ".$reg[0]['siglas2']; ?>)</th>
           <th>PRECIO PÚBLICO (<?php echo $reg[0]['codmoneda2'] == '' ? "*****" : "PRECIO ".$reg[0]['siglas2']; ?>)</th>
           <th>EXISTENCIA</th>
<?php if ($documento == "EXCEL") { ?>
           <th>STOCK ÓPTIMO</th>
           <th>STOCK MEDIO</th>
           <th>STOCK MINIMO</th>
<?php } ?>
           <th><?php echo $impuesto; ?></th>
           <th>DESC</th>
<?php if ($documento == "EXCEL") { ?>
           <th>CÓDIGO DE BARRA</th>
           <th>FECHA DE ELABORACIÓN</th>
           <th>FECHA DE EXP. ÓPTIMO</th>
           <th>FECHA DE EXP. MEDIO</th>
           <th>FECHA DE EXP. MINIMO</th>
           <th>PROVEEDOR</th>
<?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalCompra=0;
$TotalMenor=0;
$TotalMayor=0;
$TotalPublico=0;
$TotalMonedaMenor=0;
$TotalMonedaMayor=0;
$TotalMonedaPublico=0;
$TotalArticulos=0;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$simbolo2 = ($reg[$i]['simbolo2'] == "" ? "" : "<strong>".$reg[$i]['simbolo2']."</strong>");
$TotalCompra+=$reg[$i]['preciocompra'];
$TotalMenor+=$reg[$i]['precioxmenor']-$reg[$i]['descproducto']/100;
$TotalMayor+=$reg[$i]['precioxmayor']-$reg[$i]['descproducto']/100;
$TotalPublico+=$reg[$i]['precioxpublico']-$reg[$i]['descproducto']/100;
$TotalMonedaMenor+=$reg[$i]['precioxmenor']/$reg[$i]['montocambio']-$reg[$i]['descproducto']/100;
$TotalMonedaMayor+=$reg[$i]['precioxmayor']/$reg[$i]['montocambio']-$reg[$i]['descproducto']/100;
$TotalMonedaPublico+=$reg[$i]['precioxpublico']/$reg[$i]['montocambio']-$reg[$i]['descproducto']/100;
$TotalArticulos+=$reg[$i]['existencia'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codproducto']; ?></td>
           <td><?php echo $reg[$i]['producto']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['fabricante'] == '' ? "*********" : $reg[$i]['fabricante']; ?></td>
           <td><?php echo $reg[$i]['codfamilia'] == '0' ? "*********" : $reg[$i]['nomfamilia']; ?></td>
           <td><?php echo $reg[$i]['codsubfamilia'] == '0' ? "*********" : $reg[$i]['nomsubfamilia']; ?></td>
<?php } ?>
           <td><?php echo $reg[$i]['nommarca']; ?></td>
           <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*********" : $reg[$i]['nommodelo']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['codpresentacion'] == '' ? "*********" : $reg[$i]['nompresentacion']; ?></td>
           <td><?php echo $reg[$i]['codcolor'] == '0' ? "*********" : $reg[$i]['nomcolor']; ?></td>
           <td><?php echo $reg[$i]['codorigen'] == '0' ? "*********" : $reg[$i]['nomorigen']; ?></td>
           <td><?php echo $reg[$i]['year'] == '' ? "*********" : $reg[$i]['year']; ?></td>
           <td><?php echo $reg[$i]['nroparte'] == '' ? "*********" : $reg[$i]['nroparte']; ?></td>
           <td><?php echo $reg[$i]['lote'] == '' || $reg[$i]['lote'] == '0' ? "*********" : $reg[$i]['lote']; ?></td>
           <td><?php echo $reg[$i]['peso'] == '' ? "*********" : $reg[$i]['peso']; ?></td>
<?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
           
           <td><?php echo $simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ','); ?> (<?php echo $reg[$i]['codmoneda2'] == '0' ? "*****" : $simbolo2.number_format($reg[$i]['precioxmenor']/$reg[$i]['montocambio'], 2, '.', ','); ?>)</td>
           
           <td><?php echo $simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ','); ?> (<?php echo $reg[$i]['codmoneda2'] == '0' ? "*****" : $simbolo2.number_format($reg[$i]['precioxmayor']/$reg[$i]['montocambio'], 2, '.', ','); ?>)</td>
           
           <td><?php echo $simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','); ?> (<?php echo $reg[$i]['codmoneda2'] == '0' ? "*****" : $simbolo2.number_format($reg[$i]['precioxpublico']/$reg[$i]['montocambio'], 2, '.', ','); ?>)</td>
           
           <td><?php echo $reg[$i]['existencia']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['stockoptimo'] == '0' ? "*********" : $reg[$i]['stockoptimo']; ?></td>
           <td><?php echo $reg[$i]['stockmedio'] == '0' ? "*********" : $reg[$i]['stockmedio']; ?></td>
           <td><?php echo $reg[$i]['stockminimo'] == '0' ? "*********" : $reg[$i]['stockminimo']; ?></td>
<?php } ?>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['codigobarra'] == '' ? "*********" : $reg[$i]['codigobarra']; ?></td>
  <td><?php echo $reg[$i]['fechaelaboracion'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechaelaboracion'])); ?></td>
  <td><?php echo $reg[$i]['fechaoptimo'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechaoptimo'])); ?></td>
  <td><?php echo $reg[$i]['fechamedio'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechamedio'])); ?></td>
  <td><?php echo $reg[$i]['fechaminimo'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechaminimo'])); ?></td>
           <td><?php echo $reg[$i]['nomproveedor']; ?></td>
<?php } ?>
         </tr>
        <?php } ?>
         <tr>
  <?php if ($documento == "EXCEL") { ?>
           <td colspan="15"></td>
  <?php } else { ?>
           <td colspan="5"></td>
  <?php } ?>
<td><strong><?php echo $simbolo.number_format($TotalCompra, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalMenor, 2, '.', ','); ?> (<?php echo $simbolo2.number_format($TotalMonedaMenor, 2, '.', ','); ?>)</strong></td>
<td><strong><?php echo $simbolo.number_format($TotalMayor, 2, '.', ','); ?> (<?php echo $simbolo2.number_format($TotalMonedaMayor, 2, '.', ','); ?>)</strong></td>
<td><strong><?php echo $simbolo.number_format($TotalPublico, 2, '.', ','); ?> (<?php echo $simbolo2.number_format($TotalMonedaPublico, 2, '.', ','); ?>)</strong></td>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
<?php if ($documento == "EXCEL") { ?>
<td colspan="9"></td>
<?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'PRODUCTOSXSUCURSALESCSV':

$tra = new Login();
$reg = $tra->ListarProductos();  

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 

$archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS EN (SUCURSAL ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
?>
         <tr class="even_row">
           <td><?php echo $reg[$i]['codproducto']; ?></td>
           <td><?php echo $reg[$i]['producto']; ?></td>
           <td><?php echo $reg[$i]['fabricante']; ?></td>
           <td><?php echo $reg[$i]['codfamilia'] == '0' ? "0" : $reg[$i]['codfamilia']; ?></td>
           <td><?php echo $reg[$i]['codsubfamilia'] == '0' ? "0" : $reg[$i]['codsubfamilia']; ?></td>
           <td><?php echo $reg[$i]['codmarca'] == '0' ? "0" : $reg[$i]['codmarca']; ?></td>
           <td><?php echo $reg[$i]['codmodelo'] == '0' ? "0" : $reg[$i]['codmodelo']; ?></td>
           <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "0" : $reg[$i]['codpresentacion']; ?></td>
           <td><?php echo $reg[$i]['codcolor'] == '0' ? "0" : $reg[$i]['codcolor']; ?></td>
           <td><?php echo $reg[$i]['codorigen'] == '0' ? "0" : $reg[$i]['codorigen']; ?></td>
           <td><?php echo $reg[$i]['year']; ?></td>
           <td><?php echo $reg[$i]['nroparte']; ?></td>
           <td><?php echo $reg[$i]['lote']; ?></td>
           <td><?php echo $reg[$i]['peso']; ?></td>
           <td><?php echo number_format($reg[$i]['preciocompra'], 2, '.', ''); ?></td>
           <td><?php echo number_format($reg[$i]['precioxmenor'], 2, '.', ''); ?></td>
           <td><?php echo number_format($reg[$i]['precioxmayor'], 2, '.', ''); ?></td>
           <td><?php echo number_format($reg[$i]['precioxpublico'], 2, '.', ''); ?></td>
           <td><?php echo $reg[$i]['existencia']; ?></td>
           <td><?php echo $reg[$i]['stockoptimo'] == '0' ? "0" : $reg[$i]['stockoptimo']; ?></td>
           <td><?php echo $reg[$i]['stockmedio'] == '0' ? "0" : $reg[$i]['stockmedio']; ?></td>
           <td><?php echo $reg[$i]['stockminimo'] == '0' ? "0" : $reg[$i]['stockminimo']; ?></td>
          <td><?php echo $reg[$i]['ivaproducto']; ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
           <td><?php echo $reg[$i]['codigobarra']; ?></td>
  <td><?php echo $reg[$i]['fechaelaboracion'] == '0000-00-00' ? "0000-00-00" : date("d-m-Y",strtotime($reg[$i]['fechaelaboracion'])); ?></td>
  <td><?php echo $reg[$i]['fechaoptimo'] == '0000-00-00' ? "0000-00-00" : date("d-m-Y",strtotime($reg[$i]['fechaoptimo'])); ?></td>
  <td><?php echo $reg[$i]['fechamedio'] == '0000-00-00' ? "0000-00-00" : date("d-m-Y",strtotime($reg[$i]['fechamedio'])); ?></td>
  <td><?php echo $reg[$i]['fechaminimo'] == '0000-00-00' ? "0000-00-00" : date("d-m-Y",strtotime($reg[$i]['fechaminimo'])); ?></td>
           <td><?php echo $reg[$i]['codproveedor']; ?></td>
           <td><?php echo $reg[$i]['stockteorico']; ?></td>
           <td><?php echo $reg[$i]['motivoajuste']; ?></td>
           <td><?php echo $reg[$i]['codsucursal']; ?></td>
         </tr>
        <?php }  } ?>
</table>
<?php
break;

case 'PRODUCTOSXMONEDA':

$cambio = new Login();
$cambio = $cambio->BuscarTiposCambios();

$tra = new Login();
$reg = $tra->ListarProductos(); 

$archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS EN (SUCURSAL ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal']." Y MONEDA ".$cambio[0]['moneda'].")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE PRODUCTO</th>
<?php if ($documento == "EXCEL") { ?>
           <th>FABRICANTE</th>
           <th>FAMILIA</th>
           <th>SUBFAMILIA</th>
<?php } ?>
           <th>MARCA</th>
           <th>MODELO</th>
<?php if ($documento == "EXCEL") { ?>
           <th>PRESENTACIÓN</th>
           <th>COLOR</th>
           <th>ORIGEN</th>
           <th>AÑO</th>
           <th>Nº DE PARTE</th>
           <th>LOTE</th>
           <th>PESO</th>
<?php } ?>
           <th>PRECIO COMPRA</th>
           <th>PRECIO MENOR</th>
           <th>PRECIO MAYOR</th>
           <th>PRECIO PÚBLICO</th>
           <th>EXISTENCIA</th>
<?php if ($documento == "EXCEL") { ?>
           <th>STOCK ÓPTIMO</th>
           <th>STOCK MEDIO</th>
           <th>STOCK MINIMO</th>
<?php } ?>
           <th><?php echo $impuesto; ?></th>
           <th>DESC</th>
<?php if ($documento == "EXCEL") { ?>
           <th>CÓDIGO DE BARRA</th>
           <th>FECHA DE ELABORACIÓN</th>
           <th>FECHA DE EXP. ÓPTIMO</th>
           <th>FECHA DE EXP. MEDIO</th>
           <th>FECHA DE EXP. MINIMO</th>
           <th>PROVEEDOR</th>
<?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalCompra=0;
$TotalMenor=0;
$TotalMayor=0;
$TotalPublico=0;
$TotalMonedaCompra=0;
$TotalMonedaMenor=0;
$TotalMonedaMayor=0;
$TotalMonedaPublico=0;
$TotalArticulos=0;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$TotalCompra+=number_format($reg[$i]['preciocompra'], 2, '.', '');
$TotalMenor+=number_format($reg[$i]['precioxmenor']-$reg[$i]['descproducto']/100, 2, '.', '');
$TotalMayor+=number_format($reg[$i]['precioxmayor']-$reg[$i]['descproducto']/100, 2, '.', '');
$TotalPublico+=number_format($reg[$i]['precioxpublico']-$reg[$i]['descproducto']/100, 2, '.', '');
$TotalMonedaCompra+=number_format($reg[$i]['preciocompra']/$cambio[0]['montocambio']-$reg[$i]['descproducto']/100, 2, '.', '');
$TotalMonedaMenor+=number_format($reg[$i]['precioxmenor']/$cambio[0]['montocambio']-$reg[$i]['descproducto']/100, 2, '.', '');
$TotalMonedaMayor+=number_format($reg[$i]['precioxmayor']/$cambio[0]['montocambio']-$reg[$i]['descproducto']/100, 2, '.', '');
$TotalMonedaPublico+=number_format($reg[$i]['precioxpublico']/$cambio[0]['montocambio']-$reg[$i]['descproducto']/100, 2, '.', '');
$TotalArticulos+=$reg[$i]['existencia'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codproducto']; ?></td>
           <td><?php echo $reg[$i]['producto']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['fabricante'] == '' ? "*********" : $reg[$i]['fabricante']; ?></td>
           <td><?php echo $reg[$i]['codfamilia'] == '0' ? "*********" : $reg[$i]['nomfamilia']; ?></td>
           <td><?php echo $reg[$i]['codsubfamilia'] == '0' ? "*********" : $reg[$i]['nomsubfamilia']; ?></td>
<?php } ?>
           <td><?php echo $reg[$i]['nommarca']; ?></td>
           <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*********" : $reg[$i]['nommodelo']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['codpresentacion'] == '' ? "*********" : $reg[$i]['nompresentacion']; ?></td>
           <td><?php echo $reg[$i]['codcolor'] == '0' ? "*********" : $reg[$i]['nomcolor']; ?></td>
           <td><?php echo $reg[$i]['codorigen'] == '0' ? "*********" : $reg[$i]['nomorigen']; ?></td>
           <td><?php echo $reg[$i]['year'] == '' ? "*********" : $reg[$i]['year']; ?></td>
           <td><?php echo $reg[$i]['nroparte'] == '' ? "*********" : $reg[$i]['nroparte']; ?></td>
           <td><?php echo $reg[$i]['lote'] == '' || $reg[$i]['lote'] == '0' ? "*********" : $reg[$i]['lote']; ?></td>
           <td><?php echo $reg[$i]['peso'] == '' ? "*********" : $reg[$i]['peso']; ?></td>
<?php } ?>
           <td><?php echo $cambio[0]['codmoneda'] == '' ? "*****" : $cambio[0]['simbolo'].number_format($reg[$i]['preciocompra']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
           <td><?php echo $cambio[0]['codmoneda'] == '' ? "*****" : $cambio[0]['simbolo'].number_format($reg[$i]['precioxmenor']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
           <td><?php echo $cambio[0]['codmoneda'] == '' ? "*****" : $cambio[0]['simbolo'].number_format($reg[$i]['precioxmayor']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
           <td><?php echo $cambio[0]['codmoneda'] == '' ? "*****" : $cambio[0]['simbolo'].number_format($reg[$i]['precioxpublico']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
           <td><?php echo $reg[$i]['existencia']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['stockoptimo'] == '0' ? "*********" : $reg[$i]['stockoptimo']; ?></td>
           <td><?php echo $reg[$i]['stockmedio'] == '0' ? "*********" : $reg[$i]['stockmedio']; ?></td>
           <td><?php echo $reg[$i]['stockminimo'] == '0' ? "*********" : $reg[$i]['stockminimo']; ?></td>
<?php } ?>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['codigobarra'] == '' ? "*********" : $reg[$i]['codigobarra']; ?></td>
  <td><?php echo $reg[$i]['fechaelaboracion'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechaelaboracion'])); ?></td>
  <td><?php echo $reg[$i]['fechaoptimo'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechaoptimo'])); ?></td>
  <td><?php echo $reg[$i]['fechamedio'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechamedio'])); ?></td>
  <td><?php echo $reg[$i]['fechaminimo'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechaminimo'])); ?></td>
           <td><?php echo $reg[$i]['nomproveedor']; ?></td>
<?php } ?>
         </tr>
        <?php } ?>
         <tr>
  <?php if ($documento == "EXCEL") { ?>
           <td colspan="15"></td>
  <?php } else { ?>
           <td colspan="5"></td>
  <?php } ?>
<td><strong><?php echo $cambio[0]['simbolo'].number_format($TotalMonedaCompra, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $cambio[0]['simbolo'].number_format($TotalMonedaMenor, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $cambio[0]['simbolo'].number_format($TotalMonedaMayor, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $cambio[0]['simbolo'].number_format($TotalMonedaPublico, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $TotalArticulos; ?></td>
<?php if ($documento == "EXCEL") { ?>
<td colspan="9"></td>
<?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'KARDEXPRODUCTOS':

$kardex = new Login();
$kardex = $kardex->BuscarKardexProducto();

$detalle = new Login();
$detalle = $detalle->DetalleProductosKardex();
 

$archivo = str_replace(" ", "_","KARDEX DEL PRODUCTO (".portales($detalle[0]['producto'])." Y SUCURSAL: ".$detalle[0]['cuitsucursal'].": ".$detalle[0]['nomsucursal'].")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>MOVIMIENTO</th>
           <th>ENTRADAS</th>
           <th>SALIDAS</th>
           <th>DEVOLUCIÓN</th>
           <th>EXISTENCIA</th>
<?php if ($documento == "EXCEL") { ?>
           <th><?php echo $impuesto; ?></th>
           <th>DESCUENTO</th>
           <th>PRECIO</th>
<?php } ?>
           <th>DOCUMENTO</th>
           <th>FECHA KARDEX</th>
         </tr>
      <?php 

if($kardex==""){
echo "";      
} else {

$TotalEntradas=0;
$TotalSalidas=0;
$TotalDevolucion=0;
$a=1;
for($i=0;$i<sizeof($kardex);$i++){ 
$simbolo = ($detalle[0]['simbolo'] == "" ? "" : "<strong>".$detalle[0]['simbolo']."</strong>");
$TotalEntradas+=$kardex[$i]['entradas'];
$TotalSalidas+=$kardex[$i]['salidas'];
$TotalDevolucion+=$kardex[$i]['devolucion'];
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $kardex[$i]['movimiento']; ?></td>
          <td><?php echo $kardex[$i]['entradas']; ?></td>
          <td><?php echo $kardex[$i]['salidas']; ?></td>
          <td><?php echo $kardex[$i]['devolucion']; ?></td>
          <td><?php echo $kardex[$i]['stockactual']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $kardex[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
           <td><?php echo number_format($kardex[$i]['descproducto'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($kardex[$i]["precio"], 2, '.', ','); ?></td>
<?php } ?>
          <td><?php echo $kardex[$i]['documento']; ?></td>
          <td><?php echo date("d-m-Y",strtotime($kardex[$i]['fechakardex'])); ?></td>
         </tr>
        <?php } } ?>
</table>
<strong>DETALLE DE PRODUCTO</strong><br>
<strong>CÓDIGO:</strong> <?php echo $kardex[0]['codproducto']; ?><br>
<strong>DESCRIPCIÓN:</strong> <?php echo $detalle[0]['producto']; ?><br>
<strong>PRESENTACIÓN:</strong> <?php echo $detalle[0]['nompresentacion']; ?><br>
<strong>MARCA:</strong> <?php echo $detalle[0]['nommarca']; ?><br>
<strong>MODELO:</strong> <?php echo $detalle[0]['nommodelo'] == '' ? "*****" : $detalle[0]['nommodelo']; ?><br>
<strong>TOTAL ENTRADAS:</strong> <?php echo $TotalEntradas; ?><br>
<strong>TOTAL SALIDAS:</strong> <?php echo $TotalSalidas; ?><br>
<strong>TOTAL DEVOLUCIÓN:</strong> <?php echo $TotalDevolucion; ?><br>
<strong>EXISTENCIA:</strong> <?php echo $detalle[0]['existencia']; ?><br>
<strong>PRECIO COMPRA:</strong> <?php echo $simbolo." ".number_format($detalle[0]['preciocompra'], 2, '.', ','); ?><br>
<strong>P. VENTA MENOR:</strong> <?php echo $simbolo." ".number_format($detalle[0]['precioxmenor'], 2, '.', ','); ?><br>
<strong>P. VENTA MAYOR:</strong> <?php echo $simbolo." ".number_format($detalle[0]['precioxmayor'], 2, '.', ','); ?><br>
<strong>P. VENTA PUBLICO:</strong> <?php echo $simbolo." ".number_format($detalle[0]['precioxpublico'], 2, '.', ','); ?>
<?php
break;

case 'KARDEXVALORIZADO':

$tra = new Login();
$reg = $tra->ListarKardexValorizado(); 

$archivo = str_replace(" ", "_","KARDEX VALORIZADO DE SUCURSAL: (".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE PRODUCTO</th>
           <th>MARCA</th>
           <th>MODELO</th>
           <th>PRECIO PÚBLICO</th>
           <th>DESC.</th>
           <th><?php echo $impuesto; ?></th>
           <th>EXISTENCIA</th>
           <th>TOTAL VENTA</th>
           <th>TOTAL COMPRA</th>
           <th>GANANCIAS</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {

$PrecioTotal=0;
$ExisteTotal=0;
$PagoTotal=0;
$CompraTotal=0;
$VentaTotal=0;
$TotalGanancia=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$PrecioTotal+=$reg[$i]['precioxpublico'];
$ExisteTotal+=$reg[$i]['existencia'];

$CompraTotal+=$reg[$i]['preciocompra']*$reg[$i]['existencia'];

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioxpublico']*$Descuento;
$PrecioFinal = $reg[$i]['precioxpublico']-$PrecioDescuento;
$VentaTotal+=$PrecioFinal*$reg[$i]['existencia'];

$SumCompra = $reg[$i]['preciocompra']*$reg[$i]['existencia'];
$SumVenta = $PrecioFinal*$reg[$i]['existencia'];
 
$TotalGanancia+=$SumVenta-$SumCompra; 
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codproducto']; ?></td>
          <td><?php echo $reg[$i]['producto']; ?></td>
          <td><?php echo $reg[$i]['nommarca']; ?></td>
          <td><?php echo $reg[$i]['nommodelo'] == '' ? "*****" : $reg[$i]['nommodelo']; ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioxpublico"], 2, '.', ','); ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
          <td><?php echo $reg[$i]['existencia']; ?></td>
          <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['existencia'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['existencia'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
           <td colspan="8"></td>
<td><strong><?php echo $ExisteTotal; ?></strong></td>
<td><strong><?php echo $simbolo.number_format($VentaTotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($CompraTotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></strong></td>
         </tr>
</table>
<?php
break;

case 'VALORIZADOXFECHAS':

$tra = new Login();
$reg = $tra->BuscarKardexValorizadoxFechas(); 

$archivo = str_replace(" ", "_","KARDEX VALORIZADO DEL VENDEDOR (".$reg[0]['dni'].": ".$reg[0]['nombres']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE PRODUCTO</th>
           <th>MARCA</th>
           <th>MODELO</th>
           <th>DESC.</th>
           <th>PRECIO VENTA</th>
           <th>EXISTENCIA</th>
           <th>VENDIDO</th>
           <th>TOTAL VENTA</th>
           <th>TOTAL COMPRA</th>
           <th>GANANCIAS</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {

$PrecioCompraTotal=0;
$PrecioVentaTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$CompraTotal=0;
$VentaTotal=0;
$TotalGanancia=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$PrecioCompraTotal+=$reg[$i]['preciocompra'];
$PrecioVentaTotal+=$reg[$i]['precioventa'];
$ExisteTotal+=$reg[$i]['existencia'];
$VendidosTotal+=$reg[$i]['cantidad']; 

$CompraTotal+=$reg[$i]['preciocompra']*$reg[$i]['cantidad'];

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
$VentaTotal+=$PrecioFinal*$reg[$i]['cantidad'];

$SumVenta = $PrecioFinal*$reg[$i]['cantidad']; 
$SumCompra = $reg[$i]['preciocompra']*$reg[$i]['cantidad'];
$TotalGanancia+=$SumVenta-$SumCompra;
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codproducto']; ?></td>
          <td><?php echo $reg[$i]['producto']; ?></td>
          <td><?php echo $reg[$i]['nommarca']; ?></td>
          <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']; ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo $reg[$i]['existencia']; ?></td>
          <td><?php echo $reg[$i]['cantidad']; ?></td>
          <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
           <td colspan="6"></td>
<td><strong><?php echo $simbolo.number_format($PrecioVentaTotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $ExisteTotal; ?></strong></td>
<td><strong><?php echo $VendidosTotal; ?></strong></td>
<td><strong><?php echo $simbolo.number_format($VentaTotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($CompraTotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></strong></td>
         </tr>
</table>
<?php
break;
############################### MODULO DE PRODUCTOS ###############################

























################################# MODULO DE TRASPASOS #################################
case 'TRASPASOS':

$tra = new Login();
$reg = $tra->ListarTraspasos(); 

if ($_SESSION['acceso'] == "administradorG") {
$archivo = str_replace(" ", "_","LISTADO DE TRASPASOS");
} else {
$archivo = str_replace(" ", "_","LISTADO DE TRASPASOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE TRASPASO</th>
           <th>SUCURSAL QUE ENVIA</th>
           <th>SUCURSAL QUE RECIBE</th>
           <th>FECHA DE EMISIÓN</th>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th>TOTAL <?php echo $impuesto; ?></th>
           <th>TOTAL DESC</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
         <tr align="center" class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codfactura']; ?></td>
          <td><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></td>
          <td><?php echo $reg[$i]['cuitsucursal2'].": ".$reg[$i]['nomsucursal2']; ?></td>
          <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechatraspaso'])); ?></td>
          <td><?php echo $reg[$i]['articulos']; ?></td>
          <?php if ($documento == "EXCEL") { ?>
          <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
          <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
          <?php } ?>
          <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
        </tr>
        <?php } ?>
        <tr align="center">
        <td colspan="5"></td>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
           <?php if ($documento == "EXCEL") { ?>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
           <?php } ?>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'TRASPASOSXSUCURSAL':

$tra = new Login();
$reg = $tra->BuscarTraspasosxSucursal(); 

$archivo = str_replace(" ", "_","LISTADO DE TRASPASOS DE SUCURSAL (N°: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE TRASPASO</th>
           <th>SUCURSAL QUE ENVIA</th>
           <th>SUCURSAL QUE RECIBE</th>
           <th>FECHA DE EMISIÓN</th>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th>TOTAL <?php echo $impuesto; ?></th>
           <th>TOTAL DESC</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
         <tr align="center" class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codfactura']; ?></td>
          <td><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></td>
          <td><?php echo $reg[$i]['cuitsucursal2'].": ".$reg[$i]['nomsucursal2']; ?></td>
          <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechatraspaso'])); ?></td>
          <td><?php echo $reg[$i]['articulos']; ?></td>
          <?php if ($documento == "EXCEL") { ?>
          <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
          <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
          <?php } ?>
          <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
        </tr>
        <?php } ?>
        <tr align="center">
        <td colspan="5"></td>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
           <?php if ($documento == "EXCEL") { ?>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
           <?php } ?>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'TRASPASOSXFECHAS':

$tra = new Login();
$reg = $tra->BuscarTraspasosxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE TRASPASOS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL N°: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE TRASPASO</th>
           <th>SUCURSAL QUE ENVIA</th>
           <th>SUCURSAL QUE RECIBE</th>
           <th>FECHA DE EMISIÓN</th>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th>TOTAL <?php echo $impuesto; ?></th>
           <th>TOTAL DESC</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
         <tr align="center" class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codfactura']; ?></td>
          <td><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></td>
          <td><?php echo $reg[$i]['cuitsucursal2'].": ".$reg[$i]['nomsucursal2']; ?></td>
          <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechatraspaso'])); ?></td>
          <td><?php echo $reg[$i]['articulos']; ?></td>
          <?php if ($documento == "EXCEL") { ?>
          <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
          <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
          <?php } ?>
          <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
        </tr>
        <?php } ?>
        <tr align="center">
        <td colspan="5"></td>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
           <?php if ($documento == "EXCEL") { ?>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
           <?php } ?>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'DETALLESTRASPASOSXFECHAS':

$tra = new Login();
$reg = $tra->BuscarDetallesTraspasosxFechas(); 

$archivo = str_replace(" ", "_","DETALLES DE TRASPASOS POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE PRODUCTO</th>
           <th>MARCA</th>
           <th>MODELO</th>
           <th>DESC.</th>
           <th><?php echo $impuesto; ?></th>
           <th>PRECIO VENTA</th>
           <th>EXISTENCIA</th>
           <th>TRASPASADO</th>
           <th>MONTO TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {

$PrecioTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$PagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$PrecioTotal+=$reg[$i]['precioventa'];
$ExisteTotal+=$reg[$i]['existencia'];
$VendidosTotal+=$reg[$i]['cantidad']; 

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
$PagoTotal+=$PrecioFinal*$reg[$i]['cantidad'];
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codproducto']; ?></td>
          <td><?php echo $reg[$i]['producto']; ?></td>
          <td><?php echo $reg[$i]['nommarca']; ?></td>
          <td><?php echo $reg[$i]['nommodelo'] == '' ? "*****" : $reg[$i]['nommodelo']; ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo $reg[$i]['existencia']; ?></td>
          <td><?php echo $reg[$i]['cantidad']; ?></td>
          <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
           <td colspan="7"></td>
<td><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></td>
<td><?php echo $ExisteTotal; ?></strong></td>
<td><?php echo $VendidosTotal; ?></strong></td>
<td><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></td>
         </tr>
</table>
<?php
break;
################################## MODULO DE TRASPASOS ###################################


















############################### MODULO DE COMPRAS ###############################
case 'COMPRAS':

$tra = new Login();
$reg = $tra->ListarCompras(); 

if ($_SESSION['acceso'] == "administradorG") {
$archivo = str_replace(" ", "_","LISTADO DE COMPRAS");
} else {
$archivo = str_replace(" ", "_","LISTADO DE COMPRAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE COMPRA</th>
           <th>DESCRIPCIÓN DE PROVEEDOR</th>
           <th>FECHA DE EMISIÓN</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'];
$TotalImpuesto+=$reg[$i]['totalivac'];
$TotalDescuento+=$reg[$i]['totaldescuentoc'];
$TotalImporte+=$reg[$i]['totalpagoc'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codcompra']; ?></td>
           <td><?php echo $reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']; ?></td>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
           
           <?php if ($documento == "EXCEL") { ?>
           <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo $reg[$i]["statuscompra"]; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo $reg[$i]["statuscompra"]; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "VENCIDA"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo $reg[$i]["statuscompra"]; } ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
      
      <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
        <?php } ?>

           <td><?php echo $reg[$i]['articulos']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['totalivac'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['ivac'], 2, '.', ','); ?>%</sup></td>
          <td><?php echo $simbolo.number_format($reg[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuentoc'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td><strong><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></strong></td><?php } ?>
         </tr>
        <?php } ?>
         <tr>
           <td colspan="4"></td>
           <?php if ($documento == "EXCEL") { ?>
           <td colspan="4"></td>
           <?php } ?>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
           <?php if ($documento == "EXCEL") { ?>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
           <?php } ?>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td></td><?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'CUENTASXPAGAR':

$tra = new Login();
$reg = $tra->ListarCuentasxPagar(); 

if ($_SESSION['acceso'] == "administradorG") {
$archivo = str_replace(" ", "_","LISTADO DE COMPRAS POR PAGAR");
} else {
$archivo = str_replace(" ", "_","LISTADO DE COMPRAS POR PAGAR EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE COMPRA</th>
           <th>DESCRIPCIÓN DE PROVEEDOR</th>
           <th>FECHA DE EMISIÓN</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
           <th>TOTAL ABONO</th>
           <th>TOTAL DEBE</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalImporte+=$reg[$i]['totalpagoc'];
$TotalAbono+=$reg[$i]['abonototal'];
$TotalDebe+=$reg[$i]['totalpagoc']-$reg[$i]['abonototal'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codcompra']; ?></td>
           <td><?php echo $reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']; ?></td>

           <?php if ($documento == "EXCEL") { ?>
           <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo $reg[$i]["statuscompra"]; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo $reg[$i]["statuscompra"]; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "VENCIDA"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo $reg[$i]["statuscompra"]; } ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
      
      <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
           
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['abonototal'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc']-$reg[$i]['abonototal'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr>
           <td colspan="4"></td>
           <?php if ($documento == "EXCEL") { ?>
            <td colspan="4"></td>
          <?php } ?>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
         </tr>
        <?php } ?> 
</table>
<?php
break;

case 'COMPRASXPROVEEDOR':

$tra = new Login();
$reg = $tra->BuscarComprasxProveedor(); 

$archivo = str_replace(" ", "_","LISTADO DE COMPRAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal'])." Y PROVEEDOR ".$reg[0]['cuitproveedor'].": ".$reg[0]['nomproveedor'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE COMPRA</th>
           <th>DESCRIPCIÓN DE PROVEEDOR</th>
           <th>FECHA DE EMISIÓN</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'];
$TotalImpuesto+=$reg[$i]['totalivac'];
$TotalDescuento+=$reg[$i]['totaldescuentoc'];
$TotalImporte+=$reg[$i]['totalpagoc'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codcompra']; ?></td>
           <td><?php echo $reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']; ?></td>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
           
           <?php if ($documento == "EXCEL") { ?>
           <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo $reg[$i]["statuscompra"]; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo $reg[$i]["statuscompra"]; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "VENCIDA"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo $reg[$i]["statuscompra"]; } ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
      
      <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
        <?php } ?>

           <td><?php echo $reg[$i]['articulos']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['totalivac'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['ivac'], 2, '.', ','); ?>%</sup></td>
          <td><?php echo $simbolo.number_format($reg[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuentoc'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr>
           <td colspan="4"></td>
           <?php if ($documento == "EXCEL") { ?>
           <td colspan="4"></td>
           <?php } ?>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
           <?php if ($documento == "EXCEL") { ?>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
           <?php } ?>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'COMPRASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarComprasxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE COMPRAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE COMPRA</th>
           <th>DESCRIPCIÓN DE PROVEEDOR</th>
           <th>FECHA DE EMISIÓN</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'];
$TotalImpuesto+=$reg[$i]['totalivac'];
$TotalDescuento+=$reg[$i]['totaldescuentoc'];
$TotalImporte+=$reg[$i]['totalpagoc'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codcompra']; ?></td>
           <td><?php echo $reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']; ?></td>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
           
           <?php if ($documento == "EXCEL") { ?>
           <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo $reg[$i]["statuscompra"]; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo $reg[$i]["statuscompra"]; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "VENCIDA"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo $reg[$i]["statuscompra"]; } ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
      
      <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
        <?php } ?>

           <td><?php echo $reg[$i]['articulos']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['totalivac'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['ivac'], 2, '.', ','); ?>%</sup></td>
          <td><?php echo $simbolo.number_format($reg[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuentoc'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr>
           <td colspan="4"></td>
           <?php if ($documento == "EXCEL") { ?>
           <td colspan="4"></td>
           <?php } ?>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
           <?php if ($documento == "EXCEL") { ?>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
           <?php } ?>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'CREDITOSXPROVEEDOR':

$tra = new Login();
$reg = $tra->BuscarCreditosxProveedor(); 

$archivo = str_replace(" ", "_","LISTADO DE CREDITOS DEL (PROVEEDOR: ".$reg[0]["cuitproveedor"].": ".$reg[0]["nomproveedor"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE COMPRA</th>
           <th>FECHA DE EMISIÓN</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
           <th>TOTAL ABONO</th>
           <th>TOTAL DEBE</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalImporte+=$reg[$i]['totalpagoc'];
$TotalAbono+=$reg[$i]['abonototal'];
$TotalDebe+=$reg[$i]['totalpagoc']-$reg[$i]['abonototal'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codcompra']; ?></td>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo $reg[$i]["statuscompra"]; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo $reg[$i]["statuscompra"]; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "VENCIDA"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo $reg[$i]["statuscompra"]; } ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
      
      <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['abonototal'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc']-$reg[$i]['abonototal'], 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
          <td colspan="3"></td>
          <?php if ($documento == "EXCEL") { ?>
          <td colspan="4"></td>
          <?php } ?>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
         </tr>
</table>
<?php
break;

case 'CREDITOSCOMPRASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarCreditosComprasxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE CREDITOS DE COMPRAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE COMPRA</th>
           <th>DESCRIPCIÓN DE PROVEEDOR</th>
           <th>FECHA DE EMISIÓN</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
           <th>TOTAL ABONO</th>
           <th>TOTAL DEBE</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 

$TotalImporte+=$reg[$i]['totalpagoc'];
$TotalAbono+=$reg[$i]['abonototal'];
$TotalDebe+=$reg[$i]['totalpagoc']-$reg[$i]['abonototal'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codcompra']; ?></td>
           <td><?php echo $reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']; ?></td>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>

           <?php if ($documento == "EXCEL") { ?>
           <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo $reg[$i]["statuscompra"]; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo $reg[$i]["statuscompra"]; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "VENCIDA"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo $reg[$i]["statuscompra"]; } ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
      
      <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
          <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['abonototal'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc']-$reg[$i]['abonototal'], 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
           <td colspan="4"></td>
           <?php if ($documento == "EXCEL") { ?>
           <td colspan="4"></td>
           <?php } ?>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
         </tr>
</table>
<?php
break;
############################### MODULO DE COMPRAS ###############################




















############################### MODULO DE COTIZACIONES ###############################
case 'COTIZACIONES':

$tra = new Login();
$reg = $tra->ListarCotizaciones(); 

if ($_SESSION['acceso'] == "administradorG") {
$archivo = str_replace(" ", "_","LISTADO DE COTIZACIONES");
} else {
$archivo = str_replace(" ", "_","LISTADO DE COTIZACIONES EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE COTIZACIÓN</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <th>OBSERVACIONES</th>
           <th>FECHA DE EMISIÓN</th>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codfactura']; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
           <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechacotizacion'])); ?></td>
           <td><?php echo $reg[$i]['articulos']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td><strong><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></strong></td><?php } ?>
         </tr>
        <?php } ?>
         <tr>
           <?php echo $documento == "EXCEL" ? '<td colspan="5"></td>' : '<td colspan="5"></td>'; ?>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
           <?php if ($documento == "EXCEL") { ?>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
           <?php } ?>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td></td><?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'COTIZACIONESXFECHAS':

$tra = new Login();
$reg = $tra->BuscarCotizacionesxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE COTIZACIONES (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE COTIZACIÓN</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <th>OBSERVACIONES</th>
           <th>FECHA DE EMISIÓN</th>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codfactura']; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
           <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechacotizacion'])); ?></td>
           <td><?php echo $reg[$i]['articulos']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr>
           <?php echo $documento == "EXCEL" ? '<td colspan="5"></td>' : '<td colspan="5"></td>'; ?>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
           <?php if ($documento == "EXCEL") { ?>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
           <?php } ?>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'DETALLESCOTIZACIONESXFECHAS':

$tra = new Login();
$reg = $tra->BuscarDetallesCotizacionesxFechas(); 

$archivo = str_replace(" ", "_","DETALLES COTIZACIONES POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>TIPO</th>
           <th>DESCRIPCIÓN</th>
           <th>MARCA</th>
           <th>MODELO</th>
           <th>DESC.</th>
           <th><?php echo $impuesto; ?></th>
           <th>PRECIO VENTA</th>
           <th>EXISTENCIA</th>
           <th>COTIZADO</th>
           <th>MONTO TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {

$PrecioTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$PagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$PrecioTotal+=$reg[$i]['precioventa'];
$ExisteTotal+=$reg[$i]['tipodetalle'] == '1' ? $reg[$i]['existencia'] : "0";
$VendidosTotal+=$reg[$i]['cantidad']; 

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
$PagoTotal+=$PrecioFinal*$reg[$i]['cantidad'];
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['tipodetalle'] == 1 ? "PRODUCTO" : "SERVICIO"; ?></td>
          <td><?php echo $reg[$i]['producto']; ?></td>
          <td><?php echo $reg[$i]["codmarca"] == '0' ? "*****" : $reg[$i]['nommarca']; ?></td>
          <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']; ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo $reg[$i]['tipodetalle'] == '1' ? $reg[$i]['existencia'] : "******"; ?></td>
          <td><?php echo $reg[$i]['cantidad']; ?></td>
          <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
           <td colspan="7"></td>
<td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $ExisteTotal; ?></strong></td>
<td><strong><?php echo $VendidosTotal; ?></strong></td>
<td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
         </tr>
</table>
<?php
break;

case 'DETALLESCOTIZACIONESXVENDEDOR':

$tra = new Login();
$reg = $tra->BuscarDetallesCotizacionesxVendedor(); 

$archivo = str_replace(" ", "_","DETALLES COTIZACIONES POR VENDEDOR (".$reg[0]['dni'].": ".$reg[0]['nombres']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>TIPO</th>
           <th>DESCRIPCIÓN</th>
           <th>MARCA</th>
           <th>MODELO</th>
           <th>DESC.</th>
           <th><?php echo $impuesto; ?></th>
           <th>PRECIO VENTA</th>
           <th>EXISTENCIA</th>
           <th>COTIZADO</th>
           <th>MONTO TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {

$PrecioTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$PagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$PrecioTotal+=$reg[$i]['precioventa'];
$ExisteTotal+=$reg[$i]['tipodetalle'] == '1' ? $reg[$i]['existencia'] : "0";
$VendidosTotal+=$reg[$i]['cantidad']; 

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
$PagoTotal+=$PrecioFinal*$reg[$i]['cantidad'];
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['tipodetalle'] == 1 ? "PRODUCTO" : "SERVICIO"; ?></td>
          <td><?php echo $reg[$i]['producto']; ?></td>
          <td><?php echo $reg[$i]["codmarca"] == '0' ? "*****" : $reg[$i]['nommarca']; ?></td>
          <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']; ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo $reg[$i]['tipodetalle'] == '1' ? $reg[$i]['existencia'] : "******"; ?></td>
          <td><?php echo $reg[$i]['cantidad']; ?></td>
          <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
           <td colspan="7"></td>
<td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $ExisteTotal; ?></strong></td>
<td><strong><?php echo $VendidosTotal; ?></strong></td>
<td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
         </tr>
</table>
<?php
break;
############################### MODULO DE COTIZACIONES ###############################




















############################### MODULO DE PREVENTAS ###############################
case 'PREVENTAS':

$tra = new Login();
$reg = $tra->ListarPreventas(); 

if ($_SESSION['acceso'] == "administradorG") {
$archivo = str_replace(" ", "_","LISTADO DE PREVENTAS");
} else {
$archivo = str_replace(" ", "_","LISTADO DE PREVENTAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE PREVENTA</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <th>OBSERVACIONES</th>
           <th>FECHA DE EMISIÓN</th>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codfactura']; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
           <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechapreventa'])); ?></td>
           <td><?php echo $reg[$i]['articulos']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td><strong><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></strong></td><?php } ?>
         </tr>
        <?php } ?>
         <tr>
           <?php echo $documento == "EXCEL" ? '<td colspan="5"></td>' : '<td colspan="5"></td>'; ?>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
           <?php if ($documento == "EXCEL") { ?>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
           <?php } ?>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td></td><?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'PREVENTASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarPreventasxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE PREVENTAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE PREVENTA</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <th>OBSERVACIONES</th>
           <th>FECHA DE EMISIÓN</th>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codfactura']; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
           <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechapreventa'])); ?></td>
           <td><?php echo $reg[$i]['articulos']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
           <td colspan="5"></td>
<td><?php echo $TotalArticulos; ?></strong></td>
           <?php if ($documento == "EXCEL") { ?>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
           <?php } ?>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
         </tr>
</table>
<?php
break;

case 'DETALLESPREVENTASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarDetallesPreventasxFechas(); 

$archivo = str_replace(" ", "_","DETALLES DE PREVENTAS POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>TIPO</th>
           <th>DESCRIPCIÓN</th>
           <th>MARCA</th>
           <th>MODELO</th>
           <th>DESC.</th>
           <th><?php echo $impuesto; ?></th>
           <th>PRECIO VENTA</th>
           <th>EXISTENCIA</th>
           <th>PREVENTA</th>
           <th>MONTO TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {

$PrecioTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$PagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$PrecioTotal+=$reg[$i]['precioventa'];
$ExisteTotal+=$reg[$i]['existencia'];
$VendidosTotal+=$reg[$i]['cantidad']; 

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
$PagoTotal+=$PrecioFinal*$reg[$i]['cantidad'];
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['tipodetalle'] == 1 ? "PRODUCTO" : "SERVICIO"; ?></td>
          <td><?php echo $reg[$i]['producto']; ?></td>
          <td><?php echo $reg[$i]['codmarca'] == '0' ? "*****" : $reg[$i]['nommarca']; ?></td>
          <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']; ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo $reg[$i]['tipodetalle'] == '1' ? $reg[$i]['existencia'] : "******"; ?></td>
          <td><?php echo $reg[$i]['cantidad']; ?></td>
          <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
           <td colspan="7"></td>
<td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $ExisteTotal; ?></strong></td>
<td><strong><?php echo $VendidosTotal; ?></strong></td>
<td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
         </tr>
</table>
<?php
break;

case 'DETALLESPREVENTASXVENDEDOR':

$tra = new Login();
$reg = $tra->BuscarDetallesPreventasxVendedor(); 

$archivo = str_replace(" ", "_","DETALLES DE PREVENTAS DEL VENDEDOR (".$reg[0]['dni'].": ".$reg[0]['nombres']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>TIPO</th>
           <th>DESCRIPCIÓN DE PRODUCTO</th>
           <th>MARCA</th>
           <th>MODELO</th>
           <th>DESC.</th>
           <th><?php echo $impuesto; ?></th>
           <th>PRECIO VENTA</th>
           <th>EXISTENCIA</th>
           <th>PREVENTA</th>
           <th>MONTO TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {

$PrecioTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$PagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$PrecioTotal+=$reg[$i]['precioventa'];
$ExisteTotal+=$reg[$i]['tipodetalle'] == '1' ? $reg[$i]['existencia'] : "0";
$VendidosTotal+=$reg[$i]['cantidad']; 

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
$PagoTotal+=$PrecioFinal*$reg[$i]['cantidad']; 
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['tipodetalle'] == 1 ? "PRODUCTO" : "SERVICIO"; ?></td>
          <td><?php echo $reg[$i]['producto']; ?></td>
          <td><?php echo $reg[$i]["codmarca"] == '0' ? "*****" : $reg[$i]['nommarca']; ?></td>
          <td><?php echo $reg[$i]["codmodelo"] == '0' ? "*****" : $reg[$i]['nommodelo']; ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo $reg[$i]['tipodetalle'] == '1' ? $reg[$i]['existencia'] : "******"; ?></td>
          <td><?php echo $reg[$i]['cantidad']; ?></td>
          <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
           <td colspan="7"></td>
<td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $ExisteTotal; ?></strong></td>
<td><strong><?php echo $VendidosTotal; ?></strong></td>
<td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
         </tr>
</table>
<?php
break;
############################### MODULO DE PREVENTAS ###############################

















############################### MODULO DE CAJAS ###############################
case 'CAJAS':

$tra = new Login();
$reg = $tra->ListarCajas(); 

if ($_SESSION['acceso'] == "administradorG") {
$archivo = str_replace(" ", "_","LISTADO DE CAJAS ASIGNADAS");
} else {
$archivo = str_replace(" ", "_","LISTADO DE CAJAS ASIGNADAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE CAJA</th>
           <th>NOMBRE DE CAJA</th>
           <th>RESPONSABLE</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nrocaja']; ?></td>
           <td><?php echo $reg[$i]['nomcaja']; ?></td>
           <td><?php echo $reg[$i]['dni'].": ".$reg[$i]['nombres']; ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td><strong><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></strong></td><?php } ?>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'ARQUEOS':

$tra = new Login();
$reg = $tra->ListarArqueoCaja(); 

if ($_SESSION['acceso'] == "administradorG") {
$archivo = str_replace(" ", "_","LISTADO DE ARQUEOS DE CAJAS");
} else {
$archivo = str_replace(" ", "_","LISTADO DE ARQUEOS DE CAJAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE CAJA</th>
<?php if ($documento == "EXCEL") { ?>
           <th>RESPONSABLE</th>
           <th>APERTURA</th>
           <th>CIERRE</th>
           <th>OBSERVACIONES</th>
<?php } ?>
           <th>INICIAL</th>
           <th>INGRESOS</th>
           <th>EGRESOS</th>
           <th>CRÉDITOS</th>
           <th>ABONOS</th>
           <th>TOTAL VENTAS</th>
           <th>TOTAL INGRESOS</th>
           <th>DINERO EFECTIVO</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['dni'].": ".$reg[$i]['nombres']; ?></td>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaapertura'])); ?></td>
           <td><?php echo $reg[$i]['fechacierre'] == '0000-00-00 00:00:00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechacierre'])); ?></td>
           <td><?php echo $reg[$i]['comentarios'] == '' ? "*********" : $reg[$i]['comentarios']; ?></td>
<?php } ?>
            <td><?php echo $simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['ingresos'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['egresos'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['creditos'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['abonos'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['ingresos']+$reg[$i]['creditos'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['montoinicial']+$reg[$i]['ingresos']+$reg[$i]['abonos']-$reg[$i]['egresos'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['dineroefectivo'], 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td><strong><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></strong></td><?php } ?>
         </tr>
        <?php } } ?>
</table>
<?php
break;


case 'MOVIMIENTOS':

$tra = new Login();
$reg = $tra->ListarMovimientos(); 

if ($_SESSION['acceso'] == "administradorG") {
$archivo = str_replace(" ", "_","LISTADO DE MOVIMIENTOS DE CAJAS");
} else {
$archivo = str_replace(" ", "_","LISTADO DE MOVIMIENTOS DE CAJAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE CAJA</th>
           <th>RESPONSABLE</th>
           <th>DESCRIPCIÓN</th>
           <th>TIPO</th>
           <th>MONTO</th>
           <th>MEDIO</th>
           <th>FECHA MOVIMIENTO</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
           <td><?php echo $reg[$i]['dni'].": ".$reg[$i]['nombres']; ?></td>
           <td><?php echo $reg[$i]['descripcionmovimiento']; ?></td>
           <td><?php echo $reg[$i]['tipomovimiento']; ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ','); ?></td>
           <td><?php echo $reg[$i]['mediopago']; ?></td>
           <td><?php echo $reg[$i]['fechamovimiento']; ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td><strong><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></strong></td><?php } ?>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'ARQUEOSXFECHAS':

$tra = new Login();
$reg = $tra->BuscarArqueosxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE ARQUEOS EN (CAJA ".$reg[0]['nrocaja'].": ".$reg[0]['nomcaja']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL Nº: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE CAJA</th>
<?php if ($documento == "EXCEL") { ?>
           <th>RESPONSABLE</th>
           <th>APERTURA</th>
           <th>CIERRE</th>
           <th>OBSERVACIONES</th>
<?php } ?>
           <th>INICIAL</th>
           <th>INGRESOS</th>
           <th>EGRESOS</th>
           <th>CRÉDITOS</th>
           <th>ABONOS</th>
           <th>TOTAL VENTAS</th>
           <th>TOTAL INGRESOS</th>
           <th>DINERO EFECTIVO</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['dni'].": ".$reg[$i]['nombres']; ?></td>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaapertura'])); ?></td>
           <td><?php echo $reg[$i]['fechacierre'] == '0000-00-00 00:00:00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechacierre'])); ?></td>
           <td><?php echo $reg[$i]['comentarios'] == '' ? "*********" : $reg[$i]['comentarios']; ?></td>
<?php } ?>
            <td><?php echo $simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['ingresos'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['egresos'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['creditos'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['abonos'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['ingresos']+$reg[$i]['creditos'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['montoinicial']+$reg[$i]['ingresos']+$reg[$i]['abonos']-$reg[$i]['egresos'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['dineroefectivo'], 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'MOVIMIENTOSXFECHAS':

$tra = new Login();
$reg = $tra->BuscarMovimientosxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE MOVIMIENTOS EN (CAJA ".$reg[0]['nrocaja'].": ".$reg[0]['nomcaja']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL Nº: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>RESPONSABLE</th>
           <th>DESCRIPCIÓN</th>
           <th>TIPO</th>
           <th>MONTO</th>
           <th>MEDIO</th>
           <th>FECHA MOVIMIENTO</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['dni'].": ".$reg[$i]['nombres']; ?></td>
           <td><?php echo $reg[$i]['descripcionmovimiento']; ?></td>
           <td><?php echo $reg[$i]['tipomovimiento']; ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ','); ?></td>
           <td><?php echo $reg[$i]['mediopago']; ?></td>
           <td><?php echo $reg[$i]['fechamovimiento']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;
############################### MODULO DE CAJAS ###############################


















############################### MODULO DE VENTAS ###############################
case 'VENTAS':

$tra = new Login();
$reg = $tra->ListarVentas(); 

if ($_SESSION['acceso'] == "administradorG") {
$archivo = str_replace(" ", "_","LISTADO DE VENTAS");
} else {
$archivo = str_replace(" ", "_","LISTADO DE VENTAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE VENTA</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <th>TIPO DE PAGO</th>
           <th>NOTA CRÉDITO</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>FECHA DE EMISIÓN</th>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codfactura']; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
           <td><?php echo $reg[$i]['tipopago']; ?></td>
           <td><?php echo $reg[$i]['notacredito'] == 1 ? "SI" : "NO"; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo $reg[$i]["statusventa"]; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo $reg[$i]["statusventa"]; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "VENCIDA"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo $reg[$i]["statusventa"]; } ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
      
      <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

          <?php } ?>
           
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
           <td><?php echo $reg[$i]['articulos']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td><strong><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></strong></td><?php } ?>
         </tr>
        <?php } ?>
         <tr>
           <?php echo $documento == "EXCEL" ? '<td colspan="10"></td>' : '<td colspan="6"></td>'; ?>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
           <?php if ($documento == "EXCEL") { ?>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
           <?php } ?>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>

<?php if ($_SESSION['acceso'] == "administradorG") { ?><td></td><?php } ?>
<?php } ?>
         </tr>
</table>
<?php
break;

case 'VENTASXCAJAS':

$tra = new Login();
$reg = $tra->BuscarVentasxCajas(); 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS EN (CAJA Nº: ".$reg[0]["nrocaja"].": ".$reg[0]["nomcaja"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE VENTA</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <th>TIPO DE PAGO</th>
           <th>NOTA CRÉDITO</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>FECHA DE EMISIÓN</th>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codfactura']; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
           <td><?php echo $reg[$i]['tipopago']; ?></td>
           <td><?php echo $reg[$i]['notacredito'] == 1 ? "SI" : "NO"; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo $reg[$i]["statusventa"]; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo $reg[$i]["statusventa"]; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "VENCIDA"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo $reg[$i]["statusventa"]; } ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
      
      <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
           
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
           <td><?php echo $reg[$i]['articulos']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
           <?php echo $documento == "EXCEL" ? '<td colspan="10"></td>' : '<td colspan="6"></td>'; ?>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
           <?php if ($documento == "EXCEL") { ?>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
           <?php } ?>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
         </tr>
</table>
<?php
break;

case 'VENTASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarVentasxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE VENTA</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <th>TIPO DE PAGO</th>
           <th>NOTA CRÉDITO</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>FECHA DE EMISIÓN</th>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codfactura']; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
           <td><?php echo $reg[$i]['tipopago']; ?></td>
           <td><?php echo $reg[$i]['notacredito'] == 1 ? "SI" : "NO"; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo $reg[$i]["statusventa"]; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo $reg[$i]["statusventa"]; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "VENCIDA"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo $reg[$i]["statusventa"]; } ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
      
      <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
           
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
           <td><?php echo $reg[$i]['articulos']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
           <?php echo $documento == "EXCEL" ? '<td colspan="10"></td>' : '<td colspan="6"></td>'; ?>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
           <?php if ($documento == "EXCEL") { ?>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
           <?php } ?>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
         </tr>
</table>
<?php
break;


case 'VENTASXCLIENTES':

$tra = new Login();
$reg = $tra->BuscarVentasxClientes(); 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS (CLIENTE: ".$reg[0]["dnicliente"].": ".$reg[0]["nomcliente"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE VENTA</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <th>TIPO DE PAGO</th>
           <th>NOTA CRÉDITO</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>FECHA DE EMISIÓN</th>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codfactura']; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
           <td><?php echo $reg[$i]['tipopago']; ?></td>
           <td><?php echo $reg[$i]['notacredito'] == 1 ? "SI" : "NO"; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo $reg[$i]["statusventa"]; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo $reg[$i]["statusventa"]; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "VENCIDA"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo $reg[$i]["statusventa"]; } ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
      
      <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
           
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
           <td><?php echo $reg[$i]['articulos']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
           <?php echo $documento == "EXCEL" ? '<td colspan="10"></td>' : '<td colspan="6"></td>'; ?>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
           <?php if ($documento == "EXCEL") { ?>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
           <?php } ?>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
         </tr>
</table>
<?php
break;


case 'COMISIONXVENTAS':

$tra = new Login();
$reg = $tra->BuscarComisionxVentas(); 

$archivo = str_replace(" ", "_","LISTADO DE COMISIÓN EN VENTAS DEL VENDEDOR (Nº: ".$reg[0]["dni"].": ".$reg[0]["nombres"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE VENTA</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <th>TIPO DE PAGO</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>FECHA DE EMISIÓN</th>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
           <th>TOTAL COMISIÓN</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;
$TotalComision=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
$comision = number_format($reg[0]['comision']/100, 3, '.', ',');
$TotalComision+=number_format($reg[$i]['totalpago']*$comision, 3, '.', ',');
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codfactura']; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
           <td><?php echo $reg[$i]['tipopago']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo $reg[$i]["statusventa"]; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo $reg[$i]["statusventa"]; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "VENCIDA"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo $reg[$i]["statusventa"]; } ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
      
      <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
           
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
           <td><?php echo $reg[$i]['articulos']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago']*$reg[0]['comision']/100, 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
           <?php echo $documento == "EXCEL" ? '<td colspan="9"></td>' : '<td colspan="5"></td>'; ?>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
           <?php if ($documento == "EXCEL") { ?>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
           <?php } ?>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalComision, 2, '.', ','); ?></strong></td>
         </tr>
</table>
<?php
break;


case 'DETALLESVENTASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarDetallesVentasxFechas(); 

$archivo = str_replace(" ", "_","DETALLES DE VENTAS POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>TIPO</th>
           <th>DESCRIPCIÓN</th>
           <th>MARCA</th>
           <th>MODELO</th>
           <th>DESC.</th>
           <th><?php echo $impuesto; ?></th>
           <th>PRECIO VENTA</th>
           <th>EXISTENCIA</th>
           <th>VENDIDO</th>
           <th>MONTO TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {

$PrecioTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$PagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$PrecioTotal+=$reg[$i]['precioventa'];
$ExisteTotal+=$reg[$i]['tipodetalle'] == '1' ? $reg[$i]['existencia'] : "0";
$VendidosTotal+=$reg[$i]['cantidad']; 

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
$PagoTotal+=$PrecioFinal*$reg[$i]['cantidad'];
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['tipodetalle'] == 1 ? "PRODUCTO" : "SERVICIO"; ?></td>
          <td><?php echo $reg[$i]['producto']; ?></td>
          <td><?php echo $reg[$i]['codmarca'] == '0' ? "*****" : $reg[$i]['nommarca']; ?></td>
          <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']; ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo $reg[$i]['tipodetalle'] == '1' ? $reg[$i]['existencia'] : "******"; ?></td>
          <td><?php echo $reg[$i]['cantidad']; ?></td>
          <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
           <td colspan="7"></td>
<td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $ExisteTotal; ?></strong></td>
<td><strong><?php echo $VendidosTotal; ?></strong></td>
<td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
         </tr>
</table>
<?php
break;

case 'DETALLESVENTASXVENDEDOR':

$tra = new Login();
$reg = $tra->BuscarDetallesVentasxVendedor(); 

$archivo = str_replace(" ", "_","DETALLES DE VENTAS DEL VENDEDOR (".$reg[0]['dni'].": ".$reg[0]['nombres']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>TIPO</th>
           <th>DESCRIPCIÓN DE PRODUCTO</th>
           <th>MARCA</th>
           <th>MODELO</th>
           <th>DESC.</th>
           <th><?php echo $impuesto; ?></th>
           <th>PRECIO VENTA</th>
           <th>EXISTENCIA</th>
           <th>VENDIDO</th>
           <th>MONTO TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {

$PrecioTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$PagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$PrecioTotal+=$reg[$i]['precioventa'];
$ExisteTotal+=$reg[$i]['tipodetalle'] == '1' ? $reg[$i]['existencia'] : "0";
$VendidosTotal+=$reg[$i]['cantidad']; 

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
$PagoTotal+=$PrecioFinal*$reg[$i]['cantidad']; 
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['tipodetalle'] == 1 ? "PRODUCTO" : "SERVICIO"; ?></td>
          <td><?php echo $reg[$i]['producto']; ?></td>
          <td><?php echo $reg[$i]["codmarca"] == '0' ? "*****" : $reg[$i]['nommarca']; ?></td>
          <td><?php echo $reg[$i]["codmodelo"] == '0' ? "*****" : $reg[$i]['nommodelo']; ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo $reg[$i]['tipodetalle'] == '1' ? $reg[$i]['existencia'] : "******"; ?></td>
          <td><?php echo $reg[$i]['cantidad']; ?></td>
          <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
           <td colspan="7"></td>
<td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $ExisteTotal; ?></strong></td>
<td><strong><?php echo $VendidosTotal; ?></strong></td>
<td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
         </tr>
</table>
<?php
break;
############################### MODULO DE VENTAS ###############################























############################### MODULO DE CREDITOS ###############################
case 'CREDITOS':

$tra = new Login();
$reg = $tra->ListarCreditos(); 

if ($_SESSION['acceso'] == "administradorG") {
$archivo = str_replace(" ", "_","LISTADO DE CREDITOS");
} else {
$archivo = str_replace(" ", "_","LISTADO DE CREDITOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE VENTA</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <th>OBSERVACIONES</th>
           <th>FECHA DE EMISIÓN</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
           <th>TOTAL ABONO</th>
           <th>TOTAL DEBE</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalImporte+=$reg[$i]['totalpago'];
$TotalAbono+=$reg[$i]['creditopagado'];
$TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['creditopagado'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codfactura']; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
           <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>

           <?php if ($documento == "EXCEL") { ?>
           <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo $reg[$i]["statusventa"]; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo $reg[$i]["statusventa"]; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "VENCIDA"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo $reg[$i]["statusventa"]; } ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
      
      <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
        <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
        <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
        <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
           
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td><strong><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></strong></td><?php } ?>
         </tr>
        <?php } ?>
         <tr>
          <td colspan="5"></td>
          <?php if ($documento == "EXCEL") { ?>
          <td colspan="4"></td>
          <?php } ?>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td></td><?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'CREDITOSXCLIENTES':

$tra = new Login();
$reg = $tra->BuscarCreditosxClientes(); 

$archivo = str_replace(" ", "_","LISTADO DE CREDITOS DEL (CLIENTE: ".$reg[0]["dnicliente"].": ".$reg[0]["nomcliente"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE VENTA</th>
           <th>OBSERVACIONES</th>
           <th>FECHA DE EMISIÓN</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
           <th>TOTAL ABONO</th>
           <th>TOTAL DEBE</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalImporte+=$reg[$i]['totalpago'];
$TotalAbono+=$reg[$i]['creditopagado'];
$TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['creditopagado'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codfactura']; ?></td>
           <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>

           <?php if ($documento == "EXCEL") { ?>
           <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo $reg[$i]["statusventa"]; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo $reg[$i]["statusventa"]; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "VENCIDA"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo $reg[$i]["statusventa"]; } ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
      
      <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
           
         </tr>
        <?php } } ?>
         <tr>
          <td colspan="4"></td>
          <?php if ($documento == "EXCEL") { ?>
           <td colspan="4"></td> 
          <?php } ?> 
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
         </tr>
</table>
<?php
break;

case 'CREDITOSXFECHAS':

$tra = new Login();
$reg = $tra->BuscarCreditosxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE CREDITOS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE VENTA</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <th>OBSERVACIONES</th>
           <th>FECHA DE EMISIÓN</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
           <th>TOTAL ABONO</th>
           <th>TOTAL DEBE</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 

$TotalImporte+=$reg[$i]['totalpago'];
$TotalAbono+=$reg[$i]['creditopagado'];
$TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['creditopagado'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codfactura']; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
           <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>

           <?php if ($documento == "EXCEL") { ?>
           <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo $reg[$i]["statusventa"]; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo $reg[$i]["statusventa"]; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "VENCIDA"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo $reg[$i]["statusventa"]; } ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
      
      <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
           
         </tr>
        <?php } } ?>
         <tr>
          <td colspan="4"></td>
          <?php if ($documento == "EXCEL") { ?>
          <td colspan="4"></td>
          <?php } ?>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
         </tr>
</table>
<?php
break;

case 'CREDITOSXDETALLES':

$tra = new Login();
$reg = $tra->BuscarCreditosxDetalles(); 

$archivo = str_replace(" ", "_","LISTADO DE CREDITOS DEL CLIENTE (".$reg[0]["dnicliente"].": ".$reg[0]["nomcliente"]."DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE VENTA</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <th>OBSERVACIONES</th>
           <th>DETALLES DE PRODUCTOS</th>
           <th>FECHA DE EMISIÓN</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
           <th>TOTAL ABONO</th>
           <th>TOTAL DEBE</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalImporte+=$reg[$i]['totalpago'];
$TotalAbono+=$reg[$i]['creditopagado'];
$TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['creditopagado'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codfactura']; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
           <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
           <td><?php echo $reg[$i]['detalles']; ?></td>
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>

           <?php if ($documento == "EXCEL") { ?>
           <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo $reg[$i]["statusventa"]; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo $reg[$i]["statusventa"]; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "VENCIDA"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo $reg[$i]["statusventa"]; } ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
      
      <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
        <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
        <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
        <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
           
         </tr>
        <?php } } ?>
         <tr>
          <td colspan="6"></td>
          <?php if ($documento == "EXCEL") { ?>
           <td colspan="4"></td> 
          <?php } ?>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
        </tr>
</table>
<?php
break;
############################### MODULO DE CREDITOS ###############################














############################### MODULO DE CREDITOS ###############################
case 'NOTASCREDITO':

$tra = new Login();
$reg = $tra->ListarNotasCreditos(); 

if ($_SESSION['acceso'] == "administradorG") {
$archivo = str_replace(" ", "_","LISTADO DE NOTAS DE CREDITO");
} else {
$archivo = str_replace(" ", "_","LISTADO DE NOTAS DE CREDITO EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE NOTA</th>
           <th>Nº DE DOCUMENTO</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <th>Nº DE ARTICULOS</th>
           <th>FECHA DE EMISIÓN</th>
           <th>MOTIVO DE NOTA</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codfactura']; ?></td>
           <td><?php echo $reg[$i]['tipodocumento']." Nº: ".$reg[$i]['facturaventa']; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '' || $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
           <td><?php echo $reg[$i]['articulos']; ?></td>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechanota'])); ?></td>
           <td><?php echo $reg[$i]['observaciones']; ?></td>

           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td><strong><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></strong></td><?php } ?>
         </tr>
        <?php } ?>
         <tr>
           <?php echo $documento == "EXCEL" ? '<td colspan="7"></td>' : '<td colspan="7"></td>'; ?>
           <?php if ($documento == "EXCEL") { ?>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
           <?php } ?>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td></td><?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'NOTASCREDITOXCAJAS':

$tra = new Login();
$reg = $tra->BuscarNotasxCajas(); 

$archivo = str_replace(" ", "_","LISTADO DE NOTAS DE CRÉDITO EN (CAJA Nº: ".$reg[0]["nrocaja"].": ".$reg[0]["nomcaja"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE NOTA</th>
           <th>Nº DE DOCUMENTO</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <th>Nº DE ARTICULOS</th>
           <th>FECHA DE EMISIÓN</th>
           <th>MOTIVO DE NOTA</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codfactura']; ?></td>
           <td><?php echo $reg[$i]['tipodocumento']." Nº: ".$reg[$i]['facturaventa']; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '' || $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
           <td><?php echo $reg[$i]['articulos']; ?></td>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechanota'])); ?></td>
           <td><?php echo $reg[$i]['observaciones']; ?></td>

           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr>
           <?php echo $documento == "EXCEL" ? '<td colspan="7"></td>' : '<td colspan="4"></td>'; ?>
           <?php if ($documento == "EXCEL") { ?>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
           <?php } ?>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'NOTASCREDITOXFECHAS':

$tra = new Login();
$reg = $tra->BuscarNotasxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE NOTAS DE CRÉDITO (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE NOTA</th>
           <th>Nº DE DOCUMENTO</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <th>Nº DE ARTICULOS</th>
           <th>FECHA DE EMISIÓN</th>
           <th>MOTIVO DE NOTA</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codfactura']; ?></td>
           <td><?php echo $reg[$i]['tipodocumento']." Nº: ".$reg[$i]['facturaventa']; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '' || $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
           <td><?php echo $reg[$i]['articulos']; ?></td>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechanota'])); ?></td>
           <td><?php echo $reg[$i]['observaciones']; ?></td>

           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr>
           <?php echo $documento == "EXCEL" ? '<td colspan="7"></td>' : '<td colspan="4"></td>'; ?>
           <?php if ($documento == "EXCEL") { ?>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
           <?php } ?>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'NOTASCREDITOXCLIENTE':

$tra = new Login();
$reg = $tra->BuscarNotasxClientes(); 

$archivo = str_replace(" ", "_","LISTADO DE NOTAS DE CRÉDITO DEL (CLIENTE: ".$reg[0]["dnicliente"].": ".$reg[0]["nomcliente"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE NOTA</th>
           <th>Nº DE DOCUMENTO</th>
           <th>Nº DE ARTICULOS</th>
           <th>FECHA DE EMISIÓN</th>
           <th>MOTIVO DE NOTA</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codfactura']; ?></td>
           <td><?php echo $reg[$i]['tipodocumento']." Nº: ".$reg[$i]['facturaventa']; ?></td>
           <td><?php echo $reg[$i]['articulos']; ?></td>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechanota'])); ?></td>
           <td><?php echo $reg[$i]['observaciones']; ?></td>

           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr>
           <?php echo $documento == "EXCEL" ? '<td colspan="6"></td>' : '<td colspan="6"></td>'; ?>
           <?php if ($documento == "EXCEL") { ?>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
           <?php } ?>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
         </tr>
        <?php } ?>
</table>
<?php
break;
############################### MODULO DE CREDITOS ###############################

}
 
?>


<?php } else { ?> 
    <script type='text/javascript' language='javascript'>
      alert('NO TIENES PERMISO PARA ACCEDER A ESTA PAGINA.\nCONSULTA CON EL ADMINISTRADOR PARA QUE TE DE ACCESO')  
    document.location.href='panel'   
        </script> 
<?php } } else { ?>
    <script type='text/javascript' language='javascript'>
      alert('NO TIENES PERMISO PARA ACCEDER AL SISTEMA.\nDEBERA DE INICIAR SESION')  
    document.location.href='logout'  
        </script> 
<?php } ?>  