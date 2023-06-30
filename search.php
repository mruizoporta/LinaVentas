<?php
require_once("class/class.php");
if (isset($_SESSION['acceso'])) {
  if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero" || $_SESSION["acceso"]=="vendedor") {

$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = ($imp == "" ? "Impuesto" : $imp[0]['nomimpuesto']);
$valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);
    
$tra = new Login();
?>


<?php
############################# CARGAR LOGS DE USUARIOS ############################
if (isset($_GET['CargaLogs'])) { 
?>

<div id="div2"><div class="table-responsive" data-pattern="priority-columns">
      <table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Ip de Máquina</th>
                                                    <th>Fecha</th>
                                                    <th>Navegador</th>
                                                    <th>Usuario</th>
  <?php if($_SESSION['acceso']=="administradorG"){ ?><th>Sucursal</th><?php } ?>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->BusquedaLogs();

if($reg==""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON REGISTROS DE ACCESO ACTUALMENTE</center>";
  echo "</div>";
  exit;    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['ip']; ?></td>
                                               <td><?php echo $reg[$i]['tiempo']; ?></td>
                                               <td><?php echo $reg[$i]['detalles']; ?></td>
                                               <td><?php echo $reg[$i]['usuario']; ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td><?php echo $reg[$i]['codsucursal'] == 0 ? "**********" : $reg[$i]['cuitsucursal'].": <strong>".$reg[$i]['nomsucursal']."</strong>"; ?></td><?php } ?>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div></div>
 <?php
   } 
############################# CARGAR LOGS DE USUARIOS ############################
?>





