<?php
session_start();

//Se valida el tiempo de inactividad de la session
$current_sinIn = (time() - $_SESSION['time_login']);
if ($current_sinIn > $_SESSION['time_incative']) {
	session_destroy();
	header('location: ../index.php');
}else{
	$_SESSION['time_login'] = time();
}

header("Content-Type: text/html;charset=utf-8");
//Se incluye la libreria FPDF
require('../fpdf181/fpdf.php');
$pk_venta = $_GET['pk_venta'];

require_once('../conexion.php');
$objet_conexion = new Conexion();
$conexion = $objet_conexion->conectar();

date_default_timezone_set("America/Bahia_Banderas");

$nombre_cliente = "-------";

$query_validateCliente = "SELECT c.nombre_cliente FROM venta v, cliente c WHERE v.fk_cliente=c.pk_cliente AND pk_venta=?";
$statement_fkCliente = $conexion->prepare($query_validateCliente);
$statement_fkCliente->bindParam(1,$pk_venta);
$statement_fkCliente->execute();
$resultado_fkCliente = $statement_fkCliente->fetchAll();
if (count($resultado_fkCliente)>0) {
	$nombre_cliente = $resultado_fkCliente[0]['nombre_cliente'];
}
$statement_fkCliente->closeCursor();

$query = "SELECT v.pk_venta, v.fecha, DATE_FORMAT(v.hora,'%r') AS hora, v.total, u.nombre AS nom_usuario, v.cant_pago, v.cambio FROM venta v, usuario u WHERE pk_venta=? AND u.pk_usuario=v.fk_usuario";
$statement = $conexion->prepare($query);
$statement->bindParam(1, $pk_venta);
$statement->execute();
$resultado = $statement->fetchAll();
$statement->closeCursor();

$query_listadoProductos = "SELECT p.nombre, vp.cant_producto, p.precio, (vp.cant_producto*p.precio) AS monto FROM venta v, venta_producto vp, producto p WHERE v.pk_venta=? AND v.pk_venta=vp.fk_venta AND p.pk_producto=vp.fk_producto";
$statement_listaProductos = $conexion->prepare($query_listadoProductos);
$statement_listaProductos->bindParam(1, $pk_venta);
$statement_listaProductos->execute();
$result_listadoProductos = $statement_listaProductos->fetchAll();
$statement_listaProductos->closeCursor();

$query_importes = "SELECT SUM(vp.cant_importe) AS total_importe FROM venta v, venta_producto vp WHERE v.pk_venta=? AND v.pk_venta=vp.fk_venta";
$statement_importe = $conexion->prepare($query_importes);
$statement_importe->bindParam(1, $pk_venta);
$statement_importe->execute();
$result_importe = $statement_importe->fetchAll();
$statement_importe->closeCursor();


class PDF_JavaScript extends FPDF {

	protected $javascript;
	protected $n_js;

	function IncludeJS($script, $isUTF8=false) {
		if(!$isUTF8)
			$script=utf8_encode($script);
		$this->javascript=$script;
	}

	function _putjavascript() {
		$this->_newobj();
		$this->n_js=$this->n;
		$this->_put('<<');
		$this->_put('/Names [(EmbeddedJS) '.($this->n+1).' 0 R]');
		$this->_put('>>');
		$this->_put('endobj');
		$this->_newobj();
		$this->_put('<<');
		$this->_put('/S /JavaScript');
		$this->_put('/JS '.$this->_textstring($this->javascript));
		$this->_put('>>');
		$this->_put('endobj');
	}

	function _putresources() {
		parent::_putresources();
		if (!empty($this->javascript)) {
			$this->_putjavascript();
		}
	}

	function _putcatalog() {
		parent::_putcatalog();
		if (!empty($this->javascript)) {
			$this->_put('/Names <</JavaScript '.($this->n_js).' 0 R>>');
		}
	}
}

class PDF_AutoPrint extends PDF_JavaScript
{
	function AutoPrint($dialog=false)
	{
    //Abre el cuadro de diálogo de impresión o empieza a imprimir inmediatamente en la impresora estándar
		$param=($dialog ? 'true' : 'false');
		$script="print($param);";
		$this->IncludeJS($script);
	}
	function AutoPrintToPrinter($server, $printer, $dialog=false)
	{
    //Imprimir en una impresora compartida (requiere al menos Acrobat 6)
		$script = "var pp = getPrintParams();";
		if($dialog)
			$script .= "pp.interactive = pp.constants.interactionLevel.full;";
		else
			$script .= "pp.interactive = pp.constants.interactionLevel.automatic;";
		$script .= "pp.printerName = '\\\\\\\\".$server."\\\\".$printer."';";
		$script .= "print(pp);";
		$this->IncludeJS($script);
	}
}

$calculador = 0;
$lineas = 0;
$num_lineas = 0;
foreach ($result_listadoProductos as $value) {
	$string = $value['nombre'];
	$array = str_split($string);
	$lineas = (count($array)/17);
	$num_lineas =  round($lineas, 0, PHP_ROUND_HALF_UP);
	$calculador += $num_lineas*1.5;
}
//$alto = $calculador+16.4;
$alto = $calculador+12;

