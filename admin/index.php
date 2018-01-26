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
	<link href="../css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" media="all" />
	<link href="../css/lightbox.css" rel="stylesheet" type="text/css" media="all" />
	<link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
	<link href="../css/font-awesome.css" rel="stylesheet">
</head>

<body>
	
	<?php include 'header.php' ?>

	<!--// top_header_agile_info_w3ls -->
	<!-- Modal2 -->
	<div class="modal fade" id="myModal3" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="signin-form profile">
						<h3 class="agileinfo_sign">Regístrate</h3>
						<div class="login-form">
							<form action="../controladores/insertar_usuario.php" method="POST" role="form">
								<label for="">Nombre:</label>
								<input type="text" name="nombre" placeholder="Juan Antonio" required="">
								<label for="">Apellidos:</label>
								<input type="text" name="apellidos" placeholder="Ramirez Carrillo" required="">
								<label for="">Correo:</label>
								<input type="email" name="correo" placeholder="antonio_surf_sayulita@hotmail.com" required="">
								<label for="">Contraseña:</label>
								<input type="password" name="contrasenia" placeholder="Contraseña" required="">
								<label for="">Tipo de Usuario:</label>
								<select name="tipo_usuario" class="form-control">
									<option value="1">Administrador</option>
									<option value="2">Vendedor</option>
								</select>
								<br>
								<br>
								<input type="submit" value="Regístrate">
							</form>
						</div>
						<p class="click"><a> Al hacer clic en Registrarse, usted está de acuerdo con mis <a>Términos y condiciones de la póliza.</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- //Modal2 -->
	<!-- js -->
	<script type="text/javascript" src="../js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="../js/lightbox.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){

		</script>
		<!-- //js -->
		<!-- //load-more -->
		<!-- for bootstrap working -->
		<script src="../js/bootstrap.js"></script>
		<script type="text/javascript" src="../js/sweetalert.min.js"></script>
		<!-- //for bootstrap working -->
	</body>

	</html>