<?php
############################# CARGAR CLIENTES ############################
if (isset($_GET['CargaClientes']) && isset($_GET['bclientes'])) {

$criterio = limpiar($_GET['bclientes']); 
?>

<div id="div2"><div class="table-responsive" data-pattern="priority-columns">
      <table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nº Documento</th>
                                                    <th>Nombres/Razón Social</th>
                                                    <th>Giro Cliente</th>
                                                    <th>Correo Electrónico</th>
                                                    <th>Nº de Teléfono</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 

if($criterio==""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE VALOR PARA TU CRITERIO DE BÚSQUEDA </center>";
  echo "</div>";
  exit;    

} else {

$reg = $tra->BusquedaClientes();
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
<td><?php echo "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento'])." ".$reg[$i]['dnicliente']; ?></td>
    <td><?php echo $cliente = ($reg[$i]['tipocliente'] == 'JURIDICO' ? $reg[$i]['razoncliente'] : $reg[$i]['nomcliente']); ?></td>
    <td><?php echo $cliente = ($reg[$i]['tipocliente'] == 'JURIDICO' ? $reg[$i]['girocliente'] : '**********'); ?></td>
           <td><?php echo $reg[$i]['emailcliente'] == '' ? "*********" : $reg[$i]['emailcliente']; ?></td>
           <td><?php echo $reg[$i]['tlfcliente'] == '' ? "*********" : $reg[$i]['tlfcliente']; ?></td>
                                               <td>
<button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerCliente('<?php echo encrypt($reg[$i]["codcliente"]); ?>')"><i class="fa fa-eye"></i></button>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCliente" data-backdrop="static" data-keyboard="false" onClick="UpdateCliente('<?php echo $reg[$i]["codcliente"]; ?>','<?php echo $reg[$i]["tipocliente"]; ?>','<?php echo $reg[$i]["documcliente"]; ?>','<?php echo $reg[$i]["dnicliente"]; ?>','<?php echo $reg[$i]["nomcliente"]; ?>','<?php echo $reg[$i]["razoncliente"]; ?>','<?php echo $reg[$i]["girocliente"]; ?>','<?php echo $reg[$i]["tlfcliente"]; ?>','<?php echo $reg[$i]["id_provincia"]; ?>','<?php echo $reg[$i]["direccliente"]; ?>','<?php echo $reg[$i]["emailcliente"]; ?>','<?php echo number_format($reg[$i]["limitecredito"], 2, '.', ''); ?>','<?php echo $criterio; ?>','update'); SelectDepartamento('<?php echo $reg[$i]["id_provincia"]; ?>','<?php echo $reg[$i]["id_departamento"]; ?>'); CargaTipoCliente('<?php echo $reg[$i]["tipocliente"]; ?>');"><i class="fa fa-edit"></i></button>

<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarCliente('<?php echo encrypt($reg[$i]["codcliente"]); ?>','<?php echo $criterio; ?>','<?php echo encrypt("CLIENTES") ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div></div>
 <?php
   } 
############################# CARGAR CLIENTES ############################
?>






<?php
############################# CARGAR COMPRAS ############################
if (isset($_GET['CargaCompras']) && isset($_GET['bcompras'])) {

$criterio = limpiar($_GET['bcompras']); 
?>
<div id="div2"><div class="table-responsive" data-pattern="priority-columns">
      <table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>N° de Compra</th>
                                                    <th>Descripción de Proveedor</th>
                                                    <th>Nº Artic</th>
                                                    <th>Subtotal</th>
                                                    <th><?php echo $impuesto; ?></th>
                                                    <th>Dcto %</th>
                                                    <th>Imp. Total</th>
                                                    <th>Fecha Emisión</th>
  <?php if($_SESSION['acceso']=="administradorG"){ ?><th>Sucursal</th><?php } ?>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 

if($criterio==""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE VALOR PARA TU CRITERIO DE BÚSQUEDA </center>";
  echo "</div>"; 
  exit;   

} else {

$reg = $tra->BusquedaCompras();
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codcompra']; ?></td>
<td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']; ?>"><?php echo $reg[$i]['nomproveedor']; ?></abbr></td>
      <td><?php echo $reg[$i]['articulos']; ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totalivac'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['ivac'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuentoc'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
                    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
  <?php if($_SESSION['acceso']=="administradorG"){ ?><td><?php echo $reg[$i]['codsucursal'] == 0 ? "**********" : $reg[$i]['cuitsucursal'].": <strong>".$reg[$i]['nomsucursal']."</strong>"; ?></td><?php } ?>
                                               <td>
<button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target=".bs-example-modal-lg" data-backdrop="static" data-keyboard="false" onClick="VerCompraPagada('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if($_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="secretaria"){ ?>

<button type="button" class="btn btn-info btn-rounded" onClick="UpdateCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("U"); ?>','<?php echo encrypt("P"); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codproveedor"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo "P"; ?>','<?php echo $criterio; ?>','<?php echo encrypt("COMPRAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> 

<?php } ?>

<a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
                                              </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div></div>
 <?php
   } 
############################# CARGAR COMPRAS ############################
?>





<?php
############################# CARGAR CUENTAS POR PAGAR ############################
if (isset($_GET['CargaCuentasxPagar']) && isset($_GET['bcompras'])) {

$criterio = limpiar($_GET['bcompras']);  
?>

<div id="div2"><div class="table-responsive" data-pattern="priority-columns">
      <table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>N° de Compra</th>
                                                    <th>Descripción de Proveedor</th>
                                                    <th>Imp. Total</th>
                                                    <th>Abono</th>
                                                    <th>Debe</th>
                                                    <th>Status</th>
  <?php if($_SESSION['acceso']=="administradorG"){ ?><th>Sucursal</th><?php } ?>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 

if($criterio==""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE VALOR PARA TU CRITERIO DE BÚSQUEDA </center>";
  echo "</div>";
  exit;    

} else {

$reg = $tra->BusquedaCuentasxPagar();
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codcompra']; ?></td>
<td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']; ?>"><?php echo $reg[$i]['nomproveedor']; ?></abbr></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['abonototal'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc']-$reg[$i]['abonototal'], 2, '.', ','); ?></td>
<td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-success'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA</span>"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } ?></td>

  <?php if($_SESSION['acceso']=="administradorG"){ ?><td><?php echo $reg[$i]['codsucursal'] == 0 ? "**********" : $reg[$i]['cuitsucursal'].": <strong>".$reg[$i]['nomsucursal']."</strong>"; ?></td><?php } ?>
                                               <td>
<button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target=".bs-example-modal-lg" data-backdrop="static" data-keyboard="false" onClick="VerCompraPendiente('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if ($_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria") { ?>

<button type="button" class="btn btn-info btn-rounded" onClick="UpdateCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("U"); ?>','<?php echo "D"; ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

<button type="button" class="btn btn-info btn-rounded waves-effect waves-light" data-placement="left" title="Abonar" data-original-title="" data-href="#" data-toggle="modal" data-target="#ModalAbonosCompra" data-backdrop="static" data-keyboard="false" onClick="AbonoCreditoCompra('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt($reg[$i]["codproveedor"]); ?>',
'<?php echo $reg[$i]["codcompra"]; ?>',
'<?php echo number_format($reg[$i]['totalpagoc']-$reg[$i]['abonototal'], 2, '.', ''); ?>',
'<?php echo $reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3'].": ".$reg[$i]["cuitproveedor"]; ?>',
'<?php echo $reg[$i]["nomproveedor"]; ?>',
'<?php echo $reg[$i]["codcompra"]; ?>',
'<?php echo number_format($reg[$i]["totalpagoc"], 2, '.', ''); ?>',
'<?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?>',
'<?php echo number_format($total = ( $reg[$i]['abonototal'] == '' ? "0.00" : $reg[$i]['abonototal']), 2, '.', ''); ?>',
'<?php echo number_format($reg[$i]['totalpagoc']-$reg[$i]['abonototal'], 2, '.', ''); ?>','<?php echo $criterio; ?>')"><i class="fa fa-credit-card"></i></button>

<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codproveedor"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("D") ?>','<?php echo $criterio; ?>','<?php echo encrypt("COMPRAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> 

<?php } ?>

