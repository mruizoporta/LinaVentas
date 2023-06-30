function DoAction(idproducto, codproducto, producto, codmarca, marcas, codmodelo, modelos, codpresentacion, presentacion, preciocompra, precioventa, descproducto, ivaproducto, existencia, precioconiva, tipodetalle) {
    addItem(idproducto, codproducto, 1, producto, codmarca, marcas, codmodelo, modelos, codpresentacion, presentacion, preciocompra, precioventa, descproducto, ivaproducto, existencia, precioconiva, tipodetalle, '+=');
}

function pulsar(e, valor) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 13) comprueba(valor)
}

$(document).ready(function() {

    /*############ FUNCION AGREGA POR CRITERIO ############*/
    $('.agregaventa').keypress(function(e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == '13') {
          AgregaVentas();
          e.preventDefault();
          return false;
        }
    });
    /*############ FUNCION AGREGA POR CRITERIO ############*/

    /*############ FUNCION AGREGA POR LECTOR ############*/
    $('.agregaproducto').keypress(function(e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == '13') {
            AgregaVentas();
            e.preventDefault();
            return false;
        }
    });

    $('.agregaproducto').change(function(e) {        
        AgregaVentas();
        e.preventDefault();     
    });
    /*############ FUNCION AGREGA POR LECTOR ############*/

    function AgregaVentas () {
        var code = $('input#codproducto').val();
        var prod = $('input#producto').val();
        var cantp = $('input#cantidad').val();
        var exist = $('input#existencia').val();
        var prec = $('input#preciocompra').val();
        var prec2 = $('input#precioventa').val();
        var descuen = $('input#descproducto').val();
        var ivgprod = $('input#ivaproducto').val();
        var tipodetalle = $('input#tipodetalle').val();
        var er_num = /^([0-9])*[.]?[0-9]*$/;
        cantp = parseInt(cantp);
        exist = parseInt(exist);
        cantp = cantp;

        if (code == "") {
            $("#search_producto").focus();
            //$("#search_producto").css('border-color', '#ff7676');
            //swal("Oops", "POR FAVOR REALICE LA BÚSQUEDA DEL PRODUCTO/SERVICIO CORRECTAMENTE!", "error");
            return false;
            
        } else if(prec2=="" || prec2=="0" || prec2=="0.00"){
            $("#precioventa").focus();
            $('#precioventa').css('border-color','#ff7676');
            $("#precioventa").val("");
            swal("Oops", "POR FAVOR INGRESE PRECIO DE VENTA VALIDO PARA PRODUCTO!", "error");  
            return false;
            
        } else if(!er_num.test($('#precioventa').val())){
            $("#precioventa").focus();
            $('#precioventa').css('border-color','#ff7676');
            $("#precioventa").val("");
            swal("Oops", "POR FAVOR INGRESE SOLO NUMEROS POSITIVOS EN PRECIO VENTA!", "error");  
            return false;

        } else if ($('#cantidad').val() == "" || $('#cantidad').val() == "0") {
            $("#cantidad").focus();
            $("#cantidad").css('border-color', '#ff7676');
            $("#precioventa").val("");
            swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA EN VENTAS!", "error");
            return false;

        } else if (isNaN($('#cantidad').val())) {
            $("#cantidad").focus();
            $("#cantidad").css('border-color', '#ff7676');
            $("#cantidad").val("");
            swal("Oops", "POR FAVOR INGRESE SOLO DIGITOS EN CANTIDAD DE VENTAS!", "error");
            return false;
            
       } else if(cantp > exist){
            $("#cantidad").focus();
            $('#cantidad').css('border-color','#ff7676');
            $("#existencia").focus();
            $('#existencia').css('border-color','#ff7676');
            swal("Oops", "LA CANTIDAD DE PRODUCTOS SOLICITADA NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");
            return false;

        } else {

            var Carrito = new Object();
            Carrito.Id = $('input#idproducto').val();
            Carrito.Codigo = $('input#codproducto').val();
            Carrito.Producto = $('input#producto').val();
            Carrito.Codmarca = $('input#codmarca').val();
            Carrito.Marcas = $('input#marcas').val();
            Carrito.Codmodelo = $('input#codmodelo').val();
            Carrito.Modelos = $('input#modelos').val();
            Carrito.Codpresentacion = $('input#codpresentacion').val();
            Carrito.Presentacion = $('input#presentacion').val();
            Carrito.Precio      = $('input#preciocompra').val();
            Carrito.Precio2      = $('input#precioventa').val();
            Carrito.Descproducto      = $('input#descproducto').val();
            Carrito.Ivaproducto = $('input#ivaproducto').val();
            Carrito.Existencia = $('input#existencia').val();
            Carrito.Precioconiva = $('input#precioconiva').val();
            //Carrito.Precioconiva = ($('input#ivaproducto').val() == "SI" ? $('input#precioventa').val() : "0.00");
            Carrito.TipoDetalle = $('input#tipodetalle').val();
            Carrito.Cantidad = $('input#cantidad').val();
            Carrito.opCantidad = '+=';
            var DatosJson = JSON.stringify(Carrito);
            $.post('carritoventa.php', {
                    MiCarrito: DatosJson
                },
                function(data, textStatus) {
                    $("#carrito tbody").html("");
                    var TotalDescuento = 0;
                    var SubtotalFact = 0;
                    var BaseImpIva1 = 0;
                    var contador = 0;
                    var iva = 0;
                    var total = 0;
                    var TotalCompra = 0;

                    $.each(data, function(i, item) {
                        var cantsincero = item.cantidad;
                        cantsincero = parseInt(cantsincero);
                        if (cantsincero != 0) {
                            contador = contador + 1;

            var OperacionCompra= parseFloat(item.precio) * parseFloat(item.cantidad);
            TotalCompra = parseFloat(TotalCompra) + parseFloat(OperacionCompra);

             //CALCULO DEL VALOR TOTAL
            var ValorTotal= parseFloat(item.precio2) * parseFloat(item.cantidad);

            //CALCULO DEL TOTAL DEL DESCUENTO %
            var Descuento = ValorTotal * item.descproducto / 100;
            TotalDescuento = parseFloat(TotalDescuento) + parseFloat(Descuento);

            //OBTENEMOS DESCUENTO INDIVIDUAL POR PRODUCTOS
            var descsiniva = item.precio2 * item.descproducto / 100;
            var descconiva = item.precioconiva * item.descproducto / 100;

            //CALCULO DE BASE IMPONIBLE IVA SIN PORCENTAJE
            var Operac= parseFloat(item.precio2) - parseFloat(descsiniva);
            var Operacion= parseFloat(Operac) * parseFloat(item.cantidad);
            var Subtotal = Operacion.toFixed(2);

            //CALCULO DE BASE IMPONIBLE IVA CON PORCENTAJE
            var Operac3 = parseFloat(item.precioconiva) - parseFloat(descconiva);
            var Operacion3 = parseFloat(Operac3) * parseFloat(item.cantidad);
            var Subbaseimponiva = Operacion3.toFixed(2);

            //BASE IMPONIBLE IVA CON PORCENTAJE
            BaseImpIva1 = parseFloat(BaseImpIva1) + parseFloat(Subbaseimponiva);
            
            //CALCULO GENERAL DE IVA CON BASE IVA * IVA %
            var ivg = $('input#iva').val();
            ivg2  = ivg/100;
            TotalIvaGeneral = parseFloat(BaseImpIva1) * parseFloat(ivg2.toFixed(2));
            
            //SUBTOTAL GENERAL DE FACTURA
            SubtotalFact = parseFloat(SubtotalFact) + parseFloat(Subtotal);
            //BASE IMPONIBLE IVA SIN PORCENTAJE
            BaseImpIva2 = parseFloat(SubtotalFact) - parseFloat(BaseImpIva1);
            
            //CALCULAMOS DESCUENTO POR PRODUCTO
            var desc = $('input#descuento').val();
            desc2  = desc/100;
            
            //CALCULO DEL TOTAL DE FACTURA
            Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIvaGeneral);
            TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
            TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));


            var nuevaFila =
                "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;' align='center'>" +
                    "<td>" +
                    '<button class="btn btn-info btn-sm" style="cursor:pointer;border-radius:5px 0px 0px 5px;" onclick="addItem(' +
                    "'" + item.id + "'," +
                    "'" + item.txtCodigo + "'," +
                    "'-1'," +
                    "'" + item.producto + "'," +
                    "'" + item.codmarca + "'," +
                    "'" + item.marcas + "'," +
                    "'" + item.codmodelo + "'," +
                    "'" + item.modelos + "'," +
                    "'" + item.codpresentacion + "'," +
                    "'" + item.presentacion + "'," +
                    "'" + item.precio + "', " +
                    "'" + item.precio2 + "', " +
                    "'" + item.descproducto + "', " +
                    "'" + item.ivaproducto + "', " +
                    "'" + item.existencia + "', " +
                    "'" + item.precioconiva + "', " +
                    "'" + item.tipodetalle + "', " +
                    "'-'" +
                    ')"' +
                    " type='button'><span class='fa fa-minus'></span></button>" +
                    "<input type='text' id='" + item.cantidad + "' class='bold' style='width:25px;height:28px;' value='" + item.cantidad + "'>" +
                    '<button class="btn btn-info btn-sm" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onclick="addItem(' +
                    "'" + item.id + "'," +
                    "'" + item.txtCodigo + "'," +
                    "'+1'," +
                    "'" + item.producto + "'," +
                    "'" + item.codmarca + "'," +
                    "'" + item.marcas + "'," +
                    "'" + item.codmodelo + "'," +
                    "'" + item.modelos + "'," +
                    "'" + item.codpresentacion + "'," +
                    "'" + item.presentacion + "'," +
                    "'" + item.precio + "', " +
                    "'" + item.precio2 + "', " +
                    "'" + item.descproducto + "', " +
                    "'" + item.ivaproducto + "', " +
                    "'" + item.existencia + "', " +
                    "'" + item.precioconiva + "', " +
                    "'" + item.tipodetalle + "', " +
                    "'+'" +
                    ')"' +
                    " type='button'><span class='fa fa-plus'></span></button></td>" +
                    "<td class='text-left'><h6><strong>" + item.producto + "</strong></h6><small>MARCA (" + (item.marcas == '' || item.marcas == '0' ? '******' : item.marcas) + ") : MODELO (" + (item.modelos == '' || item.modelos == '0' ? '****' : item.modelos) + ")</small></td>" +
                    "<td><strong>" + item.precio2 + "</strong></td>" +
                    "<td><strong>" + Operacion.toFixed(2) + "</strong></td>" +
                    "<td>" +
                    '<button class="btn btn-dark btn-sm" style="cursor:pointer;border-radius:5px 5px 5px 5px;color:#fff;" ' +
                    'onclick="addItem(' +
                    "'" + item.id + "'," +
                    "'" + item.txtCodigo + "'," +
                    "'0'," +
                    "'" + item.producto + "'," +
                    "'" + item.codmarca + "'," +
                    "'" + item.marcas + "'," +
                    "'" + item.codmodelo + "'," +
                    "'" + item.modelos + "'," +
                    "'" + item.codpresentacion + "'," +
                    "'" + item.presentacion + "'," +
                    "'" + item.precio + "', " +
                    "'" + item.precio2 + "', " +
                    "'" + item.descproducto + "', " +
                    "'" + item.ivaproducto + "', " +
                    "'" + item.existencia + "', " +
                    "'" + item.precioconiva + "', " +
                    "'" + item.tipodetalle + "', " +
                    "'='" +
                    ')"' +
                    ' type="button"><span class="fa fa-trash-o"></span></button>' +
                                "</td>" +
                                "</tr>";
                    $(nuevaFila).appendTo("#carrito tbody");
                                
                    $("#lblsubtotal").text(BaseImpIva1.toFixed(2));
                    $("#lblsubtotal2").text(BaseImpIva2.toFixed(2));
                    $("#lbliva").text(TotalIvaGeneral.toFixed(2));
                    $("#lbldescontado").text(TotalDescuento.toFixed(2));
                    $("#lbldescuento").text(TotalDescuentoGeneral.toFixed(2));
                    $("#lbltotal").text(TotalFactura.toFixed(2));
                    
                    $("#txtsubtotal").val(BaseImpIva1.toFixed(2));
                    $("#txtsubtotal2").val(BaseImpIva2.toFixed(2));
                    $("#txtIva").val(TotalIvaGeneral.toFixed(2));
                    $("#txtdescontado").val(TotalDescuento.toFixed(2));
                    $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
                    $("#txtTotal").val(TotalFactura.toFixed(2));
                    $("#txtTotalCompra").val(TotalCompra.toFixed(2));

                    /*####### ACTIVAR BOTON DE PAGO #######*/
                    $("#buttonpago").attr('disabled', false);
                    $("#TextImporte").text(TotalFactura.toFixed(2));
                    $("#TextPagado").text(TotalFactura.toFixed(2));
                    $("#montopagado").val(TotalFactura.toFixed(2));

                        }
                    });

                    $("#search_producto_barra").focus();
                    //$("#search_producto").focus();
                    LimpiarTexto();
                },
                "json"
            );
            return false;
        }
    }

