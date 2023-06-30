<?php
define('FPDF_FONTPATH','fpdf/font/');
define('EURO', chr(128));
require 'pdf_js.php';

############## VARIABLE PARA TAMAÑO DE LOGO ##############
$GLOBALS['logo1_vertical'] = 30;
$GLOBALS['logo1_vertical_X'] = 8;
$GLOBALS['logo1_vertical_Y'] = 2;

$GLOBALS['logo2_vertical'] = 30;
$GLOBALS['logo2_vertical_X'] = 10;
$GLOBALS['logo2_vertical_Y'] = 2;

$GLOBALS['logo1_horizontal'] = 32;
$GLOBALS['logo1_horizontal_X'] = 25;
$GLOBALS['logo1_horizontal_Y'] = 1;

$GLOBALS['logo2_horizontal'] = 32;
$GLOBALS['logo2_horizontal_X'] = 15;
$GLOBALS['logo2_horizontal_Y'] = 1;
############## VARIABLE PARA TAMAÑO DE LOGO ##############
 
//class PDF extends FPDF{ 
class PDF extends PDF_JavaScript
{
var $widths;
var $aligns;
var $flowingBlockAttr;

########################### FUNCION PARA MOSTRAR EL FOOTER ###########################
function Footer() 
{
  if($this->PageNo() != 1){
  //footer code
  $this->Ln();
  $this->SetY(-12);
  //Courier B 10
  $this->SetFont('courier','B',10);
  //Titulo de Footer
  $this->Cell(190,5,'FACTURACIÓN E INVENTARIOS (Administración, Compras y ventas)','T',0,'L');
  //$this->AliasNbPages();
  //Numero de Pagina
  $this->Cell(0,5,'Pagina '.$this->PageNo(),'T',1,'R'); 

  }
}
########################## FUNCION PARA MOSTRAR EL FOOTER ############################
    
######################## FUNCION PARA CARGAR AUTOPRINTF ########################
function AutoPrint($dialog=false)
{
    //Open the print dialog or start printing immediately on the standard printer
    $param=($dialog ? 'true' : 'false');
    $script="print($param);";
    $this->IncludeJS($script);
}

function AutoPrintToPrinter($server, $printer, $dialog=false)
{
    //Print on a shared printer (requires at least Acrobat 6)
    $script = "var pp = getPrintParams();";
    if($dialog)
        $script .= "pp.interactive = pp.constants.interactionLevel.full;";
    else
        $script .= "pp.interactive = pp.constants.interactionLevel.automatic;";
    $script .= "pp.printerName = '\\\\\\\\".$server."\\\\".$printer."';";
    $script .= "print(pp);";
    $this->IncludeJS($script);
}
######################## FUNCION PARA CARGAR AUTOPRINT ########################

 
############################### REPORTES DE ADMINISTRACION ##############################

########################## FUNCION LISTAR PROVINCIAS ##############################
function TablaListarProvincias()
{
    
    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,14,'LISTADO GENERAL DE PROVINCIAS',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(180,8,'NOMBRE DE PROVINCIA',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarProvincias();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,180));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["provincia"])));
  }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PROVINCIAS ##############################


########################## FUNCION LISTAR DEPARTAMENTOS ##############################
function TablaListarDepartamentos()
{
    
   ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,14,'LISTADO GENERAL DE DEPARTAMENTOS',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(80,8,'NOMBRE DE PROVINCIA',1,0,'C', True);
    $this->Cell(95,8,'NOMBRE DE DEPARTAMENTO',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarDepartamentos();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,80,95));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["provincia"]),utf8_decode($reg[$i]["departamento"])));
  }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR DEPARTAMENTOS ##############################

########################## FUNCION LISTAR TIPOS DE DOCUMENTOS ##########################
function TablaListarDocumentos()
{
    
    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,14,'LISTADO GENERAL DE DOCUMENTOS TRIBUTARIOS',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(50,8,'NOMBRE DE DOCUMENTO',1,0,'C', True);
    $this->Cell(125,8,'DESCRIPCIÓN DE DOCUMENTO',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarDocumentos();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,50,125));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["documento"]),utf8_decode($reg[$i]["descripcion"])));
  }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR TIPOS DE DOCUMENTOS ##########################

########################## FUNCION LISTAR TIPOS DE MONEDA ##############################
function TablaListarTiposMonedas()
{
    
    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################


    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,14,'LISTADO GENERAL DE TIPOS DE MONEDA',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(85,8,'NOMBRE DE MONEDA',1,0,'C', True);
    $this->Cell(45,8,'SIGLAS',1,0,'C', True);
    $this->Cell(45,8,'SIMBOLO',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarTipoMoneda();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,85,45,45));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["moneda"]),utf8_decode($reg[$i]["siglas"]),utf8_decode($reg[$i]["simbolo"])));
  }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR TIPOS DE MONEDA ##############################

########################## FUNCION LISTAR TIPOS DE CAMBIO ##############################
function TablaListarTiposCambio()
{
    
    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,14,'LISTADO GENERAL DE TIPOS DE CAMBIO',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCIÓN DE CAMBIO',1,0,'C', True);
    $this->Cell(35,8,'MONTO DE CAMBIO',1,0,'C', True);
    $this->Cell(35,8,'TIPO DE MONEDA',1,0,'C', True);
    $this->Cell(35,8,'FECHA DE INGRESO',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarTipoCambio();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,70,35,35,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["descripcioncambio"]),utf8_decode(number_format($reg[$i]["montocambio"], 2, '.', ',')),utf8_decode($reg[$i]['moneda'].":".$reg[$i]['siglas']),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechacambio'])))));
  }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR TIPOS DE CAMBIO ##############################

########################## FUNCION LISTAR MEDIOS DE PAGO ##############################
function TablaListarMediosPagos()
{
    
    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,14,'LISTADO GENERAL DE MEDIOS DE PAGO',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(175,8,'NOMBRE DE PAGO',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarMediosPagos();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,175));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["mediopago"])));
  }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR MEDIOS DE PAGO ##############################

########################## FUNCION LISTAR IMPUESTOS ##############################
function TablaListarImpuestos()
{
    
    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,14,'LISTADO GENERAL DE IMPUESTOS',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(70,8,'NOMBRE DE IMPUESTO',1,0,'C', True);
    $this->Cell(35,8,'VALOR(%)',1,0,'C', True);
    $this->Cell(35,8,'STATUS',1,0,'C', True);
    $this->Cell(35,8,'FECHA DE INGRESO',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarImpuestos();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,70,35,35,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["nomimpuesto"]),utf8_decode(number_format($reg[$i]["valorimpuesto"], 2, '.', ',')),utf8_decode($reg[$i]['statusimpuesto']),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaimpuesto'])))));
  }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR IMPUESTOS ##############################

########################## FUNCION LISTAR FAMILIAS ##############################
function TablaListarFamilias()
{
    
    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,14,'LISTADO GENERAL DE FAMILIAS',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(175,8,'NOMBRE DE FAMILIA',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarFamilias();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,175));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["nomfamilia"])));
  }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR FAMILIAS ##############################


########################## FUNCION LISTAR SUB-FAMILIAS ##############################
function TablaListarSubfamilias()
{
    
    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,14,'LISTADO GENERAL DE SUB-FAMILIAS',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(90,8,'NOMBRE DE FAMILIA',1,0,'C', True);
    $this->Cell(90,8,'NOMBRE DE SUBFAMILIA',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarSubfamilias();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,90,90));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["nomfamilia"]),utf8_decode($reg[$i]["nomsubfamilia"])));
  }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR SUB-FAMILIAS ##############################

########################## FUNCION LISTAR MARCAS ##############################
function TablaListarMarcas()
{
    
    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,14,'LISTADO GENERAL DE MARCAS',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(175,8,'NOMBRE DE MARCA',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarMarcas();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,175));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["nommarca"])));
  }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR MARCAS ##############################

########################## FUNCION LISTAR MODELOS ##############################
function TablaListarModelos()
{
    
    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################


    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,14,'LISTADO GENERAL DE MODELOS',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(90,8,'NOMBRE DE MARCA',1,0,'C', True);
    $this->Cell(90,8,'NOMBRE DE MODELO',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarModelos();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,90,90));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["nommarca"]),utf8_decode($reg[$i]["nommodelo"])));
  }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR MODELOS ##############################

########################## FUNCION LISTAR PRESENTACIONES ##############################
function TablaListarPresentaciones()
{
    
    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,14,'LISTADO GENERAL DE PRESENTACIONES',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(175,8,'NOMBRE DE PRESENTACIÓN',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarPresentaciones();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,175));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["nompresentacion"])));
  }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PRESENTACIONES ##############################

########################## FUNCION LISTAR COLORES ##############################
function TablaListarColores()
{
    
    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,14,'LISTADO GENERAL DE COLORES',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(175,8,'NOMBRE DE COLOR',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarColores();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,175));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["nomcolor"])));
  }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COLORES ##############################

########################## FUNCION LISTAR ORIGENES ##############################
function TablaListarOrigenes()
{
    
    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,14,'LISTADO GENERAL DE ORIGENES',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(175,8,'NOMBRE DE ORIGEN',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarOrigenes();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,175));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["nomorigen"])));
  }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR ORIGENES ##############################

########################## FUNCION LISTAR SUCURSALES ##############################
function TablaListarSucursales()
{
    ################################# MEMBRETE LEGAL #################################
    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);
   ################################# MEMBRETE LEGAL #################################

    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO GENERAL DE SUCURSALES',0,0,'C');
    
    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE DOCUMENTO',1,0,'C', True);
    $this->Cell(60,8,'RAZÓN SOCIAL',1,0,'C', True);
    $this->Cell(20,8,'PROVINCIA',1,0,'C', True);
    $this->Cell(30,8,'DEPARTAMENTO',1,0,'C', True);
    $this->Cell(55,8,'DIRECCIÓN',1,0,'C', True);
    $this->Cell(40,8,'Nº DE TELÉFONO',1,0,'C', True);
    $this->Cell(35,8,'Nº DE DNI ',1,0,'C', True);
    $this->Cell(45,8,'ENCARGADO',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarSucursales();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,35,60,20,30,55,40,35,45));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["cuitsucursal"]),utf8_decode($reg[$i]["nomsucursal"]),utf8_decode($reg[$i]['id_provincia'] == '0' ? "********" : $reg[$i]['provincia']),utf8_decode($reg[$i]['id_departamento'] == '0' ? "********" : $reg[$i]['departamento']),utf8_decode($reg[$i]["direcsucursal"]),utf8_decode($reg[$i]["tlfsucursal"]),utf8_decode($reg[$i]["dniencargado"]),utf8_decode($reg[$i]["nomencargado"])));
  }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR SUCURSALES ##############################

########################## FUNCION LISTAR USUARIOS ##############################
function TablaListarUsuarios()
{
    
    $tra = new Login();
    $reg = $tra->ListarUsuarios();
    
    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO GENERAL DE USUARIOS',0,0,'C');
    

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DOCUMENTO',1,0,'C', True);
    $this->Cell(70,8,'NOMBRES Y APELLIDOS',1,0,'C', True);
    $this->Cell(25,8,'Nº TELÉFONO',1,0,'C', True);
    $this->Cell(60,8,'EMAIL',1,0,'C', True);
    $this->Cell(40,8,'USUARIO',1,0,'C', True);
    $this->Cell(40,8,'NIVEL',1,0,'C', True);
    $this->Cell(50,8,'SUCURSAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,35,70,25,60,40,40,50));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["dni"]),utf8_decode($reg[$i]["nombres"]),utf8_decode($reg[$i]["telefono"]),utf8_decode($reg[$i]["email"]),utf8_decode($reg[$i]["usuario"]),utf8_decode($reg[$i]["nivel"]),utf8_decode($reg[$i]['codsucursal'] == '' ? "*********" : $reg[$i]['nomsucursal'])));
   }
 }
    } else {

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'Nº DOCUMENTO',1,0,'C', True);
    $this->Cell(80,8,'NOMBRES Y APELLIDOS',1,0,'C', True);
    $this->Cell(25,8,'SEXO',1,0,'C', True);
    $this->Cell(45,8,'Nº DE TELÉFONO',1,0,'C', True);
    $this->Cell(60,8,'EMAIL',1,0,'C', True);
    $this->Cell(40,8,'USUARIO',1,0,'C', True);
    $this->Cell(40,8,'NIVEL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,30,80,25,45,60,40,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["dni"]),utf8_decode($reg[$i]["nombres"]),utf8_decode($reg[$i]["sexo"]),utf8_decode($reg[$i]["telefono"]),utf8_decode($reg[$i]["email"]),utf8_decode($reg[$i]["usuario"]),utf8_decode($reg[$i]["nivel"])));
   }
 }
    }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR USUARIOS ##############################


########################## FUNCION LISTAR LOGS DE USUARIOS ##############################
 function TablaListarLogs()
{
    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################

    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO DE LOGS DE ACCESO DE USUARIOS',0,0,'C');
    
    $this->Ln();
    $this->SetFont('Courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(10,8,'N°',1,0,'C', True);
    $this->Cell(35,8,'IP EQUIPO',1,0,'C', True);
    $this->Cell(45,8,'TIEMPO ENTRADA',1,0,'C', True);
    $this->Cell(145,8,'NAVEGADOR DE ACCESO',1,0,'C', True);
    $this->Cell(60,8,'PÁGINAS DE ACCESO',1,0,'C', True);
    $this->Cell(35,8,'USUARIO',1,1,'C', True);
    

    $tra = new Login();
    $reg = $tra->ListarLogs();

    if($reg==""){
    echo "";      
    } else {
    
    /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,35,45,145,60,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["ip"]),utf8_decode($reg[$i]["tiempo"]),utf8_decode($reg[$i]["detalles"]),utf8_decode($reg[$i]["paginas"]),utf8_decode($reg[$i]["usuario"])));
  }
   }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
   }
########################## FUNCION LISTAR LOGS DE USUARIOS ##############################

############################ REPORTES DE ADMINISTRACION #############################








































############################### REPORTES DE MANTENIMIENTO ##############################

########################## FUNCION LISTAR CLIENTES ##############################
function TablaListarClientes()
{
    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO GENERAL DE CLIENTES',0,0,'C');
    

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE DOCUMENTO',1,0,'C', True);
    $this->Cell(60,8,'NOMBRES Y APELLIDOS',1,0,'C', True);
    $this->Cell(35,8,'Nº DE TELEFONO',1,0,'C', True);
    $this->Cell(75,8,'DIRECCIÓN DOMICILIARIA',1,0,'C', True);
    $this->Cell(60,8,'EMAIL',1,0,'C', True);
    $this->Cell(25,8,'TIPO',1,0,'C', True);
    $this->Cell(25,8,'CRÉDITO',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarClientes();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,60,35,75,60,25,25));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["documento"]." ".$reg[$i]["dnicliente"]),portales(utf8_decode($reg[$i]["nomcliente"])),utf8_decode($reg[$i]["tlfcliente"]),utf8_decode($reg[$i]["provincia"]."-".$reg[$i]["departamento"]."-".$reg[$i]["direccliente"]),utf8_decode($reg[$i]['emailcliente']),utf8_decode($reg[$i]["tipocliente"]),utf8_decode(number_format($reg[$i]["limitecredito"], 2, '.', ','))));
  }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CLIENTES ##############################

########################## FUNCION LISTAR PROVEEDORES ##############################
function TablaListarProveedores()
{
    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO GENERAL DE PROVEEDORES',0,0,'C');
    

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE DOCUMENTO',1,0,'C', True);
    $this->Cell(60,8,'NOMBRE DE PROVEEDOR',1,0,'C', True);
    $this->Cell(25,8,'Nº DE TLF',1,0,'C', True);
    $this->Cell(75,8,'DIRECCIÓN DOMICILIARIA',1,0,'C', True);
    $this->Cell(60,8,'EMAIL',1,0,'C', True);
    $this->Cell(35,8,'VENDEDOR',1,0,'C', True);
    $this->Cell(25,8,'Nº DE TLF',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarProveedores();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,60,25,75,60,35,25));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["documento"]." ".$reg[$i]["cuitproveedor"]),portales(utf8_decode($reg[$i]["nomproveedor"])),utf8_decode($reg[$i]["tlfproveedor"]),utf8_decode($reg[$i]["provincia"]."-".$reg[$i]["departamento"]."-".$reg[$i]["direcproveedor"]),utf8_decode($reg[$i]['emailproveedor']),utf8_decode($reg[$i]["vendedor"]),utf8_decode($reg[$i]["tlfvendedor"])));
  }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PROVEEDORES ##############################

########################## FUNCION FACTURA PEDIDO ##############################
function FacturaPedido()
{
        
    $tra = new Login();
    $reg = $tra->PedidosPorId();

    //Logo
    if (isset($reg[0]['cuitsucursal'])) {
             if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

        $logo = "./fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
        $this->Image($logo , 15 ,11, 25 , 15 , "PNG");

    } else {

        $logo = "./fotos/logo_principal.png";                         
        $this->Image($logo , 15 ,11, 55 , 15 , "PNG");  
   }                                      
    }

######################## BLOQUE N° 1 FACTURA ##########################   
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 10, 190, 17, '1.5', '');
    
    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(98, 12, 12, 12, '1.5', 'F');

    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(98, 12, 12, 12, '1.5', '');

    $this->SetFont('courier','B',16);
    $this->SetXY(101, 14);
    $this->Cell(20, 5, 'P', 0 , 0);
    $this->SetFont('courier','B',8);
    $this->SetXY(98, 19);
    $this->Cell(20, 5, 'Pedido', 0, 0);
    
    $this->SetFont('courier','B',11);
    $this->SetXY(124, 12);
    $this->Cell(20, 5, 'N° DE PEDIDO ', 0, 0);
    $this->SetFont('courier','B',11);
    $this->SetXY(176, 12);
    $this->Cell(22, 5,utf8_decode($reg[0]['codfactura']), 0, 0, "R");

    $this->SetFont('courier','B',9);
    $this->SetXY(124, 16);
    $this->Cell(20, 5, 'FECHA DE PEDIDO ', 0, 0);
    $this->SetFont('courier','',9);
    $this->SetXY(177, 16);
    $this->Cell(20, 5,utf8_decode(date("d-m-Y",strtotime($reg[0]['fechapedido']))), 0, 0, "R");

    $this->SetFont('courier','B',9);
    $this->SetXY(124, 20);
    $this->Cell(20, 5, 'FECHA DE EMISIÓN', 0, 0);
    $this->SetFont('courier','',9);
    $this->SetXY(177, 20);
    $this->Cell(20, 5,utf8_decode(date("d-m-Y H:i:s")), 0, 0, "R");
############################### BLOQUE N° 1 FACTURA ############################### 

############################### BLOQUE N° 2 SUCURSAL ##############################   
   //Bloque de datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 29, 190, 18, '1.5', '');
    //DATOS DE SUCURSAL LINEA 1
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 30);
    $this->Cell(20, 5, 'DATOS DE SUCURSAL ', 0 , 0);
    //DATOS DE SUCURSAL LINEA 1

    //DATOS DE SUCURSAL LINEA 2
    $this->SetFont('courier','B',8);
    $this->SetXY(12, 34);
    $this->Cell(20, 5, 'RAZÓN SOCIAL:', 0 , 0);
    $this->SetFont('courier','',8);
    $this->SetXY(36, 34);
    $this->Cell(20, 5,utf8_decode($reg[0]['nomsucursal']), 0 , 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(102, 34);
    $this->Cell(90, 5, 'Nº DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : $reg[0]['documento'].":"), 0 , 0);
    $this->SetFont('courier','',8);
    $this->SetXY(120, 34);
    $this->Cell(90, 5,utf8_decode($reg[0]['cuitsucursal']), 0 , 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(152, 34);
    $this->Cell(90, 5, 'N° DE TLF:', 0 , 0);
    $this->SetFont('courier','',8);
    $this->SetXY(170, 34);
    $this->Cell(90, 5,utf8_decode($reg[0]['tlfsucursal']), 0 , 0);
    //DATOS DE SUCURSAL LINEA 2

    //DATOS DE SUCURSAL LINEA 3
    $this->SetFont('courier','B',8);
    $this->SetXY(12, 38);
    $this->Cell(20, 5, 'DIRECCIÓN:', 0 , 0);
    $this->SetFont('courier','',8);
    $this->SetXY(30, 38);
    $this->Cell(20, 5,utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "*********" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['departamento'] == '' ? "*********" : $reg[0]['departamento'])." ".$reg[0]['direcsucursal']), 0 , 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(132, 38);
    $this->Cell(20, 5, 'EMAIL:', 0 , 0);
    $this->SetFont('courier','',8);
    $this->SetXY(144, 38);
    $this->Cell(20, 5,utf8_decode($reg[0]['correosucursal']), 0 , 0);
    //DATOS DE SUCURSAL LINEA 3

    //DATOS DE SUCURSAL LINEA 4
    $this->SetFont('courier','B',8);
    $this->SetXY(12, 42);
    $this->Cell(20, 5, 'RESPONSABLE:', 0 , 0);
    $this->SetFont('courier','',8);
    $this->SetXY(34, 42);
    $this->Cell(20, 5,utf8_decode($reg[0]['nomencargado']), 0 , 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(102, 42);
    $this->Cell(20, 5, 'Nº DE '.$documento = ($reg[0]['documencargado'] == '0' ? "DOC.:" : $reg[0]['documento2'].":"), 0 , 0);
    $this->SetFont('courier','',8);
    $this->SetXY(120, 42);
    $this->Cell(20, 5,utf8_decode($reg[0]['dniencargado']), 0 , 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(152, 42);
    $this->Cell(20, 5, 'N° DE TLF:', 0 , 0);
    $this->SetFont('courier','',8);
    $this->SetXY(170, 42);
    $this->Cell(20, 5,utf8_decode($tlf = ($reg[0]['tlfencargado'] == '' ? "*********" : $reg[0]['tlfencargado'])), 0 , 0);
    //DATOS DE SUCURSAL LINEA 4
############################# BLOQUE N° 2 SUCURSAL ##############################   

############################# BLOQUE N° 3 PROVEEDOR #################################  
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 49, 190, 14, '1.5', '');

    $this->SetFont('courier','B',9);
    $this->SetXY(12, 50);
    $this->Cell(20, 5, 'DATOS DEL PROVEEDOR ', 0 , 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(12, 54);
    $this->Cell(20, 5, 'PROVEEDOR:', 0 , 0);
    $this->SetFont('courier','',8);
    $this->SetXY(30, 54);
    $this->Cell(20, 5,utf8_decode($reg[0]['nomproveedor']), 0 , 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(90, 54);
    $this->Cell(70, 5, 'Nº DE '.$documento = ($reg[0]['documproveedor'] == '0' ? "DOC.:" : $reg[0]['documento3'].":"), 0 , 0);
    $this->SetFont('courier','',8);
    $this->SetXY(108, 54);
    $this->Cell(75, 5,utf8_decode($reg[0]['cuitproveedor']), 0 , 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(134, 54);
    $this->Cell(90, 5, 'EMAIL:', 0 , 0);
    $this->SetFont('courier','',8);
    $this->SetXY(146, 54);
    $this->Cell(90, 5,utf8_decode($reg[0]['emailproveedor']), 0 , 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(12, 58);
    $this->Cell(20, 5, 'DIRECCIÓN:', 0 , 0);
    $this->SetFont('courier','',8);
    $this->SetXY(30, 58);
    $this->Cell(20, 5,getSubString(utf8_decode($provincia = ($reg[0]['provincia2'] == '' ? "*********" : $reg[0]['provincia2'])." ".$departamento = ($reg[0]['departamento2'] == '' ? "*********" : $reg[0]['departamento2'])." ".$reg[0]['direcproveedor']),38), 0 , 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(98, 58);
    $this->Cell(20, 5, 'N° DE TLF:', 0 , 0);
    $this->SetFont('courier','',8);
    $this->SetXY(116, 58);
    $this->Cell(20, 5,utf8_decode($reg[0]['tlfproveedor']), 0 , 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(144, 58);
    $this->Cell(20, 5, 'VENDEDOR:', 0 , 0);
    $this->SetFont('courier','',8);
    $this->SetXY(160, 58);
    $this->Cell(20, 5,getSubString(utf8_decode($reg[0]['vendedor']),22), 0 , 0); 
############################## BLOQUE N° 3 PROVEEDOR ###############################  

    //Bloque Cuadro de Detalles de Productos
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 73, 190, 184, '0', '');

    //Bloque Letra Cantidad
    $this->SetFont('courier','B',10);
    $this->SetXY(10, 65);
    $this->SetTextColor(3,3,3);
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->Cell(8, 8,"Nº", 1, 0, 'C', True);
    $this->Cell(25, 8,"CÓDIGO", 1, 0, 'C', True);
    $this->Cell(82, 8,"DESCRIPCIÓN DE PRODUCTO", 1, 0, 'C', True);
    $this->Cell(25, 8,"MARCA", 1, 0, 'C', True);
    $this->Cell(25, 8,"MODELO", 1, 0, 'C', True);
    $this->Cell(25, 8,"CANTIDAD", 1, 1, 'C', True);

    $tra = new Login();
    $detalle = $tra->VerDetallesPedidos();
    $cantidad=0;

     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(8,25,82,25,25,25));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $this->SetX(10);
    $this->SetFont('Courier','',9);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->RowFacture(array($a++,utf8_decode($detalle[$i]["codproducto"]),portales(utf8_decode($detalle[$i]["producto"])),utf8_decode($detalle[$i]["nommarca"] == '' ? "******" : $detalle[$i]["nommarca"]),utf8_decode($detalle[$i]["nommodelo"] == '' ? "******" : $detalle[$i]["nommodelo"]),utf8_decode($detalle[$i]["cantpedido"])));
  }

    $this->SetXY(10, 266);
    $this->SetFont('courier','B',9);
    $this->Cell(100,8,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]),0,0,'C');
    $this->Cell(90,8,'RECIBIDO POR:__________________________________',0,0,'C');
    $this->Ln(4);

    }
########################## FUNCION FACTURA PEDIDO ##############################

########################## FUNCION LISTAR PEDIDOS ##############################
function ListarPedidos()
{
    
    $tra = new Login();
    $reg = $tra->ListarPedidos();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO GENERAL DE PEDIDOS',0,0,'C');
    
if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE PEDIDO',1,0,'C', True);
    $this->Cell(85,8,'DESCRIPCIÓN DE PROVEEDOR',1,0,'C', True);
    $this->Cell(80,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(30,8,'Nº ARTICULOS',1,0,'C', True);
    $this->Cell(35,8,'FECHA DE PEDIDO',1,0,'C', True);
    $this->Cell(50,8,'SUCURSAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,85,80,30,35,50));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),portales(utf8_decode($reg[$i]["nomproveedor"])),utf8_decode($reg[$i]["observacionpedido"]),utf8_decode($reg[$i]["articulos"]),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechapedido']))),utf8_decode($reg[$i]["nomsucursal"])));
   }
 }
    } else {

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE PEDIDO',1,0,'C', True);
    $this->Cell(90,8,'DESCRIPCIÓN DE PROVEEDOR',1,0,'C', True);
    $this->Cell(125,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(30,8,'Nº ARTICULOS',1,0,'C', True);
    $this->Cell(35,8,'FECHA DE PEDIDO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,90,125,30,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),portales(utf8_decode($reg[$i]["nomproveedor"])),utf8_decode($reg[$i]["observacionpedido"]),utf8_decode($reg[$i]["articulos"]),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechapedido'])))));
   }
 }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PEDIDOS ##############################

######################## FUNCION LISTAR PEDIDOS POR PROVEEDORES ########################
function TablaListarPedidosxProveedor()
{
    
    $tra = new Login();
    $reg = $tra->BuscarPedidosxProveedor();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################

    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE PEDIDOS POR PROVEEDOR',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($documento = ($reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']))." PROVEEDOR: ".utf8_decode($reg[0]["cuitproveedor"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"PROVEEDOR: ".portales(utf8_decode($reg[0]["nomproveedor"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"Nº TELÉFONO: ".portales(utf8_decode($reg[0]['tlfproveedor'] == '' ? "******" : $reg[0]["tlfproveedor"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE PEDIDO',1,0,'C', True);
    $this->Cell(90,8,'DESCRIPCIÓN DE PROVEEDOR',1,0,'C', True);
    $this->Cell(125,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(30,8,'Nº ARTICULOS',1,0,'C', True);
    $this->Cell(35,8,'FECHA DE PEDIDO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,90,125,30,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),portales(utf8_decode($reg[$i]["nomproveedor"])),utf8_decode($reg[$i]["observacionpedido"]),utf8_decode($reg[$i]["articulos"]),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechapedido'])))));
   }
 }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
####################### FUNCION LISTAR PEDIDOS POR PROVEEDORES ########################

############################### REPORTES DE MANTENIMIENTO ###########################
























############################### REPORTES DE PRODUCTOS ###########################

####################### FUNCION LISTAR PRODUCTOS ##############################
function TablaListarProductos()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->ListarProductos(); 
   
    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId();

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################

    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO GENERAL DE PRODUCTOS EN ALMACEN',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && $reg != ""){

    $this->Ln();
    $this->Cell(260,5,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(260,5,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(260,5,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,1,'L'); 

    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(25,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(25,8,'PRESENTACIÓN',1,0,'C', True);
    $this->Cell(25,8,'MARCA',1,0,'C', True);
    $this->Cell(25,8,'MODELO',1,0,'C', True);
    $this->Cell(25,8,'P. COMPRA',1,0,'C', True);
    $this->Cell(25,8,'P. MENOR',1,0,'C', True);
    $this->Cell(25,8,'P. MAYOR',1,0,'C', True);
    $this->Cell(25,8,'P. PÚBLICO',1,0,'C', True);
    $this->Cell(25,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(15,8,$impuesto,1,0,'C', True);
    $this->Cell(15,8,'DCTO %',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,25,60,25,25,25,25,25,25,25,25,15,15));

    $a=1;
    $TotalCompra=0;
    $TotalMenor=0;
    $TotalMayor=0;
    $TotalPublico=0;
    //$TotalMonedaMenor=0;
    //$TotalMonedaMayor=0;
    //$TotalMonedaPublico=0;
    $TotalArticulos=0;
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    $TotalCompra+=$reg[$i]['preciocompra'];
    $TotalMenor+=$reg[$i]['precioxmenor']-$reg[$i]['descproducto']/100;
    $TotalMayor+=$reg[$i]['precioxmayor']-$reg[$i]['descproducto']/100;
    $TotalPublico+=$reg[$i]['precioxpublico']-$reg[$i]['descproducto']/100;
    //$TotalMonedaMenor+=$reg[$i]['precioxmenor']/$reg[$i]['montocambio']-$reg[$i]['descproducto']/100;
    //$TotalMonedaMayor+=$reg[$i]['precioxmayor']/$reg[$i]['montocambio']-$reg[$i]['descproducto']/100;
    //$TotalMonedaPublico+=$reg[$i]['precioxpublico']/$reg[$i]['montocambio']-$reg[$i]['descproducto']/100;
    $TotalArticulos+=$reg[$i]['existencia'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        portales(utf8_decode($reg[$i]["producto"])),
        utf8_decode($reg[$i]["nompresentacion"]),
        utf8_decode($reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['nommodelo'] == '' ? "*********" : $reg[$i]['nommodelo']),
        utf8_decode($simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ',')),
        utf8_decode($reg[$i]['existencia']),
        utf8_decode($reg[$i]['ivaproducto'] == 'SI' ? number_format($imp[0]["valorimpuesto"], 2, '.', ',')."%" : "(E)"),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ','))));
  }
   
    $this->Cell(175,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalCompra, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalMenor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalMayor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalPublico, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->Ln();
   }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PRODUCTOS ##############################

