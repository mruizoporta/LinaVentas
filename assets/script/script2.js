//SELECCIONAR/DESELECCIONAR TODOS LOS CHECKBOX
$("#checkTodos").change(function () {
      $("input:checkbox").prop('checked', $(this).prop("checked"));
      //$("input[type='checkbox']:checked:enabled").prop('checked', $(this).prop("checked"));
  });

// FUNCION PARA LIMPIAR CHECKBOX ACTIVOS
function LimpiarCheckbox(){
$("input[type='checkbox']:checked:enabled").attr('checked',false); 
}

//BUSQUEDA EN CONSULTAS
$(document).ready(function () {
   (function($) {
       $('#FiltrarContenido').keyup(function () {
            var ValorBusqueda = new RegExp($(this).val(), 'i');
            $('.BusquedaRapida tr').hide();
             $('.BusquedaRapida tr').filter(function () {
                return ValorBusqueda.test($(this).text());
              }).show();
                })
      }(jQuery));
});

//FUNCION REFRESCA PRECIO VENTA
function Refrescar() {
    $("#search_producto_barra").attr('disabled', false);
    $("#muestra_input").html('<i class="fa fa-bars form-control-feedback"></i><select name="precioventa" id="precioventa" class="form-control"><option value=""> -- SIN RESULTADOS -- </option></select>');
}













/////////////////////////////////// FUNCIONES DE USUARIOS //////////////////////////////////////

// FUNCION PARA MOSTRAR USUARIOS EN VENTANA MODAL
function VerUsuario(codigo){

$('#muestrausuariomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaUsuarioModal=si&codigo='+codigo;

$.ajax({
            type: "GET",
                  url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestrausuariomodal').empty();
                $('#muestrausuariomodal').append(''+response+'').fadeIn("slow");
                
            }
      });
}

// FUNCION PARA ACTUALIZAR USUARIOS
function UpdateUsuario(codigo,dni,nombres,sexo,direccion,telefono,email,usuario,nivel,status,comision,codsucursal,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#saveuser #codigo").val(codigo);
  $("#saveuser #dni").val(dni);
  $("#saveuser #nombres").val(nombres);
  $("#saveuser #sexo").val(sexo);
  $("#saveuser #direccion").val(direccion);
  $("#saveuser #telefono").val(telefono);
  $("#saveuser #email").val(email);
  $("#saveuser #usuario").val(usuario);
  $("#saveuser #nivel").val(nivel);
  $("#saveuser #status").val(status);
  $("#saveuser #comision").val(comision);
  $("#saveuser #codsucursal").val(codsucursal);
  $("#saveuser #proceso").val(proceso);
}


/////FUNCION PARA ELIMINAR USUARIOS 
function EliminarUsuario(codigo,dni,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Usuario?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codigo="+codigo+"&dni="+dni+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $("#usuarios").load("consultas.php?CargaUsuarios=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Usuario no puede ser Eliminado, tiene registros relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Usuarios, no eres el Administrador del Sistema!", "error"); 

                }

            }
        })
    });
}

// FUNCION PARA MOSTRAR USUARIOS POR SUCURSAL
function CargaUsuarios(codsucursal){

$('#codigo').html('<center><i class="fa fa-spin fa-spinner"></i></center>');
                
var dataString = 'BuscaUsuariosxSucursal=si&codsucursal='+codsucursal;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#codigo').empty();
                $('#codigo').append(''+response+'').fadeIn("slow");
                
           }
      });
}

////FUNCION PARA MOSTRAR USUARIO POR CODIGO
function SelectUsuario(codigo,codsucursal){

  $("#codigo").load("funciones.php?MuestraUsuario=si&codigo="+codigo+"&codsucursal="+codsucursal);

}

//FUNCIONES PARA ACTIVAR-DESACTIVAR NIVEL DE USUARIO
function NivelUsuario(nivel){

  $("#nivel").on("change", function() {

      var valor = $("#nivel").val();

      if (valor == "ADMINISTRADOR(A) SUCURSAL" || valor == "SECRETARIA" || valor == "CAJERO(A)" || valor === true) {
       
        $("#codsucursal").attr('disabled', false);

      } else {

        // deshabilitamos
        $("#codsucursal").attr('disabled', true);
      }
  });
}


// FUNCION PARA BUSCAR LOGS DE ACCESO
$(document).ready(function(){
//function BuscarPacientes() {  
    var consulta;
    //hacemos focus al campo de búsqueda
    $("#blogs").focus();
    //comprobamos si se pulsa una tecla
    $("#blogs").keyup(function(e){
      //obtenemos el texto introducido en el campo de búsqueda
      consulta = $("#blogs").val();

      if (consulta.trim() === '') {  

      $("#logs").html("<center><div class='alert alert-danger'><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BUSQUEDA CORRECTAMENTE</div></center>");
      return false;

      } else {
                                                                           
        //hace la búsqueda
        $.ajax({
          type: "POST",
          url: "search.php?CargaLogs=si",
          data: "b="+consulta,
          dataType: "html",
          beforeSend: function(){
              //imagen de carga
              $("#logs").html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>');
          },
          error: function(){
              swal("Oops", "Ha ocurrido un error en la petición Ajax, verifique por favor!", "error"); 
          },
          success: function(data){                                                    
            $("#logs").empty();
            $("#logs").append(data);
          }
      });
     }
   });                                                               
});











/////////////////////////////////// FUNCIONES DE PROVINCIAS //////////////////////////////////////

