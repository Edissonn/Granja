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
		<h2 class="title-w3-agileits inner">Registrar Cliente</h2>
		<p class="quia">El paraiso Granja organica sostenible</p>
	</div>
	<br>
	<br>
	<div class="container">
		<div class="jumbotron">
			<form action="../controladores/insertar_cliente.php" method="POST" enctype="multipart/form-data">
				<div class="table table-hover">
					<tr>
						<td>
							<div class="form-group">
								<label for="choose">Nombre del cliente:</label>
								<input type="text" class="form-control" id="nombre" name="nombre" required="" placeholder="Nombre">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">
								<label for="choose">Edad:</label>
								<input type="number" class="form-control" id="edad" name="edad" required="" placeholder="43">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">
								<label for="choose">Telefono:</label>
								<input type="text" class="form-control" maxlength="10" id="telefono" name="telefono" required="" placeholder="3221019219">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">
								<label for="choose">Telefono de casa:</label>
								<input type="text" class="form-control"  id="tel" name="tel" required="" placeholder="">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">
								<label for="choose">Nombre del local:</label>
								<input type="text" class="form-control" id="nombre_local" name="nombre_local" required="" placeholder="Bar leyza">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">
								<label for="choose">Localidad:</label>
								<select name="localidad" id="localidad" required="" class="form-control">
									<option value="">Seleccione una localidad</option>
									<?php 
									$sql_unidades = "SELECT * FROM localidad";
									$obtener_localidad = $conexion->prepare($sql_unidades);
									$obtener_localidad->execute();
									if ($obtener_localidad->rowCount()>0) {
										$res_localidad = $obtener_localidad->fetchAll();
										foreach ($res_localidad as $value) {
											?>
											<option value="<?php echo $value['pk_localidad']; ?>"><?php echo $value['nombre']; ?></option>
											<?php
										}
									}else{
										?>
										<option value="">No hay localidades registradas</option>
										<?php
									}
									$obtener_localidad->closeCursor();
									?>
								</select>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">
								<label for="choose">Calle(Avenida):</label>
								<input type="text" class="form-control" id="calle_ave" name="calle_ave" required="" placeholder="Av. Revolucion">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">
								<label for="choose">Desccripcion:</label>
								<input type="text" class="form-control" id="descripcion" name="descripcion" required="" placeholder="Entre Mercurio y Tamarindo">
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
	<!-- hasta termina el formulario -->
	<!-- banner-bottom -->
	<div class="clearfix"> </div>
</div>
</div>
</div>
<br>
<div class="container">
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 align="center" class="panel-title">Clientes Registrados </h3>
		</div>
		<div align="center" class="panel-body">
			<div class="table-responsive">
				<table align="center" id="tb_clientes" class="display table-responsive" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>ID.</th>
							<th>Nombre del cliente</th>
							<th>Edad</th>
							<th>Telefono celular</th>
							<th>Telefono(casa)</th>
							<th>Nombre del local</th>
							<th>localidad</th>
							<th>Calle(Avenida)</th>
							<th>Descripcion</th>
							<th>Editar</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</div>
<br>
<br>
<br>

