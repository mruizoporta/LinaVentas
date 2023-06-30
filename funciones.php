<?php
require_once("class/class.php");
?>

<?php
$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = ($imp == "" ? "Impuesto" : $imp[0]['nomimpuesto']);
$valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

$conf = new Login();
$conf = $conf->ConfiguracionPorId();

$new = new Login();
?>


<?php 
######################## BUSCA DEPARTAMENTOS POR PROVINCIAS ########################
if (isset($_GET['BuscaDepartamentos']) && isset($_GET['id_provincia'])) {
  
   $dep = $new->ListarDepartamentoXProvincias();

$id_provincia = limpiar($_GET['id_provincia']);

 if($id_provincia=="") { ?>

  <option value=""> -- SIN RESULTADOS -- </option>
  <?php } else { ?>

    <option value=""> -- SELECCIONE -- </option>
  <?php
   for($i=0;$i<sizeof($dep);$i++){
    ?>
<option style="color:#000;font-weight:bold;" value="<?php echo $dep[$i]['id_departamento']; ?>" ><?php echo $dep[$i]['departamento']; ?></option>
    <?php 
    }
  }
}
######################## BUSCA DEPARTAMENTOS POR PROVINCIAS ########################
?>

<?php 
######################## SELECCIONE DEPARTAMENTOS POR PAISES ########################
if (isset($_GET['SeleccionaDepartamento']) && isset($_GET['id_provincia']) && isset($_GET['id_departamento'])) {
  
   $dep = $new->SeleccionaDepartamento();
  ?>
    </div>
  </div>
  <option value="">SELECCIONE</option>
  <?php for($i=0;$i<sizeof($dep);$i++){ ?>
<option value="<?php echo $dep[$i]['id_departamento']; ?>"<?php if (!(strcmp($_GET['id_departamento'], htmlentities($dep[$i]['id_departamento'])))) {echo "selected=\"selected\"";} ?>><?php echo $dep[$i]['departamento']; ?></option>
<?php
   } 
}
######################## SELECCIONE LOCALIDAD POR CIUDADES ########################
?>

<?php 
######################## BUSCA SUBFAMILIAS POR FAMILIAS ########################
if (isset($_GET['BuscaSubfamilias']) && isset($_GET['codfamilia'])) {
  
$rag = $new->ListarSubfamilias2();

$codfamilia = limpiar($_GET['codfamilia']);

 if($codfamilia=="") { ?>

  <option value=""> -- SIN RESULTADOS -- </option>
  <?php } else { ?>
  <option value=""> -- SELECCIONE -- </option>
  <?php
  for($i=0;$i<sizeof($rag);$i++){
  ?>
  <option value="<?php echo $rag[$i]['codsubfamilia']; ?>" ><?php echo $rag[$i]['nomsubfamilia']; ?></option>
    <?php 
    } 
  }
}
######################## BUSCA SUBFAMILIAS POR FAMILIAS ########################
?>

<?php 
######################## BUSCA MODELOS POR MARCAS ########################
if (isset($_GET['BuscaModelos']) && isset($_GET['codmarca'])) {
  
$rag = $new->ListarModelosxMarcas();

$codmarca = limpiar($_GET['codmarca']);

 if($codmarca=="") { ?>

  <option value=""> -- SIN RESULTADOS -- </option>
  <?php } else { ?>
  <option value=""> -- SELECCIONE -- </option>
  <?php
  for($i=0;$i<sizeof($rag);$i++){
  ?>
  <option value="<?php echo $rag[$i]['codmodelo']; ?>" ><?php echo $rag[$i]['nommodelo']; ?></option>
    <?php 
    } 
  }
}
######################## BUSCA MODELOS POR MARCAS #############################
?>

<?php 
######################## BUSCA PRECIOS DE PRODUCTO ########################
if (isset($_GET['BuscaPreciosProductos']) && isset($_GET['idproducto'])) {
  
$producto = $new->BuscarPrecioProductoxCodigo();

$idproducto = limpiar($_GET['idproducto']);

 if($idproducto=="") { ?>

  <option value=""> -- SIN RESULTADOS -- </option>
  
<?php } else { ?>

  <option value=""> -- SELECCIONE -- </option>

<?php
$explode = explode("|",$producto[0]['precioventa']);
$listaSimple = array_values(array_unique($explode));
# Recorremos el array para despues separar en 2 partes.
for($cont=0; $cont<COUNT($listaSimple); $cont++):
list($nombre,$precio) = explode("_",$listaSimple[$cont]);
?>
<option value="<?php echo $precio; ?>"<?php if (!(strcmp("PRECIO PUBLICO", htmlentities($nombre)))) { echo "selected=\"selected\""; } ?>><?php echo $nombre.": ".$precio; ?></option>
    <?php 
    endfor;
    //}
  }
}
######################## BUSCA PRECIOS DE PRODUCTO ########################
?>


<?php
########################## MOSTRAR USUARIO EN VENTANA MODAL ###########################
if (isset($_GET['BuscaUsuarioModal']) && isset($_GET['codigo'])) { 
$reg = $new->UsuariosPorId();
?>

  <table class="table-responsive" border="0" align="center">
  <tr>
    <td><strong>Nº de Documento:</strong> <?php echo $reg[0]['dni']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombres y Apellidos:</strong> <?php echo $reg[0]['nombres']; ?></td>
  </tr>
  <tr>
    <td><strong>Sexo:</strong> <?php echo $reg[0]['sexo']; ?></td>
  </tr>
  <tr>
    <td><strong>Dirección Domiciliaria: </strong> <?php echo $reg[0]['direccion']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de Teléfono: </strong> <?php echo $reg[0]['telefono']; ?></td>
  </tr>
  <tr>
    <td><strong>Correo Electrónico: </strong> <?php echo $reg[0]['email']; ?></td>
  </tr>
  <tr>
    <td><strong>Usuario de Acceso: </strong> <?php echo $reg[0]['usuario']; ?></td>
  </tr>
  <tr>
    <td><strong>Nivel de Acceso: </strong> <?php echo $reg[0]['nivel']; ?></td>
  </tr>
  <?php if($_SESSION['acceso']=="administradorG"){ ?>
  <tr>
    <td><strong>Sucursal Asignada: </strong> <?php echo $reg[0]['codsucursal'] == '' ? "*********" : $reg[0]['nomsucursal']; ?></td>
  </tr>
<?php } ?>
  <tr>
  <td><strong>Status de Acceso: </strong> <?php echo $status = ( $reg[0]['status'] == 1 ? "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-pill badge-warning'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
  </tr>
</table>  

  <?php
   } 
######################### MOSTRAR USUARIO EN VENTANA MODAL ############################
?>

<?php 
########################## BUSCA USUARIOS POR SUCURSALES #############################
if (isset($_GET['BuscaUsuariosxSucursal']) && isset($_GET['codsucursal'])) {
  
$usuario = $new->BuscarUsuariosxSucursal();
?>
<option value=""> -- SELECCIONE -- </option>
  <?php
   for($i=0;$i<sizeof($usuario);$i++){
    ?>
<option value="<?php echo $usuario[$i]['codigo'] ?>"><?php echo $usuario[$i]['dni'].": ".$usuario[$i]['nombres'].": ".$usuario[$i]['nivel']; ?></option>
    <?php 
   } 
}
############################# BUSCA USUARIOS POR SUCURSALES ##########################
?>


<?php 
######################## SELECCIONE USUARIOS POR SUCURSALES ########################
if (isset($_GET['MuestraUsuario']) && isset($_GET['codigo']) && isset($_GET['codsucursal'])) {
  
$usuario = $new->BuscarUsuariosxSucursal();
?>
<option value=""> -- SELECCIONE -- </option>
  <?php
   for($i=0;$i<sizeof($usuario);$i++){
    ?>
<option value="<?php echo $usuario[$i]['codigo'] ?>"<?php if (!(strcmp($_GET['codigo'], htmlentities($usuario[$i]['codigo'])))) { echo "selected=\"selected\"";} ?>><?php echo $usuario[$i]['nombres'].": ".$usuario[$i]['nivel']; ?></option>
<?php
   } 
}
######################## SELECCIONE USUARIOS POR SUCURSALES #######################
?>





<?php
######################### MOSTRAR SUCURSAL EN VENTANA MODAL ##########################
if (isset($_GET['BuscaSucursalModal']) && isset($_GET['codsucursal'])) { 

$reg = $new->SucursalesPorId();
?>
  
  <table class="table-responsive" border="0" align="center">
  <tr>
    <td><strong>Nº de <?php echo $reg[0]['documsucursal'] == '0' ? "Documento" : $reg[0]['documento'] ?>: </strong> <?php echo $reg[0]['cuitsucursal']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombre de Sucursal: </strong> <?php echo $reg[0]['nomsucursal']; ?></td>
  </tr>
  <tr>
    <td><strong>Pais: </strong> <?php echo $reg[0]['provincia']; ?></td>
  </tr>
  <tr>
    <td><strong>Departamento: </strong> <?php echo $reg[0]['departamento']; ?></td>
  </tr>
  <tr>
    <td><strong>Dirección de Sucursal: </strong> <?php echo $reg[0]['direcsucursal']; ?></td>
  </tr>
  <tr>
    <td><strong>Correo Electrónico: </strong> <?php echo $reg[0]['correosucursal']; ?></td>
  </tr> 
  <tr>
    <td><strong>Nº de Teléfono: </strong> <?php echo $reg[0]['tlfsucursal']; ?></td>
  </tr> 
  <tr>
    <td><strong>Nº de Inicio de Ticket: </strong> <?php echo $reg[0]['inicioticket']; ?></td>
  </tr> 
  <tr>
    <td><strong>Nº de Inicio de Factura: </strong> <?php echo $reg[0]['iniciofactura']; ?></td>
  </tr> 
  <tr>
    <td><strong>Nº de Inicio de Guia: </strong> <?php echo $reg[0]['inicioguia']; ?></td>
  </tr> 
  <tr>
    <td><strong>Nº de Inicio Nota Venta: </strong> <?php echo $reg[0]['inicionotaventa']; ?></td>
  </tr> 
  <tr>
    <td><strong>Nº de Inicio Nota Credito: </strong> <?php echo $reg[0]['inicionotacredito']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de Actividad: </strong> <?php echo $reg[0]['nroactividadsucursal']; ?></td>
  </tr>  
  <tr>
    <td><strong>Fecha de Autorización: </strong> <?php echo $reg[0]['fechaautorsucursal'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[0]['fechaautorsucursal'])); ?></td>
  </tr> 
  <tr>
    <td><strong>Lleva Contabilidad: </strong> <?php echo $reg[0]['llevacontabilidad']; ?></td>
  </tr> 
  <tr>
    <td><strong>Nº <?php echo $reg[0]['documencargado'] == '0' ? "Documento" : $reg[0]['documento2'] ?> de Encargado:</strong> <?php echo $reg[0]['dniencargado']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombre de Encargado:</strong> <?php echo $reg[0]['nomencargado']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de Telèfono:</strong> <?php echo $reg[0]['tlfencargado'] == '' ? "*********" : $reg[0]['tlfencargado']; ?></td>
  </tr>
  <tr>
    <td><strong>Descuento Global en Ventas: </strong> <?php echo number_format($reg[0]['descsucursal'], 2, '.', ','); ?>%</td>
  </tr> 
  <tr>
    <td><strong>Porcentaje para Calcular Precio Venta: </strong> <?php echo number_format($reg[0]['porcentaje'], 2, '.', ','); ?>%</td>
  </tr>   
  <tr>
    <td><strong>Moneda Nacional: </strong> <?php echo $reg[0]['codmoneda'] == '0' ? "*********" : $reg[0]['moneda']; ?></td>
  </tr> 
  <tr>
    <td><strong>Moneda Tipo de Cambio:</strong> <?php echo $reg[0]['codmoneda2'] == '0' ? "*********" : $reg[0]['moneda2']; ?></td>
  </tr> 
</table>
<?php 
} 
######################### MOSTRAR SUCURSAL EN VENTANA MODAL #########################
?>






<?php 
############################# MUESTRA DIV CLIENTE #############################
if (isset($_GET['BuscaDivCliente'])) {
  
  ?>
<div class="row">
      <div class="col-md-12">
<font color="red"><strong> Para poder realizar la Carga Masiva de Clientes, el archivo Excel, debe estar estructurado de 13 columnas, la cuales tendrán las siguientes especificaciones:</strong></font><br>

  1. Código de Cliente. (Ejemplo: C1, C2, C3, C4, C5......)<br>
  2. Tipo de Cliente (Opciones: NATURAL/JURIDICO).<br>
  3. Tipo de Documento. (Debera de Ingresar el Codigo de Documento a la que corresponde)<br>
  4. Nº de Documento.<br>
  5. Nombre de Cliente (Ingresar Nombre completo con Apellidos).<br>
  6. Razón Social (Ingresar en caso de ser Cliente Juridico de lo contrario dejarlo vacio).<br>
  7. Giro de Cliente (Ingresar en caso de ser Cliente Juridico de lo contrario dejarlo vacio).<br>
  8. Nº de Teléfono. (Formato: (9999) 9999999).<br>
  9. Pais. (Debera de Ingresar el Codigo de Pais a la que corresponde)<br>
  10. Departamento. (Debera de Ingresar el Codigo de Departamento a la que corresponde)<br>
  11. Dirección Domiciliaria.<br>
  12. Correo Electronico.<br>
  13. Monto de Crédito en Ventas.<br><br>

  <font color="red"><strong> NOTA:</strong></font><br>
  a) El Archivo no debe de tener cabecera, solo deben estar los registros a grabar.<br>
  b) Se debe de guardar como archivo .CSV  (delimitado por comas)(*.csv).<br>
  c) Descargar Plantilla de Formato para Carga Masiva de Clientes <a class="text-info" href="fotos/clientes.csv">AQUI</a>. (La Cabecera deberá de ser eliminada al momento de hacer la Carga Masiva)<br>
  d) Todos los datos deberán escribirse en mayúscula para mejor orden y visibilidad en los reportes.<br>
  e) Deben de tener en cuenta que la carga masiva de Clientes, deben de ser cargados como se explica, para evitar problemas de datos del cliente dentro del Sistema.<br><br>
   </div>
</div>                               
<?php 
  }
############################ MUESTRA DIV CLIENTE ############################
?>

<?php
########################### MOSTRAR CLIENTE EN VENTANA MODAL ############################
if (isset($_GET['BuscaClienteModal']) && isset($_GET['codcliente'])) { 

$reg = $new->ClientesPorId();
?>
  <table class="table-responsive" border="0" align="center">
  <tr>
    <td><strong>Código:</strong> <?php echo $reg[0]['codcliente']; ?></td>
  </tr>
  <tr>
    <td><strong>Tipo de Cliente: </strong> <?php echo $reg[0]['tipocliente']; ?></td>
  </tr> 
  <tr>
    <td><strong>Nº de <?php echo $reg[0]['documcliente'] == '0' ? "Documento" : $reg[0]['documento'] ?>:</strong> <?php echo $reg[0]['dnicliente']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombres/Razón Social:</strong> <?php echo $reg[0]['nomcliente']; ?></td>
  </tr>
  <tr>
    <td><strong>Giro de Cliente:</strong> <?php echo $reg[0]['tipocliente'] == 'NATURAL' ? "*********" : $reg[0]['girocliente']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de Teléfono: </strong> <?php echo $reg[0]['tlfcliente'] == '' ? "*********" : $reg[0]['tlfcliente'] ?></td>
  </tr>
  <tr>
    <td><strong>Pais: </strong> <?php echo $reg[0]['provincia'] == '' ? "*********" : $reg[0]['provincia'] ?></td>
  </tr>
  <tr>
    <td><strong>Departamento: </strong> <?php echo $reg[0]['departamento'] == '' ? "*********" : $reg[0]['departamento'] ?></td>
  </tr>
  <tr>
    <td><strong>Dirección Domiciliaria: </strong> <?php echo $reg[0]['direccliente']; ?></td>
  </tr>
  <tr>
    <td><strong>Correo Electrónico: </strong> <?php echo $reg[0]['emailcliente'] == '' ? "*********" : $reg[0]['emailcliente'] ?></td>
  </tr>
  <tr>
    <td><strong>Limite de Crédito: </strong> <?php echo number_format($reg[0]['limitecredito'], 2, '.', ','); ?></td>
  </tr> 
  <tr>
    <td><strong>Fecha de Ingreso: </strong> <?php echo date("d-m-Y",strtotime($reg[0]['fechaingreso'])); ?></td>
  </tr>
</table>
<?php 
} 
########################## MOSTRAR CLIENTE EN VENTANA MODAL ###########################
?>













<?php 
############################# MUESTRA DIV PROVEEDOR #############################
if (isset($_GET['BuscaDivProveedor'])) {
  
  ?>
<div class="row">
      <div class="col-md-12">
<font color="red"><strong> Para poder realizar la Carga Masiva de Proveedores, el archivo Excel, debe estar estructurado de 11 columnas, la cuales tendrán las siguientes especificaciones:</strong></font><br>

  1. Código de Proveedor. (Ejemplo: P1, P2, P3, P4, P5......)<br>
  2. Tipo de Documento. (Debera de Ingresar el Codigo de Documento a la que corresponde)<br>
  3. Nº de Documento.<br>
  4. Nombre de Proveedor (Ingresar Nombre de Proveedor).<br>
  5. Nº de Teléfono. (Formato: (9999) 9999999).<br>
  6. Pais. (Debera de Ingresar el Codigo de Pais a la que corresponde)<br>
  7. Departamento. (Debera de Ingresar el Codigo de Departamento a la que corresponde)<br>
  8. Dirección de Proveedor.<br>
  9. Correo Electronico.<br>
  10. Nombre de Vendedor.<br>
  11. Nº de Teléfono de Vendedor. (Formato: (9999) 9999999).<br><br>

  <font color="red"><strong> NOTA:</strong></font><br>
  a) El Archivo no debe de tener cabecera, solo deben estar los registros a grabar.<br>
  b) Se debe de guardar como archivo .CSV  (delimitado por comas)(*.csv).<br>
  c) Descargar Plantilla de Formato para Carga Masiva de Proveedores <a class="text-info" href="fotos/proveedores.csv">AQUI</a>. (La Cabecera deberá de ser eliminada al momento de hacer la Carga Masiva)<br>
  d) Todos los datos deberán escribirse en mayúscula para mejor orden y visibilidad en los reportes.<br>
  e) Deben de tener en cuenta que la carga masiva de Proveedores, deben de ser cargados como se explica, para evitar problemas de datos del proveedor dentro del Sistema.<br><br>
   </div>
</div>
<?php 
  }
############################ MUESTRA DIV PROVEEDOR #############################
?>

<?php
########################### MOSTRAR PROVEEDOR EN VENTANA MODAL ##########################
if (isset($_GET['BuscaProveedorModal']) && isset($_GET['codproveedor'])) { 

$reg = $new->ProveedoresPorId();
?>
  
  <table class="table-responsive" border="0" align="center">
  <tr>
    <td><strong>Código:</strong> <?php echo $reg[0]['codproveedor']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de <?php echo $reg[0]['documproveedor'] == '0' ? "Documento" : $reg[0]['documento'] ?>:</strong> <?php echo $reg[0]['cuitproveedor']; ?>:</td>
  </tr>
  <tr>
    <td><strong>Nombres de Proveedor:</strong> <?php echo $reg[0]['nomproveedor']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de Teléfono: </strong> <?php echo $reg[0]['tlfproveedor']; ?></td>
  </tr>
  <tr>
    <td><strong>Pais: </strong> <?php echo $reg[0]['provincia'] == '' ? "*********" : $reg[0]['provincia'] ?></td>
  </tr>
  <tr>
    <td><strong>Departamento: </strong> <?php echo $reg[0]['departamento'] == '' ? "*********" : $reg[0]['departamento'] ?></td>
  </tr>
  <tr>
    <td><strong>Dirección de Proveedor: </strong> <?php echo $reg[0]['direcproveedor']; ?></td>
  </tr>
  <tr>
    <td><strong>Correo Electrónico: </strong> <?php echo $reg[0]['emailproveedor']; ?></td>
  </tr> 
  <tr>
    <td><strong>Vendedor: </strong> <?php echo $reg[0]['vendedor']; ?></td>
  </tr> 
  <tr>
    <td><strong>Nº de Teléfono: </strong> <?php echo $reg[0]['tlfvendedor']; ?></td>
  </tr>
  <tr>
    <td><strong>Fecha de Ingreso: </strong> <?php echo date("d-m-Y",strtotime($reg[0]['fechaingreso'])); ?></td>
  </tr>
</table>
<?php 
} 
########################## MOSTRAR PROVEEDOR EN VENTANA MODAL ##########################
?>


























<?php
########################### MOSTRAR PEDIDOS EN VENTANA MODAL ############################
if (isset($_GET['BuscaPedidoModal']) && isset($_GET['codpedido']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->PedidosPorId();

  if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PEDIDOS Y DETALLES ACTUALMENTE </center>";
    echo "</div>";    

} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-dark">SUCURSAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "REGISTRO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?></p>

  <h4><b class="text-dark">Nº PEDIDO <?php echo $reg[0]['codfactura']; ?></b></h4>
  <p class="text-muted m-l-5">FECHA DE EMISIÓN: <?php echo date("d-m-Y",strtotime($reg[0]['fechapedido'])); ?>
  <br/> OBSERVACIONES: <?php echo $reg[0]['observacionpedido']; ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-dark">PROVEEDOR</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nomproveedor'] == '' ? "*******" : $reg[0]['nomproveedor']; ?>,
  <br/>DIREC: <?php echo $reg[0]['direcproveedor'] == '' ? "*********" : $reg[0]['direcproveedor']; ?> <?php echo $reg[0]['provincia'] == '' ? "*********" : $reg[0]['provincia']; ?> <?php echo $reg[0]['departamento'] == '' ? "*********" : $reg[0]['departamento']; ?>
  <br/> EMAIL: <?php echo $reg[0]['emailproveedor'] == '' ? "*******" : $reg[0]['emailproveedor']; ?>
  <br/> Nº <?php echo $reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['cuitproveedor'] == '' ? "*******" : $reg[0]['cuitproveedor']; ?> - TLF: <?php echo $reg[0]['tlfproveedor'] == '' ? "*******" : $reg[0]['tlfproveedor']; ?>
  <br/> VENDEDOR: <?php echo $reg[0]['vendedor'] == '' ? "*******" : $reg[0]['vendedor']; ?> - TLF: <?php echo $reg[0]['tlfvendedor'] == '' ? "*******" : $reg[0]['tlfvendedor']; ?></p>
                                            
                                        </address>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-10" style="clear: both;">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">Descripción de Producto</th>
                                                    <th class="text-center">Marca</th>
                                                    <th class="text-center">Modelo</th>
                                                    <th class="text-center">Cantidad</th>
<?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") { ?><th class="text-center">Acción</th><?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesPedidos();

$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
?>
                                                <tr>
      <td><?php echo $a++; ?></td>
      <td></strong><?php echo $detalle[$i]['producto']; ?></strong></td>
      <td><?php echo $detalle[$i]['nommarca']; ?></td>
      <td><?php echo $detalle[$i]['nommodelo']; ?></td>
      <td><?php echo $detalle[$i]['cantpedido']; ?></td>
 <?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") { ?><td class="text-center">
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesPedidosModal('<?php echo encrypt($detalle[$i]["coddetallepedido"]); ?>','<?php echo encrypt($detalle[$i]["codpedido"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESPEDIDOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                                </tr>
                                      <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="text-right">
 <a href="reportepdf?codpedido=<?php echo encrypt($reg[0]['codpedido']); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURAPEDIDO") ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"><span><i class="fa fa-print"></i> Imprimir</span></button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                                    </div>
                                </div>
                            </div>
                <!-- .row -->

  <?php
       }
   } 
########################## MOSTRAR PEDIDOS EN VENTANA MODAL ############################
?>