// FUNCION PARA ACTUALIZAR PROVINCIAS
function UpdateProvincia(id_provincia,provincia,proceso) 
{
  // aqui asigno cada valor a los campos correspondientes
  $("#saveprovincias #id_provincia").val(id_provincia);
  $("#saveprovincias #provincia").val(provincia);
  $("#saveprovincias #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR PROVINCIAS 
function EliminarProvincia(id_provincia,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Provincia?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "id_provincia="+id_provincia+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#provincias').load("consultas?CargaProvincias=si");
                  
          } else if(data==2){ 

             swal("Oops", "Esta Provincia no puede ser Eliminada, tiene Departamentos relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Provincias, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}











/////////////////////////////////// FUNCIONES DE DEPARTAMENTOS //////////////////////////////////////

// FUNCION PARA ACTUALIZAR DEPARTAMENTOS
function UpdateDepartamento(id_departamento,departamento,id_provincia,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savedepartamentos #id_departamento").val(id_departamento);
  $("#savedepartamentos #departamento").val(departamento);
  $("#savedepartamentos #id_provincia").val(id_provincia);
  $("#savedepartamentos #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR DEPARTAMENTOS 
function EliminarDepartamento(id_departamento,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Departamento de Provincia?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "id_departamento="+id_departamento+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#departamentos').load("consultas?CargaDepartamentos=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Departamento no puede ser Eliminado, tiene registros relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Departamento, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}

////FUNCION PARA MOSTRAR PROVINCIAS POR DEPARTAMENTOS
function CargaDepartamentos(id_provincia){

$('#id_departamento').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaDepartamentos=si&id_provincia='+id_provincia;

$.ajax({
            type: "GET",
                  url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#id_departamento').empty();
                $('#id_departamento').append(''+response+'').fadeIn("slow");
           }
      });
}




////FUNCION PARA MOSTRAR PROVINCIAS POR DEPARTAMENTOS #2
function CargaDepartamentos2(id_provincia2){

$('#id_departamento2').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaDepartamentos2=si&id_provincia2='+id_provincia2;

$.ajax({
            type: "GET",
                  url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#id_departamento2').empty();
                $('#id_departamento2').append(''+response+'').fadeIn("slow");
           }
      });
}

////FUNCION PARA MOSTRAR LOCALIDAD POR CIUDAD
function SelectDepartamento(id_provincia,id_departamento){

  $("#id_departamento").load("funciones.php?SeleccionaDepartamento=si&id_provincia="+id_provincia+"&id_departamento="+id_departamento);

}











/////////////////////////////////// FUNCIONES DE TIPOS DE DOCUMENTOS  //////////////////////////////////////

// FUNCION PARA ACTUALIZAR TIPOS DE DOCUMENTOS
function UpdateDocumento(coddocumento,documento,descripcion,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savedocumentos #coddocumento").val(coddocumento);
  $("#savedocumentos #documento").val(documento);
  $("#savedocumentos #descripcion").val(descripcion);
  $("#savedocumentos #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR TIPOS DE DOCUMENTOS 
function EliminarDocumento(coddocumento,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Tipo de Documento?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddocumento="+coddocumento+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#documentos').load("consultas?CargaDocumentos=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Documento no puede ser Eliminado, tiene registros relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Documentos, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}











/////////////////////////////////// FUNCIONES DE TIPOS DE MONEDA //////////////////////////////////////

// FUNCION PARA ACTUALIZAR TIPOS DE MONEDA
function UpdateTipoMoneda(codmoneda,moneda,siglas,simbolo,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savemonedas #codmoneda").val(codmoneda);
  $("#savemonedas #moneda").val(moneda);
  $("#savemonedas #siglas").val(siglas);
  $("#savemonedas #simbolo").val(simbolo);
  $("#savemonedas #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR TIPOS DE MONEDA 
function EliminarTipoMoneda(codmoneda,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Tipo de Moneda?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codmoneda="+codmoneda+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#monedas').load("consultas?CargaMonedas=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Tipo de Moneda no puede ser Eliminado, tiene Tipos de Cambio relacionadas!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Tipos de Moneda, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}











/////////////////////////////////// FUNCIONES DE TIPOS DE CAMBIO  //////////////////////////////////////

// FUNCION PARA ACTUALIZAR TIPOS DE CAMBIO
function UpdateTipoCambio(codcambio,descripcioncambio,montocambio,codmoneda,fechacambio,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savecambios #codcambio").val(codcambio);
  $("#savecambios #descripcioncambio").val(descripcioncambio);
  $("#savecambios #montocambio").val(montocambio);
  $("#savecambios #codmoneda").val(codmoneda);
  $("#savecambios #fechacambio").val(fechacambio);
  $("#savecambios #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR TIPOS DE CAMBIO 
function EliminarTipoCambio(codcambio,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Tipo de Cambio?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codcambio="+codcambio+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#cambios').load("consultas?CargaCambios=si");
                  
           } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Tipos de Cambio, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}











/////////////////////////////////// FUNCIONES DE MEDIOS DE PAGOS //////////////////////////////////////

// FUNCION PARA ACTUALIZAR MEDIOS DE PAGOS
function UpdateMedio(codmediopago,mediopago,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savemedios #codmediopago").val(codmediopago);
  $("#savemedios #mediopago").val(mediopago);
  $("#savemedios #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR MEDIOS DE PAGOS 
function EliminarMedio(codmediopago,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Medio de Pago?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codmediopago="+codmediopago+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#mediospagos').load("consultas?CargaMediosPagos=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Medio de Pago no puede ser Eliminado, tiene Ventas relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Medios de Pagos, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}












/////////////////////////////////// FUNCIONES DE IMPUESTOS //////////////////////////////////////

// FUNCION PARA ACTUALIZAR IMPUESTOS
function UpdateImpuesto(codimpuesto,nomimpuesto,valorimpuesto,statusimpuesto,fechaimpuesto,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#saveimpuestos #codimpuesto").val(codimpuesto);
  $("#saveimpuestos #nomimpuesto").val(nomimpuesto);
  $("#saveimpuestos #valorimpuesto").val(valorimpuesto);
  $("#saveimpuestos #statusimpuesto").val(statusimpuesto);
  $("#saveimpuestos #fechaimpuesto").val(fechaimpuesto);
  $("#saveimpuestos #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR IMPUESTOS
function EliminarImpuesto(codimpuesto,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Impuesto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codimpuesto="+codimpuesto+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#impuestos').load("consultas?CargaImpuestos=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Impuesto no puede ser Eliminado, se encuentra activo para Ventas!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Impuestos, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}











/////////////////////////////////// FUNCIONES DE SUCURSALES //////////////////////////////////////

// FUNCION PARA MOSTRAR SUCURSALES EN VENTANA MODAL
function VerSucursal(codsucursal){

$('#muestrasucursalmodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaSucursalModal=si&codsucursal='+codsucursal;

$.ajax({
            type: "GET",
                  url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestrasucursalmodal').empty();
                $('#muestrasucursalmodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA ACTUALIZAR SUCURSALES
function UpdateSucursal(codsucursal,documsucursal,cuitsucursal,nomsucursal,
id_provincia,direcsucursal,correosucursal,tlfsucursal,inicioticket,iniciofactura,inicioguia,inicionotaventa,inicionotacredito,nroactividadsucursal,fechaautorsucursal,
llevacontabilidad,documencargado,dniencargado,nomencargado,tlfencargado,descsucursal,porcentaje,codmoneda,codmoneda2,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savesucursal #codsucursal").val(codsucursal);
  $("#savesucursal #documsucursal").val(documsucursal);
  $("#savesucursal #cuitsucursal").val(cuitsucursal);
  $("#savesucursal #nomsucursal").val(nomsucursal);
  $("#savesucursal #id_provincia").val(id_provincia);
  $("#savesucursal #direcsucursal").val(direcsucursal);
  $("#savesucursal #correosucursal").val(correosucursal);
  $("#savesucursal #tlfsucursal").val(tlfsucursal);
  $("#savesucursal #inicioticket").val(inicioticket);
  $("#savesucursal #iniciofactura").val(iniciofactura);
  $("#savesucursal #inicioguia").val(inicioguia);
  $("#savesucursal #inicionotaventa").val(inicionotaventa);
  $("#savesucursal #inicionotacredito").val(inicionotacredito);
  $("#savesucursal #nroactividadsucursal").val(nroactividadsucursal);
  $("#savesucursal #fechaautorsucursal").val(fechaautorsucursal);
  $("#savesucursal #llevacontabilidad").val(llevacontabilidad);
  $("#savesucursal #documencargado").val(documencargado);
  $("#savesucursal #dniencargado").val(dniencargado);
  $("#savesucursal #nomencargado").val(nomencargado);
  $("#savesucursal #tlfencargado").val(tlfencargado);
  $("#savesucursal #descsucursal").val(descsucursal);
  $("#savesucursal #porcentaje").val(porcentaje);
  $("#savesucursal #codmoneda").val(codmoneda);
  $("#savesucursal #codmoneda2").val(codmoneda2);
  $("#savesucursal #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR SUCURSALES 
function EliminarSucursal(codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Sucursal?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

         if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#sucursales').load("consultas?CargaSucursales=si");
                  
          } else if(data==2){ 

             swal("Oops", "Esta Sucursal no puede ser Eliminada, tiene registros relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Sucursales, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}











/////////////////////////////////// FUNCIONES DE FAMILIAS //////////////////////////////////////

// FUNCION PARA ACTUALIZAR FAMILIAS
function UpdateFamilia(codfamilia,nomfamilia,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savefamilias #codfamilia").val(codfamilia);
  $("#savefamilias #nomfamilia").val(nomfamilia);
  $("#savefamilias #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR FAMILIAS 
function EliminarFamilia(codfamilia,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Familia de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codfamilia="+codfamilia+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#familias').load("consultas?CargaFamilias=si");
                  
          } else if(data==2){ 

             swal("Oops", "Esta Familia no puede ser Eliminada, tiene Subfamilias relacionadas!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Familias, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}











/////////////////////////////////// FUNCIONES DE SUBFAMILIAS //////////////////////////////////////

// FUNCION PARA ACTUALIZAR SUBFAMILIAS
function UpdateSubfamilia(codsubfamilia,nomsubfamilia,codfamilia,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savesubfamilias #codsubfamilia").val(codsubfamilia);
  $("#savesubfamilias #nomsubfamilia").val(nomsubfamilia);
  $("#savesubfamilias #codfamilia").val(codfamilia);
  $("#savesubfamilias #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR SUBFAMILIAS 
function EliminarSubfamilia(codsubfamilia,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Subfamilia de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codsubfamilia="+codsubfamilia+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#subfamilias').load("consultas?CargaSubfamilias=si");
                  
          } else if(data==2){ 

             swal("Oops", "Esta Subfamilia no puede ser Eliminada, tiene Productos relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Subfamilias, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}

// FUNCION PARA MOSTRAR SUBFAMILIAS POR FAMILIAS
function CargaSubfamilias(codfamilia){

$('#codsubfamilia').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaSubfamilias=si&codfamilia='+codfamilia;

$.ajax({
            type: "GET",
                  url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#codsubfamilia').empty();
                $('#codsubfamilia').append(''+response+'').fadeIn("slow");
           }
      });
}











/////////////////////////////////// FUNCIONES DE MARCAS //////////////////////////////////////

// FUNCION PARA ACTUALIZAR MARCAS
function UpdateMarca(codmarca,nommarca,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savemarcas #codmarca").val(codmarca);
  $("#savemarcas #nommarca").val(nommarca);
  $("#savemarcas #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR MARCAS 
function EliminarMarca(codmarca,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Marca de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codmarca="+codmarca+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#marcas').load("consultas?CargaMarcas=si");
                  
          } else if(data==2){ 

             swal("Oops", "Esta Marca no puede ser Eliminada, tiene Modelos relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Marcas, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}











/////////////////////////////////// FUNCIONES DE MODELOS //////////////////////////////////////

// FUNCION PARA ACTUALIZAR MODELOS
function UpdateModelo(codmodelo,nommodelo,codmarca,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savemodelos #codmodelo").val(codmodelo);
  $("#savemodelos #nommodelo").val(nommodelo);
  $("#savemodelos #codmarca").val(codmarca);
  $("#savemodelos #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR MODELOS 
function EliminarModelo(codmodelo,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Modelo de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codmodelo="+codmodelo+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#modelos').load("consultas?CargaModelos=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Modelo no puede ser Eliminado, tiene Productos relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Modelos, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}

// FUNCION PARA MOSTRAR MODELOS POR MARCAS---  $(document).off('focusin.bs.modal');
function CargaModelos(codmarca){

$('#codmodelo').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaModelos=si&codmarca='+codmarca;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#codmodelo').empty();
                $('#codmodelo').append(''+response+'').fadeIn("slow");
           }
      });
}











/////////////////////////////////// FUNCIONES DE PRESENTACIONES //////////////////////////////////////

// FUNCION PARA ACTUALIZAR PRESENTACIONES
function UpdatePresentacion(codpresentacion,nompresentacion,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savepresentaciones #codpresentacion").val(codpresentacion);
  $("#savepresentaciones #nompresentacion").val(nompresentacion);
  $("#savepresentaciones #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR PRESENTACIONES 
function EliminarPresentacion(codpresentacion,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Presentaci&oacute;n de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codpresentacion="+codpresentacion+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#presentaciones').load("consultas?CargaPresentaciones=si");
                  
          } else if(data==2){ 

             swal("Oops", "Esta Presentaci&oacute;n no puede ser Eliminada, tiene Productos relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Presentaciones, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}











/////////////////////////////////// FUNCIONES DE COLORES //////////////////////////////////////

// FUNCION PARA ACTUALIZAR COLORES
function UpdateColor(codcolor,nomcolor,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savecolores #codcolor").val(codcolor);
  $("#savecolores #nomcolor").val(nomcolor);
  $("#savecolores #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR COLORES 
function EliminarColor(codcolor,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Color de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codcolor="+codcolor+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#colores').load("consultas?CargaColores=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Color no puede ser Eliminado, tiene Productos relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Colores, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}











/////////////////////////////////// FUNCIONES DE ORIGENES //////////////////////////////////////

// FUNCION PARA ACTUALIZAR ORIGENES
function UpdateOrigen(codorigen,nomorigen,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#saveorigenes #codorigen").val(codorigen);
  $("#saveorigenes #nomorigen").val(nomorigen);
  $("#saveorigenes #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR ORIGENES 
function EliminarOrigen(codorigen,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Origen de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codorigen="+codorigen+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#origenes').load("consultas?CargaOrigenes=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Origen no puede ser Eliminado, tiene Productos relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Origenes, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}











/////////////////////////////////// FUNCIONES DE CLIENTES //////////////////////////////////////

// FUNCION PARA BUSCAR CLIENTES
function BuscarClientes(){
                        
$('#muestraclientes').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var search = $("#bclientes").val();
var dataString = $("#busquedaclientes").serialize();
var url = 'search.php?CargaClientes=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
      success: function(response) {            
        $('#muestraclientes').empty();
        $('#muestraclientes').append(''+response+'').fadeIn("slow");
      }
  });
}

// FUNCION PARA MOSTRAR DIV DE CARGA MASIVA DE CLIENTES
function CargaDivClientes(){

$('#divcliente').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');
                
var dataString = 'BuscaDivCliente=si';

$.ajax({
          type: "GET",
          url: "funciones.php",
          data: dataString,
          success: function(response) {            
              $('#divcliente').empty();
              $('#divcliente').append(''+response+'').fadeIn("slow");
         }
    });
}

// FUNCION PARA LIMPIAR DIV DE CARGA MASIVA DE CLIENTES
function ModalCliente(){
  $("#divcliente").html("");
}

// FUNCION PARA MOSTRAR CLIENTES EN VENTANA MODAL
function VerCliente(codcliente){

$('#muestraclientemodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaClienteModal=si&codcliente='+codcliente;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraclientemodal').empty();
                $('#muestraclientemodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA MOSTRAR DATOS DE CHEQUE O TARJETA DE CREDITO PAGO #1
function CargaTipoCliente(tipocliente){

    if (tipocliente === "NATURAL" || tipocliente === true) {
    
    $('#nomcliente').attr('disabled', false);
    $("#razoncliente").attr('disabled', true);
    $('#girocliente').attr('disabled', true);

    } else {

    // deshabilitamos
    $('#nomcliente').attr('disabled', true);
    $("#razoncliente").attr('disabled', false);
    $('#girocliente').attr('disabled', false);

  }
}

// FUNCION PARA ACTUALIZAR CLIENTES
function UpdateCliente(codcliente,tipocliente,documcliente,dnicliente,nomcliente,razoncliente,girocliente,tlfcliente,id_provincia,
  direccliente,emailcliente,limitecredito,criterio,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#saveclientes #codcliente").val(codcliente);
  $("#saveclientes #tipocliente").val(tipocliente);
  $("#saveclientes #documcliente").val(documcliente);
  $("#saveclientes #dnicliente").val(dnicliente);
  $("#saveclientes #nomcliente").val(nomcliente);
  $("#saveclientes #razoncliente").val(razoncliente);
  $("#saveclientes #girocliente").val(girocliente);
  $("#saveclientes #tlfcliente").val(tlfcliente);
  $("#saveclientes #id_provincia").val(id_provincia);
  $("#saveclientes #direccliente").val(direccliente);
  $("#saveclientes #emailcliente").val(emailcliente);
  $("#saveclientes #limitecredito").val(limitecredito);
  $("#saveclientes #criterio").val(criterio);
  $("#saveclientes #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR CLIENTES 
function EliminarCliente(codcliente,criterio,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Cliente?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codcliente="+codcliente+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#muestraclientes').load("search.php?CargaClientes=si&bclientes="+criterio);
                  
          } else if(data==2){ 

             swal("Oops", "Este Cliente no puede ser Eliminado, tiene Ventas relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Clientes, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}













/////////////////////////////////// FUNCIONES DE PROVEEDORES //////////////////////////////////////

// FUNCION PARA MOSTRAR DIV DE CARGA MASIVA DE PROVEEDORES
function CargaDivProveedores(){

$('#divproveedor').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');
                
var dataString = 'BuscaDivProveedor=si';

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#divproveedor').empty();
                $('#divproveedor').append(''+response+'').fadeIn("slow");
           }
      });
}


// FUNCION PARA LIMPIAR DIV DE CARGA MASIVA DE PROVEEDORES
function ModalProveedor(){
  $("#divproveedor").html("");
}

// FUNCION PARA MOSTRAR PROVEEDORES EN VENTANA MODAL
function VerProveedor(codproveedor){

$('#muestraproveedormodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaProveedorModal=si&codproveedor='+codproveedor;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraproveedormodal').empty();
                $('#muestraproveedormodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA ACTUALIZAR PROVEEDORES
function UpdateProveedor(codproveedor,documproveedor,cuitproveedor,nomproveedor,tlfproveedor,id_provincia,
  direcproveedor,emailproveedor,vendedor,tlfvendedor,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#saveproveedores #codproveedor").val(codproveedor);
  $("#saveproveedores #documproveedor").val(documproveedor);
  $("#saveproveedores #cuitproveedor").val(cuitproveedor);
  $("#saveproveedores #nomproveedor").val(nomproveedor);
  $("#saveproveedores #tlfproveedor").val(tlfproveedor);
  $("#saveproveedores #id_provincia").val(id_provincia);
  $("#saveproveedores #direcproveedor").val(direcproveedor);
  $("#saveproveedores #emailproveedor").val(emailproveedor);
  $("#saveproveedores #vendedor").val(vendedor);
  $("#saveproveedores #tlfvendedor").val(tlfvendedor);
  $("#saveproveedores #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR PROVEEDORES 
function EliminarProveedor(codproveedor,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Proveedor?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codproveedor="+codproveedor+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#proveedores').load("consultas.php?CargaProveedores=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Proveedor no puede ser Eliminado, tiene Productos relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Proveedores, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}











/////////////////////////////////// FUNCIONES DE PEDIDOS //////////////////////////////////////

// FUNCION PARA MOSTRAR PEDIDOS EN VENTANA MODAL
function VerPedido(codpedido,codsucursal){

$('#muestrapedidomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaPedidoModal=si&codpedido='+codpedido+"&codsucursal="+codsucursal;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestrapedidomodal').empty();
                $('#muestrapedidomodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA ACTUALIZAR PEDIDOS
function UpdatePedido(codpedido,codsucursal,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar este Pedido al Proveedor?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forpedido?codpedido="+codpedido+"&codsucursal="+codsucursal+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

// FUNCION PARA AGREGAR DETALLES A PEDIDOS
function AgregaDetallePedido(codpedido,codsucursal,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Agregar Detalles de Productos a este Pedido al Proveedor?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Continuar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forpedido?codpedido="+codpedido+"&codsucursal="+codsucursal+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}


/////FUNCION PARA ELIMINAR DETALLES DE PEDIDOS EN VENTANA MODAL
function EliminarDetallesPedidosModal(coddetallepedido,codpedido,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle del Pedido?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallepedido="+coddetallepedido+"&codpedido="+codpedido+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#muestrapedidomodal').load("funciones.php?BuscaPedidoModal=si&codpedido="+codpedido+"&codsucursal="+codsucursal); 
            $('#pedidos').load("consultas.php?CargaPedidos=si");    
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Pedidos en este Módulo, realice la Eliminación completa del Pedido!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Pedidos, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}


/////FUNCION PARA ELIMINAR DETALLES DE PEDIDOS EN ACTUALIZAR
function EliminarDetallesPedidosUpdate(coddetallepedido,codpedido,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle del Pedido?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallepedido="+coddetallepedido+"&codpedido="+codpedido+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#detallespedidosupdate').load("funciones.php?MuestraDetallesPedidosUpdate=si&codpedido="+codpedido+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Pedidos en este Módulo, realice la Eliminación completa del Pedido!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Pedidos, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR DETALLES DE PEDIDOS EN AGREGAR
function EliminarDetallesPedidosAgregar(coddetallepedido,codpedido,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle del Pedido?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallepedido="+coddetallepedido+"&codpedido="+codpedido+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#detallespedidosagregar').load("funciones.php?MuestraDetallesPedidosAgregar=si&codpedido="+codpedido+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Pedidos en este Módulo, realice la Eliminación completa del Pedido!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Pedidos, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}


/////FUNCION PARA ELIMINAR PRESUPUESTOS 
function EliminarPedido(codpedido,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Pedido?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codpedido="+codpedido+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#pedidos').load("consultas.php?CargaPedidos=si");
                  
          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Pedidos a Proveedores, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}


// FUNCION PARA BUSQUEDA DE PEDIDOS POR PROVEEDORES
function BuscarPedidosxProveedores(){
                        
$('#muestrapedidosxproveedores').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var codsucursal = $("#codsucursal").val();
var codproveedor = $("select#codproveedor").val();
var dataString = $("#pedidosxproveedores").serialize();
var url = 'funciones.php?BuscaPedidosxProvedores=si';


$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestrapedidosxproveedores').empty();
                $('#muestrapedidosxproveedores').append(''+response+'').fadeIn("slow");
             }
      });
}











/////////////////////////////////// FUNCIONES DE PRODUCTOS //////////////////////////////////////

////FUNCION MUESTRA BOTON PRODUCTOS
function MostrarProductos(){
  
  $('#loading').load("familias_productos?CargarProductos=si");
}

//FUNCION PARA CALCULAR PRECIO VENTA
$(document).ready(function (){
    $('.calculoprecio').keyup(function (){
       
      var precio = $('input#preciocompra').val();
      var porcentaje = $('input#porcentaje').val()/100;

      //REALIZO EL CALCULO
      var calculo = parseFloat(precio)*parseFloat(porcentaje);
      precioventa = parseFloat(calculo)+parseFloat(precio);
      $("#precioventa").val((porcentaje == "0.00") ? "" : precioventa.toFixed(2));

  });
});

// FUNCION PARA MOSTRAR DIV DE CARGA MASIVA DE PRODUCTOS
function CargaDivProductos(){

$('#divproducto').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');
                
var dataString = 'BuscaDivProducto=si';

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#divproducto').empty();
                $('#divproducto').append(''+response+'').fadeIn("slow");
           }
      });
}

// FUNCION PARA LIMPIAR DIV DE CARGA MASIVA DE PRODUCTOS
function ModalProducto(){
  $("#divproducto").html("");
}

// FUNCION PARA MOSTRAR FOTO DE PRODUCTO EN VENTANA MODAL
function VerFoto(codproducto,codsucursal){

$('#muestrafotomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaFotoProductoModal=si&codproducto='+codproducto+"&codsucursal="+codsucursal;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestrafotomodal').empty();
                $('#muestrafotomodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA MOSTRAR PRODUCTOS EN VENTANA MODAL
function VerProducto(codproducto,codsucursal){

$('#muestraproductomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaProductoModal=si&codproducto='+codproducto+"&codsucursal="+codsucursal;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraproductomodal').empty();
                $('#muestraproductomodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA ACTUALIZAR PRODUCTOS
function UpdateProducto(codproducto,codsucursal) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar este Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forproducto?codproducto="+codproducto+"&codsucursal="+codsucursal;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

/////FUNCION PARA ELIMINAR PRODUCTOS 
function EliminarProducto(codproducto,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codproducto="+codproducto+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#productos').load("consultas.php?CargaProductos=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Producto no puede ser Eliminado, tiene Ventas relacionadas!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Productos, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}

// FUNCION PARA BUSQUEDA DE PRODUCTOS POR SUCURSAL
function BuscaProductosxSucursal(){

$('#muestraproductos').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#productosxsucursal").serialize();
var url = 'funciones.php?BuscaProductosxSucursal=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestraproductos').empty();
                $('#muestraproductos').append(''+response+'').fadeIn("slow");
            }
      }); 
}

// FUNCION PARA BUSQUEDA DE PRODUCTOS VENDIDOS
function BuscaProductosVendidos(){
    
$('#muestraproductosvendidos').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#productosvendidos").serialize();
var url = 'funciones.php?BuscaProductoVendidos=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestraproductosvendidos').empty();
                $('#muestraproductosvendidos').append(''+response+'').fadeIn("slow");
            }
      }); 
}

// FUNCION PARA BUSQUEDA DE PRODUCTOS VENDIDOS POR VENDEDOR
function BuscaProductosxVendedor(){
    
$('#muestraproductosxvendedor').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codigo = $("#codigo").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#productosxvendedor").serialize();
var url = 'funciones.php?BuscaProductoxVendedor=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestraproductosxvendedor').empty();
                $('#muestraproductosxvendedor').append(''+response+'').fadeIn("slow");
            }
      }); 
}

// FUNCION PARA BUSQUEDA DE PRODUCTOS POR MONEDA
function BuscaProductosxMoneda(){
    
$('#muestraproductosxmoneda').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codmoneda = $("select#codmoneda").val();
var dataString = $("#productosxmoneda").serialize();
var url = 'funciones.php?BuscaProductoxMoneda=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestraproductosxmoneda').empty();
                $('#muestraproductosxmoneda').append(''+response+'').fadeIn("slow");
            }
      }); 
}


// FUNCION PARA CARGAR PRODUCTOS POR FAMILIAS EN VENTANA MODAL
function CargaProductos(){

$('#loadproductos').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var dataString = "CargarProductos=si&url=modal";

$.ajax({
            type: "GET",
            url: "familias_productos.php",
            data: dataString,
            success: function(response) {            
                $('#loadproductos').empty();
                $('#loadproductos').append(''+response+'').fadeIn("slow");
            }
      });
}


// FUNCION PARA BUSQUEDA DE KARDEX POR PRODUCTOS
function BuscaKardexProductos(){

$('#muestrakardex').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codproducto = $("input#codproducto").val();
var dataString = $("#buscakardex").serialize();
var url = 'funciones.php?BuscaKardexProducto=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestrakardex').empty();
                $('#muestrakardex').append(''+response+'').fadeIn("slow");
            }
      }); 
}

// FUNCION PARA BUSQUEDA DE KARDEX VALORIZADO
function BuscaKardexValorizadoxSucursal(){
    
$('#muestrakardexvalorizado').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#buscakardexvalorizado").serialize();
var url = 'funciones.php?BuscaKardexValorizado=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestrakardexvalorizado').empty();
                $('#muestrakardexvalorizado').append(''+response+'').fadeIn("slow");
            }
      }); 
}

// FUNCION PARA BUSQUEDA DE KARDEX POR FECHAS Y VENDEDOR
function BuscaKardexFechas(){
    
$('#muestrakardexfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codigo = $("#codigo").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#kardevalorizadoxfechas").serialize();
var url = 'funciones.php?BuscaKardexFechas=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestrakardexfechas').empty();
                $('#muestrakardexfechas').append(''+response+'').fadeIn("slow");
            }
      }); 
}






















/////////////////////////////////// FUNCIONES DE TRASPASOS //////////////////////////////////////

// FUNCION PARA MOSTRAR SUCURSALES QUE RECIBEN TRASPASS
function CargaSucursal(envia){

$('#recibe').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaSucursalesRecibeTraspaso=si&envia='+envia;

$.ajax({
            type: "GET",
                  url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#recibe').empty();
                $('#recibe').append(''+response+'').fadeIn("slow");
                
           }
      });
}

// FUNCION PARA MOSTRAR TRASPASOS EN VENTANA MODAL
function VerTraspaso(codtraspaso,codsucursal){

$('#muestratraspasomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaTraspasoModal=si&codtraspaso='+codtraspaso+"&codsucursal="+codsucursal;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestratraspasomodal').empty();
                $('#muestratraspasomodal').append(''+response+'').fadeIn("slow");
                
            }
      });
}

// FUNCION PARA ACTUALIZAR TRASPASOS
function UpdateTraspaso(codtraspaso,codsucursal,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar este Traspaso de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "fortraspaso?codtraspaso="+codtraspaso+"&codsucursal="+codsucursal+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

// FUNCION PARA CALCULAR DETALLES TRASPASOS EN ACTUALIZAR
function ProcesarCalculoTraspaso(indice){
    var cantidad = $('#cantidad_'+indice).val();
    var precioventa = $('#precioventa_'+indice).val();
    var preciocompra = $('#preciocompra_'+indice).val();
    var neto = $('#valorneto_'+indice).val();
    var descproducto = $('#descproducto_'+indice).val();
    var ivaproducto = $('#ivaproducto_'+indice).val();
    var ivg = $('#iva').val();
    var desc = $('#descuento').val();
    var ValorNeto = 0;

    if (cantidad == "" || cantidad == "0" || cantidad == "0.00") {

        $("#cantidad_"+indice).focus();
        $("#cantidad_"+indice).css('border-color', '#f0ad4e');
        swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA!", "error");
        return false;
    }
    //REALIZAMOS LA MULTIPLICACION DE PRECIO VENTA * CANTIDAD
    var ValorTotal = parseFloat(cantidad) * parseFloat(precioventa);

    //REALIZAMOS LA MULTIPLICACION DE PRECIO COMPRA * CANTIDAD
    var ValorTotal2 = parseFloat(cantidad) * parseFloat(preciocompra);

    //CALCULO DEL TOTAL DEL DESCUENTO %
    var Descuento = ValorTotal * descproducto / 100;
    var ValorNeto = parseFloat(ValorTotal) - parseFloat(Descuento);

    //CALCULO DEL TOTAL PARA COMPRA

    //CALCULO VALOR TOTAL
    $("#valortotal_"+indice).val(ValorTotal.toFixed(2));
    $("#txtvalortotal_"+indice).text(ValorTotal.toFixed(2));

    //CALCULO TOTAL DESCUENTO
    $("#totaldescuentov_"+indice).val(Descuento.toFixed(2));
    $("#txtdescproducto_"+indice).text(Descuento.toFixed(2));

    //CALCULO VALOR NETO
    $("#valorneto_"+indice).val(ValorNeto.toFixed(2));
    $("#txtvalorneto_"+indice).text(ValorNeto.toFixed(2));

    //CALCULO VALOR NETO 2
    $("#valorneto2_"+indice).val(ValorTotal2.toFixed(2));

    //CALCULO SUBTOTAL IVA SI
    $("#subtotalivasi_"+indice).val(ivaproducto == "SI" ? ValorNeto.toFixed(2) : "0.00");
    //CALCULO SUBTOTAL IVA NO
    $("#subtotalivano_"+indice).val(ivaproducto == "NO" ? ValorNeto.toFixed(2) : "0.00");

    //CALCULO DE VALOR NETO PARA COMPRAS
    var NetoCompra=0;
    $('.valorneto2').each(function() {  
    NetoCompra += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    });  

    //CALCULO DE SUBTOTAL CON IVA
    var BaseImpIva1=0;
    $('.subtotalivasi').each(function() {  
    BaseImpIva1 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtsubtotal').val(BaseImpIva1.toFixed(2));
    $('#lblsubtotal').text(BaseImpIva1.toFixed(2));

    //CALCULO DE SUBTOTAL SIN IVA
    var BaseImpIva2=0;
    $('.subtotalivano').each(function() {  
    BaseImpIva2 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtsubtotal2').val(BaseImpIva2.toFixed(2));
    $('#lblsubtotal2').text(BaseImpIva2.toFixed(2));

    //CALCULO DE TOTAL IVA
    var TotalIva = BaseImpIva1 * ivg / 100;
    $('#txtIva').val(TotalIva.toFixed(2));
    $('#lbliva').text(TotalIva.toFixed(2));

    //CALCULO DE TOTAL DESCONTADO
    var TotalDescontado=0;
    $('.totaldescuentov').each(function() {  
    TotalDescontado += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    });
    $('#txtdescontado').val(TotalDescontado.toFixed(2));
    $('#lbldescontado').text(TotalDescontado.toFixed(2)); 

    //CALCULAMOS DESCUENTO POR PRODUCTO
    desc2  = desc/100;

    //CALCULO DEL TOTAL DE FACTURA
    var Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIva);
    SubTotal = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2);
    TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
    TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));

    $('#txtTotal').val(TotalFactura.toFixed(2));
    $('#txtTotalCompra').val(NetoCompra.toFixed(2));
    $('#lbltotal').text(TotalFactura.toFixed(2));
}


// FUNCION PARA AGREGAR DETALLES A TRASPASOS
function AgregaDetalleTraspaso(codtraspaso,codsucursal,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Agregar Detalles de Productos a este Traspaso?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Continuar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "fortraspaso?codtraspaso="+codtraspaso+"&codsucursal="+codsucursal+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}


/////FUNCION PARA ELIMINAR DETALLES DE TRASPASOS EN VENTANA MODAL
function EliminarDetalleTraspasoModal(coddetalletraspaso,codtraspaso,recibe,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Traspaso?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetalletraspaso="+coddetalletraspaso+"&codtraspaso="+codtraspaso+"&recibe="+recibe+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#muestratraspasomodal').load("funciones.php?BuscaTraspasoModal=si&codtraspaso="+codtraspaso+"&codsucursal="+codsucursal); 
            $('#traspasos').load("consultas.php?CargaTraspasos=si");    
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Traspasos en este Módulo, realice la Eliminación completa del Traspaso!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Traspasos, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR DETALLES DE TRASPASOS EN ACTUALIZAR
function EliminarDetalleTraspasoUpdate(coddetalletraspaso,codtraspaso,recibe,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Traspaso?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetalletraspaso="+coddetalletraspaso+"&codtraspaso="+codtraspaso+"&recibe="+recibe+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#detallestraspasoupdate').load("funciones.php?MuestraDetallesTraspasoUpdate=si&codtraspaso="+codtraspaso+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Traspasos en este Módulo, realice la Eliminación completa del Traspaso!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Traspasos, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR DETALLES DE TRASPASOS EN AGREGAR
function EliminarDetalleTraspasoAgregar(coddetalletraspaso,codtraspaso,recibe,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Traspaso?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetalletraspaso="+coddetalletraspaso+"&codtraspaso="+codtraspaso+"&recibe="+recibe+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#detallestraspasosagregar').load("funciones.php?MuestraDetallesTrapasoAgregar=si&codtraspaso="+codtraspaso+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Traspasos en este Módulo, realice la Eliminación completa del Traspaso!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Traspasos, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR TRASPASOS 
function EliminarTraspaso(codtraspaso,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Traspaso?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codtraspaso="+codtraspaso+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#traspasos').load("consultas.php?CargaTraspasos=si");
                  
          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Traspasos de Productos, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

// FUNCION PARA BUSQUEDA DE TRASPASOS POR SUCURSAL
function BuscarTraspasosxSucursal(){
                        
$('#muestratraspasosxsucursal').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

codsucursal = $("#codsucursal").val();
var dataString = $("#traspasosxsucursal").serialize();
var url = 'funciones.php?BuscaTraspasosxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function(response) {            
      $('#muestratraspasosxsucursal').empty();
      $('#muestratraspasosxsucursal').append(''+response+'').fadeIn("slow");  
    }
  });
}


// FUNCION PARA BUSQUEDA DE TRASPASOS POR FECHAS
function BuscarTraspasosxFechas(){
                        
$('#muestratraspasosxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

codsucursal = $("#codsucursal").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#traspasosxfechas").serialize();
var url = 'funciones.php?BuscaTraspasosxFechas=si';

$.ajax({
      type: "GET",
      url: url,
      data: dataString,
      success: function(response) {            
          $('#muestratraspasosxfechas').empty();
          $('#muestratraspasosxfechas').append(''+response+'').fadeIn("slow");
          
       }
  });
}


// FUNCION PARA BUSQUEDA DE DETALLES TRASPASOS POR FECHAS
function BuscaDetallesTraspasosxFechas(){
    
$('#muestradetallestraspasosxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#detallestraspasosxfechas").serialize();
var url = 'funciones.php?BuscaDetallesTraspasosxFechas=si';

    $.ajax({
        type: "GET",
        url: url,
        data: dataString,
        success: function(response) {
            $('#muestradetallestraspasosxfechas').empty();
            $('#muestradetallestraspasosxfechas').append(''+response+'').fadeIn("slow");
        }
  }); 
}
















/////////////////////////////////// FUNCIONES DE COMPRAS //////////////////////////////////////

// FUNCION PARA BUSCAR COMPRAS PAGADAS
function BuscarCompras(){
                        
$('#muestracompras').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var search = $("#bcompras").val();
var dataString = $("#busquedacompras").serialize();
var url = 'search.php?CargaCompras=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
      success: function(response) {            
        $('#muestracompras').empty();
        $('#muestracompras').append(''+response+'').fadeIn("slow");
      }
  });
}

// FUNCION PARA BUSCAR COMPRAS PENDIENTES
function BuscarCuentasxPagar(){
                        
$('#muestracuentasxpagar').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var search = $("#bcompras").val();
var dataString = $("#busquedacuentasxpagar").serialize();
var url = 'search.php?CargaCuentasxPagar=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
      success: function(response) {            
        $('#muestracuentasxpagar').empty();
        $('#muestracuentasxpagar').append(''+response+'').fadeIn("slow");
      }
  });
}

// FUNCION PARA MOSTRAR FORMA DE PAGO EN COMPRAS
function CargaFormaPagosCompras(){

  var valor = $("#tipocompra").val();

      if (valor === "" || valor === true) {
         
          $("#formacompra").attr('disabled', true);
          $("#fechavencecredito").attr('disabled', true);

      } else if (valor === "CONTADO" || valor === true) {
         
          $("#formacompra").attr('disabled', false);
          $("#fechavencecredito").attr('disabled', true);

      } else {

          $("#formacompra").attr('disabled', true);
          $("#fechavencecredito").attr('disabled', false);
      }
}

// FUNCION PARA MOSTRAR COMPRA PAGADA EN VENTANA MODAL
function VerCompraPagada(codcompra,codsucursal){

$('#muestracompramodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaCompraPagadaModal=si&codcompra='+codcompra+"&codsucursal="+codsucursal;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestracompramodal').empty();
                $('#muestracompramodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA MOSTRAR COMPRA PENDIENTE EN VENTANA MODAL
function VerCompraPendiente(codcompra,codsucursal){

$('#muestracompramodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaCompraPendienteModal=si&codcompra='+codcompra+"&codsucursal="+codsucursal;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestracompramodal').empty();
                $('#muestracompramodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA ACTUALIZAR COMPRAS
function UpdateCompra(codcompra,codsucursal,proceso,status) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar esta Compra de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forcompra?codcompra="+codcompra+"&codsucursal="+codsucursal+"&proceso="+proceso+"&status="+status;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}



// FUNCION PARA CALCULAR DETALLES VENTAS EN ACTUALIZAR
function ProcesarCalculoCompra(indice){
    var cantidad = $('#cantcompra_'+indice).val();
    var preciocompra = $('#preciocompra_'+indice).val();
    var neto = $('#valorneto_'+indice).val();
    var descproducto = $('#descfactura_'+indice).val();
    var ivaproducto = $('#ivaproducto_'+indice).val();
    var ivg = $('#iva').val();
    var desc = $('#descuento').val();
    var ValorNeto = 0;

    if (cantidad == "" || cantidad == "0" || cantidad == "0.00") {

        $("#cantcompra_"+indice).focus();
        $("#cantcompra_"+indice).css('border-color', '#f0ad4e');
        swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA!", "error");
        return false;
    }
    //REALIZAMOS LA MULTIPLICACION DE PRECIO VENTA * CANTIDAD
    var ValorTotal = parseFloat(cantidad) * parseFloat(preciocompra);

    //CALCULO DEL TOTAL DEL DESCUENTO %
    var Descuento = ValorTotal * descproducto / 100;
    var ValorNeto = parseFloat(ValorTotal) - parseFloat(Descuento);
    
    //CALCULO VALOR TOTAL
    $("#valortotal_"+indice).val(ValorTotal.toFixed(2));
    $("#txtvalortotal_"+indice).text(ValorTotal.toFixed(2));

    //CALCULO TOTAL DESCUENTO
    $("#totaldescuentoc_"+indice).val(Descuento.toFixed(2));
    $("#txtdescproducto_"+indice).text(Descuento.toFixed(2));

    //CALCULO VALOR NETO
    $("#valorneto_"+indice).val(ValorNeto.toFixed(2));
    $("#txtvalorneto_"+indice).text(ValorNeto.toFixed(2));

    //CALCULO SUBTOTAL IVA SI
    $("#subtotalivasi_"+indice).val(ivaproducto == "SI" ? ValorNeto.toFixed(2) : "0.00");
    //CALCULO SUBTOTAL IVA NO
    $("#subtotalivano_"+indice).val(ivaproducto == "NO" ? ValorNeto.toFixed(2) : "0.00"); 

    //CALCULO DE SUBTOTAL CON IVA
    var BaseImpIva1=0;
    $('.subtotalivasi').each(function() {  
    BaseImpIva1 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtsubtotal').val(BaseImpIva.toFixed(2));
    $('#lblsubtotal').text(BaseImpIva.toFixed(2));

    //CALCULO DE SUBTOTAL SIN IVA
    var BaseImpIva2=0;
    $('.subtotalivano').each(function() {  
    BaseImpIva2 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtsubtotal2').val(BaseImpIva2.toFixed(2));
    $('#lblsubtotal2').text(BaseImpIva2.toFixed(2));

    //CALCULO DE TOTAL IVA
    var TotalIva = BaseImpIva1 * ivg / 100;
    $('#txtIva').val(TotalIva.toFixed(2));
    $('#lbliva').text(TotalIva.toFixed(2));

    //CALCULO DE TOTAL DESCONTADO
    var TotalDescontado=0;
    $('.totaldescuentoc').each(function() {  
    TotalDescontado += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    });
    $('#txtdescontado').val(TotalDescontado.toFixed(2));
    $('#lbldescontado').text(TotalDescontado.toFixed(2)); 

    //CALCULAMOS DESCUENTO POR PRODUCTO
    desc2  = desc/100;

    //CALCULO DEL TOTAL DE FACTURA
    var Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIva);
    SubTotal = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2);
    TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
    TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));

    $('#txtTotal').val(TotalFactura.toFixed(2));
    $('#lbltotal').text(TotalFactura.toFixed(2));
}


// FUNCION PARA AGREGAR DETALLES A COMPRAS
function AgregaDetalleCompra(codcompra,codsucursal,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Agregar Detalles de Productos a esta Compra?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Continuar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forcompra?codcompra="+codcompra+"&codsucursal="+codsucursal+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

// FUNCION PARA ABONAR PAGO DE CREDITOS DE COMPRAS
function AbonoCreditoCompra(codsucursal,codproveedor,codcompra,totaldebe,cuitproveedor,nomproveedor,nrocompra,totalfactura,fechaemision,totalabono,debe,criterio) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savepagocompra #codsucursal").val(codsucursal);
  $("#savepagocompra #codproveedor").val(codproveedor);
  $("#savepagocompra #codcompra").val(codcompra);
  $("#savepagocompra #totaldebe").val(totaldebe);
  $("#savepagocompra #cuitproveedor").val(cuitproveedor);
  $("#savepagocompra #nomproveedor").val(nomproveedor);
  $("#savepagocompra #nrocompra").val(nrocompra);
  $("#savepagocompra #totalfactura").val(totalfactura);
  $("#savepagocompra #fechaemision").val(fechaemision);
  $("#savepagocompra #totalabono").val(totalabono);
  $("#savepagocompra #debe").val(debe);
  $("#savepagocompra #criterio").val(criterio);
}

// FUNCION PARA ABONAR PAGO DE CREDITOS DE COMPRAS
function AbonoCreditoProveedor(codsucursal,codproveedor,codcompra,totaldebe,cuitproveedor,nomproveedor,nrocompra,totalfactura,fechaemision,totalabono,debe) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#saveabonosproveedor #codsucursal").val(codsucursal);
  $("#saveabonosproveedor #codproveedor").val(codproveedor);
  $("#saveabonosproveedor #codcompra").val(codcompra);
  $("#saveabonosproveedor #totaldebe").val(totaldebe);
  $("#saveabonosproveedor #cuitproveedor").val(cuitproveedor);
  $("#saveabonosproveedor #nomproveedor").val(nomproveedor);
  $("#saveabonosproveedor #nrocompra").val(nrocompra);
  $("#saveabonosproveedor #totalfactura").val(totalfactura);
  $("#saveabonosproveedor #fechaemision").val(fechaemision);
  $("#saveabonosproveedor #totalabono").val(totalabono);
  $("#saveabonosproveedor #debe").val(debe);
}

/////FUNCION PARA ELIMINAR DETALLES DE COMPRAS PAGADAS EN VENTANA MODAL
function EliminarDetallesComprasPagadasModal(coddetallecompra,codcompra,codproveedor,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Compra?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallecompra="+coddetallecompra+"&codcompra="+codcompra+"&codproveedor="+codproveedor+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#muestracompramodal').load("funciones.php?BuscaCompraPagadaModal=si&codcompra="+codcompra+"&codsucursal="+codsucursal); 
            //$('#compras').load("consultas.php?CargaCompras=si");

          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Compras en este Módulo, realice la Eliminación completa de la Compra!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Compras, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR DETALLES DE COMPRAS PENDIENTES EN VENTANA MODAL
function EliminarDetallesComprasPendientesModal(coddetallecompra,codcompra,codproveedor,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Compra?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallecompra="+coddetallecompra+"&codcompra="+codcompra+"&codproveedor="+codproveedor+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#muestracompramodal').load("funciones.php?BuscaCompraPendienteModal=si&codcompra="+codcompra+"&codsucursal="+codsucursal); 
            //$('#cuentasxpagar').load("consultas?CargaCuentasxPagar=si");

          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Compras en este Módulo, realice la Eliminación completa de la Compra!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Compras, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR DETALLES DE COMPRAS EN ACTUALIZAR
function EliminarDetallesComprasUpdate(coddetallecompra,codcompra,codproveedor,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Compra?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallecompra="+coddetallecompra+"&codcompra="+codcompra+"&codproveedor="+codproveedor+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#detallescomprasupdate').load("funciones.php?MuestraDetallesComprasUpdate=si&codcompra="+codcompra+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Compras en este Módulo, realice la Eliminación completa de la Compra!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Compras, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR DETALLES DE COMPRAS EN AGREGAR
function EliminarDetallesComprasAgregar(coddetallecompra,codcompra,codproveedor,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Compra?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallecompra="+coddetallecompra+"&codcompra="+codcompra+"&codproveedor="+codproveedor+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#detallescomprasagregar').load("funciones.php?MuestraDetallesComprasAgregar=si&codcompra="+codcompra+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Compras en este Módulo, realice la Eliminación completa de la Compra!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Compras, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR COMPRAS 
function EliminarCompra(codcompra,codproveedor,codsucursal,status,criterio,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Compra?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codcompra="+codcompra+"&codproveedor="+codproveedor+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            if (status=="P") {
            $('#muestracompras').load("search.php?CargaCompras=si&bcompras="+criterio); 
            //$('#compras').load("consultas.php?CargaCompras=si");
            } else {
            $('#muestracuentasxpagar').load("search.php?CargaCuentasxPagar=si&bcompras="+criterio);  
            //$('#cuentasxpagar').load("consultas?CargaCuentasxPagar=si");
            }
            
                  
          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Compras de Productos, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}


// FUNCION PARA BUSQUEDA DE COMPRAS POR PROVEEDORES
function BuscarComprasxProveedores(){
                        
$('#muestracomprasxproveedores').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var codsucursal = $("#codsucursal").val();
var codproveedor = $("select#codproveedor").val();
var dataString = $("#comprasxproveedores").serialize();
var url = 'funciones.php?BuscaComprasxProvedores=si';


$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestracomprasxproveedores').empty();
                $('#muestracomprasxproveedores').append(''+response+'').fadeIn("slow");
             }
      });
}


// FUNCION PARA BUSQUEDA DE COMPRAS POR FECHAS
function BuscarComprasxFechas(){
                        
$('#muestracomprasxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();                
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#comprasxfechas").serialize();
var url = 'funciones.php?BuscaComprasxFechas=si';


$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestracomprasxfechas').empty();
                $('#muestracomprasxfechas').append(''+response+'').fadeIn("slow");
             }
      });
}


//FUNCION PARA BUSQUEDA DE CREDITOS DE COMPRAS POR PROVEEDOR Y FECHAS
function BuscarCreditosxProveedor(){
                  
$('#muestracreditosxproveedor').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codproveedor = $("#codproveedor").val();
var dataString = $("#creditosxproveedor").serialize();
var url = 'funciones.php?BuscaCreditosxProveedor=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestracreditosxproveedor').empty();
                $('#muestracreditosxproveedor').append(''+response+'').fadeIn("slow");
               }
      }); 
}

// FUNCION PARA BUSQUEDA DE CREDITOS DE COMPRAS POR FECHAS
function BuscarCreditosComprasxFechas(){
                        
$('#muestracreditoscomprasxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();                
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#creditoscomprasxfechas").serialize();
var url = 'funciones.php?BuscaCreditosComprasxFechas=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestracreditoscomprasxfechas').empty();
                $('#muestracreditoscomprasxfechas').append(''+response+'').fadeIn("slow");
             }
      });
}


















/////////////////////////////////// FUNCIONES DE COTIZACIONES //////////////////////////////////////

// FUNCION PARA BUSCAR COTIZACIONES
function BuscarCotizaciones(){
                        
$('#muestracotizaciones').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var search = $("#bcotizaciones").val();
var dataString = $("#busquedacotizaciones").serialize();
var url = 'search.php?CargaCotizaciones=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
      success: function(response) {            
        $('#muestracotizaciones').empty();
        $('#muestracotizaciones').append(''+response+'').fadeIn("slow");
      }
  });
}

// FUNCION PARA MOSTRAR COTIZACIONES EN VENTANA MODAL
function VerCotizacion(codcotizacion,codsucursal){

$('#muestracotizacionmodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaCotizacionModal=si&codcotizacion='+codcotizacion+"&codsucursal="+codsucursal;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestracotizacionmodal').empty();
                $('#muestracotizacionmodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA CARGAR DATOS DE COTIZACION
function ProcesaCotizacion(codcotizacion,codsucursal,codcliente,busqueda,nombres,limitecredito,totalpago,criterio) 
{
  // aqui asigno cada valor a los campos correspondientes
  $("#procesarcotizacion #codcotizacion").val(codcotizacion);
  $("#procesarcotizacion #codsucursal").val(codsucursal);
  $("#procesarcotizacion #codcliente").val(codcliente);
  $("#procesarcotizacion #busqueda").val(busqueda);
  $("#procesarcotizacion #TextCliente").text(nombres);
  $("#procesarcotizacion #TextCredito").text(limitecredito);
  $("#procesarcotizacion #txtTotal").val(totalpago);
  $("#procesarcotizacion #TextImporte").text(totalpago);
  $("#procesarcotizacion #montopagado").val(totalpago);
  $("#procesarcotizacion #criterio").val(criterio);
}


// FUNCION PARA ACTUALIZAR COTIZACIONES
function UpdateCotizacion(codcotizacion,codsucursal,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar esta Cotización de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forcotizacion?codcotizacion="+codcotizacion+"&codsucursal="+codsucursal+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

// FUNCION PARA CALCULAR DETALLES COTIZACIONES EN ACTUALIZAR
function ProcesarCalculoCotizacion(indice){
    var cantidad = $('#cantcotizacion_'+indice).val();
    var precioventa = $('#precioventa_'+indice).val();
    var preciocompra = $('#preciocompra_'+indice).val();
    var neto = $('#valorneto_'+indice).val();
    var descproducto = $('#descproducto_'+indice).val();
    var ivaproducto = $('#ivaproducto_'+indice).val();
    var ivg = $('#iva').val();
    var desc = $('#descuento').val();
    var ValorNeto = 0;

    if (cantidad == "" || cantidad == "0" || cantidad == "0.00") {

        $("#cantcotizacion_"+indice).focus();
        $("#cantcotizacion_"+indice).css('border-color', '#f0ad4e');
        swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA!", "error");
        return false;
    }
    //REALIZAMOS LA MULTIPLICACION DE PRECIO VENTA * CANTIDAD
    var ValorTotal = parseFloat(cantidad) * parseFloat(precioventa);

    //REALIZAMOS LA MULTIPLICACION DE PRECIO COMPRA * CANTIDAD
    var ValorTotal2 = parseFloat(cantidad) * parseFloat(preciocompra);

    //CALCULO DEL TOTAL DEL DESCUENTO %
    var Descuento = ValorTotal * descproducto / 100;
    var ValorNeto = parseFloat(ValorTotal) - parseFloat(Descuento);

    //CALCULO DEL TOTAL PARA COMPRA

    //CALCULO VALOR TOTAL
    $("#valortotal_"+indice).val(ValorTotal.toFixed(2));
    $("#txtvalortotal_"+indice).text(ValorTotal.toFixed(2));

    //CALCULO TOTAL DESCUENTO
    $("#totaldescuentov_"+indice).val(Descuento.toFixed(2));
    $("#txtdescproducto_"+indice).text(Descuento.toFixed(2));

    //CALCULO VALOR NETO
    $("#valorneto_"+indice).val(ValorNeto.toFixed(2));
    $("#txtvalorneto_"+indice).text(ValorNeto.toFixed(2));

    //CALCULO VALOR NETO 2
    $("#valorneto2_"+indice).val(ValorTotal2.toFixed(2));

    //CALCULO SUBTOTAL IVA SI
    $("#subtotalivasi_"+indice).val(ivaproducto == "SI" ? ValorNeto.toFixed(2) : "0.00");
    //CALCULO SUBTOTAL IVA NO
    $("#subtotalivano_"+indice).val(ivaproducto == "NO" ? ValorNeto.toFixed(2) : "0.00");

    //CALCULO DE VALOR NETO PARA COMPRAS
    var NetoCompra=0;
    $('.valorneto2').each(function() {  
    NetoCompra += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    });  

    //CALCULO DE SUBTOTAL CON IVA
    var BaseImpIva1=0;
    $('.subtotalivasi').each(function() {  
    BaseImpIva1 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtsubtotal').val(BaseImpIva1.toFixed(2));
    $('#lblsubtotal').text(BaseImpIva1.toFixed(2));

    //CALCULO DE SUBTOTAL SIN IVA
    var BaseImpIva2=0;
    $('.subtotalivano').each(function() {  
    BaseImpIva2 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtsubtotal2').val(BaseImpIva2.toFixed(2));
    $('#lblsubtotal2').text(BaseImpIva2.toFixed(2));

    //CALCULO DE TOTAL IVA
    var TotalIva = BaseImpIva1 * ivg / 100;
    $('#txtIva').val(TotalIva.toFixed(2));
    $('#lbliva').text(TotalIva.toFixed(2));

    //CALCULO DE TOTAL DESCONTADO
    var TotalDescontado=0;
    $('.totaldescuentov').each(function() {  
    TotalDescontado += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    });
    $('#txtdescontado').val(TotalDescontado.toFixed(2));
    $('#lbldescontado').text(TotalDescontado.toFixed(2)); 

    //CALCULAMOS DESCUENTO POR PRODUCTO
    desc2  = desc/100;

    //CALCULO DEL TOTAL DE FACTURA
    var Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIva);
    SubTotal = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2);
    TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
    TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));

    $('#txtTotal').val(TotalFactura.toFixed(2));
    $('#txtTotalCompra').val(NetoCompra.toFixed(2));
    $('#lbltotal').text(TotalFactura.toFixed(2));
}


// FUNCION PARA AGREGAR DETALLES A COTIZACIONES
function AgregaDetalleCotizacion(codcotizacion,codsucursal,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Agregar Detalles de Productos a esta Cotización?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Continuar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forcotizacion?codcotizacion="+codcotizacion+"&codsucursal="+codsucursal+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}


/////FUNCION PARA ELIMINAR DETALLES DE COTIZACIONES EN VENTANA MODAL
function EliminarDetallesCotizacionModal(coddetallecotizacion,codcotizacion,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Cotización?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallecotizacion="+coddetallecotizacion+"&codcotizacion="+codcotizacion+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#muestracotizacionmodal').load("funciones.php?BuscaCotizacionModal=si&codcotizacion="+codcotizacion+"&codsucursal="+codsucursal); 
            $('#cotizaciones').load("consultas.php?CargaCotizaciones=si");    
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Cotizaciones en este Módulo, realice la Eliminación completa de la Cotización!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Cotizaciones, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}


/////FUNCION PARA ELIMINAR DETALLES DE COTIZACIONES EN ACTUALIZAR
function EliminarDetallesCotizacionesUpdate(coddetallecotizacion,codcotizacion,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Cotización?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallecotizacion="+coddetallecotizacion+"&codcotizacion="+codcotizacion+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#detallescotizacionesupdate').load("funciones.php?MuestraDetallesCotizacionesUpdate=si&codcotizacion="+codcotizacion+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Cotizaciones en este Módulo, realice la Eliminación completa de la Cotización!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Cotizaciones, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR DETALLES DE COTIZACIONES EN AGREGAR
function EliminarDetallesCotizacionesAgregar(coddetallecotizacion,codcotizacion,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Cotización?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallecotizacion="+coddetallecotizacion+"&codcotizacion="+codcotizacion+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#detallescotizacionesagregar').load("funciones.php?MuestraDetallesCotizacionesAgregar=si&codcotizacion="+codcotizacion+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Cotizaciones en este Módulo, realice la Eliminación completa de la Cotización!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Cotizaciones, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR COTIZACIONES 
function EliminarCotizacion(codcotizacion,codsucursal,criterio,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Cotización?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codcotizacion="+codcotizacion+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#muestracotizaciones').load("search.php?CargaCotizaciones=si&bcotizaciones="+criterio);
            //$('#cotizaciones').load("consultas.php?CargaCotizaciones=si");
                  
          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Cotizaciones de Productos, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}


// FUNCION PARA BUSQUEDA DE COTIZACIONES POR FECHAS
function BuscarCotizacionesxFechas(){
                        
$('#muestracotizacionesxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();                
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#cotizacionesxfechas").serialize();
var url = 'funciones.php?BuscaCotizacionesxFechas=si';


$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestracotizacionesxfechas').empty();
                $('#muestracotizacionesxfechas').append(''+response+'').fadeIn("slow");
             }
      });
}

// FUNCION PARA BUSQUEDA DE DETALLES COTIZACIONES X FECHAS
function BuscaDetallesCotizacionesxFechas(){
    
$('#muestradetallescotizacionesxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#detallescotizacionesxfechas").serialize();
var url = 'funciones.php?BuscaDetallesCotizacionesxFechas=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestradetallescotizacionesxfechas').empty();
                $('#muestradetallescotizacionesxfechas').append(''+response+'').fadeIn("slow");
            }
      }); 
}


// FUNCION PARA BUSQUEDA DE DETALLES COTIZACIONES X VENDEDOR
function BuscaDetallesCotizacionesxVendedor(){
    
$('#muestradetallescotizacionesxvendedor').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codigo = $("#codigo").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#detallescotizacionesxvendedor").serialize();
var url = 'funciones.php?BuscaDetallesCotizacionesxVendedor=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestradetallescotizacionesxvendedor').empty();
                $('#muestradetallescotizacionesxvendedor').append(''+response+'').fadeIn("slow");
            }
      }); 
}






















/////////////////////////////////// FUNCIONES DE PREVENTAS //////////////////////////////////////

// FUNCION PARA MOSTRAR PREVENTAS EN VENTANA MODAL
function VerPreventa(codpreventa,codsucursal){

$('#muestrapreventamodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaPreventaModal=si&codpreventa='+codpreventa+"&codsucursal="+codsucursal;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestrapreventamodal').empty();
                $('#muestrapreventamodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA CARGAR DATOS DE PREVENTAS
function ProcesaPreventa(codpreventa,codsucursal,codcliente,busqueda,nombres,limitecredito,totalpago) 
{
  // aqui asigno cada valor a los campos correspondientes
  $("#procesarpreventa #codpreventa").val(codpreventa);
  $("#procesarpreventa #codsucursal").val(codsucursal);
  $("#procesarpreventa #codcliente").val(codcliente);
  $("#procesarpreventa #busqueda").val(busqueda);
  $("#procesarpreventa #TextCliente").text(nombres);
  $("#procesarpreventa #TextCredito").text(limitecredito);
  $("#procesarpreventa #txtTotal").val(totalpago);
  $("#procesarpreventa #TextImporte").text(totalpago);
  $("#procesarpreventa #montopagado").val(totalpago);
}


// FUNCION PARA ACTUALIZAR PREVENTAS
function UpdatePreventa(codpreventa,codsucursal,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar esta Preventa de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forpreventa?codpreventa="+codpreventa+"&codsucursal="+codsucursal+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}


// FUNCION PARA CALCULAR DETALLES COTIZACIONES EN ACTUALIZAR
function ProcesarCalculoPreventa(indice){
    var cantidad = $('#cantpreventa_'+indice).val();
    var precioventa = $('#precioventa_'+indice).val();
    var preciocompra = $('#preciocompra_'+indice).val();
    var neto = $('#valorneto_'+indice).val();
    var descproducto = $('#descproducto_'+indice).val();
    var ivaproducto = $('#ivaproducto_'+indice).val();
    var ivg = $('#iva').val();
    var desc = $('#descuento').val();
    var ValorNeto = 0;

    if (cantidad == "" || cantidad == "0" || cantidad == "0.00") {

        $("#cantpreventa_"+indice).focus();
        $("#cantpreventa_"+indice).css('border-color', '#f0ad4e');
        swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA!", "error");
        return false;
    }
    //REALIZAMOS LA MULTIPLICACION DE PRECIO VENTA * CANTIDAD
    var ValorTotal = parseFloat(cantidad) * parseFloat(precioventa);

    //REALIZAMOS LA MULTIPLICACION DE PRECIO COMPRA * CANTIDAD
    var ValorTotal2 = parseFloat(cantidad) * parseFloat(preciocompra);

    //CALCULO DEL TOTAL DEL DESCUENTO %
    var Descuento = ValorTotal * descproducto / 100;
    var ValorNeto = parseFloat(ValorTotal) - parseFloat(Descuento);

    //CALCULO DEL TOTAL PARA COMPRA

    //CALCULO VALOR TOTAL
    $("#valortotal_"+indice).val(ValorTotal.toFixed(2));
    $("#txtvalortotal_"+indice).text(ValorTotal.toFixed(2));

    //CALCULO TOTAL DESCUENTO
    $("#totaldescuentov_"+indice).val(Descuento.toFixed(2));
    $("#txtdescproducto_"+indice).text(Descuento.toFixed(2));

    //CALCULO VALOR NETO
    $("#valorneto_"+indice).val(ValorNeto.toFixed(2));
    $("#txtvalorneto_"+indice).text(ValorNeto.toFixed(2));

    //CALCULO VALOR NETO 2
    $("#valorneto2_"+indice).val(ValorTotal2.toFixed(2));

    //CALCULO SUBTOTAL IVA SI
    $("#subtotalivasi_"+indice).val(ivaproducto == "SI" ? ValorNeto.toFixed(2) : "0.00");
    //CALCULO SUBTOTAL IVA NO
    $("#subtotalivano_"+indice).val(ivaproducto == "NO" ? ValorNeto.toFixed(2) : "0.00");

    //CALCULO DE VALOR NETO PARA COMPRAS
    var NetoCompra=0;
    $('.valorneto2').each(function() {  
    NetoCompra += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    });  

    //CALCULO DE SUBTOTAL CON IVA
    var BaseImpIva1=0;
    $('.subtotalivasi').each(function() {  
    BaseImpIva1 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtsubtotal').val(BaseImpIva1.toFixed(2));
    $('#lblsubtotal').text(BaseImpIva1.toFixed(2));

    //CALCULO DE SUBTOTAL SIN IVA
    var BaseImpIva2=0;
    $('.subtotalivano').each(function() {  
    BaseImpIva2 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtsubtotal2').val(BaseImpIva2.toFixed(2));
    $('#lblsubtotal2').text(BaseImpIva2.toFixed(2));

    //CALCULO DE TOTAL IVA
    var TotalIva = BaseImpIva1 * ivg / 100;
    $('#txtIva').val(TotalIva.toFixed(2));
    $('#lbliva').text(TotalIva.toFixed(2));

    //CALCULO DE TOTAL DESCONTADO
    var TotalDescontado=0;
    $('.totaldescuentov').each(function() {  
    TotalDescontado += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    });
    $('#txtdescontado').val(TotalDescontado.toFixed(2));
    $('#lbldescontado').text(TotalDescontado.toFixed(2)); 

    //CALCULAMOS DESCUENTO POR PRODUCTO
    desc2  = desc/100;

    //CALCULO DEL TOTAL DE FACTURA
    var Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIva);
    SubTotal = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2);
    TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
    TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));

    $('#txtTotal').val(TotalFactura.toFixed(2));
    $('#txtTotalCompra').val(NetoCompra.toFixed(2));
    $('#lbltotal').text(TotalFactura.toFixed(2));
}

// FUNCION PARA AGREGAR DETALLES A PREVENTAS
function AgregaDetallePreventa(codpreventa,codsucursal,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Agregar Detalles de Productos a esta Preventa?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Continuar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forpreventa?codpreventa="+codpreventa+"&codsucursal="+codsucursal+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}


/////FUNCION PARA ELIMINAR DETALLES DE PREVENTAS EN VENTANA MODAL
function EliminarDetallesPreventaModal(coddetallepreventa,codpreventa,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Preventa?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallepreventa="+coddetallepreventa+"&codpreventa="+codpreventa+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#muestrapreventamodal').load("funciones.php?BuscaPreventaModal=si&codpreventa="+codpreventa+"&codsucursal="+codsucursal); 
            $('#preventas').load("consultas.php?CargaPreventas=si");    
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Preventas en este Módulo, realice la Eliminación completa de la Cotización!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Preventas, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}


/////FUNCION PARA ELIMINAR DETALLES DE PREVENTAS EN ACTUALIZAR
function EliminarDetallesPreventasUpdate(coddetallepreventa,codpreventa,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Preventa?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallepreventa="+coddetallepreventa+"&codpreventa="+codpreventa+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#detallespreventasupdate').load("funciones.php?MuestraDetallesPreventasUpdate=si&codpreventa="+codpreventa+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Preventas en este Módulo, realice la Eliminación completa de la Cotización!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Preventas, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR DETALLES DE PREVENTAS EN AGREGAR
function EliminarDetallesPreventasAgregar(coddetallepreventa,codpreventa,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Preventa?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallepreventa="+coddetallepreventa+"&codpreventa="+codpreventa+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#detallespreventasagregar').load("funciones.php?MuestraDetallesPreventasAgregar=si&codpreventa="+codpreventa+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Preventas en este Módulo, realice la Eliminación completa de la Cotización!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Preventas, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR PREVENTAS 
function EliminarPreventa(codpreventa,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Preventa?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codpreventa="+codpreventa+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#preventas').load("consultas.php?CargaPreventas=si");
                  
          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Preventas de Productos, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}


// FUNCION PARA BUSQUEDA DE PREVENTAS POR FECHAS
function BuscarPreventasxFechas(){
                        
$('#muestrapreventasxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();                
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#preventasxfechas").serialize();
var url = 'funciones.php?BuscaPreventasxFechas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function(response) {            
        $('#muestrapreventasxfechas').empty();
        $('#muestrapreventasxfechas').append(''+response+'').fadeIn("slow");
      }
  });
}

// FUNCION PARA BUSQUEDA DE DETALLES PREVENTAS X FECHAS
function BuscaDetallesPreventasxFechas(){
    
$('#muestradetallespreventasxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#detallespreventasxfechas").serialize();
var url = 'funciones.php?BuscaDetallesPreventasxFechas=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestradetallespreventasxfechas').empty();
                $('#muestradetallespreventasxfechas').append(''+response+'').fadeIn("slow");
            }
      }); 
}


// FUNCION PARA BUSQUEDA DE DETALLES PREVENTAS X VENDEDOR
function BuscaDetallesPreventasxVendedor(){
    
$('#muestradetallespreventasxvendedor').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codigo = $("#codigo").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#detallespreventasxvendedor").serialize();
var url = 'funciones.php?BuscaDetallesPreventasxVendedor=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestradetallespreventasxvendedor').empty();
                $('#muestradetallespreventasxvendedor').append(''+response+'').fadeIn("slow");
            }
      }); 
}












/////////////////////////////////// FUNCIONES DE CAJAS DE VENTAS //////////////////////////////////////

// FUNCION PARA MOSTRAR CAJAS DE VENTAS EN VENTANA MODAL
function VerCaja(codcaja){

$('#muestracajamodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaCajaModal=si&codcaja='+codcaja;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestracajamodal').empty();
                $('#muestracajamodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA ACTUALIZAR CAJAS DE VENTAS
function UpdateCaja(codcaja,nrocaja,nomcaja,codsucursal,codigo,proceso) 
{
  // aqui asigno cada valor a los campos correspondientes
  $("#savecaja #codcaja").val(codcaja);
  $("#savecaja #nrocaja").val(nrocaja);
  $("#savecaja #nomcaja").val(nomcaja);
  $("#savecaja #codsucursal").val(codsucursal);
  $("#savecaja #codigo").val(codigo);
  $("#savecaja #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR CAJAS DE VENTAS 
function EliminarCaja(codcaja,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Caja para Ventas?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codcaja="+codcaja+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#cajas').load("consultas?CargaCajas=si");
                  
          } else if(data==2){ 

             swal("Oops", "Esta Caja para Venta no puede ser Eliminada, tiene Ventas relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Cajas para Ventas, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}


// FUNCION PARA MOSTRAR CAJAS POR SUCURSAL
function CargaCajas(codsucursal){

$('#codcaja').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var dataString = 'BuscaCajasxSucursal=si&codsucursal='+codsucursal;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#codcaja').empty();
                $('#codcaja').append(''+response+'').fadeIn("slow");
           }
      });
}


// FUNCION PARA MOSTRAR CAJAS POR SUCURSAL
function CargaCajasAbiertas(codsucursal){

$('#codcaja').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var dataString = 'BuscaCajasAbiertasxSucursal=si&codsucursal='+codsucursal;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#codcaja').empty();
                $('#codcaja').append(''+response+'').fadeIn("slow");
           }
      });
}

















/////////////////////////////////// FUNCIONES DE ARQUEOS DE CAJAS PARA VENTAS //////////////////////////////////////

// FUNCION PARA MOSTRAR ARQUEOS DE CAJAS PARA VENTAS EN VENTANA MODAL
function VerArqueo(codarqueo){

$('#muestraarqueomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaArqueoModal=si&codarqueo='+codarqueo;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraarqueomodal').empty();
                $('#muestraarqueomodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA ACTUALIZAR ARQUEOS DE CAJAS PARA VENTAS
function CerrarArqueo(codarqueo,nrocaja,responsable,montoinicial,ingresos,egresos,creditos,abonos,estimado,fechaapertura) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savecerrararqueo #codarqueo").val(codarqueo);
  $('label[id*="nrocaja"]').text(nrocaja);
  $("#savecerrararqueo #responsable").val(responsable);
  $("#savecerrararqueo #montoinicial").val(montoinicial);
  $("#savecerrararqueo #ingresos").val(ingresos);
  $("#savecerrararqueo #egresos").val(egresos);
  $("#savecerrararqueo #creditos").val(creditos);
  $("#savecerrararqueo #abonos").val(abonos);
  $("#savecerrararqueo #estimado").val(estimado);
  $("#savecerrararqueo #fechaapertura").val(fechaapertura);
}

//FUNCION PARA CALCULAR LA DIFERENCIA EN CIERRE DE CAJA
$(document).ready(function (){
  $('.cierrecaja').keyup(function (){
      
    var efectivo = $('input#dineroefectivo').val();
    var estimado = $('input#estimado').val();
            
    //REALIZO EL CALCULO Y MUESTRO LA DEVOLUCION
    total = parseFloat(efectivo - estimado);
    var original = parseFloat(total.toFixed(2));
    $("#diferencia").val(original.toFixed(2));
      
  });
});

// FUNCION PARA ACTUALIZAR ARQUEOS DE CAJAS PARA VENTAS
function UpdateArqueo(codarqueo,nrocaja,responsable,montoinicial,ingresos,egresos,creditos,abonos,estimado,dineroefectivo,diferencia,comentarios,fechaapertura,fechacierre) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#updatearqueo #codarqueo").val(codarqueo);
  $("#updatearqueo #responsable").val(responsable);
  $("#updatearqueo #montoinicial").val(montoinicial);
  $("#updatearqueo #ingresos").val(ingresos);
  $("#updatearqueo #egresos").val(egresos);
  $("#updatearqueo #creditos").val(creditos);
  $("#updatearqueo #abonos").val(abonos);
  $("#updatearqueo #estimado2").val(estimado);
  $("#updatearqueo #dineroefectivo2").val(dineroefectivo);
  $("#updatearqueo #diferencia2").val(diferencia);
  $("#updatearqueo #comentarios").val(comentarios);
  $("#updatearqueo #fechaapertura").val(fechaapertura);
  $("#updatearqueo #fechacierre").val(fechacierre);
}

//FUNCION PARA CALCULAR LA DIFERENCIA EN CIERRE DE CAJA
$(document).ready(function (){
  $('.updatecaja').keyup(function (){
      
    var efectivo = $('input#dineroefectivo2').val();
    var estimado = $('input#estimado2').val();
            
    //REALIZO EL CALCULO Y MUESTRO LA DEVOLUCION
    total = parseFloat(efectivo - estimado);
    var original = parseFloat(total.toFixed(2));
    $("#diferencia2").val(original.toFixed(2));
      
  });
});

//FUNCION PARA BUSQUEDA DE ARQUEOS DE CAJAS POR FECHAS PARA REPORTES
function BuscarArqueosxFechas(){
                  
$('#muestraarqueosxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codcaja = $("#codcaja").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#arqueosxfechas").serialize();
var url = 'funciones.php?BuscaArqueosxFechas=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestraarqueosxfechas').empty();
                $('#muestraarqueosxfechas').append(''+response+'').fadeIn("slow");
               }
      }); 
}














/////////////////////////////////// FUNCIONES DE MOVIMIENTOS EN CAJAS DE VENTAS //////////////////////////////////////

// FUNCION PARA MOSTRAR MOVIMIENTO EN CAJAS DE VENTAS EN VENTANA MODAL
function VerMovimiento(numero,codsucursal){

$('#muestramovimientomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaMovimientoModal=si&numero='+numero+"&codsucursal="+codsucursal;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestramovimientomodal').empty();
                $('#muestramovimientomodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA ACTUALIZAR MOVIMIENTOS EN CAJAS DE VENTAS
function UpdateMovimiento(codmovimiento,numero,codcaja,tipomovimiento,descripcionmovimiento,montomovimiento,codmediopago,fechamovimiento,codarqueo,codsucursal,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savemovimiento #codmovimiento").val(codmovimiento);
  $("#savemovimiento #numero").val(numero);
  $("#savemovimiento #codcaja").val(codcaja);
  $("#savemovimiento #tipomovimiento").val(tipomovimiento);
  $("#savemovimiento #tipomovimientobd").val(tipomovimiento);
  $("#savemovimiento #descripcionmovimiento").val(descripcionmovimiento);
  $("#savemovimiento #montomovimiento").val(montomovimiento);
  $("#savemovimiento #montomovimientobd").val(montomovimiento);
  $("#savemovimiento #codmediopago").val(codmediopago);
  $("#savemovimiento #codmediopagobd").val(codmediopago);
  $("#savemovimiento #fecharegistro").val(fechamovimiento);
  $("#savemovimiento #codarqueo").val(codarqueo);
  $("#savemovimiento #codsucursal").val(codsucursal);
  $("#savemovimiento #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR MOVIMIENTOS EN CAJAS DE VENTAS 
function EliminarMovimiento(codmovimiento,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Movimiento en Caja para Ventas?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codmovimiento="+codmovimiento+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#movimientos').load("consultas?CargaMovimientos=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Movimiento en Caja para Venta no puede ser Eliminado, se encuentra Desactivado!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Movimiento en Cajas para Ventas, no eres el Administrador de Sucursal o Cajero del Sistema!", "error"); 

                }
            }
        })
    });
}

//FUNCION PARA BUSQUEDA DE MOVIMIENTOS DE CAJAS POR FECHAS PARA REPORTES
function BuscarMovimientosxFechas(){
                  
$('#muestramovimientosxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codcaja = $("#codcaja").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#movimientosxfechas").serialize();
var url = 'funciones.php?BuscaMovimientosxFechas=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestramovimientosxfechas').empty();
                $('#muestramovimientosxfechas').append(''+response+'').fadeIn("slow");
               }
      }); 
}

























/////////////////////////////////// FUNCIONES DE VENTAS //////////////////////////////////////

// FUNCION PARA CERRA CAJA EN VENTA
function CerrarCaja(){

$('#cierrecaja').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = "MuestraCajaVenta=si";

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#cierrecaja').empty();
                $('#cierrecaja').append(''+response+'').fadeIn("slow");
            }
      });
}

//FUNCION PARA CALCULADR MONTO DEVOLUCION EN DELIVERY
function CalculoDevolucion(){
      
      if ($('input#txtTotal').val()==0.00 || $('input#txtTotal').val()==0) {
              
          $("#montopagado").val("");
          swal("Oops", "POR FAVOR AGREGUE DETALLES PARA CONTINUAR CON LA VENTA DE PRODUCTOS!", "error");

            return false;
   
      } else {
      
      var montototal = $('input#txtTotal').val();
      var montopagado = $('input#montopagado').val();
      var montodevuelto = $('input#montodevuelto').val();
            
      //REALIZO EL CALCULO Y MUESTRO LA DEVOLUCION
      total=montopagado - montototal;
      var original=parseFloat(total.toFixed(2));

      $("#TextPagado").text(montopagado);
      $("#TextCambio").text((montopagado == "" || montopagado == "0") ? "0.00" : original.toFixed(2));
      $("#montodevuelto").val((montopagado == "" || montopagado == "0") ? "0.00" : original.toFixed(2));
   }
}

// FUNCION PARA MOSTRAR CONDICIONES DE PAGO
function CargaCondicionesPagos(){

var tipopago = $('input:radio[name=tipopago]:checked').val(); 

var dataString = 'BuscaCondicionesPagos=si&tipopago='+tipopago;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#condiciones').empty();
                $('#condiciones').append(''+response+'').fadeIn("slow");
                $('#mediopagos').html('');
                
            }
      });
}

// FUNCION PARA BUSCAR VENTAS
function BuscarVentas(){
                        
$('#muestraventas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var search = $("#bventas").val();
var dataString = $("#busquedaventas").serialize();
var url = 'search.php?CargaVentas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
      success: function(response) {            
        $('#muestraventas').empty();
        $('#muestraventas').append(''+response+'').fadeIn("slow");
      }
  });
}

// FUNCION PARA MOSTRAR VENTAS EN VENTANA MODAL
function VerVenta(codventa,codsucursal){

$('#muestraventamodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaVentaModal=si&codventa='+codventa+"&codsucursal="+codsucursal;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraventamodal').empty();
                $('#muestraventamodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA ACTUALIZAR VENTAS
function UpdateVenta(codventa,codsucursal,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar esta Venta de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forventa?codventa="+codventa+"&codsucursal="+codsucursal+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

// FUNCION PARA CALCULAR DETALLES VENTAS EN ACTUALIZAR
function ProcesarCalculoVenta(indice){
    var cantidad = $('#cantventa_'+indice).val();
    var precioventa = $('#precioventa_'+indice).val();
    var preciocompra = $('#preciocompra_'+indice).val();
    var neto = $('#valorneto_'+indice).val();
    var descproducto = $('#descproducto_'+indice).val();
    var ivaproducto = $('#ivaproducto_'+indice).val();
    var ivg = $('#iva').val();
    var desc = $('#descuento').val();
    var ValorNeto = 0;

    if (cantidad == "" || cantidad == "0" || cantidad == "0.00") {

        $("#cantventa_"+indice).focus();
        $("#cantventa_"+indice).css('border-color', '#f0ad4e');
        swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA!", "error");
        return false;
    }
    //REALIZAMOS LA MULTIPLICACION DE PRECIO VENTA * CANTIDAD
    var ValorTotal = parseFloat(cantidad) * parseFloat(precioventa);

    //REALIZAMOS LA MULTIPLICACION DE PRECIO COMPRA * CANTIDAD
    var ValorTotal2 = parseFloat(cantidad) * parseFloat(preciocompra);

    //CALCULO DEL TOTAL DEL DESCUENTO %
    var Descuento = ValorTotal * descproducto / 100;
    var ValorNeto = parseFloat(ValorTotal) - parseFloat(Descuento);

    //CALCULO DEL TOTAL PARA COMPRA

    //CALCULO VALOR TOTAL
    $("#valortotal_"+indice).val(ValorTotal.toFixed(2));
    $("#txtvalortotal_"+indice).text(ValorTotal.toFixed(2));

    //CALCULO TOTAL DESCUENTO
    $("#totaldescuentov_"+indice).val(Descuento.toFixed(2));
    $("#txtdescproducto_"+indice).text(Descuento.toFixed(2));

    //CALCULO VALOR NETO
    $("#valorneto_"+indice).val(ValorNeto.toFixed(2));
    $("#txtvalorneto_"+indice).text(ValorNeto.toFixed(2));

    //CALCULO VALOR NETO 2
    $("#valorneto2_"+indice).val(ValorTotal2.toFixed(2));

    //CALCULO SUBTOTAL IVA SI
    $("#subtotalivasi_"+indice).val(ivaproducto == "SI" ? ValorNeto.toFixed(2) : "0.00");
    //CALCULO SUBTOTAL IVA NO
    $("#subtotalivano_"+indice).val(ivaproducto == "NO" ? ValorNeto.toFixed(2) : "0.00");

    //CALCULO DE VALOR NETO PARA COMPRAS
    var NetoCompra=0;
    $('.valorneto2').each(function() {  
    NetoCompra += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    });  

    //CALCULO DE SUBTOTAL CON IVA
    var BaseImpIva1=0;
    $('.subtotalivasi').each(function() {  
    BaseImpIva1 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtsubtotal').val(BaseImpIva1.toFixed(2));
    $('#lblsubtotal').text(BaseImpIva1.toFixed(2));

    //CALCULO DE SUBTOTAL SIN IVA
    var BaseImpIva2=0;
    $('.subtotalivano').each(function() {  
    BaseImpIva2 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtsubtotal2').val(BaseImpIva2.toFixed(2));
    $('#lblsubtotal2').text(BaseImpIva2.toFixed(2));

    //CALCULO DE TOTAL IVA
    var TotalIva = BaseImpIva1 * ivg / 100;
    $('#txtIva').val(TotalIva.toFixed(2));
    $('#lbliva').text(TotalIva.toFixed(2));

    //CALCULO DE TOTAL DESCONTADO
    var TotalDescontado=0;
    $('.totaldescuentov').each(function() {  
    TotalDescontado += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    });
    $('#txtdescontado').val(TotalDescontado.toFixed(2));
    $('#lbldescontado').text(TotalDescontado.toFixed(2)); 

    //CALCULAMOS DESCUENTO POR PRODUCTO
    desc2  = desc/100;

    //CALCULO DEL TOTAL DE FACTURA
    var Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIva);
    SubTotal = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2);
    TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
    TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));

    $('#txtTotal').val(TotalFactura.toFixed(2));
    $('#txtTotalCompra').val(NetoCompra.toFixed(2));
    $('#lbltotal').text(TotalFactura.toFixed(2));
}


// FUNCION PARA AGREGAR DETALLES A VENTAS
function AgregaDetalleVenta(codventa,codsucursal,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Agregar Detalles de Productos a esta Venta?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Continuar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forventa?codventa="+codventa+"&codsucursal="+codsucursal+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}


/////FUNCION PARA ELIMINAR DETALLES DE VENTAS EN VENTANA MODAL
function EliminarDetallesVentaModal(coddetalleventa,codventa,codcliente,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Venta?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetalleventa="+coddetalleventa+"&codventa="+codventa+"&codcliente="+codcliente+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#muestraventamodal').load("funciones.php?BuscaVentaModal=si&codventa="+codventa+"&codsucursal="+codsucursal); 
            $('#ventas').load("consultas.php?CargaVentas=si");    
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Ventas en este Módulo, realice la Eliminación completa de la Venta!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Ventas, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}


/////FUNCION PARA ELIMINAR DETALLES DE VENTAS EN ACTUALIZAR
function EliminarDetallesVentaUpdate(coddetalleventa,codventa,codcliente,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Venta?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetalleventa="+coddetalleventa+"&codventa="+codventa+"&codcliente="+codcliente+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#detallesventasupdate').load("funciones.php?MuestraDetallesVentasUpdate=si&codventa="+codventa+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Ventas en este Módulo, realice la Eliminación completa de la Venta!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Ventas, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR DETALLES DE VENTAS EN AGREGAR
function EliminarDetallesVentaAgregar(coddetalleventa,codventa,codcliente,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Venta?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetalleventa="+coddetalleventa+"&codventa="+codventa+"&codcliente="+codcliente+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#detallesventasagregar').load("funciones.php?MuestraDetallesVentasAgregar=si&codventa="+codventa+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Ventas en este Módulo, realice la Eliminación completa de la Venta!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Ventas, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR VENTAS 
function EliminarVenta(codventa,codcliente,codsucursal,criterio,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Venta?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codventa="+codventa+"&codcliente="+codcliente+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#muestraventas').load("search.php?CargaVentas=si&bventas="+criterio);
            //$('#ventas').load("consultas.php?CargaVentas=si");
                  
          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Ventas de Productos, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}


//FUNCION PARA BUSQUEDA DE VENTAS POR CAJAS Y FECHAS
function BuscarVentasxCajas(){
                  
$('#muestraventasxcajas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codcaja = $("#codcaja").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#ventasxcajas").serialize();
var url = 'funciones.php?BuscaVentasxCajas=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestraventasxcajas').empty();
                $('#muestraventasxcajas').append(''+response+'').fadeIn("slow");
               }
      }); 
}

// FUNCION PARA BUSQUEDA DE VENTAS POR FECHAS
function BuscarVentasxFechas(){
                        
$('#muestraventasxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();                
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#ventasxfechas").serialize();
var url = 'funciones.php?BuscaVentasxFechas=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestraventasxfechas').empty();
                $('#muestraventasxfechas').append(''+response+'').fadeIn("slow");
             }
      });
}

//FUNCION PARA BUSQUEDA DE VENTAS POR CLIENTES Y FECHAS
function BuscarVentasxClientes(){
                  
$('#muestraventasxclientes').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codcliente = $("input#codcliente").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#ventasxclientes").serialize();
var url = 'funciones.php?BuscaVentasxClientes=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestraventasxclientes').empty();
                $('#muestraventasxclientes').append(''+response+'').fadeIn("slow");
                
               }
      }); 
}

