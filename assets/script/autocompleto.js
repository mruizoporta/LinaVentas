// FUNCION AUTOCOMPLETE 
$(function() {
       $("#marcas").autocomplete({
       source: "class/busqueda_autocompleto.php?Busqueda_Marcas=si",
       minLength: 1,
       select: function(event, ui) { 
       $('#codmarca').val(ui.item.codmarca);
       }  
    });
 });

$(function() {
       $("#modelos").autocomplete({
       source: "class/busqueda_autocompleto.php?Busqueda_Modelos=si",
       minLength: 1,
       select: function(event, ui) { 
       $('#codmodelo').val(ui.item.codmodelo);
       $("#cantidad").focus();
       }  
    });
 });


$(function() {
         $("#busqueda").autocomplete({
         source: "class/busqueda_autocompleto.php?Busqueda_Cliente=si",
         minLength: 1,
         select: function(event, ui) { 
        $('#codcliente').val(ui.item.codcliente);
        $('#cliente').val(ui.item.codcliente);
        $('#creditoinicial').val(ui.item.limitecredito);
        $('#montocredito').val(ui.item.creditodisponible);
        $('#creditodisponible').val(ui.item.creditodisponible);
        $('#TextCliente').text(ui.item.nomcliente);
        $('#TextCredito').text(ui.item.creditodisponible);
         }  
    });
});


$(function() {
  $("#search_kardex_producto").autocomplete({
    source: "class/busqueda_autocompleto.php?Busqueda_Kardex_Producto=si",
    minLength: 1,
    select: function(event, ui) {
      $('#codproducto').val(ui.item.codproducto);
    }
  });
});

$(function() {
    $("#busquedaproductoc").autocomplete({
        source: "class/busqueda_autocompleto.php?Busqueda_Producto_Compra=si",
        minLength: 1,
        select: function(event, ui) {
            $('#codproducto').val(ui.item.codproducto);
            $('#producto').val(ui.item.producto);
            $('#fabricante').val(ui.item.fabricante);
            $('#codfamilia').val(ui.item.codfamilia);
            $('#codsubfamilia').val(ui.item.codsubfamilia);
            $('#codmarca').val(ui.item.codmarca);
            $('#marcas').val(ui.item.nommarca);
            $('#codmodelo').val(ui.item.codmodelo);
            $('#modelos').val((ui.item.nommodelo == "") ? "*****" : ui.item.nommodelo);
            $('#codpresentacion').val(ui.item.codpresentacion);
            $('#codorigen').val(ui.item.codorigen);
            $('#preciocompra').val(ui.item.preciocompra);
            $('#precioxmenor').val(ui.item.precioxmenor);
            $('#precioxmayor').val(ui.item.precioxmayor);
            $('#precioxpublico').val(ui.item.precioxpublico);
            $('#precioconiva').val((ui.item.ivaproducto == "SI") ? ui.item.preciocompra : "0.00");
            $('#existencia').val(ui.item.existencia);
            $('#ivaproducto').val(ui.item.ivaproducto);
            $('#descproducto').val(ui.item.descproducto);
            $("#cantidad").focus();
        }
    });
});

$(function() {
  $("#search_traspaso").autocomplete({
    source: "class/busqueda_autocompleto.php?Busqueda_Producto_Venta=si",
    minLength: 1,
    select: function(event, ui) {
      $('#idproducto').val(ui.item.idproducto);
      $('#codproducto').val(ui.item.codproducto);
      $('#producto').val(ui.item.producto);
      $('#fabricante').val(ui.item.fabricante);
      $('#codfamilia').val(ui.item.codfamilia);
      $('#codsubfamilia').val(ui.item.codsubfamilia);
      $('#codmarca').val(ui.item.codmarca);
      $('#marcas').val(ui.item.nommarca);
      $('#codmodelo').val(ui.item.codmodelo);
      $('#modelos').val((ui.item.nommodelo == "") ? "*****" : ui.item.nommodelo);
      $('#codpresentacion').val(ui.item.codpresentacion);
      $('#presentacion').val(ui.item.presentacion);
      $('#codorigen').val(ui.item.codorigen);
      $('#preciocompra').val(ui.item.preciocompra);
      $('#precioxmenor').val(ui.item.precioxmenor);
      $('#precioxmayor').val(ui.item.precioxmayor);
      $('#precioxpublico').val(ui.item.precioxpublico);
      $('#precioventa').val(ui.item.precioxpublico);
      $('#existencia').val(ui.item.existencia);
      $('#ivaproducto').val(ui.item.ivaproducto);
      $('#descproducto').val(ui.item.descproducto);
      $('#fechaexpiracion').val(ui.item.fechaexpiracion);
      $("#cantidad").focus();
      $('#precioventa').load("funciones.php?BuscaPreciosProductos=si&idproducto="+ui.item.idproducto);
    }
  });
});