$pdf = new PDF_AutoPrint('P','cm',array(8,$alto));
$pdf->AddPage();
$pdf->SetMargins(0.4,0.5,1.2);
$pdf->SetAutoPageBreak(false,2);
$pdf->SetFont('Arial','B',6.3);

$pdf->Image('../img/logoP.jpeg', 2.5, 0, 3, 2,'JPEG');
$pdf->Ln(0.2);

//Informacion principal del ticket
// $pdf->Ln(0.4);
// $pdf->Cell(0,0,'ELPARAISO ',0,1,'C');
// $pdf->Ln(0.4);
// $pdf->Cell(0,0,'Granja Organica Sostenible',0,1,'C');
// $pdf->Ln(0.4);
// $pdf->Cell(0,0,utf8_decode("MARTHA ELIZABETH KOVACS UNZUETA"),0,1,'C');
// $pdf->Ln(0.4);
// $pdf->Cell(0,0,'RFC: KOUM790925D4A',0,1,'C');
// $pdf->Ln(0.4);
// $pdf->Cell(0,0,'luis Echeverria #53, col. centro,',0,1,'C');
// $pdf->Ln(0.4);
// $pdf->Cell(0,0,'Lo de Marcos, Nay',0,1,'C');
// $pdf->Ln(0.4);
// $pdf->Cell(0,0,'Tel: 327 27 50 036',0,1,'C');
// $pdf->Ln(0.4);
// $pdf->Cell(0,0,'Cel: 322-111-5320',0,1,'C');
// $pdf->Ln(0.4);
// $pdf->Cell(0,0,'',0,1,'C');
// $pdf->Ln(0.2);

$pdf->setY(2.5);
$pdf->SetFont('Arial','I',7.5);
$pdf->Cell(0,0,'NO. ticket: '.$pk_venta,0,1,'C');
$pdf->Ln(0.4);
$pdf->Cell(0,0,'Fecha: '.$resultado[0]['fecha'],0,1,'L');
$pdf->Cell(0,0,'Hora: '.$resultado[0]['hora'],0,1,'R');

$pdf->setFillColor(232,232,232);
$pdf->SetFont('Arial','B',7.5);

$pdf->setY(3.3);
$pdf->Cell(3,0.5,'Producto',1,0,'L',1);
$pdf->setX(3.4);
$pdf->Cell(1.2,0.5,'Cant.',1,0,'C',1);
$pdf->setX(4.6);
$pdf->Cell(1.1,0.5,'Pre Uni',1,0,'R',1);
$pdf->setX(5.7);
$pdf->Cell(1.2,0.5,'Monto',1,0,'R',1);
$pdf->Ln(0.5);

$pdf->SetFont('Arial','I',6.3);

foreach ($result_listadoProductos as $value) {

	//Proceso para ajurtar y ordenar el texto en las celdas
	$string = utf8_decode($value['nombre']);
	$array = str_split($string);
	$string_editado = "";
	$contador = 0;
	if (count($array) > 17) {
		for ($x=0; $x < count($array); $x++) {
			if ($contador == 17) {
				$string_editado .= $array[$x]."-\n";
				$contador = 0;
			}else{
				$string_editado .= $array[$x];
				$contador++;
			}
		}
	}else{
		$string_editado = $string."\n";
	}

	if (count($array) >= 45) {

		$pdf->Cell(0,0,$pdf->Write(0.5,utf8_decode($string_editado)),0,0,'L',0);
		$pdf->Ln(0.4);

		$pdf->setX(3.9);
		$pdf->Cell(0,2,$pdf->Write(-2,$value['cant_producto']),0,0,'C',0);

		$pdf->setX(4.6);
		$pdf->Cell(1,0,$pdf->Write(-2,$value['precio']),0,0,'C',0);

		$pdf->Cell(0.5,-2,$value['monto'],0,0,'R',0);
		$pdf->setX(0.3);
		$pdf->Cell(0,0,'_____________________________________________________',0,0,'L',0);

	}else if (count($array) > 23) {

		$pdf->Cell(0,0,$pdf->Write(0.5,utf8_decode($string_editado)),0,0,'L',0);
		$pdf->Ln(0.4);

		$pdf->setX(3.9);
		$pdf->Cell(0,2,$pdf->Write(-1,$value['cant_producto']),0,0,'C',0);

		$pdf->setX(4.6);
		$pdf->Cell(1,0,$pdf->Write(-1,$value['precio']),0,0,'C',0);

		$pdf->Cell(0.5,-1,$value['monto'],0,0,'R',0);
		$pdf->setX(0.3);
		$pdf->Cell(0,0,'_____________________________________________________',0,0,'L',0);

	}else if (count($array) > 17 && count($array) <= 23) {

		$pdf->Cell(0,0,$pdf->Write(0.5,utf8_decode($string_editado."\n")),0,0,'L',0);

		$pdf->setX(3.9);
		$pdf->Cell(0,2,$pdf->Write(-1.4,$value['cant_producto']),0,0,'C',0);

		$pdf->setX(4.6);
		$pdf->Cell(1,0,$pdf->Write(-1.4,$value['precio']),0,0,'C',0);

		$pdf->Cell(0.5,-1.5,$value['monto'],0,0,'R',0);

		$pdf->Cell(-5.3,0,'_____________________________________________________',0,0,'C',0);

	}else if(count($array) <= 17){

		$pdf->Cell(0,0,$pdf->Write(0.3,utf8_decode($string_editado."\n")),0,0,'L',0);

		$pdf->setX(3.9);
		$pdf->Cell(0,2,$pdf->Write(-0.7,$value['cant_producto']),0,0,'C',0);

		$pdf->setX(4.6);
		$pdf->Cell(1,0,$pdf->Write(-0.7,$value['precio']),0,0,'C',0);

		$pdf->Cell(0.4,-0.7,$value['monto'],0,0,'R',0);

	}
	$pdf->Ln(0.2);
}