<!-- Modal2 -->
<div class="modal fade" id="myModaEditar" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<div class="signin-form profile">
					<h3 class="agileinfo_sign">Actualizar Datos del cliente</h3>
					<div class="login-form">
						<form action="../controladores/actualizarUsuario.php" method="POST" enctype="multipart/form-data">
							<div class="table table-hover">
								<tr>
									<td>
										<div class="form-group">
											<label for="choose">Nombre del cliente:</label>
											<input type="text" class="form-control" id="nombreCliente" name="nombreCliente" required="" placeholder="Nombre">
											<input type="hidden" value="" name="pkCliente" id="pkCliente" required="">
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<div class="form-group">
											<label for="choose">Edad:</label>
											<input type="number" class="form-control" id="edadCliente" name="edadCliente" required="">
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<div class="form-group">
											<label for="choose">Telefono:</label>
											<input type="text" class="form-control" maxlength="10" id="telefonoCliente" name="telefonoCliente" required="" placeholder="3221019219">
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<div class="form-group">
											<label for="choose">Telefono de casa:</label>
											<input type="text" class="form-control"  id="telCliente" name="telCliente" required="" placeholder="">
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<div class="form-group">
											<label for="choose">Nombre del local:</label>
											<input type="text" class="form-control" id="nombre_localCliente" name="nombre_localCliente" required="" placeholder="Bar leyza">
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<div class="form-group">
											<label for="choose">Localidad:</label>
											<select name="localidadCliente" id="localidadCliente" required="" class="form-control">
												<option value="">Seleccione una localidad</option>
												<?php 
												$sql_unidades = "SELECT * FROM localidad";
												$obtener_localidad = $conexion->prepare($sql_unidades);
												$obtener_localidad->execute();
												if ($obtener_localidad->rowCount()>0) {
													$res_localidad = $obtener_localidad->fetchAll();
													foreach ($res_localidad as $value) {
														?>
														<option value="<?php echo $value['pk_localidad']; ?>"><?php echo $value['nombre']; ?></option>
														<?php
													}
												}else{
													?>
													<option value="">No hay localidades registradas</option>
													<?php
												}
												$obtener_localidad->closeCursor();
												?>
											</select>
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<div class="form-group">
											<label for="choose">Calle(Avenida):</label>
											<input type="text" class="form-control" id="calle_aveCliente" name="calle_aveCliente" required="" placeholder="Av. Revolucion">
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<div class="form-group">
											<label for="choose">Desccripcion:</label>
											<input type="text" class="form-control" id="descripcionCliente" name="descripcionCliente" required="" placeholder="Entre Mercurio y Tamarindo">
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<input type="submit" class="btn btn-success form-control" required="" value="Guardar cambios">
									</td>
								</tr>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- //Modal2 -->

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
		$( ".target" ).change(function() {
			alert( "Se ha detectado un cambio" );
		});

		//Se carga la funcion listar para llenar la tabla con los datos de la base de datos
		listar();
	});

	var listar = function(){
		var table = $('#tb_clientes').DataTable({

				//Numero de registros a mostrar en el DataTable
				"lengthMenu": [[5, 10], [5, 10]],

				//Permite volver a recargar el DataTable
				"destroy":true,

				//Cargar datos de la tabla proveedor
				"ajax":{
					"method":"POST",
					"url":"../controladores/cargarClientes.php"
				},

				//Cargar datos por cada llaves
				"columns":[
				{"data":"pk_cliente"},
				{"data":"nombre_cliente"},
				{"data":"edad"},
				{"data":"telefono_cel"},
				{"data":"telefono_casa"},
				{"data":"nombre_local"},
				{"data":"nombre"},
				{"data":"calle_ave"},
				{"data":"descripccion"},
				{"defaultContent":"<a href='#myModaEditar' class='editar btn btn-success' data-toggle='modal'>Editar</a>"},
				{"defaultContent":"<img src='../img/delete.png' href='#' class='bajaCliente btn btn-default'>"}
				],

				//Lenguaje en español
				"language": {
					"lengthMenu": "Mostrar _MENU_ registros por pagina",
					"zeroRecords": "No se encontraron resultados en su busqueda",
					"searchPlaceholder": "Buscar registros",
					"info": "Mostrando registros de _START_ al _END_ de un total de  _TOTAL_ registros",
					"infoEmpty": "No existen registros",
					"infoFiltered": "(filtrado de un total de _MAX_ registros)",
					"search": "Buscador:",
					"paginate": {
						"first":    "Primero",
						"last":    "Último",
						"next":    "Siguiente",
						"previous": "Anterior"
					}
				},

				//Se agrega el scrol vertical
				"scrollX": true
			});
		bajaCliente("#tb_clientes tbody", table);
		EditarCliente("#tb_clientes tbody", table);
	}

	function EditarCliente(tbody, table){
		$(tbody).on("click", "a.editar", function(){
			var data = table.row( $(this).parents("tr") ).data();
			$("#pkCliente").val(data.pk_cliente);
			$("#nombreCliente").val(data.nombre_cliente);
			$("#edadCliente").val(data.edad);
			$("#telefonoCliente").val(data.telefono_cel);
			$("#telCliente").val(data.telefono_casa);
			$("#nombre_localCliente").val(data.nombre_local);
			//Cargar la localidad como selecciona por defecto
			var unidad = data.nombre;
			$("#localidadCliente option").filter(function(){
				return $(this).text() == unidad;
			}).prop('selected', true);
			$("#calle_aveCliente").val(data.calle_ave);
			$("#descripcionCliente").val(data.descripccion);
		});
	}

	function bajaCliente(tbody, table){
		$(tbody).on("click", "img.bajaCliente", function(){
			var data = table.row( $(this).parents("tr") ).data();
			swal({ 
				title: "¿Esta seguro de dar de baja al cliente: "+data.nombre_cliente+"?",
				text: "No podrás deshacer este paso...",
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Baja",
				closeOnConfirm: true },

				function(){ 
                        //Dar de baja al cliente seleccionado
                        $.ajax({
                        	url:'../controladores/eliminar_cliente.php',
                        	type: 'POST',
                        	data:{pk_cliente:data.pk_cliente},
                        	cache: false,
                        	success: function(resultado){
                        		if (resultado=="true") {
                        			swal(data.nombre_cliente+" ha sido dato de baja con exito!","","info");
                        			listar();
                        		}else{
                        			swal("Error al dar de baja al cliente: "+data.nombre_cliente,"","error");
                        		}
                        	}
                        });
                    });
		});
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