<?php
//CARRITO DE ENTRADAS DE PRODUCTOS
session_start();
$ObjetoCarrito   = json_decode($_POST['MiCarrito']);
if ($ObjetoCarrito->Codigo=="vaciar") {
    unset($_SESSION["CarritoPreventa"]);
} else {
    if (isset($_SESSION['CarritoPreventa'])) {
        $carrito=$_SESSION['CarritoPreventa'];
        if (isset($ObjetoCarrito->Codigo)) {
            $id = $ObjetoCarrito->Id;
            $txtCodigo = $ObjetoCarrito->Codigo;
            $producto= $ObjetoCarrito->Producto;
            $codmarca = $ObjetoCarrito->Codmarca;
            $marcas = $ObjetoCarrito->Marcas;
            $codmodelo = $ObjetoCarrito->Codmodelo;
            $modelos = $ObjetoCarrito->Modelos;
            $codpresentacion = $ObjetoCarrito->Codpresentacion;
            $presentacion = $ObjetoCarrito->Presentacion;
            $precio = $ObjetoCarrito->Precio;
            $precio2 = $ObjetoCarrito->Precio2;
            $descproducto = $ObjetoCarrito->Descproducto;
            $ivaproducto = $ObjetoCarrito->Ivaproducto;
            $existencia = $ObjetoCarrito->Existencia;
            $precioconiva = $ObjetoCarrito->Precioconiva;
            $tipodetalle = $ObjetoCarrito->TipoDetalle;
            $cantidad = $ObjetoCarrito->Cantidad;
            $opCantidad = $ObjetoCarrito->opCantidad;

            //array_search("whatisearchfor2", array_column(array_column($response, "types"), 0));
            //$donde  = array_search($txtCodigo, array_column($carrito, 'txtCodigo'));

            if($tipodetalle == 1){
                $donde  = array_search($txtCodigo, array_column($carrito, 'txtCodigo'));
            } else {
                $donde  = array_search($producto, array_column($carrito, 'producto'));
            }

            if ($donde !== FALSE) {
                if ($opCantidad === '=') {
                    $cuanto = $cantidad;
                } else {
                    $cuanto = $carrito[$donde]['cantidad'] + $cantidad;
                }
                $carrito[$donde] = array(
                    "id"=>$id,
                    "txtCodigo"=>$txtCodigo,
                    "producto"=>$producto,
                    "codmarca"=>$codmarca,
                    "marcas"=>$marcas,
                    "codmodelo"=>$codmodelo,
                    "modelos"=>$modelos,
                    "codpresentacion"=>$codpresentacion,
                    "presentacion"=>$presentacion,
                    "precio"=>$precio,
                    "precio2"=>$precio2,
                    "descproducto"=>$descproducto,
                    "ivaproducto"=>$ivaproducto,
                    "existencia"=>$existencia,
                    "precioconiva"=>$precioconiva,
                    "tipodetalle"=>$tipodetalle,
                    "cantidad"=>$cuanto
                );
            } else {
                $carrito[]=array(
                    "id"=>$id,
                    "txtCodigo"=>$txtCodigo,
                    "producto"=>$producto,
                    "codmarca"=>$codmarca,
                    "marcas"=>$marcas,
                    "codmodelo"=>$codmodelo,
                    "modelos"=>$modelos,
                    "codpresentacion"=>$codpresentacion,
                    "presentacion"=>$presentacion,
                    "precio"=>$precio,
                    "precio2"=>$precio2,
                    "descproducto"=>$descproducto,
                    "ivaproducto"=>$ivaproducto,
                    "existencia"=>$existencia,
                    "precioconiva"=>$precioconiva,
                    "tipodetalle"=>$tipodetalle,
                    "cantidad"=>$cantidad
                );
            }
        }
    } else {
        $id = $ObjetoCarrito->Id;
        $txtCodigo = $ObjetoCarrito->Codigo;
        $producto = $ObjetoCarrito->Producto;
        $codmarca = $ObjetoCarrito->Codmarca;
        $marcas = $ObjetoCarrito->Marcas;
        $codmodelo = $ObjetoCarrito->Codmodelo;
        $modelos = $ObjetoCarrito->Modelos;
        $codpresentacion = $ObjetoCarrito->Codpresentacion;
        $presentacion = $ObjetoCarrito->Presentacion;
        $precio = $ObjetoCarrito->Precio;
        $precio2 = $ObjetoCarrito->Precio2;
        $descproducto = $ObjetoCarrito->Descproducto;
        $ivaproducto = $ObjetoCarrito->Ivaproducto;
        $existencia = $ObjetoCarrito->Existencia;
        $precioconiva = $ObjetoCarrito->Precioconiva;
        $tipodetalle = $ObjetoCarrito->TipoDetalle;
        $cantidad = $ObjetoCarrito->Cantidad;
        $carrito[] = array(
            "id"=>$id,
            "txtCodigo"=>$txtCodigo,
            "producto"=>$producto,
            "codmarca"=>$codmarca,
            "marcas"=>$marcas,
            "codmodelo"=>$codmodelo,
            "modelos"=>$modelos,
            "codpresentacion"=>$codpresentacion,
            "presentacion"=>$presentacion,
            "precio"=>$precio,
            "precio2"=>$precio2,
            "descproducto"=>$descproducto,
            "ivaproducto"=>$ivaproducto,
            "existencia"=>$existencia,
            "precioconiva"=>$precioconiva,
            "tipodetalle"=>$tipodetalle,
            "cantidad"=>$cantidad
        );
    }
    $carrito = array_values(
        array_filter($carrito, function($v) {
            return $v['cantidad'] > 0;
        })
    );
    $_SESSION['CarritoPreventa'] = $carrito;
    echo json_encode($_SESSION['CarritoPreventa']);
}