// FUNCION PARA BUSQUEDA DE COMISION POR VENDEDOR
function BuscaComisionxVentas(){
    
$('#muestracomisionxventas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codigo = $("#codigo").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#comisionxventas").serialize();
var url = 'funciones.php?BuscaComisionxVentas=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestracomisionxventas').empty();
                $('#muestracomisionxventas').append(''+response+'').fadeIn("slow");
            }
      }); 
}

// FUNCION PARA BUSQUEDA DE DETALLES VENTAS X FECHAS
function BuscaDetallesVentasxFechas(){
    
$('#muestradetallesventasxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#detallesventasxfechas").serialize();
var url = 'funciones.php?BuscaDetallesVentasxFechas=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestradetallesventasxfechas').empty();
                $('#muestradetallesventasxfechas').append(''+response+'').fadeIn("slow");
            }
      }); 
}


// FUNCION PARA BUSQUEDA DE DETALLES VENTAS X VENDEDOR
function BuscaDetallesVentasxVendedor(){
    
$('#muestradetallesventasxvendedor').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codigo = $("#codigo").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#detallesventasxvendedor").serialize();
var url = 'funciones.php?BuscaDetallesVentasxVendedor=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestradetallesventasxvendedor').empty();
                $('#muestradetallesventasxvendedor').append(''+response+'').fadeIn("slow");
            }
      }); 
}