$(function() {
    $("#busquedaproductov").autocomplete({
        source: "class/busqueda_autocompleto.php?Busqueda_Producto_Venta=si",
        minLength: 1,
        select: function(event, ui) {
            $('#idproducto').val(ui.item.idproducto);
            $('#codproducto').val(ui.item.codproducto);
            $('#producto').val(ui.item.producto);
            $('#fabricante').val(ui.item.fabricante);
            $('#codfamilia').val(ui.item.codfamilia);
            $('#codsubfamilia').val(ui.item.codsubfamilia);
            $('#codmarca').val(ui.item.codmarca);
            $('#marcas').val((ui.item.codmarca == "0") ? "*****" : ui.item.nommarca);
            $('#codmodelo').val(ui.item.codmodelo);
            $('#modelos').val((ui.item.codmodelo == "0") ? "*****" : ui.item.nommodelo);
            $('#codpresentacion').val(ui.item.codpresentacion);
            $('#presentacion').val((ui.item.codpresentacion == "0") ? "*****" : ui.item.nompresentacion);
            $('#codorigen').val(ui.item.codorigen);
            $('#preciocompra').val(ui.item.preciocompra);
            $('#precioxmenor').val(ui.item.precioxmenor);
            $('#precioxmayor').val(ui.item.precioxmayor);
            $('#precioxpublico').val(ui.item.precioxpublico);
            $('#precioventa').val(ui.item.precioxpublico);
            $('#existencia').val(ui.item.existencia);
            $('#ivaproducto').val(ui.item.ivaproducto);
            $('#descproducto').val(ui.item.descproducto);
            $('#fechaexpiracion').val(ui.item.fechaexpiracion);
            $("#cantidad").focus();
            $('#precioventa').load("funciones.php?BuscaPreciosProductos=si&idproducto="+ui.item.idproducto);
        }
    });
});

$(function() {
    $("#search_producto").autocomplete({
        source: "class/busqueda_autocompleto.php?Busqueda_Producto_Venta=si",
        minLength: 1,
        select: function(event, ui) {
            $('#idproducto').val(ui.item.idproducto);
            $('#codproducto').val(ui.item.codproducto);
            $('#producto').val(ui.item.producto);
            $('#codfamilia').val(ui.item.codfamilia);
            $('#codsubfamilia').val(ui.item.codsubfamilia);
            $('#codmarca').val(ui.item.codmarca);
            $('#marcas').val((ui.item.codmarca == "0") ? "*****" : ui.item.nommarca);
            $('#codmodelo').val(ui.item.codmodelo);
            $('#modelos').val((ui.item.codmodelo == "0") ? "*****" : ui.item.nommodelo);
            $('#codpresentacion').val(ui.item.codpresentacion);
            $('#presentacion').val((ui.item.codpresentacion == "0") ? "*****" : ui.item.nompresentacion);
            $('#preciocompra').val(ui.item.preciocompra);
            $('#precioventa').val(ui.item.precioxpublico);
            $('#precioconiva').val((ui.item.ivaproducto == "SI") ? ui.item.precioxpublico : "0.00");
            $('#ivaproducto').val(ui.item.ivaproducto);
            $('#descproducto').val(ui.item.descproducto);
            $('#existencia').val(ui.item.existencia);
            //$("#cantidad").focus();
            //$('#precioventa').load("funciones.php?BuscaPreciosProductos=si&idproducto="+ui.item.idproducto);
            $("#search_producto_barra").focus();
            setTimeout(function() {
                var e = jQuery.Event("keypress");
                e.which = 13;
                e.keyCode = 13;
                $("#search_producto").trigger(e);
            }, 100);
        }
    });
});


// FUNCION AUTOCOMPLETE SEGUN TIPO BUSQUEDA
$(function() {

    $("#search_busqueda").keyup(function() {

        var tipo = $('input:radio[name=tipodetalle]:checked').val(); 

        if (tipo == 1) {

            $("#search_busqueda").autocomplete({
            source: "class/busqueda_autocompleto.php?Busqueda_Producto_Venta=si",
            minLength: 1,
            select: function(event, ui) {
                $('#idproducto').val(ui.item.idproducto);
                $('#codproducto').val(ui.item.codproducto);
                $('#producto').val(ui.item.producto);
                $('#codmarca').val(ui.item.codmarca);
                $('#marcas').val(ui.item.nommarca);
                $('#codmodelo').val(ui.item.codmodelo);
                $('#modelos').val((ui.item.nommodelo == "") ? "*****" : ui.item.nommodelo);
                $('#codpresentacion').val(ui.item.codpresentacion);
                $('#presentacion').val(ui.item.presentacion);
                $('#preciocompra').val(ui.item.preciocompra);
                $('#precioventa').val(ui.item.precioventa);
                $('#precioconiva').val((ui.item.ivaproducto == "SI") ? ui.item.precioventa : "0.00");
                $('#ivaproducto').val(ui.item.ivaproducto);
                $('#descproducto').val(ui.item.descproducto);
                $('#existencia').val(ui.item.existencia);
                $("#cantidad").focus();
                $('#precioventa').load("funciones.php?BuscaPreciosProductos=si&idproducto="+ui.item.idproducto);
                }
            });

            return false;

        } else if (tipo == 2) {

            $("#search_busqueda").autocomplete({
            source: "",
            minLength: 1,
            select: function(event, ui) {
               
                }
            });

        } else {

            $("#search_busqueda").val("");
            swal("Oops", "POR FAVOR SELECCIONE EL TIPO DE BUSQUEDA!", "error");
            return false;
        }
    });
}); 


$(function() {
    $("#numfactura").autocomplete({
    source: "class/busqueda_autocompleto.php?Busqueda_Facturas=si",
    minLength: 1,
    select: function(event, ui) { 
    $('#idventa').val(ui.item.idventa);
    $('#codventa').val(ui.item.codventa);
    $('#codfactura').val(ui.item.codfactura);
    }  
  });
});