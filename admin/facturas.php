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
		<h2 class="title-w3-agileits inner">Administrar de Facturas</h2>
		<p class="quia">El paraiso Granja organica sostenible</p>
	</div>
	<br>
	<br>
	<div class="container">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 align="center" class="panel-title">Resultados encontrados </h3>
			</div>
			<div align="center" class="panel-body">
				<div class="table-responsive">
					<table align="center" id="tb_facturas" class="display table-responsive" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>No. Factura.</th>
								<th>Nombre del cliente</th>
								<th>Atendido por</th>
								<th>Importe pagado</th>
								<th>Total de venta</th>
								<th>Fecha</th>
								<th>Hora</th>
								<th>Estado</th>
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
	<!-- hasta termina el formulario -->
	<!-- banner-bottom -->
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

	<script type="text/javascript">
		$(document).ready(function(){
			$.ajax({
				url: "../controladores/buscadorFacturas.php",
				type: "post",
				cache: false,
				success: function(data){
					if (data!="No hay facturas registradas!" && data != "false") {
						listar();
					}else{
						alert(data);
					}
				}
			});
			
		});
		var listar = function(){
			table = $('#tb_facturas').DataTable({

				//Numero de registros a mostrar en el DataTable
				"lengthMenu": [[5, 10], [5, 10]],

				//Permite volver a recargar el DataTable
				"destroy":true,

				//Cargar datos de la tabla proveedor
				"ajax":{
					"method":"POST",
					"url":"../controladores/buscadorFacturas.php"
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
						return '<span class="label label-warning">En factura</span>'
					}
				}},
				{"defaultContent":"<a class='factura btn btn-primary'><i class='fa fa-file-text' aria-hidden='true'></i>  Ver Factura</i></a>"}
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

			factura("#tb_facturas tbody", table);
		}


		function factura(tbody, table){
			$(tbody).on("click", "a.factura", function(){
				var data = table.row( $(this).parents("tr") ).data();

				var url = 'factura.php?pk_venta='+data.pk_venta;
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