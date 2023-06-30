<?php
session_start();
require_once("classconexion.php");
include_once('funciones_basicas.php');
include "class.phpmailer.php";
include "class.smtp.php";

// Motrar todos los errores de PHP
//error_reporting(0);
error_reporting(E_ALL);
// Motrar todos los errores de PHP
ini_set('display_errors', '1');

//evita el error Fatal error: Allowed memory size of X bytes exhausted (tried to allocate Y bytes)...
ini_set('memory_limit', '-1'); 
// es lo mismo que set_time_limit(300) ;
ini_set('max_execution_time', 3800); 

################################## CLASE LOGIN ###################################
class Login extends Db
{

public function __construct()
{
	parent::__construct();
} 	

###################### FUNCION PARA EXPIRAR SESSION POR INACTIVIDAD ####################
public function ExpiraSession()
{

	/*if(!isset($_SESSION['usuario'])){// Esta logeado?.
		header("Location: logout.php"); 
	}

	//Verifico el tiempo si esta seteado, caso contrario lo seteo.
	if(isset($_SESSION['time'])){
		$tiempo = $_SESSION['time'];
	}else{
		$tiempo = strtotime(date("Y-m-d H:i:s"));
	}

	$inactividad =7200; //(1 hora de cierre sesion )600 equivale a 10 minutos

	$actual =  strtotime(date("Y-m-d H:i:s"));

	if( ($actual-$tiempo) >= $inactividad){
		?>					
		<script type='text/javascript' language='javascript'>
			alert('SU SESSION A EXPIRADO \nPOR FAVOR LOGUEESE DE NUEVO PARA ACCEDER AL SISTEMA') 
			document.location.href='logout'	 
		</script> 
		<?php

	} else {

		$_SESSION['time'] =$actual;
	} */
}
###################### FUNCION PARA EXPIRAR SESSION POR INACTIVIDAD ####################


#################### FUNCION PARA ACCEDER AL SISTEMA ####################
public function Logueo()
{
	self::SetNames();
	if(empty($_POST["usuario"]) or empty($_POST["password"]))
	{
		echo "1";
		exit;
	}

	$sql = "SELECT
	usuarios.codigo, 
	usuarios.dni,
	usuarios.nombres,
	usuarios.sexo,
	usuarios.direccion,
	usuarios.telefono,
	usuarios.email,
	usuarios.usuario,
	usuarios.password,
	usuarios.nivel,
	usuarios.status,
	usuarios.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.id_provincia,
	sucursales.id_departamento,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.iniciofactura,
	sucursales.nroactividadsucursal,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.descsucursal,
	sucursales.porcentaje,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda.simbolo,
	provincias.provincia,
	departamentos.departamento
	FROM usuarios LEFT JOIN sucursales ON usuarios.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	WHERE usuarios.usuario = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["usuario"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		echo "2";
		exit;
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[]=$row;
		}

		if (limpiar($row['status'])==0)
		{  
			echo "3";
			exit;
		} 
		elseif (password_verify($_POST["password"], $row['password'])) {
		
		######### DATOS DEL USUARIO ###########
		$_SESSION["codigo"] = $p[0]["codigo"];
		$_SESSION["dni"] = $p[0]["dni"];
		$_SESSION["nombres"] = $p[0]["nombres"];
		$_SESSION["sexo"] = $p[0]["sexo"];
		$_SESSION["direccion"] = $p[0]["direccion"];
		$_SESSION["telefono"] = $p[0]["telefono"];
		$_SESSION["email"] = $p[0]["email"];
		$_SESSION["usuario"] = $p[0]["usuario"];
		$_SESSION["password"] = $p[0]["password"];
		$_SESSION["nivel"] = $p[0]["nivel"];
		$_SESSION["status"] = $p[0]["status"];
		$_SESSION["ingreso"] = limpiar(date("d-m-Y H:i:s A"));

        ######### DATOS DE LA SUCURSAL ###########
		$_SESSION["codsucursal"] = $p[0]["codsucursal"];
		$_SESSION["documsucursal"] = $p[0]["documsucursal"];
		$_SESSION["cuitsucursal"] = $p[0]["cuitsucursal"];
		$_SESSION["nomsucursal"] = $p[0]["nomsucursal"];
		$_SESSION["tlfsucursal"] = $p[0]["tlfsucursal"];
		$_SESSION["id_provincia"] = $p[0]["id_provincia"];
		$_SESSION["provincia"] = $p[0]["provincia"];
		$_SESSION["id_departamento"] = $p[0]["id_departamento"];
		$_SESSION["departamento"] = $p[0]["departamento"];
		$_SESSION["direcsucursal"] = $p[0]["direcsucursal"];
		$_SESSION["correosucursal"] = $p[0]["correosucursal"];
		$_SESSION["nomencargado"] = $p[0]["nomencargado"];
		$_SESSION["descsucursal"] = $p[0]["descsucursal"];
		$_SESSION["porcentaje"] = $p[0]["porcentaje"];
		$_SESSION["documento"] = $p[0]["documento"];
		$_SESSION["documento2"] = $p[0]["documento2"];
		$_SESSION["simbolo"] = $p[0]["simbolo"];

		$query = "INSERT INTO log VALUES (null, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1,$a);
		$stmt->bindParam(2,$b);
		$stmt->bindParam(3,$c);
		$stmt->bindParam(4,$d);
		$stmt->bindParam(5,$e);
		$stmt->bindParam(6,$f);

		$a = limpiar($_SERVER['REMOTE_ADDR']);
		$b = limpiar(date("Y-m-d H:i:s"));
		$c = limpiar($_SERVER['HTTP_USER_AGENT']);
		$d = limpiar($_SERVER['PHP_SELF']);
		$e = limpiar($_POST["usuario"]);
		$f = limpiar($_SESSION["nivel"]== "administradorG" ? "0" : $_SESSION["codsucursal"]);
		$stmt->execute();

		switch($_SESSION["nivel"])
		{
			case 'ADMINISTRADOR(A) GENERAL':
			$_SESSION["acceso"]="administradorG";

			?>

			<script type="text/javascript">
				window.location="panel";
			</script>

			<?php
			break;
			case 'ADMINISTRADOR(A) SUCURSAL':
			$_SESSION["acceso"]="administradorS";

			?>

			<script type="text/javascript">
				window.location="panel";
			</script>

			<?php
			break;
			case 'SECRETARIA':
			$_SESSION["acceso"]="secretaria";

			?>

			<script type="text/javascript">
				window.location="panel";
			</script>

			<?php
			break;
			case 'CAJERO(A)':
			$_SESSION["acceso"]="cajero";
			?>

			<script type="text/javascript">
				window.location="panel";
			</script>
			
			<?php
			break;
			case 'VENDEDOR(A)':
			$_SESSION["acceso"]="vendedor";
			?>

			<script type="text/javascript">
				window.location="panel";
			</script>
			
			<?php
				break;
		    }//end switch

	    } else {

  	    echo "4";
  	    exit;

	   }
    }
}
#################### FUNCION PARA ACCEDER AL SISTEMA ####################



















######################## FUNCION RECUPERAR Y ACTUALIZAR PASSWORD #######################

########################### FUNCION PARA RECUPERAR CLAVE #############################
public function RecuperarPassword()
{
	self::SetNames();
	if(empty($_POST["email"]))
	{
		echo "1";
		exit;
	}

	$sql = " SELECT * FROM usuarios WHERE email = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["email"]));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "2";
		exit;
	}
	else
	{
			
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$pa[] = $row;
		}
		$id = $pa[0]["codigo"];
		$nombres = $pa[0]["nombres"];
		$email = $pa[0]["email"];
		//$password = $pa[0]["password"];
		$pass = strtoupper(generar_clave(10));
	}

	#################### VALIDACION DE ENVIO DE CORREO CON PHPMAILER ####################
	$smtp=new PHPMailer();
	$smtp->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
		)
	);

	# Indicamos que vamos a utilizar un servidor SMTP
	$smtp->IsSMTP();

    # Definimos el formato del correo con UTF-8
	$smtp->CharSet="UTF-8";

    # autenticación contra nuestro servidor smtp
	$smtp->Port = 465;
	$smtp->IsSMTP(); // use SMTP
	$smtp->SMTPAuth   = true;
	$smtp->SMTPSecure = 'ssl';						// enable SMTP authentication
	$smtp->Host       = "smtp.gmail.com";			// sets MAIL as the SMTP server
	$smtp->Username   = "elsaiya@gmail.com";	// MAIL username
	$smtp->Password   = "rubencito18633174";			// MAIL password

	# datos de quien realiza el envio
	$smtp->From       = "elsaiya@gmail.com"; // from mail
	$smtp->FromName   = "SISTEMA PARA LA GESTIÓN DE VENTAS"; // from mail name

	# Indicamos las direcciones donde enviar el mensaje con el formato
	#   "correo"=>"nombre usuario"
	# Se pueden poner tantos correos como se deseen

	# establecemos un limite de caracteres de anchura
	$smtp->WordWrap   = 50; // set word wrap

	# NOTA: Los correos es conveniente enviarlos en formato HTML y Texto para que
	# cualquier programa de correo pueda leerlo.

	# Definimos el contenido HTML del correo
	$contenidoHTML="<head>";
	$contenidoHTML.="<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
	$contenidoHTML.="</head><body>";
	$contenidoHTML.="<b>Recuperación de Contraseña</b>";
	$contenidoHTML.="<p>Nueva Contraseña de Acceso: $pass</p>";
	$contenidoHTML.="</body>\n";

	# Definimos el contenido en formato Texto del correo
	$contenidoTexto= " Recuperación de Contraseña";
	$contenidoTexto.="\n\n";

	# Definimos el subject
	$smtp->Subject= " Recuperación de Contraseña";

	# Adjuntamos el archivo al correo.
	$smtp->AddAttachment("");

	# Indicamos el contenido
	$smtp->AltBody=$contenidoTexto; //Text Body
	$smtp->MsgHTML($contenidoHTML); //Text body HTML

	$smtp->ClearAllRecipients();
	$smtp->AddAddress($email,str_replace(" ", "_",$nombres));

	//$smtp->Send();
	//Enviamos email
	if(!$smtp->Send()) {

	    //Mensaje no pudo ser enviado
	    echo "3";
		exit;

	} else {

	$sql = " UPDATE usuarios set "
	." password = ? "
	." where "
	." codigo = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $password);
	$stmt->bindParam(2, $codigo);

	$codigo = $id;
	$password = password_hash($pass, PASSWORD_DEFAULT);
	$stmt->execute();

	echo "<span class='fa fa-check-square-o'></span> SU NUEVA CLAVE DE ACCESO LE FUE ENVIADA A SU CORREO ELECTRONICO EXITOSAMENTE";
	exit;

   }
	#################### VALIDACION DE ENVIO DE CORREO CON PHPMAILER ####################
	
}	
############################# FUNCION PARA RECUPERAR CLAVE ############################

########################## FUNCION PARA ACTUALIZAR PASSWORD ############################
public function ActualizarPassword()
{
	self::SetNames();
	if(empty($_POST["dni"]))
	{
		echo "1";
		exit;
	}

	if(sha1(md5($_POST["password"]))==$_POST["clave"]){

		echo "2";
		exit;

	} else {
		
		$sql = " UPDATE usuarios set "
		." usuario = ?, "
		." password = ? "
		." where "
		." codigo = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $usuario);
		$stmt->bindParam(2, $password);
		$stmt->bindParam(3, $codigo);	

		$usuario = limpiar($_POST["usuario"]);
		$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
		$codigo = limpiar($_POST["codigo"]);
		$stmt->execute();
		
		echo "<span class='fa fa-check-square-o'></span> SU CLAVE DE ACCESO FUE ACTUALIZADA EXITOSAMENTE, SER&Aacute; EXPULSADO DE SU SESI&Oacute;N Y DEBER&Aacute; DE ACCEDER NUEVAMENTE";
		?>
		<script>
			function redireccionar(){location.href="logout.php";}
			setTimeout ("redireccionar()", 3000);
		</script>
		<?php
		exit;
	}
}
########################## FUNCION PARA ACTUALIZAR PASSWORD  ############################

####################### FUNCION RECUPERAR Y ACTUALIZAR PASSWORD ########################


























########################## FUNCION CONFIGURACION DEL SISTEMA ########################

######################## FUNCION ID CONFIGURACION DEL SISTEMA ########################
public function ConfiguracionPorId()
{
	self::SetNames();
	$sql = " SELECT 
	configuracion.id,
	configuracion.documsucursal,
	configuracion.cuit,
	configuracion.nomsucursal,
	configuracion.tlfsucursal,
	configuracion.correosucursal,
	configuracion.id_provincia,
	configuracion.id_departamento,
	configuracion.direcsucursal,
	configuracion.documencargado,
	configuracion.dniencargado,
	configuracion.nomencargado,
	documentos.documento,
	documentos2.documento AS documento2,
	provincias.provincia,
	departamentos.departamento
	FROM configuracion 
	LEFT JOIN documentos ON configuracion.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON configuracion.documencargado = documentos2.coddocumento 
	LEFT JOIN provincias ON configuracion.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON configuracion.id_departamento = departamentos.id_departamento 
	WHERE configuracion.id = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array('1'));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################## FUNCION ID CONFIGURACION DEL SISTEMA #########################

######################## FUNCION  ACTUALIZAR CONFIGURACION #########################
public function ActualizarConfiguracion()
{

	self::SetNames();
	if(empty($_POST["cuit"]) or empty($_POST["nomsucursal"]) or empty($_POST["tlfsucursal"]))
	{
		echo "1";
		exit;
	}
	$sql = " UPDATE configuracion set "
	." documsucursal = ?, "
	." cuit = ?, "
	." nomsucursal = ?, "
	." tlfsucursal = ?, "
	." correosucursal = ?, "
	." id_provincia = ?, "
	." id_departamento = ?, "
	." direcsucursal = ?, "
	." documencargado = ?, "
	." dniencargado = ?, "
	." nomencargado = ? "
	." where "
	." id = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $documsucursal);
	$stmt->bindParam(2, $cuit);
	$stmt->bindParam(3, $nomsucursal);
	$stmt->bindParam(4, $tlfsucursal);
	$stmt->bindParam(5, $correosucursal);
	$stmt->bindParam(6, $id_provincia);
	$stmt->bindParam(7, $id_departamento);
	$stmt->bindParam(8, $direcsucursal);
	$stmt->bindParam(9, $documencargado);
	$stmt->bindParam(10, $dniencargado);
	$stmt->bindParam(11, $nomencargado);
	$stmt->bindParam(12, $id);

	$documsucursal = limpiar($_POST['documsucursal'] == '' ? "0" : $_POST['documsucursal']);
	$cuit = limpiar($_POST["cuit"]);
	$nomsucursal = limpiar($_POST["nomsucursal"]);
	$tlfsucursal = limpiar($_POST["tlfsucursal"]);
	$correosucursal = limpiar($_POST["correosucursal"]);
	$id_provincia = limpiar($_POST['id_provincia'] == '' ? "0" : $_POST['id_provincia']);
	$id_departamento = limpiar($_POST['id_departamento'] == '' ? "0" : $_POST['id_departamento']);
	$direcsucursal = limpiar($_POST["direcsucursal"]);
	$documencargado = limpiar($_POST["documencargado"]);
	$dniencargado = limpiar($_POST["dniencargado"]);
	$nomencargado = limpiar($_POST["nomencargado"]);
	$id = limpiar($_POST["id"]);
	$stmt->execute();

	##################  SUBIR LOGO PRINCIPAL #1 ######################################
         //datos del arhivo  
if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo =''; }
if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo =''; }
if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo =''; }  
         //compruebo si las características del archivo son las que deseo  
	if ((strpos($tipo_archivo,'image/png')!==false)&&$tamano_archivo<200000) {  
			if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/".$nombre_archivo) && rename("fotos/".$nombre_archivo,"fotos/logo_principal.png"))
			
					{ 
		 ## se puede dar un aviso
					} 
		 ## se puede dar otro aviso 
				}
	##################  FINALIZA SUBIR LOGO PRINCIPAL #1 ##################

	##################  SUBIR LOGO PDF #1 ######################################
         //datos del arhivo  
if (isset($_FILES['imagen2']['name'])) { $nombre_archivo = $_FILES['imagen2']['name']; } else { $nombre_archivo =''; }
if (isset($_FILES['imagen2']['type'])) { $tipo_archivo = $_FILES['imagen2']['type']; } else { $tipo_archivo =''; }
if (isset($_FILES['imagen2']['size'])) { $tamano_archivo = $_FILES['imagen2']['size']; } else { $tamano_archivo =''; }  
         //compruebo si las características del archivo son las que deseo  
	if ((strpos($tipo_archivo,'image/png')!==false)&&$tamano_archivo<200000) {  
			if (move_uploaded_file($_FILES['imagen2']['tmp_name'], "fotos/".$nombre_archivo) && rename("fotos/".$nombre_archivo,"fotos/logo_pdf.png"))
			
					{ 
		 ## se puede dar un aviso
					} 
		 ## se puede dar otro aviso 
				}
	##################  FINALIZA SUBIR LOGO PDF #1 ######################################

	##################  SUBIR LOGO PDF #2 ######################################
         //datos del arhivo  
if (isset($_FILES['imagen3']['name'])) { $nombre_archivo = $_FILES['imagen3']['name']; } else { $nombre_archivo =''; }
if (isset($_FILES['imagen3']['type'])) { $tipo_archivo = $_FILES['imagen3']['type']; } else { $tipo_archivo =''; }
if (isset($_FILES['imagen3']['size'])) { $tamano_archivo = $_FILES['imagen3']['size']; } else { $tamano_archivo =''; }  
         //compruebo si las características del archivo son las que deseo  
	if ((strpos($tipo_archivo,'image/png')!==false)&&$tamano_archivo<200000) {  
			if (move_uploaded_file($_FILES['imagen3']['tmp_name'], "fotos/".$nombre_archivo) && rename("fotos/".$nombre_archivo,"fotos/logo_pdf2.png"))
			
					{ 
		 ## se puede dar un aviso
					} 
		 ## se puede dar otro aviso 
				}
	##################  FINALIZA SUBIR LOGO PDF #2 ######################################

	echo "<span class='fa fa-check-square-o'></span> LOS DATOS DE CONFIGURACI&Oacute;N FUERON ACTUALIZADOS EXITOSAMENTE";
	exit;
}
######################## FUNCION  ACTUALIZAR CONFIGURACION #########################

###################### FIN DE FUNCION CONFIGURACION DEL SISTEMA #######################


























################################## CLASE USUARIOS #####################################

############################## FUNCION REGISTRAR USUARIOS ##############################
public function RegistrarUsuarios()
{
	self::SetNames();
	if(empty($_POST["nombres"]) or empty($_POST["usuario"]) or empty($_POST["password"]))
	{
		echo "1";
		exit;
	}

	if($_POST["nivel"]=="ADMINISTRADOR(A) GENERAL" && decrypt($_POST["codsucursal"])!="0")
	{
		
		echo "2";
		exit;
	}

	elseif($_POST["nivel"]!="ADMINISTRADOR(A) GENERAL" && decrypt($_POST["codsucursal"])=="0")
	{
		
		echo "3";
		exit;
	}

	$sql = " SELECT dni FROM usuarios WHERE dni = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["dni"]));
	$num = $stmt->rowCount();
	if($num > 0)
	{
		
		echo "4";
		exit;
	}
	else
	{
		$sql = " SELECT email FROM usuarios WHERE email = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["email"]));
		$num = $stmt->rowCount();
		if($num > 0)
		{

			echo "5";
			exit;
		}
		else
		{
			$sql = " SELECT usuario FROM usuarios WHERE usuario = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["usuario"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$query = " INSERT INTO usuarios values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
				$stmt = $this->dbh->prepare($query);
				$stmt->bindParam(1, $dni);
				$stmt->bindParam(2, $nombres);
				$stmt->bindParam(3, $sexo);
				$stmt->bindParam(4, $direccion);
				$stmt->bindParam(5, $telefono);
				$stmt->bindParam(6, $email);
				$stmt->bindParam(7, $usuario);
				$stmt->bindParam(8, $password);
				$stmt->bindParam(9, $nivel);
				$stmt->bindParam(10, $status);
				$stmt->bindParam(11, $comision);
				$stmt->bindParam(12, $codsucursal);

				$dni = limpiar($_POST["dni"]);
				$nombres = limpiar($_POST["nombres"]);
				$sexo = limpiar($_POST["sexo"]);
				$direccion = limpiar($_POST["direccion"]);
				$telefono = limpiar($_POST["telefono"]);
				$email = limpiar($_POST["email"]);
				$usuario = limpiar($_POST["usuario"]);
				$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
				$nivel = limpiar($_POST["nivel"]);
				$status = limpiar($_POST["status"]);
				$comision = limpiar($_POST["comision"]);
				$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
				$stmt->execute();

				################## SUBIR FOTO DE USUARIOS ######################################
                //datos del arhivo  
				if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo =''; }
				if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo =''; }
				if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo =''; }  
                 //compruebo si las características del archivo son las que deseo  
				if ((strpos($tipo_archivo,'image/jpeg')!==false)&&$tamano_archivo<50000) 
				{  
					if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/".$nombre_archivo) && rename("fotos/".$nombre_archivo,"fotos/".$_POST["dni"].".jpg"))
					{ 
		        ## se puede dar un aviso
					} 
		        ## se puede dar otro aviso 
				}
		        ################## FINALIZA SUBIR FOTO DE USUARIOS ##################

				echo "<span class='fa fa-check-square-o'></span> EL USUARIO HA SIDO REGISTRADO EXITOSAMENTE";
				exit;
			}
			else
			{
				echo "6";
				exit;
			}
		}
	}
}
############################# FUNCION REGISTRAR USUARIOS ###############################

############################# FUNCION LISTAR USUARIOS ################################
public function ListarUsuarios()
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT * FROM usuarios 
	LEFT JOIN sucursales ON usuarios.codsucursal = sucursales.codsucursal";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

     } else {

   $sql = "SELECT * FROM usuarios 
   LEFT JOIN sucursales ON usuarios.codsucursal = sucursales.codsucursal 
   WHERE usuarios.codsucursal = '".limpiar($_SESSION["codsucursal"])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

     }
}
############################## FUNCION LISTAR USUARIOS ################################

########################## FUNCION BUSQUEDA DE LOGS DE USUARIOS ###############################
public function BusquedaLogs()
	{
	self::SetNames();
	
	$buscar = limpiar($_POST['b']);

	if(empty($buscar)) {
            echo "";
            exit;
    }

    if ($_SESSION['acceso'] == "administradorG") {

    $sql = "SELECT * FROM log LEFT JOIN sucursales ON log.codsucursal = sucursales.codsucursal 
    WHERE CONCAT(log.ip, ' ',log.tiempo, ' ',log.detalles, ' ',log.usuario) LIKE '%".$buscar."%' LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0) {

	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON REGISTROS PARA TU BUSQUEDA</div></center>";
	exit;
		
	} else {
			
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
} else {

	$sql = "SELECT * FROM log LEFT JOIN sucursales ON log.codsucursal = sucursales.codsucursal 
	WHERE CONCAT(log.ip, ' ',log.tiempo, ' ',log.detalles, ' ',log.usuario) LIKE '%".$buscar."%' AND log.codsucursal = '".limpiar($_SESSION["codsucursal"])."' LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0) {

	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON REGISTROS PARA TU BUSQUEDA</div></center>";
	exit;
		
	} else {
			
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	    }
    }
}
########################## FUNCION BUSQUEDA DE LOGS DE USUARIOS ###############################

########################### FUNCION LISTAR LOGS DE USUARIOS ###########################
public function ListarLogs()
{
	self::SetNames();
	$sql = "SELECT * FROM log";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

   }
########################### FUNCION LISTAR LOGS DE USUARIOS ###########################

############################ FUNCION ID USUARIOS #################################
public function UsuariosPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM usuarios  
	LEFT JOIN sucursales ON usuarios.codsucursal = sucursales.codsucursal 
	WHERE usuarios.codigo = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codigo"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID USUARIOS #################################

############################ FUNCION ACTUALIZAR USUARIOS ############################
public function ActualizarUsuarios()
{

	self::SetNames();
	if(empty($_POST["dni"]) or empty($_POST["nombres"]) or empty($_POST["usuario"]) or empty($_POST["password"]))
	{
		echo "1";
		exit;
	}

	if($_POST["nivel"]=="ADMINISTRADOR(A) GENERAL" && decrypt($_POST["codsucursal"])!="0")
	{
		
		echo "2";
		exit;
	}

	elseif($_POST["nivel"]!="ADMINISTRADOR(A) GENERAL" && decrypt($_POST["codsucursal"])=="0")
	{
		
		echo "3";
		exit;
	}

	$sql = "SELECT * FROM usuarios WHERE codigo != ? AND dni = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codigo"],$_POST["dni"]));
	$num = $stmt->rowCount();
	if($num > 0)
	{
		echo "4";
		exit;
	}
	else
	{
		$sql = " SELECT email FROM usuarios WHERE codigo != ? AND email = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codigo"],$_POST["email"]));
		$num = $stmt->rowCount();
		if($num > 0)
		{
			echo "5";
			exit;
		}
		else
		{
			$sql = " SELECT usuario FROM usuarios WHERE codigo != ? AND usuario = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["codigo"],$_POST["usuario"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " UPDATE usuarios set "
				." dni = ?, "
				." nombres = ?, "
				." sexo = ?, "
				." direccion = ?, "
				." telefono = ?, "
				." email = ?, "
				." usuario = ?, "
				." password = ?, "
				." nivel = ?, "
				." status = ?, "
				." comision = ?, "
				." codsucursal = ? "
				." where "
				." codigo = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $dni);
				$stmt->bindParam(2, $nombres);
				$stmt->bindParam(3, $sexo);
				$stmt->bindParam(4, $direccion);
				$stmt->bindParam(5, $telefono);
				$stmt->bindParam(6, $email);
				$stmt->bindParam(7, $usuario);
				$stmt->bindParam(8, $password);
				$stmt->bindParam(9, $nivel);
				$stmt->bindParam(10, $status);
				$stmt->bindParam(11, $comision);
				$stmt->bindParam(12, $codsucursal);
				$stmt->bindParam(13, $codigo);

				$dni = limpiar($_POST["dni"]);
				$nombres = limpiar($_POST["nombres"]);
				$sexo = limpiar($_POST["sexo"]);
				$direccion = limpiar($_POST["direccion"]);
				$telefono = limpiar($_POST["telefono"]);
				$email = limpiar($_POST["email"]);
				$usuario = limpiar($_POST["usuario"]);
				$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
				$nivel = limpiar($_POST["nivel"]);
				$status = limpiar($_POST["status"]);
				$comision = limpiar($_POST["comision"]);
				$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
				$codigo = limpiar($_POST["codigo"]);
				$stmt->execute();

		        ################## SUBIR FOTO DE USUARIOS ######################################
                //datos del arhivo  
				if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo =''; }
				if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo =''; }
				if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo =''; }  
                 //compruebo si las características del archivo son las que deseo  
				if ((strpos($tipo_archivo,'image/jpeg')!==false)&&$tamano_archivo<50000) 
				{  
					if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/".$nombre_archivo) && rename("fotos/".$nombre_archivo,"fotos/".$_POST["dni"].".jpg"))
					{ 
		        ## se puede dar un aviso
					} 
		        ## se puede dar otro aviso 
				}
		        ################## FINALIZA SUBIR FOTO DE USUARIOS ##################

				echo "<span class='fa fa-check-square-o'></span> EL USUARIO HA SIDO ACTUALIZADO EXITOSAMENTE";
				exit;

			}
			else
			{
				echo "6";
				exit;
			}
		}
	}
}
############################ FUNCION ACTUALIZAR USUARIOS ############################

############################# FUNCION ELIMINAR USUARIOS ################################
public function EliminarUsuarios()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

		$sql = "SELECT codigo FROM ventas WHERE codigo = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codigo"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = " DELETE FROM usuarios WHERE codigo = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codigo);
			$codigo = decrypt($_GET["codigo"]);
			$stmt->execute();

			$dni = decrypt($_GET["dni"]);
			if (file_exists("fotos/".$dni.".jpg")){
		    //funcion para eliminar una carpeta con contenido
			$archivos = "fotos/".$dni.".jpg";		
			unlink($archivos);
			}

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
############################## FUNCION ELIMINAR USUARIOS ##############################

######################## FUNCION BUSCAR USUARIOS POR SUCURSAL ##########################
public function BuscarUsuariosxSucursal() 
{
	self::SetNames();
	$sql = " SELECT * FROM usuarios 
	INNER JOIN sucursales ON usuarios.codsucursal = sucursales.codsucursal 
	WHERE usuarios.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<option value=''> -- SIN RESULTADOS -- </option>";
		exit;
	}
	else
	{
	while($row = $stmt->fetch())
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################### FUNCION BUSCAR USUARIOS POR SUCURSAL ##########################

################### FUNCION SELECCIONA USUARIO POR CODIGO Y SUCURSAL ###################
public function BuscarUsuariosxCodigo() 
{
	self::SetNames();
	$sql = " SELECT * FROM usuarios WHERE codigo = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_GET["codigo"],decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<option value=''> -- SIN RESULTADOS -- </option>";
		exit;
	}
	else
	{
		while($row = $stmt->fetch())
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
################### FUNCION SELECCIONA USUARIO POR CODIGO Y SUCURSAL ##################

############################ FIN DE CLASE USUARIOS ################################


























################################ CLASE PROVINCIAS ##################################

########################## FUNCION REGISTRAR PROVINCIAS ###############################
public function RegistrarProvincias()
{
	self::SetNames();
	if(empty($_POST["provincia"]))
	{
		echo "1";
		exit;
	}

			$sql = " SELECT provincia FROM provincias WHERE provincia = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["provincia"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$query = " INSERT INTO provincias values (null, ?);";
				$stmt = $this->dbh->prepare($query);
				$stmt->bindParam(1, $provincia);

				$provincia = limpiar($_POST["provincia"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> LA PROVINCIA HA SIDO REGISTRADA EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
	    }
}
############################ FUNCION REGISTRAR PROVINCIAS ############################

############################ FUNCION LISTAR PROVINCIAS ################################
public function ListarProvincias()
{
	self::SetNames();
	$sql = "SELECT * FROM provincias";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
########################### FUNCION LISTAR PROVINCIAS ################################

########################### FUNCION ID PROVINCIAS #################################
public function ProvinciasPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM provincias WHERE id_provincia = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["id_provincia"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID PROVINCIAS #################################

############################ FUNCION ACTUALIZAR PROVINCIAS ############################
public function ActualizarProvincias()
{

	self::SetNames();
	if(empty($_POST["id_provincia"]) or empty($_POST["provincia"]))
	{
		echo "1";
		exit;
	}

			$sql = " SELECT provincia FROM provincias WHERE id_provincia != ? AND provincia = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["id_provincia"],$_POST["provincia"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " UPDATE provincias set "
				." provincia = ? "
				." where "
				." id_provincia = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $provincia);
				$stmt->bindParam(2, $id_provincia);

				$provincia = limpiar($_POST["provincia"]);
				$id_provincia = limpiar($_POST['id_provincia']);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> LA PROVINCIA HA SIDO ACTUALIZADA EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
		}
}
############################ FUNCION ACTUALIZAR PROVINCIAS ############################

############################ FUNCION ELIMINAR PROVINCIAS ############################
public function EliminarProvincias()
{
	self::SetNames();
	if($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

		$sql = "SELECT id_provincia FROM departamentos WHERE id_provincia = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["id_provincia"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM provincias WHERE id_provincia = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$id_provincia);
			$id_provincia = decrypt($_GET["id_provincia"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
############################ FUNCION ELIMINAR PROVINCIAS ##############################

############################## FIN DE CLASE PROVINCIAS ################################


























############################### CLASE DEPARTAMENTOS ################################

############################# FUNCION REGISTRAR DEPARTAMENTOS ###########################
public function RegistrarDepartamentos()
{
	self::SetNames();
	if(empty($_POST["departamento"]) or empty($_POST["id_provincia"]))
	{
		echo "1";
		exit;
	}

			$sql = " SELECT departamento FROM departamentos WHERE departamento = ? AND id_provincia = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["departamento"],$_POST["id_provincia"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$query = " INSERT INTO departamentos values (null, ?, ?);";
				$stmt = $this->dbh->prepare($query);
				$stmt->bindParam(1, $departamento);
				$stmt->bindParam(2, $id_provincia);

				$departamento = limpiar($_POST["departamento"]);
				$id_provincia = limpiar($_POST['id_provincia']);
				$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> EL DEPARTAMENTO HA SIDO REGISTRADO EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
	    }
}
########################### FUNCION REGISTRAR DEPARTAMENTOS ########################

########################## FUNCION PARA LISTAR DEPARTAMENTOS ##########################
public function ListarDepartamentos()
	{
		self::SetNames();
		$sql = "SELECT * FROM departamentos LEFT JOIN provincias ON departamentos.id_provincia = provincias.id_provincia";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
######################### FUNCION PARA LISTAR DEPARTAMENTOS ##########################

###################### FUNCION LISTAR DEPARTAMENTOS POR PROVINCIAS #####################
public function ListarDepartamentoXProvincias() 
	       {
		self::SetNames();
		$sql = "SELECT * FROM departamentos WHERE id_provincia = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_GET["id_provincia"]));
		$num = $stmt->rowCount();
		    if($num==0)
		{
			echo "<option value='0' selected> -- SIN RESULTADOS -- </option>";
			exit;
		}
		else
		{
		while($row = $stmt->fetch())
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
##################### FUNCION LISTAR DEPARTAMENTOS POR PROVINCIAS ######################

################# FUNCION PARA SELECCIONAR DEPARTAMENTOS POR PROVINCIA #################
public function SeleccionaDepartamento()
	{
		self::SetNames();
		$sql = "SELECT * FROM departamentos WHERE id_provincia = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_GET["id_provincia"]));
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "<option value=''> -- SIN RESULTADOS -- </option>";
			exit;
		}
		else
		{
			while($row = $stmt->fetch())
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################# FUNCION PARA SELECCIONAR DEPARTAMENTOS POR PROVINCIA ################

############################ FUNCION ID DEPARTAMENTOS #################################
public function DepartamentosPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM departamentos LEFT JOIN provincias ON departamentos.id_provincia = provincias.id_provincia WHERE departamentos.id_provincia = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["id_provincia"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID DEPARTAMENTOS #################################

######################## FUNCION ACTUALIZAR DEPARTAMENTOS ############################
public function ActualizarDepartamentos()
{
	self::SetNames();
	if(empty($_POST["id_departamento"]) or empty($_POST["departamento"]) or empty($_POST["id_provincia"]))
	{
		echo "1";
		exit;
	}

			$sql = "SELECT departamento FROM departamentos WHERE id_departamento != ? AND departamento = ? AND id_provincia = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["id_departamento"],$_POST["departamento"],$_POST["id_provincia"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " UPDATE departamentos set "
				." departamento = ?, "
				." id_provincia = ? "
				." where "
				." id_departamento = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $departamento);
				$stmt->bindParam(2, $id_provincia);
				$stmt->bindParam(3, $id_departamento);

				$departamento = limpiar($_POST["departamento"]);
				$id_provincia = limpiar($_POST['id_provincia']);
				$id_departamento = limpiar($_POST['id_departamento']);
				$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> EL DEPARTAMENTO HA SIDO ACTUALIZADO EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
		}
}
############################ FUNCION ACTUALIZAR DEPARTAMENTOS #######################

############################ FUNCION ELIMINAR DEPARTAMENTOS ###########################
public function EliminarDepartamentos()
{
	self::SetNames();
	if($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

		$sql = "SELECT id_departamento FROM configuracion WHERE id_departamento = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["id_departamento"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM departamentos WHERE id_departamento = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$id_departamento);
			$id_departamento = decrypt($_GET["id_departamento"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
########################### FUNCION ELIMINAR DEPARTAMENTOS ############################

############################## FIN DE CLASE DEPARTAMENTOS ##############################


























################################ CLASE TIPOS DE DOCUMENTOS ##############################

########################### FUNCION REGISTRAR TIPO DE DOCUMENTOS ########################
public function RegistrarDocumentos()
{
	self::SetNames();
	if(empty($_POST["documento"]) or empty($_POST["descripcion"]))
	{
		echo "1";
		exit;
	}

			$sql = " SELECT * FROM documentos WHERE documento = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["documento"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$query = " INSERT INTO documentos values (null, ?, ?);";
				$stmt = $this->dbh->prepare($query);
				$stmt->bindParam(1, $documento);
				$stmt->bindParam(2, $descripcion);

				$documento = limpiar($_POST["documento"]);
				$descripcion = limpiar($_POST["descripcion"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> EL TIPO DE DOCUMENTO HA SIDO REGISTRADO EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
	    }
}
############################ FUNCION REGISTRAR TIPO DE MONEDA ########################

########################## FUNCION LISTAR TIPO DE MONEDA ################################
public function ListarDocumentos()
{
	self::SetNames();
	$sql = "SELECT * FROM documentos ORDER BY documento ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
######################### FUNCION LISTAR TIPO DE DOCUMENTOS ##########################

######################### FUNCION ID TIPO DE DOCUMENTOS ###############################
public function DocumentoPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM documentos WHERE coddocumento = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["coddocumento"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################## FUNCION ID TIPO DE DOCUMENTOS #########################

######################### FUNCION ACTUALIZAR TIPO DE DOCUMENTOS ########################
public function ActualizarDocumentos()
{

	self::SetNames();
	if(empty($_POST["coddocumento"]) or empty($_POST["documento"]) or empty($_POST["descripcion"]))
	{
		echo "1";
		exit;
	}

			$sql = " SELECT documento FROM documentos WHERE coddocumento != ? AND documento = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["coddocumento"],$_POST["documento"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " UPDATE documentos set "
				." documento = ?, "
				." descripcion = ? "
				." where "
				." coddocumento = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $documento);
				$stmt->bindParam(2, $descripcion);
				$stmt->bindParam(3, $coddocumento);

				$documento = limpiar($_POST["documento"]);
				$descripcion = limpiar($_POST["descripcion"]);
				$coddocumento = limpiar($_POST["coddocumento"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> EL TIPO DE DOCUMENTO HA SIDO ACTUALIZADO EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
		}
}
####################### FUNCION ACTUALIZAR TIPO DE DOCUMENTOS #######################

######################### FUNCION ELIMINAR TIPO DE DOCUMENTOS #########################
public function EliminarDocumentos()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

		$sql = "SELECT documsucursal FROM sucursales WHERE documsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["coddocumento"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM documentos WHERE coddocumento = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$coddocumento);
			$coddocumento = decrypt($_GET["coddocumento"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
######################## FUNCION ELIMINAR TIPOS DE DOCUMENTOS ###########################

########################### FIN DE CLASE TIPOS DE DOCUMENTOS ###########################



























############################### CLASE TIPOS DE MONEDAS ##############################

############################ FUNCION REGISTRAR TIPO DE MONEDA ##########################
public function RegistrarTipoMoneda()
{
	self::SetNames();
	if(empty($_POST["moneda"]) or empty($_POST["moneda"]) or empty($_POST["simbolo"]))
	{
		echo "1";
		exit;
	}

		$sql = " SELECT * FROM tiposmoneda WHERE moneda = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["moneda"]));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = " INSERT INTO tiposmoneda values (null, ?, ?, ?);";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $moneda);
			$stmt->bindParam(2, $siglas);
			$stmt->bindParam(3, $simbolo);

			$moneda = limpiar($_POST["moneda"]);
			$siglas = limpiar($_POST["siglas"]);
			$simbolo = limpiar($_POST["simbolo"]);
			$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> EL TIPO DE MONEDA HA SIDO REGISTRADO EXITOSAMENTE";
		exit;

		} else {

		echo "2";
		exit;
    }
}
######################### FUNCION REGISTRAR TIPO DE MONEDA #######################

########################## FUNCION LISTAR TIPO DE MONEDA ################################
public function ListarTipoMoneda()
{
	self::SetNames();
	$sql = "SELECT * FROM tiposmoneda";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
########################### FUNCION LISTAR TIPO DE MONEDA #########################

############################ FUNCION ID TIPO DE MONEDA #################################
public function TipoMonedaPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM tiposmoneda WHERE codmoneda = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codmoneda"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID TIPO DE MONEDA #################################

####################### FUNCION ACTUALIZAR TIPO DE MONEDA ###########################
public function ActualizarTipoMoneda()
{

	self::SetNames();
	if(empty($_POST["codmoneda"]) or empty($_POST["moneda"]) or empty($_POST["siglas"]) or empty($_POST["simbolo"]))
	{
		echo "1";
		exit;
	}

		$sql = " SELECT moneda FROM tiposmoneda WHERE codmoneda != ? AND moneda = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codmoneda"],$_POST["moneda"]));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$sql = " UPDATE tiposmoneda set "
			." moneda = ?, "
			." siglas = ?, "
			." simbolo = ? "
			." where "
			." codmoneda = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $moneda);
			$stmt->bindParam(2, $siglas);
			$stmt->bindParam(3, $simbolo);
			$stmt->bindParam(4, $codmoneda);

			$moneda = limpiar($_POST["moneda"]);
			$siglas = limpiar($_POST["siglas"]);
			$simbolo = limpiar($_POST["simbolo"]);
			$codmoneda = limpiar($_POST["codmoneda"]);
			$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> EL TIPO DE MONEDA HA SIDO ACTUALIZADO EXITOSAMENTE";
		exit;

		} else {

		echo "2";
		exit;
	}
}
######################## FUNCION ACTUALIZAR TIPO DE MONEDA ############################

######################### FUNCION ELIMINAR TIPO DE MONEDA ###########################
public function EliminarTipoMoneda()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

	$sql = "SELECT codmoneda FROM tiposcambio WHERE codmoneda = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codmoneda"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{

		$sql = "DELETE FROM tiposmoneda WHERE codmoneda = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codmoneda);
		$codmoneda = decrypt($_GET["codmoneda"]);
		$stmt->execute();

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
			
	} else {
		
		echo "3";
		exit;
	}	
}
########################### FUNCION ELIMINAR TIPOS DE MONEDAS ########################

##################### FUNCION BUSCAR TIPOS DE CAMBIOS POR MONEDA #######################
public function BuscarTiposCambios()
{
	self::SetNames();
	$sql = "SELECT * FROM tiposmoneda INNER JOIN tiposcambio ON tiposmoneda.codmoneda = tiposcambio.codmoneda WHERE tiposcambio.codmoneda = ? ORDER BY tiposcambio.codcambio DESC LIMIT 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codmoneda"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<center><div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON TIPOS DE CAMBIO PARA LA MONEDA SELECCIONADA</div></center>";
		exit;
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
##################### FUNCION BUSCAR TIPOS DE CAMBIOS POR MONEDA #####################

############################# FIN DE CLASE TIPOS DE MONEDAS #############################
























############################## CLASE TIPOS DE CAMBIOS ################################

########################## FUNCION REGISTRAR TIPO DE CAMBIO #########################
public function RegistrarTipoCambio()
{
	self::SetNames();
	if(empty($_POST["descripcioncambio"]) or empty($_POST["montocambio"]) or empty($_POST["codmoneda"]) or empty($_POST["fechacambio"]))
	{
		echo "1";
		exit;
	}
			
	$sql = "SELECT codmoneda, fechacambio FROM tiposcambio WHERE codmoneda = ? AND fechacambio = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codmoneda"],date("Y-m-d",strtotime($_POST['fechacambio']))));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$query = "INSERT INTO tiposcambio values (null, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $descripcioncambio);
		$stmt->bindParam(2, $montocambio);
		$stmt->bindParam(3, $codmoneda);
		$stmt->bindParam(4, $fechacambio);

		$descripcioncambio = limpiar($_POST["descripcioncambio"]);
		$montocambio = number_format($_POST["montocambio"], 3, '.', '');
		$codmoneda = limpiar($_POST["codmoneda"]);
		$fechacambio = limpiar(date("Y-m-d",strtotime($_POST['fechacambio'])));
		$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> EL TIPO DE CAMBIO HA SIDO REGISTRADO EXITOSAMENTE";
		exit;

		} else {

		echo "2";
		exit;
    }
}
######################### FUNCION REGISTRAR TIPO DE CAMBIO ########################

########################### FUNCION LISTAR TIPO DE CAMBIO ########################
public function ListarTipoCambio()
{
	self::SetNames();
	$sql = "SELECT * FROM tiposcambio INNER JOIN tiposmoneda ON tiposcambio.codmoneda = tiposmoneda.codmoneda";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
######################### FUNCION LISTAR TIPO DE CAMBIO ################################

######################## FUNCION ID TIPO DE CAMBIO #################################
public function TipoCambioPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM tiposcambio INNER JOIN tiposmoneda ON tiposcambio.codmoneda = tiposmoneda.codmoneda WHERE tiposcambio.codcambio = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcambio"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID TIPO DE CAMBIO #################################

####################### FUNCION ACTUALIZAR TIPO DE CAMBIO ############################
public function ActualizarTipoCambio()
{
	self::SetNames();
	if(empty($_POST["codcambio"])or empty($_POST["descripcioncambio"]) or empty($_POST["montocambio"]) or empty($_POST["codmoneda"]) or empty($_POST["fechacambio"]))
	{
		echo "1";
		exit;
	}
			
	$sql = "SELECT codmoneda, fechacambio FROM tiposcambio WHERE codcambio != ? AND codmoneda = ? AND fechacambio = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codcambio"],$_POST["codmoneda"],date("Y-m-d",strtotime($_POST['fechacambio']))));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$sql = "UPDATE tiposcambio set "
		." descripcioncambio = ?, "
		." montocambio = ?, "
		." codmoneda = ?, "
		." fechacambio = ? "
		." where "
		." codcambio = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $descripcioncambio);
		$stmt->bindParam(2, $montocambio);
		$stmt->bindParam(3, $codmoneda);
		$stmt->bindParam(4, $fechacambio);
		$stmt->bindParam(5, $codcambio);

		$descripcioncambio = limpiar($_POST["descripcioncambio"]);
		$montocambio = number_format($_POST["montocambio"], 3, '.', '');
		$codmoneda = limpiar($_POST["codmoneda"]);
		$fechacambio = limpiar(date("Y-m-d",strtotime($_POST['fechacambio'])));
		$codcambio = limpiar($_POST["codcambio"]);
		$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> EL TIPO DE CAMBIO HA SIDO ACTUALIZADO EXITOSAMENTE";
		exit;

		} else {

		echo "2";
		exit;
    }
}
###################### FUNCION ACTUALIZAR TIPO DE CAMBIO ############################

########################## FUNCION ELIMINAR TIPO DE CAMBIO ###########################
public function EliminarTipoCambio()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

	    $sql = "DELETE FROM tiposcambio WHERE codcambio = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codcambio);
		$codcambio = decrypt($_GET["codcambio"]);
		$stmt->execute();

		echo "1";
		exit;

	} else {
	   
		echo "2";
		exit;
	} 
}
########################### FUNCION ELIMINAR TIPO DE CAMBIO ###########################

######################## FUNCION BUSCAR PRODUCTOS POR MONEDA ###########################
public function MonedaProductoId()
{
	self::SetNames();
	if($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT sucursales.codmoneda, tiposmoneda.moneda, tiposmoneda.siglas, tiposmoneda.simbolo, tiposcambio.montocambio 
	FROM tiposmoneda 
	INNER JOIN sucursales ON tiposmoneda.codmoneda = sucursales.codmoneda
	INNER JOIN tiposcambio ON tiposmoneda.codmoneda = tiposcambio.codmoneda 
	WHERE sucursales.codsucursal = ? ORDER BY tiposcambio.codcambio DESC LIMIT 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	   }

	} else {

	$sql = "SELECT sucursales.codmoneda, tiposmoneda.moneda, tiposmoneda.siglas, tiposmoneda.simbolo, tiposcambio.montocambio 
	FROM sucursales 
	INNER JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	INNER JOIN tiposcambio ON tiposmoneda.codmoneda = tiposcambio.codmoneda 
	WHERE sucursales.codsucursal = ? ORDER BY tiposcambio.codcambio DESC LIMIT 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_SESSION["codsucursal"]));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	   }
	}
}
###################### FUNCION BUSCAR PRODUCTOS POR MONEDA ##########################

############################ FIN DE CLASE TIPOS DE CAMBIOS #############################


























################################# CLASE MEDIOS DE PAGOS ################################

########################### FUNCION REGISTRAR MEDIOS DE PAGOS ###########################
public function RegistrarMediosPagos()
{
	self::SetNames();
	if(empty($_POST["mediopago"]))
	{
		echo "1";
		exit;
	}

		$sql = " SELECT mediopago FROM mediospagos WHERE mediopago = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["mediopago"]));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = " INSERT INTO mediospagos values (null, ?);";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $mediopago);

			$mediopago = limpiar($_POST["mediopago"]);
			$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> EL MEDIO DE PAGO HA SIDO REGISTRADO EXITOSAMENTE";
		exit;

		} else {

		echo "2";
		exit;
    }
}
############################ FUNCION REGISTRAR MEDIOS DE PAGOS ##########################

########################## FUNCION LISTAR MEDIOS DE PAGOS ##########################
public function ListarMediosPagos()
{
	self::SetNames();
	$sql = "SELECT * FROM mediospagos";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
########################### FUNCION LISTAR MEDIOS DE PAGOS ##########################

############################ FUNCION ID MEDIOS DE PAGOS #################################
public function MediosPagosPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM mediospagos WHERE codmediopago = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codmediopago"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID MEDIOS DE PAGOS #################################

##################### FUNCION ACTUALIZAR MEDIOS DE PAGOS ############################
public function ActualizarMediosPagos()
{
	self::SetNames();
	if(empty($_POST["codmediopago"]) or empty($_POST["mediopago"]))
	{
		echo "1";
		exit;
	}

		$sql = " SELECT mediopago FROM mediospagos WHERE codmediopago != ? AND mediopago = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codmediopago"],$_POST["mediopago"]));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$sql = " UPDATE mediospagos set "
			." mediopago = ? "
			." where "
			." codmediopago = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $mediopago);
			$stmt->bindParam(2, $codmediopago);

			$mediopago = limpiar($_POST["mediopago"]);
			$codmediopago = limpiar($_POST["codmediopago"]);
			$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> EL MEDIO DE PAGO HA SIDO ACTUALIZADO EXITOSAMENTE";
		exit;

		} else {

		echo "2";
		exit;
	}
}
##################### FUNCION ACTUALIZAR MEDIOS DE PAGOS ############################

########################## FUNCION ELIMINAR MEDIOS DE PAGOS #########################
public function EliminarMediosPagos()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

	$sql = "SELECT formapago FROM ventas WHERE formapago = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codmediopago"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{

		$sql = "DELETE FROM mediospagos WHERE codmediopago = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codmediopago);
		$codmediopago = decrypt($_GET["codmediopago"]);
		$stmt->execute();

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
			
	} else {
		
		echo "3";
		exit;
	}	
}
########################## FUNCION ELIMINAR MEDIOS DE PAGOS ###########################

############################ FIN DE CLASE MEDIOS DE PAGOS ##############################

























############################### CLASE IMPUESTOS ####################################

############################ FUNCION REGISTRAR IMPUESTOS ###############################
public function RegistrarImpuestos()
{
	self::SetNames();
	if(empty($_POST["nomimpuesto"]) or empty($_POST["valorimpuesto"]) or empty($_POST["statusimpuesto"]))
	{
		echo "1";
		exit;
	}

			$sql = " SELECT statusimpuesto FROM impuestos WHERE nomimpuesto != ? AND statusimpuesto = ? AND statusimpuesto = 'ACTIVO'";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["nomimpuesto"],$_POST["statusimpuesto"]));
			$num = $stmt->rowCount();
			if($num>0)
			{
				echo "2";
				exit;
			}
			else
			{

			$sql = " SELECT nomimpuesto FROM impuestos WHERE nomimpuesto = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["nomimpuesto"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$query = " INSERT INTO impuestos values (null, ?, ?, ?, ?);";
				$stmt = $this->dbh->prepare($query);
				$stmt->bindParam(1, $nomimpuesto);
				$stmt->bindParam(2, $valorimpuesto);
				$stmt->bindParam(3, $statusimpuesto);
				$stmt->bindParam(4, $fechaimpuesto);

				$nomimpuesto = limpiar($_POST["nomimpuesto"]);
				$valorimpuesto = limpiar($_POST["valorimpuesto"]);
				$statusimpuesto = limpiar($_POST["statusimpuesto"]);
				$fechaimpuesto = limpiar(date("Y-m-d",strtotime($_POST['fechaimpuesto'])));
				$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> EL IMPUESTO HA SIDO REGISTRADO  EXITOSAMENTE";
			exit;

			} else {

			echo "3";
			exit;
	    }
	}
}
############################ FUNCION REGISTRAR IMPUESTOS ###############################

############################# FUNCION LISTAR IMPUESTOS ################################
public function ListarImpuestos()
{
	self::SetNames();
	$sql = "SELECT * FROM impuestos";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
############################# FUNCION LISTAR IMPUESTOS ################################

############################ FUNCION ID IMPUESTOS #################################
public function ImpuestosPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM impuestos WHERE statusimpuesto = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array("ACTIVO"));
	$num = $stmt->rowCount();
	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
}
############################ FUNCION ID IMPUESTOS #################################

############################ FUNCION ACTUALIZAR IMPUESTOS ############################
public function ActualizarImpuestos()
{

	self::SetNames();
	if(empty($_POST["codimpuesto"]) or empty($_POST["nomimpuesto"]) or empty($_POST["valorimpuesto"]) or empty($_POST["statusimpuesto"]))
	{
		echo "1";
		exit;
	}

			$sql = " SELECT statusimpuesto FROM impuestos WHERE codimpuesto != ? AND statusimpuesto = ? AND statusimpuesto = 'ACTIVO'";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["codimpuesto"],$_POST["statusimpuesto"]));
			$num = $stmt->rowCount();
			if($num>0)
			{
				echo "2";
				exit;
			}
			else
			{

			$sql = "SELECT nomimpuesto FROM impuestos WHERE codimpuesto != ? AND nomimpuesto = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["codimpuesto"],$_POST["nomimpuesto"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " UPDATE impuestos set "
				." nomimpuesto = ?, "
				." valorimpuesto = ?, "
				." statusimpuesto = ? "
				." where "
				." codimpuesto = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $nomimpuesto);
				$stmt->bindParam(2, $valorimpuesto);
				$stmt->bindParam(3, $statusimpuesto);
				$stmt->bindParam(4, $codimpuesto);

				$nomimpuesto = limpiar($_POST["nomimpuesto"]);
				$valorimpuesto = limpiar($_POST["valorimpuesto"]);
				$statusimpuesto = limpiar($_POST["statusimpuesto"]);
				$codimpuesto = limpiar($_POST["codimpuesto"]);
				$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> EL IMPUESTO HA SIDO ACTUALIZADO EXITOSAMENTE";
			exit;

			} else {

			echo "3";
			exit;
		}
	}
}
############################ FUNCION ACTUALIZAR IMPUESTOS ############################

######################### FUNCION ELIMINAR IMPUESTOS #########################
public function EliminarImpuestos()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

		$sql = "SELECT * FROM impuestos WHERE codimpuesto = ? AND statusimpuesto = 'ACTIVO'";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codimpuesto"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM impuestos WHERE codimpuesto = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codimpuesto);
			$codimpuesto = decrypt($_GET["codimpuesto"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
######################## FUNCION ELIMINAR IMPUESTOS ###########################

############################ FIN DE CLASE IMPUESTOS ################################



























############################# CLASE SUCURSALES ##################################

############################ FUNCION REGISTRAR SUCURSALES ##########################
public function RegistrarSucursales()
{
	self::SetNames();
	if(empty($_POST["dniencargado"]) or empty($_POST["nomencargado"]) or empty($_POST["cuitsucursal"]) or empty($_POST["nomsucursal"]))
	{
		echo "1";
		exit;
	}

	$sql = " SELECT correosucursal FROM sucursales WHERE correosucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["correosucursal"]));
	$num = $stmt->rowCount();
	if($num > 0)
	{

		echo "2";
		exit;
	}
	else
	{
		$sql = " SELECT cuitsucursal FROM sucursales WHERE cuitsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["cuitsucursal"]));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = " INSERT INTO sucursales values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $documsucursal);
			$stmt->bindParam(2, $cuitsucursal);
			$stmt->bindParam(3, $nomsucursal);
			$stmt->bindParam(4, $id_provincia);
			$stmt->bindParam(5, $id_departamento);
			$stmt->bindParam(6, $direcsucursal);
			$stmt->bindParam(7, $correosucursal);
			$stmt->bindParam(8, $tlfsucursal);
			$stmt->bindParam(9, $nroactividadsucursal);
			$stmt->bindParam(10, $inicioticket);
			$stmt->bindParam(11, $iniciofactura);
			$stmt->bindParam(12, $inicioguia);
			$stmt->bindParam(13, $inicionotaventa);
			$stmt->bindParam(14, $inicionotacredito);
			$stmt->bindParam(15, $fechaautorsucursal);
			$stmt->bindParam(16, $llevacontabilidad);
			$stmt->bindParam(17, $documencargado);
			$stmt->bindParam(18, $dniencargado);
			$stmt->bindParam(19, $nomencargado);
			$stmt->bindParam(20, $tlfencargado);
			$stmt->bindParam(21, $descsucursal);
			$stmt->bindParam(22, $porcentaje);
			$stmt->bindParam(23, $codmoneda);
			$stmt->bindParam(24, $codmoneda2);

			$documsucursal = limpiar($_POST['documsucursal'] == '' ? "0" : $_POST['documsucursal']);
			$cuitsucursal = limpiar($_POST["cuitsucursal"]);
			$nomsucursal = limpiar($_POST["nomsucursal"]);
			$id_provincia = limpiar($_POST['id_provincia'] == '' ? "0" : $_POST['id_provincia']);
			$id_departamento = limpiar($_POST['id_departamento'] == '' ? "0" : $_POST['id_departamento']);
			$direcsucursal = limpiar($_POST["direcsucursal"]);
			$correosucursal = limpiar($_POST["correosucursal"]);
			$tlfsucursal = limpiar($_POST["tlfsucursal"]);
			$nroactividadsucursal = limpiar($_POST["nroactividadsucursal"]);
			$inicioticket = limpiar($_POST["inicioticket"]);
			$iniciofactura = limpiar($_POST["iniciofactura"]);
			$inicioguia = limpiar($_POST["inicioguia"]);
			$inicionotaventa = limpiar($_POST["inicionotaventa"]);
			$inicionotacredito = limpiar($_POST["inicionotacredito"]);
			if (limpiar(isset($_POST['fechaautorsucursal'])) && limpiar($_POST['fechaautorsucursal']!="")) { $fechaautorsucursal = limpiar(date("Y-m-d",strtotime($_POST['fechaautorsucursal']))); } else { $fechaautorsucursal = limpiar('0000-00-00'); };
			$llevacontabilidad = limpiar($_POST["llevacontabilidad"]);
			$documencargado = limpiar($_POST["documencargado"]);
			$dniencargado = limpiar($_POST["dniencargado"]);
			$nomencargado = limpiar($_POST["nomencargado"]);
			$tlfencargado = limpiar($_POST["tlfencargado"]);
			$descsucursal = limpiar($_POST["descsucursal"]);
			$porcentaje = limpiar($_POST["porcentaje"]);
			$codmoneda = limpiar($_POST["codmoneda"]);
			$codmoneda2 = limpiar($_POST["codmoneda2"]);
			$stmt->execute();

##################  SUBIR LOGO DE SUCURSAL ######################################
//datos del arhivo  
    if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo =''; }
	if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo =''; }
    if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo =''; }  
//compruebo si las características del archivo son las que deseo  
	if ((strpos($tipo_archivo,'image/png')!==false)&&$tamano_archivo<200000) {  
					if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/sucursales/".$nombre_archivo) && rename("fotos/sucursales/".$nombre_archivo,"fotos/sucursales/".$_POST["cuitsucursal"].".png"))
					{ 
## se puede dar un aviso
					} 
## se puede dar otro aviso 
				}
##################  FINALIZA SUBIR LOGO DE SUCURSAL ##################


			echo "<span class='fa fa-check-square-o'></span> LA SUCURSAL HA SIDO REGISTRADA EXITOSAMENTE";
			exit;
		}
		else
		{
			echo "3";
			exit;
		}
	 }
}
######################### FUNCION REGISTRAR SUCURSALES ###############################

######################## FUNCION LISTAR SUCURSALES ###############################
public function ListarSucursales()
{
	self::SetNames();
	$sql = "SELECT 
	sucursales.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.id_provincia,
	sucursales.id_departamento,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.inicioticket,
	sucursales.iniciofactura,
	sucursales.inicioguia,
	sucursales.inicionotaventa,
	sucursales.inicionotacredito,
	sucursales.nroactividadsucursal,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.descsucursal,
	sucursales.porcentaje,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda2.moneda AS moneda2,
	provincias.provincia,
	departamentos.departamento 
	FROM sucursales 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
########################## FUNCION LISTAR SUCURSALES ##########################

######################## FUNCION LISTAR SUCURSALES DIFERENTES A SESSION ###############################
public function ListarSucursalesDiferentes()
{
	self::SetNames();
	$sql = "SELECT 
	sucursales.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.id_provincia,
	sucursales.id_departamento,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.inicioticket,
	sucursales.iniciofactura,
	sucursales.inicioguia,
	sucursales.inicionotaventa,
	sucursales.inicionotacredito,
	sucursales.nroactividadsucursal,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.descsucursal,
	sucursales.porcentaje,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda2.moneda AS moneda2,
	provincias.provincia,
	departamentos.departamento
	FROM sucursales 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	WHERE sucursales.codsucursal != '".limpiar($_SESSION["codsucursal"])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
########################## FUNCION LISTAR SUCURSALES DIFERENTES A SESSION ########################## 

############################ FUNCION ID SUCURSALES #################################
public function SucursalesPorId()
{
	self::SetNames();
	$sql = "SELECT  
	sucursales.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.id_provincia,
	sucursales.id_departamento,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.inicioticket,
	sucursales.iniciofactura,
	sucursales.inicioguia,
	sucursales.inicionotaventa,
	sucursales.inicionotacredito,
	sucursales.nroactividadsucursal,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.descsucursal,
	sucursales.porcentaje,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda2.moneda AS moneda2,
	provincias.provincia,
	departamentos.departamento 
	FROM sucursales 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	WHERE sucursales.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID SUCURSALES #################################

############################ FUNCION ACTUALIZAR SUCURSALES ############################
public function ActualizarSucursales()
{
	self::SetNames();
	if(empty($_POST["codsucursal"]) or empty($_POST["dniencargado"]) or empty($_POST["nomencargado"]) or empty($_POST["cuitsucursal"]) or empty($_POST["nomsucursal"]))
	{
		echo "1";
		exit;
	}

	$sql = " SELECT correosucursal FROM sucursales WHERE codsucursal != ? AND correosucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codsucursal"],$_POST["correosucursal"]));
	$num = $stmt->rowCount();
	if($num > 0)
	{
		echo "2";
		exit;
	}
	else
	{
	$sql = " SELECT cuitsucursal FROM sucursales WHERE codsucursal != ? AND cuitsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codsucursal"],$_POST["cuitsucursal"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$sql = " UPDATE sucursales set "
		." documsucursal = ?, "
		." cuitsucursal = ?, "
		." nomsucursal = ?, "
		." id_provincia = ?, "
		." id_departamento = ?, "
		." direcsucursal = ?, "
		." correosucursal = ?, "
		." tlfsucursal = ?, "
		." inicioticket = ?, "
		." iniciofactura = ?, "
		." inicioguia = ?, "
		." inicionotaventa = ?, "
		." inicionotacredito = ?, "
		." nroactividadsucursal = ?, "
		." fechaautorsucursal = ?, "
		." llevacontabilidad = ?, "
		." documencargado = ?, "
		." dniencargado = ?, "
		." nomencargado = ?, "
		." tlfencargado = ?, "
		." descsucursal = ?, "
		." porcentaje = ?, "
		." codmoneda = ?, "
		." codmoneda2 = ? "
		." where "
		." codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $documsucursal);
		$stmt->bindParam(2, $cuitsucursal);
		$stmt->bindParam(3, $nomsucursal);
		$stmt->bindParam(4, $id_provincia);
		$stmt->bindParam(5, $id_departamento);
		$stmt->bindParam(6, $direcsucursal);
		$stmt->bindParam(7, $correosucursal);
		$stmt->bindParam(8, $tlfsucursal);
		$stmt->bindParam(9, $inicioticket);
		$stmt->bindParam(10, $iniciofactura);
		$stmt->bindParam(11, $inicioguia);
		$stmt->bindParam(12, $inicionotaventa);
		$stmt->bindParam(13, $inicionotacredito);
		$stmt->bindParam(14, $nroactividadsucursal);
		$stmt->bindParam(15, $fechaautorsucursal);
		$stmt->bindParam(16, $llevacontabilidad);
		$stmt->bindParam(17, $documencargado);
		$stmt->bindParam(18, $dniencargado);
		$stmt->bindParam(19, $nomencargado);
		$stmt->bindParam(20, $tlfencargado);
		$stmt->bindParam(21, $descsucursal);
		$stmt->bindParam(22, $porcentaje);
		$stmt->bindParam(23, $codmoneda);
		$stmt->bindParam(24, $codmoneda2);
		$stmt->bindParam(25, $codsucursal);

		$documsucursal = limpiar($_POST['documsucursal'] == '' ? "0" : $_POST['documsucursal']);
		$cuitsucursal = limpiar($_POST["cuitsucursal"]);
		$nomsucursal = limpiar($_POST["nomsucursal"]);
		$id_provincia = limpiar($_POST['id_provincia'] == '' ? "0" : $_POST['id_provincia']);
		$id_departamento = limpiar($_POST['id_departamento'] == '' ? "0" : $_POST['id_departamento']);
		$direcsucursal = limpiar($_POST["direcsucursal"]);
		$correosucursal = limpiar($_POST["correosucursal"]);
		$tlfsucursal = limpiar($_POST["tlfsucursal"]);
		$nroactividadsucursal = limpiar($_POST["nroactividadsucursal"]);
		$inicioticket = limpiar($_POST["inicioticket"]);
		$iniciofactura = limpiar($_POST["iniciofactura"]);
		$inicioguia = limpiar($_POST["inicioguia"]);
		$inicionotaventa = limpiar($_POST["inicionotaventa"]);
		$inicionotacredito = limpiar($_POST["inicionotacredito"]);
		if (limpiar(isset($_POST['fechaautorsucursal'])) && limpiar($_POST['fechaautorsucursal']!="")) { $fechaautorsucursal = limpiar(date("Y-m-d",strtotime($_POST['fechaautorsucursal']))); } else { $fechaautorsucursal = limpiar('0000-00-00'); };
		$llevacontabilidad = limpiar($_POST["llevacontabilidad"]);
		$documencargado = limpiar($_POST['documencargado'] == '' ? "0" : $_POST['documencargado']);
		$dniencargado = limpiar($_POST["dniencargado"]);
		$nomencargado = limpiar($_POST["nomencargado"]);
		$tlfencargado = limpiar($_POST["tlfencargado"]);
		$descsucursal = limpiar($_POST["descsucursal"]);
		$porcentaje = limpiar($_POST["porcentaje"]);
		$codmoneda = limpiar($_POST["codmoneda"]);
		$codmoneda2 = limpiar($_POST["codmoneda2"]);
		$codsucursal = limpiar($_POST["codsucursal"]);
		$stmt->execute();

##################  SUBIR LOGO DE SUCURSAL ######################################
//datos del arhivo  
    if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo =''; }
	if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo =''; }
    if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo =''; }  
//compruebo si las características del archivo son las que deseo  
	if ((strpos($tipo_archivo,'image/png')!==false)&&$tamano_archivo<200000) {  
					if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/sucursales/".$nombre_archivo) && rename("fotos/sucursales/".$nombre_archivo,"fotos/sucursales/".$_POST["cuitsucursal"].".png"))
					{ 
## se puede dar un aviso
					} 
## se puede dar otro aviso 
				}
##################  FINALIZA SUBIR LOGO DE SUCURSAL ##################

			echo "<span class='fa fa-check-square-o'></span> LA SUCURSAL HA SIDO ACTUALIZADA EXITOSAMENTE";
			exit;

		}
		else
		{
			echo "3";
			exit;
		}
	 }
}
############################ FUNCION ACTUALIZAR SUCURSALES ############################

########################## FUNCION ELIMINAR SUCURSALES ########################
public function EliminarSucursales()
{
self::SetNames();
   if($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT codsucursal FROM productos WHERE codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$sql = " DELETE FROM sucursales WHERE codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codsucursal);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
			
	} else {
		
		echo "3";
		exit;
	}	
}
############################ FUNCION ELIMINAR SUCURSALES #######################

############################# FIN DE CLASE SUCURSALES ################################


























################################ CLASE FAMILIAS ######################################

############################# FUNCION REGISTRAR FAMILIAS ###############################
public function RegistrarFamilias()
{
	self::SetNames();
	if(empty($_POST["nomfamilia"]))
	{
		echo "1";
		exit;
	}

		$sql = " SELECT nomfamilia FROM familias WHERE nomfamilia = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["nomfamilia"]));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = " INSERT INTO familias values (null, ?);";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $nomfamilia);

			$nomfamilia = limpiar($_POST["nomfamilia"]);
			$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> LA FAMILIA HA SIDO REGISTRADA EXITOSAMENTE";
		exit;

		} else {

		echo "2";
		exit;
    }
}
########################### FUNCION REGISTRAR FAMILIAS ###############################

########################### FUNCION LISTAR FAMILIAS ################################
public function ListarFamilias()
{
	self::SetNames();
	$sql = "SELECT * FROM familias";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
############################ FUNCION LISTAR FAMILIAS ################################

############################ FUNCION ID FAMILIAS #################################
public function FamiliasPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM familias WHERE codfamilia = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codfamilia"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID FAMILIAS #################################

############################ FUNCION ACTUALIZAR FAMILIAS ############################
public function ActualizarFamilias()
{

	self::SetNames();
	if(empty($_POST["codfamilia"]) or empty($_POST["nomfamilia"]))
	{
		echo "1";
		exit;
	}

		$sql = " SELECT nomfamilia FROM familias WHERE codfamilia != ? AND nomfamilia = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codfamilia"],$_POST["nomfamilia"]));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$sql = " UPDATE familias set "
			." nomfamilia = ? "
			." where "
			." codfamilia = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $nomfamilia);
			$stmt->bindParam(2, $codfamilia);

			$nomfamilia = limpiar($_POST["nomfamilia"]);
			$codfamilia = limpiar($_POST["codfamilia"]);
			$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> LA FAMILIA HA SIDO ACTUALIZADA EXITOSAMENTE";
		exit;

		} else {

		echo "2";
		exit;
	}
}
############################ FUNCION ACTUALIZAR FAMILIAS ############################

########################### FUNCION ELIMINAR FAMILIAS #################################
public function EliminarFamilias()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

		$sql = "SELECT codfamilia FROM subfamilias WHERE codfamilia = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codfamilia"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM familias WHERE codfamilia = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codfamilia);
			$codfamilia = decrypt($_GET["codfamilia"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
########################## FUNCION ELIMINAR FAMILIAS #################################

############################# FIN DE CLASE FAMILIAS #################################


























################################# CLASE SUBFAMILIAS ####################################

########################### FUNCION REGISTRAR SUBFAMILIAS #########################
public function RegistrarSubfamilias()
{
	self::SetNames();
	if(empty($_POST["nomsubfamilia"]) or empty($_POST["codfamilia"]))
	{
		echo "1";
		exit;
	}

		$sql = " SELECT nomsubfamilia FROM subfamilias WHERE nomsubfamilia = ? AND codfamilia = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["nomsubfamilia"],$_POST["codfamilia"]));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = " INSERT INTO subfamilias values (null, ?, ?);";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $nomsubfamilia);
			$stmt->bindParam(2, $codfamilia);

			$nomsubfamilia = limpiar($_POST["nomsubfamilia"]);
			$codfamilia = limpiar($_POST["codfamilia"]);
			$stmt->execute();

	echo "<span class='fa fa-check-square-o'></span> LA SUBFAMILIA HA SIDO REGISTRADA EXITOSAMENTE";
		exit;

		} else {

		echo "2";
		exit;
    }
}
########################## FUNCION REGISTRAR SUBFAMILIAS ###############################

######################### FUNCION LISTAR SUBFAMILIAS ################################
public function ListarSubfamilias()
{
	self::SetNames();
	$sql = "SELECT * FROM subfamilias LEFT JOIN familias ON familias.codfamilia = subfamilias.codfamilia";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
########################### FUNCION LISTAR SUBFAMILIAS ################################

####################### FUNCION LISTAR SUBFAMILIAS POR FAMILIAS ######################
public function ListarSubfamilias2() 
{
	self::SetNames();
	$sql = "SELECT * FROM subfamilias WHERE codfamilia = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_GET["codfamilia"]));
	$num = $stmt->rowCount();
	    if($num==0)
	{
		echo "<option value='0' selected> -- SIN RESULTADOS -- </option>";
		exit;
	}
	else
	{
	while($row = $stmt->fetch())
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
####################### FUNCION LISTAR SUBFAMILIAS POR FAMILIAS #########################

############################ FUNCION ID SUBFAMILIAS #################################
public function SubfamiliasPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM subfamilias LEFT JOIN familias ON familias.codfamilia = subfamilias.codfamilia WHERE subfamilias.codsubfamilia = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codsubfamilia"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID SUBFAMILIAS #################################

############################ FUNCION ACTUALIZAR SUBFAMILIAS ############################
public function ActualizarSubfamilias()
{

	self::SetNames();
	if(empty($_POST["codsubfamilia"]) or empty($_POST["nomsubfamilia"]) or empty($_POST["codfamilia"]))
	{
		echo "1";
		exit;
	}

		$sql = "SELECT nomsubfamilia FROM subfamilias WHERE codsubfamilia != ? AND nomsubfamilia = ? AND codfamilia = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codsubfamilia"],$_POST["nomsubfamilia"],$_POST["codfamilia"]));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$sql = " UPDATE subfamilias set "
			." nomsubfamilia = ?, "
			." codfamilia = ? "
			." where "
			." codsubfamilia = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $nomsubfamilia);
			$stmt->bindParam(2, $codfamilia);
			$stmt->bindParam(3, $codsubfamilia);

			$nomsubfamilia = limpiar($_POST["nomsubfamilia"]);
			$codfamilia = limpiar($_POST["codfamilia"]);
			$codsubfamilia = limpiar($_POST["codsubfamilia"]);
			$stmt->execute();

	echo "<span class='fa fa-check-square-o'></span> LA SUBFAMILIA HA SIDO ACTUALIZADA EXITOSAMENTE";
		exit;

		} else {

		echo "2";
		exit;
	}
}
############################ FUNCION ACTUALIZAR SUBFAMILIAS ############################

############################ FUNCION ELIMINAR SUBFAMILIAS ##########################
public function EliminarSubfamilias()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

		$sql = "SELECT codsubfamilia FROM productos WHERE codsubfamilia = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codsubfamilia"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM subfamilias WHERE codsubfamilia = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codsubfamilia);
			$codsubfamilia = decrypt($_GET["codsubfamilia"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
############################ FUNCION ELIMINAR SUBFAMILIAS ##########################

############################## FIN DE CLASE SUBFAMILIAS ##############################


























################################## CLASE MARCAS ######################################

############################ FUNCION REGISTRAR MARCAS ###############################
public function RegistrarMarcas()
{
	self::SetNames();
	if(empty($_POST["nommarca"]))
	{
		echo "1";
		exit;
	}

		$sql = " SELECT nommarca FROM marcas WHERE nommarca = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["nommarca"]));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = " INSERT INTO marcas values (null, ?);";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $nommarca);

			$nommarca = limpiar($_POST["nommarca"]);
			$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> LA MARCA HA SIDO REGISTRADA EXITOSAMENTE";
		exit;

		} else {

		echo "2";
		exit;
    }
}
############################ FUNCION REGISTRAR MARCAS ###############################

############################## FUNCION LISTAR MARCAS ################################
public function ListarMarcas()
{
	self::SetNames();
	$sql = "SELECT * FROM marcas";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
################################## FUNCION LISTAR MARCAS ################################

############################ FUNCION ID MARCAS #################################
public function MarcasPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM marcas WHERE codmarca = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codmarca"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID MARCAS #################################

############################ FUNCION ACTUALIZAR MARCAS ############################
public function ActualizarMarcas()
{

	self::SetNames();
	if(empty($_POST["codmarca"]) or empty($_POST["nommarca"]))
	{
		echo "1";
		exit;
	}

			$sql = " SELECT nommarca FROM marcas WHERE codmarca != ? AND nommarca = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["codmarca"],$_POST["nommarca"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " UPDATE marcas set "
				." nommarca = ? "
				." where "
				." codmarca = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $nommarca);
				$stmt->bindParam(2, $codmarca);

				$nommarca = limpiar($_POST["nommarca"]);
				$codmarca = limpiar($_POST["codmarca"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> LA MARCA HA SIDO ACTUALIZADA EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
		}
}
############################ FUNCION ACTUALIZAR MARCAS ############################

########################### FUNCION ELIMINAR MARCAS #################################
public function EliminarMarcas()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

		$sql = "SELECT codmarca FROM modelos WHERE codmarca = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codmarca"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM marcas WHERE codmarca = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codmarca);
			$codmarca = decrypt($_GET["codmarca"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
########################### FUNCION ELIMINAR MARCAS #################################

############################## FIN DE CLASE MARCAS ###################################


























################################# CLASE MODELOS ######################################

########################### FUNCION REGISTRAR MODELOS ###############################
public function RegistrarModelos()
{
	self::SetNames();
	if(empty($_POST["nommodelo"]) or empty($_POST["codmarca"]))
	{
		echo "1";
		exit;
	}

			$sql = " SELECT nommodelo FROM modelos WHERE nommodelo = ? AND codmarca = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["nommodelo"],$_POST["codmarca"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$query = " INSERT INTO modelos values (null, ?, ?);";
				$stmt = $this->dbh->prepare($query);
				$stmt->bindParam(1, $nommodelo);
				$stmt->bindParam(2, $codmarca);

				$nommodelo = limpiar($_POST["nommodelo"]);
				$codmarca = limpiar($_POST["codmarca"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> EL MODELO HA SIDO REGISTRADO EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
	    }
}
########################### FUNCION REGISTRAR MODELOS ###############################

############################ FUNCION LISTAR MODELOS ################################
public function ListarModelos()
{
	self::SetNames();
	$sql = "SELECT * FROM modelos INNER JOIN marcas ON marcas.codmarca = modelos.codmarca";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
############################## FUNCION LISTAR MODELOS ################################

########################## FUNCION LISTAR MODELOS POR MARCAS ##########################
 public function ListarModelosxMarcas() 
	       {
		self::SetNames();
		$sql = "SELECT * FROM modelos WHERE codmarca = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_GET["codmarca"]));
		$num = $stmt->rowCount();
		     if($num==0)
		{
	        echo "<option value='0' selected> -- SIN RESULTADOS -- </option>";
			exit;
		}
		else
		{
		while($row = $stmt->fetch())
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
############################# FUNCION LISTAR MODELOS POR MARCAS #########################

############################ FUNCION ID MODELOS #################################
public function ModelosPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM modelos LEFT JOIN marcas ON marcas.codmarca = modelos.codmarca WHERE modelos.codmodelo = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codmodelo"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID MODELOS #################################

############################ FUNCION ACTUALIZAR MODELOS ############################
public function ActualizarModelos()
{
	self::SetNames();
	if(empty($_POST["codmodelo"]) or empty($_POST["nommodelo"]) or empty($_POST["codmarca"]))
	{
		echo "1";
		exit;
	}

			$sql = "SELECT nommodelo FROM modelos WHERE codmodelo != ? AND nommodelo = ? AND codmarca = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["codmodelo"],$_POST["nommodelo"],$_POST["codmarca"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " UPDATE modelos set "
				." nommodelo = ?, "
				." codmarca = ? "
				." where "
				." codmodelo = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $nommodelo);
				$stmt->bindParam(2, $codmarca);
				$stmt->bindParam(3, $codmodelo);

				$nommodelo = limpiar($_POST["nommodelo"]);
				$codmarca = limpiar($_POST["codmarca"]);
				$codmodelo = limpiar($_POST["codmodelo"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> EL MODELO HA SIDO ACTUALIZADO EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
		}
}
############################ FUNCION ACTUALIZAR MODELOS ############################

############################ FUNCION ELIMINAR MODELOS ############################
public function EliminarModelos()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

		$sql = "SELECT codmodelo FROM productos WHERE codmodelo = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codmodelo"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM modelos WHERE codmodelo = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codmodelo);
			$codmodelo = decrypt($_GET["codmodelo"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
############################ FUNCION ELIMINAR MODELOS ############################

############################## FIN DE CLASE MODELOS #################################


























################################# CLASE PRESENTACIONES ################################

########################### FUNCION REGISTRAR PRESENTACIONES ##########################
public function RegistrarPresentaciones()
{
	self::SetNames();
	if(empty($_POST["nompresentacion"]))
	{
		echo "1";
		exit;
	}

			$sql = " SELECT nompresentacion FROM presentaciones WHERE nompresentacion = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["nompresentacion"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$query = " INSERT INTO presentaciones values (null, ?);";
				$stmt = $this->dbh->prepare($query);
				$stmt->bindParam(1, $nompresentacion);

				$nompresentacion = limpiar($_POST["nompresentacion"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> LA PRESENTACI&Oacute;N HA SIDO REGISTRADA EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
	    }
}
########################### FUNCION REGISTRAR PRESENTACIONES #########################

########################### FUNCION LISTAR PRESENTACIONES ############################
public function ListarPresentaciones()
{
	self::SetNames();
	$sql = "SELECT * FROM presentaciones";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
########################### FUNCION LISTAR PRESENTACIONES #########################

############################ FUNCION ID PRESENTACIONES #################################
public function PresentacionesPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM presentaciones WHERE codpresentacion = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codpresentacion"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID PRESENTACIONES #################################

######################### FUNCION ACTUALIZAR PRESENTACIONES #######################
public function ActualizarPresentaciones()
{
	self::SetNames();
	if(empty($_POST["codpresentacion"]) or empty($_POST["nompresentacion"]))
	{
		echo "1";
		exit;
	}

			$sql = " SELECT nompresentacion FROM presentaciones WHERE codpresentacion != ? AND nompresentacion = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["codpresentacion"],$_POST["nompresentacion"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " UPDATE presentaciones set "
				." nompresentacion = ? "
				." where "
				." codpresentacion = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $nompresentacion);
				$stmt->bindParam(2, $codpresentacion);

				$nompresentacion = limpiar($_POST["nompresentacion"]);
				$codpresentacion = limpiar($_POST["codpresentacion"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> LA PRESENTACI&Oacute;N HA SIDO ACTUALIZADA EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
		}
}
######################## FUNCION ACTUALIZAR PRESENTACIONES #######################

########################### FUNCION ELIMINAR PRESENTACIONES ############################
public function EliminarPresentaciones()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

		$sql = "SELECT codpresentacion FROM productos WHERE codpresentacion = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codpresentacion"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM presentaciones WHERE codpresentacion = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codpresentacion);
			$codpresentacion = decrypt($_GET["codpresentacion"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
########################### FUNCION ELIMINAR PRESENTACIONES ###########################

########################### FIN DE CLASE PRESENTACIONES ###############################


























################################## CLASE COLORES ######################################

########################### FUNCION REGISTRAR COLORES ###############################
public function RegistrarColores()
{
	self::SetNames();
	if(empty($_POST["nomcolor"]))
	{
		echo "1";
		exit;
	}

			$sql = " SELECT nomcolor FROM colores WHERE nomcolor = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["nomcolor"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$query = " INSERT INTO colores values (null, ?);";
				$stmt = $this->dbh->prepare($query);
				$stmt->bindParam(1, $nomcolor);

				$nomcolor = limpiar($_POST["nomcolor"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> EL COLOR HA SIDO REGISTRADO EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
	    }
}
########################## FUNCION REGISTRAR COLORES ###############################

########################## FUNCION LISTAR COLORES ################################
public function ListarColores()
{
	self::SetNames();
	$sql = "SELECT * FROM colores";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
########################### FUNCION LISTAR COLORES ################################

############################ FUNCION ID COLORES #################################
public function ColoresPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM colores WHERE codcolor = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcolor"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID COLORES #################################

############################ FUNCION ACTUALIZAR COLORES ############################
public function ActualizarColores()
{

	self::SetNames();
	if(empty($_POST["codcolor"]) or empty($_POST["nomcolor"]))
	{
		echo "1";
		exit;
	}

			$sql = " SELECT nomcolor FROM colores WHERE codcolor != ? AND nomcolor = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["codcolor"],$_POST["nomcolor"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " UPDATE colores set "
				." nomcolor = ? "
				." where "
				." codcolor = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $nomcolor);
				$stmt->bindParam(2, $codcolor);

				$nomcolor = limpiar($_POST["nomcolor"]);
				$codcolor = limpiar($_POST["codcolor"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> EL COLOR HA SIDO ACTUALIZADO EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
		}
}
############################ FUNCION ACTUALIZAR COLORES ############################

########################### FUNCION ELIMINAR COLORES ###########################
public function EliminarColores()
{
	self::SetNames();
		if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

		$sql = "SELECT codcolor FROM productos WHERE codcolor = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codcolor"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM colores WHERE codcolor = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codcolor);
			$codcolor = decrypt($_GET["codcolor"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
########################### FUNCION ELIMINAR COLORES #################################

############################ FIN DE CLASE COLORES ##################################


























################################### CLASE ORIGENES ####################################

########################## FUNCION REGISTRAR ORIGENES ###############################
public function RegistrarOrigenes()
{
	self::SetNames();
	if(empty($_POST["nomorigen"]))
	{
		echo "1";
		exit;
	}

			$sql = " SELECT nomorigen FROM origenes WHERE nomorigen = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["nomorigen"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$query = " INSERT INTO origenes values (null, ?);";
				$stmt = $this->dbh->prepare($query);
				$stmt->bindParam(1, $nomorigen);

				$nomorigen = limpiar($_POST["nomorigen"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> EL ORIGEN HA SIDO REGISTRADO EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
	    }
}
############################# FUNCION REGISTRAR ORIGENES ###############################

############################ FUNCION LISTAR ORIGENES ################################
public function ListarOrigenes()
{
	self::SetNames();
	$sql = "SELECT * FROM origenes";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
############################ FUNCION LISTAR ORIGENES ################################

############################ FUNCION ID ORIGENES #################################
public function OrigenesPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM origenes WHERE codorigen = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codorigen"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID ORIGENES #################################

############################ FUNCION ACTUALIZAR ORIGENES ############################
public function ActualizarOrigenes()
{

	self::SetNames();
	if(empty($_POST["codorigen"]) or empty($_POST["nomorigen"]))
	{
		echo "1";
		exit;
	}

			$sql = " SELECT nomorigen FROM origenes WHERE codorigen != ? AND nomorigen = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["codorigen"],$_POST["nomorigen"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " UPDATE origenes set "
				." nomorigen = ? "
				." where "
				." codorigen = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $nomorigen);
				$stmt->bindParam(2, $codorigen);

				$nomorigen = limpiar($_POST["nomorigen"]);
				$codorigen = limpiar($_POST["codorigen"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> EL ORIGEN HA SIDO ACTUALIZADO EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
		}
}
############################ FUNCION ACTUALIZAR ORIGENES ############################

########################### FUNCION ELIMINAR ORIGENES ##############################
public function EliminarOrigenes()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

		$sql = "SELECT codorigen FROM productos WHERE codorigen = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codorigen"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM origenes WHERE codorigen = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codorigen);
			$codorigen = decrypt($_GET["codorigen"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
########################### FUNCION ELIMINAR ORIGENES #################################

############################ FIN DE CLASE ORIGENES #################################


























################################## CLASE CLIENTES ##################################

############################### FUNCION CARGAR CLIENTES ##############################
public function CargarClientes()
	{
	self::SetNames();
	if(empty($_FILES["sel_file"]))
	{
		echo "1";
		exit;
	}
    //Aquí es donde seleccionamos nuestro csv
     $fname = $_FILES['sel_file']['name'];
     //echo 'Cargando nombre del archivo: '.$fname.' ';
     $chk_ext = explode(".",$fname);
     
    if(strtolower(end($chk_ext)) == "csv")
    {
    //si es correcto, entonces damos permisos de lectura para subir
    $filename = $_FILES['sel_file']['tmp_name'];
    $handle = fopen($filename, "r");
    $this->dbh->beginTransaction();
    
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

           //Insertamos los datos con los valores...
		   
	$query = "INSERT INTO clientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codcliente);
	$stmt->bindParam(2, $tipocliente);
	$stmt->bindParam(3, $documcliente);
	$stmt->bindParam(4, $dnicliente);
	$stmt->bindParam(5, $nomcliente);
	$stmt->bindParam(6, $razoncliente);
	$stmt->bindParam(7, $girocliente);
	$stmt->bindParam(8, $tlfcliente);
	$stmt->bindParam(9, $id_provincia);
	$stmt->bindParam(10, $id_departamento);
	$stmt->bindParam(11, $direccliente);
	$stmt->bindParam(12, $emailcliente);
	$stmt->bindParam(13, $limitecredito);
	$stmt->bindParam(14, $fechaingreso);

	$tipocliente = limpiar($data[0]);
	$codcliente = limpiar($data[1]);
	$documcliente = limpiar($data[2]);
	$dnicliente = limpiar($data[3]);
	$nomcliente = limpiar($data[4]);
	$razoncliente = limpiar($data[5]);
	$girocliente = limpiar($data[6]);
	$tlfcliente = limpiar($data[5]);
	$id_provincia = limpiar($data[6]);
	$id_departamento = limpiar($data[7]);
	$direccliente = limpiar($data[10]);
	$emailcliente = limpiar($data[11]);
	$limitecredito = limpiar($data[12]);
	$fechaingreso = limpiar(date("Y-m-d"));
	$stmt->execute();
			
    }
    $this->dbh->commit();
    //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
    fclose($handle);
	        
	echo "<span class='fa fa-check-square-o'></span> LA CARGA MASIVA DE CLIENTES FUE REALIZADA EXITOSAMENTE";
	exit;
             
    } else {
    //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para ver si esta separado por " , "
         echo "2";
		 exit;
    }  
}
################################# FUNCION CARGAR CLIENTES ###############################

############################ FUNCION REGISTRAR CLIENTES ###############################
public function RegistrarClientes()
	{
	self::SetNames();
	if(empty($_POST["tipocliente"]) or empty($_POST["dnicliente"]) or empty($_POST["direccliente"]))
	{
		echo "1";
		exit;
	}

	$sql = "SELECT codcliente FROM clientes ORDER BY idcliente DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$id=$row["codcliente"];

	}
	if(empty($id))
	{
		$codcliente = "C1";

	} else {

		$resto = substr($id, 0, 1);
		$coun = strlen($resto);
		$num     = substr($id, $coun);
		$codigo     = $num + 1;
		$codcliente = "C".$codigo;
	}

	$sql = "SELECT dnicliente FROM clientes WHERE dnicliente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["dnicliente"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$query = "INSERT INTO clientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcliente);
		$stmt->bindParam(2, $tipocliente);
		$stmt->bindParam(3, $documcliente);
		$stmt->bindParam(4, $dnicliente);
		$stmt->bindParam(5, $nomcliente);
		$stmt->bindParam(6, $razoncliente);
		$stmt->bindParam(7, $girocliente);
		$stmt->bindParam(8, $tlfcliente);
		$stmt->bindParam(9, $id_provincia);
		$stmt->bindParam(10, $id_departamento);
		$stmt->bindParam(11, $direccliente);
		$stmt->bindParam(12, $emailcliente);
		$stmt->bindParam(13, $limitecredito);
		$stmt->bindParam(14, $fechaingreso);
		
		$tipocliente = limpiar($_POST["tipocliente"]);
		$documcliente = limpiar($_POST['documcliente'] == '' ? "0" : $_POST['documcliente']);
		$dnicliente = limpiar($_POST["dnicliente"]);
		$nomcliente = limpiar($_POST['tipocliente'] == 'JURIDICO' ? "" : $_POST["nomcliente"]);
		$razoncliente = limpiar($_POST['tipocliente'] == 'NATURAL' ? "" : $_POST["razoncliente"]);
		$girocliente = limpiar($_POST['tipocliente'] == 'NATURAL' ? "" : $_POST["girocliente"]);
		$tlfcliente = limpiar($_POST["tlfcliente"]);
		$id_provincia = limpiar($_POST['id_provincia'] == '' ? "0" : $_POST['id_provincia']);
		$id_departamento = limpiar($_POST['id_departamento'] == '' ? "0" : $_POST['id_departamento']);
		$direccliente = limpiar($_POST["direccliente"]);
		$emailcliente = limpiar($_POST["emailcliente"]);
		$limitecredito = limpiar($_POST["limitecredito"]);
	    $fechaingreso = limpiar(date("Y-m-d"));
		$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> EL CLIENTE HA SIDO REGISTRADO EXITOSAMENTE";
		exit;

		} else {

		echo "2";
		exit;
	}
}
######################## FUNCION REGISTRAR CLIENTES ###############################

########################## FUNCION BUSQUEDA DE CLIENTES ###############################
public function BusquedaClientes() 
{
	self::SetNames();
	$sql ="SELECT
	clientes.codcliente,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	clientes.nomcliente,
	clientes.razoncliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	clientes.fechaingreso,
    documentos.documento,
	provincias.provincia,
	departamentos.departamento
	FROM clientes 
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento
	WHERE CONCAT(dnicliente, '',nomcliente, '',razoncliente, '',direccliente, '',emailcliente) 
	LIKE '%".limpiar($_GET['bclientes'])."%' LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BUSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################## FUNCION BUSQUEDA DE CLIENTES ###############################

############################ FUNCION LISTAR CLIENTES ################################
public function ListarClientes()
	{
self::SetNames();
	$sql = "SELECT
	clientes.codcliente,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	clientes.fechaingreso,
    documentos.documento,
	provincias.provincia,
	departamentos.departamento
	FROM clientes 
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
######################### FUNCION LISTAR CLIENTES ################################

######################### FUNCION ID CLIENTES #################################
public function ClientesPorId()
	{
	self::SetNames();
	$sql = "SELECT
	clientes.codcliente,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	clientes.fechaingreso,
    documentos.documento,
	provincias.provincia,
	departamentos.departamento
	FROM clientes 
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento WHERE clientes.codcliente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcliente"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID CLIENTES #################################
	
############################ FUNCION ACTUALIZAR CLIENTES ############################
public function ActualizarClientes()
{
	self::SetNames();
	if(empty($_POST["codcliente"]) or empty($_POST["tipocliente"]) or empty($_POST["dnicliente"]) or empty($_POST["direccliente"]))
	{
		echo "1";
		exit;
	}
	$sql = " SELECT dnicliente FROM clientes WHERE codcliente != ? AND dnicliente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codcliente"],$_POST["dnicliente"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
	$sql = "UPDATE clientes set "
	." tipocliente = ?, "
	." documcliente = ?, "
	." dnicliente = ?, "
	." nomcliente = ?, "
	." razoncliente = ?, "
	." girocliente = ?, "
	." tlfcliente = ?, "
	." id_provincia = ?, "
	." id_departamento = ?, "
	." direccliente = ?, "
	." emailcliente = ?, "
	." limitecredito = ? "
	." where "
	." codcliente = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $tipocliente);
    $stmt->bindParam(2, $documcliente);
	$stmt->bindParam(3, $dnicliente);
	$stmt->bindParam(4, $nomcliente);
	$stmt->bindParam(5, $razoncliente);
	$stmt->bindParam(6, $girocliente);
	$stmt->bindParam(7, $tlfcliente);
	$stmt->bindParam(8, $id_provincia);
	$stmt->bindParam(9, $id_departamento);
	$stmt->bindParam(10, $direccliente);
	$stmt->bindParam(11, $emailcliente);
	$stmt->bindParam(12, $limitecredito);
	$stmt->bindParam(13, $codcliente);
	
	$documcliente = limpiar($_POST['documcliente'] == '' ? "0" : $_POST['documcliente']);
	$dnicliente = limpiar($_POST["dnicliente"]);
	$nomcliente = limpiar($_POST['tipocliente'] == 'JURIDICO' ? "" : $_POST["nomcliente"]);
	$razoncliente = limpiar($_POST['tipocliente'] == 'NATURAL' ? "" : $_POST["razoncliente"]);
	$girocliente = limpiar($_POST['tipocliente'] == 'NATURAL' ? "" : $_POST["girocliente"]);
	$tlfcliente = limpiar($_POST["tlfcliente"]);
	$id_provincia = limpiar($_POST['id_provincia'] == '' ? "0" : $_POST['id_provincia']);
	$id_departamento = limpiar($_POST['id_departamento'] == '' ? "0" : $_POST['id_departamento']);
	$direccliente = limpiar($_POST["direccliente"]);
	$emailcliente = limpiar($_POST["emailcliente"]);
	$tipocliente = limpiar($_POST["tipocliente"]);
	$limitecredito = limpiar($_POST["limitecredito"]);
	$codcliente = limpiar($_POST["codcliente"]);
	$stmt->execute();
    
	echo "<span class='fa fa-check-square-o'></span> EL CLIENTE HA SIDO ACTUALIZADO EXITOSAMENTE";
	exit;

	} else {

		echo "2";
		exit;
	}
}
############################ FUNCION ACTUALIZAR CLIENTES ############################

########################### FUNCION ELIMINAR CLIENTES #################################
public function EliminarClientes()
	{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

	$sql = "SELECT codcliente FROM ventas WHERE codcliente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcliente"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{

		$sql = "DELETE FROM clientes where codcliente = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codcliente);
		$codcliente = decrypt($_GET["codcliente"]);
		$stmt->execute();

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
			
	} else {
		
		echo "3";
		exit;
	}	
}
########################## FUNCION ELIMINAR CLIENTES #################################

############################## FIN DE CLASE CLIENTES #################################


























################################## CLASE PROVEEDORES ###################################

########################## FUNCION CARGAR PROVEEDORES ###############################
public function CargarProveedores()
	{
		self::SetNames();
		if(empty($_FILES["sel_file"]))
		{
			echo "1";
			exit;
		}
        //Aquí es donde seleccionamos nuestro csv
         $fname = $_FILES['sel_file']['name'];
         //echo 'Cargando nombre del archivo: '.$fname.' ';
         $chk_ext = explode(".",$fname);
         
        if(strtolower(end($chk_ext)) == "csv")
        {
        //si es correcto, entonces damos permisos de lectura para subir
        $filename = $_FILES['sel_file']['tmp_name'];
        $handle = fopen($filename, "r");
        $this->dbh->beginTransaction();
        
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

               //Insertamos los datos con los valores...
			   
		$query = "INSERT INTO proveedores values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codproveedor);
		$stmt->bindParam(2, $documproveedor);
		$stmt->bindParam(3, $dniproveedor);
		$stmt->bindParam(4, $nomproveedor);
		$stmt->bindParam(5, $tlfproveedor);
		$stmt->bindParam(6, $id_provincia);
		$stmt->bindParam(7, $id_departamento);
		$stmt->bindParam(8, $direcproveedor);
		$stmt->bindParam(9, $emailproveedor);
		$stmt->bindParam(10, $vendedor);
		$stmt->bindParam(11, $tlfvendedor);
		$stmt->bindParam(12, $fechaingreso);

		$codproveedor = limpiar($data[0]);
		$documproveedor = limpiar($data[1]);
		$dniproveedor = limpiar($data[2]);
		$nomproveedor = limpiar($data[3]);
		$tlfproveedor = limpiar($data[4]);
		$id_provincia = limpiar($data[5]);
		$id_departamento = limpiar($data[6]);
		$direcproveedor = limpiar($data[7]);
		$emailproveedor = limpiar($data[8]);
		$vendedor = limpiar($data[9]);
		$tlfvendedor = limpiar($data[10]);
		$fechaingreso = limpiar(date("Y-m-d"));
		$stmt->execute();
				
        }
           $this->dbh->commit();
           //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
           fclose($handle);
	        
	echo "<span class='fa fa-check-square-o'></span> LA CARGA MASIVA DE PROVEEDORES FUE REALIZADA EXITOSAMENTE";
	exit;
             
         }
         else
         {
    //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para ver si esta separado por " , "
         echo "2";
		 exit;
      }  
}
############################# FUNCION CARGAR PROVEEDORES ##############################

############################ FUNCION REGISTRAR PROVEEDORES ##########################
public function RegistrarProveedores()
	{
		self::SetNames();
		if(empty($_POST["cuitproveedor"]) or empty($_POST["nomproveedor"]) or empty($_POST["direcproveedor"]))
		{
			echo "1";
			exit;
		}

		$sql = "SELECT codproveedor FROM proveedores ORDER BY idproveedor DESC LIMIT 1";
		foreach ($this->dbh->query($sql) as $row){

			$id=$row["codproveedor"];

		}
		if(empty($id))
		{
			$codproveedor = "P1";

		} else {

			$resto = substr($id, 0, 1);
			$coun = strlen($resto);
			$num     = substr($id, $coun);
			$codigo     = $num + 1;
			$codproveedor = "P".$codigo;
		}

		$sql = " SELECT cuitproveedor FROM proveedores WHERE cuitproveedor = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["cuitproveedor"]));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = " INSERT INTO proveedores values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codproveedor);
		    $stmt->bindParam(2, $documproveedor);
			$stmt->bindParam(3, $cuitproveedor);
			$stmt->bindParam(4, $nomproveedor);
			$stmt->bindParam(5, $tlfproveedor);
			$stmt->bindParam(6, $id_provincia);
			$stmt->bindParam(7, $id_departamento);
			$stmt->bindParam(8, $direcproveedor);
			$stmt->bindParam(9, $emailproveedor);
			$stmt->bindParam(10, $vendedor);
			$stmt->bindParam(11, $tlfvendedor);
			$stmt->bindParam(12, $fechaingreso);
			
			$documproveedor = limpiar($_POST['documproveedor'] == '' ? "0" : $_POST['documproveedor']);
			$cuitproveedor = limpiar($_POST["cuitproveedor"]);
			$nomproveedor = limpiar($_POST["nomproveedor"]);
			$tlfproveedor = limpiar($_POST["tlfproveedor"]);
			$id_provincia = limpiar($_POST['id_provincia'] == '' ? "0" : $_POST['id_provincia']);
			$id_departamento = limpiar($_POST['id_departamento'] == '' ? "0" : $_POST['id_departamento']);
			$direcproveedor = limpiar($_POST["direcproveedor"]);
			$emailproveedor = limpiar($_POST["emailproveedor"]);
			$vendedor = limpiar($_POST["vendedor"]);
			$tlfvendedor = limpiar($_POST["tlfvendedor"]);
		    $fechaingreso = limpiar(date("Y-m-d"));
			$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> EL PROVEEDOR HA SIDO REGISTRADO EXITOSAMENTE";
			exit;

		} else {

			echo "2";
			exit;
		}
	}
########################### FUNCION REGISTRAR PROVEEDORES ########################

########################### FUNCION LISTAR PROVEEDORES ################################
public function ListarProveedores()
	{
		self::SetNames();
	    $sql = "SELECT
		proveedores.codproveedor,
		proveedores.documproveedor,
		proveedores.cuitproveedor,
		proveedores.nomproveedor,
		proveedores.tlfproveedor,
		proveedores.id_provincia,
		proveedores.id_departamento,
		proveedores.direcproveedor,
		proveedores.emailproveedor,
		proveedores.vendedor,
		proveedores.tlfvendedor,
		proveedores.fechaingreso,
	    documentos.documento,
		provincias.provincia,
		departamentos.departamento
		FROM proveedores 
		LEFT JOIN documentos ON proveedores.documproveedor = documentos.coddocumento
		LEFT JOIN provincias ON proveedores.id_provincia = provincias.id_provincia 
		LEFT JOIN departamentos ON proveedores.id_departamento = departamentos.id_departamento";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################### FUNCION LISTAR PROVEEDORES ################################

########################### FUNCION ID PROVEEDORES #################################
public function ProveedoresPorId()
	{
		self::SetNames();
		$sql = "SELECT
		proveedores.codproveedor,
		proveedores.documproveedor,
		proveedores.cuitproveedor,
		proveedores.nomproveedor,
		proveedores.tlfproveedor,
		proveedores.id_provincia,
		proveedores.id_departamento,
		proveedores.direcproveedor,
		proveedores.emailproveedor,
		proveedores.vendedor,
		proveedores.tlfvendedor,
		proveedores.fechaingreso,
	    documentos.documento,
		provincias.provincia,
		departamentos.departamento
		FROM proveedores 
		LEFT JOIN documentos ON proveedores.documproveedor = documentos.coddocumento
		LEFT JOIN provincias ON proveedores.id_provincia = provincias.id_provincia 
		LEFT JOIN departamentos ON proveedores.id_departamento = departamentos.id_departamento WHERE proveedores.codproveedor = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codproveedor"])));
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
############################ FUNCION ID PROVEEDORES #################################
	
############################ FUNCION ACTUALIZAR PROVEEDORES ############################
public function ActualizarProveedores()
	{
	self::SetNames();
		if(empty($_POST["codproveedor"]) or empty($_POST["cuitproveedor"]) or empty($_POST["nomproveedor"]) or empty($_POST["direcproveedor"]))
		{
			echo "1";
			exit;
		}
		$sql = " SELECT cuitproveedor FROM proveedores WHERE codproveedor != ? AND cuitproveedor = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codproveedor"],$_POST["cuitproveedor"]));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$sql = "UPDATE proveedores set "
			." documproveedor = ?, "
			." cuitproveedor = ?, "
			." nomproveedor = ?, "
			." tlfproveedor = ?, "
			." id_provincia = ?, "
			." id_departamento = ?, "
			." direcproveedor = ?, "
			." emailproveedor = ?, "
			." vendedor = ?, "
			." tlfvendedor = ? "
			." where "
			." codproveedor = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $documproveedor);
			$stmt->bindParam(2, $cuitproveedor);
			$stmt->bindParam(3, $nomproveedor);
			$stmt->bindParam(4, $tlfproveedor);
			$stmt->bindParam(5, $id_provincia);
			$stmt->bindParam(6, $id_departamento);
			$stmt->bindParam(7, $direcproveedor);
			$stmt->bindParam(8, $emailproveedor);
			$stmt->bindParam(9, $vendedor);
			$stmt->bindParam(10, $tlfvendedor);
			$stmt->bindParam(11, $codproveedor);
			
			$documproveedor = limpiar($_POST['documproveedor'] == '' ? "0" : $_POST['documproveedor']);
			$cuitproveedor = limpiar($_POST["cuitproveedor"]);
			$nomproveedor = limpiar($_POST["nomproveedor"]);
			$tlfproveedor = limpiar($_POST["tlfproveedor"]);
			$id_provincia = limpiar($_POST['id_provincia'] == '' ? "0" : $_POST['id_provincia']);
			$id_departamento = limpiar($_POST['id_departamento'] == '' ? "0" : $_POST['id_departamento']);
			$direcproveedor = limpiar($_POST["direcproveedor"]);
			$emailproveedor = limpiar($_POST["emailproveedor"]);
			$vendedor = limpiar($_POST["vendedor"]);
			$tlfvendedor = limpiar($_POST["tlfvendedor"]);
			$codproveedor = limpiar($_POST["codproveedor"]);
			$stmt->execute();
        
		echo "<span class='fa fa-check-square-o'></span> EL PROVEEDOR HA SIDO ACTUALIZADO EXITOSAMENTE";
		exit;

		} else {

			echo "2";
			exit;
		}
	}
############################ FUNCION ACTUALIZAR PROVEEDORES ############################

########################## FUNCION ELIMINAR PROVEEDORES #################################
public function EliminarProveedores()
	{
	self::SetNames();
		if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

		$sql = "SELECT codproveedor FROM productos WHERE codproveedor = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codproveedor"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM proveedores where codproveedor = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codproveedor);
			$codproveedor = decrypt($_GET["codproveedor"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
########################### FUNCION ELIMINAR PROVEEDORES #########################

############################## FIN DE CLASE PROVEEDORES #################################




























###################################### CLASE PEDIDOS ###################################

############################ FUNCION REGISTRAR PEDIDOS #############################
public function RegistrarPedidos()
	{
	self::SetNames();
	if(empty($_POST["codsucursal"]) or empty($_POST["codproveedor"]) or empty($_POST["fecharegistro"]) or empty($_POST["observacionpedido"]))
	{
		echo "1";
		exit;
	}

	if(empty($_SESSION["CarritoPedido"]))
	{
		echo "2";
		exit;
		
	}

	################# OBTENGO DATOS DE SUCURSAL #################
	$sql = " SELECT 
	codsucursal, 
	nroactividadsucursal, 
	iniciofactura 
	FROM sucursales WHERE codsucursal = '".limpiar($_POST["codsucursal"])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$nroactividad = $row['nroactividadsucursal'];
	$iniciofactura = $row['iniciofactura'];
	################# OBTENGO DATOS DE SUCURSAL #################

	################ CREO CODIGO DE PEDIDO ####################
	$sql = "SELECT codpedido FROM pedidos 
	ORDER BY idpedido DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$pedido=$row["codpedido"];

	}
	if(empty($pedido))
	{
		$codpedido = "01";

	} else {

		$num = substr($pedido, 0);
        $dig = $num + 1;
        $codigofinal = str_pad($dig, 2, "0", STR_PAD_LEFT);
        $codpedido = $codigofinal;
	}
    ################ CREO CODIGO DE PEDIDO ###############

    ################### CREO CODIGO DE FACTURA ####################
	$sql = "SELECT codfactura FROM pedidos 
	WHERE codsucursal = '".limpiar($_POST["codsucursal"])."' 
	ORDER BY idpedido DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$factura=$row["codfactura"];

	}
	if(empty($pedido))
	{
		$codfactura = $nroactividad.'-'.$iniciofactura;

	} else {

		$var = strlen($nroactividad."-");
        $var1 = substr($factura , $var);
        $var2 = strlen($var1);
        $var3 = $var1 + 1;
        $var4 = str_pad($var3, $var2, "0", STR_PAD_LEFT);
        $codfactura = $nroactividad.'-'.$var4;
	}
    ################### CREO CODIGO DE FACTURA ####################

        $query = "INSERT INTO pedidos values (null, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codpedido);
		$stmt->bindParam(2, $codfactura);
		$stmt->bindParam(3, $codproveedor);
		$stmt->bindParam(4, $observacionpedido);
		$stmt->bindParam(5, $fechapedido);
		$stmt->bindParam(6, $codigo);
		$stmt->bindParam(7, $codsucursal);
	    
		$codproveedor = limpiar($_POST["codproveedor"]);
		$observacionpedido = limpiar($_POST["observacionpedido"]);
        $fechapedido = limpiar(date("Y-m-d",strtotime($_POST['fecharegistro'])));
		$codigo = limpiar($_SESSION["codigo"]);
		$codsucursal = limpiar($_POST["codsucursal"]);
		$stmt->execute();
		
		$this->dbh->beginTransaction();
		$detalle = $_SESSION["CarritoPedido"];
		for($i=0;$i<count($detalle);$i++){
		
        $query = "INSERT INTO detallepedidos values (null, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codpedido);
	    $stmt->bindParam(2, $codproducto);
	    $stmt->bindParam(3, $producto);
		$stmt->bindParam(4, $codmarca);
		$stmt->bindParam(5, $codmodelo);
		$stmt->bindParam(6, $cantpedido);
		$stmt->bindParam(7, $codsucursal);
			
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$producto = limpiar($detalle[$i]['producto']);
		$codmarca = limpiar($detalle[$i]['codmarca']);
		$codmodelo = limpiar($detalle[$i]['codmodelo']);
		$cantpedido = limpiar($detalle[$i]['cantidad']);
		$codsucursal = limpiar($_POST["codsucursal"]);
		$stmt->execute();
      }
        ####################### DESTRUYO LA VARIABLE DE SESSION #####################
      unset($_SESSION["CarritoPedido"]);
      $this->dbh->commit();
		
echo "<span class='fa fa-check-square-o'></span> EL PEDIDO DE PRODUCTOS HA SIDO REGISTRADO EXITOSAMENTE <a href='reportepdf?codpedido=".encrypt($codpedido)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURAPEDIDO")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

echo "<script>window.open('reportepdf?codpedido=".encrypt($codpedido)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURAPEDIDO")."', '_blank');</script>";
	exit;
}
############################ FUNCION REGISTRAR PEDIDOS ###############################

########################### FUNCION LISTAR PEDIDOS ################################
public function ListarPedidos()
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT 
	pedidos.codpedido, 
	pedidos.codfactura,
	pedidos.codproveedor, 
	pedidos.observacionpedido, 
	pedidos.fechapedido, 
	pedidos.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	proveedores.documproveedor, 
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	usuarios.dni, 
	usuarios.nombres, 
	SUM(detallepedidos.cantpedido) AS articulos 
	FROM (pedidos LEFT JOIN detallepedidos ON detallepedidos.codpedido = pedidos.codpedido) 
	LEFT JOIN sucursales ON pedidos.codsucursal = sucursales.codsucursal  
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN proveedores ON pedidos.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN usuarios ON pedidos.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	GROUP BY detallepedidos.codpedido 
	ORDER BY pedidos.idpedido ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

     } else {

   $sql = "SELECT 
	pedidos.codpedido, 
	pedidos.codfactura,
	pedidos.codproveedor, 
	pedidos.observacionpedido, 
	pedidos.fechapedido, 
	pedidos.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	proveedores.documproveedor, 
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	usuarios.dni, 
	usuarios.nombres, 
	SUM(detallepedidos.cantpedido) AS articulos 
	FROM (pedidos LEFT JOIN detallepedidos ON detallepedidos.codpedido = pedidos.codpedido) 
	LEFT JOIN sucursales ON pedidos.codsucursal = sucursales.codsucursal  
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN proveedores ON pedidos.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN usuarios ON pedidos.codigo = usuarios.codigo 
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	WHERE pedidos.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
	GROUP BY detallepedidos.codpedido 
	ORDER BY pedidos.idpedido ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

     }
}
############################# FUNCION LISTAR PEDIDOS ############################

############################ FUNCION ID PEDIDOS #################################
public function PedidosPorId()
{
	self::SetNames();
	$sql = "SELECT 
	pedidos.codpedido,
    pedidos.codfactura, 
	pedidos.codproveedor,
	pedidos.observacionpedido, 
	pedidos.fechapedido,
	pedidos.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.tlfsucursal,
	sucursales.correosucursal,
	sucursales.id_provincia,
	sucursales.id_departamento,
	sucursales.direcsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
    proveedores.documproveedor, 
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	proveedores.tlfproveedor, 
	proveedores.id_provincia, 
	proveedores.id_departamento, 
	proveedores.direcproveedor, 
	proveedores.emailproveedor,  
	proveedores.vendedor,
	proveedores.tlfvendedor,
    documentos.documento,
    documentos2.documento AS documento2, 
    documentos3.documento AS documento3, 
	usuarios.dni, 
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2
	FROM (pedidos INNER JOIN sucursales ON pedidos.codsucursal = sucursales.codsucursal)
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento 
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN proveedores ON proveedores.codproveedor = pedidos.codproveedor
    LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON proveedores.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON proveedores.id_departamento = departamentos2.id_departamento 
	LEFT JOIN usuarios ON pedidos.codigo = usuarios.codigo
	WHERE pedidos.codpedido = ? AND pedidos.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codpedido"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID PEDIDOS #################################
	
########################### FUNCION VER DETALLES PEDIDOS ###########################
public function VerDetallesPedidos()
{
	self::SetNames();
	$sql = "SELECT * FROM detallepedidos 
	INNER JOIN marcas ON detallepedidos.codmarca = marcas.codmarca 
	LEFT JOIN modelos ON detallepedidos.codmodelo = modelos.codmodelo 
	WHERE detallepedidos.codpedido = ? 
	AND detallepedidos.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codpedido"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
}
########################### FUNCION VER DETALLES PEDIDOS ############################

########################### FUNCION ACTUALIZAR PEDIDOS #############################
public function ActualizarPedidos()
	{
	self::SetNames();
	if(empty($_POST["codsucursal"]) or empty($_POST["codproveedor"]) or empty($_POST["fechapedido"]) or empty($_POST["observacionpedido"]))
	{
		echo "1";
		exit;
	}


	for($i=0;$i<count($_POST['coddetallepedido']);$i++){  //recorro el array
        if (!empty($_POST['coddetallepedido'][$i])) {

	       if($_POST['cantpedido'][$i]==0){

		      echo "2";
		      exit();

	       }
        }
    }

	$sql = " UPDATE pedidos SET "
		  ." codproveedor = ?, "
		  ." observacionpedido = ?, "
		  ." fechapedido= ? "
		  ." WHERE "
		  ." codpedido = ? AND codsucursal = ?;
		   ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $codproveedor);
	$stmt->bindParam(2, $observacionpedido);
	$stmt->bindParam(3, $fechapedido);
	$stmt->bindParam(4, $codpedido);
	$stmt->bindParam(5, $codsucursal);
	
	$codproveedor = limpiar($_POST["codproveedor"]);
	$observacionpedido = limpiar($_POST["observacionpedido"]);
    $fechapedido = limpiar(date("Y-m-d H:i:s",strtotime($_POST['fechapedido'])));
	$codpedido = limpiar($_POST["codpedido"]);
	$codsucursal = limpiar($_POST["codsucursal"]);
	$stmt->execute();

    $this->dbh->beginTransaction();
	for($i=0;$i<count($_POST['coddetallepedido']);$i++){  //recorro el array
	if (!empty($_POST['coddetallepedido'][$i])) {

		$query = "UPDATE detallepedidos set"
		." cantpedido = ? "
		." WHERE "
		." coddetallepedido = ? AND codpedido = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $cantpedido);
		$stmt->bindParam(2, $coddetallepedido);
		$stmt->bindParam(3, $codpedido);
		$stmt->bindParam(4, $codsucursal);

		$cantpedido = limpiar($_POST['cantpedido'][$i]);
		$coddetallepedido = limpiar($_POST['coddetallepedido'][$i]);
		$codpedido = limpiar($_POST["codpedido"]);
		$codsucursal = limpiar($_POST["codsucursal"]);
		$stmt->execute();

	    }
    }
    $this->dbh->commit();


echo "<span class='fa fa-check-square-o'></span> EL PEDIDO DE PRODUCTOS HA SIDO ACTUALIZADO EXITOSAMENTE <a href='reportepdf?codpedido=".encrypt($codpedido)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURAPEDIDO")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

echo "<script>window.open('reportepdf?codpedido=".encrypt($codpedido)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURAPEDIDO")."', '_blank');</script>";
	exit;
	//}
}
########################### FUNCION ACTUALIZAR PEDIDOS ############################

########################### FUNCION ACTUALIZAR PEDIDOS ############################
public function AgregarDetallesPedidos()
	{
	self::SetNames();
	if(empty($_POST["codproveedor"]) or empty($_POST["fechapedido"]) or empty($_POST["observacionpedido"]))
	{
		echo "1";
		exit;
	}


    if(empty($_SESSION["CarritoPedido"]))
	{
		echo "2";
		exit;
		
	} else {


	$sql = " UPDATE pedidos SET "
		  ." codproveedor = ?, "
		  ." observacionpedido = ?, "
		  ." fechapedido= ? "
		  ." WHERE "
		  ." codpedido = ? AND codsucursal = ?;
		   ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $codproveedor);
	$stmt->bindParam(2, $observacionpedido);
	$stmt->bindParam(3, $fechapedido);
	$stmt->bindParam(4, $codpedido);
	$stmt->bindParam(5, $codsucursal);
	
	$codproveedor = limpiar($_POST["codproveedor"]);
	$observacionpedido = limpiar($_POST["observacionpedido"]);
    $fechapedido = limpiar(date("Y-m-d H:i:s",strtotime($_POST['fechapedido'])));
	$codpedido = limpiar($_POST["codpedido"]);
	$codsucursal = limpiar($_POST["codsucursal"]);
	$stmt->execute();

    $this->dbh->beginTransaction();
    $detalle = $_SESSION["CarritoPedido"];
	for($i=0;$i<count($detalle);$i++){

	$sql = "SELECT codpedido, codproducto FROM detallepedidos WHERE codpedido = '".limpiar($_POST['codpedido'])."' AND codsucursal = '".limpiar($_POST['codsucursal'])."' AND codproducto = '".limpiar($detalle[$i]['txtCodigo'])."'";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute();
			$num = $stmt->rowCount();
			if($num == 0)
			{

        $query = "INSERT INTO detallepedidos values (null, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codpedido);
	    $stmt->bindParam(2, $codproducto);
	    $stmt->bindParam(3, $producto);
		$stmt->bindParam(4, $codmarca);
		$stmt->bindParam(5, $codmodelo);
		$stmt->bindParam(6, $cantpedido);
		$stmt->bindParam(7, $codsucursal);
			
		$codpedido = limpiar($_POST["codpedido"]);
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$producto = limpiar($detalle[$i]['producto']);
		$codmarca = limpiar($detalle[$i]['codmarca']);
		$codmodelo = limpiar($detalle[$i]['codmodelo']);
		$cantpedido = limpiar($detalle[$i]['cantidad']);
        $codsucursal = limpiar($_POST['codsucursal']);
		$stmt->execute();

	  } else {

	  	$sql = "SELECT cantpedido FROM detallepedidos WHERE codpedido = '".limpiar($_POST['codpedido'])."' AND codsucursal = '".limpiar($_POST['codsucursal'])."' AND codproducto = '".limpiar($detalle[$i]['txtCodigo'])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$cantidad = $row['cantpedido'];

	  	$query = "UPDATE detallepedidos set"
		." codmodelo = ?, "
		." cantpedido = ? "
		." WHERE "
		." codpedido = ? AND codsucursal = ? AND codproducto = ?;
		";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codmodelo);
		$stmt->bindParam(2, $cantpedido);
		$stmt->bindParam(3, $codpedido);
		$stmt->bindParam(4, $codsucursal);
		$stmt->bindParam(5, $codproducto);

		$codmodelo = limpiar($detalle[$i]['codmodelo']);
		$cantpedido = limpiar($detalle[$i]['cantidad']+$cantidad);
		$codpedido = limpiar($_POST["codpedido"]);
		$codsucursal = limpiar($_POST["codsucursal"]);
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$stmt->execute();
	 }
   }
      ####################### DESTRUYO LA VARIABLE DE SESSION #####################
	  unset($_SESSION["CarritoPedido"]);
      $this->dbh->commit();

echo "<span class='fa fa-check-square-o'></span> LOS DETALLES DE PRODUCTOS FUERON AGREGADOS AL PEDIDO EXITOSAMENTE <a href='reportepdf?codpedido=".encrypt($codpedido)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURAPEDIDO")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

echo "<script>window.open('reportepdf?codpedido=".encrypt($codpedido)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURAPEDIDO")."', '_blank');</script>";
	exit;
	}
}
########################### FUNCION ACTUALIZAR PEDIDOS ############################

########################## FUNCION ELIMINAR DETALLES PEDIDOS #########################
public function EliminarDetallesPedidos()
	{
	self::SetNames();
		if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

		$sql = "SELECT * FROM detallepedidos where codpedido = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codpedido"]),decrypt($_GET["codsucursal"])));
		$num = $stmt->rowCount();
		if($num > 1)
		{

			$sql = "DELETE FROM detallepedidos WHERE coddetallepedido = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$coddetallepedido);
			$coddetallepedido = decrypt($_GET["coddetallepedido"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
######################## FUNCION ELIMINAR DETALLES PEDIDOS #########################

######################### FUNCION ELIMINAR PEDIDOS ###############################
public function EliminarPedidos()
	{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

		$sql = "DELETE FROM pedidos WHERE codpedido = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codpedido);
		$stmt->bindParam(2,$codsucursal);
		$codpedido = decrypt($_GET["codpedido"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();

		$sql = "DELETE FROM detallepedidos WHERE codpedido = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codpedido);
		$stmt->bindParam(2,$codsucursal);
		$codpedido = decrypt($_GET["codpedido"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();

		echo "1";
		exit;

	} else {

		echo "2";
		exit;
	}
}
####################### FUNCION ELIMINAR PEDIDOS #################################

###################### FUNCION BUSQUEDA PEDIDOS POR PROVEEDORES ######################
public function BuscarPedidosxProveedor() 
{
    self::SetNames();
	$sql = "SELECT 
	pedidos.codpedido,
	pedidos.codfactura, 
	pedidos.codproveedor, 
	pedidos.observacionpedido, 
	pedidos.fechapedido, 
	pedidos.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
    proveedores.documproveedor, 
	proveedores.codproveedor, 
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	proveedores.tlfproveedor, 
	proveedores.direcproveedor, 
	proveedores.vendedor, 
    documentos.documento,
    documentos2.documento AS documento2, 
    documentos3.documento AS documento3, 
	provincias.provincia, 
	departamentos.departamento,
	SUM(detallepedidos.cantpedido) as articulos 
	FROM (pedidos LEFT JOIN detallepedidos ON pedidos.codpedido=detallepedidos.codpedido)
	LEFT JOIN sucursales ON pedidos.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN proveedores ON pedidos.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN provincias ON proveedores.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON proveedores.id_departamento = departamentos.id_departamento 
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	WHERE pedidos.codsucursal = ? 
	AND pedidos.codproveedor = ? 
	GROUP BY detallepedidos.codpedido";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codsucursal"]),decrypt($_GET["codproveedor"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PEDIDOS PARA EL PROVEEDOR SELECCIONADO</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA PEDIDOS POR PROVEEDORES ######################

############################# FIN DE CLASE PEDIDOS #################################


























################################# CLASE PRODUCTOS ######################################

############################### FUNCION CARGAR PRODUCTOS ##############################
public function CargarProductos()
	{
	self::SetNames();
	if(empty($_FILES["sel_file"]))
	{
		echo "1";
		exit;
	}

  //$porcentaje=($_SESSION['acceso']=="administradorG" ? "0.00" : $_SESSION['porcentaje']);

    //Aquí es donde seleccionamos nuestro csv
     $fname = $_FILES['sel_file']['name'];
     //echo 'Cargando nombre del archivo: '.$fname.' ';
     $chk_ext = explode(".",$fname);
     
    if(strtolower(end($chk_ext)) == "csv")
    {
    //si es correcto, entonces damos permisos de lectura para subir
    $filename = $_FILES['sel_file']['tmp_name'];
    $handle = fopen($filename, "r");
    $this->dbh->beginTransaction();
    
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

    //Insertamos los datos con los valores...
    $query = "INSERT INTO productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    	$stmt = $this->dbh->prepare($query);
    	$stmt->bindParam(1, $codproducto);
    	$stmt->bindParam(2, $producto);
    	$stmt->bindParam(3, $fabricante);
    	$stmt->bindParam(4, $codfamilia);
    	$stmt->bindParam(5, $codsubfamilia);
    	$stmt->bindParam(6, $codmarca);
    	$stmt->bindParam(7, $codmodelo);
    	$stmt->bindParam(8, $codpresentacion);
    	$stmt->bindParam(9, $codcolor);
    	$stmt->bindParam(10, $codorigen);
    	$stmt->bindParam(11, $year);
    	$stmt->bindParam(12, $nroparte);
    	$stmt->bindParam(13, $lote);
    	$stmt->bindParam(14, $peso);
    	$stmt->bindParam(15, $preciocompra);
    	$stmt->bindParam(16, $precioxmenor);
    	$stmt->bindParam(17, $precioxmayor);
    	$stmt->bindParam(18, $precioxpublico);
    	$stmt->bindParam(19, $existencia);
    	$stmt->bindParam(20, $stockoptimo);
    	$stmt->bindParam(21, $stockmedio);
    	$stmt->bindParam(22, $stockminimo);
    	$stmt->bindParam(23, $ivaproducto);
    	$stmt->bindParam(24, $descproducto);
    	$stmt->bindParam(25, $codigobarra);
    	$stmt->bindParam(26, $fechaelaboracion);
    	$stmt->bindParam(27, $fechaoptimo);
    	$stmt->bindParam(28, $fechamedio);
    	$stmt->bindParam(29, $fechaminimo);
    	$stmt->bindParam(30, $codproveedor);
    	$stmt->bindParam(31, $stockteorico);
    	$stmt->bindParam(32, $motivoajuste);
    	$stmt->bindParam(33, $codsucursal);

    	$codproducto = limpiar($data[0]);
    	$producto = limpiar($data[1]);
    	$fabricante = limpiar($data[2]);
    	$codfamilia = limpiar($data[3]);
    	$codsubfamilia = limpiar($data[4]);
    	$codmarca = limpiar($data[5]);
    	$codmodelo = limpiar($data[6]);
    	$codpresentacion = limpiar($data[7]);
    	$codcolor = limpiar($data[8]);
    	$codorigen = limpiar($data[9]);
    	$year = limpiar($data[10]);
    	$nroparte = limpiar($data[11]);
    	$lote = limpiar($data[12]);
    	$peso = limpiar($data[13]);
    	$preciocompra = limpiar($data[14]);
    	$precioxmenor = limpiar($data[15]);
    	$precioxmayor = limpiar($data[16]);
    	$precioxpublico = limpiar($data[17]);
    	$existencia = limpiar($data[18]);
    	$stockoptimo = limpiar($data[19]);
    	$stockmedio = limpiar($data[20]);
    	$stockminimo = limpiar($data[21]);
    	$ivaproducto = limpiar($data[22]);
    	$descproducto = limpiar($data[23]);
    	$codigobarra = limpiar($data[24]);
    	$fechaelaboracion = limpiar($data[25]);
    	$fechaoptimo = limpiar($data[26]);
    	$fechamedio = limpiar($data[27]);
    	$fechaminimo = limpiar($data[28]);
    	$codproveedor = limpiar($data[29]);
    	$stockteorico = limpiar("0");
    	$motivoajuste = limpiar("NINGUNO");
    	$codsucursal = limpiar($_SESSION["codsucursal"]);
    	$stmt->execute();

    	##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX #####################
		$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codproceso);
		$stmt->bindParam(2, $codresponsable);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);
		$stmt->bindParam(14, $tipokardex);
		$stmt->bindParam(15, $codsucursal);
		
		$codproceso = limpiar($data[0]);
		$codresponsable = limpiar("0");
		$codproducto = limpiar($data[0]);
		$movimiento = limpiar("ENTRADAS");
		$entradas = limpiar($data[18]);
		$salidas = limpiar("0");
		$devolucion = limpiar("0");
		$stockactual = limpiar($data[18]);
		$ivaproducto = limpiar($data[22]);
		$descproducto = limpiar($data[23]);
		$precio = limpiar("0.00");
		$documento = limpiar("INVENTARIO INICIAL");
		$fechakardex = limpiar(date("Y-m-d"));
		$tipokardex = limpiar("1");
    	$codsucursal = limpiar($_SESSION["codsucursal"]);
		$stmt->execute();
		##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX #####################
	
    }
           
    $this->dbh->commit();
    //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
    fclose($handle);
	        
	echo "<span class='fa fa-check-square-o'></span> LA CARGA MASIVA DE PRODUCTOS FUE REALIZADA EXITOSAMENTE";
	exit;
             
    }
    else
    {
    //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para ver si esta separado por " , "
        echo "2";
		exit;
    }  
}
############################## FUNCION CARGAR PRODUCTOS ##############################

########################### FUNCION REGISTRAR PRODUCTOS ###############################
public function RegistrarProductos()
	{
	self::SetNames();
	if(empty($_POST["codproducto"]) or empty($_POST["producto"]) or empty($_POST["codfamilia"]))
	{
		echo "1";
		exit;
	}


	$sql = " SELECT codproducto FROM productos WHERE codproducto = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codproducto"],$_POST["codsucursal"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
	    $query = "INSERT INTO productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codproducto);
		$stmt->bindParam(2, $producto);
		$stmt->bindParam(3, $fabricante);
		$stmt->bindParam(4, $codfamilia);
		$stmt->bindParam(5, $codsubfamilia);
		$stmt->bindParam(6, $codmarca);
		$stmt->bindParam(7, $codmodelo);
		$stmt->bindParam(8, $codpresentacion);
		$stmt->bindParam(9, $codcolor);
		$stmt->bindParam(10, $codorigen);
		$stmt->bindParam(11, $year);
		$stmt->bindParam(12, $nroparte);
		$stmt->bindParam(13, $lote);
		$stmt->bindParam(14, $peso);
		$stmt->bindParam(15, $preciocompra);
		$stmt->bindParam(16, $precioxmenor);
		$stmt->bindParam(17, $precioxmayor);
		$stmt->bindParam(18, $precioxpublico);
		$stmt->bindParam(19, $existencia);
		$stmt->bindParam(20, $stockoptimo);
		$stmt->bindParam(21, $stockmedio);
		$stmt->bindParam(22, $stockminimo);
		$stmt->bindParam(23, $ivaproducto);
		$stmt->bindParam(24, $descproducto);
		$stmt->bindParam(25, $codigobarra);
		$stmt->bindParam(26, $fechaelaboracion);
		$stmt->bindParam(27, $fechaoptimo);
		$stmt->bindParam(28, $fechamedio);
		$stmt->bindParam(29, $fechaminimo);
		$stmt->bindParam(30, $codproveedor);
		$stmt->bindParam(31, $stockteorico);
		$stmt->bindParam(32, $motivoajuste);
		$stmt->bindParam(33, $codsucursal);

		$codproducto = limpiar($_POST["codproducto"]);
		$producto = limpiar($_POST["producto"]);
		$fabricante = limpiar($_POST["fabricante"]);
		$codfamilia = limpiar($_POST["codfamilia"]);
		$codsubfamilia = limpiar($_POST['codsubfamilia'] == '' ? "0" : $_POST['codsubfamilia']);
		$codmarca = limpiar($_POST["codmarca"]);
		$codmodelo = limpiar($_POST['codmodelo'] == '' ? "0" : $_POST['codmodelo']);
		$codpresentacion = limpiar($_POST['codpresentacion'] == '' ? "0" : $_POST['codpresentacion']);
		$codcolor = limpiar($_POST['codcolor'] == '' ? "0" : $_POST['codcolor']);
		$codorigen = limpiar($_POST['codorigen'] == '' ? "0" : $_POST['codorigen']);
		$year = limpiar($_POST["year"]);
		$nroparte = limpiar($_POST["nroparte"]);
		$lote = limpiar($_POST['lote'] == '' ? "0" : $_POST['lote']);
		$peso = limpiar($_POST["peso"]);
		$preciocompra = limpiar($_POST["preciocompra"]);
		$precioxmenor = limpiar($_POST["precioxmenor"]);
		$precioxmayor = limpiar($_POST["precioxmayor"]);
		$precioxpublico = limpiar($_POST["precioxpublico"]);
		$existencia = limpiar($_POST["existencia"]);
		$stockoptimo = limpiar($_POST["stockoptimo"]);
		$stockmedio = limpiar($_POST["stockmedio"]);
		$stockminimo = limpiar($_POST["stockminimo"]);
		$ivaproducto = limpiar($_POST["ivaproducto"]);
		$descproducto = limpiar($_POST["descproducto"]);
		$codigobarra = limpiar($_POST["codigobarra"]);
		$fechaelaboracion = limpiar($_POST['fechaelaboracion'] == '' ? "0000-00-00" : date("Y-m-d",strtotime($_POST['fechaelaboracion'])));
		$fechaoptimo = limpiar($_POST['fechaoptimo'] == '' ? "0000-00-00" : date("Y-m-d",strtotime($_POST['fechaoptimo'])));
		$fechamedio = limpiar($_POST['fechamedio'] == '' ? "0000-00-00" : date("Y-m-d",strtotime($_POST['fechamedio'])));
		$fechaminimo = limpiar($_POST['fechaminimo'] == '' ? "0000-00-00" : date("Y-m-d",strtotime($_POST['fechaminimo'])));
		$codproveedor = limpiar($_POST["codproveedor"]);
		$stockteorico = limpiar("0");
		$motivoajuste = limpiar("NINGUNO");
		$codsucursal = limpiar($_POST["codsucursal"]);
		$stmt->execute();

		##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX #####################
		$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codproceso);
		$stmt->bindParam(2, $codresponsable);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);
		$stmt->bindParam(14, $tipokardex);
		$stmt->bindParam(15, $codsucursal);

		$codproceso = limpiar($_POST['codproducto']);
		$codresponsable = limpiar("0");
		$codproducto = limpiar($_POST['codproducto']);
		$movimiento = limpiar("ENTRADAS");
		$entradas = limpiar($_POST['existencia']);
		$salidas = limpiar("0");
		$devolucion = limpiar("0");
		$stockactual = limpiar($_POST['existencia']);
		$ivaproducto = limpiar($_POST["ivaproducto"]);
		$descproducto = limpiar($_POST["descproducto"]);
		$precio = limpiar("0.00");
		$documento = limpiar("INVENTARIO INICIAL");
		$fechakardex = limpiar(date("Y-m-d"));
		$tipokardex = limpiar("1");
		$codsucursal = limpiar($_POST["codsucursal"]);
		$stmt->execute();
		##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX #####################


	##################  SUBIR FOTO DE PRODUCTO ######################################
         //datos del arhivo  
if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo =''; }
if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo =''; }
if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo =''; } 
         //compruebo si las características del archivo son las que deseo  
if ((strpos($tipo_archivo,'image/jpeg')!==false)&&$tamano_archivo<200000) 
		 {  
if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/productos/".$nombre_archivo) && rename("fotos/productos/".$nombre_archivo,"fotos/productos/".$codproducto.".jpg"))
		 { 
		 ## se puede dar un aviso
		 } 
		 ## se puede dar otro aviso 
		 }
	##################  FINALIZA SUBIR FOTO DE PRODUCTO ######################################

		echo "<span class='fa fa-check-square-o'></span> EL PRODUCTO HA SIDO REGISTRADO EXITOSAMENTE";
		exit;

	} else {

		echo "2";
		exit;
	}
}
########################## FUNCION REGISTRAR PRODUCTOS ###############################

########################### FUNCION LISTAR PRODUCTOS ################################
public function ListarProductos()
	{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.fabricante,
	productos.codfamilia,
	productos.codsubfamilia,
	productos.codmarca,
	productos.codmodelo,
	productos.codpresentacion,
	productos.codcolor,
	productos.codorigen,
	productos.year,
	productos.nroparte,
	productos.lote,
	productos.peso,
	productos.preciocompra,
	productos.precioxmenor,
	productos.precioxmayor,
	productos.precioxpublico,
	productos.existencia,
	productos.stockoptimo,
	productos.stockmedio,
	productos.stockminimo,
	productos.ivaproducto,
	productos.descproducto,
	productos.codigobarra,
	productos.fechaelaboracion,
	productos.fechaoptimo,
	productos.fechamedio,
	productos.fechaminimo,
	productos.codproveedor,
	productos.stockteorico,
	productos.motivoajuste,
	productos.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	familias.nomfamilia,
	subfamilias.nomsubfamilia,
	marcas.nommarca,
	modelos.nommodelo,
	presentaciones.nompresentacion,
	colores.nomcolor,
	origenes.nomorigen,
	proveedores.cuitproveedor,
	proveedores.nomproveedor,
	provincias.provincia,
	departamentos.departamento
	FROM (productos INNER JOIN sucursales ON productos.codsucursal = sucursales.codsucursal)
    LEFT JOIN familias ON productos.codfamilia=familias.codfamilia
	LEFT JOIN subfamilias ON productos.codsubfamilia=subfamilias.codsubfamilia 
	LEFT JOIN marcas ON productos.codmarca=marcas.codmarca 
	LEFT JOIN modelos ON productos.codmodelo = modelos.codmodelo
	LEFT JOIN presentaciones ON productos.codpresentacion=presentaciones.codpresentacion 
	LEFT JOIN colores ON productos.codcolor=colores.codcolor 
	LEFT JOIN origenes ON productos.codorigen=origenes.codorigen 
	LEFT JOIN proveedores ON productos.codproveedor=proveedores.codproveedor
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	WHERE productos.codsucursal = ?";
    $stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
	    exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}

	} else {

    $sql = "SELECT
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.fabricante,
	productos.codfamilia,
	productos.codsubfamilia,
	productos.codmarca,
	productos.codmodelo,
	productos.codpresentacion,
	productos.codcolor,
	productos.codorigen,
	productos.year,
	productos.nroparte,
	productos.lote,
	productos.peso,
	productos.preciocompra,
	productos.precioxmenor,
	productos.precioxmayor,
	productos.precioxpublico,
	productos.existencia,
	productos.stockoptimo,
	productos.stockmedio,
	productos.stockminimo,
	productos.ivaproducto,
	productos.descproducto,
	productos.codigobarra,
	productos.fechaelaboracion,
	productos.fechaoptimo,
	productos.fechamedio,
	productos.fechaminimo,
	productos.codproveedor,
	productos.stockteorico,
	productos.motivoajuste,
	productos.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	familias.nomfamilia,
	subfamilias.nomsubfamilia,
	marcas.nommarca,
	modelos.nommodelo,
	presentaciones.nompresentacion,
	colores.nomcolor,
	origenes.nomorigen,
	proveedores.cuitproveedor,
	proveedores.nomproveedor,
	provincias.provincia,
	departamentos.departamento
	FROM (productos INNER JOIN sucursales ON productos.codsucursal = sucursales.codsucursal)
    LEFT JOIN familias ON productos.codfamilia=familias.codfamilia
	LEFT JOIN subfamilias ON productos.codsubfamilia=subfamilias.codsubfamilia 
	LEFT JOIN marcas ON productos.codmarca=marcas.codmarca 
	LEFT JOIN modelos ON productos.codmodelo = modelos.codmodelo
	LEFT JOIN presentaciones ON productos.codpresentacion=presentaciones.codpresentacion 
	LEFT JOIN colores ON productos.codcolor=colores.codcolor 
	LEFT JOIN origenes ON productos.codorigen=origenes.codorigen 
	LEFT JOIN proveedores ON productos.codproveedor=proveedores.codproveedor
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2

	WHERE productos.codsucursal = '".limpiar($_SESSION["codsucursal"])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
    }
}
########################## FUNCION LISTAR PRODUCTOS ################################

########################### FUNCION LISTAR PRODUCTOS EN STOCK OPTIMO ################################
public function ListarProductosOptimo()
	{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {
		
    $sql = "SELECT
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.fabricante,
	productos.codfamilia,
	productos.codsubfamilia,
	productos.codmarca,
	productos.codmodelo,
	productos.codpresentacion,
	productos.codcolor,
	productos.codorigen,
	productos.year,
	productos.nroparte,
	productos.lote,
	productos.peso,
	productos.preciocompra,
	productos.precioxmenor,
	productos.precioxmayor,
	productos.precioxpublico,
	productos.existencia,
	productos.stockoptimo,
	productos.stockmedio,
	productos.stockminimo,
	productos.ivaproducto,
	productos.descproducto,
	productos.codigobarra,
	productos.fechaelaboracion,
	productos.fechaoptimo,
	productos.fechamedio,
	productos.fechaminimo,
	productos.codproveedor,
	productos.stockteorico,
	productos.motivoajuste,
	productos.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	familias.nomfamilia,
	subfamilias.nomsubfamilia,
	marcas.nommarca,
	modelos.nommodelo,
	presentaciones.nompresentacion,
	colores.nomcolor,
	origenes.nomorigen,
	proveedores.cuitproveedor,
	proveedores.nomproveedor,
	provincias.provincia,
	departamentos.departamento
	FROM (productos INNER JOIN sucursales ON productos.codsucursal = sucursales.codsucursal)
    LEFT JOIN familias ON productos.codfamilia=familias.codfamilia
	LEFT JOIN subfamilias ON productos.codsubfamilia=subfamilias.codsubfamilia 
	LEFT JOIN marcas ON productos.codmarca=marcas.codmarca 
	LEFT JOIN modelos ON productos.codmodelo = modelos.codmodelo
	LEFT JOIN presentaciones ON productos.codpresentacion=presentaciones.codpresentacion 
	LEFT JOIN colores ON productos.codcolor=colores.codcolor 
	LEFT JOIN origenes ON productos.codorigen=origenes.codorigen 
	LEFT JOIN proveedores ON productos.codproveedor=proveedores.codproveedor
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	WHERE productos.codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."' 
	AND productos.existencia <= productos.stockoptimo 
	AND productos.existencia > productos.stockmedio";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
} 
else {

    $sql = "SELECT
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.fabricante,
	productos.codfamilia,
	productos.codsubfamilia,
	productos.codmarca,
	productos.codmodelo,
	productos.codpresentacion,
	productos.codcolor,
	productos.codorigen,
	productos.year,
	productos.nroparte,
	productos.lote,
	productos.peso,
	productos.preciocompra,
	productos.precioxmenor,
	productos.precioxmayor,
	productos.precioxpublico,
	productos.existencia,
	productos.stockoptimo,
	productos.stockmedio,
	productos.stockminimo,
	productos.ivaproducto,
	productos.descproducto,
	productos.codigobarra,
	productos.fechaelaboracion,
	productos.fechaoptimo,
	productos.fechamedio,
	productos.fechaminimo,
	productos.codproveedor,
	productos.stockteorico,
	productos.motivoajuste,
	productos.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	familias.nomfamilia,
	subfamilias.nomsubfamilia,
	marcas.nommarca,
	modelos.nommodelo,
	presentaciones.nompresentacion,
	colores.nomcolor,
	origenes.nomorigen,
	proveedores.cuitproveedor,
	proveedores.nomproveedor,
	provincias.provincia,
	departamentos.departamento
	FROM (productos INNER JOIN sucursales ON productos.codsucursal = sucursales.codsucursal)
    LEFT JOIN familias ON productos.codfamilia=familias.codfamilia
	LEFT JOIN subfamilias ON productos.codsubfamilia=subfamilias.codsubfamilia 
	LEFT JOIN marcas ON productos.codmarca=marcas.codmarca 
	LEFT JOIN modelos ON productos.codmodelo = modelos.codmodelo
	LEFT JOIN presentaciones ON productos.codpresentacion=presentaciones.codpresentacion 
	LEFT JOIN colores ON productos.codcolor=colores.codcolor 
	LEFT JOIN origenes ON productos.codorigen=origenes.codorigen 
	LEFT JOIN proveedores ON productos.codproveedor=proveedores.codproveedor
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	WHERE productos.codsucursal = '".limpiar($_SESSION["codsucursal"])."' AND productos.existencia <= productos.stockoptimo AND productos.existencia > productos.stockmedio";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
  }
}
########################## FUNCION LISTAR PRODUCTOS EN STOCK OPTIMO ################################

########################### FUNCION LISTAR PRODUCTOS EN STOCK MEDIO ################################
public function ListarProductosMedio()
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {
		
    $sql = "SELECT
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.fabricante,
	productos.codfamilia,
	productos.codsubfamilia,
	productos.codmarca,
	productos.codmodelo,
	productos.codpresentacion,
	productos.codcolor,
	productos.codorigen,
	productos.year,
	productos.nroparte,
	productos.lote,
	productos.peso,
	productos.preciocompra,
	productos.precioxmenor,
	productos.precioxmayor,
	productos.precioxpublico,
	productos.existencia,
	productos.stockoptimo,
	productos.stockmedio,
	productos.stockminimo,
	productos.ivaproducto,
	productos.descproducto,
	productos.codigobarra,
	productos.fechaelaboracion,
	productos.fechaoptimo,
	productos.fechamedio,
	productos.fechaminimo,
	productos.codproveedor,
	productos.stockteorico,
	productos.motivoajuste,
	productos.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	familias.nomfamilia,
	subfamilias.nomsubfamilia,
	marcas.nommarca,
	modelos.nommodelo,
	presentaciones.nompresentacion,
	colores.nomcolor,
	origenes.nomorigen,
	proveedores.cuitproveedor,
	proveedores.nomproveedor,
	provincias.provincia,
	departamentos.departamento
	FROM (productos INNER JOIN sucursales ON productos.codsucursal = sucursales.codsucursal)
    LEFT JOIN familias ON productos.codfamilia=familias.codfamilia
	LEFT JOIN subfamilias ON productos.codsubfamilia=subfamilias.codsubfamilia 
	LEFT JOIN marcas ON productos.codmarca=marcas.codmarca 
	LEFT JOIN modelos ON productos.codmodelo = modelos.codmodelo
	LEFT JOIN presentaciones ON productos.codpresentacion=presentaciones.codpresentacion 
	LEFT JOIN colores ON productos.codcolor=colores.codcolor 
	LEFT JOIN origenes ON productos.codorigen=origenes.codorigen 
	LEFT JOIN proveedores ON productos.codproveedor=proveedores.codproveedor
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	WHERE productos.codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."' 
	AND productos.existencia <= productos.stockmedio 
	AND productos.existencia > productos.stockminimo";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
} 
else {

    $sql = "SELECT
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.fabricante,
	productos.codfamilia,
	productos.codsubfamilia,
	productos.codmarca,
	productos.codmodelo,
	productos.codpresentacion,
	productos.codcolor,
	productos.codorigen,
	productos.year,
	productos.nroparte,
	productos.lote,
	productos.peso,
	productos.preciocompra,
	productos.precioxmenor,
	productos.precioxmayor,
	productos.precioxpublico,
	productos.existencia,
	productos.stockoptimo,
	productos.stockmedio,
	productos.stockminimo,
	productos.ivaproducto,
	productos.descproducto,
	productos.codigobarra,
	productos.fechaelaboracion,
	productos.fechaoptimo,
	productos.fechamedio,
	productos.fechaminimo,
	productos.codproveedor,
	productos.stockteorico,
	productos.motivoajuste,
	productos.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	familias.nomfamilia,
	subfamilias.nomsubfamilia,
	marcas.nommarca,
	modelos.nommodelo,
	presentaciones.nompresentacion,
	colores.nomcolor,
	origenes.nomorigen,
	proveedores.cuitproveedor,
	proveedores.nomproveedor,
	provincias.provincia,
	departamentos.departamento
	FROM (productos INNER JOIN sucursales ON productos.codsucursal = sucursales.codsucursal)
    LEFT JOIN familias ON productos.codfamilia=familias.codfamilia
	LEFT JOIN subfamilias ON productos.codsubfamilia=subfamilias.codsubfamilia 
	LEFT JOIN marcas ON productos.codmarca=marcas.codmarca 
	LEFT JOIN modelos ON productos.codmodelo = modelos.codmodelo
	LEFT JOIN presentaciones ON productos.codpresentacion=presentaciones.codpresentacion 
	LEFT JOIN colores ON productos.codcolor=colores.codcolor 
	LEFT JOIN origenes ON productos.codorigen=origenes.codorigen 
	LEFT JOIN proveedores ON productos.codproveedor=proveedores.codproveedor
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	WHERE productos.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
	AND productos.existencia <= productos.stockmedio 
	AND productos.existencia > productos.stockminimo";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
  }
}
########################## FUNCION LISTAR PRODUCTOS EN STOCK MEDIO ################################

########################### FUNCION LISTAR PRODUCTOS EN STOCK MINIMO ################################
public function ListarProductosMinimo()
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {
		
    $sql = "SELECT
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.fabricante,
	productos.codfamilia,
	productos.codsubfamilia,
	productos.codmarca,
	productos.codmodelo,
	productos.codpresentacion,
	productos.codcolor,
	productos.codorigen,
	productos.year,
	productos.nroparte,
	productos.lote,
	productos.peso,
	productos.preciocompra,
	productos.precioxmenor,
	productos.precioxmayor,
	productos.precioxpublico,
	productos.existencia,
	productos.stockoptimo,
	productos.stockmedio,
	productos.stockminimo,
	productos.ivaproducto,
	productos.descproducto,
	productos.codigobarra,
	productos.fechaelaboracion,
	productos.fechaoptimo,
	productos.fechamedio,
	productos.fechaminimo,
	productos.codproveedor,
	productos.stockteorico,
	productos.motivoajuste,
	productos.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	familias.nomfamilia,
	subfamilias.nomsubfamilia,
	marcas.nommarca,
	modelos.nommodelo,
	presentaciones.nompresentacion,
	colores.nomcolor,
	origenes.nomorigen,
	proveedores.cuitproveedor,
	proveedores.nomproveedor,
	provincias.provincia,
	departamentos.departamento
	FROM (productos INNER JOIN sucursales ON productos.codsucursal = sucursales.codsucursal)
    LEFT JOIN familias ON productos.codfamilia=familias.codfamilia
	LEFT JOIN subfamilias ON productos.codsubfamilia=subfamilias.codsubfamilia 
	LEFT JOIN marcas ON productos.codmarca=marcas.codmarca 
	LEFT JOIN modelos ON productos.codmodelo = modelos.codmodelo
	LEFT JOIN presentaciones ON productos.codpresentacion=presentaciones.codpresentacion 
	LEFT JOIN colores ON productos.codcolor=colores.codcolor 
	LEFT JOIN origenes ON productos.codorigen=origenes.codorigen 
	LEFT JOIN proveedores ON productos.codproveedor=proveedores.codproveedor
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	WHERE productos.codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."' 
	AND productos.existencia <= productos.stockminimo";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
} 
else {

    $sql = "SELECT
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.fabricante,
	productos.codfamilia,
	productos.codsubfamilia,
	productos.codmarca,
	productos.codmodelo,
	productos.codpresentacion,
	productos.codcolor,
	productos.codorigen,
	productos.year,
	productos.nroparte,
	productos.lote,
	productos.peso,
	productos.preciocompra,
	productos.precioxmenor,
	productos.precioxmayor,
	productos.precioxpublico,
	productos.existencia,
	productos.stockoptimo,
	productos.stockmedio,
	productos.stockminimo,
	productos.ivaproducto,
	productos.descproducto,
	productos.codigobarra,
	productos.fechaelaboracion,
	productos.fechaoptimo,
	productos.fechamedio,
	productos.fechaminimo,
	productos.codproveedor,
	productos.stockteorico,
	productos.motivoajuste,
	productos.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	familias.nomfamilia,
	subfamilias.nomsubfamilia,
	marcas.nommarca,
	modelos.nommodelo,
	presentaciones.nompresentacion,
	colores.nomcolor,
	origenes.nomorigen,
	proveedores.cuitproveedor,
	proveedores.nomproveedor,
	provincias.provincia,
	departamentos.departamento
	FROM (productos INNER JOIN sucursales ON productos.codsucursal = sucursales.codsucursal)
    LEFT JOIN familias ON productos.codfamilia=familias.codfamilia
	LEFT JOIN subfamilias ON productos.codsubfamilia=subfamilias.codsubfamilia 
	LEFT JOIN marcas ON productos.codmarca=marcas.codmarca 
	LEFT JOIN modelos ON productos.codmodelo = modelos.codmodelo
	LEFT JOIN presentaciones ON productos.codpresentacion=presentaciones.codpresentacion 
	LEFT JOIN colores ON productos.codcolor=colores.codcolor 
	LEFT JOIN origenes ON productos.codorigen=origenes.codorigen 
	LEFT JOIN proveedores ON productos.codproveedor=proveedores.codproveedor
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	WHERE productos.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
	AND productos.existencia <= productos.stockminimo";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
  }
}
########################## FUNCION LISTAR PRODUCTOS EN STOCK MINIMO ################################

###################### FUNCION LISTAR PRECIOS POR CODIGO DE PRODUCTO #####################
public function BuscarPrecioProductoxCodigo() 
	{
	self::SetNames();
	$sql = "SELECT GROUP_CONCAT('PRECIO MENOR', '_', precioxmenor, '|', 'PRECIO MAYOR', '_', precioxmayor, '|', 'PRECIO PUBLICO', '_', precioxpublico SEPARATOR '<br>') AS precioventa 
	FROM productos 
	WHERE idproducto = ? 
	AND codsucursal = '".limpiar($_SESSION["codsucursal"])."'";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_GET["idproducto"]));
	$num = $stmt->rowCount();
	    if($num==0)
	{
		echo "<option value='' selected=''> -- SIN RESULTADOS -- </option>";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
##################### FUNCION LISTAR PRECIOS POR CODIGO PRODUCTO ######################

############################# FUNCION LISTAR PRODUCTOS EN VENTANA MODAL ################################
public function ListarProductosModal()
{
	self::SetNames();
	$sql = "SELECT 
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.codmarca,
	productos.codmodelo,
	productos.codpresentacion,
	productos.preciocompra,
	productos.precioxmenor,
	productos.precioxmayor,
	productos.precioxpublico,
	productos.existencia,
	productos.ivaproducto,
	productos.descproducto,
	productos.codsucursal,
	familias.nomfamilia,
	marcas.nommarca,
	modelos.nommodelo,
	presentaciones.nompresentacion, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio
	FROM (productos INNER JOIN sucursales ON productos.codsucursal = sucursales.codsucursal)
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
    LEFT JOIN familias ON productos.codfamilia=familias.codfamilia
    LEFT JOIN marcas ON productos.codmarca=marcas.codmarca 
    LEFT JOIN modelos ON productos.codmodelo = modelos.codmodelo
    LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion 
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2  
    WHERE productos.codsucursal = '".limpiar($_SESSION["codsucursal"])."'
    AND productos.existencia != 0";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################## FUNCION LISTAR PRODUCTOS EN VENTANA MODAL ################################

########################## FUNCION LISTAR CODIGO DE BARRAS #########################
public function ListarCodigoBarra()
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT 
	productos.codproducto, 
	productos.codigobarra, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal, 
	sucursales.nomencargado, 
	documentos.documento 
	FROM productos INNER JOIN sucursales ON productos.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento 
	WHERE productos.codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

     } else {

    $sql = "SELECT codproducto, codigobarra FROM productos WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
   }
}
############################ FUNCION LISTAR CODIGO DE BARRAS #########################

############################ FUNCION ID PRODUCTOS #################################
public function ProductosPorId()
{
	self::SetNames();
	$sql = "SELECT
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.fabricante,
	productos.codfamilia,
	productos.codsubfamilia,
	productos.codmarca,
	productos.codmodelo,
	productos.codpresentacion,
	productos.codcolor,
	productos.codorigen,
	productos.year,
	productos.nroparte,
	productos.lote,
	productos.peso,
	productos.preciocompra,
	productos.precioxmenor,
	productos.precioxmayor,
	productos.precioxpublico,
	productos.existencia,
	productos.stockoptimo,
	productos.stockmedio,
	productos.stockminimo,
	productos.ivaproducto,
	productos.descproducto,
	productos.codigobarra,
	productos.fechaelaboracion,
	productos.fechaoptimo,
	productos.fechamedio,
	productos.fechaminimo,
	productos.codproveedor,
	productos.stockteorico,
	productos.motivoajuste,
	productos.codsucursal,
	familias.nomfamilia,
	subfamilias.nomsubfamilia,
	marcas.nommarca,
	modelos.nommodelo,
	presentaciones.nompresentacion,
	colores.nomcolor,
	origenes.nomorigen,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	proveedores.cuitproveedor,
	proveedores.nomproveedor,
	provincias.provincia,
	departamentos.departamento
	FROM(productos LEFT JOIN sucursales ON productos.codsucursal = sucursales.codsucursal)
    LEFT JOIN familias ON productos.codfamilia=familias.codfamilia 
	LEFT JOIN subfamilias ON productos.codsubfamilia=subfamilias.codsubfamilia 
	LEFT JOIN marcas ON productos.codmarca=marcas.codmarca 
	LEFT JOIN modelos ON productos.codmodelo = modelos.codmodelo
	LEFT JOIN presentaciones ON productos.codpresentacion=presentaciones.codpresentacion 
	LEFT JOIN colores ON productos.codcolor=colores.codcolor 
	LEFT JOIN origenes ON productos.codorigen=origenes.codorigen
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN proveedores ON productos.codproveedor=proveedores.codproveedor
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2  
	WHERE productos.codproducto = ? 
	AND productos.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codproducto"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID PRODUCTOS #################################

############################ FUNCION ACTUALIZAR PRODUCTOS ############################
public function ActualizarProductos()
{
	self::SetNames();
	if(empty($_POST["codproducto"]) or empty($_POST["producto"]) or empty($_POST["codfamilia"]))
	{
		echo "1";
		exit;
	}
	$sql = "SELECT codproducto FROM productos WHERE idproducto != ? AND codproducto = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["idproducto"],$_POST["codproducto"],$_POST["codsucursal"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		##################### ACTUALIZO LOS DATOS DE PRODUCTOS #####################
		$sql = "UPDATE productos set"
		." producto = ?, "
		." fabricante = ?, "
		." codfamilia = ?, "
		." codsubfamilia = ?, "
		." codmarca = ?, "
		." codmodelo = ?, "
		." codpresentacion = ?, "
		." codcolor = ?, "
		." codorigen = ?, "
		." year = ?, "
		." nroparte = ?, "
		." lote = ?, "
		." peso = ?, "
		." preciocompra = ?, "
		." precioxmenor = ?, "
		." precioxmayor = ?, "
		." precioxpublico = ?, "
		." existencia = ?, "
		." stockoptimo = ?, "
		." stockmedio = ?, "
		." stockminimo = ?, "
		." ivaproducto = ?, "
		." descproducto = ?, "
		." codigobarra = ?, "
		." fechaelaboracion = ?, "
		." fechaoptimo = ?, "
		." fechamedio = ?, "
		." fechaminimo = ?, "
		." codproveedor = ? "
		." where "
		." idproducto = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $producto);
		$stmt->bindParam(2, $fabricante);
		$stmt->bindParam(3, $codfamilia);
		$stmt->bindParam(4, $codsubfamilia);
		$stmt->bindParam(5, $codmarca);
		$stmt->bindParam(6, $codmodelo);
		$stmt->bindParam(7, $codpresentacion);
		$stmt->bindParam(8, $codcolor);
		$stmt->bindParam(9, $codorigen);
		$stmt->bindParam(10, $year);
		$stmt->bindParam(11, $nroparte);
		$stmt->bindParam(12, $lote);
		$stmt->bindParam(13, $peso);
		$stmt->bindParam(14, $preciocompra);
		$stmt->bindParam(15, $precioxmenor);
		$stmt->bindParam(16, $precioxmayor);
		$stmt->bindParam(17, $precioxpublico);
		$stmt->bindParam(18, $existencia);
		$stmt->bindParam(19, $stockoptimo);
		$stmt->bindParam(20, $stockmedio);
		$stmt->bindParam(21, $stockminimo);
		$stmt->bindParam(22, $ivaproducto);
		$stmt->bindParam(23, $descproducto);
		$stmt->bindParam(24, $codigobarra);
		$stmt->bindParam(25, $fechaelaboracion);
		$stmt->bindParam(26, $fechaoptimo);
		$stmt->bindParam(27, $fechamedio);
		$stmt->bindParam(28, $fechaminimo);
		$stmt->bindParam(29, $codproveedor);
		$stmt->bindParam(30, $idproducto);

		$producto = limpiar($_POST["producto"]);
		$fabricante = limpiar($_POST["fabricante"]);
		$codfamilia = limpiar($_POST["codfamilia"]);
		$codsubfamilia = limpiar($_POST['codsubfamilia'] == '' ? "0" : $_POST['codsubfamilia']);
		$codmarca = limpiar($_POST["codmarca"]);
		$codmodelo = limpiar($_POST['codmodelo'] == '' ? "0" : $_POST['codmodelo']);
		$codpresentacion = limpiar($_POST['codpresentacion'] == '' ? "0" : $_POST['codpresentacion']);
		$codcolor = limpiar($_POST['codcolor'] == '' ? "0" : $_POST['codcolor']);
		$codorigen = limpiar($_POST['codorigen'] == '' ? "0" : $_POST['codorigen']);
		$year = limpiar($_POST["year"]);
		$nroparte = limpiar($_POST["nroparte"]);
		$lote = limpiar($_POST['lote'] == '' ? "0" : $_POST['lote']);
		$peso = limpiar($_POST["peso"]);
		$preciocompra = limpiar($_POST["preciocompra"]);
		$precioxmenor = limpiar($_POST["precioxmenor"]);
		$precioxmayor = limpiar($_POST["precioxmayor"]);
		$precioxpublico = limpiar($_POST["precioxpublico"]);
		$existencia = limpiar($_POST["existencia"]);
		$stockoptimo = limpiar($_POST["stockoptimo"]);
		$stockmedio = limpiar($_POST["stockmedio"]);
		$stockminimo = limpiar($_POST["stockminimo"]);
		$ivaproducto = limpiar($_POST["ivaproducto"]);
		$descproducto = limpiar($_POST["descproducto"]);
		$codigobarra = limpiar($_POST["codigobarra"]);
		$fechaelaboracion = limpiar($_POST['fechaelaboracion'] == '' ? "0000-00-00" : date("Y-m-d",strtotime($_POST['fechaelaboracion'])));
		$fechaoptimo = limpiar($_POST['fechaoptimo'] == '' ? "0000-00-00" : date("Y-m-d",strtotime($_POST['fechaoptimo'])));
		$fechamedio = limpiar($_POST['fechamedio'] == '' ? "0000-00-00" : date("Y-m-d",strtotime($_POST['fechamedio'])));
		$fechaminimo = limpiar($_POST['fechaminimo'] == '' ? "0000-00-00" : date("Y-m-d",strtotime($_POST['fechaminimo'])));
		$codproveedor = limpiar($_POST["codproveedor"]);
		$codproducto = limpiar($_POST["codproducto"]);
		$idproducto = limpiar($_POST["idproducto"]);
		$stmt->execute();
		##################### ACTUALIZO LOS DATOS DE PRODUCTOS #####################

		if($_POST['existencia'] != $_POST['existencia2']){

		##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX #####################
		$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codproceso);
		$stmt->bindParam(2, $codresponsable);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);
		$stmt->bindParam(14, $tipokardex);
		$stmt->bindParam(15, $codsucursal);

		$codproceso = limpiar($_POST['codproducto']);
		$codresponsable = limpiar("0");
		$codproducto = limpiar($_POST['codproducto']);
		$movimiento = limpiar($_POST['existencia'] > $_POST['existencia2'] ? "ENTRADAS" : "SALIDAS");
		$entradas = limpiar($_POST['existencia'] > $_POST['existencia2'] ? $_POST['existencia']-$_POST['existencia2'] : '0');
		$salidas = limpiar($_POST['existencia'] > $_POST['existencia2'] ? '0' : $_POST['existencia2']-$_POST['existencia']);
		$devolucion = limpiar("0");
		$stockactual = limpiar($_POST['existencia']);
		$ivaproducto = limpiar($_POST["ivaproducto"]);
		$descproducto = limpiar($_POST["descproducto"]);
		$precio = limpiar("0.00");
		$documento = limpiar("ACTUALIZACIÓN DE INVENTARIO");
		$fechakardex = limpiar(date("Y-m-d"));
		$tipokardex = limpiar("1");
		$codsucursal = limpiar($_POST["codsucursal"]);
		$stmt->execute();
		##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX #####################

		}

	    ##################  SUBIR FOTO DE PRODUCTO ######################################
         //datos del arhivo  
        if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo =''; }
        if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo =''; }
        if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo =''; } 
         //compruebo si las características del archivo son las que deseo  
        if ((strpos($tipo_archivo,'image/jpeg')!==false)&&$tamano_archivo<200000) 
		{  
		if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/productos/".$nombre_archivo) && rename("fotos/productos/".$nombre_archivo,"fotos/productos/".$codproducto.".jpg"))
		{ 
		## se puede dar un aviso
		} 
		## se puede dar otro aviso 
		}
		################## FINALIZA SUBIR FOTO DE PRODUCTO ##########################
        
	echo "<span class='fa fa-check-square-o'></span> EL PRODUCTO HA SIDO ACTUALIZADO EXITOSAMENTE";
	exit;

	} else {

		echo "2";
		exit;
	}
}
############################ FUNCION ACTUALIZAR PRODUCTOS ############################

########################## FUNCION AJUSTAR STOCK DE PRODUCTOS ###########################
public function ActualizarAjuste()
{
	self::SetNames();
	if(empty($_POST["codproducto"]) or empty($_POST["stockteorico"]) or empty($_POST["motivoajuste"]))
	{
		echo "1";
	    exit;
	}
	
	$sql = "UPDATE productos set"
		  ." stockteorico = ?, "
		  ." motivoajuste = ? "
		  ." where "
		  ." idproducto = ?;
		   ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $stockteorico);
	$stmt->bindParam(2, $motivoajuste);
    $stmt->bindParam(3, $idproducto);
	
	$stockteorico = limpiar($_POST["stockteorico"]);
	$motivoajuste = limpiar($_POST["motivoajuste"]);
	$idproducto = limpiar($_POST["idproducto"]);
	$stmt->execute();

	echo "<span class='fa fa-check-square-o'></span> EL AJUSTE DE STOCK DEL PRODUCTO SE HA REALIZADO EXITOSAMENTE";
	exit;
}
###################### FUNCION AJUSTAR STOCK DE PRODUCTOS #########################

########################## FUNCION ELIMINAR PRODUCTOS ###########################
public function EliminarProductos()
{
	self::SetNames();
	if ($_SESSION["acceso"]=="administradorS") {

	$sql = "SELECT codproducto FROM detalleventas WHERE codproducto = ? AND codsucursal = ? AND tipodetalle = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codproducto"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{

		$sql = "DELETE FROM productos WHERE codproducto = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codproducto);
		$stmt->bindParam(2,$codsucursal);
		$codproducto = decrypt($_GET["codproducto"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();

		$sql = "DELETE FROM kardex where codproducto = ? AND codsucursal = ? AND tipokardex = 1";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codproducto);
		$stmt->bindParam(2,$codsucursal);
		$codproducto = decrypt($_GET["codproducto"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();

		$codproducto = decrypt($_GET["codproducto"]);
		if (file_exists("fotos/productos/".$codproducto.".jpg")){
	    //funcion para eliminar una carpeta con contenido
		$archivos = "fotos/productos/".$codproducto.".jpg";		
		unlink($archivos);
		}

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
    } 
			
	} else {
		
		echo "3";
		exit;
	}	
}
########################## FUNCION ELIMINAR PRODUCTOS #################################

######################## FUNCION BUSCA KARDEX PRODUCTOS ##########################
public function BuscarKardexProducto() 
	{
	self::SetNames();
	$sql ="SELECT * FROM kardex WHERE codproducto = ? AND codsucursal = ? AND tipokardex = 1";
    $stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_GET["codproducto"], decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN MOVIMIENTOS EN KARDEX PARA EL PRODUCTO INGRESADO</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################## FUNCION BUSCA KARDEX PRODUCTOS #########################

######################## FUNCION DETALLE PRODUCTO KARDEX #########################
public function DetalleProductosKardex()
{
	self::SetNames();
	$sql = "SELECT
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.fabricante,
	productos.codfamilia,
	productos.codsubfamilia,
	productos.codmarca,
	productos.codmodelo,
	productos.codpresentacion,
	productos.codcolor,
	productos.codorigen,
	productos.year,
	productos.nroparte,
	productos.lote,
	productos.peso,
	productos.preciocompra,
	productos.precioxmenor,
	productos.precioxmayor,
	productos.precioxpublico,
	productos.existencia,
	productos.stockoptimo,
	productos.stockmedio,
	productos.stockminimo,
	productos.ivaproducto,
	productos.descproducto,
	productos.codigobarra,
	productos.fechaelaboracion,
	productos.fechaoptimo,
	productos.fechamedio,
	productos.fechaminimo,
	productos.codproveedor,
	productos.stockteorico,
	productos.motivoajuste,
	productos.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	familias.nomfamilia,
	subfamilias.nomsubfamilia,
	marcas.nommarca,
	modelos.nommodelo,
	presentaciones.nompresentacion,
	colores.nomcolor,
	origenes.nomorigen,
	proveedores.cuitproveedor,
	proveedores.nomproveedor
	FROM(productos LEFT JOIN sucursales ON productos.codsucursal = sucursales.codsucursal)
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN familias ON productos.codfamilia=familias.codfamilia 
	LEFT JOIN subfamilias ON productos.codsubfamilia=subfamilias.codsubfamilia 
	LEFT JOIN marcas ON productos.codmarca=marcas.codmarca 
	LEFT JOIN modelos ON productos.codmodelo = modelos.codmodelo
	LEFT JOIN presentaciones ON productos.codpresentacion=presentaciones.codpresentacion 
	LEFT JOIN colores ON productos.codcolor=colores.codcolor 
	LEFT JOIN origenes ON productos.codorigen=origenes.codorigen 
	LEFT JOIN proveedores ON productos.codproveedor=proveedores.codproveedor
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2  
	WHERE productos.codproducto = ? AND productos.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_GET["codproducto"],decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################## FUNCION DETALLE PRODUCTO KARDEX #########################

########################### FUNCION LISTAR KARDEX VALORIZADO ################################
public function ListarKardexValorizado()
	{
	self::SetNames();
        
	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT
 	productos.idproducto,
 	productos.codproducto,
 	productos.producto,
 	productos.fabricante,
 	productos.codfamilia,
 	productos.codsubfamilia,
 	productos.codmarca,
 	productos.codmodelo,
 	productos.codpresentacion,
 	productos.codcolor,
 	productos.codorigen,
 	productos.year,
 	productos.nroparte,
 	productos.lote,
 	productos.peso,
 	productos.preciocompra,
 	productos.precioxmenor,
 	productos.precioxmayor,
 	productos.precioxpublico,
 	productos.existencia,
 	productos.stockoptimo,
 	productos.stockmedio,
 	productos.stockminimo,
 	productos.ivaproducto,
 	productos.descproducto,
 	productos.codigobarra,
 	productos.fechaelaboracion,
 	productos.fechaoptimo,
 	productos.fechamedio,
 	productos.fechaminimo,
 	productos.codproveedor,
 	productos.stockteorico,
 	productos.motivoajuste,
 	productos.codsucursal,
 	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
 	familias.nomfamilia,
 	subfamilias.nomsubfamilia,
 	marcas.nommarca,
 	modelos.nommodelo,
 	presentaciones.nompresentacion,
 	colores.nomcolor,
 	origenes.nomorigen,
 	proveedores.cuitproveedor,
 	proveedores.nomproveedor
	FROM (productos INNER JOIN sucursales ON productos.codsucursal = sucursales.codsucursal)
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
    LEFT JOIN familias ON productos.codfamilia=familias.codfamilia
	LEFT JOIN subfamilias ON productos.codsubfamilia=subfamilias.codsubfamilia 
	LEFT JOIN marcas ON productos.codmarca=marcas.codmarca 
	LEFT JOIN modelos ON productos.codmodelo = modelos.codmodelo
	LEFT JOIN presentaciones ON productos.codpresentacion=presentaciones.codpresentacion 
	LEFT JOIN colores ON productos.codcolor=colores.codcolor 
	LEFT JOIN origenes ON productos.codorigen=origenes.codorigen
	LEFT JOIN proveedores ON productos.codproveedor=proveedores.codproveedor
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	WHERE productos.codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

     } else {

 	$sql = "SELECT
 	productos.idproducto,
 	productos.codproducto,
 	productos.producto,
 	productos.fabricante,
 	productos.codfamilia,
 	productos.codsubfamilia,
 	productos.codmarca,
 	productos.codmodelo,
 	productos.codpresentacion,
 	productos.codcolor,
 	productos.codorigen,
 	productos.year,
 	productos.nroparte,
 	productos.lote,
 	productos.peso,
 	productos.preciocompra,
 	productos.precioxmenor,
 	productos.precioxmayor,
 	productos.precioxpublico,
 	productos.existencia,
 	productos.stockoptimo,
 	productos.stockmedio,
 	productos.stockminimo,
 	productos.ivaproducto,
 	productos.descproducto,
 	productos.codigobarra,
 	productos.fechaelaboracion,
 	productos.fechaoptimo,
 	productos.fechamedio,
 	productos.fechaminimo,
 	productos.codproveedor,
 	productos.stockteorico,
 	productos.motivoajuste,
 	productos.codsucursal,
 	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
 	familias.nomfamilia,
 	subfamilias.nomsubfamilia,
 	marcas.nommarca,
 	modelos.nommodelo,
 	presentaciones.nompresentacion,
 	colores.nomcolor,
 	origenes.nomorigen,
 	proveedores.cuitproveedor,
 	proveedores.nomproveedor
	FROM (productos INNER JOIN sucursales ON productos.codsucursal = sucursales.codsucursal)
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
    LEFT JOIN familias ON productos.codfamilia=familias.codfamilia
	LEFT JOIN subfamilias ON productos.codsubfamilia=subfamilias.codsubfamilia 
	LEFT JOIN marcas ON productos.codmarca=marcas.codmarca 
	LEFT JOIN modelos ON productos.codmodelo = modelos.codmodelo
	LEFT JOIN presentaciones ON productos.codpresentacion=presentaciones.codpresentacion 
	LEFT JOIN colores ON productos.codcolor=colores.codcolor 
	LEFT JOIN origenes ON productos.codorigen=origenes.codorigen
	LEFT JOIN proveedores ON productos.codproveedor=proveedores.codproveedor
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	WHERE productos.codsucursal = '".limpiar($_SESSION["codsucursal"])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
   }
}
########################## FUNCION LISTAR KARDEX VALORIZADO ################################

###################### FUNCION KARDEX POR FECHAS Y VENDEDOR #########################
public function BuscarKardexValorizadoxFechas() 
	{
	self::SetNames();
   $sql ="SELECT 
   detalleventas.idproducto,
   detalleventas.codproducto, 
   detalleventas.producto, 
   detalleventas.codmarca,
   detalleventas.codmodelo,
   detalleventas.codpresentacion,
   detalleventas.preciocompra,  
   detalleventas.precioventa,  
   detalleventas.ivaproducto,
   detalleventas.descproducto,
   detalleventas.tipodetalle,
   productos.codmarca, 
   productos.codmodelo, 
   productos.existencia,
   marcas.nommarca, 
   modelos.nommodelo,
   ventas.iva, 
   ventas.fechaventa, 
   sucursales.cuitsucursal, 
   sucursales.nomsucursal,
   sucursales.codmoneda,
   sucursales.codmoneda2,
   documentos.documento,
   documentos2.documento AS documento2,
   tiposmoneda.moneda,
   tiposmoneda.siglas,
   tiposmoneda.simbolo,
   tiposmoneda2.moneda AS moneda2,
   tiposmoneda2.siglas AS siglas2,
   tiposmoneda2.simbolo AS simbolo2,
   valor_cambio.montocambio,
   usuarios.dni,
   usuarios.nombres, 
   SUM(detalleventas.cantventa) as cantidad 
   FROM (ventas INNER JOIN detalleventas ON ventas.codventa=detalleventas.codventa) 
   INNER JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal
   LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
   LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
   LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
   LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
   LEFT JOIN productos ON detalleventas.idproducto=productos.idproducto 
   LEFT JOIN marcas ON marcas.codmarca=productos.codmarca 
   LEFT JOIN modelos ON modelos.codmodelo=productos.codmodelo 
   LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo 
   LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
   WHERE ventas.codsucursal = '".decrypt($_GET['codsucursal'])."' 
   AND ventas.codigo = ? 
   AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') BETWEEN ? AND ?
   AND detalleventas.tipodetalle = 1 
   GROUP BY detalleventas.codproducto, detalleventas.precioventa, detalleventas.descproducto, detalleventas.codsucursal 
   ORDER BY detalleventas.codproducto ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_GET['codigo']));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN PRODUCTOS FACTURADOS PARA EL VENDEDOR Y RANGO DE FECHA INGRESADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################### FUNCION KARDEX POR FECHAS Y VENDEDOR ###############################

############################### FIN DE CLASE PRODUCTOS ###############################































################################## CLASE TRASPASOS ###################################

############################## FUNCION REGISTRAR TRASPASOS ############################
public function RegistrarTraspasos()
	{
	self::SetNames();
	if(empty($_POST["recibe"]) or empty($_POST["codsucursal"]) or empty($_POST["fechatraspaso"]))
	{
		echo "1";
		exit;
	}

	else if(empty($_SESSION["CarritoTraspaso"]) || $_POST["txtTotal"]=="0.00")
	{
		echo "2";
		exit;
		
	} else {

	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #############
	$v = $_SESSION["CarritoTraspaso"];
	for($i=0;$i<count($v);$i++){

	    $sql = "SELECT existencia FROM productos 
	    WHERE codproducto = '".$v[$i]['txtCodigo']."' 
	    AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
	    foreach ($this->dbh->query($sql) as $row)
	    {
		$this->p[] = $row;
	    }
	
	    $existenciadb = $row['existencia'];
	    $cantidad = $v[$i]['cantidad'];

        if ($cantidad > $existenciadb) 
        { 
	       echo "3";
	       exit;
        }
	}
	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #############

	################# OBTENGO DATOS DE SUCURSAL #################
	$sql = " SELECT 
	codsucursal, 
	nroactividadsucursal, 
	iniciofactura 
	FROM sucursales WHERE codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$nroactividad = $row['nroactividadsucursal'];
	$iniciofactura = $row['iniciofactura'];
	################# OBTENGO DATOS DE SUCURSAL #################

	################ CREO CODIGO DE TRASPASO ####################
	$sql = "SELECT codtraspaso FROM traspasos 
	ORDER BY idtraspaso DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$traspaso=$row["codtraspaso"];

	}
	if(empty($traspaso))
	{
		$codtraspaso = "01";

	} else {

		$num = substr($traspaso, 0);
        $dig = $num + 1;
        $codigofinal = str_pad($dig, 2, "0", STR_PAD_LEFT);
        $codtraspaso = $codigofinal;
	}
    ################ CREO CODIGO DE TRASPASO ###############

	################### CREO CODIGO DE FACTURA ####################
	$sql4 = "SELECT codfactura FROM traspasos 
	WHERE codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."' 
	ORDER BY idtraspaso DESC LIMIT 1";
	 foreach ($this->dbh->query($sql4) as $row4){

		$factura=$row4["codfactura"];
	}
	if(empty($factura))
	{
		$codfactura = $nroactividad.'-'.$iniciofactura;

	} else {

		$var = strlen($nroactividad."-");
        $var1 = substr($factura , $var);
        $var2 = strlen($var1);
        $var3 = $var1 + 1;
        $var4 = str_pad($var3, $var2, "0", STR_PAD_LEFT);
        $codfactura = $nroactividad.'-'.$var4;
	}
    ################### CREO CODIGO DE FACTURA ####################

    $query = "INSERT INTO traspasos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codtraspaso);
	$stmt->bindParam(2, $codfactura);
	$stmt->bindParam(3, $recibe);
	$stmt->bindParam(4, $subtotalivasi);
	$stmt->bindParam(5, $subtotalivano);
	$stmt->bindParam(6, $iva);
	$stmt->bindParam(7, $totaliva);
	$stmt->bindParam(8, $descontado);
	$stmt->bindParam(9, $descuento);
	$stmt->bindParam(10, $totaldescuento);
	$stmt->bindParam(11, $totalpago);
	$stmt->bindParam(12, $totalpago2);
	$stmt->bindParam(13, $fechatraspaso);
	$stmt->bindParam(14, $observaciones);
	$stmt->bindParam(15, $codigo);
	$stmt->bindParam(16, $codsucursal);
    
	$recibe = limpiar(decrypt($_POST["recibe"]));
	$subtotalivasi = limpiar($_POST["txtsubtotal"]);
	$subtotalivano = limpiar($_POST["txtsubtotal2"]);
	$iva = limpiar($_POST["iva"]);
	$totaliva = limpiar($_POST["txtIva"]);
	$descontado = limpiar($_POST["txtdescontado"]);
	$descuento = limpiar($_POST["descuento"]);
	$totaldescuento = limpiar($_POST["txtDescuento"]);
	$totalpago = limpiar($_POST["txtTotal"]);
	$totalpago2 = limpiar($_POST["txtTotalCompra"]);
	$fechatraspaso = limpiar(date("Y-m-d",strtotime($_POST['fechatraspaso']))." ".date("H:i:s"));
	$observaciones = limpiar($_POST["observaciones"]);
	$codigo = limpiar($_SESSION["codigo"]);
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();
	
	$this->dbh->beginTransaction();
	$detalle = $_SESSION["CarritoTraspaso"];
	for($i=0;$i<count($detalle);$i++){

	################ VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ################
	$sql = "SELECT * FROM productos 
	WHERE codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' 
	AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$existenciabd = $row['existencia'];
	################ VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ################

	################################### REGISTRO DETALLES DE TRASPASO ###################################
	$query = "INSERT INTO detalletraspasos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codtraspaso);
    $stmt->bindParam(2, $idproducto);
    $stmt->bindParam(3, $codproducto);
    $stmt->bindParam(4, $producto);
    $stmt->bindParam(5, $codmarca);
    $stmt->bindParam(6, $codmodelo);
    $stmt->bindParam(7, $codpresentacion);
	$stmt->bindParam(8, $cantidad);
	$stmt->bindParam(9, $preciocompra);
	$stmt->bindParam(10, $precioventa);
	$stmt->bindParam(11, $ivaproducto);
	$stmt->bindParam(12, $descproducto);
	$stmt->bindParam(13, $valortotal);
	$stmt->bindParam(14, $totaldescuentov);
	$stmt->bindParam(15, $valorneto);
	$stmt->bindParam(16, $valorneto2);
    $stmt->bindParam(17, $tipodetalle);
	$stmt->bindParam(18, $codsucursal);
		
	$idproducto = limpiar($detalle[$i]['id']);
	$codproducto = limpiar($detalle[$i]['txtCodigo']);
	$producto = limpiar($detalle[$i]['producto']);
	$codmarca = limpiar($detalle[$i]['codmarca']);
	$codmodelo = limpiar($detalle[$i]['codmodelo']);
	$codpresentacion = limpiar($detalle[$i]['codpresentacion']);
	$cantidad = limpiar($detalle[$i]['cantidad']);
	$preciocompra = limpiar($detalle[$i]['precio']);
	$precioventa = limpiar($detalle[$i]['precio2']);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$descuento = $detalle[$i]['descproducto']/100;
	$valortotal = number_format($detalle[$i]['precio2']*$detalle[$i]['cantidad'], 2, '.', '');
	$totaldescuentov = number_format($valortotal*$descuento, 2, '.', '');
    $valorneto = number_format($valortotal-$totaldescuentov, 2, '.', '');
	$valorneto2 = number_format($detalle[$i]['precio']*$detalle[$i]['cantidad'], 2, '.', '');
    $tipodetalle = limpiar($detalle[$i]['tipodetalle']);
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();
	################################### REGISTRO DETALLES DE TRASPASO ###################################

	##########################################################################################################
	#                                                                                                        #
	#                                   PROCESO DE PRODUCTOS SALIENTES                                       #
	#                                                                                                        #
	##########################################################################################################

    ##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
	$sql = " UPDATE productos set "
		  ." existencia = ? "
		  ." where "
		  ." codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' 
		  AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."';
		   ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $existencia);
	$cantraspaso = limpiar($detalle[$i]['cantidad']);
	$existencia = $existenciabd-$cantraspaso;
	$stmt->execute();
	##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################

	################ REGISTRAMOS LOS PRODUCTOS SALIENTES EN KARDEX #################
    $query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codtraspaso);
	$stmt->bindParam(2, $codresponsable);
	$stmt->bindParam(3, $codproducto);
	$stmt->bindParam(4, $movimiento);
	$stmt->bindParam(5, $entradas);
	$stmt->bindParam(6, $salidas);
	$stmt->bindParam(7, $devolucion);
	$stmt->bindParam(8, $stockactual);
	$stmt->bindParam(9, $ivaproducto);
	$stmt->bindParam(10, $descproducto);
	$stmt->bindParam(11, $precio);
	$stmt->bindParam(12, $documento);
	$stmt->bindParam(13, $fechakardex);	
	$stmt->bindParam(14, $tipokardex);	
	$stmt->bindParam(15, $codsucursal);

	$codresponsable = limpiar(decrypt($_POST["recibe"]));
	$codproducto = limpiar($detalle[$i]['txtCodigo']);
	$movimiento = limpiar("SALIDAS");
	$entradas = limpiar("0");
	$salidas= limpiar($detalle[$i]['cantidad']);
	$devolucion = limpiar("0");
	$stockactual = limpiar($existenciabd-$detalle[$i]['cantidad']);
	$precio = limpiar($detalle[$i]["precio2"]);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$documento = limpiar("TRASPASO: ".$codtraspaso);
	$fechakardex = limpiar(date("Y-m-d"));
	$tipokardex = limpiar($detalle[$i]['tipodetalle']);
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();
	################ REGISTRAMOS LOS PRODUCTOS SALIENTES EN KARDEX #################

	##########################################################################################################
	#                                                                                                        #
	#                                   PROCESO DE PRODUCTOS SALIENTES                                       #
	#                                                                                                        #
	##########################################################################################################


	##########################################################################################################
	#                                                                                                        #
	#                                   PROCESO DE PRODUCTOS ENTRANTES                                       #
	#                                                                                                        #
	##########################################################################################################

	############ VERIFICO SI EL PRODUCTO YA EXISTE EN LA SUCURSAL QUE RECIBE ###########
	$sql = "SELECT codproducto FROM productos WHERE codproducto = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($detalle[$i]['txtCodigo']),limpiar(decrypt($_POST['recibe']))));
	$num = $stmt->rowCount();
	if($num == 0)
	{

		############################## REGISTRO DATOS DE PRODUCTOS ##############################
		$query = "INSERT INTO productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codproducto);
		$stmt->bindParam(2, $producto);
		$stmt->bindParam(3, $fabricante);
		$stmt->bindParam(4, $codfamilia);
		$stmt->bindParam(5, $codsubfamilia);
		$stmt->bindParam(6, $codmarca);
		$stmt->bindParam(7, $codmodelo);
		$stmt->bindParam(8, $codpresentacion);
		$stmt->bindParam(9, $codcolor);
		$stmt->bindParam(10, $codorigen);
		$stmt->bindParam(11, $year);
		$stmt->bindParam(12, $nroparte);
		$stmt->bindParam(13, $lote);
		$stmt->bindParam(14, $peso);
		$stmt->bindParam(15, $preciocompra);
		$stmt->bindParam(16, $precioxmenor);
		$stmt->bindParam(17, $precioxmayor);
		$stmt->bindParam(18, $precioxpublico);
		$stmt->bindParam(19, $existencia);
		$stmt->bindParam(20, $stockoptimo);
		$stmt->bindParam(21, $stockmedio);
		$stmt->bindParam(22, $stockminimo);
		$stmt->bindParam(23, $ivaproducto);
		$stmt->bindParam(24, $descproducto);
		$stmt->bindParam(25, $codigobarra);
		$stmt->bindParam(26, $fechaelaboracion);
		$stmt->bindParam(27, $fechaoptimo);
		$stmt->bindParam(28, $fechamedio);
		$stmt->bindParam(29, $fechaminimo);
		$stmt->bindParam(30, $codproveedor);
		$stmt->bindParam(31, $stockteorico);
		$stmt->bindParam(32, $motivoajuste);
		$stmt->bindParam(33, $recibe);

		$codproducto = limpiar($detalle[$i]["txtCodigo"]);
		$producto = limpiar($row["producto"]);
		$fabricante = limpiar($row["fabricante"]);
		$codfamilia = limpiar($row["codfamilia"]);
		$codsubfamilia = limpiar($row["codsubfamilia"]);
		$codmarca = limpiar($row["codmarca"]);
		$codmodelo = limpiar($row["codmodelo"]);
		$codpresentacion = limpiar($row["codpresentacion"]);
		$codcolor = limpiar($row["codcolor"]);
		$codorigen = limpiar($row["codorigen"]);
		$year = limpiar($row["year"]);
		$nroparte = limpiar($row["nroparte"]);
		$lote = limpiar($row["lote"]);
		$peso = limpiar($row["peso"]);
		$preciocompra = limpiar($detalle[$i]["precio"]);
		$precioxmenor = limpiar($row["precioxmenor"]);
		$precioxmayor = limpiar($row["precioxmayor"]);
		$precioxpublico = limpiar($row["precioxpublico"]);
		$existencia = limpiar($detalle[$i]["cantidad"]);
		$stockoptimo = limpiar($row["stockoptimo"]);
		$stockmedio = limpiar($row["stockmedio"]);
		$stockminimo = limpiar($row["stockminimo"]);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$codigobarra = limpiar($row["codigobarra"]);
		$fechaelaboracion = limpiar($row['fechaelaboracion']);
		$fechaoptimo = limpiar($row['fechaoptimo']);
		$fechamedio = limpiar($row['fechamedio']);
		$fechaminimo = limpiar($row['fechaminimo']);
		$codproveedor = limpiar($row["codproveedor"]);
		$stockteorico = limpiar("0");
		$motivoajuste = limpiar("NINGUNO");
		$recibe = limpiar(decrypt($_POST["recibe"]));
		$stmt->execute();
		############################## REGISTRO DATOS DE PRODUCTOS ##############################

		############## REGISTRAMOS LOS PRODUCTOS ENTRANTES EN KARDEX ###############
        $query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codtraspaso);
		$stmt->bindParam(2, $codresponsable);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);
		$stmt->bindParam(14, $tipokardex);	
		$stmt->bindParam(15, $recibe);

		$codresponsable = limpiar(decrypt($_POST["codsucursal"]));
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$movimiento = limpiar("ENTRADAS");
		$entradas= limpiar($detalle[$i]['cantidad']);
		$salidas = limpiar("0");
		$devolucion = limpiar("0");
		$stockactual = limpiar($detalle[$i]['cantidad']);
		$precio = limpiar($detalle[$i]["precio2"]);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$documento = limpiar("TRASPASO ".$codtraspaso);
		$fechakardex = limpiar(date("Y-m-d"));	
	    $tipokardex = limpiar($detalle[$i]['tipodetalle']);	
		$recibe = limpiar(decrypt($_POST["recibe"]));
		$stmt->execute();
		############## REGISTRAMOS LOS PRODUCTOS ENTRANTES EN KARDEX ###############

	} else {

		############### VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ##################
		$sql = "SELECT 
		* 
		FROM 
		productos 
		WHERE codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' 
		AND codsucursal = '".limpiar(decrypt($_POST["recibe"]))."'";
		foreach ($this->dbh->query($sql) as $row2)
		{
			$this->p[] = $row2;
		}
		$existenciarecibebd = $row2['existencia'];
	    ############### VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ##################

		############# ACTUALIZAMOS LA EXISTENCIA DE PRODUCTOS RECIBIDOS ###############
		$sql = "UPDATE productos set "
		      ." preciocompra = ?, "
			  ." precioxmenor = ?, "
			  ." precioxmayor = ?, "
			  ." precioxpublico = ?, "
			  ." existencia = ?, "
			  ." ivaproducto = ?, "
			  ." descproducto = ?, "
			  ." fechaoptimo = ?, "
			  ." fechamedio = ?, "
			  ." fechaminimo = ? "
			  ." WHERE "
			  ." codproducto = ? AND codsucursal = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $preciocompra);
		$stmt->bindParam(2, $precioxmenor);
		$stmt->bindParam(3, $precioxmayor);
		$stmt->bindParam(4, $precioxpublico);
		$stmt->bindParam(5, $existencia);
		$stmt->bindParam(6, $ivaproducto);
		$stmt->bindParam(7, $descproducto);
		$stmt->bindParam(8, $fechaoptimo);
		$stmt->bindParam(9, $fechamedio);
		$stmt->bindParam(10, $fechaminimo);
		$stmt->bindParam(11, $codproducto);
		$stmt->bindParam(12, $recibe);
		
		$preciocompra = limpiar($detalle[$i]['precio']);
		$precioxmenor = limpiar($row['precioxmenor']);
		$precioxmayor = limpiar($row['precioxmayor']);
		$precioxpublico = limpiar($row['precioxpublico']);
		$existencia = limpiar($existenciarecibebd+$detalle[$i]['cantidad']);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$fechaoptimo = limpiar($row['fechaoptimo']);
		$fechamedio = limpiar($row['fechamedio']);
		$fechaminimo = limpiar($row['fechaminimo']);
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$recibe = limpiar(decrypt($_POST["recibe"]));
		$stmt->execute();
		############# ACTUALIZAMOS LA EXISTENCIA DE PRODUCTOS RECIBIDOS ###############

		############### REGISTRAMOS LOS PRODUCTOS ENTRANTES EN KARDEX ###############
        $query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codtraspaso);
		$stmt->bindParam(2, $codresponsable);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);	
	    $stmt->bindParam(14, $tipokardex);
		$stmt->bindParam(15, $recibe);

		$codresponsable = limpiar(decrypt($_POST["codsucursal"]));
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$movimiento = limpiar("ENTRADAS");
		$entradas= limpiar($detalle[$i]['cantidad']);
		$salidas = limpiar("0");
		$devolucion = limpiar("0");
		$stockactual = limpiar($existenciarecibebd+$detalle[$i]['cantidad']);
		$precio = limpiar($detalle[$i]["precio2"]);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$documento = limpiar("TRASPASO ".$codtraspaso);
		$fechakardex = limpiar(date("Y-m-d"));	
	    $tipokardex = limpiar($detalle[$i]['tipodetalle']);	
		$recibe = limpiar(decrypt($_POST["recibe"]));
		$stmt->execute();
		############### REGISTRAMOS LOS PRODUCTOS ENTRANTES EN KARDEX ###############

	}//FIN DE REGISTRO DE PRODUCTOS

	##########################################################################################################
	#                                                                                                        #
	#                                   PROCESO DE PRODUCTOS ENTRANTES                                       #
	#                                                                                                        #
	##########################################################################################################

        }//FIN SESSION DETALLES
        
    ####################### DESTRUYO LA VARIABLE DE SESSION #####################
	unset($_SESSION["CarritoTraspaso"]);
    $this->dbh->commit();
    ################################### REGISTRO DETALLES DE FACTURA ###################################
		
   echo "<span class='fa fa-check-square-o'></span> EL TRASPASO DE PRODUCTOS HA SIDO REALIZADO EXITOSAMENTE <a href='reportepdf?codtraspaso=".encrypt($codtraspaso)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURATRASPASO")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

	echo "<script>window.open('reportepdf?codtraspaso=".encrypt($codtraspaso)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURATRASPASO")."', '_blank');</script>";
	exit;
	}
}
############################## FUNCION REGISTRAR TRASPASOS #############################

############################## FUNCION LISTAR TRASPASOS ################################
public function ListarTraspasos()
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT 
	traspasos.idtraspaso, 
	traspasos.codtraspaso,
	traspasos.codfactura, 
	traspasos.recibe, 
	traspasos.subtotalivasi, 
	traspasos.subtotalivano, 
	traspasos.iva, 
	traspasos.totaliva,
	traspasos.descontado, 
	traspasos.descuento, 
	traspasos.totaldescuento,
	traspasos.totalpago, 
	traspasos.totalpago2, 
	traspasos.fechatraspaso, 
	traspasos.observaciones, 
	traspasos.codigo,
	traspasos.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	documentos.documento,
	documentos2.documento AS documento2,
	sucursales2.documsucursal AS documsucursal2,
	sucursales2.cuitsucursal AS cuitsucursal2,
	sucursales2.nomsucursal AS nomsucursal2,
	sucursales2.documencargado AS documencargado2,
	sucursales2.dniencargado AS dniencargado2,
	sucursales2.nomencargado AS nomencargado2,
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	usuarios.dni,
	usuarios.nombres,
	SUM(detalletraspasos.cantidad) AS articulos 
	FROM (traspasos LEFT JOIN detalletraspasos ON detalletraspasos.codtraspaso = traspasos.codtraspaso)
	LEFT JOIN sucursales ON traspasos.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN sucursales AS sucursales2 ON traspasos.recibe = sucursales2.codsucursal
	LEFT JOIN documentos AS documentos3 ON sucursales.documsucursal = documentos3.coddocumento
	LEFT JOIN documentos AS documentos4 ON sucursales.documencargado = documentos4.coddocumento
	LEFT JOIN usuarios ON traspasos.codigo = usuarios.codigo 
	GROUP BY detalletraspasos.codtraspaso, traspasos.codsucursal 
	ORDER BY traspasos.idtraspaso ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

	} else {

   $sql = "SELECT 
	traspasos.idtraspaso, 
	traspasos.codtraspaso,
	traspasos.codfactura, 
	traspasos.recibe, 
	traspasos.subtotalivasi, 
	traspasos.subtotalivano, 
	traspasos.iva, 
	traspasos.totaliva,
	traspasos.descontado, 
	traspasos.descuento, 
	traspasos.totaldescuento,
	traspasos.totalpago, 
	traspasos.totalpago2, 
	traspasos.fechatraspaso, 
	traspasos.observaciones, 
	traspasos.codigo,
	traspasos.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	documentos.documento,
	documentos2.documento AS documento2,
	sucursales2.documsucursal AS documsucursal2,
	sucursales2.cuitsucursal AS cuitsucursal2,
	sucursales2.nomsucursal AS nomsucursal2,
	sucursales2.documencargado AS documencargado2,
	sucursales2.dniencargado AS dniencargado2,
	sucursales2.nomencargado AS nomencargado2,
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	usuarios.dni,
	usuarios.nombres,
	SUM(detalletraspasos.cantidad) AS articulos 
	FROM (traspasos LEFT JOIN detalletraspasos ON detalletraspasos.codtraspaso = traspasos.codtraspaso)
	LEFT JOIN sucursales ON traspasos.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN sucursales AS sucursales2 ON traspasos.recibe = sucursales2.codsucursal
	LEFT JOIN documentos AS documentos3 ON sucursales.documsucursal = documentos3.coddocumento
	LEFT JOIN documentos AS documentos4 ON sucursales.documencargado = documentos4.coddocumento
	LEFT JOIN usuarios ON traspasos.codigo = usuarios.codigo 
	WHERE traspasos.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
	GROUP BY detalletraspasos.codtraspaso, traspasos.codsucursal 
	ORDER BY traspasos.idtraspaso ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

    }
}
############################ FUNCION LISTAR TRASPASOS ############################

############################ FUNCION ID TRASPASOS #################################
public function TraspasosPorId()
{
	self::SetNames();
	$sql = "SELECT 
	traspasos.idtraspaso, 
	traspasos.codtraspaso,
	traspasos.codfactura, 
	traspasos.recibe,
	traspasos.subtotalivasi,
	traspasos.subtotalivano, 
	traspasos.iva,
	traspasos.totaliva,
	traspasos.descontado, 
	traspasos.descuento,
	traspasos.totaldescuento, 
	traspasos.totalpago, 
	traspasos.totalpago2, 
	traspasos.fechatraspaso, 
	traspasos.observaciones, 
	traspasos.codigo,
	traspasos.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.id_provincia,
	sucursales.id_departamento,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	provincias.provincia,
	departamentos.departamento,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	documentos.documento,
	documentos2.documento AS documento2,
	sucursales2.documsucursal AS documsucursal2,
	sucursales2.cuitsucursal AS cuitsucursal2,
	sucursales2.nomsucursal AS nomsucursal2,
	sucursales2.id_provincia AS id_provincia2,
	sucursales2.id_departamento AS id_departamento2,
	sucursales2.direcsucursal AS direcsucursal2,
	sucursales2.correosucursal AS correosucursal2,
	sucursales2.tlfsucursal AS tlfsucursal2,
	sucursales2.documencargado AS documencargado2,
	sucursales2.dniencargado AS dniencargado2,
	sucursales2.nomencargado AS nomencargado2,
	sucursales2.tlfencargado AS tlfencargado2,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	usuarios.dni, 
	usuarios.nombres
	FROM (traspasos LEFT JOIN detalletraspasos ON detalletraspasos.codtraspaso = traspasos.codtraspaso)
	LEFT JOIN sucursales ON traspasos.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN sucursales AS sucursales2 ON traspasos.recibe = sucursales2.codsucursal
	LEFT JOIN documentos AS documentos3 ON sucursales.documsucursal = documentos3.coddocumento
	LEFT JOIN documentos AS documentos4 ON sucursales.documencargado = documentos4.coddocumento
	LEFT JOIN provincias AS provincias2 ON sucursales.id_provincia = provincias2.id_provincia
	LEFT JOIN departamentos AS departamentos2 ON sucursales.id_departamento = departamentos2.id_departamento
	LEFT JOIN usuarios ON traspasos.codigo = usuarios.codigo 
	WHERE traspasos.codtraspaso = ? AND traspasos.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codtraspaso"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID TRASPASOS #################################

############################ FUNCION VER DETALLES TRASPASOS ###########################
public function VerDetallesTraspasos()
{
	self::SetNames();
	$sql = "SELECT
	detalletraspasos.coddetalletraspaso,
	detalletraspasos.codtraspaso,
	detalletraspasos.idproducto,
	detalletraspasos.codproducto,
	detalletraspasos.producto,
	detalletraspasos.codmarca,
	detalletraspasos.codmodelo,
	detalletraspasos.codpresentacion,
	detalletraspasos.cantidad,
	detalletraspasos.preciocompra,
	detalletraspasos.precioventa,
	detalletraspasos.ivaproducto,
	detalletraspasos.descproducto,
	detalletraspasos.valortotal, 
	detalletraspasos.totaldescuentov,
	detalletraspasos.valorneto,
	detalletraspasos.valorneto2,
	detalletraspasos.tipodetalle,
	detalletraspasos.codsucursal,
	marcas.nommarca,
	modelos.nommodelo
	FROM detalletraspasos 
	LEFT JOIN marcas ON detalletraspasos.codmarca = marcas.codmarca
	LEFT JOIN modelos ON detalletraspasos.codmodelo = modelos.codmodelo 
	WHERE detalletraspasos.codtraspaso = ?
	AND detalletraspasos.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codtraspaso"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$this->p[]=$row;
	}
	return $this->p;
	$this->dbh=null;
}
############################ FUNCION VER DETALLES TRASPASOS ############################

############################ FUNCION ACTUALIZAR TRASPASOS ##########################
public function ActualizarTraspasos()
	{
	self::SetNames();
	if(empty($_POST["codtraspaso"]) or empty($_POST["recibe"]) or empty($_POST["codsucursal"]) or empty($_POST["fechatraspaso"]))
	{
		echo "1";
		exit;
	}

	############ VERIFICO QUE CANTIDAD NO SEA IGUAL A CERO #############
	for($i=0;$i<count($_POST['coddetalletraspaso']);$i++){  //recorro el array
        if (!empty($_POST['coddetalletraspaso'][$i])) {

	       if($_POST['cantidad'][$i]==0){

		      echo "2";
		      exit();
	       }
        }
    }
    ############ VERIFICO QUE CANTIDAD NO SEA IGUAL A CERO #############

	$this->dbh->beginTransaction();
	for($i=0;$i<count($_POST['coddetalletraspaso']);$i++){  //recorro el array
	if (!empty($_POST['coddetalletraspaso'][$i])) {

	############### OBTENGO DETALLES DE TRASPASOS ##################
	$sql = "SELECT 
	cantidad 
	FROM detalletraspasos 
	WHERE coddetalletraspaso = '".limpiar($_POST['coddetalletraspaso'][$i])."' 
	AND codtraspaso = '".limpiar(decrypt($_POST["codtraspaso"]))."' 
	AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$cantidadbd = $row['cantidad'];
	############### OBTENGO DETALLES DE TRASPASOS ##################

	if($cantidadbd != $_POST['cantidad'][$i]){

	############ CONSULTO LA EXISTENCIA DE PRODUCTO EN ALMACEN SALIENTE ############
    $sql = "SELECT existencia FROM productos 
    WHERE codproducto = '".limpiar($_POST['codproducto'][$i])."' 
    AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
	    foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$existenciabd = $row['existencia'];
	$cantidad = $_POST["cantidad"][$i];
	$cantidadbd = $_POST["cantidadbd"][$i];
	$totaltraspaso = $cantidad-$cantidadbd;
	############ CONSULTO LA EXISTENCIA DE PRODUCTO EN ALMACEN SALIENTE ############

    if ($totaltraspaso > $existenciabd) 
    { 
	    echo "3";
	    exit;
    }

	##################### ACTUALIZO DETALLES DE TRASPASOS ####################
	$query = "UPDATE detalletraspasos set"
	." cantidad = ?, "
	." valortotal = ?, "
	." totaldescuentov = ?, "
	." valorneto = ?, "
	." valorneto2 = ? "
	." WHERE "
	." coddetalletraspaso = ? AND codtraspaso = ? AND codsucursal = ?;
	";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $cantidad);
	$stmt->bindParam(2, $valortotal);
	$stmt->bindParam(3, $totaldescuentov);
	$stmt->bindParam(4, $valorneto);
	$stmt->bindParam(5, $valorneto2);
	$stmt->bindParam(6, $coddetalletraspaso);
	$stmt->bindParam(7, $codtraspaso);
	$stmt->bindParam(8, $codsucursal);

	$cantidad = limpiar($_POST['cantidad'][$i]);
	$preciocompra = limpiar($_POST['preciocompra'][$i]);
	$precioventa = limpiar($_POST['precioventa'][$i]);
	$ivaproducto = limpiar($_POST['ivaproducto'][$i]);
	$descuento = $_POST['descproducto'][$i]/100;
	$valortotal = number_format($_POST['valortotal'][$i], 2, '.', '');
	$totaldescuento = number_format($_POST['totaldescuentov'][$i], 2, '.', '');
	$valorneto = number_format($_POST['valorneto'][$i], 2, '.', '');
	$valorneto2 = number_format($_POST['valorneto2'][$i], 2, '.', '');
	$coddetalletraspaso = limpiar($_POST['coddetalletraspaso'][$i]);
	$codtraspaso = limpiar(decrypt($_POST["codtraspaso"]));
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();
	##################### ACTUALIZO DETALLES DE TRASPASOS ####################

	############## ACTUALIZAMOS EXISTENCIA DEL PRODUCTO EN ALMACEN #1 ##############
	$sql2 = " UPDATE productos set "
	." existencia = ? "
	." WHERE "
	." codproducto = '".limpiar($_POST["codproducto"][$i])."' 
	AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."';
	";
	$stmt = $this->dbh->prepare($sql2);
	$stmt->bindParam(1, $existencia);
	$existencia = $existenciabd-$totaltraspaso;
	$stmt->execute();
    ############## ACTUALIZAMOS EXISTENCIA DEL PRODUCTO EN ALMACEN #1 ##############

	############### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX #1 ###############
	$sql3 = " UPDATE kardex set "
	." salidas = ?, "
	." stockactual = ? "
	." WHERE "
	." codproceso = '".limpiar($_POST["codtraspaso"])."' 
	AND codproducto = '".limpiar($_POST["codproducto"][$i])."' 
	AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'
	AND tipokardex = 1;
	";
	$stmt = $this->dbh->prepare($sql3);
	$stmt->bindParam(1, $salidas);
	$stmt->bindParam(2, $existencia);
	
	$salidas = limpiar($_POST["cantidad"][$i]);
	$stmt->execute();
	############### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX #1 ###############

	############ CONSULTO LA EXISTENCIA DE PRODUCTO EN ALMACEN ENTRANDO ############
	$sql = "SELECT 
	existencia 
	FROM productos 
	WHERE codproducto = '".limpiar($_POST['codproducto'][$i])."' 
	AND codsucursal = '".limpiar(decrypt($_POST["recibe"]))."'";
	    foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$existenciarecibebd = $row['existencia'];
	############ CONSULTO LA EXISTENCIA DE PRODUCTO EN ALMACEN ENTRANDO ############

	############## ACTUALIZAMOS EXISTENCIA DE PRODUCTO EN ALMACEN #2 ##############
	$sql2 = " UPDATE productos set "
	." existencia = ? "
	." WHERE "
	." codproducto = '".limpiar($_POST["codproducto"][$i])."' 
	AND codsucursal = '".limpiar(decrypt($_POST["recibe"]))."';
	";
	$stmt = $this->dbh->prepare($sql2);
	$stmt->bindParam(1, $existenciarecibe);
	$existenciarecibe = $existenciarecibebd+$totaltraspaso;
	$stmt->execute();
	############## ACTUALIZAMOS EXISTENCIA DE PRODUCTO EN ALMACEN #2 ##############

    ############### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX #2 ###############
	$sql3 = " UPDATE kardex set "
	." entradas = ?, "
	." stockactual = ? "
	." WHERE "
	." codproceso = '".limpiar(decrypt($_POST["codtraspaso"]))."' 
	AND codproducto = '".limpiar($_POST["codproducto"][$i])."' 
	AND codsucursal = '".limpiar(decrypt($_POST["recibe"]))."'
	AND tipokardex = 1;
	";
	$stmt = $this->dbh->prepare($sql3);
	$stmt->bindParam(1, $entradas);
	$stmt->bindParam(2, $existenciarecibe);
	
    $existenciarecibe = $existenciarecibebd+$totaltraspaso;
	$entradas = limpiar($_POST["cantidad"][$i]);
	$stmt->execute();
	############### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX #2 ###############


		} else {

           echo "";

	       }
        }
    }
    $this->dbh->commit();

    ############ ACTUALIZO LOS TOTALES EN LA TRASPASOS ##############
	$sql = " UPDATE traspasos SET "
	." subtotalivasi = ?, "
	." subtotalivano = ?, "
	." totaliva = ?, "
	." descontado = ?, "
	." descuento = ?, "
	." totaldescuento = ?, "
	." totalpago = ?, "
	." totalpago2= ? "
	." WHERE "
	." codtraspaso = ? AND codsucursal = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $subtotalivasi);
	$stmt->bindParam(2, $subtotalivano);
	$stmt->bindParam(3, $totaliva);
	$stmt->bindParam(4, $descontado);
	$stmt->bindParam(5, $descuento);
	$stmt->bindParam(6, $totaldescuento);
	$stmt->bindParam(7, $totalpago);
	$stmt->bindParam(8, $totalpago2);
	$stmt->bindParam(9, $codtraspaso);
	$stmt->bindParam(10, $codsucursal);

	$subtotalivasi = number_format($_POST["txtsubtotal"], 2, '.', '');
	$subtotalivano = number_format($_POST["txtsubtotal2"], 2, '.', '');
	$totaliva = number_format($_POST["txtIva"], 2, '.', '');
	$descontado = number_format($_POST["txtdescontado"], 2, '.', '');
	$descuento = limpiar($_POST["descuento"]);
	$totaldescuento = number_format($_POST["txtDescuento"], 2, '.', '');
	$totalpago = number_format($_POST["txtTotal"], 2, '.', '');
	$totalpago2 = number_format($_POST["txtTotalCompra"], 2, '.', '');
	$codtraspaso = limpiar(decrypt($_POST["codtraspaso"]));
    $codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();
	############ ACTUALIZO LOS TOTALES EN LA TRASPASOS ##############

    echo "<span class='fa fa-check-square-o'></span> EL TRASPASO DE PRODUCTOS HA SIDO ACTUALIZADO EXITOSAMENTE <a href='reportepdf?codtraspaso=".encrypt($codtraspaso)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURATRASPASO")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

	echo "<script>window.open('reportepdf?codtraspaso=".encrypt($codtraspaso)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURATRASPASO")."', '_blank');</script>";
	exit;
}
######################### FUNCION ACTUALIZAR TRASPASOS ############################

######################### FUNCION AGREGAR DETALLES TRASPASOS #########################
public function AgregarDetallesTraspasos()
	{
	self::SetNames();
	if(empty($_POST["codtraspaso"]) or empty($_POST["recibe"]) or empty($_POST["codsucursal"]) or empty($_POST["fechatraspaso"]))
	{
		echo "1";
		exit;
	}
    elseif(empty($_SESSION["CarritoTraspaso"]) || $_POST["txtTotal"]=="0.00")
	{
		echo "2";
		exit;
		
	}

    $this->dbh->beginTransaction();
    $detalle = $_SESSION["CarritoTraspaso"];
	for($i=0;$i<count($detalle);$i++){

    ############### VERIFICO AL EXISTENCIA DEL PRODUCTO AGREGADO ################
	$sql = "SELECT * FROM productos 
	WHERE codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' 
	AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$existenciabd = $row['existencia'];
	############### VERIFICO AL EXISTENCIA DEL PRODUCTO AGREGADO ################

	############# REVISAMOS QUE LA CANTIDAD NO SEA IGUAL A CERO ##############
	if($detalle[$i]['cantidad']==0){

		echo "3";
		exit;
    
    }
    ############# REVISAMOS QUE LA CANTIDAD NO SEA IGUAL A CERO ##############

	############ REVISAMOS SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #######
    if ($detalle[$i]['cantidad'] > $existenciabd) 
    { 
       echo "4";
       exit;
    }
    ############ REVISAMOS SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #######

	$sql = "SELECT 
	codtraspaso, 
	codproducto 
	FROM detalletraspasos 
	WHERE codtraspaso = '".limpiar(decrypt($_POST['codtraspaso']))."' 
	AND codsucursal = '".limpiar(decrypt($_POST['codsucursal']))."' 
	AND codproducto = '".limpiar($detalle[$i]['txtCodigo'])."'";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num == 0)
	{

        $query = "INSERT INTO detalletraspasos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codtraspaso);
        $stmt->bindParam(2, $idproducto);
	    $stmt->bindParam(3, $codproducto);
	    $stmt->bindParam(4, $producto);
        $stmt->bindParam(5, $codmarca);
        $stmt->bindParam(6, $codmodelo);
        $stmt->bindParam(7, $codpresentacion);
		$stmt->bindParam(8, $cantidad);
		$stmt->bindParam(9, $preciocompra);
		$stmt->bindParam(10, $precioventa);
		$stmt->bindParam(11, $ivaproducto);
		$stmt->bindParam(12, $descproducto);
		$stmt->bindParam(13, $valortotal);
		$stmt->bindParam(14, $totaldescuentov);
		$stmt->bindParam(15, $valorneto);
		$stmt->bindParam(16, $valorneto2);
		$stmt->bindParam(17, $tipodetalle);
		$stmt->bindParam(18, $codsucursal);
			
		$codtraspaso = limpiar(decrypt($_POST["codtraspaso"]));
	    $idproducto = limpiar($detalle[$i]['id']);
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$producto = limpiar($detalle[$i]['producto']);
		$codmarca = limpiar($detalle[$i]['codmarca']);
		$codmodelo = limpiar($detalle[$i]['codmodelo']);
		$codpresentacion = limpiar($detalle[$i]['codpresentacion']);
		$cantidad = limpiar($detalle[$i]['cantidad']);
		$preciocompra = limpiar($detalle[$i]['precio']);
		$precioventa = limpiar($detalle[$i]['precio2']);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$descuento = $detalle[$i]['descproducto']/100;
		$valortotal = number_format($detalle[$i]['precio2']*$detalle[$i]['cantidad'], 2, '.', '');
		$totaldescuentov = number_format($valortotal*$descuento, 2, '.', '');
	    $valorneto = number_format($valortotal-$totaldescuentov, 2, '.', '');
		$valorneto2 = number_format($detalle[$i]['precio']*$detalle[$i]['cantidad'], 2, '.', '');
        $tipodetalle = limpiar($detalle[$i]['tipodetalle']);
		$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
		$stmt->execute();

	    ##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN #1 ###################
		$sql = " UPDATE productos set "
		." existencia = ? "
		." where "
		." codproducto = '".limpiar($detalle[$i]['txtCodigo'])."'
		AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."';
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$cantraspaso = limpiar($detalle[$i]['cantidad']);
		$existencia = $existenciabd-$cantraspaso;
		$stmt->execute();
		##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN #1 ###################

		############### REGISTRAMOS LOS PRODUCTOS SALIENTES EN KARDEX #1 ###############
        $query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codtraspaso);
		$stmt->bindParam(2, $codresponsable);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);	
		$stmt->bindParam(14, $tipokardex);		
		$stmt->bindParam(15, $codsucursal);

		$codresponsable = limpiar(decrypt($_POST["recibe"]));
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$movimiento = limpiar("SALIDAS");
		$entradas = limpiar("0");
		$salidas= limpiar($detalle[$i]['cantidad']);
		$devolucion = limpiar("0");
		$stockactual = limpiar($existenciabd-$detalle[$i]['cantidad']);
		$precio = limpiar($detalle[$i]["precio2"]);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$documento = limpiar("TRASPASO: ".$codtraspaso);
		$fechakardex = limpiar(date("Y-m-d"));
		$tipokardex = limpiar($detalle[$i]['tipodetalle']);
		$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
		$stmt->execute();

	  } else {

	  	############### OBTENGO DETALLES DE TRASPASOS ##################
	  	$sql = "SELECT cantidad FROM detalletraspasos 
	  	WHERE codtraspaso = '".limpiar(decrypt($_POST['codtraspaso']))."' 
	  	AND codsucursal = '".limpiar(decrypt($_POST['codsucursal']))."' 
	  	AND codproducto = '".limpiar($detalle[$i]['txtCodigo'])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$cantidadbd = $row['cantidad'];
		############### OBTENGO DETALLES DE TRASPASOS ##################

	  	##################### ACTUALIZO DETALLES DE TRASPASOS ####################
	  	$query = "UPDATE detalletraspasos set"
		." cantidad = ?, "
		." descproducto = ?, "
		." valortotal = ?, "
		." totaldescuentov = ?, "
		." valorneto = ?, "
		." valorneto2 = ? "
		." WHERE "
		." codtraspaso = ? AND codsucursal = ? AND codproducto = ?;
		";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $cantidad);
		$stmt->bindParam(2, $descproducto);
		$stmt->bindParam(3, $valortotal);
		$stmt->bindParam(4, $totaldescuentov);
		$stmt->bindParam(5, $valorneto);
		$stmt->bindParam(6, $valorneto2);
		$stmt->bindParam(7, $codtraspaso);
		$stmt->bindParam(8, $codsucursal);
		$stmt->bindParam(9, $codproducto);

		$cantidad = limpiar($detalle[$i]['cantidad']+$cantidadbd);
		$preciocompra = limpiar($detalle[$i]['precio']);
		$precioventa = limpiar($detalle[$i]['precio2']);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$descuento = $detalle[$i]['descproducto']/100;
		$valortotal = number_format($detalle[$i]['precio2'] * $cantidad, 2, '.', '');
		$totaldescuentov = number_format($valortotal * $descuento, 2, '.', '');
		$valorneto = number_format($valortotal - $totaldescuentov, 2, '.', '');
		$valorneto2 = number_format($detalle[$i]['precio'] * $cantidad, 2, '.', '');
		$codtraspaso = limpiar(decrypt($_POST["codtraspaso"]));
		$codsucursal = limpiar(decrypt($_POST['codsucursal']));
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$stmt->execute();
		##################### ACTUALIZO DETALLES DE TRASPASOS ####################

		############## ACTUALIZAMOS EXISTENCIA DEL PRODUCTO EN ALMACEN #1 ##############
		$sql = " UPDATE productos set "
			  ." existencia = ? "
			  ." where "
			  ." codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' 
			  AND codsucursal = '".limpiar(decrypt($_POST['codsucursal']))."';
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$cantraspaso = limpiar($detalle[$i]['cantidad']);
		$existencia = $existenciabd-$cantraspaso;
		$stmt->execute();
		############## ACTUALIZAMOS EXISTENCIA DEL PRODUCTO EN ALMACEN #1 ##############

		############### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX #1 ##############
		$sql3 = " UPDATE kardex set "
		." salidas = ?, "
		." stockactual = ? "
		." WHERE "
		." codproceso = '".limpiar(decrypt($_POST["codtraspaso"]))."' 
		AND codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' 
		AND codsucursal = '".limpiar(decrypt($_POST['codsucursal']))."'
		AND tipokardex = 1;
		";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->bindParam(1, $salidas);
		$stmt->bindParam(2, $existencia);
		
		$salidas = limpiar($detalle[$i]['cantidad']+$cantidadbd);
		$stmt->execute();
		############### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX #1 ##############

	 }//FIN DE AGREGAR DETALLES DE PRODUCTOS

	############### VERIFICO AL EXISTENCIA DEL PRODUCTO AGREGADO ################
	$sql = "SELECT * FROM productos 
	WHERE codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' 
	AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	############### VERIFICO AL EXISTENCIA DEL PRODUCTO AGREGADO ################

	############ VERIFICO SI EL PRODUCTO YA EXISTE EN LA SUCURSAL QUE RECIBE ###########
	$sql = "SELECT codproducto FROM productos WHERE codproducto = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($detalle[$i]['txtCodigo']),limpiar(decrypt($_POST['recibe']))));
	$num = $stmt->rowCount();
	if($num == 0)
	{

		############################## REGISTRO DATOS DE PRODUCTOS ##############################
		$query = "INSERT INTO productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codproducto);
		$stmt->bindParam(2, $producto);
		$stmt->bindParam(3, $fabricante);
		$stmt->bindParam(4, $codfamilia);
		$stmt->bindParam(5, $codsubfamilia);
		$stmt->bindParam(6, $codmarca);
		$stmt->bindParam(7, $codmodelo);
		$stmt->bindParam(8, $codpresentacion);
		$stmt->bindParam(9, $codcolor);
		$stmt->bindParam(10, $codorigen);
		$stmt->bindParam(11, $year);
		$stmt->bindParam(12, $nroparte);
		$stmt->bindParam(13, $lote);
		$stmt->bindParam(14, $peso);
		$stmt->bindParam(15, $preciocompra);
		$stmt->bindParam(16, $precioxmenor);
		$stmt->bindParam(17, $precioxmayor);
		$stmt->bindParam(18, $precioxpublico);
		$stmt->bindParam(19, $existencia);
		$stmt->bindParam(20, $stockoptimo);
		$stmt->bindParam(21, $stockmedio);
		$stmt->bindParam(22, $stockminimo);
		$stmt->bindParam(23, $ivaproducto);
		$stmt->bindParam(24, $descproducto);
		$stmt->bindParam(25, $codigobarra);
		$stmt->bindParam(26, $fechaelaboracion);
		$stmt->bindParam(27, $fechaoptimo);
		$stmt->bindParam(28, $fechamedio);
		$stmt->bindParam(29, $fechaminimo);
		$stmt->bindParam(30, $codproveedor);
		$stmt->bindParam(31, $stockteorico);
		$stmt->bindParam(32, $motivoajuste);
		$stmt->bindParam(33, $recibe);

		$codproducto = limpiar($detalle[$i]["txtCodigo"]);
		$producto = limpiar($row["producto"]);
		$fabricante = limpiar($row["fabricante"]);
		$codfamilia = limpiar($row["codfamilia"]);
		$codsubfamilia = limpiar($row["codsubfamilia"]);
		$codmarca = limpiar($row["codmarca"]);
		$codmodelo = limpiar($row["codmodelo"]);
		$codpresentacion = limpiar($row["codpresentacion"]);
		$codcolor = limpiar($row["codcolor"]);
		$codorigen = limpiar($row["codorigen"]);
		$year = limpiar($row["year"]);
		$nroparte = limpiar($row["nroparte"]);
		$lote = limpiar($row["lote"]);
		$peso = limpiar($row["peso"]);
		$preciocompra = limpiar($detalle[$i]["precio"]);
		$precioxmenor = limpiar($row["precioxmenor"]);
		$precioxmayor = limpiar($row["precioxmayor"]);
		$precioxpublico = limpiar($row["precioxpublico"]);
		$existencia = limpiar($detalle[$i]["cantidad"]);
		$stockoptimo = limpiar($row["stockoptimo"]);
		$stockmedio = limpiar($row["stockmedio"]);
		$stockminimo = limpiar($row["stockminimo"]);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$codigobarra = limpiar($row["codigobarra"]);
		$fechaelaboracion = limpiar($row['fechaelaboracion']);
		$fechaoptimo = limpiar($row['fechaoptimo']);
		$fechamedio = limpiar($row['fechamedio']);
		$fechaminimo = limpiar($row['fechaminimo']);
		$codproveedor = limpiar($row["codproveedor"]);
		$stockteorico = limpiar("0");
		$motivoajuste = limpiar("NINGUNO");
		$recibe = limpiar(decrypt($_POST["recibe"]));
		$stmt->execute();
		############################## REGISTRO DATOS DE PRODUCTOS ##############################

		################# REGISTRAMOS KARDEX DE PRODUCTO QUE RECIBE ###################
        $query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codtraspaso);
		$stmt->bindParam(2, $codresponsable);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);	
		$stmt->bindParam(14, $tipokardex);		
		$stmt->bindParam(15, $recibe);

		$codresponsable = limpiar(decrypt($_POST["codsucursal"]));
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$movimiento = limpiar("ENTRADAS");
		$entradas= limpiar($detalle[$i]['cantidad']);
		$salidas = limpiar("0");
		$devolucion = limpiar("0");
		$stockactual = limpiar($detalle[$i]['cantidad']);
		$precio = limpiar($detalle[$i]["precio"]);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$documento = limpiar("TRASPASO ".$codtraspaso);
		$fechakardex = limpiar(date("Y-m-d"));
		$tipokardex = limpiar($detalle[$i]['tipodetalle']);
		$recibe = limpiar(decrypt($_POST["recibe"]));
		$stmt->execute();

	} else {

		################ VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ################
		$sql = "SELECT * FROM productos 
		WHERE codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' 
		AND codsucursal = '".limpiar(decrypt($_POST["recibe"]))."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$existenciarecibebd = $row['existencia'];
		################ VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ################

		############# ACTUALIZAMOS LA EXISTENCIA DE PRODUCTOS RECIBIDOS ###############
		$sql = "UPDATE productos set "
		      ." preciocompra = ?, "
			  ." existencia = ?, "
			  ." ivaproducto = ?, "
			  ." descproducto = ? "
			  ." WHERE "
			  ." codproducto = ? AND codsucursal = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $preciocompra);
		$stmt->bindParam(2, $existencia);
		$stmt->bindParam(3, $ivaproducto);
		$stmt->bindParam(4, $descproducto);
		$stmt->bindParam(5, $codproducto);
		$stmt->bindParam(6, $recibe);
		
		$preciocompra = limpiar($detalle[$i]['precio']);
		$existencia = limpiar($existenciarecibebd+$detalle[$i]['cantidad']);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$recibe = limpiar(decrypt($_POST["recibe"]));
		$stmt->execute();
		############# ACTUALIZAMOS LA EXISTENCIA DE PRODUCTOS RECIBIDOS ###############

		################# REGISTRAMOS KARDEX DE PRODUCTO QUE RECIBE ###################
        $query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codtraspaso);
		$stmt->bindParam(2, $codresponsable);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);	
		$stmt->bindParam(14, $tipokardex);	
		$stmt->bindParam(15, $recibe);

		$codresponsable = limpiar(decrypt($_POST["codsucursal"]));
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$movimiento = limpiar("ENTRADAS");
		$entradas= limpiar($detalle[$i]['cantidad']);
		$salidas = limpiar("0");
		$devolucion = limpiar("0");
		$stockactual = limpiar($existenciarecibebd+$detalle[$i]['cantidad']);
		$precio = limpiar($detalle[$i]["precio"]);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$documento = limpiar("TRASPASO ".$codtraspaso);
		$fechakardex = limpiar(date("Y-m-d"));
		$tipokardex = limpiar($detalle[$i]['tipodetalle']);
		$recibe = limpiar(decrypt($_POST["recibe"]));
		$stmt->execute();
		################# REGISTRAMOS KARDEX DE PRODUCTO QUE RECIBE ###################

	}//FIN DE REGISTRO DE PRODUCTOS

        }//FIN SESSION DETALLES

    
    ####################### DESTRUYO LA VARIABLE DE SESSION #####################
    unset($_SESSION["CarritoTraspaso"]);
    $this->dbh->commit();

    ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############
	$sql3 = "SELECT SUM(totaldescuentov) AS totaldescuentosi, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detalletraspasos WHERE codtraspaso = '".limpiar(decrypt($_POST["codtraspaso"]))."' AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."' AND ivaproducto = 'SI'";
	foreach ($this->dbh->query($sql3) as $row3)
	{
		$this->p[] = $row3;
	}
	$subtotaldescuentosi = ($row3['totaldescuentosi']== "" ? "0.00" : $row3['totaldescuentosi']);
	$subtotalivasi = ($row3['valorneto']== "" ? "0.00" : $row3['valorneto']);
	$subtotalivasi2 = ($row3['valorneto2']== "" ? "0.00" : $row3['valorneto2']);
	############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############	

	############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############
	$sql4 = "SELECT SUM(totaldescuentov) AS totaldescuentono, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detalletraspasos WHERE codtraspaso = '".limpiar(decrypt($_POST["codtraspaso"]))."' AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."' AND ivaproducto = 'NO'";
	foreach ($this->dbh->query($sql4) as $row4)
	{
		$this->p[] = $row4;
	}
	$subtotaldescuentono = ($row4['totaldescuentono']== "" ? "0.00" : $row4['totaldescuentono']);
	$subtotalivano = ($row4['valorneto']== "" ? "0.00" : $row4['valorneto']);
	$subtotalivano2 = ($row4['valorneto2']== "" ? "0.00" : $row4['valorneto2']);
	############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############


    ############ ACTUALIZO LOS TOTALES EN TRASPASOS ##############
	$sql = " UPDATE traspasos SET "
	." subtotalivasi = ?, "
	." subtotalivano = ?, "
	." totaliva = ?, "
	." descontado = ?, "
	." descuento = ?, "
	." totaldescuento = ?, "
	." totalpago = ?, "
	." totalpago2= ? "
	." WHERE "
	." codtraspaso = ? AND codsucursal = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $subtotalivasi);
	$stmt->bindParam(2, $subtotalivano);
	$stmt->bindParam(3, $totaliva);
	$stmt->bindParam(4, $descontado);
	$stmt->bindParam(5, $descuento);
	$stmt->bindParam(6, $totaldescuento);
	$stmt->bindParam(7, $totalpago);
	$stmt->bindParam(8, $totalpago2);
	$stmt->bindParam(9, $codtraspaso);
	$stmt->bindParam(10, $codsucursal);

	$iva = $_POST["iva"]/100;
	$totaliva = number_format($subtotalivasi*$iva, 2, '.', '');
	$descontado = number_format($subtotaldescuentosi+$subtotaldescuentono, 2, '.', '');
	$descuento = limpiar($_POST["descuento"]);
    $txtDescuento = $_POST["descuento"]/100;
    $total = number_format($subtotalivasi+$subtotalivano+$totaliva, 2, '.', '');
    $totaldescuento = number_format($total*$txtDescuento, 2, '.', '');
    $totalpago = number_format($total-$totaldescuento, 2, '.', '');
	$totalpago2 = number_format($subtotalivasi2+$subtotalivano2, 2, '.', '');
	$codtraspaso = limpiar(decrypt($_POST["codtraspaso"]));
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();
	############ ACTUALIZO LOS TOTALES EN TRASPASOS ##############

    echo "<span class='fa fa-check-square-o'></span> LOS DETALLES DE PRODUCTOS FUERON AGREGADOS AL TRASPASO EXITOSAMENTE <a href='reportepdf?codtraspaso=".encrypt($codtraspaso)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURATRASPASO")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

	echo "<script>window.open('reportepdf?codtraspaso=".encrypt($codtraspaso)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURATRASPASO")."', '_blank');</script>";
	exit;
}
########################### FUNCION AGREGAR DETALLES TRASPASOS #########################

########################## FUNCION ELIMINAR DETALLES TRASPASOS ##########################
public function EliminarDetallesTraspasos()
	{
	self::SetNames();
	if ($_SESSION["acceso"]=="administradorS") {

    ############ CONSULTO DATOS DE TRASPASO ##############
	$sql = "SELECT * FROM traspasos 
	WHERE codtraspaso = '".limpiar(decrypt($_GET["codtraspaso"]))."' 
	AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$recibebd = $row['recibe'];
	$totalpagobd = $row['totalpago'];
	############ CONSULTO DATOS DE TRASPASO ##############

	$sql = "SELECT * FROM detalletraspasos WHERE codtraspaso = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codtraspaso"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num > 1)
	{

		############ OBTENGO DETALLES DE TRASPASO ##############
		$sql = "SELECT 
		codproducto, 
		cantidad, 
		precioventa, 
		ivaproducto, 
		descproducto 
		FROM detalletraspasos 
		WHERE coddetalletraspaso = ? 
		AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["coddetalletraspaso"]),decrypt($_GET["codsucursal"])));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$codproducto = $row['codproducto'];
		$cantidadbd = $row['cantidad'];
		$precioventabd = $row['precioventa'];
		$ivaproductobd = $row['ivaproducto'];
		$descproductobd = $row['descproducto'];
		############ OBTENGO DETALLES DE TRASPASO ##############


    ######################### DATOS DE SUCURSAL QUE ENVIA TRASPASO #######################	

	############ OBTENGO LA EXISTENCIA DE PRODUCTO EN ALMACEN #############
	$sql2 = "SELECT existencia FROM productos WHERE codproducto = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql2);
	$stmt->execute(array($codproducto,decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();

	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$p[] = $row;
	}
	$existenciabd = $row['existencia'];
	############ OBTENGO LA EXISTENCIA DE PRODUCTO EN ALMACEN #############

	############ ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############
	$sql = "UPDATE productos SET "
	." existencia = ? "
	." WHERE "
	." codproducto = ? AND codsucursal = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $existencia);
	$stmt->bindParam(2, $codproducto);
	$stmt->bindParam(3, $codsucursal);

	$existencia = limpiar($existenciabd+$cantidadbd);
	$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
	$stmt->execute();
	############ ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############

    ########## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ##########
	$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codtraspaso);
	$stmt->bindParam(2, $recibe);
	$stmt->bindParam(3, $codproducto);
	$stmt->bindParam(4, $movimiento);
	$stmt->bindParam(5, $entradas);
	$stmt->bindParam(6, $salidas);
	$stmt->bindParam(7, $devolucion);
	$stmt->bindParam(8, $stockactual);
	$stmt->bindParam(9, $ivaproducto);
	$stmt->bindParam(10, $descproducto);
	$stmt->bindParam(11, $precio);
	$stmt->bindParam(12, $documento);
	$stmt->bindParam(13, $fechakardex);	
	$stmt->bindParam(14, $tipokardex);	
	$stmt->bindParam(15, $codsucursal);

	$codtraspaso = limpiar(decrypt($_GET["codtraspaso"]));
	$recibe = limpiar(decrypt($_GET["recibe"]));
	$movimiento = limpiar("DEVOLUCION");
	$entradas= limpiar("0");
	$salidas = limpiar("0");
	$devolucion = limpiar($cantidadbd);
	$stockactual = limpiar($existenciabd+$cantidadbd);
	$precio = limpiar($precioventabd);
	$ivaproducto = limpiar($ivaproductobd);
	$descproducto = limpiar($descproductobd);
	$documento = limpiar("DEVOLUCION TRASPASO: ".decrypt($_GET["codtraspaso"]));
	$fechakardex = limpiar(date("Y-m-d"));
	$tipokardex = limpiar("1");
	$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
	$stmt->execute();
	########## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ##########

    ######################### DATOS DE SUCURSAL QUE ENVIA TRASPASO #######################			

    ######################### DATOS DE SUCURSAL QUE RECIBE TRASPASO #######################			
		
	############ OBTENGO LA EXISTENCIA DE PRODUCTO EN ALMACEN #############
	$sql2 = "SELECT existencia FROM productos WHERE codproducto = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql2);
	$stmt->execute(array($codproducto,$recibebd));
	$num = $stmt->rowCount();

	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$p[] = $row;
	}
	$existenciarecibebd = $row['existencia'];
	############ OBTENGO LA EXISTENCIA DE PRODUCTO EN ALMACEN #############

	############ ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############
	$sql = "UPDATE productos SET "
	." existencia = ? "
	." WHERE "
	." codproducto = ? AND codsucursal = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $existencia);
	$stmt->bindParam(2, $codproducto);
	$stmt->bindParam(3, $recibebd);

	$existencia = limpiar($existenciarecibebd-$cantidadbd);
	$stmt->execute();
	############ ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############

    ########## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ##########
	$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codtraspaso);
	$stmt->bindParam(2, $codsucursal);
	$stmt->bindParam(3, $codproducto);
	$stmt->bindParam(4, $movimiento);
	$stmt->bindParam(5, $entradas);
	$stmt->bindParam(6, $salidas);
	$stmt->bindParam(7, $devolucion);
	$stmt->bindParam(8, $stockactual);
	$stmt->bindParam(9, $ivaproducto);
	$stmt->bindParam(10, $descproducto);
	$stmt->bindParam(11, $precio);
	$stmt->bindParam(12, $documento);
	$stmt->bindParam(13, $fechakardex);
	$stmt->bindParam(14, $tipokardex);	
	$stmt->bindParam(15, $recibe);

	$codtraspaso = limpiar(decrypt($_GET["codtraspaso"]));			
	$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
	$movimiento = limpiar("DEVOLUCION");
	$entradas= limpiar("0");
	$salidas = limpiar("0");
	$devolucion = limpiar($cantidadbd);
	$stockactual = limpiar($existenciarecibebd-$cantidadbd);
	$precio = limpiar($precioventabd);
	$ivaproducto = limpiar($ivaproductobd);
	$descproducto = limpiar($descproductobd);
	$documento = limpiar("DEVOLUCION TRASPASO: ".decrypt($_GET["codtraspaso"]));
	$fechakardex = limpiar(date("Y-m-d"));
	$tipokardex = limpiar("1");
	$recibe = limpiar($recibebd);
	$stmt->execute();
	########## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ##########

    ######################### DATOS DE SUCURSAL QUE RECIBE TRASPASO #######################			

	########## ELIMINO DETALLES DE TRASPASOS ##########
	$sql = "DELETE FROM detalletraspasos WHERE coddetalletraspaso = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1,$coddetalletraspaso);
	$stmt->bindParam(2,$codsucursal);
	$coddetalletraspaso = decrypt($_GET["coddetalletraspaso"]);
	$codsucursal = decrypt($_GET["codsucursal"]);
	$stmt->execute();
	########## ELIMINO DETALLES DE TRASPASOS ##########

	 ############ CONSULTO LOS TOTALES DE TRASPASO ##############
    $sql2 = "SELECT iva, descuento FROM traspasos WHERE codtraspaso = ? AND codsucursal = ?";
    $stmt = $this->dbh->prepare($sql2);
    $stmt->execute(array(decrypt($_GET["codtraspaso"]),decrypt($_GET["codsucursal"])));
    $num = $stmt->rowCount();

	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$paea[] = $row;
	}
	$iva = $paea[0]["iva"]/100;
    $descuento = $paea[0]["descuento"]/100;
    ############ CONSULTO LOS TOTALES DE TRASPASO ##############

    ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############
	$sql3 = "SELECT SUM(totaldescuentov) AS totaldescuentosi, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detalletraspasos WHERE codtraspaso = '".limpiar(decrypt($_GET["codtraspaso"]))."' AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."' AND ivaproducto = 'SI'";
	foreach ($this->dbh->query($sql3) as $row3)
	{
		$this->p[] = $row3;
	}
	$subtotaldescuentosi = ($row3['totaldescuentosi']== "" ? "0.00" : $row3['totaldescuentosi']);
	$subtotalivasi = ($row3['valorneto']== "" ? "0.00" : $row3['valorneto']);
	$subtotalivasi2 = ($row3['valorneto2']== "" ? "0.00" : $row3['valorneto2']);
	############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############

    ############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############
	$sql4 = "SELECT SUM(totaldescuentov) AS totaldescuentono, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detalletraspasos WHERE codtraspaso = '".limpiar(decrypt($_GET["codtraspaso"]))."' AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."' AND ivaproducto = 'NO'";
	foreach ($this->dbh->query($sql4) as $row4)
	{
		$this->p[] = $row4;
	}
	$subtotaldescuentono = ($row4['totaldescuentono']== "" ? "0.00" : $row4['totaldescuentono']);
	$subtotalivano = ($row4['valorneto']== "" ? "0.00" : $row4['valorneto']);
	$subtotalivano2 = ($row4['valorneto2']== "" ? "0.00" : $row4['valorneto2']);
	############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############

    ############ ACTUALIZO LOS TOTALES EN EL TRASPASO ##############
	$sql = " UPDATE traspasos SET "
	." subtotalivasi = ?, "
	." subtotalivano = ?, "
	." totaliva = ?, "
	." descontado = ?, "
	." totaldescuento = ?, "
	." totalpago = ?, "
	." totalpago2= ? "
	." WHERE "
	." codtraspaso = ? AND codsucursal = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $subtotalivasi);
	$stmt->bindParam(2, $subtotalivano);
	$stmt->bindParam(3, $totaliva);
	$stmt->bindParam(4, $descontado);
	$stmt->bindParam(5, $totaldescuento);
	$stmt->bindParam(6, $totalpago);
	$stmt->bindParam(7, $totalpago2);
	$stmt->bindParam(8, $codtraspaso);
	$stmt->bindParam(9, $codsucursal);

	$totaliva= number_format($subtotalivasi*$iva, 2, '.', '');
	$descontado = number_format($subtotaldescuentosi+$subtotaldescuentono, 2, '.', '');
    $total= number_format($subtotalivasi+$subtotalivano+$totaliva, 2, '.', '');
    $totaldescuento= number_format($total*$descuento, 2, '.', '');
    $totalpago= number_format($total-$totaldescuento, 2, '.', '');
	$totalpago2 = number_format($subtotalivasi2+$subtotalivano2, 2, '.', '');
	$codtraspaso = limpiar(decrypt($_GET["codtraspaso"]));
	$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
	$stmt->execute();
	############ ACTUALIZO LOS TOTALES EN EL TRASPASO ##############

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
			
	} else {
		
		echo "3";
		exit;
	}	
}
######################### FUNCION ELIMINAR DETALLES TRASPASOS #########################

########################## FUNCION ELIMINAR TRASPASOS #############################
public function EliminarTraspasos()
	{
	self::SetNames();
	if ($_SESSION["acceso"]=="administradorS") {

    ########################## CONSULTO DATOS DE TRASPASO ##########################
	$sql = "SELECT * FROM traspasos 
	WHERE codtraspaso = '".limpiar(decrypt($_GET["codtraspaso"]))."' 
	AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$recibebd = $row['recibe'];
	$totalpagobd = $row['totalpago'];
	########################## CONSULTO DATOS DE TRASPASO ##########################

    $sql = "SELECT * FROM detalletraspasos 
    WHERE codtraspaso = '".limpiar(decrypt($_GET["codtraspaso"]))."' 
    AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;

		$codproductobd = $row['codproducto'];
		$cantidadbd = $row['cantidad'];
		$precioventabd = $row['precioventa'];
		$ivaproductobd = $row['ivaproducto'];
		$descproductobd = $row['descproducto'];

    ######################### DATOS DE SUCURSAL QUE ENVIA TRASPASO #######################

    ############ OBTENGO LA EXISTENCIA DE PRODUCTO EN ALMACEN #############
	$sql2 = "SELECT existencia FROM productos WHERE codproducto = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql2);
	$stmt->execute(array($codproductobd,decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();

	if($row2 = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$p[] = $row2;
	}
	$existenciaenviabd = $row2['existencia'];
	############ OBTENGO LA EXISTENCIA DE PRODUCTO EN ALMACEN #############

	########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN ############
	$sql = "UPDATE productos SET "
	." existencia = ? "
	." WHERE "
	." codproducto = ? AND codsucursal = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $existencia);
	$stmt->bindParam(2, $codproductobd);
	$stmt->bindParam(3, $codsucursal);

	$existencia = limpiar($existenciaenviabd+$cantidadbd);
	$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
	$stmt->execute();
	########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN ############

    ########### REGISTRAMOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ############
	$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codtraspaso);
	$stmt->bindParam(2, $recibe);
	$stmt->bindParam(3, $codproducto);
	$stmt->bindParam(4, $movimiento);
	$stmt->bindParam(5, $entradas);
	$stmt->bindParam(6, $salidas);
	$stmt->bindParam(7, $devolucion);
	$stmt->bindParam(8, $stockactual);
	$stmt->bindParam(9, $ivaproducto);
	$stmt->bindParam(10, $descproducto);
	$stmt->bindParam(11, $precio);
	$stmt->bindParam(12, $documento);
	$stmt->bindParam(13, $fechakardex);	
	$stmt->bindParam(14, $tipokardex);	
	$stmt->bindParam(15, $codsucursal);

	$codtraspaso = limpiar(decrypt($_GET["codtraspaso"]));
    $recibe = limpiar($recibebd);
    $codproducto = limpiar($codproductobd);
	$movimiento = limpiar("DEVOLUCION");
	$entradas= limpiar("0");
	$salidas = limpiar("0");
	$devolucion = limpiar($cantidadbd);
	$stockactual = limpiar($existenciaenviabd+$cantidadbd);
	$ivaproducto = limpiar($ivaproductobd);
	$descproducto = limpiar($descproductobd);
	$precio = limpiar($precioventabd);
	$documento = limpiar("DEVOLUCION TRASPASO: ".decrypt($_GET["codtraspaso"]));
	$fechakardex = limpiar(date("Y-m-d"));
	$tipokardex = limpiar("1");
	$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
	$stmt->execute();
	########### REGISTRAMOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ############
    
    ######################### DATOS DE SUCURSAL QUE ENVIA TRASPASO #######################			





    ######################### DATOS DE SUCURSAL QUE RECIBE TRASPASO #######################			
            
    ############ OBTENGO LA EXISTENCIA DE PRODUCTO EN ALMACEN #############
	$sql3 = "SELECT existencia FROM productos WHERE codproducto = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql3);
	$stmt->execute(array($codproductobd,$recibebd));
	$num = $stmt->rowCount();

	if($row3 = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$p[] = $row3;
	}
	$existenciarecibebd = $row3['existencia'];
	############ OBTENGO LA EXISTENCIA DE PRODUCTO EN ALMACEN #############

	########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN ############
	$sql = "UPDATE productos SET "
	." existencia = ? "
	." WHERE "
	." codproducto = ? AND codsucursal = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $existencia);
	$stmt->bindParam(2, $codproductobd);
	$stmt->bindParam(3, $recibebd);

	$existencia = limpiar($existenciarecibebd-$cantidadbd);
	$stmt->execute();
	########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN ############

    ########### REGISTRAMOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ############
	$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codtraspaso);
	$stmt->bindParam(2, $codsucursal);
	$stmt->bindParam(3, $codproducto);
	$stmt->bindParam(4, $movimiento);
	$stmt->bindParam(5, $entradas);
	$stmt->bindParam(6, $salidas);
	$stmt->bindParam(7, $devolucion);
	$stmt->bindParam(8, $stockactual);
	$stmt->bindParam(9, $ivaproducto);
	$stmt->bindParam(10, $descproducto);
	$stmt->bindParam(11, $precio);
	$stmt->bindParam(12, $documento);
	$stmt->bindParam(13, $fechakardex);
    $stmt->bindParam(14, $tipokardex);	
    $stmt->bindParam(15, $recibe);

	$codtraspaso = limpiar(decrypt($_GET["codtraspaso"]));		
	$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
	$movimiento = limpiar("DEVOLUCION");
	$entradas= limpiar("0");
	$salidas = limpiar("0");
	$devolucion = limpiar($cantidadbd);
	$stockactual = limpiar($existenciarecibebd-$cantidadbd);
	$precio = limpiar($precioventabd);
	$ivaproducto = limpiar($ivaproductobd);
	$descproducto = limpiar($descproductobd);
	$documento = limpiar("DEVOLUCION TRASPASO: ".decrypt($_GET["codtraspaso"]));
	$fechakardex = limpiar(date("Y-m-d"));
	$tipokardex = limpiar("1");
    $recibe = limpiar($recibebd);
	$stmt->execute();
	########### REGISTRAMOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ############

    ######################### DATOS DE SUCURSAL QUE RECIBE TRASPASO #######################			
	}

	########################## ELIMINO TRASPASOS ##########################
	$sql = "DELETE FROM traspasos WHERE codtraspaso = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1,$codtraspaso);
	$stmt->bindParam(2,$codsucursal);
	$codtraspaso = decrypt($_GET["codtraspaso"]);
	$codsucursal = decrypt($_GET["codsucursal"]);
	$stmt->execute();
	########################## ELIMINO TRASPASOS ##########################

	########################## ELIMINO DETALLES TRASPASOS ##########################
	$sql = "DELETE FROM detalletraspasos WHERE codtraspaso = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1,$codtraspaso);
	$stmt->bindParam(2,$codsucursal);
	$codtraspaso = decrypt($_GET["codtraspaso"]);
	$codsucursal = decrypt($_GET["codsucursal"]);
	$stmt->execute();
	########################## ELIMINO DETALLES TRASPASOS ##########################

		echo "1";
		exit;

	} else {

		echo "2";
		exit;
	}
}
########################## FUNCION ELIMINAR TRASPASOS ###########################

####################### FUNCION BUSQUEDA TRASPASOS POR SUCURSAL ######################
public function BuscarTraspasosxSucursal() 
{
	self::SetNames();
	$sql ="SELECT 
	traspasos.idtraspaso, 
	traspasos.codtraspaso,
	traspasos.codfactura, 
	traspasos.recibe, 
	traspasos.subtotalivasi, 
	traspasos.subtotalivano, 
	traspasos.iva, 
	traspasos.totaliva,
	traspasos.descontado, 
	traspasos.descuento, 
	traspasos.totaldescuento,
	traspasos.totalpago, 
	traspasos.totalpago2, 
	traspasos.fechatraspaso, 
	traspasos.observaciones, 
	traspasos.codigo,
	traspasos.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.id_provincia,
	sucursales.id_departamento,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	provincias.provincia,
	departamentos.departamento,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	documentos.documento,
	documentos2.documento AS documento2,
	sucursales2.documsucursal AS documsucursal2,
	sucursales2.cuitsucursal AS cuitsucursal2,
	sucursales2.nomsucursal AS nomsucursal2,
	sucursales2.id_provincia AS id_provincia2,
	sucursales2.id_departamento AS id_departamento2,
	sucursales2.direcsucursal AS direcsucursal2,
	sucursales2.correosucursal AS correosucursal2,
	sucursales2.tlfsucursal AS tlfsucursal2,
	sucursales2.documencargado AS documencargado2,
	sucursales2.dniencargado AS dniencargado2,
	sucursales2.nomencargado AS nomencargado2,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	SUM(detalletraspasos.cantidad) AS articulos 
	FROM (traspasos LEFT JOIN detalletraspasos ON detalletraspasos.codtraspaso = traspasos.codtraspaso)
	LEFT JOIN sucursales ON traspasos.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN sucursales AS sucursales2 ON traspasos.recibe = sucursales2.codsucursal
	LEFT JOIN documentos AS documentos3 ON sucursales.documsucursal = documentos3.coddocumento
	LEFT JOIN documentos AS documentos4 ON sucursales.documencargado = documentos4.coddocumento
	LEFT JOIN provincias AS provincias2 ON sucursales.id_provincia = provincias2.id_provincia
	LEFT JOIN departamentos AS departamentos2 ON sucursales.id_departamento = departamentos2.id_departamento
	WHERE traspasos.codsucursal = ? 
	GROUP BY detalletraspasos.codtraspaso";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TRASPASOS PARA LA SUCURSAL SELECCIONADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA TRASPASOS POR SUCURSAL ########################

####################### FUNCION BUSQUEDA TRASPASOS POR FECHAS #######################
public function BuscarTraspasosxFechas() 
	{
	self::SetNames();
	$sql ="SELECT 
	traspasos.idtraspaso, 
	traspasos.codtraspaso,
	traspasos.codfactura, 
	traspasos.recibe, 
	traspasos.subtotalivasi, 
	traspasos.subtotalivano, 
	traspasos.iva, 
	traspasos.totaliva,
	traspasos.descontado, 
	traspasos.descuento, 
	traspasos.totaldescuento,
	traspasos.totalpago, 
	traspasos.totalpago2, 
	traspasos.fechatraspaso, 
	traspasos.observaciones, 
	traspasos.codigo,
	traspasos.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.id_provincia,
	sucursales.id_departamento,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	provincias.provincia,
	departamentos.departamento,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	documentos.documento,
	documentos2.documento AS documento2,
	sucursales2.documsucursal AS documsucursal2,
	sucursales2.cuitsucursal AS cuitsucursal2,
	sucursales2.nomsucursal AS nomsucursal2,
	sucursales2.id_provincia AS id_provincia2,
	sucursales2.id_departamento AS id_departamento2,
	sucursales2.direcsucursal AS direcsucursal2,
	sucursales2.correosucursal AS correosucursal2,
	sucursales2.tlfsucursal AS tlfsucursal2,
	sucursales2.documencargado AS documencargado2,
	sucursales2.dniencargado AS dniencargado2,
	sucursales2.nomencargado AS nomencargado2,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	SUM(detalletraspasos.cantidad) AS articulos 
	FROM (traspasos LEFT JOIN detalletraspasos ON detalletraspasos.codtraspaso = traspasos.codtraspaso)
	LEFT JOIN sucursales ON traspasos.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN sucursales AS sucursales2 ON traspasos.recibe = sucursales2.codsucursal
	LEFT JOIN documentos AS documentos3 ON sucursales.documsucursal = documentos3.coddocumento
	LEFT JOIN documentos AS documentos4 ON sucursales.documencargado = documentos4.coddocumento
	LEFT JOIN provincias AS provincias2 ON sucursales.id_provincia = provincias2.id_provincia
	LEFT JOIN departamentos AS departamentos2 ON sucursales.id_departamento = departamentos2.id_departamento
	WHERE traspasos.codsucursal = ? 
	AND DATE_FORMAT(traspasos.fechatraspaso,'%Y-%m-%d') BETWEEN ? AND ? 
	GROUP BY detalletraspasos.codtraspaso";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TRASPASOS PARA EL RANGO DE FECHA INGRESADO</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA TRASPASOS POR FECHAS ###########################

####################### FUNCION BUSQUEDA DETALLES TRASPASOS POR FECHAS #######################
public function BuscarDetallesTraspasosxFechas() 
	{
	self::SetNames();
	$sql ="SELECT 
	detalletraspasos.idproducto,
	detalletraspasos.codproducto,
	detalletraspasos.producto,
	detalletraspasos.codmarca,
	detalletraspasos.codmodelo,
	detalletraspasos.codpresentacion,
	detalletraspasos.preciocompra,
	detalletraspasos.precioventa,  
	detalletraspasos.ivaproducto,
	detalletraspasos.descproducto,
    detalletraspasos.tipodetalle,
	productos.existencia,
	marcas.nommarca,
	modelos.nommodelo,
	traspasos.fechatraspaso,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	documentos.documento,
	documentos2.documento AS documento2,
	usuarios.dni,
	usuarios.nombres, 
	SUM(detalletraspasos.cantidad) as cantidad 
	FROM (traspasos INNER JOIN detalletraspasos ON traspasos.codtraspaso = detalletraspasos.codtraspaso)
	LEFT JOIN productos ON detalletraspasos.idproducto = productos.idproducto 
	LEFT JOIN marcas ON marcas.codmarca=productos.codmarca 
	LEFT JOIN modelos ON modelos.codmodelo=productos.codmodelo
	LEFT JOIN sucursales ON traspasos.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN usuarios ON traspasos.codigo = usuarios.codigo 
	WHERE traspasos.codsucursal = '".decrypt($_GET['codsucursal'])."'
	AND DATE_FORMAT(traspasos.fechatraspaso,'%Y-%m-%d') BETWEEN ? AND ?
	GROUP BY detalletraspasos.codproducto, detalletraspasos.precioventa, detalletraspasos.descproducto 
	ORDER BY detalletraspasos.codproducto ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	    echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA DETALLES TRASPASOS POR FECHAS ###########################

################################## CLASE TRASPASOS ###################################
























###################################### CLASE COMPRAS ###################################

############################# FUNCION REGISTRAR COMPRAS #############################
public function RegistrarCompras()
{
	self::SetNames();
	if(empty($_POST["codsucursal"]) or empty($_POST["codcompra"]) or empty($_POST["fechaemision"]) or empty($_POST["fecharecepcion"]) or empty($_POST["codproveedor"]))
	{
		echo "1";
		exit;
	}

	if (limpiar(isset($_POST['fechavencecredito']))) {  

	$fechaactual = date("Y-m-d");
	$fechavence = date("Y-m-d",strtotime($_POST['fechavencecredito']));
	
     if (strtotime($fechavence) < strtotime($fechaactual)) {
  
     echo "2";
	 exit;
  
        }
    }

	if(empty($_SESSION["CarritoCompra"]))
	{
		echo "3";
		exit;
		
	}

    $sql = "SELECT codcompra FROM compras WHERE codcompra = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST['codcompra']));
	$num = $stmt->rowCount();
	if($num == 0)
	{

    $query = "INSERT INTO compras values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codcompra);
	$stmt->bindParam(2, $codproveedor);
	$stmt->bindParam(3, $subtotalivasic);
	$stmt->bindParam(4, $subtotalivanoc);
	$stmt->bindParam(5, $ivac);
	$stmt->bindParam(6, $totalivac);
	$stmt->bindParam(7, $descontadoc);
	$stmt->bindParam(8, $descuentoc);
	$stmt->bindParam(9, $totaldescuentoc);
	$stmt->bindParam(10, $totalpagoc);
	$stmt->bindParam(11, $tipocompra);
	$stmt->bindParam(12, $formacompra);
	$stmt->bindParam(13, $fechavencecredito);
	$stmt->bindParam(14, $fechapagado);
	$stmt->bindParam(15, $statuscompra);
	$stmt->bindParam(16, $fechaemision);
	$stmt->bindParam(17, $fecharecepcion);
	$stmt->bindParam(18, $observaciones);
	$stmt->bindParam(19, $codigo);
	$stmt->bindParam(20, $codsucursal);
    
	$codcompra = limpiar($_POST["codcompra"]);
	$codproveedor = limpiar($_POST["codproveedor"]);
	$subtotalivasic = limpiar($_POST["txtsubtotal"]);
	$subtotalivanoc = limpiar($_POST["txtsubtotal2"]);
	$ivac = limpiar($_POST["iva"]);
	$totalivac = limpiar($_POST["txtIva"]);
	$descontadoc = limpiar($_POST["txtdescontado"]);
	$descuentoc = limpiar($_POST["descuento"]);
	$totaldescuentoc = limpiar($_POST["txtDescuento"]);
	$totalpagoc = limpiar($_POST["txtTotal"]);
	$tipocompra = limpiar($_POST["tipocompra"]);
	$tipocompra = limpiar($_POST["tipocompra"]);
	$formacompra = limpiar($_POST["tipocompra"]=="CONTADO" ? $_POST["formacompra"] : "CREDITO");
	$fechavencecredito = limpiar($_POST["tipocompra"]=="CREDITO" ? date("Y-m-d",strtotime($_POST['fechavencecredito'])) : "0000-00-00");
    $fechapagado = limpiar("0000-00-00");
	$statuscompra = limpiar($_POST["tipocompra"]=="CONTADO" ? "PAGADA" : "PENDIENTE");
    $fechaemision = limpiar(date("Y-m-d",strtotime($_POST['fechaemision'])));
    $fecharecepcion = limpiar(date("Y-m-d",strtotime($_POST['fecharecepcion'])));
    $observaciones = limpiar($_POST["observaciones"]);
	$codigo = limpiar($_SESSION["codigo"]);
	$codsucursal = limpiar($_POST["codsucursal"]);
	$stmt->execute();
	
	$this->dbh->beginTransaction();

	$detalle = $_SESSION["CarritoCompra"];
	for($i=0;$i<count($detalle);$i++){

    ############### VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ################
	$sql = "SELECT existencia FROM productos WHERE codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' AND codsucursal = '".limpiar($_POST['codsucursal'])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$existenciabd = $row['existencia'];

	$query = "INSERT INTO detallecompras values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codcompra);
    $stmt->bindParam(2, $codproducto);
    $stmt->bindParam(3, $producto);
	$stmt->bindParam(4, $preciocomprac);
	$stmt->bindParam(5, $precioxmenorc);
	$stmt->bindParam(6, $precioxmayorc);
	$stmt->bindParam(7, $precioxpublicoc);
	$stmt->bindParam(8, $cantcompra);
	$stmt->bindParam(9, $ivaproductoc);
	$stmt->bindParam(10, $descproductoc);
	$stmt->bindParam(11, $descfactura);
	$stmt->bindParam(12, $valortotal);
	$stmt->bindParam(13, $totaldescuentoc);
	$stmt->bindParam(14, $valorneto);
	$stmt->bindParam(15, $lotec);
	$stmt->bindParam(16, $fechaelaboracionc);
	$stmt->bindParam(17, $fechaoptimoc);
	$stmt->bindParam(18, $fechamedioc);
	$stmt->bindParam(19, $fechaminimoc);
	$stmt->bindParam(20, $stockoptimoc);
	$stmt->bindParam(21, $stockmedioc);
	$stmt->bindParam(22, $stockminimoc);
	$stmt->bindParam(23, $codsucursal);
		
	$codcompra = limpiar($_POST['codcompra']);
	$codproducto = limpiar($detalle[$i]['txtCodigo']);
	$producto = limpiar($detalle[$i]['producto']);
	$preciocomprac = limpiar($detalle[$i]['precio']);
	$precioxmenorc = limpiar($detalle[$i]['precio2']);
	$precioxmayorc = limpiar($detalle[$i]['precio3']);
	$precioxpublicoc = limpiar($detalle[$i]['precio4']);
	$cantcompra = limpiar($detalle[$i]['cantidad']);
	$ivaproductoc = limpiar($detalle[$i]['ivaproducto']);
	$descproductoc = limpiar($detalle[$i]['descproducto']);
	$descfactura = limpiar($detalle[$i]['descproductofact']);
	$descuento = $detalle[$i]["descproductofact"]/100;
	$valortotal = number_format($detalle[$i]['precio']*$detalle[$i]['cantidad'], 2, '.', '');
	$totaldescuentoc = number_format($valortotal*$descuento, 2, '.', '');
    $valorneto = number_format($valortotal-$totaldescuentoc, 2, '.', '');
	$lotec = limpiar($detalle[$i]['lote']);
	$fechaelaboracionc = limpiar($detalle[$i]['fechaelaboracion']=="" ? "0000-00-00" : date("Y-m-d",strtotime($detalle[$i]['fechaelaboracion'])));
	$fechaoptimoc = limpiar($detalle[$i]['fechaexpiracion']=="" ? "0000-00-00" : date("Y-m-d",strtotime($detalle[$i]['fechaexpiracion'])));
	$fechamedioc = limpiar($detalle[$i]['fechaexpiracion2']=="" ? "0000-00-00" : date("Y-m-d",strtotime($detalle[$i]['fechaexpiracion2'])));
	$fechaminimoc = limpiar($detalle[$i]['fechaexpiracion3']=="" ? "0000-00-00" : date("Y-m-d",strtotime($detalle[$i]['fechaexpiracion3'])));
	$stockoptimoc = limpiar($detalle[$i]['optimo']);
	$stockmedioc = limpiar($detalle[$i]['medio']);
	$stockminimoc = limpiar($detalle[$i]['minimo']);
	$codsucursal = limpiar($_POST["codsucursal"]);
	$stmt->execute();

	############# ACTUALIZAMOS LA EXISTENCIA DE PRODUCTOS COMPRADOS ###############
	$sql = "UPDATE productos set "
	      ." preciocompra = ?, "
		  ." precioxmenor = ?, "
		  ." precioxmayor = ?, "
		  ." precioxpublico = ?, "
		  ." existencia = ?, "
		  ." ivaproducto = ?, "
		  ." descproducto = ?, "
		  ." fechaelaboracion = ?, "
		  ." fechaoptimo = ?, "
		  ." fechamedio = ?, "
		  ." fechaminimo = ?, "
		  ." stockoptimo = ?, "
		  ." stockmedio = ?, "
		  ." stockminimo = ?, "
		  ." codproveedor = ?, "
		  ." lote = ? "
		  ." WHERE "
		  ." codproducto = ? AND codsucursal = ?;
		   ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $preciocompra);
	$stmt->bindParam(2, $precioxmenorc);
	$stmt->bindParam(3, $precioxmayorc);
	$stmt->bindParam(4, $precioxpublicoc);
	$stmt->bindParam(5, $existencia);
	$stmt->bindParam(6, $ivaproducto);
	$stmt->bindParam(7, $descproducto);
	$stmt->bindParam(8, $fechaelaboracion);
	$stmt->bindParam(9, $fechaoptimoc);
	$stmt->bindParam(10, $fechamedioc);
	$stmt->bindParam(11, $fechaminimoc);
	$stmt->bindParam(12, $stockoptimoc);
	$stmt->bindParam(13, $stockmedioc);
	$stmt->bindParam(14, $stockminimoc);
	$stmt->bindParam(15, $codproveedor);
	$stmt->bindParam(16, $lote);
	$stmt->bindParam(17, $codproducto);
	$stmt->bindParam(18, $codsucursal);
	
	$preciocompra = limpiar($detalle[$i]['precio']);
	$precioxmenorc = limpiar($detalle[$i]['precio2']);
	$precioxmayorc = limpiar($detalle[$i]['precio3']);
	$precioxpublicoc = limpiar($detalle[$i]['precio4']);
	$existencia = limpiar($detalle[$i]['cantidad']+$existenciabd);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$fechaelaboracionc = limpiar($detalle[$i]['fechaelaboracion']=="" ? "0000-00-00" : date("Y-m-d",strtotime($detalle[$i]['fechaelaboracion'])));
	$fechaoptimoc = limpiar($detalle[$i]['fechaexpiracion']=="" ? "0000-00-00" : date("Y-m-d",strtotime($detalle[$i]['fechaexpiracion'])));
	$fechamedioc = limpiar($detalle[$i]['fechaexpiracion2']=="" ? "0000-00-00" : date("Y-m-d",strtotime($detalle[$i]['fechaexpiracion2'])));
	$fechaminimoc = limpiar($detalle[$i]['fechaexpiracion3']=="" ? "0000-00-00" : date("Y-m-d",strtotime($detalle[$i]['fechaexpiracion3'])));
	$stockoptimoc = limpiar($detalle[$i]['optimo']);
	$stockmedioc = limpiar($detalle[$i]['medio']);
	$stockminimoc = limpiar($detalle[$i]['minimo']);
	$codproveedor = limpiar($_POST['codproveedor']);
	$lote = limpiar($detalle[$i]['lote']);
	$codproducto = limpiar($detalle[$i]['txtCodigo']);
	$codsucursal = limpiar($_POST['codsucursal']);
	$stmt->execute();

	############### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
    $query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codcompra);
	$stmt->bindParam(2, $codproveedor);
	$stmt->bindParam(3, $codproducto);
	$stmt->bindParam(4, $movimiento);
	$stmt->bindParam(5, $entradas);
	$stmt->bindParam(6, $salidas);
	$stmt->bindParam(7, $devolucion);
	$stmt->bindParam(8, $stockactual);
	$stmt->bindParam(9, $ivaproducto);
	$stmt->bindParam(10, $descproducto);
	$stmt->bindParam(11, $precio);
	$stmt->bindParam(12, $documento);
	$stmt->bindParam(13, $fechakardex);	
	$stmt->bindParam(14, $tipokardex);		
	$stmt->bindParam(15, $codsucursal);

	$codcompra = limpiar($_POST['codcompra']);
	$codproveedor = limpiar($_POST["codproveedor"]);
	$codproducto = limpiar($detalle[$i]['txtCodigo']);
	$movimiento = limpiar("ENTRADAS");
	$entradas= limpiar($detalle[$i]['cantidad']);
	$salidas = limpiar("0");
	$devolucion = limpiar("0");
	$stockactual = limpiar($detalle[$i]['cantidad']+$existenciabd);
	$precio = limpiar($detalle[$i]["precio"]);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$documento = limpiar("COMPRA: ".$_POST['codcompra']);
	$fechakardex = limpiar(date("Y-m-d"));
	$tipokardex = limpiar("1");
	$codsucursal = limpiar($_POST["codsucursal"]);
	$stmt->execute();
  }
	####################### DESTRUYO LA VARIABLE DE SESSION #####################
    unset($_SESSION["CarritoCompra"]);
    $this->dbh->commit();

		
echo "<span class='fa fa-check-square-o'></span> LA COMPRA DE PRODUCTOS HA SIDO REGISTRADA EXITOSAMENTE <a href='reportepdf?codcompra=".encrypt($codcompra)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURACOMPRA")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

echo "<script>window.open('reportepdf?codcompra=".encrypt($codcompra)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURACOMPRA")."', '_blank');</script>";
	exit;
	}
	else
	{
		echo "4";
		exit;
	}
}
############################ FUNCION REGISTRAR COMPRAS ##########################

########################## FUNCION BUSQUEDA DE COMPRAS ###############################
public function BusquedaCompras() 
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql ="SELECT 
	compras.codcompra, 
	compras.codproveedor, 
	compras.subtotalivasic, 
	compras.subtotalivanoc, 
	compras.ivac, 
	compras.totalivac, 
	compras.descontadoc,
	compras.descuentoc, 
	compras.totaldescuentoc, 
	compras.totalpagoc, 
	compras.statuscompra, 
	compras.fechavencecredito, 
	compras.fechapagado,
	compras.fecharecepcion, 
	compras.fechaemision, 
	compras.observaciones,
	compras.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	proveedores.documproveedor, 
	proveedores.documproveedor, 
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	usuarios.dni, 
	usuarios.nombres, 
	SUM(detallecompras.cantcompra) AS articulos 
	FROM (compras LEFT JOIN detallecompras ON detallecompras.codcompra = compras.codcompra) 
	LEFT JOIN sucursales ON compras.codsucursal = sucursales.codsucursal  
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	WHERE CONCAT(compras.codcompra, '',proveedores.nomproveedor, '',sucursales.cuitsucursal, '',sucursales.nomsucursal, '',sucursales.dniencargado, '',sucursales.nomencargado) LIKE '%".limpiar($_GET['bcompras'])."%'
	AND compras.statuscompra = 'PAGADA' 
	GROUP BY detallecompras.codcompra 
	ORDER BY compras.idcompra ASC LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BUSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
  } else {

  	$sql ="SELECT 
	compras.codcompra, 
	compras.codproveedor, 
	compras.subtotalivasic, 
	compras.subtotalivanoc, 
	compras.ivac, 
	compras.totalivac, 
	compras.descontadoc,
	compras.descuentoc, 
	compras.totaldescuentoc, 
	compras.totalpagoc, 
	compras.statuscompra, 
	compras.fechavencecredito, 
	compras.fechapagado,
	compras.fecharecepcion, 
	compras.fechaemision, 
	compras.observaciones,
	compras.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	proveedores.documproveedor, 
	proveedores.documproveedor, 
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	usuarios.dni, 
	usuarios.nombres, 
	SUM(detallecompras.cantcompra) AS articulos 
	FROM (compras LEFT JOIN detallecompras ON detallecompras.codcompra = compras.codcompra) 
	LEFT JOIN sucursales ON compras.codsucursal = sucursales.codsucursal  
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	WHERE CONCAT(compras.codcompra, ' ',proveedores.nomproveedor, ' ',sucursales.cuitsucursal, ' ',sucursales.nomsucursal, ' ',sucursales.dniencargado, ' ',sucursales.nomencargado) LIKE '%".limpiar($_GET['bcompras'])."%'
	AND compras.codsucursal = '".limpiar($_SESSION["codsucursal"])."'
	AND compras.statuscompra = 'PAGADA' 
	GROUP BY detallecompras.codcompra 
	ORDER BY compras.idcompra ASC LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BUSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	    }
    }
}
########################## FUNCION BUSQUEDA DE COMPRAS ###############################

######################### FUNCION LISTAR COMPRAS ################################
public function ListarCompras()
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT 
	compras.codcompra, 
	compras.codproveedor, 
	compras.subtotalivasic, 
	compras.subtotalivanoc, 
	compras.ivac, 
	compras.totalivac, 
	compras.descontadoc,
	compras.descuentoc, 
	compras.totaldescuentoc, 
	compras.totalpagoc, 
	compras.statuscompra, 
	compras.fechavencecredito, 
	compras.fechapagado,
	compras.fecharecepcion, 
	compras.fechaemision, 
	compras.observaciones,
	compras.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	proveedores.documproveedor, 
	proveedores.documproveedor, 
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	usuarios.dni, 
	usuarios.nombres, 
	SUM(detallecompras.cantcompra) AS articulos 
	FROM (compras LEFT JOIN detallecompras ON detallecompras.codcompra = compras.codcompra) 
	LEFT JOIN sucursales ON compras.codsucursal = sucursales.codsucursal  
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2  
	WHERE compras.statuscompra = 'PAGADA' 
	GROUP BY detallecompras.codcompra 
	ORDER BY compras.idcompra ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

     } else {

   $sql = "SELECT 
	compras.codcompra, 
	compras.codproveedor, 
	compras.subtotalivasic, 
	compras.subtotalivanoc, 
	compras.ivac, 
	compras.totalivac, 
	compras.descontadoc,
	compras.descuentoc, 
	compras.totaldescuentoc, 
	compras.totalpagoc, 
	compras.statuscompra, 
	compras.fechavencecredito, 
	compras.fechapagado,
	compras.fecharecepcion, 
	compras.fechaemision, 
	compras.observaciones,
	compras.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	proveedores.documproveedor, 
	proveedores.documproveedor, 
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	usuarios.dni, 
	usuarios.nombres, 
	SUM(detallecompras.cantcompra) AS articulos 
	FROM (compras LEFT JOIN detallecompras ON detallecompras.codcompra = compras.codcompra) 
	LEFT JOIN sucursales ON compras.codsucursal = sucursales.codsucursal  
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo 
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	WHERE compras.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
	AND compras.statuscompra = 'PAGADA' 
	GROUP BY detallecompras.codcompra 
	ORDER BY compras.idcompra ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

     }
}
################################## FUNCION LISTAR COMPRAS ############################

########################## FUNCION BUSQUEDA DE CUENTAS POR PAGAR ###############################
public function BusquedaCuentasxPagar() 
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql ="SELECT 
	compras.codcompra, 
	compras.codproveedor, 
	compras.subtotalivasic, 
	compras.subtotalivanoc, 
	compras.ivac, 
	compras.totalivac, 
	compras.descontadoc,
	compras.descuentoc, 
	compras.totaldescuentoc, 
	compras.totalpagoc, 
	compras.statuscompra, 
	compras.fechavencecredito, 
	compras.fechapagado,
	compras.fecharecepcion, 
	compras.fechaemision, 
	compras.observaciones,
	compras.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	proveedores.documproveedor, 
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	usuarios.dni, 
	usuarios.nombres, 
	SUM(abonoscreditoscompras.montoabono) AS abonototal 
	FROM (compras LEFT JOIN abonoscreditoscompras ON compras.codcompra = abonoscreditoscompras.codcompra)
	LEFT JOIN sucursales ON compras.codsucursal = sucursales.codsucursal  
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	WHERE CONCAT(compras.codcompra, ' ',proveedores.nomproveedor, ' ',sucursales.cuitsucursal, ' ',sucursales.nomsucursal, ' ',sucursales.dniencargado, ' ',sucursales.nomencargado) LIKE '%".limpiar($_GET['bcompras'])."%'
	AND compras.statuscompra = 'PENDIENTE' 
	GROUP BY compras.codcompra 
	ORDER BY compras.idcompra ASC LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BUSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
  } 
  else {

  	$sql ="SELECT 
	compras.codcompra, 
	compras.codproveedor, 
	compras.subtotalivasic, 
	compras.subtotalivanoc, 
	compras.ivac, 
	compras.totalivac, 
	compras.descontadoc,
	compras.descuentoc, 
	compras.totaldescuentoc, 
	compras.totalpagoc, 
	compras.statuscompra, 
	compras.fechavencecredito, 
	compras.fechapagado,
	compras.fecharecepcion, 
	compras.fechaemision, 
	compras.observaciones,
	compras.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	proveedores.documproveedor, 
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	usuarios.dni, 
	usuarios.nombres, 
	SUM(abonoscreditoscompras.montoabono) AS abonototal 
	FROM (compras LEFT JOIN abonoscreditoscompras ON compras.codcompra = abonoscreditoscompras.codcompra)
	LEFT JOIN sucursales ON compras.codsucursal = sucursales.codsucursal  
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	WHERE CONCAT(compras.codcompra, ' ',proveedores.nomproveedor, ' ',sucursales.cuitsucursal, ' ',sucursales.nomsucursal, ' ',sucursales.dniencargado, ' ',sucursales.nomencargado) LIKE '%".limpiar($_GET['bcompras'])."%'
	AND compras.codsucursal = '".limpiar($_SESSION["codsucursal"])."'
	AND compras.statuscompra = 'PENDIENTE' 
	GROUP BY compras.codcompra 
	ORDER BY compras.idcompra ASC LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BUSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	    }
    }
}
########################## FUNCION BUSQUEDA DE CUENTAS POR PAGAR ###############################

########################### FUNCION LISTAR CUENTAS POR PAGAR #######################
public function ListarCuentasxPagar()
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT 
	compras.codcompra, 
	compras.codproveedor, 
	compras.subtotalivasic, 
	compras.subtotalivanoc, 
	compras.ivac, 
	compras.totalivac, 
	compras.descontadoc,
	compras.descuentoc, 
	compras.totaldescuentoc, 
	compras.totalpagoc, 
	compras.statuscompra, 
	compras.fechavencecredito, 
	compras.fechapagado,
	compras.fecharecepcion, 
	compras.fechaemision, 
	compras.observaciones,
	compras.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	proveedores.documproveedor, 
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	usuarios.dni, 
	usuarios.nombres, 
	SUM(abonoscreditoscompras.montoabono) AS abonototal 
	FROM (compras LEFT JOIN abonoscreditoscompras ON compras.codcompra = abonoscreditoscompras.codcompra)
	LEFT JOIN sucursales ON compras.codsucursal = sucursales.codsucursal  
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo 
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	WHERE compras.statuscompra = 'PENDIENTE' 
	GROUP BY compras.codcompra 
	ORDER BY compras.idcompra ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

     } else {

   $sql = "SELECT 
	compras.codcompra, 
	compras.codproveedor, 
	compras.subtotalivasic, 
	compras.subtotalivanoc, 
	compras.ivac, 
	compras.totalivac, 
	compras.descontadoc,
	compras.descuentoc, 
	compras.totaldescuentoc, 
	compras.totalpagoc, 
	compras.statuscompra, 
	compras.fechavencecredito, 
	compras.fechapagado,
	compras.fecharecepcion, 
	compras.fechaemision, 
	compras.observaciones,
	compras.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	proveedores.documproveedor, 
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	usuarios.dni, 
	usuarios.nombres, 
	SUM(abonoscreditoscompras.montoabono) AS abonototal 
	FROM (compras LEFT JOIN abonoscreditoscompras ON compras.codcompra = abonoscreditoscompras.codcompra)
	LEFT JOIN sucursales ON compras.codsucursal = sucursales.codsucursal  
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo 
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	WHERE compras.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
	AND compras.statuscompra = 'PENDIENTE' 
	GROUP BY compras.codcompra 
	ORDER BY compras.idcompra ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

     }
}
######################### FUNCION LISTAR CUENTAS POR PAGAR ############################

############################ FUNCION PARA PAGAR COMPRAS ############################
public function RegistrarPagoCompra()
{
	self::SetNames();

	if(empty($_POST["codproveedor"]) or empty($_POST["codcompra"]) or empty($_POST["montoabono"]))
	{
		echo "1";
		exit;
	} 
	else if($_POST["montoabono"] > $_POST["totaldebe"])
	{
		echo "2";
		exit;

	} else {

	$query = "INSERT INTO abonoscreditoscompras values (null, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codcompra);
	$stmt->bindParam(2, $codproveedor);
	$stmt->bindParam(3, $montoabono);
	$stmt->bindParam(4, $fechaabono);
	$stmt->bindParam(5, $codsucursal);

	$codcompra = limpiar($_POST["codcompra"]);
	$codproveedor = limpiar(decrypt($_POST["codproveedor"]));
	$montoabono = limpiar($_POST["montoabono"]);
	$fechaabono = limpiar(date("Y-m-d H:i:s"));
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();

    ############## ACTUALIZAMOS EL STATUS DE LA FACTURA ##################
	if($_POST["montoabono"] == $_POST["totaldebe"]) {

		$sql = "UPDATE compras set "
		." statuscompra = ?, "
		." fechapagado = ? "
		." WHERE "
		." codcompra = ? and codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $statuscompra);
		$stmt->bindParam(2, $fechapagado);
		$stmt->bindParam(3, $codcompra);
		$stmt->bindParam(4, $codsucursal);

		$statuscompra = limpiar("PAGADA");
		$fechapagado = limpiar(date("Y-m-d"));
		$codcompra = limpiar($_POST["codcompra"]);
		$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
		$stmt->execute();
	}
    ############## ACTUALIZAMOS EL STATUS DE LA FACTURA ##################

    echo "<span class='fa fa-check-square-o'></span> EL ABONO AL CR&Eacute;DITO DE COMPRA HA SIDO REGISTRADO EXITOSAMENTE</div>";
	exit;
   }
}
########################## FUNCION PARA PAGAR COMPRAS ###############################

########################### FUNCION VER DETALLES COMPRAS #######################
public function VerDetallesAbonosCompras()
{
	self::SetNames();
	$sql = "SELECT * FROM abonoscreditoscompras 
	INNER JOIN compras ON abonoscreditoscompras.codcompra = compras.codcompra  
	WHERE abonoscreditoscompras.codcompra = ? 
	AND abonoscreditoscompras.codsucursal = ?";	
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET["codcompra"])));
	$stmt->bindValue(2, trim(decrypt($_GET["codsucursal"])));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################## FUNCION VER DETALLES COMPRAS ###########################

############################ FUNCION ID COMPRAS #################################
public function ComprasPorId()
{
	self::SetNames();
	$sql = " SELECT 
	compras.idcompra, 
	compras.codcompra,
	compras.codproveedor, 
	compras.subtotalivasic,
	compras.subtotalivanoc, 
	compras.ivac,
	compras.totalivac,
    compras.descontadoc, 
	compras.descuentoc,
	compras.totaldescuentoc, 
	compras.totalpagoc, 
	compras.tipocompra,
	compras.formacompra,
	compras.fechavencecredito,
    compras.fechapagado,
	compras.statuscompra,
	compras.fechaemision,
	compras.fecharecepcion,
    compras.observaciones,
	compras.codigo,
	compras.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.tlfsucursal,
	sucursales.correosucursal,
	sucursales.id_provincia,
	sucursales.id_departamento,
	sucursales.direcsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	proveedores.documproveedor,
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	proveedores.tlfproveedor, 
	proveedores.id_provincia AS id_provincia2, 
	proveedores.id_departamento AS id_departamento2, 
	proveedores.direcproveedor, 
	proveedores.emailproveedor,
	proveedores.vendedor,
	proveedores.tlfvendedor,
    documentos.documento,
    documentos2.documento AS documento2, 
    documentos3.documento AS documento3, 
	mediospagos.mediopago,
	usuarios.dni, 
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
    SUM(abonoscreditoscompras.montoabono) AS abonototal 
    FROM (compras LEFT JOIN abonoscreditoscompras ON compras.codcompra = abonoscreditoscompras.codcompra)
	INNER JOIN sucursales ON compras.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON proveedores.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON proveedores.id_departamento = departamentos2.id_departamento 
	LEFT JOIN mediospagos ON compras.formacompra = mediospagos.codmediopago
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	WHERE compras.codcompra = ? AND compras.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcompra"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID COMPRAS #################################
	
############################ FUNCION VER DETALLES COMPRAS ############################
public function VerDetallesCompras()
{
	self::SetNames();
	$sql = "SELECT
	detallecompras.coddetallecompra,
	detallecompras.codcompra,
	detallecompras.codproducto,
	detallecompras.preciocomprac,
	detallecompras.precioxmenorc,
	detallecompras.precioxmayorc,
	detallecompras.precioxpublicoc,
	detallecompras.cantcompra,
	detallecompras.ivaproductoc,
	detallecompras.descproductoc,
	detallecompras.descfactura,
	detallecompras.valortotal, 
	detallecompras.totaldescuentoc,
	detallecompras.valorneto,
	detallecompras.lotec,
	detallecompras.fechaelaboracionc,
	detallecompras.fechaoptimoc,
	detallecompras.fechamedioc,
	detallecompras.fechaminimoc,
	detallecompras.stockoptimoc,
	detallecompras.stockmedioc,
	detallecompras.stockminimoc,
	detallecompras.codsucursal,
	marcas.nommarca,
	modelos.nommodelo
	FROM detallecompras 
	INNER JOIN marcas ON detallecompras.codmarca = marcas.codmarca
	LEFT JOIN modelos ON detallecompras.codmodelo = modelos.codmodelo 
	WHERE detallecompras.codcompra = ? 
	AND detallecompras.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcompra"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$this->p[]=$row;
	}
	return $this->p;
	$this->dbh=null;
}
############################ FUNCION VER DETALLES COMPRAS ##############################

############################## FUNCION ACTUALIZAR COMPRAS #############################
public function ActualizarCompras()
{
	self::SetNames();
	if(empty($_POST["codsucursal"]) or empty($_POST["codcompra"]) or empty($_POST["fechaemision"]) or empty($_POST["fecharecepcion"]) or empty($_POST["codproveedor"]))
	{
		echo "1";
		exit;
	}

	if (limpiar(isset($_POST['fechavencecredito']))) {  

	$fechaactual = date("Y-m-d");
	$fechavence = date("Y-m-d",strtotime($_POST['fechavencecredito']));
	
     if (strtotime($fechavence) < strtotime($fechaactual)) {
  
     echo "2";
	 exit;
  
         }
    }

	for($i=0;$i<count($_POST['coddetallecompra']);$i++){  //recorro el array
        if (!empty($_POST['coddetallecompra'][$i])) {

	       if($_POST['cantcompra'][$i]==0){

		      echo "3";
		      exit();

	        }
        }
    }

    $this->dbh->beginTransaction();

    for($i=0;$i<count($_POST['coddetallecompra']);$i++){  //recorro el array
         if (!empty($_POST['coddetallecompra'][$i])) {

    $sql = "SELECT cantcompra FROM detallecompras WHERE coddetallecompra = '".limpiar($_POST['coddetallecompra'][$i])."' AND codcompra = '".limpiar($_POST["codcompra"])."' AND codsucursal = '".limpiar($_POST["codsucursal"])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	
	$cantidadbd = $row['cantcompra'];

	if($cantidadbd != $_POST['cantcompra'][$i]){

		$sql = "SELECT existencia FROM productos WHERE codproducto = '".limpiar($_POST['codproducto'][$i])."' AND codsucursal = '".limpiar($_POST["codsucursal"])."'";
	    foreach ($this->dbh->query($sql) as $row)
	    {
		$this->p[] = $row;
	    }
	    $existenciabd = $row['existencia'];
	    $cantcompra = $_POST["cantcompra"][$i];
	    $cantidadcomprabd = $_POST["cantidadcomprabd"][$i];
	    $totalcompra = $cantcompra-$cantidadcomprabd;

		$query = "UPDATE detallecompras set"
		." cantcompra = ?, "
		." valortotal = ?, "
		." totaldescuentoc = ?, "
		." valorneto = ? "
		." WHERE "
		." coddetallecompra = ? AND codcompra = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $cantcompra);
		$stmt->bindParam(2, $valortotal);
		$stmt->bindParam(3, $totaldescuento);
		$stmt->bindParam(4, $valorneto);
		$stmt->bindParam(5, $coddetallecompra);
		$stmt->bindParam(6, $codcompra);
		$stmt->bindParam(7, $codsucursal);

		$cantcompra = limpiar($_POST['cantcompra'][$i]);
		$preciocompra = limpiar($_POST['preciocompra'][$i]);
		$ivaproducto = limpiar($_POST['ivaproducto'][$i]);
		$descuento = $_POST['descfactura'][$i]/100;
		$valortotal = number_format($_POST['valortotal'][$i], 2, '.', '');
		$totaldescuento = number_format($_POST['totaldescuentoc'][$i], 2, '.', '');
		$valorneto = number_format($_POST['valorneto'][$i], 2, '.', '');
		$coddetallecompra = limpiar($_POST['coddetallecompra'][$i]);
		$codcompra = limpiar($_POST["codcompra"]);
		$codsucursal = limpiar($_POST["codsucursal"]);
		$stmt->execute();

	############ ACTUALIZAMOS EXISTENCIA DEL PRODUCTO EN ALMACEN ################
	$sql2 = " UPDATE productos set "
		  ." existencia = ? "
		  ." WHERE "
		  ." codproducto = '".limpiar($_POST["codproducto"][$i])."' AND codsucursal = '".limpiar($_POST["codsucursal"])."';
		  ";
		  $stmt = $this->dbh->prepare($sql2);
		  $stmt->bindParam(1, $existencia);
		  $existencia = $existenciabd+$totalcompra;
		  $stmt->execute();
	############ ACTUALIZAMOS EXISTENCIA DEL PRODUCTO EN ALMACEN ################

	############## ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX ###################
	$sql3 = " UPDATE kardex set "
	      ." entradas = ?, "
	      ." stockactual = ? "
		  ." WHERE "
		  ." codproceso = '".limpiar($_POST["codcompra"])."' and codproducto = '".limpiar($_POST["codproducto"][$i])."'AND codsucursal = '".limpiar($_POST["codsucursal"])."';
		   ";
	$stmt = $this->dbh->prepare($sql3);
	$stmt->bindParam(1, $entradas);
	$stmt->bindParam(2, $existencia);
	
	$entradas = limpiar($_POST["cantcompra"][$i]);
	$stmt->execute();
	############## ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX ###################

		} else {

           echo "";

	       }
        }
    }

    $this->dbh->commit();

        ############ ACTUALIZO LOS TOTALES EN LA COMPRA ##############
		$sql = " UPDATE compras SET "
		." codproveedor = ?, "
		." subtotalivasic = ?, "
		." subtotalivanoc = ?, "
		." totalivac = ?, "
		." descontadoc = ?, "
		." descuentoc = ?, "
		." totaldescuentoc = ?, "
		." totalpagoc = ?, "
		." tipocompra = ?, "
		." formacompra = ?, "
		." fechavencecredito = ?, "
		." fechaemision = ?, "
		." fecharecepcion = ? "
		." WHERE "
		." codcompra = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $codproveedor);
		$stmt->bindParam(2, $subtotalivasic);
		$stmt->bindParam(3, $subtotalivanoc);
		$stmt->bindParam(4, $totalivac);
		$stmt->bindParam(5, $descontadoc);
		$stmt->bindParam(6, $descuentoc);
		$stmt->bindParam(7, $totaldescuentoc);
		$stmt->bindParam(8, $totalpagoc);
		$stmt->bindParam(9, $tipocompra);
		$stmt->bindParam(10, $formacompra);
		$stmt->bindParam(11, $fechavencecredito);
		$stmt->bindParam(12, $fechaemision);
		$stmt->bindParam(13, $fecharecepcion);
		$stmt->bindParam(14, $codcompra);
		$stmt->bindParam(15, $codsucursal);

		$codproveedor = limpiar($_POST["codproveedor"]);
		$subtotalivasi = number_format($_POST["txtsubtotal"], 2, '.', '');
		$subtotalivano = number_format($_POST["txtsubtotal2"], 2, '.', '');
		$totaliva = number_format($_POST["txtIva"], 2, '.', '');
		$descontado = number_format($_POST["txtdescontado"], 2, '.', '');
		$descuento = limpiar($_POST["descuento"]);
		$totaldescuento = number_format($_POST["txtDescuento"], 2, '.', '');
		$totalpago = number_format($_POST["txtTotal"], 2, '.', '');
		$tipocompra = limpiar($_POST["tipocompra"]);
		$formacompra = limpiar($_POST["tipocompra"]=="CONTADO" ? $_POST["formacompra"] : "CREDITO");
		$fechavencecredito = limpiar($_POST["tipocompra"]=="CREDITO" ? date("Y-m-d",strtotime($_POST['fechavencecredito'])) : "0000-00-00");
		$statuscompra = limpiar($_POST["tipocompra"]=="CONTADO" ? "PAGADA" : "PENDIENTE");
		$fechaemision = limpiar(date("Y-m-d",strtotime($_POST['fechaemision'])));
		$fecharecepcion = limpiar(date("Y-m-d",strtotime($_POST['fecharecepcion'])));
		$codcompra = limpiar($_POST["codcompra"]);
		$codsucursal = limpiar($_POST["codsucursal"]);
		$stmt->execute();
		############ ACTUALIZO LOS TOTALES EN LA COMPRA ##############

echo "<span class='fa fa-check-square-o'></span> LA COMPRA DE PRODUCTOS HA SIDO ACTUALIZADA EXITOSAMENTE <a href='reportepdf?codcompra=".encrypt($codcompra)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURACOMPRA")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

echo "<script>window.open('reportepdf?codcompra=".encrypt($codcompra)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURACOMPRA")."', '_blank');</script>";
	exit;
}
############################# FUNCION ACTUALIZAR COMPRAS #########################

########################## FUNCION ELIMINAR DETALLES COMPRAS ########################
public function EliminarDetallesCompras()
	{
    self::SetNames();
	if ($_SESSION["acceso"]=="administradorS") {

	$sql = "SELECT * FROM detallecompras WHERE codcompra = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcompra"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num > 1)
	{

		$sql = "SELECT codproducto, cantcompra, preciocomprac, ivaproductoc, descproductoc FROM detallecompras WHERE coddetallecompra = ? and codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["coddetallecompra"]),decrypt($_GET["codsucursal"])));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$codproducto = $row['codproducto'];
		$cantidaddb = $row['cantcompra'];
		$preciocompradb = $row['preciocomprac'];
		$ivaproductodb = $row['ivaproductoc'];
		$descproductodb = $row['descproductoc'];

		$sql2 = "SELECT existencia FROM productos WHERE codproducto = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute(array($codproducto,decrypt($_GET["codsucursal"])));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$existenciabd = $row['existencia'];

		############# ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############
		$sql = "UPDATE productos SET "
		." existencia = ? "
		." WHERE "
		." codproducto = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$stmt->bindParam(2, $codproducto);
		$stmt->bindParam(3, $codsucursal);

		$existencia = limpiar($existenciabd-$cantidaddb);
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute();
		############# ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############

	    ########## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ##########
		$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcompra);
		$stmt->bindParam(2, $codproveedor);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);	
		$stmt->bindParam(14, $tipokardex);		
		$stmt->bindParam(15, $codsucursal);

		$codcompra = limpiar(decrypt($_GET["codcompra"]));
	    $codproveedor = limpiar(decrypt($_GET["codproveedor"]));
		$movimiento = limpiar("DEVOLUCION");
		$entradas= limpiar("0");
		$salidas = limpiar("0");
		$devolucion = limpiar($cantidaddb);
		$stockactual = limpiar($existenciabd-$cantidaddb);
		$precio = limpiar($preciocompradb);
		$ivaproducto = limpiar($ivaproductodb);
		$descproducto = limpiar($descproductodb);
		$documento = limpiar("DEVOLUCION COMPRA: ".decrypt($_GET["codcompra"]));
		$fechakardex = limpiar(date("Y-m-d"));
		$tipokardex = limpiar("1");
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute();

		########## ELIMINAMOS EL PRODUCTO EN DETALLES DE COMPRAS ###########
		$sql = "DELETE FROM detallecompras WHERE coddetallecompra = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$coddetallecompra);
		$stmt->bindParam(2,$codsucursal);
		$coddetallecompra = decrypt($_GET["coddetallecompra"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();
		########## ELIMINAMOS EL PRODUCTO EN DETALLES DE COMPRAS ###########

	    ############ CONSULTO LOS TOTALES DE COMPRAS ##############
	    $sql2 = "SELECT ivac, descuentoc FROM compras WHERE codcompra = ? AND codsucursal = ?";
	    $stmt = $this->dbh->prepare($sql2);
	    $stmt->execute(array(decrypt($_GET["codcompra"]),decrypt($_GET["codsucursal"])));
	    $num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$paea[] = $row;
		}
		$iva = $paea[0]["ivac"]/100;
	    $descuento = $paea[0]["descuentoc"]/100;
	    ############ CONSULTO LOS TOTALES DE COMPRAS ##############

        ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############
		$sql3 = "SELECT SUM(totaldescuentoc) AS totaldescuentosi, SUM(valorneto) AS valorneto FROM detallecompras WHERE codcompra = '".limpiar(decrypt($_GET["codcompra"]))."' AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."' AND ivaproductoc = 'SI'";
		foreach ($this->dbh->query($sql3) as $row3)
		{
			$this->p[] = $row3;
		}
		$subtotaldescuentosi = ($row3['totaldescuentosi']== "" ? "0.00" : $row3['totaldescuentosi']);
		$subtotalivasic = ($row3['valorneto']== "" ? "0.00" : $row3['valorneto']);
		############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############

	    ############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############
		$sql4 = "SELECT SUM(totaldescuentoc) AS totaldescuentono, SUM(valorneto) AS valorneto FROM detallecompras WHERE codcompra = '".limpiar(decrypt($_GET["codcompra"]))."' AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."' AND ivaproductoc = 'NO'";
		foreach ($this->dbh->query($sql4) as $row4)
		{
			$this->p[] = $row4;
		}
		$subtotaldescuentono = ($row4['totaldescuentono']== "" ? "0.00" : $row4['totaldescuentono']);
		$subtotalivanoc = ($row4['valorneto']== "" ? "0.00" : $row4['valorneto']);
		############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############

        ############ ACTUALIZO LOS TOTALES EN LA COMPRAS ##############
		$sql = " UPDATE compras SET "
		." subtotalivasic = ?, "
		." subtotalivanoc = ?, "
		." totalivac = ?, "
		." descontadoc = ?, "
		." totaldescuentoc = ?, "
		." totalpagoc = ? "
		." WHERE "
		." codcompra = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $subtotalivasic);
		$stmt->bindParam(2, $subtotalivanoc);
		$stmt->bindParam(3, $totalivac);
		$stmt->bindParam(4, $descontadoc);
		$stmt->bindParam(5, $totaldescuentoc);
		$stmt->bindParam(6, $totalpagoc);
		$stmt->bindParam(7, $codcompra);
		$stmt->bindParam(8, $codsucursal);

		$totalivac= number_format($subtotalivasic*$iva, 2, '.', '');
		$descontadoc = number_format($subtotaldescuentosi+$subtotaldescuentono, 2, '.', '');
	    $total= number_format($subtotalivasic+$subtotalivanoc+$totalivac, 2, '.', '');
	    $totaldescuentoc = number_format($total*$descuento, 2, '.', '');
	    $totalpagoc = number_format($total-$totaldescuentoc, 2, '.', '');
		$codcompra = limpiar(decrypt($_GET["codcompra"]));
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute();
		############ ACTUALIZO LOS TOTALES EN LA COMPRAS ##############

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
			
	} else {
		
		echo "3";
		exit;
	}	
}
###################### FUNCION ELIMINAR DETALLES COMPRAS #######################

####################### FUNCION ELIMINAR COMPRAS #################################
public function EliminarCompras()
{
	self::SetNames();
	if ($_SESSION["acceso"]=="administradorS") {

	$sql = "SELECT * FROM detallecompras WHERE codcompra = '".limpiar(decrypt($_GET["codcompra"]))."' 
	AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."'";

	$array=array();

	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;

		$codproducto = $row['codproducto'];
		$cantidaddb = $row['cantcompra'];
		$preciocompradb = $row['preciocomprac'];
		$ivaproductodb = $row['ivaproductoc'];
		$descproductodb = $row['descproductoc'];

		$sql2 = "SELECT existencia FROM productos WHERE codproducto = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute( array($codproducto,decrypt($_GET["codsucursal"])));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$existenciabd = $row['existencia'];

		########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############
		$sql = "UPDATE productos SET "
		." existencia = ? "
		." WHERE "
		." codproducto = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$stmt->bindParam(2, $codproducto);
		$stmt->bindParam(3, $codsucursal);

		$existencia = limpiar($existenciabd-$cantidaddb);
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute();
		########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############

	    ########## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ##########
		$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcompra);
		$stmt->bindParam(2, $codproveedor);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);
		$stmt->bindParam(14, $tipokardex);		
		$stmt->bindParam(15, $codsucursal);

		$codcompra = limpiar(decrypt($_GET["codcompra"]));
	    $codproveedor = limpiar(decrypt($_GET["codproveedor"]));
		$movimiento = limpiar("DEVOLUCION");
		$entradas= limpiar("0");
		$salidas = limpiar("0");
		$devolucion = limpiar($cantidaddb);
		$stockactual = limpiar($existenciabd-$cantidaddb);
		$precio = limpiar($preciocompradb);
		$ivaproducto = limpiar($ivaproductodb);
		$descproducto = limpiar($descproductodb);
		$documento = limpiar("DEVOLUCION COMPRA: ".decrypt($_GET["codcompra"]));
		$fechakardex = limpiar(date("Y-m-d"));
		$tipokardex = limpiar("1");
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute();
	}


		$sql = "DELETE FROM compras WHERE codcompra = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codcompra);
		$stmt->bindParam(2,$codsucursal);
		$codcompra = decrypt($_GET["codcompra"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();

		$sql = "DELETE FROM detallecompras WHERE codcompra = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codcompra);
		$stmt->bindParam(2,$codsucursal);
		$codcompra = decrypt($_GET["codcompra"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();

		echo "1";
		exit;

	} else {

		echo "2";
		exit;
	}
}
######################### FUNCION ELIMINAR COMPRAS #################################

##################### FUNCION BUSQUEDA COMPRAS POR PROVEEDORES ###################
public function BuscarComprasxProveedor() 
{
	self::SetNames();
	$sql = "SELECT 
	compras.codcompra,
	compras.codproveedor, 
	compras.subtotalivasic,
	compras.subtotalivanoc, 
	compras.ivac,
	compras.totalivac,
	compras.descontadoc, 
	compras.descuentoc,
	compras.totaldescuentoc, 
	compras.totalpagoc, 
	compras.tipocompra,
	compras.formacompra,
	compras.fechavencecredito,
    compras.fechapagado,
	compras.statuscompra,
	compras.fechaemision,
	compras.fecharecepcion,
    compras.observaciones,
	compras.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.tlfsucursal,
	sucursales.correosucursal,
	sucursales.id_provincia,
	sucursales.id_departamento,
	sucursales.direcsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	proveedores.documproveedor,
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	proveedores.tlfproveedor, 
	proveedores.id_provincia AS id_provincia2, 
	proveedores.id_departamento AS id_departamento2, 
	proveedores.direcproveedor, 
	proveedores.emailproveedor,
	proveedores.vendedor,
	proveedores.tlfvendedor,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	usuarios.dni, 
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2, 
	SUM(detallecompras.cantcompra) as articulos 
	FROM (compras LEFT JOIN detallecompras ON compras.codcompra=detallecompras.codcompra) 
	INNER JOIN sucursales ON compras.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON proveedores.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON proveedores.id_departamento = departamentos2.id_departamento 
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	WHERE compras.codsucursal = ? 
	AND compras.codproveedor = ?
	 GROUP BY detallecompras.codcompra";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codsucursal"]),decrypt($_GET["codproveedor"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COMPRAS DE PRODUCTOS PARA EL PROVEEDOR SELECCIONADO</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
################### FUNCION BUSQUEDA COMPRAS POR PROVEEDORES ###################

###################### FUNCION BUSQUEDA COMPRAS POR FECHAS ###########################
public function BuscarComprasxFechas() 
{
	self::SetNames();
	$sql ="SELECT 
	compras.codcompra,
	compras.codproveedor, 
	compras.subtotalivasic,
	compras.subtotalivanoc, 
	compras.ivac,
	compras.totalivac,
	compras.descontadoc, 
	compras.descuentoc,
	compras.totaldescuentoc, 
	compras.totalpagoc, 
	compras.tipocompra,
	compras.formacompra,
	compras.fechavencecredito,
    compras.fechapagado,
	compras.statuscompra,
	compras.fechaemision,
	compras.fecharecepcion,
    compras.observaciones,
	compras.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.tlfsucursal,
	sucursales.correosucursal,
	sucursales.id_provincia,
	sucursales.id_departamento,
	sucursales.direcsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	proveedores.documproveedor,
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	proveedores.tlfproveedor, 
	proveedores.id_provincia AS id_provincia2, 
	proveedores.id_departamento AS id_departamento2, 
	proveedores.direcproveedor, 
	proveedores.emailproveedor,
	proveedores.vendedor,
	proveedores.tlfvendedor,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	usuarios.dni, 
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2, 
	SUM(detallecompras.cantcompra) as articulos 
	FROM (compras LEFT JOIN detallecompras ON compras.codcompra=detallecompras.codcompra) 
	INNER JOIN sucursales ON compras.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON proveedores.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON proveedores.id_departamento = departamentos2.id_departamento 
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	WHERE compras.codsucursal = ? 
	AND DATE_FORMAT(compras.fecharecepcion,'%Y-%m-%d') BETWEEN ? AND ?
	GROUP BY detallecompras.codcompra";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COMPRAS DE PRODUCTO PARA EL RANGO DE FECHA INGRESADO</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA COMPRAS POR FECHAS ###########################

###################### FUNCION BUSQUEDA CREDITOS POR PROVEEDOR ###########################
public function BuscarCreditosxProveedor() 
{
	self::SetNames();
	$sql = "SELECT 
	compras.codcompra, 
	compras.totalpagoc, 
	compras.tipocompra,
	compras.statuscompra,
	compras.fechaemision, 
	compras.fechavencecredito,
	compras.fechapagado,
	compras.codsucursal, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.correosucursal,
	sucursales.llevacontabilidad,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	proveedores.codproveedor,
	proveedores.documproveedor, 
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	proveedores.tlfproveedor, 
	abonoscreditoscompras.codcompra as codigo, 
	abonoscreditoscompras.fechaabono, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	SUM(abonoscreditoscompras.montoabono) AS abonototal  
	FROM (compras INNER JOIN proveedores ON compras.codproveedor = proveedores.codproveedor)
	LEFT JOIN abonoscreditoscompras ON compras.codcompra = abonoscreditoscompras.codcompra
	LEFT JOIN sucursales ON compras.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	WHERE compras.codsucursal = ? 
	AND compras.codproveedor = ? 
	AND compras.tipocompra ='CREDITO' 
	GROUP BY compras.codcompra";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim(decrypt($_GET['codproveedor'])));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CREDITOS PARA EL PROVEEDOR INGRESADO</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA CREDITOS POR PROVEEDOR ###########################

###################### FUNCION BUSQUEDA CREDITOS DE COMPRAS POR FECHAS ###########################
public function BuscarCreditosComprasxFechas() 
{
	self::SetNames();
	$sql = "SELECT 
	compras.codcompra, 
	compras.totalpagoc, 
	compras.tipocompra,
	compras.statuscompra,
	compras.fechaemision, 
	compras.fechavencecredito,
	compras.fechapagado,
	compras.codsucursal, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.correosucursal,
	sucursales.llevacontabilidad,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	proveedores.codproveedor,
	proveedores.documproveedor, 
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	proveedores.tlfproveedor, 
	abonoscreditoscompras.codcompra as codigo, 
	abonoscreditoscompras.fechaabono, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	SUM(abonoscreditoscompras.montoabono) AS abonototal  
	FROM (compras INNER JOIN proveedores ON compras.codproveedor = proveedores.codproveedor)
	LEFT JOIN abonoscreditoscompras ON compras.codcompra = abonoscreditoscompras.codcompra
	LEFT JOIN sucursales ON compras.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	WHERE compras.codsucursal = ? 
	AND DATE_FORMAT(compras.fechaemision,'%Y-%m-%d') BETWEEN ? AND ?
	AND compras.tipocompra ='CREDITO' 
	GROUP BY compras.codcompra";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CREDITOS DE COMPRAS PARA EL RANGO DE FECHA INGRESADO</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA CREDITOS DE COMPRAS POR FECHAS ###########################

############################# FIN DE CLASE COMPRAS ###################################





























############################## CLASE COTIZACIONES ###################################

########################### FUNCION REGISTRAR COTIZACIONES ##########################
public function RegistrarCotizaciones()
	{
	self::SetNames();
	if(empty($_POST["codsucursal"]) or empty($_POST["txtTotal"]))
	{
		echo "1";
		exit;
	}

	if(empty($_SESSION["CarritoCotizacion"]))
	{
		echo "2";
		exit;
	}

	################# OBTENGO DATOS DE SUCURSAL #################
	$sql = " SELECT 
	codsucursal, 
	nroactividadsucursal, 
	iniciofactura 
	FROM sucursales WHERE codsucursal = '".limpiar($_POST["codsucursal"])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$nroactividad = $row['nroactividadsucursal'];
	$iniciofactura = $row['iniciofactura'];
	################# OBTENGO DATOS DE SUCURSAL #################

	################ CREO CODIGO DE PEDIDO ####################
	$sql = "SELECT codcotizacion FROM cotizaciones 
	ORDER BY idcotizacion DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$cotizacion=$row["codcotizacion"];

	}
	if(empty($cotizacion))
	{
		$codcotizacion = "01";

	} else {

		$num = substr($cotizacion, 0);
        $dig = $num + 1;
        $codigofinal = str_pad($dig, 2, "0", STR_PAD_LEFT);
        $codcotizacion = $codigofinal;
	}
    ################ CREO CODIGO DE PEDIDO ###############

    ################### CREO CODIGO DE FACTURA ####################
	$sql4 = "SELECT codfactura FROM cotizaciones 
	WHERE codsucursal = '".limpiar($_POST["codsucursal"])."' 
	ORDER BY idcotizacion DESC LIMIT 1";
	foreach ($this->dbh->query($sql4) as $row4){

		$factura=$row4["codfactura"];

	}
	if(empty($factura))
	{
		$codfactura = $nroactividad.'-'.$iniciofactura;

	} else {

		$var = strlen($nroactividad."-");
        $var1 = substr($factura , $var);
        $var2 = strlen($var1);
        $var3 = $var1 + 1;
        $var4 = str_pad($var3, $var2, "0", STR_PAD_LEFT);
        $codfactura = $nroactividad.'-'.$var4;
	}
	################### CREO CODIGO DE FACTURA ####################

    $query = "INSERT INTO cotizaciones values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codcotizacion);
	$stmt->bindParam(2, $codfactura);
	$stmt->bindParam(3, $codcliente);
	$stmt->bindParam(4, $subtotalivasi);
	$stmt->bindParam(5, $subtotalivano);
	$stmt->bindParam(6, $iva);
	$stmt->bindParam(7, $totaliva);
	$stmt->bindParam(8, $descontado);
	$stmt->bindParam(9, $descuento);
	$stmt->bindParam(10, $totaldescuento);
	$stmt->bindParam(11, $totalpago);
	$stmt->bindParam(12, $totalpago2);
	$stmt->bindParam(13, $observaciones);
	$stmt->bindParam(14, $fechacotizacion);
	$stmt->bindParam(15, $codigo);
	$stmt->bindParam(16, $codsucursal);
    
	$codcliente = limpiar($_POST["codcliente"]);
	$subtotalivasi = limpiar($_POST["txtsubtotal"]);
	$subtotalivano = limpiar($_POST["txtsubtotal2"]);
	$iva = limpiar($_POST["iva"]);
	$totaliva = limpiar($_POST["txtIva"]);
	$descontado = limpiar($_POST["txtdescontado"]);
	$descuento = limpiar($_POST["descuento"]);
	$totaldescuento = limpiar($_POST["txtDescuento"]);
	$totalpago = limpiar($_POST["txtTotal"]);
	$totalpago2 = limpiar($_POST["txtTotalCompra"]);
	$observaciones = limpiar($_POST["observaciones"]);
    $fechacotizacion = limpiar(date("Y-m-d H:i:s"));
	$codigo = limpiar($_SESSION["codigo"]);
	$codsucursal = limpiar($_POST["codsucursal"]);
	$stmt->execute();
	
	$this->dbh->beginTransaction();
	$detalle = $_SESSION["CarritoCotizacion"];
	for($i=0;$i<count($detalle);$i++){

	$query = "INSERT INTO detallecotizaciones values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codcotizacion);
    $stmt->bindParam(2, $idproducto);
    $stmt->bindParam(3, $codproducto);
    $stmt->bindParam(4, $producto);
    $stmt->bindParam(5, $codmarca);
    $stmt->bindParam(6, $codmodelo);
    $stmt->bindParam(7, $codpresentacion);
	$stmt->bindParam(8, $cantidad);
	$stmt->bindParam(9, $preciocompra);
	$stmt->bindParam(10, $precioventa);
	$stmt->bindParam(11, $ivaproducto);
	$stmt->bindParam(12, $descproducto);
	$stmt->bindParam(13, $valortotal);
	$stmt->bindParam(14, $totaldescuentov);
	$stmt->bindParam(15, $valorneto);
	$stmt->bindParam(16, $valorneto2);
	$stmt->bindParam(17, $tipodetalle);
	$stmt->bindParam(18, $codsucursal);
		
    $idproducto = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['id'] : "0");
	$codproducto = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['txtCodigo'] : "0");
	$producto = limpiar($detalle[$i]['producto']);
	$codmarca = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['codmarca'] : "0");
	$codmodelo = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['codmodelo'] : "0");
	$codpresentacion = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['codpresentacion'] : "0");
	$cantidad = limpiar($detalle[$i]['cantidad']);
	$preciocompra = limpiar($detalle[$i]['precio']);
	$precioventa = limpiar($detalle[$i]['precio2']);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$descuento = $detalle[$i]['descproducto']/100;
	$valortotal = number_format($detalle[$i]['precio2']*$detalle[$i]['cantidad'], 2, '.', '');
	$totaldescuentov = number_format($valortotal*$descuento, 2, '.', '');
    $valorneto = number_format($valortotal-$totaldescuentov, 2, '.', '');
	$valorneto2 = limpiar($detalle[$i]['tipodetalle'] == "1" ? number_format($detalle[$i]['precio']*$detalle[$i]['cantidad'], 2, '.', '') : "0.00");
	$tipodetalle = limpiar($detalle[$i]['tipodetalle']);
	$codsucursal = limpiar($_POST["codsucursal"]);
	$stmt->execute();
    }
        
    ####################### DESTRUYO LA VARIABLE DE SESSION #####################
	unset($_SESSION["CarritoCotizacion"]);
    $this->dbh->commit();
		
    echo "<span class='fa fa-check-square-o'></span> LA COTIZACI&Oacute;N DE PRODUCTOS HA SIDO REGISTRADA EXITOSAMENTE <a href='reportepdf?codcotizacion=".encrypt($codcotizacion)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURACOTIZACION")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

    echo "<script>window.open('reportepdf?codcotizacion=".encrypt($codcotizacion)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURACOTIZACION")."', '_blank');</script>";
	exit;
}
########################## FUNCION REGISTRAR COTIZACIONES ############################

########################## FUNCION BUSQUEDA DE COTIZACIONES ###############################
public function BusquedaCotizaciones() 
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql ="SELECT 
	cotizaciones.idcotizacion, 
	cotizaciones.codcotizacion, 
	cotizaciones.codfactura,
	cotizaciones.codcliente, 
	cotizaciones.subtotalivasi, 
	cotizaciones.subtotalivano, 
	cotizaciones.iva, 
	cotizaciones.totaliva, 
	cotizaciones.descontado,
	cotizaciones.descuento, 
	cotizaciones.totaldescuento,
	cotizaciones.totalpago, 
	cotizaciones.totalpago2, 
	cotizaciones.observaciones,
	cotizaciones.fechacotizacion, 
	cotizaciones.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio, 
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	usuarios.dni,
	usuarios.nombres,    
	SUM(detallecotizaciones.cantcotizacion) AS articulos 
	FROM (cotizaciones LEFT JOIN detallecotizaciones ON detallecotizaciones.codcotizacion = cotizaciones.codcotizacion) 
	LEFT JOIN sucursales ON cotizaciones.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON cotizaciones.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN usuarios ON cotizaciones.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
	WHERE CONCAT(cotizaciones.codcotizacion, ' ',cotizaciones.codfactura, ' ',if(cotizaciones.codcliente='0','0',clientes.dnicliente), ' ',if(cotizaciones.codcliente='0','0',clientes.nomcliente), ' ',if(cotizaciones.codcliente='0','0',clientes.girocliente), ' ',sucursales.cuitsucursal, ' ',sucursales.nomsucursal, ' ',sucursales.dniencargado, ' ',sucursales.nomencargado) LIKE '%".limpiar($_GET['bcotizaciones'])."%'
	GROUP BY detallecotizaciones.codcotizacion 
	ORDER BY cotizaciones.idcotizacion ASC LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BUSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
  } else {

  	$sql ="SELECT 
	cotizaciones.idcotizacion, 
	cotizaciones.codcotizacion, 
	cotizaciones.codfactura,
	cotizaciones.codcliente, 
	cotizaciones.subtotalivasi, 
	cotizaciones.subtotalivano, 
	cotizaciones.iva, 
	cotizaciones.totaliva, 
	cotizaciones.descontado,
	cotizaciones.descuento, 
	cotizaciones.totaldescuento,
	cotizaciones.totalpago, 
	cotizaciones.totalpago2, 
	cotizaciones.observaciones,
	cotizaciones.fechacotizacion, 
	cotizaciones.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio, 
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	usuarios.dni,
	usuarios.nombres,    
	SUM(detallecotizaciones.cantcotizacion) AS articulos 
	FROM (cotizaciones LEFT JOIN detallecotizaciones ON detallecotizaciones.codcotizacion = cotizaciones.codcotizacion) 
	LEFT JOIN sucursales ON cotizaciones.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON cotizaciones.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN usuarios ON cotizaciones.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
	WHERE CONCAT(cotizaciones.codcotizacion, ' ',cotizaciones.codfactura, ' ',if(cotizaciones.codcliente='0','0',clientes.dnicliente), ' ',if(cotizaciones.codcliente='0','0',clientes.nomcliente), ' ',if(cotizaciones.codcliente='0','0',clientes.girocliente), ' ',sucursales.cuitsucursal, ' ',sucursales.nomsucursal, ' ',sucursales.dniencargado, ' ',sucursales.nomencargado) LIKE '%".limpiar($_GET['bcotizaciones'])."%'
	AND cotizaciones.codsucursal = '".limpiar($_SESSION["codsucursal"])."'
	GROUP BY detallecotizaciones.codcotizacion 
	ORDER BY cotizaciones.idcotizacion ASC LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BUSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	    }
    }
}
########################## FUNCION BUSQUEDA DE COTIZACIONES ###############################

####################### FUNCION LISTAR COTIZACIONES ################################
public function ListarCotizaciones()
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT 
	cotizaciones.idcotizacion, 
	cotizaciones.codcotizacion, 
	cotizaciones.codfactura,
	cotizaciones.codcliente, 
	cotizaciones.subtotalivasi, 
	cotizaciones.subtotalivano, 
	cotizaciones.iva, 
	cotizaciones.totaliva, 
	cotizaciones.descontado,
	cotizaciones.descuento, 
	cotizaciones.totaldescuento,
	cotizaciones.totalpago, 
	cotizaciones.totalpago2, 
	cotizaciones.observaciones,
	cotizaciones.fechacotizacion, 
	cotizaciones.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio, 
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	usuarios.dni,
	usuarios.nombres,    
	SUM(detallecotizaciones.cantcotizacion) AS articulos 
	FROM (cotizaciones LEFT JOIN detallecotizaciones ON detallecotizaciones.codcotizacion = cotizaciones.codcotizacion) 
	LEFT JOIN sucursales ON cotizaciones.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON cotizaciones.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN usuarios ON cotizaciones.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	GROUP BY detallecotizaciones.codcotizacion 
	ORDER BY cotizaciones.idcotizacion ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

     } else if($_SESSION["acceso"] == "cajero") {

     $sql = "SELECT 
	cotizaciones.idcotizacion, 
	cotizaciones.codcotizacion, 
	cotizaciones.codfactura,
	cotizaciones.codcliente, 
	cotizaciones.subtotalivasi, 
	cotizaciones.subtotalivano, 
	cotizaciones.iva, 
	cotizaciones.totaliva, 
	cotizaciones.descontado,
	cotizaciones.descuento, 
	cotizaciones.totaldescuento,
	cotizaciones.totalpago, 
	cotizaciones.totalpago2, 
	cotizaciones.observaciones,
	cotizaciones.fechacotizacion, 
	cotizaciones.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio, 
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	usuarios.dni,
	usuarios.nombres,    
	SUM(detallecotizaciones.cantcotizacion) AS articulos 
	FROM (cotizaciones LEFT JOIN detallecotizaciones ON detallecotizaciones.codcotizacion = cotizaciones.codcotizacion) 
	LEFT JOIN sucursales ON cotizaciones.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON cotizaciones.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN usuarios ON cotizaciones.codigo = usuarios.codigo 
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
	WHERE cotizaciones.codigo = '".limpiar($_SESSION["codigo"])."' 
	GROUP BY detallecotizaciones.codcotizacion 
	ORDER BY cotizaciones.idcotizacion ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
		return $this->p;
		$this->dbh=null;

	} else {

	$sql = "SELECT 
	cotizaciones.idcotizacion, 
	cotizaciones.codcotizacion, 
	cotizaciones.codfactura,
	cotizaciones.codcliente, 
	cotizaciones.subtotalivasi, 
	cotizaciones.subtotalivano, 
	cotizaciones.iva, 
	cotizaciones.totaliva, 
	cotizaciones.descontado,
	cotizaciones.descuento, 
	cotizaciones.totaldescuento,
	cotizaciones.totalpago, 
	cotizaciones.totalpago2, 
	cotizaciones.observaciones,
	cotizaciones.fechacotizacion, 
	cotizaciones.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio, 
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	usuarios.dni,
	usuarios.nombres,    
	SUM(detallecotizaciones.cantcotizacion) AS articulos 
	FROM (cotizaciones LEFT JOIN detallecotizaciones ON detallecotizaciones.codcotizacion = cotizaciones.codcotizacion) 
	LEFT JOIN sucursales ON cotizaciones.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON cotizaciones.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN usuarios ON cotizaciones.codigo = usuarios.codigo 
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
	WHERE cotizaciones.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
	GROUP BY detallecotizaciones.codcotizacion
	ORDER BY cotizaciones.idcotizacion ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

    }
}
######################### FUNCION LISTAR COTIZACIONES ############################

############################ FUNCION ID COTIZACIONES #################################
public function CotizacionesPorId()
	{
	self::SetNames();
	$sql = " SELECT 
	cotizaciones.idcotizacion, 
	cotizaciones.codcotizacion, 
	cotizaciones.codfactura,
	cotizaciones.codcliente, 
	cotizaciones.subtotalivasi,
	cotizaciones.subtotalivano, 
	cotizaciones.iva,
	cotizaciones.totaliva,
    cotizaciones.descontado, 
	cotizaciones.descuento,
	cotizaciones.totaldescuento, 
	cotizaciones.totalpago, 
	cotizaciones.totalpago2,
    cotizaciones.observaciones,
	cotizaciones.fechacotizacion,
	cotizaciones.codsucursal, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.tlfsucursal,
	sucursales.correosucursal,
	sucursales.id_provincia,
	sucursales.id_departamento,
	sucursales.direcsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia AS id_provincia2, 
	clientes.id_departamento AS id_departamento2,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	usuarios.dni, 
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2
	FROM (cotizaciones INNER JOIN sucursales ON cotizaciones.codsucursal = sucursales.codsucursal)
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento 
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON cotizaciones.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON clientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON clientes.id_departamento = departamentos2.id_departamento
	LEFT JOIN usuarios ON cotizaciones.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
	WHERE cotizaciones.codcotizacion = ? AND cotizaciones.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcotizacion"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID COTIZACIONES #################################
	
######################## FUNCION VER DETALLES COTIZACIONES ############################
public function VerDetallesCotizaciones()
	{
	self::SetNames();
	$sql = "SELECT
	detallecotizaciones.coddetallecotizacion,
	detallecotizaciones.codcotizacion,
	detallecotizaciones.coddetallecotizacion,
	detallecotizaciones.idproducto,
	detallecotizaciones.codproducto,
	detallecotizaciones.producto,
	detallecotizaciones.codmarca,
	detallecotizaciones.codmodelo,
	detallecotizaciones.codpresentacion,
	detallecotizaciones.cantcotizacion,
	detallecotizaciones.preciocompra,
	detallecotizaciones.precioventa,
	detallecotizaciones.ivaproducto,
	detallecotizaciones.descproducto,
	detallecotizaciones.valortotal, 
	detallecotizaciones.totaldescuentov,
	detallecotizaciones.valorneto,
	detallecotizaciones.valorneto2,
	detallecotizaciones.tipodetalle,
	detallecotizaciones.codsucursal,
	marcas.nommarca,
	modelos.nommodelo,
	presentaciones.nompresentacion
	FROM detallecotizaciones 
	LEFT JOIN marcas ON detallecotizaciones.codmarca = marcas.codmarca
	LEFT JOIN modelos ON detallecotizaciones.codmodelo = modelos.codmodelo
	LEFT JOIN presentaciones ON detallecotizaciones.codpresentacion = presentaciones.codpresentacion 
	WHERE detallecotizaciones.codcotizacion = ? 
	AND detallecotizaciones.codsucursal = ? ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcotizacion"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$this->p[]=$row;
	}
	return $this->p;
	$this->dbh=null;
}
##################### FUNCION VER DETALLES COTIZACIONES #########################

######################## FUNCION ACTUALIZAR COTIZACIONES #######################
public function ActualizarCotizaciones()
	{
	self::SetNames();
	if(empty($_POST["codcotizacion"]) or empty($_POST["codsucursal"]))
	{
		echo "1";
		exit;
	}

	for($i=0;$i<count($_POST['coddetallecotizacion']);$i++){  //recorro el array
        if (!empty($_POST['coddetallecotizacion'][$i])) {

	       if($_POST['cantcotizacion'][$i]==0){

		      echo "2";
		      exit();

	       }
        }
    }

	$this->dbh->beginTransaction();
	for($i=0;$i<count($_POST['coddetallecotizacion']);$i++){  //recorro el array
	if (!empty($_POST['coddetallecotizacion'][$i])) {

	$sql = "SELECT cantcotizacion 
	FROM detallecotizaciones 
	WHERE coddetallecotizacion = '".limpiar($_POST['coddetallecotizacion'][$i])."' 
	AND codcotizacion = '".limpiar($_POST["codcotizacion"])."' 
	AND codsucursal = '".limpiar($_POST["codsucursal"])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
		
	$cantidadbd = $row['cantcotizacion'];

	if($cantidadbd != $_POST['cantcotizacion'][$i]){

		$query = "UPDATE detallecotizaciones set"
		." cantcotizacion = ?, "
		." valortotal = ?, "
		." totaldescuentov = ?, "
		." valorneto = ?, "
		." valorneto2 = ? "
		." WHERE "
		." coddetallecotizacion = ? AND codcotizacion = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $cantcotizacion);
		$stmt->bindParam(2, $valortotal);
		$stmt->bindParam(3, $totaldescuentov);
		$stmt->bindParam(4, $valorneto);
		$stmt->bindParam(5, $valorneto2);
		$stmt->bindParam(6, $coddetallecotizacion);
		$stmt->bindParam(7, $codcotizacion);
		$stmt->bindParam(8, $codsucursal);

		$cantcotizacion = limpiar($_POST['cantcotizacion'][$i]);
		$preciocompra = limpiar($_POST['preciocompra'][$i]);
		$precioventa = limpiar($_POST['precioventa'][$i]);
		$ivaproducto = limpiar($_POST['ivaproducto'][$i]);
		$descuento = $_POST['descproducto'][$i]/100;
		$valortotal = number_format($_POST['valortotal'][$i], 2, '.', '');
		$totaldescuento = number_format($_POST['totaldescuentov'][$i], 2, '.', '');
		$valorneto = number_format($_POST['valorneto'][$i], 2, '.', '');
		$valorneto2 = number_format($_POST['valorneto2'][$i], 2, '.', '');
		$coddetallecotizacion = limpiar($_POST['coddetallecotizacion'][$i]);
		$codcotizacion = limpiar($_POST["codcotizacion"]);
		$codsucursal = limpiar($_POST["codsucursal"]);
		$stmt->execute();

		} else {

           echo "";

	       }
        }
    }
    $this->dbh->commit();

    ############ ACTUALIZO LOS TOTALES EN LA COTIZACION ##############
	$sql = " UPDATE cotizaciones SET "
	." codcliente = ?, "
	." observaciones = ?, "
	." subtotalivasi = ?, "
	." subtotalivano = ?, "
	." totaliva = ?, "
	." descontado = ?, "
	." descuento = ?, "
	." totaldescuento = ?, "
	." totalpago = ?, "
	." totalpago2= ? "
	." WHERE "
	." codcotizacion = ? AND codsucursal = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $codcliente);
	$stmt->bindParam(2, $observaciones);
	$stmt->bindParam(3, $subtotalivasi);
	$stmt->bindParam(4, $subtotalivano);
	$stmt->bindParam(5, $totaliva);
	$stmt->bindParam(6, $descontado);
	$stmt->bindParam(7, $descuento);
	$stmt->bindParam(8, $totaldescuento);
	$stmt->bindParam(9, $totalpago);
	$stmt->bindParam(10, $totalpago2);
	$stmt->bindParam(11, $codcotizacion);
	$stmt->bindParam(12, $codsucursal);

	$codcliente = limpiar($_POST["codcliente"]);
	$observaciones = limpiar($_POST["observaciones"]);
	$subtotalivasi = number_format($_POST["txtsubtotal"], 2, '.', '');
	$subtotalivano = number_format($_POST["txtsubtotal2"], 2, '.', '');
	$totaliva = number_format($_POST["txtIva"], 2, '.', '');
	$descontado = number_format($_POST["txtdescontado"], 2, '.', '');
	$descuento = limpiar($_POST["descuento"]);
    $totaldescuento = number_format($_POST["txtDescuento"], 2, '.', '');
    $totalpago = number_format($_POST["txtTotal"], 2, '.', '');
    $totalpago2 = number_format($_POST["txtTotalCompra"], 2, '.', '');
	$codcotizacion = limpiar($_POST["codcotizacion"]);
	$codsucursal = limpiar($_POST["codsucursal"]);
	$stmt->execute();
	############ ACTUALIZO LOS TOTALES EN LA COTIZACION ##############

    echo "<span class='fa fa-check-square-o'></span> LA COTIZACI&Oacute;N DE PRODUCTOS HA SIDO ACTUALIZADA EXITOSAMENTE <a href='reportepdf?codcotizacion=".encrypt($codcotizacion)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURACOTIZACION")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

    echo "<script>window.open('reportepdf?codcotizacion=".encrypt($codcotizacion)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURACOTIZACION")."', '_blank');</script>";
	exit;
}
####################### FUNCION ACTUALIZAR COTIZACIONES ############################

####################### FUNCION AGREGAR DETALLES COTIZACIONES ########################
public function AgregarDetallesCotizaciones()
	{
	self::SetNames();
	if(empty($_POST["codcotizacion"]) or empty($_POST["codsucursal"]))
	{
		echo "1";
		exit;
	}
    elseif(empty($_SESSION["CarritoCotizacion"]))
	{
		echo "2";
		exit;
		
	}

    $this->dbh->beginTransaction();
    $detalle = $_SESSION["CarritoCotizacion"];
	for($i=0;$i<count($detalle);$i++){

	$sql = "SELECT codcotizacion, codproducto 
	FROM detallecotizaciones 
	WHERE codcotizacion = '".limpiar($_POST['codcotizacion'])."' 
	AND codsucursal = '".limpiar($_POST['codsucursal'])."' 
	AND codproducto = '".limpiar($detalle[$i]['txtCodigo'])."'";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num == 0)
		{

        $query = "INSERT INTO detallecotizaciones values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(1, $codcotizacion);
        $stmt->bindParam(2, $idproducto);
        $stmt->bindParam(3, $codproducto);
        $stmt->bindParam(4, $producto);
        $stmt->bindParam(5, $codmarca);
        $stmt->bindParam(6, $codmodelo);
        $stmt->bindParam(7, $codpresentacion);
        $stmt->bindParam(8, $cantidad);
        $stmt->bindParam(9, $preciocompra);
        $stmt->bindParam(10, $precioventa);
        $stmt->bindParam(11, $ivaproducto);
        $stmt->bindParam(12, $descproducto);
        $stmt->bindParam(13, $valortotal);
        $stmt->bindParam(14, $totaldescuentov);
        $stmt->bindParam(15, $valorneto);
        $stmt->bindParam(16, $valorneto2);
        $stmt->bindParam(17, $tipodetalle);
        $stmt->bindParam(18, $codsucursal);
			
		$codcotizacion = limpiar($_POST["codcotizacion"]);
		$idproducto = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['id'] : "0");
		$codproducto = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['txtCodigo'] : "0");
		$producto = limpiar($detalle[$i]['producto']);
		$codmarca = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['codmarca'] : "0");
		$codmodelo = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['codmodelo'] : "0");
		$codpresentacion = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['codpresentacion'] : "0");
		$cantidad = limpiar($detalle[$i]['cantidad']);
		$preciocompra = limpiar($detalle[$i]['precio']);
		$precioventa = limpiar($detalle[$i]['precio2']);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$descuento = $detalle[$i]['descproducto']/100;
		$valortotal = number_format($detalle[$i]['precio2']*$detalle[$i]['cantidad'], 2, '.', '');
		$totaldescuentov = number_format($valortotal*$descuento, 2, '.', '');
		$valorneto = number_format($valortotal-$totaldescuentov, 2, '.', '');
		$valorneto2 = limpiar($detalle[$i]['tipodetalle'] == "1" ? number_format($detalle[$i]['precio']*$detalle[$i]['cantidad'], 2, '.', '') : "0.00");
		$tipodetalle = limpiar($detalle[$i]['tipodetalle']);
		$codsucursal = limpiar($_POST["codsucursal"]);
		$stmt->execute();

	  } else {

	  	$sql = "SELECT cantcotizacion 
	  	FROM detallecotizaciones 
	  	WHERE codcotizacion = '".limpiar($_POST['codcotizacion'])."' 
	  	AND codsucursal = '".limpiar($_POST['codsucursal'])."' 
	  	AND codproducto = '".limpiar($detalle[$i]['txtCodigo'])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$cantidad = $row['cantcotizacion'];

	  	$query = "UPDATE detallecotizaciones set"
		." cantcotizacion = ?, "
		." descproducto = ?, "
		." valortotal = ?, "
		." totaldescuentov = ?, "
		." valorneto = ?, "
		." valorneto2 = ? "
		." WHERE "
		." codcotizacion = ? AND codsucursal = ? AND codproducto = ?;
		";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $cantcotizacion);
		$stmt->bindParam(2, $descproducto);
		$stmt->bindParam(3, $valortotal);
		$stmt->bindParam(4, $totaldescuentov);
		$stmt->bindParam(5, $valorneto);
		$stmt->bindParam(6, $valorneto2);
		$stmt->bindParam(7, $codcotizacion);
		$stmt->bindParam(8, $codsucursal);
		$stmt->bindParam(9, $codproducto);

		$cantcotizacion = limpiar($detalle[$i]['cantidad']+$cantidad);
		$preciocompra = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['precio'] : "0.00");
		$precioventa = limpiar($detalle[$i]['precio2']);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$descuento = $detalle[$i]['descproducto']/100;
		$valortotal = number_format($detalle[$i]['precio2'] * $cantcotizacion, 2, '.', '');
		$totaldescuentov = number_format($valortotal * $descuento, 2, '.', '');
		$valorneto = number_format($valortotal - $totaldescuentov, 2, '.', '');
		$valorneto2 = limpiar($detalle[$i]['tipodetalle'] == "1" ? number_format($detalle[$i]['precio']*$cantcotizacion, 2, '.', '') : "0.00");
		$codcotizacion = limpiar($_POST["codcotizacion"]);
		$codsucursal = limpiar($_POST["codsucursal"]);
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$stmt->execute();
	 }
   }    
        ####################### DESTRUYO LA VARIABLE DE SESSION #####################
	    unset($_SESSION["CarritoCotizacion"]);
        $this->dbh->commit();

        ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############
        $sql3 = "SELECT SUM(totaldescuentov) AS totaldescuentosi, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detallecotizaciones WHERE codcotizacion = '".limpiar($_POST["codcotizacion"])."' AND codsucursal = '".limpiar($_POST["codsucursal"])."' AND ivaproducto = 'SI'";
        foreach ($this->dbh->query($sql3) as $row3)
        {
        	$this->p[] = $row3;
        }
        $subtotaldescuentosi = ($row3['totaldescuentosi']== "" ? "0.00" : $row3['totaldescuentosi']);
        $subtotalivasi = ($row3['valorneto']== "" ? "0.00" : $row3['valorneto']);
        $subtotalivasi2 = ($row3['valorneto2']== "" ? "0.00" : $row3['valorneto2']);
        ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############

		############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############
        $sql4 = "SELECT SUM(totaldescuentov) AS totaldescuentono, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detallecotizaciones WHERE codcotizacion = '".limpiar($_POST["codcotizacion"])."' AND codsucursal = '".limpiar($_POST["codsucursal"])."' AND ivaproducto = 'NO'";
        foreach ($this->dbh->query($sql4) as $row4)
        {
        	$this->p[] = $row4;
        }
        $subtotaldescuentono = ($row4['totaldescuentono']== "" ? "0.00" : $row4['totaldescuentono']);
        $subtotalivano = ($row4['valorneto']== "" ? "0.00" : $row4['valorneto']);
        $subtotalivano2 = ($row4['valorneto2']== "" ? "0.00" : $row4['valorneto2']);
        ############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############

        ############ ACTUALIZO LOS TOTALES EN LA COTIZACION ##############
        $sql = " UPDATE cotizaciones SET "
        ." codcliente = ?, "
        ." observaciones = ?, "
        ." subtotalivasi = ?, "
        ." subtotalivano = ?, "
        ." totaliva = ?, "
        ." descontado = ?, "
        ." descuento = ?, "
        ." totaldescuento = ?, "
        ." totalpago = ?, "
        ." totalpago2= ? "
        ." WHERE "
        ." codcotizacion = ? AND codsucursal = ?;
        ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(1, $codcliente);
        $stmt->bindParam(2, $observaciones);
        $stmt->bindParam(3, $subtotalivasi);
        $stmt->bindParam(4, $subtotalivano);
        $stmt->bindParam(5, $totaliva);
        $stmt->bindParam(6, $descontado);
        $stmt->bindParam(7, $descuento);
        $stmt->bindParam(8, $totaldescuento);
        $stmt->bindParam(9, $totalpago);
        $stmt->bindParam(10, $totalpago2);
        $stmt->bindParam(11, $codcotizacion);
        $stmt->bindParam(12, $codsucursal);

        $codcliente = limpiar($_POST["codcliente"]);
        $observaciones = limpiar($_POST["observaciones"]);
        $iva = $_POST["iva"]/100;
        $totaliva = number_format($subtotalivasi*$iva, 2, '.', '');
        $descontado = number_format($subtotaldescuentosi+$subtotaldescuentono, 2, '.', '');
        $descuento = limpiar($_POST["descuento"]);
        $txtDescuento = $_POST["descuento"]/100;
        $total = number_format($subtotalivasi+$subtotalivano+$totaliva, 2, '.', '');
        $totaldescuento = number_format($total*$txtDescuento, 2, '.', '');
        $totalpago = number_format($total-$totaldescuento, 2, '.', '');
        $totalpago2 = number_format($subtotalivasi2+$subtotalivano2, 2, '.', '');
        $codcotizacion = limpiar($_POST["codcotizacion"]);
        $codsucursal = limpiar($_POST["codsucursal"]);
        $stmt->execute();
        ############ ACTUALIZO LOS TOTALES EN LA COTIZACION ##############
		
echo "<span class='fa fa-check-square-o'></span> LOS DETALLES DE PRODUCTOS FUERON AGREGADOS A LA COTIZACI&Oacute;N EXITOSAMENTE <a href='reportepdf?codcotizacion=".encrypt($codcotizacion)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURACOTIZACION")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

echo "<script>window.open('reportepdf?codcotizacion=".encrypt($codcotizacion)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURACOTIZACION")."', '_blank');</script>";
	exit;
}
######################### FUNCION AGREGAR DETALLES COTIZACIONES #######################

######################## FUNCION ELIMINAR DETALLES COTIZACIONES #######################
public function EliminarDetallesCotizaciones()
	{
	self::SetNames();
	if ($_SESSION["acceso"]=="administradorS") {

	$sql = "SELECT * FROM detallecotizaciones WHERE codcotizacion = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcotizacion"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num > 1)
	{

		################## ELIMINO DETALLE DE COTIZACION ##################
		$sql = "DELETE FROM detallecotizaciones WHERE coddetallecotizacion = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$coddetallecotizacion);
		$stmt->bindParam(2,$codsucursal);
		$coddetallecotizacion = decrypt($_GET["coddetallecotizacion"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();
		################## ELIMINO DETALLE DE COTIZACION ##################

	    ############ CONSULTO LOS TOTALES DE COTIZACIONES ##############
	    $sql2 = "SELECT iva, descuento FROM cotizaciones WHERE codcotizacion = ? AND codsucursal = ?";
	    $stmt = $this->dbh->prepare($sql2);
	    $stmt->execute(array(decrypt($_GET["codcotizacion"]),decrypt($_GET["codsucursal"])));
	    $num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$paea[] = $row;
		}
		$iva = $paea[0]["iva"]/100;
	    $descuento = $paea[0]["descuento"]/100;
	    ############ CONSULTO LOS TOTALES DE COTIZACIONES ##############

        ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############
		$sql3 = "SELECT SUM(totaldescuentov) AS totaldescuentosi, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detallecotizaciones WHERE codcotizacion = '".limpiar(decrypt($_GET["codcotizacion"]))."' AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."' AND ivaproducto = 'SI'";
		foreach ($this->dbh->query($sql3) as $row3)
		{
			$this->p[] = $row3;
		}
		$subtotaldescuentosi = ($row3['totaldescuentosi']== "" ? "0.00" : $row3['totaldescuentosi']);
		$subtotalivasi = ($row3['valorneto']== "" ? "0.00" : $row3['valorneto']);
		$subtotalivasi2 = ($row3['valorneto2']== "" ? "0.00" : $row3['valorneto2']);
		############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############

	    ############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############
		$sql4 = "SELECT SUM(totaldescuentov) AS totaldescuentono, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detallecotizaciones WHERE codcotizacion = '".limpiar(decrypt($_GET["codcotizacion"]))."' AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."' AND ivaproducto = 'NO'";
		foreach ($this->dbh->query($sql4) as $row4)
		{
			$this->p[] = $row4;
		}
		$subtotaldescuentono = ($row4['totaldescuentono']== "" ? "0.00" : $row4['totaldescuentono']);
		$subtotalivano = ($row4['valorneto']== "" ? "0.00" : $row4['valorneto']);
		$subtotalivano2 = ($row4['valorneto2']== "" ? "0.00" : $row4['valorneto2']);
		############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############

        ############ ACTUALIZO LOS TOTALES EN LA COTIZACION ##############
		$sql = " UPDATE cotizaciones SET "
		." subtotalivasi = ?, "
		." subtotalivano = ?, "
		." totaliva = ?, "
		." descontado = ?, "
		." totaldescuento = ?, "
		." totalpago = ?, "
		." totalpago2= ? "
		." WHERE "
		." codcotizacion = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $subtotalivasi);
		$stmt->bindParam(2, $subtotalivano);
		$stmt->bindParam(3, $totaliva);
		$stmt->bindParam(4, $descontado);
		$stmt->bindParam(5, $totaldescuento);
		$stmt->bindParam(6, $totalpago);
		$stmt->bindParam(7, $totalpago2);
		$stmt->bindParam(8, $codcotizacion);
		$stmt->bindParam(9, $codsucursal);

		$totaliva= number_format($subtotalivasi*$iva, 2, '.', '');
		$descontado = number_format($subtotaldescuentosi+$subtotaldescuentono, 2, '.', '');
	    $total= number_format($subtotalivasi+$subtotalivano+$totaliva, 2, '.', '');
	    $totaldescuento= number_format($total*$descuento, 2, '.', '');
	    $totalpago= number_format($total-$totaldescuento, 2, '.', '');
		$totalpago2 = number_format($subtotalivasi2+$subtotalivano2, 2, '.', '');
		$codcotizacion = limpiar(decrypt($_GET["codcotizacion"]));
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute();
		############ ACTUALIZO LOS TOTALES EN LA COTIZACION ##############

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
			
	} else {
		
		echo "3";
		exit;
	}	
}
################### FUNCION ELIMINAR DETALLES COTIZACIONES #####################

####################### FUNCION ELIMINAR COTIZACIONES #################################
public function EliminarCotizaciones()
	{
	self::SetNames();
	if ($_SESSION["acceso"]=="administradorS") {

		################## ELIMINO COTIZACION ##################
		$sql = "DELETE FROM cotizaciones WHERE codcotizacion = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codcotizacion);
		$stmt->bindParam(2,$codsucursal);
		$codcotizacion = decrypt($_GET["codcotizacion"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();
		################## ELIMINO COTIZACION ##################

		################## ELIMINO DETALLE DE COTIZACION ##################
		$sql = "DELETE FROM detallecotizaciones WHERE codcotizacion = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codcotizacion);
		$stmt->bindParam(2,$codsucursal);
		$codcotizacion = decrypt($_GET["codcotizacion"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();
		################## ELIMINO DETALLE DE COTIZACION ##################

		echo "1";
		exit;

	} else {

		echo "2";
		exit;
	}
}
###################### FUNCION ELIMINAR COTIZACIONES #################################

####################### FUNCION PROCESAR COTIZACIONES A VENTA #################################
public function ProcesarCotizaciones()
	{
	self::SetNames();
	####################### VERIFICO ARQUEO DE CAJA #######################
	$sql = "SELECT * FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
	WHERE usuarios.codigo = ? AND arqueocaja.statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_SESSION["codigo"]));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "1";
		exit;

	} else {
		
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		$codarqueo = $row['codarqueo'];
		$codcaja = $row['codcaja'];
		$ingreso = ($row['ingresos']== "" ? "0.00" : $row['ingresos']);
		$credito = ($row['creditos']== "" ? "0.00" : $row['creditos']);
		$abono = ($row['abonos']== "" ? "0.00" : $row['abonos']);
	}
    ####################### VERIFICO ARQUEO DE CAJA #######################

    if(empty($_POST["codsucursal"]) or empty($_POST["tipodocumento"]) or empty($_POST["tipopago"]))
	{
		echo "2";
		exit;
	}
	elseif(limpiar($_POST["txtTotal"]=="") && limpiar($_POST["txtTotal"]==0) && limpiar($_POST["txtTotal"]==0.00))
	{
		echo "3";
		exit;
		
	}

	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #############
	$sql = "SELECT * FROM detallecotizaciones 
	WHERE codcotizacion = '".decrypt($_POST['codcotizacion'])."' 
	AND codsucursal = '".decrypt($_POST['codsucursal'])."'";
    	foreach ($this->dbh->query($sql) as $row2) {

	    $sql = "SELECT 
	    existencia 
	    FROM productos 
	    WHERE codproducto = '".limpiar($row2['codproducto'])."' 
	    AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
	    foreach ($this->dbh->query($sql) as $row)
	    {
		   $this->p[] = $row;
	    }
	
	    $existenciadb = $row['existencia'];
	    $cantidad = $row2['cantcotizacion'];

        if ($cantidad > $existenciadb) 
        { 
	       echo "4";
	       exit;
        }
	}
	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #############

	################### SELECCIONE LOS DATOS DEL CLIENTE ######################
    $sql = "SELECT
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	provincias.provincia,
	departamentos.departamento,
    ROUND(SUM(if(pag.montocredito!='0',pag.montocredito,'0.00')), 2) montoactual,
    ROUND(SUM(if(pag.montocredito!='0',clientes.limitecredito-pag.montocredito,clientes.limitecredito)), 2) creditodisponible
    FROM clientes
    LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
    LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento 
    LEFT JOIN
       (SELECT
       codcliente, montocredito       
       FROM creditosxclientes 
       WHERE codsucursal = '".limpiar($_POST['codsucursal'])."') pag ON pag.codcliente = clientes.codcliente
       WHERE clientes.codcliente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST['codcliente']));
	$num = $stmt->rowCount();
	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$p[] = $row;
	}
    $tipocliente = ($row['tipocliente'] == "" ? "0" : $row['tipocliente']);
    $dnicliente = ($row['dnicliente'] == "" ? "0" : $row['dnicliente']);
    $nomcliente = ($row['nomcliente'] == "" ? "0" : $row['nomcliente']);
    $girocliente = ($row['girocliente'] == "" ? "0" : $row['girocliente']);
    $emailcliente = $row['emailcliente'];
    $limitecredito = $row['limitecredito'];
    $montoactual = $row['montoactual'];
    $creditodisponible = $row['creditodisponible'];
    $montoabono = (empty($_POST["montoabono"]) ? "0.00" : $_POST["montoabono"]);
    $total = number_format($_POST["txtTotal"]-$montoabono, 2, '.', '');
    ################### SELECCIONE LOS DATOS DEL CLIENTE ######################

    ################### VALIDO TIPO DE PAGO ES A CREDITO ######################
    if (limpiar($_POST["tipopago"]) == "CREDITO") {

    	$fechaactual = date("Y-m-d");
		$fechavence = date("Y-m-d",strtotime($_POST['fechavencecredito']));

		if ($_POST["codcliente"] == '0') { 

        echo "5";
        exit;

        } else if (strtotime($fechavence) < strtotime($fechaactual)) {

			echo "6";
			exit;

		} else if ($limitecredito != "0.00" && $total > $creditodisponible) {

            echo "7";
            exit;

        } else if($_POST["montoabono"] >= $_POST["txtTotal"]) { 

	        echo "8";
	        exit;
        }
    }
    ################### VALIDO TIPO DE PAGO ES A CREDITO ######################
	
	################# OBTENGO DATOS DE SUCURSAL #################
	$sql = " SELECT 
	codsucursal, 
	nroactividadsucursal, 
	inicioticket,
	iniciofactura, 
	inicioguia, 
	inicionotaventa  
	FROM sucursales 
	WHERE codsucursal = '".limpiar(decrypt($_POST['codsucursal']))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$nroactividad = $row['nroactividadsucursal'];

	$inicioticket = $row['inicioticket'];
	$iniciofactura = $row['iniciofactura'];
	$inicioguia = $row['inicioguia'];
	$inicionotaventa = $row['inicionotaventa'];
	################# OBTENGO DATOS DE SUCURSAL #################

	################ CREO CODIGO DE PEDIDO ####################
	$sql = "SELECT codventa FROM ventas 
	ORDER BY idventa DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$venta=$row["codventa"];

	}
	if(empty($venta))
	{
		$codventa = "01";

	} else {

		$num = substr($venta, 0);
        $dig = $num + 1;
        $codigofinal = str_pad($dig, 2, "0", STR_PAD_LEFT);
        $codventa = $codigofinal;
	}
    ################ CREO CODIGO DE PEDIDO ###############

	################### CREO CODIGO DE FACTURA ####################
	$sql = "SELECT codfactura
	FROM ventas 
	WHERE codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."' 
	ORDER BY idventa DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$factura=$row["codfactura"];

	}
	
	if($_POST['tipodocumento']=="TICKET") {

        if(empty($factura)){ 
        	$codfactura = $nroactividad.'-'.$inicioticket;
        } else {
           $var = strlen($nroactividad."-");
           $var1 = substr($factura , $var);
           $var2 = strlen($var1);
           $var3 = $var1 + 1;
           $var4 = str_pad($var3, $var2, "0", STR_PAD_LEFT);
           $codfactura = $nroactividad.'-'.$var4;
        }
		   $codserie = limpiar($nroactividad);
		   $codautorizacion = limpiar(GenerateRandomStringg());

	} elseif($_POST['tipodocumento']=="FACTURA") {

        if(empty($factura)){ 
        	$codfactura = $nroactividad.'-'.$iniciofactura;
        } else {
           $var = strlen($nroactividad."-");
           $var1 = substr($factura , $var);
           $var2 = strlen($var1);
           $var3 = $var1 + 1;
           $var4 = str_pad($var3, $var2, "0", STR_PAD_LEFT);
           $codfactura = $nroactividad.'-'.$var4;
        }
		   $codserie = limpiar($nroactividad);
		   $codautorizacion = limpiar(GenerateRandomStringg());

	} elseif($_POST['tipodocumento']=="GUIA") {

        if(empty($factura)){ 
        	$codfactura = $nroactividad.'-'.$inicioguia;
        } else {
           $var = strlen($nroactividad."-");
           $var1 = substr($factura , $var);
           $var2 = strlen($var1);
           $var3 = $var1 + 1;
           $var4 = str_pad($var3, $var2, "0", STR_PAD_LEFT);
           $codfactura = $nroactividad.'-'.$var4;
        }
		   $codserie = limpiar($nroactividad);
		   $codautorizacion = limpiar(GenerateRandomStringg());

	} elseif($_POST['tipodocumento']=="NOTA VENTA") {

        if(empty($factura)){ 
        	$codfactura = $nroactividad.'-'.$inicionotaventa;
        } else {
           $var = strlen($nroactividad."-");
           $var1 = substr($factura , $var);
           $var2 = strlen($var1);
           $var3 = $var1 + 1;
           $var4 = str_pad($var3, $var2, "0", STR_PAD_LEFT);
           $codfactura = $nroactividad.'-'.$var4;
        }
		   $codserie = limpiar($nroactividad);
		   $codautorizacion = limpiar(GenerateRandomStringg());
	}
    ################### CREO CODIGO DE FACTURA ####################

	################### SELECCIONE LOS DATOS DE LA COTIZACION ######################
    $sql = "SELECT * FROM cotizaciones WHERE codcotizacion = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_POST['codcotizacion']),decrypt($_POST['codsucursal'])));
	$num = $stmt->rowCount();
	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$p[] = $row;
	}
    ################### SELECCIONE LOS DATOS DE LA COTIZACION ######################

    $fecha = date("Y-m-d H:i:s");

    $query = "INSERT INTO ventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $tipodocumento);
	$stmt->bindParam(2, $codcaja);
	$stmt->bindParam(3, $codventa);
	$stmt->bindParam(4, $codfactura);
	$stmt->bindParam(5, $codserie);
	$stmt->bindParam(6, $codautorizacion);
	$stmt->bindParam(7, $codcliente);
	$stmt->bindParam(8, $subtotalivasi);
	$stmt->bindParam(9, $subtotalivano);
	$stmt->bindParam(10, $iva);
	$stmt->bindParam(11, $totaliva);
	$stmt->bindParam(12, $descontado);
	$stmt->bindParam(13, $descuento);
	$stmt->bindParam(14, $totaldescuento);
	$stmt->bindParam(15, $totalpago);
	$stmt->bindParam(16, $totalpago2);
	$stmt->bindParam(17, $creditopagado);
	$stmt->bindParam(18, $tipopago);
	$stmt->bindParam(19, $formapago);
	$stmt->bindParam(20, $montopagado);
	$stmt->bindParam(21, $montodevuelto);
	$stmt->bindParam(22, $fechavencecredito);
	$stmt->bindParam(23, $fechapagado);
	$stmt->bindParam(24, $statusventa);
	$stmt->bindParam(25, $fechaventa);
	$stmt->bindParam(26, $observaciones);
	$stmt->bindParam(27, $notacredito);
	$stmt->bindParam(28, $codigo);
	$stmt->bindParam(29, $codsucursal);
    
	$tipodocumento = limpiar($_POST["tipodocumento"]);
	$codcaja = limpiar($_POST["codcaja"]);
	$codcliente = limpiar($_POST['codcliente']);
	$subtotalivasi = limpiar($row["subtotalivasi"]);
	$subtotalivano = limpiar($row["subtotalivano"]);
	$iva = limpiar($row["iva"]);
	$totaliva = limpiar($row["totaliva"]);
	$descontado = limpiar($row["descontado"]);
	$descuento = limpiar($row["descuento"]);
	$totaldescuento = limpiar($row["totaldescuento"]);
	$totalpago = limpiar($row["totalpago"]);
	$totalpago2 = limpiar($row["totalpago2"]);
	$creditopagado = limpiar(isset($_POST['montoabono']) ? $_POST["montoabono"] : "0.00");
	$tipopago = limpiar($_POST["tipopago"]);
	$formapago = limpiar($_POST["tipopago"]=="CONTADO" ? decrypt($_POST["codmediopago"]) : "CREDITO");
	$montopagado = limpiar(isset($_POST['montopagado']) ? $_POST["montopagado"] : "0.00");
	$montodevuelto = limpiar(isset($_POST['montodevuelto']) ? $_POST["montodevuelto"] : "0.00");
	$fechavencecredito = limpiar($_POST["tipopago"]=="CREDITO" ? date("Y-m-d",strtotime($_POST['fechavencecredito'])) : "0000-00-00");
    $fechapagado = limpiar("0000-00-00");
    $statusventa = limpiar($_POST["tipopago"]=="CONTADO" ? "PAGADA" : "PENDIENTE");
    $fechaventa = limpiar($fecha);
	$observaciones = limpiar($_POST["observaciones"]);
	$notacredito = limpiar("0");
	$codigo = limpiar($_SESSION["codigo"]);
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();

	################### SELECCIONO DETALLES DE LA COTIZACION ######################
	$sql = "SELECT * FROM detallecotizaciones 
	WHERE codcotizacion = '".decrypt($_POST['codcotizacion'])."' 
	AND codsucursal = '".decrypt($_POST['codsucursal'])."'";
    foreach ($this->dbh->query($sql) as $row2)
	{

	    $query = "INSERT INTO detalleventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
    	$stmt = $this->dbh->prepare($query);
    	$stmt->bindParam(1, $codventa);
    	$stmt->bindParam(2, $idproducto);
    	$stmt->bindParam(3, $codproducto);
    	$stmt->bindParam(4, $producto);
    	$stmt->bindParam(5, $codmarca);
    	$stmt->bindParam(6, $codmodelo);
    	$stmt->bindParam(7, $codpresentacion);
    	$stmt->bindParam(8, $cantidad);
    	$stmt->bindParam(9, $preciocompra);
    	$stmt->bindParam(10, $precioventa);
    	$stmt->bindParam(11, $ivaproducto);
    	$stmt->bindParam(12, $descproducto);
    	$stmt->bindParam(13, $valortotal);
    	$stmt->bindParam(14, $totaldescuentov);
    	$stmt->bindParam(15, $valorneto);
    	$stmt->bindParam(16, $valorneto2);
    	$stmt->bindParam(17, $tipodetalle);
    	$stmt->bindParam(18, $codsucursal);

	    $idproducto = limpiar($row2['idproducto']);
    	$codproducto = limpiar($row2['codproducto']);
    	$producto = limpiar($row2['producto']);
    	$codmarca = limpiar($row2['codmarca']);
    	$codmodelo = limpiar($row2['codmodelo']);
    	$codpresentacion = limpiar($row2['codpresentacion']);
    	$cantidad = limpiar($row2['cantcotizacion']);
    	$preciocompra = limpiar($row2['preciocompra']);
    	$precioventa = limpiar($row2['precioventa']);
    	$ivaproducto = limpiar($row2['ivaproducto']);
    	$descproducto = limpiar($row2['descproducto']);
    	$descuento = $row2['descproducto']/100;
    	$valortotal = number_format($row2['valortotal'], 2, '.', '');
    	$totaldescuentov = number_format($row2['totaldescuentov'], 2, '.', '');
    	$valorneto = number_format($row2['valorneto'], 2, '.', '');
    	$valorneto2 = number_format($row2['valorneto2'], 2, '.', '');
    	$tipodetalle = limpiar($row2['tipodetalle']);
    	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
    	$stmt->execute();

    	if(limpiar($row2['tipodetalle'])==1){

        ############### VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ##################
		$sql = "SELECT existencia FROM productos WHERE codproducto = '".limpiar($row2['codproducto'])."' AND codsucursal = '".limpiar(decrypt($_POST['codsucursal']))."'";
		foreach ($this->dbh->query($sql) as $row3)
		{
			$this->p[] = $row3;
		}
		$existenciabd = $row3['existencia'];
	    ############### VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ##################

	    ##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
    	$sql = " UPDATE productos set "
    	." existencia = ? "
    	." where "
    	." codproducto = '".limpiar($row2['codproducto'])."' AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."';
    	";
    	$stmt = $this->dbh->prepare($sql);
    	$stmt->bindParam(1, $existencia);
    	$cantventa = limpiar($row2['cantcotizacion']);
    	$existencia = $existenciabd-$cantventa;
    	$stmt->execute();
    	##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################

    	}

        ############### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###############
    	$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
    	$stmt = $this->dbh->prepare($query);
    	$stmt->bindParam(1, $codventa);
    	$stmt->bindParam(2, $codcliente);
    	$stmt->bindParam(3, $codproducto);
    	$stmt->bindParam(4, $movimiento);
    	$stmt->bindParam(5, $entradas);
    	$stmt->bindParam(6, $salidas);
    	$stmt->bindParam(7, $devolucion);
    	$stmt->bindParam(8, $stockactual);
    	$stmt->bindParam(9, $ivaproducto);
    	$stmt->bindParam(10, $descproducto);
    	$stmt->bindParam(11, $precio);
    	$stmt->bindParam(12, $documento);
    	$stmt->bindParam(13, $fechakardex);	
    	$stmt->bindParam(14, $tipokardex);		
    	$stmt->bindParam(15, $codsucursal);

    	$codcliente = limpiar($_POST["codcliente"]);
    	$codproducto = limpiar($row2['codproducto']);
    	$movimiento = limpiar("SALIDAS");
    	$entradas = limpiar("0");
    	$salidas= limpiar($row2['cantcotizacion']);
    	$devolucion = limpiar("0");
    	$stockactual = limpiar($row2['tipodetalle'] == 1 ? $existenciabd-$row2['cantcotizacion'] : "0");
    	$precio = limpiar($row2["precioventa"]);
    	$ivaproducto = limpiar($row2['ivaproducto']);
    	$descproducto = limpiar($row2['descproducto']);
    	$documento = limpiar("VENTA: ".$codventa);
    	$fechakardex = limpiar(date("Y-m-d"));	
    	$tipokardex = limpiar($row2['tipodetalle']);
    	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
    	$stmt->execute();

	}
	################### SELECCIONO DETALLES DE LA COTIZACION ######################

	################ AGREGAMOS EL INGRESO DE VENTAS PAGADAS A CAJA ##############
    if (limpiar($_POST["tipopago"]=="CONTADO")){

		$sql = "UPDATE arqueocaja set "
		." ingresos = ? "
		." WHERE "
		." codarqueo = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtTotal);
		$stmt->bindParam(2, $codarqueo);

		$txtTotal = number_format($_POST["txtTotal"]+$ingreso, 2, '.', '');
		$stmt->execute();
    }
    ################ AGREGAMOS EL INGRESO DE VENTAS PAGADAS A CAJA ################

    ########## AGREGAMOS EL INGRESO Y ABONOS DE VENTAS A CREDITOS A CAJA ##########
    if (limpiar($_POST["tipopago"]=="CREDITO" && $_POST["montoabono"]=="0.00" && $_POST["montoabono"]=="0")) {

		$sql = " UPDATE arqueocaja SET "
		." creditos = ? "
		." where "
		." codarqueo = ? and statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtTotal);
		$stmt->bindParam(2, $codarqueo);

		$txtTotal = number_format($_POST["txtTotal"]+$credito, 2, '.', '');
		$stmt->execute(); 

		$sql = " SELECT codcliente FROM creditosxclientes WHERE codcliente = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codcliente"],decrypt($_POST["codsucursal"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = "INSERT INTO creditosxclientes values (null, ?, ?, ?);";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codcliente);
			$stmt->bindParam(2, $montocredito);
			$stmt->bindParam(3, $codsucursal);

			$codcliente = limpiar($_POST["codcliente"]);
			$montocredito = number_format($_POST["txtTotal"]-$_POST["montoabono"], 2, '.', '');
			$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
			$stmt->execute();

		} else { 

			$sql = "UPDATE creditosxclientes set"
			." montocredito = ? "
			." where "
			." codcliente = ? AND codsucursal = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $montocredito);
			$stmt->bindParam(2, $codcliente);
			$stmt->bindParam(3, $codsucursal);

			$montocredito = number_format($montoactual+($_POST["txtTotal"]-$_POST["montoabono"]), 2, '.', '');
			$codcliente = limpiar($_POST["codcliente"]);
			$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
			$stmt->execute();
		}

	} else if (limpiar($_POST["tipopago"]=="CREDITO" && $_POST["montoabono"]!="0.00" && $_POST["montoabono"]!="0")) { 

		$sql = " UPDATE arqueocaja SET "
		." creditos = ?, "
		." abonos = ? "
		." where "
		." codarqueo = ? and statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtTotal);
		$stmt->bindParam(2, $totalabono);
		$stmt->bindParam(3, $codarqueo);

		$TotalCredito = number_format($_POST["txtTotal"]-$_POST["montoabono"], 2, '.', '');
		$txtTotal = number_format($TotalCredito+$credito, 2, '.', '');
		$totalabono = number_format($_POST["montoabono"]+$abono, 2, '.', '');
		$stmt->execute();

		$query = "INSERT INTO abonoscreditosventas values (null, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcaja);
		$stmt->bindParam(2, $codventa);
		$stmt->bindParam(3, $codcliente);
		$stmt->bindParam(4, $montoabono);
		$stmt->bindParam(5, $fechaabono);
		$stmt->bindParam(6, $codsucursal);

		$codcliente = limpiar($_POST["codcliente"]);
		$montoabono = number_format($_POST["montoabono"], 2, '.', '');
		$fechaabono = limpiar($fecha);
		$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
		$stmt->execute();

		$sql = " SELECT codcliente FROM creditosxclientes WHERE codcliente = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codcliente"],decrypt($_POST["codsucursal"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = "INSERT INTO creditosxclientes values (null, ?, ?, ?);";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codcliente);
			$stmt->bindParam(2, $montocredito);
			$stmt->bindParam(3, $codsucursal);

			$codcliente = limpiar($_POST["codcliente"]);
			$montocredito = number_format($_POST["txtTotal"]-$_POST["montoabono"], 2, '.', '');
			$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
			$stmt->execute();

		} else { 

			$sql = "UPDATE creditosxclientes set"
			." montocredito = ? "
			." where "
			." codcliente = ? AND codsucursal = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $montocredito);
			$stmt->bindParam(2, $codcliente);
			$stmt->bindParam(3, $codsucursal);

			$montocredito = number_format($montoactual+($_POST["txtTotal"]-$_POST["montoabono"]), 2, '.', '');
			$codcliente = limpiar($_POST["codcliente"]);
			$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
			$stmt->execute();
		}
	}
	########### AGREGAMOS EL INGRESO Y ABONOS DE VENTAS A CREDITOS A CAJA #########
	
	$sql = "DELETE FROM cotizaciones WHERE codcotizacion = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1,$codcotizacion);
	$stmt->bindParam(2,$codsucursal);
	$codcotizacion = decrypt($_POST["codcotizacion"]);
	$codsucursal = decrypt($_POST["codsucursal"]);
	$stmt->execute();

	$sql = "DELETE FROM detallecotizaciones WHERE codcotizacion = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(1,$codcotizacion);
	$stmt->bindParam(2,$codsucursal);
	$codcotizacion = decrypt($_POST["codcotizacion"]);
	$codsucursal = decrypt($_POST["codsucursal"]);
	$stmt->execute();

echo "<span class='fa fa-check-square-o'></span> LA COTIZACION HA SIDO PROCESADA COMO VENTA EXITOSAMENTE <a href='reportepdf?codventa=".encrypt($codventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt($tipodocumento)."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

echo "<script>window.open('reportepdf?codventa=".encrypt($codventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt($tipodocumento)."', '_blank');</script>";
	exit;
}
###################### FUNCION PROCESAR COTIZACIONES A VENTAS #################################

###################### FUNCION BUSQUEDA COTIZACIONES POR FECHAS ####################
public function BuscarCotizacionesxFechas() 
{
	self::SetNames();
	$sql ="SELECT 
	cotizaciones.idcotizacion, 
	cotizaciones.codcotizacion,
	cotizaciones.codfactura,
	cotizaciones.codcliente, 
	cotizaciones.subtotalivasi,
	cotizaciones.subtotalivano, 
	cotizaciones.iva,
	cotizaciones.totaliva, 
	cotizaciones.descontado,
	cotizaciones.descuento,
	cotizaciones.totaldescuento, 
	cotizaciones.totalpago, 
	cotizaciones.totalpago2,
	cotizaciones.observaciones,
	cotizaciones.fechacotizacion,
	cotizaciones.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	SUM(detallecotizaciones.cantcotizacion) as articulos 
	FROM (cotizaciones LEFT JOIN detallecotizaciones ON detallecotizaciones.codcotizacion = cotizaciones.codcotizacion)
	LEFT JOIN sucursales ON cotizaciones.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON cotizaciones.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON clientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON clientes.id_departamento = departamentos2.id_departamento
	LEFT JOIN usuarios ON cotizaciones.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
	WHERE cotizaciones.codsucursal = ? 
	AND DATE_FORMAT(cotizaciones.fechacotizacion,'%Y-%m-%d') BETWEEN ? AND ? 
	GROUP BY detallecotizaciones.codcotizacion";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COTIZACIONES PARA EL RANGO DE FECHA INGRESADO</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
################### FUNCION BUSQUEDA COTIZACIONES POR FECHAS ###################

###################### FUNCION BUSCAR DETALLES COTIZACIONES POR FECHAS #########################
public function BuscarDetallesCotizacionesxFechas() 
{
   self::SetNames();
   $sql ="SELECT 
   detallecotizaciones.idproducto,
   detallecotizaciones.codproducto,
   detallecotizaciones.producto,
   detallecotizaciones.codmarca,
   detallecotizaciones.codmodelo,
   detallecotizaciones.codpresentacion,
   detallecotizaciones.descproducto,
   detallecotizaciones.ivaproducto, 
   detallecotizaciones.precioventa,
   detallecotizaciones.tipodetalle, 
   productos.existencia,
   marcas.nommarca, 
   modelos.nommodelo, 
   cotizaciones.fechacotizacion, 
   sucursales.documsucursal, 
   sucursales.cuitsucursal, 
   sucursales.nomsucursal,
   sucursales.documencargado,
   sucursales.dniencargado,
   sucursales.nomencargado,
   sucursales.tlfsucursal,
   sucursales.direcsucursal,
   sucursales.correosucursal,
   sucursales.llevacontabilidad,
   sucursales.codmoneda,
   sucursales.codmoneda2,
   documentos.documento,
   documentos2.documento AS documento2,
   tiposmoneda.moneda,
   tiposmoneda.siglas,
   tiposmoneda.simbolo,
   tiposmoneda2.moneda AS moneda2,
   tiposmoneda2.siglas AS siglas2,
   tiposmoneda2.simbolo AS simbolo2,
   valor_cambio.montocambio,
   provincias.provincia,
   departamentos.departamento,
   documentos.documento,
   usuarios.dni,
   usuarios.nombres, 
   SUM(detallecotizaciones.cantcotizacion) as cantidad 
   FROM (cotizaciones INNER JOIN detallecotizaciones ON cotizaciones.codcotizacion = detallecotizaciones.codcotizacion) 
   LEFT JOIN productos ON detallecotizaciones.idproducto = productos.idproducto  
   LEFT JOIN marcas ON detallecotizaciones.codmarca = marcas.codmarca 
   LEFT JOIN modelos ON detallecotizaciones.codmodelo = modelos.codmodelo 
   LEFT JOIN sucursales ON cotizaciones.codsucursal = sucursales.codsucursal
   LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
   LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
   LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
   LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
   LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
   LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
   LEFT JOIN usuarios ON cotizaciones.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
   WHERE cotizaciones.codsucursal = '".decrypt($_GET['codsucursal'])."' 
   AND DATE_FORMAT(cotizaciones.fechacotizacion,'%Y-%m-%d') BETWEEN ? AND ? 
   GROUP BY detallecotizaciones.codproducto, detallecotizaciones.producto, detallecotizaciones.precioventa, detallecotizaciones.descproducto, detallecotizaciones.codsucursal
   ORDER BY detallecotizaciones.codproducto ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN PRODUCTOS COTIZADOS PARA EL RANGO DE FECHA INGRESADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################### FUNCION BUSCAR DETALLES COTIZACIONES POR FECHAS ###############################

###################### FUNCION BUSCAR DETALLES COTIZACIONES POR VENDEDOR #########################
public function BuscarDetallesCotizacionesxVendedor() 
{
   self::SetNames();
   $sql ="SELECT 
   detallecotizaciones.idproducto,
   detallecotizaciones.codproducto,
   detallecotizaciones.producto,
   detallecotizaciones.codmarca,
   detallecotizaciones.codmodelo,
   detallecotizaciones.codpresentacion,
   detallecotizaciones.descproducto,
   detallecotizaciones.ivaproducto, 
   detallecotizaciones.precioventa,
   detallecotizaciones.tipodetalle, 
   productos.existencia,
   marcas.nommarca, 
   modelos.nommodelo, 
   cotizaciones.fechacotizacion, 
   sucursales.documsucursal, 
   sucursales.cuitsucursal, 
   sucursales.nomsucursal,
   sucursales.documencargado,
   sucursales.dniencargado,
   sucursales.nomencargado,
   sucursales.tlfsucursal,
   sucursales.direcsucursal,
   sucursales.correosucursal,
   sucursales.llevacontabilidad,
   sucursales.codmoneda,
   sucursales.codmoneda2,
   documentos.documento,
   documentos2.documento AS documento2,
   tiposmoneda.moneda,
   tiposmoneda.siglas,
   tiposmoneda.simbolo,
   tiposmoneda2.moneda AS moneda2,
   tiposmoneda2.siglas AS siglas2,
   tiposmoneda2.simbolo AS simbolo2,
   valor_cambio.montocambio,
   provincias.provincia,
   departamentos.departamento,
   usuarios.dni,
   usuarios.nombres, 
   SUM(detallecotizaciones.cantcotizacion) as cantidad 
   FROM (cotizaciones INNER JOIN detallecotizaciones ON cotizaciones.codcotizacion = detallecotizaciones.codcotizacion)
   LEFT JOIN productos ON detallecotizaciones.idproducto = productos.idproducto  
   LEFT JOIN marcas ON detallecotizaciones.codmarca = marcas.codmarca 
   LEFT JOIN modelos ON detallecotizaciones.codmodelo = modelos.codmodelo 
   LEFT JOIN sucursales ON cotizaciones.codsucursal = sucursales.codsucursal
   LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
   LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
   LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
   LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
   LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
   LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
   LEFT JOIN usuarios ON cotizaciones.codigo = usuarios.codigo 
   LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
   WHERE cotizaciones.codsucursal = '".decrypt($_GET['codsucursal'])."' 
   AND cotizaciones.codigo = ? 
   AND DATE_FORMAT(cotizaciones.fechacotizacion,'%Y-%m-%d') BETWEEN ? AND ? 
   GROUP BY detallecotizaciones.codproducto, detallecotizaciones.producto, detallecotizaciones.precioventa, detallecotizaciones.descproducto, detallecotizaciones.codsucursal
   ORDER BY detallecotizaciones.codproducto ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_GET['codigo']));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN PRODUCTOS FACTURADOS PARA EL VENDEDOR Y RANGO DE FECHA INGRESADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################### FUNCION BUSCAR DETALLES COTIZACIONES POR VENDEDOR ###############################

########################### FIN DE CLASE COTIZACIONES ############################





























############################## CLASE PREVENTAS ###################################

########################### FUNCION REGISTRAR PREVENTAS ##########################
public function RegistrarPreventas()
{
	self::SetNames();
	if(empty($_POST["codsucursal"]) or empty($_POST["txtTotal"]))
	{
		echo "1";
		exit;
	}
	elseif(empty($_SESSION["CarritoPreventa"]))
	{
		echo "2";
		exit;
	}

	$v = $_SESSION["CarritoPreventa"];
	for($i=0;$i<count($v);$i++){

	    if($v[$i]['tipodetalle'] == 1){ 

	    $sql = "SELECT existencia FROM productos 
	    WHERE codproducto = '".$v[$i]['txtCodigo']."' 
	    AND codsucursal = '".limpiar($_POST["codsucursal"])."'";
	    foreach ($this->dbh->query($sql) as $row)
	    {
		$this->p[] = $row;
	    }
	
	    $existenciadb = $row['existencia'];
	    $cantidad = $v[$i]['cantidad'];

	        if ($cantidad > $existenciadb) 
	        { 
		       echo "3";
		       exit;
	        }
        }
	}

	################# OBTENGO DATOS DE SUCURSAL #################
	$sql = " SELECT 
	codsucursal, 
	nroactividadsucursal, 
	iniciofactura 
	FROM sucursales WHERE codsucursal = '".limpiar($_POST["codsucursal"])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$nroactividad = $row['nroactividadsucursal'];
	$iniciofactura = $row['iniciofactura'];
	################# OBTENGO DATOS DE SUCURSAL #################

	################ CREO CODIGO DE PREVENTA ####################
	$sql = "SELECT codpreventa FROM preventas 
	ORDER BY idpreventa DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$preventa=$row["codpreventa"];

	}
	if(empty($preventa))
	{
		$codpreventa = "01";

	} else {

		$num = substr($preventa, 0);
        $dig = $num + 1;
        $codigofinal = str_pad($dig, 2, "0", STR_PAD_LEFT);
        $codpreventa = $codigofinal;
	}
    ################ CREO CODIGO DE PREVENTA ###############

	################### CREO CODIGO DE FACTURA ####################
	$sql4 = "SELECT codfactura FROM preventas 
	WHERE codsucursal = '".limpiar($_POST["codsucursal"])."' 
	ORDER BY idpreventa DESC LIMIT 1";
	 foreach ($this->dbh->query($sql4) as $row4){

		$factura=$row4["codfactura"];

	}
	if(empty($factura))
	{
		$codfactura = $nroactividad.'-'.$iniciofactura;

	} else {

		$var = strlen($nroactividad."-");
        $var1 = substr($factura , $var);
        $var2 = strlen($var1);
        $var3 = $var1 + 1;
        $var4 = str_pad($var3, $var2, "0", STR_PAD_LEFT);
        $codfactura = $nroactividad.'-'.$var4;
	}
    ################### CREO LOS CODIGO DE PREVENTA ####################

    $query = "INSERT INTO preventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codpreventa);
	$stmt->bindParam(2, $codfactura);
	$stmt->bindParam(3, $codcliente);
	$stmt->bindParam(4, $subtotalivasi);
	$stmt->bindParam(5, $subtotalivano);
	$stmt->bindParam(6, $iva);
	$stmt->bindParam(7, $totaliva);
	$stmt->bindParam(8, $descontado);
	$stmt->bindParam(9, $descuento);
	$stmt->bindParam(10, $totaldescuento);
	$stmt->bindParam(11, $totalpago);
	$stmt->bindParam(12, $totalpago2);
	$stmt->bindParam(13, $observaciones);
	$stmt->bindParam(14, $fechapreventa);
	$stmt->bindParam(15, $codigo);
	$stmt->bindParam(16, $codsucursal);
    
	$codcliente = limpiar($_POST["codcliente"]);
	$subtotalivasi = limpiar($_POST["txtsubtotal"]);
	$subtotalivano = limpiar($_POST["txtsubtotal2"]);
	$iva = limpiar($_POST["iva"]);
	$totaliva = limpiar($_POST["txtIva"]);
	$descontado = limpiar($_POST["txtdescontado"]);
	$descuento = limpiar($_POST["descuento"]);
	$totaldescuento = limpiar($_POST["txtDescuento"]);
	$totalpago = limpiar($_POST["txtTotal"]);
	$totalpago2 = limpiar($_POST["txtTotalCompra"]);
	$observaciones = limpiar($_POST["observaciones"]);
    $fechapreventa = limpiar(date("Y-m-d H:i:s"));
	$codigo = limpiar($_SESSION["codigo"]);
	$codsucursal = limpiar($_POST["codsucursal"]);
	$stmt->execute();
	
	$this->dbh->beginTransaction();
	$detalle = $_SESSION["CarritoPreventa"];
	for($i=0;$i<count($detalle);$i++){

	$query = "INSERT INTO detallepreventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codpreventa);
	$stmt->bindParam(2, $idproducto);
    $stmt->bindParam(3, $codproducto);
    $stmt->bindParam(4, $producto);
    $stmt->bindParam(5, $codmarca);
    $stmt->bindParam(6, $codmodelo);
    $stmt->bindParam(7, $codpresentacion);
	$stmt->bindParam(8, $cantidad);
	$stmt->bindParam(9, $preciocompra);
	$stmt->bindParam(10, $precioventa);
	$stmt->bindParam(11, $ivaproducto);
	$stmt->bindParam(12, $descproducto);
	$stmt->bindParam(13, $valortotal);
	$stmt->bindParam(14, $totaldescuentov);
	$stmt->bindParam(15, $valorneto);
	$stmt->bindParam(16, $valorneto2);
	$stmt->bindParam(17, $tipodetalle);
	$stmt->bindParam(18, $codsucursal);
		
    $idproducto = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['id'] : "0");
	$codproducto = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['txtCodigo'] : "0");
	$producto = limpiar($detalle[$i]['producto']);
	$codmarca = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['codmarca'] : "0");
	$codmodelo = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['codmodelo'] : "0");
	$codpresentacion = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['codpresentacion'] : "0");
	$cantidad = limpiar($detalle[$i]['cantidad']);
	$preciocompra = limpiar($detalle[$i]['precio']);
	$precioventa = limpiar($detalle[$i]['precio2']);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$descuento = $detalle[$i]['descproducto']/100;
	$valortotal = number_format($detalle[$i]['precio2']*$detalle[$i]['cantidad'], 2, '.', '');
	$totaldescuentov = number_format($valortotal*$descuento, 2, '.', '');
    $valorneto = number_format($valortotal-$totaldescuentov, 2, '.', '');
	$valorneto2 = limpiar($detalle[$i]['tipodetalle'] == "1" ? number_format($detalle[$i]['precio']*$detalle[$i]['cantidad'], 2, '.', '') : "0.00");
	$tipodetalle = limpiar($detalle[$i]['tipodetalle']);
	$codsucursal = limpiar($_POST["codsucursal"]);
	$stmt->execute();

	if(limpiar($detalle[$i]['tipodetalle'])==1){

    ################ VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ################
	$sql = "SELECT * FROM productos 
	WHERE codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' 
	AND codsucursal = '".limpiar($_POST['codsucursal'])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$existenciabd = $row['existencia'];
    ################ VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ################

    ##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
	$sql = " UPDATE productos set "
	." existencia = ? "
	." where "
	." codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' 
	AND codsucursal = '".limpiar($_POST["codsucursal"])."';
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $existencia);

	$existencia = $existenciabd-$detalle[$i]['cantidad'];
	$stmt->execute();
    ##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
    	
    }

	################ REGISTRAMOS LOS PRODUCTOS SALIENTES EN KARDEX #################
    $query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codpreventa);
	$stmt->bindParam(2, $codresponsable);
	$stmt->bindParam(3, $codproducto);
	$stmt->bindParam(4, $movimiento);
	$stmt->bindParam(5, $entradas);
	$stmt->bindParam(6, $salidas);
	$stmt->bindParam(7, $devolucion);
	$stmt->bindParam(8, $stockactual);
	$stmt->bindParam(9, $ivaproducto);
	$stmt->bindParam(10, $descproducto);
	$stmt->bindParam(11, $precio);
	$stmt->bindParam(12, $documento);
	$stmt->bindParam(13, $fechakardex);
	$stmt->bindParam(14, $tipodetalle);		
	$stmt->bindParam(15, $codsucursal);

	$codresponsable = limpiar($_POST["codcliente"]);
	$codproducto = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['txtCodigo'] : "0");
	$movimiento = limpiar("SALIDAS");
	$entradas = limpiar("0");
	$salidas= limpiar($detalle[$i]['cantidad']);
	$devolucion = limpiar("0");
	$stockactual = limpiar($detalle[$i]['tipodetalle'] == 1 ? $existenciabd-$detalle[$i]['cantidad'] : "0");
	$precio = limpiar($detalle[$i]["precio2"]);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$documento = limpiar("PREVENTA: ".$codpreventa);
	$fechakardex = limpiar(date("Y-m-d"));
	$tipodetalle = limpiar($detalle[$i]['tipodetalle']);
	$codsucursal = limpiar($_POST["codsucursal"]);
	$stmt->execute();
	################ REGISTRAMOS LOS PRODUCTOS SALIENTES EN KARDEX #################

    }
        
    ####################### DESTRUYO LA VARIABLE DE SESSION #####################
	unset($_SESSION["CarritoPreventa"]);
    $this->dbh->commit();
		
echo "<span class='fa fa-check-square-o'></span> LA PREVENTA DE PRODUCTOS HA SIDO REGISTRADA EXITOSAMENTE <a href='reportepdf?codpreventa=".encrypt($codpreventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("TICKETPREVENTA")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

echo "<script>window.open('reportepdf?codpreventa=".encrypt($codpreventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("TICKETPREVENTA")."', '_blank');</script>";
	exit;
}
########################## FUNCION REGISTRAR PREVENTAS ############################

####################### FUNCION LISTAR PREVENTAS ################################
public function ListarPreventas()
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT 
	preventas.idpreventa, 
	preventas.codpreventa,
	preventas.codfactura, 
	preventas.codcliente, 
	preventas.subtotalivasi, 
	preventas.subtotalivano, 
	preventas.iva, 
	preventas.totaliva,  
	preventas.descontado,
	preventas.descuento, 
	preventas.totaldescuento,
	preventas.totalpago, 
	preventas.totalpago2, 
	preventas.observaciones,
	preventas.fechapreventa, 
	preventas.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,  
	SUM(detallepreventas.cantpreventa) AS articulos 
	FROM (preventas LEFT JOIN detallepreventas ON detallepreventas.codpreventa = preventas.codpreventa) 
	LEFT JOIN sucursales ON preventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON preventas.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN usuarios ON preventas.codigo = usuarios.codigo 
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
	GROUP BY detallepreventas.codpreventa 
	ORDER BY preventas.idpreventa ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

     } else if($_SESSION["acceso"] == "cajero") {

     $sql = "SELECT 
	preventas.idpreventa, 
	preventas.codpreventa,
	preventas.codfactura, 
	preventas.codcliente, 
	preventas.subtotalivasi, 
	preventas.subtotalivano, 
	preventas.iva, 
	preventas.totaliva,  
	preventas.descontado,
	preventas.descuento, 
	preventas.totaldescuento,
	preventas.totalpago, 
	preventas.totalpago2, 
	preventas.observaciones,
	preventas.fechapreventa, 
	preventas.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,  
	SUM(detallepreventas.cantpreventa) AS articulos 
	FROM (preventas LEFT JOIN detallepreventas ON detallepreventas.codpreventa = preventas.codpreventa) 
	LEFT JOIN sucursales ON preventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON preventas.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN usuarios ON preventas.codigo = usuarios.codigo 
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
	WHERE preventas.codigo = '".limpiar($_SESSION["codigo"])."' 
	GROUP BY detallepreventas.codpreventa 
	ORDER BY preventas.idpreventa ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	    return $this->p;
		$this->dbh=null;

	} else {

	$sql = "SELECT 
	preventas.idpreventa, 
	preventas.codpreventa,
	preventas.codfactura, 
	preventas.codcliente, 
	preventas.subtotalivasi, 
	preventas.subtotalivano, 
	preventas.iva, 
	preventas.totaliva,  
	preventas.descontado,
	preventas.descuento, 
	preventas.totaldescuento,
	preventas.totalpago, 
	preventas.totalpago2, 
	preventas.observaciones,
	preventas.fechapreventa, 
	preventas.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,  
	SUM(detallepreventas.cantpreventa) AS articulos 
	FROM (preventas LEFT JOIN detallepreventas ON detallepreventas.codpreventa = preventas.codpreventa) 
	LEFT JOIN sucursales ON preventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON preventas.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN usuarios ON preventas.codigo = usuarios.codigo 
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
	WHERE preventas.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
	GROUP BY detallepreventas.codpreventa
	ORDER BY preventas.idpreventa ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

    }
}
######################### FUNCION LISTAR PREVENTAS ############################


####################### FUNCION LISTAR CLIENTES CON PREVENTAS ################################
public function ListarClientesxPreventas()
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT 
	preventas.idpreventa, 
	preventas.codpreventa,
	preventas.codfactura, 
	preventas.codcliente, 
	preventas.subtotalivasi, 
	preventas.subtotalivano, 
	preventas.iva, 
	preventas.totaliva,  
	preventas.descontado,
	preventas.descuento, 
	preventas.totaldescuento,
	preventas.totalpago, 
	preventas.totalpago2, 
	preventas.observaciones,
	preventas.fechapreventa, 
	preventas.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,  
	SUM(detallepreventas.cantpreventa) AS articulos 
	FROM (preventas LEFT JOIN detallepreventas ON detallepreventas.codpreventa = preventas.codpreventa) 
	LEFT JOIN sucursales ON preventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	INNER JOIN clientes ON preventas.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON clientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON clientes.id_departamento = departamentos2.id_departamento
	LEFT JOIN usuarios ON preventas.codigo = usuarios.codigo 
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
	GROUP BY detallepreventas.codpreventa 
	ORDER BY preventas.idpreventa ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

     } else if($_SESSION["acceso"] == "cajero") {

     $sql = "SELECT 
	preventas.idpreventa, 
	preventas.codpreventa,
	preventas.codfactura, 
	preventas.codcliente, 
	preventas.subtotalivasi, 
	preventas.subtotalivano, 
	preventas.iva, 
	preventas.totaliva,  
	preventas.descontado,
	preventas.descuento, 
	preventas.totaldescuento,
	preventas.totalpago, 
	preventas.totalpago2, 
	preventas.observaciones,
	preventas.fechapreventa, 
	preventas.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,  
	SUM(detallepreventas.cantpreventa) AS articulos 
	FROM (preventas LEFT JOIN detallepreventas ON detallepreventas.codpreventa = preventas.codpreventa) 
	LEFT JOIN sucursales ON preventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	INNER JOIN clientes ON preventas.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON clientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON clientes.id_departamento = departamentos2.id_departamento
	LEFT JOIN usuarios ON preventas.codigo = usuarios.codigo 
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
	WHERE preventas.codigo = '".limpiar($_SESSION["codigo"])."' 
	GROUP BY detallepreventas.codpreventa 
	ORDER BY preventas.idpreventa ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	    return $this->p;
		$this->dbh=null;

	} else {

	$sql = "SELECT 
	preventas.idpreventa, 
	preventas.codpreventa,
	preventas.codfactura, 
	preventas.codcliente, 
	preventas.subtotalivasi, 
	preventas.subtotalivano, 
	preventas.iva, 
	preventas.totaliva,  
	preventas.descontado,
	preventas.descuento, 
	preventas.totaldescuento,
	preventas.totalpago, 
	preventas.totalpago2, 
	preventas.observaciones,
	preventas.fechapreventa, 
	preventas.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2, 
	SUM(detallepreventas.cantpreventa) AS articulos 
	FROM (preventas LEFT JOIN detallepreventas ON detallepreventas.codpreventa = preventas.codpreventa) 
	LEFT JOIN sucursales ON preventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	INNER JOIN clientes ON preventas.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON clientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON clientes.id_departamento = departamentos2.id_departamento
	LEFT JOIN usuarios ON preventas.codigo = usuarios.codigo 
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
	WHERE preventas.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
	GROUP BY detallepreventas.codpreventa
	ORDER BY preventas.idpreventa ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

    }
}
######################### FUNCION LISTAR CLIENETS CON PREVENTAS ############################

############################ FUNCION ID PREVENTAS #################################
public function PreventasPorId()
{
	self::SetNames();
	$sql = " SELECT 
	preventas.idpreventa, 
	preventas.codpreventa,
	preventas.codfactura, 
	preventas.codcliente, 
	preventas.subtotalivasi,
	preventas.subtotalivano, 
	preventas.iva,
	preventas.totaliva,
	preventas.descontado, 
	preventas.descuento,
	preventas.totaldescuento, 
	preventas.totalpago, 
	preventas.totalpago2,
    preventas.observaciones,
	preventas.fechapreventa,
	preventas.codsucursal, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.tlfsucursal,
	sucursales.correosucursal,
	sucursales.id_provincia,
	sucursales.id_departamento,
	sucursales.direcsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia AS id_provincia2, 
	clientes.id_departamento AS id_departamento2,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	usuarios.dni, 
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2
	FROM (preventas INNER JOIN sucursales ON preventas.codsucursal = sucursales.codsucursal)
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON preventas.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON clientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON clientes.id_departamento = departamentos2.id_departamento
	LEFT JOIN usuarios ON preventas.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
	WHERE preventas.codpreventa = ? AND preventas.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codpreventa"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID PREVENTAS #################################
	
######################## FUNCION VER DETALLES PREVENTAS ############################
public function VerDetallesPreventas()
	{
	self::SetNames();
	$sql = "SELECT
	detallepreventas.coddetallepreventa,
	detallepreventas.codpreventa,
	detallepreventas.coddetallepreventa,
	detallepreventas.idproducto,
	detallepreventas.codproducto,
	detallepreventas.producto,
	detallepreventas.codmarca,
	detallepreventas.codmodelo,
	detallepreventas.codpresentacion,
	detallepreventas.cantpreventa,
	detallepreventas.preciocompra,
	detallepreventas.precioventa,
	detallepreventas.ivaproducto,
	detallepreventas.descproducto,
	detallepreventas.valortotal, 
	detallepreventas.totaldescuentov,
	detallepreventas.valorneto,
	detallepreventas.valorneto2,
	detallepreventas.tipodetalle,
	detallepreventas.codsucursal,
	marcas.nommarca,
	modelos.nommodelo,
	presentaciones.nompresentacion
	FROM detallepreventas 
	LEFT JOIN marcas ON detallepreventas.codmarca = marcas.codmarca
	LEFT JOIN modelos ON detallepreventas.codmodelo = modelos.codmodelo 
	LEFT JOIN presentaciones ON detallepreventas.codpresentacion = presentaciones.codpresentacion
	WHERE detallepreventas.codpreventa = ? AND detallepreventas.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codpreventa"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$this->p[]=$row;
	}
	return $this->p;
	$this->dbh=null;
}
##################### FUNCION VER DETALLES PREVENTAS #########################

######################## FUNCION ACTUALIZAR PREVENTAS #######################
public function ActualizarPreventas()
{
	self::SetNames();
	if(empty($_POST["codpreventa"]) or empty($_POST["codsucursal"]))
	{
		echo "1";
		exit;
	}

	for($i=0;$i<count($_POST['coddetallepreventa']);$i++){  //recorro el array
        if (!empty($_POST['coddetallepreventa'][$i])) {

	       if($_POST['cantpreventa'][$i]==0){

		      echo "2";
		      exit();

	       }
        }
    }

	$this->dbh->beginTransaction();
	for($i=0;$i<count($_POST['coddetallepreventa']);$i++){  //recorro el array
	if (!empty($_POST['coddetallepreventa'][$i])) {

	$sql = "SELECT 
	cantpreventa 
	FROM detallepreventas 
	WHERE coddetallepreventa = '".limpiar($_POST['coddetallepreventa'][$i])."' 
	AND codpreventa = '".limpiar($_POST["codpreventa"])."' 
	AND codsucursal = '".limpiar($_POST["codsucursal"])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
		
		$cantidadbd = $row['cantpreventa'];

		if($cantidadbd != $_POST['cantpreventa'][$i]){

		if($_POST['tipodetalle'][$i] == 1){

		############ CONSULTO LA EXISTENCIA DE PRODUCTO EN ALMACEN SALIENTE ############
		$sql = "SELECT 
		existencia 
		FROM productos 
		WHERE codproducto = '".limpiar($_POST['codproducto'][$i])."' 
		AND codsucursal = '".limpiar($_POST["codsucursal"])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$existenciabd = $row['existencia'];
		$cantidad = $_POST["cantpreventa"][$i];
		$cantidadbd = $_POST["cantpreventabd"][$i];
		$totalpreventa = $cantidad-$cantidadbd;

        if ($totalpreventa > $existenciabd) 
        { 
		    echo "3";
		    exit;
	    }
	    ############ CONSULTO LA EXISTENCIA DE PRODUCTO EN ALMACEN SALIENTE ############

	    ############## ACTUALIZAMOS EXISTENCIA DEL PRODUCTO EN ALMACEN #1 ##############
		$sql2 = " UPDATE productos set "
		." existencia = ? "
		." WHERE "
		." codproducto = '".limpiar($_POST["codproducto"][$i])."' 
		AND codsucursal = '".limpiar($_POST["codsucursal"])."';
		";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->bindParam(1, $existencia);
		$existencia = $existenciabd-$totalpreventa;
		$stmt->execute();
	    ############## ACTUALIZAMOS EXISTENCIA DEL PRODUCTO EN ALMACEN #1 ##############

	    }

		$query = "UPDATE detallepreventas set"
		." cantpreventa = ?, "
		." valortotal = ?, "
		." totaldescuentov = ?, "
		." valorneto = ?, "
		." valorneto2 = ? "
		." WHERE "
		." coddetallepreventa = ? AND codpreventa = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $cantpreventa);
		$stmt->bindParam(2, $valortotal);
		$stmt->bindParam(3, $totaldescuentov);
		$stmt->bindParam(4, $valorneto);
		$stmt->bindParam(5, $valorneto2);
		$stmt->bindParam(6, $coddetallepreventa);
		$stmt->bindParam(7, $codpreventa);
		$stmt->bindParam(8, $codsucursal);

		$cantpreventa = limpiar($_POST['cantpreventa'][$i]);
		$preciocompra = limpiar($_POST['preciocompra'][$i]);
		$precioventa = limpiar($_POST['precioventa'][$i]);
		$ivaproducto = limpiar($_POST['ivaproducto'][$i]);
		$descuento = $_POST['descproducto'][$i]/100;
		$valortotal = number_format($_POST['valortotal'][$i], 2, '.', '');
		$totaldescuento = number_format($_POST['totaldescuentov'][$i], 2, '.', '');
		$valorneto = number_format($_POST['valorneto'][$i], 2, '.', '');
		$valorneto2 = number_format($_POST['valorneto2'][$i], 2, '.', '');
		$coddetallepreventa = limpiar($_POST['coddetallepreventa'][$i]);
		$codpreventa = limpiar($_POST["codpreventa"]);
		$codsucursal = limpiar($_POST["codsucursal"]);
		$stmt->execute();

		############### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX #1 ###############
		$sql3 = " UPDATE kardex set "
		." salidas = ?, "
		." stockactual = ? "
		." WHERE "
		." codproceso = '".limpiar($_POST["codpreventa"])."' 
		AND codproducto = '".limpiar($_POST["codproducto"][$i])."' 
		AND codsucursal = '".limpiar($_POST["codsucursal"])."';
		";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->bindParam(1, $salidas);
		$stmt->bindParam(2, $existencia);
		
		$existencia = ($_POST["tipodetalle"][$i] == 1 ? $existenciabd-$totalpreventa : "0");
		$salidas = limpiar($_POST["cantpreventa"][$i]);
		$stmt->execute();

			} else {

               echo "";

		       }
	        }
        }
        $this->dbh->commit();

       ############ ACTUALIZO LOS TOTALES EN LA PREVENTA ##############
		$sql = " UPDATE preventas SET "
		." codcliente = ?, "
		." observaciones = ?, "
		." subtotalivasi = ?, "
		." subtotalivano = ?, "
		." totaliva = ?, "
		." descontado = ?, "
		." descuento = ?, "
		." totaldescuento = ?, "
		." totalpago = ?, "
		." totalpago2= ? "
		." WHERE "
		." codpreventa = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $codcliente);
		$stmt->bindParam(2, $observaciones);
		$stmt->bindParam(3, $subtotalivasi);
		$stmt->bindParam(4, $subtotalivano);
		$stmt->bindParam(5, $totaliva);
		$stmt->bindParam(6, $descontado);
		$stmt->bindParam(7, $descuento);
		$stmt->bindParam(8, $totaldescuento);
		$stmt->bindParam(9, $totalpago);
		$stmt->bindParam(10, $totalpago2);
		$stmt->bindParam(11, $codpreventa);
		$stmt->bindParam(12, $codsucursal);

		$codcliente = limpiar($_POST["codcliente"]);
		$observaciones = limpiar($_POST["observaciones"]);
		$subtotalivasi = number_format($_POST["txtsubtotal"], 2, '.', '');
		$subtotalivano = number_format($_POST["txtsubtotal2"], 2, '.', '');
		$totaliva = number_format($_POST["txtIva"], 2, '.', '');
		$descontado = number_format($_POST["txtdescontado"], 2, '.', '');
		$descuento = limpiar($_POST["descuento"]);
		$totaldescuento = number_format($_POST["txtDescuento"], 2, '.', '');
		$totalpago = number_format($_POST["txtTotal"], 2, '.', '');
		$totalpago2 = number_format($_POST["txtTotalCompra"], 2, '.', '');
		$codpreventa = limpiar($_POST["codpreventa"]);
		$codsucursal = limpiar($_POST["codsucursal"]);
		$stmt->execute();
		############ ACTUALIZO LOS TOTALES EN LA PREVENTA ##############

echo "<span class='fa fa-check-square-o'></span> LA PREVENTA DE PRODUCTOS HA SIDO ACTUALIZADA EXITOSAMENTE <a href='reportepdf?codpreventa=".encrypt($codpreventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("TICKETPREVENTA")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

echo "<script>window.open('reportepdf?codpreventa=".encrypt($codpreventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("TICKETPREVENTA")."', '_blank');</script>";
	exit;
}
####################### FUNCION ACTUALIZAR PREVENTAS ############################

####################### FUNCION AGREGAR DETALLES PREVENTAS ########################
public function AgregarDetallesPreventas()
{
	self::SetNames();
	if(empty($_POST["codpreventa"]) or empty($_POST["codsucursal"]))
	{
		echo "1";
		exit;
	}
    elseif(empty($_SESSION["CarritoPreventa"]) || $_POST["txtTotal"]=="0.00")
	{
		echo "2";
		exit;
		
	}

    $this->dbh->beginTransaction();
    $detalle = $_SESSION["CarritoPreventa"];
	for($i=0;$i<count($detalle);$i++){

	############# REVISAMOS QUE LA CANTIDAD NO SEA IGUAL A CERO ##############
	if($detalle[$i]['cantidad']==0)
	{
		echo "3";
		exit;
	}
	############# REVISAMOS QUE LA CANTIDAD NO SEA IGUAL A CERO ##############

	if(limpiar($detalle[$i]['tipodetalle']) == 1){
	    ############### VERIFICO AL EXISTENCIA DEL PRODUCTO AGREGADO ################
		$sql = "SELECT * FROM productos 
		WHERE codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' 
		AND codsucursal = '".limpiar($_POST["codsucursal"])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}

		$existenciabd = $row['existencia'];
		############### VERIFICO AL EXISTENCIA DEL PRODUCTO AGREGADO ################

		############ REVISAMOS SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #######
	    if ($detalle[$i]['cantidad'] > $existenciabd) 
	    { 
		    echo "4";
		    exit;
	    }
	    ############ REVISAMOS SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #######
	}

	$sql = "SELECT 
	codpreventa, 
	codproducto 
	FROM detallepreventas 
	WHERE codpreventa = '".limpiar($_POST['codpreventa'])."' 
	AND codsucursal = '".limpiar($_POST['codsucursal'])."' 
	AND codproducto = '".limpiar($detalle[$i]['txtCodigo'])."'";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num == 0)
	{

        $query = "INSERT INTO detallepreventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codpreventa);
	    $stmt->bindParam(2, $idproducto);
	    $stmt->bindParam(3, $codproducto);
	    $stmt->bindParam(4, $producto);
	    $stmt->bindParam(5, $codmarca);
	    $stmt->bindParam(6, $codmodelo);
	    $stmt->bindParam(7, $codpresentacion);
		$stmt->bindParam(8, $cantidad);
		$stmt->bindParam(9, $preciocompra);
		$stmt->bindParam(10, $precioventa);
		$stmt->bindParam(11, $ivaproducto);
		$stmt->bindParam(12, $descproducto);
		$stmt->bindParam(13, $valortotal);
		$stmt->bindParam(14, $totaldescuentov);
		$stmt->bindParam(15, $valorneto);
		$stmt->bindParam(16, $valorneto2);
		$stmt->bindParam(17, $tipodetalle);
		$stmt->bindParam(18, $codsucursal);
			
		$codpreventa = limpiar($_POST["codpreventa"]);
		$idproducto = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['id'] : "0");
		$codproducto = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['txtCodigo'] : "0");
		$producto = limpiar($detalle[$i]['producto']);
	    $codmarca = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['codmarca'] : "0");
		$codmodelo = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['codmodelo'] : "0");
		$codpresentacion = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['codpresentacion'] : "0");
		$cantidad = limpiar($detalle[$i]['cantidad']);
		$preciocompra = limpiar($detalle[$i]['precio']);
		$precioventa = limpiar($detalle[$i]['precio2']);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$descuento = $detalle[$i]['descproducto']/100;
		$valortotal = number_format($detalle[$i]['precio2']*$detalle[$i]['cantidad'], 2, '.', '');
		$totaldescuentov = number_format($valortotal*$descuento, 2, '.', '');
	    $valorneto = number_format($valortotal-$totaldescuentov, 2, '.', '');
		$valorneto2 = limpiar($detalle[$i]['tipodetalle'] == "1" ? number_format($detalle[$i]['precio']*$detalle[$i]['cantidad'], 2, '.', '') : "0.00");
		$tipodetalle = limpiar($detalle[$i]['tipodetalle']);
		$codsucursal = limpiar($_SESSION["codsucursal"]);
		$stmt->execute();

	    if(limpiar($detalle[$i]['tipodetalle']) == 1){

	    ##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ###################
		$sql = " UPDATE productos set "
		." existencia = ? "
		." where "
		." codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' 
		AND codsucursal = '".limpiar($_POST["codsucursal"])."';
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$cantpreventa = limpiar($detalle[$i]['cantidad']);
		$existencia = $existenciabd-$cantpreventa;
		$stmt->execute();
		##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ###################
	    }

		############### REGISTRAMOS LOS PRODUCTOS SALIENTES EN KARDEX #1 ###############
        $query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codpreventa);
		$stmt->bindParam(2, $codresponsable);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);	
		$stmt->bindParam(14, $tipokardex);	
		$stmt->bindParam(15, $codsucursal);

		$codresponsable = limpiar($_POST["codcliente"]);
		$codproducto = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['txtCodigo'] : "0");
		$movimiento = limpiar("SALIDAS");
		$entradas = limpiar("0");
		$salidas= limpiar($detalle[$i]['cantidad']);
		$devolucion = limpiar("0");
		$stockactual = limpiar($detalle[$i]['tipodetalle'] == 1 ? $existenciabd-$detalle[$i]['cantidad'] : "0");
		$precio = limpiar($detalle[$i]["precio2"]);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$documento = limpiar("PREVENTA: ".$codpreventa);
		$fechakardex = limpiar(date("Y-m-d"));
		$tipokardex = limpiar($detalle[$i]['tipodetalle']);
		$codsucursal = limpiar($_POST["codsucursal"]);
		$stmt->execute();

	  } else {

	  	$sql = "SELECT cantpreventa 
	  	FROM detallepreventas 
	  	WHERE codpreventa = '".limpiar($_POST['codpreventa'])."' 
	  	AND codsucursal = '".limpiar($_POST['codsucursal'])."' 
	  	AND codproducto = '".limpiar($detalle[$i]['txtCodigo'])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$cantidad = $row['cantpreventa'];

	  	$query = "UPDATE detallepreventas set"
		." cantpreventa = ?, "
		." descproducto = ?, "
		." valortotal = ?, "
		." totaldescuentov = ?, "
		." valorneto = ?, "
		." valorneto2 = ? "
		." WHERE "
		." codpreventa = ? AND codsucursal = ? AND codproducto = ?;
		";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $cantpreventa);
		$stmt->bindParam(2, $descproducto);
		$stmt->bindParam(3, $valortotal);
		$stmt->bindParam(4, $totaldescuentov);
		$stmt->bindParam(5, $valorneto);
		$stmt->bindParam(6, $valorneto2);
		$stmt->bindParam(7, $codpreventa);
		$stmt->bindParam(8, $codsucursal);
		$stmt->bindParam(9, $codproducto);

		$cantpreventa = limpiar($detalle[$i]['cantidad']+$cantidad);
		$preciocompra = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['precio'] : "0.00");
		$precioventa = limpiar($detalle[$i]['precio2']);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$descuento = $detalle[$i]['descproducto']/100;
		$valortotal = number_format($detalle[$i]['precio2'] * $cantpreventa, 2, '.', '');
		$totaldescuentov = number_format($valortotal * $descuento, 2, '.', '');
		$valorneto = number_format($valortotal - $totaldescuentov, 2, '.', '');
		$valorneto2 = limpiar($detalle[$i]['tipodetalle'] == "1" ? number_format($detalle[$i]['precio']*$cantpreventa, 2, '.', '') : "0.00");
		$codpreventa = limpiar($_POST["codpreventa"]);
		$codsucursal = limpiar($_POST["codsucursal"]);
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$stmt->execute();

		if($detalle[$i]['tipodetalle'] == 1){ 

		############## ACTUALIZAMOS EXISTENCIA DEL PRODUCTO EN ALMACEN ##############
		$sql = " UPDATE productos set "
			  ." existencia = ? "
			  ." where "
			  ." codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' and codsucursal = '".limpiar($_POST["codsucursal"])."';
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$cantpreventa = limpiar($detalle[$i]['cantidad']);
		$existencia = $existenciabd-$cantpreventa;
		$stmt->execute();
		############## ACTUALIZAMOS EXISTENCIA DEL PRODUCTO EN ALMACEN ##############

	    }

		############### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX ##############
		$sql3 = " UPDATE kardex set "
		." salidas = ?, "
		." stockactual = ? "
		." WHERE "
		." codproceso = '".limpiar($_POST["codpreventa"])."'
		AND codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' 
		AND codsucursal = '".limpiar($_POST["codsucursal"])."';
		";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->bindParam(1, $salidas);
		$stmt->bindParam(2, $existencia);
		
		$salidas = limpiar($detalle[$i]['cantidad']+$cantidadbd);
		$existencia = ($detalle[$i]['tipodetalle'] == 1 ? $existenciabd-$cantpreventa : "0");
		$stmt->execute();
		############### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX ##############

	 }
   }    
    ####################### DESTRUYO LA VARIABLE DE SESSION #####################
    unset($_SESSION["CarritoPreventa"]);
    $this->dbh->commit();

    ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############
	$sql3 = "SELECT SUM(totaldescuentov) AS totaldescuentosi, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detallepreventas WHERE codpreventa = '".limpiar($_POST["codpreventa"])."' AND codsucursal = '".limpiar($_POST["codsucursal"])."' AND ivaproducto = 'SI'";
	foreach ($this->dbh->query($sql3) as $row3)
	{
		$this->p[] = $row3;
	}
	$subtotaldescuentosi = ($row3['totaldescuentosi']== "" ? "0.00" : $row3['totaldescuentosi']);
	$subtotalivasi = ($row3['valorneto']== "" ? "0.00" : $row3['valorneto']);
	$subtotalivasi2 = ($row3['valorneto2']== "" ? "0.00" : $row3['valorneto2']);
	############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############

	############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############
	$sql4 = "SELECT SUM(totaldescuentov) AS totaldescuentono, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detallepreventas WHERE codpreventa = '".limpiar($_POST["codpreventa"])."' AND codsucursal = '".limpiar($_POST["codsucursal"])."' AND ivaproducto = 'NO'";
	foreach ($this->dbh->query($sql4) as $row4)
	{
		$this->p[] = $row4;
	}
	$subtotaldescuentono = ($row4['totaldescuentono']== "" ? "0.00" : $row4['totaldescuentono']);
	$subtotalivano = ($row4['valorneto']== "" ? "0.00" : $row4['valorneto']);
	$subtotalivano2 = ($row4['valorneto2']== "" ? "0.00" : $row4['valorneto2']);
	############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############


    ############ ACTUALIZO LOS TOTALES EN LA PREVENTA ##############
	$sql = " UPDATE preventas SET "
	." codcliente = ?, "
	." observaciones = ?, "
	." subtotalivasi = ?, "
	." subtotalivano = ?, "
	." totaliva = ?, "
	." descontado = ?, "
	." descuento = ?, "
	." totaldescuento = ?, "
	." totalpago = ?, "
	." totalpago2= ? "
	." WHERE "
	." codpreventa = ? AND codsucursal = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $codcliente);
	$stmt->bindParam(2, $observaciones);
	$stmt->bindParam(3, $subtotalivasi);
	$stmt->bindParam(4, $subtotalivano);
	$stmt->bindParam(5, $totaliva);
	$stmt->bindParam(6, $descontado);
	$stmt->bindParam(7, $descuento);
	$stmt->bindParam(8, $totaldescuento);
	$stmt->bindParam(9, $totalpago);
	$stmt->bindParam(10, $totalpago2);
	$stmt->bindParam(11, $codpreventa);
	$stmt->bindParam(12, $codsucursal);

	$codcliente = limpiar($_POST["codcliente"]);
	$observaciones = limpiar($_POST["observaciones"]);
	$iva = $_POST["iva"]/100;
	$totaliva = number_format($subtotalivasi*$iva, 2, '.', '');
	$descontado = number_format($subtotaldescuentosi+$subtotaldescuentono, 2, '.', '');
	$descuento = limpiar($_POST["descuento"]);
    $txtDescuento = $_POST["descuento"]/100;
    $total = number_format($subtotalivasi+$subtotalivano+$totaliva, 2, '.', '');
    $totaldescuento = number_format($total*$txtDescuento, 2, '.', '');
    $totalpago = number_format($total-$totaldescuento, 2, '.', '');
	$totalpago2 = number_format($subtotalivasi2+$subtotalivano2, 2, '.', '');
	$codpreventa = limpiar($_POST["codpreventa"]);
	$codsucursal = limpiar($_POST["codsucursal"]);
	$stmt->execute();
	############ ACTUALIZO LOS TOTALES EN LA PREVENTA ##############

    echo "<span class='fa fa-check-square-o'></span> LOS DETALLES DE PRODUCTOS FUERON AGREGADOS A LA PREVENTA EXITOSAMENTE <a href='reportepdf?codpreventa=".encrypt($codpreventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("TICKETPREVENTA")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

    echo "<script>window.open('reportepdf?codpreventa=".encrypt($codpreventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("TICKETPREVENTA")."', '_blank');</script>";
	exit;
}
######################### FUNCION AGREGAR DETALLES PREVENTAS #######################

######################## FUNCION ELIMINAR DETALLES PREVENTAS #######################
public function EliminarDetallesPreventas()
	{
	self::SetNames();
	if ($_SESSION["acceso"]=="administradorS") {

    ############ CONSULTO DATOS DE TRASPASO ##############
	$sql = "SELECT * FROM preventas WHERE codpreventa = '".limpiar(decrypt($_GET["codpreventa"]))."' AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$codclientebd = $row['codcliente'];
	$totalpagobd = $row['totalpago'];
	############ CONSULTO DATOS DE TRASPASO ##############

	$sql = "SELECT * FROM detallepreventas WHERE codpreventa = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codpreventa"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num > 1)
	{

		$sql = "SELECT codproducto, cantpreventa, precioventa, ivaproducto, descproducto, tipodetalle FROM detallepreventas WHERE coddetallepreventa = ? and codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["coddetallepreventa"]),decrypt($_GET["codsucursal"])));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$codproducto = $row['codproducto'];
		$cantidadbd = $row['cantpreventa'];
		$precioventabd = $row['precioventa'];
		$ivaproductobd = $row['ivaproducto'];
		$descproductobd = $row['descproducto'];
		$tipodetallebd = $row['tipodetalle'];

		if($tipodetallebd == 1){

		############ OBTENGO LA EXISTENCIA DE PRODUCTO EN ALMACEN #############
		$sql2 = "SELECT existencia FROM productos WHERE codproducto = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute(array($codproducto,decrypt($_GET["codsucursal"])));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$existenciabd = $row['existencia'];
		############ OBTENGO LA EXISTENCIA DE PRODUCTO EN ALMACEN #############

		############ ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############
		$sql = "UPDATE productos SET "
		." existencia = ? "
		." WHERE "
		." codproducto = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$stmt->bindParam(2, $codproducto);
		$stmt->bindParam(3, $codsucursal);

		$existencia = limpiar($existenciabd+$cantidadbd);
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute();
		############ ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############

		}

	    ########## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ##########
		$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codpreventa);
		$stmt->bindParam(2, $codresponsable);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);	
		$stmt->bindParam(14, $tipokardex);	
		$stmt->bindParam(15, $codsucursal);

		$codpreventa = limpiar(decrypt($_GET["codpreventa"]));
		$codresponsable = limpiar($codclientebd);
		$movimiento = limpiar("DEVOLUCION");
		$entradas= limpiar("0");
		$salidas = limpiar("0");
		$devolucion = limpiar($cantidadbd);
		$stockactual = limpiar($tipodetallebd == 1 ? $existenciabd+$cantidadbd : "0");
		$precio = limpiar($precioventabd);
		$ivaproducto = limpiar($ivaproductobd);
		$descproducto = limpiar($descproductobd);
		$documento = limpiar("DEVOLUCION PREVENTA: ".decrypt($_GET["codpreventa"]));
		$fechakardex = limpiar(date("Y-m-d"));
		$tipokardex = limpiar($tipodetallebd);
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute();
		########## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ##########

		################## ELIMINO DETALLE DE PREVENTA ##################
		$sql = "DELETE FROM detallepreventas WHERE coddetallepreventa = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$coddetallepreventa);
		$stmt->bindParam(2,$codsucursal);
		$coddetallepreventa = decrypt($_GET["coddetallepreventa"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();
		################## ELIMINO DETALLE DE PREVENTA ##################

	    ############ CONSULTO LOS TOTALES DE PREVENTAS ##############
	    $sql2 = "SELECT iva, descuento FROM preventas WHERE codpreventa = ? AND codsucursal = ?";
	    $stmt = $this->dbh->prepare($sql2);
	    $stmt->execute(array(decrypt($_GET["codpreventa"]),decrypt($_GET["codsucursal"])));
	    $num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$paea[] = $row;
		}
		$iva = $paea[0]["iva"]/100;
	    $descuento = $paea[0]["descuento"]/100;

        ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############
		$sql3 = "SELECT SUM(totaldescuentov) AS totaldescuentosi, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detallepreventas WHERE codpreventa = '".limpiar(decrypt($_GET["codpreventa"]))."' AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."' AND ivaproducto = 'SI'";
		foreach ($this->dbh->query($sql3) as $row3)
		{
			$this->p[] = $row3;
		}
		$subtotaldescuentosi = ($row3['totaldescuentosi']== "" ? "0.00" : $row3['totaldescuentosi']);
		$subtotalivasi = ($row3['valorneto']== "" ? "0.00" : $row3['valorneto']);
		$subtotalivasi2 = ($row3['valorneto2']== "" ? "0.00" : $row3['valorneto2']);
		############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############

	    ############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############
		$sql4 = "SELECT SUM(totaldescuentov) AS totaldescuentono, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detallepreventas WHERE codpreventa = '".limpiar(decrypt($_GET["codpreventa"]))."' AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."' AND ivaproducto = 'NO'";
		foreach ($this->dbh->query($sql4) as $row4)
		{
			$this->p[] = $row4;
		}
		$subtotaldescuentono = ($row4['totaldescuentono']== "" ? "0.00" : $row4['totaldescuentono']);
		$subtotalivano = ($row4['valorneto']== "" ? "0.00" : $row4['valorneto']);
		$subtotalivano2 = ($row4['valorneto2']== "" ? "0.00" : $row4['valorneto2']);
		############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############

        ############ ACTUALIZO LOS TOTALES EN LA PREVENTA ##############
		$sql = " UPDATE preventas SET "
		." subtotalivasi = ?, "
		." subtotalivano = ?, "
		." totaliva = ?, "
		." descontado = ?, "
		." totaldescuento = ?, "
		." totalpago = ?, "
		." totalpago2= ? "
		." WHERE "
		." codpreventa = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $subtotalivasi);
		$stmt->bindParam(2, $subtotalivano);
		$stmt->bindParam(3, $totaliva);
		$stmt->bindParam(4, $descontado);
		$stmt->bindParam(5, $totaldescuento);
		$stmt->bindParam(6, $totalpago);
		$stmt->bindParam(7, $totalpago2);
		$stmt->bindParam(8, $codpreventa);
		$stmt->bindParam(9, $codsucursal);

		$totaliva= number_format($subtotalivasi*$iva, 2, '.', '');
		$descontado = number_format($subtotaldescuentosi+$subtotaldescuentono, 2, '.', '');
	    $total= number_format($subtotalivasi+$subtotalivano+$totaliva, 2, '.', '');
	    $totaldescuento= number_format($total*$descuento, 2, '.', '');
	    $totalpago= number_format($total-$totaldescuento, 2, '.', '');
		$totalpago2 = number_format($subtotalivasi2+$subtotalivano2, 2, '.', '');
		$codpreventa = limpiar(decrypt($_GET["codpreventa"]));
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute();
		############ ACTUALIZO LOS TOTALES EN LA PREVENTA ##############

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
			
	} else {
		
		echo "3";
		exit;
	}	
}
################### FUNCION ELIMINAR DETALLES PREVENTAS #####################

####################### FUNCION ELIMINAR PREVENTAS #################################
public function EliminarPreventas()
{
	self::SetNames();
	if ($_SESSION["acceso"]=="administradorS") {

    ############ CONSULTO DATOS DE TRASPASO ##############
	$sql = "SELECT * FROM preventas WHERE codpreventa = '".limpiar(decrypt($_GET["codpreventa"]))."' AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$codclientebd = $row['codcliente'];
	$totalpagobd = $row['totalpago'];
	############ CONSULTO DATOS DE TRASPASO ##############

    $sql = "SELECT * FROM detallepreventas WHERE codpreventa = '".limpiar(decrypt($_GET["codpreventa"]))."' AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."'";

	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;

		$codproducto = $row['codproducto'];
		$cantidadbd = $row['cantpreventa'];
		$precioventabd = $row['precioventa'];
		$ivaproductobd = $row['ivaproducto'];
		$descproductobd = $row['descproducto'];
		$tipodetallebd = $row['tipodetalle'];

		if($tipodetallebd == 1){

		############ OBTENGO LA EXISTENCIA DE PRODUCTO EN ALMACEN #############
		$sql2 = "SELECT existencia FROM productos WHERE codproducto = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute( array($codproducto,decrypt($_GET["codsucursal"])));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$existenciabd = $row['existencia'];
		############ OBTENGO LA EXISTENCIA DE PRODUCTO EN ALMACEN #############

		########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN ############
		$sql = "UPDATE productos SET "
		." existencia = ? "
		." WHERE "
		." codproducto = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$stmt->bindParam(2, $codproducto);
		$stmt->bindParam(3, $codsucursal);

		$existencia = limpiar($existenciabd+$cantidadbd);
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute();
		########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN ############

	    }

	    ########### REGISTRAMOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ############
		$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codpreventa);
		$stmt->bindParam(2, $codresponsable);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);	
		$stmt->bindParam(14, $tipokardex);	
		$stmt->bindParam(15, $codsucursal);

		$codpreventa = limpiar(decrypt($_GET["codpreventa"]));
	    $codresponsable = limpiar($codclientebd);
		$movimiento = limpiar("DEVOLUCION");
		$entradas= limpiar("0");
		$salidas = limpiar("0");
		$devolucion = limpiar($cantidadbd);
		$stockactual = limpiar($tipodetallebd == 1 ? $existenciabd+$cantidadbd : "0");
		$precio = limpiar($precioventabd);
		$ivaproducto = limpiar($ivaproductobd);
		$descproducto = limpiar($descproductobd);
		$documento = limpiar("DEVOLUCION PREVENTA: ".decrypt($_GET["codpreventa"]));
		$fechakardex = limpiar(date("Y-m-d"));
		$tipokardex = limpiar($tipodetallebd);
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute();
		########### REGISTRAMOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ############
	}

		################## ELIMINO PREVENTA ##################
	    $sql = "DELETE FROM preventas WHERE codpreventa = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codpreventa);
		$stmt->bindParam(2,$codsucursal);
		$codpreventa = decrypt($_GET["codpreventa"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();
		################## ELIMINO PREVENTA ##################

		################## ELIMINO DETALLE DE PREVENTA ##################
		$sql = "DELETE FROM detallepreventas WHERE codpreventa = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codpreventa);
		$stmt->bindParam(2,$codsucursal);
		$codpreventa = decrypt($_GET["codpreventa"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();
		################## ELIMINO DETALLE DE PREVENTA ##################

		echo "1";
		exit;

	} else {

		echo "2";
		exit;
	}
}
###################### FUNCION ELIMINAR PREVENTAS #################################

####################### FUNCION PROCESAR PREVENTAS A VENTA #################################
public function ProcesarPreventas()
	{
	self::SetNames();
	####################### VERIFICO ARQUEO DE CAJA #######################
	$sql = "SELECT * FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
	WHERE usuarios.codigo = ? AND arqueocaja.statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_SESSION["codigo"]));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "1";
		exit;

	} else {
		
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		$codarqueo = $row['codarqueo'];
		$codcaja = $row['codcaja'];
		$ingreso = ($row['ingresos']== "" ? "0.00" : $row['ingresos']);
		$credito = ($row['creditos']== "" ? "0.00" : $row['creditos']);
		$abono = ($row['abonos']== "" ? "0.00" : $row['abonos']);
	}
    ####################### VERIFICO ARQUEO DE CAJA #######################

   if(empty($_POST["codsucursal"]) or empty($_POST["tipodocumento"]) or empty($_POST["tipopago"]))
	{
		echo "2";
		exit;
	}
	elseif(limpiar($_POST["txtTotal"]=="") && limpiar($_POST["txtTotal"]==0) && limpiar($_POST["txtTotal"]==0.00))
	{
		echo "3";
		exit;
	}

	################### SELECCIONE LOS DATOS DEL CLIENTE ######################
    $sql = "SELECT
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	provincias.provincia,
	departamentos.departamento,
    ROUND(SUM(if(pag.montocredito!='0',pag.montocredito,'0.00')), 2) montoactual,
    ROUND(SUM(if(pag.montocredito!='0',clientes.limitecredito-pag.montocredito,clientes.limitecredito)), 2) creditodisponible
    FROM clientes
    LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
    LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento 
    LEFT JOIN
       (SELECT
       codcliente, montocredito       
       FROM creditosxclientes 
       WHERE codsucursal = '".limpiar($_POST['codsucursal'])."') pag ON pag.codcliente = clientes.codcliente
       WHERE clientes.codcliente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST['codcliente']));
	$num = $stmt->rowCount();
	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$p[] = $row;
	}
    $tipocliente = ($row['tipocliente'] == "" ? "0" : $row['tipocliente']);
    $dnicliente = ($row['dnicliente'] == "" ? "0" : $row['dnicliente']);
    $nomcliente = ($row['nomcliente'] == "" ? "0" : $row['nomcliente']);
    $girocliente = ($row['girocliente'] == "" ? "0" : $row['girocliente']);
    $emailcliente = $row['emailcliente'];
    $limitecredito = $row['limitecredito'];
    $montoactual = $row['montoactual'];
    $creditodisponible = $row['creditodisponible'];
    $montoabono = (empty($_POST["montoabono"]) ? "0.00" : $_POST["montoabono"]);
    $total = number_format($_POST["txtTotal"]-$montoabono, 2, '.', '');
    ################### SELECCIONE LOS DATOS DEL CLIENTE ######################

    ################### VALIDO TIPO DE PAGO ES A CREDITO ######################
    if (limpiar($_POST["tipopago"]) == "CREDITO") {

    	$fechaactual = date("Y-m-d");
		$fechavence = date("Y-m-d",strtotime($_POST['fechavencecredito']));

		if ($_POST["codcliente"] == '0') { 

        echo "4";
        exit;

        } else if (strtotime($fechavence) < strtotime($fechaactual)) {

			echo "5";
			exit;

		} else if ($limitecredito != "0.00" && $total > $creditodisponible) {

            echo "6";
            exit;

        } else if($_POST["montoabono"] >= $_POST["txtTotal"]) { 

	        echo "7";
	        exit;
        }
    }
    ################### VALIDO TIPO DE PAGO ES A CREDITO ######################

	################# OBTENGO DATOS DE SUCURSAL #################
	$sql = " SELECT 
	codsucursal, 
	nroactividadsucursal,  
	inicioticket,
	iniciofactura, 
	inicioguia, 
	inicionotaventa  
	FROM sucursales WHERE codsucursal = '".limpiar(decrypt($_POST['codsucursal']))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$nroactividad = $row['nroactividadsucursal'];
	$inicioticket = $row['inicioticket'];
	$iniciofactura = $row['iniciofactura'];
	$inicioguia = $row['inicioguia'];
	$inicionotaventa = $row['inicionotaventa'];
	################# OBTENGO DATOS DE SUCURSAL #################

	################ CREO CODIGO DE PEDIDO ####################
	$sql = "SELECT codventa FROM ventas 
	ORDER BY idventa DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$venta=$row["codventa"];

	}
	if(empty($venta))
	{
		$codventa = "01";

	} else {

		$num = substr($venta, 0);
        $dig = $num + 1;
        $codigofinal = str_pad($dig, 2, "0", STR_PAD_LEFT);
        $codventa = $codigofinal;
	}
    ################ CREO CODIGO DE PEDIDO ###############

    ################### CREO CODIGO DE FACTURA ####################
	$sql = "SELECT codfactura
	FROM ventas 
	WHERE codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."' 
	ORDER BY idventa DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$factura=$row["codfactura"];

	}
	
	if($_POST['tipodocumento']=="TICKET") {

        if(empty($factura)){ 
        	$codfactura = $nroactividad.'-'.$inicioticket;
        } else {
           $var = strlen($nroactividad."-");
           $var1 = substr($factura , $var);
           $var2 = strlen($var1);
           $var3 = $var1 + 1;
           $var4 = str_pad($var3, $var2, "0", STR_PAD_LEFT);
           $codfactura = $nroactividad.'-'.$var4;
        }
		   $codserie = limpiar($nroactividad);
		   $codautorizacion = limpiar(GenerateRandomStringg());

	} elseif($_POST['tipodocumento']=="FACTURA") {

        if(empty($factura)){ 
        	$codfactura = $nroactividad.'-'.$iniciofactura;
        } else {
           $var = strlen($nroactividad."-");
           $var1 = substr($factura , $var);
           $var2 = strlen($var1);
           $var3 = $var1 + 1;
           $var4 = str_pad($var3, $var2, "0", STR_PAD_LEFT);
           $codfactura = $nroactividad.'-'.$var4;
        }
		   $codserie = limpiar($nroactividad);
		   $codautorizacion = limpiar(GenerateRandomStringg());

	} elseif($_POST['tipodocumento']=="GUIA") {

        if(empty($factura)){ 
        	$codfactura = $nroactividad.'-'.$inicioguia;
        } else {
           $var = strlen($nroactividad."-");
           $var1 = substr($factura , $var);
           $var2 = strlen($var1);
           $var3 = $var1 + 1;
           $var4 = str_pad($var3, $var2, "0", STR_PAD_LEFT);
           $codfactura = $nroactividad.'-'.$var4;
        }
		   $codserie = limpiar($nroactividad);
		   $codautorizacion = limpiar(GenerateRandomStringg());

	} elseif($_POST['tipodocumento']=="NOTA VENTA") {

        if(empty($factura)){ 
        	$codfactura = $nroactividad.'-'.$inicionotaventa;
        } else {
           $var = strlen($nroactividad."-");
           $var1 = substr($factura , $var);
           $var2 = strlen($var1);
           $var3 = $var1 + 1;
           $var4 = str_pad($var3, $var2, "0", STR_PAD_LEFT);
           $codfactura = $nroactividad.'-'.$var4;
        }
		   $codserie = limpiar($nroactividad);
		   $codautorizacion = limpiar(GenerateRandomStringg());
	}
    ################### CREO CODIGO DE FACTURA ####################

	################### SELECCIONE LOS DATOS DE LA preventa ######################
    $sql = "SELECT * FROM preventas WHERE codpreventa = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_POST['codpreventa']),decrypt($_POST['codsucursal'])));
	$num = $stmt->rowCount();
	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$p[] = $row;
	}
    ################### SELECCIONE LOS DATOS DE LA preventa ######################

    $fecha = date("Y-m-d H:i:s");

    $query = "INSERT INTO ventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $tipodocumento);
	$stmt->bindParam(2, $codcaja);
	$stmt->bindParam(3, $codventa);
	$stmt->bindParam(4, $codfactura);
	$stmt->bindParam(5, $codserie);
	$stmt->bindParam(6, $codautorizacion);
	$stmt->bindParam(7, $codcliente);
	$stmt->bindParam(8, $subtotalivasi);
	$stmt->bindParam(9, $subtotalivano);
	$stmt->bindParam(10, $iva);
	$stmt->bindParam(11, $totaliva);
	$stmt->bindParam(12, $descontado);
	$stmt->bindParam(13, $descuento);
	$stmt->bindParam(14, $totaldescuento);
	$stmt->bindParam(15, $totalpago);
	$stmt->bindParam(16, $totalpago2);
	$stmt->bindParam(17, $creditopagado);
	$stmt->bindParam(18, $tipopago);
	$stmt->bindParam(19, $formapago);
	$stmt->bindParam(20, $montopagado);
	$stmt->bindParam(21, $montodevuelto);
	$stmt->bindParam(22, $fechavencecredito);
	$stmt->bindParam(23, $fechapagado);
	$stmt->bindParam(24, $statusventa);
	$stmt->bindParam(25, $fechaventa);
	$stmt->bindParam(26, $observaciones);
	$stmt->bindParam(27, $notacredito);
	$stmt->bindParam(28, $codigo);
	$stmt->bindParam(29, $codsucursal);
   
	$tipodocumento = limpiar($_POST["tipodocumento"]);
	$codcaja = limpiar($_POST["codcaja"]);
	$codcliente = limpiar($_POST['codcliente']);
	$subtotalivasi = limpiar($row["subtotalivasi"]);
	$subtotalivano = limpiar($row["subtotalivano"]);
	$iva = limpiar($row["iva"]);
	$totaliva = limpiar($row["totaliva"]);
	$descontado = limpiar($row["descontado"]);
	$descuento = limpiar($row["descuento"]);
	$totaldescuento = limpiar($row["totaldescuento"]);
	$totalpago = limpiar($row["totalpago"]);
	$totalpago2 = limpiar($row["totalpago2"]);
	if (limpiar(isset($_POST['montoabono']))) { $creditopagado = limpiar($_POST['montoabono']); } else { $creditopagado ='0.00'; }
	$tipopago = limpiar($_POST["tipopago"]);
	$formapago = limpiar($_POST["tipopago"]=="CONTADO" ? decrypt($_POST["codmediopago"]) : "CREDITO");
	if (limpiar(isset($_POST['montopagado']))) { $montopagado = limpiar($_POST['montopagado']); } else { $montopagado ='0.00'; }
	if (limpiar(isset($_POST['montodevuelto']))) { $montodevuelto = limpiar($_POST['montodevuelto']); } else { $montodevuelto ='0.00'; }
	$fechavencecredito = limpiar($_POST["tipopago"]=="CREDITO" ? date("Y-m-d",strtotime($_POST['fechavencecredito'])) : "0000-00-00");
    $fechapagado = limpiar("0000-00-00");
    $statusventa = limpiar($_POST["tipopago"]=="CONTADO" ? "PAGADA" : "PENDIENTE");
    $fechaventa = limpiar($fecha);
	$observaciones = limpiar($_POST["observaciones"]);
	$notacredito = limpiar("0");
	$codigo = limpiar($_SESSION["codigo"]);
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();

	################### SELECCIONO DETALLES DE LA preventa ######################
	$sql = "SELECT * FROM detallepreventas 
	WHERE codpreventa = '".decrypt($_POST['codpreventa'])."' 
	AND codsucursal = '".decrypt($_POST['codsucursal'])."'";
    foreach ($this->dbh->query($sql) as $row2)
	{

	    $query = "INSERT INTO detalleventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
    	$stmt = $this->dbh->prepare($query);
    	$stmt->bindParam(1, $codventa);
    	$stmt->bindParam(2, $idproducto);
    	$stmt->bindParam(3, $codproducto);
    	$stmt->bindParam(4, $producto);
    	$stmt->bindParam(5, $codmarca);
    	$stmt->bindParam(6, $codmodelo);
    	$stmt->bindParam(7, $codpresentacion);
    	$stmt->bindParam(8, $cantidad);
    	$stmt->bindParam(9, $preciocompra);
    	$stmt->bindParam(10, $precioventa);
    	$stmt->bindParam(11, $ivaproducto);
    	$stmt->bindParam(12, $descproducto);
    	$stmt->bindParam(13, $valortotal);
    	$stmt->bindParam(14, $totaldescuentov);
    	$stmt->bindParam(15, $valorneto);
    	$stmt->bindParam(16, $valorneto2);
    	$stmt->bindParam(17, $tipodetalle);
    	$stmt->bindParam(18, $codsucursal);

	    $idproducto = limpiar($row2['idproducto']);
    	$codproducto = strip_tags($row2['codproducto']);
    	$producto = strip_tags($row2['producto']);
    	$codmarca = strip_tags($row2['codmarca']);
    	$codmodelo = strip_tags($row2['codmodelo']);
    	$codpresentacion = strip_tags($row2['codpresentacion']);
    	$cantidad = limpiar($row2['cantpreventa']);
    	$preciocompra = limpiar($row2['preciocompra']);
    	$precioventa = limpiar($row2['precioventa']);
    	$ivaproducto = limpiar($row2['ivaproducto']);
    	$descproducto = limpiar($row2['descproducto']);
    	$descuento = $row2['descproducto']/100;
    	$valortotal = number_format($row2['valortotal'], 2, '.', '');
    	$totaldescuentov = number_format($row2['totaldescuentov'], 2, '.', '');
    	$valorneto = number_format($row2['valorneto'], 2, '.', '');
    	$valorneto2 = number_format($row2['valorneto2'], 2, '.', '');
    	$tipodetalle = limpiar($row2['tipodetalle']);
    	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
    	$stmt->execute();

    	if(limpiar($row2['tipodetalle'])==1){

            ################ VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ################
    		$sql4 = "SELECT * FROM productos 
    		WHERE codproducto = '".limpiar($row2['codproducto'])."' 
    		AND codsucursal = '".limpiar($_POST['codsucursal'])."'";
    		foreach ($this->dbh->query($sql4) as $row4)
    		{
    			$this->p[] = $row4;
    		}
    		$existenciabd = $row4['existencia'];
            ################ VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ################

            ##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
    		$sql = " UPDATE productos set "
    		." existencia = ? "
    		." where "
    		." codproducto = '".limpiar($row2['codproducto'])."' 
    		AND codsucursal = '".limpiar($_POST["codsucursal"])."';
    		";
    		$stmt = $this->dbh->prepare($sql);
    		$stmt->bindParam(1, $existencia);

    		$existencia = $existenciabd-$row2['cantpreventa'];
    		$stmt->execute();
            ##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################

    	}

        ############### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###############
    	$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
    	$stmt = $this->dbh->prepare($query);
    	$stmt->bindParam(1, $codventa);
    	$stmt->bindParam(2, $codcliente);
    	$stmt->bindParam(3, $codproducto);
    	$stmt->bindParam(4, $movimiento);
    	$stmt->bindParam(5, $entradas);
    	$stmt->bindParam(6, $salidas);
    	$stmt->bindParam(7, $devolucion);
    	$stmt->bindParam(8, $stockactual);
    	$stmt->bindParam(9, $ivaproducto);
    	$stmt->bindParam(10, $descproducto);
    	$stmt->bindParam(11, $precio);
    	$stmt->bindParam(12, $documento);
    	$stmt->bindParam(13, $fechakardex);
    	$stmt->bindParam(14, $tipokardex);		
    	$stmt->bindParam(15, $codsucursal);

    	$codcliente = limpiar($_POST["codcliente"]);
    	$codproducto = limpiar($row2['codproducto']);
    	$movimiento = limpiar("SALIDAS");
    	$entradas = limpiar("0");
    	$salidas= limpiar($row2['cantpreventa']);
    	$devolucion = limpiar("0");
    	$stockactual = limpiar($row2['tipodetalle'] == 1 ? $existenciabd-$row2['cantpreventa'] : "0");
    	$precio = limpiar($row2["precioventa"]);
    	$ivaproducto = limpiar($row2['ivaproducto']);
    	$descproducto = limpiar($row2['descproducto']);
    	$documento = limpiar("VENTA: ".$codventa);
    	$fechakardex = limpiar(date("Y-m-d"));
    	$tipokardex = limpiar($row2['tipodetalle']);
    	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
    	$stmt->execute();

	}

	################ AGREGAMOS EL INGRESO DE VENTAS PAGADAS A CAJA ##############
	if (limpiar($_POST["tipopago"]=="CONTADO")){

		$sql = "UPDATE arqueocaja set "
		." ingresos = ? "
		." WHERE "
		." codarqueo = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtTotal);
		$stmt->bindParam(2, $codarqueo);

		$txtTotal = number_format($_POST["txtTotal"]+$ingreso, 2, '.', '');
		$stmt->execute();
	}
    ################ AGREGAMOS EL INGRESO DE VENTAS PAGADAS A CAJA ################

    ########## AGREGAMOS EL INGRESO Y ABONOS DE VENTAS A CREDITOS A CAJA ##########
    if (limpiar($_POST["tipopago"]=="CREDITO" && $_POST["montoabono"]=="0.00" && $_POST["montoabono"]=="0")) {

		$sql = " UPDATE arqueocaja SET "
		." creditos = ? "
		." where "
		." codarqueo = ? and statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtTotal);
		$stmt->bindParam(2, $codarqueo);

		$txtTotal = number_format($_POST["txtTotal"]+$credito, 2, '.', '');
		$stmt->execute(); 

		$sql = " SELECT codcliente FROM creditosxclientes WHERE codcliente = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codcliente"],decrypt($_POST["codsucursal"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = "INSERT INTO creditosxclientes values (null, ?, ?, ?);";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codcliente);
			$stmt->bindParam(2, $montocredito);
			$stmt->bindParam(3, $codsucursal);

			$codcliente = limpiar($_POST["codcliente"]);
			$montocredito = number_format($_POST["txtTotal"]-$_POST["montoabono"], 2, '.', '');
			$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
			$stmt->execute();

		} else { 

			$sql = "UPDATE creditosxclientes set"
			." montocredito = ? "
			." where "
			." codcliente = ? AND codsucursal = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $montocredito);
			$stmt->bindParam(2, $codcliente);
			$stmt->bindParam(3, $codsucursal);

			$montocredito = number_format($montoactual+($_POST["txtTotal"]-$_POST["montoabono"]), 2, '.', '');
			$codcliente = limpiar($_POST["codcliente"]);
			$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
			$stmt->execute();
		}

	} else if (limpiar($_POST["tipopago"]=="CREDITO" && $_POST["montoabono"]!="0.00" && $_POST["montoabono"]!="0")) { 

		$sql = " UPDATE arqueocaja SET "
		." creditos = ?, "
		." abonos = ? "
		." where "
		." codarqueo = ? and statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtTotal);
		$stmt->bindParam(2, $totalabono);
		$stmt->bindParam(3, $codarqueo);

		$TotalCredito = number_format($_POST["txtTotal"]-$_POST["montoabono"], 2, '.', '');
		$txtTotal = number_format($TotalCredito+$credito, 2, '.', '');
		$totalabono = number_format($_POST["montoabono"]+$abono, 2, '.', '');
		$stmt->execute();

		$query = "INSERT INTO abonoscreditosventas values (null, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcaja);
		$stmt->bindParam(2, $codventa);
		$stmt->bindParam(3, $codcliente);
		$stmt->bindParam(4, $montoabono);
		$stmt->bindParam(5, $fechaabono);
		$stmt->bindParam(6, $codsucursal);

		$codcliente = limpiar($_POST["codcliente"]);
		$montoabono = number_format($_POST["montoabono"], 2, '.', '');
		$fechaabono = limpiar($fecha);
		$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
		$stmt->execute();

		$sql = " SELECT codcliente FROM creditosxclientes WHERE codcliente = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codcliente"],decrypt($_POST["codsucursal"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = "INSERT INTO creditosxclientes values (null, ?, ?, ?);";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codcliente);
			$stmt->bindParam(2, $montocredito);
			$stmt->bindParam(3, $codsucursal);

			$codcliente = limpiar($_POST["codcliente"]);
			$montocredito = number_format($_POST["txtTotal"]-$_POST["montoabono"], 2, '.', '');
			$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
			$stmt->execute();

		} else { 

			$sql = "UPDATE creditosxclientes set"
			." montocredito = ? "
			." where "
			." codcliente = ? AND codsucursal = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $montocredito);
			$stmt->bindParam(2, $codcliente);
			$stmt->bindParam(3, $codsucursal);

			$montocredito = number_format($montoactual+($_POST["txtTotal"]-$_POST["montoabono"]), 2, '.', '');
			$codcliente = limpiar($_POST["codcliente"]);
			$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
			$stmt->execute();
		}
	}
	########### AGREGAMOS EL INGRESO Y ABONOS DE VENTAS A CREDITOS A CAJA #########
		
	################## ELIMINO PREVENTA ##################
	$sql = "DELETE FROM preventas WHERE codpreventa = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1,$codpreventa);
	$stmt->bindParam(2,$codsucursal);
	$codpreventa = decrypt($_POST["codpreventa"]);
	$codsucursal = decrypt($_POST["codsucursal"]);
	$stmt->execute();
	################## ELIMINO PREVENTA ##################

	################## ELIMINO DETALLE DE PREVENTA ##################
	$sql = "DELETE FROM detallepreventas WHERE codpreventa = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(1,$codpreventa);
	$stmt->bindParam(2,$codsucursal);
	$codpreventa = decrypt($_POST["codpreventa"]);
	$codsucursal = decrypt($_POST["codsucursal"]);
	$stmt->execute();
	################## ELIMINO DETALLE DE PREVENTA ##################

    echo "<span class='fa fa-check-square-o'></span> LA PREVENTA HA SIDO PROCESADA COMO VENTA EXITOSAMENTE <a href='reportepdf?codventa=".encrypt($codventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt($tipodocumento)."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

    echo "<script>window.open('reportepdf?codventa=".encrypt($codventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt($tipodocumento)."', '_blank');</script>";
	exit;
}
###################### FUNCION PROCESAR PREVENTAS A VENTAS #################################

###################### FUNCION BUSQUEDA PREVENTAS POR FECHAS ####################
public function BuscarPreventasxFechas() 
{
	self::SetNames();
	$sql ="SELECT 
	preventas.idpreventa, 
	preventas.codpreventa,
	preventas.codfactura,
	preventas.codcliente, 
	preventas.subtotalivasi,
	preventas.subtotalivano, 
	preventas.iva,
	preventas.totaliva,
	preventas.descontado, 
	preventas.descuento,
	preventas.totaldescuento, 
	preventas.totalpago, 
	preventas.totalpago2,
	preventas.observaciones,
	preventas.fechapreventa,
	preventas.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	SUM(detallepreventas.cantpreventa) as articulos 
	FROM (preventas LEFT JOIN detallepreventas ON detallepreventas.codpreventa=preventas.codpreventa)
	INNER JOIN sucursales ON preventas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON preventas.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON clientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON clientes.id_departamento = departamentos2.id_departamento
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
	WHERE preventas.codsucursal = ? 
	AND DATE_FORMAT(preventas.fechapreventa,'%Y-%m-%d') BETWEEN ? AND ? 
	GROUP BY detallepreventas.codpreventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PREVENTAS PARA EL RANGO DE FECHA INGRESADO</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
################### FUNCION BUSQUEDA PREVENTAS POR FECHAS ###################

###################### FUNCION BUSCAR DETALLES PREVENTAS POR FECHAS #########################
public function BuscarDetallesPreventasxFechas() 
{
	self::SetNames();
   $sql ="SELECT 
   detallepreventas.idproducto,
   detallepreventas.codproducto,
   detallepreventas.producto,
   detallepreventas.codmarca,
   detallepreventas.codmodelo,
   detallepreventas.codpresentacion,
   detallepreventas.descproducto,
   detallepreventas.ivaproducto, 
   detallepreventas.precioventa, 
   detallepreventas.tipodetalle,
   productos.existencia,
   presentaciones.nompresentacion,
   marcas.nommarca, 
   modelos.nommodelo, 
   preventas.fechapreventa, 
   sucursales.documsucursal, 
   sucursales.cuitsucursal, 
   sucursales.nomsucursal,
   sucursales.documencargado,
   sucursales.dniencargado,
   sucursales.nomencargado,
   sucursales.tlfsucursal,
   sucursales.direcsucursal,
   sucursales.correosucursal,
   sucursales.llevacontabilidad,
   sucursales.codmoneda,
   sucursales.codmoneda2,
   documentos.documento,
   documentos2.documento AS documento2,
   tiposmoneda.moneda,
   tiposmoneda.siglas,
   tiposmoneda.simbolo,
   tiposmoneda2.moneda AS moneda2,
   tiposmoneda2.siglas AS siglas2,
   tiposmoneda2.simbolo AS simbolo2,
   valor_cambio.montocambio,
   documentos.documento,
   documentos2.documento AS documento2,
   provincias.provincia,
   departamentos.departamento,
   SUM(detallepreventas.cantpreventa) as cantidad 
   FROM (preventas INNER JOIN detallepreventas ON preventas.codpreventa = detallepreventas.codpreventa)   
   LEFT JOIN productos ON detallepreventas.idproducto = productos.idproducto     
   LEFT JOIN marcas ON detallepreventas.codmarca = marcas.codmarca 
   LEFT JOIN modelos ON detallepreventas.codmodelo = modelos.codmodelo 
   LEFT JOIN presentaciones ON detallepreventas.codpresentacion = presentaciones.codpresentacion
   LEFT JOIN sucursales ON preventas.codsucursal = sucursales.codsucursal 
   LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
   LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
   LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
   LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
   LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
   LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
   WHERE preventas.codsucursal = '".decrypt($_GET['codsucursal'])."' 
   AND DATE_FORMAT(preventas.fechapreventa,'%Y-%m-%d') BETWEEN ? AND ? 
   GROUP BY detallepreventas.codproducto, detallepreventas.producto, detallepreventas.precioventa, detallepreventas.descproducto, detallepreventas.codsucursal
   ORDER BY detallepreventas.codproducto ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN PRODUCTOS PREVENTAS PARA EL RANGO DE FECHA INGRESADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################### FUNCION BUSCAR DETALLES PREVENTAS POR FECHAS ###############################

###################### FUNCION BUSCAR DETALLES PREVENTAS POR VENDEDOR #########################
public function BuscarDetallesPreventasxVendedor() 
	{
	self::SetNames();
   $sql ="SELECT 
   detallepreventas.idproducto,
   detallepreventas.codproducto,
   detallepreventas.producto,
   detallepreventas.codmarca,
   detallepreventas.codmodelo,
   detallepreventas.codpresentacion,
   detallepreventas.descproducto,
   detallepreventas.ivaproducto, 
   detallepreventas.precioventa,
   detallepreventas.tipodetalle,
   productos.existencia,
   marcas.nommarca, 
   modelos.nommodelo, 
   preventas.fechapreventa, 
   sucursales.documsucursal, 
   sucursales.cuitsucursal, 
   sucursales.nomsucursal,
   sucursales.documencargado,
   sucursales.dniencargado,
   sucursales.nomencargado,
   sucursales.tlfsucursal,
   sucursales.direcsucursal,
   sucursales.correosucursal,
   sucursales.llevacontabilidad,
   sucursales.codmoneda,
   sucursales.codmoneda2,
   documentos.documento,
   documentos2.documento AS documento2,
   tiposmoneda.moneda,
   tiposmoneda.siglas,
   tiposmoneda.simbolo,
   tiposmoneda2.moneda AS moneda2,
   tiposmoneda2.siglas AS siglas2,
   tiposmoneda2.simbolo AS simbolo2,
   valor_cambio.montocambio,
   documentos.documento,
   usuarios.dni,
   usuarios.nombres, 
   SUM(detallepreventas.cantpreventa) as cantidad 
   FROM (preventas INNER JOIN detallepreventas ON preventas.codpreventa = detallepreventas.codpreventa)
   LEFT JOIN productos ON detallepreventas.idproducto = productos.idproducto  
   LEFT JOIN marcas ON detallepreventas.codmarca = marcas.codmarca 
   LEFT JOIN modelos ON detallepreventas.codmodelo = modelos.codmodelo 
   LEFT JOIN sucursales ON preventas.codsucursal = sucursales.codsucursal 
   LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
   LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
   LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
   LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
   LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
   LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
   LEFT JOIN usuarios ON preventas.codigo = usuarios.codigo 
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
   WHERE preventas.codsucursal = '".decrypt($_GET['codsucursal'])."' 
   AND preventas.codigo = ? 
   AND DATE_FORMAT(preventas.fechapreventa,'%Y-%m-%d') BETWEEN ? AND ? 
   GROUP BY detallepreventas.codproducto, detallepreventas.producto, detallepreventas.precioventa, detallepreventas.descproducto, detallepreventas.codsucursal
   ORDER BY detallepreventas.codproducto ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_GET['codigo']));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN PRODUCTOS FACTURADOS PARA EL VENDEDOR Y RANGO DE FECHA INGRESADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################### FUNCION BUSCAR DETALLES PREVENTAS POR VENDEDOR ###############################

########################### FIN DE CLASE PREVENTAS ############################



































################################ CLASE CAJAS DE VENTAS ################################

######################### FUNCION REGISTRAR CAJAS DE VENTAS #######################
public function RegistrarCajas()
{
	self::SetNames();
	if(empty($_POST["nrocaja"]) or empty($_POST["nomcaja"]) or empty($_POST["codigo"]))
	{
		echo "1";
		exit;
	}
		
		$sql = "SELECT nrocaja FROM cajas WHERE nrocaja = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["nrocaja"],decrypt($_POST["codsucursal"])));
		$num = $stmt->rowCount();
		if($num > 0)
		{
		    echo "2";
		    exit;

		} else {
			
		$sql = "SELECT nomcaja FROM cajas WHERE nomcaja = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["nomcaja"],decrypt($_POST["codsucursal"])));
		$num = $stmt->rowCount();
		if($num > 0)
		{
			echo "3";
			exit;

		} else {
			
		$sql = "SELECT codigo FROM cajas WHERE codigo = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codigo"],decrypt($_POST["codsucursal"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = "INSERT INTO cajas values (null, ?, ?, ?, ?); ";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $nrocaja);
			$stmt->bindParam(2, $nomcaja);
			$stmt->bindParam(3, $codigo);
			$stmt->bindParam(4, $codsucursal);

			$nrocaja = limpiar($_POST["nrocaja"]);
			$nomcaja = limpiar($_POST["nomcaja"]);
			$codigo = limpiar($_POST["codigo"]);
			$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
			$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> LA CAJA PARA VENTA HA SIDO REGISTRADA EXITOSAMENTE";
			exit;

			} else {

			echo "4";
			exit;
		    }
		}
	}
}
######################### FUNCION REGISTRAR CAJAS DE VENTAS #########################

######################### FUNCION LISTAR CAJAS DE VENTAS ################################
public function ListarCajas()
{
	self::SetNames();
	
	if($_SESSION['acceso'] == "administradorS" || $_SESSION['acceso'] == "secretaria") {

    $sql = "SELECT * FROM cajas 
    INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal 
    WHERE cajas.codsucursal = '".limpiar($_SESSION["codsucursal"])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;

	} else if($_SESSION["acceso"] == "cajero") {

    $sql = "SELECT * FROM cajas 
    INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal 
    WHERE cajas.codigo = '".limpiar($_SESSION["codigo"])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;

	} else {

	$sql = "SELECT * FROM cajas 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
	LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################### FUNCION LISTAR CAJAS DE VENTAS ##########################

############################ FUNCION ID CAJAS DE VENTAS #################################
public function CajasPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM cajas 
	LEFT JOIN usuarios ON usuarios.codigo = cajas.codigo 
	LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal 
	WHERE cajas.codcaja = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcaja"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID CAJAS DE VENTAS #################################

#################### FUNCION ACTUALIZAR CAJAS DE VENTAS ############################
public function ActualizarCajas()
{
	self::SetNames();
	if(empty($_POST["codcaja"]) or empty($_POST["nrocaja"]) or empty($_POST["nomcaja"]) or empty($_POST["codigo"]))
	{
		echo "1";
		exit;
	}
		$sql = "SELECT nrocaja FROM cajas WHERE codcaja != ? AND nrocaja = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codcaja"],$_POST["nrocaja"]));
		$num = $stmt->rowCount();
		if($num > 0)
		{
		    echo "2";
		    exit;

		} else {
			
		$sql = "SELECT nomcaja FROM cajas WHERE codcaja != ? AND nomcaja = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codcaja"],$_POST["nomcaja"]));
		$num = $stmt->rowCount();
		if($num > 0)
		{
			echo "3";
			exit;

		} else {
			
		$sql = "SELECT codigo FROM cajas WHERE codcaja != ? AND codigo = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codcaja"],$_POST["codigo"]));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$sql = "UPDATE cajas set "
			." nrocaja = ?, "
			." nomcaja = ?, "
			." codigo = ? "
			." where "
			." codcaja = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $nrocaja);
			$stmt->bindParam(2, $nomcaja);
			$stmt->bindParam(3, $codigo);
			$stmt->bindParam(4, $codcaja);

			$nrocaja = limpiar($_POST["nrocaja"]);
			$nomcaja = limpiar($_POST["nomcaja"]);
			$codigo = limpiar($_POST["codigo"]);
			$codcaja = limpiar($_POST["codcaja"]);
			$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> LA CAJA PARA VENTA HA SIDO ACTUALIZADA EXITOSAMENTE";
			exit;

			} else {

			echo "4";
			exit;
		    }
		}
	}
}
#################### FUNCION ACTUALIZAR CAJAS DE VENTAS ###########################

####################### FUNCION ELIMINAR CAJAS DE VENTAS ########################
public function EliminarCajas()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

	$sql = "SELECT codcaja FROM ventas WHERE codcaja = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcaja"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{

		$sql = "DELETE FROM cajas WHERE codcaja = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codcaja);
		$codcaja = decrypt($_GET["codcaja"]);
		$stmt->execute();

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
			
	} else {
		
		echo "3";
		exit;
	}	
}
####################### FUNCION ELIMINAR CAJAS DE VENTAS #######################

####################### FUNCION BUSCAR CAJAS POR SUCURSAL ###############################
public function BuscarCajasxSucursal() 
    {
	self::SetNames();
	$sql = " SELECT * FROM cajas 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
	INNER JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal 
	WHERE cajas.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<option value=''> -- SIN RESULTADOS -- </option>";
		exit;
	}
	else
	{
	while($row = $stmt->fetch())
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################## FUNCION BUSCAR CAJAS POR SUCURSAL #######################

######################### FUNCION LISTAR CAJAS ABIERTAS ##########################
public function ListarCajasAbiertas()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT * FROM arqueocaja INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo  
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
    WHERE cajas.codsucursal = ? AND arqueocaja.statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	     if($num==0)
	{
		echo "<option value=''> -- SIN RESULTADOS -- </option>";
		exit;
	       }
	else
	{
	while($row = $stmt->fetch())
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}

	} else if($_SESSION["acceso"] == "cajero") {

    $sql = "SELECT * FROM arqueocaja INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo  
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
    WHERE cajas.codigo = '".limpiar($_SESSION["codigo"])."'
    AND cajas.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
    AND arqueocaja.statusarqueo = 1
    GROUP BY arqueocaja.codarqueo";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;

	} else {

	$sql = "SELECT * FROM arqueocaja INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo  
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
    WHERE cajas.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
    AND arqueocaja.statusarqueo = 1
    GROUP BY arqueocaja.codarqueo";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
   }
}
######################### FUNCION LISTAR CAJAS ABIERTAS ##########################

############################ FIN DE CLASE CAJAS DE VENTAS ##############################


























########################## CLASE ARQUEOS DE CAJA ###################################

########################## FUNCION PARA REGISTRAR ARQUEO DE CAJA ####################
public function RegistrarArqueoCaja()
{
	self::SetNames();
	if(empty($_POST["codcaja"]) or empty($_POST["montoinicial"]) or empty($_POST["fecharegistro"]))
	{
		echo "1";
		exit;
	}

	$sql = "SELECT codcaja FROM arqueocaja WHERE codcaja = ? AND statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_POST["codcaja"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$query = "INSERT INTO arqueocaja values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcaja);
		$stmt->bindParam(2, $montoinicial);
		$stmt->bindParam(3, $ingresos);
		$stmt->bindParam(4, $egresos);
		$stmt->bindParam(5, $creditos);
		$stmt->bindParam(6, $abonos);
		$stmt->bindParam(7, $dineroefectivo);
		$stmt->bindParam(8, $diferencia);
		$stmt->bindParam(9, $comentarios);
		$stmt->bindParam(10, $fechaapertura);
		$stmt->bindParam(11, $fechacierre);
		$stmt->bindParam(12, $statusarqueo);

		$codcaja = limpiar(decrypt($_POST["codcaja"]));
		$montoinicial = limpiar($_POST["montoinicial"]);
		$ingresos = limpiar("0.00");
		$egresos = limpiar("0.00");
		$creditos = limpiar("0.00");
		$abonos = limpiar("0.00");
		$dineroefectivo = limpiar("0.00");
		$diferencia = limpiar("0.00");
		$comentarios = limpiar('NINGUNO');
		$fechaapertura = limpiar(date("Y-m-d H:i:s",strtotime($_POST['fecharegistro'])));
		$fechacierre = limpiar(date("0000-00-00 00:00:00"));
		$statusarqueo = limpiar("1");
		$stmt->execute();

	echo "<span class='fa fa-check-square-o'></span> EL ARQUEO DE CAJA HA SIDO REALIZADO EXITOSAMENTE";
	exit;

		} else {

		echo "2";
		exit;
    }
}
######################## FUNCION PARA REGISTRAR ARQUEO DE CAJA #######################

######################## FUNCION PARA LISTAR ARQUEO DE CAJA ########################
public function ListarArqueoCaja()
{
	self::SetNames();
	if($_SESSION['acceso'] == "administradorS") {

    $sql = "SELECT * FROM arqueocaja 
    INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
    LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo  
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda 
    WHERE cajas.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
    ORDER BY arqueocaja.codarqueo DESC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

	} else if($_SESSION["acceso"] == "cajero") {

    $sql = "SELECT * FROM arqueocaja 
    INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
    LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo  
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda 
    WHERE cajas.codigo = '".limpiar($_SESSION["codigo"])."'
    AND cajas.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
    ORDER BY arqueocaja.codarqueo DESC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

    } else {

	$sql = "SELECT * FROM arqueocaja 
    INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
    LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo  
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda 
	ORDER BY arqueocaja.codarqueo DESC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

	}
}
######################## FUNCION PARA LISTAR ARQUEO DE CAJA #########################

########################## FUNCION ID ARQUEO DE CAJA #############################
public function ArqueoCajaPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo 
	LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento  
	 WHERE arqueocaja.codarqueo = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codarqueo"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################## FUNCION ID ARQUEO DE CAJA #############################

##################### FUNCION VERIFICA ARQUEO DE CAJA POR USUARIO #######################
public function ArqueoCajaPorUsuario()
{
	self::SetNames();
	$sql = "SELECT * FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
	LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda 
	WHERE usuarios.codigo = ? 
	AND arqueocaja.statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_SESSION["codigo"]));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION VERIFICA ARQUEO DE CAJA POR USUARIO ###################

######################### FUNCION PARA CERRAR ARQUEO DE CAJA #########################
public function CerrarArqueoCaja()
{
	self::SetNames();
	if(empty($_POST["codarqueo"]) or empty($_POST["dineroefectivo"]))
	{
		echo "1";
		exit;
	}

	if($_POST["dineroefectivo"] != 0.00 || $_POST["dineroefectivo"] != 0){

		$sql = "UPDATE arqueocaja SET "
		." dineroefectivo = ?, "
		." diferencia = ?, "
		." comentarios = ?, "
		." fechacierre = ?, "
		." statusarqueo = ? "
		." WHERE "
		." codarqueo = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $dineroefectivo);
		$stmt->bindParam(2, $diferencia);
		$stmt->bindParam(3, $comentarios);
		$stmt->bindParam(4, $fechacierre);
		$stmt->bindParam(5, $statusarqueo);
		$stmt->bindParam(6, $codarqueo);

		$dineroefectivo = limpiar($_POST["dineroefectivo"]);
		$diferencia = limpiar($_POST["diferencia"]);
		$comentarios = limpiar($_POST['comentarios']);
		$fechacierre = limpiar(date("Y-m-d H:i:s",strtotime($_POST['fecharegistro2'])));
		$statusarqueo = limpiar("0");
		$codarqueo = limpiar($_POST["codarqueo"]);
		$stmt->execute();

	echo "<span class='fa fa-check-square-o'></span> EL CIERRE DE CAJA FUE REALIZADO EXITOSAMENTE <a href='reportepdf?codarqueo=".encrypt($codarqueo)."&tipo=".encrypt("TICKETCIERRE")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR TICKET</strong></font color></a></div>";

	echo "<script>window.open('reportepdf?codarqueo=".encrypt($codarqueo)."&tipo=".encrypt("TICKETCIERRE")."', '_blank');</script>";
	exit;

	} else {

		echo "2";
		exit;
    }
}
######################### FUNCION PARA CERRAR ARQUEO DE CAJA ######################

######################### FUNCION PARA ACTUALIZAR ARQUEO DE CAJA #########################
public function ActualizarArqueoCaja()
{
	self::SetNames();
	if(empty($_POST["codarqueo"]) or empty($_POST["dineroefectivo"]))
	{
		echo "1";
		exit;
	}

	if($_POST["dineroefectivo"] != 0.00 || $_POST["dineroefectivo"] != 0){

		$sql = "UPDATE arqueocaja SET "
		." dineroefectivo = ?, "
		." diferencia = ?, "
		." comentarios = ? "
		." WHERE "
		." codarqueo = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $dineroefectivo);
		$stmt->bindParam(2, $diferencia);
		$stmt->bindParam(3, $comentarios);
		$stmt->bindParam(4, $codarqueo);

		$dineroefectivo = limpiar($_POST["dineroefectivo"]);
		$diferencia = limpiar($_POST["diferencia"]);
		$comentarios = limpiar($_POST['comentarios']);
		$codarqueo = limpiar($_POST["codarqueo"]);
		$stmt->execute();

	echo "<span class='fa fa-check-square-o'></span> EL ARQUEO DE CAJA FUE ACTUALIZADO EXITOSAMENTE <a href='reportepdf?codarqueo=".encrypt($codarqueo)."&tipo=".encrypt("TICKETCIERRE")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR TICKET</strong></font color></a></div>";

	echo "<script>window.open('reportepdf?codarqueo=".encrypt($codarqueo)."&tipo=".encrypt("TICKETCIERRE")."', '_blank');</script>";
	exit;

	} else {

		echo "2";
		exit;
    }
}
######################### FUNCION PARA ACTUALIZAR ARQUEO DE CAJA ######################

###################### FUNCION BUSCAR ARQUEOS DE CAJA POR FECHAS ######################
public function BuscarArqueosxFechas() 
{
	self::SetNames();		
	$sql = "SELECT * FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo 
	LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda  
	WHERE sucursales.codsucursal = ? 
	AND arqueocaja.codcaja = ? 
	AND DATE_FORMAT(arqueocaja.fechaapertura,'%Y-%m-%d') BETWEEN ? AND ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim(decrypt($_GET['codcaja'])));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(4, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON ARQUEOS DE CAJAS PARA LAS FECHAS SELECCIONADAS</div></center>";
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
    }
}
######################## FUNCION BUSCAR ARQUEOS DE CAJA POR FECHAS ####################

############################# FIN DE CLASE ARQUEOS DE CAJA ###########################



























############################ CLASE MOVIMIENTOS EN CAJAS ##############################

###################### FUNCION PARA REGISTRAR MOVIMIENTO EN CAJA #######################
public function RegistrarMovimientos()
{
	self::SetNames();
	if(empty($_POST["codcaja"]) or empty($_POST["tipomovimiento"]) or empty($_POST["montomovimiento"]) or empty($_POST["descripcionmovimiento"]) or empty($_POST["codmediopago"]))
	{
		echo "1";
		exit;
	}
	elseif($_POST["montomovimiento"] == "" || $_POST["montomovimiento"] == 0 || $_POST["montomovimiento"] == 0.00)
	{
		echo "2";
		exit;

	}
	
	####################### VERIFICO ARQUEO DE CAJA #######################
	$sql = "SELECT * FROM arqueocaja 
	WHERE codcaja = ? AND statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_POST["codcaja"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "4";
		exit;

	} else {
		
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		$arqueo = $row['codarqueo'];
		$inicial = $row['montoinicial'];
		$ingreso = $row['ingresos'];
		$egreso = $row['egresos'];
		$abono = $row['abonos'];
		$total = $inicial+$ingreso+$abono-$egreso;
	}
    ####################### VERIFICO ARQUEO DE CAJA #######################

    ################ CREO Nº DE MOVIMIENTO ####################
	$sql = "SELECT numero FROM movimientoscajas
	WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
	ORDER BY codmovimiento DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$documento=$row["numero"];

	}
	if(empty($documento))
	{
		$numero = "01";

	} else {

		$num = substr($documento, 0);
		$digitos = $num + 1;
		$numfinal = str_pad($digitos, 2, "0", STR_PAD_LEFT);
		$numero = $numfinal;
	}
    ################ CREO Nº DE MOVIMIENTO ###############

	//REALIZO LA CONDICION SI EL MOVIMIENTO ES UN INGRESO
	if($_POST["tipomovimiento"]=="INGRESO"){ 

		######################## ACTUALIZO DATOS EN ARQUEO ########################
		$sql = " UPDATE arqueocaja SET "
		." ingresos = ? "
		." WHERE "
		." codcaja = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtIngresos);
		$stmt->bindParam(2, $codcaja);

		$txtIngresos = number_format($_POST["montomovimiento"] + $ingreso, 2, '.', '');
		$codcaja = limpiar(decrypt($_POST["codcaja"]));
		$stmt->execute();
		######################## ACTUALIZO DATOS EN ARQUEO ########################

		######################## REGISTRO EL MOVIMIENTOS EN CAJA ########################
		$query = "INSERT INTO movimientoscajas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $numero);
		$stmt->bindParam(2, $codcaja);
		$stmt->bindParam(3, $tipomovimiento);
		$stmt->bindParam(4, $descripcionmovimiento);
		$stmt->bindParam(5, $montomovimiento);
		$stmt->bindParam(6, $codmediopago);
		$stmt->bindParam(7, $fechamovimiento);
		$stmt->bindParam(8, $arqueo);
		$stmt->bindParam(9, $codsucursal);

		$codcaja = limpiar(decrypt($_POST["codcaja"]));
		$tipomovimiento = limpiar($_POST["tipomovimiento"]);
		$descripcionmovimiento = limpiar($_POST["descripcionmovimiento"]);
		$montomovimiento = limpiar($_POST["montomovimiento"]);
		$codmediopago = limpiar($_POST["codmediopago"]);
		$fechamovimiento = limpiar(date("Y-m-d H:i:s",strtotime($_POST['fecharegistro'])));
		$codsucursal = limpiar($_SESSION["codsucursal"]);
		$stmt->execute();
		######################## REGISTRO EL MOVIMIENTOS EN CAJA ########################

	//REALIZO LA CONDICION SI EL MOVIMIENTO ES UN EGRESO
	} else { 

	    if($_POST["montomovimiento"]>$total){

			echo "6";
			exit;

        } else {

		######################## ACTUALIZO DATOS EN ARQUEO ########################
        $sql = "UPDATE arqueocaja SET "
		." egresos = ? "
		." WHERE "
		." codcaja = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtEgresos);
		$stmt->bindParam(2, $codcaja);

		$txtEgresos = number_format($egresos + $_POST["montomovimiento"], 2, '.', '');
		$codcaja = limpiar(decrypt($_POST["codcaja"]));
		$stmt->execute();
		######################## ACTUALIZO DATOS EN ARQUEO ########################

		######################## REGISTRO EL MOVIMIENTOS EN CAJA ########################
		$query = "INSERT INTO movimientoscajas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $numero);
		$stmt->bindParam(2, $codcaja);
		$stmt->bindParam(3, $tipomovimiento);
		$stmt->bindParam(4, $descripcionmovimiento);
		$stmt->bindParam(5, $montomovimiento);
		$stmt->bindParam(6, $codmediopago);
		$stmt->bindParam(7, $fechamovimiento);
		$stmt->bindParam(8, $arqueo);
		$stmt->bindParam(9, $codsucursal);

		$codcaja = limpiar(decrypt($_POST["codcaja"]));
		$tipomovimiento = limpiar($_POST["tipomovimiento"]);
		$descripcionmovimiento = limpiar($_POST["descripcionmovimiento"]);
		$montomovimiento = limpiar($_POST["montomovimiento"]);
		$codmediopago = limpiar($_POST["codmediopago"]);
		$fechamovimiento = limpiar(date("Y-m-d H:i:s",strtotime($_POST['fecharegistro'])));
		$codsucursal = limpiar($_SESSION["codsucursal"]);
		$stmt->execute();
		######################## REGISTRO EL MOVIMIENTOS EN CAJA ########################

	     }
	}

	echo "<span class='fa fa-check-square-o'></span> EL MOVIMIENTO EN CAJA HA SIDO REGISTRADO EXITOSAMENTE <a href='reportepdf?numero=".encrypt($numero)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("TICKETMOVIMIENTO")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR TICKET</strong></font color></a></div>";

    echo "<script>window.open('reportepdf?numero=".encrypt($numero)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("TICKETMOVIMIENTO")."', '_blank');</script>";
	exit;	 
}
##################### FUNCION PARA REGISTRAR MOVIMIENTO EN CAJA #######################

###################### FUNCION PARA LISTAR MOVIMIENTO EN CAJA #######################
public function ListarMovimientos()
{
	self::SetNames();
	
	if($_SESSION['acceso'] == "administradorS" || $_SESSION['acceso'] == "secretaria") {

    $sql = " SELECT * FROM movimientoscajas 
    INNER JOIN cajas ON movimientoscajas.codcaja = cajas.codcaja
    LEFT JOIN arqueocaja ON movimientoscajas.codarqueo = arqueocaja.codarqueo 
    LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo 
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN mediospagos ON mediospagos.codmediopago = movimientoscajas.codmediopago
    WHERE usuarios.codsucursal = '".limpiar($_SESSION["codsucursal"])."'";
    foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

	} else if($_SESSION["acceso"] == "cajero") {

	$sql = " SELECT * FROM movimientoscajas 
    INNER JOIN cajas ON movimientoscajas.codcaja = cajas.codcaja
    LEFT JOIN arqueocaja ON movimientoscajas.codarqueo = arqueocaja.codarqueo 
    LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo 
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN mediospagos ON mediospagos.codmediopago = movimientoscajas.codmediopago
    WHERE usuarios.codsucursal = '".limpiar($_SESSION["codigo"])."'";
    foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

	} else {

	$sql = " SELECT * FROM movimientoscajas 
    INNER JOIN cajas ON movimientoscajas.codcaja = cajas.codcaja
    LEFT JOIN arqueocaja ON movimientoscajas.codarqueo = arqueocaja.codarqueo 
    LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo 
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN mediospagos ON mediospagos.codmediopago = movimientoscajas.codmediopago";
    foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

	}
}
###################### FUNCION PARA LISTAR MOVIMIENTO EN CAJA ######################

########################## FUNCION ID MOVIMIENTO EN CAJA #############################
public function MovimientosPorId()
{
	self::SetNames();
	$sql = "SELECT 
	movimientoscajas.codmovimiento,
	movimientoscajas.numero,
	movimientoscajas.codcaja,
	movimientoscajas.tipomovimiento,
	movimientoscajas.descripcionmovimiento,
	movimientoscajas.montomovimiento,
	movimientoscajas.codmediopago,
	movimientoscajas.fechamovimiento,
	movimientoscajas.codarqueo,
	movimientoscajas.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.tlfsucursal,
	sucursales.correosucursal,
	sucursales.id_provincia,
	sucursales.id_departamento,
	sucursales.direcsucursal,
	sucursales.nroactividadsucursal,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	mediospagos.mediopago,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	documentos.documento,
    cajas.nrocaja,
    cajas.nomcaja,
    usuarios.dni, 
    usuarios.nombres,
    provincias.provincia,
    departamentos.departamento
	FROM movimientoscajas 
    LEFT JOIN sucursales ON movimientoscajas.codsucursal = sucursales.codsucursal
    LEFT JOIN arqueocaja ON movimientoscajas.codarqueo = arqueocaja.codarqueo
    LEFT JOIN cajas ON movimientoscajas.codcaja = cajas.codcaja
    LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN mediospagos ON mediospagos.codmediopago = movimientoscajas.codmediopago
	WHERE movimientoscajas.numero = ? AND movimientoscajas.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["numero"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################## FUNCION ID MOVIMIENTO EN CAJA #############################

##################### FUNCION PARA ACTUALIZAR MOVIMIENTOS EN CAJA ##################
public function ActualizarMovimientos()
{
	self::SetNames();
	if(empty($_POST["codmovimiento"]) or empty($_POST["codcaja"]) or empty($_POST["tipomovimiento"]) or empty($_POST["montomovimiento"]) or empty($_POST["descripcionmovimiento"]) or empty($_POST["codmediopago"]))
	{
		echo "1";
		exit;
	}
	elseif($_POST["montomovimiento"] == "" || $_POST["montomovimiento"] == 0 || $_POST["montomovimiento"] == 0.00)
	{
		echo "2";
		exit;

	}
	elseif($_POST["tipomovimiento"] != $_POST["tipomovimientobd"] || $_POST["codmediopago"] != $_POST["codmediopagobd"])
	{
		echo "3";
		exit;
	}

	####################### VERIFICO ARQUEO DE CAJA #######################
	$sql = "SELECT * FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
	WHERE arqueocaja.codarqueo = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_POST["codarqueo"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "4";
		exit;

	} else {
		
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		$inicial = $row['montoinicial'];
		$ingreso = $row['ingresos'];
		$egreso = $row['egresos'];
		$abono = $row['abonos'];
		$status = $row['statusarqueo'];
		$total = $inicial+$ingreso+$abono-$egreso;
	}
    ####################### VERIFICO ARQUEO DE CAJA #######################

	//REALIZAMOS CALCULO DE CAMPOS
	$numero = limpiar(decrypt($_POST["numero"]));
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$montomovimiento = limpiar($_POST["montomovimiento"]);
	$montomovimientobd = limpiar($_POST["montomovimientobd"]);
	$ingresobd = number_format($ingreso-$montomovimientobd, 2, '.', '');
	$totalmovimiento = number_format($montomovimiento-$montomovimientobd, 2, '.', '');

	if($status == 1) {

	//REALIZO LA CONDICION SI EL MOVIMIENTO ES UN INGRESO
	if($_POST["tipomovimiento"]=="INGRESO"){ 

	    ######################## ACTUALIZO DATOS EN ARQUEO ########################
	    $sql = "UPDATE arqueocaja SET "
		." ingresos = ? "
		." WHERE "
		." codarqueo = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtIngresos);
		$stmt->bindParam(2, $codarqueo);
		
	    $txtIngresos = number_format($ingresobd + $montomovimiento, 2, '.', '');
		$codarqueo = limpiar(decrypt($_POST["codarqueo"]));
		$stmt->execute();
		######################## ACTUALIZO DATOS EN ARQUEO ########################

	    ######################## ACTUALIZO EL MOVIMIENTOS EN CAJA ########################
	    $sql = "UPDATE movimientoscajas SET"
		." codcaja = ?, "
		." tipomovimiento = ?, "
		." descripcionmovimiento = ?, "
		." montomovimiento = ?, "
		." codmediopago = ? "
		." WHERE "
		." codmovimiento = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $codcaja);
		$stmt->bindParam(2, $tipomovimiento);
		$stmt->bindParam(3, $descripcionmovimiento);
		$stmt->bindParam(4, $montomovimiento);
		$stmt->bindParam(5, $codmediopago);
		$stmt->bindParam(6, $codmovimiento);

		$codcaja = limpiar(decrypt($_POST["codcaja"]));
		$tipomovimiento = limpiar($_POST["tipomovimiento"]);
		$descripcionmovimiento = limpiar($_POST["descripcionmovimiento"]);
		$montomovimiento = limpiar($_POST["montomovimiento"]);
		$codmediopago = limpiar($_POST["codmediopago"]);
		$codmovimiento = limpiar(decrypt($_POST["codmovimiento"]));
		$stmt->execute();
		######################## ACTUALIZO EL MOVIMIENTOS EN CAJA ########################

	//REALIZO LA CONDICION SI EL MOVIMIENTO ES UN EGRESO
	} else { 

	    if($totalmovimiento>$total){

			echo "6";
			exit;

        } else {

		######################## ACTUALIZO DATOS EN ARQUEO ########################
        $sql = "UPDATE arqueocaja SET"
		." egresos = ? "
		." WHERE "
		." codarqueo = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $egresos);
		$stmt->bindParam(2, $codarqueo);

		$txtEgresos = number_format($egreso + $totalmovimiento, 2, '.', '');
		$codarqueo = limpiar(decrypt($_POST["codarqueo"]));
		$stmt->execute();
		######################## ACTUALIZO DATOS EN ARQUEO ########################

	    ######################## ACTUALIZO EL MOVIMIENTOS EN CAJA ########################
		$sql = "UPDATE movimientoscajas SET"
		." codcaja = ?, "
		." tipomovimiento = ?, "
		." descripcionmovimiento = ?, "
		." montomovimiento = ?, "
		." codmediopago = ? "
		." WHERE "
		." codmovimiento = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $codcaja);
		$stmt->bindParam(2, $tipomovimiento);
		$stmt->bindParam(3, $descripcionmovimiento);
		$stmt->bindParam(4, $montomovimiento);
		$stmt->bindParam(5, $codmediopago);
		$stmt->bindParam(6, $codmovimiento);

		$codcaja = limpiar(decrypt($_POST["codcaja"]));
		$tipomovimiento = limpiar($_POST["tipomovimiento"]);
		$descripcionmovimiento = limpiar($_POST["descripcionmovimiento"]);
		$montomovimiento = limpiar($_POST["montomovimiento"]);
		$codmediopago = limpiar($_POST["codmediopago"]);
		$codmovimiento = limpiar(decrypt($_POST["codmovimiento"]));
		$stmt->execute();
		######################## ACTUALIZO EL MOVIMIENTOS EN CAJA ########################

	    }
	}

	echo "<span class='fa fa-check-square-o'></span> EL MOVIMIENTO EN CAJA HA SIDO ACTUALIZADO EXITOSAMENTE <a href='reportepdf?numero=".encrypt($numero)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("TICKETMOVIMIENTO")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR TICKET</strong></font color></a></div>";

    echo "<script>window.open('reportepdf?numero=".encrypt($numero)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("TICKETMOVIMIENTO")."', '_blank');</script>";
    exit;	

	} else {
		   
		echo "7";
		exit;
    }
} 
##################### FUNCION PARA ACTUALIZAR MOVIMIENTOS EN CAJA ####################	

###################### FUNCION PARA ELIMINAR MOVIMIENTOS EN CAJA ######################
public function EliminarMovimientos()
{
	if($_SESSION['acceso'] == "administradorS" || $_SESSION['acceso'] == "cajero") {

    #################### AGREGAMOS EL INGRESO A ARQUEO EN CAJA ####################
	$sql = "SELECT * FROM movimientoscajas 
	INNER JOIN arqueocaja ON movimientoscajas.codarqueo = arqueocaja.codarqueo 
	WHERE movimientoscajas.codmovimiento = '".limpiar(decrypt($_GET["codmovimiento"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	//OBTENEMOS CAMPOS DE MOVIMIENTOS
	$codcaja = $row['codcaja'];
	$codarqueo = $row['codarqueo'];
	$tipomovimiento = $row['tipomovimiento'];
	$descripcionmovimiento = $row['descripcionmovimiento'];
	$montomovimiento = $row['montomovimiento'];
	$codmediopago = $row['codmediopago'];
	$fechamovimiento = $row['fechamovimiento'];
	//OBTENEMOS CAMPOS DE MOVIMIENTOS

	//OBTENEMOS CAMPOS DE ARQUEO
	$inicial = $row['montoinicial'];
	$ingreso = $row['ingresos'];
	$egreso = $row['egresos'];
	$status = $row['statusarqueo'];
	//OBTENEMOS CAMPOS DE ARQUEO

    if($status == 1) {

        //REALIZO LA CONDICION SI EL MOVIMIENTO ES UN INGRESO
        if($tipomovimiento=="INGRESO"){

		######################## ACTUALIZO DATOS EN ARQUEO ########################
        $sql = "UPDATE arqueocaja SET"
		." ingresos = ? "
		." WHERE "
		." codcaja = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtIngresos);
		$stmt->bindParam(2, $codcaja);

	    $txtIngresos = number_format($ingreso - $montomovimiento);
		$stmt->execute();
		######################## ACTUALIZO DATOS EN ARQUEO ########################

        //REALIZO LA CONDICION SI EL MOVIMIENTO ES UN EGRESO
	    } else {

		######################## ACTUALIZO DATOS EN ARQUEO ########################
		$sql = "UPDATE arqueocaja SET "
		." egresos = ? "
		." WHERE "
		." codcaja = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtEgresos);
		$stmt->bindParam(2, $codcaja);

		$txtEgresos = number_format($egreso - $montomovimiento, 2, '.', '');
		$stmt->execute();
		######################## ACTUALIZO DATOS EN ARQUEO ########################

      }

		######################## ELIMINO EL MOVIMIENTO EN CAJA ########################
        $sql = "DELETE FROM movimientoscajas WHERE codmovimiento = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codmovimiento);
		$codmovimiento = decrypt($_GET["codmovimiento"]);
		$stmt->execute();
		######################## ELIMINO EL MOVIMIENTO EN CAJA ########################

		echo "1";
		exit;
		   
	} else {
		   
		echo "2";
		exit;
	}
			
	} else {
		
		echo "3";
		exit;
	}	
}
###################### FUNCION PARA ELIMINAR MOVIMIENTOS EN CAJAS  ####################

################## FUNCION BUSCAR MOVIMIENTOS DE CAJA POR FECHAS #######################
public function BuscarMovimientosxFechas() 
	{
	self::SetNames();
	$sql = "SELECT * FROM movimientoscajas 
	INNER JOIN cajas ON movimientoscajas.codcaja = cajas.codcaja 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo
	LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN mediospagos ON mediospagos.codmediopago = movimientoscajas.codmediopago 
	WHERE sucursales.codsucursal = ? 
	AND movimientoscajas.codcaja = ? 
	AND DATE_FORMAT(movimientoscajas.fechamovimiento,'%Y-%m-%d') BETWEEN ? AND ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim(decrypt($_GET['codcaja'])));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(4, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON MOVIMIENTOS DE CAJAS PARA LAS FECHAS SELECCIONADAS</div></center>";
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
    }
}
###################### FUNCION BUSCAR MOVIMIENTOS DE CAJA POR FECHAS ###################

######################### FIN DE CLASE MOVIMIENTOS EN CAJAS #############################



































###################################### CLASE VENTAS ###################################

############################# FUNCION REGISTRAR VENTAS ###############################
public function RegistrarVentas()
	{
	self::SetNames();
	####################### VERIFICO ARQUEO DE CAJA #######################
	$sql = "SELECT * FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
	WHERE usuarios.codigo = ? AND arqueocaja.statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_SESSION["codigo"]));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "1";
		exit;

	} else {
		
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		$codarqueo = $row['codarqueo'];
		$codcaja = $row['codcaja'];
		$ingreso = ($row['ingresos']== "" ? "0.00" : $row['ingresos']);
		$credito = ($row['creditos']== "" ? "0.00" : $row['creditos']);
		$abono = ($row['abonos']== "" ? "0.00" : $row['abonos']);
	}
    ####################### VERIFICO ARQUEO DE CAJA #######################

	if(empty($_POST["codsucursal"]) or empty($_POST["tipodocumento"]) or empty($_POST["tipopago"]))
	{
		echo "2";
		exit;
	}
	elseif(empty($_SESSION["CarritoVenta"]) || $_POST["txtTotal"]=="0.00")
	{
		echo "3";
		exit;
		
	}

	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #############
	$v = $_SESSION["CarritoVenta"];
	for($i=0;$i<count($v);$i++){

		if(limpiar($v[$i]['tipodetalle'])==1){

			$sql = "SELECT 
			existencia 
			FROM productos 
			WHERE codproducto = '".$v[$i]['txtCodigo']."' 
			AND codsucursal = '".limpiar($_POST["codsucursal"])."'";
			foreach ($this->dbh->query($sql) as $row)
			{
				$this->p[] = $row;
			}
			
			$existenciadb = $row['existencia'];
			$cantidad = $v[$i]['cantidad'];

			if ($cantidad > $existenciadb) 
			{ 
				echo "4";
				exit;
			}
		}
	}
	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #############

	################### SELECCIONE LOS DATOS DEL CLIENTE ######################
    $sql = "SELECT
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	provincias.provincia,
	departamentos.departamento,
    ROUND(SUM(if(pag.montocredito!='0',pag.montocredito,'0.00')), 2) montoactual,
    ROUND(SUM(if(pag.montocredito!='0',clientes.limitecredito-pag.montocredito,clientes.limitecredito)), 2) creditodisponible
    FROM clientes
    LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
    LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento 
    LEFT JOIN
       (SELECT
       codcliente, montocredito       
       FROM creditosxclientes 
       WHERE codsucursal = '".limpiar($_POST['codsucursal'])."') pag ON pag.codcliente = clientes.codcliente
       WHERE clientes.codcliente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST['codcliente']));
	$num = $stmt->rowCount();
	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$p[] = $row;
	}
    $tipocliente = ($row['tipocliente'] == "" ? "0" : $row['tipocliente']);
    $dnicliente = ($row['dnicliente'] == "" ? "0" : $row['dnicliente']);
    $nomcliente = ($row['nomcliente'] == "" ? "0" : $row['nomcliente']);
    $girocliente = ($row['girocliente'] == "" ? "0" : $row['girocliente']);
    $emailcliente = $row['emailcliente'];
    $limitecredito = $row['limitecredito'];
    $montoactual = $row['montoactual'];
    $creditodisponible = $row['creditodisponible'];
    $montoabono = (empty($_POST["montoabono"]) ? "0.00" : $_POST["montoabono"]);
    $total = number_format($_POST["txtTotal"]-$montoabono, 2, '.', '');
    ################### SELECCIONE LOS DATOS DEL CLIENTE ######################

    ################### VALIDO TIPO DE PAGO ES A CREDITO ######################
    if (limpiar($_POST["tipopago"]) == "CREDITO") {

    	$fechaactual = date("Y-m-d");
		$fechavence = date("Y-m-d",strtotime($_POST['fechavencecredito']));

		if ($_POST["codcliente"] == '0') { 

        echo "5";
        exit;

        } else if (strtotime($fechavence) < strtotime($fechaactual)) {

			echo "6";
			exit;

		} else if ($limitecredito != "0.00" && $total > $creditodisponible) {

            echo "7";
            exit;

        } else if($_POST["montoabono"] >= $_POST["txtTotal"]) { 

	        echo "8";
	        exit;
        }
    }
    ################### VALIDO TIPO DE PAGO ES A CREDITO ######################

	################# OBTENGO DATOS DE SUCURSAL #################
	$sql = " SELECT 
	codsucursal, 
	nroactividadsucursal,
	inicioticket,
	iniciofactura, 
	inicioguia, 
	inicionotaventa 
	FROM sucursales WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$nroactividad = $row['nroactividadsucursal'];
	$inicioticket = $row['inicioticket'];
	$iniciofactura = $row['iniciofactura'];
	$inicioguia = $row['inicioguia'];
	$inicionotaventa = $row['inicionotaventa'];
	################# OBTENGO DATOS DE SUCURSAL #################

	################ CREO CODIGO DE VENTA ####################
	$sql = "SELECT codventa FROM ventas 
	ORDER BY idventa DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$venta=$row["codventa"];

	}
	if(empty($venta))
	{
		$codventa = "01";

	} else {

		$num = substr($venta, 0);
        $dig = $num + 1;
        $codigofinal = str_pad($dig, 2, "0", STR_PAD_LEFT);
        $codventa = $codigofinal;
	}
    ################ CREO CODIGO DE VENTA ###############

    ################### CREO CODIGO DE FACTURA ####################
	$sql = "SELECT codfactura
	FROM ventas 
	WHERE codsucursal = '".limpiar($_POST["codsucursal"])."' 
	ORDER BY idventa DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$factura=$row["codfactura"];

	}
	
	if($_POST['tipodocumento']=="TICKET") {

        if(empty($factura)){ 
        	$codfactura = $nroactividad.'-'.$inicioticket;
        } else {
           $var = strlen($nroactividad."-");
           $var1 = substr($factura , $var);
           $var2 = strlen($var1);
           $var3 = $var1 + 1;
           $var4 = str_pad($var3, $var2, "0", STR_PAD_LEFT);
           $codfactura = $nroactividad.'-'.$var4;
        }
		   $codserie = limpiar($nroactividad);
		   $codautorizacion = limpiar(GenerateRandomStringg());

	} elseif($_POST['tipodocumento']=="FACTURA") {

        if(empty($factura)){ 
        	$codfactura = $nroactividad.'-'.$iniciofactura;
        } else {
           $var = strlen($nroactividad."-");
           $var1 = substr($factura , $var);
           $var2 = strlen($var1);
           $var3 = $var1 + 1;
           $var4 = str_pad($var3, $var2, "0", STR_PAD_LEFT);
           $codfactura = $nroactividad.'-'.$var4;
        }
		   $codserie = limpiar($nroactividad);
		   $codautorizacion = limpiar(GenerateRandomStringg());

	} elseif($_POST['tipodocumento']=="GUIA") {

        if(empty($factura)){ 
        	$codfactura = $nroactividad.'-'.$inicioguia;
        } else {
           $var = strlen($nroactividad."-");
           $var1 = substr($factura , $var);
           $var2 = strlen($var1);
           $var3 = $var1 + 1;
           $var4 = str_pad($var3, $var2, "0", STR_PAD_LEFT);
           $codfactura = $nroactividad.'-'.$var4;
        }
		   $codserie = limpiar($nroactividad);
		   $codautorizacion = limpiar(GenerateRandomStringg());

	} elseif($_POST['tipodocumento']=="NOTA VENTA") {

        if(empty($factura)){ 
        	$codfactura = $nroactividad.'-'.$inicionotaventa;
        } else {
           $var = strlen($nroactividad."-");
           $var1 = substr($factura , $var);
           $var2 = strlen($var1);
           $var3 = $var1 + 1;
           $var4 = str_pad($var3, $var2, "0", STR_PAD_LEFT);
           $codfactura = $nroactividad.'-'.$var4;
        }
		   $codserie = limpiar($nroactividad);
		   $codautorizacion = limpiar(GenerateRandomStringg());
	}
    ################### CREO CODIGO DE FACTURA ####################

    $fecha = date("Y-m-d H:i:s");

    $query = "INSERT INTO ventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $tipodocumento);
	$stmt->bindParam(2, $codcaja);
	$stmt->bindParam(3, $codventa);
	$stmt->bindParam(4, $codfactura);
	$stmt->bindParam(5, $codserie);
	$stmt->bindParam(6, $codautorizacion);
	$stmt->bindParam(7, $codcliente);
	$stmt->bindParam(8, $subtotalivasi);
	$stmt->bindParam(9, $subtotalivano);
	$stmt->bindParam(10, $iva);
	$stmt->bindParam(11, $totaliva);
	$stmt->bindParam(12, $descontado);
	$stmt->bindParam(13, $descuento);
	$stmt->bindParam(14, $totaldescuento);
	$stmt->bindParam(15, $totalpago);
	$stmt->bindParam(16, $totalpago2);
	$stmt->bindParam(17, $creditopagado);
	$stmt->bindParam(18, $tipopago);
	$stmt->bindParam(19, $formapago);
	$stmt->bindParam(20, $montopagado);
	$stmt->bindParam(21, $montodevuelto);
	$stmt->bindParam(22, $fechavencecredito);
	$stmt->bindParam(23, $fechapagado);
	$stmt->bindParam(24, $statusventa);
	$stmt->bindParam(25, $fechaventa);
	$stmt->bindParam(26, $observaciones);
	$stmt->bindParam(27, $notacredito);
	$stmt->bindParam(28, $codigo);
	$stmt->bindParam(29, $codsucursal);
   
	$tipodocumento = limpiar($_POST["tipodocumento"]);
	$codcaja = limpiar($_POST["codcaja"]);
	$codcliente = limpiar($_POST["codcliente"]);
	$subtotalivasi = limpiar($_POST["txtsubtotal"]);
	$subtotalivano = limpiar($_POST["txtsubtotal2"]);
	$iva = limpiar($_POST["iva"]);
	$totaliva = limpiar($_POST["txtIva"]);
	$descontado = limpiar($_POST["txtdescontado"]);
	$descuento = limpiar($_POST["descuento"]);
	$totaldescuento = limpiar($_POST["txtDescuento"]);
	$totalpago = limpiar($_POST["txtTotal"]);
	$totalpago2 = limpiar($_POST["txtTotalCompra"]);
	$creditopagado = limpiar(isset($_POST['montoabono']) ? $_POST["montoabono"] : "0.00");
	$tipopago = limpiar($_POST["tipopago"]);
	$formapago = limpiar($_POST["tipopago"]=="CONTADO" ? decrypt($_POST["codmediopago"]) : "CREDITO");
	$montopagado = limpiar(isset($_POST['montopagado']) ? $_POST["montopagado"] : "0.00");
	$montodevuelto = limpiar(isset($_POST['montodevuelto']) ? $_POST["montodevuelto"] : "0.00");
	$fechavencecredito = limpiar($_POST["tipopago"]=="CREDITO" ? date("Y-m-d",strtotime($_POST['fechavencecredito'])) : "0000-00-00");
    $fechapagado = limpiar("0000-00-00");
    $statusventa = limpiar($_POST["tipopago"]=="CONTADO" ? "PAGADA" : "PENDIENTE");
    $fechaventa = limpiar($fecha);
	$observaciones = limpiar($_POST["observaciones"]);
	$notacredito = limpiar("0");
	$codigo = limpiar($_SESSION["codigo"]);
	$codsucursal = limpiar($_POST["codsucursal"]);
	$stmt->execute();

	$this->dbh->beginTransaction();
	$detalle = $_SESSION["CarritoVenta"];
	for($i=0;$i<count($detalle);$i++){

	$query = "INSERT INTO detalleventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codventa);
    $stmt->bindParam(2, $idproducto);
    $stmt->bindParam(3, $codproducto);
    $stmt->bindParam(4, $producto);
    $stmt->bindParam(5, $codmarca);
    $stmt->bindParam(6, $codmodelo);
    $stmt->bindParam(7, $codpresentacion);
	$stmt->bindParam(8, $cantidad);
	$stmt->bindParam(9, $preciocompra);
	$stmt->bindParam(10, $precioventa);
	$stmt->bindParam(11, $ivaproducto);
	$stmt->bindParam(12, $descproducto);
	$stmt->bindParam(13, $valortotal);
	$stmt->bindParam(14, $totaldescuentov);
	$stmt->bindParam(15, $valorneto);
	$stmt->bindParam(16, $valorneto2);
    $stmt->bindParam(17, $tipodetalle);
	$stmt->bindParam(18, $codsucursal);
		
	$idproducto = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['id'] : "0");
	$codproducto = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['txtCodigo'] : "0");
	$producto = limpiar($detalle[$i]['producto']);
	$codmarca = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['codmarca'] : "0");
	$codmodelo = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['codmodelo'] : "0");
	$codpresentacion = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['codpresentacion'] : "0");
	$cantidad = limpiar($detalle[$i]['cantidad']);
	$preciocompra = limpiar($detalle[$i]['precio']);
	$precioventa = limpiar($detalle[$i]['precio2']);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$descuento = $detalle[$i]['descproducto']/100;
	$valortotal = number_format($detalle[$i]['precio2']*$detalle[$i]['cantidad'], 2, '.', '');
	$totaldescuentov = number_format($valortotal*$descuento, 2, '.', '');
    $valorneto = number_format($valortotal-$totaldescuentov, 2, '.', '');
	$valorneto2 = limpiar($detalle[$i]['tipodetalle'] == "1" ? number_format($detalle[$i]['precio']*$detalle[$i]['cantidad'], 2, '.', '') : "0.00");
    $tipodetalle = limpiar($detalle[$i]['tipodetalle']);
	$codsucursal = limpiar($_SESSION["codsucursal"]);
	$stmt->execute();

	if(limpiar($detalle[$i]['tipodetalle'])==1){

	################ VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ################
	$sql = "SELECT * FROM productos 
	WHERE codproducto = '".limpiar($detalle[$i]['txtCodigo'])."'
	AND codsucursal = '".limpiar($_POST['codsucursal'])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$existenciabd = $row['existencia'];
    ################ VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ################

	##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
	$sql = " UPDATE productos set "
	." existencia = ? "
	." where "
	." codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' 
	AND codsucursal = '".limpiar($_POST["codsucursal"])."';
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $existencia);
	$cantraspaso = limpiar($detalle[$i]['cantidad']);
	$existencia = $existenciabd-$cantraspaso;
	$stmt->execute();
    ##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
    	
    }


	############### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###############
    $query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codventa);
	$stmt->bindParam(2, $codcliente);
	$stmt->bindParam(3, $codproducto);
	$stmt->bindParam(4, $movimiento);
	$stmt->bindParam(5, $entradas);
	$stmt->bindParam(6, $salidas);
	$stmt->bindParam(7, $devolucion);
	$stmt->bindParam(8, $stockactual);
	$stmt->bindParam(9, $ivaproducto);
	$stmt->bindParam(10, $descproducto);
	$stmt->bindParam(11, $precio);
	$stmt->bindParam(12, $documento);
	$stmt->bindParam(13, $fechakardex);	
    $stmt->bindParam(14, $tipokardex);			
	$stmt->bindParam(15, $codsucursal);

	$codcliente = limpiar($_POST["codcliente"]);
	$codproducto = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['txtCodigo'] : "0");
	$movimiento = limpiar("SALIDAS");
	$entradas = limpiar("0");
	$salidas= limpiar($detalle[$i]['cantidad']);
	$devolucion = limpiar("0");
	$stockactual = limpiar($detalle[$i]['tipodetalle'] == 1 ? $existenciabd-$detalle[$i]['cantidad'] : "0");
	$precio = limpiar($detalle[$i]["precio2"]);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$documento = limpiar("VENTA: ".$codventa);
	$fechakardex = limpiar(date("Y-m-d"));
    $tipokardex = limpiar($detalle[$i]['tipodetalle']);
	$codsucursal = limpiar($_POST["codsucursal"]);
	$stmt->execute();
	############### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###############
  }
		
	####################### DESTRUYO LA VARIABLE DE SESSION #####################
	unset($_SESSION["CarritoVenta"]);
    $this->dbh->commit();

    ################ AGREGAMOS EL INGRESO DE VENTAS PAGADAS A CAJA ##############
	if (limpiar($_POST["tipopago"]=="CONTADO")){

		$sql = "UPDATE arqueocaja set "
		." ingresos = ? "
		." WHERE "
		." codarqueo = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtTotal);
		$stmt->bindParam(2, $codarqueo);

		$txtTotal = number_format($_POST["txtTotal"]+$ingreso, 2, '.', '');
		$stmt->execute();
	}
    ################ AGREGAMOS EL INGRESO DE VENTAS PAGADAS A CAJA ################

    ########## AGREGAMOS EL INGRESO Y ABONOS DE VENTAS A CREDITOS A CAJA ##########
	if (limpiar($_POST["tipopago"]=="CREDITO" && $_POST["montoabono"]=="0.00" && $_POST["montoabono"]=="0")) {

		$sql = " UPDATE arqueocaja SET "
		." creditos = ? "
		." where "
		." codarqueo = ? and statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtTotal);
		$stmt->bindParam(2, $codarqueo);

		$txtTotal = number_format($_POST["txtTotal"]+$credito, 2, '.', '');
		$stmt->execute(); 

		$sql = " SELECT codcliente FROM creditosxclientes WHERE codcliente = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codcliente"],$_POST["codsucursal"]));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = "INSERT INTO creditosxclientes values (null, ?, ?, ?);";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codcliente);
			$stmt->bindParam(2, $montocredito);
			$stmt->bindParam(3, $codsucursal);

			$codcliente = limpiar($_POST["codcliente"]);
			$montocredito = number_format($_POST["txtTotal"]-$_POST["montoabono"], 2, '.', '');
			$codsucursal = limpiar($_POST["codsucursal"]);
			$stmt->execute();

		} else { 

			$sql = "UPDATE creditosxclientes set"
			." montocredito = ? "
			." where "
			." codcliente = ? AND codsucursal = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $montocredito);
			$stmt->bindParam(2, $codcliente);
			$stmt->bindParam(3, $codsucursal);

			$montocredito = number_format($montoactual+($_POST["txtTotal"]-$_POST["montoabono"]), 2, '.', '');
			$codcliente = limpiar($_POST["codcliente"]);
			$codsucursal = limpiar($_POST["codsucursal"]);
			$stmt->execute();
		}

	} else if (limpiar($_POST["tipopago"]=="CREDITO" && $_POST["montoabono"]!="0.00" && $_POST["montoabono"]!="0")) { 

		$sql = " UPDATE arqueocaja SET "
		." creditos = ?, "
		." abonos = ? "
		." where "
		." codarqueo = ? and statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtTotal);
		$stmt->bindParam(2, $totalabono);
		$stmt->bindParam(3, $codarqueo);

		$TotalCredito = number_format($_POST["txtTotal"]-$_POST["montoabono"], 2, '.', '');
		$txtTotal = number_format($TotalCredito+$credito, 2, '.', '');
		$totalabono = number_format($_POST["montoabono"]+$abono, 2, '.', '');
		$stmt->execute();

		$query = "INSERT INTO abonoscreditosventas values (null, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcaja);
		$stmt->bindParam(2, $codventa);
		$stmt->bindParam(3, $codcliente);
		$stmt->bindParam(4, $montoabono);
		$stmt->bindParam(5, $fechaabono);
		$stmt->bindParam(6, $codsucursal);

		$codcliente = limpiar($_POST["codcliente"]);
		$montoabono = number_format($_POST["montoabono"], 2, '.', '');
		$fechaabono = limpiar($fecha);
		$codsucursal = limpiar($_POST["codsucursal"]);
		$stmt->execute();

		$sql = " SELECT codcliente FROM creditosxclientes WHERE codcliente = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codcliente"],$_POST["codsucursal"]));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = "INSERT INTO creditosxclientes values (null, ?, ?, ?);";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codcliente);
			$stmt->bindParam(2, $montocredito);
			$stmt->bindParam(3, $codsucursal);

			$codcliente = limpiar($_POST["codcliente"]);
			$montocredito = number_format($_POST["txtTotal"]-$_POST["montoabono"], 2, '.', '');
			$codsucursal = limpiar($_POST["codsucursal"]);
			$stmt->execute();

		} else { 

			$sql = "UPDATE creditosxclientes set"
			." montocredito = ? "
			." where "
			." codcliente = ? AND codsucursal = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $montocredito);
			$stmt->bindParam(2, $codcliente);
			$stmt->bindParam(3, $codsucursal);

			$montocredito = number_format($montoactual+($_POST["txtTotal"]-$_POST["montoabono"]), 2, '.', '');
			$codcliente = limpiar($_POST["codcliente"]);
			$codsucursal = limpiar($_POST["codsucursal"]);
			$stmt->execute();
		}
	}
    ########### AGREGAMOS EL INGRESO Y ABONOS DE VENTAS A CREDITOS A CAJA #########

    echo "<span class='fa fa-check-square-o'></span> LA VENTA DE PRODUCTOS HA SIDO REGISTRADA EXITOSAMENTE <a href='reportepdf?codventa=".encrypt($codventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt($tipodocumento)."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

    echo "<script>window.open('reportepdf?codventa=".encrypt($codventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt($tipodocumento)."', '_blank');</script>";
	exit;
}
########################### FUNCION REGISTRAR VENTAS ################################

########################## FUNCION BUSQUEDA DE VENTAS ###############################
public function BusquedaVentas() 
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql ="SELECT 
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa,
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descontado,
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,  
	ventas.notacredito, 
	ventas.codsucursal, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	usuarios.dni,
	usuarios.nombres,
	cajas.nrocaja,
	cajas.nomcaja,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	mediospagos.mediopago,
	SUM(detalleventas.cantventa) AS articulos 
	FROM (ventas LEFT JOIN detalleventas ON detalleventas.codventa = ventas.codventa)
	INNER JOIN cajas ON ventas.codcaja = cajas.codcaja 
	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN mediospagos ON ventas.formapago = mediospagos.codmediopago 
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	WHERE CONCAT(ventas.codventa, ' ',ventas.codfactura, ' ',ventas.tipodocumento, ' ',ventas.totalpago, ' ',cajas.nrocaja, ' ',cajas.nomcaja, ' ',if(ventas.codcliente='0','0',clientes.dnicliente), ' ',if(ventas.codcliente='0','0',clientes.nomcliente), ' ',if(ventas.codcliente='0','0',clientes.girocliente), ' ',sucursales.cuitsucursal, ' ',sucursales.nomsucursal, ' ',sucursales.dniencargado, ' ',sucursales.nomencargado) LIKE '%".limpiar($_GET['bventas'])."%'
	GROUP BY detalleventas.codventa 
	ORDER BY ventas.idventa DESC LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BUSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
  } else {

  	$sql ="SELECT 
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa,
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descontado,
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,  
	ventas.notacredito, 
	ventas.codsucursal, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	usuarios.dni,
	usuarios.nombres,
	cajas.nrocaja,
	cajas.nomcaja,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	mediospagos.mediopago,
	SUM(detalleventas.cantventa) AS articulos 
	FROM (ventas LEFT JOIN detalleventas ON detalleventas.codventa = ventas.codventa)
	INNER JOIN cajas ON ventas.codcaja = cajas.codcaja 
	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN mediospagos ON ventas.formapago = mediospagos.codmediopago 
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	WHERE CONCAT(ventas.codventa, ' ',ventas.codfactura, ' ',ventas.tipodocumento, ' ',ventas.totalpago, ' ',cajas.nrocaja, ' ',cajas.nomcaja, ' ',if(ventas.codcliente='0','0',clientes.dnicliente), ' ',if(ventas.codcliente='0','0',clientes.nomcliente), ' ',if(ventas.codcliente='0','0',clientes.girocliente), ' ',sucursales.cuitsucursal, ' ',sucursales.nomsucursal, ' ',sucursales.dniencargado, ' ',sucursales.nomencargado) LIKE '%".limpiar($_GET['bventas'])."%'
	AND ventas.codsucursal = '".limpiar($_SESSION["codsucursal"])."'
	GROUP BY detalleventas.codventa 
	ORDER BY ventas.idventa DESC LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BUSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	    }
    }
}
########################## FUNCION BUSQUEDA DE VENTAS ###############################

########################## FUNCION LISTAR VENTAS ################################
public function ListarVentas()
{
	self::SetNames();

if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT 
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa,
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descontado,
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,  
	ventas.notacredito, 
	ventas.codsucursal, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	usuarios.dni,
	usuarios.nombres,
	cajas.nrocaja,
	cajas.nomcaja,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	mediospagos.mediopago,
	SUM(detalleventas.cantventa) AS articulos 
	FROM (ventas LEFT JOIN detalleventas ON detalleventas.codventa = ventas.codventa)
	INNER JOIN cajas ON ventas.codcaja = cajas.codcaja 
	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN mediospagos ON ventas.formapago = mediospagos.codmediopago 
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo 
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	GROUP BY ventas.codventa";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

 } else if($_SESSION["acceso"] == "cajero") {

	$sql = "SELECT 
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa,
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descontado,
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,  
	ventas.notacredito, 
	ventas.codsucursal, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	usuarios.dni,
	usuarios.nombres,
	cajas.nrocaja,
	cajas.nomcaja,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	mediospagos.mediopago,
	SUM(detalleventas.cantventa) AS articulos 
	FROM (ventas LEFT JOIN detalleventas ON detalleventas.codventa = ventas.codventa)
	INNER JOIN cajas ON ventas.codcaja = cajas.codcaja 
	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN mediospagos ON ventas.formapago = mediospagos.codmediopago 
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2  
	WHERE ventas.codigo = '".limpiar($_SESSION["codigo"])."'
	GROUP BY ventas.codventa";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

  } else {

   $sql = "SELECT 
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa,
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descontado,
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,  
	ventas.notacredito, 
	ventas.codsucursal, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	usuarios.dni,
	usuarios.nombres,
	cajas.nrocaja,
	cajas.nomcaja,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	mediospagos.mediopago,
	SUM(detalleventas.cantventa) AS articulos 
	FROM (ventas LEFT JOIN detalleventas ON detalleventas.codventa = ventas.codventa)
	INNER JOIN cajas ON ventas.codcaja = cajas.codcaja 
	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN mediospagos ON ventas.formapago = mediospagos.codmediopago 
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2  
	WHERE ventas.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
	GROUP BY ventas.codventa";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
   }
}
############################ FUNCION LISTAR VENTAS ############################

############################ FUNCION ID VENTAS #################################
public function VentasPorId()
	{
	self::SetNames();
	$sql = "SELECT 
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa,
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
    ventas.descontado, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
    ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
    ventas.observaciones,  
    ventas.notacredito,   
	ventas.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.tlfsucursal,
	sucursales.correosucursal,
	sucursales.id_provincia,
	sucursales.id_departamento,
	sucursales.direcsucursal,
	sucursales.nroactividadsucursal,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia AS id_provincia2, 
	clientes.id_departamento AS id_departamento2,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
    documentos2.documento AS documento2, 
    documentos3.documento AS documento3,
    cajas.nrocaja,
    cajas.nomcaja,
    mediospagos.mediopago,
    usuarios.dni, 
    usuarios.nombres,
    provincias.provincia,
    departamentos.departamento,
    provincias2.provincia AS provincia2,
    departamentos2.departamento AS departamento2,
	ROUND(SUM(if(pag.montocredito!='0',pag.montocredito,'0.00')), 2) montoactual,
    ROUND(SUM(if(pag.montocredito!='0',clientes.limitecredito-pag.montocredito,clientes.limitecredito)), 2) creditodisponible,
    pag2.abonototal
    FROM (ventas INNER JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal)
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento 
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON clientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON clientes.id_departamento = departamentos2.id_departamento 
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja
	LEFT JOIN mediospagos ON ventas.formapago = mediospagos.codmediopago 
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo

	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
    
    LEFT JOIN
        (SELECT
        codcliente, montocredito       
        FROM creditosxclientes 
        WHERE codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."') pag ON pag.codcliente = clientes.codcliente
    
    LEFT JOIN
        (SELECT
        codventa, codcliente, SUM(if(montoabono!='0',montoabono,'0.00')) AS abonototal
        FROM abonoscreditosventas 
        WHERE codventa = '".limpiar(decrypt($_GET["codventa"]))."' AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."') pag2 ON pag2.codcliente = clientes.codcliente

        WHERE ventas.codventa = ? AND ventas.codsucursal = ?";
    $stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codventa"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID VENTAS #################################
	
########################### FUNCION VER DETALLES VENTAS ##########################
public function VerDetallesVentas()
	{
	self::SetNames();
	$sql = "SELECT
	detalleventas.coddetalleventa,
	detalleventas.codventa,
	detalleventas.idproducto,
	detalleventas.codproducto,
	detalleventas.producto,
	detalleventas.codmarca,
	detalleventas.codmodelo,
	detalleventas.codpresentacion,
	detalleventas.cantventa,
	detalleventas.preciocompra,
	detalleventas.precioventa,
	detalleventas.ivaproducto,
	detalleventas.descproducto,
	detalleventas.valortotal, 
	detalleventas.totaldescuentov,
	detalleventas.valorneto,
	detalleventas.valorneto2,
	detalleventas.tipodetalle,
	detalleventas.codsucursal,
	marcas.nommarca,
	modelos.nommodelo,
	presentaciones.nompresentacion
	FROM detalleventas  
	LEFT JOIN marcas ON detalleventas.codmarca = marcas.codmarca
	LEFT JOIN modelos ON detalleventas.codmodelo = modelos.codmodelo 
	LEFT JOIN presentaciones ON detalleventas.codpresentacion = presentaciones.codpresentacion 
	WHERE detalleventas.codventa = ? 
	AND detalleventas.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codventa"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$this->p[]=$row;
	}
	return $this->p;
	$this->dbh=null;
}
############################ FUNCION VER DETALLES VENTAS #######################

############################# FUNCION ACTUALIZAR VENTAS ##########################
public function ActualizarVentas()
	{
	self::SetNames();
	if(empty($_POST["codventa"]) or empty($_POST["codsucursal"]))
	{
		echo "1";
		exit;
	}

    ############ CONSULTO TOTAL ACTUAL ##############
	$sql = "SELECT totalpago FROM ventas WHERE codventa = '".limpiar($_POST["codventa"])."' AND codsucursal = '".limpiar($_POST["codsucursal"])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$totalpagobd = $row['totalpago'];
	############ CONSULTO TOTAL ACTUAL ##############

    ################### SELECCIONE LOS DATOS DEL CLIENTE ######################
    $sql = "SELECT
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	provincias.provincia,
	departamentos.departamento,
    ROUND(SUM(if(pag.montocredito!='0',pag.montocredito,'0.00')), 2) montoactual,
    ROUND(SUM(if(pag.montocredito!='0',clientes.limitecredito-pag.montocredito,clientes.limitecredito)), 2) creditodisponible
    FROM clientes
    LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
    LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento 
    LEFT JOIN
       (SELECT
       codcliente, montocredito       
       FROM creditosxclientes 
       WHERE codsucursal = '".limpiar($_POST['codsucursal'])."') pag ON pag.codcliente = clientes.codcliente
       WHERE clientes.codcliente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST['codcliente']));
	$num = $stmt->rowCount();
	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$p[] = $row;
	}
    $tipocliente = ($row['tipocliente'] == "" ? "0" : $row['tipocliente']);
    $dnicliente = ($row['dnicliente'] == "" ? "0" : $row['dnicliente']);
    $nomcliente = ($row['nomcliente'] == "" ? "0" : $row['nomcliente']);
    $girocliente = ($row['girocliente'] == "" ? "0" : $row['girocliente']);
    $emailcliente = $row['emailcliente'];
    $limitecredito = $row['limitecredito'];
    $montoactual = $row['montoactual'];
    $creditodisponible = $row['creditodisponible'];
    $montoabono = (empty($_POST["montoabono"]) ? "0.00" : $_POST["montoabono"]);
    $total = number_format($_POST["txtTotal"]-$montoabono, 2, '.', '');
    ################### SELECCIONE LOS DATOS DEL CLIENTE ######################

	for($i=0;$i<count($_POST['coddetalleventa']);$i++){  //recorro el array
		if (!empty($_POST['coddetalleventa'][$i])) {

			if($_POST['cantventa'][$i]==0){

				echo "2";
				exit();

			}
		}
	}

    if ($_POST["tipopago"] == "CREDITO") {

  
	   /*if ($limitecredito != "0.00" && $total > $creditodisponible) {

           echo "3";
	       exit;

        }*/ 
    }

    $this->dbh->beginTransaction();
    for($i=0;$i<count($_POST['coddetalleventa']);$i++){  //recorro el array
    if (!empty($_POST['coddetalleventa'][$i])) {

    $sql = "SELECT cantventa FROM detalleventas WHERE coddetalleventa = '".limpiar($_POST['coddetalleventa'][$i])."' AND codventa = '".limpiar($_POST["codventa"])."' AND codsucursal = '".limpiar($_POST["codsucursal"])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	
	$cantidadbd = $row['cantventa'];

    if($cantidadbd != $_POST['cantventa'][$i]){

    if($_POST['tipodetalle'][$i] == 1){

    ############## VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #############
    $sql = "SELECT existencia 
    FROM productos 
    WHERE codproducto = '".limpiar($_POST['codproducto'][$i])."' 
    AND codsucursal = '".limpiar($_POST["codsucursal"])."'";
	    foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$existenciabd = $row['existencia'];
	$cantventa = $_POST["cantventa"][$i];
	$cantidadventabd = $_POST["cantidadventabd"][$i];
	$totalventa = $cantventa-$cantidadventabd;
	############## VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #############

	    if ($totalventa > $existenciabd) 
	    { 
		    echo "4";
		    exit;
	    }
	}

    $query = "UPDATE detalleventas set"
	." cantventa = ?, "
	." valortotal = ?, "
	." totaldescuentov = ?, "
	." valorneto = ?, "
	." valorneto2 = ? "
	." WHERE "
	." coddetalleventa = ? AND codventa = ? AND codsucursal = ?;
	";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $cantventa);
	$stmt->bindParam(2, $valortotal);
	$stmt->bindParam(3, $totaldescuentov);
	$stmt->bindParam(4, $valorneto);
	$stmt->bindParam(5, $valorneto2);
	$stmt->bindParam(6, $coddetalleventa);
	$stmt->bindParam(7, $codventa);
	$stmt->bindParam(8, $codsucursal);

	$cantventa = limpiar($_POST['cantventa'][$i]);
	$preciocompra = limpiar($_POST['preciocompra'][$i]);
	$precioventa = limpiar($_POST['precioventa'][$i]);
	$ivaproducto = limpiar($_POST['ivaproducto'][$i]);
	$descuento = $_POST['descproducto'][$i]/100;
	$valortotal = number_format($_POST['valortotal'][$i], 2, '.', '');
	$totaldescuento = number_format($_POST['totaldescuentov'][$i], 2, '.', '');
	$valorneto = number_format($_POST['valorneto'][$i], 2, '.', '');
	$valorneto2 = number_format($_POST['valorneto2'][$i], 2, '.', '');
	$coddetalleventa = limpiar($_POST['coddetalleventa'][$i]);
	$codventa = limpiar($_POST["codventa"]);
	$codsucursal = limpiar($_POST["codsucursal"]);
	$stmt->execute();

	if($_POST['tipodetalle'][$i] == 1){

	############### ACTUALIZAMOS EXISTENCIA DEL PRODUCTO EN ALMACEN #################
	$sql2 = " UPDATE productos set "
	." existencia = ? "
	." WHERE "
	." codproducto = '".limpiar($_POST["codproducto"][$i])."' AND codsucursal = '".limpiar($_POST["codsucursal"])."';
	";
	$stmt = $this->dbh->prepare($sql2);
	$stmt->bindParam(1, $existencia);
	$existencia = $existenciabd-$totalventa;
	$stmt->execute();
    ############### ACTUALIZAMOS EXISTENCIA DEL PRODUCTO EN ALMACEN #################

    }

	################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX ###################
	$sql3 = " UPDATE kardex set "
	." salidas = ?, "
	." stockactual = ? "
	." WHERE "
	." codproceso = '".limpiar($_POST["codventa"])."' and codproducto = '".limpiar($_POST["codproducto"][$i])."' AND codsucursal = '".limpiar($_POST["codsucursal"])."';
	";
	$stmt = $this->dbh->prepare($sql3);
	$stmt->bindParam(1, $salidas);
	$stmt->bindParam(2, $existencia);
	
	$salidas = limpiar($_POST["cantventa"][$i]);
	$existencia = $_POST['tipodetalle'][$i] == 1 ? $existenciabd-$totalventa : "0";
	$stmt->execute();
	################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX ###################

		} else {

           echo "";

	       }
        } 
    }    
        $this->dbh->commit();

    ############ ACTUALIZO LOS TOTALES EN LA VENTA ##############
    $sql = " UPDATE ventas SET "
    ." codcliente = ?, "
    ." subtotalivasi = ?, "
    ." subtotalivano = ?, "
    ." totaliva = ?, "
	." descontado = ?, "
    ." descuento = ?, "
    ." totaldescuento = ?, "
    ." totalpago = ?, "
	." totalpago2 = ?, "
	." montodevuelto = ? "
    ." WHERE "
    ." codventa = ? AND codsucursal = ?;
    ";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(1, $codcliente);
    $stmt->bindParam(2, $subtotalivasi);
    $stmt->bindParam(3, $subtotalivano);
    $stmt->bindParam(4, $totaliva);
	$stmt->bindParam(5, $descontado);
    $stmt->bindParam(6, $descuento);
    $stmt->bindParam(7, $totaldescuento);
    $stmt->bindParam(8, $totalpago);
    $stmt->bindParam(9, $totalpago2);
	$stmt->bindParam(10, $montodevuelto);
    $stmt->bindParam(11, $codventa);
    $stmt->bindParam(12, $codsucursal);

    $codcliente = limpiar($_POST["codcliente"]);
    $subtotalivasi = number_format($_POST["txtsubtotal"], 2, '.', '');
	$subtotalivano = number_format($_POST["txtsubtotal2"], 2, '.', '');
	$totaliva = number_format($_POST["txtIva"], 2, '.', '');
	$descontado = number_format($_POST["txtdescontado"], 2, '.', '');
	$descuento = limpiar($_POST["descuento"]);
	$totaldescuento = number_format($_POST["txtDescuento"], 2, '.', '');
	$totalpago = number_format($_POST["txtTotal"], 2, '.', '');
	$totalpago2 = number_format($_POST["txtTotalCompra"], 2, '.', '');
	$montodevuelto = number_format($totalpago > $_POST["pagado"] ? "0.00" : $_POST["pagado"]-$totalpago, 2, '.', '');
    $codventa = limpiar($_POST["codventa"]);
    $codsucursal = limpiar($_POST["codsucursal"]);
    $tipodocumento = limpiar($_POST["tipodocumento"]);
    $tipopago = limpiar($_POST["tipopago"]);
    $observaciones = limpiar($_POST["observaciones"]);
    $fecha = date("Y-m-d H:i:s");
    $stmt->execute();
    ############ ACTUALIZO LOS TOTALES EN LA VENTA ##############

    ################## AGREGAMOS O QUITAMOS LA DIFERENCIA EN CAJA ##############
	if (limpiar($_POST["tipopago"]=="CONTADO") && $totalpagobd != $totalpago){

		$sql = "SELECT ingresos FROM arqueocaja WHERE codcaja = '".limpiar($_POST["codcaja"])."' AND statusarqueo = 1";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$ingreso = ($row['ingresos']== "" ? "0.00" : $row['ingresos']);

		$sql = "UPDATE arqueocaja set "
		." ingresos = ? "
		." WHERE "
		." codcaja = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $TxtTotal);
		$stmt->bindParam(2, $codcaja);

        $TxtTotal = number_format(($totalpagobd>$totalpago ? $ingreso-($totalpagobd-$totalpago) : $ingreso+($totalpago-$totalpagobd)), 2, '.', '');
		$codcaja = limpiar($_POST["codcaja"]);
		$stmt->execute();
	}
    ################ AGREGAMOS O QUITAMOS LA DIFERENCIA EN CAJA ####################

    ############## AGREGAMOS O QUITAMOS LA DIFERENCIA EN CAJA ##################
	if (limpiar($_POST["tipopago"]=="CREDITO") && $totalpagobd != $totalpago) {

		$sql = "SELECT creditos FROM arqueocaja WHERE codcaja = '".limpiar($_POST["codcaja"])."' AND statusarqueo = 1";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$credito = ($row['creditos']== "" ? "0.00" : $row['creditos']);

		$sql = " UPDATE arqueocaja SET "
		." creditos = ? "
		." where "
		." codcaja = ? and statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $TxtTotal);
		$stmt->bindParam(2, $codcaja);

		$TxtTotal = number_format(($totalpagobd>$totalpago ? $credito-($totalpagobd-$totalpago) : $credito+($totalpago-$totalpagobd)), 2, '.', '');
		$codcaja = limpiar($_POST["codcaja"]);
		$stmt->execute(); 	

		$sql = "UPDATE creditosxclientes set"
		." montocredito = ? "
		." where "
		." codcliente = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $montocredito);
		$stmt->bindParam(2, $codcliente);
		$stmt->bindParam(3, $codsucursal);

        $montocredito = number_format(($totalpagobd>$totalpago ? $montoactual-($totalpagobd-$totalpago) : $montoactual+($totalpago-$totalpagobd)), 2, '.', '');
		$codcliente = limpiar($_POST["codcliente"]);
		$codsucursal = limpiar($_POST["codsucursal"]);
		$stmt->execute(); 
	}
    ############## AGREGAMOS O QUITAMOS LA DIFERENCIA EN CAJA ##################

    echo "<span class='fa fa-check-square-o'></span> LA VENTA DE PRODUCTOS HA SIDO ACTUALIZADA EXITOSAMENTE <a href='reportepdf?codventa=".encrypt($codventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt($tipodocumento)."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

    echo "<script>window.open('reportepdf?codventa=".encrypt($codventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt($tipodocumento)."', '_blank');</script>";
	exit;
}
########################## FUNCION ACTUALIZAR VENTAS ###########################

########################## FUNCION AGREGAR DETALLES VENTAS ############################
public function AgregarDetallesVentas()
	{
	self::SetNames();
	if(empty($_POST["codventa"]) or empty($_POST["codsucursal"]))
	{
		echo "1";
		exit;
	}
	else if(empty($_SESSION["CarritoVenta"]) || $_POST["txtTotal"]=="0.00")
	{
		echo "2";
		exit;
		
	}

    ############ CONSULTO TOTAL ACTUAL ##############
	$sql = "SELECT totalpago 
	FROM ventas 
	WHERE codventa = '".limpiar($_POST["codventa"])."' 
	AND codsucursal = '".limpiar($_POST["codsucursal"])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$totalpagobd = $row['totalpago'];
	############ CONSULTO TOTAL ACTUAL ##############

	################### SELECCIONE LOS DATOS DEL CLIENTE ######################
    $sql = "SELECT
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	provincias.provincia,
	departamentos.departamento,
    ROUND(SUM(if(pag.montocredito!='0',pag.montocredito,'0.00')), 2) montoactual,
    ROUND(SUM(if(pag.montocredito!='0',clientes.limitecredito-pag.montocredito,clientes.limitecredito)), 2) creditodisponible
    FROM clientes
    LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
    LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento 
    LEFT JOIN
       (SELECT
       codcliente, montocredito       
       FROM creditosxclientes 
       WHERE codsucursal = '".limpiar($_POST['codsucursal'])."') pag ON pag.codcliente = clientes.codcliente
       WHERE clientes.codcliente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST['codcliente']));
	$num = $stmt->rowCount();
	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$p[] = $row;
	}
    $tipocliente = ($row['tipocliente'] == "" ? "0" : $row['tipocliente']);
    $dnicliente = ($row['dnicliente'] == "" ? "0" : $row['dnicliente']);
    $nomcliente = ($row['nomcliente'] == "" ? "0" : $row['nomcliente']);
    $girocliente = ($row['girocliente'] == "" ? "0" : $row['girocliente']);
    $emailcliente = $row['emailcliente'];
    $limitecredito = $row['limitecredito'];
    $montoactual = $row['montoactual'];
    $creditodisponible = $row['creditodisponible'];
    $montoabono = (empty($_POST["montoabono"]) ? "0.00" : $_POST["montoabono"]);
    $total = number_format($_POST["txtTotal"]-$montoabono, 2, '.', '');
    ################### SELECCIONE LOS DATOS DEL CLIENTE ######################

   if ($_POST["tipopago"] == "CREDITO") {
  
	    if ($limitecredito != "0.00" && $total > $creditodisponible) {	
  
           echo "3";
	       exit;

        } 
    }

    $this->dbh->beginTransaction();
    $detalle = $_SESSION["CarritoVenta"];
	for($i=0;$i<count($detalle);$i++){

	    ############### REVISAMOS QUE LA CANTIDAD NO SEA IGUAL A CERO ##############
		if($detalle[$i]['cantidad']==0){

			echo "4";
			exit;
	    }
	    ############### REVISAMOS QUE LA CANTIDAD NO SEA IGUAL A CERO ##############

	    if($detalle[$i]['tipodetalle'] == 1){

	    ############### SELECCIONAMOS LA EXISTENCIA DEL PRODUCTO ################
	    $sql2 = "SELECT existencia 
	    FROM productos 
	    WHERE codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' 
	    AND codsucursal = '".limpiar($_POST["codsucursal"])."'";
		foreach ($this->dbh->query($sql2) as $row)
		{
		   $this->p[] = $row;
		}
		
		$existenciabd = $row["existencia"];
		############### SELECCIONAMOS LA EXISTENCIA DEL PRODUCTO ################

		######### REVISAMOS SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA EN ALMACEN ########
        if ($detalle[$i]['cantidad'] > $existenciabd) 
        { 
	       echo "5";
	       exit;
        }
        ######### REVISAMOS SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA EN ALMACEN ########
	}

    ############# REVISAMOS QUE EL PRODUCTO NO ESTE EN LA BD ###################
    $sql = "SELECT codventa, codproducto FROM detalleventas WHERE codventa = '".limpiar($_POST['codventa'])."' AND codsucursal = '".limpiar($_POST['codsucursal'])."' AND codproducto = '".limpiar($detalle[$i]['txtCodigo'])."'";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num == 0)
	{

    $query = "INSERT INTO detalleventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codventa);
    $stmt->bindParam(2, $idproducto);
    $stmt->bindParam(3, $codproducto);
    $stmt->bindParam(4, $producto);
    $stmt->bindParam(5, $codmarca);
    $stmt->bindParam(6, $codmodelo);
    $stmt->bindParam(7, $codpresentacion);
	$stmt->bindParam(8, $cantidad);
	$stmt->bindParam(9, $preciocompra);
	$stmt->bindParam(10, $precioventa);
	$stmt->bindParam(11, $ivaproducto);
	$stmt->bindParam(12, $descproducto);
	$stmt->bindParam(13, $valortotal);
	$stmt->bindParam(14, $totaldescuentov);
	$stmt->bindParam(15, $valorneto);
	$stmt->bindParam(16, $valorneto2);
	$stmt->bindParam(17, $tipodetalle);
	$stmt->bindParam(18, $codsucursal);
		
	$codventa = limpiar($_POST["codventa"]);
	$idproducto = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['id'] : "0");
	$codproducto = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['txtCodigo'] : "0");
	$producto = limpiar($detalle[$i]['producto']);
	$codmarca = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['codmarca'] : "0");
	$codmodelo = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['codmodelo'] : "0");
	$codpresentacion = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['codpresentacion'] : "0");
	$cantidad = limpiar($detalle[$i]['cantidad']);
	$preciocompra = limpiar($detalle[$i]['precio']);
	$precioventa = limpiar($detalle[$i]['precio2']);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$descuento = $detalle[$i]['descproducto']/100;
	$valortotal = number_format($detalle[$i]['precio2']*$detalle[$i]['cantidad'], 2, '.', '');
	$totaldescuentov = number_format($valortotal*$descuento, 2, '.', '');
    $valorneto = number_format($valortotal-$totaldescuentov, 2, '.', '');
	$valorneto2 = limpiar($detalle[$i]['tipodetalle'] == "1" ? number_format($detalle[$i]['precio']*$detalle[$i]['cantidad'], 2, '.', '') : "0.00");
	$tipodetalle = limpiar($detalle[$i]['tipodetalle']);
	$codsucursal = limpiar($_POST["codsucursal"]);
	$stmt->execute();

	if($detalle[$i]['tipodetalle'] == 1){

		############### ACTUALIZAMOS EXISTENCIA DEL PRODUCTO EN ALMACEN ##############
		$sql = " UPDATE productos set "
	    ." existencia = ? "
	    ." WHERE "
	    ." codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' 
	    AND codsucursal = '".limpiar($_POST["codsucursal"])."';
	    ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$cantventa = limpiar($detalle[$i]['cantidad']);
		$existencia = $existenciabd-$cantventa;
		$stmt->execute();
		############### ACTUALIZAMOS EXISTENCIA DEL PRODUCTO EN ALMACEN ##############
	}

	############## REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
    $query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codventa);
	$stmt->bindParam(2, $codcliente);
	$stmt->bindParam(3, $codproducto);
	$stmt->bindParam(4, $movimiento);
	$stmt->bindParam(5, $entradas);
	$stmt->bindParam(6, $salidas);
	$stmt->bindParam(7, $devolucion);
	$stmt->bindParam(8, $stockactual);
	$stmt->bindParam(9, $ivaproducto);
	$stmt->bindParam(10, $descproducto);
	$stmt->bindParam(11, $precio);
	$stmt->bindParam(12, $documento);
	$stmt->bindParam(13, $fechakardex);	
	$stmt->bindParam(14, $tipokardex);	
	$stmt->bindParam(15, $codsucursal);

	$codventa = limpiar($_POST['codventa']);
	$codcliente = limpiar($_POST["codcliente"]);
	$codproducto = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['txtCodigo'] : "0");
	$movimiento = limpiar("SALIDAS");
	$entradas = limpiar("0");
	$salidas= limpiar($detalle[$i]['cantidad']);
	$devolucion = limpiar("0");
	$stockactual = limpiar($detalle[$i]['tipodetalle'] == 1 ? $existenciabd-$detalle[$i]['cantidad'] : "0");
	$precio = limpiar($detalle[$i]["precio2"]);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$documento = limpiar("VENTA: ".$_POST['codventa']);
	$fechakardex = limpiar(date("Y-m-d"));
	$tipokardex = limpiar($detalle[$i]['tipodetalle']);
	$codsucursal = limpiar($_POST["codsucursal"]);
	$stmt->execute();

    } else {

  	$sql = "SELECT cantventa 
  	FROM detalleventas 
  	WHERE codventa = '".limpiar($_POST['codventa'])."' 
  	AND codsucursal = '".limpiar($_POST['codsucursal'])."' 
  	AND codproducto = '".limpiar($detalle[$i]['txtCodigo'])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$cantidad = $row['cantventa'];

  	$query = "UPDATE detalleventas set"
	." cantventa = ?, "
	." descproducto = ?, "
	." valortotal = ?, "
	." totaldescuentov = ?, "
	." valorneto = ?, "
	." valorneto2 = ? "
	." WHERE "
	." codventa = ? AND codsucursal = ? AND codproducto = ?;
	";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $cantventa);
	$stmt->bindParam(2, $descproducto);
	$stmt->bindParam(3, $valortotal);
	$stmt->bindParam(4, $totaldescuentov);
	$stmt->bindParam(5, $valorneto);
	$stmt->bindParam(6, $valorneto2);
	$stmt->bindParam(7, $codventa);
	$stmt->bindParam(8, $codsucursal);
	$stmt->bindParam(9, $codproducto);

	$cantventa = limpiar($detalle[$i]['cantidad']+$cantidad);
	$preciocompra = limpiar($detalle[$i]['tipodetalle'] == "1" ? $detalle[$i]['precio'] : "0.00");
	$precioventa = limpiar($detalle[$i]['precio2']);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$descuento = $detalle[$i]['descproducto']/100;
	$valortotal = number_format($detalle[$i]['precio2'] * $cantventa, 2, '.', '');
	$totaldescuentov = number_format($valortotal * $descuento, 2, '.', '');
	$valorneto = number_format($valortotal - $totaldescuentov, 2, '.', '');
	$valorneto2 = limpiar($detalle[$i]['tipodetalle'] == "1" ? number_format($detalle[$i]['precio']*$cantventa, 2, '.', '') : "0.00");
	$codventa = limpiar($_POST["codventa"]);
	$codsucursal = limpiar($_POST["codsucursal"]);
	$codproducto = limpiar($detalle[$i]['txtCodigo']);
	$stmt->execute();

	if($detalle[$i]['tipodetalle'] == 1){

		################ ACTUALIZAMOS EXISTENCIA DEL PRODUCTO EN ALMACEN ################
		$sql = " UPDATE productos set "
		." existencia = ? "
		." WHERE "
		." codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' AND codsucursal = '".limpiar($_POST["codsucursal"])."';
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$cantventa = limpiar($detalle[$i]['cantidad']);
		$existencia = $existenciabd-$cantventa;
		$stmt->execute();
		################ ACTUALIZAMOS EXISTENCIA DEL PRODUCTO EN ALMACEN ################
	}

	################ ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX ##############
	$sql3 = " UPDATE kardex set "
	." salidas = ?, "
	." stockactual = ? "
	." WHERE "
	." codproceso = '".limpiar($_POST["codventa"])."' 
	AND codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' 
	AND codsucursal = '".limpiar($_POST["codsucursal"])."';
	";
	$stmt = $this->dbh->prepare($sql3);
	$stmt->bindParam(1, $salidas);
	$stmt->bindParam(2, $existencia);
	
	$salidas = limpiar($detalle[$i]['cantidad']+$cantidad);
	$existencia = ($detalle[$i]['tipodetalle'] == 1 ? $existenciabd-$cantventa : "0");
	$stmt->execute();
	################ ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX ##############

       }
    }
    ####################### DESTRUYO LA VARIABLE DE SESSION #####################
    unset($_SESSION["CarritoVenta"]);
    $this->dbh->commit();

    ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############
	$sql3 = "SELECT SUM(totaldescuentov) AS totaldescuentosi, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detalleventas WHERE codventa = '".limpiar($_POST["codventa"])."' AND codsucursal = '".limpiar($_POST["codsucursal"])."' AND ivaproducto = 'SI'";
	foreach ($this->dbh->query($sql3) as $row3)
	{
		$this->p[] = $row3;
	}
	$subtotaldescuentosi = ($row3['totaldescuentosi']== "" ? "0.00" : $row3['totaldescuentosi']);
	$subtotalivasi = ($row3['valorneto']== "" ? "0.00" : $row3['valorneto']);
	$subtotalivasi2 = ($row3['valorneto2']== "" ? "0.00" : $row3['valorneto2']);
	############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############

	############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############
	$sql4 = "SELECT SUM(totaldescuentov) AS totaldescuentono, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detalleventas WHERE codventa = '".limpiar($_POST["codventa"])."' AND codsucursal = '".limpiar($_POST["codsucursal"])."' AND ivaproducto = 'NO'";
	foreach ($this->dbh->query($sql4) as $row4)
	{
		$this->p[] = $row4;
	}
	$subtotaldescuentono = ($row4['totaldescuentono']== "" ? "0.00" : $row4['totaldescuentono']);
	$subtotalivano = ($row4['valorneto']== "" ? "0.00" : $row4['valorneto']);
	$subtotalivano2 = ($row4['valorneto2']== "" ? "0.00" : $row4['valorneto2']);
	############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############

    ############ ACTUALIZO LOS TOTALES EN LA VENTA ##############
	$sql = " UPDATE ventas SET "
	." codcliente = ?, "
	." subtotalivasi = ?, "
	." subtotalivano = ?, "
	." totaliva = ?, "
	." descontado = ?, "
	." descuento = ?, "
	." totaldescuento = ?, "
	." totalpago = ?, "
	." totalpago2 = ?, "
	." montodevuelto = ? "
	." WHERE "
	." codventa = ? AND codsucursal = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $codcliente);
	$stmt->bindParam(2, $subtotalivasi);
	$stmt->bindParam(3, $subtotalivano);
	$stmt->bindParam(4, $totaliva);
	$stmt->bindParam(5, $descontado);
	$stmt->bindParam(6, $descuento);
	$stmt->bindParam(7, $totaldescuento);
	$stmt->bindParam(8, $totalpago);
	$stmt->bindParam(9, $totalpago2);
	$stmt->bindParam(10, $montodevuelto);
	$stmt->bindParam(11, $codventa);
	$stmt->bindParam(12, $codsucursal);

	$codcliente = limpiar($_POST["codcliente"]);
	$iva = $_POST["iva"]/100;
	$totaliva = number_format($subtotalivasi*$iva, 2, '.', '');
	$descontado = number_format($subtotaldescuentosi+$subtotaldescuentono, 2, '.', '');
	$descuento = limpiar($_POST["descuento"]);
	$txtDescuento = $_POST["descuento"]/100;
	$total = number_format($subtotalivasi+$subtotalivano+$totaliva, 2, '.', '');
	$totaldescuento = number_format($total*$txtDescuento, 2, '.', '');
	$totalpago = number_format($total-$totaldescuento, 2, '.', '');
	$totalpago2 = number_format($subtotalivasi2+$subtotalivano2, 2, '.', '');
	$montodevuelto = number_format($totalpago > $_POST["pagado"] ? "0.00" : $_POST["pagado"]-$totalpago, 2, '.', '');
	$codventa = limpiar($_POST["codventa"]);
	$codsucursal = limpiar($_POST["codsucursal"]);
	$tipodocumento = limpiar($_POST["tipodocumento"]);
	$tipopago = limpiar($_POST["tipopago"]);
	$observaciones = limpiar($_POST["observaciones"]);
	$fecha = date("Y-m-d H:i:s");
	$stmt->execute();
	############ ACTUALIZO LOS TOTALES EN LA VENTA ##############

    ################## AGREGAMOS O QUITAMOS LA DIFERENCIA EN CAJA ###############
    if (limpiar($_POST["tipopago"]=="CONTADO") && $totalpagobd != $totalpago){

        $sql = "SELECT ingresos FROM arqueocaja WHERE codcaja = '".limpiar($_POST["codcaja"])."' AND statusarqueo = 1";
        foreach ($this->dbh->query($sql) as $row)
        {
            $this->p[] = $row;
        }
        $ingreso = ($row['ingresos']== "" ? "0.00" : $row['ingresos']);

        $sql = "UPDATE arqueocaja set "
        ." ingresos = ? "
        ." WHERE "
        ." codcaja = ? AND statusarqueo = 1;
        ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(1, $TxtTotal);
        $stmt->bindParam(2, $codcaja);

        $TxtTotal = number_format(($totalpagobd>$totalpago ? $ingreso-($totalpagobd-$totalpago) : $ingreso+($totalpago-$totalpagobd)), 2, '.', '');
        $codcaja = limpiar($_POST["codcaja"]);
        $stmt->execute();
    }
    ################# AGREGAMOS O QUITAMOS LA DIFERENCIA EN CAJA ###################

    ############## AGREGAMOS O QUITAMOS LA DIFERENCIA EN CAJA ##################
    if (limpiar($_POST["tipopago"]=="CREDITO") && $totalpagobd != $totalpago) {

        $sql = "SELECT creditos FROM arqueocaja WHERE codcaja = '".limpiar($_POST["codcaja"])."' AND statusarqueo = 1";
        foreach ($this->dbh->query($sql) as $row)
        {
            $this->p[] = $row;
        }
        $credito = ($row['creditos']== "" ? "0.00" : $row['creditos']);

        $sql = " UPDATE arqueocaja SET "
        ." creditos = ? "
        ." where "
        ." codcaja = ? and statusarqueo = 1;
        ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(1, $TxtTotal);
        $stmt->bindParam(2, $codcaja);

        $TxtTotal = number_format(($totalpagobd>$totalpago ? $credito-($totalpagobd-$totalpago) : $credito+($totalpago-$totalpagobd)), 2, '.', '');
        $codcaja = limpiar($_POST["codcaja"]);
        $stmt->execute(); 

		$sql = "UPDATE creditosxclientes set"
		." montocredito = ? "
		." where "
		." codcliente = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $montocredito);
		$stmt->bindParam(2, $codcliente);
		$stmt->bindParam(3, $codsucursal);

        $montocredito = number_format(($totalpagobd>$totalpago ? $montoactual-($totalpagobd-$totalpago) : $montoactual+($totalpago-$totalpagobd)), 2, '.', '');
		$codcliente = limpiar($_POST["codcliente"]);
		$codsucursal = limpiar($_POST["codsucursal"]);
		$stmt->execute(); 
    }
    ############## AGREGAMOS O QUITAMOS LA DIFERENCIA EN CAJA ##################

    echo "<span class='fa fa-check-square-o'></span> LOS DETALLES DE PRODUCTOS FUERON AGREGADOS A LA VENTA EXITOSAMENTE <a href='reportepdf?codventa=".encrypt($codventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt($tipodocumento)."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

    echo "<script>window.open('reportepdf?codventa=".encrypt($codventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt($tipodocumento)."', '_blank');</script>";
	exit;
}
########################### FUNCION AGREGAR DETALLES VENTAS ##########################

########################### FUNCION ELIMINAR DETALLES VENTAS ###########################
public function EliminarDetallesVentas()
{
	self::SetNames();
	if ($_SESSION["acceso"]=="administradorS") {

    ############ CONSULTO TOTAL ACTUAL ##############
	$sql = "SELECT 
	codcaja, 
	codcliente, 
	tipopago, 
	totalpago 
	FROM ventas WHERE codventa = '".limpiar(decrypt($_GET["codventa"]))."' 
	AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$cajabd = $row['codcaja'];
	$clientebd = $row['codcliente'];
	$tipopagobd = $row['tipopago'];
	$totalpagobd = $row['totalpago'];
	############ CONSULTO TOTAL ACTUAL ##############

	################### VERIFICO MONTO DE CREDITO DEL CLIENTE ######################
	$sql = "SELECT montocredito FROM creditosxclientes 
	WHERE codcliente = '".$clientebd."' 
	AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$monto = (empty($row['montocredito']) ? "0.00" : $row['montocredito']);
	################### VERIFICO MONTO DE CREDITO DEL CLIENTE ######################

	$sql = "SELECT * FROM detalleventas WHERE codventa = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codventa"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num > 1)
	{

		$sql = "SELECT 
		codproducto, 
		cantventa, 
		precioventa, 
		ivaproducto, 
		descproducto, 
		tipodetalle 
		FROM detalleventas 
		WHERE coddetalleventa = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["coddetalleventa"]),decrypt($_GET["codsucursal"])));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$codproducto = $row['codproducto'];
		$cantidadbd = $row['cantventa'];
		$precioventabd = $row['precioventa'];
		$ivaproductobd = $row['ivaproducto'];
		$descproductobd = $row['descproducto'];
		$tipodetallebd = $row['tipodetalle'];

	    if($tipodetallebd == 1){

		    ############ CONSULTO EXISTENCIA DE PRODUCTO ############
		    $sql2 = "SELECT existencia FROM productos WHERE codproducto = ? AND codsucursal = ?";
			$stmt = $this->dbh->prepare($sql2);
			$stmt->execute(array($codproducto,decrypt($_GET["codsucursal"])));
			$num = $stmt->rowCount();

			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$p[] = $row;
			}
			$existenciabd = $row['existencia'];
			############ CONSULTO EXISTENCIA DE PRODUCTO ############

			############ ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN ############
			$sql = "UPDATE productos SET "
			." existencia = ? "
			." WHERE "
			." codproducto = ? AND codsucursal = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $existencia);
			$stmt->bindParam(2, $codproducto);
			$stmt->bindParam(3, $codsucursal);

			//$existencia = limpiar($tipodetallebd == 1 ? $existenciabd+$cantidadbd : "0");
			$existencia = limpiar($existenciabd+$cantidadbd);
			$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
			$stmt->execute();
			############ ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN ############

		}


	    ######## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ##########
		$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codventa);
		$stmt->bindParam(2, $codcliente);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);
		$stmt->bindParam(14, $tipokardex);			
		$stmt->bindParam(15, $codsucursal);

		$codventa = limpiar(decrypt($_GET["codventa"]));
		$codcliente = limpiar((decrypt($_GET["codcliente"])== "" ? "0" : decrypt($_GET["codcliente"])));
		$movimiento = limpiar("DEVOLUCION");
		$entradas= limpiar("0");
		$salidas = limpiar("0");
		$devolucion = limpiar($cantidadbd);
		$stockactual = limpiar($tipodetallebd == 1 ? $existenciabd+$cantidadbd : "0");
		$precio = limpiar($precioventabd);
		$ivaproducto = limpiar($ivaproductobd);
		$descproducto = limpiar($descproductobd);
		$documento = limpiar("DEVOLUCION VENTA: ".decrypt($_GET["codventa"]));
		$fechakardex = limpiar(date("Y-m-d"));
		$tipokardex = limpiar($tipodetallebd);
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute();

		################## ELIMINO DETALLE DE VENTA ##################
		$sql = "DELETE FROM detalleventas WHERE coddetalleventa = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$coddetalleventa);
		$stmt->bindParam(2,$codsucursal);
		$coddetalleventa = decrypt($_GET["coddetalleventa"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();
		################## ELIMINO DETALLE DE VENTA ##################

	    ############ CONSULTO LOS TOTALES DE VENTA ##############
		$sql2 = "SELECT iva, descuento FROM ventas WHERE codventa = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute(array(decrypt($_GET["codventa"]),decrypt($_GET["codsucursal"])));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$paea[] = $row;
		}
		$iva = $paea[0]["iva"]/100;
		$descuento = $paea[0]["descuento"]/100;
		############ CONSULTO LOS TOTALES DE VENTA ##############

        ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############
		$sql3 = "SELECT SUM(totaldescuentov) AS totaldescuentosi, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detalleventas WHERE codventa = '".limpiar(decrypt($_GET["codventa"]))."' AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."' AND ivaproducto = 'SI'";
		foreach ($this->dbh->query($sql3) as $row3)
		{
			$this->p[] = $row3;
		}
		$subtotaldescuentosi = ($row3['totaldescuentosi']== "" ? "0.00" : $row3['totaldescuentosi']);
		$subtotalivasi = ($row3['valorneto']== "" ? "0.00" : $row3['valorneto']);
		$subtotalivasi2 = ($row3['valorneto2']== "" ? "0.00" : $row3['valorneto2']);
		############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############

	    ############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############
		$sql4 = "SELECT SUM(totaldescuentov) AS totaldescuentono, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detalleventas WHERE codventa = '".limpiar(decrypt($_GET["codventa"]))."' AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."' AND ivaproducto = 'NO'";
		foreach ($this->dbh->query($sql4) as $row4)
		{
			$this->p[] = $row4;
		}
		$subtotaldescuentono = ($row4['totaldescuentono']== "" ? "0.00" : $row4['totaldescuentono']);
		$subtotalivano = ($row4['valorneto']== "" ? "0.00" : $row4['valorneto']);
		$subtotalivano2 = ($row4['valorneto2']== "" ? "0.00" : $row4['valorneto2']);
		############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############

        ############ ACTUALIZO LOS TOTALES EN LA VENTA ##############
		$sql = " UPDATE ventas SET "
		." subtotalivasi = ?, "
		." subtotalivano = ?, "
		." totaliva = ?, "
		." descontado = ?, "
		." totaldescuento = ?, "
		." totalpago = ?, "
		." totalpago2= ? "
		." WHERE "
		." codventa = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $subtotalivasi);
		$stmt->bindParam(2, $subtotalivano);
		$stmt->bindParam(3, $totaliva);
		$stmt->bindParam(4, $descontado);
		$stmt->bindParam(5, $totaldescuento);
		$stmt->bindParam(6, $totalpago);
		$stmt->bindParam(7, $totalpago2);
		$stmt->bindParam(8, $codventa);
		$stmt->bindParam(9, $codsucursal);

		$totaliva= number_format($subtotalivasi*$iva, 2, '.', '');
		$descontado = number_format($subtotaldescuentosi+$subtotaldescuentono, 2, '.', '');
		$total= number_format($subtotalivasi+$subtotalivano+$totaliva, 2, '.', '');
		$totaldescuento= number_format($total*$descuento, 2, '.', '');
		$totalpago= number_format($total-$totaldescuento, 2, '.', '');
		$totalpago2 = number_format($subtotalivasi2+$subtotalivano2, 2, '.', '');
		$codventa = limpiar(decrypt($_GET["codventa"]));
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute();
		############ ACTUALIZO LOS TOTALES EN LA VENTA ##############

		#################### QUITAMOS LA DIFERENCIA EN CAJA ####################
		if ($tipopagobd=="CONTADO"){

			$sql = "SELECT ingresos FROM arqueocaja WHERE codcaja = '".$cajabd."' AND statusarqueo = 1";
			foreach ($this->dbh->query($sql) as $row)
			{
				$this->p[] = $row;
			}
			$ingreso = ($row['ingresos']== "" ? "0.00" : $row['ingresos']);

			$sql = "UPDATE arqueocaja set "
			." ingresos = ? "
			." WHERE "
			." codcaja = ? AND statusarqueo = 1;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $TxtTotal);
			$stmt->bindParam(2, $cajabd);

			$MontoCalculo = number_format($totalpagobd-$totalpago, 2, '.', '');
			$TxtTotal = number_format($ingreso-$MontoCalculo, 2, '.', '');
			$stmt->execute();
		}
	    #################### QUITAMOS LA DIFERENCIA EN CAJA ####################
	    
	    ############## QUITAMOS LA DIFERENCIA EN CAJA ##################
		if ($tipopagobd=="CREDITO") {

			$sql = "SELECT creditos FROM arqueocaja WHERE codcaja = '".$cajabd."' AND statusarqueo = 1";
			foreach ($this->dbh->query($sql) as $row)
			{
				$this->p[] = $row;
			}
			$credito = ($row['creditos']== "" ? "0.00" : $row['creditos']);

			$sql = " UPDATE arqueocaja SET "
			    ." creditos = ? "
			    ." where "
			    ." codcaja = ? and statusarqueo = 1;
			    ";
			    $stmt = $this->dbh->prepare($sql);
			    $stmt->bindParam(1, $TxtTotal);
			    $stmt->bindParam(2, $cajabd);

			    $MontoCalculo = number_format($totalpagobd-$totalpago, 2, '.', '');
			    $TxtTotal = number_format($credito-$MontoCalculo, 2, '.', '');
			    $stmt->execute();

			    $sql = "UPDATE creditosxclientes set"
			    ." montocredito = ? "
				." where "
				." codcliente = ? AND codsucursal = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $montocredito);
				$stmt->bindParam(2, $clientebd);
				$stmt->bindParam(3, $codsucursal);

				$montocredito = number_format($monto-$MontoCalculo, 2, '.', '');
				$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
				$stmt->execute(); 	
		}
	    ############## QUITAMOS LA DIFERENCIA EN CAJA ##################

		echo "1";
		exit;

	} else {

		echo "2";
		exit;
	} 

	} else {
		
		echo "3";
		exit;
	}	
}
######################## FUNCION ELIMINAR DETALLES VENTAS ########################

####################### FUNCION ELIMINAR VENTAS ########################
public function EliminarVentas()
	{
	
	self::SetNames();
	if ($_SESSION["acceso"]=="administradorS") {

    ############ CONSULTO TOTAL ACTUAL ##############
	$sql = "SELECT 
	codcaja, 
	codcliente, 
	tipopago, 
	totalpago 
	FROM ventas 
	WHERE codventa = '".limpiar(decrypt($_GET["codventa"]))."' 
	AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$cajabd = $row['codcaja'];
	$clientebd = $row['codcliente'];
	$tipopagobd = $row['tipopago'];
	$totalpagobd = $row['totalpago'];
	############ CONSULTO TOTAL ACTUAL ##############

	################### VERIFICO MONTO DE CREDITO DEL CLIENTE ######################
	$sql = "SELECT montocredito FROM creditosxclientes 
	WHERE codcliente = '".$clientebd."' 
	AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
    $monto = (empty($row['montocredito']) ? "0.00" : $row['montocredito']);
    ################### VERIFICO MONTO DE CREDITO DEL CLIENTE ######################

    $sql = "SELECT * FROM detalleventas 
    WHERE codventa = '".limpiar(decrypt($_GET["codventa"]))."' 
    AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."'";

	$array=array();

	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;

		$codproducto = $row['codproducto'];
		$cantidadbd = $row['cantventa'];
		$precioventabd = $row['precioventa'];
		$ivaproductobd = $row['ivaproducto'];
		$descproductobd = $row['descproducto'];
		$tipodetallebd = $row['tipodetalle'];

		if($tipodetallebd == 1){

		    ############ CONSULTO EXISTENCIA DE PRODUCTO ############
			$sql2 = "SELECT existencia FROM productos WHERE codproducto = ? AND codsucursal = ?";
			$stmt = $this->dbh->prepare($sql2);
			$stmt->execute( array($codproducto,decrypt($_GET["codsucursal"])));
			$num = $stmt->rowCount();

			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$p[] = $row;
			}
			$existenciabd = $row['existencia'];
			############ CONSULTO EXISTENCIA DE PRODUCTO ############

			########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN ##############
			$sql = "UPDATE productos SET "
			." existencia = ? "
			." WHERE "
			." codproducto = ? AND codsucursal = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $existencia);
			$stmt->bindParam(2, $codproducto);
			$stmt->bindParam(3, $codsucursal);

			$existencia = limpiar($tipodetallebd == 1 ? $existenciabd+$cantidadbd : "0");
			$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
			$stmt->execute();
			########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN ##############

		}

	    ########## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ##########
		$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codventa);
		$stmt->bindParam(2, $codcliente);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);	
		$stmt->bindParam(14, $tipokardex);		
		$stmt->bindParam(15, $codsucursal);

		$codventa = limpiar(decrypt($_GET["codventa"]));
	    $codcliente = limpiar((decrypt($_GET["codcliente"])== "" ? "0" : decrypt($_GET["codcliente"])));
		$movimiento = limpiar("DEVOLUCION");
		$entradas= limpiar("0");
		$salidas = limpiar("0");
		$devolucion = limpiar($cantidadbd);
		$stockactual = limpiar($tipodetallebd == 1 ? $existenciabd+$cantidadbd : "0");
		$precio = limpiar($precioventabd);
		$ivaproducto = limpiar($ivaproductobd);
		$descproducto = limpiar($descproductobd);
		$documento = limpiar("DEVOLUCION VENTA: ".decrypt($_GET["codventa"]));
		$fechakardex = limpiar(date("Y-m-d"));
		$tipokardex = limpiar($tipodetallebd);
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute();
	}

	#################### QUITAMOS LA DIFERENCIA EN CAJA ####################
	if ($tipopagobd=="CONTADO"){

		$sql = "SELECT ingresos FROM arqueocaja WHERE codcaja = '".$cajabd."' AND statusarqueo = 1";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$ingreso = ($row['ingresos']== "" ? "0.00" : $row['ingresos']);

		$sql = "UPDATE arqueocaja set "
		    ." ingresos = ? "
		    ." WHERE "
		    ." codcaja = ? AND statusarqueo = 1;
		    ";
		    $stmt = $this->dbh->prepare($sql);
		    $stmt->bindParam(1, $TxtTotal);
		    $stmt->bindParam(2, $cajabd);

            $TxtTotal = number_format($ingreso-$totalpagobd, 2, '.', '');
		    $stmt->execute();
	}
    #################### QUITAMOS LA DIFERENCIA EN CAJA ####################

    ############## QUITAMOS LA DIFERENCIA EN CAJA ##################
	if ($tipopagobd=="CREDITO") {

	$sql = "SELECT creditos FROM arqueocaja WHERE codcaja = '".$cajabd."' AND statusarqueo = 1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$credito = ($row['creditos']== "" ? "0.00" : $row['creditos']);

	    $sql = " UPDATE arqueocaja SET "
	    ." creditos = ? "
	    ." where "
	    ." codcaja = ? and statusarqueo = 1;
	    ";
	    $stmt = $this->dbh->prepare($sql);
	    $stmt->bindParam(1, $TxtTotal);
	    $stmt->bindParam(2, $cajabd);

	    $TxtTotal = number_format($credito-$totalpagobd, 2, '.', '');
	    $stmt->execute();

	    $sql = "UPDATE creditosxclientes set"
	    ." montocredito = ? "
		." where "
		." codcliente = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $montocredito);
		$stmt->bindParam(2, $clientebd);
		$stmt->bindParam(3, $codsucursal);

		$montocredito = number_format($monto-$totalpagobd, 2, '.', '');
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute(); 	
	}
    ############## QUITAMOS LA DIFERENCIA EN CAJA ##################

		################## ELIMINO VENTA ##################
	    $sql = "DELETE FROM ventas WHERE codventa = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codventa);
		$stmt->bindParam(2,$codsucursal);
		$codventa = decrypt($_GET["codventa"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();
		################## ELIMINO VENTA ##################

		################## ELIMINO DETALLE DE VENTA ##################
		$sql = "DELETE FROM detalleventas WHERE codventa = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codventa);
		$stmt->bindParam(2,$codsucursal);
		$codventa = decrypt($_GET["codventa"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();
		################## ELIMINO DETALLE DE VENTA ##################

		echo "1";
		exit;

	} else {

		echo "2";
		exit;
	}
}
######################### FUNCION ELIMINAR VENTAS ############################

######################### FUNCION LISTAR VENTAS DIARIAS ###########################
public function BuscarVentasDiarias()
{
	self::SetNames();
	if($_SESSION['acceso'] == "administradorS") {

	$sql = "SELECT
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa, 
	ventas.codfactura,
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
	ventas.descontado,
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,   
	ventas.notacredito,  
	ventas.codsucursal, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	usuarios.dni,
	usuarios.nombres,
	cajas.nrocaja,
	cajas.nomcaja,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	mediospagos.mediopago,
	SUM(detalleventas.cantventa) AS articulos 
	FROM (ventas LEFT JOIN detalleventas ON detalleventas.codventa=ventas.codventa)
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja 
	LEFT JOIN mediospagos ON ventas.formapago = mediospagos.codmediopago 
	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	WHERE ventas.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
	AND DATE_FORMAT(ventas.fechaventa,'%d-%m-%Y') = '".date("d-m-Y")."' 
	GROUP BY ventas.codventa";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

	} else {

	$sql = "SELECT
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa, 
	ventas.codfactura,
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
	ventas.descontado,
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,   
	ventas.notacredito,  
	ventas.codsucursal, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	usuarios.dni,
	usuarios.nombres,
	cajas.nrocaja,
	cajas.nomcaja,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	mediospagos.mediopago,
	SUM(detalleventas.cantventa) AS articulos 
	FROM (ventas LEFT JOIN detalleventas ON detalleventas.codventa=ventas.codventa)
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja 
	LEFT JOIN mediospagos ON ventas.formapago = mediospagos.codmediopago 
	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	WHERE ventas.codigo = '".limpiar($_SESSION["codigo"])."' 
	AND ventas.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
	AND DATE_FORMAT(ventas.fechaventa,'%d-%m-%Y') = '".date("d-m-Y")."' 
	GROUP BY ventas.codventa";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION LISTAR VENTAS DIARIAS ######################

###################### FUNCION BUSQUEDA VENTAS POR CAJAS ###########################
public function BuscarVentasxCajas() 
{
	self::SetNames();
	$sql ="SELECT 
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa,
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
	ventas.descontado, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.fechavencecredito,
    ventas.fechapagado, 
	ventas.statusventa, 
	ventas.fechaventa, 
    ventas.observaciones,  
	ventas.notacredito,  
	ventas.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	provincias.provincia,
	departamentos.departamento,
	mediospagos.mediopago,
	cajas.nrocaja,
	cajas.nomcaja,
    usuarios.dni,
    usuarios.nombres,
	SUM(detalleventas.cantventa) as articulos 
	FROM (ventas LEFT JOIN detalleventas ON detalleventas.codventa=ventas.codventa)
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja 
	LEFT JOIN mediospagos ON ventas.formapago = mediospagos.codmediopago 
	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	WHERE ventas.codsucursal = ? 
	AND ventas.codcaja = ? 
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') BETWEEN ? AND ? 
	GROUP BY ventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim(decrypt($_GET['codcaja'])));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(4, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BUSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA VENTAS POR CAJAS ###########################

###################### FUNCION BUSQUEDA VENTAS POR FECHAS ###########################
public function BuscarVentasxFechas() 
	{
	self::SetNames();
	$sql ="SELECT 
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa,
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
	ventas.descontado, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.fechavencecredito,
    ventas.fechapagado, 
	ventas.statusventa, 
	ventas.fechaventa, 
    ventas.observaciones,  
	ventas.notacredito,  
	ventas.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	provincias.provincia,
	departamentos.departamento,
	mediospagos.mediopago,
	cajas.nrocaja,
	cajas.nomcaja,
    usuarios.dni,
    usuarios.nombres,
	SUM(detalleventas.cantventa) as articulos 
	FROM (ventas LEFT JOIN detalleventas ON detalleventas.codventa=ventas.codventa)
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja 
	LEFT JOIN mediospagos ON ventas.formapago = mediospagos.codmediopago 
	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	WHERE ventas.codsucursal = ? 
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') BETWEEN ? AND ? 
	GROUP BY detalleventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BUSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA VENTAS POR FECHAS ###########################

###################### FUNCION BUSQUEDA VENTAS POR CLIENTES ###########################
public function BuscarVentasxClientes() 
{
	self::SetNames();
	$sql ="SELECT 
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa,
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
	ventas.descontado, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.fechavencecredito,
    ventas.fechapagado, 
	ventas.statusventa, 
	ventas.fechaventa, 
    ventas.observaciones,  
	ventas.notacredito,  
	ventas.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	provincias.provincia,
	departamentos.departamento,
	mediospagos.mediopago,
	cajas.nrocaja,
	cajas.nomcaja,
    usuarios.dni,
    usuarios.nombres,
	SUM(detalleventas.cantventa) as articulos 
	FROM (ventas LEFT JOIN detalleventas ON detalleventas.codventa=ventas.codventa)
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja 
	LEFT JOIN mediospagos ON ventas.formapago = mediospagos.codmediopago 
	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	 WHERE ventas.codsucursal = ? 
	 AND ventas.codcliente = ? 
	 AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') BETWEEN ? AND ? 
	 GROUP BY detalleventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim($_GET['codcliente']));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(4, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BUSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA VENTAS POR CLIENTES ###########################

###################### FUNCION BUSQUEDA COMISION POR VENTAS ###########################
public function BuscarComisionxVentas() 
{
	self::SetNames();
	$sql ="SELECT 
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa,
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
	ventas.descontado, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.fechavencecredito,
    ventas.fechapagado, 
	ventas.statusventa, 
	ventas.fechaventa, 
    ventas.observaciones,  
	ventas.notacredito,  
	ventas.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	provincias.provincia,
	departamentos.departamento,
	mediospagos.mediopago,
	cajas.nrocaja,
	cajas.nomcaja,
    usuarios.dni,
    usuarios.nombres,
    usuarios.comision,
	SUM(detalleventas.cantventa) as articulos 
	FROM (ventas LEFT JOIN detalleventas ON detalleventas.codventa=ventas.codventa)
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja 
	LEFT JOIN mediospagos ON ventas.formapago = mediospagos.codmediopago 
	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	WHERE ventas.codsucursal = ? 
	AND ventas.codigo = ? 
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') BETWEEN ? AND ? 
	GROUP BY detalleventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim($_GET['codigo']));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(4, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BUSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA COMISION POR VENTAS ###########################

###################### FUNCION BUSCAR DETALLES VENTAS POR FECHAS #########################
public function BuscarDetallesVentasxFechas() 
{
   self::SetNames();
   $sql ="SELECT 
   detalleventas.idproducto,
   detalleventas.codproducto,
   detalleventas.producto,
   detalleventas.codmarca,
   detalleventas.codmodelo,
   detalleventas.codpresentacion,
   detalleventas.descproducto,  
   detalleventas.ivaproducto,
   detalleventas.precioventa,
   detalleventas.tipodetalle,
   productos.existencia,
   marcas.nommarca, 
   modelos.nommodelo, 
   ventas.iva, 
   ventas.fechaventa,  
   sucursales.documsucursal,
   sucursales.cuitsucursal, 
   sucursales.nomsucursal,  
   sucursales.documencargado,
   sucursales.dniencargado,
   sucursales.nomencargado,
   sucursales.codmoneda,
   sucursales.codmoneda2,
   documentos.documento,
   documentos2.documento AS documento2,
   tiposmoneda.moneda,
   tiposmoneda.siglas,
   tiposmoneda.simbolo,
   tiposmoneda2.moneda AS moneda2,
   tiposmoneda2.siglas AS siglas2,
   tiposmoneda2.simbolo AS simbolo2,
   valor_cambio.montocambio, 
   SUM(detalleventas.cantventa) as cantidad 
   FROM (ventas INNER JOIN detalleventas ON ventas.codventa = detalleventas.codventa) 
   LEFT JOIN productos ON detalleventas.idproducto = productos.idproducto 
   LEFT JOIN marcas ON detalleventas.codmarca = marcas.codmarca 
   LEFT JOIN modelos ON detalleventas.codmodelo = modelos.codmodelo 
   INNER JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal
   LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
   LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
   LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
   LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
   WHERE ventas.codsucursal = '".decrypt($_GET['codsucursal'])."' 
   AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') BETWEEN ? AND ?
   GROUP BY detalleventas.codproducto, detalleventas.precioventa, detalleventas.descproducto, detalleventas.codsucursal 
   ORDER BY detalleventas.codproducto ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN PRODUCTOS FACTURADOS PARA EL RANGO DE FECHA INGRESADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################### FUNCION BUSCAR DETALLES VENTAS POR FECHAS ###############################

###################### FUNCION BUSCAR DETALLES VENTAS POR VENDEDOR #########################
public function BuscarDetallesVentasxVendedor() 
{
	self::SetNames();
   $sql ="SELECT 
   detalleventas.idproducto,
   detalleventas.codproducto,
   detalleventas.producto,
   detalleventas.codmarca,
   detalleventas.codmodelo,
   detalleventas.codpresentacion,
   detalleventas.descproducto,  
   detalleventas.ivaproducto,
   detalleventas.precioventa,
   detalleventas.tipodetalle, 
   productos.existencia,
   marcas.nommarca, 
   modelos.nommodelo, 
   ventas.iva, 
   ventas.fechaventa,  
   sucursales.documsucursal,
   sucursales.cuitsucursal, 
   sucursales.nomsucursal,  
   sucursales.documencargado,
   sucursales.dniencargado,
   sucursales.nomencargado,
   sucursales.codmoneda,
   sucursales.codmoneda2,
   documentos.documento,
   documentos2.documento AS documento2,
   tiposmoneda.moneda,
   tiposmoneda.siglas,
   tiposmoneda.simbolo,
   tiposmoneda2.moneda AS moneda2,
   tiposmoneda2.siglas AS siglas2,
   tiposmoneda2.simbolo AS simbolo2,
   valor_cambio.montocambio,
   usuarios.dni,
   usuarios.nombres, 
   SUM(detalleventas.cantventa) as cantidad 
   FROM (ventas INNER JOIN detalleventas ON ventas.codventa = detalleventas.codventa) 
   LEFT JOIN productos ON detalleventas.idproducto = productos.idproducto 
   LEFT JOIN marcas ON detalleventas.codmarca = marcas.codmarca 
   LEFT JOIN modelos ON detalleventas.codmodelo = modelos.codmodelo
   INNER JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal
   LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
   LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
   LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
   LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
   LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo 
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
   WHERE ventas.codsucursal = '".decrypt($_GET['codsucursal'])."'
   AND ventas.codigo = ? 
   AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') BETWEEN ? AND ?
   GROUP BY detalleventas.codproducto, detalleventas.precioventa, detalleventas.descproducto, detalleventas.codsucursal 
   ORDER BY detalleventas.codproducto ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_GET['codigo']));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN PRODUCTOS FACTURADOS PARA EL VENDEDOR Y RANGO DE FECHA INGRESADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################### FUNCION BUSCAR DETALLES VENTAS POR VENDEDOR ###############################

############################ FIN DE CLASE VENTAS #############################





































###################################### CLASE CREDITOS ###################################

####################### FUNCION REGISTRAR PAGOS A CREDITOS ##########################
public function RegistrarPago()
	{
	self::SetNames();
	####################### VERIFICO ARQUEO DE CAJA #######################
	$sql = "SELECT * FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
	WHERE usuarios.codigo = ? AND arqueocaja.statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_SESSION["codigo"]));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "1";
		exit;

	} else {
		
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		$codarqueo = $row['codarqueo'];
		$codcaja = $row['codcaja'];
		$ingreso = ($row['ingresos']== "" ? "0.00" : $row['ingresos']);
		$credito = ($row['creditos']== "" ? "0.00" : $row['creditos']);
		$abono = ($row['abonos']== "" ? "0.00" : $row['abonos']);
	}
    ####################### VERIFICO ARQUEO DE CAJA #######################

	if(empty($_POST["codcliente"]) or empty($_POST["codventa"]) or empty($_POST["montoabono"]))
	{
		echo "2";
		exit;
	} 
	else if($_POST["montoabono"] > $_POST["totaldebe"])
	{
		echo "3";
		exit;

	} else {

	################### VERIFICO MONTO DE CREDITO DEL CLIENTE ######################
	$sql = "SELECT montocredito 
	FROM creditosxclientes 
	WHERE codcliente = '".limpiar($_POST['codcliente'])."' 
	AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
    $monto = (empty($row['montocredito']) ? "0.00" : $row['montocredito']);
    ################### VERIFICO MONTO DE CREDITO DEL CLIENTE ######################

	################### INGRESOS EL ABONO DEL CREDITO ######################
	$query = "INSERT INTO abonoscreditosventas values (null, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codcaja);
	$stmt->bindParam(2, $codventa);
	$stmt->bindParam(3, $codcliente);
	$stmt->bindParam(4, $montoabono);
	$stmt->bindParam(5, $fechaabono);
	$stmt->bindParam(6, $codsucursal);

	$codventa = limpiar(decrypt($_POST["codventa"]));
	$codcliente = limpiar(decrypt($_POST["codcliente"]));
	$montoabono = limpiar($_POST["montoabono"]);
	$fechaabono = limpiar(date("Y-m-d H:i:s"));
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();
	################### INGRESOS EL ABONO DEL CREDITO ######################

	############# ACTUALIZAMNOS DATOS DE CAJA ##############
	$sql = "UPDATE arqueocaja set "
	." ingresos = ? "
	." WHERE "
	." codarqueo = ? AND statusarqueo = 1;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $txtEfectivo);
	$stmt->bindParam(2, $codarqueo);

    $txtEfectivo = number_format($_POST["montoabono"] + $ingreso, 2, '.', '');
	$stmt->execute();
	############# ACTUALIZAMNOS DATOS DE CAJA ##############

	############## ACTUALIZAMOS EL MONTO DE CREDITO ##################
	$sql = "UPDATE creditosxclientes set"
	." montocredito = ? "
	." where "
	." codcliente = ? AND codsucursal = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $montocredito);
	$stmt->bindParam(2, $codcliente);
	$stmt->bindParam(3, $codsucursal);

	$montocredito = number_format($monto - $_POST["montoabono"], 2, '.', '');
	$codcliente = limpiar(decrypt($_POST["codcliente"]));
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();
    ############## ACTUALIZAMOS EL MONTO DE CREDITO ##################

    ############## ACTUALIZAMOS EL STATUS DE LA FACTURA ##################
	if($_POST["montoabono"] == $_POST["totaldebe"]) {

		$sql = "UPDATE ventas set "
		." creditopagado = ?, "
		." statusventa = ?, "
		." fechapagado = ? "
		." WHERE "
		." codventa = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $creditopagado);
		$stmt->bindParam(2, $statusventa);
		$stmt->bindParam(3, $fechapagado);
		$stmt->bindParam(4, $codventa);
		$stmt->bindParam(5, $codsucursal);

		$creditopagado = number_format($_POST["totalabono"] + $_POST["montoabono"], 2, '.', '');
		$statusventa = limpiar("PAGADA");
		$fechapagado = limpiar(date("Y-m-d"));
		$codventa = limpiar(decrypt($_POST["codventa"]));
		$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
		$stmt->execute();
	
	} else {

		$sql = "UPDATE ventas set "
		." creditopagado = ? "
		." WHERE "
		." codventa = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $creditopagado);
		$stmt->bindParam(2, $codventa);
		$stmt->bindParam(3, $codsucursal);

		$creditopagado = number_format($_POST["totalabono"] + $_POST["montoabono"], 2, '.', '');
		$codventa = limpiar(decrypt($_POST["codventa"]));
		$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
		$stmt->execute();
	}
    ############## ACTUALIZAMOS EL STATUS DE LA FACTURA ##################
	
echo "<span class='fa fa-check-square-o'></span> EL ABONO AL CR&Eacute;DITO DE VENTA HA SIDO REGISTRADO EXITOSAMENTE <a href='reportepdf?codventa=".encrypt($codventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("TICKETCREDITO")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR TICKET</strong></font color></a></div>";

echo "<script>window.open('reportepdf?codventa=".encrypt($codventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("TICKETCREDITO")."', '_blank');</script>";
	exit;
   }
}
########################## FUNCION REGISTRAR PAGOS A CREDITOS ####################

###################### FUNCION LISTAR CREDITOS ####################### 
public function ListarCreditos()
{
	self::SetNames();

if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT 
	ventas.idventa,
	ventas.tipodocumento,
	ventas.codventa,
	ventas.codcliente,
	ventas.codfactura, 
	ventas.totalpago, 
	ventas.tipopago,
	ventas.creditopagado,
	ventas.statusventa,
	ventas.fechaventa, 
	ventas.fechavencecredito,
	ventas.fechapagado,
	ventas.observaciones,
	ventas.codsucursal, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito, 
	abonoscreditosventas.codventa as codigo, 
	abonoscreditosventas.fechaabono, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3 
	FROM (ventas INNER JOIN clientes ON ventas.codcliente = clientes.codcliente)
	LEFT JOIN abonoscreditosventas ON ventas.codventa = abonoscreditosventas.codventa
	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
	WHERE ventas.tipopago ='CREDITO'
	GROUP BY ventas.idventa 
	ORDER BY ventas.idventa ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

 } else if($_SESSION["acceso"] == "cajero") {

	$sql = "SELECT 
	ventas.idventa,
	ventas.tipodocumento,
	ventas.codventa,
	ventas.codcliente,
	ventas.codfactura, 
	ventas.totalpago, 
	ventas.tipopago,
	ventas.creditopagado,
	ventas.statusventa,
	ventas.fechaventa, 
	ventas.fechavencecredito,
	ventas.fechapagado,
	ventas.observaciones,
	ventas.codsucursal, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito, 
	abonoscreditosventas.codventa as codigo, 
	abonoscreditosventas.fechaabono, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3 
	FROM (ventas INNER JOIN clientes ON ventas.codcliente = clientes.codcliente)
	LEFT JOIN abonoscreditosventas ON ventas.codventa = abonoscreditosventas.codventa
	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	WHERE ventas.tipopago ='CREDITO'
	AND ventas.codigo = '".limpiar($_SESSION["codigo"])."'
	GROUP BY ventas.idventa 
	ORDER BY ventas.idventa ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

  } else {

   $sql = "SELECT 
	ventas.idventa,
	ventas.tipodocumento,
	ventas.codventa,
	ventas.codcliente,
	ventas.codfactura, 
	ventas.totalpago, 
	ventas.tipopago,
	ventas.creditopagado,
	ventas.statusventa,
	ventas.fechaventa, 
	ventas.fechavencecredito,
	ventas.fechapagado,
	ventas.observaciones,
	ventas.codsucursal, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito, 
	abonoscreditosventas.codventa as codigo, 
	abonoscreditosventas.fechaabono, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3 
	FROM (ventas INNER JOIN clientes ON ventas.codcliente = clientes.codcliente)
	LEFT JOIN abonoscreditosventas ON ventas.codventa = abonoscreditosventas.codventa
	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
	WHERE ventas.tipopago ='CREDITO' 
	AND ventas.codsucursal = '".limpiar($_SESSION["codsucursal"])."'
	GROUP BY ventas.idventa 
	ORDER BY ventas.idventa ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
   }
}
###################### FUNCION LISTAR CREDITOS ####################### 

############################ FUNCION ID CREDITOS #################################
public function CreditosPorId()
{
	self::SetNames();
	$sql = " SELECT 
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa,
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2,
	ventas.creditopagado, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
    ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
    ventas.observaciones,  
	ventas.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.tlfsucursal,
	sucursales.correosucursal,
	sucursales.id_provincia,
	sucursales.id_departamento,
	sucursales.direcsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia AS id_provincia2, 
	clientes.id_departamento AS id_departamento2,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	mediospagos.mediopago,
	cajas.nrocaja,
	cajas.nomcaja,
	usuarios.dni, 
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento,
    provincias2.provincia AS provincia2,
    departamentos2.departamento AS departamento2
	FROM (ventas INNER JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal)
	LEFT JOIN abonoscreditosventas ON ventas.codventa = abonoscreditosventas.codventa
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento 
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON clientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON clientes.id_departamento = departamentos2.id_departamento 
	LEFT JOIN cajas ON abonoscreditosventas.codcaja = cajas.codcaja
	LEFT JOIN mediospagos ON ventas.formapago = mediospagos.codmediopago 
	LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
	WHERE ventas.codventa = ? 
	AND ventas.codsucursal = ? 
	GROUP BY abonoscreditosventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codventa"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID CREDITOS #################################
	
########################### FUNCION VER DETALLES VENTAS #######################
public function VerDetallesAbonos()
{
	self::SetNames();
	$sql = "SELECT * FROM abonoscreditosventas 
	INNER JOIN ventas ON abonoscreditosventas.codventa = ventas.codventa 
	LEFT JOIN cajas ON abonoscreditosventas.codcaja = cajas.codcaja 
	WHERE abonoscreditosventas.codventa = ? 
	AND abonoscreditosventas.codsucursal = ?";	
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET["codventa"])));
	$stmt->bindValue(2, trim(decrypt($_GET["codsucursal"])));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################## FUNCION VER DETALLES VENTAS ###########################

###################### FUNCION BUSQUEDA CREDITOS POR CLIENTES ###########################
public function BuscarCreditosxClientes() 
{
	self::SetNames();
	$sql = "SELECT 
	ventas.codventa,
	ventas.codcliente, 
	ventas.codfactura,
	ventas.tipodocumento, 
	ventas.totalpago, 
	ventas.tipopago,
	ventas.creditopagado,
	ventas.statusventa,
	ventas.fechaventa, 
	ventas.fechavencecredito,
	ventas.fechapagado,
	ventas.observaciones,
	ventas.codsucursal, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito, 
	abonoscreditosventas.codventa as codigo, 
	abonoscreditosventas.fechaabono, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3  
	FROM (ventas INNER JOIN clientes ON ventas.codcliente = clientes.codcliente)
	LEFT JOIN abonoscreditosventas ON ventas.codventa = abonoscreditosventas.codventa
	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
	WHERE ventas.codsucursal = ? 
	AND ventas.codcliente = ? 
	AND ventas.tipopago ='CREDITO' 
	GROUP BY ventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim($_GET['cliente']));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CREDITOS PARA EL CLIENTE INGRESADO</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA CREDITOS POR CLIENTES ###########################

###################### FUNCION BUSQUEDA CREDITOS POR FECHAS ###########################
public function BuscarCreditosxFechas() 
{
	self::SetNames();
	$sql = "SELECT 
	ventas.codventa,
	ventas.codcliente,
	ventas.codfactura,
	ventas.tipodocumento, 
	ventas.totalpago, 
	ventas.tipopago,
	ventas.creditopagado,
	ventas.statusventa,
	ventas.fechaventa, 
	ventas.fechavencecredito,
	ventas.fechapagado,
	ventas.observaciones,
	ventas.codsucursal, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito, 
	abonoscreditosventas.codventa as codigo, 
	abonoscreditosventas.fechaabono, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3  
	FROM (ventas INNER JOIN clientes ON ventas.codcliente = clientes.codcliente)
	LEFT JOIN abonoscreditosventas ON ventas.codventa = abonoscreditosventas.codventa
	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
	WHERE ventas.codsucursal = ? 
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') BETWEEN ? AND ?
	AND ventas.tipopago ='CREDITO' GROUP BY ventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CREDITOS PARA EL RANGO DE FECHA INGRESADO</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA CREDITOS POR FECHAS ###########################

###################### FUNCION BUSQUEDA CREDITOS POR DETALLES ###########################
public function BuscarCreditosxDetalles() 
{
	self::SetNames();
	$sql = "SELECT 
	ventas.codventa,
	ventas.codcliente,
	ventas.codfactura, 
	ventas.tipodocumento,
	ventas.totalpago,
	ventas.creditopagado, 
	ventas.tipopago,
	ventas.statusventa,
	ventas.fechaventa, 
	ventas.fechavencecredito,
	ventas.fechapagado,
	ventas.observaciones,
	ventas.codsucursal, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	GROUP_CONCAT(detalleventas.cantventa, ' | ', detalleventas.producto SEPARATOR '<br>') AS detalles
    FROM (ventas LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente)
	LEFT JOIN detalleventas ON ventas.codventa = detalleventas.codventa
    LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
	WHERE ventas.codsucursal = ? 
	AND ventas.codcliente = ? 
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') BETWEEN ? AND ?
	AND ventas.tipopago ='CREDITO' GROUP BY ventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim($_GET['cliente']));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(4, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CREDITOS PARA TU BUSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA CREDITOS POR DETALLES ###########################

###################################### CLASE CREDITOS ###################################














































###################################### CLASE NOTA DE CREDITO ###################################

############################ FUNCION ID VENTAS #################################
public function BuscarVentasPorId()
	{
	self::SetNames();
	$sql = "SELECT 
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa,
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
    ventas.descontado, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.creditopagado,
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
    ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
    ventas.observaciones,  
    ventas.notacredito,   
	ventas.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.tlfsucursal,
	sucursales.correosucursal,
	sucursales.id_provincia,
	sucursales.id_departamento,
	sucursales.direcsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia AS id_provincia2, 
	clientes.id_departamento AS id_departamento2,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
    documentos2.documento AS documento2, 
    documentos3.documento AS documento3,
    mediospagos.mediopago,
    cajas.nrocaja,
    cajas.nomcaja,
    usuarios.dni, 
    usuarios.nombres,
    provincias.provincia,
    departamentos.departamento,
    provincias2.provincia AS provincia2,
    departamentos2.departamento AS departamento2,
	ROUND(SUM(if(pag.montocredito!='0',pag.montocredito,'0.00')), 2) montoactual,
    ROUND(SUM(if(pag.montocredito!='0',clientes.limitecredito-pag.montocredito,clientes.limitecredito)), 2) creditodisponible,
    pag2.abonototal
    FROM (ventas INNER JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal)
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento 
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON clientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON clientes.id_departamento = departamentos2.id_departamento 
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja
	LEFT JOIN mediospagos ON ventas.formapago = mediospagos.codmediopago 
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo

	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
    
    LEFT JOIN
        (SELECT
        codcliente, montocredito       
        FROM creditosxclientes 
        WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."') pag ON pag.codcliente = clientes.codcliente
    
    LEFT JOIN
        (SELECT
        codventa, codcliente, SUM(if(montoabono!='0',montoabono,'0.00')) AS abonototal
        FROM abonoscreditosventas 
        WHERE codventa = '".limpiar($_GET["codventa"])."' AND codsucursal = '".limpiar($_SESSION["codsucursal"])."') pag2 ON pag2.codcliente = clientes.codcliente

        WHERE ventas.codventa = ? AND ventas.codsucursal = ?";
    $stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_GET["codventa"],limpiar($_SESSION["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID VENTAS #################################
	
############################ FUNCION VER DETALLES VENTAS #############################
public function BuscarDetallesVentas()
	{
	self::SetNames();
	$sql = "SELECT
	detalleventas.coddetalleventa,
	detalleventas.codventa,
	detalleventas.idproducto,
	detalleventas.codproducto,
	detalleventas.producto,
	detalleventas.codmarca,
	detalleventas.codmodelo,
	detalleventas.codpresentacion,
	detalleventas.cantventa,
	detalleventas.preciocompra,
	detalleventas.precioventa,
	detalleventas.ivaproducto,
	detalleventas.descproducto,
	detalleventas.valortotal, 
	detalleventas.totaldescuentov,
	detalleventas.valorneto,
	detalleventas.valorneto2,
	detalleventas.tipodetalle,
	detalleventas.codsucursal,
	marcas.nommarca,
	modelos.nommodelo,
	presentaciones.nompresentacion
	FROM detalleventas LEFT JOIN productos ON detalleventas.codproducto = productos.codproducto 
	LEFT JOIN marcas ON productos.codmarca = marcas.codmarca
	LEFT JOIN modelos ON productos.codmodelo = modelos.codmodelo 
	LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion 
	WHERE detalleventas.codventa = ? 
	AND detalleventas.codsucursal = ? ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($_GET["codventa"]),limpiar($_SESSION["codsucursal"])));
	$num = $stmt->rowCount();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$this->p[]=$row;
	}
		return $this->p;
		$this->dbh=null;
}
########################### FUNCION VER DETALLES VENTAS ###########################

####################### FUNCION REGISTRAR NOTA DE CREDITO #############################
public function RegistrarNotaCredito()
	{
	self::SetNames();
	if($_POST["descontar"] == 1){//VERIFICO SI SE DESCONTARA DE CAJA

	####################### VERIFICO ARQUEO DE CAJA #######################
	$sql = "SELECT * FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
	WHERE arqueocaja.codarqueo = ? AND arqueocaja.statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_POST["codarqueo"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "1";
		exit;

	} else {
		
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		$codarqueo = $row['codarqueo'];
		$codcaja = $row['codcaja'];
		$SaldoCaja = number_format($row['ingresos']-$row['egresos'], 2, '.', '');
	}
    ####################### VERIFICO ARQUEO DE CAJA #######################

    }//FIN DE VERIFICO SI SE DESCONTARA DE CAJA

	if(empty($_POST["codventa"]) or empty($_POST["observaciones"]) or empty($_POST["fechanota"]))
	{
		echo "2";
		exit;
	} 
	elseif(!array_filter($_POST['devuelto']) || $_POST["txtTotal"] == "" || $_POST["txtTotal"] == "0" || $_POST["txtTotal"] == "0.00")
	{
		echo "3";
		exit;
	} 
	else if($_POST["descontar"] == 1 && $_POST["txtTotal"] > $SaldoCaja){

		echo "4";
		exit;
	}

	$this->dbh->beginTransaction();
	for($i=0;$i<count($_POST['devuelto']);$i++){
        if (!empty($_POST['devuelto'][$i])) {

        	if($_POST['devuelto'][$i] > $_POST['cantidad'][$i]){

        		echo "5";
        		exit;
        	}

        }//fin de if
	}//fin de for
    $this->dbh->commit();

	################# OBTENGO DATOS DE SUCURSAL #################
	$sql = " SELECT 
	codsucursal, 
	nroactividadsucursal, 
	inicionotacredito 
	FROM sucursales WHERE codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$nroactividad = $row['nroactividadsucursal'];
	$inicionotacredito = $row['inicionotacredito'];
	################# OBTENGO DATOS DE SUCURSAL #################

	################ CREO CODIGO DE NOTA ####################
	$sql = "SELECT codnota FROM notascredito 
	ORDER BY idnota DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$nota=$row["codnota"];

	}
	if(empty($nota))
	{
		$codnota = "01";

	} else {

		$num = substr($nota, 0);
        $dig = $num + 1;
        $codigofinal = str_pad($dig, 2, "0", STR_PAD_LEFT);
        $codnota = $codigofinal;
	}
    ################ CREO CODIGO DE NOTA ###############

	################### CREO CODIGO DE FACTURA ####################
	$sql4 = "SELECT codfactura 
	FROM notascredito 
	WHERE codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."' 
	ORDER BY idnota DESC LIMIT 1";
	foreach ($this->dbh->query($sql4) as $row4){

	    $factura=$row4["codfactura"];

	}
	if(empty($nota))
	{
		$codfactura = $nroactividad.'-'.$inicionotacredito;

	} else {

        $var = strlen($nroactividad."-");
        $var1 = substr($factura , $var);
        $var2 = strlen($var1);
        $var3 = $var1 + 1;
        $var4 = str_pad($var3, $var2, "0", STR_PAD_LEFT);
        $codfactura = $nroactividad.'-'.$var4;
	}
    ################ CREO LOS CODIGO VENTA-SERIE-AUTORIZACION ###############

	$query = "INSERT INTO notascredito values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $numerocaja);
	$stmt->bindParam(2, $codnota);
	$stmt->bindParam(3, $codfactura);
	$stmt->bindParam(4, $tipodocumento);
	$stmt->bindParam(5, $facturaventa);
	$stmt->bindParam(6, $codcliente);
	$stmt->bindParam(7, $subtotalivasi);
	$stmt->bindParam(8, $subtotalivano);
	$stmt->bindParam(9, $iva);
	$stmt->bindParam(10, $totaliva);
	$stmt->bindParam(11, $descontado);
	$stmt->bindParam(12, $descuento);
	$stmt->bindParam(13, $totaldescuento);
	$stmt->bindParam(14, $totalpago);
	$stmt->bindParam(15, $fechanota);
	$stmt->bindParam(16, $observaciones);
	$stmt->bindParam(17, $codigo);
	$stmt->bindParam(18, $codsucursal);

    $numerocaja = limpiar($_POST['descontar'] == 1 ? $codcaja : "0");	
    $tipodocumento = limpiar($_POST["tipodocumento"]);
	$facturaventa = limpiar($_POST["codfactura"]);
	$codcliente = limpiar($_POST["codcliente"]);
	$subtotalivasi = limpiar($_POST["txtsubtotal"]);
	$subtotalivano = limpiar($_POST["txtsubtotal2"]);
	$iva = limpiar($_POST["iva"]);
	$totaliva = limpiar($_POST["txtIva"]);
	$descontado = limpiar($_POST["txtdescontado"]);
	$descuento = limpiar($_POST["descuento"]);
	$totaldescuento = limpiar($_POST["txtDescuento"]);
	$totalpago = limpiar($_POST["txtTotal"]);
	$fechanota = limpiar(date("Y-m-d H:i:s",strtotime($_POST['fechanota'])));
	$observaciones = limpiar($_POST["observaciones"]);
	$codigo = limpiar($_SESSION["codigo"]);
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();

	$this->dbh->beginTransaction();
	for($i=0;$i<count($_POST['devuelto']);$i++){
        if (!empty($_POST['devuelto'][$i])) {

        	$query = "INSERT INTO detallenotas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
        	$stmt = $this->dbh->prepare($query);
        	$stmt->bindParam(1, $codnota);
        	$stmt->bindParam(2, $idproducto);
        	$stmt->bindParam(3, $codproducto);
        	$stmt->bindParam(4, $producto);
        	$stmt->bindParam(5, $codmarca);
        	$stmt->bindParam(6, $codmodelo);
        	$stmt->bindParam(7, $codpresentacion);
        	$stmt->bindParam(8, $cantidad);
        	$stmt->bindParam(9, $preciocompra);
        	$stmt->bindParam(10, $precioventa);
        	$stmt->bindParam(11, $ivaproducto);
        	$stmt->bindParam(12, $descproducto);
        	$stmt->bindParam(13, $valortotal);
        	$stmt->bindParam(14, $totaldescuentov);
        	$stmt->bindParam(15, $valorneto);
        	$stmt->bindParam(16, $tipodetalle);
        	$stmt->bindParam(17, $codsucursal);

        	$idproducto = limpiar($_POST['idproducto'][$i]);
        	$codproducto = limpiar($_POST['codproducto'][$i]);
        	$producto = limpiar($_POST['producto'][$i]);
        	$codmarca = limpiar($_POST['codmarca'][$i]);
        	$codmodelo = limpiar($_POST['codmodelo'][$i]);
        	$codpresentacion = limpiar($_POST['codpresentacion'][$i]);
        	$cantidad = limpiar($_POST['devuelto'][$i]);
        	$preciocompra = limpiar($_POST['preciocompra'][$i]);
        	$precioventa = limpiar($_POST['precioventa'][$i]);
        	$ivaproducto = limpiar($_POST['ivaproducto'][$i]);
        	$descproducto = limpiar($_POST['descproducto'][$i]);
        	$descuento = $_POST['descproducto'][$i]/100;
        	$valortotal = number_format($_POST['valortotal'][$i], 2, '.', '');
        	$totaldescuentov = number_format($_POST['totaldescuentov'][$i], 2, '.', '');
        	$valorneto = number_format($valortotal-$totaldescuentov, 2, '.', '');
        	$tipodetalle = limpiar($_POST['tipodetalle'][$i]);
        	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
        	$stmt->execute();

        if($_POST['tipodetalle'][$i] == 1 && $_POST['devuelto'][$i] == 1){

        	#################### CONSULTO EXISTENCIA DE PRODUCTO ####################
        	$sql2 = "SELECT existencia FROM productos WHERE codproducto = ? AND codsucursal = ?";
			$stmt = $this->dbh->prepare($sql2);
			$stmt->execute(array($_POST['codproducto'][$i],decrypt($_POST["codsucursal"])));
			$num = $stmt->rowCount();

			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$p[] = $row;
			}
			$existenciabd = $row['existencia'];
			#################### CONSULTO EXISTENCIA DE PRODUCTO ####################

        	#################### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO ####################
			$sql = "UPDATE productos SET "
			." existencia = ? "
			." WHERE "
			." codproducto = ? AND codsucursal = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $existencia);
			$stmt->bindParam(2, $codproducto);
			$stmt->bindParam(3, $codsucursal);

			$existencia = limpiar($existenciabd + $_POST['devuelto'][$i]);
			$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
			$stmt->execute();
			#################### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO ####################
		}

        	############## REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
        	$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
        	$stmt = $this->dbh->prepare($query);
        	$stmt->bindParam(1, $codnota);
        	$stmt->bindParam(2, $codresponsable);
        	$stmt->bindParam(3, $codproducto);
        	$stmt->bindParam(4, $movimiento);
        	$stmt->bindParam(5, $entradas);
        	$stmt->bindParam(6, $salidas);
        	$stmt->bindParam(7, $devolucion);
        	$stmt->bindParam(8, $stockactual);
        	$stmt->bindParam(9, $ivaproducto);
        	$stmt->bindParam(10, $descproducto);
        	$stmt->bindParam(11, $precio);
        	$stmt->bindParam(12, $documento);
        	$stmt->bindParam(13, $fechakardex);	
        	$stmt->bindParam(14, $tipokardex);	
        	$stmt->bindParam(15, $codsucursal);

        	$codresponsable = limpiar($_POST["codcliente"]);
        	$codproducto = limpiar($_POST['codproducto'][$i]);
        	$movimiento = limpiar("DEVOLUCION");
        	$entradas = limpiar("0");
        	$salidas= limpiar("0");
        	$devolucion = limpiar($_POST['devuelto'][$i]);
        	$stockactual = limpiar($_POST['tipodetalle'][$i] == 1 ? $existenciabd+$_POST['devuelto'][$i] : "0");
        	$precio = limpiar($_POST["precioventa"][$i]);
        	$ivaproducto = limpiar($_POST['ivaproducto'][$i]);
        	$descproducto = limpiar($_POST['descproducto'][$i]);
        	$documento = limpiar("NOTA DE CRÉDITO: ".$codnota);
        	$fechakardex = limpiar(date("Y-m-d"));
        	$tipokardex = limpiar($_POST['tipodetalle'][$i]);
        	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
        	$stmt->execute();
        	############## REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################

        }//fin de if
	}//fin de for
    $this->dbh->commit();


	############## ACTUALIZAMOS STATUS DE FACTURA ###############
	$sql = "UPDATE ventas set "
	." notacredito = ? "
	." WHERE "
	." codventa = ? AND codsucursal = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $notacredito);
	$stmt->bindParam(2, $codventa);
	$stmt->bindParam(3, $codsucursal);

	$notacredito = limpiar("1");
	$codventa = limpiar($_POST["codventa"]);
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();
    ################ ACTUALIZAMOS STATUS DE FACTURA ##############

    ############## DESCONTAMOS EL TOTAL DE DOCUMENTO EN CAJA ###############
	if (limpiar($_POST["descontar"] == 1 && $_POST["tipopago"]=="CONTADO")){

		################## OBTENGO LOS DATOS EN CAJA ##################
		$sql = "SELECT 
		ingresos, 
		egresos,
		creditos,
		abonos
		FROM arqueocaja 
		WHERE codarqueo = '".limpiar($codarqueo)."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$ingreso = ($row['ingresos']== "" ? "0.00" : $row['ingresos']);
		$credito = ($row['creditos']== "" ? "0.00" : $row['creditos']);
		$egreso = ($row['egresos']== "" ? "0.00" : $row['egresos']);
		$abono = ($row['abonos']== "" ? "0.00" : $row['abonos']);
		$disponible = $ingreso-$egreso;
		################## OBTENGO LOS DATOS EN CAJA ##################

		########################## DESCUENTO EL MONTO EN CAJA ##########################
	    $sql = "UPDATE arqueocaja set "
		." ingresos = ? "
		." WHERE "
		." codarqueo = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtTotal);
		$stmt->bindParam(2, $codarqueo);

		$txtTotal = number_format($disponible-$_POST["txtTotal"], 2, '.', '');
		$stmt->execute();
		########################## DESCUENTO EL MONTO EN CAJA ##########################
	}
    ################ DESCONTAMOS EL TOTAL DE DOCUMENTO EN CAJA ##############

    ############## DESCONTAMOS EL TOTAL DE DOCUMENTO EN CAJA ###############
	if (limpiar($_POST["descontar"] == 1 && $_POST["tipopago"]=="CREDITO")){

		################## OBTENGO LOS DATOS EN CAJA ##################
		$sql = "SELECT 
		ingresos, 
		egresos,
		creditos,
		abonos
		FROM arqueocaja 
		WHERE codarqueo = '".limpiar($codarqueo)."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$ingreso = ($row['ingresos']== "" ? "0.00" : $row['ingresos']);
		$egreso = ($row['egresos']== "" ? "0.00" : $row['egresos']);
		$credito = ($row['creditos']== "" ? "0.00" : $row['creditos']);
		$abono = ($row['abonos']== "" ? "0.00" : $row['abonos']);
		$disponible = $ingreso-$egreso;
		################## OBTENGO LOS DATOS EN CAJA ##################

		########################## DESCUENTO EL MONTO EN CAJA ##########################
	    $sql = "UPDATE arqueocaja set "
		." ingresos = ?, "
		." creditos = ?, "
		." WHERE "
		." codarqueo = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtIngreso);
		$stmt->bindParam(2, $txtCredito);
		$stmt->bindParam(3, $codarqueo);

		$txtIngreso = ($_POST["abonototal"]!= "0.00" ? number_format($ingreso-$_POST["abonototal"], 2, '.', '') : $ingreso);
		$txtCredito = number_format($credito-$_POST["txtTotal"], 2, '.', '');
		$stmt->execute();
		########################## DESCUENTO EL MONTO EN CAJA ##########################

	}
    ################ DESCONTAMOS EL TOTAL DE DOCUMENTO CAJA ##############

echo "<span class='fa fa-check-square-o'></span> EL NOTA DE CR&Eacute;DITO HA SIDO REGISTRADA EXITOSAMENTE <a href='reportepdf?codnota=".encrypt($codnota)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("NOTACREDITO")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR DOCUMENTO</strong></font color></a></div>";

echo "<script>window.open('reportepdf?codnota=".encrypt($codnota)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("NOTACREDITO")."', '_blank');</script>";
	exit;
}
##################### FUNCION REGISTRAR NOTA DE CREDITO ###########################

############################ FUNCION ID NOTA CREDITO #################################
public function NotaCreditoPorId()
	{
	self::SetNames();
	$sql = "SELECT 
    notascredito.idnota,
	notascredito.codcaja, 
    notascredito.codnota,
    notascredito.codfactura,
    notascredito.tipodocumento,
    notascredito.facturaventa,
	notascredito.codcliente, 
	notascredito.subtotalivasi, 
	notascredito.subtotalivano, 
	notascredito.iva, 
	notascredito.totaliva,
	notascredito.descontado, 
	notascredito.descuento, 
	notascredito.totaldescuento, 
	notascredito.totalpago, 
	notascredito.fechanota,
    notascredito.observaciones,  
	notascredito.codsucursal,
    sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.tlfsucursal,
	sucursales.correosucursal,
	sucursales.id_provincia,
	sucursales.id_departamento,
	sucursales.direcsucursal,
	sucursales.nroactividadsucursal,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia AS id_provincia2, 
	clientes.id_departamento AS id_departamento2,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
    documentos2.documento AS documento2, 
    documentos3.documento AS documento3,
    provincias.provincia,
    departamentos.departamento,
    provincias2.provincia AS provincia2,
    departamentos2.departamento AS departamento2,
    cajas.nrocaja,
    cajas.nomcaja,
    usuarios.dni, 
    usuarios.nombres
    FROM (notascredito INNER JOIN sucursales ON notascredito.codsucursal = sucursales.codsucursal)
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento 
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON notascredito.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON clientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON clientes.id_departamento = departamentos2.id_departamento 
	LEFT JOIN cajas ON notascredito.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON notascredito.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
	WHERE notascredito.codnota = ? 
	AND notascredito.codsucursal = ?";
    $stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codnota"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID NOTA CREDITO #################################

########################### FUNCION VER DETALLES NOTA DE CREDITO ##########################
public function VerDetallesNotasCredito()
	{
	self::SetNames();
	$sql = "SELECT
	detallenotas.coddetallenota,
	detallenotas.codnota,
	detallenotas.idproducto,
	detallenotas.codproducto,
	detallenotas.producto,
	detallenotas.codmarca,
	detallenotas.codmodelo,
	detallenotas.codpresentacion,
	detallenotas.cantventa,
	detallenotas.preciocompra,
	detallenotas.precioventa,
	detallenotas.ivaproducto,
	detallenotas.descproducto,
	detallenotas.valortotal, 
	detallenotas.totaldescuentov,
	detallenotas.valorneto,
	detallenotas.tipodetalle,
	detallenotas.codsucursal,
	marcas.nommarca,
	modelos.nommodelo
	FROM detallenotas 
	LEFT JOIN productos ON detallenotas.codproducto = productos.codproducto 
	LEFT JOIN marcas ON detallenotas.codmarca = marcas.codmarca
	LEFT JOIN modelos ON detallenotas.codmodelo = modelos.codmodelo 
	WHERE detallenotas.codnota = ? 
	AND detallenotas.codsucursal = ? ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codnota"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$this->p[]=$row;
	}
		return $this->p;
		$this->dbh=null;
}
############################ FUNCION VER DETALLES NOTA DE CREDITO #######################

###################### FUNCION LISTAR NOTA DE CREDITO ####################### 
public function ListarNotasCreditos()
{
	self::SetNames();

if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT 
	notascredito.idnota, 
	notascredito.codcaja, 
    notascredito.codnota,
    notascredito.codfactura,
    notascredito.tipodocumento,
    notascredito.facturaventa,
	notascredito.codcliente, 
	notascredito.subtotalivasi, 
	notascredito.subtotalivano, 
	notascredito.iva, 
	notascredito.totaliva,
	notascredito.descontado, 
	notascredito.descuento, 
	notascredito.totaldescuento, 
	notascredito.totalpago, 
	notascredito.fechanota,
    notascredito.observaciones,  
	notascredito.codsucursal,
    sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
    documentos2.documento AS documento2, 
    documentos3.documento AS documento3,
	cajas.nrocaja,
	cajas.nomcaja,
    usuarios.dni, 
    usuarios.dni, 
    usuarios.nombres,
	SUM(detallenotas.cantventa) AS articulos 
	FROM (notascredito LEFT JOIN detallenotas ON detallenotas.codnota = notascredito.codnota)
	INNER JOIN sucursales ON notascredito.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON notascredito.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN cajas ON notascredito.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON notascredito.codigo = usuarios.codigo 
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
	GROUP BY notascredito.codnota 
	ORDER BY notascredito.idnota ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

 } else if($_SESSION["acceso"] == "cajero") {

	$sql = "SELECT 
	notascredito.idnota, 
	notascredito.codcaja, 
    notascredito.codnota,
    notascredito.codfactura,
    notascredito.tipodocumento,
    notascredito.facturaventa,
	notascredito.codcliente, 
	notascredito.subtotalivasi, 
	notascredito.subtotalivano, 
	notascredito.iva, 
	notascredito.totaliva,
	notascredito.descontado, 
	notascredito.descuento, 
	notascredito.totaldescuento, 
	notascredito.totalpago, 
	notascredito.fechanota,
    notascredito.observaciones,  
	notascredito.codsucursal,
    sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
    documentos2.documento AS documento2, 
    documentos3.documento AS documento3,
	cajas.nrocaja,
	cajas.nomcaja,
    usuarios.dni, 
    usuarios.dni, 
    usuarios.nombres,
	SUM(detallenotas.cantventa) AS articulos 
	FROM (notascredito LEFT JOIN detallenotas ON detallenotas.codnota = notascredito.codnota)
	INNER JOIN sucursales ON notascredito.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON notascredito.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN cajas ON notascredito.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON notascredito.codigo = usuarios.codigo 
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2 
	WHERE notascredito.codigo = '".limpiar($_SESSION["codigo"])."'
	GROUP BY notascredito.codnota 
	ORDER BY notascredito.idnota ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

  } else {

   $sql = "SELECT 
	notascredito.idnota, 
	notascredito.codcaja, 
    notascredito.codnota,
    notascredito.codfactura,
    notascredito.tipodocumento,
    notascredito.facturaventa,
	notascredito.codcliente, 
	notascredito.subtotalivasi, 
	notascredito.subtotalivano, 
	notascredito.iva, 
	notascredito.totaliva,
	notascredito.descontado, 
	notascredito.descuento, 
	notascredito.totaldescuento, 
	notascredito.totalpago, 
	notascredito.fechanota,
    notascredito.observaciones,  
	notascredito.codsucursal,
    sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
    documentos2.documento AS documento2, 
    documentos3.documento AS documento3,
	cajas.nrocaja,
	cajas.nomcaja,
    usuarios.dni, 
    usuarios.dni, 
    usuarios.nombres,
	SUM(detallenotas.cantventa) AS articulos 
	FROM (notascredito LEFT JOIN detallenotas ON detallenotas.codnota = notascredito.codnota)
	INNER JOIN sucursales ON notascredito.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON notascredito.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN cajas ON notascredito.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON notascredito.codigo = usuarios.codigo  
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
	WHERE notascredito.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
	GROUP BY notascredito.codnota 
	ORDER BY notascredito.idnota ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
   }
}
###################### FUNCION LISTAR NOTA DE CREDITO ####################### 

###################### FUNCION BUSQUEDA NOTAS POR CAJAS ###########################
public function BuscarNotasxCajas() 
	{
	self::SetNames();
	$sql ="SELECT 
	notascredito.idnota, 
	notascredito.codcaja, 
    notascredito.codnota,
    notascredito.codfactura,
    notascredito.tipodocumento,
    notascredito.facturaventa,
	notascredito.codcliente, 
	notascredito.subtotalivasi, 
	notascredito.subtotalivano, 
	notascredito.iva, 
	notascredito.totaliva,
	notascredito.descontado, 
	notascredito.descuento, 
	notascredito.totaldescuento, 
	notascredito.totalpago, 
	notascredito.fechanota,
    notascredito.observaciones,  
	notascredito.codsucursal,
    sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
    documentos2.documento AS documento2, 
    documentos3.documento AS documento3,
	cajas.nrocaja,
	cajas.nomcaja,
    usuarios.dni, 
    usuarios.nombres,
	SUM(detallenotas.cantventa) AS articulos 
	FROM (notascredito LEFT JOIN detallenotas ON detallenotas.codnota = notascredito.codnota)
	INNER JOIN sucursales ON notascredito.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON notascredito.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN cajas ON notascredito.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON notascredito.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
	WHERE notascredito.codsucursal = ?
	AND notascredito.codcaja = ? 
	AND DATE_FORMAT(notascredito.fechanota,'%Y-%m-%d') BETWEEN ? AND ?  
	GROUP BY notascredito.codnota 
	ORDER BY notascredito.idnota ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim(decrypt($_GET['codcaja'])));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(4, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA NOTAS POR CAJAS ###########################

###################### FUNCION BUSQUEDA NOTAS POR FECHAS ###########################
public function BuscarNotasxFechas() 
	{
	self::SetNames();
	$sql ="SELECT 
	notascredito.idnota, 
	notascredito.codcaja, 
    notascredito.codnota,
    notascredito.codfactura,
    notascredito.tipodocumento,
    notascredito.facturaventa,
	notascredito.codcliente, 
	notascredito.subtotalivasi, 
	notascredito.subtotalivano, 
	notascredito.iva, 
	notascredito.totaliva,
	notascredito.descontado, 
	notascredito.descuento, 
	notascredito.totaldescuento, 
	notascredito.totalpago, 
	notascredito.fechanota,
    notascredito.observaciones,  
	notascredito.codsucursal,
    sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
    documentos2.documento AS documento2, 
    documentos3.documento AS documento3,
	cajas.nrocaja,
	cajas.nomcaja,
    usuarios.dni, 
    usuarios.nombres,
	SUM(detallenotas.cantventa) AS articulos 
	FROM (notascredito LEFT JOIN detallenotas ON detallenotas.codnota = notascredito.codnota)
	INNER JOIN sucursales ON notascredito.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON notascredito.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN cajas ON notascredito.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON notascredito.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
	WHERE notascredito.codsucursal = ? 
	AND DATE_FORMAT(notascredito.fechanota,'%Y-%m-%d') BETWEEN ? AND ?  
	GROUP BY notascredito.codnota 
	ORDER BY notascredito.idnota ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA NOTAS POR FECHAS ###########################

###################### FUNCION BUSQUEDA NOTAS POR CLIENTE ###########################
public function BuscarNotasxClientes() 
	{
	self::SetNames();
	$sql ="SELECT 
	notascredito.idnota, 
	notascredito.codcaja, 
    notascredito.codnota,
    notascredito.codfactura,
    notascredito.tipodocumento,
    notascredito.facturaventa,
	notascredito.codcliente, 
	notascredito.subtotalivasi, 
	notascredito.subtotalivano, 
	notascredito.iva, 
	notascredito.totaliva,
	notascredito.descontado, 
	notascredito.descuento, 
	notascredito.totaldescuento, 
	notascredito.totalpago, 
	notascredito.fechanota,
    notascredito.observaciones,  
	notascredito.codsucursal,
    sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	valor_cambio.montocambio,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
    documentos2.documento AS documento2, 
    documentos3.documento AS documento3,
	cajas.nrocaja,
	cajas.nomcaja,
    usuarios.dni, 
    usuarios.nombres,
	SUM(detallenotas.cantventa) AS articulos 
	FROM (notascredito LEFT JOIN detallenotas ON detallenotas.codnota = notascredito.codnota)
	INNER JOIN sucursales ON notascredito.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN clientes ON notascredito.codcliente = clientes.codcliente
	LEFT JOIN documentos AS documentos3 ON clientes.documcliente = documentos3.coddocumento
	LEFT JOIN cajas ON notascredito.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON notascredito.codigo = usuarios.codigo
	LEFT JOIN
        (SELECT
        codcambio, descripcioncambio, montocambio, codmoneda       
        FROM tiposcambio
        ORDER BY codcambio DESC LIMIT 1) valor_cambio ON valor_cambio.codmoneda = sucursales.codmoneda2
	WHERE notascredito.codsucursal = ? 
	AND notascredito.codcliente = ?
	GROUP BY notascredito.codnota 
	ORDER BY notascredito.idnota ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET['codsucursal']),$_GET["codcliente"]));
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA NOTAS POR CLIENTES ###########################

###################################### CLASE NOTA DE CREDITO ###################################



























########################## FUNCION PARA GRAFICOS #################################

########################## FUNCION GRAFICO POR SUCURSALES ##########################
public function GraficoxSucursal()
{
	self::SetNames();
    $sql = "SELECT 
    sucursales.codsucursal id,
	sucursales.nomsucursal,
    pag.sumcompras,
    pag2.sumcotizacion,
    pag3.sumventas
     FROM
       sucursales
     LEFT JOIN
       ( SELECT
           codsucursal, SUM(totalpagoc) AS sumcompras         
           FROM compras WHERE DATE_FORMAT(fechaemision,'%Y') = '".date("Y")."' GROUP BY codsucursal) pag ON pag.codsucursal = sucursales.codsucursal  
     LEFT JOIN
       ( SELECT
           codsucursal, SUM(totalpago) AS sumcotizacion
         FROM cotizaciones WHERE DATE_FORMAT(fechacotizacion,'%Y') = '".date("Y")."' GROUP BY codsucursal) pag2 ON pag2.codsucursal = sucursales.codsucursal 
     LEFT JOIN
       ( SELECT
           codsucursal, SUM(totalpago) AS sumventas
         FROM ventas WHERE DATE_FORMAT(fechaventa,'%Y') = '".date("Y")."' GROUP BY codsucursal) pag3 ON pag3.codsucursal = sucursales.codsucursal GROUP BY id";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################## FUNCION GRAFICO POR SUCURSALES ###########################

########################### FUNCION SUMA DE COMPRAS #################################
 public function SumaCompras()
{
	self::SetNames();
	$sql ="SELECT  
	MONTH(fecharecepcion) mes, 
	SUM(totalpagoc) totalmes
	FROM compras 
	WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."' AND YEAR(fecharecepcion) = '".date('Y')."' AND MONTH(fecharecepcion) GROUP BY MONTH(fecharecepcion) ORDER BY 1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
} 
########################### FUNCION SUMA DE COMPRAS #################################

########################### FUNCION SUMA DE COTIZACIONES ############################
public function SumaCotizaciones()
{
	self::SetNames();
	$sql ="SELECT  
	MONTH(fechacotizacion) mes, 
	SUM(totalpago) totalmes
	FROM cotizaciones 
	WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."' AND YEAR(fechacotizacion) = '".date('Y')."' AND MONTH(fechacotizacion) GROUP BY MONTH(fechacotizacion) ORDER BY 1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
} 
########################### FUNCION SUMA DE COTIZACIONES #############################

########################### FUNCION SUMA DE PREVENTAS ############################
public function SumaPreventas()
{
	self::SetNames();
	$sql ="SELECT  
	MONTH(fechapreventa) mes, 
	SUM(totalpago) totalmes
	FROM preventas 
	WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."' AND YEAR(fechapreventa) = '".date('Y')."' AND MONTH(fechapreventa) GROUP BY MONTH(fechapreventa) ORDER BY 1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
} 
########################### FUNCION SUMA DE PREVENTAS #############################

########################### FUNCION SUMA DE VENTAS #################################
 public function SumaVentas()
{
	self::SetNames();
	$sql ="SELECT  
	MONTH(fechaventa) mes, 
	SUM(totalpago) totalmes
	FROM ventas 
	WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."' AND YEAR(fechaventa) = '".date('Y')."' AND MONTH(fechaventa) GROUP BY MONTH(fechaventa) ORDER BY 1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################### FUNCION SUMA DE VENTAS #################################

########################### FUNCION PRODUCTOS 5 MAS VENDIDOS ############################
public function ProductosMasVendidos()
	{
		self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT productos.codproducto, productos.producto, productos.codmarca, detalleventas.descproducto, detalleventas.precioventa, productos.existencia, marcas.nommarca, modelos.nommodelo, ventas.fechaventa, sucursales.cuitsucursal, sucursales.nomsucursal, SUM(detalleventas.cantventa) as cantidad FROM (ventas LEFT JOIN detalleventas ON ventas.codventa=detalleventas.codventa) LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal LEFT JOIN productos ON detalleventas.codproducto=productos.codproducto LEFT JOIN marcas ON marcas.codmarca=productos.codmarca LEFT JOIN modelos ON modelos.codmodelo=productos.codmodelo GROUP BY detalleventas.codproducto, detalleventas.precioventa, detalleventas.descproducto ORDER BY productos.codproducto ASC LIMIT 5";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

     } else {

       $sql = "SELECT 
       productos.codproducto, 
       productos.producto,
       SUM(detalleventas.cantventa) as cantidad 
       FROM (ventas LEFT JOIN detalleventas ON ventas.codventa=detalleventas.codventa) 
       LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal 
       LEFT JOIN productos ON detalleventas.codproducto=productos.codproducto 
       WHERE ventas.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
       AND YEAR(ventas.fechaventa) = '".date('Y')."' 
       GROUP BY productos.codproducto, productos.producto 
       ORDER BY productos.codproducto ASC LIMIT 5";


	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
   }
}
########################## FUNCION 5 PRODUCTOS MAS VENDIDOS ###########################

########################## FUNCION SUMAR VENTAS POR USUARIOS ##########################
public function VentasxUsuarios()
	{
		self::SetNames();
     $sql = "SELECT usuarios.codigo, usuarios.nombres, SUM(ventas.totalpago) as total FROM (usuarios INNER JOIN ventas ON usuarios.codigo=ventas.codigo) WHERE ventas.codsucursal = '".limpiar($_SESSION["codsucursal"])."' AND YEAR(ventas.fechaventa) = '".date('Y')."' GROUP BY usuarios.codigo";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################## FUNCION SUMAR VENTAS POR USUARIOS #########################


########################## FUNCION PARA CONTAR REGISTROS ###########################
public function ContarRegistros()
	{
      self::SetNames();
if($_SESSION['acceso'] == "administradorG") {

$sql = "SELECT
(SELECT COUNT(codsucursal) FROM sucursales) AS sucursales,
(SELECT COUNT(codigo) FROM usuarios) AS usuarios,
(SELECT COUNT(codproducto) FROM productos) AS productos,
(SELECT COUNT(codcliente) FROM clientes) AS clientes,
(SELECT COUNT(codproveedor) FROM proveedores) AS proveedores,

(SELECT COUNT(codproducto) FROM productos WHERE existencia <= stockoptimo) AS poptimo,
(SELECT COUNT(codproducto) FROM productos WHERE existencia <= stockmedio) AS pmedio,
(SELECT COUNT(codproducto) FROM productos WHERE existencia <= stockminimo) AS pminimo,

(SELECT COUNT(codproducto) FROM productos WHERE fechaoptimo != '0000-00-00' AND fechaoptimo <= '".date("Y-m-d")."') AS foptimo,
(SELECT COUNT(codproducto) FROM productos WHERE fechamedio != '0000-00-00' AND fechamedio <= '".date("Y-m-d")."') AS fmedio,
(SELECT COUNT(codproducto) FROM productos WHERE fechaminimo != '0000-00-00' AND fechaminimo <= '".date("Y-m-d")."') AS fminimo,

(SELECT COUNT(idcompra) FROM compras WHERE tipocompra = 'CREDITO' AND statuscompra = 'PENDIENTE' AND fechavencecredito <= '".date("Y-m-d")."') AS creditoscomprasvencidos,
(SELECT COUNT(idventa) FROM ventas WHERE tipopago = 'CREDITO' AND statusventa = 'PENDIENTE' AND fechavencecredito <= '".date("Y-m-d")."') AS creditosventasvencidos";

		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;

     } else {

$sql = "SELECT
(SELECT COUNT(codigo) FROM usuarios WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS usuarios,
(SELECT COUNT(codproducto) FROM productos WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS productos,
(SELECT COUNT(codcliente) FROM clientes) AS clientes,
(SELECT COUNT(codproveedor) FROM proveedores) AS proveedores,
(SELECT SUM(ingresos) FROM arqueocaja INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja INNER JOIN usuarios ON cajas.codigo = usuarios.codigo WHERE usuarios.codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS ingresos,
(SELECT SUM(egresos) FROM arqueocaja INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja INNER JOIN usuarios ON cajas.codigo = usuarios.codigo WHERE usuarios.codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS egresos,
(SELECT COUNT(idtraspaso) FROM traspasos WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS traspasos,
(SELECT COUNT(idcotizacion) FROM cotizaciones WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS cotizaciones,
(SELECT COUNT(idcompra) FROM compras WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS compras,
(SELECT COUNT(idventa) FROM ventas WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS ventas,

(SELECT COUNT(codproducto) FROM productos WHERE existencia <= stockoptimo AND existencia > stockmedio AND codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS poptimo,
(SELECT COUNT(codproducto) FROM productos WHERE existencia <= stockmedio AND existencia > stockminimo AND codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS pmedio,
(SELECT COUNT(codproducto) FROM productos WHERE existencia <= stockminimo AND codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS pminimo,


(SELECT COUNT(codproducto) FROM productos WHERE fechaoptimo != '0000-00-00' AND '".date("Y-m-d")."' <= fechaoptimo AND '".date("Y-m-d")."' > fechamedio AND codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS foptimo,
(SELECT COUNT(codproducto) FROM productos WHERE fechamedio != '0000-00-00' AND fechamedio <= '".date("Y-m-d")."' AND '".date("Y-m-d")."' > fechaminimo AND codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS fmedio,
(SELECT COUNT(codproducto) FROM productos WHERE fechaminimo != '0000-00-00' AND fechaminimo <= '".date("Y-m-d")."' AND codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS fminimo,

(SELECT COUNT(idcompra) FROM compras WHERE tipocompra = 'CREDITO' AND statuscompra = 'PENDIENTE' AND fechavencecredito <= '".date("Y-m-d")."' AND codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS creditoscomprasvencidos,
(SELECT COUNT(idventa) FROM ventas WHERE tipopago = 'CREDITO' AND statusventa = 'PENDIENTE' AND fechavencecredito <= '".date("Y-m-d")."' AND codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS creditosventasvencidos";

		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################## FUNCION PARA CONTAR REGISTROS #############################

########################## FUNCION PARA GRAFICOS #################################




}
############## TERMINA LA CLASE LOGIN ######################
?>