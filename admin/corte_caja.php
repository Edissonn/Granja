<!--
author: W3layouts
author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<?php
session_start();
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

	$sql2 = "SELECT * FROM corte_caja WHERE status=1";
	$cortes_confirmados = $conexion->prepare($sql2);
	$cortes_confirmados->execute();
	$res_cortesConfirm = $cortes_confirmados->fetchAll();

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
								<strong style="color: black;">----</strong>
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
						<form action="#" method="post">
							<div class="form-group">
								<label>Nombre de Usuario</label>
								<input type="text" class="form-control" name="user" id="user">
							</div>
							<div class="form-group">
								<label>Contraseña</label>
								<input type="password" class="form-control" name="pass" id="pass">
							</div>
							<div class="form-group">
								<label>Cantidad en caja</label>
								<input type="number" class="form-control" name="cantidadEfec" id="cantidadEfec">
							</div>
							<div class="form-group">
								<input type="submit" value="Confirmar">
							</div>
						</form>
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

	function validBtnCorteCaja() {
		var Digital=new Date();
		var hours=Digital.getHours();
		var minutes=Digital.getMinutes();
		var seconds=Digital.getSeconds();
		var dn="am";

		if (hours>12){
			dn="pm";
			hours=hours-12;
		}
		if (hours==0){
			hours=12;
		}
		if (minutes<=9){
			minutes="0"+minutes;
		}
		if (seconds<=9){
			seconds="0"+seconds;
		}
		
		if (hours>=4 && minutes>=0 && dn=="pm") {
			corteCaja();
		}
	}
	$(document).ready(function(){
		validBtnCorteCaja();
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