/* CANCELAR LOS ITEM AGREGADOS EN REGISTRO */
$("#vaciar").click(function() {
        var Carrito = new Object();
        Carrito.Id = "vaciar";
        Carrito.Codigo = "vaciar";
        Carrito.Producto = "vaciar";
        Carrito.Codmarca = "vaciar";
        Carrito.Marcas = "vaciar";
        Carrito.Codmodelo = "vaciar";
        Carrito.Modelos = "vaciar";
        Carrito.Codpresentacion = "vaciar";
        Carrito.Presentacion = "vaciar";
        Carrito.Precio      = "0";
        Carrito.Precio2      = "0";
        Carrito.Descproducto      = "0";
        Carrito.Ivaproducto = "vaciar";
        Carrito.Existencia = "vaciar";
        Carrito.Precioconiva      = "0";
        Carrito.TipoDetalle      = "vaciar";
        Carrito.Cantidad = "0";
        var DatosJson = JSON.stringify(Carrito);
        $.post('carritoventa.php', {
                MiCarrito: DatosJson
            },
            function(data, textStatus) {
                $("#carrito tbody").html("");
                var nuevaFila =
                "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=5><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
                $(nuevaFila).appendTo("#carrito tbody");
                LimpiarTexto();
            },
            "json"
        );
        return false;
    });