####################### FUNCION LISTAR PRODUCTOS EN STOCK OPTIMO ##############################
function TablaListarProductosOptimo()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->ListarProductosOptimo(); 

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO DE PRODUCTOS EN STOCK ÓPTIMO',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && $reg != ""){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(25,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(45,8,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(30,8,'PRESENTACIÓN',1,0,'C', True);
    $this->Cell(20,8,'MARCA',1,0,'C', True);
    $this->Cell(20,8,'MODELO',1,0,'C', True);
    $this->Cell(25,8,'P. COMPRA',1,0,'C', True);
    $this->Cell(25,8,'P. MENOR',1,0,'C', True);
    $this->Cell(25,8,'P. MAYOR',1,0,'C', True);
    $this->Cell(25,8,'P. PÚBLICO',1,0,'C', True);
    $this->Cell(20,8,'EXIST.',1,0,'C', True);
    $this->Cell(25,8,'STOCK ÓPT.',1,0,'C', True);
    $this->Cell(15,8,$impuesto,1,0,'C', True);
    $this->Cell(15,8,'DCTO %',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,25,45,30,20,20,25,25,25,25,20,25,15,15));

    $a=1;
    $TotalCompra=0;
    $TotalMenor=0;
    $TotalMayor=0;
    $TotalPublico=0;
    $TotalArticulos=0;
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);  
    $TotalCompra+=$reg[$i]['preciocompra'];
    $TotalMenor+=$reg[$i]['precioxmenor']-$reg[$i]['descproducto']/100;
    $TotalMayor+=$reg[$i]['precioxmayor']-$reg[$i]['descproducto']/100;
    $TotalPublico+=$reg[$i]['precioxpublico']-$reg[$i]['descproducto']/100;
    $TotalArticulos+=$reg[$i]['existencia'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        portales(utf8_decode($reg[$i]["producto"])),
        utf8_decode($reg[$i]["nompresentacion"]),
        utf8_decode($reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['nommodelo'] == '' ? "*********" : $reg[$i]['nommodelo']),
        utf8_decode($simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ',')),
        utf8_decode($reg[$i]['existencia']),
        utf8_decode($reg[$i]['stockoptimo']),
        utf8_decode($reg[$i]['ivaproducto'] == 'SI' ? number_format($imp[0]["valorimpuesto"], 2, '.', ',')."%" : "(E)"),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ','))));
  }
   
    $this->Cell(155,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalCompra, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalMenor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalMayor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalPublico, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(20,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->Ln();
   }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PRODUCTOS EN STOCK OPTIMO ##############################

####################### FUNCION LISTAR PRODUCTOS EN STOCK MEDIO ##############################
function TablaListarProductosMedio()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->ListarProductosMedio(); 

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO DE PRODUCTOS EN STOCK MEDIO',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && $reg != ""){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }
    

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(25,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(45,8,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(30,8,'PRESENTACIÓN',1,0,'C', True);
    $this->Cell(20,8,'MARCA',1,0,'C', True);
    $this->Cell(20,8,'MODELO',1,0,'C', True);
    $this->Cell(25,8,'P. COMPRA',1,0,'C', True);
    $this->Cell(25,8,'P. MENOR',1,0,'C', True);
    $this->Cell(25,8,'P. MAYOR',1,0,'C', True);
    $this->Cell(25,8,'P. PÚBLICO',1,0,'C', True);
    $this->Cell(20,8,'EXIST.',1,0,'C', True);
    $this->Cell(25,8,'STOCK ÓPT.',1,0,'C', True);
    $this->Cell(15,8,$impuesto,1,0,'C', True);
    $this->Cell(15,8,'DCTO %',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,25,45,30,20,20,25,25,25,25,20,25,15,15));

    $a=1;
    $TotalCompra=0;
    $TotalMenor=0;
    $TotalMayor=0;
    $TotalPublico=0;
    $TotalArticulos=0;
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);  
    $TotalCompra+=$reg[$i]['preciocompra'];
    $TotalMenor+=$reg[$i]['precioxmenor']-$reg[$i]['descproducto']/100;
    $TotalMayor+=$reg[$i]['precioxmayor']-$reg[$i]['descproducto']/100;
    $TotalPublico+=$reg[$i]['precioxpublico']-$reg[$i]['descproducto']/100;
    $TotalArticulos+=$reg[$i]['existencia'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        portales(utf8_decode($reg[$i]["producto"])),
        utf8_decode($reg[$i]["nompresentacion"]),
        utf8_decode($reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['nommodelo'] == '' ? "*********" : $reg[$i]['nommodelo']),
        utf8_decode($simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ',')),
        utf8_decode($reg[$i]['existencia']),
        utf8_decode($reg[$i]['stockmedio']),
        utf8_decode($reg[$i]['ivaproducto'] == 'SI' ? number_format($imp[0]["valorimpuesto"], 2, '.', ',')."%" : "(E)"),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ','))));
  }
   
    $this->Cell(155,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalCompra, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalMenor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalMayor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalPublico, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(20,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->Ln();
   }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PRODUCTOS EN STOCK MEDIO ##############################

####################### FUNCION LISTAR PRODUCTOS EN STOCK MINIMO ##############################
function TablaListarProductosMinimo()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->ListarProductosMinimo(); 

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO DE PRODUCTOS EN STOCK MINIMO',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && $reg != ""){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(25,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(45,8,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(30,8,'PRESENTACIÓN',1,0,'C', True);
    $this->Cell(20,8,'MARCA',1,0,'C', True);
    $this->Cell(20,8,'MODELO',1,0,'C', True);
    $this->Cell(25,8,'P. COMPRA',1,0,'C', True);
    $this->Cell(25,8,'P. MENOR',1,0,'C', True);
    $this->Cell(25,8,'P. MAYOR',1,0,'C', True);
    $this->Cell(25,8,'P. PÚBLICO',1,0,'C', True);
    $this->Cell(20,8,'EXIST.',1,0,'C', True);
    $this->Cell(25,8,'STOCK MIN.',1,0,'C', True);
    $this->Cell(15,8,$impuesto,1,0,'C', True);
    $this->Cell(15,8,'DCTO %',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,25,45,30,20,20,25,25,25,25,20,25,15,15));

    $a=1;
    $TotalCompra=0;
    $TotalMenor=0;
    $TotalMayor=0;
    $TotalPublico=0;
    $TotalArticulos=0;
    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    $TotalCompra+=$reg[$i]['preciocompra'];
    $TotalMenor+=$reg[$i]['precioxmenor']-$reg[$i]['descproducto']/100;
    $TotalMayor+=$reg[$i]['precioxmayor']-$reg[$i]['descproducto']/100;
    $TotalPublico+=$reg[$i]['precioxpublico']-$reg[$i]['descproducto']/100;
    $TotalArticulos+=$reg[$i]['existencia'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        portales(utf8_decode($reg[$i]["producto"])),
        utf8_decode($reg[$i]["nompresentacion"]),
        utf8_decode($reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['nommodelo'] == '' ? "*********" : $reg[$i]['nommodelo']),
        utf8_decode($simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ',')),
        utf8_decode($reg[$i]['existencia']),
        utf8_decode($reg[$i]['stockminimo']),
        utf8_decode($reg[$i]['ivaproducto'] == 'SI' ? number_format($imp[0]["valorimpuesto"], 2, '.', ',')."%" : "(E)"),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ','))));
  }
   
    $this->Cell(155,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalCompra, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalMenor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalMayor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalPublico, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(20,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->Ln();
   }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PRODUCTOS EN STOCK MINIMO ##############################

##################### FUNCION LISTAR CODIGO DE BARRAS DE PRODUCTOS #####################
function TablaListarCodigoBarras()
{

    $tra = new Login();
    $reg = $tra->ListarCodigoBarra();

    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,14,'LISTADO DE CÓDIGO DE BARRAS DE PRODUCTOS',0,0,'C');
    $this->Ln();

    if($_SESSION['acceso'] == "administradorG" && $reg != ""){

    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    $this->Ln(10);

    }


    if($reg==""){
    echo "";      
    } else {

    $rows = 0;
    for($i=0;$i<sizeof($reg);$i++){
    $this->SetDrawColor(3,3,3);
    //$this->DashedRect(10,50,65,64);

    $code = ( $reg[$i]['codigobarra'] == '' ? $reg[$i]['codproducto'] : $reg[$i]['codigobarra']);

    barcode('fpdf/codigos/'.$code.'.png', $code, 22, 'horizontal', 'code128', true);

    $this->Cell(63,14,$this->Image('fpdf/codigos/'.$code.'.png',14, $this->GetY()+2, 58), 1, 0, "PNG" );
    $this->Cell(63,14,$this->Image('fpdf/codigos/'.$code.'.png',76, $this->GetY()+2, 58), 1, 0, "PNG" );
    $this->Cell(63,14,$this->Image('fpdf/codigos/'.$code.'.png',140, $this->GetY()+2, 58), 1, 0, "PNG" );
    $this->Ln(14);

    $rows++;
 
    if ($rows>=14) {
        $rows = 0;
        $this->AddPage();
    }

     }
    }

}
##################### FUNCION LISTAR CODIGO DE BARRAS DE PRODUCTOS ###################

