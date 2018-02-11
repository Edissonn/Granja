<!--
author: W3layouts
author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<?php
session_start();
date_default_timezone_set("America/Bahia_Banderas");
$nombre = "";

//Validar si se ha iniciado session correctamente, y si los datos de la sesion estan puestos
if (!isset($_SESSION['nombre_admin']) && !isset($_SESSION['pk_admin']) && !isset($_SESSION['time_incative']) && !isset($_SESSION['time_login'])) {
	//Redirecciona al usuario al inicio o pagina principal
	header("location: ../index.php");
}else{

	//Se valida el tiempo de inactividad de la session
	$current_sinIn = (time() - $_SESSION['time_login']);
	if ($current_sinIn > $_SESSION['time_incative']) {
		session_destroy();
		header('location: ../index.php');
	}else{
		$_SESSION['time_login'] = time();
	}

	//Se agrega la conexion de PDO
	require_once('../conexion.php');

	//Se crea la instancia y el objeto de la clase conexion, para ejecutar las peticiones a la base de datos
	$obj_conexion = new Conexion();
	$conexion = $obj_conexion->conectar();

	//Si los datos esta puestos en session, se asignan los valores
	$nombre = $_SESSION['nombre_admin'];

	$sql2 = "SELECT pk_corcaja,fecha_corte,fecha_venta,DATE_FORMAT(hora,'%r') AS hora,ganancias FROM corte_caja WHERE status=1";
	$cortes_confirmados = $conexion->prepare($sql2);
	$cortes_confirmados->execute();
	$res_cortesConfirm = $cortes_confirmados->fetchAll();

}

