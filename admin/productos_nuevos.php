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
		<h2 class="title-w3-agileits inner">Registrar Productos</h2>
		<p class="quia">El paraiso Granja organica sostenible</p>
	</div>
	<br>
	<br>
	<div class="container">
		<div class="jumbotron">
			<form action="../controladores/insertar_producto.php" method="POST" enctype="multipart/form-data">
				<div class="table table-hover">
					<tr>
						<td>
							<div class="form-group">
								<label for="choose">Imagen:</label>
								<input type="file" class="form-control" class="form-control" id="file_img" name="file_img" required="" placeholder="Seleccione una imagen para el producto">
							</div>
						</td>
					</tr>
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
								<label for="choose">Codigo:</label>
								<input type="text" class="form-control" class="form-control" id="codigo" name="codigo" maxlength="13" minlength="5" required="" placeholder="190865431728364759">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">
								<label for="choose">Precio:</label>
								<input type="number" class="form-control" min="1" id="precio" name="precio" required="">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">
								<label for="choose">Importe:</label>
								<input type="number" class="form-control" min="0" id="importe" name="importe" required="">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">
								<label for="choose">Unidad de medida:</label>
								<select name="unidad_medida" id="unidad_medida" required="" class="form-control">
									<option value="">Seleccione una Unidad de Medida</option>
									<?php
									$sql_unidades = "SELECT * FROM unidad_medida";
									$obtener_medidas = $conexion->prepare($sql_unidades);
									$obtener_medidas->execute();
									if ($obtener_medidas->rowCount()>0) {
										$res_unidades = $obtener_medidas->fetchAll();
										foreach ($res_unidades as $value) {
											?>
											<option value="<?php echo $value['pk_unidad']; ?>"><?php echo $value['unidad']; ?></option>
											<?php
										}
									}else{
										?>
										<option value="">No hay medidas registradas</option>
										<?php
									}
									$obtener_medidas->closeCursor();
									?>
								</select>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">
								<label for="choose">Cantidad de contenido del producto:</label>
								<input type="number" class="form-control" id="cantidadProducto" name="cantidadProducto" min="1"  required="">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">
								<label for="choose">Categoria:</label>
								<select name="categoria" id="categoria" required="" class="form-control">
									<option value="">Seleccione una Categoria</option>
									<?php
									$sql_categoria = "SELECT * FROM categoria";
									$obtener_categoria = $conexion->prepare($sql_categoria);
									$obtener_categoria->execute();
									if ($obtener_categoria->rowCount()>0) {
										$res_categoria = $obtener_categoria->fetchAll();
										foreach ($res_categoria as $value) {
											?>
											<option value="<?php echo $value['pk_categoria']; ?>"><?php echo $value['nom_categoria']; ?></option>
											<?php
										}
									}else{
										?>
										<option value="">No hay medidas registradas</option>
										<?php
									}
									$obtener_categoria->closeCursor();
									?>
								</select>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">
								<label for="choose">Precio del proveedor:</label>
								<input type="number" onkeyup="validarGanacia()" class="form-control" min="1" id="precioProveedor" name="precioProveedor" placeholder="">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">
								<label for="choose">Proveedor (Campo opcional):</label>
								<select name="proveedor" id="proveedor" class="form-control">
									<option value="">Seleccione un proveedor</option>
									<?php
									$sql_proveedor = "SELECT * FROM provedor";
									$obtener_proveedor = $conexion->prepare($sql_proveedor);
									$obtener_proveedor->execute();
									if ($obtener_proveedor->rowCount()>0) {
										$res_proveedor = $obtener_proveedor->fetchAll();
										foreach ($res_proveedor as $value) {
											?>
											<option value="<?php echo $value['pk_provedor']; ?>"><?php echo $value['nombre_provedor']; ?></option>
											<?php
										}
									}else{
										?>
										<option value="">No hay proveedores registrados</option>
										<?php
									}
									$obtener_proveedor->closeCursor();
									?>
								</select>
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
<br>
<div class="container">
	<h2 class="title-w3-agileits inner">Productos Registrados</h2>
	<p class="quia">El paraiso Granja organica sostenible</p>
</div>
<br>
<br>
<div class="container">
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 align="center" class="panel-title">Productos Registrados</h3>
		</div>
		<div align="center" class="panel-body">
			<div class="table-responsive">
				<table align="center" id="tb_productos" class="display table-responsive" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>ID.</th>
							<th>Imagen</th>
							<th>Nombre</th>
							<th>Codigo de Barras</th>
							<th>Categoria</th>
							<th>Precio Publico</th>
							<th>Importe</th>
							<th>Precio de Proveedor</th>
							<th>Stock</th>
							<th>Unidad de Medida</th>
							<th>Contenido de Producto</th>
							<th>Editar</th>
							<th>Aumentar Stok</th>
							<th>Eliminar</th>
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