/////////////////////////////////// FUNCIONES DE CREDITOS //////////////////////////////////////

// FUNCION PARA MOSTRAR VENTA DE CREDITO EN VENTANA MODAL
function VerCredito(codventa,codsucursal){

$('#muestracreditomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaCreditoModal=si&codventa='+codventa+"&codsucursal="+codsucursal;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestracreditomodal').empty();
                $('#muestracreditomodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA ABONAR PAGO A CREDITOS #1
function AbonoCreditoVenta1(codsucursal,codcliente,codventa,dnicliente,nomcliente,nroventa,totalfactura,fechaventa,totaldebe,totalabono) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#saveabonosventas #codsucursal").val(codsucursal);
  $("#saveabonosventas #codcliente").val(codcliente);
  $("#saveabonosventas #codventa").val(codventa);
  $("#saveabonosventas #dnicliente").val(dnicliente);
  $("#saveabonosventas #nomcliente").val(nomcliente);
  $("#saveabonosventas #nroventa").val(nroventa);
  $("#saveabonosventas #totalfactura").val(totalfactura);
  $("#saveabonosventas #fechaventa").val(fechaventa);
  $("#saveabonosventas #totaldebe").val(totaldebe);
  $("#saveabonosventas #debe").val(totaldebe);
  $("#saveabonosventas #totalabono").val(totalabono);
  $("#saveabonosventas #abono").val(totalabono);
}

// FUNCION PARA ABONAR PAGO A CREDITOS #2
function AbonoCreditoVenta2(codsucursal,codcliente,codventa,dnicliente,nomcliente,nroventa,totalfactura,fechaventa,totaldebe,totalabono) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#saveabonoscliente #codsucursal").val(codsucursal);
  $("#saveabonoscliente #codcliente").val(codcliente);
  $("#saveabonoscliente #codventa").val(codventa);
  $("#saveabonoscliente #dnicliente").val(dnicliente);
  $("#saveabonoscliente #nomcliente").val(nomcliente);
  $("#saveabonoscliente #nroventa").val(nroventa);
  $("#saveabonoscliente #totalfactura").val(totalfactura);
  $("#saveabonoscliente #fechaventa").val(fechaventa);
  $("#saveabonoscliente #totaldebe").val(totaldebe);
  $("#saveabonoscliente #debe").val(totaldebe);
  $("#saveabonoscliente #totalabono").val(totalabono);
  $("#saveabonoscliente #abono").val(totalabono);
}

// FUNCION PARA ABONAR PAGO A CREDITOS #3
function AbonoCreditoVenta3(codsucursal,codcliente,codventa,dnicliente,nomcliente,nroventa,totalfactura,fechaventa,totaldebe,totalabono,inicio,fin) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#saveabonosfechas #codsucursal").val(codsucursal);
  $("#saveabonosfechas #codcliente").val(codcliente);
  $("#saveabonosfechas #codventa").val(codventa);
  $("#saveabonosfechas #dnicliente").val(dnicliente);
  $("#saveabonosfechas #nomcliente").val(nomcliente);
  $("#saveabonosfechas #nroventa").val(nroventa);
  $("#saveabonosfechas #totalfactura").val(totalfactura);
  $("#saveabonosfechas #fechaventa").val(fechaventa);
  $("#saveabonosfechas #totaldebe").val(totaldebe);
  $("#saveabonosfechas #debe").val(totaldebe);
  $("#saveabonosfechas #totalabono").val(totalabono);
  $("#saveabonosfechas #abono").val(totalabono);
  $("#saveabonosfechas #inicio").val(inicio);
  $("#saveabonosfechas #fin").val(fin);
}

