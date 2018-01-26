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
if (!isset($_SESSION['nombre_user']) && !isset($_SESSION['pk_usuario'])) {
	//Redirecciona al usuario al inicio o pagina principal
	header("location: ../index.php");
}else{
	//Si los datos esta puestos en session, se asignan los valores
	$nombre = $_SESSION['nombre_user'];
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
	<!-- //custom-theme -->
	<!-- font-awesome-icons -->
	<link href="../css/font-awesome.css" rel="stylesheet">
	<!-- //font-awesome-icons -->
	<link href="//fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Montserrat:200,200i,300,400,400i,500,500i,600,600i,700,700i,800" rel="stylesheet">
</head>

<body>
	<!-- banner -->
	<div class="banner1" id="home">
		<div class="center-container inner_agile">
			<!-- top_header_agile_info_w3ls -->
			<div class="top_header_agile_info_w3ls">
				<nav class="navbar navbar-default">
					<div class="navbar-header navbar-left">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<h1><a class="navbar-brand" href="index.php"><span>P</span>unto de venta</a></h1>
					</div>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
						<div class="w3l_header_left">
							<ul>
								<li><i class="fa fa-phone" aria-hidden="true"></i> +(52) 322 111 5320</li>
								<li><i class="glyphicon glyphicon-user" aria-hidden="true"></i><?php if ($nombre != "") {
									echo $nombre;
								} ?></a></li>
								<li> <i class="glyphicon glyphicon-remove-sign"></i> <a href="../controladores/control_sesiones/cerrar_session.php">Cerrar Sesion</a></li>
							</ul>
						</div>
						<div class="clearfix"> </div>
						<div id="m_nav_container" class="m_nav wthree_bg" align="right">
							<nav class="menu menu--sebastian">
								<ul id="m_nav_list" class="m_nav menu__list">
									<li class="m_nav_item active" id="m_nav_item_1"> <a href="index.php" class="link link--kumya"><i class="glyphicon glyphicon-inbox" aria-hidden="true"></i><span data-letters="Pedidos">Pedidos</span></a></li>
									<li class="m_nav_item" id="moble_nav_item_4"> <a href="agregar_producto.php" class="link link--kumya"><i class="glyphicon glyphicon-file" aria-hidden="true"></i><span data-letters="Agregar productos">Agregar productos</span></a></li>
									<li class="m_nav_item" id="moble_nav_item_6"> <a href="ventas.php" class="link link--kumya"><i class="glyphicon glyphicon-usd" aria-hidden="true"></i><span data-letters="Ventas">Ventas</span></a></li>
								</ul>
							</nav>
						</div>
					</div>
				</nav>
			</div>

			<!--// top_header_agile_info_w3ls -->
			<!--/slider-->
			<div class="banner_wthree_agile_info">
				<div class="slider">
					<div class="callbacks_container">
						<ul class="rslides callbacks callbacks1" id="slider4">
							<li>
								<div class="agileits-banner-info">
									<p>"El paraiso"</p>
									<h3>Granja orgánica sostenible</h3>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!--//slider-->
		</div>
	</div>
</div>
<!-- //banner -->
<!-- Modal1 -->
<!-- Tipos de Usurios -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<div class="signin-form profile">
					<h3 class="agileinfo_sign">Usuarios</h3>
					<div class="login-form">
						<form action="controladores/control_sesiones/login.php" method="post">
							<input type="email" name="user" placeholder="Nombre usuario" required="">
							<input type="password" name="pass" placeholder="Contraseña" required="">
							<div class="tp">
								<input type="submit" value="Iniciar Sesion">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- //Modal1 -->
<!-- banner-bottom -->
<div class="banner-bottom">
	<div class="container">
		<div class="col-md-7 banner_bottom_left">
			<h2 class="title-w3-agileits one">Registrar productos</h2>
			<p><i>Productos de la mejor calidad! </i></p>
			<form action="insertar_producto.php">
				<div class="table table-hover">
					<tr>
						<td>
							<div class="form-group">
								<label for="choose">Nombre del producto:</label>
								<input type="text" class="form-control" id="nombre" name="nombre" required="" placeholder="Nombre">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">
								<label for="choose">Ruta de la imagen:</label>
								<input type="text" class="form-control" id="ruta_img" name="ruta_img" required="" placeholder="$20.00">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">
								<label for="choose">Codigo:</label>
								<input type="text" class="form-control" id="codigo" name="codigo" required="" placeholder="$0">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">
								<label for="choose">Precio:</label>
								<input type="text" class="form-control" id="precio" name="precio" placeholder="$0">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">
								<label for="choose">Categoria:</label>
								<input type="text" class="form-control" id="categoria" name="categoria" placeholder="Lacteos">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">
								<label for="choose">Stok:</label>
								<input type="text" class="form-control" id="stok" name="stok" required="" placeholder="$20.00">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">
								<label for="choose">Importe:</label>
								<input type="text" class="form-control" id="importe" name="importe">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">
								<label for="choose">Ganancia:</label>
								<input type="text" class="form-control" id="ganancia" name="ganancia">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">
								<label for="choose">Unidad:</label>
								<input type="text" class="form-control" id="unidad" name="unidad" placeholder="Litros, Gramos, 1/2 litro, Kilogramos, Mililitors">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">
								<label for="choose">Cantidad:</label>
								<input type="text" class="form-control" id="cant_producto" name="cant_producto">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<input type="submit" class="btn btn-success form-control" required="" value="Guardar">
						</td>
					</tr>

				</div>
			</form>
		</div>
		<br>
		<br>
	</div>
	<div class="col-md-5 banner_bottom_right">
	</div>
</div>
</div>

<div class="container">
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 align="center" class="panel-title">Lista de productos</h3>
		</div>
		<div class="panel-body">
			<form action="modificar_producto.php" method="POST">
				<div align="right" class="form-group">
					<input type="text" placeholder="Buscar" name="valor">
					<input type="submit" class="btn btn-success" value="Buscar">
				</div>
			</form>
			<div class="table-responsive">
				<table class="table table-bordered table-striped table-hover">
					<thead>
						<tr align="center">
							<th>ID</th>
							<th>Nombre del producto</th>
							<th>Precio</th>
							<th>Cantidad</th>
							<th>Cantidad en existencia</th>
							<th>Categoría</th>
							<th>Importe</th>
							<th>Responsable</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (count($res) > 0) {
							foreach ($res as $valores) {
								?>
								<tr>
									<form action="editarDocumento.php" method="POST">
										<td>
											<a href="dowload.php?rutaArchivo=<?php echo $valores['archivo']; ?>" target="_blank" class="btn btn-success"><span class="glyphicon glyphicon-link">Archivo</span></a>
										</td>
										<td>
											<?php echo $valores['id']; ?>
											<input type="hidden" name="id" value="<?php echo $valores['id']; ?>">
										</td>
										<td>
											<?php echo $valores['nombre']; ?>
											<input type="hidden" name="pk_producto" id="pk_producto" value="<?php echo $valores['pk_producto']; ?>">
										</td>
										<td>
											<?php echo $valores['ruta_image']; ?>
											<input type="hidden" name="ruta_image" value="<?php echo $valores['ruta_image']; ?>">
										</td>
										<td>
											<?php echo $valores['precio']; ?>
											<input type="hidden" name="precio" value="<?php echo $valores['precio']; ?>">
										</td>
										<td>
											<?php echo $valores['categoria']; ?>
											<input type="hidden" name="pk_categoria" value="<?php echo $valores['pk_categoria']; ?>">
										</td>
										<td>
											<?php echo $valores['stok']; ?>
											<input type="hidden" name="stok" value="<?php echo $valores['stok']; ?>">
										</td>
										<td>
											<?php echo $valores['importe']; ?>
											<input type="hidden" name="importe" value="<?php echo $valores['importe']; ?>">
										</td>
										<td>
											<?php echo $valores['ganancia']; ?>
											<input type="hidden" name="pk_ganancia" value="<?php echo $valores['pk_ganancia']; ?>">
										</td>
										<td>
											<?php echo $valores['unidad']; ?>
											<input type="hidden" name="pk_unidad" value="<?php echo $valores['pk_unidad']; ?>">
										</td>
										<td>
											<?php echo $valores['cant_producto']; ?>
											<input type="hidden" name="cant_producto" value="<?php echo $valores['cant_producto']; ?>">
										</td>
										<td>
											<?php echo $valores['provedor']; ?>
											<input type="hidden" name="pk_provedor" value="<?php echo $valores['pk_provedor']; ?>">
										</td>
										<td>

											<input type="hidden" name="pkDocumentos" value="<?php echo $valores['pkDocumentos']; ?>">
											<input type="hidden" name="fk_tipo" value="<?php echo $valores['fk_tipo']; ?>">
											<input type="submit" class="btn btn-warning" value="Modificar">

										</td>
									</form>
									<?php
									if ($valores['estado'] == 0) {
										?>
										<form action="activar.php" method="POST">
											<td>
												<input type="hidden" name="pkDocumentos" value="<?php echo $valores['pkDocumentos']; ?>">
												<input type="submit" class="btn btn-success" value="Dar de Alta">
											</td>
										</form>
										<?php 
									}else if ($valores['estado'] == 1){
										?>
										<form action="desactivar.php" method="POST">
											<td>
												<input type="hidden" name="pkDocumentos" value="<?php echo $valores['pkDocumentos']; ?>">
												<input type="submit" class="btn btn-danger" value="Dar de Baja">
											</td>
										</form>
										<?php
									}
									?>

								</tr>

								<?php
							}
						}else{
							?>
							<h3 align="center">No hay documentos registrados</h3>
							<?php
						}

						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</div>
<!-- //testimonials -->
<!-- footer -->

<div class="agileinfo_copy_right">
	<div class="container">
		<div class="agileinfo_copy_right_left">
			<p>© 2017 Granja. Todos los derechos reservados | Diseñado por <a href="https://www.facebook.com/J.AntonioRamirezC.10">Antonio Ramirez</a></p>
		</div>

		<div class="clearfix"> </div>
	</div>
</div>
<!-- //footer -->
<!-- js -->
<script type="text/javascript" src="../js/jquery-2.1.4.min.js"></script>
<!-- //js -->
<script src="../js/jquery.vide.min.js"></script>
<script src="../js/responsiveslides.min.js"></script>
<script>
		// You can also use "$(window).load(function() {"
			$(function () {
			// Slideshow 4
			$("#slider4").responsiveSlides({
				auto: true,
				pager: true,
				nav: false,
				speed: 500,
				namespace: "callbacks",
				before: function () {
					$('.events').append("<li>before event fired.</li>");
				},
				after: function () {
					$('.events').append("<li>after event fired.</li>");
				}
			});

		});
		</script>

		<!-- Stats-Number-Scroller-Animation-JavaScript -->
		<script src="../js/waypoints.min.js"></script>
		<script src="../js/counterup.min.js"></script>
		<script>
			jQuery(document).ready(function ($) {
				$('.counter').counterUp({
					delay: 10,
					time: 1000,
				});
			});
		</script>
		<!-- //Stats-Number-Scroller-Animation-JavaScript -->

		<!-- flexSlider -->
		<link rel="stylesheet" href="../css/flexslider.css" type="text/css" media="screen" property="" />
		<script defer src="../js/jquery.flexslider.js"></script>
		<script type="text/javascript">
			$(window).load(function () {
				$('.flexslider').flexslider({
					animation: "slide",
					start: function (slider) {
						$('body').removeClass('loading');
					}
				});
			});
		</script>
		<!-- //flexSlider -->
		<!-- //load-more -->
		<!-- for bootstrap working -->
		<script src="../js/bootstrap.js"></script>
		<!-- //for bootstrap working -->
	</body>

	</html>