$(document).ready(function() {
    $('#vaciar').click(function() {
        $("#carrito tbody").html("");
        var nuevaFila =
        "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=5><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
        $(nuevaFila).appendTo("#carrito tbody");
        $("#savepos")[0].reset();
        $("#codcliente").val("0");
        $("#lblsubtotal").text("0.00");
        $("#lblsubtotal2").text("0.00");
        $("#lbliva").text("0.00");
        $("#lbldescontado").text("0.00");
        $("#lbldescuento").text("0.00");
        $("#lbltotal").text("0.00");

        $("#txtsubtotal").val("0.00");
        $("#txtsubtotal2").val("0.00");
        $("#txtIva").val("0.00");
        $("#txtdescontado").val("0.00");
        $("#txtDescuento").val("0.00");
        $("#txtTotal").val("0.00");

        /*####### ACTIVAR BOTON DE PAGO #######*/
        $("#buttonpago").attr('disabled', true);
        $("#TextImporte").text("0.00");
        $("#TextPagado").text("0.00");
        $("#TextCambio").text("0.00");
        $('#TextCliente').text("Consumidor Final");
        $('#TextCredito').text("0.00");
        $("#montopagado").val("0");
    });
});

$(document).ready(function(){
    $("#search_producto_barra").change(function(){
        let codeBar=$(this).val();
        $.ajax({    
            url: "class/busqueda_autocompleto.php?Busqueda_Producto_Barcode=si",
            data:{barcode:codeBar},      
            type : 'POST',   
            dataType : 'json',    
            success : function(json) {
                console.log(json);
                $('#idproducto').val(json[0].idproducto);
                $('#codproducto').val(json[0].codproducto);
                $('#producto').val(json[0].producto);
                $('#codmarca').val(json[0].codmarca);
                $('#marcas').val(json[0].nommarca);
                $('#codmodelo').val(json[0].codmodelo);
                $('#modelos').val((json[0].codmodelo == "0") ? "*****" : json[0].nommodelo);
                $('#codpresentacion').val(json[0].codpresentacion);
                $('#presentacion').val((json[0].codpresentacion == "0") ? "******" : json[0].nompresentacion);
                $('#preciocompra').val(json[0].preciocompra);
                $('#precioventa').val(json[0].precioxpublico);
                $('#descproducto').val(json[0].descproducto);
                $('#ivaproducto').val(json[0].ivaproducto);
                $('#existencia').val(json[0].existencia);
                $('#precioconiva').val((json[0].ivaproducto == "SI") ? json[0].precioxpublico : "0.00");
                $("#cantidad").val("1");
                $("#search_producto_barra").focus();
                //$('#precioventa').load("funciones.php?BuscaPreciosProductos=si&idproducto="+json[0].idproducto);
                AgregaVentas();
            },
            error : function(error) {
                console.log(error);
                //swal("Oops", "HA Ocurrido un Error en el procesamiento de informacion!", "error");
                alert('Disculpe, Ha Ocurrido un Error en el procesamiento de informacion');
            }
        });
    });
});