<?php
########################## MOSTRAR DETALLES DE PEDIDOS UPDATE ############################
if (isset($_GET['MuestraDetallesPedidosUpdate']) && isset($_GET['codpedido']) && isset($_GET['codsucursal'])) { 
 
$ped = $new->PedidosPorId();
?>
<div class="table-responsive m-t-20">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Código</th>
                        <th>Descripción de Producto</th>
                        <th>Marcas</th>
                        <th>Modelo</th>
<?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") { ?><th class="text-center">Acción</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesPedidos();
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
    ?>
                                 <tr>
      <td><input type="text" class="form-control" name="cantpedido[]" id="cantpedido_<?php echo $a; ?>" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Cantidad" value="<?php echo $detalle[$i]["cantpedido"]; ?>" style="width: 80px;" onfocus="this.style.background=('#B7F0FF')" onBlur="this.style.background=('#e4e7ea')" title="Ingrese Cantidad" required="" aria-required="true"></td>

      <td><input type="hidden" name="coddetallepedido[]" id="coddetallepedido" value="<?php echo $detalle[$i]["coddetallepedido"]; ?>"><?php echo $detalle[$i]['codproducto']; ?></td>
      <td><?php echo $detalle[$i]['producto']; ?></td>
      <td><?php echo $detalle[$i]['nommarca']; ?></td>
      <td><?php echo $detalle[$i]['nommodelo']; ?></td>
 <?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") { ?><td class="text-center">
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesPedidosUpdate('<?php echo encrypt($detalle[$i]["coddetallepedido"]); ?>','<?php echo encrypt($detalle[$i]["codpedido"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESPEDIDOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                 </tr>
                     <?php } ?>
                </tbody>
            </table>
        </div>
<?php
  } 
########################## MOSTRAR DETALLES DE PEDIDOS UPDATE #########################
?>

<?php
########################## MOSTRAR DETALLES DE PEDIDOS AGREGAR #########################
if (isset($_GET['MuestraDetallesPedidosAgregar']) && isset($_GET['codpedido']) && isset($_GET['codsucursal'])) { 
 
$ped = $new->PedidosPorId();

?>

<div class="table-responsive m-t-20">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Código</th>
                        <th>Descripción de Producto</th>
                        <th>Marcas</th>
                        <th>Modelo</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesPedidos();
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
    ?>
                                 <tr>
      <td><?php echo $a++; ?></td>
      <td><?php echo $detalle[$i]['codproducto']; ?></td>
      <td><?php echo $detalle[$i]['producto']; ?></td>
      <td><?php echo $detalle[$i]['nommarca']; ?></td>
      <td><?php echo $detalle[$i]['nommodelo']; ?></td>
      <td><?php echo $detalle[$i]['cantpedido']; ?></td>
 <?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") { ?><td class="text-center">
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesPedidosAgregar('<?php echo encrypt($detalle[$i]["coddetallepedido"]); ?>','<?php echo encrypt($detalle[$i]["codpedido"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESPEDIDOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                 </tr>
                     <?php } ?>
                </tbody>
            </table>
        </div>
<?php
  } 
########################## MOSTRAR DETALLES DE PEDIDOS AGREGRA #########################
?>


<?php
########################## BUSQUEDA PEDIDOS POR PROVEEDORES ##########################
if (isset($_GET['BuscaPedidosxProvedores']) && isset($_GET['codsucursal']) && isset($_GET['codproveedor'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codproveedor = limpiar($_GET['codproveedor']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codproveedor=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE PROVEEDOR PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarPedidosxProveedor();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Pedidos al Proveedor <?php echo $reg[0]['cuitproveedor'].": ".$reg[0]['nomproveedor']; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codproveedor=<?php echo $codproveedor; ?>&codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("PEDIDOSXPROVEEDOR") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codproveedor=<?php echo $codproveedor; ?>&codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PEDIDOSXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codproveedor=<?php echo $codproveedor; ?>&codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PEDIDOSXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              </div>
            </div>
          </div>

          <div id="div1"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                              <th>Nº</th>
                              <th>N° de Pedido</th>
                              <th>Descripción de Proveedor</th>
                              <th>Nº de Articulos</th>
                              <th>Observaciones</th>
                              <th>Fecha de Pedido</th>
                              <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
                                <tr>
                      <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codfactura']; ?></td>
<td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']; ?>"><?php echo $reg[$i]['nomproveedor']; ?></abbr></td>
                    <td><?php echo $reg[$i]['articulos']; ?></td>
                    <td><?php echo $reg[$i]['observacionpedido']; ?></td>
                    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechapedido'])); ?></td>
                    <td>
<a href="reportepdf?codpedido=<?php echo encrypt($reg[$i]['codpedido']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURAPEDIDO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                </tr>
                        <?php  }  ?>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA PEDIDOS POR PROVEEDORES ##########################
?>


























<?php 
############################# MUESTRA DIV PRODUCTO ############################
if (isset($_GET['BuscaDivProducto'])) {
  
  ?>
<div class="row">
      <div class="col-md-12">
<font color="red"><strong> Para poder realizar la Carga Masiva de Productos, el archivo Excel, debe estar estructurado de 31 columnas, la cuales tendrán las siguientes especificaciones:</strong></font><br><br>

  1. Código de Producto (Ejem. 0001).<br>
  2. Nombre de Producto.<br>
  3. Nombre de Fabricante (En caso de no tener colocar Cero).<br>
  4. Familia de Producto. (Deberá ingresar el Nº de Familia a la que corresponde o colocar Cero).<br>
  5. Subfamilia de Producto. (Deberá ingresar el Nº de Subfamilia a la que corresponde o colocar Cero)<br>
  6. Marca de Producto (Deberá ingresar el Nº de Marca a la que corresponde o colocar Cero)<br>
  7. Modelo de Producto (Deberá ingresar el Nº de Modelo a la que corresponde o colocar Cero)<br>
  8. Presentación (Deberá ingresar el Nº de Presentación a la que corresponde o colocar Cero)<br>
  9. Color de Producto (Deberá ingresar el Nº de Color a la que corresponde o colocar Cero).<br>
  10. Origen de Producto (Deberá ingresar el Nº de Origen a la que corresponde o colocar Cero).<br>
  11. Año de Producto (En caso de ser algun Producto de Año de Fabricación).<br>
  12. Nº de Parte de Producto (En caso de no tener colocar Cero).<br>
  13. Lote de Producto (En caso de no tener colocar Cero).<br>
  14. Peso de Producto (En caso de no tener colocar Cero).<br>
  15. Precio Compra. (Numeros con 2 decimales).<br>
  16. Precio Venta Menor. (Numeros con 2 decimales).<br>
  17. Precio Venta Mayor. (Numeros con 2 decimales).<br>
  18. Precio Venta Público. (Numeros con 2 decimales).<br>
  19. Existencia. (Debe de ser solo enteros).<br>
  20. Stock Óptimo. (Debe de ser solo enteros).<br>
  21. Stock Medio. (Debe de ser solo enteros).<br>
  22. Stock Minimo. (Debe de ser solo enteros).<br>
  23. <?php echo $impuesto; ?> de Producto. (Ejem. SI o NO).<br>
  24. Descuento de Producto. (Numeros con 2 decimales).<br>
  25. Código de Barra. (En caso de no tener colocar Cero).<br>
  26. Fecha de Elaboración. (Formato: 0000-00-00).<br>
  27. Fecha de Expiración Óptimo. (Formato: 0000-00-00).<br>
  28. Fecha de Expiración Medio. (Formato: 0000-00-00).<br>
  29. Fecha de Expiración Minimo. (Formato: 0000-00-00).<br>
  30. Proveedor. (Debe de verificar a que codigo pertenece el Proveedor existente).<br>
  31. Código de Sucursal.<br><br>

  <font color="red"><strong> NOTA:</strong></font><br>
  a) El Archivo no debe de tener cabecera, solo deben estar los registros a grabar.<br>
  b) Se debe de guardar como archivo .CSV  (delimitado por comas)(*.csv).<br>
  c) Descargar Plantilla <a class="text-info" href="fotos/productos.csv">AQUI</a>. (La Cabecera deberá de ser eliminada al momento de hacer la Carga Masiva)<br>
  d) Todos los datos deberán escribirse en mayúscula para mejor orden y visibilidad en los reportes.<br>
  e) Deben de tener en cuenta que la carga masiva de Productos, deben de ser cargados como se explica, para evitar problemas de datos del productos dentro del Sistema.<br><br>
    </div>
</div>                                 
<?php 
  }
############################# MUESTRA DIV PRODUCTO #############################
?>

<?php 
########################## MOSTRAR FOTO DE PRODUCTO EN VENTANA MODAL ##########################
if (isset($_GET['BuscaFotoProductoModal']) && isset($_GET['codproducto']) && isset($_GET['codsucursal'])) { 

$reg = $new->ProductosPorId(); 
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>"); 
?>
  <center>
    <div class="row">
      <div class="col-md-12">
        <?php 
        if (file_exists("./fotos/productos/".$reg[0]["codproducto"].".jpg")){
                
        echo "<img src='fotos/productos/".$reg[0]['codproducto'].".jpg?' class='rounded-circle' width='240' height='240'>";
                  
        } ?>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <abbr title="Nombre de Producto" class="alert-link"><?php echo $reg[0]['producto']; ?></abbr>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <abbr title="Código de Producto" class="alert-link"><?php echo $reg[0]['codproducto']; ?></abbr>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <abbr title="Precio Venta Minorista" class="alert-link"><?php echo $simbolo.number_format($reg[0]['precioxmenor'], 2, '.', ','); ?></abbr> - 

        <abbr title="Precio Venta Mayorista" class="alert-link"><?php echo $simbolo.number_format($reg[0]['precioxmayor'], 2, '.', ','); ?></abbr> - 

        <abbr title="Precio Venta Público" class="alert-link"><?php echo $simbolo.number_format($reg[0]['precioxpublico'], 2, '.', ','); ?></abbr>

      </div>
    </div>

  </center> 

  <?php
    //require_once('fpdf/barcode.php'); 
    //barcode('125689365472365458',0,'hello.gif', 190, 130, true);
  ?>                              
<?php 
  }
############################# MOSTRAR FOTO DE PRODUCTO EN VENTANA MODAL #############################
?>

