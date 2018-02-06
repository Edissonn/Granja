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
		<h2 class="title-w3-agileits inner">Historial de ventas</h2>
		<p class="quia">El paraiso Granja organica sostenible</p>
	</div>
	<br>
	<br>
	<div class="container">
		<div class="jumbotron">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Filtros de Busqueda</h3>
				</div>
				<div class="panel-body">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No. Venta</th>
								<th>Cliente</th>
								<th>Fecha de venta</th>
								<th>Producto</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<input type="text" name="noVenta" id="noVenta" class="form-control" required="" autocomplete="off">
								</td>
								<td>
									<input type="text" name="cliente" id="cliente" class="form-control" required="" autocomplete="off">
								</td>
								<td>
									<input type="date" name="fechaVenta" id="fechaVenta" class="form-control" required="" autocomplete="off">
								</td>
								<td>
									<input type="text" placeholder="Yogurt Kefirt" class="form-control" required="" id="producto_id" name="producto_id">
								</td>
								<td>
									<button class="btn btn-success" id="btn_buscar">Buscar <i class="fa fa-search" aria-hidden="true"></i></button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
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
			<h3 align="center" class="panel-title">Resultados encontrados </h3>
		</div>
		<div align="center" class="panel-body">
			<div class="table-responsive">
				<table align="center" id="tb_ventas" class="display table-responsive" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>No. Venta.</th>
							<th>Nombre del cliente</th>
							<th>Atendido por</th>
							<th>Importe pagado</th>
							<th>Total de venta</th>
							<th>Fecha</th>
							<th>Hora</th>
							<th>Estado</th>
							<th></th>
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