<!-- ModaStock -->
<div class="modal fade" id="myModalStock" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<div class="signin-form profile">
					<h3 class="agileinfo_sign">Aumentar Stock</h3>
					<div class="login-form">
						<form action="../controladores/insertarStock.php" method="POST">
							<div class="form-group">
								<label>No. de producto</label>
								<input type="text" id="pk_producto" class="form-control" name="pk_producto" required="" readonly="false">
							</div>
							<div class="form-group">
								<label>Proveedor del producto</label>
								<select id="pk_proveedor" class="form-control" name="pk_proveedor" required="">
									<option value="">Seleccione un proveedor</option>
									<?php
									$sql_proveedor = "SELECT * FROM provedor";
									$obtener_proveedor = $conexion->prepare($sql_proveedor);
									$obtener_proveedor->execute();
									if ($obtener_proveedor->rowCount()>0) {
										$res_proveedor = $obtener_proveedor->fetchAll();
										foreach ($res_proveedor as $value) {
											?>
											<option value="<?php echo $value['pk_provedor']; ?>"><?php echo $value['nombre_provedor']; ?></option>
											<?php
										}
									}else{
										?>
										<option value="">No hay proveedores registrados</option>
										<?php
									}
									$obtener_proveedor->closeCursor();
									?>
								</select>
							</div>
							<div class="form-group">
								<label>Cantidad de productos a agregar</label>
								<input type="number" min="1" class="form-control" id="cantidadProveedor" name="cantidadProveedor" required="">
							</div>
							<div class="form-group">
								<input type="submit" value="Agregar Stock" class="btn btn-success">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- //ModaStock -->