$pdf->SetFont('Arial','B',6.3);

$pdf->Cell(6.5,0.5,'TOTAL: $'.$resultado[0]['total'],1,1,'R');
$pdf->Ln(0.4);
$pdf->SetFont('Arial','I',7.5);
$pdf->Cell(0,0,'Pago: Contado',0,1,'L');
$pdf->Ln(0.4);
$pdf->Cell(0,0,'Cliente: '.utf8_decode($nombre_cliente),0,1,'L');
$pdf->Ln(0.4);
$pdf->Cell(0,0,'Atendido por: '.$resultado[0]['nom_usuario'],0,1,'L');
$pdf->Ln(0.4);
$pdf->Cell(0,0,'Exp. en: Lo de marcos Nayarit',0,1,'L');
$pdf->Ln(0.7);
$pdf->Cell(0,0,'Total venta:',0,1,'L');
$pdf->Cell(0,0,'$'.$resultado[0]['total'],0,1,'R');
$pdf->Ln(0.4);
$pdf->Cell(0,0,'Total de importes:',0,1,'L');
$pdf->Cell(0,0,'$'.$result_importe[0]['total_importe'],0,1,'R');
$pdf->Ln(0.4);
$pdf->Cell(0,0,'____________________________________________',0,1,'L');
$pdf->Ln(0.4);
$pdf->Cell(0,0,'Pago final: ',0,1,'L');
$pdf->Cell(0,0,'$'.($resultado[0]['total']+$result_importe[0]['total_importe']),0,1,'R');
$pdf->Ln(0.4);
$pdf->Cell(0,0,'Pago efectivo: ',0,1,'L');
$pdf->Cell(0,0,'$'.$resultado[0]['cant_pago'],0,1,'R');
$pdf->Ln(0.4);
$pdf->Cell(0,0,'Cambio: ',0,1,'L');
$pdf->Cell(0,0,'$'.$resultado[0]['cambio'],0,1,'R');
$pdf->Ln(0.7);

$pdf->Cell(0,0,utf8_decode("MARTHA ELIZABETH KOVACS UNZUETA"),0,1,'C');
$pdf->Ln(0.4);
$pdf->Cell(0,0,'RFC: KOUM790925D4A',0,1,'C');
$pdf->Ln(0.4);
$pdf->Cell(0,0,'luis Echeverria #53, col. centro,',0,1,'C');
$pdf->Ln(0.4);
$pdf->Cell(0,0,'Lo de Marcos, Nay',0,1,'C');
$pdf->Ln(0.4);
$pdf->Cell(0,0,'Tel: 327 27 50 036',0,1,'C');
$pdf->Ln(0.4);
$pdf->Cell(0,0,'Cel: 322-111-5320',0,1,'C');
$pdf->Ln(0.4);
$pdf->Cell(0,0,'',0,1,'C');
$pdf->Ln(0.2);

// $pdf->Cell(0,0,'En partes electricas no hay garantia. Aclaraciones o',0,1,'L');
// $pdf->Ln(0.3);
// $pdf->Cell(0,0,'devoluciones de un dia para otro. Foraneos 2 dias   ',0,1,'L');
// $pdf->Ln(0.3);
// $pdf->Cell(0,0,'para devolucion. Motores 60 dias de garantia. Pre-   ',0,1,'L');
// $pdf->Ln(0.3);
// $pdf->Cell(0,0,'sentar este ticket para cualquier aclaracion o devo-   ',0,1,'L');
// $pdf->Ln(0.3);
// $pdf->Cell(0,0,'lucion.',0,1,'L');

try {
	$pdf->AutoPrint(true);
	//$pdf->Output("ticket.pdf",'F');
	$pdf->Output();
} catch (Exception $e) {
	echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>tickt</title>
	<script type="text/javascript">

		function Cerraraliniciar(){
			// var id;
			//id = setTimeout("cerrar()", 500);
		}
		// function cerrar() {
		// 	var ventana = window.self;
		// 	ventana.opener = window.self;
		// 	ventana.close();
		// }
	</script>
</head>
<body onLoad="JavaScript:Cerraraliniciar()">
</body>
</html>