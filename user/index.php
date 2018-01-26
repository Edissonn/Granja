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
						<h1><a class="navbar-brand" href="index.html"><span>P</span>unto de venta</a></h1>
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
		</div>
	</div>
	<!-- //banner -->
	<div class="services-breadcrumb">
		<div class="container">
			<ul>
				<li><a href="index.php">Inicio</a><i>|</i></li>
				<li>Vendedor</li>
			</ul>
		</div>
	</div>
	<!-- /single_page-->
	<div class="banner-bottom">
		<div class="container">
			<h2 class="title-w3-agileits inner">Vendedor</h2>
			<p class="quia">Historial de ventas </p>
			<div class="agile_about_grids">
				<div class="col-md-4 agile_single_left">
					<div class="agileits_recent_posts">
						<h3>Ventas recientes</h3>
						<div class="agileits_recent_posts_grid">
							<div class="agileits_recent_posts_gridl">
								<img src="images/7.jpg" alt=" " class="img-responsive" />
							</div>
							<div class="agileits_recent_posts_gridr">
								<h4><a href="administrador.php">velit esse quam nihil</a></h4>
								<ul>
									<li><span class="fa fa-envelope-o" aria-hidden="true"></span><a href="#">2</a></li>
									<li><span class="fa fa-clock-o" aria-hidden="true"></span>5:30 AM</li>
								</ul>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="agileits_recent_posts_grid">
							<div class="agileits_recent_posts_gridl">
								<img src="images/8.jpg" alt=" " class="img-responsive" />
							</div>
							<div class="agileits_recent_posts_gridr">
								<h4><a href="administrador.php">molestiae conseq</a></h4>
								<ul>
									<li><span class="fa fa-envelope-o" aria-hidden="true"></span><a href="#">5</a></li>
									<li><span class="fa fa-clock-o" aria-hidden="true"></span>6:00 AM</li>
								</ul>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="agileits_recent_posts_grid">
							<div class="agileits_recent_posts_gridl">
								<img src="images/9.jpg" alt=" " class="img-responsive" />
							</div>
							<div class="agileits_recent_posts_gridr">
								<h4><a href="administrador.php">dolorem eum fugiat</a></h4>
								<ul>
									<li><span class="fa fa-envelope-o" aria-hidden="true"></span><a href="#">3</a></li>
									<li><span class="fa fa-clock-o" aria-hidden="true"></span>6:30 AM</li>
								</ul>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="agileits_recent_posts_grid">
							<div class="agileits_recent_posts_gridl">
								<img src="images/10.jpg" alt=" " class="img-responsive" />
							</div>
							<div class="agileits_recent_posts_gridr">
								<h4><a href="administrador.php">quo voluptas nulla</a></h4>
								<ul>
									<li><span class="fa fa-envelope-o" aria-hidden="true"></span><a href="#">7</a></li>
									<li><span class="fa fa-clock-o" aria-hidden="true"></span>8:30 AM</li>
								</ul>
							</div>
							<div class="clearfix"> </div>
						</div>
					</div>
				</div>
				<div class="col-md-8 agile_single_right">
					<div class="w3_comments">
						<ul>
							<li><span class="fa fa-calendar" aria-hidden="true"></span>25th Jan 2017</li>
							<li><span class="fa fa-user" aria-hidden="true"></span><a href="#">James Smith</a></li>
							<li><span class="fa fa-envelope-o" aria-hidden="true"></span><a href="#">5 Comments</a></li>
							<li><span class="fa fa-tags" aria-hidden="true"></span><a href="#">5 Tags</a></li>
						</ul>
					</div>
					<div align="center" class="banner-bottom">
						<div align="center" class="container">
							<div class="col-md-7 banner_bottom_left">
								<h2 class="title-w3-agileits one">Nuestros Productos</h2>
								<p><i>Productos de la mejor calidad! </i></p>
								<br>
								<div class="row" class="container">
									<form action="">
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
														<label for="choose">Precio:</label>
														<input type="text" class="form-control" id="" name="" required="" placeholder="">
													</div>
												</td>
											</tr>
											<tr>
												<td>
													<div class="form-group">
														<label for="choose">Cantidad:</label>
														<input type="text" class="form-control" id="" name="" required="" placeholder="">
													</div>
												</td>
											</tr>
											<tr>
												<td>
													<div class="form-group">
														<label for="choose">Kg:</label>
														<input type="text" class="form-control" id="" name="" required="" placeholder="">
													</div>
												</td>
											</tr>
											<tr>
												<td>
													<div class="form-group">
														<label for="choose">Iva:</label>
														<input type="text" class="form-control" id="" name="" required="" placeholder="">
													</div>
												</td>
											</tr>
											<tr>
												<td>
													<div class="form-group">
														<label for="choose">Tipo:</label>
														<input type="text" class="form-control" id="" name="" required="" placeholder="">
													</div>
												</td>
											</tr>
											<tr>
												<td>
													<div class="form-group">
														<label for="choose">Fecha:</label>
														<input type="text" class="form-control" id="" name="" required="" placeholder="">
													</div>
												</td>
											</tr>
											<tr>
												<td>
													<div class="form-group">
														<label for="choose">Responsable:</label>
														<input type="text" class="form-control" id="" name="" required="" placeholder="">
													</div>
												</td>
											</tr>
											<tr>
												<td>
													<div class="form-group">
														<label for="choose">Categoria:</label>
														<input type="text" class="form-control" id="" name="" required="" placeholder="">
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
							</div>
							<div class="col-md-5 banner_bottom_right">
							</div>
						</div>
					</div>
					<!-- banner-bottom -->
					<div class="clearfix"> </div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 align="center" class="panel-title">Ventas</h3>
				</div>
				<div class="panel-body">
					<form action="#" method="POST">
						<div align="right" class="form-group">
							<i class="glyphicon glyphicon-search"></i>
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
									<th>Categoría</th>
									<th>Gramos</th>
									<th>Litros</th>
									<th>Tipo</th>
									<th>Fecha</th>
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
													<?php echo $valores['id']; ?>
													<input type="hidden" name="" value="<?php echo $valores['']; ?>">
												</td>
												<td>
													<?php echo $valores['nombre']; ?>
													<input type="hidden" name="" value="<?php echo $valores['']; ?>">
												</td>
												<td>
													<?php echo $valores['tipo']; ?>
													<input type="hidden" name="" id="" value="<?php echo $valores['']; ?>">
												</td>
												<td>
													<?php echo $valores['']; ?>
													<input type="hidden" name="" value="<?php echo $valores['']; ?>">
												</td>
												<td>
													<?php echo $valores['']; ?>
													<input type="hidden" name="" value="<?php echo $valores['']; ?>">
												</td>
												<td>
													<?php echo $valores['']; ?>
													<input type="hidden" name="" value="<?php echo $valores['']; ?>">
												</td>
												<td>
													<?php echo $valores['']; ?>
													<input type="hidden" name="" value="<?php echo $valores['']; ?>">
												</td>
												<td>
													<?php echo $valores['']; ?>
													<input type="hidden" name="" value="<?php echo $valores['']; ?>">
												</td>
												<td>
													<?php echo $valores['']; ?>
													<input type="hidden" name="" value="<?php echo $valores['']; ?>">
												</td>
												<td>
													<?php echo $valores['']; ?>
													<input type="hidden" name="" value="<?php echo $valores['']; ?>">
												</td>
												<td>
													<?php echo $valores['']; ?>
													<input type="hidden" name="" value="<?php echo $valores['']; ?>">
												</td>
												<td>
													<?php echo $valores['']; ?>
													<input type="hidden" name="" value="<?php echo $valores['']; ?>">
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
									<h3 align="center">No hay ventas registradas</h3>
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
	<!-- //single_page -->
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
	<!-- //load-more -->
	<!-- for bootstrap working -->
	<script src="../js/bootstrap.js"></script>
	<!-- //for bootstrap working -->
</body>

</html>