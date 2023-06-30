<?php
session_start();
require_once("classconexion.php");

class conectorDB extends Db
{
	public function __construct()
    {
        parent::__construct();
    } 	
	
	public function EjecutarSentencia($consulta, $valores = array()){  //funcion principal, ejecuta todas las consultas
		$resultado = false;
		
		if($statement = $this->dbh->prepare($consulta)){  //prepara la consulta
			if(preg_match_all("/(:\w+)/", $consulta, $campo, PREG_PATTERN_ORDER)){ //tomo los nombres de los campos iniciados con :xxxxx
				$campo = array_pop($campo); //inserto en un arreglo
				foreach($campo as $parametro){
					$statement->bindValue($parametro, $valores[substr($parametro,1)]);
				}
			}
			try {
				if (!$statement->execute()) { //si no se ejecuta la consulta...
					print_r($statement->errorInfo()); //imprimir errores
					return false;
				}
				$resultado = $statement->fetchAll(PDO::FETCH_ASSOC); //si es una consulta que devuelve valores los guarda en un arreglo.
				$statement->closeCursor();
			}
			catch(PDOException $e){
				echo "Error de ejecución: \n";
				print_r($e->getMessage());
			}	
		}
		return $resultado;
		$this->dbh = null; //cerramos la conexión
	} /// Termina funcion consultarBD
}/// Termina clase conectorDB

class Json
{
	private $json;

	################################ BUSQUEDA DE MARCAS ################################
	public function BuscaMarcas($filtro){
    $consulta = "SELECT CONCAT(nommarca) as label, codmarca FROM marcas WHERE CONCAT(nommarca) LIKE '%".$filtro."%' ORDER BY codmarca ASC LIMIT 0,10";
			$conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}
	################################ BUSQUEDA DE MARCAS ################################
	
	################################ BUSQUEDA DE MODELOS ################################
	public function BuscaModelos($filtro){
    $consulta = "SELECT CONCAT(nommodelo) as label, codmodelo FROM modelos WHERE CONCAT(nommodelo) LIKE '%".$filtro."%' GROUP BY nommodelo ORDER BY codmodelo ASC LIMIT 0,10";
			$conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}
	################################ BUSQUEDA DE MODELOS ################################


	################################ BUSQUEDA DE PRODUCTOS PARA COMPRAS ################################
	public function BuscaProductoC($filtro){

if ($_SESSION["acceso"]=="administradorG") {

    $consulta = "SELECT CONCAT(productos.codproducto, ' | ',productos.producto, ' | MARCA(',marcas.nommarca, ') | MODELO(',if(productos.codmodelo='0','***',modelos.nommodelo), ')') as label, productos.codproducto, productos.producto, productos.fabricante, productos.codfamilia, productos.codsubfamilia, productos.codmarca, productos.codmodelo, productos.codpresentacion, productos.codorigen, ROUND(productos.preciocompra, 2) preciocompra, ROUND(productos.precioxmenor, 2) precioxmenor, ROUND(productos.precioxmayor, 2) precioxmayor, ROUND(productos.precioxpublico, 2) precioxpublico, productos.existencia, productos.ivaproducto, ROUND(productos.descproducto, 2) descproducto, marcas.nommarca, modelos.nommodelo FROM productos INNER JOIN marcas ON productos.codmarca=marcas.codmarca LEFT JOIN modelos ON productos.codmodelo = modelos.codmodelo WHERE CONCAT(codproducto, '',producto, '',nommarca, '',codigobarra) LIKE '%".$filtro."%' GROUP BY codproducto ASC LIMIT 0,15";
    $conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;

		} else {

    $consulta = "SELECT CONCAT(productos.codproducto, ' | ',productos.producto, ' | MARCA(',marcas.nommarca, ') | MODELO(',if(productos.codmodelo='0','***',modelos.nommodelo), ')') as label, productos.codproducto, productos.producto, productos.fabricante, productos.codfamilia, productos.codsubfamilia, productos.codmarca, productos.codmodelo, productos.codpresentacion, productos.codorigen, ROUND(productos.preciocompra, 2) preciocompra, ROUND(productos.precioxmenor, 2) precioxmenor, ROUND(productos.precioxmayor, 2) precioxmayor, ROUND(productos.precioxpublico, 2) precioxpublico, productos.existencia, productos.ivaproducto, ROUND(productos.descproducto, 2) descproducto, marcas.nommarca, modelos.nommodelo FROM productos INNER JOIN marcas ON productos.codmarca=marcas.codmarca LEFT JOIN modelos ON productos.codmodelo = modelos.codmodelo WHERE CONCAT(codproducto, '',producto, '',nommarca, '',codigobarra) LIKE '%".$filtro."%' AND productos.codsucursal= '".strip_tags($_SESSION["codsucursal"])."' GROUP BY codproducto, codsucursal ASC LIMIT 0,15";
        $conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;

	    }
	}
	################################ BUSQUEDA DE PRODUCTOS PARA COMPRAS ################################