// FUNCION PARA ABONAR PAGO A CREDITOS #4
function AbonoCreditoVenta4(codsucursal,codcliente,codventa,dnicliente,nomcliente,nroventa,totalfactura,fechaventa,totaldebe,totalabono,inicio,fin) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#saveabonosdetalles #codsucursal").val(codsucursal);
  $("#saveabonosdetalles #codcliente").val(codcliente);
  $("#saveabonosdetalles #codventa").val(codventa);
  $("#saveabonosdetalles #dnicliente").val(dnicliente);
  $("#saveabonosdetalles #nomcliente").val(nomcliente);
  $("#saveabonosdetalles #nroventa").val(nroventa);
  $("#saveabonosdetalles #totalfactura").val(totalfactura);
  $("#saveabonosdetalles #fechaventa").val(fechaventa);
  $("#saveabonosdetalles #totaldebe").val(totaldebe);
  $("#saveabonosdetalles #debe").val(totaldebe);
  $("#saveabonosdetalles #totalabono").val(totalabono);
  $("#saveabonosdetalles #abono").val(totalabono);
  $("#saveabonosdetalles #inicio").val(inicio);
  $("#saveabonosdetalles #fin").val(fin);
}


//FUNCION PARA BUSQUEDA DE CREDITOS POR CLIENTES Y FECHAS
function BuscarCreditosxClientes(){
                  
$('#muestracreditosxclientes').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var cliente = $("#cliente").val();
var dataString = $("#creditosxclientes").serialize();
var url = 'funciones.php?BuscaCreditosxClientes=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestracreditosxclientes').empty();
                $('#muestracreditosxclientes').append(''+response+'').fadeIn("slow");
               }
      }); 
}