//FUNCION PARA ACTUALIZAR CALCULO EN FACTURA DE COMPRAS CON DESCUENTO
$(document).ready(function(){
      $('#descuento').keyup(function(){
    
        var txtsubtotal = $('input#txtsubtotal').val();
        var txtsubtotal2 = $('input#txtsubtotal2').val();
        var txtIva = $('input#txtIva').val();
        var desc = $('input#descuento').val();
        descuento  = desc/100;
                    
        //REALIZO EL CALCULO CON EL DESCUENTO INDICADO
        Subtotal = parseFloat(txtsubtotal) + parseFloat(txtsubtotal2) + parseFloat(txtIva); 
        TotalDescuentoGeneral   = parseFloat(Subtotal.toFixed(2)) * parseFloat(descuento.toFixed(2));
        TotalFactura   = parseFloat(Subtotal.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));        
    
        $("#lbldescuento").text(TotalDescuentoGeneral.toFixed(2));
        $("#lbltotal").text(TotalFactura.toFixed(2));
        $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
        $("#txtTotal").val(TotalFactura.toFixed(2));

        $("#TextImporte").text(TotalFactura.toFixed(2));
        $("#TextPagado").text(TotalFactura.toFixed(2));
        $("#montopagado").val(TotalFactura.toFixed(2));
     });
 });