<?php 
########################### BUSQUEDA DE PRODUCTOS POR SUCURSAL ##########################
if (isset($_GET['BuscaProductosxSucursal']) && isset($_GET['codsucursal'])) { 

$codsucursal = limpiar($_GET['codsucursal']);

  if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
   } else {
  
$reg = $new->ListarProductos(); 
?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Productos de la Sucursal <?php echo $reg[0]['nomsucursal']; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            
            <div class="col-md-12">
              <div class="btn-group m-b-20">
              <div class="btn-group">
              <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf-o"></i> Pdf</button>
              <div class="dropdown-menu dropdown-menu-left" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(164px, 35px, 0px);">

                <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("PRODUCTOS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Listado General</a>

                <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("STOCKOPTIMO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Stock Óptimo</a>

                <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("STOCKMEDIO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Stock Medio</a>

                <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("STOCKMINIMO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Stock Minimo</a>

                <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("CODIGOBARRAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-barcode text-dark"></span> Código Barras</a>

              </div>
            </div>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSCSV") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> CSV</a>

              </div>
            </div>
          </div>

          <div id="div3"><table id="datatable-responsive" class="table table-hover table-nomargin table-bordered dataTable table-striped" cellspacing="0" width="100%">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Foto</th>
                                                    <th>Código</th>
                                                    <th>Nombre de Producto</th>
                                                    <th>Stock</th>
                                                    <th>Fecha Venc.</th>
                                                    <th>Fecha Elab.</th>
                                                    <th>Marca</th>
                                                    <th>Modelo</th>
                                                    <th>P. Menor</th>
                                                    <th>P. Mayor</th>
                                                    <th>P. Público</th>
                                                    <th><?php echo $impuesto; ?></th>
                                                    <th>Descto</th>
                                                    <th>Ver</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 

if($reg==""){ 

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
                                               <td><?php echo $reg[$i]['codproducto']; ?></td>
                                               <td><?php echo $reg[$i]['producto']; ?></td>
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
 </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table>
                         </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA DE PRODUCTOS POR SUCURSAL ##########################
?>

<?php
########################## MOSTRAR PRODUCTOS EN VENTANA MODAL ##########################
if (isset($_GET['BuscaProductoModal']) && isset($_GET['codproducto']) && isset($_GET['codsucursal'])) { 

$reg = $new->ProductosPorId(); 
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>"); 
?>
  
  <table class="table-responsive" border="0" align="center">
  <tr>
    <td><strong>Código:</strong> <?php echo $reg[0]['codproducto']; ?></td>
  </tr>
  <tr>
    <td><strong>Producto:</strong> <?php echo $reg[0]['producto']; ?></td>
  </tr> 
  <tr>
  <td><strong>Proveedor: </strong><?php echo $reg[0]['cuitproveedor'].": ".$reg[0]['nomproveedor']; ?></td>
  </tr> 
  <tr>
    <td><strong>Fabricante:</strong> <?php echo $reg[0]['fabricante'] == '' ? "*********" : $reg[0]['fabricante']; ?></td>
  </tr>
  <tr>
    <td><strong>Familia: </strong> <?php echo $reg[0]['nomfamilia']; ?></td>
  </tr>
  <tr>
    <td><strong>Subfamilia: </strong> <?php echo $reg[0]['codsubfamilia'] == '0' ? "*********" : $reg[0]['nomsubfamilia']; ?></td>
  </tr>
  <tr>
    <td><strong>Marca: </strong> <?php echo $reg[0]['nommarca']; ?></td>
  </tr>
  <tr>
    <td><strong>Modelo: </strong> <?php echo $reg[0]['nommodelo'] == '' ? "*********" : $reg[0]['nommodelo']; ?></td>
  </tr>
  <tr>
    <td><strong>Presentación: </strong> <?php echo $reg[0]['nompresentacion']; ?></td>
  </tr> 
  <tr>
    <td><strong>Color: </strong> <?php echo $reg[0]['codcolor'] == '0' ? "*********" : $reg[0]['nomcolor']; ?></td>
  </tr> 
  <tr>
    <td><strong>Origen: </strong> <?php echo $reg[0]['codorigen'] == '0' ? "*********" : $reg[0]['nomorigen']; ?></td>
  </tr>
  <tr>
    <td><strong>Año de Fábrica: </strong> <?php echo $reg[0]['year'] == '' ? "*********" : $reg[0]['year']; ?></td>
  </tr> 
  <tr>
    <td><strong>Part Number: </strong> <?php echo $reg[0]['nroparte'] == '' ? "*********" : $reg[0]['nroparte']; ?></td>
  </tr> 
  <tr>
    <td><strong>Nº de Lote: </strong> <?php echo $reg[0]['lote'] == '' ? "*********" : $reg[0]['lote']; ?></td>
  </tr> 
  <tr>
    <td><strong>Peso: </strong> <?php echo $reg[0]['peso'] == '' ? "*********" : $reg[0]['peso']; ?></td>
  </tr>  
  <tr>
    <td><strong>Precio de Compra: </strong> <?php echo $simbolo.number_format($reg[0]['preciocompra'], 2, '.', ','); ?></td>
  </tr> 
  <tr>
    <td><strong>Precio de Venta Menor: </strong> <?php echo $simbolo.number_format($reg[0]['precioxmenor'], 2, '.', ','); ?> (<?php echo $reg[0]['montocambio'] == '' ? "*****" : "<strong>".$reg[0]['simbolo2']."</strong>".number_format($reg[0]['precioxmenor']/$reg[0]['montocambio'], 2, '.', ','); ?>)</td>
  </tr> 
  <tr>
    <td><strong>Precio de Venta Mayor: </strong> <?php echo $simbolo.number_format($reg[0]['precioxmayor'], 2, '.', ','); ?> (<?php echo $reg[0]['montocambio'] == '' ? "*****" : "<strong>".$reg[0]['simbolo2']."</strong>".number_format($reg[0]['precioxmayor']/$reg[0]['montocambio'], 2, '.', ','); ?>)</td>
  </tr> 
  <tr>
    <td><strong>Precio de Venta Publico: </strong> <?php echo $simbolo.number_format($reg[0]['precioxpublico'], 2, '.', ','); ?> (<?php echo $reg[0]['montocambio'] == '' ? "*****" : "<strong>".$reg[0]['simbolo2']."</strong>".number_format($reg[0]['precioxpublico']/$reg[0]['montocambio'], 2, '.', ','); ?>)</td>
  </tr> 
  <tr>
    <td><strong>Existencia: </strong> <?php echo $reg[0]['existencia']; ?></td>
  </tr> 
  <tr>
    <td><strong>Stock Óptimo: </strong> <?php echo $reg[0]['stockoptimo'] == '0' ? "*********" : $reg[0]['stockoptimo']; ?></td>
  </tr> 
  <tr>
    <td><strong>Stock Medio: </strong> <?php echo $reg[0]['stockmedio'] == '0' ? "*********" : $reg[0]['stockmedio']; ?></td>
  </tr> 
  <tr>
    <td><strong>Stock Minimo: </strong> <?php echo $reg[0]['stockminimo'] == '0' ? "*********" : $reg[0]['stockminimo']; ?></td>
  </tr> 
  <tr>
    <td><strong><?php echo $impuesto; ?>: </strong> <?php echo $reg[0]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
  </tr> 
  <tr>
    <td><strong>Descuento: </strong> <?php echo number_format($reg[0]['descproducto'], 2, '.', ',')."%"; ?></td>
  </tr> 
  <tr>
    <td><strong>Código de Barra: </strong> <?php echo $reg[0]['codigobarra'] == '' ? "*********" : $reg[0]['codigobarra']; ?></td>
  </tr> 
  <tr>
    <td><strong>Fecha de Elaboración: </strong> <?php echo $reg[0]['fechaelaboracion'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[0]['fechaelaboracion'])); ?></td>
  </tr> 
  <tr>
    <td><strong>Fecha de Exp. Óptimo: </strong> <?php echo $reg[0]['fechaoptimo'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[0]['fechaoptimo'])); ?></td>
  </tr>
  <tr>
    <td><strong>Fecha de Exp. Medio: </strong> <?php echo $reg[0]['fechamedio'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[0]['fechamedio'])); ?></td>
  </tr>
  <tr>
    <td><strong>Fecha de Exp. Minimo: </strong> <?php echo $reg[0]['fechaminimo'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[0]['fechaminimo'])); ?></td>
  </tr>
  <tr>
    <td><strong>Status: </strong> <?php echo $status = ( $reg[0]['existencia'] != 0 ? "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-pill badge-warning'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
  </tr>

<?php if ($_SESSION['acceso'] == "administradorG") { ?>
    <tr>
    <td><strong>Sucursal: </strong> <?php echo $reg[0]['nomsucursal']; ?></td>  
    </tr>
<?php } ?>

</table>
<?php 
} 
########################## MOSTRAR PRODUCTOS EN VENTANA MODAL ##########################
?>

<?php 
########################### BUSQUEDA DE PRODUCTOS POR MONEDA ##########################
if (isset($_GET['BuscaProductoxMoneda']) && isset($_GET['codsucursal']) && isset($_GET['codmoneda'])) { 

  $codsucursal = limpiar($_GET['codsucursal']);
  $codmoneda = limpiar($_GET['codmoneda']);

  if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
   } else if($codmoneda=="") { 

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO DE MONEDA PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
   } else {

$cambio = new Login();
$cambio = $cambio->BuscarTiposCambios();
  
$reg = $new->ListarProductos();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Productos al Cambio de <?php echo $cambio[0]['moneda']." (".$cambio[0]['siglas'].")"; ?> de la Sucursal <?php echo $reg[0]['nomsucursal']; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codmoneda=<?php echo $codmoneda; ?>&tipo=<?php echo encrypt("PRODUCTOSXMONEDA") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codmoneda=<?php echo $codmoneda; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSXMONEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codmoneda=<?php echo $codmoneda; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOSXMONEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              </div>
            </div>
          </div>

          <div id="div3"><table id="datatable-responsive" class="table table-hover table-nomargin table-bordered dataTable table-striped" cellspacing="0" width="100%">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Código</th>
                                                    <th>Nombre de Producto</th>
                                                    <th>Marca</th>
                                                    <th>Modelo</th>
                                                    <th>P. Compra <?php echo $cambio[0]['siglas']; ?></th>
                                                    <th>P. Menor <?php echo $cambio[0]['siglas']; ?></th>
                                                    <th>P. Mayor <?php echo $cambio[0]['siglas']; ?></th>
                                                    <th>P. Público <?php echo $cambio[0]['siglas']; ?></th>
                                                    <th>Existencia</th>
                                                    <th><?php echo $impuesto; ?></th>
                                                    <th>Dcto %</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 

if($reg==""){ 

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
$simbolo2 = ($reg[$i]['simbolo2'] == "" ? "" : "<strong>".$reg[$i]['simbolo2']."</strong>");

$TotalCompra+=number_format($reg[$i]['preciocompra'], 2, '.', ',');
$TotalMenor+=number_format($reg[$i]['precioxmenor']-$reg[$i]['descproducto']/100, 2, '.', '');
$TotalMayor+=number_format($reg[$i]['precioxmayor']-$reg[$i]['descproducto']/100, 2, '.', '');
$TotalPublico+=number_format($reg[$i]['precioxpublico']-$reg[$i]['descproducto']/100, 2, '.', '');

$TotalMonedaCompra+=number_format($reg[$i]['preciocompra']/$cambio[0]['montocambio'], 2, '.', ',');
$TotalMonedaMenor+=number_format($reg[$i]['precioxmenor']/$cambio[0]['montocambio']-$reg[$i]['descproducto']/100, 2, '.', '');
$TotalMonedaMayor+=number_format($reg[$i]['precioxmayor']/$cambio[0]['montocambio']-$reg[$i]['descproducto']/100, 2, '.', '');
$TotalMonedaPublico+=number_format($reg[$i]['precioxpublico']/$cambio[0]['montocambio']-$reg[$i]['descproducto']/100, 2, '.', '');
$TotalArticulos+=$reg[$i]['existencia'];

?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codproducto']; ?></td>
                    <td><?php echo $reg[$i]['producto']; ?></td>
                    <td><?php echo $reg[$i]['nommarca']; ?></td>
                    <td><?php echo $reg[$i]['nommodelo'] == '' ? "*****" : $reg[$i]['nommodelo']; ?></td>
                    <td><?php echo "<strong>".$cambio[0]['simbolo']."</strong>".number_format($reg[$i]['preciocompra']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
                    <td><?php echo "<strong>".$cambio[0]['simbolo']."</strong>".number_format($reg[$i]['precioxmenor']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
                    <td><?php echo "<strong>".$cambio[0]['simbolo']."</strong>".number_format($reg[$i]['precioxmayor']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
                    <td><?php echo "<strong>".$cambio[0]['simbolo']."</strong>".number_format($reg[$i]['precioxpublico']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
                    <td><?php echo $reg[$i]['existencia']; ?></td>
                    <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
                    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
                          </tr>
                        <?php } ?>
                      <tr>
                        <td colspan="5"></td>
                        <td><strong><?php echo $simbolo2.number_format($TotalMonedaCompra, 2, '.', ','); ?></strong></td>
                        <td><strong><?php echo $simbolo2.number_format($TotalMonedaMenor, 2, '.', ','); ?></strong></td>
                        <td><strong><?php echo $simbolo2.number_format($TotalMonedaMayor, 2, '.', ','); ?></strong></td>
                        <td><strong><?php echo $simbolo2.number_format($TotalMonedaPublico, 2, '.', ','); ?></strong></td>
                        <td><strong><?php echo $TotalArticulos; ?></strong></td>
                      </tr>
        <?php } ?>
                              </tbody>
                          </table>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA DE PRODUCTOS POR MONEDA ##########################
?>


<?php 
######################## BUSQUEDA DE KARDEX POR PRODUCTOS ########################
if (isset($_GET['BuscaKardexProducto']) && isset($_GET['codsucursal']) && isset($_GET['codproducto'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$codproducto = limpiar($_GET['codproducto']); 

  if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($codproducto=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL PRODUCTO CORRECTAMENTE</center>";
  echo "</div>";
  exit;
   
   } else {

$detalle = new Login();
$detalle = $detalle->DetalleProductosKardex();
  
$kardex = new Login();
$kardex = $kardex->BuscarKardexProducto();  
?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Movimientos del Producto <?php echo $detalle[0]['codproducto'].": ".$detalle[0]['producto']; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codproducto=<?php echo $codproducto; ?>&tipo=<?php echo encrypt("KARDEXPRODUCTOS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codproducto=<?php echo $codproducto; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("KARDEXPRODUCTOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codproducto=<?php echo $codproducto; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("KARDEXPRODUCTOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              </div>
            </div>
          </div>

          <div id="div3"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                                  <th>Nº</th>
                                  <th>Movimiento</th>
                                  <th>Entradas</th>
                                  <th>Salidas</th>
                                  <th>Devolución</th>
                                  <th>Precio Costo</th>
                                  <th>Costo Movimiento</th>
                                  <th>Stock Actual</th>
                                  <th>Documento</th>
                                  <th>Fecha de Kardex</th>
                              </tr>
                              </thead>
                              <tbody>
<?php
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
                              <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $kardex[$i]['movimiento']; ?></td>
                                  <td><?php echo $kardex[$i]['entradas']; ?></td>
                                  <td><?php echo $kardex[$i]['salidas']; ?></td>
                                  <td><?php echo $kardex[$i]['devolucion']; ?></td>
                                  <td><?php echo $simbolo.number_format($kardex[$i]['precio'], 2, '.', ','); ?></td>
                          <?php if($kardex[$i]["movimiento"]=="ENTRADAS"){ ?>
        <td><?php echo number_format($kardex[$i]['precio']*$kardex[$i]['entradas'], 2, '.', ','); ?></td>
                          <?php } elseif($kardex[$i]["movimiento"]=="SALIDAS"){ ?>
        <td><?php echo number_format($kardex[$i]['precio']*$kardex[$i]['salidas'], 2, '.', ','); ?></td>
                          <?php } else { ?>
        <td><?php echo number_format($kardex[$i]['precio']*$kardex[$i]['devolucion'], 2, '.', ','); ?></td>
                          <?php } ?>
                                  <td><?php echo $kardex[$i]['stockactual']; ?></td>
                                  <td><?php echo $kardex[$i]['documento']; ?></td>
                                  <td><?php echo date("d-m-Y",strtotime($kardex[$i]['fechakardex'])); ?></td>
                              </tr>
                        <?php  }  ?>
                              </tbody>
                          </table>
                        
          <strong>Detalles de Producto</strong><br>
          <strong>Código:</strong> <?php echo $kardex[0]['codproducto']; ?><br>
          <strong>Descripción:</strong> <?php echo $detalle[0]['producto']; ?><br>
          <strong>Presentación:</strong> <?php echo $detalle[0]['nompresentacion']; ?><br>
          <strong>Marca:</strong> <?php echo $detalle[0]['nommarca']; ?><br>
          <strong>Modelo:</strong> <?php echo $detalle[0]['nommodelo'] == '' ? "*****" : $detalle[0]['nommodelo']; ?><br>
          <strong>Total Entradas:</strong> <?php echo $TotalEntradas; ?><br>
          <strong>Total Salidas:</strong> <?php echo $TotalSalidas; ?><br>
          <strong>Total Devolución:</strong> <?php echo $TotalDevolucion; ?><br>
          <strong>Existencia:</strong> <?php echo $detalle[0]['existencia']; ?><br>
          <strong>Precio Compra:</strong> <?php echo $simbolo." ".number_format($detalle[0]['preciocompra'], 2, '.', ','); ?><br>
          <strong>P. Venta Menor:</strong> <?php echo $simbolo." ".number_format($detalle[0]['precioxmenor'], 2, '.', ','); ?><br>
          <strong>P. Venta Mayor:</strong> <?php echo $simbolo." ".number_format($detalle[0]['precioxmayor'], 2, '.', ','); ?><br>
          <strong>P. Venta Público:</strong> <?php echo $simbolo." ".number_format($detalle[0]['precioxpublico'], 2, '.', ','); ?>

            </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
######################## BUSQUEDA DE KARDEX POR PRODUCTOS ########################
?>

<?php 
########################### BUSQUEDA KARDEX VALORIZADO POR SUCURSAL ##########################
if (isset($_GET['BuscaKardexValorizado']) && isset($_GET['codsucursal'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->ListarKardexValorizado();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Kardex Valorizado de Sucursal <?php echo $reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal']; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("KARDEXVALORIZADO") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("KARDEXVALORIZADO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("KARDEXVALORIZADO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Código</th>
                                  <th>Descripción de Producto</th>
                                  <th>Marca</th>
                                  <th>Modelo</th>
                                  <th>Precio Público</th>
                                  <th>Descto</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Existencia</th>
                                  <th>Total Venta</th>
                                  <th>Total Compra</th>
                                  <th>Ganancias</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$PrecioTotal=0;
$ExisteTotal=0;
$PagoTotal=0;
$CompraTotal=0;
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
                                <tr>
                      <td><?php echo $a++; ?></div></td>
                      <td><?php echo $reg[$i]['codproducto']; ?></td>
                      <td><?php echo $reg[$i]['producto']; ?></td>
                      <td><?php echo $reg[$i]['nommarca']; ?></td>
                      <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']; ?></td>
                      <td><?php echo $simbolo.number_format($reg[$i]["precioxpublico"], 2, '.', ','); ?></td>
                      <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
                      <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
                      <td><?php echo $reg[$i]['existencia']; ?></td>
                      <td><?php echo $simbolo.number_format($reg[$i]['precioxpublico']*$reg[$i]['existencia']-$reg[$i]['descproducto']/100, 2, '.', ','); ?></td>
                      <td><?php echo $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['existencia'], 2, '.', ','); ?></td>
                      <td><?php echo $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','); ?></td>
                                </tr>
                        <?php  }  ?>
                      <tr>
                        <td colspan="8"></td>
                        <td><strong><?php echo $ExisteTotal; ?></strong></td>
                        <td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
                        <td><strong><?php echo $simbolo.number_format($CompraTotal, 2, '.', ','); ?></strong></td>
                        <td><strong><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></strong></td>
                      </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA KARDEX VALORIZADO POR SUCURSAL ##########################
?>

<?php 
########################### BUSQUEDA KARDEX VALORIZADO POR FECHAS Y VENDEDOR ##########################
if (isset($_GET['BuscaKardexFechas']) && isset($_GET['codsucursal']) && isset($_GET['codigo']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$codigo = limpiar($_GET['codigo']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($codigo=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE VENDEDOR PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarKardexValorizadoxFechas();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Kardex Productos Valorizado por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("VALORIZADOXFECHAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("VALORIZADOXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("VALORIZADOXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Nombre de Vendedor: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Código</th>
                                  <th>Descripción de Producto</th>
                                  <th>Marca</th>
                                  <th>Modelo</th>
                                  <th>Desc</th>
                                  <th>Precio de Venta</th>
                                  <th>Existencia</th>
                                  <th>Vendido</th>
                                  <th>Total Venta</th>
                                  <th>Total Compra</th>
                                  <th>Ganancias</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                      <td><?php echo $a++; ?></div></td>
                      <td><?php echo $reg[$i]['codproducto']; ?></td>
                      <td><?php echo $reg[$i]['producto']; ?></td>
                      <td><?php echo $reg[$i]['nommarca']; ?></td>
                      <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']; ?></td>
                      <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
                      <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
                      <td><?php echo $reg[$i]['existencia']; ?></td>
                      <td><?php echo $reg[$i]['cantidad']; ?></td>
                      <td><?php echo $simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['cantidad']-$reg[$i]['descproducto']/100, 2, '.', ','); ?></td>
                      <td><?php echo $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
                      <td><?php echo $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','); ?></td>
                                </tr>
                        <?php  }  ?>
                      <tr>
                        <td colspan="6"></td>
                        <td><strong><?php echo $simbolo.number_format($PrecioVentaTotal, 2, '.', ','); ?></strong></td>
                        <td><strong><?php echo $ExisteTotal; ?></strong></td>
                        <td><strong><?php echo $VendidosTotal; ?></strong></td>
                        <td><strong><?php echo $simbolo.number_format($VentaTotal, 2, '.', ','); ?></strong></td>
                        <td><strong><?php echo $simbolo.number_format($CompraTotal, 2, '.', ','); ?></strong></td>
                        <td><strong><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></strong></td>
                      </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA KARDEX VALORIZADO POR FECHAS Y VENDEDOR ##########################
?>



































<?php
######################## MOSTRAR TRASPASOS EN VENTANA MODAL ########################
if (isset($_GET['BuscaTraspasoModal']) && isset($_GET['codtraspaso']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->TraspasosPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

  if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TRASPASOS Y DETALLES ACTUALMENTE </center>";
    echo "</div>";    

} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-dark">SUCURSAL ENVIA</b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['nomsucursal']; ?>
  <br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?>
  <br/>DIREC: <?php echo $reg[0]['provincia'] == '' ? "" : strtoupper($reg[0]['provincia']); ?> <?php echo $reg[0]['departamento'] == '' ? "" : strtoupper($reg[0]['departamento']); ?> <?php echo $reg[0]['direcsucursal'] == '' ? "*********" : $reg[0]['direcsucursal']; ?>
  <br/> EMAIL: <?php echo $reg[0]['correosucursal'] == '' ? "**********" : $reg[0]['correosucursal']; ?></p>

  <h4><b class="text-dark">Nº TRASPASO <?php echo $reg[0]['codfactura']; ?></b></h4>
  <p class="text-muted m-l-5">FECHA DE TRASPASO: <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechatraspaso'])); ?>
  <br/> OBSERVACIONES: <?php echo $reg[0]['observaciones'] == '' ? "**********" : $reg[0]['observaciones']; ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-dark">SUCURSAL RECIBE</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nomsucursal2']; ?>
  <br/> Nº <?php echo $reg[0]['documsucursal2'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['cuitsucursal2']; ?> - TLF: <?php echo $reg[0]['tlfsucursal2']; ?>
  <?php echo $reg[0]['direcsucursal2'] == '' ? "" : "<br/>".$reg[0]['direcsucursal2']; ?>
  <?php echo $reg[0]['provincia2'] == '' ? "" : "<br/>".$reg[0]['provincia2']; ?> <?php echo $reg[0]['departamento2'] == '' ? "" : strtoupper($reg[0]['departamento2']); ?>
  <br/> EMAIL: <?php echo $reg[0]['correosucursal2'] == '' ? "**********" : $reg[0]['correosucursal2'] ?></p>
                                            
                                        </address>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-10" style="clear: both;">
                                        <table class="table table-hover">
                               <thead>
                        <tr>
                        <th>#</th>
                        <th>Descripción de Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
    <?php if ($_SESSION['acceso'] == "administradorS") { ?><th>Acción</th><?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesTraspasos();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto']; 
?>
              <tr>
      <td><?php echo $a++; ?></td>
      <td class="text-left"><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5>
      <small>MARCA (<?php echo $detalle[$i]['nommarca'] == '' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['nommodelo'] == '' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
      <td><?php echo $detalle[$i]['cantidad']; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($reg[0]['iva'], 2, '.', ',')."%" : "(E)"; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetalleTraspasoModal('<?php echo encrypt($detalle[$i]["coddetalletraspaso"]); ?>','<?php echo encrypt($detalle[$i]["codtraspaso"]); ?>','<?php echo encrypt($reg[0]["recibe"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLETRASPASO") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>


                                                </tr>
                                      <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-12">

                                    <div class="pull-right text-right">
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($SubTotal, 2, '.', ','); ?></p>
<p><b>Gravado  <?php echo number_format($reg[0]['iva'], 2, '.', ',') ?>%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivasi'], 2, '.', ','); ?><p>
<p><b>Exento 0%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivano'], 2, '.', ','); ?></p>
<p><b>Total <?php echo $impuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaliva'], 2, '.', ','); ?> </p>
<p><b>Descontado %:</b> <?php echo $simbolo.number_format($reg[0]['descontado'], 2, '.', ','); ?> </p>
<p><b>Desc. Global (<?php echo number_format($reg[0]['descuento'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaldescuento'], 2, '.', ','); ?> </p>
                                        <hr>
<h4><b>Importe Total:</b> <?php echo $simbolo.number_format($reg[0]['totalpago'], 2, '.', ','); ?></h4></div>
                                    <div class="clearfix"></div>
                                    <hr>

                                <div class="col-md-12">
                                    <div class="text-right">
 <a href="reportepdf?codtraspaso=<?php echo encrypt($reg[0]['codtraspaso']); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURATRASPASO") ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"><span><i class="fa fa-print"></i> Imprimir</span></button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                                    </div>
                                </div>
                            </div>
                <!-- .row -->
  <?php
       }
   } 
######################## MOSTRAR TRASPASOS EN VENTANA MODAL ########################
?>


<?php
######################## MOSTRAR DETALLES DE TRASPASOS UPDATE ########################
if (isset($_GET['MuestraDetallesTraspasoUpdate']) && isset($_GET['codtraspaso']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->TraspasosPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

?>

<div class="table-responsive m-t-20">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Código</th>
                        <th>Descripción de Producto</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administradorS") { ?><th>Acción</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesTraspasos();
$a=1;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){ 
$count++;   
?>
                                 <tr>
      <td>
      <input type="text" step="1" min="1" class="form-control cantidad bold" name="cantidad[]" id="cantidad_<?php echo $count; ?>" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoTraspaso(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" style="width: 80px;background:#e4e7ea;border-radius:5px 5px 5px 5px;" onfocus="this.style.background=('#B7F0FF')" onfocus="this.style.background=('#B7F0FF')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e4e7ea');" title="Ingrese Cantidad" value="<?php echo $detalle[$i]["cantidad"]; ?>" required="" aria-required="true">
      <input type="hidden" name="cantidadbd[]" id="cantidadbd" value="<?php echo $detalle[$i]["cantidad"]; ?>">
      <input type="hidden" name="coddetalletraspaso[]" id="coddetalletraspaso" value="<?php echo $detalle[$i]["coddetalletraspaso"]; ?>">
      <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
      <input type="hidden" name="tipodetalle[]" id="tipodetalle" value="<?php echo $detalle[$i]["tipodetalle"]; ?>">
      <input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>"></td>
      
      <td><strong><?php echo $detalle[$i]['codproducto']; ?></strong></td>
      
      <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['nommarca'] == '' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['nommodelo'] == '' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
      
       <td><strong><input type="hidden" name="precioventa[]" id="precioventa_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>"><?php echo number_format($detalle[$i]['precioventa'], 2, '.', ''); ?></strong></td>

       <td><input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["valortotal"], 2, '.', ''); ?>"><strong><label id="txtvalortotal_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valortotal'], 2, '.', ''); ?></label></strong></td>

       <td><input type="hidden" name="descproducto[]" id="descproducto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["descproducto"], 2, '.', ''); ?>">
        <input type="hidden" class="totaldescuentov" name="totaldescuentov[]" id="totaldescuentov_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["totaldescuentov"], 2, '.', ''); ?>">
        <strong><label id="txtdescproducto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['totaldescuentov'], 2, '.', ''); ?></label><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ''); ?>%</sup></strong></td>

      <td><input type="hidden" name="ivaproducto[]" id="ivaproducto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["ivaproducto"]; ?>"><strong><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($reg[0]['iva'], 2, '.', '')."%" : "(E)"; ?></strong></td>

      <td><input type="hidden" class="subtotalivasi" name="subtotalivasi[]" id="subtotalivasi_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

        <input type="hidden" class="subtotalivano" name="subtotalivano[]" id="subtotalivano_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == 'NO' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

        <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?>" >

        <input type="hidden" class="valorneto2" name="valorneto2[]" id="valorneto2_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto2'], 2, '.', ''); ?>" >

        <strong><label id="txtvalorneto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?></label></strong></td>

 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetalleTraspasoUpdate('<?php echo encrypt($detalle[$i]["coddetalletraspaso"]); ?>','<?php echo encrypt($detalle[$i]["codtraspaso"]); ?>','<?php echo encrypt($reg[0]["recibe"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLETRASPASO") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                 </tr>
                     <?php } ?>
                </tbody>
            </table><hr>

             <table id="carritototal" class="table-responsive">
                <tr>
    <td width="250"><h5><label>Gravado <?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>%:</label></h5></td>
    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal" name="lblsubtotal"><?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtsubtotal" id="txtsubtotal" value="<?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ''); ?>"/>    </td>
                  
    <td width="250">
    <h5><label>Exento 0%:</label></h5>    </td>

    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal2" name="lblsubtotal2"><?php echo number_format($reg[0]['subtotalivano'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="<?php echo number_format($reg[0]['subtotalivano'], 2, '.', ''); ?>"/>    </td>
    
    <td width="250"><h5><label><?php echo $impuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>%:<input type="hidden" name="iva" id="iva" autocomplete="off" value="<?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>"></label></h5>
    </td>

    <td class="text-center" width="250">
    <h5><?php echo $simbolo; ?><label id="lbliva" name="lbliva"><?php echo number_format($reg[0]['totaliva'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtIva" id="txtIva" value="<?php echo number_format($reg[0]['totaliva'], 2, '.', ''); ?>"/>
    </td>
                </tr>
                <tr>
    <td>
    <h5><label>Descontado %:</label></h5> </td>
    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescontado" name="lbldescontado"><?php echo number_format($reg[0]['descontado'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtdescontado" id="txtdescontado" value="<?php echo number_format($reg[0]['descontado'], 2, '.', ''); ?>"/>
        </td>
    
    <td>
    <h5><label>Desc. Global <input class="number" type="text" name="descuento" id="descuento" onKeyPress="EvaluateText('%f', this);" style="border-radius:4px;height:30px;width:60px;" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($reg[0]['descuento'], 2, '.', ''); ?>">%:</label></h5>    </td>

    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescuento" name="lbldescuento"><?php echo number_format($reg[0]['totaldescuento'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtDescuento" id="txtDescuento" value="<?php echo number_format($reg[0]['totaldescuento'], 2, '.', ''); ?>"/>    </td>

    <td><h4><b>Importe Total</b></h4>
    </td>

    <td class="text-center">
    <h4><b><?php echo $simbolo; ?><label id="lbltotal" name="lbltotal"><?php echo number_format($reg[0]['totalpago'], 2, '.', ''); ?></label></b></h4>
    <input type="hidden" name="txtTotal" id="txtTotal" value="<?php echo number_format($reg[0]['totalpago'], 2, '.', ''); ?>"/>
    <input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="<?php echo number_format($reg[0]['totalpago2'], 2, '.', ''); ?>"/>    </td>
                    </tr>
                  </table>
        </div>
<?php
  } 
######################## MOSTRAR DETALLES DE TRASPASOS UPDATE ########################
?>

<?php
######################## MOSTRAR DETALLES DE TRASPASOS AGREGAR ########################
if (isset($_GET['MuestraDetallesTrapasoAgregar']) && isset($_GET['codtraspaso']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->TraspasosPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

?>

<div class="table-responsive m-t-20">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Código</th>
                        <th>Descripción de Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administradorS") { ?><th>Acción</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesTraspasos();
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
    ?>
                                 <tr>
      <td><strong><?php echo $a++; ?></td>
      
      <td><strong><?php echo $detalle[$i]['codproducto']; ?></strong></td>

    <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['nommarca'] == '' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['nommodelo'] == '' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>

      <td><strong><?php echo $detalle[$i]['cantidad']; ?></strong></td>
      
      <td><strong><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></strong></td>

       <td><strong><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></strong></td>
      
      <td><strong><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></strong></td>

      <td><strong><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($reg[0]['iva'], 2, '.', ',')."%" : "(E)"; ?></strong></td>

      <td><strong><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></strong></td>

 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetalleTraspasoAgregar('<?php echo encrypt($detalle[$i]["coddetalletraspaso"]); ?>','<?php echo encrypt($detalle[$i]["codtraspaso"]); ?>','<?php echo encrypt($reg[0]["recibe"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLETRASPASO") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                 </tr>
                     <?php } ?>
                </tbody>
            </table>

            <table id="carritototal" class="table-responsive">
                <tr>
    <td width="250"><h5><label>Gravado <?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%:</label></h5></td>
    <td width="250">
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ','); ?></label></h5>
    </td>
                  
    <td width="250">
    <h5><label>Exento 0%:</label></h5>    </td>

    <td width="250">
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['subtotalivano'], 2, '.', ','); ?></label></h5>
    </td>
    
    <td width="250"><h5><label><?php echo $impuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%:</label></h5>
    </td>

    <td class="text-center" width="250">
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totaliva'], 2, '.', ','); ?></label></h5>
    </td>
                </tr>
                <tr>
    <td>
    <h5><label>Descontado %:</label></h5> </td>
    <td>
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['descontado'], 2, '.', ','); ?></label></h5>
        </td>
    
    <td>
    <h5><label>Desc. Global <?php echo number_format($reg[0]['descuento'], 2, '.', ','); ?>%:</label></h5>    </td>

    <td>
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totaldescuento'], 2, '.', ','); ?></label></h5>
    </td>

    <td><h4><b>Importe Total</b></h4>
    </td>

    <td class="text-center">
    <h4><b><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totalpago'], 2, '.', ','); ?></label></b></h4>
    </td>
                    </tr>
                  </table>
          </div>
<?php
  } 
######################## MOSTRAR DETALLES DE TRASPASOS AGREGRA ########################
?>


<?php
######################## BUSQUEDA TRASPASOS POR SUCURSAL ########################
if (isset($_GET['BuscaTraspasosxSucursal']) && isset($_GET['codsucursal'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarTraspasosxSucursal();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Traspasos en Sucursal <?php echo $reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal']; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("TRASPASOSXSUCURSAL") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("TRASPASOSXSUCURSAL") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("TRASPASOSXSUCURSAL") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Traspaso</th>
                                  <th>Sucursal Envia</th>
                                  <th>Sucursal Recibe</th>
                                  <th>Fecha Emisión</th>
                                  <th>Nº de Articulos</th>
                                  <th>Subtotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc%</th>
                                  <th>Imp. Total</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['codfactura']; ?></td>
<td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['cuitsucursal']; ?>"><?php echo $reg[$i]['nomsucursal']; ?></abbr></td>

<td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documsucursal2'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitsucursal2']; ?>"><?php echo $reg[$i]['nomsucursal2']; ?></abbr></td> 
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechatraspaso'])); ?></td> 

    <td><?php echo $reg[$i]['articulos']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  <td> <a href="reportepdf?codtraspaso=<?php echo encrypt($reg[$i]['codtraspaso']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURATRASPASO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php } ?>
         <tr>
          <td colspan="5"></td>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA TRASPASOS POR SUCURSAL ##########################
?>


<?php
######################## BUSQUEDA TRASPASOS POR FECHAS ########################
if (isset($_GET['BuscaTraspasosxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarTraspasosxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Traspasos por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("TRASPASOSXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("TRASPASOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("TRASPASOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Traspaso</th>
                                  <th>Sucursal Envia</th>
                                  <th>Sucursal Recibe</th>
                                  <th>Fecha Emisión</th>
                                  <th>Nº de Articulos</th>
                                  <th>Subtotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc%</th>
                                  <th>Imp. Total</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['codfactura']; ?></td>
<td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['cuitsucursal']; ?>"><?php echo $reg[$i]['nomsucursal']; ?></abbr></td>

<td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documsucursal2'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitsucursal2']; ?>"><?php echo $reg[$i]['nomsucursal2']; ?></abbr></td> 
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechatraspaso'])); ?></td> 

    <td><?php echo $reg[$i]['articulos']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  <td> <a href="reportepdf?codtraspaso=<?php echo encrypt($reg[$i]['codtraspaso']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURATRASPASO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php } ?>
         <tr>
          <td colspan="5"></td>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
######################## BUSQUEDA TRASPASOS POR FECHAS ########################
?>


<?php
########################## BUSQUEDA DETALLES PRODUCTOS TRASPASOS POR FECHAS ##########################
if (isset($_GET['BuscaDetallesTraspasosxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA HASTA</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarDetallesTraspasosxFechas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Traspasos por Fechas </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DETALLESTRASPASOSXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESTRASPASOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESTRASPASOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Código</th>
                                  <th>Descripción</th>
                                  <th>Marca</th>
                                  <th>Modelo</th>
                                  <th>Desc</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Precio de Venta</th>
                                  <th>Existencia</th>
                                  <th>Traspasado</th>
                                  <th>Monto Total</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                      <td><?php echo $a++; ?></td>
                      <td><?php echo $reg[$i]['codproducto']; ?></td>
                      <td><?php echo $reg[$i]['producto']; ?></td>
                      <td><?php echo $reg[$i]['codmarca'] == '0' ? "**********" : $reg[$i]['nommarca']; ?></td>
                      <td><?php echo $reg[$i]['codmodelo'] == '' ? "*****" : $reg[$i]['nommodelo']; ?></td>
                      <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
                      <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
                      <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
                      <td><?php echo $reg[$i]['existencia']; ?></td>
                      <td><?php echo $reg[$i]['cantidad']; ?></td>
                      <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
                                </tr>
                        <?php  }  ?>
                      <tr>
                        <td colspan="7"></td>
                        <td><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
                        <td><?php echo $ExisteTotal; ?></td>
                        <td><?php echo $VendidosTotal; ?></td>
                        <td><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></td>
                      </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA DETALLES PRODUCTOS TRASPASOS POR FECHAS ##########################
?>































<?php
######################## MOSTRAR COMPRA PAGADA EN VENTANA MODAL ########################
if (isset($_GET['BuscaCompraPagadaModal']) && isset($_GET['codcompra']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->ComprasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

  if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COMPRAS Y DETALLES ACTUALMENTE </center>";
    echo "</div>";    

} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-dark">SUCURSAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?></p>

  <h4><b class="text-dark">Nº COMPRA <?php echo $reg[0]['codcompra']; ?></b></h4>
  <p class="text-muted m-l-5">STATUS: 
  <?php if($reg[0]['fechavencecredito']== '0000-00-00') { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[0]["statuscompra"]."</span>"; } 
        elseif($reg[0]['fechavencecredito'] >= date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-success'><i class='fa fa-exclamation-circle'></i> ".$reg[0]["statuscompra"]."</span>"; } 
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA</span>"; }
        elseif($reg[0]['fechavencecredito'] <= date("Y-m-d") && $reg[0]['fechapagado']!= "0000-00-00") { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[0]["statuscompra"]."</span>"; } ?>

  <?php if($reg[0]['fechavencecredito']!= "0000-00-00") { ?>
  <br>DIAS VENCIDOS: 
  <?php if($reg[0]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[0]['fechavencecredito'] >= date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']); }
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[0]['fechapagado'],$reg[0]['fechavencecredito']); } ?>
  <?php } ?>
  
  <?php if($reg[0]['fechapagado']!= "0000-00-00") { ?>
  <br>FECHA PAGADA: <?php echo date("d-m-Y",strtotime($reg[0]['fechapagado'])); ?>
  <?php } ?>

  <br>FECHA DE EMISIÓN: <?php echo date("d-m-Y",strtotime($reg[0]['fechaemision'])); ?>
  <br/> FECHA DE RECEPCIÓN: <?php echo date("d-m-Y",strtotime($reg[0]['fecharecepcion'])); ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-dark">PROVEEDOR</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nomproveedor'] == '' ? "*******" : $reg[0]['nomproveedor']; ?>,
  <?php echo $reg[0]['direcproveedor'] == '' ? "" : "<br/>".$reg[0]['direcproveedor']; ?>
  <?php echo $reg[0]['provincia2'] == '' ? "" : "<br/>".$reg[0]['provincia2']; ?> <?php echo $reg[0]['departamento2'] == '' ? "" : strtoupper($reg[0]['departamento2']); ?>
  <br/> EMAIL: <?php echo $reg[0]['emailproveedor'] == '' ? "*******" : $reg[0]['emailproveedor']; ?>
  <br/> Nº <?php echo $reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['cuitproveedor'] == '' ? "*******" : $reg[0]['cuitproveedor']; ?> - TLF: <?php echo $reg[0]['tlfproveedor'] == '' ? "*******" : $reg[0]['tlfproveedor']; ?>
  <br/> VENDEDOR: <?php echo $reg[0]['vendedor']; ?> - TLF: <?php echo $reg[0]['tlfvendedor'] == '' ? "*******" : $reg[0]['tlfvendedor']; ?></p>
                                            
                                        </address>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-10" style="clear: both;">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                        <th>#</th>
                        <th>Descripción de Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administradorS") { ?><th>Acción</th><?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesCompras();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto']; 
?>
                                                <tr>
      <td><?php echo $a++; ?></td>
      <td class="text-left"><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5>
      <small>MARCA (<?php echo $detalle[$i]['nommarca'] == '' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['nommodelo'] == '' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
      <td><?php echo $detalle[$i]['cantcompra']; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['preciocomprac'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descfactura'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $detalle[$i]['ivaproductoc'] == 'SI' ? number_format($reg[0]['ivac'], 2, '.', ',')."%" : "(E)"; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesComprasPagadasModal('<?php echo encrypt($detalle[$i]["coddetallecompra"]); ?>','<?php echo encrypt($detalle[$i]["codcompra"]); ?>','<?php echo encrypt($reg[0]["codproveedor"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESCOMPRAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                                </tr>
                                      <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="col-md-12">

                                    <div class="pull-right text-right">
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($SubTotal, 2, '.', ','); ?></p>
<p><b>Gravado  <?php echo number_format($reg[0]['ivac'], 2, '.', ',') ?>%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivasic'], 2, '.', ','); ?></p>
<p><b>Exento 0%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivanoc'], 2, '.', ','); ?></p>
<p><b>Total <?php echo $impuesto; ?> (<?php echo number_format($reg[0]['ivac'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totalivac'], 2, '.', ','); ?> </p>
<p><b>Descontado %:</b> <?php echo $simbolo.number_format($reg[0]['descontadoc'], 2, '.', ','); ?> </p>
<p><b>Desc. Global (<?php echo number_format($reg[0]['descuentoc'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaldescuentoc'], 2, '.', ','); ?> </p>
                                        <hr>
<h4><b>Importe Total :</b> <?php echo $simbolo.number_format($reg[0]['totalpagoc'], 2, '.', ','); ?></h4></div>
                                    <div class="clearfix"></div>
                                    <hr>
                                <div class="col-md-12">
                                    <div class="text-right">
 <a href="reportepdf?codcompra=<?php echo encrypt($reg[0]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"><span><i class="fa fa-print"></i> Imprimir</span> </button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                                    </div>
                                </div>
                            </div>
                <!-- .row -->

  <?php
       }
   } 
######################## MOSTRAR COMPRA PAGADA EN VENTANA MODAL ########################
?>

<?php
####################### MOSTRAR COMPRA PENDIENTE EN VENTANA MODAL #######################
if (isset($_GET['BuscaCompraPendienteModal']) && isset($_GET['codcompra']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->ComprasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

  if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COMPRAS Y DETALLES ACTUALMENTE </center>";
    echo "</div>";    

} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-dark">SUCURSAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/>Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?></p>

  <h4><b class="text-dark">Nº COMPRA <?php echo $reg[0]['codcompra']; ?></b></h4>
  <p class="text-muted m-l-5">STATUS: 
  <?php if($reg[0]['fechavencecredito']== '0000-00-00') { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[0]["statuscompra"]."</span>"; } 
        elseif($reg[0]['fechavencecredito'] >= date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-success'><i class='fa fa-exclamation-circle'></i> ".$reg[0]["statuscompra"]."</span>"; } 
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA</span>"; }
        elseif($reg[0]['fechavencecredito'] <= date("Y-m-d") && $reg[0]['fechapagado']!= "0000-00-00") { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[0]["statuscompra"]."</span>"; } ?>

  <br>TOTAL FACTURA: <?php echo $simbolo.number_format($reg[0]['totalpagoc'], 2, '.', ','); ?>
  <br>TOTAL ABONO: <?php echo $simbolo.number_format($reg[0]['abonototal'], 2, '.', ','); ?>
  <br>TOTAL DEBE: <?php echo $simbolo.number_format($reg[0]['totalpagoc']-$reg[0]['abonototal'], 2, '.', ','); ?>
  <?php if($reg[0]['fechavencecredito']!= "0000-00-00") { ?>
  <br>DIAS VENCIDOS: 
  <?php if($reg[0]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[0]['fechavencecredito'] >= date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']); }
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[0]['fechapagado'],$reg[0]['fechavencecredito']); } ?>
  <?php } ?>
  
  <?php if($reg[0]['fechapagado']!= "0000-00-00") { ?>
  <br>FECHA PAGADA: <?php echo date("d-m-Y",strtotime($reg[0]['fechapagado'])); ?>
  <?php } ?>

  <br>FECHA DE EMISIÓN: <?php echo date("d-m-Y",strtotime($reg[0]['fechaemision'])); ?>
  <br/> FECHA DE RECEPCIÓN: <?php echo date("d-m-Y",strtotime($reg[0]['fecharecepcion'])); ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-dark">PROVEEDOR</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nomproveedor'] == '' ? "*******" : $reg[0]['nomproveedor']; ?>,
  <?php echo $reg[0]['direcproveedor'] == '' ? "" : "<br/>".$reg[0]['direcproveedor']; ?>
  <?php echo $reg[0]['provincia2'] == '' ? "" : "<br/>".$reg[0]['provincia2']; ?> <?php echo $reg[0]['departamento2'] == '' ? "" : strtoupper($reg[0]['departamento2']); ?>
  <br/> EMAIL: <?php echo $reg[0]['emailproveedor'] == '' ? "*******" : $reg[0]['emailproveedor']; ?>
  <br/> Nº <?php echo $reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['cuitproveedor'] == '' ? "*******" : $reg[0]['cuitproveedor']; ?> - TLF: <?php echo $reg[0]['tlfproveedor'] == '' ? "*******" : $reg[0]['tlfproveedor']; ?>
  <br/> VENDEDOR: <?php echo $reg[0]['vendedor']; ?> - TLF: <?php echo $reg[0]['tlfvendedor'] == '' ? "*******" : $reg[0]['tlfvendedor']; ?></p>
                                            
                                        </address>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-10" style="clear: both;">
                                        <table class="table table-hover">
                                            <thead>
                                              <tr>
                        <th>#</th>
                        <th>Descripción de Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administradorS") { ?><th>Acción</th><?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesCompras();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto']; 
?>
                                                <tr>
      <td><?php echo $a++; ?></td>
      <td class="text-left"><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5>
      <small>MARCA (<?php echo $detalle[$i]['nommarca'] == '' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['nommodelo'] == '' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
      <td><?php echo $detalle[$i]['cantcompra']; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['preciocomprac'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descfactura'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $detalle[$i]['ivaproductoc'] == 'SI' ? number_format($reg[0]['ivac'], 2, '.', ',')."%" : "(E)"; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesComprasPendientesModal('<?php echo encrypt($detalle[$i]["coddetallecompra"]); ?>','<?php echo encrypt($detalle[$i]["codcompra"]); ?>','<?php echo encrypt($reg[0]["codproveedor"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESCOMPRAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                                </tr>
                                      <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="col-md-12">

                                    <div class="pull-right text-right">
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($SubTotal, 2, '.', ','); ?></p>
<p><b>Gravado  <?php echo number_format($reg[0]['ivac'], 2, '.', ',') ?>%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivasic'], 2, '.', ','); ?></p>
<p><b>Exento 0%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivanoc'], 2, '.', ','); ?></p>
<p><b>Total <?php echo $impuesto; ?> (<?php echo number_format($reg[0]['ivac'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totalivac'], 2, '.', ','); ?> </p>
<p><b>Descontado %:</b> <?php echo $simbolo.number_format($reg[0]['descontadoc'], 2, '.', ','); ?> </p>
<p><b>Desc. Global (<?php echo number_format($reg[0]['descuentoc'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaldescuentoc'], 2, '.', ','); ?> </p>
                                        <hr>
<h4><b>Importe Total :</b> <?php echo $simbolo.number_format($reg[0]['totalpagoc'], 2, '.', ','); ?></h4></div>
                                    <div class="clearfix"></div>
                                    <hr>

                                <div class="col-md-12">
                                    <div class="text-right">
 <a href="reportepdf?codcompra=<?php echo encrypt($reg[0]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"><span><i class="fa fa-print"></i> Imprimir</span></button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                                    </div>
                                </div>
                            </div>
                <!-- .row -->

  <?php
       }
   } 
####################### MOSTRAR COMPRA PENDIENTE EN VENTANA MODAL ######################
?>


<?php
######################### MOSTRAR DETALLES DE COMPRAS UPDATE ##########################
if (isset($_GET['MuestraDetallesComprasUpdate']) && isset($_GET['codcompra']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->ComprasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

?>

<div class="table-responsive m-t-20">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Código</th>
                        <th>Descripción de Producto</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administradorS") { ?><th>Acción</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesCompras();
$a=1;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){ 
$count++; 
?>
                                 <tr>
      <td>
      <input type="text" step="1" min="1" class="form-control cantidad bold" name="cantcompra[]" id="cantcompra_<?php echo $count; ?>" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoCompra(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" style="width: 80px;background:#e4e7ea;border-radius:5px 5px 5px 5px;" onfocus="this.style.background=('#B7F0FF')" onfocus="this.style.background=('#B7F0FF')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e4e7ea');" title="Ingrese Cantidad" value="<?php echo $detalle[$i]["cantcompra"]; ?>" required="" aria-required="true">
      <input type="hidden" name="cantidadcomprabd[]" id="cantidadcomprabd" value="<?php echo $detalle[$i]["cantcompra"]; ?>">
      <input type="hidden" name="coddetallecompra[]" id="coddetallecompra" value="<?php echo $detalle[$i]["coddetallecompra"]; ?>">
      <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
      </td>
      
      <td><strong><?php echo $detalle[$i]['codproducto']; ?></strong></td>
      
      <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['nommarca'] == '' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['nommodelo'] == '' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
      
      <td><strong><input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["preciocomprac"], 2, '.', ''); ?>"><?php echo number_format($detalle[$i]['preciocomprac'], 2, '.', ''); ?></strong></td>

      <td><input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["valortotal"], 2, '.', ''); ?>"><strong><label id="txtvalortotal_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></label></strong></td>
      
      <td>
    <input type="hidden" name="descfactura[]" id="descfactura_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["descfactura"], 2, '.', ','); ?>">
    <input type="hidden" class="totaldescuentoc" name="totaldescuentoc[]" id="totaldescuentoc_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["totaldescuentoc"], 2, '.', ','); ?>">
    <strong><label id="txtdescproducto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['totaldescuentoc'], 2, '.', ','); ?></label><sup><?php echo number_format($detalle[$i]['descfactura'], 2, '.', ','); ?>%</sup></strong></td>

      <td><input type="hidden" name="ivaproducto[]" id="ivaproducto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["ivaproductoc"]; ?>"><strong><?php echo $detalle[$i]['ivaproductoc'] == 'SI' ? number_format($reg[0]['ivac'], 2, '.', '')."%" : "(E)"; ?></strong></td>

      <td><input type="hidden" class="subtotalivasi" name="subtotalivasi[]" id="subtotalivasi_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproductoc'] == 'SI' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

        <input type="hidden" class="subtotalivano" name="subtotalivano[]" id="subtotalivano_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproductoc'] == 'NO' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

        <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?>" ><strong> <label id="txtvalorneto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></label></strong></td>

 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesComprasUpdate('<?php echo encrypt($detalle[$i]["coddetallecompra"]); ?>','<?php echo encrypt($detalle[$i]["codcompra"]); ?>','<?php echo encrypt($reg[0]["codproveedor"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESCOMPRAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                 </tr>
                     <?php } ?>
                </tbody>
            </table><hr>

            <table id="carritototal" class="table-responsive">
                <tr>
    <td width="250"><h5><label>Gravado <?php echo number_format($reg[0]['ivac'], 2, '.', ''); ?>%:</label></h5></td>
    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal" name="lblsubtotal"><?php echo number_format($reg[0]['subtotalivasic'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtsubtotal" id="txtsubtotal" value="<?php echo number_format($reg[0]['subtotalivasic'], 2, '.', ''); ?>"/>    </td>
                  
    <td width="250">
    <h5><label>Exento 0%:</label></h5>    </td>

    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal2" name="lblsubtotal2"><?php echo number_format($reg[0]['subtotalivanoc'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="<?php echo number_format($reg[0]['subtotalivanoc'], 2, '.', ''); ?>"/>    </td>
    
    <td width="250"><h5><label><?php echo $impuesto; ?> <?php echo number_format($reg[0]['ivac'], 2, '.', ''); ?>%:<input type="hidden" name="iva" id="iva" autocomplete="off" value="<?php echo number_format($reg[0]['ivac'], 2, '.', ''); ?>"></label></h5>
    </td>

    <td class="text-center" width="250">
    <h5><?php echo $simbolo; ?><label id="lbliva" name="lbliva"><?php echo number_format($reg[0]['totalivac'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtIva" id="txtIva" value="<?php echo number_format($reg[0]['totalivac'], 2, '.', ''); ?>"/>
    </td>
                </tr>
                <tr>
    <td>
    <h5><label>Descontado %:</label></h5> </td>
    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescontado" name="lbldescontado"><?php echo number_format($reg[0]['descontadoc'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtdescontado" id="txtdescontado" value="<?php echo number_format($reg[0]['descontadoc'], 2, '.', ''); ?>"/>
        </td>
    
    <td>
    <h5><label>Desc. Global <input class="number" type="text" name="descuento" id="descuento" onKeyPress="EvaluateText('%f', this);" style="border-radius:4px;height:30px;width:60px;" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($reg[0]['descuentoc'], 2, '.', ''); ?>">%:</label></h5>    </td>

    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescuento" name="lbldescuento"><?php echo number_format($reg[0]['totaldescuentoc'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtDescuento" id="txtDescuento" value="<?php echo number_format($reg[0]['totaldescuentoc'], 2, '.', ''); ?>"/>    </td>

    <td><h4><b>Importe Total</b></h4>
    </td>

    <td class="text-center">
    <h4><b><?php echo $simbolo; ?><label id="lbltotal" name="lbltotal"><?php echo number_format($reg[0]['totalpagoc'], 2, '.', ''); ?></label></b></h4>
    <input type="hidden" name="txtTotal" id="txtTotal" value="<?php echo number_format($reg[0]['totalpagoc'], 2, '.', ''); ?>"/></td>
                    </tr>
                  </table>
        </div>

<?php
  } 
######################### MOSTRAR DETALLES DE COMPRAS UPDATE ##########################
?>


<?php
########################## BUSQUEDA COMPRAS POR PROVEEDORES ##########################
if (isset($_GET['BuscaComprasxProvedores']) && isset($_GET['codsucursal']) && isset($_GET['codproveedor'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codproveedor = limpiar($_GET['codproveedor']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codproveedor=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE PROVEEDOR PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarComprasxProveedor();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Compras de Productos por Proveedor</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codproveedor=<?php echo $codproveedor; ?>&codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("COMPRASXPROVEEDOR") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codproveedor=<?php echo $codproveedor; ?>&codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COMPRASXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codproveedor=<?php echo $codproveedor; ?>&codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COMPRASXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label"><?php echo "Nº ".$documento = ($reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']); ?> de Proveedor: </label> <?php echo $reg[0]['cuitproveedor']; ?><br>

            <label class="control-label">Nombre de Proveedor: </label> <?php echo $reg[0]['nomproveedor']; ?>
        </div>
      </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                              <th>Nº</th>
                              <th>N° de Compra</th>
                              <th>Descripción de Proveedor</th>
                              <th>Status</th>
                              <th>Dias Venc.</th>
                              <th>Fecha de Emisión</th>
                              <th>Fecha de Recepción</th>
                              <th>Nº de Articulos</th>
                              <th>Subtotal</th>
                              <th><?php echo $impuesto; ?></th>
                              <th>Desc%</th>
                              <th>Imp. Total</th>
                              <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                    <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codcompra']; ?></td>
 <td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']; ?>"><?php echo $reg[$i]['nomproveedor']; ?></abbr></td>
                    <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-success'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA</span>"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } ?></td>
<td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
          <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
          <td><?php echo date("d-m-Y",strtotime($reg[$i]['fecharecepcion'])); ?></td>

          <td><?php echo $reg[$i]['articulos']; ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['totalivac'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['ivac'], 2, '.', ','); ?>%</sup></td>
          <td><?php echo $simbolo.number_format($reg[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuentoc'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
                    <td>
<a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                </tr>
                        <?php  }  ?>
         <tr>
          <td colspan="7"></td>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA COMPRAS POR PROVEEDORES ##########################
?>


<?php
######################### BUSQUEDA COMPRAS POR FECHAS ########################
if (isset($_GET['BuscaComprasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarComprasxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Compras de Productos por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("COMPRASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COMPRASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COMPRASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                              <th>Nº</th>
                              <th>N° de Compra</th>
                              <th>Descripción de Proveedor</th>
                              <th>Status</th>
                              <th>Dias Venc.</th>
                              <th>Fecha de Emisión</th>
                              <th>Fecha de Recepción</th>
                              <th>Nº de Articulos</th>
                              <th>Subtotal</th>
                              <th><?php echo $impuesto; ?></th>
                              <th>Desc%</th>
                              <th>Imp. Total</th>
                              <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                    <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codcompra']; ?></td>
 <td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']; ?>"><?php echo $reg[$i]['nomproveedor']; ?></abbr></td>
                    <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-success'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA</span>"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } ?></td>
<td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
          <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
          <td><?php echo date("d-m-Y",strtotime($reg[$i]['fecharecepcion'])); ?></td>

          <td><?php echo $reg[$i]['articulos']; ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['totalivac'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['ivac'], 2, '.', ','); ?>%</sup></td>
          <td><?php echo $simbolo.number_format($reg[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuentoc'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
                    <td>
<a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                </tr>
                        <?php  }  ?>
         <tr>
          <td colspan="7"></td>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA COMPRAS POR FECHAS ##########################
?>

<?php
########################## BUSQUEDA CREDITOS POR PROVEEDOR ##########################
if (isset($_GET['BuscaCreditosxProveedor']) && isset($_GET['codsucursal']) && isset($_GET['codproveedor'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codproveedor = limpiar($_GET['codproveedor']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codproveedor=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE PROVEEDOR PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarCreditosxProveedor();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Créditos Compras por Proveedor</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codproveedor=<?php echo $codproveedor; ?>&tipo=<?php echo encrypt("CREDITOSXPROVEEDOR") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codproveedor=<?php echo $codproveedor; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CREDITOSXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codproveedor=<?php echo $codproveedor; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CREDITOSXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label"><?php echo "Nº ".$documento = ($reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']); ?> de Proveedor: </label> <?php echo $reg[0]['cuitproveedor']; ?><br>

            <label class="control-label">Nombre de Proveedor: </label> <?php echo $reg[0]['nomproveedor']; ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Compra</th>
                                  <th>Descripción de Proveedor</th>
                                  <th>Status</th>
                                  <th>Dias Venc</th>
                                  <th>Fecha Emisión</th>
                                  <th>Imp. Total</th>
                                  <th>Total Abono</th>
                                  <th>Total Debe</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['codcompra']; ?></td>
  <td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']; ?>"><?php echo $reg[$i]['nomproveedor']; ?></abbr></td>
      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-success'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA</span>"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } ?></td>

<td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
  <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['abonototal'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc']-$reg[$i]['abonototal'], 2, '.', ','); ?></td>

  <td> <button type="button" class="btn btn-info btn-rounded waves-effect waves-light" data-placement="left" title="Abonar" data-original-title="" data-href="#" data-toggle="modal" data-target="#ModalAbonosProveedor" data-backdrop="static" data-keyboard="false" onClick="AbonoCreditoProveedor('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt($reg[$i]["codproveedor"]); ?>',
'<?php echo $reg[$i]["codcompra"]; ?>',
'<?php echo number_format($reg[$i]['totalpagoc']-$reg[$i]['abonototal'], 2, '.', ''); ?>',
'<?php echo $reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3'].": ".$reg[$i]["cuitproveedor"]; ?>',
'<?php echo $reg[$i]["nomproveedor"]; ?>',
'<?php echo $reg[$i]["codcompra"]; ?>',
'<?php echo number_format($reg[$i]["totalpagoc"], 2, '.', ''); ?>',
'<?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?>',
'<?php echo number_format($total = ( $reg[$i]['abonototal'] == '' ? "0.00" : $reg[$i]['abonototal']), 2, '.', ''); ?>',
'<?php echo number_format($reg[$i]['totalpagoc']-$reg[$i]['abonototal'], 2, '.', ''); ?>')"><i class="fa fa-credit-card"></i></button>

<a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCOMPRA"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-warning text-white" title="Imprimir Pdf"><i class="fa fa-folder-open-o"></i></button></a>

<a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
</td>
                                  </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="6"></td>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
<td></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA CREDITOS POR PROVEEDOR ##########################
?>


<?php
########################## BUSQUEDA CREDITOS DE COMPRAS POR FECHAS ##########################
if (isset($_GET['BuscaCreditosComprasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarCreditosComprasxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Créditos por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("CREDITOSCOMPRASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CREDITOSCOMPRASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CREDITOSCOMPRASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Compra</th>
                                  <th>Descripción de Proveedor</th>
                                  <th>Status</th>
                                  <th>Dias Venc</th>
                                  <th>Fecha Emisión</th>
                                  <th>Imp. Total</th>
                                  <th>Total Abono</th>
                                  <th>Total Debe</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['codcompra']; ?></td>
  <td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']; ?>"><?php echo $reg[$i]['nomproveedor']; ?></abbr></td>
      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-success'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA</span>"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } ?></td>

<td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
  <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['abonototal'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc']-$reg[$i]['abonototal'], 2, '.', ','); ?></td>

<td><a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCOMPRA"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-warning text-white" title="Imprimir Pdf"><i class="fa fa-folder-open-o"></i></button></a>

<a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
</td>
                                  </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="6"></td>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
<td></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA CREDITOS DE COMPRAS POR FECHAS ##########################
?>




























<?php
######################## MOSTRAR COTIZACIONES EN VENTANA MODAL #########################
if (isset($_GET['BuscaCotizacionModal']) && isset($_GET['codcotizacion']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->CotizacionesPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

  if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COTIZACIONES Y DETALLES ACTUALMENTE </center>";
    echo "</div>";    

} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-dark">SUCURSAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?></p>

  <h4><b class="text-dark">Nº COTIZACIÓN <?php echo $reg[0]['codfactura']; ?></b></h4>
  <p class="text-muted m-l-5">FECHA DE EMISIÓN: <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechacotizacion'])); ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-dark">CLIENTE</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nomcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']; ?>,
  <?php echo $reg[0]['direccliente'] == '' ? "" : "<br/>".$reg[0]['direccliente']; ?>
  <?php echo $reg[0]['provincia2'] == '' ? "" : "<br/>".$reg[0]['provincia2']; ?> <?php echo $reg[0]['departamento2'] == '' ? "" : strtoupper($reg[0]['departamento2']); ?>
  <br/> EMAIL: <?php echo $reg[0]['emailcliente'] == '' ? "*******" : $reg[0]['emailcliente']; ?>
  <br/> Nº <?php echo $reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['dnicliente'] == '' ? "*******" : $reg[0]['dnicliente']; ?> - TLF: <?php echo $reg[0]['tlfcliente'] == '' ? "*******" : $reg[0]['tlfcliente']; ?></p>
                                            
                                        </address>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-10" style="clear: both;">
                                        <table class="table table-hover">
                               <thead>
                        <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administradorS") { ?><th>Acción</th><?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesCotizaciones();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto'];
?>
                                                <tr>
      <td><strong><?php echo $a++; ?></strong></td>
      <td class="text-left"><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5>
      <small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
      <td><?php echo $detalle[$i]['cantcotizacion']; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($reg[0]['iva'], 2, '.', ',')."%" : "(E)"; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesCotizacionModal('<?php echo encrypt($detalle[$i]["coddetallecotizacion"]); ?>','<?php echo encrypt($detalle[$i]["codcotizacion"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESCOTIZACIONES") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                                </tr>
                                      <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="col-md-12">

                                    <div class="pull-right text-right">
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($SubTotal, 2, '.', ','); ?></p>
<p><b>Gravado  <?php echo number_format($reg[0]['iva'], 2, '.', ',') ?>%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivasi'], 2, '.', ','); ?><p>
<p><b>Exento 0%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivano'], 2, '.', ','); ?></p>
<p><b>Total <?php echo $impuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaliva'], 2, '.', ','); ?> </p>
<p><b>Descontado %:</b> <?php echo $simbolo.number_format($reg[0]['descontado'], 2, '.', ','); ?> </p>
<p><b>Desc. Global (<?php echo number_format($reg[0]['descuento'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaldescuento'], 2, '.', ','); ?> </p>
                                        <hr>
<h4><b>Importe Total:</b> <?php echo $simbolo.number_format($reg[0]['totalpago'], 2, '.', ','); ?></h4></div>
                                    <div class="clearfix"></div>
                                    <hr>

                                <div class="col-md-12">
                                    <div class="text-right">
 <a href="reportepdf?codcotizacion=<?php echo encrypt($reg[0]['codcotizacion']); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOTIZACION") ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"> <span><i class="fa fa-print"></i> Imprimir</span></button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                                    </div>
                                </div>
                            </div>
                <!-- .row -->
  <?php
       }
   } 
######################### MOSTRAR COTIZACIONES EN VENTANA MODAL #########################
?>


<?php
####################### MOSTRAR DETALLES DE COTIZACIONES UPDATE #########################
if (isset($_GET['MuestraDetallesCotizacionesUpdate']) && isset($_GET['codcotizacion']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->CotizacionesPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

?>

<div class="table-responsive m-t-20">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administradorS") { ?><th>Acción</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesCotizaciones();
$a=1;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){ 
$count++;  
?>
                                 <tr>
      <td>
      <input type="text" step="1" min="1" class="form-control cantidad bold" name="cantcotizacion[]" id="cantcotizacion_<?php echo $count; ?>" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoCotizacion(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" style="width: 80px;background:#e4e7ea;border-radius:5px 5px 5px 5px;" onfocus="this.style.background=('#B7F0FF')" onfocus="this.style.background=('#B7F0FF')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e4e7ea');" title="Ingrese Cantidad" value="<?php echo $detalle[$i]["cantcotizacion"]; ?>" required="" aria-required="true">
      <input type="hidden" name="cantcotizacionbd[]" id="cantcotizacionbd" value="<?php echo $detalle[$i]["cantcotizacion"]; ?>">
      <input type="hidden" name="coddetallecotizacion[]" id="coddetallecotizacion" value="<?php echo $detalle[$i]["coddetallecotizacion"]; ?>">
      <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
      <input type="hidden" name="tipodetalle[]" id="tipodetalle" value="<?php echo $detalle[$i]["tipodetalle"]; ?>">
      <input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>"></td>
      
      <td class="text-danger alert-link"><?php echo $detalle[$i]['tipodetalle'] == 1 ? "PRODUCTO" : "SERVICIO"; ?></td>
      
      <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
      
      <td><strong><input type="hidden" name="precioventa[]" id="precioventa_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>"><?php echo number_format($detalle[$i]['precioventa'], 2, '.', ''); ?></strong></td>

       <td><input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["valortotal"], 2, '.', ''); ?>"><strong><label id="txtvalortotal_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valortotal'], 2, '.', ''); ?></label></strong></td>

       <td><input type="hidden" name="descproducto[]" id="descproducto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["descproducto"], 2, '.', ''); ?>">
        <input type="hidden" class="totaldescuentov" name="totaldescuentov[]" id="totaldescuentov_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["totaldescuentov"], 2, '.', ''); ?>">
        <strong><label id="txtdescproducto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['totaldescuentov'], 2, '.', ''); ?></label><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ''); ?>%</sup></strong></td>

      <td><input type="hidden" name="ivaproducto[]" id="ivaproducto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["ivaproducto"]; ?>"><strong><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($reg[0]['iva'], 2, '.', '')."%" : "(E)"; ?></strong></td>

       <td><input type="hidden" class="subtotalivasi" name="subtotalivasi[]" id="subtotalivasi_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

        <input type="hidden" class="subtotalivano" name="subtotalivano[]" id="subtotalivano_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == 'NO' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

        <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?>" >

        <input type="hidden" class="valorneto2" name="valorneto2[]" id="valorneto2_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto2'], 2, '.', ''); ?>" >

        <strong> <label id="txtvalorneto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?></label></strong></td>

 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesCotizacionesUpdate('<?php echo encrypt($detalle[$i]["coddetallecotizacion"]); ?>','<?php echo encrypt($detalle[$i]["codcotizacion"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESCOTIZACIONES") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                 </tr>
                     <?php } ?>
                </tbody>
            </table><hr>

            <table id="carritototal" class="table-responsive">
                <tr>
    <td width="250"><h5><label>Gravado <?php echo number_format($reg[0]['iva'], 2, '.', '') ?>%:</label></h5></td>
    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal" name="lblsubtotal"><?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtsubtotal" id="txtsubtotal" value="<?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ''); ?>"/>    </td>
                  
    <td width="250">
    <h5><label>Exento 0%:</label></h5>    </td>

    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal2" name="lblsubtotal2"><?php echo number_format($reg[0]['subtotalivano'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="<?php echo number_format($reg[0]['subtotalivano'], 2, '.', ''); ?>"/>    </td>
    
    <td width="250"><h5><label><?php echo $impuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>%:<input type="hidden" name="iva" id="iva" autocomplete="off" value="<?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>"></label></h5>
    </td>

    <td class="text-center" width="250">
    <h5><?php echo $simbolo; ?><label id="lbliva" name="lbliva"><?php echo number_format($reg[0]['totaliva'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtIva" id="txtIva" value="<?php echo number_format($reg[0]['totaliva'], 2, '.', ''); ?>"/>
    </td>
                </tr>
                <tr>
    <td>
    <h5><label>Descontado %:</label></h5> </td>
    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescontado" name="lbldescontado"><?php echo number_format($reg[0]['descontado'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtdescontado" id="txtdescontado" value="<?php echo number_format($reg[0]['descontado'], 2, '.', ''); ?>"/>
        </td>
    
    <td>
    <h5><label>Desc. Global <input class="number" type="text" name="descuento" id="descuento" onKeyPress="EvaluateText('%f', this);" style="border-radius:4px;height:30px;width:60px;" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($reg[0]['descuento'], 2, '.', ''); ?>">%:</label></h5>    </td>

    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescuento" name="lbldescuento"><?php echo number_format($reg[0]['totaldescuento'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtDescuento" id="txtDescuento" value="<?php echo number_format($reg[0]['totaldescuento'], 2, '.', ''); ?>"/>    </td>

    <td><h4><b>Importe Total</b></h4>
    </td>

    <td class="text-center">
    <h4><b><?php echo $simbolo; ?><label id="lbltotal" name="lbltotal"><?php echo number_format($reg[0]['totalpago'], 2, '.', ''); ?></label></b></h4>
    <input type="hidden" name="txtTotal" id="txtTotal" value="<?php echo number_format($reg[0]['totalpago'], 2, '.', ''); ?>"/>
    <input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="<?php echo number_format($reg[0]['totalpago2'], 2, '.', ''); ?>"/>    </td>
                    </tr>
                  </table>
        </div>
<?php
  } 
####################### MOSTRAR DETALLES DE COTIZACIONES UPDATE #########################
?>

<?php
####################### MOSTRAR DETALLES DE COTIZACIONES AGREGAR #######################
if (isset($_GET['MuestraDetallesCotizacionesAgregar']) && isset($_GET['codcotizacion']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->CotizacionesPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

?>

<div class="table-responsive m-t-20">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administradorS") { ?><th>Acción</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesCotizaciones();
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
    ?>
                                 <tr>
      <td><strong><?php echo $a++; ?></strong></td>
      
      <td class="text-danger alert-link"><?php echo $detalle[$i]['tipodetalle'] == 1 ? "PRODUCTO" : "SERVICIO"; ?></td>
      
      <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5>
    <small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>

      <td><strong><?php echo $detalle[$i]['cantcotizacion']; ?></strong></td>
      
      <td><strong><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></strong></td>

       <td><strong><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></strong></td>
      
      <td><strong><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></strong></td>

      <td><strong><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($reg[0]['iva'], 2, '.', ',')."%" : "(E)"; ?></strong></td>

      <td><strong><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></strong></td>

 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesCotizacionesAgregar('<?php echo encrypt($detalle[$i]["coddetallecotizacion"]); ?>','<?php echo encrypt($detalle[$i]["codcotizacion"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESCOTIZACIONES") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                 </tr>
                     <?php } ?>
                </tbody>
            </table>

            <table id="carritototal" class="table-responsive">
                <tr>
    <td width="250"><h5><label>Gravado <?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%:</label></h5></td>
    <td width="250">
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ','); ?></label></h5>
    </td>
                  
    <td width="250">
    <h5><label>Exento 0%:</label></h5>    </td>

    <td width="250">
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['subtotalivano'], 2, '.', ','); ?></label></h5>
    </td>
    
    <td width="250"><h5><label><?php echo $impuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%:</label></h5>
    </td>

    <td class="text-center" width="250">
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totaliva'], 2, '.', ','); ?></label></h5>
    </td>
                </tr>
                <tr>
    <td>
    <h5><label>Descontado %:</label></h5> </td>
    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescontado" name="lbldescontado"><?php echo number_format($reg[0]['descontado'], 2, '.', ','); ?></label></h5>
        </td>
    
    <td>
    <h5><label>Desc. Global <?php echo number_format($reg[0]['descuento'], 2, '.', ','); ?>%:</label></h5>    </td>

    <td>
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totaldescuento'], 2, '.', ','); ?></label></h5>
    </td>

    <td><h4><b>Importe Total</b></h4>
    </td>

    <td class="text-center">
    <h4><b><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totalpago'], 2, '.', ','); ?></label></b></h4>
    </td>
                    </tr>
                  </table>

            </div>
<?php
  } 
######################## MOSTRAR DETALLES DE COTIZACIONES AGREGRA #######################
?>


<?php
########################## BUSQUEDA COTIZACIONES POR FECHAS ##########################
if (isset($_GET['BuscaCotizacionesxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarCotizacionesxFechas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Cotizaciones por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("COTIZACIONESXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COTIZACIONESXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COTIZACIONESXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Cotización</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Fecha Emisión</th>
                                  <th>Nº de Articulos</th>
                                  <th>Subtotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc%</th>
                                  <th>Imp. Total</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['codfactura']; ?></td>
<td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>  
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechacotizacion'])); ?></td>
          <td><?php echo $reg[$i]['articulos']; ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
          <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  <td> <a href="reportepdf?codcotizacion=<?php echo encrypt($reg[$i]['codcotizacion']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOTIZACION") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
        <?php } ?>
         <tr>
          <td colspan="4"></td>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA COTIZACIONES POR FECHAS ##########################
?>

<?php 
########################### BUSQUEDA DE DETALLES COTIZACIONES POR FECHAS ##########################
if (isset($_GET['BuscaDetallesCotizacionesxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$cotizado = new Login();
$reg = $cotizado->BuscarDetallesCotizacionesxFechas();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Cotizaciones por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DETALLESCOTIZACIONESXFECHAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESCOTIZACIONESXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESCOTIZACIONESXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Tipo</th>
                                  <th>Descripción</th>
                                  <th>Marca</th>
                                  <th>Modelo</th>
                                  <th>Desc</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Precio de Venta</th>
                                  <th>Existencia</th>
                                  <th>Cotizado</th>
                                  <th>Monto Total</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
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
                        <?php  }  ?>
                      <tr>
                        <td colspan="7"></td>
                        <td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
                        <td><strong><?php echo $ExisteTotal; ?></strong></td>
                        <td><strong><?php echo $VendidosTotal; ?></strong></td>
                        <td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
                      </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA DE DETALLES COTIZACIONES POR FECHAS ##########################
?>


<?php 
########################### BUSQUEDA DE DETALLES COTIZACIONES POR VENDEDOR ##########################
if (isset($_GET['BuscaDetallesCotizacionesxVendedor']) && isset($_GET['codsucursal']) && isset($_GET['codigo']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$codigo = limpiar($_GET['codigo']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($codigo=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE VENDEDOR PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarDetallesCotizacionesxVendedor();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Cotizaciones por Vendedor</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DETALLESCOTIZACIONESXVENDEDOR") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESCOTIZACIONESXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESCOTIZACIONESXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Nombre de Vendedor: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Tipo</th>
                                  <th>Descripción</th>
                                  <th>Marca</th>
                                  <th>Modelo</th>
                                  <th>Desc</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Precio de Venta</th>
                                  <th>Existencia</th>
                                  <th>Cotizado</th>
                                  <th>Monto Total</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                      <td><?php echo $a++; ?></div></td>
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
                        <?php  }  ?>
                      <tr>
                        <td colspan="7"></td>
                        <td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
                        <td><strong><?php echo $ExisteTotal; ?></strong></td>
                        <td><strong><?php echo $VendidosTotal; ?></strong></td>
                        <td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
                      </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA DE DETALLES COTIZACIONES POR VENDEDOR ##########################
?>
























<?php
######################## MOSTRAR PREVENTAS EN VENTANA MODAL #########################
if (isset($_GET['BuscaPreventaModal']) && isset($_GET['codpreventa']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->PreventasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

  if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PREVENTAS Y DETALLES ACTUALMENTE </center>";
    echo "</div>";    

} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-dark">SUCURSAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?></p>

  <h4><b class="text-dark">Nº PREVENTA <?php echo $reg[0]['codfactura']; ?></b></h4>
  <p class="text-muted m-l-5">FECHA DE EMISIÓN: <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechapreventa'])); ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-dark">CLIENTE</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nomcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']; ?>,
  <?php echo $reg[0]['direccliente'] == '' ? "" : "<br/>".$reg[0]['direccliente']; ?>
  <?php echo $reg[0]['provincia2'] == '' ? "" : "<br/>".$reg[0]['provincia2']; ?> <?php echo $reg[0]['departamento2'] == '' ? "" : strtoupper($reg[0]['departamento2']); ?>
  <br/> EMAIL: <?php echo $reg[0]['emailcliente'] == '' ? "*******" : $reg[0]['emailcliente']; ?>
  <br/> Nº <?php echo $reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['dnicliente'] == '' ? "*******" : $reg[0]['dnicliente']; ?> - TLF: <?php echo $reg[0]['tlfcliente'] == '' ? "*******" : $reg[0]['tlfcliente']; ?></p>
                                            
                                        </address>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-10" style="clear: both;">
                                        <table class="table table-hover">
                               <thead>
                        <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administradorS") { ?><th>Acción</th><?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesPreventas();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto'];
?>
                                <tr>
      <td><strong><?php echo $a++; ?></strong></td>
      <td class="text-left"><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5>
      <small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
      <td><?php echo $detalle[$i]['cantpreventa']; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($reg[0]['iva'], 2, '.', ',')."%" : "(E)"; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesPreventaModal('<?php echo encrypt($detalle[$i]["coddetallepreventa"]); ?>','<?php echo encrypt($detalle[$i]["codpreventa"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESPREVENTAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                                </tr>
                                      <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="col-md-12">

                                    <div class="pull-right text-right">
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($SubTotal, 2, '.', ','); ?></p>
<p><b>Total Grabado <?php echo number_format($reg[0]['iva'], 2, '.', ',') ?>%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivasi'], 2, '.', ','); ?><p>
<p><b>Total Exento 0%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivano'], 2, '.', ','); ?></p>
<p><b>Total <?php echo $impuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaliva'], 2, '.', ','); ?> </p>
<p><b>Descontado %:</b> <?php echo $simbolo.number_format($reg[0]['descontado'], 2, '.', ','); ?> </p>
<p><b>Desc. Global (<?php echo number_format($reg[0]['descuento'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaldescuento'], 2, '.', ','); ?> </p>
                                        <hr>
<h4><b>Importe Total:</b> <?php echo $simbolo.number_format($reg[0]['totalpago'], 2, '.', ','); ?></h4></div>
                                    <div class="clearfix"></div>
                                    <hr>

                                <div class="col-md-12">
                                    <div class="text-right">
 <a href="reportepdf?codpreventa=<?php echo encrypt($reg[0]['codpreventa']); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETPREVENTA") ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"> <span><i class="fa fa-print"></i> Imprimir</span></button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                                    </div>
                                </div>
                            </div>
                <!-- .row -->
  <?php
       }
   } 
######################### MOSTRAR PREVENTAS EN VENTANA MODAL #########################
?>


<?php
####################### MOSTRAR DETALLES DE PREVENTAS UPDATE #########################
if (isset($_GET['MuestraDetallesPreventasUpdate']) && isset($_GET['codpreventa']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->PreventasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

?>

<div class="table-responsive m-t-20">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administradorS") { ?><th>Acción</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesPreventas();
$a=1;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){ 
$count++;  
?>
                                 <tr>
    <td>
    <input type="text" step="1" min="1" class="form-control cantidad bold" name="cantpreventa[]" id="cantpreventa_<?php echo $count; ?>" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoPreventa(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" style="width: 80px;background:#e4e7ea;border-radius:5px 5px 5px 5px;" onfocus="this.style.background=('#B7F0FF')" onfocus="this.style.background=('#B7F0FF')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e4e7ea');" title="Ingrese Cantidad" value="<?php echo $detalle[$i]["cantpreventa"]; ?>" required="" aria-required="true">
      <input type="hidden" name="cantpreventabd[]" id="cantpreventabd" value="<?php echo $detalle[$i]["cantpreventa"]; ?>">
      <input type="hidden" name="coddetallepreventa[]" id="coddetallepreventa" value="<?php echo $detalle[$i]["coddetallepreventa"]; ?>">
      <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
      <input type="hidden" name="tipodetalle[]" id="tipodetalle" value="<?php echo $detalle[$i]["tipodetalle"]; ?>">
      <input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>">
    </td>
      
    <td class="text-danger alert-link"><?php echo $detalle[$i]['tipodetalle'] == 1 ? "PRODUCTO" : "SERVICIO"; ?></td>
      
    <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
      
    <td><strong><input type="hidden" name="precioventa[]" id="precioventa_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>"><?php echo number_format($detalle[$i]['precioventa'], 2, '.', ''); ?></strong></td>

    <td><input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["valortotal"], 2, '.', ''); ?>"><strong><label id="txtvalortotal_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valortotal'], 2, '.', ''); ?></label></strong></td>
      
    <td><input type="hidden" name="descproducto[]" id="descproducto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["descproducto"], 2, '.', ''); ?>">
        <input type="hidden" class="totaldescuentov" name="totaldescuentov[]" id="totaldescuentov_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["totaldescuentov"], 2, '.', ''); ?>">
        <strong><label id="txtdescproducto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['totaldescuentov'], 2, '.', ''); ?></label><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ''); ?>%</sup></strong></td>

    <td><input type="hidden" name="ivaproducto[]" id="ivaproducto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["ivaproducto"]; ?>"><strong><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($reg[0]['iva'], 2, '.', '')."%" : "(E)"; ?></strong></td>

    <td><input type="hidden" class="subtotalivasi" name="subtotalivasi[]" id="subtotalivasi_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

        <input type="hidden" class="subtotalivano" name="subtotalivano[]" id="subtotalivano_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == 'NO' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

        <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?>" >

        <input type="hidden" class="valorneto2" name="valorneto2[]" id="valorneto2_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto2'], 2, '.', ''); ?>" >

        <strong> <label id="txtvalorneto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?></label></strong></td>

 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesPreventasUpdate('<?php echo encrypt($detalle[$i]["coddetallepreventa"]); ?>','<?php echo encrypt($detalle[$i]["codpreventa"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESPREVENTAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                 </tr>
                     <?php } ?>
                </tbody>
            </table><hr>

            <table id="carritototal" class="table-responsive">
                <tr>
    <td width="250"><h5><label>Gravado <?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>%:</label></h5></td>
    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal" name="lblsubtotal"><?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtsubtotal" id="txtsubtotal" value="<?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ''); ?>"/>    </td>
                  
    <td width="250">
    <h5><label>Exento 0%:</label></h5>    </td>

    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal2" name="lblsubtotal2"><?php echo number_format($reg[0]['subtotalivano'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="<?php echo number_format($reg[0]['subtotalivano'], 2, '.', ''); ?>"/>    </td>
    
    <td width="250"><h5><label><?php echo $impuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>%:<input type="hidden" name="iva" id="iva" autocomplete="off" value="<?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>"></label></h5>
    </td>

    <td class="text-center" width="250">
    <h5><?php echo $simbolo; ?><label id="lbliva" name="lbliva"><?php echo number_format($reg[0]['totaliva'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtIva" id="txtIva" value="<?php echo number_format($reg[0]['totaliva'], 2, '.', ''); ?>"/>
    </td>
                </tr>
                <tr>
    <td>
    <h5><label>Descontado %:</label></h5> </td>
    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescontado" name="lbldescontado"><?php echo number_format($reg[0]['descontado'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtdescontado" id="txtdescontado" value="<?php echo number_format($reg[0]['descontado'], 2, '.', ''); ?>"/>
        </td>
    
    <td>
    <h5><label>Desc. Global <input class="number" type="text" name="descuento" id="descuento" onKeyPress="EvaluateText('%f', this);" style="border-radius:4px;height:30px;width:60px;" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($reg[0]['descuento'], 2, '.', ''); ?>">%:</label></h5>    </td>

    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescuento" name="lbldescuento"><?php echo number_format($reg[0]['totaldescuento'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtDescuento" id="txtDescuento" value="<?php echo number_format($reg[0]['totaldescuento'], 2, '.', ''); ?>"/>    </td>

    <td><h4><b>Importe Total</b></h4>
    </td>

    <td class="text-center">
    <h4><b><?php echo $simbolo; ?><label id="lbltotal" name="lbltotal"><?php echo number_format($reg[0]['totalpago'], 2, '.', ''); ?></label></b></h4>
    <input type="hidden" name="txtTotal" id="txtTotal" value="<?php echo number_format($reg[0]['totalpago'], 2, '.', ''); ?>"/>
    <input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="<?php echo number_format($reg[0]['totalpago2'], 2, '.', ''); ?>"/>    </td>
                    </tr>
                  </table>
        </div>
<?php
  } 
####################### MOSTRAR DETALLES DE PREVENTAS UPDATE #########################
?>

<?php
####################### MOSTRAR DETALLES DE PREVENTAS AGREGAR #######################
if (isset($_GET['MuestraDetallesPreventasAgregar']) && isset($_GET['codpreventa']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->PreventasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

?>

<div class="table-responsive m-t-20">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administradorS") { ?><th>Acción</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesPreventas();
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
    ?>
                                 <tr>
      <td><strong><?php echo $a++; ?></strong></td>
      
      <td class="text-danger alert-link"><?php echo $detalle[$i]['tipodetalle'] == 1 ? "PRODUCTO" : "SERVICIO"; ?></td>
      
      <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5>
    <small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>

      <td><strong><?php echo $detalle[$i]['cantpreventa']; ?></strong></td>
      
      <td><strong><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></strong></td>

       <td><strong><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></strong></td>
      
      <td><strong><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></strong></td>

      <td><strong><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($reg[0]['iva'], 2, '.', ',')."%" : "(E)"; ?></strong></td>

      <td><strong><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></strong></td>

 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesPreventasAgregar('<?php echo encrypt($detalle[$i]["coddetallepreventa"]); ?>','<?php echo encrypt($detalle[$i]["codpreventa"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESPREVENTAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                 </tr>
                     <?php } ?>
                </tbody>
            </table>
                                
            <table id="carritototal" class="table-responsive">
                <tr>
    <td width="250"><h5><label>Gravado <?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%:</label></h5></td>
    <td width="250">
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ','); ?></label></h5>
    </td>
                  
    <td width="250">
    <h5><label>Exento 0%:</label></h5>    </td>

    <td width="250">
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['subtotalivano'], 2, '.', ','); ?></label></h5>
    </td>
    
    <td width="250"><h5><label><?php echo $impuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%:</label></h5>
    </td>

    <td class="text-center" width="250">
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totaliva'], 2, '.', ','); ?></label></h5>
    </td>
                </tr>
                <tr>
    <td>
    <h5><label>Descontado %:</label></h5> </td>
    <td>
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['descontado'], 2, '.', ','); ?></label></h5>
        </td>
    
    <td>
    <h5><label>Desc. Global <?php echo number_format($reg[0]['descuento'], 2, '.', ''); ?>%:</label></h5>    </td>

    <td>
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totaldescuento'], 2, '.', ','); ?></label></h5>
    </td>

    <td><h4><b>Importe Total</b></h4>
    </td>

    <td class="text-center">
    <h4><b><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totalpago'], 2, '.', ','); ?></label></b></h4>
    </td>
                    </tr>
                  </table>
            </div>
<?php
  } 
######################## MOSTRAR DETALLES DE PREVENTAS AGREGRA #######################
?>


<?php
########################## BUSQUEDA PREVENTAS POR FECHAS ##########################
if (isset($_GET['BuscaPreventasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarPreventasxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Preventas por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("PREVENTASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PREVENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PREVENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Preventa</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Fecha Emisión</th>
                                  <th>Nº de Articulos</th>
                                   <th>Subtotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc</th>
                                  <th>Imp. Total</th>
                                  <th><i class="mdi mdi-drag-horizontal"></i></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['codfactura']; ?></td>
<td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>  
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechapreventa'])); ?></td>
          <td><?php echo $reg[$i]['articulos']; ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
          <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  <td> <a href="reportepdf?codpreventa=<?php echo encrypt($reg[$i]['codpreventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETPREVENTA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php  }  ?>
         <tr>
          <td colspan="4"></td>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA PREVENTAS POR FECHAS ##########################
?>

<?php 
########################### BUSQUEDA DE DETALLES PREVENTAS POR FECHAS ##########################
if (isset($_GET['BuscaDetallesPreventasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$cotizado = new Login();
$reg = $cotizado->BuscarDetallesPreventasxFechas();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Preventas por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DETALLESPREVENTASXFECHAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESPREVENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESPREVENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Tipo</th>
                                  <th>Descripción</th>
                                  <th>Marca</th>
                                  <th>Modelo</th>
                                  <th>Desc</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Precio de Venta</th>
                                  <th>Existencia</th>
                                  <th>Preventa</th>
                                  <th>Monto Total</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                      <td><?php echo $a++; ?></div></td>
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
                        <?php  }  ?>
                      <tr>
                        <td colspan="7"></td>
                        <td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
                        <td><strong><?php echo $ExisteTotal; ?></strong></td>
                        <td><strong><?php echo $VendidosTotal; ?></strong></td>
                        <td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
                      </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA DE DETALLES PREVENTAS POR FECHAS ##########################
?>

<?php 
########################### BUSQUEDA DE DETALLES PREVENTAS POR VENDEDOR ##########################
if (isset($_GET['BuscaDetallesPreventasxVendedor']) && isset($_GET['codsucursal']) && isset($_GET['codigo']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$codigo = limpiar($_GET['codigo']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($codigo=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE VENDEDOR PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarDetallesPreventasxVendedor();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Preventas por Vendedor</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DETALLESPREVENTASXVENDEDOR") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESPREVENTASXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESPREVENTASXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Nombre de Vendedor: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Tipo</th>
                                  <th>Descripción de Producto</th>
                                  <th>Marca</th>
                                  <th>Modelo</th>
                                  <th>Desc</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Precio de Venta</th>
                                  <th>Existencia</th>
                                  <th>Preventa</th>
                                  <th>Monto Total</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                      <td><?php echo $a++; ?></div></td>
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
                        <?php  }  ?>
                      <tr>
                        <td colspan="7"></td>
                        <td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
                        <td><strong><?php echo $ExisteTotal; ?></strong></td>
                        <td><strong><?php echo $VendidosTotal; ?></strong></td>
                        <td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
                      </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA DE PRODUCTOS PREVENTAS POR VENDEDOR ##########################
?>









































<?php
####################### MOSTRAR CAJA DE VENTA EN VENTANA MODAL ########################
if (isset($_GET['BuscaCajaModal']) && isset($_GET['codcaja'])) { 

$reg = $new->CajasPorId();
?>
  
  <table class="table-responsive" border="0" align="center"> 
  <tr>
    <td><strong>Nº de Caja:</strong> <?php echo $reg[0]['nrocaja']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombre de Caja:</strong> <?php echo $reg[0]['nomcaja']; ?></td>
  </tr>
  <tr>
    <td><strong>Responsable de Caja: </strong> <?php echo $reg[0]['nombres']; ?></td>
  </tr>
<?php if ($_SESSION["acceso"]=="administradorG") { ?>
  <tr>
    <td><strong>Sucursal:</strong> <?php echo $reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal']; ?></td>
  </tr>
<?php } ?>
</table>
<?php 
} 
######################## MOSTRAR CAJA DE VENTA EN VENTANA MODAL #########################
?>


<?php 
############################# BUSCAR CAJAS POR SUCURSALES #############################
if (isset($_GET['BuscaCajasxSucursal']) && isset($_GET['codsucursal'])) {
  
$caja = $new->BuscarCajasxSucursal();
  ?>
<option value=""> -- SELECCIONE -- </option>
  <?php
   for($i=0;$i<sizeof($caja);$i++){
    ?>
<option value="<?php echo encrypt($caja[$i]['codcaja']) ?>"><?php echo $caja[$i]['nrocaja'].": ".$caja[$i]['nomcaja']." - ".$caja[$i]['nombres']; ?></option>
    <?php 
   } 
}
############################# BUSCAR CAJAS POR SUCURSALES ##########################
?>


<?php 
############################# BUSCAR CAJAS POR SUCURSALES #############################
if (isset($_GET['BuscaCajasAbiertasxSucursal']) && isset($_GET['codsucursal'])) {
  
$caja = $new->ListarCajasAbiertas();
  ?>
<option value=""> -- SELECCIONE -- </option>
  <?php
   for($i=0;$i<sizeof($caja);$i++){
    ?>
<option value="<?php echo $caja[$i]['codcaja']; ?>"><?php echo $caja[$i]['nrocaja'].": ".$caja[$i]['nomcaja']." - ".$caja[$i]['nombres']; ?></option>
    <?php 
   } 
}
############################# BUSCAR CAJAS POR SUCURSALES ##########################
?>


<?php
######################## MOSTRAR ARQUEO EN CAJA EN VENTANA MODAL #######################
if (isset($_GET['BuscaArqueoModal']) && isset($_GET['codarqueo'])) { 

$reg = $new->ArqueoCajaPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

  ?>
  
  <table class="table-responsive" border="0" align="center">
  <tr>
    <td><strong>Nombre de Caja:</strong> <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?></td>
  </tr>
  <tr>
    <td><strong>Monto Inicial:</strong> <?php echo $simbolo.number_format($reg[0]['montoinicial'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Ingresos:</strong> <?php echo $simbolo.number_format($reg[0]['ingresos'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Egresos:</strong> <?php echo $simbolo.number_format($reg[0]['egresos'], 2, '.', ','); ?></td>
    </tr>
  <tr>
    <td><strong>Créditos:</strong> <?php echo $simbolo.number_format($reg[0]['creditos'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Abonos de Créditos:</strong> <?php echo $simbolo.number_format($reg[0]['abonos'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Total Ventas:</strong> <?php echo $simbolo.number_format($reg[0]['ingresos']+$reg[0]['creditos'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Total Ingresos:</strong> <?php echo $simbolo.number_format($reg[0]['ingresos']+$reg[0]['abonos'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Dinero en Efectivo:</strong> <?php echo $simbolo.number_format($reg[0]['dineroefectivo'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Diferencia:</strong> <?php echo $simbolo.number_format($reg[0]['diferencia'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Observaciones:</strong> <?php echo $reg[0]['comentarios']; ?></td>
  </tr>
  <tr>
    <td><strong>Hora Apertura:</strong> <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechaapertura'])); ?></td>
  </tr>
  <tr>
    <td><strong>Hora Cierre:</strong> <?php echo $cierre = ( $reg[0]['statusarqueo'] == '1' ? $reg[0]['fechacierre'] : date("d-m-Y H:i:s",strtotime($reg[0]['fechacierre']))); ?></td>
  </tr>
  <tr>
    <td><strong>Responsable:</strong> <?php echo $reg[0]['dni'].": ".$reg[0]['nombres']; ?></td>
  </tr>
<?php if ($_SESSION["acceso"]=="administradorG") { ?>
  <tr>
    <td><strong>Sucursal:</strong> <?php echo $reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal']; ?></td>
  </tr>
<?php } ?>
</table>
  
  <?php
   } 
######################## MOSTRAR ARQUEO EN CAJA EN VENTANA MODAL ########################
?>


<?php
########################## BUSQUEDA ARQUEOS DE CAJA POR FECHAS ##########################
if (isset($_GET['BuscaArqueosxFechas']) && isset($_GET['codsucursal']) && isset($_GET['codcaja']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codcaja = limpiar($_GET['codcaja']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codcaja=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarArqueosxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Arqueos de Cajas por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("ARQUEOSXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("ARQUEOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("ARQUEOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Descripción de Caja: </label> <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?><br>

            <label class="control-label">Responsable de Caja: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Caja</th>
                                  <th>Hora de Apertura</th>
                                  <th>Hora de Cierre</th>
                                  <th>Inicial</th>
                                  <th>Ingresos</th>
                                  <th>Egresos</th>
                                  <th>Créditos</th>
                                  <th>Abonos</th>
                                  <th>Total Ventas</th>
                                  <th>Total Ingresos</th>
                                  <th>Dinero Efectivo</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
?>
                                <tr>
                    <td><?php echo $a++; ?></td>
<td><abbr title="<?php echo "Responsable: ".$reg[$i]['nombres'] ?>"><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></abbr></td>
              <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaapertura'])); ?></td>
<td><?php echo $reg[$i]['fechacierre'] == '0000-00-00 00:00:00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechacierre'])); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['ingresos'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['egresos'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['creditos'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['abonos'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['ingresos']+$reg[$i]['creditos'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['montoinicial']+$reg[$i]['ingresos']+$reg[$i]['abonos']-$reg[$i]['egresos'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['dineroefectivo'], 2, '.', ','); ?></td>
                                </tr>
                        <?php  }  ?>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA ARQUEOS DE CAJAS POR FECHAS ##########################
?>









<?php
###################### MOSTRAR MOVIMIENTO EN CAJA EN VENTANA MODAL #####################
if (isset($_GET['BuscaMovimientoModal']) && isset($_GET['numero']) && isset($_GET['codsucursal'])) { 

$reg = $new->MovimientosPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

?>
  
  <table class="table-responsive" border="0" align="center">
  <tr>
    <td><strong>Nombre de Caja:</strong> <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?></td>
  </tr>
  <tr>
    <td><strong>Tipo de Movimiento:</strong> <?php echo $reg[0]['tipomovimiento']; ?></td>
  </tr>
  <tr>
    <td><strong>Descripción de Movimiento:</strong> <?php echo $reg[0]['descripcionmovimiento']; ?></td>
  </tr>
  <tr>
    <td><strong>Monto de Movimiento:</strong> <?php echo $simbolo.number_format($reg[0]['montomovimiento'], 2, '.', ','); ?></td>
    </tr>
  <tr>
    <td><strong>Tipo de Pago:</strong> <?php echo $reg[0]['mediopago']; ?></td>
  </tr>
  <tr>
    <td><strong>Hora Cierre:</strong> <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechamovimiento'])); ?></td>
  </tr>
  <tr>
    <td><strong>Responsable:</strong> <?php echo $reg[0]['dni'].": ".$reg[0]['nombres']; ?></td>
  </tr>
<?php if ($_SESSION["acceso"]=="administradorG") { ?>
  <tr>
    <td><strong>Sucursal:</strong> <?php echo $reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal']; ?></td>
  </tr>
<?php } ?>
</table>
  
  <?php
   } 
##################### MOSTRAR MOVIMIENTO EN CAJA EN VENTANA MODAL ######################
?>






<?php
######################### BUSQUEDA MOVIMIENTOS DE CAJA POR FECHAS ########################
if (isset($_GET['BuscaMovimientosxFechas']) && isset($_GET['codsucursal']) && isset($_GET['codcaja']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codcaja = limpiar($_GET['codcaja']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codcaja=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarMovimientosxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Movimientos en Cajas por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("MOVIMIENTOSXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("MOVIMIENTOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("MOVIMIENTOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Descripción de Caja: </label> <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?><br>

            <label class="control-label">Responsable de Caja: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Nº de Caja</th>
                                  <th>Responsable</th>
                                  <th>Tipo Movimiento</th>
                                  <th>Descripción</th>
                                  <th>Monto</th>
                                  <th>Forma de Movimiento</th>
                                  <th>Fecha Movimiento</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
?>
                                <tr>
                    <td><?php echo $a++; ?></td>
              <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
              <td><?php echo $reg[$i]['nombres']; ?></td>
<td><?php echo $status = ( $reg[$i]['tipomovimiento'] == 'INGRESO' ? "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]['tipomovimiento']."</span>" : "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> ".$reg[$i]['tipomovimiento']."</span>"); ?></td>
<td><?php echo $reg[$i]['descripcionmovimiento']; ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ','); ?></td>
              <td><?php echo $reg[$i]['mediopago']; ?></td>
              <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechamovimiento'])); ?></td>
                                </tr>
                        <?php  }  ?>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
####################### BUSQUEDA MOVIMIENTOS DE CAJAS POR FECHAS ########################
?>





























<?php 
############################# MUESTRA FORMULARIO PARA VENTAS ########################
if (isset($_GET['CargaDetalleCaja'])) {

$arqueo = new Login();
$arqueo = $arqueo->ArqueoCajaPorUsuario(); 
?>

    <h4 class="modal-title text-white" id="myModalLabel"><i class="mdi mdi-desktop-mac"></i> Caja Nº: <?php echo $arqueo[0]["nrocaja"].":".$arqueo[0]["nomcaja"]; ?></h4>
    <input type="hidden" name="codcaja" id="codcaja" value="<?php echo $arqueo[0]["codcaja"]; ?>">
             
<?php  
  }
############################# MUESTRA FORMULARIO PARA VENTAS ########################
?>

<?php 
############################# MUESTRA CAJA DE VENTA PARA CIERRE ########################
if (isset($_GET['MuestraCajaVenta'])) { 

$reg = $new->ArqueoCajaPorUsuario();

  if($reg[0]["codcaja"]==""){

    echo "<center><div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<span class='fa fa-info-circle'></span> NO TIENE UN ARQUEO DE CAJA, VERIFIQUE NUEVAMENTE POR FAVOR </div></center>";
    exit;

  } else {

?>

          <div class="row">
              <div class="col-md-12">
                  <div class="form-group has-feedback">
                    <label class="control-label">Nº de Caja: <span class="symbol required"></span></label>
                    <input type="hidden" name="proceso" id="proceso" value="cierre"/>
                    <input type="hidden" name="codarqueo" id="codarqueo" value="<?php echo $reg[0]["codarqueo"]; ?>"/>
                    <input type="text" class="form-control" name="responsable" id="responsable" placeholder="Ingrese Nombre Cajero" autocomplete="off" value="<?php echo $reg[0]["nrocaja"].": ".$reg[0]["nomcaja"].": ".$reg[0]["nombres"]; ?>" disabled=""aria-required="true"/>
                    <i class="fa fa-pencil form-control-feedback"></i> 
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-md-4">
                  <div class="form-group has-feedback">
                    <label class="control-label">Monto Inicial: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="montoinicial" id="montoinicial" autocomplete="off" placeholder="Monto Inicial" value="<?php echo number_format($reg[0]["montoinicial"], 2, '.', ''); ?>" autocomplete="off" readonly="" aria-required="true"/> 
                    <i class="fa fa-tint form-control-feedback"></i> 
                  </div>
              </div>

              <div class="col-md-4">
                  <div class="form-group has-feedback">
                    <label class="control-label">Ingresos: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="ingresos" id="ingresos" autocomplete="off" placeholder="Ingrese Monto de Ingresos" autocomplete="off" value="<?php echo number_format($reg[0]["ingresos"], 2, '.', ''); ?>" readonly="" aria-required="true"/> 
                    <i class="fa fa-tint form-control-feedback"></i> 
                  </div>
              </div>

              <div class="col-md-4">
                  <div class="form-group has-feedback">
                    <label class="control-label">Egresos: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="egresos" id="egresos" autocomplete="off" placeholder="Monto de Egresos" autocomplete="off" value="<?php echo number_format($reg[0]["egresos"], 2, '.', ''); ?>" readonly="" aria-required="true"/> 
                    <i class="fa fa-tint form-control-feedback"></i>
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-md-4">
                  <div class="form-group has-feedback">
                    <label class="control-label">Créditos: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="creditos" id="creditos" autocomplete="off" placeholder="Monto de Créditos" autocomplete="off" value="<?php echo number_format($reg[0]["creditos"], 2, '.', ''); ?>" readonly="" aria-required="true"/> 
                    <i class="fa fa-tint form-control-feedback"></i>
                  </div>
              </div>

              <div class="col-md-4">
                  <div class="form-group has-feedback">
                    <label class="control-label">Abonos de Crédito: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="abonos" id="abonos" autocomplete="off" placeholder="Abono de Créditos" autocomplete="off" value="<?php echo number_format($reg[0]["abonos"], 2, '.', ''); ?>" readonly="" aria-required="true"/> 
                    <i class="fa fa-tint form-control-feedback"></i>
                </div>
             </div>

              <div class="col-md-4">
                  <div class="form-group has-feedback">
                    <label class="control-label">Estimado en Caja: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="estimado" id="estimado" autocomplete="off" placeholder="Estimado en Caja" autocomplete="off" value="<?php echo number_format($reg[0]["montoinicial"]+$reg[0]["ingresos"]+$reg[0]["abonos"]-$reg[0]["egresos"], 2, '.', ''); ?>" readonly="" aria-required="true"/> 
                    <i class="fa fa-tint form-control-feedback"></i>
                  </div>
              </div>
          </div>


          <div class="row">
              <div class="col-md-4">
                  <div class="form-group has-feedback">
                    <label class="control-label">Efectivo Disponible: <span class="symbol required"></span></label>
                    <input type="text" class="form-control cierrecaja" name="dineroefectivo" id="dineroefectivo" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Efectivo" autocomplete="off" required="" aria-required="true"/> 
                    <i class="fa fa-tint form-control-feedback"></i>
                  </div>
              </div>

              <div class="col-md-4">
                  <div class="form-group has-feedback">
                    <label class="control-label">Diferencia en Caja: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="diferencia" id="diferencia" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Diferencia en Caja" autocomplete="off" readonly="" aria-required="true"/>
                    <i class="fa fa-tint form-control-feedback"></i>
                  </div>
              </div>

              <div class="col-md-4">
                  <div class="form-group has-feedback">
                    <label class="control-label">Hora de Apertura: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="fechaapertura" id="fechaapertura" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Hora de Apertura" value="<?php echo $reg[0]["fechaapertura"]; ?>" autocomplete="off" readonly="" aria-required="true"/> 
                    <i class="fa fa-clock-o form-control-feedback"></i> 
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-md-4">
                  <div class="form-group has-feedback">
                    <label class="control-label">Hora de Cierre: <span class="symbol required"></span></label>
                    <input type="text" class="form-control fecharegistro" name="fecharegistro" id="fecharegistro" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Hora de Cierre" autocomplete="off" readonly="" aria-required="true"/> 
                    <i class="fa fa-clock-o form-control-feedback"></i> 
                  </div>
              </div>

              <div class="col-md-8">
                  <div class="form-group has-feedback">
                    <label class="control-label">Observaciones: </label>
                    <input type="text" class="form-control" name="comentarios" id="comentarios" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Observaciones de Cierre" autocomplete="off" required="" aria-required="true"/> 
                    <i class="fa fa-comment-o form-control-feedback"></i> 
                  </div>
              </div>
          </div>

<?php    
     }       
  }
############################# MUESTRA CAJA DE VENTA PARA CIERRE ########################
?>


<?php 
####################### MUESTRA CONDICIONES DE PAGO PARA VENTAS ########################
if (isset($_GET['BuscaCondicionesPagos']) && isset($_GET['tipopago'])) { 
  
$tra = new Login();

 if(limpiar($_GET['tipopago'])==""){ echo ""; 

 } elseif(limpiar($_GET['tipopago'])=="CONTADO"){  ?>

          <div class="row">
              <div class="col-md-6"> 
                  <div class="form-group has-feedback"> 
                      <label class="control-label">Forma de Pago: <span class="symbol required"></span></label>
                      <i class="fa fa-bars form-control-feedback"></i>
                      <select style="color:#000;font-weight:bold;" name="codmediopago" id="codmediopago" class="form-control" required="" aria-required="true">
                      <option value=""> -- SELECCIONE -- </option>
                      <?php
                      $pago = new Login();
                      $pago = $pago->ListarMediosPagos();
                      if($pago==""){
                        echo "";
                      } else {
                      for($i=0;$i<sizeof($pago);$i++){ ?>
                      <option value="<?php echo encrypt($pago[$i]['codmediopago']); ?>"<?php if (!(strcmp('1', $pago[$i]['codmediopago']))) {echo "selected=\"selected\"";} ?>><?php echo $pago[$i]['mediopago'] ?></option>       
                      <?php } } ?>
                      </select>
                  </div> 
              </div>

              <div class="col-md-6"> 
                  <div class="form-group has-feedback"> 
                     <label class="control-label">Monto Recibido: </label>
                     <input class="form-control" type="text" name="montopagado" id="montopagado" autocomplete="off" onKeyUp="CalculoDevolucion();" placeholder="Monto Recibido" value="0" required="" aria-required="true"> 
                     <i class="fa fa-tint form-control-feedback"></i>
                  </div> 
              </div>
          </div>
          
 <?php   } else if(limpiar($_GET['tipopago'])=="CREDITO"){  ?>

          <div class="row">
              <div class="col-md-6"> 
                   <div class="form-group has-feedback"> 
                      <label class="control-label">Fecha Vence Crédito: <span class="symbol required"></span></label> 
                      <input type="text" class="form-control expira" name="fechavencecredito" id="fechavencecredito" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha Vence Crédito" aria-required="true">
                      <i class="fa fa-calendar form-control-feedback"></i>  
                 </div> 
              </div> 

              <div class="col-md-6"> 
                  <div class="form-group has-feedback"> 
                     <label class="control-label">Abono Crédito: <span class="symbol required"></span></label>
                     <input class="form-control number" type="text" name="montoabono" id="montoabono" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" autocomplete="off" placeholder="Ingrese Monto de Abono" value="0.00" required="" aria-required="true"> 
                     <i class="fa fa-tint form-control-feedback"></i>
                  </div> 
              </div>
          </div>
 
<?php  }
  }
####################### MUESTRA CONDICIONES DE PAGO PARA VENTAS ########################
?>

<?php
############################# MOSTRAR VENTAS EN VENTANA MODAL ############################
if (isset($_GET['BuscaVentaModal']) && isset($_GET['codventa']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->VentasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

  if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON VENTAS Y DETALLES ACTUALMENTE </center>";
    echo "</div>";    

} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-dark">SUCURSAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?></p>

  <h4><b class="text-dark">Nº VENTA <?php echo $reg[0]['codfactura']; ?></b></h4>
  <p class="text-muted m-l-5">Nº SERIE: <?php echo $reg[0]['codserie']; ?>
  <br>Nº DE CAJA: <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?>
  
  <?php if($reg[0]['fechavencecredito']!= "0000-00-00") { ?>
  <br>DIAS VENCIDOS: 
  <?php if($reg[0]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[0]['fechavencecredito'] >= date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']); }
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[0]['fechapagado'],$reg[0]['fechavencecredito']); } ?>
  <?php } ?>

  <br>STATUS: 
  <?php if($reg[0]['fechavencecredito']== '0000-00-00') { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[0]["statusventa"]."</span>"; } 
        elseif($reg[0]['fechavencecredito'] >= date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-success'><i class='fa fa-exclamation-circle'></i> ".$reg[0]["statusventa"]."</span>"; } 
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA</span>"; }
        elseif($reg[0]['fechavencecredito'] <= date("Y-m-d") && $reg[0]['fechapagado']!= "0000-00-00") { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[0]["statusventa"]."</span>"; } ?>
  
  <?php if($reg[0]['fechapagado']!= "0000-00-00") { ?>
  <br>FECHA PAGADA: <?php echo date("d-m-Y",strtotime($reg[0]['fechapagado'])); ?>
  <?php } ?>

  <br>FECHA DE EMISIÓN: <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechaventa'])); ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-dark">CLIENTE</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nomcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']; ?>,
  <?php echo $reg[0]['direccliente'] == '' ? "" : "<br/>".$reg[0]['direccliente']; ?>
  <?php echo $reg[0]['provincia2'] == '' ? "" : "<br/>".$reg[0]['provincia2']; ?> <?php echo $reg[0]['departamento2'] == '' ? "" : strtoupper($reg[0]['departamento2']); ?>
  <br/> EMAIL: <?php echo $reg[0]['emailcliente'] == '' ? "*******" : $reg[0]['emailcliente']; ?>
  <br/> Nº <?php echo $reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['dnicliente'] == '' ? "*******" : $reg[0]['dnicliente']; ?> - TLF: <?php echo $reg[0]['tlfcliente'] == '' ? "*******" : $reg[0]['tlfcliente']; ?></p>
                                            
                                        </address>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-10" style="clear: both;">
                                        <table class="table table-hover">
                               <thead>
                        <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administradorS") { ?><th>Acción</th><?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesVentas();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto'];
?>
                                                <tr>
      <td><?php echo $a++; ?></td>
      <td class="text-left"><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5>
      <small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
      <td><?php echo $detalle[$i]['cantventa']; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($reg[0]['iva'], 2, '.', ',')."%" : "(E)"; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesVentaModal('<?php echo encrypt($detalle[$i]["coddetalleventa"]); ?>','<?php echo encrypt($detalle[$i]["codventa"]); ?>','<?php echo encrypt($reg[0]["codcliente"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESVENTAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                                </tr>
                                      <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="col-md-12">

                                    <div class="pull-right text-right">
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($SubTotal, 2, '.', ','); ?></p>
<p><b>Gravado  <?php echo number_format($reg[0]['iva'], 2, '.', ',') ?>%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivasi'], 2, '.', ','); ?><p>
<p><b>Exento 0%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivano'], 2, '.', ','); ?></p>
<p><b>Total <?php echo $impuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaliva'], 2, '.', ','); ?> </p>
<p><b>Descontado %:</b> <?php echo $simbolo.number_format($reg[0]['descontado'], 2, '.', ','); ?> </p>
<p><b>Desc. Global (<?php echo number_format($reg[0]['descuento'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaldescuento'], 2, '.', ','); ?> </p>
                                        <hr>
<h4><b>Importe Total:</b> <?php echo $simbolo.number_format($reg[0]['totalpago'], 2, '.', ','); ?></h4></div>
                                    <div class="clearfix"></div>
                                    <hr>

                                <div class="col-md-12">
                                    <div class="text-right">
 <a href="reportepdf?codventa=<?php echo encrypt($reg[0]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[0]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"> <span><i class="fa fa-print"></i> Imprimir</span> </button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                                    </div>
                                </div>
                            </div>
                <!-- .row -->
  <?php
       }
   } 
############################# MOSTRAR VENTAS EN VENTANA MODAL ############################
?>


<?php
######################### MOSTRAR DETALLES DE VENTAS UPDATE ############################
if (isset($_GET['MuestraDetallesVentasUpdate']) && isset($_GET['codventa']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->VentasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

?>

<div class="table-responsive m-t-20">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administradorS") { ?><th>Acción</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesVentas();
$a=1;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){ 
$count++;    
?>
                                 <tr>
      <td>
      <input type="text" step="1" min="1" class="form-control cantidad bold" name="cantventa[]" id="cantventa_<?php echo $count; ?>" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoVenta(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" style="width: 80px;background:#e4e7ea;border-radius:5px 5px 5px 5px;" onfocus="this.style.background=('#B7F0FF')" onfocus="this.style.background=('#B7F0FF')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e4e7ea');" title="Ingrese Cantidad" value="<?php echo $detalle[$i]["cantventa"]; ?>" required="" aria-required="true">
      <input type="hidden" name="cantidadventabd[]" id="cantidadventabd" value="<?php echo $detalle[$i]["cantventa"]; ?>">
      <input type="hidden" name="coddetalleventa[]" id="coddetalleventa" value="<?php echo $detalle[$i]["coddetalleventa"]; ?>">
      <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
      <input type="hidden" name="tipodetalle[]" id="tipodetalle" value="<?php echo $detalle[$i]["tipodetalle"]; ?>">
      <input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>"></td>
      
      <td class="text-danger alert-link"><?php echo $detalle[$i]['tipodetalle'] == 1 ? "PRODUCTO" : "SERVICIO"; ?></td>
      
      <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
      
      <td><strong><input type="hidden" name="precioventa[]" id="precioventa_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>"><?php echo number_format($detalle[$i]['precioventa'], 2, '.', ''); ?></strong></td>

       <td><input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["valortotal"], 2, '.', ''); ?>"><strong><label id="txtvalortotal_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valortotal'], 2, '.', ''); ?></label></strong></td>

       <td><input type="hidden" name="descproducto[]" id="descproducto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["descproducto"], 2, '.', ''); ?>">
        <input type="hidden" class="totaldescuentov" name="totaldescuentov[]" id="totaldescuentov_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["totaldescuentov"], 2, '.', ''); ?>">
        <strong><label id="txtdescproducto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['totaldescuentov'], 2, '.', ''); ?></label><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ''); ?>%</sup></strong></td>

      <td><input type="hidden" name="ivaproducto[]" id="ivaproducto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["ivaproducto"]; ?>"><strong><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($reg[0]['iva'], 2, '.', '')."%" : "(E)"; ?></strong></td>

      <td><input type="hidden" class="subtotalivasi" name="subtotalivasi[]" id="subtotalivasi_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

        <input type="hidden" class="subtotalivano" name="subtotalivano[]" id="subtotalivano_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == 'NO' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

        <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?>" >

        <input type="hidden" class="valorneto2" name="valorneto2[]" id="valorneto2_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto2'], 2, '.', ''); ?>" >

        <strong><label id="txtvalorneto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?></label></strong></td>

 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesVentaUpdate('<?php echo encrypt($detalle[$i]["coddetalleventa"]); ?>','<?php echo encrypt($detalle[$i]["codventa"]); ?>','<?php echo encrypt($reg[0]["codcliente"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESVENTAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                 </tr>
                     <?php } ?>
                </tbody>
            </table><hr>

             <table id="carritototal" class="table-responsive">
                <tr>
    <td width="250"><h5><label>Gravado <?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>%:</label></h5></td>
    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal" name="lblsubtotal"><?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtsubtotal" id="txtsubtotal" value="<?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ''); ?>"/>    </td>
                  
    <td width="250">
    <h5><label>Exento 0%:</label></h5>    </td>

    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal2" name="lblsubtotal2"><?php echo number_format($reg[0]['subtotalivano'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="<?php echo number_format($reg[0]['subtotalivano'], 2, '.', ''); ?>"/>    </td>
    
    <td width="250"><h5><label><?php echo $impuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>%:<input type="hidden" name="iva" id="iva" autocomplete="off" value="<?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>"></label></h5>
    </td>

    <td class="text-center" width="250">
    <h5><?php echo $simbolo; ?><label id="lbliva" name="lbliva"><?php echo number_format($reg[0]['totaliva'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtIva" id="txtIva" value="<?php echo number_format($reg[0]['totaliva'], 2, '.', ''); ?>"/>
    </td>
                </tr>
                <tr>
    <td>
    <h5><label>Descontado %:</label></h5> </td>
    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescontado" name="lbldescontado"><?php echo number_format($reg[0]['descontado'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtdescontado" id="txtdescontado" value="<?php echo number_format($reg[0]['descontado'], 2, '.', ''); ?>"/>
        </td>
    
    <td>
    <h5><label>Desc. Global <input class="number" type="text" name="descuento" id="descuento" onKeyPress="EvaluateText('%f', this);" style="border-radius:4px;height:30px;width:60px;" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($reg[0]['descuento'], 2, '.', ''); ?>">%:</label></h5>    </td>

    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescuento" name="lbldescuento"><?php echo number_format($reg[0]['totaldescuento'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtDescuento" id="txtDescuento" value="<?php echo number_format($reg[0]['totaldescuento'], 2, '.', ''); ?>"/>    </td>

    <td><h4><b>Importe Total</b></h4>
    </td>

    <td class="text-center">
    <h4><b><?php echo $simbolo; ?><label id="lbltotal" name="lbltotal"><?php echo number_format($reg[0]['totalpago'], 2, '.', ''); ?></label></b></h4>
    <input type="hidden" name="txtTotal" id="txtTotal" value="<?php echo number_format($reg[0]['totalpago'], 2, '.', ''); ?>"/>
    <input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="<?php echo number_format($reg[0]['totalpago2'], 2, '.', ''); ?>"/>    </td>
                    </tr>
                  </table>
        </div>
<?php
  } 
########################### MOSTRAR DETALLES DE VENTAS UPDATE ##########################
?>

<?php
########################### MOSTRAR DETALLES DE VENTAS AGREGAR ##########################
if (isset($_GET['MuestraDetallesVentasAgregar']) && isset($_GET['codventa']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->VentasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

?>

<div class="table-responsive m-t-20">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administradorS") { ?><th>Acción</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesVentas();
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
    ?>
                                 <tr>
      <td><strong><?php echo $a++; ?></strong></td>
      
      <td class="text-danger alert-link"><?php echo $detalle[$i]['tipodetalle'] == 1 ? "PRODUCTO" : "SERVICIO"; ?></td>

    <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>

      <td><strong><?php echo $detalle[$i]['cantventa']; ?></strong></td>
      
      <td><strong><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></strong></td>

       <td><strong><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></strong></td>
      
      <td><strong><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ''); ?>%</sup></strong></td>

      <td><strong><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($reg[0]['iva'], 2, '.', ',')."%" : "(E)"; ?></strong></td>

      <td><strong><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></strong></td>

 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesVentaAgregar('<?php echo encrypt($detalle[$i]["coddetalleventa"]); ?>','<?php echo encrypt($detalle[$i]["codventa"]); ?>','<?php echo encrypt($reg[0]["codcliente"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESVENTAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                 </tr>
                     <?php } ?>
                </tbody>
            </table>

            <table id="carritototal" class="table-responsive">
                <tr>
    <td width="250"><h5><label>Gravado <?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%:</label></h5></td>
    <td width="250">
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ','); ?></label></h5>
    </td>
                  
    <td width="250">
    <h5><label>Exento 0%:</label></h5>    </td>

    <td width="250">
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['subtotalivano'], 2, '.', ','); ?></label></h5>
    </td>
    
    <td width="250"><h5><label><?php echo $impuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%:</label></h5>
    </td>

    <td class="text-center" width="250">
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totaliva'], 2, '.', ','); ?></label></h5>
    </td>
                </tr>
                <tr>
    <td>
    <h5><label>Descontado %:</label></h5> </td>
    <td>
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['descontado'], 2, '.', ','); ?></label></h5>
        </td>
    
    <td>
    <h5><label>Desc. Global <?php echo number_format($reg[0]['descuento'], 2, '.', ','); ?>%:</label></h5>    </td>

    <td>
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totaldescuento'], 2, '.', ','); ?></label></h5>
    </td>

    <td><h4><b>Importe Total</b></h4>
    </td>

    <td class="text-center">
    <h4><b><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totalpago'], 2, '.', ','); ?></label></b></h4>
    </td>
                    </tr>
                  </table>
           </div>
<?php
  } 
########################## MOSTRAR DETALLES DE VENTAS AGREGRAR #########################
?>


<?php
########################## BUSQUEDA VENTAS POR CAJAS ##########################
if (isset($_GET['BuscaVentasxCajas']) && isset($_GET['codsucursal']) && isset($_GET['codcaja']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codcaja = limpiar($_GET['codcaja']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codcaja=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarVentasxCajas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ventas por Caja</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("VENTASXCAJAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("VENTASXCAJAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("VENTASXCAJAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Descripción de Caja: </label> <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?><br>

            <label class="control-label">Responsable de Caja: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Venta</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Nota Credito</th>
                                  <th>Status</th>
                                  <th>Fecha Emisión</th>
                                  <th>Nº de Articulos</th>
                                  <th>Subtotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Dcto %</th>
                                  <th>Imp. Total</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['codfactura']; ?></td>
  <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>
  <td><?php echo $reg[$i]['notacredito'] == 1 ? "<span class='badge badge-pill badge-danger'><i class='fa fa-exclamation-circle'></i> SI</span>" : "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> NO</span>"; ?></td>

  <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-success'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA</span>"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
  <td><?php echo $reg[$i]['articulos']; ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>

  <td> <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php  }  ?>
         <tr>
          <td colspan="6"></td>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA VENTAS POR CAJAS ##########################
?>


<?php
########################## BUSQUEDA VENTAS POR FECHAS ##########################
if (isset($_GET['BuscaVentasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarVentasxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ventas por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("VENTASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("VENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("VENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Venta</th>
                                  <th>Vendedor</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Nota Credito</th>
                                  <th>Status</th>
                                  <th>Fecha Emisión</th>
                                  <th>Nº de Articulos</th>
                                  <th>Subtotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc %</th>
                                  <th>Imp. Total</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['codfactura']; ?></td>
                                  <td><?php echo $reg[$i]['nombres']; ?></td>
  <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>
  <td><?php echo $reg[$i]['notacredito'] == 1 ? "<span class='badge badge-pill badge-danger'><i class='fa fa-exclamation-circle'></i> SI</span>" : "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> NO</span>"; ?></td>
  <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-success'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA</span>"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
  <td><?php echo $reg[$i]['articulos']; ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>

  <td> <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php  }  ?>
         <tr>
          <td colspan="7"></td>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA VENTAS POR FECHAS ##########################
?>


<?php
########################## BUSQUEDA VENTAS POR CLIENTES ##########################
if (isset($_GET['BuscaVentasxClientes']) && isset($_GET['codsucursal']) && isset($_GET['codcliente']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codcliente = limpiar($_GET['codcliente']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

  } else if($codcliente=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL CLIENTE CORRECTAMENTE</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarVentasxClientes();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ventas por Cliente</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcliente=<?php echo $codcliente; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("VENTASXCLIENTES") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcliente=<?php echo $codcliente; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("VENTASXCLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcliente=<?php echo $codcliente; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("VENTASXCLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Nombre de Cliente: </label> <?php echo $reg[0]['nomcliente']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Venta</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Status</th>
                                  <th>Fecha Emisión</th>
                                  <th>Nº de Articulos</th>
                                  <th>Subtotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc %</th>
                                  <th>Imp. Total</th>
                                  <th><i class="mdi mdi-drag-horizontal"></i></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['codfactura']; ?></td>
  <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>
  <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-success'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA</span>"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
  <td><?php echo $reg[$i]['articulos']; ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>

  <td> <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php } ?>
         <tr>
          <td colspan="5"></td>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA VENTAS POR CLIENTES ##########################
?>


<?php 
########################### BUSQUEDA COMISION POR VENDEDOR ##########################
if (isset($_GET['BuscaComisionxVentas']) && isset($_GET['codsucursal']) && isset($_GET['codigo']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$codigo = limpiar($_GET['codigo']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($codigo=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE VENDEDOR PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarComisionxVentas();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Comisión en Ventas por Vendedor </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("COMISIONXVENTAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COMISIONXVENTAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COMISIONXVENTAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Nombre de Vendedor: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Venta</th>
                                  <th>Vendedor</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Status</th>
                                  <th>Fecha Emisión</th>
                                  <th>Nº de Articulos</th>
                                  <th>Subtotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc %</th>
                                  <th>Imp. Total</th>
                                  <th>Total Comisión</th>
                                  <th><i class="mdi mdi-drag-horizontal"></i></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
$TotalComision+=$reg[$i]['totalpago']*$reg[$i]['comision']/100;
?>
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['codfactura']; ?></td>
                                  <td><?php echo $reg[$i]['nombres']; ?></td>
  <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>

  <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-success'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA</span>"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
  <td><?php echo $reg[$i]['articulos']; ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago']*$reg[$i]['comision']/100, 2, '.', ','); ?></td>
  <td> <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php  }  ?>
         <tr>
          <td colspan="6"></td>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalComision, 2, '.', ','); ?></strong></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA DE COMISION POR VENDEDOR ##########################
?>

<?php 
########################### BUSQUEDA DE DETALLES VENTAS POR FECHAS ##########################
if (isset($_GET['BuscaDetallesVentasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarDetallesVentasxFechas();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Ventas por Fecha</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DETALLESVENTASXFECHAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESVENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESVENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Tipo</th>
                                  <th>Descripción</th>
                                  <th>Marca</th>
                                  <th>Modelo</th>
                                  <th>Desc</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Precio de Venta</th>
                                  <th>Existencia</th>
                                  <th>Vendido</th>
                                  <th>Monto Total</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                      <td><?php echo $a++; ?></div></td>
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
                        <?php  }  ?>
                      <tr>
                        <td colspan="7"></td>
                        <td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
                        <td><strong><?php echo $ExisteTotal; ?></strong></td>
                        <td><strong><?php echo $VendidosTotal; ?></strong></td>
                        <td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
                      </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA DE DETALLES VENTAS POR FECHAS ##########################
?>


<?php 
########################### BUSQUEDA DE DETALLES VENTAS POR VENDEDOR ##########################
if (isset($_GET['BuscaDetallesVentasxVendedor']) && isset($_GET['codsucursal']) && isset($_GET['codigo']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$codigo = limpiar($_GET['codigo']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($codigo=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE VENDEDOR PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarDetallesVentasxVendedor();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Ventas por Vendedor</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DETALLESVENTASXVENDEDOR") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESVENTASXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESVENTASXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Nombre de Vendedor: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Tipo</th>
                                  <th>Descripción</th>
                                  <th>Marca</th>
                                  <th>Modelo</th>
                                  <th>Desc</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Precio de Venta</th>
                                  <th>Existencia</th>
                                  <th>Vendido</th>
                                  <th>Monto Total</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                      <td><?php echo $a++; ?></div></td>
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
                        <?php  }  ?>
                      <tr>
                        <td colspan="7"></td>
                        <td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
                        <td><strong><?php echo $ExisteTotal; ?></strong></td>
                        <td><strong><?php echo $VendidosTotal; ?></strong></td>
                        <td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
                      </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA DE DETALLES VENTAS POR VENDEDOR ##########################
?>





































<?php
####################### MOSTRAR VENTA DE CREDITO EN VENTANA MODAL #######################
if (isset($_GET['BuscaCreditoModal']) && isset($_GET['codventa']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->CreditosPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-dark">SUCURSAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?></p>

  <h4><b class="text-dark">Nº VENTA <?php echo $reg[0]['codfactura']; ?></b></h4>
  <p class="text-muted m-l-5">Nº DE CAJA: <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?>
  <br>TOTAL FACTURA: <?php echo $simbolo.number_format($reg[0]['totalpago'], 2, '.', ','); ?>
  <br>TOTAL ABONO: <?php echo $simbolo.number_format($reg[0]['creditopagado'], 2, '.', ','); ?>
  <br>TOTAL DEBE: <?php echo $simbolo.number_format($reg[0]['totalpago']-$reg[0]['creditopagado'], 2, '.', ','); ?>
  
  <br>DIAS VENCIDOS: 
  <?php if($reg[0]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[0]['fechavencecredito'] >= date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']); }
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[0]['fechapagado'],$reg[0]['fechavencecredito']); } ?>
  
  <br>STATUS: 
  <?php if($reg[0]['fechavencecredito']== '0000-00-00') { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[0]["statusventa"]."</span>"; } 
        elseif($reg[0]['fechavencecredito'] >= date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-success'><i class='fa fa-exclamation-circle'></i> ".$reg[0]["statusventa"]."</span>"; } 
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA</span>"; }
        elseif($reg[0]['fechavencecredito'] <= date("Y-m-d") && $reg[0]['fechapagado']!= "0000-00-00") { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[0]["statusventa"]."</span>"; } ?>
  <?php if($reg[0]['fechapagado']!= "0000-00-00") { ?>
  <br>FECHA PAGADA: <?php echo date("d-m-Y",strtotime($reg[0]['fechapagado'])); ?>
  <?php } ?>

  <br>FECHA DE EMISIÓN: <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechaventa'])); ?></p>

  <h4><b class="text-dark">CLIENTE </b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['nomcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']; ?>,
  <?php echo $reg[0]['direccliente'] == '' ? "" : "<br/>".$reg[0]['direccliente']; ?>
  <?php echo $reg[0]['provincia2'] == '' ? "" : "<br/>".$reg[0]['provincia2']; ?> <?php echo $reg[0]['departamento2'] == '' ? "" : strtoupper($reg[0]['departamento2']); ?>
  <br/> EMAIL: <?php echo $reg[0]['emailcliente'] == '' ? "*******" : $reg[0]['emailcliente']; ?>
  <br/> Nº <?php echo $reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['dnicliente'] == '' ? "*******" : $reg[0]['dnicliente']; ?> - TLF: <?php echo $reg[0]['tlfcliente'] == '' ? "*******" : $reg[0]['tlfcliente']; ?></p>


                                        </address>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-10" style="clear: both;">
                                        <table class="table table-hover">
                               <thead>
                        <tr><th colspan="4">Detalles de Abonos</th></tr>
                        <tr>
                        <th>#</th>
                        <th>Nº de Caja</th>
                        <th>Monto de Abono</th>
                        <th>Fecha de Abono</th>
                        </tr>
                                            </thead>
                                            <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesAbonos();

if($detalle==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON ABONOS ACTUALMENTE </center>";
    echo "</div>";    

} else {

$a=1;
for($i=0;$i<sizeof($detalle);$i++){  

?>
                                                <tr>
      <td><?php echo $a++; ?></td>
      <td><?php echo $detalle[$i]['nrocaja'].": ".$detalle[$i]['nomcaja']; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['montoabono'], 2, '.', ','); ?></td>
      <td><?php echo date("d-m-Y H:i:s",strtotime($detalle[$i]['fechaabono'])); ?></td>
                                                </tr>
                                      <?php } } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <hr>

                                <div class="col-md-12">
                                    <div class="text-right">
 <a href="reportepdf?codventa=<?php echo encrypt($reg[0]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCREDITO") ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"><span><i class="fa fa-print"></i> Imprimir</span></button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                                    </div>
                                </div>
                              </div>
                <!-- .row -->
  <?php
   } 
####################### MOSTRAR VENTA DE CREDITO EN VENTANA MODAL #######################
?>


<?php
########################## BUSQUEDA CREDITOS POR CLIENTES ##########################
if (isset($_GET['BuscaCreditosxClientes']) && isset($_GET['codsucursal']) && isset($_GET['cliente'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $cliente = limpiar($_GET['cliente']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($cliente=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL CLIENTE CORRECTAMENTE</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarCreditosxClientes();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ventas a Créditos por Cliente</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&cliente=<?php echo $cliente; ?>&tipo=<?php echo encrypt("CREDITOSXCLIENTES") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&cliente=<?php echo $cliente; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CREDITOSXCLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&cliente=<?php echo $cliente; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CREDITOSXCLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Nº de <?php echo $reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']; ?>: </label> <?php echo $reg[0]['dnicliente']; ?><br>

            <label class="control-label">Nombre de Cliente: </label> <?php echo $reg[0]['nomcliente']; ?><br>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Venta</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Observaciones</th>
                                  <th>Status</th>
                                  <th>Dias Venc</th>
                                  <th>Fecha Emisión</th>
                                  <th>Imp. Total</th>
                                  <th>Total Abono</th>
                                  <th>Total Debe</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['codfactura']; ?></td>
  <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>
           <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-success'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA</span>"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>

<td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  
  <td> 

<?php if($_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero"){ ?>

<button type="button" class="btn btn-info btn-rounded waves-effect waves-light" data-placement="left" title="Abonar" data-original-title="" data-href="#" data-toggle="modal" data-target="#ModalAbonos" data-backdrop="static" data-keyboard="false" onClick="AbonoCreditoVenta2('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo $reg[$i]["codcliente"]; ?>',
'<?php echo encrypt($reg[$i]["codventa"]); ?>',
'<?php echo $reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3'].": ".$reg[$i]["dnicliente"]; ?>',
'<?php echo $reg[$i]["nomcliente"]; ?>',
'<?php echo $reg[$i]["codventa"]; ?>',
'<?php echo number_format($reg[$i]["totalpago"], 2, '.', ''); ?>',
'<?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?>',
'<?php echo number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ''); ?>',
'<?php echo number_format($reg[$i]['creditopagado'], 2, '.', ''); ?>')"><i class="fa fa-credit-card"></i></button>

<?php } ?>

<a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCREDITO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-warning btn-rounded text-white" title="Imprimir Pdf"><i class="fa fa-print"></i></button>

<a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></td>
                                  </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="7"></td>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA CREDITOS POR CLIENTES ##########################
?>

<?php
########################## BUSQUEDA CREDITOS POR FECHAS ##########################
if (isset($_GET['BuscaCreditosxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarCreditosxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ventas a Créditos por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("CREDITOSXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CREDITOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CREDITOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Venta</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Observaciones</th>
                                  <th>Status</th>
                                  <th>Dias Venc</th>
                                  <th>Fecha Emisión</th>
                                  <th>Imp. Total</th>
                                  <th>Total Abono</th>
                                  <th>Total Debe</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['codfactura']; ?></td>
  <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>
           <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-success'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA</span>"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>

<td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  <td>

<?php if($_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero"){ ?>

<button type="button" class="btn btn-info btn-rounded waves-effect waves-light" data-placement="left" title="Abonar" data-original-title="" data-href="#" data-toggle="modal" data-target="#ModalAbonos" data-backdrop="static" data-keyboard="false" onClick="AbonoCreditoVenta3('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo $reg[$i]["codcliente"]; ?>',
'<?php echo encrypt($reg[$i]["codventa"]); ?>',
'<?php echo $reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3'].": ".$reg[$i]["dnicliente"]; ?>',
'<?php echo $reg[$i]["nomcliente"]; ?>',
'<?php echo $reg[$i]["codventa"]; ?>',
'<?php echo number_format($reg[$i]["totalpago"], 2, '.', ''); ?>',
'<?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?>',
'<?php echo number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ''); ?>',
'<?php echo number_format($reg[$i]['creditopagado'], 2, '.', ''); ?>',
'<?php echo $desde; ?>',
'<?php echo $hasta; ?>')"><i class="fa fa-credit-card"></i></button>

<?php } ?>

 <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCREDITO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-warning btn-rounded text-white" title="Imprimir Pdf"><i class="fa fa-print"></i></button>

<a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></td>
                                  </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="7"></td>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA CREDITOS POR FECHAS ##########################
?>

<?php
########################## BUSQUEDA CREDITOS POR DETALLES ##########################
if (isset($_GET['BuscaCreditosxDetalles']) && isset($_GET['codsucursal']) && isset($_GET['cliente']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $cliente = limpiar($_GET['cliente']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

  if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

  } else if($cliente=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL CLIENTE CORRECTAMENTE</center>";
  echo "</div>";   
  exit;

  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

  } else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarCreditosxDetalles();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ventas a Créditos por Cliente</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&cliente=<?php echo $cliente; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("CREDITOSXDETALLES") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&cliente=<?php echo $cliente; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CREDITOSXDETALLES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&cliente=<?php echo $cliente; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CREDITOSXDETALLES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Nº de <?php echo $reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']; ?>: </label> <?php echo $reg[0]['dnicliente']; ?><br>

            <label class="control-label">Nombre de Cliente: </label> <?php echo $reg[0]['nomcliente']; ?><br>
            
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Venta</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Observaciones</th>
                                  <th>Detalles Productos</th>
                                  <th>Status</th>
                                  <th>Dias Venc</th>
                                  <th>Fecha Emisión</th>
                                  <th>Imp. Total</th>
                                  <th>Total Abono</th>
                                  <th>Total Debe</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['codfactura']; ?></td>
  <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>
           <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
           <td><?php echo $reg[$i]['detalles']; ?></td>
      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-success'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA</span>"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>

<td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  <td>
<?php if($_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero"){ ?>

<button type="button" class="btn btn-info btn-rounded waves-effect waves-light" data-placement="left" title="Abonar" data-original-title="" data-href="#" data-toggle="modal" data-target="#ModalAbonos" data-backdrop="static" data-keyboard="false" onClick="AbonoCreditoVenta4('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo $reg[$i]["codcliente"]; ?>',
'<?php echo encrypt($reg[$i]["codventa"]); ?>',
'<?php echo $reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3'].": ".$reg[$i]["dnicliente"]; ?>',
'<?php echo $reg[$i]["nomcliente"]; ?>',
'<?php echo $reg[$i]["codventa"]; ?>',
'<?php echo number_format($reg[$i]["totalpago"], 2, '.', ''); ?>',
'<?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?>',
'<?php echo number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ''); ?>',
'<?php echo number_format($reg[$i]['creditopagado'], 2, '.', ''); ?>',
'<?php echo $desde; ?>',
'<?php echo $hasta; ?>')"><i class="fa fa-credit-card"></i></button>

<?php } ?>

 <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCREDITO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-warning btn-rounded text-white" title="Imprimir Pdf"><i class="fa fa-print"></i></button>

<a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></td>
                                  </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="8"></td>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA CREDITOS POR DETALLES ##########################
?>


































<?php
######################## MOSTRAR FACTURA PARA NOTA DE CREDITO ########################
if (isset($_GET['ProcesaNotaCredito']) && isset($_GET['codventa']) && isset($_GET['codsucursal']) && isset($_GET['descontar'])) { 
 
  $codventa = limpiar($_GET['codventa']);
  $codsucursal = limpiar($_GET['codsucursal']);
  $descontar = limpiar($_GET['descontar']);
  $codarqueo = limpiar(isset($_GET['codarqueo']) ? $_GET["codarqueo"] : "");

  $reg = $new->BuscarVentasPorId();
  $simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

 if($codventa=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL Nº DE DOCUMENTO CORRECTAMENTE</center>";
   echo "</div>";   
   exit;

 } else if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if(isset($_GET['codarqueo']) && $codarqueo=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

 } elseif($reg==""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> EL Nº DE DOCUMENTO INGRESADO NO SE ENCUENTRA REGISTRADO </center>";
  echo "</div>";    

} else {

?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalle de <?php echo $reg[0]['tipodocumento']." Nº: ".$reg[0]['codventa']; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="table-responsive m-t-20">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Devolución</th>
                        <th>Vendido</th>
                        <th>Tipo</th>
                        <th>Descripción de Producto</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->BuscarDetallesVentas();

$SubTotal = 0;
$a=1;
$b=0;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto'];
$c = $b++; 
$count++; 
?>
                                 <tr>
      <td>
      <input type="text" step="1" min="0" class="form-control cantidad bold" name="devuelto[]" id="devuelto_<?php echo $count; ?>" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoDevolucion(<?php echo $count; ?>);" autocomplete="off" placeholder="Devolución" style="width: 80px;background:#e4e7ea;border-radius:5px 5px 5px 5px;" onfocus="this.style.background=('#B7F0FF')" onfocus="this.style.background=('#B7F0FF')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e4e7ea');" title="" value="0">
      </td>

      <td><h5><strong><?php echo $detalle[$i]['cantventa']; ?></strong></h5></td>

      <td class="text-danger alert-link"><?php echo $detalle[$i]['tipodetalle'] == 1 ? "PRODUCTO" : "SERVICIO"; ?></td>

      <td class="text-left">
      <input type="hidden" name="coddetalleventa[]" id="coddetalleventa" value="<?php echo encrypt($detalle[$i]["coddetalleventa"]); ?>">
      <input type="hidden" name="idproducto[]" id="idproducto" value="<?php echo $detalle[$i]["idproducto"]; ?>">
      <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
      <input type="hidden" name="tipodetalle[]" id="tipodetalle" value="<?php echo $detalle[$i]["tipodetalle"]; ?>">
      <input type="hidden" name="producto[]" id="producto" value="<?php echo $detalle[$i]["producto"]; ?>">
      <input type="hidden" name="codmarca[]" id="codmarca" value="<?php echo $detalle[$i]["codmarca"]; ?>">
      <input type="hidden" name="codmodelo[]" id="codmodelo" value="<?php echo $detalle[$i]["codmodelo"]; ?>">
      <input type="hidden" name="codpresentacion[]" id="codpresentacion" value="<?php echo $detalle[$i]["codpresentacion"]; ?>">
      <input type="hidden" name="cantidad[]" id="cantidad_<?php echo $count; ?>" value="<?php echo $detalle[$i]["cantventa"]; ?>">
      <h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5>
      <small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
      <td>
      <input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>">
      <input type="hidden" name="precioventa[]" id="precioventa_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>"><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ''); ?></td>
      <td>
      <input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="0.00">
      <strong><label id="txtvalortotal_<?php echo $count; ?>">0.00</label></strong></td>
      
      <td>
      <input type="hidden" name="descproducto[]" id="descproducto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["descproducto"], 2, '.', ''); ?>">
      <input type="hidden" class="totaldescuentov" name="totaldescuentov[]" id="totaldescuentov_<?php echo $count; ?>" value="0.00">
      <?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup>0.00%</sup></td>

      <td>
      <input type="hidden" name="ivaproducto[]" id="ivaproducto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["ivaproducto"]; ?>"><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? $reg[0]['iva']."%" : "(E)"; ?></td>

      <td><input type="hidden" class="subtotalivasi" name="subtotalivasi[]" id="subtotalivasi_<?php echo $count; ?>" value="0.00">

        <input type="hidden" class="subtotalivano" name="subtotalivano[]" id="subtotalivano_<?php echo $count; ?>" value="0.00">

        <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="0.00" >

        <strong> <label id="txtvalorneto_<?php echo $count; ?>">0.00</label></strong></td>
                                 </tr>
                     <?php } ?>
                </tbody>
            </table><hr>
            <input type="hidden" name="abonototal" id="abonototal" value="<?php echo number_format($reg[0]["creditopagado"], 2, '.', ''); ?>"/>
            <input type="hidden" name="tipodocumento" id="tipodocumento" value="<?php echo $reg[0]['tipodocumento']; ?>"/>
            <input type="hidden" name="tipopago" id="tipopago" value="<?php echo $reg[0]['tipopago']; ?>"/>
            <input type="hidden" name="codcliente" id="codcliente" value="<?php echo $codigo = ($reg[0]['codcliente'] == "" ? "0" : $reg[0]['codcliente']); ?>"/>

             <table id="carritototal" class="table-responsive">
                <tr>
    <td width="250"><h5><label>Gravado <?php echo number_format($reg[0]['iva'], 2, '.', '') ?>%:</label></h5></td>
    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal" name="lblsubtotal">0.00</label></h5>
    <input type="hidden" name="txtsubtotal" id="txtsubtotal" value="0.00"/>    </td>
                  
    <td width="250">
    <h5><label>Exento 0%:</label></h5>    </td>

    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal2" name="lblsubtotal2">0.00</label></h5>
    <input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="0.00"/>    </td>
    
    <td width="250"><h5><label><?php echo $impuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', '') ?>%:<input type="hidden" name="iva" id="iva" autocomplete="off" value="<?php echo number_format($reg[0]['iva'], 2, '.', '') ?>"></label></h5>
    </td>

    <td class="text-center" width="250">
    <h5><?php echo $simbolo; ?><label id="lbliva" name="lbliva">0.00</label></h5>
    <input type="hidden" name="txtIva" id="txtIva" value="0.00"/>
    </td>
                </tr>
                <tr>
    <td>
    <h5><label>Descontado %:</label></h5> </td>
    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescontado" name="lbldescontado">0.00</label></h5>
    <input type="hidden" name="txtdescontado" id="txtdescontado" value="0.00"/>
        </td>
    
    <td>
    <h5><label>Desc. Global <?php echo number_format($reg[0]['descuento'], 2, '.', '') ?>%:</label></h5>    </td>

    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescuento" name="lbldescuento">0.00</label></h5>
    <input type="hidden" name="descuento" id="descuento" value="<?php echo number_format($reg[0]['descuento'], 2, '.', '') ?>">
    <input type="hidden" name="txtDescuento" id="txtDescuento" value="0.00"/></td>

    <td><h4><b>Importe Total</b></h4>
    </td>

    <td class="text-center">
    <h4><b><?php echo $simbolo; ?><label id="lbltotal" name="lbltotal">0.00</label></b></h4>
    <input type="hidden" name="txtTotal" id="txtTotal" value="0.00"/></td>
                    </tr>
                  </table>
        </div>

      <div class="text-right">
<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-primary"><span class="fa fa-save"></span> Guardar Nota</button>
      </div>
          
        </div>
      </div>

    </div>
  </div>
</div>
<!-- End Row -->

<?php  
    }
}
?>


<?php
######################## MOSTRAR NOTA DE CREDITO EN VENTANA MODAL ########################
if (isset($_GET['BuscaNotaModal']) && isset($_GET['codnota']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->NotaCreditoPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

  if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON VENTAS Y DETALLES ACTUALMENTE </center>";
    echo "</div>";    

} else {

?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-dark">RAZÓN SOCIAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?></p>

  <h4><b class="text-dark">Nº NOTA CRÉDITO <?php echo $reg[0]['codfactura']; ?></b></h4>
  <p class="text-muted m-l-5">Nº <?php echo $reg[0]['tipodocumento']; ?>: <?php echo $reg[0]['facturaventa']; ?>

  <br>MOTIVO DE NOTA: <?php echo $reg[0]["observaciones"]; ?>
  
  <br>FECHA DE EMISIÓN: <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechanota'])); ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-dark">CLIENTE</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nomcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']; ?>,
  <?php echo $reg[0]['direccliente'] == '' ? "" : "<br/>".$reg[0]['direccliente']; ?>
  <?php echo $reg[0]['provincia2'] == '' ? "" : "<br/>".$reg[0]['provincia2']; ?> <?php echo $reg[0]['departamento2'] == '' ? "" : strtoupper($reg[0]['departamento2']); ?>
  <br/> EMAIL: <?php echo $reg[0]['emailcliente'] == '' ? "*******" : $reg[0]['emailcliente']; ?>
  <br/> Nº <?php echo $reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['dnicliente'] == '' ? "*******" : $reg[0]['dnicliente']; ?> - TLF: <?php echo $reg[0]['tlfcliente'] == '' ? "*******" : $reg[0]['tlfcliente']; ?></p>
                                            
                                        </address>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-10" style="clear: both;">
                                        <table class="table table-hover">
                               <thead>
                        <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesNotasCredito();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto'];
?>
                                                <tr>
      <td><?php echo $a++; ?></td>
      <td><h5><?php echo $detalle[$i]['producto']; ?></h5>
      <small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
      <td><?php echo $detalle[$i]['cantventa']; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($reg[0]['iva'], 2, '.', ',')."%" : "(E)"; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
                                                </tr>
                                      <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="col-md-12">

                                    <div class="pull-right text-right">
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($SubTotal, 2, '.', ','); ?></p>
<p><b>Gravado  <?php echo number_format($reg[0]['iva'], 2, '.', '.') ?>%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivasi'], 2, '.', ','); ?><p>
<p><b>Exento 0%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivano'], 2, '.', ','); ?></p>
<p><b>Total <?php echo $impuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaliva'], 2, '.', ','); ?> </p>
<p><b>Descontado %:</b> <?php echo $simbolo.number_format($reg[0]['descontado'], 2, '.', ','); ?></p>
<p><b>Desc. Global (<?php echo number_format($reg[0]['descuento'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaldescuento'], 2, '.', ','); ?> </p>
                                        <hr>
<h4><b>Importe Total:</b> <?php echo $simbolo.number_format($reg[0]['totalpago'], 2, '.', ','); ?></h4></div>
                                    <div class="clearfix"></div>
                                    <hr>

                                <div class="col-md-12">
                                    <div class="text-right">
 <a href="reportepdf?codnota=<?php echo encrypt($reg[0]['codnota']); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt("NOTACREDITO") ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"><span><i class="fa fa-print"></i> Imprimir</span></button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                                    </div>
                                </div>
                            </div>
                <!-- .row -->
  <?php
       }
   } 
######################## MOSTRAR NOTA DE CREDITO EN VENTANA MODAL ########################
?>

<?php
########################## BUSQUEDA NOTAS DE CREDITOS POR CAJAS ##########################
if (isset($_GET['BuscaNotasxCajas']) && isset($_GET['codsucursal']) && isset($_GET['codcaja']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codcaja = limpiar($_GET['codcaja']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($codcaja=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarNotasxCajas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Notas de Créditos por Caja</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("NOTASCREDITOXCAJAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("NOTASCREDITOXCAJAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("NOTASCREDITOXCAJAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Nº de Caja: </label> <?php echo $reg[0]['nrocaja']; ?><br>

            <label class="control-label">Nombre de Caja: </label> <?php echo $reg[0]['nomcaja']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                                <th>N°</th>
                                <th>N° de Caja</th>
                                <th>N° de Nota</th>
                                <th>Nº de Documento</th>
                                <th>Descripción de Cliente</th>
                                <th>Motivo de Nota</th>
                                <th>Fecha Emisión</th>
                                <th>SubTotal</th>
                                <th><?php echo $impuesto; ?></th>
                                <th>Dcto</th>
                                <th>Imp. Total</th>
                                <th><i class="mdi mdi-drag-horizontal"></i></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                    <td><?php echo $a++; ?></td>
                    <td><?php echo $caja = ($reg[$i]['codcaja'] == '0' ? "**********" : $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']); ?></td>
                    <td><?php echo $reg[$i]['codfactura']; ?></td>
                    <td><?php echo $reg[$i]['tipodocumento']." Nº: ".$reg[$i]['facturaventa']; ?></td>
                    <td><?php echo $reg[$i]['codcliente'] == '' || $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
                    <td><?php echo $reg[$i]['observaciones']; ?></td>

                    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechanota'])); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
                                               <td>
<a href="reportepdf?codnota=<?php echo encrypt($reg[$i]['codnota']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("NOTACREDITO"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
                                              </td>

                                </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="7"></td>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?> </td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA NOTAS DE CREDITOS POR CAJAS ########################
?>

<?php
########################## BUSQUEDA NOTAS DE CREDITOS POR FECHAS ##########################
if (isset($_GET['BuscaNotasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarNotasxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Notas de Créditos por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("NOTASCREDITOXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("NOTASCREDITOXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("NOTASCREDITOXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                                <th>N°</th>
                                <th>N° de Nota</th>
                                <th>Nº de Documento</th>
                                <th>Descripción de Cliente</th>
                                <th>Motivo de Nota</th>
                                <th>Fecha Emisión</th>
                                <th>SubTotal</th>
                                <th><?php echo $impuesto; ?></th>
                                <th>Dcto %</th>
                                <th>Imp. Total</th>
                                <th><i class="mdi mdi-drag-horizontal"></i></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                    <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codfactura']; ?></td>
                    <td><?php echo $reg[$i]['tipodocumento']." Nº: ".$reg[$i]['facturaventa']; ?></td>
                    <td><?php echo $reg[$i]['codcliente'] == '' || $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
                    <td><?php echo $reg[$i]['observaciones']; ?></td>

                    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechanota'])); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
                                               <td>
<a href="reportepdf?codnota=<?php echo encrypt($reg[$i]['codnota']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("NOTACREDITO"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
                                              </td>

                                </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="6"></td>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?> </td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA NOTAS DE CREDITOS POR FECHAS ########################
?>


<?php
######################## BUSQUEDA NOTAS DE CREDITOS POR CLIENTES ########################
if (isset($_GET['BuscaNotasxClientes']) && isset($_GET['codsucursal']) && isset($_GET['codcliente'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codcliente = limpiar($_GET['codcliente']);

if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codcliente=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL CLIENTE CORRECTAMENTE</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarNotasxClientes();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Notas de Créditos del Cliente</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcliente=<?php echo $codcliente; ?>&tipo=<?php echo encrypt("NOTASCREDITOXCLIENTE") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcliente=<?php echo $codcliente; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("NOTASCREDITOXCLIENTE") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcliente=<?php echo $codcliente; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("NOTASCREDITOXCLIENTE") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Nombre de Cliente: </label> <?php echo $reg[0]['nomcliente']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                                <th>N°</th>
                                <th>N° de Nota</th>
                                <th>Nº de Documento</th>
                                <th>Motivo de Nota</th>
                                <th>Fecha Emisión</th>
                                <th>SubTotal</th>
                                <th><?php echo $impuesto; ?></th>
                                <th>Dcto %</th>
                                <th>Imp. Total</th>
                                <th><i class="mdi mdi-drag-horizontal"></i></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                    <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codfactura']; ?></td>
                    <td><?php echo $reg[$i]['tipodocumento']." Nº: ".$reg[$i]['facturaventa']; ?></td>
                    <td><?php echo $reg[$i]['observaciones']; ?></td>

                    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechanota'])); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
                                               <td>
<a href="reportepdf?codnota=<?php echo encrypt($reg[$i]['codnota']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("NOTACREDITO"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
                                              </td>

                                </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="5"></td>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA NOTAS DE CREDITOS POR CLIENTES ##########################
?>