// FUNCION PARA BUSQUEDA DE CREDITOS POR FECHAS
function BuscarCreditosxFechas(){
                        
$('#muestracreditosxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();                
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#creditosxfechas").serialize();
var url = 'funciones.php?BuscaCreditosxFechas=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestracreditosxfechas').empty();
                $('#muestracreditosxfechas').append(''+response+'').fadeIn("slow");
             }
      });
}

// FUNCION PARA BUSQUEDA DE CREDITOS POR DETALLES
function BuscarCreditosxDetalles(){
                        
$('#muestracreditosxdetalles').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codcliente = $("#codcliente").val();                
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#creditosxdetalles").serialize();
var url = 'funciones.php?BuscaCreditosxDetalles=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestracreditosxdetalles').empty();
                $('#muestracreditosxdetalles').append(''+response+'').fadeIn("slow");
             }
      });
}

























/////////////////////////////////// FUNCIONES DE NOTAS DE CREDITO //////////////////////////////////////

// FUNCION PARA CALCULAR DETALLES VENTAS PARA NOTA DE CREDITO
function ProcesarCalculoDevolucion(indice){

    var devuelto = $('#devuelto_'+indice).val();
    var cantidad = $('#cantidad_'+indice).val();
    var preciocompra = $('#preciocompra_'+indice).val();
    var precioventa = $('#precioventa_'+indice).val();
    var valortotal = $('#valortotal_'+indice).val();
    var neto = $('#valorneto_'+indice).val();
    var descproducto = $('#descproducto_'+indice).val();
    var ivaproducto = $('#ivaproducto_'+indice).val();
    var ivg = $('#iva').val();
    var desc = $('#descuento').val();
    var ValorNeto = 0;

    if (devuelto > cantidad) {

        $("#devuelto_"+indice).val("0");
        $("#devuelto_"+indice).focus();
        $("#devuelto").css('border-color', '#f0ad4e');
        swal("Oops", "LA DEVOLUCIÓN NO PUEDE SER MAYOR QUE LA CANTIDAD!", "error");
        return false;
    }

    //REALIZAMOS LA MULTIPLICACION DE PRECIO VENTA * CANTIDAD
    var ValorTotal = parseFloat(devuelto) * parseFloat(precioventa);

    //CALCULO DEL TOTAL DEL DESCUENTO %
    var Descuento = ValorTotal * descproducto / 100;
    var ValorNeto = parseFloat(ValorTotal) - parseFloat(Descuento);

    //CALCULO VALOR TOTAL
    $("#valortotal_"+indice).val(ValorTotal.toFixed(2));
    $("#txtvalortotal_"+indice).text(ValorTotal.toFixed(2));

    //CALCULO TOTAL DESCUENTO
    $("#totaldescuentov_"+indice).val(Descuento.toFixed(2));
    $("#txtdescproducto_"+indice).text(Descuento.toFixed(2));

    //CALCULO VALOR NETO
    $("#valorneto_"+indice).val(ValorNeto.toFixed(2));
    $("#txtvalorneto_"+indice).text(ValorNeto.toFixed(2));

    //CALCULO SUBTOTAL IVA SI
    $("#subtotalivasi_"+indice).val(ivaproducto == "SI" ? ValorNeto.toFixed(2) : "0.00");
    //CALCULO SUBTOTAL IVA NO
    $("#subtotalivano_"+indice).val(ivaproducto == "NO" ? ValorNeto.toFixed(2) : "0.00"); 

    //CALCULO DE SUBTOTAL CON IVA
    var BaseImpIva1=0;
    $('.subtotalivasi').each(function() {  
    BaseImpIva1 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtsubtotal').val(BaseImpIva1.toFixed(2));
    $('#lblsubtotal').text(BaseImpIva1.toFixed(2));

    //CALCULO DE SUBTOTAL SIN IVA
    var BaseImpIva2=0;
    $('.subtotalivano').each(function() {  
    BaseImpIva2 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtsubtotal2').val(BaseImpIva2.toFixed(2));
    $('#lblsubtotal2').text(BaseImpIva2.toFixed(2));

    //CALCULO DE TOTAL IVA
    var TotalIva = BaseImpIva1 * ivg / 100;
    $('#txtIva').val(TotalIva.toFixed(2));
    $('#lbliva').text(TotalIva.toFixed(2));

    //CALCULO DE TOTAL DESCONTADO
    var TotalDescontado=0;
    $('.totaldescuentov').each(function() {  
    TotalDescontado += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    });
    $('#txtdescontado').val(TotalDescontado.toFixed(2));
    $('#lbldescontado').text(TotalDescontado.toFixed(2)); 

    //CALCULAMOS DESCUENTO POR PRODUCTO
    desc2  = desc/100;

    //CALCULO DEL TOTAL DE FACTURA
    var Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIva);
    TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
    TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));

    $('#txtTotal').val(TotalFactura.toFixed(2));
    $('#lbltotal').text(TotalFactura.toFixed(2));

}


// FUNCION PARA BUSQUEDA DE FACTURA PARA NOTA DE CREDITO
function BuscarFactura(){
                        
$('#muestrafactura').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var codsucursal = $("input#codsucursal").val();
var codventa = $("input#codventa").val();
var status = $('input:radio[name=descontar]:checked').val();
var codarqueo = $("input#codarqueo").val();
var dataString = $("#savenota").serialize();
var url = 'funciones.php?ProcesaNotaCredito=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function(response) {            
        $('#muestrafactura').empty();
        $('#muestrafactura').append(''+response+'').fadeIn("slow");
            
    }
  });
}