//FUNCION PARA ACTUALIZAR CALCULO EN FACTURA DE COMPRAS CON IVA
$(document).ready(function(){
      $('#iva').keyup(function(){
    
        var txtsubtotal = $('input#txtsubtotal').val();
        var txtsubtotal2 = $('input#txtsubtotal2').val();
        var txtIva = $('input#txtIva').val();
        var iva = $('input#iva').val();
        var desc = $('input#descuento').val();
        ivg2  = iva/100;
        descuento  = desc/100;
                    
        //REALIZO EL CALCULO CON EL IVA INDICADO
        TotalIvaGeneral = parseFloat(txtsubtotal) * parseFloat(ivg2.toFixed(2));

        Subtotal = parseFloat(txtsubtotal) + parseFloat(txtsubtotal2) + parseFloat(TotalIvaGeneral); 
        TotalDescuentoGeneral   = parseFloat(Subtotal.toFixed(2)) * parseFloat(descuento.toFixed(2));
        TotalFactura   = parseFloat(Subtotal.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));        
    
        $("#lbliva").text(TotalIvaGeneral.toFixed(2));
        $("#txtIva").text(TotalIvaGeneral.toFixed(2));
        
        $("#lbldescuento").text(TotalDescuentoGeneral.toFixed(2));
        $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
        
        $("#lbltotal").text(TotalFactura.toFixed(2));
        $("#txtTotal").val(TotalFactura.toFixed(2));
     });
 });