<!-- Modal2 -->
<div class="modal fade" id="detalles_venta">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Detalles de Venta</h4>
			</div>
			<div class="modal-body">
				<div class="panel panel-success">
					<div class="panel-heading"></div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-condensed table-hover">
								<thead>
									<tr>
										<th style="color: black;">Producto</th>
										<th style="color: black;">Cod. Barra</th>
										<th style="color: black;">Precio</th>
										<th style="color: black;">Importe</th>
										<th style="color: black;">Cantidad comprada</th>
										<th style="color: black;">Subtotal</th>
										<th style="color: black;">Importe pagado</th>
									</tr>
								</thead>
								<tbody id="detallesdeVenta">

								</tbody>
							</table>
						</div>							
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
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

		var arrayKV;
		var table;

		$("#btn_buscar").click(function(){

			var $noVenta = $("#noVenta");
			var $cliente = $("#cliente");
			var $fechaVenta = $("#fechaVenta");
			var $producto_id = $("#producto_id");

			if ($noVenta.val().trim()!="" && $cliente.val().trim()!="" && $fechaVenta.val()!="" && $producto_id.val()!="") {
				arrayKV = {noVenta: $noVenta.val().trim(), cliente: $cliente.val().trim(), fechaVenta: $fechaVenta.val(), producto_id: $producto_id.val()};

			}else if ($noVenta.val().trim()!="" && $cliente.val().trim()!="" && $fechaVenta.val()!="") {
				arrayKV = {noVenta: $noVenta.val().trim(), cliente: $cliente.val().trim(), fechaVenta: $fechaVenta.val()};

			}else if ($noVenta.val().trim()!="" && $cliente.val().trim()!="") {
				arrayKV = {noVenta: $noVenta.val().trim(), cliente: $cliente.val().trim()};

			}else if ($noVenta.val()!="" && $producto_id.val()!="") {
				arrayKV = {noVenta: $noVenta.val().trim(), producto_id: $producto_id.val()};

			}else if ($noVenta.val()!="" && $fechaVenta.val()!="") {
				arrayKV = {noVenta: $noVenta.val().trim(), fechaVenta: $fechaVenta.val()};

			}else if ($noVenta.val().trim()!="") {
				arrayKV = {noVenta: $noVenta.val().trim()};

			}else if ($cliente.val().trim()!="" && $fechaVenta.val()!="" && $producto_id.val()!="") {
				arrayKV = {cliente: $cliente.val().trim(), fechaVenta: $fechaVenta.val(), producto_id: $producto_id.val()};

			}else if ($cliente.val()!="" && $producto_id.val()!="") {
				arrayKV = {cliente: $cliente.val().trim(), producto_id: $producto_id.val()};

			}else if ($fechaVenta.val()!="" && $producto_id.val()!="") {
				arrayKV = {fechaVenta: $fechaVenta.val(), producto_id: $producto_id.val()};

			}else if ($producto_id.val()!="") {
				arrayKV = {producto_id: $producto_id.val()};

			}else if ($cliente.val()!="" && $fechaVenta.val()!="") {
				arrayKV = {cliente: $cliente.val().trim(), fechaVenta: $fechaVenta.val()};

			}else if ($cliente.val()!="") {
				arrayKV = {cliente: $cliente.val().trim()};

			}else if ($fechaVenta.val()!="") {
				arrayKV = {fechaVenta: $fechaVenta.val()};
			}

			//Al menos un campo tiene que contener un valor para realizar la busqueda
			if ($noVenta.val().trim()!="" || $cliente.val().trim()!="" || $fechaVenta.val()!="" || $producto_id.val()!="") {

				$.ajax({
					url:'../controladores/buscadorVentas.php',
					type: 'POST',
					data:{array: JSON.stringify(arrayKV)},
					cache: false,
					success: function(resultado){
						if (resultado!="false") {
							listar(arrayKV);
						}else{
							swal({
								position: 'top-center',
								type: 'info',
								title: 'No se han encontrado resultados :(',
								showConfirmButton: false,
								timer: 2000
							});
							$("#tb_ventas tbody").empty();
						}
					}
				});

			}
		});

	});

	var listar = function(arrayKV){
		table = $('#tb_ventas').DataTable({

				//Numero de registros a mostrar en el DataTable
				"lengthMenu": [[5, 10], [5, 10]],

				//Permite volver a recargar el DataTable
				"destroy":true,

				//Cargar datos de la tabla proveedor
				"ajax":{
					"method":"POST",
					"data":{array: JSON.stringify(arrayKV)},
					"url":"../controladores/buscadorVentas.php"
				},

				//Cargar datos por cada llaves
				"columns":[
				{"data":"pk_venta"},
				{"render":function(data,type,full,meta){
					if (full.nombre_cliente == null) {
						return '<span class="label label-default">Venta General</span>'
					}else{
						return full.nombre_cliente
					}
				}},
				{"data":"nombre_usuario"},
				{"data":"cant_importe"},
				{"data":"total"},
				{"data":"fecha"},
				{"data":"hora"},
				{"render":function(data,type,full,meta){
					if (full.estado == 1) {
						return '<span class="label label-success">Exitosa</span>'
					}else{
						return '<span class="label label-danger">Cancelada</span>'
					}
				}},
				{"defaultContent":"<a href='#detalles_venta' class='detalles btn btn-success' data-toggle='modal'><i class='fa fa-table' aria-hidden='true'>  Detalles</i></a>"},
				{"defaultContent":"<a href='#' class='ticket btn btn-warning' data-toggle='modal'><i class='fa fa-file-text' aria-hidden='true'></i>  Ticket</i></a>"}
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

		detallesVentas("#tb_ventas tbody", table);
		ticket("#tb_ventas tbody", table);
	}

	function detallesVentas(tbody, table){
		//Se remueve el evento agregado a los elementos a.detalles del tbody de a tabla
		$(tbody).off();

		//Se vuelven a activar los eventos de a.detalles, pero ya con los nuevos elementos resultantes de la busqueda
		$(tbody).on("click", "a.detalles", function(){
			var data = table.row( $(this).parents("tr") ).data();
			$.ajax({
				url:'../controladores/buscadorVentas.php',
				type: 'POST',
				dataType: "json",
				data:{venta_id:data.pk_venta},
				cache: false,
				success: function(resultado){
					$("#detallesdeVenta").empty();
					$.each(resultado, function (index, value) {
						$("#detallesdeVenta").append('<tr><td>'+value.nombre+'</td><td>'+value.codigo_barras+'</td><td>'+value.precio+'</td><td>'+value.importe+'</td><td>'+value.cant_producto+'</td><td>'+value.subtotal+'</td><td>'+value.cant_importe+'</td></tr>');
					});
					
				}
			});
		});
	}

	function ticket(tbody, table){
		$(tbody).on("click", "a.ticket", function(){
			var data = table.row( $(this).parents("tr") ).data();

			var url = 'ticket.php?pk_venta='+data.pk_venta;
			window.open(url, '_blank');

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