	################################ BUSQUEDA DE PRODUCTOS POR CODIGO DE BARRA ################################
	public function BuscaProductoBarCode($filtro){

if ($_SESSION["acceso"]=="administradorG") {

    $consulta = "SELECT 
    CONCAT(productos.codproducto, ' | ',productos.producto, ' | MARCA(',marcas.nommarca, ') | MODELO(',if(productos.codmodelo='0','***',modelos.nommodelo), ')') as label, productos.idproducto, productos.codproducto, productos.producto, productos.fabricante, productos.codfamilia, productos.codsubfamilia, productos.codmarca, productos.codmodelo, productos.codpresentacion, productos.codorigen, ROUND(productos.preciocompra, 2) preciocompra, ROUND(productos.precioxmenor, 2) precioxmenor, ROUND(productos.precioxmayor, 2) precioxmayor, ROUND(productos.precioxpublico, 2) precioxpublico, productos.existencia, productos.ivaproducto, ROUND(productos.descproducto, 2) descproducto, productos.fechaelaboracion, productos.fechaoptimo, productos.fechamedio, productos.fechaminimo, marcas.nommarca, modelos.nommodelo, presentaciones.nompresentacion FROM productos INNER JOIN marcas ON productos.codmarca=marcas.codmarca LEFT JOIN modelos ON productos.codmodelo = modelos.codmodelo LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion WHERE codigobarra='".$filtro."' GROUP BY codproducto ASC LIMIT 0,15";
        $conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;

		} else {

    $consulta = "SELECT 
    CONCAT(productos.codproducto, ' | ',productos.producto, ' | MARCA(',marcas.nommarca, ') | MODELO(',if(productos.codmodelo='0','***',modelos.nommodelo), ')') as label, productos.idproducto, productos.codproducto, productos.producto, productos.fabricante, productos.codfamilia, productos.codsubfamilia, productos.codmarca, productos.codmodelo, productos.codpresentacion, productos.codorigen, ROUND(productos.preciocompra, 2) preciocompra, ROUND(productos.precioxmenor, 2) precioxmenor, ROUND(productos.precioxmayor, 2) precioxmayor, ROUND(productos.precioxpublico, 2) precioxpublico, productos.existencia, productos.ivaproducto, ROUND(productos.descproducto, 2) descproducto, productos.fechaelaboracion, productos.fechaoptimo, productos.fechamedio, productos.fechaminimo, marcas.nommarca, modelos.codmodelo, modelos.nommodelo, presentaciones.nompresentacion FROM productos INNER JOIN marcas ON productos.codmarca=marcas.codmarca LEFT JOIN modelos ON modelos.codmodelo = productos.codmodelo LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion WHERE codigobarra= '$filtro' AND productos.codsucursal= '".strip_tags($_SESSION["codsucursal"])."' GROUP BY codproducto, codsucursal ASC LIMIT 0,15";
        $conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;

	    }
	}
	################################ BUSQUEDA DE PRODUCTOS POR CODIGO DE BARRA ################################