<a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCOMPRA"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-warning text-white" title="Imprimir Pdf"><i class="fa fa-folder-open-o"></i></button></a>

<a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn  btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
                                              </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div></div>
 <?php
   } 
############################# CARGAR CUENTAS POR PAGAR ############################
?>











<?php
############################# CARGAR COTIZACIONES ############################
if (isset($_GET['CargaCotizaciones']) && isset($_GET['bcotizaciones'])) {

$criterio = limpiar($_GET['bcotizaciones']); 
?>
<div id="div2"><div class="table-responsive" data-pattern="priority-columns">
      <table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>N° de Cotización</th>
                                                    <th>Descripción de Cliente</th>
                                                    <th>Nº Artic</th>
                                                    <th>Subtotal</th>
                                                    <th><?php echo $impuesto; ?></th>
                                                    <th>Dcto %</th>
                                                    <th>Imp. Total</th>
                                                    <th>Fecha Emisión</th>
  <?php if($_SESSION['acceso']=="administradorG"){ ?><th>Sucursal</th><?php } ?>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 

if($criterio==""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE VALOR PARA TU CRITERIO DE BÚSQUEDA </center>";
  echo "</div>";
  exit;    

} else {

$reg = $tra->BusquedaCotizaciones();
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codfactura']; ?></td>
<td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td> 
      <td><?php echo $reg[$i]['articulos']; ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
                    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechacotizacion'])); ?></td>
  <?php if($_SESSION['acceso']=="administradorG"){ ?><td><?php echo $reg[$i]['codsucursal'] == 0 ? "**********" : $reg[$i]['cuitsucursal'].": <strong>".$reg[$i]['nomsucursal']."</strong>"; ?></td><?php } ?>
                                               <td>
<button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target=".bs-example-modal-lg" data-backdrop="static" data-keyboard="false" onClick="VerCotizacion('<?php echo encrypt($reg[$i]["codcotizacion"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if($_SESSION['acceso']=="administradorS" || $_SESSION['acceso']=="secretaria" || $_SESSION["acceso"]=="cajero"){ ?>

  <button type="button" class="btn btn-danger btn-rounded" data-placement="left" title="Procesar a Venta" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="ProcesaCotizacion('<?php echo encrypt($reg[$i]["codcotizacion"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo $reg[$i]["codcliente"]; ?>','<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?>','<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?>','<?php echo number_format($reg[$i]["limitecredito"], 2, '.', ''); ?>','<?php echo number_format($reg[$i]["totalpago"], 2, '.', ''); ?>','<?php echo $criterio; ?>')"><i class="fa fa-folder-open-o"></i></button>

<?php } ?>

<?php if($_SESSION['acceso']=="administradorS"){ ?>

<button type="button" class="btn btn-info btn-rounded" onClick="UpdateCotizacion('<?php echo encrypt($reg[$i]["codcotizacion"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("U"); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

<button type="button" class="btn btn-warning btn-rounded" onClick="AgregaDetalleCotizacion('<?php echo encrypt($reg[$i]["codcotizacion"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("A"); ?>')" title="Agregar Detalle" ><i class="text-white fa fa-tasks"></i></button>

<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarCotizacion('<?php echo encrypt($reg[$i]["codcotizacion"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo $criterio; ?>','<?php echo encrypt("COTIZACIONES") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> 

<?php } ?>

<a href="reportepdf?codcotizacion=<?php echo encrypt($reg[$i]['codcotizacion']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOTIZACION") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
                                              </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                          </table></div></div>
 <?php
   } 
