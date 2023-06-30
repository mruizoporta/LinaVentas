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
############################# CARGAR USUARIOS ############################
if (isset($_GET['CargaUsuarios'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>N° de Documento</th>
                                                    <th>Nombres y Apellidos</th>
                                                    <th>Nº de Teléfono</th>
                                                    <th>Usuario</th>
                                                    <th>Nivel</th>
                                                    <th>Status</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>Sucursal</th><?php } ?>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarUsuarios();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON USUARIOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['dni']; ?></td>
                                               <td><?php echo $reg[$i]['nombres']; ?></td>
                                               <td><?php echo $reg[$i]['telefono']; ?></td>
                                               <td><?php echo $reg[$i]['usuario']; ?></td>
                                               <td><?php echo $reg[$i]['nivel']; ?></td>
<td><?php echo $status = ( $reg[$i]['status'] == 1 ? "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-pill badge-dark'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td class="text-dark alert-link"><?php echo $reg[$i]['codsucursal'] == 0 ? "**********" : $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></td><?php } ?>
                                               <td>

<button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerUsuario('<?php echo encrypt($reg[$i]["codigo"]); ?>')"><i class="fa fa-eye"></i></button>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalUser" data-backdrop="static" data-keyboard="false" onClick="UpdateUsuario('<?php echo $reg[$i]["codigo"]; ?>','<?php echo $reg[$i]["dni"]; ?>','<?php echo $reg[$i]["nombres"]; ?>','<?php echo $reg[$i]["sexo"]; ?>','<?php echo $reg[$i]["direccion"]; ?>','<?php echo $reg[$i]["telefono"]; ?>','<?php echo $reg[$i]["email"]; ?>','<?php echo $reg[$i]["usuario"]; ?>','<?php echo $reg[$i]["nivel"]; ?>','<?php echo $reg[$i]["status"]; ?>','<?php echo number_format($reg[$i]["comision"], 2, '.', ''); ?>','<?php echo $reg[$i]["codsucursal"] == '' ? encrypt("0") : encrypt($reg[$i]["codsucursal"]); ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarUsuario('<?php echo encrypt($reg[$i]["codigo"]); ?>','<?php echo encrypt($reg[$i]["dni"]); ?>','<?php echo encrypt("USUARIOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR USUARIOS ############################
?>


<?php
############################# CARGAR LOGS DE USUARIOS ############################
if (isset($_GET['CargaLogs'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Ip de Máquina</th>
                                                    <th>Fecha</th>
                                                    <th>Navegador</th>
                                                    <th>Usuario</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarLogs();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON REGISTROS DE ACCESO ACTUALMENTE</center>";
    echo "</div>";    

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
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR LOGS DE USUARIOS ############################
?>


<?php
############################# CARGAR PROVINCIAS ############################
if (isset($_GET['CargaProvincias'])) { 
?>

<div class="table-responsive"><table id="datatable" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Paises</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarProvincias();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PAISES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['provincia']; ?></td>
                                               <td>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateProvincia('<?php echo $reg[$i]["id_provincia"]; ?>','<?php echo $reg[$i]["provincia"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarProvincia('<?php echo encrypt($reg[$i]["id_provincia"]); ?>','<?php echo encrypt("PROVINCIAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR PROVINCIAS ############################
?>


<?php
############################# CARGAR DEPARTAMENTOS ############################
if (isset($_GET['CargaDepartamentos'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Paises</th>
                                                    <th>Departamento</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarDepartamentos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON DEPARTAMENTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['provincia']; ?></td>
                                               <td><?php echo $reg[$i]['departamento']; ?></td>
                                               <td>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateDepartamento('<?php echo $reg[$i]["id_departamento"]; ?>','<?php echo $reg[$i]["departamento"]; ?>','<?php echo $reg[$i]["id_provincia"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarDepartamento('<?php echo encrypt($reg[$i]["id_departamento"]); ?>','<?php echo encrypt("DEPARTAMENTOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR DEPARTAMENTOS ############################
?>


<?php
############################# CARGAR TIPOS DE DOCUMENTOS ############################
if (isset($_GET['CargaDocumentos'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombre</th>
                                                    <th>Descripción de Documento</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarDocumentos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TIPOS DE DOCUMENTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['documento']; ?></td>
                                               <td><?php echo $reg[$i]['descripcion']; ?></td>
                                               <td>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateDocumento('<?php echo $reg[$i]["coddocumento"]; ?>','<?php echo $reg[$i]["documento"]; ?>','<?php echo $reg[$i]["descripcion"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarDocumento('<?php echo encrypt($reg[$i]["coddocumento"]); ?>','<?php echo encrypt("DOCUMENTOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR TIPOS DE DOCUMENTOS ############################
?>


<?php
############################# CARGAR TIPOS DE MONEDA ############################
if (isset($_GET['CargaMonedas'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombre de Moneda</th>
                                                    <th>Siglas</th>
                                                    <th>Simbolo</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarTipoMoneda();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TIPOS DE MONEDAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['moneda']; ?></td>
                                               <td><?php echo $reg[$i]['siglas']; ?></td>
                                               <td><?php echo $reg[$i]['simbolo']; ?></td>
                                               <td>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateTipoMoneda('<?php echo $reg[$i]["codmoneda"]; ?>','<?php echo $reg[$i]["moneda"]; ?>','<?php echo $reg[$i]["siglas"]; ?>','<?php echo $reg[$i]["simbolo"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarTipoMoneda('<?php echo encrypt($reg[$i]["codmoneda"]); ?>','<?php echo encrypt("TIPOMONEDA") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR TIPOS DE MONEDA ############################
?>


<?php
############################# CARGAR TIPOS DE CAMBIO ############################
if (isset($_GET['CargaCambios'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Descripción de Cambio</th>
                                                    <th>Monto de Cambio</th>
                                                    <th>Tipo Moneda</th>
                                                    <th>Fecha Ingreso</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarTipoCambio();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TIPOS DE CAMBIO DE MONEDA ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['descripcioncambio']; ?></td>
                                               <td><?php echo number_format($reg[$i]['montocambio'], 2, '.', ','); ?></td>
  <td><abbr title="<?php echo "Siglas: ".$reg[$i]['siglas']; ?>"><?php echo $reg[$i]['moneda']; ?></abbr></td>
                    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechacambio'])); ?></td>
                    <td>
<?php if(date("d-m-Y",strtotime($reg[$i]['fechacambio'])) == date("d-m-Y")) { ?>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateTipoCambio('<?php echo $reg[$i]["codcambio"]; ?>','<?php echo $reg[$i]["descripcioncambio"]; ?>','<?php echo number_format($reg[$i]["montocambio"], 2, '.', ''); ?>','<?php echo $reg[$i]["codmoneda"]; ?>','<?php echo date("Y-m-d",strtotime($reg[$i]['fechacambio'])); ?>','update')"><i class="fa fa-edit"></i></button>

<?php } ?>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarTipoCambio('<?php echo encrypt($reg[$i]["codcambio"]); ?>','<?php echo encrypt("TIPOCAMBIO") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR TIPOS DE CAMBIO ############################
?>


<?php
############################# CARGAR MEDIOS DE PAGOS ############################
if (isset($_GET['CargaMediosPagos'])) { 
?>

<div class="table-responsive"><table id="datatable" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Medio de Pago</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarMediosPagos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON MEDIOS DE PAGOS PARA VENTAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['mediopago']; ?></td>
                                               <td>
<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateMedio('<?php echo $reg[$i]["codmediopago"]; ?>','<?php echo $reg[$i]["mediopago"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarMedio('<?php echo encrypt($reg[$i]["codmediopago"]); ?>','<?php echo encrypt("MEDIOSPAGOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR MEDIOS DE PAGOS ############################
?>


<?php
############################# CARGAR IMPUESTOS ############################
if (isset($_GET['CargaImpuestos'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombre de Impuesto</th>
                                                    <th>Valor (%)</th>
                                                    <th>Status</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarImpuestos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON IMPUESTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['nomimpuesto']; ?></td>
                                               <td><?php echo number_format($reg[$i]['valorimpuesto'], 2, '.', ','); ?></td>
<td><?php echo $status = ( $reg[$i]['statusimpuesto'] == 'ACTIVO' ? "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]['statusimpuesto']."</span>" : "<span class='badge badge-pill badge-dark'><i class='fa fa-times'></i> ".$reg[$i]['statusimpuesto']."</span>"); ?></td>
                                               <td>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateImpuesto('<?php echo $reg[$i]["codimpuesto"]; ?>','<?php echo $reg[$i]["nomimpuesto"]; ?>','<?php echo number_format($reg[$i]["valorimpuesto"], 2, '.', ''); ?>','<?php echo $reg[$i]["statusimpuesto"]; ?>','<?php echo date("d-m-Y",strtotime($reg[$i]['fechaimpuesto'])); ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarImpuesto('<?php echo encrypt($reg[$i]["codimpuesto"]); ?>','<?php echo encrypt("IMPUESTOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>

       
 <?php 
   } 
############################# CARGAR IMPUESTOS ############################
?>


<?php
############################# CARGAR SUCURSALES ############################
if (isset($_GET['CargaSucursales'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Logo</th>
                                                    <th>N° de Documento</th>
                                                    <th>Razón Social</th>
                                                    <th>Nº de Teléfono</th>
                                                    <th>Email</th>
                                                    <th>Encargado</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarSucursales();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON SUCURSALES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
<td><?php if (file_exists("fotos/sucursales/".$reg[$i]["cuitsucursal"].".png")){
    echo "<img src='fotos/sucursales/".$reg[$i]["cuitsucursal"].".png?' class='img-rounded' style='margin:0px;' width='50' height='40'>";
       }else{
    echo "<img src='fotos/img.png' class='img-rounded' style='margin:0px;' width='50' height='40'>";  
    } ?>
  </a></td>
                                               <td><?php echo $reg[$i]['cuitsucursal']; ?></td>
                                               <td class="text-dark alert-link"><?php echo $reg[$i]['nomsucursal']; ?></td>
                                               <td><?php echo $reg[$i]['tlfsucursal']; ?></td>
                                               <td><?php echo $reg[$i]['correosucursal']; ?></td>
                                               <td><?php echo $reg[$i]['nomencargado']; ?></td>
                                               <td>
<button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerSucursal('<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalSucursal" data-backdrop="static" data-keyboard="false" onClick="UpdateSucursal('<?php echo $reg[$i]["codsucursal"]; ?>','<?php echo $reg[$i]["documsucursal"]; ?>','<?php echo $reg[$i]["cuitsucursal"]; ?>','<?php echo $reg[$i]["nomsucursal"]; ?>','<?php echo $reg[$i]["id_provincia"]; ?>','<?php echo $reg[$i]["direcsucursal"]; ?>','<?php echo $reg[$i]["correosucursal"]; ?>','<?php echo $reg[$i]["tlfsucursal"]; ?>','<?php echo $reg[$i]["inicioticket"]; ?>','<?php echo $reg[$i]["iniciofactura"]; ?>','<?php echo $reg[$i]["inicioguia"]; ?>','<?php echo $reg[$i]["inicionotaventa"]; ?>','<?php echo $reg[$i]["inicionotacredito"]; ?>','<?php echo $reg[$i]["nroactividadsucursal"]; ?>','<?php echo $reg[$i]["fechaautorsucursal"]; ?>','<?php echo $reg[$i]["llevacontabilidad"]; ?>','<?php echo $reg[$i]["documencargado"]; ?>','<?php echo $reg[$i]["dniencargado"]; ?>','<?php echo $reg[$i]["nomencargado"]; ?>','<?php echo $reg[$i]["tlfencargado"]; ?>','<?php echo number_format($reg[$i]["descsucursal"], 2, '.', ''); ?>','<?php echo number_format($reg[$i]["porcentaje"], 2, '.', ''); ?>','<?php echo $reg[$i]["codmoneda"]; ?>','<?php echo $reg[$i]["codmoneda2"]; ?>','update'); SelectProvincia('<?php echo $reg[$i]["id_departamento"]; ?>','<?php echo $reg[$i]["id_provincia"]; ?>')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarSucursal('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("SUCURSALES") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR SUCURSALES ############################
?>


<?php
############################# CARGAR FAMILIAS ############################
if (isset($_GET['CargaFamilias'])) { 
?>

<div class="table-responsive"><table id="datatable" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Familias</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarFamilias();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON FAMILIAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['nomfamilia']; ?></td>
                                               <td>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateFamilia('<?php echo $reg[$i]["codfamilia"]; ?>','<?php echo $reg[$i]["nomfamilia"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarFamilia('<?php echo encrypt($reg[$i]["codfamilia"]); ?>','<?php echo encrypt("FAMILIAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR FAMILIAS ############################
?>


<?php
############################# CARGAR SUBFAMILIAS ############################
if (isset($_GET['CargaSubfamilias'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Subfamilias</th>
                                                    <th>Familias</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarSubfamilias();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON SUBFAMILIAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['nomsubfamilia']; ?></td>
                                               <td><?php echo $reg[$i]['nomfamilia']; ?></td>
                                               <td>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateSubfamilia('<?php echo $reg[$i]["codsubfamilia"]; ?>','<?php echo $reg[$i]["nomsubfamilia"]; ?>','<?php echo $reg[$i]["codfamilia"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarSubfamilia('<?php echo encrypt($reg[$i]["codsubfamilia"]); ?>','<?php echo encrypt("SUBFAMILIAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR SUBFAMILIAS ############################
?>


<?php
############################# CARGAR MARCAS ############################
if (isset($_GET['CargaMarcas'])) { 
?>

<div class="table-responsive"><table id="datatable" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Marcas</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarMarcas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON MARCAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['nommarca']; ?></td>
                                               <td>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateMarca('<?php echo $reg[$i]["codmarca"]; ?>','<?php echo $reg[$i]["nommarca"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarMarca('<?php echo encrypt($reg[$i]["codmarca"]); ?>','<?php echo encrypt("MARCAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR MARCAS ############################
?>


<?php
############################# CARGAR MODELOS ############################
if (isset($_GET['CargaModelos'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Modelos</th>
                                                    <th>Marcas</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarModelos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON MARCAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['nommodelo']; ?></td>
                                               <td><?php echo $reg[$i]['nommarca']; ?></td>
                                               <td>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateModelo('<?php echo $reg[$i]["codmodelo"]; ?>','<?php echo $reg[$i]["nommodelo"]; ?>','<?php echo $reg[$i]["codmarca"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarModelo('<?php echo encrypt($reg[$i]["codmodelo"]); ?>','<?php echo encrypt("MODELOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR MODELOS ############################
?>


<?php
############################# CARGAR PRESENTACIONES ############################
if (isset($_GET['CargaPresentaciones'])) { 
?>

<div class="table-responsive"><table id="datatable" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Presentaciones</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarPresentaciones();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PRESENTACIONES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['nompresentacion']; ?></td>
                                               <td>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdatePresentacion('<?php echo $reg[$i]["codpresentacion"]; ?>','<?php echo $reg[$i]["nompresentacion"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarPresentacion('<?php echo encrypt($reg[$i]["codpresentacion"]); ?>','<?php echo encrypt("PRESENTACIONES") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR PRESENTACIONES ############################
?>


<?php
############################# CARGAR COLORES ############################
if (isset($_GET['CargaColores'])) { 
?>

<div class="table-responsive"><table id="datatable" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Colores</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarColores();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COLORES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['nomcolor']; ?></td>
                                               <td>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateColor('<?php echo $reg[$i]["codcolor"]; ?>','<?php echo $reg[$i]["nomcolor"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarColor('<?php echo encrypt($reg[$i]["codcolor"]); ?>','<?php echo encrypt("COLORES") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR COLORES ############################
?>


<?php
############################# CARGAR ORIGENES ############################
if (isset($_GET['CargaOrigenes'])) { 
?>

<div class="table-responsive"><table id="datatable" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Origenes</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarOrigenes();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON ORIGENES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['nomorigen']; ?></td>
                                               <td>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateOrigen('<?php echo $reg[$i]["codorigen"]; ?>','<?php echo $reg[$i]["nomorigen"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarOrigen('<?php echo encrypt($reg[$i]["codorigen"]); ?>','<?php echo encrypt("ORIGENES") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR ORIGENES ############################
?>


<?php
############################# CARGAR PROVEEDORES ############################
if (isset($_GET['CargaProveedores'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nº Documento</th>
                                                    <th>Nombres de Proveedor</th>
                                                    <th>Correo Electrónico</th>
                                                    <th>Nº de Teléfono</th>
                                                    <th>Vendedor</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarProveedores();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PROVEEDORES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
            <td><?php echo "Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento'])." ".$reg[$i]['cuitproveedor']; ?></td>
            <td><?php echo $reg[$i]['nomproveedor']; ?></td>
           <td><?php echo $reg[$i]['emailproveedor'] == '' ? "*********" : $reg[$i]['emailproveedor']; ?></td>
           <td><?php echo $reg[$i]['tlfproveedor'] == '' ? "*********" : $reg[$i]['tlfproveedor']; ?></td>
           <td><?php echo $reg[$i]['vendedor'] == '' ? "*********" : $reg[$i]['vendedor']; ?></td>
                                               <td>
<button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerProveedor('<?php echo encrypt($reg[$i]["codproveedor"]); ?>')"><i class="fa fa-eye"></i></button>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalProveedor" data-backdrop="static" data-keyboard="false" onClick="UpdateProveedor('<?php echo $reg[$i]["codproveedor"]; ?>','<?php echo $reg[$i]["documproveedor"]; ?>','<?php echo $reg[$i]["cuitproveedor"]; ?>','<?php echo $reg[$i]["nomproveedor"]; ?>','<?php echo $reg[$i]["tlfproveedor"]; ?>','<?php echo $reg[$i]["id_provincia"]; ?>','<?php echo $reg[$i]["direcproveedor"]; ?>','<?php echo $reg[$i]["emailproveedor"]; ?>','<?php echo $reg[$i]["vendedor"]; ?>','<?php echo $reg[$i]["tlfvendedor"]; ?>','update'); SelectProvincia('<?php echo $reg[$i]["id_departamento"]; ?>','<?php echo $reg[$i]["id_provincia"]; ?>')"><i class="fa fa-edit"></i></button>

<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarProveedor('<?php echo encrypt($reg[$i]["codproveedor"]); ?>','<?php echo encrypt("PROVEEDORES") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR PROVEEDORES ############################
?>


<?php
############################# CARGAR PEDIDOS ############################
if (isset($_GET['CargaPedidos'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>N° de Pedido</th>
                                                    <th>Descripción de Proveedor</th>
                                                    <th>Nº de Articulos</th>
                                                    <th>Fecha Emisión</th>
  <?php if($_SESSION['acceso']=="administradorG"){ ?><th>Sucursal</th><?php } ?>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarPedidos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PEDIDOS DE PRODUCTOS A PROVEEDORES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codfactura']; ?></td>
<td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']; ?>"><?php echo $reg[$i]['nomproveedor']; ?></abbr></td>
                    <td><?php echo $reg[$i]['articulos']; ?></td>
                    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechapedido'])); ?></td>
  <?php if($_SESSION['acceso']=="administradorG"){ ?><td class="text-dark alert-link"><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></td><?php } ?>
                                               <td>
<button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target=".bs-example-modal-lg" data-backdrop="static" data-keyboard="false" onClick="VerPedido('<?php echo encrypt($reg[$i]["codpedido"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

<button type="button" class="btn btn-info btn-rounded" onClick="UpdatePedido('<?php echo encrypt($reg[$i]["codpedido"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("U"); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

<button type="button" class="btn btn-warning btn-rounded" onClick="AgregaDetallePedido('<?php echo encrypt($reg[$i]["codpedido"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("A"); ?>')" title="Agregar Detalle" ><i class="text-white fa fa-tasks"></i></button>

<?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") { ?>
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarPedido('<?php echo encrypt($reg[$i]["codpedido"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("PEDIDOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> 
<?php } ?>

<a href="reportepdf?codpedido=<?php echo encrypt($reg[$i]['codpedido']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURAPEDIDO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
                                         </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR PEDIDOS ############################
?>


<?php
############################# CARGAR PRODUCTOS ############################
if (isset($_GET['CargaProductos'])) { 

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Foto</th>
                                                    <th>Nombre de Producto</th>
                                                    <th>Stock</th>
                                                    <th>Fecha Venc.</th>
                                                    <th>Fecha Elab.</th>
                                                    <th>Marca</th>
                                                    <th>Modelo</th>
                                                    <th>P. Menor</th>
                                                    <th>P. Mayor</th>
                                                    <th>P. Público</th>
                                                    <th><?php echo $impuesto; ?> </th>
                                                    <th>Descto</th>
<?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="secretaria"){ ?><th>Acciones</th><?php } else { ?><th><i class="mdi mdi-drag-horizontal"></i></th><?php } ?>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarProductos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PRODUCTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$monedaxmenor = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioxmenor'] / $reg[$i]['montocambio'], 2, '.', ','));
$monedaxmayor = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioxmayor'] / $reg[$i]['montocambio'], 2, '.', ','));
$monedaxpublico = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioxpublico'] / $reg[$i]['montocambio'], 2, '.', ',')); 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$simbolo2 = ($reg[$i]['simbolo2'] == "" ? "" : $reg[$i]['simbolo2']); 
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
  <td><?php if (file_exists("fotos/productos/".$reg[$i]["codproducto"].".jpg")){ ?>
  <img src="fotos/productos/<?php echo $reg[$i]["codproducto"]; ?>.jpg?" class="rounded-circle" style="margin:0px;" width="80" height="70" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
  <?php } else { ?>
  <img src="fotos/producto.png" class="rounded-circle" style="margin:0px;" width="80" height="70">
  <?php } ?>
  </td>
  <td><abbr title="CÓDIGO: <?php echo $reg[$i]['codproducto']; ?>"><?php echo $reg[$i]['producto']; ?></abbr></td>

  <td><abbr title="<?php if($reg[$i]['existencia'] <= $reg[$i]['stockoptimo'] && $reg[$i]['existencia'] > $reg[$i]['stockmedio']){ echo "STOCK OPTIMO"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockmedio'] && $reg[$i]['existencia'] > $reg[$i]['stockminimo']){ echo "STOCK MEDIO"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockminimo']){ echo "STOCK MINIMO"; } else { echo ""; } ?>">
    <?php if($reg[$i]['existencia'] <= $reg[$i]['stockoptimo'] && $reg[$i]['existencia'] > $reg[$i]['stockmedio']){ echo "<span class='badge badge-pill badge-success'>".$reg[$i]['existencia']."</span>"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockmedio'] && $reg[$i]['existencia'] > $reg[$i]['stockminimo']){ echo "<span class='badge badge-pill badge-warning'>".$reg[$i]['existencia']."</span>"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockminimo']){ echo "<span class='badge badge-pill badge-danger'>".$reg[$i]['existencia']."</span>"; } else { echo $reg[$i]['existencia']; } ?>
    </abbr></td>

  <td><abbr title="<?php if($reg[$i]['fechaoptimo'] != "0000-00-00" && date("Y-m-d") <= $reg[$i]['fechaoptimo'] && date("Y-m-d") > $reg[$i]['fechamedio']){ echo "FECHA OPTIMA"; } elseif($reg[$i]['fechamedio'] != "0000-00-00" && date("Y-m-d") <= $reg[$i]['fechamedio'] && date("Y-m-d") > $reg[$i]['fechaminimo']){ echo "FECHA MEDIO"; } elseif($reg[$i]['fechaminimo'] != "0000-00-00" && date("Y-m-d") <= $reg[$i]['fechaminimo']){ echo "FECHA MINIMO"; } else { echo ""; } ?>">
  	<?php 
  	if($reg[$i]['fechaoptimo'] != "0000-00-00" && date("Y-m-d") <= $reg[$i]['fechaoptimo'] && date("Y-m-d") > $reg[$i]['fechamedio']){ echo "<span class='badge badge-pill badge-danger'>".date("d-m-Y",strtotime($reg[$i]['fechaoptimo']))."</span>"; } 
  	elseif($reg[$i]['fechamedio'] != "0000-00-00" && date("Y-m-d") <= $reg[$i]['fechamedio'] && date("Y-m-d") > $reg[$i]['fechaminimo']){ echo "<span class='badge badge-pill badge-warning'>".date("d-m-Y",strtotime($reg[$i]['fechamedio']))."</span>"; }
  	elseif($reg[$i]['fechaminimo'] != "0000-00-00" && date("Y-m-d") <= $reg[$i]['fechaminimo']){ echo "<span class='badge badge-pill badge-success'>".date("d-m-Y",strtotime($reg[$i]['fechaminimo']))."</span>"; } 
  	else { echo "*****"; } ?>
  	</abbr></td>
    
    <td><?php echo $reg[$i]['fechaelaboracion'] == '' || $reg[$i]['fechaelaboracion'] == '0000-00-00' ? "*****" : "<span class='badge badge-pill badge-success'>".date("d-m-Y",strtotime($reg[$i]['fechaelaboracion']))."</span>"; ?></td>

                      <td><?php echo $reg[$i]['nommarca']; ?></td>
                      <td><?php echo $reg[$i]['nommodelo'] == '' ? "*****" : $reg[$i]['nommodelo']; ?></td>

                    <td><abbr title="<?php echo $simbolo2.$monedaxmenor; ?>"><?php echo $simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ','); ?></abbr></td>

                    <td><abbr title="<?php echo $simbolo2.$monedaxmayor; ?>"><?php echo $simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ','); ?></abbr></td>

                    <td><abbr title="<?php echo $simbolo2.$monedaxpublico; ?>"><?php echo $simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','); ?></abbr></td>
                    
                    <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
                    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
                    <td>

<button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="secretaria"){ ?>

<button type="button" class="btn btn-info btn-rounded" onClick="UpdateProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("PRODUCTOS") ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button>

<?php } ?>

</td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR PRODUCTOS ############################
?>







<?php
############################# CARGAR KARDEX VALORIZADO PRODUCTOS ############################
if (isset($_GET['CargaKardexValorizado'])) { 

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Img</th>
                                                    <th>Nombre de Producto</th>
                                                    <th>Marca</th>
                                                    <th>Modelo</th>
                                                    <th>Precio Público</th>
                                                    <th>Existencia</th>
                                                    <th><?php echo $impuesto; ?></th>
                                                    <th>Descto</th>
                                                    <th>Total Venta</th>
                                                    <th>Total Compra</th>
                                                    <th>Ganancias</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarKardexValorizado();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PRODUCTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$precioTotal=0;
$existeTotal=0;
$pagoTotal=0;
$compraTotal=0;
$TotalGanancia=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$precioTotal+=$reg[$i]['precioxpublico'];
$existeTotal+=$reg[$i]['existencia'];
$pagoTotal+=$reg[$i]['precioxpublico']*$reg[$i]['existencia']-$reg[$i]['descproducto']/100;
$compraTotal+=$reg[$i]['preciocompra']*$reg[$i]['existencia'];

$sumventa = $reg[$i]['precioxpublico']*$reg[$i]['existencia']-$reg[$i]['descproducto']/100; 
$sumcompra = $reg[$i]['preciocompra']*$reg[$i]['existencia'];

$TotalGanancia+=$sumventa-$sumcompra;
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
<td><?php
$directory='fotos/productos/';

if (is_dir($directory)) {
$dirint = dir($directory);
    while (($archivo = $dirint->read()) !== false) {
              
    if ($archivo != "." && $archivo != ".." && substr_count($archivo , ".jpg")==1 || substr_count($archivo , ".JPG")==1 ){
    
    echo '<a href="'.$directory."/".$archivo.'" class="image-zoom" rel="prettyPhoto[pp_gallery'.$reg[$i]["codproducto"].']" title="Producto N° #'.$reg[$i]["codproducto"].'">';
       }
    } $dirint->close(); 
  } else { } ?>
     <?php if (file_exists("fotos/productos/".$reg[$i]["codproducto"].".jpg")){
    echo "<img src='fotos/productos/".$reg[$i]["codproducto"].".jpg?' class='img-rounded' style='margin:0px;' width='50' height='40'>";
       }else{
    echo "<img src='fotos/producto.png' class='img-rounded' style='margin:0px;' width='50' height='40'>";  
    } ?>
  </a></td>
  <td><abbr title="CÓDIGO: <?php echo $reg[$i]['codproducto']; ?>"><?php echo $reg[$i]['producto']; ?></abbr></td>
                    <td><?php echo $reg[$i]['nommarca']; ?></td>
                    <td><?php echo $reg[$i]['nommodelo'] == '' ? "*****" : $reg[$i]['nommodelo']; ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','); ?></td>
                    <td><?php echo $reg[$i]['existencia']; ?></td>
                    <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
                    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['precioxpublico']*$reg[$i]['existencia']-$reg[$i]['descproducto']/100, 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['existencia'], 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($sumventa-$sumcompra, 2, '.', ','); ?></td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR KARDEX VALORIZADO PRODUCTOS ############################
?>









<?php
############################# CARGAR TRASPASOS ############################
if (isset($_GET['CargaTraspasos'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>N° de Traspaso</th>
                                                    <th>Sucursal Envia</th>
                                                    <th>Sucursal Recibe</th>
                                                    <th>Nº Artículos</th>
                                                    <th>Observaciones</th>
                                                    <th>Fecha Emisión</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarTraspasos();

if($reg==""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TRASPASOS DE PRODUCTOS ACTUALMENTE </center>";
  echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");  
?>
                      <tr role="row" class="odd">
  <td><?php echo $a++; ?></td>
  <td><?php echo $reg[$i]['codfactura']; ?></td>
  <td><?php echo $reg[$i]['cuitsucursal'].": <strong>".$reg[$i]['nomsucursal']."</strong>: ".$reg[$i]['nomencargado']; ?></td>
  <td><?php echo $reg[$i]['cuitsucursal2'].": <strong>".$reg[$i]['nomsucursal2']."</strong>: ".$reg[$i]['nomencargado2']; ?></td>
  <td><?php echo $reg[$i]['articulos']; ?></td>
  <td><?php echo $reg[$i]['observaciones'] == "" ? "**********" : $reg[$i]['observaciones']; ?></td>
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechatraspaso'])); ?></td>
                                               <td>
<button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target=".bs-example-modal-lg" data-backdrop="static" data-keyboard="false" onClick="VerTraspaso('<?php echo encrypt($reg[$i]["codtraspaso"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if($_SESSION['acceso']=="administradorS" || $_SESSION['acceso']=="secretaria"){ ?>

<button type="button" class="btn btn-info btn-rounded" onClick="UpdateTraspaso('<?php echo encrypt($reg[$i]["codtraspaso"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("U"); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

<button type="button" class="btn btn-warning btn-rounded" onClick="AgregaDetalleTraspaso('<?php echo encrypt($reg[$i]["codtraspaso"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("A"); ?>')" title="Agregar Detalle" ><i class="text-white fa fa-tasks"></i></button>

<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarTraspaso('<?php echo encrypt($reg[$i]["codtraspaso"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("TRASPASOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> 

<?php } ?>

<a href="reportepdf?codtraspaso=<?php echo encrypt($reg[$i]['codtraspaso']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURATRASPASO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
                                              </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                          </table></div>
 <?php
   } 
############################# CARGAR TRASPASOS ############################
?>




<?php
############################# CARGAR PREVENTAS ############################
if (isset($_GET['CargaPreventas'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>N° de Preventa</th>
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
$reg = $tra->ListarPreventas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PREVENTAS A CLIENTES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
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
                    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechapreventa'])); ?></td>
  <?php if($_SESSION['acceso']=="administradorG"){ ?><td class="text-dark alert-link"><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></td><?php } ?>
                                               <td>
<button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target=".bs-example-modal-lg" data-backdrop="static" data-keyboard="false" onClick="VerPreventa('<?php echo encrypt($reg[$i]["codpreventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if($_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="cajero"){ ?>

<button type="button" class="btn btn-danger btn-rounded" data-placement="left" title="Procesar a Venta" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="ProcesaPreventa('<?php echo encrypt($reg[$i]["codpreventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo $reg[$i]["codcliente"]; ?>','<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?>','<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?>','<?php echo number_format($reg[$i]["limitecredito"], 2, '.', ''); ?>','<?php echo number_format($reg[$i]["totalpago"], 2, '.', ''); ?>')"><i class="fa fa-folder-open-o"></i></button>

<?php } ?>


<?php if($_SESSION['acceso']=="administradorS"){ ?>

<button type="button" class="btn btn-info btn-rounded" onClick="UpdatePreventa('<?php echo encrypt($reg[$i]["codpreventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("U"); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

<button type="button" class="btn btn-warning btn-rounded" onClick="AgregaDetallePreventa('<?php echo encrypt($reg[$i]["codpreventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("A"); ?>')" title="Agregar Detalle" ><i class="text-white fa fa-tasks"></i></button>

<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarPreventa('<?php echo encrypt($reg[$i]["codpreventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("PREVENTAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> 

<?php } ?>

<a href="reportepdf?codpreventa=<?php echo encrypt($reg[$i]['codpreventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETPREVENTA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
                                              </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                          </table></div>
 <?php
   } 
############################# CARGAR PREVENTAS ############################
?>



<?php
############################# CARGAR CAJAS PARA VENTAS ############################
if (isset($_GET['CargaCajas'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>N° de Caja</th>
                                                    <th>Nombre de Caja</th>
                                                    <th>Nº Documento</th>
                                                    <th>Responsable</th>
                                                    <th>Nivel</th>
  <?php if($_SESSION['acceso']=="administradorG"){ ?><th>Sucursal</th><?php } ?>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarCajas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CAJAS PARA VENTAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['nrocaja']; ?></td>
                                               <td><?php echo $reg[$i]['nomcaja']; ?></td>
                                               <td><?php echo $reg[$i]['dni']; ?></td>
                                               <td><?php echo $reg[$i]['nombres']; ?></td>
                                               <td><?php echo $reg[$i]['nivel']; ?></td>
  <?php if($_SESSION['acceso']=="administradorG"){ ?><td class="text-dark alert-link"><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></td><?php } ?>
                                               <td>

<?php if ($_SESSION["acceso"]=="administradorG") { ?>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCaja" data-backdrop="static" data-keyboard="false" onClick="UpdateCaja('<?php echo $reg[$i]["codcaja"]; ?>','<?php echo $reg[$i]["nrocaja"]; ?>','<?php echo $reg[$i]["nomcaja"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo $reg[$i]["codigo"]; ?>','update'); CargaUsuarios('<?php echo encrypt($reg[$i]["codsucursal"]); ?>'); SelectUsuario('<?php echo $reg[$i]["codigo"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>');"><i class="fa fa-edit"></i></button>

<?php } else { ?>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCaja" data-backdrop="static" data-keyboard="false" onClick="UpdateCaja('<?php echo $reg[$i]["codcaja"]; ?>','<?php echo $reg[$i]["nrocaja"]; ?>','<?php echo $reg[$i]["nomcaja"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo $reg[$i]["codigo"]; ?>','update')"><i class="fa fa-edit"></i></button>

<?php } ?>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarCaja('<?php echo encrypt($reg[$i]["codcaja"]); ?>','<?php echo encrypt("CAJAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>

       
 <?php 
   } 
############################# CARGAR CAJAS PARA VENTAS ############################
?>


<?php
########################## CARGAR ARQUEOS DE CAJAS PARA VENTAS ##########################
if (isset($_GET['CargaArqueos'])) { 

?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                <thead>
                                                <tr role="row">
                                                <th>N°</th>
                                                <th>Caja</th>
                                                <th>Responsable</th>
                                                <th>Hora de Apertura</th>
                                                <th>Hora de Cierre</th>
                                                <th>Monto Inicial</th>
                                                <th>Ventas</th>
                                                <th>Ingresos</th>
                                                <th>Efectivo</th>
                                                <th>Diferencia</th>
<?php if($_SESSION['acceso']=="administradorG"){ ?><th>Sucursal</th><?php } ?>
                                                <th>Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarArqueoCaja();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON ARQUEOS DE CAJAS PARA VENTAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");  
?>
                                               <tr role="row" class="odd">
           	<td><?php echo $a++; ?></td>
            <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
            <td><?php echo $reg[$i]['dni'].": ".$reg[$i]['nombres']; ?></td>
            <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaapertura'])); ?></td>
            <td><?php echo $reg[$i]['statusarqueo'] == 1 ? "**********" : date("d-m-Y H:i:s",strtotime($reg[$i]['fechacierre'])); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ','); ?></td>
           	<td><?php echo $simbolo.number_format($reg[$i]['ingresos']+$reg[$i]['creditos'], 2, '.', ','); ?></td>
           	<td><?php echo $simbolo.number_format($reg[$i]['montoinicial']+$reg[$i]['ingresos']+$reg[$i]['abonos']-$reg[$i]['egresos'], 2, '.', ','); ?></td>
           	<td><?php echo $simbolo.number_format($reg[$i]['dineroefectivo'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['diferencia'], 2, '.', ','); ?></td>
  <?php if($_SESSION['acceso']=="administradorG"){ ?><td class="text-dark alert-link"><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></td><?php } ?>
                                               <td>

<button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerArqueo('<?php echo encrypt($reg[$i]["codarqueo"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if($_SESSION["acceso"]!="administradorG" && $reg[$i]["statusarqueo"]=='1'){ ?>

<button type="button" class="btn btn-dark btn-rounded" data-placement="left" title="Cerrar Arqueo" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCerrarCaja" data-backdrop="static" data-keyboard="false" onClick="CerrarArqueo('<?php echo $reg[$i]["codarqueo"]; ?>','<?php echo $reg[$i]["nrocaja"].": ".$reg[$i]["nomcaja"]; ?>','<?php echo $reg[$i]["dni"].": ".$reg[$i]["nombres"]; ?>','<?php echo number_format($reg[$i]["montoinicial"], 2, '.', ''); ?>','<?php echo number_format($reg[$i]["ingresos"], 2, '.', ''); ?>','<?php echo number_format($reg[$i]["egresos"], 2, '.', ''); ?>','<?php echo number_format($reg[$i]["creditos"], 2, '.', ''); ?>','<?php echo number_format($reg[$i]["abonos"], 2, '.', ''); ?>','<?php echo number_format($reg[$i]["montoinicial"]+$reg[$i]["ingresos"]+$reg[$i]["abonos"]-$reg[$i]["egresos"], 2, '.', ''); ?>','<?php echo $reg[$i]["fechaapertura"]; ?>')"><i class="fa fa-archive"></i></i></button>

<?php } else { ?>

<?php if ($_SESSION['acceso'] == "administradorS") { ?>
<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Cerrar Arqueo" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalUpdateArqueo" data-backdrop="static" data-keyboard="false" onClick="UpdateArqueo('<?php echo $reg[$i]["codarqueo"]; ?>','<?php echo $reg[$i]["nrocaja"].": ".$reg[$i]["nomcaja"]; ?>','<?php echo $reg[$i]["dni"].": ".$reg[$i]["nombres"]; ?>','<?php echo number_format($reg[$i]["montoinicial"], 2, '.', ''); ?>','<?php echo number_format($reg[$i]["ingresos"], 2, '.', ''); ?>','<?php echo number_format($reg[$i]["egresos"], 2, '.', ''); ?>','<?php echo number_format($reg[$i]["creditos"], 2, '.', ''); ?>','<?php echo number_format($reg[$i]["abonos"], 2, '.', ''); ?>','<?php echo number_format($reg[$i]["montoinicial"]+$reg[$i]["ingresos"]+$reg[$i]["abonos"]-$reg[$i]["egresos"], 2, '.', ''); ?>','<?php echo number_format($reg[$i]["dineroefectivo"], 2, '.', ''); ?>','<?php echo number_format($reg[$i]["diferencia"], 2, '.', ''); ?>','<?php echo $reg[$i]["comentarios"]; ?>','<?php echo $reg[$i]["fechaapertura"]; ?>','<?php echo $reg[$i]["fechacierre"]; ?>')"><i class="fa fa-edit"></i></i></button>
<?php } ?>

<a href="reportepdf?codarqueo=<?php echo encrypt($reg[$i]['codarqueo']); ?>&tipo=<?php echo encrypt("TICKETCIERRE") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>

<?php } ?></td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>

 <?php
   } 
######################### CARGAR ARQUEOS DE CAJAS PARA VENTAS #########################
?>


<?php
######################## CARGAR MOVIMIENTOS EN CAJAS PARA VENTAS #######################
if (isset($_GET['CargaMovimientos'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                  <th>N°</th>
                                                  <th>Caja</th>
                                                  <th>Responsable</th>
                                                  <th>Tipo</th>
                                                  <th>Descripción</th>
                                                  <th>Monto</th>
                                                  <th>Fecha</th>
<?php if($_SESSION['acceso']=="administradorG"){ ?><th>Sucursal</th><?php } ?>
                                                  <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarMovimientos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON MOVIMIENTOS EN CAJAS PARA VENTAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
                                  <td><?php echo $reg[$i]['nombres']; ?></td>
                                  <td><?php echo $tipo = ( $reg[$i]['tipomovimiento'] == "INGRESO" ? "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> INGRESO</span>" : "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> EGRESO</span>"); ?></td>
                                  <td><?php echo $reg[$i]['descripcionmovimiento']; ?></td>
                                  <td><?php echo $simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ','); ?></td>
                                  <td><?php echo $reg[$i]['fechamovimiento']; ?></td>
<?php if($_SESSION['acceso']=="administradorG"){ ?><td class="text-dark alert-link"><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></td><?php } ?>
                                               <td>
<button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerMovimiento('<?php echo encrypt($reg[$i]["numero"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if ($_SESSION["acceso"]=="administradorS" && $reg[$i]['statusarqueo']=="1") { ?>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalMovimiento" data-backdrop="static" data-keyboard="false" onClick="UpdateMovimiento('<?php echo encrypt($reg[$i]["codmovimiento"]); ?>','<?php echo encrypt($reg[$i]["numero"]); ?>','<?php echo encrypt($reg[$i]["codcaja"]); ?>','<?php echo $reg[$i]["tipomovimiento"]; ?>','<?php echo $reg[$i]["descripcionmovimiento"]; ?>','<?php echo number_format($reg[$i]["montomovimiento"], 2, '.', ''); ?>','<?php echo $reg[$i]["codmediopago"]; ?>','<?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechamovimiento'])); ?>','<?php echo encrypt($reg[$i]["codarqueo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarMovimiento('<?php echo encrypt($reg[$i]["codmovimiento"]); ?>','<?php echo encrypt("MOVIMIENTOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button>

 <a href="reportepdf?numero=<?php echo encrypt($reg[$i]['numero']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETMOVIMIENTO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-warning btn-rounded text-white" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>

<?php } ?> 

</td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
######################## CARGAR MOVIMIENTOS EN CAJAS PARA VENTAS #######################
?>



<?php
############################# CARGAR VENTAS DIARIAS ############################
if (isset($_GET['CargaVentasDiarias'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                   <tr class="text-center">
                                                    <th>Nº</th>
                                                    <th>N° de Venta</th>
                                                    <th>Caja</th>
                                                    <th>Descripción de Cliente</th>
                                                    <th>Nº Artic</th>
                                                    <th>Subtotal</th>
                                                    <th><?php echo $impuesto; ?></th>
                                                    <th>Dcto %</th>
                                                    <th>Imp. Total</th>
                                                    <th>Status</th>
                                                    <th><span class="mdi mdi-drag-horizontal"></span></th>
                                                  </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->BuscarVentasDiarias();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON VENTAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
                                               <tr class="text-center">
                      <td><?php echo $a++; ?></div>
                      <td><?php echo $reg[$i]['codfactura']; ?></td>
                      <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
<td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>
      <td><?php echo $reg[$i]['articulos']; ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
      <td><?php 
if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) { echo "<span class='badge badge-pill badge-success'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; } 
elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA</span>"; } ?></td>
<td>
  <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target=".bs-example-modal-lg" data-backdrop="static" data-keyboard="false" onClick="VerVenta('<?php echo encrypt($reg[$i]["codventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

  <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
</td>
                                </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR VENTAS DIARIAS ############################
?>





<?php
############################# CARGAR CREDITOS ############################
if (isset($_GET['CargaCreditos'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>N° de Venta</th>
                                                    <th>Nº de Documento</th>
                                                    <th>Nombre de Cliente</th>
                                                    <th>Imp. Total</th>
                                                    <th>Abono</th>
                                                    <th>Debe</th>
                                                    <th>Status</th>
                                                    <th>Dias Venc</th>
                                                    <th>Fecha Emisión</th>
                      <?php if($_SESSION['acceso']=="administradorG"){ ?><th>Sucursal</th><?php } ?>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarCreditos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CREDITOS DE VENTAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codfactura']; ?></td>
                    <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?></td>
                    <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></td>

  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
      
  <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-success'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA</span>"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>

<td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
  
  <?php if ($_SESSION["acceso"]=="administradorG") { ?><td class="text-dark alert-link"><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></td><?php }  ?>

                         <td>
<button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerCredito('<?php echo encrypt($reg[$i]["codventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if($_SESSION['acceso']=="administradorS" && $reg[$i]['totalpago'] != $reg[$i]['creditopagado'] || $_SESSION["acceso"]=="secretaria" && $reg[$i]['totalpago'] != $reg[$i]['creditopagado'] || $_SESSION["acceso"]=="cajero" && $reg[$i]['totalpago'] != $reg[$i]['creditopagado']){ ?>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Abonar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalPago" data-backdrop="static" data-keyboard="false" 
onClick="AbonoCreditoVenta1('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo $reg[$i]["codcliente"]; ?>',
'<?php echo encrypt($reg[$i]["codventa"]); ?>',
'<?php echo $reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3'].": ".$reg[$i]["dnicliente"]; ?>',
'<?php echo $reg[$i]["nomcliente"]; ?>',
'<?php echo $reg[$i]["codventa"]; ?>',
'<?php echo number_format($reg[$i]["totalpago"], 2, '.', ''); ?>',
'<?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?>',
'<?php echo number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ''); ?>',
'<?php echo number_format($reg[$i]['creditopagado'], 2, '.', ''); ?>')"><i class="fa fa-credit-card"></i></button>

<?php } ?>

<a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCREDITO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-warning btn-rounded text-white" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>

<a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
                                              </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR CREDITOS ############################
?>







<?php
############################# CARGAR NOTAS DE CREDITO ############################
if (isset($_GET['CargaNotas'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>N° de Nota</th>
                                                    <th>Nº de Documento</th>
                                                    <th>Descripción de Cliente</th>
                                                    <th>Nº Artic</th>
                                                    <th>SubTotal</th>
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
$reg = $tra->ListarNotasCreditos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON NOTAS DE CREDITOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
?>
                    <tr role="row" class="odd">
                    <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codfactura']; ?></td>
                    <td><?php echo $reg[$i]['tipodocumento']." Nº: ".$reg[$i]['facturaventa']; ?></td>
                    <td><?php echo $reg[$i]['codcliente'] == '' || $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></td>
                    <td><?php echo $reg[$i]['articulos']; ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
                    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechanota'])); ?></td>
  <?php if($_SESSION['acceso']=="administradorG"){ ?><td class="text-dark alert-link"><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></td><?php } ?>
                                               <td>
<button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target=".bs-example-modal-lg" data-backdrop="static" data-keyboard="false" onClick="VerNota('<?php echo encrypt($reg[$i]["codnota"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

<a href="reportepdf?codnota=<?php echo encrypt($reg[$i]['codnota']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("NOTACREDITO"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
                                              </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR NOTAS DE CREDITO ############################
?>



<!-- Datatables-->
  <script src="assets/plugins/datatables/dataTables.min.js"></script>
  <script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
  <script src="assets/plugins/datatables/datatable-basic.init.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#datatable').dataTable();
      $('#datatable-responsive').DataTable();
      $('#default_order').dataTable();
    } );
  </script>
        
  <!--Gallery-->
  <script type="text/javascript" src="assets/plugins/gallery/sagallery.js"></script>
  <script src="assets/plugins/gallery/jquery-photo-gallery/jquery-photo-gallery/js/jquery.quicksand.js" type="text/javascript"></script>
  <script src="assets/plugins/gallery/jquery-photo-gallery/jquery-photo-gallery/js/jquery.easing.js" type="text/javascript"></script>
  <script src="assets/plugins/gallery/jquery-photo-gallery/jquery-photo-gallery/js/script.js" type="text/javascript"></script>
  <script src="assets/plugins/gallery/jquery-photo-gallery/jquery-photo-gallery/js/jquery.prettyPhoto.js" type="text/javascript"></script>
  <link href="assets/plugins/gallery/jquery-photo-gallery/jquery-photo-gallery/css/prettyPhoto.css" rel="stylesheet" type="text/css" />
  <!--Gallery-->


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