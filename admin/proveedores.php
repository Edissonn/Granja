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
		<h2 class="title-w3-agileits inner">Registrar Proveedores</h2>
		<p class="quia">El paraiso Granja organica sostenible</p>
	</div>
	<br>
	<br>
	<div class="container">
		<div class="jumbotron">
			<form action="../controladores/insertar_proveedor.php" method="POST" enctype="multipart/form-data">
				<div class="table table-hover">
					<tr>
						<td>
							<div class="form-group">
								<label for="choose">Nombre del proveedor:</label>
								<input type="text" class="form-control" id="nombre" name="nombre" required="" placeholder="Nombre">
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
			<h3 align="center" class="panel-title">Proveedores Registrados </h3>
		</div>
		<div align="center" class="panel-body">
			<div class="table-responsive">
				<table align="center" id="tb_proveedores" class="display table-responsive" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>ID.</th>
							<th>Nombre del proveedor</th>
							<th>Editar</th>
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

<!-- ModaEditarProveedor -->
<div class="modal fade" id="myEditar" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<div class="signin-form profile">
					<h3 class="agileinfo_sign">Aumentar Stock</h3>
					<div class="login-form">
						<form action="../controladores/actualizarProveedor.php" method="POST">
							<div class="table table-hover">
								<tr>
									<td>
										<div class="form-group">
											<label for="choose">Nombre del proveedor:</label>
											<input type="text" class="form-control" id="nombreProveedor" name="nombreProveedor" required="" placeholder="Nombre">
											<input type="hidden" value="" name="pk_proveedor" id="pk_proveedor">
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
			</div>
		</div>
	</div>
</div>
<!-- //ModaEditarProveedor -->

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

		//Se carga la funcion listar para llenar la tabla con los datos de la base de datos
		listar();
	});

	var listar = function(){
		var table = $('#tb_proveedores').DataTable({

				//Numero de registros a mostrar en el DataTable
				"lengthMenu": [[5, 10], [5, 10]],

				//Permite volver a recargar el DataTable
				"destroy":true,

				//Cargar datos de la tabla proveedor
				"ajax":{
					"method":"POST",
					"url":"../controladores/cargarProveedores.php"
				},

				//Cargar datos por cada llaves
				"columns":[
				{"data":"pk_provedor"},
				{"data":"nombre_provedor"},
				{"defaultContent":"<a href='#myEditar' class='editar btn btn-success' data-toggle='modal'>Editar</a>"},
				{"defaultContent":"<img src='../img/delete.png' class='bajaProvedor btn btn-default'>"}
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
		editarProveedor("#tb_proveedores tbody", table);
		bajaProvvedor("#tb_proveedores tbody", table);
	}

	function bajaProvvedor(tbody, table){
		$(tbody).on("click", "img.bajaProvedor", function(){
			var data = table.row( $(this).parents("tr") ).data();
			swal({ 
				title: "¿Esta seguro de dar de baja al Proveedor: "+data.nombre_provedor+"?",
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
                        	url:'../controladores/eliminar_proveedor.php',
                        	type: 'POST',
                        	data:{pk_provedor:data.pk_provedor},
                        	cache: false,
                        	success: function(resultado){
                        		if (resultado=="true") {
                        			swal(data.nombre_provedor+" ha sido dato de baja con exito!","","info");
                        			listar();
                        		}else{
                        			swal("Error al dar de baja al Proveedor: "+data.nombre_provedor,"","error");
                        		}
                        	}
                        });
                    });
		});
	}

	function editarProveedor(tbody, table){
		$(tbody).on("click", "a.editar", function(){
			var data = table.row( $(this).parents("tr") ).data();
			$("#nombreProveedor").val(data.nombre_provedor);
			$("#pk_proveedor").val(data.pk_provedor);
		});
	}

	function validarGanacia() {
		var precio = parseFloat($("#precio").val());
		var ganancia = parseFloat($("#ganancia").val());
		if (ganancia>=precio) {
			alert("La ganancia no pude ser mayor o igual que el precio del producto!");
			$("#ganancia").val(precio-1);
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