//FUNCIONES PARA VERIFICAR NOTA CREDITO
function VerificaDescuentoCaja(){

  var status = $('input:radio[name=descontar]:checked').val();

  if (status == 1 || status == true) {
         
      //deshabilitamos
      $("#codarqueo").attr('disabled', false);

  } else {

      // habilitamos
      $("#codarqueo").attr('disabled', true);
  }
}

// FUNCION PARA MOSTRAR NOTA DE CREDITO EN VENTANA MODAL
function VerNota(codnota,codsucursal){

$('#muestranotamodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaNotaModal=si&codnota='+codnota+"&codsucursal="+codsucursal;

$.ajax({
      type: "GET",
      url: "funciones.php",
      data: dataString,
      success: function(response) {            
          $('#muestranotamodal').empty();
          $('#muestranotamodal').append(''+response+'').fadeIn("slow");
          
      }
  });
}

// FUNCION PARA BUSQUEDA DE NOTAS POR CAJAS
function BuscarNotasxCajas(){
                        
$('#muestranotasxcajas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codcaja = $("#codcaja").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#notasxcajas").serialize();
var url = 'funciones.php?BuscaNotasxCajas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function(response) {            
      $('#muestranotasxcajas').empty();
      $('#muestranotasxcajas').append(''+response+'').fadeIn("slow");  
    }
  });
}

