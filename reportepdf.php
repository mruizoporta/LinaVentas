<?php
include_once('fpdf/pdf.php');
include_once ('fpdf/barcode.php');
require_once("class/class.php");
//ob_end_clean();
//error_reporting(0);
ob_start();

$casos = array (

                  'PROVINCIAS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarProvincias',

                                    'output' => array('Listado de Provincias.pdf', 'I')

                                  ),

                  'DEPARTAMENTOS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarDepartamentos',

                                    'output' => array('Listado de Departamentos.pdf', 'I')

                                  ),

                  'DOCUMENTOS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarDocumentos',

                                    'output' => array('Listado de Tipos de Documentos.pdf', 'I')

                                  ),

                  'TIPOMONEDA' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarTiposMonedas',

                                    'output' => array('Listado de Tipos de Moneda.pdf', 'I')

                                  ),

                'TIPOCAMBIO' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarTiposCambio',

                                    'output' => array('Listado de Tipos de Cambio.pdf', 'I')

                                  ),
                  
                  'MEDIOSPAGOS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarMediosPagos',

                                    'output' => array('Listado de Medios de Pago.pdf', 'I')

                                  ),
                  
                  'IMPUESTOS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarImpuestos',

                                    'output' => array('Listado de Impuestos.pdf', 'I')

                                  ),

                  'FAMILIAS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarFamilias',

                                    'output' => array('Listado de Familias.pdf', 'I')

                                  ),

                  'SUBFAMILIAS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarSubfamilias',

                                    'output' => array('Listado de Sub-Familias.pdf', 'I')

                                  ),

                  'MARCAS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarMarcas',

                                    'output' => array('Listado de Marcas.pdf', 'I')

                                  ),

                  'MODELOS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarModelos',

                                    'output' => array('Listado de Modelos.pdf', 'I')

                                  ),

                   'PRESENTACIONES' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarPresentaciones',

                                    'output' => array('Listado de Presentaciones.pdf', 'I')

                                  ),

                  'COLORES' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarColores',

                                    'output' => array('Listado de Colores.pdf', 'I')

                                  ),

                  'ORIGENES' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarOrigenes',

                                    'output' => array('Listado de Origenes.pdf', 'I')

                                  ),

                  'SUCURSALES' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarSucursales',

                                    'output' => array('Listado de Sucursales.pdf', 'I')

                                  ),

                  'USUARIOS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarUsuarios',

                                    'output' => array('Listado de Usuarios.pdf', 'I')

                                  ),

                  'LOGS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarLogs',

                                    'output' => array('Listado Logs de Acceso.pdf', 'I')

                                  ),

                  'CLIENTES' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarClientes',

                                    'output' => array('Listado de Clientes.pdf', 'I')

                                  ),

                  'PROVEDORES' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarProveedores',

                                    'output' => array('Listado de Proveedores.pdf', 'I')

                                  ),

                 'FACTURAPEDIDO' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'FacturaPedido',

                                    'output' => array('Factura de Pedido.pdf', 'I')

                                  ),

                 'PEDIDOS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'ListarPedidos',

                                    'output' => array('Listado de Pedidos.pdf', 'I')

                                  ),

                  'PEDIDOSXPROVEEDOR' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarPedidosxProveedor',

                                    'output' => array('Listado de Pedidos x Proveedor.pdf', 'I')

                                  ),

                 'PRODUCTOS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarProductos',

                                    'output' => array('Listado de Productos.pdf', 'I')

                                  ),

                 'STOCKOPTIMO' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarProductosOptimo',

                                    'output' => array('Listado de Productos en Stock Optimo.pdf', 'I')

                                  ),

                 'STOCKMEDIO' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarProductosMedio',

                                    'output' => array('Listado de Productos en Stock Medio.pdf', 'I')

                                  ),

                 'STOCKMINIMO' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarProductosMinimo',

                                    'output' => array('Listado de Productos en Stock Minimo.pdf', 'I')

                                  ),

                 'CODIGOBARRAS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarCodigoBarras',

                                    'output' => array('Listado de Código de Barras.pdf', 'I')

                                  ),

                  'PRODUCTOSXSUCURSALES' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarProductosxSucursal',

                                    'output' => array('Listado de Productos.pdf', 'I')

                                  ),

                  'PRODUCTOSXMONEDA' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarProductosxMoneda',

                                    'output' => array('Listado de Productos por Moneda.pdf', 'I')

                                  ),

                   'KARDEXPRODUCTOS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarKardex',

                                    'output' => array('Listado de Kardex de Producto.pdf', 'I')

                                  ),

                  'KARDEXVALORIZADO' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarKardexValorizado',

                                    'output' => array('Listado de Kardex Valorizado.pdf', 'I')

                                  ),

                  'VALORIZADOXFECHAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarKardexValorizadoxFechas',

                                    'output' => array('Listado de Kardex Valorizado por Fechas.pdf', 'I')

                                  ),

                 'FACTURATRASPASO' => array(

                                    //'medidas' => array('P', 'mm', 'A4'),
                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'FacturaTraspaso',

                                    'output' => array('Factura de Traspasos.pdf', 'I')

                                  ),

                  'TRASPASOS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarTraspasos',

                                    'output' => array('Listado de Traspasos.pdf', 'I')

                                  ),

                  'TRASPASOSXSUCURSAL' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarTraspasosxSucursal',

                                    'output' => array('Listado de Traspasos por Sucursal.pdf', 'I')

                                  ),

                  'TRASPASOSXFECHAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarTraspasosxFechas',

                                    'output' => array('Listado de Traspasos por Fechas.pdf', 'I')

                                  ),

                  'DETALLESTRASPASOSXFECHAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarDetallesTraspasosxFechas',

                                    'output' => array('Listado de Detalles Traspasos por Fechas.pdf', 'I')

                                  ),

                 'FACTURACOMPRA' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'FacturaCompra',

                                    'output' => array('Factura de Compra.pdf', 'I')

                                  ),

                 'COMPRAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarCompras',

                                    'output' => array('Listado de Compras.pdf', 'I')

                                  ),

                 'CUENTASXPAGAR' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarCuentasxPagar',

                                    'output' => array('Listado de Cuentas por Pagar.pdf', 'I')

                                  ),

              'COMPRASXPROVEEDOR' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarComprasxProveedor',

                                    'output' => array('Listado de Compras por Proveedor.pdf', 'I')

                                  ),

              'COMPRASXFECHAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarComprasxFechas',

                                    'output' => array('Listado de Compras por Fechas.pdf', 'I')

                                  ),

        
                  'TICKETCOMPRA' => array(

                                    'medidas' => array('P','mm','ticketcredito'),

                                    'func' => 'TicketCreditoCompra',

                                    'setPrintFooter' => 'true',

                                    'output' => array('Ticket de Abonos.pdf', 'I')

                                  ),

                  'CREDITOSXPROVEEDOR' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarCreditosxProveedor',

                                    'output' => array('Listado de Creditos por Proveedor.pdf', 'I')

                                  ),

                  'CREDITOSCOMPRASXFECHAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarCreditosComprasxFechas',

                                    'output' => array('Listado de Creditos de Compras por Fechas.pdf', 'I')

                                  ),

                 'FACTURACOTIZACION' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'FacturaCotizacion',

                                    'setPrintFooter' => 'true',

                                    'output' => array('Factura de Cotizacion.pdf', 'I')

                                  ),

                  'COTIZACIONES' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarCotizaciones',

                                    'output' => array('Listado de Cotizaciones.pdf', 'I')

                                  ),

                  'COTIZACIONESXFECHAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarCotizacionesxFechas',

                                    'output' => array('Listado de Cotizaciones.pdf', 'I')

                                  ),

                  'DETALLESCOTIZACIONESXFECHAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarDetallesCotizacionesxFechas',

                                    'output' => array('Listado de Detalles por Fechas.pdf', 'I')

                                  ),

                  'DETALLESCOTIZACIONESXVENDEDOR' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarDetallesCotizacionesxVendedor',

                                    'output' => array('Listado de Detalles por Vendedor.pdf', 'I')

                                  ),


                 'TICKETPREVENTA' => array(

                                    'medidas' => array('P','mm','ticket'),

                                    'func' => 'TicketPreventa',

                                    'setPrintFooter' => 'true',

                                    'output' => array('Ticket de Preventa.pdf', 'I')

                                  ),

                  'PREVENTAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarPreventas',

                                    'output' => array('Listado de Preventas.pdf', 'I')

                                  ),

                  'CLIENTESXPREVENTAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'ClientesxPreventas',

                                    'output' => array('Listado de Preventas a Clientes.pdf', 'I')

                                  ),

                  'PREVENTASXFECHAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarPreventasxFechas',

                                    'output' => array('Listado de Preventas.pdf', 'I')

                                  ),

                  'DETALLESPREVENTASXFECHAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarDetallesPreventasxFechas',

                                    'output' => array('Listado de Detalles por Fechas.pdf', 'I')

                                  ),

                  'DETALLESPREVENTASXVENDEDOR' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarDetallesPreventasxVendedor',

                                    'output' => array('Listado de Detalles por Vendedor.pdf', 'I')

                                  ),

                  'GUIAPREVENTAXFECHAS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),
                                    //'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'GuiaPreventaxFechas',

                                    'setPrintFooter' => 'true',

                                    'output' => array('Guia de Remision.pdf', 'I')

                                  ),

                'CAJAS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarCajas',

                                    'output' => array('Listado de Cajas.pdf', 'I')

                                  ),

               'ARQUEOS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarArqueos',

                                    'output' => array('Listado de Arqueos de Cajas.pdf', 'I')

                                  ),
        
                  'TICKETCIERRE' => array(

                                    'medidas' => array('P','mm','cierre'),

                                    'func' => 'TicketCierre',

                                    'setPrintFooter' => 'true',

                                    'output' => array('Ticket de Cierre.pdf', 'I')

                                  ),
        
                  'TICKETMOVIMIENTO' => array(

                                    'medidas' => array('P','mm','movimiento'),

                                    'func' => 'TicketMovimiento',

                                    'setPrintFooter' => 'true',

                                    'output' => array('Ticket de Movimiento.pdf', 'I')

                                  ),

                'MOVIMIENTOS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarMovimientos',

                                    'output' => array('Listado de Movimientos en Caja.pdf', 'I')

                                  ),

                   'ARQUEOSXFECHAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarArqueosxFechas',

                                    'output' => array('Listado de Arqueos por Fechas.pdf', 'I')

                                  ),

                  'MOVIMIENTOSXFECHAS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarMovimientosxFechas',

                                    'output' => array('Listado de Movimientos por Fechas.pdf', 'I')

                                  ),
        
                  'TICKET' => array(

                                    'medidas' => array('P','mm','ticket'),

                                    'func' => 'TicketVenta',

                                    'setPrintFooter' => 'true',

                                    'output' => array('Ticket de Venta.pdf', 'I')

                                  ),

                  'FACTURA' => array(

                                    //'medidas' => array('P', 'mm', 'A4'),
                                    'medidas' => array('P','mm','mitad'),

                                    'func' => 'FacturaVenta',

                                    'setPrintFooter' => 'true',

                                    'output' => array('Factura de Venta.pdf', 'I')

                                  ),

                  'NOTA VENTA' => array(

                                    'medidas' => array('P','mm','mitad'),

                                    'func' => 'NotaVenta',

                                    'setPrintFooter' => 'true',

                                    'output' => array('Nota de Venta.pdf', 'I')

                                  ),

                  'GUIA' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'GuiaVenta',

                                    'setPrintFooter' => 'true',

                                    'output' => array('Guia de Remision.pdf', 'I')

                                  ),

                  'VENTAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarVentas',

                                    'output' => array('Listado de Ventas.pdf', 'I')

                                  ),

                  'VENTASDIARIAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarVentasDiarias',

                                    'output' => array('Listado de Ventas del Dia.pdf', 'I')

                                  ),

                  'VENTASXCAJAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarVentasxCajas',

                                    'output' => array('Listado de Ventas por Cajas.pdf', 'I')

                                  ),

                  'VENTASXFECHAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarVentasxFechas',

                                    'output' => array('Listado de Ventas por Fechas.pdf', 'I')

                                  ),

                  'VENTASXCLIENTES' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarVentasxClientes',

                                    'output' => array('Listado de Ventas por Clientes.pdf', 'I')

                                  ),

                  'COMISIONXVENTAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarComisionxVentas',

                                    'output' => array('Listado de Comisión por Ventas.pdf', 'I')

                                  ),
        
                  'VENTASGENERAL' => array(

                                    'medidas' => array('P','mm','ticket'),

                                    'func' => 'TicketVentasGeneral',

                                    'setPrintFooter' => 'true',

                                    'output' => array('Ventas General.pdf', 'I')

                                  ),

                  'DETALLESVENTASXFECHAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarDetallesVentasxFechas',

                                    'output' => array('Listado de Detalles por Fechas.pdf', 'I')

                                  ),

                  'DETALLESVENTASXVENDEDOR' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarDetallesVentasxVendedor',

                                    'output' => array('Listado de Detalles por Vendedor.pdf', 'I')

                                  ),
        
                  'TICKETCREDITO' => array(

                                    'medidas' => array('P','mm','ticketcredito'),

                                    'func' => 'TicketCredito',

                                    'setPrintFooter' => 'true',

                                    'output' => array('Ticket de Abonos.pdf', 'I')

                                  ),

                  'CREDITOS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarCreditos',

                                    'output' => array('Listado de Creditos.pdf', 'I')

                                  ),

                  'CREDITOSXCLIENTES' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarCreditosxClientes',

                                    'output' => array('Listado de Creditos por Clientes.pdf', 'I')

                                  ),

                  'CREDITOSXFECHAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarCreditosxFechas',

                                    'output' => array('Listado de Creditos por Fechas.pdf', 'I')

                                  ),

                  'CREDITOSXDETALLES' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarCreditosxDetalles',

                                    'output' => array('Listado de Creditos por Detalles.pdf', 'I')

                                  ),
        
                  'NOTACREDITO' => array(

                                    //'medidas' => array('P', 'mm', 'A4'),
                                    'medidas' => array('P','mm','mitad'),

                                    'func' => 'NotaCredito',

                                    'setPrintFooter' => 'true',

                                    'output' => array('Nota de Credito.pdf', 'I')

                                  ),

                'NOTASCREDITO' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarNotasCredito',

                                    'output' => array('Listado de Notas de Creditos.pdf', 'I')

                                  ),

                'NOTASCREDITOXCAJAS' => array(

                                     'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarNotasxCajas',

                                    'output' => array('Listado de Notas de Creditos x Fechas.pdf', 'I')

                                  ),
                
                'NOTASCREDITOXFECHAS' => array(

                                     'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarNotasxFechas',

                                    'output' => array('Listado de Notas de Creditos x Fechas.pdf', 'I')

                                  ),

                'NOTASCREDITOXCLIENTE' => array(

                                     'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarNotasxClientes',

                                    'output' => array('Listado de Notas de Creditos x Clientes.pdf', 'I')

                                  ),
                );

 
