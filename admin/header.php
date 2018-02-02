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
							<li><a class="sign" href="#" data-toggle="modal" data-target="#myModal3"><i class="fa fa-user" aria-hidden="true"></i></a>									</li>

							<li><i class="fa fa-phone" aria-hidden="true"></i> +(52) 322 111 5320</li>
							<li><i class="glyphicon glyphicon-user" aria-hidden="true"></i><?php if ($nombre != "") {
								echo $nombre;
							} ?></a></li>
							<li> <i class="glyphicon glyphicon-remove-sign"></i> <a href="../controladores/control_sesiones/cerrar_session.php">Cerrar Sesion</a></li>
						</ul>
					</div>
					<div class="clearfix"></div>
					<div id="m_nav_container" class="m_nav wthree_bg">
						<nav class="menu menu--sebastian">
							<ul id="m_nav_list" class="m_nav menu__list">
								<li class="m_nav_item" id="moble_nav_item_4">
									<ul id="m_nav_list" class="m_nav menu__list">
										<li class="dropdown">
											<a class="dropdown-toggle" data-toggle="dropdown">
												<i class="glyphicon glyphicon-plus" aria-hidden="true"></i>Agregar productos <span class="caret"></span>
											</a>
											<ul class="dropdown-menu">
												<li><a href="productos_nuevos.php"><i class="fa fa-home" aria-hidden="true"></i>Productos</a></li>
											</ul>
										</li>
									</ul>
									<!--  -->
								</li>
								<li class="m_nav_item" id="moble_nav_item_4">
									<ul id="m_nav_list" class="m_nav menu__list">
										<li class="dropdown">
											<a class="dropdown-toggle" data-toggle="dropdown">
												<i class="glyphicon glyphicon-file" aria-hidden="true"></i>Reportes <span class="caret"></span>
											</a>
											<ul class="dropdown-menu">
												<li><a href="graficas.php"><i class="fa fa-bar-chart" aria-hidden="true"></i>Graficas</a></li>
												<li><a href="facturas.php"><i class="glyphicon glyphicon-list-alt" aria-hidden="true"></i>Facturas</a></li>
											</ul>
										</li>
									</ul>
									<!--  -->
								</li>
								<!-- <li class="m_nav_item" id="moble_nav_item_6"> <a href="ventas.php" class="link link--kumya"><i class="glyphicon glyphicon-usd" aria-hidden="true"></i><span data-letters="Ventas">Ventas</span></a></li>-->
								<li class="m_nav_item" id="moble_nav_item_4">
									<ul id="m_nav_list" class="m_nav menu__list">
										<li class="dropdown">
											<a class="dropdown-toggle" data-toggle="dropdown" href="#">
												<i class="glyphicon glyphicon-piggy-bank" aria-hidden="true"></i>Ventas<span class="caret"></span>
											</a>
											<ul class="dropdown-menu">
												<li><a href="ventas.php"><i class="glyphicon glyphicon-usd" aria-hidden="true"></i>Ventas</a></li>
												<li><a href="provedores.php"><i class="glyphicon glyphicon-usd" aria-hidden="true"></i>Cortes de caja</a></li>
												<li><a href="historial_ventas.php"><i class="glyphicon glyphicon-list-alt" aria-hidden="true"></i>Historial de ventas</a></li>
											</ul>
										</li>
									</ul>
									<!--  -->
								</li>
								<!-- <li class="m_nav_item" id="moble_nav_item_6"> <a href="lista_usuarios.php" class="link link--kumya"><i class="glyphicon glyphicon-th-list" aria-hidden="true"></i><span data-letters="Lista de usuarios">Lista de usuarios</span></a></li>-->
								<li class="m_nav_item" id="moble_nav_item_4">
									<ul id="m_nav_list" class="m_nav menu__list">
										<li class="dropdown">
											<a class="dropdown-toggle" data-toggle="dropdown" href="#">
												<i class="glyphicon glyphicon-th-list" aria-hidden="true"></i> Lista de Usuarios <span class="caret"></span>
											</a>
											<ul class="dropdown-menu">
												<li><a href="cliente.php"><i class="fa fa-users" aria-hidden="true"></i>Clientes</a></li>
												<li><a href="proveedores.php"><i class="fa fa-truck" aria-hidden="true"></i>Proveedores</a></li>
											</ul>
										</li>
									</ul>
									<!--  -->
								</li>
								<li class="m_nav_item" id="moble_nav_item_4">
									<ul id="m_nav_list" class="m_nav menu__list">
										<li class="dropdown">
											<a class="dropdown-toggle" data-toggle="dropdown" href="#">
												<i class="glyphicon glyphicon-th-list" aria-hidden="true"></i>Configuraciones<span class="caret"></span>
											</a>
											<ul class="dropdown-menu">
												<li><a href="config.php"><i class="fa fa-users" aria-hidden="true"></i>Tiempo de session</a></li>
												<li><a href="#"><i class="fa fa-truck" aria-hidden="true"></i>Usuarios</a></li>
											</ul>
										</li>
									</ul>
									<!--  -->
								</li>
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