<!-- ModaEditarProducto -->
<div class="modal fade" id="myModalEditar" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<div class="signin-form profile">
					<h3 class="agileinfo_sign">Editar datos de Producto</h3>
					<div class="login-form">
						<div class="jumbotron">
							<form action="../controladores/actualizar_producto.php" method="POST">
								<div class="table table-hover">
									<tr>
										<td>
											<div class="form-group">
												<label for="choose">Nombre del producto:</label>
												<input type="text" class="form-control" id="nombreProducto" name="nombreProducto" required="" placeholder="Kombucha">
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group">
												<label for="choose">Codigo:</label>
												<input type="text" class="form-control" class="form-control" id="codigoProducto" name="codigoProducto" maxlength="13" minlength="5" required="" placeholder="190865431728364759">
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group">
												<label for="choose">Precio:</label>
												<input type="number" class="form-control" min="1" id="precioProducto" name="precioProducto" required="">
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group">
												<label for="choose">Importe:</label>
												<input type="number" class="form-control" min="0" id="importeProducto" name="importeProducto" required="">
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group">
												<label for="choose">Unidad de medida:</label>
												<select name="unidadMProducto" id="unidadMProducto" required="" class="form-control">
													<option value="">Seleccione una Unidad de Medida</option>
													<?php
													$sql_unidades = "SELECT * FROM unidad_medida";
													$obtener_medidas = $conexion->prepare($sql_unidades);
													$obtener_medidas->execute();
													if ($obtener_medidas->rowCount()>0) {
														$res_unidades = $obtener_medidas->fetchAll();
														foreach ($res_unidades as $value) {
															?>
															<option value="<?php echo $value['pk_unidad']; ?>"><?php echo $value['unidad']; ?></option>
															<?php
														}
													}else{
														?>
														<option value="">No hay medidas registradas</option>
														<?php
													}
													$obtener_medidas->closeCursor();
													?>
												</select>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group">
												<label for="choose">Cantidad de contenido del producto:</label>
												<input type="number" class="form-control" id="cantProducto" name="cantProducto" min="1"  required="">
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group">
												<label for="choose">Categoria:</label>
												<select name="categoriaProducto" id="categoriaProducto" required="" class="form-control">
													<option value="">Seleccione una Categoria</option>
													<?php
													$sql_categoria = "SELECT * FROM categoria";
													$obtener_categoria = $conexion->prepare($sql_categoria);
													$obtener_categoria->execute();
													if ($obtener_categoria->rowCount()>0) {
														$res_categoria = $obtener_categoria->fetchAll();
														foreach ($res_categoria as $value) {
															?>
															<option value="<?php echo $value['pk_categoria']; ?>"><?php echo $value['nom_categoria']; ?></option>
															<?php
														}
													}else{
														?>
														<option value="">No hay medidas registradas</option>
														<?php
													}
													$obtener_categoria->closeCursor();
													?>
												</select>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group">
												<label for="choose">Precio del proveedor:</label>
												<input type="number" class="form-control" min="1" id="precioProveedorP" name="precioProveedorP" placeholder="">
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group">
												<label for="choose">Proveedor (Campo opcional):</label>
												<select name="proveedorProducto" id="proveedorProducto" class="form-control" required="">
													<option value="">Seleccione un proveedor</option>
													<?php
													$sql_proveedor = "SELECT * FROM provedor";
													$obtener_proveedor = $conexion->prepare($sql_proveedor);
													$obtener_proveedor->execute();
													if ($obtener_proveedor->rowCount()>0) {
														$res_proveedor = $obtener_proveedor->fetchAll();
														foreach ($res_proveedor as $value) {
															?>
															<option value="<?php echo $value['pk_provedor']; ?>"><?php echo $value['nombre_provedor']; ?></option>
															<?php
														}
													}else{
														?>
														<option value="">No hay proveedores registrados</option>
														<?php
													}
													$obtener_proveedor->closeCursor();
													?>
												</select>
											</div>
										</td>
										<input type="hidden" value="" id="pk_productoP" name="pk_productoP" required="">
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
				</div>
			</div>
		</div>
	</div>
	<!-- //ModaEditarProducto -->

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
		// $( ".target" ).change(function() {
		// 	alert( "Se ha detectado un cambio" );
		// });

		//Se carga la funcion listar para llenar la tabla con los datos de la base de datos
		listar();
	});

		var listar = function(){
			var table = $('#tb_productos').DataTable({

				//Numero de registros a mostrar en el DataTable
				"lengthMenu": [[10, 20], [10, 20]],

				//Permite volver a recargar el DataTable
				"destroy":true,

				//Cargar datos de la tabla piezas
				"ajax":{
					"method":"POST",
					"url":"../controladores/cargar_tablaProductos.php"
				},

				//Cargar datos por cada llaves
				"columns":[
				{"data":"pk_producto"},
				//Sepa la chingada, pero ya jalo, y carga la imagen
				{"render":function(data,type,full,meta){
					if (full.ruta_img == null) {
						return '<p>Sin Imagen</p>'
					}else{
						return '<a class="view_imagen example-image-link" href="../img_productos/'+full.ruta_img+'" data-lightbox="example-2" data-title="'+full.nombre+'"><img class="example-image" src="../img/view imagen.png" alt="image-1"/></a>'
					}
				}},
				{"data":"nombre"},
				{"data":"codigo_barras"},
				{"data":"nom_categoria"},
				{"data":"precio"},
				{"data":"importe"},
				{"data":"precioProveedor"},
				{"data":"stok"},
				{"data":"unidad"},
				{"data":"cant_producto"},
				{"defaultContent":"<a href='#myModalEditar' class='editar btn btn-success' data-toggle='modal'>Editar</a>"},
				{"defaultContent":"<a href='#myModalStock' class='stock btn btn-success' data-toggle='modal'>Aumentar Stock</a>"},
				{"defaultContent":"<img src='../img/delete.png' href='#' class='eliminar_piezas btn btn-default'>"}
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
			//Funcion para obtener los valores de cada fila de la tabla seleccionada
			aumentarStock("#tb_productos tbody", table);
			bajaProducto("#tb_productos tbody", table);
			editarProducto("#tb_productos tbody", table);
		}

		function editarProducto(tbody, table){
			$(tbody).on("click", "a.editar", function(){
				var data = table.row( $(this).parents("tr") ).data();
				$("#pk_productoP").val(data.pk_producto);
				$("#nombreProducto").val(data.nombre);
				$("#codigoProducto").val(data.codigo_barras);
				$("#precioProducto").val(data.precio);
				$("#importeProducto").val(data.importe);
				$("#precioProveedorP").val(data.precioProveedor);
				//Cargar la unidad de medeida como selecciona por defecto
				var unidad = data.unidad;
				$("#unidadMProducto option").filter(function(){
					return $(this).text() == unidad;
				}).prop('selected', true);
				$("#cantProducto").val(data.cant_producto);
				//Cargar la categoria como selecciona por defecto
				var categoria = data.nom_categoria;
				$("#categoriaProducto option").filter(function(){
					return $(this).text() == categoria;
				}).prop('selected', true);
				//Cargar el proveedor como selecciona por defecto
				// var categoria = data.nom_categoria;
				// $("#categoriaProducto option").filter(function(){
				// 	return $(this).text() == categoria;
				// }).prop('selected', true);

			});
		}

		function aumentarStock(tbody, table){
			$(tbody).on("click", "a.stock", function(){
				var data = table.row( $(this).parents("tr") ).data();
				$("#pk_producto").val(data.pk_producto);
			});
		}

		function bajaProducto(tbody, table){
			$(tbody).on("click", "img.eliminar_piezas", function(){
				var data = table.row( $(this).parents("tr") ).data();
				swal({ 
					title: "¿Esta seguro de dar de baja el producto: "+data.nombre+"?",
					text: "No podrás deshacer este paso...",
					type: "warning",
					showCancelButton: true,
					cancelButtonText: "Cancelar",
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Baja",
					closeOnConfirm: true },

					function(){ 
                        //Dar de baja el producto seleccionado
                        $.ajax({
                        	url:'../controladores/eliminar_producto.php',
                        	type: 'POST',
                        	data:{pk_producto:data.pk_producto},
                        	cache: false,
                        	success: function(resultado){
                        		if (resultado=="true") {
                        			swal(data.nombre+" ha sido dato de baja con exito!","","info");
                        			listar();
                        		}else{
                        			swal("Error al dar de baja el producto: "+data.nombre,"","error");
                        		}
                        	}
                        });
                    });
			});
		}

		function validarGanacia() {
			var precio = parseFloat($("#precio").val());
			var ganancia = parseFloat($("#precioProveedor").val());
			if (ganancia>=precio) {
				alert("El precio al proveedor no pude ser mayor o igual que el precio del producto!");
				$("#precioProveedor").val(precio-1);
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