############################# CARGAR COTIZACIONES ############################
?>







<?php
############################# CARGAR VENTAS ############################
if (isset($_GET['CargaVentas'])&& isset($_GET['bventas'])) {

$criterio = limpiar($_GET['bventas']); 
?>
<div id="div2"><div class="table-responsive" data-pattern="priority-columns">
      <table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>N° de Venta</th>
                                                    <th>Vendedor</th>
                                                    <th>Descripción de Cliente</th>
                                                    <th>Subtotal</th>
                                                    <th><?php echo $impuesto; ?></th>
                                                    <th>Dcto %</th>
                                                    <th>Imp. Total</th>
                                                    <th>Nota Crédito</th>
                                                    <th>Status</th>
                                                    <th>Fecha Emisión</th>
  <?php if($_SESSION['acceso']=="administradorG"){ ?><th>Sucursal</th><?php } ?>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php

if($criterio==""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE VALOR PARA TU CRITERIO DE BÚSQUEDA </center>";
  echo "</div>";
  exit;    

} else {

$reg = $tra->BusquedaVentas();
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
<td><abbr title="CAJA: <?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?>"><?php echo $reg[$i]['codfactura']; ?></abbr></td>
<td><abbr title="<?php echo "Nº DE DNI: ".$reg[$i]['dni']; ?>"><?php echo $reg[$i]['nombres']; ?></abbr></td> 
<td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td> 
      <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
      <td><abbr title="Nº DE ARTICULOS: <?php echo $reg[$i]['articulos']; ?>"><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></abbr></td>
  <td><?php echo $reg[$i]['notacredito'] == 1 ? "<span class='badge badge-pill badge-danger'><i class='fa fa-exclamation-circle'></i> SI</span>" : "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> NO</span>"; ?></td>
      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-success'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA</span>"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
                    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
  <?php if($_SESSION['acceso']=="administradorG"){ ?><td><?php echo $reg[$i]['codsucursal'] == 0 ? "**********" : $reg[$i]['cuitsucursal'].": <strong>".$reg[$i]['nomsucursal']."</strong>"; ?></td><?php } ?>
                                               <td>
<button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target=".bs-example-modal-lg" data-backdrop="static" data-keyboard="false" onClick="VerVenta('<?php echo encrypt($reg[$i]["codventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if($_SESSION['acceso']=="administradorS"){ ?>

<button type="button" class="btn btn-info btn-rounded" onClick="UpdateVenta('<?php echo encrypt($reg[$i]["codventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("U"); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

<button type="button" class="btn btn-warning btn-rounded" onClick="AgregaDetalleVenta('<?php echo encrypt($reg[$i]["codventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("A"); ?>')" title="Agregar Detalle" ><i class="text-white fa fa-tasks"></i></button>

<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarVenta('<?php echo encrypt($reg[$i]["codventa"]); ?>','<?php echo encrypt($reg[$i]["codcliente"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo $criterio; ?>','<?php echo encrypt("VENTAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> 

<?php } ?>

<a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
                                              </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div></div>
 <?php
   } 
############################# CARGAR VENTAS ############################
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