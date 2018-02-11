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

}

function read()
{	
	$timeSession = "Error al obtener el tiempo de la session!!";
	if (fopen('../admin/timeSession.txt', 'r')) {
		$archivo = fopen('../admin/timeSession.txt', 'r');
		$linea = "";
		while (!feof($archivo)) {
			$linea = fgets($archivo);
			//$saltolinea = nl2br($linea);
		}
		if ($linea!="") {
			$base = 60;
			$minutos = ($linea/$base);
			if ($minutos>=60) {
				return "1 Hora";
			}else{
				return $minutos." Minutos";
			}
		}else{
			return $timeSession;
		}
	}else{
		return $timeSession;
	}
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
		<h2 class="title-w3-agileits inner">Configuracion de sessiones</h2>
		<p class="quia">El paraiso Granja organica sostenible</p>
	</div>
	<br>
	<br>
	<div class="container">
		<div class="jumbotron">
			<form action="../controladores/saveConfig.php" method="POST">
				<div class="container">
					<table class="table table-hover table-striped table-bordered">
						<thead>
							<tr>
								<th>Tipo de Usuario</th>
								<th>Tiempo actual</th>
								<th>Tiempo de Inactividad en minutos</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<strong style="color: black;">Administrador / Usuario</strong>
								</td>
								<td>
									<strong style="color: black;"><?php echo read(); ?></strong>
								</td>
								<td>
									<input type="number" min="20" max="60" step="1.0" name="time_activity" id="time_activity" class="form-control">
								</td>
								<td>
									<input type="submit" name="save" value="Guardar" id="save" class="form-control btn btn-success">
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</form>
		</div>
	</div>
	<!-- hasta termina el formulario -->
	<!-- banner-bottom -->
	<div class="clearfix"> </div>
	<div class="container">
		<h2 class="title-w3-agileits inner">Configuracion de horarios de cortes de caja</h2>
	</div>
	<br>
	<br>
	<div class="container">
		<div class="jumbotron">
			<form action="../controladores/saveConfig.php" method="POST" name="frmSaveConfigCorreCaja" id="frmSaveConfigCorreCaja">
				<div class="container">
					<table class="table table-hover table-striped table-bordered">
						<thead>
							<tr>
								<th>Tipo de Usuario</th>
								<th>Dias de la semana</th>
								<th>Hora</th>
								<th>Minutos</th>
								<th>Turno</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="6" id="tr_info">
									
								</td>
							</tr>
							<tr>
								<td>
									<strong style="color: black;">Administrador / Usuario</strong>
								</td>
								<td>
									<label><input type="checkbox" name="day[]" id="l" value="l">L</label>
									<label><input type="checkbox" name="day[]" id="m" value="m">M</label>
									<label><input type="checkbox" name="day[]" id="mi" value="mi">Mi</label>
									<label><input type="checkbox" name="day[]" id="j" value="j">J</label>
									<label><input type="checkbox" name="day[]" id="v" value="v">V</label>
									<label><input type="checkbox" name="day[]" id="s" value="s">S</label>
									<label><input type="checkbox" name="day[]" id="d" value="d">D</label>
								</td>
								<td>
									<select name="hora" id="hora" required="" class="form-control">
										<option value="">Seleccione la hora</option>
										<?php
										for ($i=0; $i < 12; $i++) {
											?>
											<option value="<?php echo ($i+1); ?>">
												<?php echo ($i+1); ?>
											</option> 
											<?php
										}
										?>
									</select>
								</td>
								<td>
									<select name="minutos" id="minutos" required="" class="form-control">
										<option value="">Seleccione los minutos</option>
										<?php
										for ($i=0; $i < 60; $i++) {
											?>
											<option value="<?php echo ($i+1); ?>">
												<?php echo ($i+1); ?>
											</option> 
											<?php
										}
										?>
									</select>
								</td>
								<td>
									<select name="turno" id="turno" class="form-control" required="">
										<option value="">Seleccione un turno</option>
										<option value="am">AM</option>
										<option value="pm">PM</option>
									</select>
								</td>
								<td>
									<input type="submit" value="Guardar" class="form-control btn btn-success">
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</form>
		</div>
	</div>
</div>
</div>
</div>
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
<!-- js -->
<script type="text/javascript" src="../js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/lightbox.js"></script>

<script type="text/javascript">
	$(document).ready(function(){

		var diasSemana = {'l':'Lunes','m':'Martes','mi':'Miercoles','j':'Jueves','v':'Viernes','s':'Sabado','d':'Domingo'};
		var diasSelected = "";

		$(<?php echo readConfCortes(); ?>).each(function(index, value) {
			for (var i = 0; i < value.days.length; i++) {
				$("#"+value.days[i]).prop('checked', true);

				for (var propiedad in diasSemana) {
					if (diasSemana.hasOwnProperty(propiedad)) {
						if (value.days[i]==propiedad) {
							diasSelected += diasSemana[propiedad]+",";
						}
					}
				}
			}
			$('#hora option[value="'+value.hora+'"]').attr("selected", "selected");
			$('#minutos option[value="'+value.minuto+'"]').attr("selected", "selected");
			$('#turno option[value="'+value.turno+'"]').attr("selected", "selected");

			$("#tr_info").append('<h4>Los usuarios pueden realizar los Cortes de Caja, justo despues de: '+value.hora+":"+value.minuto+":"+"00"+" "+value.turno+", los dias: "+diasSelected+"</h4>");
		});
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