	################################ BUSQUEDA DE PRODUCTOS PARA VENTAS ################################
	public function BuscaProductoV($filtro){

if ($_SESSION["acceso"]=="administradorG") {

    $consulta = "SELECT 
    CONCAT(productos.codproducto, ' | ',productos.producto, ' | MARCA(',marcas.nommarca, ') | MODELO(',if(productos.codmodelo='0','***',modelos.nommodelo), ')') as label, productos.idproducto, productos.codproducto, productos.producto, productos.fabricante, productos.codfamilia, productos.codsubfamilia, productos.codmarca, productos.codmodelo, productos.codpresentacion, productos.codorigen, ROUND(productos.preciocompra, 2) preciocompra, ROUND(productos.precioxmenor, 2) precioxmenor, ROUND(productos.precioxmayor, 2) precioxmayor, ROUND(productos.precioxpublico, 2) precioxpublico, productos.existencia, productos.ivaproducto, ROUND(productos.descproducto, 2) descproducto, productos.fechaelaboracion, productos.fechaoptimo, productos.fechamedio, productos.fechaminimo, marcas.nommarca, modelos.nommodelo, presentaciones.nompresentacion FROM productos INNER JOIN marcas ON productos.codmarca=marcas.codmarca LEFT JOIN modelos ON productos.codmodelo = modelos.codmodelo LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion WHERE CONCAT(codproducto, '',producto, '',nommarca, '',codigobarra) LIKE '%".$filtro."%' GROUP BY codproducto ASC LIMIT 0,15";
        $conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;

		} else {

    $consulta = "SELECT 
    CONCAT(productos.codproducto, ' | ',productos.producto, ' | MARCA(',marcas.nommarca, ') | MODELO(',if(productos.codmodelo='0','***',modelos.nommodelo), ')') as label, productos.idproducto, productos.codproducto, productos.producto, productos.fabricante, productos.codfamilia, productos.codsubfamilia, productos.codmarca, productos.codmodelo, productos.codpresentacion, productos.codorigen, ROUND(productos.preciocompra, 2) preciocompra, ROUND(productos.precioxmenor, 2) precioxmenor, ROUND(productos.precioxmayor, 2) precioxmayor, ROUND(productos.precioxpublico, 2) precioxpublico, productos.existencia, productos.ivaproducto, ROUND(productos.descproducto, 2) descproducto, productos.fechaelaboracion, productos.fechaoptimo, productos.fechamedio, productos.fechaminimo, marcas.nommarca, modelos.codmodelo, modelos.nommodelo, presentaciones.nompresentacion FROM productos INNER JOIN marcas ON productos.codmarca=marcas.codmarca LEFT JOIN modelos ON modelos.codmodelo = productos.codmodelo LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion WHERE CONCAT(codproducto, '',producto, '',nommarca, '',codigobarra) LIKE '%".$filtro."%' AND productos.codsucursal= '".strip_tags($_SESSION["codsucursal"])."' GROUP BY codproducto, codsucursal ASC LIMIT 0,15";
        $conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;

	    }
	}
	################################ BUSQUEDA DE PRODUCTOS PARA VENTAS ################################

	################################ BUSQUEDA DE CLIENTES ################################
	public function BuscaClientes($filtro){
		$consulta = "SELECT
	CONCAT(if(clientes.documcliente='0','DOCUMENTO',documentos.documento), ': ',clientes.dnicliente, ': ',clientes.nomcliente) as label,  
	clientes.codcliente, 
	clientes.tipocliente,
	clientes.nomcliente,
	clientes.razoncliente,
	clientes.limitecredito,
	ROUND(SUM(if(pag.montocredito!='0',clientes.limitecredito-pag.montocredito,clientes.limitecredito)), 2) creditodisponible
    FROM
       clientes 
     LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
     LEFT JOIN
       (SELECT
           codcliente, montocredito       
           FROM creditosxclientes WHERE codsucursal = '".strip_tags($_SESSION['codsucursal'])."') pag ON pag.codcliente = clientes.codcliente
           WHERE CONCAT(clientes.dnicliente, '',clientes.nomcliente) LIKE '%".$filtro."%' 
           GROUP BY clientes.codcliente ASC LIMIT 0,10";
		$conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}
	################################ BUSQUEDA DE CLIENTES ################################

	################################ BUSQUEDA DE FACTURAS ################################
	public function BuscaFactura($filtro){
		$consulta = "SELECT CONCAT(tipodocumento, ' Nº ',codfactura, ': ',if(ventas.codcliente='0','CONSUMIDOR FINAL',if(clientes.nomcliente='',clientes.nomcliente,clientes.nomcliente))) as label, idventa, codventa, codfactura FROM ventas LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente WHERE CONCAT(ventas.tipodocumento, ventas.codventa) LIKE '%".$filtro."%' AND ventas.notacredito != 1 ORDER BY ventas.idventa ASC LIMIT 0,10";
		$conexion = new conectorDB();
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}
	################################ BUSQUEDA DE FACTURAS ################################

}/// TERMINA CLASE  ///
?>