// FUNCION PARA BUSQUEDA DE NOTAS POR CAJAS
function BuscarNotasxCajas(){
                        
$('#muestranotasxcajas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codcaja = $("#codcaja").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#notasxcajas").serialize();
var url = 'funciones.php?BuscaNotasxCajas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function(response) {            
      $('#muestranotasxcajas').empty();
      $('#muestranotasxcajas').append(''+response+'').fadeIn("slow");  
    }
  });
}

// FUNCION PARA BUSQUEDA DE NOTAS POR FECHAS
function BuscarNotasxFechas(){
                        
$('#muestranotasxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#notasxfechas").serialize();
var url = 'funciones.php?BuscaNotasxFechas=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestranotasxfechas').empty();
                $('#muestranotasxfechas').append(''+response+'').fadeIn("slow");
                
             }
      });
}

// FUNCION PARA BUSQUEDA DE NOTAS POR CLIENTE
function BuscarNotasxClientes(){
                        
$('#muestranotasxclientes').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var codsucursal = $("#codsucursal").val();
var codcliente = $("input#codcliente").val();
var dataString = $("#notasxclientes").serialize();
var url = 'funciones.php?BuscaNotasxClientes=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestranotasxclientes').empty();
                $('#muestranotasxclientes').append(''+response+'').fadeIn("slow");
                
             }
      });
}