################## FUNCION LISTAR PRODUCTOS POR SUCURSAL SEGUN MODENA ###################
function TablaListarProductosxMoneda()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $con = new Login();
    $con = $con->ConfiguracionPorId();
    

    $cambio = new Login();
    $cambio = $cambio->BuscarTiposCambios();

    $tra = new Login();
    $reg = $tra->ListarProductos(); 

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL ################################# 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE PRODUCTOS EN ALMACEN POR MONEDA',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"MONEDA: ".portales(utf8_decode($cambio[0]["moneda"])),0,0,'L'); 
    

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(46,8,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(30,8,'PRESENTACIÓN',1,0,'C', True);
    $this->Cell(30,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'MODELO',1,0,'C', True);
    $this->Cell(33,8,'P. MENOR',1,0,'C', True);
    $this->Cell(33,8,'P. MAYOR',1,0,'C', True);
    $this->Cell(33,8,'P. PÚBLICO',1,0,'C', True);
    $this->Cell(20,8,'EXIST.',1,0,'C', True);
    $this->Cell(15,8,$impuesto,1,0,'C', True);
    $this->Cell(15,8,'DCTO %',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,30,46,30,30,30,33,33,33,20,15,15));

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
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    $TotalCompra+=number_format($reg[$i]['preciocompra'], 2, '.', '');
    $TotalMenor+=number_format($reg[$i]['precioxmenor']-$reg[$i]['descproducto']/100, 2, '.', '');
    $TotalMayor+=number_format($reg[$i]['precioxmayor']-$reg[$i]['descproducto']/100, 2, '.', '');
    $TotalPublico+=number_format($reg[$i]['precioxpublico']-$reg[$i]['descproducto']/100, 2, '.', '');
    $TotalMonedaCompra+=number_format($reg[$i]['preciocompra']/$cambio[0]['montocambio']-$reg[$i]['descproducto']/100, 2, '.', '');
    $TotalMonedaMenor+=number_format($reg[$i]['precioxmenor']/$cambio[0]['montocambio']-$reg[$i]['descproducto']/100, 2, '.', '');
    $TotalMonedaMayor+=number_format($reg[$i]['precioxmayor']/$cambio[0]['montocambio']-$reg[$i]['descproducto']/100, 2, '.', '');
    $TotalMonedaPublico+=number_format($reg[$i]['precioxpublico']/$cambio[0]['montocambio']-$reg[$i]['descproducto']/100, 2, '.', '');
    $TotalArticulos+=$reg[$i]['existencia'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codproducto"]),portales(utf8_decode($reg[$i]["producto"])),utf8_decode($reg[$i]["nompresentacion"]),utf8_decode($reg[$i]["nommarca"]),utf8_decode($reg[$i]['nommodelo'] == '' ? "*********" : $reg[$i]['nommodelo']),

        $tipo = ($cambio[0]['moneda'] == "EURO" ? chr(128) : $cambio[0]['simbolo']).utf8_decode(number_format($reg[$i]['precioxmenor']/$cambio[0]['montocambio'], 2, '.', ',')),

        $tipo = ($cambio[0]['moneda'] == "EURO" ? chr(128) : $cambio[0]['simbolo']).utf8_decode(number_format($reg[$i]['precioxmayor']/$cambio[0]['montocambio'], 2, '.', ',')),

        $tipo = ($cambio[0]['moneda'] == "EURO" ? chr(128) : $cambio[0]['simbolo']).utf8_decode(number_format($reg[$i]['precioxpublico']/$cambio[0]['montocambio'], 2, '.', ',')),

        utf8_decode($reg[$i]['existencia']),utf8_decode($reg[$i]['ivaproducto'] == 'SI' ? number_format($imp[0]["valorimpuesto"], 2, '.', ',')."%" : "(E)"),utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ','))));
  }
   }

    $this->Cell(181,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(33,5,utf8_decode($cambio[0]['simbolo'].number_format($TotalMonedaMenor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(33,5,utf8_decode($cambio[0]['simbolo'].number_format($TotalMonedaMayor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(33,5,utf8_decode($cambio[0]['simbolo'].number_format($TotalMonedaPublico, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(33,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->Ln();

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
################### FUNCION LISTAR PRODUCTOS POR SUCURSAL SEGUN MODENA ################

###################### FUNCION LISTAR KARDEX POR PRODUCTO ########################
function TablaListarKardex()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $kardex = new Login();
    $kardex = $kardex->BuscarKardexProducto(); 

    $detalle = new Login();
    $detalle = $detalle->DetalleProductosKardex();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId();
    
    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,"KARDEX GENERAL POR PRODUCTO ",0,0,'C'); 

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($detalle[0]['documento'])." SUCURSAL: ".utf8_decode($detalle[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($detalle[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($detalle[0]["nomencargado"])),0,0,'L'); 

    }  

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'MOVIMIENTO',1,0,'C', True);
    $this->Cell(25,8,'ENTRADAS',1,0,'C', True);
    $this->Cell(25,8,'SALIDAS',1,0,'C', True);
    $this->Cell(25,8,'DEVOLUCIÓN',1,0,'C', True);
    $this->Cell(25,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(20,8,$impuesto,1,0,'C', True);
    $this->Cell(30,8,'DESCUENTO',1,0,'C', True);
    $this->Cell(30,8,'PRECIO',1,0,'C', True);
    $this->Cell(70,8,'DOCUMENTO',1,0,'C', True);
    $this->Cell(30,8,'FECHA KARDEX',1,1,'C', True);

    if($kardex==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,35,25,25,25,25,20,30,30,70,30));

    $TotalEntradas=0;
    $TotalSalidas=0;
    $TotalDevolucion=0;
    $a=1;
    for($i=0;$i<sizeof($kardex);$i++){ 
    $simbolo = ($detalle[0]['simbolo'] == "" ? "" : $detalle[0]['simbolo']);
    $TotalEntradas+=$kardex[$i]['entradas'];
    $TotalSalidas+=$kardex[$i]['salidas'];
    $TotalDevolucion+=$kardex[$i]['devolucion'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($kardex[$i]["movimiento"]),
        utf8_decode($kardex[$i]["entradas"]),
        utf8_decode($kardex[$i]["salidas"]),
        utf8_decode($kardex[$i]["devolucion"]),
        utf8_decode($kardex[$i]['stockactual']),
        utf8_decode($kardex[$i]['ivaproducto']),
        utf8_decode(number_format($kardex[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($kardex[$i]['precio'], 2, '.', ',')),
        portales(utf8_decode($kardex[$i]['documento'])),
        utf8_decode(date("d-m-Y",strtotime($kardex[$i]['fechakardex'])))));
  }
   }
   
    $this->Cell(325,5,'',0,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(120,5,'DETALLES DEL PRODUCTO',1,0,'C', True);
    $this->Ln();
    
    $this->Cell(35,5,'CÓDIGO',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($kardex[0]['codproducto']),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,'DESCRIPCIÓN',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,portales(utf8_decode($detalle[0]['producto'])),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,'ENTRADAS',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($TotalEntradas),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,'SALIDAS',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($TotalSalidas),1,0,'C');
    $this->Ln();

    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,'DEVOLUCIÓN',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($TotalDevolucion),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,'EXISTENCIA',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($detalle[0]['existencia']),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(35,5,'PRECIO COMPRA',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($simbolo.number_format($detalle[0]['preciocompra'], 2, '.', ',')),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(35,5,'P.VENTA MENOR',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($simbolo.number_format($detalle[0]['precioxmenor'], 2, '.', ',')),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(35,5,'P. VENTA MAYOR',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($simbolo.number_format($detalle[0]['precioxmayor'], 2, '.', ',')),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(35,5,'P. VENTA PÚBLICO',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($simbolo.number_format($detalle[0]['precioxpublico'], 2, '.', ',')),1,0,'C');
    $this->Ln();
    

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
######################## FUNCION LISTAR KARDEX POR PRODUCTO ########################

####################### FUNCION LISTAR KARDEX VALORIZADO ###########################
function TablaListarKardexValorizado()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->ListarKardexValorizado(); 

   ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId();
    
    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,"LISTADO DE KARDEX VALORIZADO ",0,0,'C'); 

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    } 


    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCIÓN DE PRODUCTO',1,0,'C', True);
    $this->Cell(20,8,'MARCA',1,0,'C', True);
    $this->Cell(20,8,'MODELO',1,0,'C', True);
    $this->Cell(30,8,"PRECIO PÚBLICO",1,0,'C', True);
    $this->Cell(15,8,'DCTO %',1,0,'C', True);
    $this->Cell(20,8,$impuesto,1,0,'C', True);
    $this->Cell(25,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(30,8,'TOTAL VENTA',1,0,'C', True);
    $this->Cell(30,8,'TOTAL COMPRA',1,0,'C', True);
    $this->Cell(25,8,'GANANCIAS',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,30,70,20,20,30,15,20,25,30,30,25));

    $PrecioTotal=0;
    $ExisteTotal=0;
    $PagoTotal=0;
    $CompraTotal=0;
    $TotalGanancia=0;
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
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

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($reg[$i]["codproducto"]),
        portales(utf8_decode($reg[$i]["producto"])),
        utf8_decode($reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']),
        utf8_decode($simbolo.number_format($reg[$i]["precioxpublico"], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($reg[$i]['ivaproducto'] == 'SI' ? number_format($imp[0]["valorimpuesto"], 2, '.', ',')."%" : "(E)"),
        utf8_decode($reg[$i]['existencia']),
        utf8_decode($simbolo.number_format($reg[$i]['precioxpublico']*$reg[$i]['existencia']-$reg[$i]['descproducto']/100, 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','))));
  }
   }
   
    $this->Cell(220,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode($ExisteTotal),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PagoTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($CompraTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalGanancia, 2, '.', ',')),0,0,'L');
    $this->Ln();
   

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
###################### FUNCION LISTAR KARDEX VALORIZADO ##########################

####################### FUNCION LISTAR KARDEX VALORIZADO POR FECHAS ###########################
function TablaListarKardexValorizadoxFechas()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);
    
    $tra = new Login();
    $reg = $tra->BuscarKardexValorizadoxFechas(); 

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,"LISTADO DE KARDEX VALORIZADO POR VENDEDOR",0,0,'C'); 

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    } 

    $this->Ln();
    $this->Cell(335,6,"VENDEDOR: ".portales(utf8_decode($reg[0]['nombres'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L'); 

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCIÓN DE PRODUCTO',1,0,'C', True);
    $this->Cell(20,8,'MARCA',1,0,'C', True);
    $this->Cell(20,8,'MODELO',1,0,'C', True);
    $this->Cell(15,8,'DCTO %',1,0,'C', True);
    $this->Cell(30,8,"PRECIO VENTA",1,0,'C', True);
    $this->Cell(25,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(20,8,'VENDIDO',1,0,'C', True);
    $this->Cell(30,8,'TOTAL VENTA',1,0,'C', True);
    $this->Cell(30,8,'TOTAL COMPRA',1,0,'C', True);
    $this->Cell(25,8,'GANANCIAS',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,30,70,20,20,15,30,25,20,30,30,25));

    $PrecioCompraTotal=0;
    $PrecioVentaTotal=0;
    $ExisteTotal=0;
    $VendidosTotal=0;
    $CompraTotal=0;
    $VentaTotal=0;
    $TotalGanancia=0;
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

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

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($reg[$i]["codproducto"]),
        portales(utf8_decode($reg[$i]["producto"])),
        utf8_decode($reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]["precioventa"], 2, '.', ',')),
        utf8_decode($reg[$i]['existencia']),
        utf8_decode($reg[$i]['cantidad']),
        utf8_decode($simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['cantidad']-$reg[$i]['descproducto']/100, 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['cantidad'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','))));
  }
   }
   
    $this->Cell(170,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PrecioVentaTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($ExisteTotal),0,0,'L');
    $this->CellFitSpace(20,5,utf8_decode($VendidosTotal),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($VentaTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($CompraTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalGanancia, 2, '.', ',')),0,0,'L');
    $this->Ln();
   

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
###################### FUNCION LISTAR KARDEX VALORIZADO POR FECHAS ##########################

############################### REPORTES DE PRODUCTOS ###########################



























############################### REPORTES DE TRASPASOS ################################

########################## FUNCION FACTURA TRASPASOS ##############################
function FacturaTraspaso()
{
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);

    $tra = new Login();
    $reg = $tra->TraspasosPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);

    //Logo
    if (isset($reg[0]['cuitsucursal'])) {
       if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

        $logo = "./fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
        $this->Image($logo, 15, 11, 30, 18, "PNG");

    } else {

        $logo = "./fotos/logo_principal.png";                         
        $this->Image($logo, 15, 10, 64, 20, "PNG");  
   }                                      
    }

######################### BLOQUE N° 1 ######################### 
   //BLOQUE DE DATOS DE PRINCIPAL
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 10, 335, 20, '1.5', '');
    
    //Bloque de membrete principal
    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(161, 13, 13, 13, '1.5', 'F');

    //Bloque de membrete principal
    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(161, 13, 13, 13, '1.5', '');

    $this->SetFont('courier','B',16);
    $this->SetXY(164.5, 14);
    $this->Cell(20, 5, 'T', 0 , 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(161, 19);
    $this->Cell(20, 5, 'Trasp.', 0, 0);
    
    $this->SetFont('courier','B',14);
    $this->SetXY(268, 14);
    $this->Cell(42, 5, 'N° DE TRASPASO ', 0, 0);
    $this->SetFont('courier','B',14);
    $this->SetXY(312, 14);
    $this->CellFitSpace(30, 5,utf8_decode($reg[0]['codfactura']), 0, 0, "R");
    
    $this->SetFont('courier','B',10);
    $this->SetXY(268, 19);
    $this->Cell(42, 5, 'FECHA DE EMISIÓN ', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(312, 19);
    $this->CellFitSpace(30, 5,utf8_decode(date("d-m-Y H:i:s",strtotime($reg[0]['fechatraspaso']))), 0, 0, "R");
    
    $this->SetFont('courier','B',10);
    $this->SetXY(268, 23);
    $this->Cell(42, 5, 'FECHA DE RECEPCIÓN ', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(312, 23);
    $this->CellFitSpace(30, 5,utf8_decode(date("d-m-Y H:i:s")), 0, 0, "R");
######################### BLOQUE N° 1 ######################### 

############################## BLOQUE N° 2 #####################################   
   //BLOQUE DE DATOS DE PROVEEDOR
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 32, 335, 30, '1.5', '');

    //DATOS DE SUCURSAL LINEA 1
    $this->SetFont('courier','B',12);
    $this->SetXY(12, 33);
    $this->Cell(330, 5, 'DATOS DE SUCURSAL QUE ENVIA', 0, 0);
    //DATOS DE SUCURSAL LINEA 1

    //DATOS DE SUCURSAL LINEA 2
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 38);
    $this->CellFitSpace(28, 5, 'Nº DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : $reg[0]['documento'].":"), 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(40, 38);
    $this->CellFitSpace(30, 5,utf8_decode($reg[0]['cuitsucursal']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(70, 38);
    $this->Cell(30, 5, 'RAZÓN SOCIAL:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(100, 38);
    $this->CellFitSpace(50, 5,utf8_decode($reg[0]['nomsucursal']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(150, 38);
    $this->Cell(24, 5, 'DIRECCIÓN:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(174, 38);
    $this->CellFitSpace(116, 5,utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['departamento'] == '' ? "" : $reg[0]['departamento'])." ".$reg[0]['direcsucursal']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(290, 38);
    $this->Cell(22, 5, 'N° DE TLF:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(312, 38);
    $this->CellFitSpace(30, 5,utf8_decode($reg[0]['tlfsucursal']), 0, 0);
    //DATOS DE SUCURSAL LINEA 2

    //DATOS DE SUCURSAL LINEA 3
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 42);
    $this->Cell(28, 5, 'EMAIL:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(40, 42);
    $this->CellFitSpace(80, 5,utf8_decode($reg[0]['correosucursal']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(120, 42);
    $this->Cell(30, 5, 'RESPONSABLE:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(150, 42);
    $this->CellFitSpace(80, 5,utf8_decode($reg[0]['nomencargado']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(230, 42);
    $this->CellFitSpace(26, 5,'Nº DE '.$documento = ($reg[0]['documencargado'] == '0' ? "DOC.:" : $reg[0]['documento2'].":"), 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(256, 42);
    $this->CellFitSpace(34, 5,utf8_decode($reg[0]['dniencargado']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(290, 42);
    $this->Cell(22, 5, 'N° DE TLF:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(312, 42);
    $this->CellFitSpace(30, 5,utf8_decode($tlf = ($reg[0]['tlfencargado'] == '' ? "*********" : $reg[0]['tlfencargado'])), 0, 0);
    //DATOS DE SUCURSAL LINEA 3
################################# BLOQUE N° 2 #######################################   

################################# BLOQUE N° 3 #######################################   
    //DATOS DE SUCURSAL LINEA 5
    $this->SetFont('courier','B',12);
    $this->SetXY(12, 48);
    $this->Cell(330, 4, 'DATOS DE SUCURSAL QUE RECIBE', 0, 0);
    //DATOS DE SUCURSAL LINEA 5

    //DATOS DE SUCURSAL LINEA 6
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 52);
    $this->CellFitSpace(28, 5, 'Nº DE '.$documento = ($reg[0]['documsucursal2'] == '0' ? "REG.:" : $reg[0]['documento3'].":"), 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(40, 52);
    $this->CellFitSpace(30, 5,utf8_decode($reg[0]['cuitsucursal2']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(70, 52);
    $this->Cell(30, 5, 'RAZÓN SOCIAL:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(100, 52);
    $this->CellFitSpace(50, 5,utf8_decode($reg[0]['nomsucursal2']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(150, 52);
    $this->Cell(24, 5, 'DIRECCIÓN:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(174, 52);
    $this->CellFitSpace(116, 5,utf8_decode($provincia = ($reg[0]['provincia2'] == '' ? "" : $reg[0]['provincia2'])." ".$departamento = ($reg[0]['departamento2'] == '' ? "" : $reg[0]['departamento2'])." ".$reg[0]['direcsucursal2']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(290, 52);
    $this->Cell(22, 5, 'N° DE TLF:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(312, 52);
    $this->CellFitSpace(30, 5,utf8_decode($reg[0]['tlfsucursal2']), 0, 0);
    //DATOS DE SUCURSAL LINEA 6

    //DATOS DE SUCURSAL LINEA 7
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 56);
    $this->Cell(28, 5, 'EMAIL:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(40, 56);
    $this->CellFitSpace(80, 5,utf8_decode($reg[0]['correosucursal2']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(120, 56);
    $this->Cell(30, 5, 'RESPONSABLE:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(150, 56);
    $this->CellFitSpace(80, 5,utf8_decode($reg[0]['nomencargado2']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(230, 56);
    $this->CellFitSpace(26, 5,'Nº DE '.$documento = ($reg[0]['documencargado2'] == '0' ? "DOC.:" : $reg[0]['documento4'].":"), 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(256, 56);
    $this->CellFitSpace(34, 5,utf8_decode($reg[0]['dniencargado2']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(290, 56);
    $this->Cell(22, 5, 'N° DE TLF:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(312, 56);
    $this->CellFitSpace(30, 5,utf8_decode($tlf = ($reg[0]['tlfencargado2'] == '' ? "*********" : $reg[0]['tlfencargado2'])), 0, 0);
    //DATOS DE SUCURSAL LINEA 7
################################# BLOQUE N° 3 #######################################   

################################# BLOQUE N° 4 #######################################   
    //Bloque Cuadro de Detalles de Productos
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 68, 335, 90, '0', '');

    $this->SetFont('courier','B',9);
    $this->SetXY(10, 64);
    $this->SetTextColor(3, 3, 3); // Establece el color del texto (en este caso es Negro)
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->Cell(10,8,'N°',1,0,'C', True);
    $this->Cell(30,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(88,8,'DESCRIPCIÓN DE PRODUCTO',1,0,'C', True);
    $this->Cell(30,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'MODELO',1,0,'C', True);
    $this->Cell(15,8,'CANT',1,0,'C', True);
    $this->Cell(15,8,$impuesto,1,0,'C', True);
    $this->Cell(30,8,'PRECIO UNIT',1,0,'C', True);
    $this->Cell(34,8,'VALOR TOTAL',1,0,'C', True);
    $this->Cell(18,8,'% DCTO',1,0,'C', True);
    $this->Cell(35,8,'VALOR NETO',1,1,'C', True);
################################# BLOQUE N° 4 ####################################### 

################################# BLOQUE N° 5 ####################################### 
    $tra = new Login();
    $detalle = $tra->VerDetallesTraspasos();
    $cantidad = 0;
    $SubTotal = 0;

     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(9,30,88,30,30,15,15,30,34,18,34));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $cantidad += $detalle[$i]['cantidad'];
    $valortotal = $detalle[$i]["precioventa"]*$detalle[$i]["cantidad"];
    $SubTotal += $detalle[$i]['valorneto'];

    $this->SetX(11);
    $this->SetFont('Courier','',9);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->SetFillColor(255, 255, 255); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->RowFacture(array($a++,
        utf8_decode($detalle[$i]["codproducto"]),
        portales(utf8_decode($detalle[$i]["producto"])),
        utf8_decode($detalle[$i]["nommarca"] == '' ? "******" : $detalle[$i]["nommarca"]),
        utf8_decode($detalle[$i]["nommodelo"] == '' ? "******" : $detalle[$i]["nommodelo"]),
        utf8_decode($detalle[$i]["cantidad"]),
        utf8_decode($detalle[$i]["ivaproducto"] == 'SI' ? number_format($reg[0]["iva"], 2, '.', ',')."%" : "(E)"),
        utf8_decode($simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ',')),
        utf8_decode(number_format($detalle[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','))));
  }
################################# BLOQUE N° 5 ####################################### 

    ########################### BLOQUE N° 5 DE TOTALES #############################    
    //Bloque de Informacion adicional
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 162, 240, 38, '1.5', '');

    //Linea de membrete Nro 1
    $this->SetFont('courier','B',14);
    $this->SetXY(115, 164);
    $this->Cell(20, 5, 'INFORMACIÓN ADICIONAL', 0 , 0);
       
    //Linea de membrete Nro 2
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 172);
    $this->Cell(20, 5, 'CANTIDAD DE PRODUCTOS:', 0 , 0);
    $this->SetXY(64, 172);
    $this->SetFont('courier','',10);
    $this->Cell(20, 5,utf8_decode($cantidad), 0 , 0);
       
    //Linea de membrete Nro 3
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 178);
    $this->Cell(20, 5, 'TIPO DE DOCUMENTO:', 0 , 0);
    $this->SetXY(64, 178);
    $this->SetFont('courier','',10);
    $this->Cell(20, 5,utf8_decode("FACTURA"), 0 , 0);
       
    //Linea de membrete Nro 4
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 184);
    $this->Cell(20, 5, 'OBSERVACIONES:', 0 , 0);
    $this->SetXY(64, 184);
    $this->MultiCell(236,4,$this->SetFont('Courier','',10).utf8_decode($reg[0]['observaciones'] == '' ? "**********" : $reg[0]['observaciones']),0,'J');
    
    //Bloque de Totales de factura
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(253, 162, 91, 38, '1.5', '');

     //Linea de membrete Nro 1
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 166);
    $this->CellFitSpace(44, 5, 'SUBTOTAL:', 0, 0);
    $this->SetXY(298, 166);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($SubTotal, 2, '.', ',')), 0, 0, "R");

     //Linea de membrete Nro 2
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 170);
    $this->CellFitSpace(44, 5, 'TOTAL GRAVADO ('.number_format($reg[0]["iva"], 2, '.', ',').'%):', 0, 0);
    $this->SetXY(298, 170);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["subtotalivasi"], 2, '.', ',')), 0, 0, "R");

     //Linea de membrete Nro 3
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 174);
    $this->CellFitSpace(44, 5, 'TOTAL EXENTO (0%):', 0, 0);
    $this->SetXY(298, 174);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["subtotalivano"], 2, '.', ',')), 0, 0, "R");

     //Linea de membrete Nro 4
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 178);
    $this->CellFitSpace(44, 5, $impuesto == '' ? "TOTAL IMP." : "TOTAL ".$impuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):", 0, 0);
    $this->SetXY(298, 178);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["totaliva"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 3
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 182);
    $this->CellFitSpace(44, 5, 'DESCONTADO %:', 0, 0);
    $this->SetXY(298, 182);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["descontado"], 2, '.', ',')), 0, 0, "R");

     //Linea de membrete Nro 5
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 186);
    $this->CellFitSpace(44, 5, "DESC. GLOBAL (".number_format($reg[0]["descuento"], 2, '.', ',').'%):', 0, 0);
    $this->SetXY(298, 186);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["totaldescuento"], 2, '.', ',')), 0, 0, "R");

     //Linea de membrete Nro 6
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 190);
    $this->CellFitSpace(44, 5, 'IMPORTE TOTAL:', 0, 0);
    $this->SetXY(298, 190);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["totalpago"], 2, '.', ',')), 0, 0, "R");
    
}
########################## FUNCION FACTURA TRASPASOS ##############################

########################## FUNCION LISTAR TRASPASOS ##############################
function TablaListarTraspasos()
{
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->ListarTraspasos();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId();

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO GENERAL DE TRASPASOS',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE TRASPASO',1,0,'C', True);
    $this->Cell(50,8,'SUCURSAL ENVIA',1,0,'C', True);
    $this->Cell(50,8,'SUCURSAL RECIBE',1,0,'C', True);
    $this->Cell(35,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(25,8,'Nº ARTIC.',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(25,8,$impuesto,1,0,'C', True);
    $this->Cell(25,8,'DESC %',1,0,'C', True);
    $this->Cell(35,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,50,50,35,25,35,25,25,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalImpuesto=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalImpuesto+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]["nomsucursal"]),utf8_decode($reg[$i]["nomsucursal2"]),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechatraspaso']))),utf8_decode($reg[$i]["articulos"]),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
   }
   
    $this->Cell(185,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalImpuesto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
 }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR TRASPASOS ##############################

####################### FUNCION LISTAR TRASPASOS POR SUCURSAL ########################
function TablaListarTraspasosxSucursal()
{
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarTraspasosxSucursal();

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId();

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(5, 130, 275); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(45,5,$this->Image($logo, $this->GetX()+70, $this->GetY()+1, 28),0,0,'C');
    $this->Cell(240,5,utf8_decode($con[0]['nomsucursal']),0,0,'C');
    $this->Cell(45,5,$this->Image($logo2, $this->GetX()-50, $this->GetY()+1, 28),0,0,'C');

    $this->Ln();
    $this->Cell(45,5,"",0,0,'C');
    $this->Cell(240,5,$con[0]['documsucursal'] == '0' ? "" : $con[0]['documento']." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(45,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(45,5,"",0,0,'C');
    $this->Cell(240,5,utf8_decode($provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia'])." ".$departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$con[0]['direcsucursal']),0,0,'C');
    $this->Cell(45,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(45,5,"",0,0,'C');
    $this->Cell(240,5,"Nº DE TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(45,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(45,5,"",0,0,'C');
    $this->Cell(240,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(45,5,"",0,0,'C');
    $this->Ln(10);
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE TRASPASOS POR SUCURSAL',0,0,'C');

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE TRASPASO',1,0,'C', True);
    $this->Cell(50,8,'SUCURSAL ENVIA',1,0,'C', True);
    $this->Cell(50,8,'SUCURSAL RECIBE',1,0,'C', True);
    $this->Cell(35,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(25,8,'Nº ARTIC.',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(25,8,$impuesto,1,0,'C', True);
    $this->Cell(25,8,'DESC %',1,0,'C', True);
    $this->Cell(35,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,50,50,35,25,35,25,25,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalImpuesto=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalImpuesto+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]["nomsucursal"]),utf8_decode($reg[$i]["nomsucursal2"]),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechatraspaso']))),utf8_decode($reg[$i]["articulos"]),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
   }
   
    $this->Cell(185,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalImpuesto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
 }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
####################### FUNCION LISTAR TRASPASOS POR SUCURSAL #########################

####################### FUNCION LISTAR TRASPASOS POR FECHAS #########################
function TablaListarTraspasosxFechas()
{
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarTraspasosxFechas();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################

    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE TRASPASOS POR FECHAS',0,0,'C');

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L'); 

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE TRASPASO',1,0,'C', True);
    $this->Cell(50,8,'SUCURSAL ENVIA',1,0,'C', True);
    $this->Cell(50,8,'SUCURSAL RECIBE',1,0,'C', True);
    $this->Cell(35,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(25,8,'Nº ARTIC.',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(25,8,$impuesto,1,0,'C', True);
    $this->Cell(25,8,'DESC %',1,0,'C', True);
    $this->Cell(35,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,50,50,35,25,35,25,25,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalImpuesto=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalImpuesto+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]["nomsucursal"]),utf8_decode($reg[$i]["nomsucursal2"]),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechatraspaso']))),utf8_decode($reg[$i]["articulos"]),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
   }
   
    $this->Cell(185,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalImpuesto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
 }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR TRASPASOS POR FECHAS #########################

####################### FUNCION LISTAR DETALLES TRASPASOS POR FECHAS #########################
function TablaListarDetallesTraspasosxFechas()
{
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarDetallesTraspasosxFechas();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################

    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DETALLES TRASPASADOS POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    } 

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L'); 

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(90,8,'DESCRIPCIÓN DE PRODUCTO',1,0,'C', True);
    $this->Cell(30,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'DCTO %',1,0,'C', True);
    $this->Cell(30,8,"PRECIO VENTA",1,0,'C', True);
    $this->Cell(30,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(25,8,'TRASPASADO',1,0,'C', True);
    $this->Cell(30,8,'MONTO TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,30,90,30,30,20,30,30,25,30));

    $PrecioTotal=0;
    $ExisteTotal=0;
    $VendidosTotal=0;
    $PagoTotal=0;
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    $PrecioTotal+=$reg[$i]['precioventa'];
    $ExisteTotal+=$reg[$i]['existencia'];
    $VendidosTotal+=$reg[$i]['cantidad']; 

    $Descuento = $reg[$i]['descproducto']/100;
    $PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
    $PagoTotal+=$PrecioFinal*$reg[$i]['cantidad'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($reg[$i]["codproducto"]),
        portales(utf8_decode($reg[$i]["producto"])),
        utf8_decode($reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['nommodelo'] == '' ? "*****" : $reg[$i]['nommodelo']),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]["precioventa"], 2, '.', ',')),
        utf8_decode($reg[$i]['existencia']),
        utf8_decode($reg[$i]['cantidad']),
        utf8_decode($simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','))));
  }
   }
   
    $this->Cell(215,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PrecioTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($ExisteTotal),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($VendidosTotal),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PagoTotal, 2, '.', ',')),0,0,'L');
    $this->Ln();

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR DETALLES TRASPASOS POR FECHAS #########################

############################### REPORTES DE TRASPASOS ##################################





































 ############################# REPORTES DE COMPRAS ##################################

########################## FUNCION FACTURA COMPRA ##############################
function FacturaCompra()
{
        
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    
    $tra = new Login();
    $reg = $tra->ComprasPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);

    //Logo
    if (isset($reg[0]['cuitsucursal'])) {
        if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

        $logo = "./fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
        $this->Image($logo, 15, 11, 30, 18, "PNG");

    } else {

        $logo = "./fotos/logo_principal.png";                         
        $this->Image($logo, 15, 10, 64, 20, "PNG");  
   }                                      
    }

######################### BLOQUE N° 1 ######################### 
   //BLOQUE DE DATOS DE PRINCIPAL
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 10, 335, 20, '1.5', '');
    
    //Bloque de membrete principal
    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(161, 13, 13, 13, '1.5', 'F');

    //Bloque de membrete principal
    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(161, 13, 13, 13, '1.5', '');

    $this->SetFont('courier','B',16);
    $this->SetXY(164.5, 14);
    $this->Cell(20, 5, 'C', 0 , 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(161, 19);
    $this->Cell(20, 5, 'Compra', 0, 0);
    
    $this->SetFont('courier','B',12);
    $this->SetXY(270, 12);
    $this->Cell(42, 5, 'N° DE COMPRA ', 0, 0);
    $this->SetFont('courier','B',12);
    $this->SetXY(312, 12);
    $this->CellFitSpace(30, 5,utf8_decode($reg[0]['codcompra']), 0, 0, "R");
    
    $this->SetFont('courier','B',10);
    $this->SetXY(270, 16);
    $this->Cell(42, 5, 'FECHA DE EMISIÓN ', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(312, 16);
    $this->CellFitSpace(30, 5,utf8_decode(date("d-m-Y",strtotime($reg[0]['fechaemision']))), 0, 0, "R");
    
    $this->SetFont('courier','B',10);
    $this->SetXY(270, 20);
    $this->Cell(42, 5, 'FECHA DE RECEPCIÓN ', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(312, 20);
    $this->CellFitSpace(30, 5,utf8_decode(date("d-m-Y",strtotime($reg[0]['fecharecepcion']))), 0, 0, "R");
    
    $this->SetFont('courier','B',10);
    $this->SetXY(270, 24);
    $this->Cell(42, 5, 'ESTADO DE COMPRA', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(312, 24);
    
    if($reg[0]['fechavencecredito']== '0000-00-00') { 
    $this->Cell(30, 5,utf8_decode($reg[0]['statuscompra']), 0, 0, "R");
    } elseif($reg[0]['fechavencecredito'] >= date("Y-m-d")) { 
    $this->Cell(30, 5,utf8_decode($reg[0]['statuscompra']), 0, 0, "R");
    } elseif($reg[0]['fechavencecredito'] < date("Y-m-d")) { 
    $this->Cell(30, 5,utf8_decode("VENCIDA"), 0, 0, "R");
    }
######################### BLOQUE N° 1 ######################### 

############################## BLOQUE N° 2 #####################################   
   //BLOQUE DE DATOS DE PROVEEDOR
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 32, 335, 30, '1.5', '');

    //DATOS DE SUCURSAL LINEA 1
    $this->SetFont('courier','B',12);
    $this->SetXY(12, 33);
    $this->Cell(330, 5, 'DATOS DE SUCURSAL ', 0, 0);
    //DATOS DE SUCURSAL LINEA 1

    //DATOS DE SUCURSAL LINEA 2
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 38);
    $this->CellFitSpace(28, 5, 'Nº DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : $reg[0]['documento'].":"), 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(40, 38);
    $this->CellFitSpace(30, 5,utf8_decode($reg[0]['cuitsucursal']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(70, 38);
    $this->Cell(30, 5, 'RAZÓN SOCIAL:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(100, 38);
    $this->CellFitSpace(50, 5,utf8_decode($reg[0]['nomsucursal']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(150, 38);
    $this->Cell(24, 5, 'DIRECCIÓN:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(174, 38);
    $this->CellFitSpace(116, 5,utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "*********" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['departamento'] == '' ? "*********" : $reg[0]['departamento'])." ".$reg[0]['direcsucursal']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(290, 38);
    $this->Cell(22, 5, 'N° DE TLF:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(312, 38);
    $this->CellFitSpace(30, 5,utf8_decode($reg[0]['tlfsucursal']), 0, 0);
    //DATOS DE SUCURSAL LINEA 2

    //DATOS DE SUCURSAL LINEA 3
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 42);
    $this->Cell(28, 5, 'EMAIL:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(40, 42);
    $this->CellFitSpace(80, 5,utf8_decode($reg[0]['correosucursal']), 0, 0);
    //DATOS DE SUCURSAL LINEA 3

    //DATOS DE SUCURSAL LINEA 4
    $this->SetFont('courier','B',10);
    $this->SetXY(120, 42);
    $this->Cell(30, 5, 'RESPONSABLE:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(150, 42);
    $this->CellFitSpace(80, 5,utf8_decode($reg[0]['nomencargado']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(230, 42);
    $this->CellFitSpace(26, 5,'Nº DE '.$documento = ($reg[0]['documencargado'] == '0' ? "DOC.:" : $reg[0]['documento2'].":"), 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(256, 42);
    $this->CellFitSpace(34, 5,utf8_decode($reg[0]['dniencargado']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(290, 42);
    $this->Cell(22, 5, 'N° DE TLF:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(312, 42);
    $this->CellFitSpace(30, 5,utf8_decode($tlf = ($reg[0]['tlfencargado'] == '' ? "*********" : $reg[0]['tlfencargado'])), 0, 0);
    //DATOS DE SUCURSAL LINEA 4
################################# BLOQUE N° 2 #######################################   

################################# BLOQUE N° 3 #######################################   
    //DATOS DE SUCURSAL LINEA 5
    $this->SetFont('courier','B',12);
    $this->SetXY(12, 48);
    $this->Cell(330, 4, 'DATOS DE PROVEEDOR', 0, 0);
    //DATOS DE SUCURSAL LINEA 5

    //DATOS DE SUCURSAL LINEA 6
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 52);
    $this->CellFitSpace(28, 5, 'Nº DE '.$documento = ($reg[0]['documproveedor'] == '0' ? "DOC.:" : $reg[0]['documento3'].":"), 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(40, 52);
    $this->CellFitSpace(30, 5,utf8_decode($reg[0]['cuitproveedor']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(70, 52);
    $this->Cell(30, 5, 'RAZÓN SOCIAL:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(100, 52);
    $this->CellFitSpace(84, 5,utf8_decode($reg[0]['nomproveedor']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(184, 52);
    $this->Cell(24, 5, 'DIRECCIÓN:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(208, 52);
    $this->CellFitSpace(134, 5,utf8_decode($provincia = ($reg[0]['provincia2'] == '' ? "*********" : $reg[0]['provincia2'])." ".$departamento = ($reg[0]['departamento2'] == '' ? "*********" : $reg[0]['departamento2'])." ".$reg[0]['direcproveedor']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(12, 56);
    $this->Cell(28, 5, 'EMAIL:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(40, 56);
    $this->CellFitSpace(130, 5,utf8_decode($reg[0]['emailproveedor']), 0, 0);
    //DATOS DE SUCURSAL LINEA 6

    //DATOS DE SUCURSAL LINEA 7
    $this->SetFont('courier','B',10);
    $this->SetXY(170, 56);
    $this->Cell(24, 5, 'N° DE TLF:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(194, 56);
    $this->CellFitSpace(38, 5,utf8_decode($reg[0]['tlfproveedor']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(232, 56);
    $this->Cell(24, 5, 'VENDEDOR:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(256, 56);
    $this->CellFitSpace(86, 5,utf8_decode($reg[0]['vendedor']), 0, 0);
    //DATOS DE SUCURSAL LINEA 7
################################# BLOQUE N° 3 #######################################   

################################# BLOQUE N° 4 #######################################   
    //Bloque Cuadro de Detalles de Productos
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 68, 335, 90, '0', '');

    $this->SetFont('courier','B',9);
    $this->SetXY(10, 64);
    $this->SetTextColor(3, 3, 3); // Establece el color del texto (en este caso es Negro)
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->Cell(10,8,'N°',1,0,'C', True);
    $this->Cell(30,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(18,8,'LOTE',1,0,'C', True);
    $this->Cell(23,8,'F.VCTO ÓPT',1,0,'C', True);
    $this->Cell(75,8,'DESCRIPCIÓN DE PRODUCTO',1,0,'C', True);
    $this->Cell(25,8,'MARCA',1,0,'C', True);
    $this->Cell(25,8,'MODELO',1,0,'C', True);
    $this->Cell(15,8,'CANT',1,0,'C', True);
    $this->Cell(15,8,$impuesto,1,0,'C', True);
    $this->Cell(25,8,'PRECIO UNIT',1,0,'C', True);
    $this->Cell(25,8,'VALOR TOTAL',1,0,'C', True);
    $this->Cell(18,8,'% DCTO',1,0,'C', True);
    $this->Cell(31,8,'VALOR NETO',1,1,'C', True);
################################# BLOQUE N° 4 ####################################### 

################################# BLOQUE N° 5 ####################################### 
    $tra = new Login();
    $detalle = $tra->VerDetallesCompras();
    $cantidad = 0;
    $SubTotal = 0;

     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(9,30,18,23,75,25,25,15,15,25,25,18,30));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $cantidad += $detalle[$i]['cantcompra'];
    $valortotal = $detalle[$i]["preciocomprac"]*$detalle[$i]["cantcompra"];
    $SubTotal += $detalle[$i]['valorneto'];

    $this->SetX(11);
    $this->SetFont('Courier','',9);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->SetFillColor(255, 255, 255); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->RowFacture2(array($a++,
        utf8_decode($detalle[$i]["codproducto"]),
        utf8_decode($detalle[$i]["lotec"]),
        utf8_decode($detalle[$i]["fechaoptimoc"] == '0000-00-00' ? "******" : $detalle[$i]["fechaoptimoc"]),
        portales(utf8_decode($detalle[$i]["producto"])),
        utf8_decode($detalle[$i]["nommarca"] == '' ? "******" : $detalle[$i]["nommarca"]),
        utf8_decode($detalle[$i]["nommodelo"] == '' ? "******" : $detalle[$i]["nommodelo"]),
        utf8_decode($detalle[$i]["cantcompra"]),
        utf8_decode($detalle[$i]["ivaproductoc"] == 'SI' ? number_format($reg[0]["ivac"], 2, '.', ',')."%" : "(E)"),
        utf8_decode($simbolo.number_format($detalle[$i]['preciocomprac'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ',')),
        utf8_decode(number_format($detalle[$i]['descfactura'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','))));
  }
################################# BLOQUE N° 5 ####################################### 

    ########################### BLOQUE N° 5 DE TOTALES #############################    
    //Bloque de Informacion adicional
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 162, 240, 38, '1.5', '');

    //Linea de membrete Nro 1
    $this->SetFont('courier','B',14);
    $this->SetXY(115, 163);
    $this->Cell(20, 5, 'INFORMACIÓN ADICIONAL', 0 , 0);
       
    //Linea de membrete Nro 2
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 169);
    $this->Cell(20, 5, 'CANTIDAD DE PRODUCTOS:', 0 , 0);
    $this->SetXY(64, 169);
    $this->SetFont('courier','',10);
    $this->Cell(20, 5,utf8_decode($cantidad), 0 , 0);
       
    //Linea de membrete Nro 3
    $this->SetFont('courier','B',10);
    $this->SetXY(120, 169);
    $this->Cell(20, 5, 'TIPO DE DOCUMENTO:', 0 , 0);
    $this->SetXY(168, 169);
    $this->SetFont('courier','',10);
    $this->Cell(20, 5,utf8_decode("FACTURA"), 0 , 0);
       
    //Linea de membrete Nro 4
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 174);
    $this->Cell(20, 5, 'TIPO DE PAGO:', 0 , 0);
    $this->SetXY(64, 174);
    $this->SetFont('courier','',10);
    $this->Cell(20, 5,utf8_decode($reg[0]['tipocompra']), 0 , 0);
       
    if($reg[0]['tipocompra']=="CREDITO"){

   //Linea de membrete Nro 5
    $this->SetFont('courier','B',10);
    $this->SetXY(120, 174);
    $this->Cell(20, 5, 'FECHA DE VENCIMIENTO:', 0 , 0);
    $this->SetXY(168, 174);
    $this->SetFont('courier','',10);
    $this->Cell(20, 5,utf8_decode($vence = ( $reg[0]['fechavencecredito'] == '0000-00-00' ? "0" : date("d-m-Y",strtotime($reg[0]['fechavencecredito'])))), 0 , 0);
        
    //Linea de membrete Nro 6
    $this->SetFont('courier','B',10);
    $this->SetXY(200, 174);
    $this->Cell(20, 5, 'DIAS VENCIDOS:', 0 , 0);
    $this->SetXY(234, 174);
    $this->SetFont('courier','',10);
        
      if($reg[0]['fechavencecredito']== '0000-00-00') { 
        $this->Cell(20, 5,utf8_decode("0"), 0 , 0);
 } elseif($reg[0]['fechavencecredito'] >= date("Y-m-d")) { 
        $this->Cell(20, 5,utf8_decode("0"), 0 , 0);
 } elseif($reg[0]['fechavencecredito'] < date("Y-m-d")) { 
        $this->Cell(20, 5,utf8_decode(Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito'])), 0 , 0);
 }
    }
    
    //Linea de membrete Nro 4
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 179);
    $this->Cell(20, 5, 'MEDIO DE PAGO:', 0 , 0);
    $this->SetXY(64, 179);
    $this->SetFont('courier','',10);
    $this->Cell(20, 5,utf8_decode($variable = ($reg[0]['tipocompra'] == 'CONTADO' ? $reg[0]['mediopago'] : $reg[0]['formacompra'])), 0 , 0);
    
    //Linea de membrete Nro 4
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 184);
    $this->MultiCell(236,4,$this->SetFont('Courier','',10).utf8_decode(numtoletras(number_format($reg[0]['totalpagoc'], 2, '.', ''))),0,'J');

    //Linea de membrete Nro 5
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 188);
    $this->MultiCell(236,5,$this->SetFont('Courier','',10).utf8_decode($reg[0]["observaciones"]=="" ? "" : "OBSERVACIONES: ".$reg[0]["observaciones"]),0,'J');
    
    //Bloque de Totales de factura
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(253, 162, 91, 38, '1.5', '');

     //Linea de membrete Nro 1
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 166);
    $this->CellFitSpace(44, 5, 'SUBTOTAL:', 0, 0);
    $this->SetXY(298, 166);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($SubTotal, 2, '.', ',')), 0, 0, "R");

     //Linea de membrete Nro 2
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 170);
    $this->CellFitSpace(44, 5, 'TOTAL GRAVADO ('.number_format($reg[0]["ivac"], 2, '.', ',').'%):', 0, 0);
    $this->SetXY(298, 170);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["subtotalivasic"], 2, '.', ',')), 0, 0, "R");

     //Linea de membrete Nro 3
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 174);
    $this->CellFitSpace(44, 5, 'TOTAL EXENTO (0%):', 0, 0);
    $this->SetXY(298, 174);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["subtotalivanoc"], 2, '.', ',')), 0, 0, "R");

     //Linea de membrete Nro 4
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 178);
    $this->CellFitSpace(44, 5, $impuesto == '' ? "TOTAL IMP." : "TOTAL ".$impuesto." (".number_format($reg[0]["ivac"], 2, '.', ',')."%):", 0, 0);
    $this->SetXY(298, 178);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["totalivac"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 3
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 182);
    $this->CellFitSpace(44, 5, 'DESCONTADO %:', 0, 0);
    $this->SetXY(298, 182);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["descontadoc"], 2, '.', ',')), 0, 0, "R");

     //Linea de membrete Nro 5
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 186);
    $this->CellFitSpace(44, 5, "DESC. GLOBAL (".number_format($reg[0]["descuentoc"], 2, '.', ',').'%):', 0, 0);
    $this->SetXY(298, 186);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["totaldescuentoc"], 2, '.', ',')), 0, 0, "R");

     //Linea de membrete Nro 6
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 190);
    $this->CellFitSpace(44, 5, 'IMPORTE TOTAL:', 0, 0);
    $this->SetXY(298, 190);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["totalpagoc"], 2, '.', ',')), 0, 0, "R");
    
    }
########################## FUNCION FACTURA COMPRA ##############################

########################## FUNCION TICKET COMPRA ##############################
function TicketCreditoCompra()
{  
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);

    $tra = new Login();
    $reg = $tra->ComprasPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

    $logo = "./fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
    $this->Image($logo , 20, 3, 35, 15, "PNG");
    $this->Ln(8);

    }
  
    $this->SetX(4);
    $this->SetFont('Courier','B',12);
    $this->SetFillColor(2,157,116);
    $this->Cell(66, 5, "TICKET DE CRÉDITO", 0, 0, 'C');
    $this->Ln(5);
  
    $this->SetX(4);
    $this->SetFont('Courier','B',10);
    $this->CellFitSpace(66,4,utf8_decode($reg[0]['nomsucursal']), 0, 1, 'C');

    $this->SetX(4);
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(66,3,$reg[0]['documsucursal'] == '0' ? "" : "Nº ".$reg[0]['documento']." ".utf8_decode($reg[0]['cuitsucursal']),0,1,'C');

    if($reg[0]['id_provincia']!='0'){

    $this->SetX(4);
    $this->CellFitSpace(66,3,utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['departamento'] == '' ? "" : $reg[0]['departamento'])),0,1,'C');

    }

    $this->SetX(4);
    $this->CellFitSpace(66,3,utf8_decode($reg[0]['direcsucursal']),0,1,'C');

    $this->SetX(4);
    $this->CellFitSpace(66,3,"OBLIGADO A LLEVAR CONTABILIDAD: ".utf8_decode($reg[0]['llevacontabilidad']),0,1,'C');
    
    $this->SetX(4);
    $this->CellFitSpace(66,3,"Nº DE COMPRA: ".utf8_decode($reg[0]['codcompra']),0,1,'C');
    
    $this->SetX(4);
    $this->CellFitSpace(66,3,"AMBIENTE: PRODUCCIÓN",0,1,'C');
    
    $this->SetX(4);
    $this->CellFitSpace(66,3,"EMISIÓN: NORMAL",0,1,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont('courier','B',8);
    $this->Cell(70,3,'-------------- PROVEEDOR --------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(16,3,"CÓDIGO:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,utf8_decode($reg[0]['codproveedor']),0,1,'L');
    
    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(16,3,utf8_decode($documento = ($reg[0]['documproveedor'] == '0' ? "DOC.:" : $reg[0]['documento3'].": ")),0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,utf8_decode($reg[0]['cuitproveedor']),0,1,'L');
    
    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(16,3,"NOMBRES:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,utf8_decode($reg[0]['nomproveedor']),0,1,'L');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(16,3,"DIREC:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,utf8_decode($reg[0]['direcproveedor']),0,1,'L');

    $this->SetFont('courier','',8);
    $this->SetX(2);
    $this->Cell(70,3,'---------------------------------------',0,1,'C');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(26,3,"FECHA EMISIÓN:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(40,3,date("d-m-Y",strtotime($reg[0]['fechaemision'])),0,1,'L');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(26,3,"FECHA RECEPCIÓN:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(40,3,date("d-m-Y",strtotime($reg[0]['fecharecepcion'])),0,1,'L');

    $this->SetFont('courier','B',8);
    $this->SetX(2);
    $this->Cell(70,3,'---------- DETALLES DE ABONO ----------',0,1,'C');
    $this->Ln(1);

    $this->SetX(4);
    $this->SetFont('courier','B',7);
    $this->SetTextColor(3, 3, 3); // Establece el color del texto (en este caso es Negro)
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->Cell(10,3,"Nº",0,0,'C');
    $this->Cell(20,3,"MONTO ABONO",0,0,'C');
    $this->Cell(36,3,"FECHA DE ABONO",0,1,'C');

    $this->SetFont('courier','B',8);
    $this->SetX(2);
    $this->Cell(70,3,'---------------------------------------',0,0,'C');
    $this->Ln(3);

    $tra = new Login();
    $detalle = $tra->VerDetallesAbonosCompras();
    if($detalle==""){
    
    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->Cell(70,3,'NO SE ENCONTRARON ABONOS',0,0,'C');
    $this->Ln(3);

    } else {
    $cantidad=0;

     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,20,36));

    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){

    $this->SetX(4);
    $this->SetFont('courier','',7);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->CellFitSpace(10,4,$a++,0,0,'C');
    $this->CellFitSpace(20,4,utf8_decode($simbolo.number_format($detalle[$i]['montoabono'], 2, '.', ',')),0,0,'C');
    $this->CellFitSpace(36,4,utf8_decode(date("d-m-Y H:i:s",strtotime($detalle[$i]['fechaabono']))),0,0,'C');
    $this->Ln();  
  }
    }

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->Cell(70,3,'---------------------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"IMPORTE TOTAL:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(36,3,utf8_decode($simbolo.number_format($reg[0]["totalpagoc"], 2, '.', ',')),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"TOTAL ABONADO:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(36,3,utf8_decode($simbolo.number_format($reg[0]["abonototal"], 2, '.', ',')),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"TOTAL DEBE:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(36,3,utf8_decode($simbolo.number_format($reg[0]["totalpagoc"]-$reg[0]["abonototal"], 2, '.', ',')),0,1,'R');

    $this->SetFont('Courier','B',8);
    $this->SetX(2);
    $this->Cell(70,3,'---------------------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"STATUS PAGO:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(36,3,utf8_decode($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00" && $reg[0]['statuscompra'] == "PENDIENTE" ? "VENCIDA" : $reg[0]["statuscompra"]),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"VENCE CRÉDITO:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(36,3,utf8_decode(date("d-m-Y",strtotime($reg[0]["fechavencecredito"]))),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"DIAS VENCIDOS:",0,0,'L');
    $this->SetFont('Courier','',8);

    if($reg[0]['fechavencecredito']== '0000-00-00') { 
        $this->CellFitSpace(36,3,utf8_decode("0"),0,1,'R');
    } elseif($reg[0]['fechavencecredito'] >= date("Y-m-d")) { 
        $this->CellFitSpace(36,3,utf8_decode("0"),0,1,'R');
    } elseif($reg[0]['fechavencecredito'] < date("Y-m-d")) { 
        $this->CellFitSpace(36,3,utf8_decode(Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito'])),0,1,'R');
    }

    $this->SetFont('Courier','B',8);
    $this->SetX(2);
    $this->Cell(70,3,'---------------------------------------',0,0,'C');
    $this->Ln(3); 

}
########################## FUNCION TICKET CREDITO COMPRA ##############################

########################## FUNCION LISTAR COMPRAS ##############################
function TablaListarCompras()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);
    
    $tra = new Login();
    $reg = $tra->ListarCompras();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO GENERAL DE COMPRAS',0,0,'C');

if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(45,8,'SUCURSAL',1,0,'C', True);
    $this->Cell(30,8,'Nº DE COMPRA',1,0,'C', True);
    $this->Cell(65,8,'DESCRIPCIÓN DE PROVEEDOR',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(25,8,'Nº ARTIC.',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(25,8,$impuesto,1,0,'C', True);
    $this->Cell(25,8,'DESC %',1,0,'C', True);
    $this->Cell(35,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,45,30,65,30,25,35,25,25,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalImpuesto=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);  
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'];
    $TotalImpuesto+=$reg[$i]['totalivac'];
    $TotalDescuento+=$reg[$i]['totaldescuentoc'];
    $TotalImporte+=$reg[$i]['totalpagoc'];
  
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["nomsucursal"]),utf8_decode($reg[$i]["codcompra"]),portales(utf8_decode($reg[$i]["nomproveedor"])),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaemision']))),utf8_decode($reg[$i]["articulos"]),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalivac'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuentoc'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','))));
   }
   
    $this->Cell(185,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalImpuesto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
 }

    } else {

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE COMPRA',1,0,'C', True);
    $this->Cell(80,8,'DESCRIPCIÓN DE PROVEEDOR',1,0,'C', True);
    $this->Cell(35,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(25,8,'Nº ARTIC.',1,0,'C', True);
    $this->Cell(40,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(30,8,$impuesto,1,0,'C', True);
    $this->Cell(30,8,'DESC %',1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,80,35,25,40,30,30,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalImpuesto=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);  
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'];
    $TotalImpuesto+=$reg[$i]['totalivac'];
    $TotalDescuento+=$reg[$i]['totaldescuentoc'];
    $TotalImporte+=$reg[$i]['totalpagoc'];
  
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codcompra"]),portales(utf8_decode($reg[$i]["nomproveedor"])),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaemision']))),utf8_decode($reg[$i]["articulos"]),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalivac'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuentoc'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','))));
   }
   
    $this->Cell(165,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalImpuesto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
 }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COMPRAS ##############################

######################### FUNCION LISTAR CUENTAS POR PAGAR ###########################
function TablaListarCuentasxPagar()
{
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->ListarCuentasxPagar();

   ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO GENERAL DE CUENTAS POR PAGAR',0,0,'C');

    
if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(50,8,'SUCURSAL',1,0,'C', True);
    $this->Cell(30,8,'Nº DE COMPRA',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCIÓN DE PROVEEDOR',1,0,'C', True);
    $this->Cell(25,8,'STATUS',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,0,'C', True);
    $this->Cell(40,8,'TOTAL ABONO',1,0,'C', True);
    $this->Cell(40,8,'TOTAL DEBE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,50,30,60,25,30,40,40,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalImporte=0;
    $TotalAbono=0;
    $TotalDebe=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    
    $TotalImporte+=$reg[$i]['totalpagoc'];
    $TotalAbono+=$reg[$i]['abonototal'];
    $TotalDebe+=$reg[$i]['totalpagoc']-$reg[$i]['abonototal'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["nomsucursal"]),utf8_decode($reg[$i]["codcompra"]),utf8_decode($reg[$i]['nomproveedor']),utf8_decode($reg[$i]["statuscompra"]),
        utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaemision']))),utf8_decode($simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['abonototal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpagoc']-$reg[$i]['abonototal'], 2, '.', ','))));
   }
   
    $this->Cell(210,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();

 }
    } else {

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(40,8,'Nº DE COMPRA',1,0,'C', True);
    $this->Cell(75,8,'DESCRIPCIÓN DE PROVEEDOR',1,0,'C', True);
    $this->Cell(25,8,'STATUS',1,0,'C', True);
    $this->Cell(40,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(45,8,'IMPORTE TOTAL',1,0,'C', True);
    $this->Cell(45,8,'TOTAL ABONO',1,0,'C', True);
    $this->Cell(45,8,'TOTAL DEBE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,40,75,25,40,45,45,45));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalImporte=0;
    $TotalAbono=0;
    $TotalDebe=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    
    $TotalImporte+=$reg[$i]['totalpagoc'];
    $TotalAbono+=$reg[$i]['abonototal'];
    $TotalDebe+=$reg[$i]['totalpagoc']-$reg[$i]['abonototal'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codcompra"]),utf8_decode($reg[$i]['nomproveedor']),utf8_decode($reg[$i]["statuscompra"]),
        utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaemision']))),utf8_decode($simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['abonototal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpagoc']-$reg[$i]['abonototal'], 2, '.', ','))));
   }
   
    $this->Cell(195,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(45,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(45,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(45,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();
 }

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CUENTAS POR PAGAR ##########################

####################### FUNCION LISTAR COMPRAS POR PROVEEDORES #########################
function TablaListarComprasxProveedor()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);
    
    $tra = new Login();
    $reg = $tra->BuscarComprasxProveedor();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO DE COMPRAS POR PROVEEDOR',0,0,'C');
    
    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($documento = ($reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']))." PROVEEDOR: ".utf8_decode($reg[0]["cuitproveedor"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"PROVEEDOR: ".portales(utf8_decode($reg[0]["nomproveedor"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"Nº TELÉFONO: ".portales(utf8_decode($reg[0]['tlfproveedor'] == '' ? "******" : $reg[0]["tlfproveedor"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE COMPRA',1,0,'C', True);
    $this->Cell(40,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(40,8,'STATUS',1,0,'C', True);
    $this->Cell(40,8,'FECHA VENCE',1,0,'C', True);
    $this->Cell(25,8,'Nº ARTIC.',1,0,'C', True);
    $this->Cell(40,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(30,8,$impuesto,1,0,'C', True);
    $this->Cell(30,8,'DESC %',1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,40,40,40,25,40,30,30,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalImpuesto=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);  
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'];
    $TotalImpuesto+=$reg[$i]['totalivac'];
    $TotalDescuento+=$reg[$i]['totaldescuentoc'];
    $TotalImporte+=$reg[$i]['totalpagoc'];
  
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codcompra"]),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaemision']))),utf8_decode($reg[$i]['fechavencecredito']== '0000-00-00' || $reg[$i]['fechavencecredito'] >= date("Y-m-d") ? $reg[$i]['statuscompra'] : "VENCIDA"),utf8_decode($reg[$i]['fechavencecredito'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechavencecredito']))),utf8_decode($reg[$i]["articulos"]),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalivac'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuentoc'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','))));
        }
    }
   
    $this->Cell(170,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalImpuesto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
###################### FUNCION LISTAR COMPRAS POR PROVEEDORES #########################

####################### FUNCION LISTAR COMPRAS POR FECHAS ##########################
function TablaListarComprasxFechas()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);
    
    $tra = new Login();
    $reg = $tra->BuscarComprasxFechas();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $this->Ln(2);
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO DE COMPRAS POR FECHAS',0,0,'C');
    
    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L'); 

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE COMPRA',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCIÓN DE PROVEEDOR',1,0,'C', True);
    $this->Cell(35,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(30,8,'STATUS',1,0,'C', True);
    $this->Cell(25,8,'Nº ARTIC.',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(30,8,$impuesto,1,0,'C', True);
    $this->Cell(30,8,'DESC %',1,0,'C', True);
    $this->Cell(35,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,60,35,30,25,35,30,30,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalImpuesto=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);  
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'];
    $TotalImpuesto+=$reg[$i]['totalivac'];
    $TotalDescuento+=$reg[$i]['totaldescuentoc'];
    $TotalImporte+=$reg[$i]['totalpagoc'];
  
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codcompra"]),portales(utf8_decode($reg[$i]["nomproveedor"])),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaemision']))),utf8_decode($reg[$i]['fechavencecredito']== '0000-00-00' || $reg[$i]['fechavencecredito'] >= date("Y-m-d") ? $reg[$i]['statuscompra'] : "VENCIDA"),utf8_decode($reg[$i]["articulos"]),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalivac'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuentoc'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','))));
      }
   }
   
    $this->Cell(175,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalImpuesto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COMPRAS POR FECHAS ##########################

######################## FUNCION LISTAR CREDITOS POR PROVEEDOR ########################
function TablaListarCreditosxProveedor()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);
    
    $tra = new Login();
    $reg = $tra->BuscarCreditosxProveedor();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO DE CRÉDITOS COMPRAS POR PROVEEDOR',0,0,'C');
    
    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($documento = ($reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']))." PROVEEDOR: ".utf8_decode($reg[0]["cuitproveedor"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"PROVEEDOR: ".portales(utf8_decode($reg[0]["nomproveedor"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"Nº TELÉFONO: ".portales(utf8_decode($reg[0]['tlfproveedor'] == '' ? "******" : $reg[0]["tlfproveedor"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE COMPRA',1,0,'C', True);
    $this->Cell(80,8,'DESCRIPCIÓN DE PROVEEDOR',1,0,'C', True);
    $this->Cell(30,8,'STATUS',1,0,'C', True);
    $this->Cell(20,8,'DIAS VENC',1,0,'C', True);
    $this->Cell(50,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(35,8,'IMPORTE TOTAL',1,0,'C', True);
    $this->Cell(30,8,'TOTAL ABONO',1,0,'C', True);
    $this->Cell(35,8,'TOTAL DEBE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,80,30,20,50,35,30,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalImporte=0;
    $TotalAbono=0;
    $TotalDebe=0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    
    $TotalImporte+=$reg[$i]['totalpagoc'];
    $TotalAbono+=$reg[$i]['abonototal'];
    $TotalDebe+=$reg[$i]['totalpagoc']-$reg[$i]['abonototal'];

    if($reg[$i]['fechavencecredito']== '0000-00-00'){
        $vencecredito = "0";
    } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00"){
        $vencecredito = "0";
    } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00"){
        $vencecredito = Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']);
    } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00"){
        $vencecredito = Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']);
    }

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codcompra"]),utf8_decode($reg[$i]['nomproveedor']),utf8_decode($reg[$i]["statuscompra"]),
        utf8_decode($vencecredito),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaemision']))),utf8_decode($simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['abonototal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpagoc']-$reg[$i]['abonototal'], 2, '.', ','))));
   }
 }
   
    $this->Cell(230,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();
    

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CREDITOS POR PROVEEDOR ########################

########################## FUNCION LISTAR CREDITOS DE COMPRAS POR FECHAS #########################
function TablaListarCreditosComprasxFechas()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);
    
    $tra = new Login();
    $reg = $tra->BuscarCreditosComprasxFechas();

   ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO DE CRÉDITOS COMPRAS POR FECHAS',0,0,'C');
    
    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L'); 

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE COMPRA',1,0,'C', True);
    $this->Cell(80,8,'DESCRIPCIÓN DE PROVEEDOR',1,0,'C', True);
    $this->Cell(30,8,'STATUS',1,0,'C', True);
    $this->Cell(20,8,'DIAS VENC',1,0,'C', True);
    $this->Cell(50,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(35,8,'IMPORTE TOTAL',1,0,'C', True);
    $this->Cell(30,8,'TOTAL ABONO',1,0,'C', True);
    $this->Cell(35,8,'TOTAL DEBE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,80,30,20,50,35,30,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalImporte=0;
    $TotalAbono=0;
    $TotalDebe=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    
    $TotalImporte+=$reg[$i]['totalpagoc'];
    $TotalAbono+=$reg[$i]['abonototal'];
    $TotalDebe+=$reg[$i]['totalpagoc']-$reg[$i]['abonototal'];

    if($reg[$i]['fechavencecredito']== '0000-00-00'){
        $vencecredito = "0";
    } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00"){
        $vencecredito = "0";
    } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00"){
        $vencecredito = Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']);
    } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00"){
        $vencecredito = Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']);
    }

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codcompra"]),utf8_decode($reg[$i]['nomproveedor']),utf8_decode($reg[$i]["statuscompra"]),
        utf8_decode($vencecredito),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaemision']))),utf8_decode($simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['abonototal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpagoc']-$reg[$i]['abonototal'], 2, '.', ','))));
   }
 }
   
    $this->Cell(230,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();
    

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CREDITOS DE COMPRAS POR FECHAS #########################

################################ REPORTES DE COMPRAS ################################















































############################### REPORTES DE COTIZACIONES #############################

########################## FUNCION FACTURA COTIZACION ##############################
function FacturaCotizacion()
{     
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
        
    $tra = new Login();
    $reg = $tra->CotizacionesPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);

    //Logo
    if (isset($reg[0]['cuitsucursal'])) {
             if (file_exists("fotos/".$reg[0]['cuitsucursal'].".png")) {

        $logo = "./fotos/".$reg[0]['cuitsucursal'].".png";
        $this->Image($logo , 15 ,11, 25 , 15 , "PNG");

    } else {

        $logo = "./fotos/logo_principal.png";                         
        $this->Image($logo , 15 ,11, 55 , 15 , "PNG");  
   }                                      
    }

############################# BLOQUE N° 1 FACTURA ###############################   
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 10, 190, 17, '1.5', '');
    
    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(98, 12, 12, 12, '1.5', 'F');

    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(98, 12, 12, 12, '1.5', '');

    $this->SetFont('courier','B',16);
    $this->SetXY(101, 14);
    $this->Cell(20, 5, 'C', 0 , 0);
    $this->SetFont('courier','B',8);
    $this->SetXY(98, 19);
    $this->Cell(20, 5, 'Cotiz.', 0, 0);
    
    $this->SetFont('courier','B',11);
    $this->SetXY(120, 12);
    $this->Cell(40, 4, 'N° DE COTIZACIÓN ', 0, 0);
    $this->SetFont('courier','B',11);
    $this->SetXY(160, 12);
    $this->CellFitSpace(38, 4,utf8_decode($reg[0]['codfactura']), 0, 0, "R");

    $this->SetFont('courier','B',9);
    $this->SetXY(120, 16);
    $this->Cell(40, 4, 'FECHA DE COTIZACIÓN ', 0, 0);
    $this->SetFont('courier','',9);
    $this->SetXY(160, 16);
    $this->CellFitSpace(38, 4,utf8_decode(date("d-m-Y",strtotime($reg[0]['fechacotizacion']))), 0, 0, "R");

    $this->SetFont('courier','B',9);
    $this->SetXY(120, 20);
    $this->Cell(40, 4, 'FECHA DE EMISIÓN', 0, 0);
    $this->SetFont('courier','',9);
    $this->SetXY(160, 20);
    $this->CellFitSpace(38, 4,utf8_decode(date("d-m-Y H:i:s")), 0, 0, "R");
################################# BLOQUE N° 1 FACTURA ################################ 

############################# BLOQUE N° 2 SUCURSAL ###############################   
   //Bloque de datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 29, 190, 18, '1.5', '');
    //DATOS DE SUCURSAL LINEA 1
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 30);
    $this->Cell(186, 4, 'DATOS DE SUCURSAL ', 0, 0);
    //DATOS DE SUCURSAL LINEA 1

    //DATOS DE SUCURSAL LINEA 2
    $this->SetFont('courier','B',8);
    $this->SetXY(12, 34);
    $this->Cell(24, 4, 'RAZÓN SOCIAL:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(36, 34);
    $this->CellFitSpace(66, 4,utf8_decode($reg[0]['nomsucursal']), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(102, 34);
    $this->CellFitSpace(22, 4, 'Nº DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : $reg[0]['documento'].":"), 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(124, 34);
    $this->CellFitSpace(28, 4,utf8_decode($reg[0]['cuitsucursal']), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(152, 34);
    $this->Cell(18, 4, 'N° DE TLF:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(170, 34);
    $this->Cell(28, 4,utf8_decode($reg[0]['tlfsucursal']), 0, 0);
    //DATOS DE SUCURSAL LINEA 2

    //DATOS DE SUCURSAL LINEA 3
    $this->SetFont('courier','B',8);
    $this->SetXY(12, 38);
    $this->Cell(24, 4, 'DIRECCIÓN:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(36, 38);
    $this->CellFitSpace(96, 4,utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "*********" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['departamento'] == '' ? "*********" : $reg[0]['departamento'])." ".$reg[0]['direcsucursal']), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(132, 38);
    $this->Cell(12, 4, 'EMAIL:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(144, 38);
    $this->Cell(54, 4,utf8_decode($reg[0]['correosucursal']), 0, 0);
    //DATOS DE SUCURSAL LINEA 3

    //DATOS DE SUCURSAL LINEA 4
    $this->SetFont('courier','B',8);
    $this->SetXY(12, 42);
    $this->Cell(24, 4, 'RESPONSABLE:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(36, 42);
    $this->CellFitSpace(66, 4,utf8_decode($reg[0]['nomencargado']), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(102, 42);
    $this->CellFitSpace(22, 4, 'Nº DE '.$documento = ($reg[0]['documencargado'] == '0' ? "DOC.:" : $reg[0]['documento2'].":"), 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(124, 42);
    $this->CellFitSpace(28, 4,utf8_decode($reg[0]['dniencargado']), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(152, 42);
    $this->Cell(18, 4, 'N° DE TLF:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(170, 42);
    $this->Cell(28, 4,utf8_decode($tlf = ($reg[0]['tlfencargado'] == '' ? "*********" : $reg[0]['tlfencargado'])), 0, 0);
    //DATOS DE SUCURSAL LINEA 4
############################ BLOQUE N° 2 SUCURSAL ###############################   


############################## BLOQUE N° 3 CLIENTE #################################  
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 49, 190, 14, '1.5', '');

    $this->SetFont('courier','B',9);
    $this->SetXY(12, 50);
    $this->Cell(186, 4, 'DATOS DE CLIENTE ', 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(12, 54);
    $this->Cell(20, 4, 'NOMBRES:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(32, 54);
    $this->CellFitSpace(58, 4,utf8_decode($nombre = ($reg[0]['nomcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente'])), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(90, 54);
    $this->CellFitSpace(20, 4, 'Nº DE '.$documento = ($reg[0]['documcliente'] == '0' ? "DOC.:" : $reg[0]['documento3'].":"), 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(110, 54);
    $this->CellFitSpace(24, 4,utf8_decode($nombre = ($reg[0]['dnicliente'] == '' ? "*********" : $reg[0]['dnicliente'])), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(134, 54);
    $this->Cell(12, 4, 'EMAIL:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(146, 54);
    $this->CellFitSpace(52, 4,utf8_decode($email = ($reg[0]['emailcliente'] == '' ? "*********" : $reg[0]['emailcliente'])), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(12, 58);
    $this->Cell(20, 4, 'DIRECCIÓN:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(32, 58);
    $this->CellFitSpace(124, 4,getSubString(utf8_decode($provincia = ($reg[0]['provincia2'] == '' ? "*********" : $reg[0]['provincia2'])." ".$departamento = ($reg[0]['departamento2'] == '' ? "*********" : $reg[0]['departamento2'])." ".$reg[0]['direccliente']), 70), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(156, 58);
    $this->Cell(20, 4, 'N° DE TLF:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(176, 58);
    $this->CellFitSpace(22, 4,utf8_decode($tlf = ($reg[0]['tlfcliente'] == '' ? "*********" : $reg[0]['tlfcliente'])), 0, 0); 
############################## BLOQUE N° 3 CLIENTE #################################  

################################# BLOQUE N° 4 #######################################   
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 72, 190, 176, '0', '');

    $this->SetFont('courier','B',9);
    $this->SetXY(10, 65);
    $this->SetTextColor(3,3,3);
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->Cell(8, 8,"Nº", 1, 0, 'C', True);
    $this->Cell(50, 8,"DESCRIPCIÓN DE PRODUCTO", 1, 0, 'C', True);
    $this->Cell(20, 8,"MARCA", 1, 0, 'C', True);
    $this->Cell(15, 8,"MODELO", 1, 0, 'C', True);
    $this->Cell(10, 8,"CANT", 1, 0, 'C', True);
    $this->Cell(20, 8,"P/UNIT", 1, 0, 'C', True);
    $this->Cell(20, 8,"V/TOTAL", 1, 0, 'C', True);
    $this->Cell(15, 8,"DESC %", 1, 0, 'C', True);
    $this->Cell(12, 8,$impuesto, 1, 0, 'C', True);
    $this->Cell(20, 8,"V/NETO", 1, 1, 'C', True);
################################# BLOQUE N° 4 #######################################  

################################# BLOQUE N° 5 ####################################### 
    $tra = new Login();
    $detalle = $tra->VerDetallesCotizaciones();
    $cantidad = 0;
    $SubTotal = 0;

     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(8,49,20,15,10,20,20,15,12,19));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $cantidad += $detalle[$i]['cantcotizacion'];
    $valortotal = $detalle[$i]["precioventa"]*$detalle[$i]["cantcotizacion"];
    $SubTotal += $detalle[$i]['valorneto'];

    $this->SetX(11);
    $this->SetFont('Courier','',7);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->SetFillColor(255, 255, 255); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->RowFacture2(array($a++,
        portales(utf8_decode($detalle[$i]["producto"])),
        utf8_decode($detalle[$i]["codmarca"] == '0' ? "******" : $detalle[$i]["nommarca"]),
        utf8_decode($detalle[$i]["codmodelo"] == '0' ? "******" : $detalle[$i]["nommodelo"]),
        utf8_decode($detalle[$i]["cantcotizacion"]),
        utf8_decode($simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ',')),
        utf8_decode(number_format($detalle[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($detalle[$i]["ivaproducto"]),
        utf8_decode($simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','))));
  }
################################# BLOQUE N° 5 #######################################  

########################### BLOQUE N° 6 #############################    
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 250, 110, 26, '1.5', '');

    $this->SetFont('courier','B',12);
    $this->SetXY(36, 250);
    $this->Cell(20, 5, 'INFORMACIÓN ADICIONAL', 0 , 0);
    
    $this->SetFont('courier','B',8);
    $this->SetXY(11, 254);
    $this->Cell(20, 5, 'CANTIDAD DE PRODUCTOS:', 0 , 0);
    $this->SetXY(56, 254);
    $this->SetFont('courier','',8);
    $this->Cell(20, 5,utf8_decode($cantidad), 0 , 0);
    
    $this->SetFont('courier','B',8);
    $this->SetXY(11, 258);
    $this->Cell(20, 5, 'TIPO DE DOCUMENTO:', 0 , 0);
    $this->SetXY(56, 258);
    $this->SetFont('courier','',8);
    $this->Cell(20, 5,"COTIZACIÓN", 0 , 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(11, 263);
    $this->MultiCell(106,2.5,$this->SetFont('Courier','',7).utf8_decode(numtoletras(number_format($reg[0]['totalpago'], 2, '.', ''))),0,'J');

    //Linea de membrete Nro 5
    $this->SetFont('courier','B',7);
    $this->SetXY(11, 266);
    $this->MultiCell(106,3,$this->SetFont('Courier','',7).utf8_decode($reg[0]["observaciones"]=="" ? "" : "OBSERVACIONES: ".$reg[0]["observaciones"]), 0,'J');
########################### BLOQUE N° 6 ############################# 

################################# BLOQUE N° 7 #######################################  
    //Bloque de Totales de factura
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(122, 250, 78, 26, '1.5', '');

    //Linea de membrete Nro 1
    $this->SetFont('courier','B',9);
    $this->SetXY(124, 249.5);
    $this->CellFitSpace(36, 5, 'SUBTOTAL:', 0, 0);
    $this->SetXY(160, 249.5);
    $this->SetFont('courier','',9);
    $this->CellFitSpace(40, 5,utf8_decode($simbolo.number_format($SubTotal, 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',9);
    $this->SetXY(124, 252.5);
    $this->CellFitSpace(36, 5, 'TOTAL GRAVADO ('.number_format($reg[0]["iva"], 2, '.', ',').'%):', 0, 0);
    $this->SetXY(160, 252.5);
    $this->SetFont('courier','',9);
    $this->CellFitSpace(40, 5,utf8_decode($simbolo.number_format($reg[0]["subtotalivasi"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 3
    $this->SetFont('courier','B',9);
    $this->SetXY(124, 255.5);
    $this->CellFitSpace(36, 5, 'TOTAL EXENTO (0%):', 0, 0);
    $this->SetXY(160, 255.5);
    $this->SetFont('courier','',9);
    $this->CellFitSpace(40, 5,utf8_decode($simbolo.number_format($reg[0]["subtotalivano"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 4
    $this->SetFont('courier','B',9);
    $this->SetXY(124, 258.5);
    $this->CellFitSpace(36, 5, $impuesto == '' ? "TOTAL IMP." : "TOTAL ".$impuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):", 0, 0);
    $this->SetXY(160, 258.5);
    $this->SetFont('courier','',9);
    $this->CellFitSpace(40, 5,utf8_decode($simbolo.number_format($reg[0]["totaliva"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 3
    $this->SetFont('courier','B',9);
    $this->SetXY(124, 261.5);
    $this->CellFitSpace(36, 5, 'DESCONTADO %:', 0, 0);
    $this->SetXY(160, 261.5);
    $this->SetFont('courier','',9);
    $this->CellFitSpace(40, 5,utf8_decode($simbolo.number_format($reg[0]["descontado"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 5
    $this->SetFont('courier','B',9);
    $this->SetXY(124, 264.5);
    $this->CellFitSpace(36, 5, "DESC. GLOBAL (".number_format($reg[0]["descuento"], 2, '.', ',').'%):', 0, 0);
    $this->SetXY(160, 264.5);
    $this->SetFont('courier','',9);
    $this->CellFitSpace(40, 5,utf8_decode($simbolo.number_format($reg[0]["totaldescuento"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 6
    $this->SetFont('courier','B',9);
    $this->SetXY(124, 267.5);
    $this->CellFitSpace(36, 5, 'IMPORTE TOTAL:', 0, 0);
    $this->SetXY(160, 267.5);
    $this->SetFont('courier','',9);
    $this->CellFitSpace(40, 5,utf8_decode($simbolo.number_format($reg[0]["totalpago"], 2, '.', ',')), 0, 0, "R");
################################# BLOQUE N° 7 ####################################### 
}
########################## FUNCION FACTURA COTIZACION ##############################

########################## FUNCION LISTAR COTIZACIONES ##############################
function TablaListarCotizaciones()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);
    
    $tra = new Login();
    $reg = $tra->ListarCotizaciones();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId();

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO GENERAL DE COTIZACIONES',0,0,'C');
    
if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(45,8,'SUCURSAL',1,0,'C', True);
    $this->Cell(40,8,'Nº DE COTIZACIÓN',1,0,'C', True);
    $this->Cell(55,8,'DESCRIPCIÓN DE CLIENTE',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(25,8,'Nº ARTIC.',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(25,8,$impuesto,1,0,'C', True);
    $this->Cell(25,8,'DESC %',1,0,'C', True);
    $this->Cell(35,8,'IMPORTE TOTAL',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,45,40,55,30,25,35,25,25,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalImpuesto=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalImpuesto+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["nomsucursal"]),utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechacotizacion']))),utf8_decode($reg[$i]["articulos"]),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
   }
   
    $this->Cell(185,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalImpuesto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
 }

    } else {

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(40,8,'Nº DE COTIZACIÓN',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCIÓN DE CLIENTE',1,0,'C', True);
    $this->Cell(50,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(25,8,'Nº ARTIC.',1,0,'C', True);
    $this->Cell(40,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(30,8,$impuesto,1,0,'C', True);
    $this->Cell(30,8,'DESC %',1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,40,60,50,25,40,30,30,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalImpuesto=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalImpuesto+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechacotizacion']))),utf8_decode($reg[$i]["articulos"]),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
   }
   
    $this->Cell(165,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalImpuesto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
 }
    }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COTIZACIONES ##############################

####################### FUNCION LISTAR COTIZACIONES POR FECHAS ########################
function TablaListarCotizacionesxFechas()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);
    
    $tra = new Login();
    $reg = $tra->BuscarCotizacionesxFechas();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId();

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO DE COTIZACIONES POR FECHAS',0,0,'C');
    
    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L'); 

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(40,8,'Nº DE COTIZACIÓN',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCIÓN DE CLIENTE',1,0,'C', True);
    $this->Cell(50,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(25,8,'Nº ARTIC.',1,0,'C', True);
    $this->Cell(40,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(30,8,$impuesto,1,0,'C', True);
    $this->Cell(30,8,'DESC %',1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,40,60,50,25,40,30,30,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalImpuesto=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalImpuesto+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechacotizacion']))),utf8_decode($reg[$i]["articulos"]),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
       }
   }
   
    $this->Cell(165,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalImpuesto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COTIZACIONES POR FECHAS ######################

####################### FUNCION LISTAR DETALLES COTIZACIONES POR FECHAS ###########################
function TablaListarDetallesCotizacionesxFechas()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarDetallesCotizacionesxFechas(); 

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId();

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################

    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO DE DETALLES COTIZACIONES POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(330,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(330,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(330,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');
  

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'TIPO',1,0,'C', True);
    $this->Cell(90,8,'DESCRIPCIÓN DE PRODUCTO',1,0,'C', True);
    $this->Cell(30,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'DCTO %',1,0,'C', True);
    $this->Cell(30,8,"PRECIO VENTA",1,0,'C', True);
    $this->Cell(30,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(25,8,'COTIZADO',1,0,'C', True);
    $this->Cell(30,8,'MONTO TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,30,90,30,30,20,30,30,25,30));

    $PrecioTotal=0;
    $ExisteTotal=0;
    $VendidosTotal=0;
    $PagoTotal=0;
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    $PrecioTotal+=$reg[$i]['precioventa'];
    $ExisteTotal+=$reg[$i]['tipodetalle'] == '1' ? $reg[$i]['existencia'] : "0";
    $VendidosTotal+=$reg[$i]['cantidad']; 

    $Descuento = $reg[$i]['descproducto']/100;
    $PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
    $PagoTotal+=$PrecioFinal*$reg[$i]['cantidad'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($reg[$i]['tipodetalle'] == 1 ? "PRODUCTO" : "SERVICIO"),
        portales(utf8_decode($reg[$i]["producto"])),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "*****" : $reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]["precioventa"], 2, '.', ',')),
        utf8_decode($reg[$i]['tipodetalle'] == '1' ? $reg[$i]['existencia'] : "******"),
        utf8_decode($reg[$i]['cantidad']),
        utf8_decode($simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','))));
  }
   }
   
    $this->Cell(215,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PrecioTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($ExisteTotal),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($VendidosTotal),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PagoTotal, 2, '.', ',')),0,0,'L');
    $this->Ln();
   

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
###################### FUNCION LISTAR DETALLES COTIZACIONES POR FECHAS ##########################

####################### FUNCION LISTAR PRODUCTOS COTIZADOS POR VENDEDOR ###########################
function TablaListarDetallesCotizacionesxVendedor()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarDetallesCotizacionesxVendedor(); 

     ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId();

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO DE DETALLES COTIZACIONES POR VENDEDOR',0,0,'C');
    
    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(330,6,"VENDEDOR: ".portales(utf8_decode($reg[0]['nombres'])),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'TIPO',1,0,'C', True);
    $this->Cell(90,8,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(30,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'DCTO %',1,0,'C', True);
    $this->Cell(30,8,"PRECIO VENTA",1,0,'C', True);
    $this->Cell(30,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(25,8,'COTIZADO',1,0,'C', True);
    $this->Cell(30,8,'MONTO TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,30,90,30,30,20,30,30,25,30));

    $PrecioTotal=0;
    $ExisteTotal=0;
    $VendidosTotal=0;
    $PagoTotal=0;
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    $PrecioTotal+=$reg[$i]['precioventa'];
    $ExisteTotal+=$reg[$i]['tipodetalle'] == '1' ? $reg[$i]['existencia'] : "0";
    $VendidosTotal+=$reg[$i]['cantidad']; 

    $Descuento = $reg[$i]['descproducto']/100;
    $PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
    $PagoTotal+=$PrecioFinal*$reg[$i]['cantidad'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($reg[$i]['tipodetalle'] == 1 ? "PRODUCTO" : "SERVICIO"),
        portales(utf8_decode($reg[$i]["producto"])),
        utf8_decode($reg[$i]["codmarca"] == '0' ? "*****" : $reg[$i]['nommarca']),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]["precioventa"], 2, '.', ',')),
        utf8_decode($reg[$i]['tipodetalle'] == '1' ? $reg[$i]['existencia'] : "******"),
        utf8_decode($reg[$i]['cantidad']),
        utf8_decode($simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','))));
  }
   }
   
    $this->Cell(215,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PrecioTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($ExisteTotal),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($VendidosTotal),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PagoTotal, 2, '.', ',')),0,0,'L');
    $this->Ln();
   

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
###################### FUNCION LISTAR PRODUCTOS COTIZADOS POR VENDEDOR ##########################

########################### REPORTES DE COTIZACIONES ############################












































############################### REPORTES DE PREVENTAS #############################

########################## FUNCION TICKET PREVENTA ##############################
function TicketPreventa()
{       
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    
    $tra = new Login();
    $reg = $tra->PreventasPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

    $logo = "./fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
    $this->Image($logo , 20, 3, 35, 15, "PNG");
    $this->Ln(8);

    }
  
    $this->SetX(4);
    $this->SetFont('Courier','B',12);
    $this->SetFillColor(2,157,116);
    $this->Cell(66, 5, "TICKET DE PREVENTA", 0, 0, 'C');
    $this->Ln(5);
  
    $this->SetX(4);
    $this->SetFont('Courier','B',10);
    $this->CellFitSpace(66,4,utf8_decode($reg[0]['nomsucursal']), 0, 1, 'C');

    $this->SetX(4);
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(66,3,$reg[0]['documsucursal'] == '0' ? "" : "Nº ".$reg[0]['documento']." ".utf8_decode($reg[0]['cuitsucursal']),0,1,'C');

    if($reg[0]['id_provincia']!='0'){

    $this->SetX(4);
    $this->CellFitSpace(66,3,utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['departamento'] == '' ? "" : $reg[0]['departamento'])),0,1,'C');

    }

    $this->SetX(4);
    $this->CellFitSpace(66,3,utf8_decode($reg[0]['direcsucursal']),0,1,'C');

    $this->SetX(4);
    $this->CellFitSpace(66,3,"OBLIGADO A LLEVAR CONTABILIDAD: ".utf8_decode($reg[0]['llevacontabilidad']),0,1,'C');
    
    $this->SetX(4);
    $this->CellFitSpace(66,3,"Nº DE TICKET: ".utf8_decode($reg[0]['codfactura']),0,1,'C');
    
    $this->SetX(4);
    $this->CellFitSpace(66,3,"AMBIENTE: PRODUCCIÓN",0,1,'C');
    
    $this->SetX(4);
    $this->CellFitSpace(66,3,"EMISIÓN: NORMAL",0,1,'C');

    $this->SetX(2);
    $this->SetFont('Courier','B',12);
    $this->Cell(70,3,'--------------------------',0,0,'C');
    $this->Ln(3);
    
    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(16,3,"VENDEDOR:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,utf8_decode($reg[0]['nombres']),0,1,'L');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(26,3,"FECHA PREVENTA:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(40,3,date("d-m-Y H:i:s",strtotime($reg[0]['fechapreventa'])),0,1,'L');
    
    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(26,3,"FECHA EMISIÓN:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(40,3,date("d-m-Y H:i:s"),0,1,'L');

    $this->SetFont('Courier','B',12);
    $this->SetX(2);
    $this->Cell(70,3,'--------------------------',0,0,'C');
    $this->Ln(3);

    if($reg[0]['nomcliente']==""){

    $this->SetFont('Courier','',8);
    $this->SetX(4);
    $this->CellFitSpace(66, 3, "CONSUMIDOR FINAL",0,1,'C');

    } else {

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(15,3,$documento = ($reg[0]['documcliente'] == '0' ? "Nº DOC:" : "Nº ".$reg[0]['documento'].": "),0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(51,3,utf8_decode($reg[0]['dnicliente']),0,1,'L');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(15,3,"SEÑOR(A):",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->MultiCell(51,3,$this->SetFont('Courier','B',8).utf8_decode($reg[0]['nomcliente']),0,'L');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(15,3,"DIREC:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->MultiCell(51,3,$this->SetFont('Courier','B',8).portales(utf8_decode(getSubString($reg[0]['direccliente'],32))),0,'L');
        
    }

    $this->SetX(2);
    $this->SetFont('Courier','B',12);
    $this->Cell(70,3,'--------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->SetTextColor(3, 3, 3); // Establece el color del texto (en este caso es Negro)
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->Cell(10,3,'CANT',0,0,'L');
    $this->Cell(56,3,'DESCRIPCIÓN DE PRODUCTO',0,1,'C');

    $this->SetX(4);
    $this->Cell(22,3,'PVP.',0,0,'C');
    $this->Cell(22,3,'DCTO.',0,0,'C');
    $this->Cell(22,3,'TOTAL IMPORTE',0,1,'C');

    $this->SetX(2);
    $this->SetFont('Courier','B',12);
    $this->Cell(70,3,'--------------------------',0,0,'C');
    $this->Ln(3);

    $tra = new Login();
    $detalle = $tra->VerDetallesPreventas();
    $cantidad = 0;
    $SubTotal = 0;
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){
    $SubTotal += $detalle[$i]['valorneto'];

    $this->SetX(4);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->CellFitSpace(10,3,utf8_decode($detalle[$i]['cantpreventa']),0,0,'C');
    $this->CellFitSpace(56,3,portales(utf8_decode(getSubString($detalle[$i]["producto"], 25))),0,1,'C');
    $this->SetX(4);
    $this->CellFitSpace(24,3,utf8_decode($simbolo.number_format($detalle[$i]["precioventa"], 2, '.', ',')),0,0,'C');
    $this->CellFitSpace(18,3,utf8_decode(number_format($detalle[$i]["descproducto"], 2, '.', ',')),0,0,'C');
    $this->CellFitSpace(24,3,utf8_decode($simbolo.number_format($detalle[$i]["valorneto"], 2, '.', ',')),0,0,'C');
    $this->Ln();  
    }

    $this->SetX(2);
    $this->SetFont('Courier','B',12);
    $this->Cell(70,3,'--------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(36,3,"SUBTOTAL:",0,0,'R');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(30,3,utf8_decode($simbolo.number_format($SubTotal, 2, '.', ',')),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(36,3,"GRAVADO (".number_format($reg[0]["iva"], 2, '.', ',')."%):",0,0,'R');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(30,3,utf8_decode($simbolo.number_format($reg[0]["subtotalivasi"], 2, '.', ',')),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(36,3,"EXENTO (0%):",0,0,'R');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(30,3,utf8_decode($simbolo.number_format($reg[0]["subtotalivano"], 2, '.', ',')),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(36,3,$impuesto == '' ? "TOTAL IMP." : "TOTAL ".$impuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):",0,0,'R');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(30,3,utf8_decode($simbolo.number_format($reg[0]["totaliva"], 2, '.', ',')),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(36,3,"DESCONTADO %:",0,0,'R');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(30,3,utf8_decode($simbolo.number_format($reg[0]["descontado"], 2, '.', ',')),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(36,3,"DESC % (".number_format($reg[0]["descuento"], 2, '.', ',')."%):",0,0,'R');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(30,3,utf8_decode($simbolo.number_format($reg[0]["totaldescuento"], 2, '.', ',')),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(36,3,"IMPORTE TOTAL:",0,0,'R');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(30,3,utf8_decode($simbolo.number_format($reg[0]["totalpago"], 2, '.', ',')),0,1,'R');

    if($reg[0]['observaciones']!=""){
    ########################### BLOQUE N° 6 #############################
    $this->SetX(2);
    $this->SetFont('Courier','B',12);
    $this->Cell(70,0.5,'--------------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(70,0.5,'--------------------------',0,1,'C'); 
    $this->Ln(2);  
    $this->SetX(4);
    $this->SetFont('courier','B',7);
    $this->MultiCell(70,3,"OBSERVACIONES: ".utf8_decode($reg[0]['observaciones'] == '' ? "" : $reg[0]['observaciones']),0,1,'');
    $this->Ln(4);
    ########################### BLOQUE N° 6 #############################    
    }

    $this->SetX(2);
    $this->SetFont('Courier','B',12);
    $this->Cell(70,0.5,'--------------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(70,0.5,'--------------------------',0,1,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','BI',10);
    $this->SetFillColor(3, 3, 3);
    $this->CellFitSpace(70,3,"GRACIAS POR SU COMPRA",0,1,'C');
    $this->Ln(3);
}
########################## FUNCION TICKET PREVENTA ##############################

########################## FUNCION LISTAR PREVENTAS ##############################
function TablaListarPreventas()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->ListarPreventas();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO GENERAL DE PREVENTAS',0,0,'C');

    
if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(45,8,'SUCURSAL',1,0,'C', True);
    $this->Cell(40,8,'Nº DE PREVENTA',1,0,'C', True);
    $this->Cell(55,8,'DESCRIPCIÓN DE CLIENTE',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(25,8,'Nº ARTIC.',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(25,8,$impuesto,1,0,'C', True);
    $this->Cell(25,8,'DESC %',1,0,'C', True);
    $this->Cell(35,8,'IMPORTE TOTAL',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,45,40,55,30,25,35,25,25,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalImpuesto=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalImpuesto+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["nomsucursal"]),utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechapreventa']))),utf8_decode($reg[$i]["articulos"]),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
   }
   
    $this->Cell(185,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalImpuesto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
 }

    } else {

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(40,8,'Nº DE PREVENTA',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCIÓN DE CLIENTE',1,0,'C', True);
    $this->Cell(50,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(25,8,'Nº ARTIC.',1,0,'C', True);
    $this->Cell(40,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(30,8,$impuesto,1,0,'C', True);
    $this->Cell(30,8,'DESC %',1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,40,60,50,25,40,30,30,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalImpuesto=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalImpuesto+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechapreventa']))),utf8_decode($reg[$i]["articulos"]),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
   }
   
    $this->Cell(165,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalImpuesto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
 }
    }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PREVENTAS ##############################

########################## FUNCION LISTAR CLIENTES EN PREVENTAS ##############################
function ClientesxPreventas()
{
    
    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,14,'LISTADO DE CLIENTES CON PREVENTAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(40,8,'SUCURSAL',1,0,'C', True);
    $this->Cell(40,8,'Nº FACTURA',1,0,'C', True);
    $this->Cell(40,8,'Nº DOCUMENTO',1,0,'C', True);
    $this->Cell(60,8,'NOMBRE DE CLIENTE',1,0,'C', True);
    $this->Cell(100,8,'DIRECCIÓN',1,0,'C', True);
    $this->Cell(40,8,'TELEFONO',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarClientesxPreventas();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,40,40,40,60,100,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,portales(utf8_decode($reg[$i]["nomsucursal"])),utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]["documento"]." ".$reg[$i]["dnicliente"]),portales(utf8_decode($reg[$i]["nomcliente"])),
        utf8_decode($provincia = ($reg[$i]['provincia2'] == '' ? "" : $reg[$i]['provincia2'])." ".$departamento = ($reg[$i]['departamento2'] == '' ? "" : $reg[$i]['departamento2'])." ".$reg[$i]['direccliente']),utf8_decode($reg[$i]["tlfcliente"])));
    }
 }
    } else {

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(40,8,'Nº FACTURA',1,0,'C', True);
    $this->Cell(40,8,'Nº DOCUMENTO',1,0,'C', True);
    $this->Cell(70,8,'NOMBRE DE CLIENTE',1,0,'C', True);
    $this->Cell(130,8,'DIRECCIÓN',1,0,'C', True);
    $this->Cell(40,8,'TELEFONO',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarClientesxPreventas();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,40,40,70,130,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]["documento"]." ".$reg[$i]["dnicliente"]),portales(utf8_decode($reg[$i]["nomcliente"])),
        utf8_decode($provincia = ($reg[$i]['provincia2'] == '' ? "" : $reg[$i]['provincia2'])." ".$departamento = ($reg[$i]['departamento2'] == '' ? "" : $reg[$i]['departamento2'])." ".$reg[$i]['direccliente']),utf8_decode($reg[$i]["tlfcliente"])));
    }
      }
    }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CLIENTES EN PREVENTAS ##############################

####################### FUNCION LISTAR PREVENTAS POR FECHAS ########################
function TablaListarPreventasxFechas()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarPreventasxFechas();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO DE PREVENTAS POR FECHAS',0,0,'C'); 
   
   if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(330,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(330,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(330,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(40,8,'Nº DE PREVENTA',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCIÓN DE CLIENTE',1,0,'C', True);
    $this->Cell(50,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(25,8,'Nº ARTIC.',1,0,'C', True);
    $this->Cell(40,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(30,8,$impuesto,1,0,'C', True);
    $this->Cell(30,8,'DESC %',1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,40,60,50,25,40,30,30,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalImpuesto=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalImpuesto+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechapreventa']))),utf8_decode($reg[$i]["articulos"]),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
      }
   }
   
    $this->Cell(165,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalImpuesto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PREVENTAS POR FECHAS ######################

####################### FUNCION LISTAR DETALLES DE PREVENTAS POR FECHAS ###########################
function TablaListarDetallesPreventasxFechas()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarDetallesPreventasxFechas(); 

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO DE DETALLES PREVENTAS POR FECHAS',0,0,'C'); 
   
   if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(330,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(330,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(330,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'TIPO',1,0,'C', True);
    $this->Cell(90,8,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(30,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'DESC',1,0,'C', True);
    $this->Cell(30,8,"PRECIO VENTA",1,0,'C', True);
    $this->Cell(30,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(25,8,'PREVENTA',1,0,'C', True);
    $this->Cell(30,8,'MONTO TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,30,90,30,30,20,30,30,25,30));

    $PrecioTotal=0;
    $ExisteTotal=0;
    $VendidosTotal=0;
    $PagoTotal=0;
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    $PrecioTotal+=$reg[$i]['precioventa'];
    $ExisteTotal+=$reg[$i]['tipodetalle'] == '1' ? $reg[$i]['existencia'] : "0";
    $VendidosTotal+=$reg[$i]['cantidad']; 

    $Descuento = $reg[$i]['descproducto']/100;
    $PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
    $PagoTotal+=$PrecioFinal*$reg[$i]['cantidad'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($reg[$i]['tipodetalle'] == 1 ? "PRODUCTO" : "SERVICIO"),
        portales(utf8_decode($reg[$i]["producto"])),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "*****" : $reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]["precioventa"], 2, '.', ',')),
        utf8_decode($reg[$i]['tipodetalle'] == '1' ? $reg[$i]['existencia'] : "******"),
        utf8_decode($reg[$i]['cantidad']),
        utf8_decode($simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','))));
  }
   }
   
    $this->Cell(215,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PrecioTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($ExisteTotal),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($VendidosTotal),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PagoTotal, 2, '.', ',')),0,0,'L');
    $this->Ln();
   

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4); 
}
###################### FUNCION LISTAR DETALLES DE PREVENTAS POR FECHAS ##########################

####################### FUNCION LISTAR DETALLES DE PREVENTAS POR VENDEDOR ###########################
function TablaListarDetallesPreventasxVendedor()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarDetallesPreventasxVendedor(); 

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO DE DETALLES PREVENTAS POR VENDEDOR',0,0,'C'); 
   
   if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(330,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(330,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(330,6,"VENDEDOR: ".portales(utf8_decode($reg[0]['nombres'])),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');    

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'TIPO',1,0,'C', True);
    $this->Cell(90,8,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(30,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'DESC',1,0,'C', True);
    $this->Cell(30,8,"PRECIO VENTA",1,0,'C', True);
    $this->Cell(30,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(25,8,'PREVENTA',1,0,'C', True);
    $this->Cell(30,8,'MONTO TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,30,90,30,30,20,30,30,25,30));

    $PrecioTotal=0;
    $ExisteTotal=0;
    $VendidosTotal=0;
    $PagoTotal=0;
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    $PrecioTotal+=$reg[$i]['precioventa'];
    $ExisteTotal+=$reg[$i]['tipodetalle'] == '1' ? $reg[$i]['existencia'] : "0";
    $VendidosTotal+=$reg[$i]['cantidad']; 

    $Descuento = $reg[$i]['descproducto']/100;
    $PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
    $PagoTotal+=$PrecioFinal*$reg[$i]['cantidad'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($reg[$i]['tipodetalle'] == 1 ? "PRODUCTO" : "SERVICIO"),
        portales(utf8_decode($reg[$i]["producto"])),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "*****" : $reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]["precioventa"], 2, '.', ',')),
        utf8_decode($reg[$i]['tipodetalle'] == '1' ? $reg[$i]['existencia'] : "******"),
        utf8_decode($reg[$i]['cantidad']),
        utf8_decode($simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','))));
  }
   }
   
    $this->Cell(215,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PrecioTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($ExisteTotal),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($VendidosTotal),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PagoTotal, 2, '.', ',')),0,0,'L');
    $this->Ln();
   

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
###################### FUNCION LISTAR DETALLES DE PREVENTAS POR VENDEDOR ##########################

########################## FUNCION GUIA PREVENTA ##############################
function GuiaPreventaxFechas()
{
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
        
    $tra = new Login();
    $reg = $tra->BuscarProductosPreventas();

    $logo = ( file_exists("./fotos/sucursales/".$reg[0]['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$reg[0]['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($reg[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($reg[0]['documsucursal'] == '0' ? "" : $reg[0]['documento'])." ".utf8_decode($reg[0]['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($reg[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($reg[0]['id_departamento'] == '0' ? "" : $reg[0]['departamento'])." ".$provincia = ($reg[0]['id_provincia'] == '0' ? "" : $reg[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($reg[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($reg[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($reg[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,14,'GUIA DE REMISIÓN',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',9);
    $this->SetTextColor(255,255,255); // Establece el color del texto (en este caso es Negro)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->Cell(10,8,'N°',1,0,'C', True);
    $this->Cell(25,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(25,8,"PRESENTACIÓN", 1, 0, 'C', True);
    $this->Cell(20,8,'MARCA',1,0,'C', True);
    $this->Cell(20,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'CANTIDAD',1,1,'C', True);
    ############################### BLOQUE N° 5 #####################################


    ############################### BLOQUE N° 6 #####################################
    $cantidad = 0;
    $SubTotal = 0;

    $this->SetWidths(array(10,25,70,25,20,20,20));

    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    $cantidad += $reg[$i]['cantidad'];
    $valortotal = $reg[$i]["precioventa"]*$reg[$i]["cantidad"];

    $this->SetX(10);
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->RowFacture(array($a++,
        utf8_decode($reg[$i]["codproducto"]),
        portales(utf8_decode($reg[$i]["producto"])),
        utf8_decode($reg[$i]["nompresentacion"]),
        utf8_decode($reg[$i]["nommarca"]),
        utf8_decode($modelo = ($reg[$i]["codmodelo"] == '' ? "*********" : $reg[$i]["nommodelo"])),
        utf8_decode($reg[$i]["cantidad"])));
  }
    ############################### BLOQUE N° 6 #####################################

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION GUIA PREVENTA ##############################

########################## FUNCION GUIA PREVENTA ##############################
function GuiaPreventaxFechas2()
{
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);

    $con = new Login();
    $con = $con->ConfiguracionPorId();
            
    $tra = new Login();
    $reg = $tra->BuscarProductosPreventas();

    ######################### BLOQUE N° 1 ######################### 
   //Bloque de membrete principal
    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 10, 245, 24, '1.5', '');
    
    //Linea de membrete Nro 1
    $this->SetFont('courier','B',14);
    $this->SetXY(12, 12);
    $this->Cell(20, 5, utf8_decode($reg[0]['nomsucursal']), 0 , 0);
    
    //Linea de membrete Nro 2
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 16);
    $this->Cell(20, 5, 'DIREC. MATRIZ:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(47, 16);
    $this->Cell(20, 5,utf8_decode(utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "*********" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['departamento'] == '' ? "*********" : $reg[0]['departamento'])." ".$reg[0]['direcsucursal'])), 0 , 0);
    
    //Linea de membrete Nro 3
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 20);
    $this->Cell(20, 5, 'DIREC. SUCURSAL:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(52, 20);
    $this->Cell(20, 5,utf8_decode(utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "*********" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['departamento'] == '' ? "*********" : $reg[0]['departamento'])." ".$reg[0]['direcsucursal'])), 0 , 0);
    
    //Linea de membrete Nro 4
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 24);
    $this->Cell(20, 5, 'CONTRIBUYENTE ESPECIAL:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(65, 24);
    $this->Cell(20, 5,utf8_decode($reg[0]['direcsucursal']), 0 , 0);

    //Linea de membrete Nro 4
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 28);
    $this->Cell(20, 5, 'OBLIGADO A LLEVAR CONTABILIDAD:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(82, 28);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);
    ######################### BLOQUE N° 1 ######################### 


    ############################### BLOQUE N° 2 ##################################### 
    //Bloque de datos de chofer
    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 36, 245, 24, '1.5', '');

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 37);
    $this->Cell(20, 5, 'IDENTIF (TRANSPORTISTA):', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(78, 37);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);

  //Linea de membrete Nro 3
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 41);
    $this->Cell(90, 5, 'RAZÓN SOC / NOMBRE Y APELLIDOS:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(78, 41);
    $this->Cell(90, 5,utf8_decode(""), 0 , 0);

    //Linea de membrete Nro 4
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 45);
    $this->Cell(90, 5, 'PLACA:', 0 , 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(78, 45);
    $this->Cell(90, 5,utf8_decode(""), 0 , 0);

     //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(178, 45);
    $this->Cell(20, 5, 'N° DE BULTOS :', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(210, 45);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);

      //Linea de membrete Nro 5
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 49);
    $this->Cell(20, 5, 'PUNTO DE PARTIDA:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(78, 49);
    $this->Cell(20, 5,utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "*********" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['departamento'] == '' ? "*********" : $reg[0]['departamento'])." ".$reg[0]['direcsucursal']), 0 , 0);

    //Linea de membrete Nro 6
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 53);
    $this->Cell(20, 5, 'FECHA INICIO TRANSPORTE:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(78, 53);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);

    //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(178, 53);
    $this->Cell(20, 5, 'FECHA FIN TRANSPORTE:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(220, 53);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);
    ############################### BLOQUE N° 2 ##################################### 


    ############################### BLOQUE N° 3 ##################################### 
    //Bloque de datos de factura
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 62, 245, 27, '1.5', '');

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 63);
    $this->Cell(20, 5, 'COMPROBANTE DE VENTA:', 0 , 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(78, 63);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);

    //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(178, 63);
    $this->Cell(20, 5, 'FECHA EMISIÓN :', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(210, 63);
    $this->Cell(20, 5,utf8_decode(date("d-m-Y")), 0 , 0);

    //Linea de membrete Nro 3
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 67);
    $this->Cell(70, 5, 'NÚMERO DE AUTORIZACIÓN:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(78, 67);
    $this->Cell(75, 5,utf8_decode(""), 0 , 0);

    //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(178, 67);
    $this->Cell(20, 5, 'RUTA:', 0 , 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(192, 67);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);

    //Linea de membrete Nro 4
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 71);
    $this->Cell(90, 5, 'MOTIVO DE TRASLADO:', 0 , 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(78, 71);
    $this->Cell(90, 5,utf8_decode(""), 0 , 0);

    //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(178, 71);
    $this->Cell(20, 5, 'CIUDAD:', 0 , 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(192, 71);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);

    //Linea de membrete Nro 5
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 75);
    $this->Cell(20, 5, 'RAZÓN SOC / NOMBRE Y APELLIDOS:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(78, 75);
    $this->Cell(20, 5,utf8_decode($reg[0]['nomencargado']), 0 , 0);

    //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(178, 75);
    $this->Cell(20, 5, 'IDENTIF. (DESTINATARIO):', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(227, 75);
    $this->Cell(20, 5,utf8_decode($reg[0]['dniencargado']), 0 , 0);

    //Linea de membrete Nro 6
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 79);
    $this->Cell(20, 5, 'ESTABLECIMIENTO:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(78, 79);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);

   //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 83);
    $this->Cell(20, 5, 'DESTINO (PUNTO DE LLEGADA):', 0 , 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(78, 83);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);
    
    ############################### BLOQUE N° 3 #####################################


    ############################### BLOQUE N° 4 ##################################### 
    //Bloque de membrete principal
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(257, 10, 88, 79, '1.5', '');
    
    //Linea de membrete Nro 2
    $this->SetFont('courier','B',14);
    $this->SetXY(258, 16);
    $this->Cell(20, 5, 'Nº DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : $reg[0]['documento'].":"), 0 , 0);
    $this->SetFont('courier','',14);
    $this->SetXY(295, 16);
    $this->Cell(20, 5,utf8_decode($reg[0]['cuitsucursal']), 0 , 0);

    //Linea de membrete Nro 1
    $this->SetFont('courier','B',18);
    $this->SetXY(258, 28);
    $this->Cell(20, 5,"GUIA DE REMISIÓN", 0 , 0);
    
    //Linea de membrete Nro 2
    $this->SetFont('courier','B',14);
    $this->SetXY(258, 38);
    $this->Cell(20, 5, 'N°:', 0 , 0);
    $this->SetFont('courier','B',14);
    $this->SetXY(268, 38);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',14);
    $this->SetXY(258, 48);
    $this->Cell(20, 5, 'AMBIENTE:', 0 , 0);
    $this->SetFont('courier','B',14);
    $this->SetXY(286, 48);
    $this->Cell(20, 5,"PRODUCCIÓN", 0 , 0);

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',14);
    $this->SetXY(258, 54);
    $this->Cell(20, 5, 'EMISIÓN:', 0 , 0);
    $this->SetFont('courier','B',14);
    $this->SetXY(286, 54);
    $this->Cell(20, 5,utf8_decode("NORMAL"), 0 , 0);

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',14);
    $this->SetXY(258, 66);
    $this->Cell(20, 5, 'CLAVE ACCESO - N° DE AUTORIZ:', 0 , 0);

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',14);
    $this->SetXY(258, 76);
    $this->Codabar(260,75,utf8_decode(""));
    $this->Ln(10);
    ############################### BLOQUE N° 4 ##################################### 


    ############################### BLOQUE N° 5 ##################################### 
    //Bloque Cuadro de Detalles de Productos
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 92, 335, 110, '0', '');

    $this->Ln(6);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3, 3, 3); // Establece el color del texto (en este caso es Negro)
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->Cell(10,8,'N°',1,0,'C', True);
    $this->Cell(40,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(130,8,'DESCRIPCIÓN DE PRODUCTO',1,0,'C', True);
    $this->Cell(45, 8,"PRESENTACIÓN", 1, 0, 'C', True);
    $this->Cell(45,8,'MARCA',1,0,'C', True);
    $this->Cell(45,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'CANTIDAD',1,1,'C', True);
    ############################### BLOQUE N° 5 #####################################


    ############################### BLOQUE N° 6 #####################################
    $cantidad = 0;
    $SubTotal = 0;

    $this->SetWidths(array(10,40,130,45,45,45,20));

    $a=1;
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    $cantidad += $reg[$i]['cantidad'];
    $valortotal = $reg[$i]["precioventa"]*$reg[$i]["cantidad"];

    $this->SetX(10);
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->RowFacture(array($a++,
        utf8_decode($reg[$i]["codproducto"]),
        portales(utf8_decode($reg[$i]["producto"])),
        utf8_decode($reg[$i]["nompresentacion"]),
        utf8_decode($reg[$i]["nommarca"]),
        utf8_decode($modelo = ($reg[$i]["nommodelo"] == '' ? "*********" : $reg[$i]["nommodelo"])),
        utf8_decode($reg[$i]["cantidad"])));
  }
    ############################### BLOQUE N° 6 #####################################  
}
########################## FUNCION GUIA PREVENTA ##############################

########################### REPORTES DE PREVENTAS ############################






























########################### REPORTES DE CAJAS DE VENTAS ##############################

########################## FUNCION LISTAR CAJAS ASIGNADAS ##############################
function TablaListarCajas()
{
    $tra = new Login();
    $reg = $tra->ListarCajas();
    
    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,14,'LISTADO GENERAL DE CAJAS',0,0,'C');

   if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'Nº DE CAJA',1,0,'C', True);
    $this->Cell(50,8,'NOMBRE DE CAJA',1,0,'C', True);
    $this->Cell(55,8,'RESPONSABLE',1,0,'C', True);
    $this->Cell(45,8,'SUCURSAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,30,50,55,45));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["nrocaja"]),utf8_decode($reg[$i]['nomcaja']),utf8_decode($reg[$i]["nombres"]),utf8_decode($reg[$i]["nomsucursal"])));
  }
 }
    } else {

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE CAJA',1,0,'C', True);
    $this->Cell(55,8,'NOMBRE DE CAJA',1,0,'C', True);
    $this->Cell(90,8,'RESPONSABLE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,35,55,90));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["nrocaja"]),utf8_decode($reg[$i]['nomcaja']),utf8_decode($reg[$i]["nombres"])));
   }
 }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CAJAS ASIGNADAS ##############################

########################## FUNCION TICKET CIERRE ARQUEO ##############################
function TicketCierre()
{  
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);

    $tra = new Login();
    $reg = $tra->ArqueoCajaPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

    $logo = "./fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
    $this->Image($logo , 20, 3, 35, 15, "PNG");
    $this->Ln(8);

    }
  
    $this->SetX(4);
    $this->SetFont('Courier','B',12);
    $this->SetFillColor(2,157,116);
    $this->Cell(66, 5, "TICKET DE CIERRE", 0, 0, 'C');
    $this->Ln(5);
  
    $this->SetX(4);
    $this->SetFont('Courier','B',10);
    $this->CellFitSpace(66,4,utf8_decode($reg[0]['nomsucursal']), 0, 1, 'C');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(66,3,$reg[0]['documsucursal'] == '0' ? "" : "Nº ".$reg[0]['documento']." ".utf8_decode($reg[0]['cuitsucursal']),0,1,'C');

    if($reg[0]['provincia']==''){

    $this->SetX(4);
    $this->CellFitSpace(66,3,utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['departamento'] == '' ? "" : $reg[0]['departamento'])),0,1,'C');

    }

    $this->SetX(4);
    $this->CellFitSpace(66,3,utf8_decode($reg[0]['direcsucursal']),0,1,'C');

    $this->SetX(4);
    $this->CellFitSpace(66,3,utf8_decode($reg[0]['correosucursal']),0,1,'C');

    $this->SetX(4);
    $this->CellFitSpace(66,3,"OBLIGADO A LLEVAR CONTABILIDAD: ".utf8_decode($reg[0]['llevacontabilidad']),0,1,'C');

    $this->SetX(4);
    $this->CellFitSpace(66,3,"AMBIENTE: PRODUCCIÓN",0,1,'C');
    
    $this->SetX(4);
    $this->CellFitSpace(66,3,"EMISIÓN: NORMAL",0,1,'C');

    $this->SetX(2);
    $this->SetFont('Courier','B',12);
    $this->Cell(70,3,'--------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(16,3,"CAJA Nº:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,utf8_decode($reg[0]['nrocaja']."-".$reg[0]['nomcaja']),0,1,'L');
    
    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(16,3,"CAJERO:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,utf8_decode($reg[0]['nombres']),0,1,'L');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(26,3,"FECHA EMISIÓN:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(40,3,date("d-m-Y H:i:s"),0,1,'L');

    $this->SetFont('Courier','B',12);
    $this->SetX(2);
    $this->Cell(70,3,'--------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(26,3,"HORA APERTURA:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(40,3,utf8_decode(date("d-m-Y H:i:s",strtotime($reg[0]['fechaapertura']))),0,1,'L');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(26,3,"HORA CIERRE:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(40,3,utf8_decode(date("d-m-Y H:i:s",strtotime($reg[0]['fechacierre']))),0,1,'L');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(26,3,"MONTO APERTURA:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(40,3,utf8_decode($simbolo.number_format($reg[0]["montoinicial"], 2, '.', ',')),0,1,'L');

    $this->SetFont('Courier','B',12);
    $this->SetX(2);
    $this->Cell(70,3,'--------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"INGRESOS:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(36,3,utf8_decode($simbolo.number_format($reg[0]["ingresos"], 2, '.', ',')),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"EGRESOS:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(36,3,utf8_decode($simbolo.number_format($reg[0]["egresos"], 2, '.', ',')),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"CRÉDITOS:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(36,3,utf8_decode($simbolo.number_format($reg[0]["creditos"], 2, '.', ',')),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"ABONO CRÉDITO:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(36,3,utf8_decode($simbolo.number_format($reg[0]["abonos"], 2, '.', ',')),0,1,'R');

    $this->SetFont('Courier','B',12);
    $this->SetX(2);
    $this->Cell(70,3,'--------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"TOTAL EN VENTAS:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(36,3,utf8_decode($simbolo.number_format($reg[0]['ingresos']+$reg[0]['creditos'], 2, '.', ',')),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"TOTAL INGRESOS:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(36,3,utf8_decode($simbolo.number_format($reg[0]['ingresos']+$reg[0]['abonos'], 2, '.', ',')),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"EFECTIVO EN CAJA:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(36,3,utf8_decode($simbolo.number_format($reg[0]["dineroefectivo"], 2, '.', ',')),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"DIF. EFECTIVO:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(36,3,utf8_decode($simbolo.number_format($reg[0]["diferencia"], 2, '.', ',')),0,1,'R');


    if($reg[0]["comentarios"]==""){

    $this->SetFont('Courier','B',12);
    $this->SetX(2);
    $this->Cell(70,0.5,'--------------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(70,0.5,'--------------------------',0,1,'C');
    $this->Ln(3);

   } else { 

    $this->SetFont('Courier','B',12);
    $this->SetX(2);
    $this->Cell(70,3,'--------------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(4);
    $this->MultiCell(65,4,$this->SetFont('Courier',"",7).utf8_decode($reg[0]["comentarios"]),0,'L');

    $this->SetFont('Courier','B',12);
    $this->SetX(2);
    $this->Cell(70,0.5,'--------------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(70,0.5,'--------------------------',0,1,'C');
    $this->Ln(3);

    }
 
    $this->SetFont('Courier','BI',9);
    $this->SetX(4);
    $this->SetFillColor(3, 3, 3);
    $this->CellFitSpace(66,3,"GRACIAS POR SU ATENCIÓN",0,1,'C');
    $this->Ln(3);
        
}
########################## FUNCION TICKET CIERRE ARQUEO ##############################

########################## FUNCION LISTAR ARQUEOS DE CAJAS ##############################
function TablaListarArqueos()
{

    $tra = new Login();
    $reg = $tra->ListarArqueoCaja();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################

    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO GENERAL DE ARQUEOS EN CAJAS',0,0,'C');

 if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(60,8,'Nº DE CAJA',1,0,'C', True);
    $this->Cell(25,8,'INICIO',1,0,'C', True);
    $this->Cell(25,8,'CIERRE',1,0,'C', True);
    $this->Cell(20,8,'INICIAL',1,0,'C', True);
    $this->Cell(25,8,'INGRESOS',1,0,'C', True);
    $this->Cell(25,8,'EGRESOS',1,0,'C', True);
    $this->Cell(25,8,'CRÉDITOS',1,0,'C', True);
    $this->Cell(25,8,'ABONOS',1,0,'C', True);
    $this->Cell(25,8,'EFECTIVO',1,0,'C', True);
    $this->Cell(25,8,'DIFERENCIA',1,0,'C', True);
    $this->Cell(40,8,'SUCURSAL',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,60,25,25,20,25,25,25,25,25,25,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja'].":".$reg[$i]['nombres']),
        utf8_decode( date("d-m-Y H:i:s",strtotime($reg[$i]['fechaapertura']))),
    utf8_decode($reg[$i]['fechacierre'] == '0000-00-00 00:00:00' ? "*********" : date("d-m-Y H:i:s",strtotime($reg[$i]['fechacierre']))),
        utf8_decode($simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['ingresos'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['egresos'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['creditos'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['abonos'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['dineroefectivo'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['diferencia'], 2, '.', ',')),
        utf8_decode($reg[$i]['nomsucursal'])));
   }
 }
    } else {

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(100,8,'Nº DE CAJA',1,0,'C', True);
    $this->Cell(25,8,'INICIO',1,0,'C', True);
    $this->Cell(25,8,'CIERRE',1,0,'C', True);
    $this->Cell(20,8,'INICIAL',1,0,'C', True);
    $this->Cell(25,8,'INGRESOS',1,0,'C', True);
    $this->Cell(25,8,'EGRESOS',1,0,'C', True);
    $this->Cell(25,8,'CRÉDITOS',1,0,'C', True);
    $this->Cell(25,8,'ABONOS',1,0,'C', True);
    $this->Cell(25,8,'EFECTIVO',1,0,'C', True);
    $this->Cell(25,8,'DIFERENCIA',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,100,25,25,20,25,25,25,25,25,25));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja'].":".$reg[$i]['nombres']),
        utf8_decode( date("d-m-Y H:i:s",strtotime($reg[$i]['fechaapertura']))),
    utf8_decode($reg[$i]['fechacierre'] == '0000-00-00 00:00:00' ? "*********" : date("d-m-Y H:i:s",strtotime($reg[$i]['fechacierre']))),
        utf8_decode($simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['ingresos'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['egresos'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['creditos'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['abonos'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['dineroefectivo'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['diferencia'], 2, '.', ','))));
   }
 }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR ARQUEOS DE CAJAS ##############################

########################## FUNCION TICKET MOVIMIENTOS EN CAJA ##############################
function TicketMovimiento()
{  
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->MovimientosPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

    $logo = "./fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
    $this->Image($logo , 20, 3, 35, 15, "PNG");
    $this->Ln(8);

    }
  
    $this->SetX(4);
    $this->SetFont('Courier','B',12);
    $this->SetFillColor(2,157,116);
    $this->Cell(66, 5, "TICKET DE MOVIMIENTO", 0, 0, 'C');
    $this->Ln(5);
  
    $this->SetX(4);
    $this->SetFont('Courier','B',10);
    $this->CellFitSpace(66,4,utf8_decode($reg[0]['nomsucursal']), 0, 1, 'C');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(66,3,$reg[0]['documsucursal'] == '0' ? "" : "Nº ".$reg[0]['documento']." ".utf8_decode($reg[0]['cuitsucursal']),0,1,'C');

    if($reg[0]['provincia']==''){

    $this->SetX(4);
    $this->CellFitSpace(66,3,utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['departamento'] == '' ? "" : $reg[0]['departamento'])),0,1,'C');

    }

    $this->SetX(4);
    $this->CellFitSpace(66,3,utf8_decode($reg[0]['direcsucursal']),0,1,'C');

    $this->SetX(4);
    $this->CellFitSpace(66,3,utf8_decode($reg[0]['correosucursal']),0,1,'C');

    $this->SetX(4);
    $this->CellFitSpace(66,3,"Nº DE TICKET: ".utf8_decode($reg[0]['numero']),0,1,'C');

    $this->SetX(4);
    $this->CellFitSpace(66,3,"AMBIENTE: PRODUCCIÓN",0,1,'C');
    
    $this->SetX(4);
    $this->CellFitSpace(66,3,"EMISIÓN: NORMAL",0,1,'C');

    $this->SetX(2);
    $this->SetFont('Courier','B',12);
    $this->Cell(70,3,'--------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(16,4,"CAJA Nº:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,4,utf8_decode($reg[0]['nrocaja']."-".$reg[0]['nomcaja']),0,1,'L');
    
    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(16,4,"CAJERO:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,4,utf8_decode($reg[0]['nombres']),0,1,'L');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(16,4,"MONTO:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,4,utf8_decode($simbolo.number_format($reg[0]["montomovimiento"], 2, '.', ',')),0,1,'L');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(16,4,"MEDIO:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,4,utf8_decode($reg[0]['mediopago']),0,1,'L');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(16,4,"TIPO:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,4,utf8_decode($reg[0]['tipomovimiento']),0,1,'L');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->MultiCell(68,2,$this->SetFont('Courier','B',8)."NOTA: ".utf8_decode($reg[0]['descripcionmovimiento']),0,'J');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(16,4,"FECHA:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,4,date("d-m-Y H:i:s",strtotime($reg[0]['fechamovimiento'])),0,1,'L');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(26,4,"FECHA EMISIÓN:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(40,4,date("d-m-Y H:i:s"),0,1,'L');

    $this->SetFont('Courier','B',12);
    $this->SetX(2);
    $this->Cell(70,0.5,'--------------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(70,0.5,'--------------------------',0,1,'C');
    $this->Ln(3);

    $this->SetFont('Courier','BI',9);
    $this->SetX(4);
    $this->SetFillColor(3, 3, 3);
    $this->CellFitSpace(66,3,"MUCHAS GRACIAS",0,1,'C');
    $this->Ln(3);
        
}
########################## FUNCION TICKET MOVIMIENTOS EN CAJA ##############################

####################### FUNCION LISTAR MOVIMIENTOS EN CAJA ##########################
function TablaListarMovimientos()
{
    $tra = new Login();
    $reg = $tra->ListarMovimientos();
    
    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,14,'LISTADO GENERAL DE MOVIMIENTOS EN CAJA',0,0,'C');

if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'Nº DE CAJA',1,0,'C', True);
    $this->Cell(20,8,'TIPO',1,0,'C', True);
    $this->Cell(35,8,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(25,8,'MONTO',1,0,'C', True);
    $this->Cell(25,8,'MEDIO',1,0,'C', True);
    $this->Cell(45,8,'SUCURSAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,30,20,35,25,25,45));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']),utf8_decode($reg[$i]["tipomovimiento"]),utf8_decode($reg[$i]['descripcionmovimiento']),utf8_decode($simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ',')),utf8_decode($reg[$i]["mediopago"]),utf8_decode($reg[$i]["nomsucursal"])));
  }
 }
    } else {

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(40,8,'Nº DE CAJA',1,0,'C', True);
    $this->Cell(20,8,'TIPO',1,0,'C', True);
    $this->Cell(55,8,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(30,8,'MONTO',1,0,'C', True);
    $this->Cell(35,8,'MEDIO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,40,20,55,30,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']),utf8_decode($reg[$i]["tipomovimiento"]),utf8_decode($reg[$i]['descripcionmovimiento']),utf8_decode($simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ',')),utf8_decode($reg[$i]["mediopago"])));
   }
 }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
######################## FUNCION LISTAR MOVIMIENTOS EN CAJAS #########################

####################### FUNCION LISTAR ARQUEOS DE CAJAS POR FECHAS ######################
function TablaListarArqueosxFechas()
{

    $tra = new Login();
    $reg = $tra->BuscarArqueosxFechas();

   ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,"LISTADO DE ARQUEOS EN CAJA ",0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(330,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(330,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(330,6,"Nº DE CAJA: ".utf8_decode($reg[0]['nrocaja'].": ".$reg[0]['nomcaja']),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"RESPONSABLE: ".portales(utf8_decode($reg[0]['nombres'])),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'INICIO',1,0,'C', True);
    $this->Cell(35,8,'CIERRE',1,0,'C', True);
    $this->Cell(20,8,'INICIAL',1,0,'C', True);
    $this->Cell(25,8,'INGRESOS',1,0,'C', True);
    $this->Cell(25,8,'EGRESOS',1,0,'C', True);
    $this->Cell(25,8,'CRÉDITOS',1,0,'C', True);
    $this->Cell(25,8,'ABONOS',1,0,'C', True);
    $this->Cell(35,8,'TOTAL VENTAS',1,0,'C', True);
    $this->Cell(35,8,'TOTAL INGRESOS',1,0,'C', True);
    $this->Cell(30,8,'EFECTIVO',1,0,'C', True);
    $this->Cell(30,8,'DIFERENCIA',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,35,35,20,25,25,25,25,35,35,30,30));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode( date("d-m-Y H:i:s",strtotime($reg[$i]['fechaapertura']))),
    utf8_decode($reg[$i]['fechacierre'] == '0000-00-00 00:00:00' ? "*********" : date("d-m-Y H:i:s",strtotime($reg[$i]['fechacierre']))),
        utf8_decode($simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['ingresos'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['egresos'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['creditos'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['abonos'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['ingresos']+$reg[$i]['creditos'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['montoinicial']+$reg[$i]['ingresos']+$reg[$i]['abonos']-$reg[$i]['egresos'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['dineroefectivo'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['diferencia'], 2, '.', ','))));
   }
 }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
###################### FUNCION LISTAR ARQUEOS DE CAJAS POR FECHAS ######################

##################### FUNCION LISTAR MOVIMIENTOS EN CAJA POR FECHAS #####################
function TablaListarMovimientosxFechas()
{

    $tra = new Login();
    $reg = $tra->BuscarMovimientosxFechas();
    
   ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,7,"LISTADO DE MOVIMIENTOS EN CAJA ",0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(190,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(190,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(190,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(190,6,"Nº DE CAJA: ".utf8_decode($reg[0]['nrocaja'].": ".$reg[0]['nomcaja']),0,0,'L');
    $this->Ln();
    $this->Cell(190,6,"RESPONSABLE: ".portales(utf8_decode($reg[0]['nombres'])),0,0,'L');
    $this->Ln();
    $this->Cell(190,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(190,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');


    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(20,8,'TIPO',1,0,'C', True);
    $this->Cell(75,8,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(40,8,'MONTO',1,0,'C', True);
    $this->Cell(45,8,'MEDIO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,20,75,40,45));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["tipomovimiento"]),utf8_decode($reg[$i]['descripcionmovimiento']),utf8_decode($simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ',')),utf8_decode($reg[$i]["mediopago"])));
   }
 }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
##################### FUNCION LISTAR MOVIMIENTOS EN CAJAS POR FECHAS ###################

############################## REPORTES DE CAJAS DE VENTAS ##############################







































################################### REPORTES DE VENTAS ##################################

########################## FUNCION TICKET VENTA ##############################
function TicketVenta()
{  
   
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->VentasPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']); 

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

    $logo = "./fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
    $this->Image($logo , 20, 3, 35, 15, "PNG");
    $this->Ln(8);

    }
  
    $this->SetX(4);
    $this->SetFont('Courier','B',12);
    $this->SetFillColor(2,157,116);
    $this->Cell(66, 5, "TICKET DE VENTA", 0, 0, 'C');
    $this->Ln(5);
  
    $this->SetX(4);
    $this->SetFont('Courier','B',10);
    $this->CellFitSpace(66,4,utf8_decode($reg[0]['nomsucursal']), 0, 1, 'C');

    $this->SetX(4);
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(66,3,$reg[0]['documsucursal'] == '0' ? "" : "Nº ".$reg[0]['documento']." ".utf8_decode($reg[0]['cuitsucursal']),0,1,'C');

    if($reg[0]['id_provincia']!='0'){

    $this->SetX(4);
    $this->CellFitSpace(66,3,utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['departamento'] == '' ? "" : $reg[0]['departamento'])),0,1,'C');

    }

    $this->SetX(4);
    $this->CellFitSpace(66,3,utf8_decode($reg[0]['direcsucursal']),0,1,'C');
    
    $this->SetX(4);
    $this->CellFitSpace(66,3,"Nº DE TICKET: ".utf8_decode($reg[0]['codfactura']),0,1,'C');

    $this->SetX(2);
    $this->SetFont('Courier','B',12);
    $this->Cell(70,3,'--------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(16,3,"CAJA Nº:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,utf8_decode($reg[0]['nrocaja']."-".$reg[0]['nomcaja']),0,1,'L');
    
    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(16,3,"CAJERO:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,utf8_decode($reg[0]['nombres']),0,1,'L');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(26,3,"FECHA VENTA:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(40,3,date("d-m-Y H:i:s",strtotime($reg[0]['fechaventa'])),0,1,'L');
    
    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(26,3,"FECHA EMISIÓN:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(40,3,date("d-m-Y H:i:s"),0,1,'L');

    $this->SetFont('Courier','B',12);
    $this->SetX(2);
    $this->Cell(70,3,'--------------------------',0,0,'C');
    $this->Ln(3);

    if($reg[0]['nomcliente']==""){

    $this->SetFont('Courier','',8);
    $this->SetX(4);
    $this->CellFitSpace(66, 3, "CONSUMIDOR FINAL",0,1,'C');

    } else {

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(15,3,$documento = ($reg[0]['documcliente'] == '0' ? "Nº DOC:" : "Nº ".$reg[0]['documento'].": "),0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(51,3,utf8_decode($reg[0]['dnicliente']),0,1,'L');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(15,3,"SEÑOR(A):",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->MultiCell(51,3,$this->SetFont('Courier','B',8).utf8_decode($reg[0]['nomcliente']),0,'L');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(15,3,"DIREC:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->MultiCell(51,3,$this->SetFont('Courier','B',8).portales(utf8_decode(getSubString($reg[0]['direccliente'],32))),0,'L');
        
    }

    $this->SetX(2);
    $this->SetFont('Courier','B',12);
    $this->Cell(70,3,'--------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->SetTextColor(3, 3, 3); // Establece el color del texto (en este caso es Negro)
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->Cell(10,3,'CANT',0,0,'L');
    $this->Cell(56,3,'DESCRIPCIÓN',0,1,'C');

    $this->SetX(4);
    $this->Cell(22,3,'PVP.',0,0,'C');
    $this->Cell(22,3,'DCTO.',0,0,'C');
    $this->Cell(22,3,'TOTAL IMPORTE',0,1,'C');

    $this->SetX(2);
    $this->SetFont('Courier','B',12);
    $this->Cell(70,3,'--------------------------',0,0,'C');
    $this->Ln(3);

    $tra = new Login();
    $detalle = $tra->VerDetallesVentas();
    $cantidad = 0;
    $SubTotal = 0;
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){
    $SubTotal += $detalle[$i]['valorneto'];

    $this->SetX(4);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->CellFitSpace(10,3,utf8_decode($detalle[$i]['cantventa']),0,0,'C');
    $this->CellFitSpace(56,3,portales(utf8_decode(getSubString($detalle[$i]["producto"], 25))),0,1,'C');
    $this->SetX(4);
    $this->CellFitSpace(24,3,utf8_decode($simbolo.number_format($detalle[$i]["precioventa"], 2, '.', ',')),0,0,'C');
    $this->CellFitSpace(18,3,utf8_decode(number_format($detalle[$i]["descproducto"], 2, '.', ',')),0,0,'C');
    $this->CellFitSpace(24,3,utf8_decode($simbolo.number_format($detalle[$i]["valorneto"], 2, '.', ',')),0,0,'C');
    $this->Ln();  
    }

    $this->SetX(2);
    $this->SetFont('Courier','B',12);
    $this->Cell(70,3,'--------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(36,3,"SUBTOTAL:",0,0,'R');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(30,3,utf8_decode($simbolo.number_format($SubTotal, 2, '.', ',')),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(36,3,"GRAVADO (".number_format($reg[0]["iva"], 2, '.', ',')."%):",0,0,'R');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(30,3,utf8_decode($simbolo.number_format($reg[0]["subtotalivasi"], 2, '.', ',')),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(36,3,"EXENTO (0%):",0,0,'R');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(30,3,utf8_decode($simbolo.number_format($reg[0]["subtotalivano"], 2, '.', ',')),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(36,3,$impuesto == '' ? "TOTAL IMP." : "TOTAL ".$impuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):",0,0,'R');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(30,3,utf8_decode($simbolo.number_format($reg[0]["totaliva"], 2, '.', ',')),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(36,3,"DESCONTADO %:",0,0,'R');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(30,3,utf8_decode($simbolo.number_format($reg[0]["descontado"], 2, '.', ',')),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(36,3,"DESC % (".number_format($reg[0]["descuento"], 2, '.', ',')."%):",0,0,'R');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(30,3,utf8_decode($simbolo.number_format($reg[0]["totaldescuento"], 2, '.', ',')),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(36,3,"IMPORTE TOTAL:",0,0,'R');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(30,3,utf8_decode($simbolo.number_format($reg[0]["totalpago"], 2, '.', ',')),0,1,'R');

    $this->SetFont('Courier','B',12);
    $this->SetX(2);
    $this->Cell(70,3,'--------------------------',0,0,'C');
    $this->Ln(3);

    if($reg[0]['tipopago']=="CREDITO"){

    $this->SetX(4);
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(66,3,utf8_decode($reg[0]["tipopago"]." - ".$reg[0]['formapago']),0,1,'C');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(36,3,"STATUS PAGO:",0,0,'R');
    $this->SetFont('Courier','',8);
    if($reg[0]['fechavencecredito']== '0000-00-00') { 
        $this->CellFitSpace(30,3,utf8_decode($reg[0]["statusventa"]),0,1,'R');
    } elseif($reg[0]['fechavencecredito'] >= date("Y-m-d")) { 
        $this->CellFitSpace(30,3,utf8_decode($reg[0]["statusventa"]),0,1,'R');
    } elseif($reg[0]['fechavencecredito'] < date("Y-m-d")) { 
        $this->CellFitSpace(30,3,utf8_decode("VENCIDA"),0,1,'R');
    }  

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(36,3,"VENCE CRÉDITO:",0,0,'R');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(30,3,utf8_decode(date("d-m-Y",strtotime($reg[0]["fechavencecredito"]))),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(36,3,"DIAS VENCIDOS:",0,0,'R');
    $this->SetFont('Courier','',8);
    if($reg[0]['fechavencecredito']== '0000-00-00') { 
        $this->CellFitSpace(30,3,utf8_decode("0"),0,1,'R');
    } elseif($reg[0]['fechavencecredito'] >= date("Y-m-d")) { 
        $this->CellFitSpace(30,3,utf8_decode("0"),0,1,'R');
    } elseif($reg[0]['fechavencecredito'] < date("Y-m-d")) { 
        $this->CellFitSpace(30,3,utf8_decode(Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito'])),0,1,'R');
    }

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(36,3,"TOTAL ABONO:",0,0,'R');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(30,3,utf8_decode($simbolo.number_format($reg[0]["abonototal"], 2, '.', ',')),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(36,3,"TOTAL DEBE:",0,0,'R');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(30,3,utf8_decode($simbolo.number_format($reg[0]["totalpago"]-$reg[0]["abonototal"], 2, '.', ',')),0,1,'R');
    $this->Ln(1);

    } else {

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(36,3,"CONDICIÓN DE PAGO:",0,0,'R');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(30,3,utf8_decode($reg[0]["tipopago"]),0,1,'R');
    
    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(36,3,"FORMA DE PAGO:",0,0,'R');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(30,3,utf8_decode($reg[0]["mediopago"]),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(36,3,"MONTO DE PAGO:",0,0,'R');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(30,3,utf8_decode($simbolo.number_format($reg[0]["montopagado"], 2, '.', ',')),0,1,'R');

    if($reg[0]["montodevuelto"]!="0.00") {

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(36,3,"DIFERENCIA:",0,0,'R');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(30,3,utf8_decode($simbolo.number_format($reg[0]["montodevuelto"], 2, '.', ',')),0,1,'R');

   }

    }

    if($reg[0]['observaciones']!=""){
    ########################### BLOQUE N° 6 #############################
    $this->SetX(2);
    $this->SetFont('Courier','B',12);
    $this->Cell(70,0.5,'--------------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(70,0.5,'--------------------------',0,1,'C'); 
    $this->Ln(2);  
    $this->SetX(4);
    $this->SetFont('courier','B',7);
    $this->MultiCell(70,3,"OBSERVACIONES: ".utf8_decode($reg[0]['observaciones'] == '' ? "" : $reg[0]['observaciones']),0,1,'');
    $this->Ln(4);
    ########################### BLOQUE N° 6 #############################    
    }

    $this->SetX(2);
    $this->SetFont('Courier','B',12);
    $this->Cell(70,0.5,'--------------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(70,0.5,'--------------------------',0,1,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','BI',10);
    $this->SetFillColor(3, 3, 3);
    $this->CellFitSpace(70,3,"GRACIAS POR SU COMPRA",0,1,'C');
    $this->Ln(3);
 
}
########################## FUNCION TICKET VENTA ##############################

########################## FUNCION FACTURA VENTA (MITAD) #############################
function FacturaVenta()
{
   
    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");

    $this->Image($logo, 10, 4.5, 20, 10, "PNG");

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->VentasPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']); 
        
    //Bloque datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(5, 15, 42, 25, '1.5', "");
    
    $this->SetFont('Courier','BI',8);
    $this->SetTextColor(3,3,3); // Establece el color del texto (en este caso es Negro)
    $this->SetXY(5, 15);
    $this->CellFitSpace(42, 5,utf8_decode($reg[0]['nomsucursal']), 0, 1); //Membrete Nro 1

    $this->SetFont('Courier','B',6);
    if($reg[0]['id_provincia']!='0'){
    $this->SetX(5);
    $this->CellFitSpace(42, 3,utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "" : $reg[0]['provincia']." ").$departamento = ($reg[0]['departamento'] == '' ? "" : $reg[0]['departamento']." ")), 0,1);
    }

    $this->SetX(5);
    $this->CellFitSpace(42, 3,$reg[0]['direcsucursal'], 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,'Nº DE ACTIVIDAD: '.$reg[0]['nroactividadsucursal'], 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,'Nº TLF: '.utf8_decode($reg[0]['tlfsucursal']), 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,utf8_decode($reg[0]['correosucursal']), 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,'OBLIGADO A LLEVAR CONTABILIDAD: '.utf8_decode($reg[0]['llevacontabilidad']), 0 , 0); 
      
    //Bloque datos de factura
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(48, 5, 57, 35, '1.5', "");

    $this->SetFont('Courier','B',10);
    $this->SetXY(48, 4);
    $this->Cell(5, 7, 'FACTURA DE VENTA', 0 , 0);


    $this->SetFont('Courier','B',7);
    $this->SetXY(48, 7);
    $this->Cell(5, 7, 'Nº DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : $reg[0]['documento'].":"), 0 , 0);
    $this->SetXY(78, 7);
    $this->CellFitSpace(28, 7,utf8_decode($reg[0]['cuitsucursal']), 0, 0);

    $this->SetXY(48, 10);
    $this->SetFont('Courier','B',8);
    $this->Cell(5, 7, 'Nº DE FACTURA', 0 , 0);
    $this->SetXY(78, 10);
    $this->CellFitSpace(28, 7,utf8_decode($reg[0]['codfactura']), 0, 0);

    $this->SetXY(48, 13);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'NÚMERO DE AUTORIZACIÓN:', 0, 0);
    $this->SetXY(48, 16);
    $this->CellFitSpace(56, 7,utf8_decode($reg[0]['codautorizacion']), 0, 0);

    $this->SetXY(48, 19);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'NÚMERO DE SERIE:', 0, 0);
    $this->SetXY(48, 22);
    $this->CellFitSpace(56, 7,utf8_decode($reg[0]['codserie']), 0, 0);

    $this->SetXY(48, 25);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,"FECHA DE AUTORIZACIÓN:", 0, 0);
    $this->SetXY(78, 25);
    $this->Cell(28, 7,$fecha = ($reg[0]['fechaautorsucursal'] == '0000-00-00' ? "" : date("d-m-Y",strtotime($reg[0]['fechaautorsucursal']))), 0, 0);

    $this->SetXY(48, 28);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,"FECHA DE VENTA:", 0, 0);
    $this->SetXY(78, 28);
    $this->Cell(28, 7,date("d-m-Y H:i:s",strtotime($reg[0]['fechaventa'])), 0, 0);


    $this->SetXY(48, 31);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'AMBIENTE: ', 0 , 0);
    $this->SetXY(78, 31);
    $this->Cell(28, 7,'PRODUCCIÓN', 0 , 0);

    $this->SetXY(48, 34);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'EMISIÓN: ', 0 , 0);
    $this->SetXY(78, 34);
    $this->Cell(28, 7,'NORMAL', 0 , 0);
     
    //Bloque datos de cliente
    $this->SetLineWidth(0.3);
    $this->SetFillColor(192);
    $this->RoundedRect(5, 41, 100, 10, '1.5', "");
    $this->SetFont('Courier','B',6);

    $this->SetXY(6, 40.2);
    $this->CellFitSpace(66, 5,'RAZÓN SOCIAL: '.utf8_decode($reg[0]['codcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']), 0, 0);
    $this->CellFitSpace(32, 5,'Nº DE '.$documento = ($reg[0]['documcliente'] == '' ? "DOC: " : $reg[0]['documento'].": ").$dni = ($reg[0]['dnicliente'] == '' ? "**********" : $reg[0]['dnicliente']), 0, 0);

    $this->SetXY(6, 43.2);
    $this->CellFitSpace(66, 5,'DIRECCIÓN: '.utf8_decode($reg[0]['direccliente'] == '' ? "**********" : $reg[0]['direccliente']), 0, 0);
    $this->CellFitSpace(32, 5,'Nº DE TLF: '.($reg[0]['tlfcliente'] == '' ? "**********" : $reg[0]['tlfcliente']), 0, 0);

    $this->SetXY(6, 46.2);
    $this->CellFitSpace(92, 5,'EMAIL: '.utf8_decode($reg[0]['emailcliente'] == '' ? "**********" : $reg[0]['emailcliente']), 0, 0);

    $this->Ln(6);
    $this->SetX(5);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(5,3,'N°',1,0,'C', True);
    $this->Cell(50,3,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(12,3,'CANTIDAD',1,0,'C', True);
    $this->Cell(14,3,'PRECIO',1,0,'C', True);
    $this->Cell(19,3,'IMPORTE',1,1,'C', True);
    
    $tra = new Login();
    $detalle = $tra->VerDetallesVentas();
    $cantidad = 0;
    $SubTotal = 0;

    $this->SetWidths(array(5,50,12,14,19));

    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $cantidad += $detalle[$i]['cantventa'];
    $valortotal = $detalle[$i]["precioventa"]*$detalle[$i]["cantventa"];
    $SubTotal += $detalle[$i]['valorneto'];

    $this->SetX(5);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier',"",6);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->RowFacture(array($a++,portales(utf8_decode($detalle[$i]["producto"])),utf8_decode($detalle[$i]['cantventa']),utf8_decode(number_format($detalle[$i]["precioventa"], 2, '.', ',')),utf8_decode(number_format($detalle[$i]['valorneto'], 2, '.', ','))));
       
    }
     
    $this->Ln(1);
    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'INFORMACIÓN ADICIONAL',1,0,'C');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->SetFont('Courier','B',6);
    $this->CellFitSpace(20,3.5,'SUBTOTAL ',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($SubTotal, 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'Nº DE CAJA: '.utf8_decode($reg[0]['nrocaja']."-".$reg[0]['nomcaja']),1,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,'GRAVADO ('.number_format($reg[0]["iva"], 2, '.', ',').'%):',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["subtotalivasi"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'CAJERO(A): '.utf8_decode($reg[0]['nombres']),1,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,'EXENTO (0%):',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["subtotalivano"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'FECHA DE EMISIÓN: '.date("d-m-Y H:i:s"),1,0,'L');

    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,$impuesto == '' ? "IMPUESTO" : "".$impuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):",1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["totaliva"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'CONDICIÓN DE PAGO: '.utf8_decode($reg[0]['tipopago'])."          ".utf8_decode($reg[0]['tipopago'] == 'CONTADO' ? "" : "VENCIMIENTO: ".date("d-m-Y",strtotime($reg[0]['fechavencecredito']))),1,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,'DESCONTADO %:',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["descontado"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'MEDIO DE PAGO: '.utf8_decode($medio = ($reg[0]['tipopago'] == 'CONTADO' ? $reg[0]['mediopago'] : $reg[0]['formapago'])),1,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,'DESC % ('.number_format($reg[0]["descuento"], 2, '.', ',').'%):',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["totaldescuento"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(59,3.5,'',0,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->SetFont('Courier','B',6);
    $this->Cell(20,3.5,'IMPORTE TOTAL:',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["totalpago"], 2, '.', ','),1,0,'R');
    $this->Ln(4);
    
    $this->SetX(5);
    $this->SetDrawColor(3,3,3);
    $this->SetFont('Courier','BI',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(100,2,'MONTO EN LETRAS: '.utf8_decode(numtoletras(number_format($reg[0]['totalpago'], 2, '.', ''))),0,0,'L');
    $this->Ln();
}  
########################## FUNCION FACTURA VENTA (MITAD) ##############################

########################## FUNCION FACTURA VENTA (A4) #############################
function FacturaVenta2()
{     
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->VentasPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']); 

    //Logo
    if (isset($reg[0]['cuitsucursal'])) {
             if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

        $logo = "./fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
        $this->Image($logo , 15 ,11, 25 , 15 , "PNG");

    } else {

        $logo = "./fotos/logo_principal.png";                         
        $this->Image($logo , 15 ,11, 55 , 15 , "PNG");  
   }                                      
    }

############################ BLOQUE N° 1 FACTURA ###################################  
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 10, 190, 17, '1.5', '');
    
    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(98, 12, 12, 12, '1.5', 'F');

    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(98, 12, 12, 12, '1.5', '');

    $this->SetFont('courier','B',16);
    $this->SetXY(101, 14);
    $this->Cell(20, 5, 'V', 0 , 0);
    $this->SetFont('courier','B',8);
    $this->SetXY(98, 19);
    $this->Cell(20, 5, 'Venta', 0, 0);
    
    $this->SetFont('courier','B',11);
    $this->SetXY(124, 10);
    $this->Cell(34, 5, 'N° DE FACTURA ', 0, 0);
    $this->SetFont('courier','B',11);
    $this->SetXY(158, 10);
    $this->CellFitSpace(40, 5,utf8_decode($reg[0]['codfactura']), 0, 0, "R");

    $this->SetFont('courier','B',9);
    $this->SetXY(124, 14);
    $this->Cell(34, 4, 'FECHA DE VENTA ', 0, 0);
    $this->SetFont('courier','',9);
    $this->SetXY(158, 14);
    $this->Cell(40, 4,utf8_decode(date("d-m-Y",strtotime($reg[0]['fechaventa']))), 0, 0, "R");

    $this->SetFont('courier','B',9);
    $this->SetXY(124, 18);
    $this->Cell(34, 4, 'FECHA DE EMISIÓN', 0, 0);
    $this->SetFont('courier','',9);
    $this->SetXY(158, 18);
    $this->Cell(40, 4,utf8_decode(date("d-m-Y H:i:s")), 0, 0, "R");
    
    $this->SetFont('courier','B',9);
    $this->SetXY(124, 22);
    $this->Cell(34, 4, 'ESTADO DE PAGO', 0, 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(158, 22);
    
    if($reg[0]['fechavencecredito']== '0000-00-00') { 
    $this->Cell(40, 4,utf8_decode($reg[0]['statusventa']), 0, 0, "R");
    } elseif($reg[0]['fechavencecredito'] >= date("Y-m-d")) { 
    $this->Cell(40, 4,utf8_decode($reg[0]['statusventa']), 0, 0, "R");
    } elseif($reg[0]['fechavencecredito'] < date("Y-m-d")) { 
    $this->Cell(40, 4,utf8_decode("VENCIDA"), 0, 0, "R");
    }
############################## BLOQUE N° 1 FACTURA ###############################     
    
############################### BLOQUE N° 2 SUCURSAL ##############################   
   //Bloque de datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 29, 190, 18, '1.5', '');
    //DATOS DE SUCURSAL LINEA 1
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 30);
    $this->Cell(186, 4, 'DATOS DE SUCURSAL ', 0, 0);
    //DATOS DE SUCURSAL LINEA 1

    //DATOS DE SUCURSAL LINEA 2
    $this->SetFont('courier','B',8);
    $this->SetXY(12, 34);
    $this->Cell(24, 4, 'RAZÓN SOCIAL:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(36, 34);
    $this->CellFitSpace(66, 4,utf8_decode($reg[0]['nomsucursal']), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(102, 34);
    $this->CellFitSpace(22, 4, 'Nº DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : $reg[0]['documento'].":"), 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(124, 34);
    $this->CellFitSpace(28, 4,utf8_decode($reg[0]['cuitsucursal']), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(152, 34);
    $this->Cell(18, 4, 'N° DE TLF:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(170, 34);
    $this->Cell(28, 4,utf8_decode($reg[0]['tlfsucursal']), 0, 0);
    //DATOS DE SUCURSAL LINEA 2

    //DATOS DE SUCURSAL LINEA 3
    $this->SetFont('courier','B',8);
    $this->SetXY(12, 38);
    $this->Cell(24, 4, 'DIRECCIÓN:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(36, 38);
    $this->CellFitSpace(96, 4,utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "*********" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['departamento'] == '' ? "*********" : $reg[0]['departamento'])." ".$reg[0]['direcsucursal']), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(132, 38);
    $this->Cell(12, 4, 'EMAIL:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(144, 38);
    $this->Cell(54, 4,utf8_decode($reg[0]['correosucursal']), 0, 0);
    //DATOS DE SUCURSAL LINEA 3

    //DATOS DE SUCURSAL LINEA 4
    $this->SetFont('courier','B',8);
    $this->SetXY(12, 42);
    $this->Cell(24, 4, 'RESPONSABLE:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(36, 42);
    $this->CellFitSpace(66, 4,utf8_decode($reg[0]['nomencargado']), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(102, 42);
    $this->CellFitSpace(22, 4, 'Nº DE '.$documento = ($reg[0]['documencargado'] == '0' ? "DOC.:" : $reg[0]['documento2'].":"), 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(124, 42);
    $this->CellFitSpace(28, 4,utf8_decode($reg[0]['dniencargado']), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(152, 42);
    $this->Cell(18, 4, 'N° DE TLF:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(170, 42);
    $this->Cell(28, 4,utf8_decode($tlf = ($reg[0]['tlfencargado'] == '' ? "*********" : $reg[0]['tlfencargado'])), 0, 0);
    //DATOS DE SUCURSAL LINEA 4
############################### BLOQUE N° 2 SUCURSAL ###############################   


################################# BLOQUE N° 3 CLIENTE ################################  
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 49, 190, 14, '1.5', '');

    $this->SetFont('courier','B',9);
    $this->SetXY(12, 50);
    $this->Cell(186, 4, 'DATOS DE CLIENTE ', 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(12, 54);
    $this->Cell(20, 4, 'NOMBRES:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(32, 54);
    $this->CellFitSpace(58, 4,utf8_decode($nombre = ($reg[0]['nomcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente'])), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(90, 54);
    $this->CellFitSpace(20, 4, 'Nº DE '.$documento = ($reg[0]['documcliente'] == '0' ? "DOC.:" : $reg[0]['documento3'].":"), 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(110, 54);
    $this->CellFitSpace(24, 4,utf8_decode($nombre = ($reg[0]['dnicliente'] == '' ? "*********" : $reg[0]['dnicliente'])), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(134, 54);
    $this->Cell(12, 4, 'EMAIL:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(146, 54);
    $this->CellFitSpace(52, 4,utf8_decode($email = ($reg[0]['emailcliente'] == '' ? "*********" : $reg[0]['emailcliente'])), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(12, 58);
    $this->Cell(20, 4, 'DIRECCIÓN:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(32, 58);
    $this->CellFitSpace(124, 4,getSubString(utf8_decode($provincia = ($reg[0]['provincia2'] == '' ? "*********" : $reg[0]['provincia2'])." ".$departamento = ($reg[0]['departamento2'] == '' ? "*********" : $reg[0]['departamento2'])." ".$reg[0]['direccliente']), 70), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(156, 58);
    $this->Cell(20, 4, 'N° DE TLF:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(176, 58);
    $this->CellFitSpace(22, 4,utf8_decode($tlf = ($reg[0]['tlfcliente'] == '' ? "*********" : $reg[0]['tlfcliente'])), 0, 0); 
################################# BLOQUE N° 3 CLIENTE ################################  

################################# BLOQUE N° 4 #######################################   
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 68, 190, 180, '0', '');

    $this->SetFont('courier','B',9);
    $this->SetXY(10, 65);
    $this->SetTextColor(3,3,3);
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->Cell(8, 8,"Nº", 1, 0, 'C', True);
    $this->Cell(50, 8,"DESCRIPCIÓN DE PRODUCTO", 1, 0, 'C', True);
    $this->Cell(20, 8,"MARCA", 1, 0, 'C', True);
    $this->Cell(15, 8,"MODELO", 1, 0, 'C', True);
    $this->Cell(10, 8,"CANT", 1, 0, 'C', True);
    $this->Cell(20, 8,"P/UNIT", 1, 0, 'C', True);
    $this->Cell(20, 8,"V/TOTAL", 1, 0, 'C', True);
    $this->Cell(15, 8,"DESC %", 1, 0, 'C', True);
    $this->Cell(12, 8,$impuesto, 1, 0, 'C', True);
    $this->Cell(20, 8,"V/NETO", 1, 1, 'C', True);
################################# BLOQUE N° 4 #######################################  

################################# BLOQUE N° 5 ####################################### 
    $tra = new Login();
    $detalle = $tra->VerDetallesVentas();
    $cantidad = 0;
    $SubTotal = 0;

     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(7,50,20,15,10,20,20,15,12,19));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $cantidad += $detalle[$i]['cantventa'];
    $valortotal = $detalle[$i]["precioventa"]*$detalle[$i]["cantventa"];
    $SubTotal += $detalle[$i]['valorneto'];

    $this->SetX(11);
    $this->SetFont('Courier','',7);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->SetFillColor(255, 255, 255); // establece el color del fondo de la celda (en este caso es BLANCO)
    $this->RowFacture2(array($a++,
        portales(utf8_decode($detalle[$i]["producto"])),
        utf8_decode($detalle[$i]["nommarca"] == '' ? "******" : $detalle[$i]["nommarca"]),
        utf8_decode($detalle[$i]["nommodelo"] == '' ? "******" : $detalle[$i]["nommodelo"]),
        utf8_decode($detalle[$i]["cantventa"]),
        utf8_decode($simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ',')),
        utf8_decode(number_format($detalle[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($detalle[$i]["ivaproducto"] == 'SI' ? number_format($reg[0]["iva"], 2, '.', ',')."%" : "(E)"),
        utf8_decode($simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','))));
  }
################################# BLOQUE N° 5 #######################################  

########################### BLOQUE N° 7 #############################    
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 250, 108, 26, '1.5', '');

    $this->SetFont('courier','B',8);
    $this->SetXY(11, 250);
    $this->Cell(105, 4, 'INFORMACIÓN ADICIONAL', 0, 0, 'C');
    
    $this->SetFont('courier','B',7.5);
    $this->SetXY(11, 254);
    $this->Cell(33, 3, 'CANTIDAD PRODUCTOS:', 0, 0);
    $this->SetXY(44, 254);
    $this->SetFont('courier','',7.5);
    $this->CellFitSpace(15, 3,utf8_decode($cantidad), 0, 0);
    
    $this->SetFont('courier','B',7.5);
    $this->SetXY(59, 254);
    $this->Cell(28, 3, 'TIPO DOCUMENTO:', 0, 0);
    $this->SetXY(87, 254);
    $this->SetFont('courier','',7.5);
    $this->Cell(30, 3,"FACTURA", 0, 0);

    $this->SetFont('courier','B',7.5);
    $this->SetXY(11, 257);
    $this->Cell(33, 3, 'NOMBRE DE CAJERO:', 0, 0);
    $this->SetXY(44, 257);
    $this->SetFont('courier','',7.5);
    $this->CellFitSpace(73, 3,utf8_decode($reg[0]['nombres']), 0, 0);
    
    $this->SetFont('courier','B',7.5);
    $this->SetXY(11, 260);
    $this->Cell(33, 3, 'TIPO DE PAGO:', 0, 0);
    $this->SetXY(44, 260);
    $this->SetFont('courier','',7.5);
    $this->CellFitSpace(18, 3,utf8_decode($reg[0]['tipopago']), 0, 0);
    
if($reg[0]['tipopago']=="CREDITO"){

   //Linea de membrete Nro 5
    $this->SetFont('courier','B',7.5);
    $this->SetXY(62, 260);
    $this->Cell(16, 3, 'F. VENC:', 0, 0);
    $this->SetXY(78, 260);
    $this->SetFont('courier','',7.5);
    $this->CellFitSpace(20, 3,utf8_decode($vence = ( $reg[0]['fechavencecredito'] == '0000-00-00' ? "0" : date("d-m-Y",strtotime($reg[0]['fechavencecredito'])))), 0, 0);
    
    //Linea de membrete Nro 6
    $this->SetFont('courier','B',7.5);
    $this->SetXY(98, 260);
    $this->Cell(10, 3, 'DIAS:', 0, 0);
    $this->SetXY(108, 260);
    $this->SetFont('courier','',7.5);
    
    if($reg[0]['fechavencecredito']== '0000-00-00') { 
    $this->CellFitSpace(9, 3,utf8_decode("0"), 0, 0);
    } elseif($reg[0]['fechavencecredito'] >= date("Y-m-d")) { 
    $this->CellFitSpace(9, 3,utf8_decode("0"), 0, 0);
    } elseif($reg[0]['fechavencecredito'] < date("Y-m-d")) { 
    $this->CellFitSpace(9, 3,utf8_decode(Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito'])), 0, 0);
    }
}
    
    $this->SetFont('courier','B',7.5);
    $this->SetXY(11, 263);
    $this->Cell(33, 3, 'MEDIO DE PAGO:', 0, 0);
    $this->SetXY(44, 263);
    $this->SetFont('courier','',7.5);
    $this->CellFitSpace(38, 3,utf8_decode($variable = ($reg[0]['tipopago'] == 'CONTADO' ? $reg[0]['mediopago']."(".$simbolo.$reg[0]["montopagado"].")" : $reg[0]['formapago'])), 0, 0);

    $this->SetFont('courier','B',7);
    $this->SetXY(11, 266);
    $this->MultiCell(105,3,$this->SetFont('Courier','',7).utf8_decode(numtoletras(number_format($reg[0]['totalpago'], 2, '.', ''))),0,'L');

    //Linea de membrete Nro 5
    $this->SetFont('courier','B',7);
    $this->SetXY(11, 269);
    $this->MultiCell(105,3,$this->SetFont('Courier','',7).utf8_decode($reg[0]["observaciones"]=="" ? "" : "OBSERVACIONES: ".$reg[0]["observaciones"]), 0,'J');
########################### BLOQUE N° 7 #############################    

################################# BLOQUE N° 8 #######################################  
    //Bloque de Totales de factura
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(120, 250, 80, 26, '1.5', '');

    //Linea de membrete Nro 1
    $this->SetFont('courier','B',9);
    $this->SetXY(124, 249.5);
    $this->CellFitSpace(36, 5, 'SUBTOTAL:', 0, 0);
    $this->SetXY(160, 249.5);
    $this->SetFont('courier','',9);
    $this->CellFitSpace(40, 5,utf8_decode($simbolo.number_format($SubTotal, 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',9);
    $this->SetXY(124, 252.5);
    $this->CellFitSpace(36, 5, 'TOTAL GRAVADO ('.number_format($reg[0]["iva"], 2, '.', ',').'%):', 0, 0);
    $this->SetXY(160, 252.5);
    $this->SetFont('courier','',9);
    $this->CellFitSpace(40, 5,utf8_decode($simbolo.number_format($reg[0]["subtotalivasi"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 3
    $this->SetFont('courier','B',9);
    $this->SetXY(124, 255.5);
    $this->CellFitSpace(36, 5, 'TOTAL EXENTO (0%):', 0, 0);
    $this->SetXY(160, 255.5);
    $this->SetFont('courier','',9);
    $this->CellFitSpace(40, 5,utf8_decode($simbolo.number_format($reg[0]["subtotalivano"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 4
    $this->SetFont('courier','B',9);
    $this->SetXY(124, 258.5);
    $this->CellFitSpace(36, 5, $impuesto == '' ? "TOTAL IMP." : "TOTAL ".$impuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):", 0, 0);
    $this->SetXY(160, 258.5);
    $this->SetFont('courier','',9);
    $this->CellFitSpace(40, 5,utf8_decode($simbolo.number_format($reg[0]["totaliva"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 3
    $this->SetFont('courier','B',9);
    $this->SetXY(124, 261.5);
    $this->CellFitSpace(36, 5, 'DESCONTADO %:', 0, 0);
    $this->SetXY(160, 261.5);
    $this->SetFont('courier','',9);
    $this->CellFitSpace(40, 5,utf8_decode($simbolo.number_format($reg[0]["descontado"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 5
    $this->SetFont('courier','B',9);
    $this->SetXY(124, 264.5);
    $this->CellFitSpace(36, 5, "DESC. GLOBAL (".number_format($reg[0]["descuento"], 2, '.', ',').'%):', 0, 0);
    $this->SetXY(160, 264.5);
    $this->SetFont('courier','',9);
    $this->CellFitSpace(40, 5,utf8_decode($simbolo.number_format($reg[0]["totaldescuento"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 6
    $this->SetFont('courier','B',9);
    $this->SetXY(124, 267.5);
    $this->CellFitSpace(36, 5, 'IMPORTE TOTAL:', 0, 0);
    $this->SetXY(160, 267.5);
    $this->SetFont('courier','',9);
    $this->CellFitSpace(40, 5,utf8_decode($simbolo.number_format($reg[0]["totalpago"], 2, '.', ',')), 0, 0, "R");
################################# BLOQUE N° 8 #######################################
}
########################## FUNCION FACTURA VENTA (A4) ##############################

########################## FUNCION GUIA VENTA ##############################
function GuiaVenta()
{
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->VentasPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']); 

    ######################### BLOQUE N° 1 ######################### 
   //Bloque de membrete principal
    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 10, 245, 24, '1.5', '');
    
    //Linea de membrete Nro 1
    $this->SetFont('courier','B',14);
    $this->SetXY(12, 12);
    $this->Cell(20, 5, utf8_decode($reg[0]['nomsucursal']), 0 , 0);
    
    //Linea de membrete Nro 2
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 16);
    $this->Cell(20, 5, 'DIREC. MATRIZ:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(47, 16);
    $this->Cell(20, 5,utf8_decode(utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "*********" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['departamento'] == '' ? "*********" : $reg[0]['departamento'])." ".$reg[0]['direcsucursal'])), 0 , 0);
    
    //Linea de membrete Nro 3
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 20);
    $this->Cell(20, 5, 'DIREC. SUCURSAL:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(52, 20);
    $this->Cell(20, 5,utf8_decode(utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "*********" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['departamento'] == '' ? "*********" : $reg[0]['departamento'])." ".$reg[0]['direcsucursal'])), 0 , 0);
    
    //Linea de membrete Nro 4
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 24);
    $this->Cell(20, 5, 'CONTRIBUYENTE ESPECIAL:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(65, 24);
    $this->Cell(20, 5,utf8_decode($reg[0]['direcsucursal']), 0 , 0);

    //Linea de membrete Nro 4
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 28);
    $this->Cell(20, 5, 'OBLIGADO A LLEVAR CONTABILIDAD:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(82, 28);
    $this->Cell(20, 5,utf8_decode($reg[0]['llevacontabilidad']), 0 , 0);
    ######################### BLOQUE N° 1 ######################### 


    ############################### BLOQUE N° 2 ##################################### 
    //Bloque de datos de chofer
    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 36, 245, 24, '1.5', '');

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 37);
    $this->Cell(20, 5, 'IDENTIF (TRANSPORTISTA):', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(78, 37);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);

  //Linea de membrete Nro 3
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 41);
    $this->Cell(90, 5, 'RAZÓN SOC / NOMBRE Y APELLIDOS:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(78, 41);
    $this->Cell(90, 5,utf8_decode(""), 0 , 0);

    //Linea de membrete Nro 4
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 45);
    $this->Cell(90, 5, 'PLACA:', 0 , 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(78, 45);
    $this->Cell(90, 5,utf8_decode(""), 0 , 0);

     //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(178, 45);
    $this->Cell(20, 5, 'N° DE BULTOS :', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(210, 45);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);

      //Linea de membrete Nro 5
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 49);
    $this->Cell(20, 5, 'PUNTO DE PARTIDA:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(78, 49);
    $this->Cell(20, 5,utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "*********" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['departamento'] == '' ? "*********" : $reg[0]['departamento'])." ".$reg[0]['direcsucursal']), 0 , 0);

    //Linea de membrete Nro 6
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 53);
    $this->Cell(20, 5, 'FECHA INICIO TRANSPORTE:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(78, 53);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);

    //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(178, 53);
    $this->Cell(20, 5, 'FECHA FIN TRANSPORTE:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(220, 53);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);
    ############################### BLOQUE N° 2 ##################################### 


    ############################### BLOQUE N° 3 ##################################### 
    //Bloque de datos de factura
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 62, 245, 27, '1.5', '');

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 63);
    $this->Cell(20, 5, 'COMPROBANTE DE VENTA:', 0 , 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(78, 63);
    $this->Cell(20, 5,utf8_decode($reg[0]['tipodocumento']." ".$reg[0]['codfactura']), 0 , 0);

    //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(178, 63);
    $this->Cell(20, 5, 'FECHA EMISIÓN :', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(210, 63);
    $this->Cell(20, 5,utf8_decode(date("d-m-Y")), 0 , 0);

    //Linea de membrete Nro 3
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 67);
    $this->Cell(70, 5, 'NÚMERO DE AUTORIZACIÓN:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(78, 67);
    $this->Cell(75, 5,utf8_decode($reg[0]['codautorizacion']), 0 , 0);

    //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(178, 67);
    $this->Cell(20, 5, 'RUTA:', 0 , 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(192, 67);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);

    //Linea de membrete Nro 4
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 71);
    $this->Cell(90, 5, 'MOTIVO DE TRASLADO:', 0 , 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(78, 71);
    $this->Cell(90, 5,utf8_decode(""), 0 , 0);

    //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(178, 71);
    $this->Cell(20, 5, 'CIUDAD:', 0 , 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(192, 71);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);

    //Linea de membrete Nro 5
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 75);
    $this->Cell(20, 5, 'RAZÓN SOC / NOMBRE Y APELLIDOS:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(78, 75);
    $this->Cell(20, 5,utf8_decode($reg[0]['nomencargado']), 0 , 0);

    //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(178, 75);
    $this->Cell(20, 5, 'IDENTIF. (DESTINATARIO):', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(227, 75);
    $this->Cell(20, 5,utf8_decode($reg[0]['dniencargado']), 0 , 0);

    //Linea de membrete Nro 6
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 79);
    $this->Cell(20, 5, 'ESTABLECIMIENTO:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(78, 79);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);

   //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 83);
    $this->Cell(20, 5, 'DESTINO (PUNTO DE LLEGADA):', 0 , 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(78, 83);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);
    
    ############################### BLOQUE N° 3 #####################################


    ############################### BLOQUE N° 4 ##################################### 
    //Bloque de membrete principal
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(257, 10, 88, 79, '1.5', '');
    
    //Linea de membrete Nro 2
    $this->SetFont('courier','B',14);
    $this->SetXY(258, 16);
    $this->Cell(20, 5, 'Nº DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : $reg[0]['documento'].":"), 0 , 0);
    $this->SetFont('courier','',14);
    $this->SetXY(295, 16);
    $this->Cell(20, 5,utf8_decode($reg[0]['cuitsucursal']), 0 , 0);

    //Linea de membrete Nro 1
    $this->SetFont('courier','B',18);
    $this->SetXY(258, 28);
    $this->Cell(20, 5,"GUIA DE REMISIÓN", 0 , 0);
    
    //Linea de membrete Nro 2
    $this->SetFont('courier','B',14);
    $this->SetXY(258, 38);
    $this->Cell(20, 5, 'N°:', 0 , 0);
    $this->SetFont('courier','B',14);
    $this->SetXY(268, 38);
    $this->Cell(20, 5,utf8_decode($reg[0]['codfactura']), 0 , 0);

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',14);
    $this->SetXY(258, 48);
    $this->Cell(20, 5, 'AMBIENTE:', 0 , 0);
    $this->SetFont('courier','B',14);
    $this->SetXY(286, 48);
    $this->Cell(20, 5,"PRODUCCIÓN", 0 , 0);

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',14);
    $this->SetXY(258, 54);
    $this->Cell(20, 5, 'EMISIÓN:', 0 , 0);
    $this->SetFont('courier','B',14);
    $this->SetXY(286, 54);
    $this->Cell(20, 5,utf8_decode("NORMAL"), 0 , 0);

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',14);
    $this->SetXY(258, 66);
    $this->Cell(20, 5, 'CLAVE ACCESO - N° DE AUTORIZ:', 0 , 0);

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',14);
    $this->SetXY(258, 76);
    $this->Codabar(260,75,utf8_decode($reg[0]['codautorizacion']));
    $this->Ln(10);
    ############################### BLOQUE N° 4 ##################################### 


    ############################### BLOQUE N° 5 ##################################### 
    //Bloque Cuadro de Detalles de Productos
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 92, 335, 70, '0', '');

    $this->Ln(6);
    $this->SetFont('courier','B',9);
    $this->SetTextColor(3, 3, 3); // Establece el color del texto (en este caso es Negro)
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->Cell(10,8,'N°',1,0,'C', True);
    $this->Cell(30,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(20,8,'MARCA',1,0,'C', True);
    $this->Cell(20,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'CANTIDAD',1,0,'C', True);
    $this->Cell(30, 8,"PRECIO/UNIT", 1, 0, 'C', True);
    $this->Cell(30, 8,"VALOR/TOTAL", 1, 0, 'C', True);
    $this->Cell(20, 8,"DESC %", 1, 0, 'C', True);
    $this->Cell(20, 8,$impuesto, 1, 0, 'C', True);
    $this->Cell(30, 8,"VALOR/NETO", 1, 0, 'C', True);
    $this->Cell(35,8,'TIPO',1,1,'C', True);
    ############################### BLOQUE N° 5 #####################################


    ############################### BLOQUE N° 6 #####################################
    $tra = new Login();
    $detalle = $tra->VerDetallesVentas();
    $cantidad = 0;
    $SubTotal = 0;

     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(9,30,70,20,20,20,30,30,20,20,30,34));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $cantidad += $detalle[$i]['cantventa'];
    $valortotal = $detalle[$i]["precioventa"]*$detalle[$i]["cantventa"];
    $SubTotal += $detalle[$i]['valorneto'];

    $this->SetX(11);
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->SetFillColor(255, 255, 255); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->RowFacture2(array($a++,
        utf8_decode($detalle[$i]["codproducto"]),
        portales(utf8_decode($detalle[$i]["producto"])),
        utf8_decode($detalle[$i]["codmarca"] == '0' ? "******" : $detalle[$i]["nommarca"]),
        utf8_decode($modelo = ($detalle[$i]["codmodelo"] == '0' ? "*********" : $detalle[$i]["nommodelo"])),
        utf8_decode($detalle[$i]["cantventa"]),
        utf8_decode($simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ',')),
        utf8_decode(number_format($detalle[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($detalle[$i]["ivaproducto"] == 'SI' ? number_format($reg[0]["iva"], 2, '.', ',')."%" : "(E)"),
        utf8_decode($simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ',')),
        utf8_decode($modelo = ($detalle[$i]["codpresentacion"] == '0' ? "*********" : $detalle[$i]["nompresentacion"]))));
  }
    ############################### BLOQUE N° 6 #####################################

    ########################### BLOQUE N° 8 #############################    
    //Bloque de Informacion adicional
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 165, 240, 34, '1.5', '');

    //Linea de membrete Nro 1
    $this->SetFont('courier','B',12);
    $this->SetXY(12, 166);
    $this->Cell(235, 4, 'INFORMACIÓN ADICIONAL', 0, 0, 'C');

   //Linea de membrete Nro 2
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 170);
    $this->Cell(50, 5, 'CANTIDAD DE PRODUCTOS:', 0, 0);
    $this->SetXY(62, 170);
    $this->SetFont('courier','',10);
    $this->Cell(20, 5,utf8_decode($cantidad), 0, 0);

    //Linea de membrete Nro 3
    $this->SetFont('courier','B',10);
    $this->SetXY(105, 170);
    $this->Cell(50, 5, 'TIPO DE DOCUMENTO:', 0, 0);
    $this->SetXY(155, 170);
    $this->SetFont('courier','',10);
    $this->Cell(30, 5,utf8_decode($reg[0]['tipodocumento']), 0, 0);

    //Linea de membrete Nro 4
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 175);
    $this->Cell(50, 5, 'TIPO DE PAGO:', 0, 0);
    $this->SetXY(62, 175);
    $this->SetFont('courier','',10);
    $this->Cell(20, 5,utf8_decode($reg[0]['tipopago']), 0, 0);

    if($reg[0]['tipopago']=="CREDITO"){

   //Linea de membrete Nro 5
    $this->SetFont('courier','B',10);
    $this->SetXY(105, 175);
    $this->Cell(50, 5, 'FECHA DE VENCIMIENTO:', 0, 0);
    $this->SetXY(155, 175);
    $this->SetFont('courier','',10);
    $this->Cell(30, 5,utf8_decode($vence = ( $reg[0]['fechavencecredito'] == '0000-00-00' ? "0" : date("d-m-Y",strtotime($reg[0]['fechavencecredito'])))), 0, 0);

    //Linea de membrete Nro 6
    $this->SetFont('courier','B',10);
    $this->SetXY(190, 175);
    $this->Cell(35, 5, 'DIAS VENCIDOS:', 0, 0);
    $this->SetXY(225, 175);
    $this->SetFont('courier','',10);

        if($reg[0]['fechavencecredito']== '0000-00-00') { 
            $this->Cell(22, 5,utf8_decode("0"), 0, 0);
   } elseif($reg[0]['fechavencecredito'] >= date("Y-m-d")) { 
            $this->Cell(22, 5,utf8_decode("0"), 0, 0);
   } elseif($reg[0]['fechavencecredito'] < date("Y-m-d")) { 
            $this->Cell(22, 5,utf8_decode(Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito'])), 0, 0);
   }
    }
    
    //Linea de membrete Nro 4
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 180);
    $this->Cell(50, 5, 'MEDIO DE PAGO:', 0, 0);
    $this->SetXY(62, 180);
    $this->SetFont('courier','',10);
    $this->Cell(20, 5,utf8_decode($variable = ($reg[0]['tipopago'] == 'CONTADO' ? $reg[0]['mediopago'] : $reg[0]['formapago'])), 0, 0);

    //Linea de membrete Nro 4
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 185);
    $this->MultiCell(236,4,$this->SetFont('Courier','',10).utf8_decode(numtoletras(number_format($reg[0]['totalpago'], 2, '.', ''))),0,'J');

    //Linea de membrete Nro 5
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 189);
    $this->MultiCell(236,3,$this->SetFont('Courier','',10).utf8_decode($reg[0]["observaciones"]=="" ? "" : "OBSERVACIONES: ".$reg[0]["observaciones"]), 0,'J');
########################### BLOQUE N° 8 #############################    
  
########################### BLOQUE N° 9 #############################    
    //Bloque de Totales de factura
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(253, 165, 92, 34, '1.5', '');

    //Linea de membrete Nro 1
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 166);
    $this->CellFitSpace(44, 5, 'SUBTOTAL:', 0, 0);
    $this->SetXY(298, 166);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($SubTotal, 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 170);
    $this->CellFitSpace(44, 5, 'TOTAL GRAVADO ('.number_format($reg[0]["iva"], 2, '.', ',').'%):', 0, 0);
    $this->SetXY(298, 170);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["subtotalivasi"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 3
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 174);
    $this->CellFitSpace(44, 5, 'TOTAL EXENTO (0%):', 0, 0);
    $this->SetXY(298, 174);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["subtotalivano"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 4
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 178);
    $this->CellFitSpace(44, 5, $impuesto == '' ? "TOTAL IMP." : "TOTAL ".$impuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):", 0, 0);
    $this->SetXY(298, 178);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["totaliva"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 3
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 182);
    $this->CellFitSpace(44, 5, 'DESCONTADO %:', 0, 0);
    $this->SetXY(298, 182);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["descontado"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 5
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 186);
    $this->CellFitSpace(44, 5, "DESC. GLOBAL (".number_format($reg[0]["descuento"], 2, '.', ',').'%):', 0, 0);
    $this->SetXY(298, 186);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["totaldescuento"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 6
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 190);
    $this->CellFitSpace(44, 5, 'IMPORTE TOTAL:', 0, 0);
    $this->SetXY(298, 190);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["totalpago"], 2, '.', ',')), 0, 0, "R");
    ########################### BLOQUE N° 9 #############################     
}
########################## FUNCION GUIA VENTA ##############################

########################## FUNCION NOTA VENTA (MITAD) #############################
function NotaVenta()
{
   
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->VentasPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

    $logo = "./fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
    $this->Image($logo, 10, 4.5, 20, 10, "PNG");
    //$this->Ln(6);

    }

    //Bloque datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(5, 15, 42, 25, '1.5', "");
    
    $this->SetFont('Courier','BI',8);
    $this->SetTextColor(3,3,3); // Establece el color del texto (en este caso es Negro)
    $this->SetXY(5, 15);
    $this->CellFitSpace(42, 5,utf8_decode($reg[0]['nomsucursal']), 0, 1); //Membrete Nro 1

    $this->SetFont('Courier','B',6);
    if($reg[0]['id_provincia']!='0'){
    $this->SetX(5);
    $this->CellFitSpace(42, 3,utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "" : $reg[0]['provincia']." ").$departamento = ($reg[0]['departamento'] == '' ? "" : $reg[0]['departamento']." ")), 0,1);
    }

    $this->SetX(5);
    $this->CellFitSpace(42, 3,$reg[0]['direcsucursal'], 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,'Nº DE ACTIVIDAD: '.$reg[0]['nroactividadsucursal'], 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,'Nº TLF: '.utf8_decode($reg[0]['tlfsucursal']), 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,utf8_decode($reg[0]['correosucursal']), 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,'OBLIGADO A LLEVAR CONTABILIDAD: '.utf8_decode($reg[0]['llevacontabilidad']), 0 , 0); 
      
    //Bloque datos de factura
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(48, 5, 57, 35, '1.5', "");

    $this->SetFont('Courier','B',10);
    $this->SetXY(48, 4);
    $this->Cell(5, 7, 'NOTA DE VENTA', 0 , 0);


    $this->SetFont('Courier','B',7);
    $this->SetXY(48, 7);
    $this->Cell(5, 7, 'Nº DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : $reg[0]['documento'].":"), 0 , 0);
    $this->SetXY(78, 7);
    $this->CellFitSpace(28, 7,utf8_decode($reg[0]['cuitsucursal']), 0, 0);

    $this->SetXY(48, 10);
    $this->SetFont('Courier','B',8);
    $this->Cell(5, 7, 'Nº DE NOTA', 0 , 0);
    $this->SetXY(78, 10);
    $this->CellFitSpace(28, 7,utf8_decode($reg[0]['codfactura']), 0, 0);

    $this->SetXY(48, 13);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'NÚMERO DE AUTORIZACIÓN:', 0, 0);
    $this->SetXY(48, 16);
    $this->CellFitSpace(56, 7,utf8_decode($reg[0]['codautorizacion']), 0, 0);

    $this->SetXY(48, 19);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'NÚMERO DE SERIE:', 0, 0);
    $this->SetXY(48, 22);
    $this->CellFitSpace(56, 7,utf8_decode($reg[0]['codserie']), 0, 0);

    $this->SetXY(48, 25);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,"FECHA DE AUTORIZACIÓN:", 0, 0);
    $this->SetXY(78, 25);
    $this->Cell(28, 7,$fecha = ($reg[0]['fechaautorsucursal'] == '0000-00-00' ? "" : date("d-m-Y",strtotime($reg[0]['fechaautorsucursal']))), 0, 0);

    $this->SetXY(48, 28);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,"FECHA DE VENTA:", 0, 0);
    $this->SetXY(78, 28);
    $this->Cell(28, 7,date("d-m-Y H:i:s",strtotime($reg[0]['fechaventa'])), 0, 0);


    $this->SetXY(48, 31);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'AMBIENTE: ', 0 , 0);
    $this->SetXY(78, 31);
    $this->Cell(28, 7,'PRODUCCIÓN', 0 , 0);

    $this->SetXY(48, 34);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'EMISIÓN: ', 0 , 0);
    $this->SetXY(78, 34);
    $this->Cell(28, 7,'NORMAL', 0 , 0);
     
    //Bloque datos de cliente
    $this->SetLineWidth(0.3);
    $this->SetFillColor(192);
    $this->RoundedRect(5, 41, 100, 10, '1.5', "");
    $this->SetFont('Courier','B',6);

    $this->SetXY(6, 40.2);
    $this->CellFitSpace(66, 5,'RAZÓN SOCIAL: '.utf8_decode($reg[0]['codcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']), 0, 0);
    $this->CellFitSpace(32, 5,'Nº DE '.$documento = ($reg[0]['documcliente'] == '' ? "DOC: " : $reg[0]['documento'].": ").$dni = ($reg[0]['dnicliente'] == '' ? "**********" : $reg[0]['dnicliente']), 0, 0);

    $this->SetXY(6, 43.2);
    $this->CellFitSpace(66, 5,'DIRECCIÓN: '.utf8_decode($reg[0]['direccliente'] == '' ? "**********" : $reg[0]['direccliente']), 0, 0);
    $this->CellFitSpace(32, 5,'Nº DE TLF: '.($reg[0]['tlfcliente'] == '' ? "**********" : $reg[0]['tlfcliente']), 0, 0);

    $this->SetXY(6, 46.2);
    $this->CellFitSpace(92, 5,'EMAIL: '.utf8_decode($reg[0]['emailcliente'] == '' ? "**********" : $reg[0]['emailcliente']), 0, 0);

    $this->Ln(6);
    $this->SetX(5);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(5,3,'N°',1,0,'C', True);
    $this->Cell(50,3,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(12,3,'CANTIDAD',1,0,'C', True);
    $this->Cell(14,3,'PRECIO',1,0,'C', True);
    $this->Cell(19,3,'IMPORTE',1,1,'C', True);
    
    $tra = new Login();
    $detalle = $tra->VerDetallesVentas();
    $cantidad = 0;
    $SubTotal = 0;

    $this->SetWidths(array(5,50,12,14,19));

    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $cantidad += $detalle[$i]['cantventa'];
    $valortotal = $detalle[$i]["precioventa"]*$detalle[$i]["cantventa"];
    $SubTotal += $detalle[$i]['valorneto'];

    $this->SetX(5);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier',"",6);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->RowFacture(array($a++,portales(utf8_decode($detalle[$i]["producto"])),utf8_decode($detalle[$i]['cantventa']),utf8_decode(number_format($detalle[$i]["precioventa"], 2, '.', ',')),utf8_decode(number_format($detalle[$i]['valorneto'], 2, '.', ','))));
       
    }
     
    $this->Ln(1);
    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'INFORMACIÓN ADICIONAL',1,0,'C');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->SetFont('Courier','B',6);
    $this->CellFitSpace(20,3.5,'SUBTOTAL ',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($SubTotal, 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'Nº DE CAJA: '.utf8_decode($reg[0]['nrocaja']."-".$reg[0]['nomcaja']),1,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,'GRAVADO ('.number_format($reg[0]["iva"], 2, '.', ',').'%):',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["subtotalivasi"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'CAJERO(A): '.utf8_decode($reg[0]['nombres']),1,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,'EXENTO (0%):',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["subtotalivano"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'FECHA DE EMISIÓN: '.date("d-m-Y H:i:s"),1,0,'L');

    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,$impuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):",1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["totaliva"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'CONDICIÓN DE PAGO: '.utf8_decode($reg[0]['tipopago'])."          ".utf8_decode($reg[0]['tipopago'] == 'CONTADO' ? "" : "VENCIMIENTO: ".date("d-m-Y",strtotime($reg[0]['fechavencecredito']))),1,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,'DESCONTADO %:',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["descontado"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'MEDIO DE PAGO: '.utf8_decode($medio = ($reg[0]['tipopago'] == 'CONTADO' ? $reg[0]['mediopago'] : $reg[0]['formapago'])),1,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,'DESC % ('.number_format($reg[0]["descuento"], 2, '.', ',').'%):',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["totaldescuento"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(59,3.5,'',0,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->SetFont('Courier','B',6);
    $this->Cell(20,3.5,'IMPORTE TOTAL:',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["totalpago"], 2, '.', ','),1,0,'R');
    $this->Ln(4);
    
    $this->SetX(5);
    $this->SetDrawColor(3,3,3);
    $this->SetFont('Courier','BI',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(100,2,'MONTO EN LETRAS: '.utf8_decode(numtoletras(number_format($reg[0]['totalpago'], 2, '.', ''))),0,0,'L');
    $this->Ln();
}  
########################## FUNCION NOTA VENTA (MITAD) ##############################

########################## FUNCION LISTAR VENTAS ##############################
function TablaListarVentas()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);
    
    $tra = new Login();
    $reg = $tra->ListarVentas();

   ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO GENERAL DE VENTAS',0,0,'C');

    
if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'SUCURSAL',1,0,'C', True);
    $this->Cell(32,8,'Nº DE VENTA',1,0,'C', True);
    $this->Cell(50,8,'DESCRIPCIÓN DE CLIENTE',1,0,'C', True);
    $this->Cell(18,8,'STATUS',1,0,'C', True);
    $this->Cell(20,8,'PAGO',1,0,'C', True);
    $this->Cell(45,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(20,8,'Nº ARTIC',1,0,'C', True);
    $this->Cell(28,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(22,8,$impuesto,1,0,'C', True);
    $this->Cell(20,8,'DESC%',1,0,'C', True);
    $this->Cell(30,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,32,50,18,20,45,20,28,22,20,30));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalGravado=0;
    $TotalExento=0;
    $TotalImpuesto=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalGravado+=$reg[$i]['subtotalivasi'];
    $TotalExento+=$reg[$i]['subtotalivano'];
    $TotalImpuesto+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["nomsucursal"]),utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']),utf8_decode($reg[$i]["statusventa"]),utf8_decode($reg[$i]["tipopago"]),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa']))),utf8_decode($reg[$i]["articulos"]),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
   }
   
    $this->Cell(210,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(20,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->CellFitSpace(28,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(22,5,utf8_decode($simbolo.number_format($TotalImpuesto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(20,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    } else {

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE VENTA',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCIÓN DE CLIENTE',1,0,'C', True);
    $this->Cell(20,8,'STATUS',1,0,'C', True);
    $this->Cell(20,8,'PAGO',1,0,'C', True);
    $this->Cell(45,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(20,8,'Nº ARTIC',1,0,'C', True);
    $this->Cell(33,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(25,8,$impuesto,1,0,'C', True);
    $this->Cell(25,8,'DESC%',1,0,'C', True);
    $this->Cell(32,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,60,20,20,45,20,33,25,25,32));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalGravado=0;
    $TotalExento=0;
    $TotalImpuesto=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalGravado+=$reg[$i]['subtotalivasi'];
    $TotalExento+=$reg[$i]['subtotalivano'];
    $TotalImpuesto+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']),utf8_decode($reg[$i]["statusventa"]),utf8_decode($reg[$i]["tipopago"]),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa']))),utf8_decode($reg[$i]["articulos"]),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
   }
   
    $this->Cell(195,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(20,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->CellFitSpace(33,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalImpuesto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(32,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
 }
    }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR VENTAS ##############################

########################## FUNCION LISTAR VENTAS DIARIAS ##############################
function TablaListarVentasDiarias()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);
    
    $tra = new Login();
    $reg = $tra->BuscarVentasDiarias();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO GENERAL DE VENTAS DIARIAS DEL (DIA '.date("d-m-Y").")",0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE VENTA',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCIÓN DE CLIENTE',1,0,'C', True);
    $this->Cell(20,8,'Nº ARTIC',1,0,'C', True);
    $this->Cell(33,8,'TOTAL GRAVADO',1,0,'C', True);
    $this->Cell(33,8,'TOTAL EXENTO',1,0,'C', True);
    $this->Cell(34,8,'IMPORTE TOTAL',1,0,'C', True);
    $this->Cell(25,8,'STATUS',1,0,'C', True);
    $this->Cell(20,8,'PAGO',1,0,'C', True);
    $this->Cell(45,8,'FECHA EMISIÓN',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,70,20,33,33,34,25,20,45));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalGravado=0;
    $TotalExento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalGravado+=$reg[$i]['subtotalivasi'];
    $TotalExento+=$reg[$i]['subtotalivano'];
    $TotalImporte+=$reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']),utf8_decode($reg[$i]["articulos"]),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ',')),utf8_decode($reg[$i]["statusventa"]),utf8_decode($reg[$i]["tipopago"]),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])))));
   }
   
    $this->Cell(120,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(20,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->CellFitSpace(33,5,utf8_decode($simbolo.number_format($TotalGravado, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(33,5,utf8_decode($simbolo.number_format($TotalExento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(34,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
 }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR VENTAS DIARIAS ##############################

########################## FUNCION LISTAR VENTAS POR CAJAS ##############################
function TablaListarVentasxCajas()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);
    
    $tra = new Login();
    $reg = $tra->BuscarVentasxCajas();

   ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO DE VENTAS POR CAJAS',0,0,'C');

    
if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"Nº CAJA: ".utf8_decode($reg[0]["nrocaja"].": ".$reg[0]["nomcaja"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"RESPONSABLE DE CAJA: ".portales(utf8_decode($reg[0]["nombres"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE VENTA',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCIÓN DE CLIENTE',1,0,'C', True);
    $this->Cell(20,8,'STATUS',1,0,'C', True);
    $this->Cell(20,8,'PAGO',1,0,'C', True);
    $this->Cell(45,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(20,8,'Nº ARTIC',1,0,'C', True);
    $this->Cell(33,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(25,8,$impuesto,1,0,'C', True);
    $this->Cell(25,8,'DESC%',1,0,'C', True);
    $this->Cell(32,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,60,20,20,45,20,33,25,25,32));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalGravado=0;
    $TotalExento=0;
    $TotalImpuesto=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalGravado+=$reg[$i]['subtotalivasi'];
    $TotalExento+=$reg[$i]['subtotalivano'];
    $TotalImpuesto+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']),utf8_decode($reg[$i]["statusventa"]),utf8_decode($reg[$i]["tipopago"]),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa']))),utf8_decode($reg[$i]["articulos"]),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
   }
 }
   
    $this->Cell(195,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(20,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->CellFitSpace(33,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalImpuesto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(32,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR VENTAS POR CAJAS ##############################

########################## FUNCION LISTAR VENTAS POR FECHAS ##############################
function TablaListarVentasxFechas()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);
    
    $tra = new Login();
    $reg = $tra->BuscarVentasxFechas();

   ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO DE VENTAS POR FECHAS',0,0,'C');

    
if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'Nº DE CAJA',1,0,'C', True);
    $this->Cell(32,8,'Nº DE VENTA',1,0,'C', True);
    $this->Cell(50,8,'DESCRIPCIÓN DE CLIENTE',1,0,'C', True);
    $this->Cell(20,8,'STATUS',1,0,'C', True);
    $this->Cell(20,8,'PAGO',1,0,'C', True);
    $this->Cell(35,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(20,8,'Nº ARTIC',1,0,'C', True);
    $this->Cell(30,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(25,8,$impuesto,1,0,'C', True);
    $this->Cell(20,8,'DESC%',1,0,'C', True);
    $this->Cell(32,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,32,50,20,20,35,20,30,25,20,32));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalGravado=0;
    $TotalExento=0;
    $TotalImpuesto=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalGravado+=$reg[$i]['subtotalivasi'];
    $TotalExento+=$reg[$i]['subtotalivano'];
    $TotalImpuesto+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["nrocaja"].": ".$reg[$i]["nomcaja"]),utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']),utf8_decode($reg[$i]["statusventa"]),utf8_decode($reg[$i]["tipopago"]),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa']))),utf8_decode($reg[$i]["articulos"]),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
   }
 }
   
    $this->Cell(202,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(20,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalImpuesto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(20,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(32,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR VENTAS POR FECHAS ##############################

########################## FUNCION LISTAR VENTAS POR CLIENTES ##############################
function TablaListarVentasxClientes()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);
    
    $tra = new Login();
    $reg = $tra->BuscarVentasxClientes();

   ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO DE VENTAS POR CLIENTES',0,0,'C');

    
    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($documento = ($reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'])).": ".utf8_decode($reg[0]["dnicliente"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"NOMBRE DE CLIENTE: ".portales(utf8_decode($reg[0]["nomcliente"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(50,8,'Nº DE CAJA',1,0,'C', True);
    $this->Cell(40,8,'Nº DE VENTA',1,0,'C', True);
    $this->Cell(20,8,'STATUS',1,0,'C', True);
    $this->Cell(20,8,'PAGO',1,0,'C', True);
    $this->Cell(45,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(20,8,'Nº ARTIC',1,0,'C', True);
    $this->Cell(30,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(25,8,$impuesto,1,0,'C', True);
    $this->Cell(25,8,'DESC%',1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,50,40,20,20,45,20,30,25,25,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalGravado=0;
    $TotalExento=0;
    $TotalImpuesto=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalGravado+=$reg[$i]['subtotalivasi'];
    $TotalExento+=$reg[$i]['subtotalivano'];
    $TotalImpuesto+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["nrocaja"].": ".$reg[$i]["nomcaja"]),utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]["statusventa"]),utf8_decode($reg[$i]["tipopago"]),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa']))),utf8_decode($reg[$i]["articulos"]),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
   }
 }
   
    $this->Cell(190,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(20,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalImpuesto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR VENTAS POR CLIENTES ##############################

########################## FUNCION LISTAR COMISION POR VENTAS ##############################
function TablaListarComisionxVentas()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);
    
    $tra = new Login();
    $reg = $tra->BuscarComisionxVentas();

   ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO DE COMISIÓN POR VENTAS',0,0,'C');

    
    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"Nº DE DOCUMENTO: ".utf8_decode($reg[0]["dni"]),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"NOMBRE DE VENDEDOR: ".portales(utf8_decode($reg[0]["nombres"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(32,8,'Nº DE VENTA',1,0,'C', True);
    $this->Cell(50,8,'DESCRIPCIÓN DE CLIENTE',1,0,'C', True);
    $this->Cell(20,8,'STATUS',1,0,'C', True);
    $this->Cell(20,8,'PAGO',1,0,'C', True);
    $this->Cell(35,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(20,8,'Nº ARTIC',1,0,'C', True);
    $this->Cell(30,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(25,8,$impuesto,1,0,'C', True);
    $this->Cell(20,8,'DESC%',1,0,'C', True);
    $this->Cell(32,8,'IMPORTE TOTAL',1,0,'C', True);
    $this->Cell(30,8,'COMISIÓN',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,32,50,20,20,35,20,30,25,20,32,30));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalGravado=0;
    $TotalExento=0;
    $TotalImpuesto=0;
    $TotalDescuento=0;
    $TotalImporte=0;
    $TotalComision=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalGravado+=$reg[$i]['subtotalivasi'];
    $TotalExento+=$reg[$i]['subtotalivano'];
    $TotalImpuesto+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];
    $comision = number_format($reg[0]['comision']/100, 3, '.', ',');
    $TotalComision+=number_format($reg[$i]['totalpago']*$comision, 3, '.', ',');

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']),utf8_decode($reg[$i]["statusventa"]),utf8_decode($reg[$i]["tipopago"]),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa']))),utf8_decode($reg[$i]["articulos"]),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago']*$reg[0]['comision']/100, 2, '.', ','))));
   }
 }
   
    $this->Cell(172,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(20,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalImpuesto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(20,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(32,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalComision, 2, '.', ',')),0,0,'L');
    $this->Ln();

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COMISION POR VENTAS ##############################

####################### FUNCION LISTAR DETALLES DE VENTAS POR FECHAS ###########################
function TablaListarDetallesVentasxFechas()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarDetallesVentasxFechas(); 

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO DE DETALLES VENTAS POR FECHAS',0,0,'C'); 
   
   if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(330,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(330,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(330,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'TIPO',1,0,'C', True);
    $this->Cell(90,8,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(30,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'DESC',1,0,'C', True);
    $this->Cell(30,8,"PRECIO VENTA",1,0,'C', True);
    $this->Cell(30,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(25,8,'VENDIDO',1,0,'C', True);
    $this->Cell(30,8,'MONTO TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,30,90,30,30,20,30,30,25,30));

    $PrecioTotal=0;
    $ExisteTotal=0;
    $VendidosTotal=0;
    $PagoTotal=0;
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    $PrecioTotal+=$reg[$i]['precioventa'];
    $ExisteTotal+=$reg[$i]['tipodetalle'] == '1' ? $reg[$i]['existencia'] : "0";
    $VendidosTotal+=$reg[$i]['cantidad']; 

    $Descuento = $reg[$i]['descproducto']/100;
    $PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
    $PagoTotal+=$PrecioFinal*$reg[$i]['cantidad'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($reg[$i]['tipodetalle'] == 1 ? "PRODUCTO" : "SERVICIO"),
        portales(utf8_decode($reg[$i]["producto"])),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "*****" : $reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]["precioventa"], 2, '.', ',')),
        utf8_decode($reg[$i]['tipodetalle'] == '1' ? $reg[$i]['existencia'] : "******"),
        utf8_decode($reg[$i]['cantidad']),
        utf8_decode($simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','))));
  }
   }
   
    $this->Cell(215,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PrecioTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($ExisteTotal),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($VendidosTotal),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PagoTotal, 2, '.', ',')),0,0,'L');
    $this->Ln();
   

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4); 
}
###################### FUNCION LISTAR DETALLES DE VENTAS POR FECHAS ##########################

####################### FUNCION LISTAR DETALLES DE VENTAS POR VENDEDOR ###########################
function TablaListarDetallesVentasxVendedor()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarDetallesVentasxVendedor(); 

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO DE DETALLES VENTAS POR VENDEDOR',0,0,'C'); 
   
   if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(330,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(330,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(330,6,"VENDEDOR: ".portales(utf8_decode($reg[0]['nombres'])),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');    

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'TIPO',1,0,'C', True);
    $this->Cell(90,8,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(30,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'DESC',1,0,'C', True);
    $this->Cell(30,8,"PRECIO VENTA",1,0,'C', True);
    $this->Cell(30,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(25,8,'VENDIDO',1,0,'C', True);
    $this->Cell(30,8,'MONTO TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,30,90,30,30,20,30,30,25,30));

    $PrecioTotal=0;
    $ExisteTotal=0;
    $VendidosTotal=0;
    $PagoTotal=0;
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    $PrecioTotal+=$reg[$i]['precioventa'];
    $ExisteTotal+=$reg[$i]['tipodetalle'] == '1' ? $reg[$i]['existencia'] : "0";
    $VendidosTotal+=$reg[$i]['cantidad']; 

    $Descuento = $reg[$i]['descproducto']/100;
    $PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
    $PagoTotal+=$PrecioFinal*$reg[$i]['cantidad'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($reg[$i]['tipodetalle'] == 1 ? "PRODUCTO" : "SERVICIO"),
        portales(utf8_decode($reg[$i]["producto"])),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "*****" : $reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]["precioventa"], 2, '.', ',')),
        utf8_decode($reg[$i]['tipodetalle'] == '1' ? $reg[$i]['existencia'] : "******"),
        utf8_decode($reg[$i]['cantidad']),
        utf8_decode($simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','))));
  }
   }
   
    $this->Cell(215,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PrecioTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($ExisteTotal),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($VendidosTotal),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PagoTotal, 2, '.', ',')),0,0,'L');
    $this->Ln();
   

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
###################### FUNCION LISTAR DETALLES DE VENTAS POR VENDEDOR ##########################

################################### REPORTES DE VENTAS ##################################


































############################## REPORTES DE CREDITOS ##################################

########################## FUNCION TICKET CREDITO ##############################
function TicketCredito()
{  
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);

    $tra = new Login();
    $reg = $tra->CreditosPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

    $logo = "./fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
    $this->Image($logo , 20, 3, 35, 15, "PNG");
    $this->Ln(8);

    }
  
    $this->SetX(4);
    $this->SetFont('Courier','B',12);
    $this->SetFillColor(2,157,116);
    $this->Cell(66, 5, "TICKET DE CRÉDITO", 0, 0, 'C');
    $this->Ln(5);
  
    $this->SetX(4);
    $this->SetFont('Courier','B',10);
    $this->CellFitSpace(66,4,utf8_decode($reg[0]['nomsucursal']), 0, 1, 'C');

    $this->SetX(4);
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(66,3,$reg[0]['documsucursal'] == '0' ? "" : "Nº ".$reg[0]['documento']." ".utf8_decode($reg[0]['cuitsucursal']),0,1,'C');

    if($reg[0]['id_provincia']!='0'){

    $this->SetX(4);
    $this->CellFitSpace(66,3,utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['departamento'] == '' ? "" : $reg[0]['departamento'])),0,1,'C');

    }

    $this->SetX(4);
    $this->CellFitSpace(66,3,utf8_decode($reg[0]['direcsucursal']),0,1,'C');

    $this->SetX(4);
    $this->CellFitSpace(66,3,"OBLIGADO A LLEVAR CONTABILIDAD: ".utf8_decode($reg[0]['llevacontabilidad']),0,1,'C');
    
    $this->SetX(4);
    $this->CellFitSpace(66,3,"Nº DE TICKET: ".utf8_decode($reg[0]['codfactura']),0,1,'C');
    
    $this->SetX(2);
    $this->SetFont('courier','B',8);
    $this->Cell(70,3,'--------------- CLIENTE ---------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(15,3,$documento = ($reg[0]['documcliente'] == '0' ? "Nº DOC:" : "Nº ".$reg[0]['documento'].": "),0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(51,3,utf8_decode($reg[0]['dnicliente']),0,1,'L');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(15,3,"SEÑOR(A):",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->MultiCell(51,3,$this->SetFont('Courier','B',8).utf8_decode($reg[0]['nomcliente']),0,'L');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(15,3,"DIREC:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->MultiCell(51,3,$this->SetFont('Courier','B',8).portales(utf8_decode(getSubString($reg[0]['direccliente'],32))),0,'L');

    $this->SetFont('courier','B',8);
    $this->SetX(2);
    $this->Cell(70,3,'---------- DETALLES DE ABONO ----------',0,1,'C');
    $this->Ln(1);

    $this->SetX(4);
    $this->SetFont('courier','B',7);
    $this->SetTextColor(3, 3, 3); // Establece el color del texto (en este caso es Negro)
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->Cell(16,3,"Nº CAJA",0,0,'C');
    $this->Cell(24,3,"MONTO DE ABONO",0,0,'C');
    $this->Cell(26,3,"FECHA",0,1,'C');

    $this->SetFont('courier','B',8);
    $this->SetX(2);
    $this->Cell(70,3,'---------------------------------------',0,0,'C');
    $this->Ln(3);

    $tra = new Login();
    $detalle = $tra->VerDetallesAbonos();
    if($detalle==""){
    
    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->Cell(70,3,'NO SE ENCONTRARON ABONOS',0,0,'C');
    $this->Ln(3);

    } else {
    $cantidad=0;

     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(22,22,22));

    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){

    $this->SetX(4);
    $this->SetFont('courier','',7);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->CellFitSpace(16,4,utf8_decode($detalle[$i]['nrocaja']),0,0,'C');
    $this->CellFitSpace(24,4,utf8_decode($simbolo.number_format($detalle[$i]['montoabono'], 2, '.', ',')),0,0,'C');
    $this->CellFitSpace(26,4,utf8_decode(date("d-m-Y H:i:s",strtotime($detalle[$i]['fechaabono']))),0,0,'C');
    $this->Ln();  
  }
    }

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->Cell(70,3,'---------------------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"IMPORTE TOTAL:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(36,3,utf8_decode($simbolo.number_format($reg[0]["totalpago"], 2, '.', ',')),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"TOTAL ABONADO:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(36,3,utf8_decode($simbolo.number_format($reg[0]["creditopagado"], 2, '.', ',')),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"TOTAL DEBE:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(36,3,utf8_decode($simbolo.number_format($reg[0]["totalpago"]-$reg[0]["creditopagado"], 2, '.', ',')),0,1,'R');


    $this->SetFont('Courier','B',8);
    $this->SetX(2);
    $this->Cell(70,3,'---------------------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"STATUS PAGO:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(36,3,utf8_decode($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00" && $reg[0]['statusventa'] == "PENDIENTE" ? "VENCIDA" : $reg[0]["statusventa"]),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"VENCE CRÉDITO:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(36,3,utf8_decode(date("d-m-Y",strtotime($reg[0]["fechavencecredito"]))),0,1,'R');

    $this->SetX(4);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"DIAS VENCIDOS:",0,0,'L');
    $this->SetFont('Courier','',8);

    if($reg[0]['fechavencecredito']== '0000-00-00') { 
        $this->CellFitSpace(36,3,utf8_decode("0"),0,1,'R');
    } elseif($reg[0]['fechavencecredito'] >= date("Y-m-d")) { 
        $this->CellFitSpace(36,3,utf8_decode("0"),0,1,'R');
    } elseif($reg[0]['fechavencecredito'] < date("Y-m-d")) { 
        $this->CellFitSpace(36,3,utf8_decode(Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito'])),0,1,'R');
    }

    $this->SetFont('Courier','B',8);
    $this->SetX(2);
    $this->Cell(70,3,'---------------------------------------',0,0,'C');
    $this->Ln(3); 
    
}
########################## FUNCION TICKET CREDITO ##############################

########################## FUNCION LISTAR CREDITOS ##############################
function TablaListarCreditos()
{

    $tra = new Login();
    $reg = $tra->ListarCreditos();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO GENERAL DE CRÉDITOS',0,0,'C');

    
if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE VENTA',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCIÓN DE CLIENTE',1,0,'C', True);
    $this->Cell(30,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(34,8,'IMPORTE TOTAL',1,0,'C', True);
    $this->Cell(30,8,'TOTAL ABONO',1,0,'C', True);
    $this->Cell(30,8,'TOTAL DEBE',1,0,'C', True);
    $this->Cell(22,8,'STATUS',1,0,'C', True);
    $this->Cell(40,8,'FECHA DE EMISIÓN',1,0,'C', True);
    $this->Cell(30,8,'SUCURSAL',1,1,'C', True);


    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,60,30,34,30,30,22,40,30));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalImporte=0;
    $TotalAbono=0;
    $TotalDebe=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    
    $TotalImporte+=$reg[$i]['totalpago'];
    $TotalAbono+=$reg[$i]['creditopagado'];
    $TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['creditopagado'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']),utf8_decode($reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($reg[$i]["statusventa"]),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa']))),utf8_decode($reg[$i]["nomsucursal"])));
   }
   
    $this->Cell(140,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(34,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();
 }

    } else {

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE VENTA',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCIÓN DE CLIENTE',1,0,'C', True);
    $this->Cell(40,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(35,8,'IMPORTE TOTAL',1,0,'C', True);
    $this->Cell(30,8,'TOTAL ABONO',1,0,'C', True);
    $this->Cell(35,8,'TOTAL DEBE',1,0,'C', True);
    $this->Cell(30,8,'STATUS',1,0,'C', True);
    $this->Cell(50,8,'FECHA EMISIÓN',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,60,40,35,30,35,30,50));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalImporte=0;
    $TotalAbono=0;
    $TotalDebe=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    
    $TotalImporte+=$reg[$i]['totalpago'];
    $TotalAbono+=$reg[$i]['creditopagado'];
    $TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['creditopagado'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']),utf8_decode($reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($reg[$i]["statusventa"]),
        utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])))));

   }
   
    $this->Cell(150,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();
 }
    }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CREDITOS ##############################

######################## FUNCION LISTAR CREDITOS POR CLIENTES ########################
function TablaListarCreditosxClientes()
{

    $tra = new Login();
    $reg = $tra->BuscarCreditosxClientes();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################

    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO DE CRÉDITOS POR CLIENTES ',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(330,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(330,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE VENTA',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCIÓN DE CLIENTE',1,0,'C', True);
    $this->Cell(50,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(35,8,'IMPORTE TOTAL',1,0,'C', True);
    $this->Cell(30,8,'TOTAL ABONO',1,0,'C', True);
    $this->Cell(35,8,'TOTAL DEBE',1,0,'C', True);
    $this->Cell(25,8,'STATUS',1,0,'C', True);
    $this->Cell(45,8,'FECHA EMISIÓN',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,60,50,35,30,35,25,45));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalImporte=0;
    $TotalAbono=0;
    $TotalDebe=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    
    $TotalImporte+=$reg[$i]['totalpago'];
    $TotalAbono+=$reg[$i]['creditopagado'];
    $TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['creditopagado'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']),utf8_decode($reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($reg[$i]["statusventa"]),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])))));
   }
 }
   
    $this->Cell(160,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();
    

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CREDITOS POR CLIENTES ########################

########################## FUNCION LISTAR CREDITOS POR FECHAS #########################
function TablaListarCreditosxFechas()
{

    $tra = new Login();
    $reg = $tra->BuscarCreditosxFechas();

     ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO DE CRÉDITOS VENTAS POR FECHAS',0,0,'C');
    
    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L'); 

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE VENTA',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCIÓN DE CLIENTE',1,0,'C', True);
    $this->Cell(50,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(35,8,'IMPORTE TOTAL',1,0,'C', True);
    $this->Cell(30,8,'TOTAL ABONO',1,0,'C', True);
    $this->Cell(35,8,'TOTAL DEBE',1,0,'C', True);
    $this->Cell(25,8,'STATUS',1,0,'C', True);
    $this->Cell(45,8,'FECHA EMISIÓN',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,60,50,35,30,35,25,45));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalImporte=0;
    $TotalAbono=0;
    $TotalDebe=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    
    $TotalImporte+=$reg[$i]['totalpago'];
    $TotalAbono+=$reg[$i]['creditopagado'];
    $TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['creditopagado'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']),utf8_decode($reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($reg[$i]["statusventa"]),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])))));
   }
 }
   
    $this->Cell(160,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();
    

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CREDITOS POR FECHAS #########################

########################## FUNCION LISTAR CREDITOS POR DETALLES #########################
function TablaListarCreditosxDetalles()
{

    $tra = new Login();
    $reg = $tra->BuscarCreditosxDetalles();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO DE VENTAS A CRÉDITOS POR CLIENTE Y FECHAS',0,0,'C');
    
    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(330,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(330,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(330,5,"CLIENTE: ".portales(utf8_decode($reg[0]["dnicliente"].": ".$reg[0]["nomcliente"])),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');
 
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE VENTA',1,0,'C', True);
    $this->Cell(50,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(60,8,'DETALLES D EPRODUCTOS',1,0,'C', True);
    $this->Cell(35,8,'IMPORTE TOTAL',1,0,'C', True);
    $this->Cell(30,8,'TOTAL ABONO',1,0,'C', True);
    $this->Cell(35,8,'TOTAL DEBE',1,0,'C', True);
    $this->Cell(25,8,'STATUS',1,0,'C', True);
    $this->Cell(45,8,'FECHA EMISIÓN',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,50,60,35,30,35,25,45));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalImporte=0;
    $TotalAbono=0;
    $TotalDebe=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    
    $TotalImporte+=$reg[$i]['totalpago'];
    $TotalAbono+=$reg[$i]['creditopagado'];
    $TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['creditopagado'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']),utf8_decode(str_replace("<br>","\n", $reg[$i]['detalles'])),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($reg[$i]["statusventa"]),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])))));
   }
 }
   
    $this->Cell(160,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();
    

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CREDITOS POR DETALLES #########################

############################### REPORTES DE CREDITOS ###############################













































############################## REPORTES DE NOTAS DE CREDITOS ##################################

########################## FUNCION NOTA DE CREDITO (MITAD) #############################
function NotaCredito()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);

    $tra = new Login();
    $reg = $tra->NotaCreditoPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
   
    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

    $logo = "./fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
    $this->Image($logo, 10, 4.5, 20, 10, "PNG");
    $this->Ln(6);

    }
        
    //Bloque datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(5, 15, 42, 25, '1.5', "");
    
    $this->SetFont('Courier','BI',8);
    $this->SetTextColor(3,3,3); // Establece el color del texto (en este caso es Negro)
    $this->SetXY(5, 15);
    $this->CellFitSpace(42, 5,utf8_decode($reg[0]['nomsucursal']), 0, 1); //Membrete Nro 1

    $this->SetFont('Courier','B',6);
    if($reg[0]['id_provincia']!='0'){
    $this->SetX(5);
    $this->CellFitSpace(42, 3,utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "" : $reg[0]['provincia']." ").$departamento = ($reg[0]['departamento'] == '' ? "" : $reg[0]['departamento']." ")), 0,1);
    }

    $this->SetX(5);
    $this->CellFitSpace(42, 3,$reg[0]['direcsucursal'], 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,'Nº DE ACTIVIDAD: '.$reg[0]['nroactividadsucursal'], 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,'Nº TLF: '.utf8_decode($reg[0]['tlfsucursal']), 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,utf8_decode($reg[0]['correosucursal']), 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,'OBLIGADO A LLEVAR CONTABILIDAD: '.utf8_decode($reg[0]['llevacontabilidad']), 0 , 0); 
      
    //Bloque datos de factura
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(48, 5, 57, 35, '1.5', "");

    $this->SetFont('Courier','B',10);
    $this->SetXY(48, 4);
    $this->Cell(5, 7, 'NOTA DE CRÉDITO', 0 , 0);


    $this->SetFont('Courier','B',7);
    $this->SetXY(48, 7);
    $this->Cell(5, 7, 'Nº DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : $reg[0]['documento'].":"), 0 , 0);
    $this->SetXY(78, 7);
    $this->CellFitSpace(28, 7,utf8_decode($reg[0]['cuitsucursal']), 0, 0);

    $this->SetXY(48, 10);
    $this->SetFont('Courier','B',8);
    $this->Cell(5, 7, 'Nº DE NOTA', 0 , 0);
    $this->SetXY(78, 10);
    $this->CellFitSpace(28, 7,utf8_decode($reg[0]['codfactura']), 0, 0);

    $this->SetXY(48, 13);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'Nº DE DOCUMENTO:', 0, 0);
    $this->SetXY(48, 16);
    $this->CellFitSpace(56, 7,utf8_decode($reg[0]['facturaventa']), 0, 0);

    $this->SetXY(48, 19);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'MOTIVO DE NOTA:', 0, 0);
    $this->SetXY(48, 22);
    $this->MultiCell(56,7,$this->SetFont('Courier','',6).utf8_decode($reg[0]["observaciones"]=="" ? "" : $reg[0]["observaciones"]), 0,'J');

    $this->SetXY(48, 25);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,"FECHA DE AUTORIZACIÓN:", 0, 0);
    $this->SetXY(78, 25);
    $this->Cell(28, 7,$fecha = ($reg[0]['fechaautorsucursal'] == '0000-00-00' ? "" : date("d-m-Y",strtotime($reg[0]['fechaautorsucursal']))), 0, 0);

    $this->SetXY(48, 28);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,"FECHA DE NOTA:", 0, 0);
    $this->SetXY(78, 28);
    $this->Cell(28, 7,date("d-m-Y H:i:s",strtotime($reg[0]['fechanota'])), 0, 0);


    $this->SetXY(48, 31);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'AMBIENTE: ', 0 , 0);
    $this->SetXY(78, 31);
    $this->Cell(28, 7,'PRODUCCIÓN', 0 , 0);

    $this->SetXY(48, 34);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'EMISIÓN: ', 0 , 0);
    $this->SetXY(78, 34);
    $this->Cell(28, 7,'NORMAL', 0 , 0);
     
    //Bloque datos de cliente
    $this->SetLineWidth(0.3);
    $this->SetFillColor(192);
    $this->RoundedRect(5, 41, 100, 10, '1.5', "");
    $this->SetFont('Courier','B',6);

    $this->SetXY(6, 40.2);
    $this->CellFitSpace(66, 5,'RAZÓN SOCIAL: '.utf8_decode($reg[0]['codcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']), 0, 0);
    $this->CellFitSpace(32, 5,'Nº DE '.$documento = ($reg[0]['documcliente'] == '' ? "DOC: " : $reg[0]['documento'].": ").$dni = ($reg[0]['dnicliente'] == '' ? "**********" : $reg[0]['dnicliente']), 0, 0);

    $this->SetXY(6, 43.2);
    $this->CellFitSpace(66, 5,'DIRECCIÓN: '.utf8_decode($reg[0]['direccliente'] == '' ? "**********" : $reg[0]['direccliente']), 0, 0);
    $this->CellFitSpace(32, 5,'Nº DE TLF: '.($reg[0]['tlfcliente'] == '' ? "**********" : $reg[0]['tlfcliente']), 0, 0);

    $this->SetXY(6, 46.2);
    $this->CellFitSpace(92, 5,'EMAIL: '.utf8_decode($reg[0]['emailcliente'] == '' ? "**********" : $reg[0]['emailcliente']), 0, 0);

    $this->Ln(6);
    $this->SetX(5);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(5,3,'N°',1,0,'C', True);
    $this->Cell(50,3,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(12,3,'CANTIDAD',1,0,'C', True);
    $this->Cell(14,3,'PRECIO',1,0,'C', True);
    $this->Cell(19,3,'IMPORTE',1,1,'C', True);
    
    $tra = new Login();
    $detalle = $tra->VerDetallesNotasCredito();
    $cantidad = 0;
    $SubTotal = 0;

    $this->SetWidths(array(5,50,12,14,19));

    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $cantidad += $detalle[$i]['cantventa'];
    $valortotal = $detalle[$i]["precioventa"]*$detalle[$i]["cantventa"];
    $SubTotal += $detalle[$i]['valorneto'];

    $this->SetX(5);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier',"",6);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->RowFacture(array($a++,portales(utf8_decode($detalle[$i]["producto"])),utf8_decode($detalle[$i]['cantventa']),utf8_decode(number_format($detalle[$i]["precioventa"], 2, '.', ',')),utf8_decode(number_format($detalle[$i]['valorneto'], 2, '.', ','))));
       
    }
     
    $this->Ln(1);
    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'INFORMACIÓN ADICIONAL',1,0,'C');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->SetFont('Courier','B',6);
    $this->CellFitSpace(20,3.5,'SUBTOTAL ',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($SubTotal, 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'CANTIDAD DE PRODUCTOS: '.utf8_decode($cantidad),1,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,'GRAVADO ('.number_format($reg[0]["iva"], 2, '.', ',').'%):',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["subtotalivasi"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'TIPO DE DOCUMENTO: NOTA DE CRÉDITO',1,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,'EXENTO (0%):',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["subtotalivano"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'FECHA DE EMISIÓN: '.date("d-m-Y H:i:s"),1,0,'L');

    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,$impuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):",1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["totaliva"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'Nº DE CAJA: '.$caja = ($reg[0]['codcaja'] == 0 ? "**********" : $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']),1,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,'DESCONTADO %:',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["descontado"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'CAJERO: '.$cajero = ($reg[0]['codcaja'] == 0 ? "**********" : $reg[0]['nombres']),1,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,'DESC % ('.number_format($reg[0]["descuento"], 2, '.', ',').'%):',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["totaldescuento"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(59,3.5,'',0,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->SetFont('Courier','B',6);
    $this->Cell(20,3.5,'IMPORTE TOTAL:',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["totalpago"], 2, '.', ','),1,0,'R');
    $this->Ln(4);
    
    $this->SetX(5);
    $this->SetDrawColor(3,3,3);
    $this->SetFont('Courier','BI',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(100,2,'MONTO EN LETRAS: '.utf8_decode(numtoletras(number_format($reg[0]['totalpago'], 2, '.', ''))),0,0,'L');
    $this->Ln();
}  
########################## FUNCION NOTA DE CREDITO (MITAD) ##############################

########################## FUNCION NOTA DE CREDITO (A4) #############################
function NotaCredito2()
{     
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->NotasCreditoPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

    $logo = "./fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
    $this->Image($logo , 15 ,11, 25 , 15 , "PNG");

    }

    ############################ BLOQUE N° 1 FACTURA ###################################  
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 10, 190, 17, '1.5', '');
    
    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(98, 12, 12, 12, '1.5', 'F');

    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(98, 12, 12, 12, '1.5', '');

    $this->SetFont('courier','B',16);
    $this->SetXY(101, 14);
    $this->Cell(20, 5, 'N', 0 , 0);
    $this->SetFont('courier','B',8);
    $this->SetXY(100, 19);
    $this->Cell(20, 5, 'Nota', 0, 0);
    
    $this->SetFont('courier','B',11);
    $this->SetXY(124, 10);
    $this->Cell(34, 5, 'N° DE NOTA', 0, 0);
    $this->SetFont('courier','B',11);
    $this->SetXY(158, 10);
    $this->CellFitSpace(40, 5,utf8_decode($reg[0]['codfactura']), 0, 0, "R");

    $this->SetFont('courier','B',11);
    $this->SetXY(124, 14);
    $this->Cell(34, 5, 'Nº DE '.utf8_decode($reg[0]['tipodocumento']), 0, 0);
    $this->SetFont('courier','B',11);
    $this->SetXY(158, 14);
    $this->Cell(40, 5,utf8_decode($reg[0]['facturaventa']), 0, 0, "R");

    $this->SetFont('courier','B',9);
    $this->SetXY(124, 18);
    $this->Cell(34, 4, 'FECHA DE NOTA', 0, 0);
    $this->SetFont('courier','',9);
    $this->SetXY(158, 18);
    $this->Cell(40, 4,utf8_decode(date("d-m-Y",strtotime($reg[0]['fechanota']))), 0, 0, "R");
    
    $this->SetFont('courier','B',9);
    $this->SetXY(124, 22);
    $this->Cell(34, 4, 'FECHA DE EMISIÓN', 0, 0);
    $this->SetFont('courier','',9);
    $this->SetXY(158, 22);
    $this->Cell(40, 4,utf8_decode(date("d-m-Y H:i:s")), 0, 0, "R");
    ############################## BLOQUE N° 1 FACTURA ###############################     
    
    ############################### BLOQUE N° 2 SUCURSAL ##############################   
   //Bloque de datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 29, 190, 18, '1.5', '');
    //DATOS DE SUCURSAL LINEA 1
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 30);
    $this->Cell(186, 4, 'DATOS DE SUCURSAL ', 0, 0);
    //DATOS DE SUCURSAL LINEA 1

    //DATOS DE SUCURSAL LINEA 2
    $this->SetFont('courier','B',8);
    $this->SetXY(12, 34);
    $this->Cell(24, 4, 'RAZÓN SOCIAL:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(36, 34);
    $this->CellFitSpace(66, 4,utf8_decode($reg[0]['nomsucursal']), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(102, 34);
    $this->CellFitSpace(22, 4, 'Nº DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : $reg[0]['documento'].":"), 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(124, 34);
    $this->CellFitSpace(28, 4,utf8_decode($reg[0]['cuitsucursal']), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(152, 34);
    $this->Cell(18, 4, 'N° DE TLF:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(170, 34);
    $this->Cell(28, 4,utf8_decode($reg[0]['tlfsucursal']), 0, 0);
    //DATOS DE SUCURSAL LINEA 2

    //DATOS DE SUCURSAL LINEA 3
    $this->SetFont('courier','B',8);
    $this->SetXY(12, 38);
    $this->Cell(24, 4, 'DIRECCIÓN:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(36, 38);
    $this->CellFitSpace(96, 4,utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "*********" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['departamento'] == '' ? "*********" : $reg[0]['departamento'])." ".$reg[0]['direcsucursal']), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(132, 38);
    $this->Cell(12, 4, 'EMAIL:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(144, 38);
    $this->Cell(54, 4,utf8_decode($reg[0]['correosucursal']), 0, 0);
    //DATOS DE SUCURSAL LINEA 3

    //DATOS DE SUCURSAL LINEA 4
    $this->SetFont('courier','B',8);
    $this->SetXY(12, 42);
    $this->Cell(24, 4, 'RESPONSABLE:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(36, 42);
    $this->CellFitSpace(66, 4,utf8_decode($reg[0]['nomencargado']), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(102, 42);
    $this->CellFitSpace(22, 4, 'Nº DE '.$documento = ($reg[0]['documencargado'] == '0' ? "DOC.:" : $reg[0]['documento2'].":"), 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(124, 42);
    $this->CellFitSpace(28, 4,utf8_decode($reg[0]['dniencargado']), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(152, 42);
    $this->Cell(18, 4, 'N° DE TLF:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(170, 42);
    $this->Cell(28, 4,utf8_decode($tlf = ($reg[0]['tlfencargado'] == '' ? "*********" : $reg[0]['tlfencargado'])), 0, 0);
    //DATOS DE SUCURSAL LINEA 4
    ############################### BLOQUE N° 2 SUCURSAL ###############################   


    ################################# BLOQUE N° 3 CLIENTE ################################  
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 49, 190, 14, '1.5', '');

    $this->SetFont('courier','B',9);
    $this->SetXY(12, 50);
    $this->Cell(186, 4, 'DATOS DE CLIENTE ', 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(12, 54);
    $this->Cell(20, 4, 'NOMBRES:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(32, 54);
    $this->CellFitSpace(58, 4,utf8_decode($nombre = ($reg[0]['nomcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente'])), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(90, 54);
    $this->CellFitSpace(20, 4, 'Nº DE '.$documento = ($reg[0]['documcliente'] == '0' ? "DOC.:" : $reg[0]['documento3'].":"), 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(110, 54);
    $this->CellFitSpace(24, 4,utf8_decode($nombre = ($reg[0]['dnicliente'] == '' ? "*********" : $reg[0]['dnicliente'])), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(134, 54);
    $this->Cell(12, 4, 'EMAIL:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(146, 54);
    $this->CellFitSpace(52, 4,utf8_decode($email = ($reg[0]['emailcliente'] == '' ? "*********" : $reg[0]['emailcliente'])), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(12, 58);
    $this->Cell(20, 4, 'DIRECCIÓN:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(32, 58);
    $this->CellFitSpace(124, 4,getSubString(utf8_decode($provincia = ($reg[0]['provincia2'] == '' ? "*********" : $reg[0]['provincia2'])." ".$departamento = ($reg[0]['departamento2'] == '' ? "*********" : $reg[0]['departamento2'])." ".$reg[0]['direccliente']), 70), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(156, 58);
    $this->Cell(20, 4, 'N° DE TLF:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(176, 58);
    $this->CellFitSpace(22, 4,utf8_decode($tlf = ($reg[0]['tlfcliente'] == '' ? "*********" : $reg[0]['tlfcliente'])), 0, 0); 
    ################################# BLOQUE N° 3 CLIENTE ################################  

    ################################# BLOQUE N° 4 #######################################   
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 68, 190, 180, '0', '');

    $this->SetFont('courier','B',9);
    $this->SetXY(10, 65);
    $this->SetTextColor(3,3,3);
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->Cell(8, 8,"Nº", 1, 0, 'C', True);
    $this->Cell(50, 8,"DESCRIPCIÓN", 1, 0, 'C', True);
    $this->Cell(20, 8,"MARCA", 1, 0, 'C', True);
    $this->Cell(15, 8,"MODELO", 1, 0, 'C', True);
    $this->Cell(10, 8,"CANT", 1, 0, 'C', True);
    $this->Cell(20, 8,"P/UNIT", 1, 0, 'C', True);
    $this->Cell(20, 8,"V/TOTAL", 1, 0, 'C', True);
    $this->Cell(15, 8,"DESC %", 1, 0, 'C', True);
    $this->Cell(12, 8,$impuesto, 1, 0, 'C', True);
    $this->Cell(20, 8,"V/NETO", 1, 1, 'C', True);
    ################################# BLOQUE N° 4 #######################################  

    ################################# BLOQUE N° 5 ####################################### 
    $tra = new Login();
    $detalle = $tra->VerDetallesNotasCredito();
    $cantidad = 0;
    $SubTotal = 0;

     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(8,50,20,15,10,20,20,15,12,20));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $cantidad += $detalle[$i]['cantventa'];
    $valortotal = $detalle[$i]["precioventa"]*$detalle[$i]["cantventa"];
    $SubTotal += $detalle[$i]['valorneto'];

    $this->SetX(10);
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->RowFacture(array($a++,
        portales(utf8_decode($detalle[$i]["producto"])),
        utf8_decode($detalle[$i]["codmarca"] == '0' ? "******" : $detalle[$i]["nommarca"]),
        utf8_decode($detalle[$i]["codmodelo"] == '0' ? "******" : $detalle[$i]["nommodelo"]),
        utf8_decode($detalle[$i]["cantventa"]),
        utf8_decode($simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ',')),
        utf8_decode(number_format($detalle[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($detalle[$i]["ivaproducto"] == 'SI' ? number_format($reg[0]["iva"], 2, '.', ',')."%" : "(E)"),
        utf8_decode($simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','))));
  }
    ################################# BLOQUE N° 5 #######################################  

    ########################### BLOQUE N° 7 #############################    
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 250, 108, 26, '1.5', '');

    $this->SetFont('courier','B',8);
    $this->SetXY(12, 250);
    $this->Cell(105, 4, 'INFORMACIÓN ADICIONAL', 0, 0, 'C');
    
    $this->SetFont('courier','B',7.5);
    $this->SetXY(12, 254);
    $this->Cell(32, 3, 'CANTIDAD PRODUCTOS:', 0, 0);
    $this->SetXY(44, 254);
    $this->SetFont('courier','',7.5);
    $this->CellFitSpace(15, 3,utf8_decode($cantidad), 0, 0);
    
    $this->SetFont('courier','B',7.5);
    $this->SetXY(12, 257);
    $this->Cell(28, 3, 'TIPO DOCUMENTO:', 0, 0);
    $this->SetXY(44, 257);
    $this->SetFont('courier','',7.5);
    $this->Cell(30, 3,"NOTA DE CRÉDITO", 0, 0);

    $this->SetFont('courier','B',7);
    $this->SetXY(12, 260);
    $this->MultiCell(105,3,$this->SetFont('Courier','',7).utf8_decode(numtoletras(number_format($reg[0]['totalpago'], 2, '.', ''))),0,'L');

    //Linea de membrete Nro 5
    $this->SetFont('courier','B',7);
    $this->SetXY(12, 263);
    $this->MultiCell(106,3,$this->SetFont('Courier','',7).utf8_decode($reg[0]["observaciones"]=="" ? "" : "OBSERVACIONES: ".$reg[0]["observaciones"]), 0,'J');
    ########################### BLOQUE N° 7 #############################    

   ################################# BLOQUE N° 8 #######################################  
    //Bloque de Totales de factura
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(120, 250, 80, 26, '1.5', '');

    //Linea de membrete Nro 1
    $this->SetFont('courier','B',9);
    $this->SetXY(124, 251);
    $this->CellFitSpace(36, 5, 'SUBTOTAL:', 0, 0);
    $this->SetXY(160, 251);
    $this->SetFont('courier','',9);
    $this->CellFitSpace(40, 5,utf8_decode($simbolo.number_format($SubTotal, 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',9);
    $this->SetXY(124, 254);
    $this->CellFitSpace(36, 5, 'TOTAL GRAVADO ('.number_format($reg[0]["iva"], 2, '.', ',').'%):', 0, 0);
    $this->SetXY(160, 254);
    $this->SetFont('courier','',9);
    $this->CellFitSpace(40, 5,utf8_decode($simbolo.number_format($reg[0]["subtotalivasi"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 3
    $this->SetFont('courier','B',9);
    $this->SetXY(124, 257);
    $this->CellFitSpace(36, 5, 'TOTAL EXENTO (0%):', 0, 0);
    $this->SetXY(160, 257);
    $this->SetFont('courier','',9);
    $this->CellFitSpace(40, 5,utf8_decode($simbolo.number_format($reg[0]["subtotalivano"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 4
    $this->SetFont('courier','B',9);
    $this->SetXY(124, 260);
    $this->CellFitSpace(36, 5, $impuesto == '' ? "TOTAL IMP." : "TOTAL ".$impuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):", 0, 0);
    $this->SetXY(160, 260);
    $this->SetFont('courier','',9);
    $this->CellFitSpace(40, 5,utf8_decode($simbolo.number_format($reg[0]["totaliva"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 3
    $this->SetFont('courier','B',9);
    $this->SetXY(124, 263);
    $this->CellFitSpace(36, 5, 'DESCONTADO %:', 0, 0);
    $this->SetXY(160, 263);
    $this->SetFont('courier','',9);
    $this->CellFitSpace(40, 5,utf8_decode($simbolo.number_format($reg[0]["descontado"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 5
    $this->SetFont('courier','B',9);
    $this->SetXY(124, 266);
    $this->CellFitSpace(36, 5, "DESC. GLOBAL (".number_format($reg[0]["descuento"], 2, '.', ',').'%):', 0, 0);
    $this->SetXY(160, 266);
    $this->SetFont('courier','',9);
    $this->CellFitSpace(40, 5,utf8_decode($simbolo.number_format($reg[0]["totaldescuento"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 6
    $this->SetFont('courier','B',10);
    $this->SetXY(124, 270);
    $this->CellFitSpace(36, 5, 'IMPORTE TOTAL:', 0, 0);
    $this->SetXY(160, 270);
    $this->SetFont('courier','',9);
    $this->CellFitSpace(40, 5,utf8_decode($simbolo.number_format($reg[0]["totalpago"], 2, '.', ',')), 0, 0, "R");
    ################################# BLOQUE N° 8 #######################################
}
########################## FUNCION NOTA DE CREDITO (A4) ##############################

########################## FUNCION LISTAR NOTAS DE CREDITO ##############################
function TablaListarNotasCredito()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    
    $tra = new Login();
    $reg = $tra->ListarNotasCreditos();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE NOTAS DE CREDITO',0,0,'C');

    
if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(40,8,'SUCURSAL',1,0,'C', True);
    $this->Cell(35,8,'Nº DE NOTA',1,0,'C', True);
    $this->Cell(35,8,'Nº DE DOCUMENTO',1,0,'C', True);
    $this->Cell(55,8,'DESCRIPCIÓN DE CLIENTE',1,0,'C', True);
    $this->Cell(35,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(25,8,$impuesto,1,0,'C', True);
    $this->Cell(25,8,'DCTO %',1,0,'C', True);
    $this->Cell(35,8,'TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,40,35,35,55,35,35,25,25,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalIva=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalIva+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["nomsucursal"]),utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['tipodocumento'].": ".$reg[$i]["facturaventa"]),utf8_decode($reg[$i]['codcliente'] == '' || $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechanota']))),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
   }
   
    $this->Cell(215,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    } else {

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE NOTA',1,0,'C', True);
    $this->Cell(55,8,'Nº DE DOCUMENTO',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCIÓN DE CLIENTE',1,0,'C', True);
    $this->Cell(35,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(30,8,$impuesto,1,0,'C', True);
    $this->Cell(25,8,'DCTO %',1,0,'C', True);
    $this->Cell(35,8,'TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,55,70,35,35,30,25,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalIva=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalIva+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['tipodocumento'].": ".$reg[$i]["facturaventa"]),utf8_decode($reg[$i]['codcliente'] == '' || $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechanota']))),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
   }
   
    $this->Cell(210,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
 }
    }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR NOTAS DE CREDITO ##############################


########################## FUNCION LISTAR NOTAS DE CREDITO POR CAJA ##############################
function TablaListarNotasxCajas()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    
    $tra = new Login();
    $reg = $tra->BuscarNotasxCajas();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO NOTAS DE CREDITO POR CAJA',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,5,"Nº CAJA: ".utf8_decode($reg[0]["nrocaja"].": ".$reg[0]["nomcaja"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,5,"RESPONSABLE DE CAJA: ".portales(utf8_decode($reg[0]["nombres"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,5,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,5,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,1,'L');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE NOTA',1,0,'C', True);
    $this->Cell(55,8,'Nº DE DOCUMENTO',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCIÓN DE CLIENTE',1,0,'C', True);
    $this->Cell(35,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(30,8,$impuesto,1,0,'C', True);
    $this->Cell(25,8,'DCTO',1,0,'C', True);
    $this->Cell(35,8,'TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,55,70,35,35,30,25,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalIva=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalIva+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['tipodocumento'].": ".$reg[$i]["facturaventa"]),utf8_decode($reg[$i]['codcliente'] == '' || $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechanota']))),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
   }
   
    $this->Cell(210,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
 }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR NOTAS DE CREDITO POR CAJA ##############################

########################## FUNCION LISTAR NOTAS DE CREDITO POR FECHAS ##############################
function TablaListarNotasxFechas()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    
    $tra = new Login();
    $reg = $tra->BuscarNotasxFechas();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO NOTAS DE CREDITO POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE NOTA',1,0,'C', True);
    $this->Cell(55,8,'Nº DE DOCUMENTO',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCIÓN DE CLIENTE',1,0,'C', True);
    $this->Cell(35,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(30,8,$impuesto,1,0,'C', True);
    $this->Cell(25,8,'DCTO %',1,0,'C', True);
    $this->Cell(35,8,'TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,55,70,35,35,30,25,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalIva=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalIva+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['tipodocumento'].": ".$reg[$i]["facturaventa"]),utf8_decode($reg[$i]['codcliente'] == '' || $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechanota']))),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
   }
   
    $this->Cell(210,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
 }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR NOTAS DE CREDITO POR FECHAS ##############################


########################## FUNCION LISTAR NOTAS DE CREDITO POR CLIENTE ##############################
function TablaListarNotasxClientes()
{

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    
    $tra = new Login();
    $reg = $tra->BuscarNotasxClientes();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    $logo2 = ( file_exists("./fotos/logo_pdf2.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf2.png");

    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuit']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO NOTAS DE CREDITO POR CLIENTE',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($documento = ($reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']))." CLIENTE: ".utf8_decode($reg[0]["dnicliente"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"CLIENTE: ".portales(utf8_decode($reg[0]['nomcliente'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"Nº DE TELÉFONO: ".portales(utf8_decode($reg[0]['tlfcliente'] == '' ? "********" : $reg[0]['tlfcliente'])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE NOTA',1,0,'C', True);
    $this->Cell(55,8,'Nº DE DOCUMENTO',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCIÓN DE CLIENTE',1,0,'C', True);
    $this->Cell(35,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(30,8,$impuesto,1,0,'C', True);
    $this->Cell(25,8,'DCTO %',1,0,'C', True);
    $this->Cell(35,8,'TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,55,70,35,35,30,25,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalIva=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalIva+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['tipodocumento'].": ".$reg[$i]["facturaventa"]),utf8_decode($reg[$i]['codcliente'] == '' || $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechanota']))),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
   }
   
    $this->Cell(210,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR NOTAS DE CREDITO POR FECHAS ##############################

############################## REPORTES DE NOTAS DE CREDITOS ##################################


 // FIN Class PDF
}
?>