function readConfCortes()
{	
	$timeSession = "Error al obtener la configuracion de Cortes de Caja!!";
	if (fopen('../admin/confCortes.txt', 'r')) {
		$archivo = fopen('../admin/confCortes.txt', 'r');
		$linea = "";
		while (!feof($archivo)) {
			$linea = fgets($archivo);
		}
		if ($linea!="") {
			return $linea;
		}else{
			return $timeSession;
		}
	}else{
		return $timeSession;
	}
}
?>
<!DOCTYPE html>
<html lang="es">

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
	<link href="../css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" media="all" />
	<link href="../css/lightbox.css" rel="stylesheet" type="text/css" media="all" />
	<link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
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
		<h2 class="title-w3-agileits inner">Cortes de Caja</h2>
		<p class="quia">El paraiso Granja organica sostenible</p>
	</div>
	<br>
	<br>

	<div class="container">
		<div class="jumbotron">
			<table class="table table-hover table-striped table-bordered">
				<thead>
					<tr>
						<th><strong style="color: black;">No.</strong></th>
						<th><strong style="color: black;">Quien Realizó</strong></th>
						<th><strong style="color: black;">Hora</strong></th>
						<th><strong style="color: black;">Fecha de Corte</strong></th>
						<th><strong style="color: black;">Fecha de Ventas</strong></th>
						<th><strong style="color: black;">Ventas totales</strong></th>
						<th><strong style="color: black;">Estado</strong></th>
					</tr>
				</thead>
				<tbody id="tb_cortesPendientes">
				</tbody>
			</table>
		</div>
	</div>
	<!-- hasta termina el formulario -->
	<!-- banner-bottom -->
	<div class="clearfix"> </div>
	<br>
	<br>
	<div align="center"><h1>Historial de Cortes de Caja</h1> </div>
	<div class="container">
		<div class="jumbotron">
			<table class="table table-hover table-striped table-bordered">
				<thead>
					<tr>
						<th><strong style="color: black;">No.</strong></th>
						<th><strong style="color: black;">Quien Realizó</strong></th>
						<th><strong style="color: black;">Hora</strong></th>
						<th><strong style="color: black;">Fecha de Corte</strong></th>
						<th><strong style="color: black;">Fecha de Ventas</strong></th>
						<th><strong style="color: black;">Ventas totales</strong></th>
						<th><strong style="color: black;">Estado</strong></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($res_cortesConfirm as $value) {
						?>
						<tr>
							<td>
								<strong style="color: black;"><?php echo $value['pk_corcaja']; ?></strong>
							</td>
							<td>
								<strong style="color: black;">Sistema</strong>
							</td>
							<td>
								<strong style="color: black;"><?php echo $value['hora']; ?></strong>
							</td>
							<td>
								<strong style="color: black;"><?php echo $value['fecha_corte']; ?></strong>
							</td>
							<td>
								<strong style="color: black;"><?php echo $value['fecha_venta']; ?></strong>
							</td>
							<td>
								<strong style="color: black;"><?php echo $value['ganancias']; ?></strong>
							</td>
							<td>
								<button class="btn btn-success">Confirmar corte de caja</button>
							</td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="clearfix"> </div>
</div>
</div>
</div>
<br>

<div class="modal fade" id="modalCortes" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<div class="signin-form profile">
					<h3 class="agileinfo_sign">Confirmacion de corte de caja</h3>
					<div class="login-form">
						<div class="jumbotron">
							<!-- <form action="#" method="post"> -->
							<table class="table table-hover table-striped table-bordered">
								<thead>
									<tr>
										<th><strong style="color: black;">Metodo de pago</strong></th>
										<th><strong style="color: black;">Esperado</strong></th>
										<th><strong style="color: black;">Otra cant.</strong></th>
										<th><strong style="color: black;">Correcto</strong></th>
										<th><strong style="color: black;">Contado</strong></th>
									</tr>
								</thead>
								<tbody id="tb_infoCorte">

								</tbody>
							</table>
							<!-- </form> -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
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
<!-- js -->
<script type="text/javascript" src="../js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/lightbox.js"></script>

<script type="text/javascript">

	//Variable global para el total del corte
	var total = 0;
	var ventasTotales = 0;
	var pk_corcaja = "";
	$(document).ready(function(){
		<?php 
		$json = readConfCortes();
		$data = json_decode($json);
		$hora;
		$minuto;
		if ($data->hora<=9) {
			$hora = "0".$data->hora;
		}else{
			$hora = $data->hora;
		}
		if ($data->minuto<=9) {
			$minuto = "0".$data->minuto;
		}else{
			$minuto = $data->minuto;
		}
		/////////////////Validar si el corte se puede realizar en el X dias de la semana///////////////
		$diaActual = date('D');
		$valid = 0;
		$array_dias = array('l' => 'Mon', 'm' => 'Tue', 'mi' => 'Wed', 'j' => 'Thu', 'v' => 'Fri', 's' => 'Sat', 'd' => 'Sun');
		$key_actual = array_search($diaActual, $array_dias);
		if (in_array($key_actual, $data->days)) {
			$valid = 1;
		}
		////////////////////////////////////////////////////////////////////////////////////////////////
		$horaCorte = strtotime($data->fecha." ".$hora.":".$minuto.":"."00");
		$horaActual = strtotime(date('Y-m-d h:i:s'));
		if ($horaActual>=$horaCorte && $valid==1) {
			echo "corteCaja();";
		}
		?>
	});

	function corteCaja() {
		$.ajax({
			url: "../controladores/corteCaja.php",
			type: "post",
			cache: false,
			success: function (responce) {
				$("#tb_cortesPendientes").html(responce);
			}
		});
	}

	function infoMontos(id) {
		pk_corcaja = id;
		$.ajax({
			url: "../controladores/corteCaja.php",
			type: "post",
			dataType: 'json',
			data:{pk_corcaja:id},
			cache: false,
			success: function (responce) {
				var monto_efectivo;
				var monto_tarjeta;
				$(responce).each(function(index, value){
					monto_efectivo = value.monto_efectivo;
					monto_tarjeta = value.monto_tarjeta;
					total = value.total;
					ventasTotales = value.total;
				});

				$("#tb_infoCorte").empty();

				if (monto_efectivo>1) {
					$("#tb_infoCorte").append('<tr class="1"><td><strong style="color: black;">Efectivo</strong></td><td><strong style="color: black;">$'+monto_efectivo+'</strong></td><td><strong style="color: black;"><button class="btn btn-warning" onclick="editarCant(1,'+monto_efectivo+');"><i class="fa fa-pencil" aria-hidden="true"></i></button></strong></td><td><strong style="color: black;"><button class="btn btn-success" id="1" onclick="contado_efectivo(this.id,'+monto_efectivo+');"><i class="fa fa-check" aria-hidden="true"></i></button></strong></td><td><strong style="color: black;"></strong></td></tr>');
				}else{
					$("#tb_infoCorte").append('<tr class="1"><td><strong style="color: black;">Efectivo</strong></td><td><strong style="color: black;">$'+monto_efectivo+'</strong></td><td><strong style="color: black;"></strong></td><td><strong style="color: black;"></strong></td><td><strong style="color: black;">$0</strong></td></tr>');
				}

				if (monto_tarjeta>1) {
					$("#tb_infoCorte").append('<tr class="2"><td><strong style="color: black;">Tarjeta</strong></td><td><strong style="color: black;">$'+monto_tarjeta+'</strong></td><td><strong style="color: black;"><button class="btn btn-warning" onclick="editarCant(2,'+monto_efectivo+');"><i class="fa fa-pencil" aria-hidden="true"></i></button></strong></td><td><strong style="color: black;"><button class="btn btn-success" id="2" onclick="contado_tarjeta(this.id,'+monto_tarjeta+');"><i class="fa fa-check" aria-hidden="true"></i></button></strong></td><td><strong style="color: black;"></strong></td></tr>');
				}else{
					$("#tb_infoCorte").append('<tr class="2"><td><strong style="color: black;">Tarjeta</strong></td><td><strong style="color: black;">$'+monto_tarjeta+'</strong></td><td><strong style="color: black;"></strong></td><td><strong style="color: black;"></strong></td><td><strong style="color: black;">$0</strong></td></tr>');
				}
				

				$("#tb_infoCorte").append('<tr class="3"><td><strong style="color: black;">TOTAL</strong></td><td colspan="2"><strong style="color: black;">$'+total+'</strong></td><td colspan="2"><strong style="color: red;">$-'+total+'</strong></td></tr>');
			}
		});
	}

	function editarCant(id_fila, monto_efectivo) {
		$('.'+id_fila).find('td').eq(4).html('<input type="number" min="1" name="otrcant" id="otrcant"> <button class="btn btn-success" onclick="confirmCant('+id_fila+','+monto_efectivo+');">Ok</button>');
	}

	function confirmCant(id_fila, monto_efectivo) {
		var nueva_cant = $("#otrcant").val();

		if (nueva_cant<monto_efectivo && nueva_cant!=0) {
			total = (total-nueva_cant);

			$('.'+id_fila).find('td').eq(4).html('<strong style="color: black;">$'+nueva_cant+'</strong>');

			//Se elimina el boton de editar cantidad en la fila correspondiente
			$('.'+id_fila).find('td').eq(2).html('');
			//Se remueve el boton de aprobar contado
			$("#"+id_fila).remove();

			$('.3').find('td').eq(2).html('<strong style="color: red;">$-'+total+'</strong>');

			contadoFaltante();

			$('.1').find('td').eq(3).html('');
		}else{
			alert("La nueva catidad no puede ser mayor o igual a la ganancia total, y tampoco pude dejar el campo vacio!!");
		}
		
	}

	function contado_efectivo(id_fila, monto_efectivo) {
		total = (total-monto_efectivo);

		var color="red";
		if (total==0) {
			$("#tb_infoCorte").append('<tr><td colspan="5"><label>¿Cuanto efectivo decea conservar en caja? </label><input type="number" min="1" step="1.0" name="saveCaja" id="saveCaja" class="form-control" required=""></td></tr>');
			$("#tr_acept").remove();
			$("#tb_infoCorte").append('<tr id="tr_acept"><td colspan="5"><button class="btn btn-success form-control" onclick="realizarCorteCaja();">Realizar Corte de Caja</button></td></tr>');
			color="green";
		}

		$('.'+id_fila).find('td').eq(4).html('<strong style="color: black;">$'+monto_efectivo+'</strong>');
		$('.3').find('td').eq(2).html('<strong style="color: '+color+';">$-'+total+'</strong>');

		$("#"+id_fila).remove();
		$('.'+id_fila).find('td').eq(3).html('');
		//Se elimina el boton de editar cantidad en la fila correspondiente
		$('.'+id_fila).find('td').eq(2).html('');
		
		contadoFaltante();

	}

	function contado_tarjeta(id_fila, monto_tarjeta) {
		total = (total-monto_tarjeta);

		var color="red";
		if (total==0) {
			$("#tb_infoCorte").append('<tr><td colspan="5"><label>¿Cuanto efectivo decea conservar en caja? </label><input type="number" min="1" step="1.0" name="saveCaja" id="saveCaja" class="form-control" required=""></td></tr>');
			$("#tr_acept").remove();
			$("#tb_infoCorte").append('<tr id="tr_acept"><td colspan="5"><button class="btn btn-success form-control" onclick="realizarCorteCaja();">Realizar Corte de Caja</button></td></tr>');
			color="green";
		}

		$('.'+id_fila).find('td').eq(4).html('<strong style="color: black;">$'+monto_tarjeta+'</strong>');
		$('.3').find('td').eq(2).html('<strong style="color: '+color+';">$-'+total+'</strong>');

		$("#"+id_fila).remove();
		//Se elimina el boton de editar cantidad en la fila correspondiente
		$('.'+id_fila).find('td').eq(2).html('');

		contadoFaltante();
		
	}

	function contadoFaltante() {
		var fila1 = $('.1').find('td').eq(4).text();
		var fila2 = $('.2').find('td').eq(4).text();
		if (fila1!="" && fila2!="" && total>0) {
			$("#tb_infoCorte").append('<tr><td colspan="5"><h5>Oops, parece que no cuadran las ventas totales, han faltado $'+total+' para completar las ventas totales del dia :(</h5></td></tr>');
			$("#tb_infoCorte").append('<tr><td colspan="5"><label>¿Cuanto efectivo decea conservar en caja? </label><input type="number" min="1" step="1.0" name="saveCaja" id="saveCaja" class="form-control" required=""></td></tr>');
			$("#tr_acept").remove();
			$("#tb_infoCorte").append('<tr id="tr_acept"><td colspan="5"><button class="btn btn-warning form-control" onclick="realizarCorteCaja();">Realizar Corte de Caja</button></td></tr>');
		}
	}

	function realizarCorteCaja() {
		var saveCaja = $("#saveCaja").val();
		if (saveCaja && saveCaja>0.9) {
			if (saveCaja<=ventasTotales) {
				$.ajax({
					url: "../controladores/corteCaja.php",
					type: "post",
					cache: false,
					data: {caja:saveCaja,pk_corcaja:pk_corcaja},
					success: function (responce) {
						if (responce=="true") {
							alert('Corte de caja realizado con exito!!');
							location.href ="corte_caja.php";
						}else{
							alert('Oop, algo salio mal!! ;(');
						}
					}
				});
			}else{
				alert("La cantidad maxima disponible para dejar en caja es de: $"+ventasTotales);
			}
		}else{
			$.ajax({
				url: "../controladores/corteCaja.php",
				type: "post",
				cache: false,
				data: {caja:0,pk_corcaja:pk_corcaja},
				success: function (responce) {
					if (responce=="true") {
						alert('Corte de caja realizado con exito!!');
						location.href ="corte_caja.php";
					}else{
						alert('Oop, algo salio mal!! ;(');
					}
				}
			});
		}
		
	}

</script>
<!-- //js -->
<!-- //load-more -->
<!-- for bootstrap working -->
<script src="../js/bootstrap.js"></script>
<script type="text/javascript" src="../js/sweetalert.min.js"></script>
<!-- //for bootstrap working -->
</body>

</html>