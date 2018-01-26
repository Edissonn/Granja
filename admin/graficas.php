<!--<!--
author: W3layouts
author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<?php
session_start();
$nombre = "";

//Validar si se ha iniciado session correctamente, y si los datos de la sesion estan puestos
if (!isset($_SESSION['nombre_admin']) && !isset($_SESSION['pk_admin'])) {
	//Redirecciona al usuario al inicio o pagina principal
	header("location: ../index.php");
}else{
	//Se agrega la conexion de PDO
	require_once('../conexion.php');

	//Se crea la instancia y el objeto de la clase conexion, para ejecutar las peticiones a la base de datos
	$obj_conexion = new Conexion();
	$conexion = $obj_conexion->conectar();

	//Si los datos esta puestos en session, se asignan los valores
	$nombre = $_SESSION['nombre_admin'];

}
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
	<title>Punto de venta "El paraiso Granja orgánica sostenible"</title>
	<!-- custom-theme -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Farm Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
	Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
	<script type="application/x-javascript">
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!-- //custom-theme -->
	<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
	<link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
	<!-- <link href="../css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" media="all" />
	<link href="../css/lightbox.css" rel="stylesheet" type="text/css" media="all" />
	<link rel="stylesheet" type="text/css" href="../css/sweetalert.css"> -->
	<link href="../css/font-awesome.css" rel="stylesheet">
</head>

<body>

	<?php include 'header.php' ?>

	<div class="services-breadcrumb">
		<div class="container">
			<ul>
				<li><a href="index.php">Inicio</a><i>|</i></li>
				<li>Area del Administrador</li>
			</ul>
		</div>
	</div>
	<br>
	<br>
	<div class="container">
		<h2 class="title-w3-agileits inner">Graficas de Ventas</h2>
		<p class="quia">El paraiso Granja organica sostenible</p>
	</div>
	<br>
	<br>
	<div class="container">
		<div class="jumbotron">
			<div id="contenedor">
				
			</div>
		</div>
	</div>
	<!-- hasta termina el formulario -->
	<!-- banner-bottom -->
	<br>
	<br>
	<br>

	<!-- //single_page -->
	<!-- footer -->
	<div class="agileinfo_copy_right">
		<div class="container">
			<div class="agileinfo_copy_right_left">
				<p>© 2017 El Paraiso Granja Organica Sostenible. Todos los derechos reservados | Diseñado por <a href="https://www.facebook.com/J.AntonioRamirezC.10">Antonio Ramirez</a></p>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
	<!-- //footer -->

	<?php
	$sql = "SELECT pk_venta,total,CONCAT(fecha,' ',hora) AS fecha_hora FROM venta WHERE estado=1 AND factura=0";
	$statement = $conexion->prepare($sql);
	$statement->execute();
	$res = $statement->fetchAll();
	//nos creamos dos arrays para almacenar el tiempo y el valor numérico
	$valoresArray;
	$timeArray;
	//en un bucle for obtenemos en cada iteración el valor númerico y 
	//el TIMESTAMP del tiempo y lo almacenamos en los arrays 
	for($i = 0 ;$i<count($res);$i++){
		$valoresArray[$i]= $res[$i][1];
	    //OBTENEMOS EL TIMESTAMP
		$time= $res[$i][2];
		$date = new DateTime($time);
	    //ALMACENAMOS EL TIMESTAMP EN EL ARRAY
		$timeArray[$i] = $date->getTimestamp()*1000;
	} 
	?>
	<!-- js -->
	<script type="text/javascript" src="../js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="../js/highstock.js"></script>
	<script type="text/javascript" src="../js/highExporting.js"></script>

	<script type="text/javascript">
		chartCPU = new Highcharts.StockChart({
			chart: {
				renderTo: 'contenedor'
		    	//defaultSeriesType: 'spline'
		    },
		    rangeSelector : {
		    	enabled: false
		    },
		    title: {
		    	text: 'Gráfica de ventas generales'
		    },
		    xAxis: {
		    	type: 'datetime'
		        //tickPixelInterval: 150,
		        //maxZoom: 20 * 1000
		    },
		    yAxis: {
		    	minPadding: 0.2,
		    	maxPadding: 0.2,
		    	title: {
		    		text: 'Valores',
		    		margin: 10
		    	}
		    },
		    series: [{
		    	name: 'Ventas totales',
		    	data: (function() {
	                // generate an array of random data
	                var data = [];
	                <?php
	                for($i = 0 ;$i<count($res);$i++){
	                	?>
	                	data.push([<?php echo $timeArray[$i];?>,<?php echo $valoresArray[$i];?>]);
	                	<?php } ?>
	                	return data;
	                })()
	            }],
	            credits: {
	            	enabled: false
	            },
	            //Se cambia el lenguaje a español
	            lang: {
	            	contextButtonTitle: "Menú contextual del gráfico",
	            	decimalPoint: ".",
	            	downloadJPEG: "Descargar imagen JPEG",
	            	downloadPDF: "Descargar documento PDF",
	            	downloadPNG: "Descargar imagen PNG",
	            	downloadSVG: "Descargar imagen SVG vector",
	            	invalidDate: undefined,
	            	loading: "Cargando...",
	            	months: [ "Enero" , "Febrero" , "Marzo" , "Abril" , "Mayo" , "Junio" , "Julio" , "Augosto" , "Septiembre" , "Octubre" , "Noviembre" , "Diciembre"],
	            	numericSymbolMagnitude: 1000,
	            	numericSymbols: [ "k" , "M" , "G" , "T" , "P" , "E"],
	            	printChart: "Imprimir gráfico",
	            	rangeSelectorFrom: "De",
	            	rangeSelectorTo: "A",
	            	rangeSelectorZoom: "Zoom",
	            	resetZoom: "Restablecer zoom",
	            	resetZoomTitle: "Restablecer nivel de zoom 1:1",
	            	shortMonths: [ "Ene" , "Feb" , "Mar" , "Abr" , "May" , "Jun" , "Jul" , "Ago" , "Sep" , "Oct" , "Nov" , "Dic"],
	            	shortWeekdays: undefined,
	            	thousandsSep: " ",
	            	weekdays: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado"],
	            }
	        });
	    </script>
	    <!-- //js -->
	    <!-- //load-more -->
	    <!-- for bootstrap working -->
	    <script src="../js/bootstrap.js"></script>
	    <script type="text/javascript" src="../js/sweetalert.min.js"></script>
	    <!-- //for bootstrap working -->
	</body>

	</html>