$tipo = decrypt($_GET['tipo']);

/*if ($tipo == 'FACTURACOTIZACION' || $tipo == 'TICKETPREVENTA' || $tipo == 'TICKETCIERRE' || $tipo == 'TICKET' || $tipo == 'FACTURA' || $tipo == 'NOTA VENTA' || $tipo == 'GUIA' || $tipo == 'TICKETCREDITO') {

  $caso_data = $casos[$tipo];
  $pdf = new PDF($caso_data['medidas'][0], $caso_data['medidas'][1], $caso_data['medidas'][2]);
  $pdf->AddPage();
  $pdf->SetAuthor("Software Ventas");
  $pdf->SetCreator("FPDF Y PHP");
  $pdf->{$caso_data['func']}();
  $pdf->AutoPrint(false);
  $pdf->Output($caso_data['output'][0], $caso_data['output'][1]);
  ob_end_flush();

} else {*/

  $caso_data = $casos[$tipo];
  $pdf = new PDF($caso_data['medidas'][0], $caso_data['medidas'][1], $caso_data['medidas'][2]);
  $pdf->AddPage();
  $pdf->SetAuthor("Software Ventas");
  $pdf->SetCreator("FPDF Y PHP");
  $pdf->{$caso_data['func']}();
  $pdf->Output($caso_data['output'][0], $caso_data['output'][1]);
  ob_end_flush();
//}
?>