function LimpiarTexto() {
    $("#search_producto").val("");
    $("#search_producto_barra").val("");
    $("#idproducto").val("");
    $("#codproducto").val("");
    $("#producto").val("");
    $("#codmarca").val("");
    $("#marcas").val("");
    $("#codmodelo").val("");
    $("#modelos").val("");
    $("#codpresentacion").val("");
    $("#presentacion").val("");
    $("#preciocompra").val("");
    $("#precioventa").val("");
    $("#descproducto").val("");
    $("#ivaproducto").val("");
    $("#existencia").val("");
    $("#precioconiva").val("");
    $("#cantidad").val("1");
    $("#tipodetalle").val("1");
}

$("#carrito tbody").on('keydown', 'input', function(e) {
    var element = $(this);
    var pvalue = element.val();
    var code = e.charCode || e.keyCode;
    var avalue = String.fromCharCode(code);
    var action = element.siblings('button').first().attr('onclick');
    var params;
    if (code !== 16 && /[^\d]/ig.test(avalue)) {
        e.preventDefault();
        return;
    }
    if (element.attr('data-proc') == '1') {
        return true;
    }
    element.attr('data-proc', '1');
    params = action.match(/\'([^\']+)\'/g).map(function(v) {
        return v.replace(/\'/g, '');
    });
    setTimeout(function() {
        if (element.attr('data-proc') == '1') {
            var value = element.val() || 0;
            addItem(
                params[0],
                params[1],
                value,
                params[3],
                params[4],
                params[5],
                params[6],
                params[7],
                params[8],
                params[9],
                params[10],
                params[11],
                params[12],
                params[13],
                params[14],
                params[15],
                params[16],
                '='
            );
            element.attr('data-proc', '0');
            }
        }, 300);
    });
});


function addItem(id, codigo, cantidad, producto, codmarca, marcas, codmodelo, modelos, codpresentacion, presentacion, precio, precio2, descproducto, ivaproducto, existencia, precioconiva, tipodetalle, opCantidad) {

    var Carrito = new Object();
    Carrito.Id = id;
    Carrito.Codigo = codigo;
    Carrito.Producto = producto;
    Carrito.Codmarca = codmarca;
    Carrito.Marcas = marcas;
    Carrito.Codmodelo = codmodelo;
    Carrito.Modelos = modelos;
    Carrito.Codpresentacion = codpresentacion;
    Carrito.Presentacion = presentacion;
    Carrito.Precio = precio;
    Carrito.Precio2 = precio2;
    Carrito.Descproducto = descproducto;
    Carrito.Ivaproducto = ivaproducto;
    Carrito.Existencia = existencia;
    Carrito.Precioconiva      = precioconiva;
    Carrito.TipoDetalle      = tipodetalle;
    Carrito.Cantidad = cantidad;
    Carrito.opCantidad = opCantidad;
    var DatosJson = JSON.stringify(Carrito);
    $.post('carritoventa.php', {
            MiCarrito: DatosJson
        },
        function(data, textStatus) {
            $("#carrito tbody").html("");
            var TotalDescuento = 0;
            var SubtotalFact = 0;
            var BaseImpIva1 = 0;
            var contador = 0;
            var iva = 0;
            var total = 0;
            var TotalCompra = 0;

            $.each(data, function(i, item) {
                var cantsincero = item.cantidad;
                cantsincero = parseInt(cantsincero);
                if (cantsincero != 0) {
                    contador = contador + 1;

                var OperacionCompra= parseFloat(item.precio) * parseFloat(item.cantidad);
                TotalCompra = parseFloat(TotalCompra) + parseFloat(OperacionCompra);

                 //CALCULO DEL VALOR TOTAL
                var ValorTotal= parseFloat(item.precio2) * parseFloat(item.cantidad);

                //CALCULO DEL TOTAL DEL DESCUENTO %
                var Descuento = ValorTotal * item.descproducto / 100;
                TotalDescuento = parseFloat(TotalDescuento) + parseFloat(Descuento);

                //OBTENEMOS DESCUENTO INDIVIDUAL POR PRODUCTOS
                var descsiniva = item.precio2 * item.descproducto / 100;
                var descconiva = item.precioconiva * item.descproducto / 100;

                //CALCULO DE BASE IMPONIBLE IVA SIN PORCENTAJE
                var Operac= parseFloat(item.precio2) - parseFloat(descsiniva);
                var Operacion= parseFloat(Operac) * parseFloat(item.cantidad);
                var Subtotal = Operacion.toFixed(2);

                //CALCULO DE BASE IMPONIBLE IVA CON PORCENTAJE
                var Operac3 = parseFloat(item.precioconiva) - parseFloat(descconiva);
                var Operacion3 = parseFloat(Operac3) * parseFloat(item.cantidad);
                var Subbaseimponiva = Operacion3.toFixed(2);

                //BASE IMPONIBLE IVA CON PORCENTAJE
                BaseImpIva1 = parseFloat(BaseImpIva1) + parseFloat(Subbaseimponiva);
                
                //CALCULO GENERAL DE IVA CON BASE IVA * IVA %
                var ivg = $('input#iva').val();
                ivg2  = ivg/100;
                TotalIvaGeneral = parseFloat(BaseImpIva1) * parseFloat(ivg2.toFixed(2));
                
                //SUBTOTAL GENERAL DE FACTURA
                SubtotalFact = parseFloat(SubtotalFact) + parseFloat(Subtotal);
                //BASE IMPONIBLE IVA SIN PORCENTAJE
                BaseImpIva2 = parseFloat(SubtotalFact) - parseFloat(BaseImpIva1);
                
                //CALCULAMOS DESCUENTO POR PRODUCTO
                var desc = $('input#descuento').val();
                desc2  = desc/100;
                
                //CALCULO DEL TOTAL DE FACTURA
                Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIvaGeneral);
                TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
                TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));

                   var nuevaFila =
                    "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;' align='center'>" +
                        "<td>" +
                        '<button class="btn btn-info btn-sm" style="cursor:pointer;border-radius:5px 0px 0px 5px;" onclick="addItem(' +
                        "'" + item.id + "'," +
                        "'" + item.txtCodigo + "'," +
                        "'-1'," +
                        "'" + item.producto + "'," +
                        "'" + item.codmarca + "'," +
                        "'" + item.marcas + "'," +
                        "'" + item.codmodelo + "'," +
                        "'" + item.modelos + "'," +
                        "'" + item.codpresentacion + "'," +
                        "'" + item.presentacion + "'," +
                        "'" + item.precio + "', " +
                        "'" + item.precio2 + "', " +
                        "'" + item.descproducto + "', " +
                        "'" + item.ivaproducto + "', " +
                        "'" + item.existencia + "', " +
                        "'" + item.precioconiva + "', " +
                        "'" + item.tipodetalle + "', " +
                        "'-'" +
                        ')"' +
                        " type='button'><span class='fa fa-minus'></span></button>" +
                        "<input type='text' id='" + item.cantidad + "' class='bold' style='width:25px;height:28px;' value='" + item.cantidad + "'>" +
                        '<button class="btn btn-info btn-sm" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onclick="addItem(' +
                        "'" + item.id + "'," +
                        "'" + item.txtCodigo + "'," +
                        "'+1'," +
                        "'" + item.producto + "'," +
                        "'" + item.codmarca + "'," +
                        "'" + item.marcas + "'," +
                        "'" + item.codmodelo + "'," +
                        "'" + item.modelos + "'," +
                        "'" + item.codpresentacion + "'," +
                        "'" + item.presentacion + "'," +
                        "'" + item.precio + "', " +
                        "'" + item.precio2 + "', " +
                        "'" + item.descproducto + "', " +
                        "'" + item.ivaproducto + "', " +
                        "'" + item.existencia + "', " +
                        "'" + item.precioconiva + "', " +
                        "'" + item.tipodetalle + "', " +
                        "'+'" +
                        ')"' +
                        " type='button'><span class='fa fa-plus'></span></button></td>" +
                        "<td class='text-left'><h6><strong>" + item.producto + "</strong></h6><small>MARCA (" + (item.marcas == '' || item.marcas == '0' ? '******' : item.marcas) + ") : MODELO (" + (item.modelos == '' || item.modelos == '0' ? '****' : item.modelos) + ")</small></td>" +
                        "<td><strong>" + item.precio2 + "</strong></td>" +
                        "<td><strong>" + Operacion.toFixed(2) + "</strong></td>" +
                        "<td>" +
                        '<button class="btn btn-dark btn-sm" style="cursor:pointer;border-radius:5px 5px 5px 5px;color:#fff;" ' +
                        'onclick="addItem(' +
                        "'" + item.id + "'," +
                        "'" + item.txtCodigo + "'," +
                        "'0'," +
                        "'" + item.producto + "'," +
                        "'" + item.codmarca + "'," +
                        "'" + item.marcas + "'," +
                        "'" + item.codmodelo + "'," +
                        "'" + item.modelos + "'," +
                        "'" + item.codpresentacion + "'," +
                        "'" + item.presentacion + "'," +
                        "'" + item.precio + "', " +
                        "'" + item.precio2 + "', " +
                        "'" + item.descproducto + "', " +
                        "'" + item.ivaproducto + "', " +
                        "'" + item.existencia + "', " +
                        "'" + item.precioconiva + "', " +
                        "'" + item.tipodetalle + "', " +
                        "'='" +
                        ')"' +
                        ' type="button"><span class="fa fa-trash-o"></span></button>' +
                                    "</td>" +
                                    "</tr>";
                        $(nuevaFila).appendTo("#carrito tbody");
                                    
                        $("#lblsubtotal").text(BaseImpIva1.toFixed(2));
                        $("#lblsubtotal2").text(BaseImpIva2.toFixed(2));
                        $("#lbliva").text(TotalIvaGeneral.toFixed(2));
                        $("#lbldescontado").text(TotalDescuento.toFixed(2));
                        $("#lbldescuento").text(TotalDescuentoGeneral.toFixed(2));
                        $("#lbltotal").text(TotalFactura.toFixed(2));

                        $("#txtsubtotal").val(BaseImpIva1.toFixed(2));
                        $("#txtsubtotal2").val(BaseImpIva2.toFixed(2));
                        $("#txtIva").val(TotalIvaGeneral.toFixed(2));
                        $("#txtdescontado").val(TotalDescuento.toFixed(2));
                        $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
                        $("#txtTotal").val(TotalFactura.toFixed(2));
                        $("#txtTotalCompra").val(TotalCompra.toFixed(2));

                        /*####### ACTIVAR BOTON DE PAGO #######*/
                        $("#buttonpago").attr('disabled', false);
                        $("#TextImporte").text(TotalFactura.toFixed(2));
                        $("#TextPagado").text(TotalFactura.toFixed(2));
                        $("#montopagado").val(TotalFactura.toFixed(2));
                }
            });
            if (contador == 0) {

                $("#carrito tbody").html("");

                var nuevaFila =
                "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=5><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
                $(nuevaFila).appendTo("#carrito tbody");

                //alert("ELIMINAMOS TODOS LOS SUBTOTAL Y TOTALES");
                $("#savepos")[0].reset();
                $("#lblsubtotal").text("0.00");
                $("#lblsubtotal2").text("0.00");
                $("#lbliva").text("0.00");
                $("#lbldescontado").text("0.00");
                $("#lbldescuento").text("0.00");
                $("#lbltotal").text("0.00");
                
                $("#txtsubtotal").val("0.00");
                $("#txtsubtotal2").val("0.00");
                $("#txtIva").val("0.00");
                $("#txtdescontado").val("0.00");
                $("#txtDescuento").val("0.00");
                $("#txtTotal").val("0.00");
                $("#txtTotalCompra").val("0.00");

                /*####### ACTIVAR BOTON DE PAGO #######*/
                $("#buttonpago").attr('disabled', true);
                $("#TextImporte").text("0.00");
                $("#TextPagado").text("0.00");
                $('#TextCliente').text("Consumidor Final");
                $('#TextCredito').text("0.00");
                $("#montopagado").val("0");
                $("#montopagado").text("0.00");
            }
            //LimpiarTexto();
        },
        "json"
    );
    return false;
}