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
	<style>
		.selected{
			cursor: pointer;
		}
		.selected:hover{
			background-color: #4BB036;
			color: white;
		}
	</style>
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
		<h2 class="title-w3-agileits inner">Ventas</h2>
		<p class="quia">El paraiso Granja organica sostenible</p>
	</div>
	<br>
	<div class="container">
		<label>Codigo de Barra</label>
		<input type="text" class="form-control" name="textCodigoBarras" maxlength="13" id="textCodigoBarras" class="target">
		<br>
		<label>Cliente</label>
		<select class="form-control" name="pk_cliente" id="pk_cliente">
			<option value="">Selecciona un cliente</option>
			<?php
			$sql_clientes = "SELECT * FROM cliente";
			$obtener_cliente = $conexion->prepare($sql_clientes);
			$obtener_cliente->execute();
			if ($obtener_cliente->rowCount()>0) {
				$res_unidades = $obtener_cliente->fetchAll();
				foreach ($res_unidades as $value) {
					?>
					<option value="<?php echo $value['pk_cliente']; ?>"><?php echo $value['nombre_cliente']; ?></option>
					<?php
				}
			}else{
				?>
				<option value="">No hay medidas registradas</option>
				<?php
			}
			$obtener_cliente->closeCursor();
			?>
		</select>
		<br>
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title"><label>Detalles de venta</label></h3>
			</div>
			<div class="panel-body">
				<label>Lista de productos</label>
				<div class="table-responsive">
					<table id="tablaDetalles" class="table table-bordered">
						<thead>
							<th style="color: black;">Nº producto</th>
							<th style="color: black;">Nombre</th>
							<th style="color: black;">Precio unitario</th>
							<th style="color: black;">Cant comprada</th>
							<th style="color: black;">Importe</th>
							<th style="color: black;">Proveedor</th>
							<th style="color: black;">Subtotal</th>
							<th style="color: black;">Modificar</th>
							<th style="color: black;">Eliminar</th>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
			<div class="panel-footer">
				<div class="col-md-offset-8">
					<ul class="nav nav-pills nav-stacked">
						<strong>
							<li class="active">
								<a style="color: black;">
									<span class="badge pull-right" id="total_final">0</span>
									Total de Compra:
								</a>
							</li>
						</strong>
					</ul>
				</div>
			</div>
			<br>
			<label>Cantidad de pago</label>
			<input type="number" name="cantidadPago" id="cantidadPago" min="1" class="form-control">
			<br>
			<div align="center">
				<button class="btn btn-success btn-lg" id="btnVenta" onclick="obtenerTodos(arrayIds,0);"><i class="fa fa-shopping-cart"> Realizar Venta</i></button>
				<button class="btn btn-success btn-lg" id="btnFactura" onclick="obtenerTodos(arrayIds,1);"><i class="fa fa-shopping-cart"> Facturar</i></button>
			</div>
			
			
		</div>
	</div>
	<br>
	<br>
	<br>
	<!-- //banner -->

	<!-- Moda+CantidadProducto -->
	<div class="modal fade" id="myModalCantidad" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="signin-form profile">
						<h3 class="agileinfo_sign">Cantidad de Productos</h3>
						<div class="login-form">
							<div class="form-group">
								<label>Introdusca la cantidad de compra para este producto</label>
								<input type="number" class="form-control" min="1" onkeyup="validarCampoCantidad(this.value,this.id);" value="1" id="cantProducto">
							</div>
							<div class="form-group">
								<button class="btn btn-success" id="btnOk">OK</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- //Moda+CantidadProducto -->

	<!-- Moda+CantidadProducto -->
	<div class="modal fade" id="ModalCantidadRestar" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="signin-form profile">
						<h3 class="agileinfo_sign">Decrementar cantidad de producto</h3>
						<div class="login-form">
							<div class="form-group">
								<label>Disminuya la cantidad de producto</label>
								<input type="number" class="form-control" onkeyup="validarCampoCantidad(this.value,this.id);" min="1" value="" id="cantProductoRes">
							</div>
							<div class="form-group">
								<button class="btn btn-success" id="btnOkRes">OK</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- //Moda+CantidadProducto -->


	<!-- //footer -->
	<!-- js -->
	<script type="text/javascript" src="../js/jquery-2.1.4.min.js"></script>
	<!-- //js -->
	<script src="../js/jquery.vide.min.js"></script>
	<script src="../js/responsiveslides.min.js"></script>
	<script type="text/javascript">
		function validarCampoCantidad(valor,id) {
			var parseValor = parseFloat(valor);
			if (valor<=0) {
				$("#"+id).val(1);
			}
		}
	//Arreglo para almacenar los subtotales
	var arraySubTotales = [];
	//Arreglo para almecenar los ids de cada TR de la tabla
	var arrayIds = [];
	//Arreglo para almecenar los importes de cada TR de la tabla
	var arrayImportes = [];
	//Arreglo para almecenar los ids de cada checkbox que se agrega a la tabla
	var arrayChacks = [];
	//Variable para lod IDs de cada fila que se agrege de cada producto
	var cont=0;

	$(document).ready(function(){
		//Ocultar el bonton de realizacion de la venta, hasta que se agregen productos
		$("#btnVenta").hide();
		$("#btnFactura").hide();
		//Variable para almecenar el codigo de barra escaneado
		var codigoBarras = "";
		$("#textCodigoBarras").change(function() {
			codigoBarras = $("#textCodigoBarras").val();
			//Mostrar la ventana para la cantidad del producto
			$("#myModalCantidad").modal('show');
		});

		$("#btnOk").click(function(){
			var cantidadComprada = parseFloat($("#cantProducto").val());
			//Sacar los producto escaneado y agregarlo a la tabla de detalle de venta
			$.ajax({
				url:'../controladores/obtenerProductoEscaner.php',
				type: 'POST',
				data:{codigoBarras:codigoBarras,cantProducto:cantidadComprada},
				cache: false,
				success: function(resultado){
					if (resultado!="false" && resultado!="!stok") {
						try{
							var json = JSON.parse(resultado);
						//Ciclo para recorrer todos los elementos del JSON
						$(json).each(function(index, value){
							cont++;
							var precio = parseFloat(value.precio);
							//Se calcula el subtotal para X producto
							var subtotal = (cantidadComprada*precio);
							if (parseFloat(value.importe)>0) {
								//Se agrega cada producto escaneado
								$("#tablaDetalles").append('<tr class="selected fila'+cont+'"><td style="color: black;">'+value.pk_producto+'</td><td style="color: black;">'+value.nombre+'</td><td style="color: black;">'+precio+'</td><td style="color: black;">'+cantidadComprada+'</td><td style="color: black;"><input type="checkbox" id="check'+cont+'">'+value.importe+'</td><td style="color: black;">'+value.nombre_provedor+'</td><td style="color: black;">'+subtotal+'</td><td><button class="btn btn-warning" id="fila'+cont+'" onclick="midificarCantC(this.id);">Midificar cant. compra</button></td><td><button class="btn btn-danger" id="fila'+cont+'" onclick="eliminarCantC(this.id);">Eliminar</button></td></tr>');
								//Agregar la accion al checbox que se va agregando
								$("#check"+cont).change(function(){
									if($(this).is(":checked")) {
										var id = $(this).attr("id");

										//Obtener el numero de cantidad comprada de la fila
										var idFilaSelect = "fila"+id.split("check")[1];
										var canP = parseFloat($('.'+idFilaSelect+'').find('td').eq(3).text());

										var cantImporte=(parseFloat(value.importe)*canP);
										arrayImportes.push(cantImporte);
										$("#total_final").text("$"+calcularTotalYImportes(arraySubTotales));

										//Calcular nuevo subtotal con importe
										var subActual = parseFloat($('.'+idFilaSelect+'').find('td').eq(6).text());
										$('.'+idFilaSelect+'').find('td').eq(6).text((subActual+cantImporte));

									}else{
										var id = $(this).attr("id");

										//Obtener el numero de cantidad comprada de la fila
										var idFilaSelect = "fila"+id.split("check")[1];
										var canP = parseFloat($('.'+idFilaSelect+'').find('td').eq(3).text());

										var cantImporte=(parseFloat(value.importe)*canP);
										for (var i = 0; i < arrayImportes.length; i++) {
											if (arrayImportes[i]==cantImporte) {
												arrayImportes.splice(i, 1);
												break;
											}
										}
										if (arrayImportes.length>0) {
											$("#total_final").text("$"+calcularTotalYImportes(arraySubTotales));
										}else{
											$("#total_final").text("$"+calcularTotal(arraySubTotales));
										}

										//Calcular nuevo subtotal con importe
										var subActual = parseFloat($('.'+idFilaSelect+'').find('td').eq(6).text());
										$('.'+idFilaSelect+'').find('td').eq(6).text((subActual-cantImporte));
										
									}
								});
								//Se alamacena el id de cada CheckBox de cada TR que se agrega a la tabla
								var id="check"+cont;
								arrayChacks.push(id);
							}else{
								//Se agrega cada producto escaneado
								$("#tablaDetalles").append('<tr class="selected fila'+cont+'"><td style="color: black;">'+value.pk_producto+'</td><td style="color: black;">'+value.nombre+'</td><td style="color: black;">'+precio+'</td><td style="color: black;">'+cantidadComprada+'</td><td style="color: black;">No aplica</td><td style="color: black;">'+value.nombre_provedor+'</td><td style="color: black;">'+subtotal+'</td><td><button class="btn btn-warning" id="fila'+cont+'" onclick="midificarCantC(this.id);">Midificar cant. compra</button></td><td><button class="btn btn-danger" id="fila'+cont+'" onclick="eliminarCantC(this.id);">Eliminar</button></td></tr>');
							}

							//Decrementar el stok de cada producto que se vaya agregando
							$.ajax({
								url:"../controladores/obtenerProductoEscaner.php",
								type:"post",
								data:{pk_producto:value.pk_producto,cantProducto:cantidadComprada},
								cache: false,
								success: function(data) {
									console.log(data);
								}
							});

							//Se almacena el subtotal de X producto
							arraySubTotales.push(subtotal);
							
							//Se alamacena el id de cada TR que se agrega a la tabla
							var id="fila"+cont;
							arrayIds.push(id);
							//Mostrar bonton para la realizacion de la venta
							$("#btnVenta").show();
							$("#btnFactura").show();

							//Se calcula y se muestra el total de la venta
							$("#total_final").text("$"+calcularTotal(arraySubTotales));

							//Se oculta la ventana modal
							$("#myModalCantidad").modal('hide');
							//Se restablece el valor del campo de cantidad de producto
							$("#cantProducto").val('1');

						});
}catch(err){
	console.log(err.message);
}
}else{
					//Cerrar la ventana para la cantidad del producto
					$("#myModalCantidad").modal('hide');
					//Se restablece el valor del campo de cantidad de producto
					$("#cantProducto").val(1);
					swal({
						position: 'top-center',
						type: 'warning',
						title: 'El codigo de barra no existe o el Stok del producto se ha agotado :( !!',
						showConfirmButton: true
					});
				}
			}
		});
$("#textCodigoBarras").val('');
});

});

var Idfila;
function midificarCantC(id_fila){
	Idfila=id_fila;
		//Se obtiene la cantidad de producto a comprar
		var cantC = parseFloat($('.'+id_fila+'').find('td').eq(3).text());
		
		$("#cantProductoRes").val(cantC);
		//Mostrar modal para restar numero de productos
		$("#ModalCantidadRestar").modal('show');
	}

	function eliminarCantC(id_fila){
		Idfila=id_fila;

		//Incrementar el stok de cada producto que se va a eleminar de la tabla de ventas
		var pk_producto = parseFloat($('.'+Idfila+'').find('td').eq(0).text());
		var cantidadComprada = parseFloat($('.'+Idfila+'').find('td').eq(3).text());
		$.ajax({
			url:"../controladores/obtenerProductoEscaner.php",
			type:"post",
			data:{pk_producto:pk_producto,cantProducto_sum:cantidadComprada},
			cache: false,
			success: function(data) {
				console.log(data);
			}
		});

		//Se busca la clase de la fila en concreto para removerla de la tabla
		for (var i = 0; i < arrayIds.length; i++) {
			if (Idfila==arrayIds[i]) {
				//Proceso para eliminar los dato del subtotal de la fila a eliminar, asi como el ID
				arrayIds.splice(i, 1);
				arraySubTotales.splice(i, 1);
				//Se elimina la fila de la table
				$("."+Idfila).remove();
				
				if (arrayImportes.length>0) {
					//Se eliminan los importes de la fila X o Y
					var numId = "check"+Idfila.split("fila")[1];
					var valid = $('.'+Idfila+'').find('td').eq(4).text();
					if (valid!="No aplica") {
						for (var i = 0; i < arrayChacks.length; i++) {
							if (numId==arrayChacks[i]) {
								arrayImportes.splice(i, 1);
								arrayChacks.splice(i, 1);
								break;
							}
						}
					}

					if (arrayImportes.length>0) {
						//Se vuelve a recalcular el total de toda la venta pero con importes aplicados
						$("#total_final").text("$"+calcularTotalYImportes(arraySubTotales));
					}else{
						//Se vuelve a recalcular el total de toda la compra
						$("#total_final").text("$"+calcularTotal(arraySubTotales));
					}
					
				}else{
					//Se vuelve a recalcular el total de toda la compra
					$("#total_final").text("$"+calcularTotal(arraySubTotales));
				}
				break;
			}
		}
	}


	function eliminarTodoFilas(){
		//Se busca la clase de la fila en concreto para removerla de la tabla
		for (var i = 0; i < arrayIds.length; i++) {
				//Se elimina la fila de la table
				$("."+arrayIds[i]).remove();
			}
			//Se vuelve a recalcular el total de toda la compra
			$("#total_final").text("$0");
		}

	//Funcion del boton para agregar o restar cantidad a X producto
	$("#btnOkRes").click(function(){

		//Se obtienen la nueva cantidad de productos midificada
		var nuevaCant = parseFloat($("#cantProductoRes").val());

		var pk_producto = parseFloat($('.'+Idfila+'').find('td').eq(0).text());
		var cantComp = parseFloat($('.'+Idfila+'').find('td').eq(3).text());
		var cantAumRes = (nuevaCant-cantComp);
		if (cantAumRes>=1) {
			//Restar al Stock del producto
			$.ajax({
				url:"../controladores/obtenerProductoEscaner.php",
				type:"post",
				data:{pk_producto:pk_producto,cantProducto:cantAumRes},
				cache: false,
				success: function(data) {
					console.log(data);
				}
			});
		}else if (cantAumRes<0){
			//Aumentar al Stock del producto
			$.ajax({
				url:"../controladores/obtenerProductoEscaner.php",
				type:"post",
				data:{pk_producto:pk_producto,cantProducto_sum:Math.abs(cantAumRes)},
				cache: false,
				success: function(data) {
					console.log(data);
				}
			});
		}

		//Se agrega el nuevo valor la cantidad comprada dentro de la tabla, en la fila indicada
		$('.'+Idfila+'').find('td').eq(3).text(nuevaCant);
		var precioU = parseFloat($('.'+Idfila+'').find('td').eq(2).text());
		//Se calcula y obtiene el nuevo subtotal
		var nuevoSubtotal = (nuevaCant*precioU);

		//Se agrega el nuevo valor de SUBTOTAL dentro de la tabla, en la fila indicada
		$('.'+Idfila+'').find('td').eq(6).text(nuevoSubtotal);

		//Calcular el nuevo subtotal y total de compra
		for (var i = 0; i < arrayIds.length; i++) {
			if (Idfila==arrayIds[i]) {
				arraySubTotales[i]=nuevoSubtotal;
				break;
			}
		}

		var importe = 0;
		if (arrayImportes.length>0) {
			//Proceso para eliminar o agregar los imprtes al afectar la cantidad de producto
			var numId = "check"+Idfila.split("fila")[1];
			if($("#"+numId).is(":checked")) {
				var valid = $('.'+Idfila+'').find('td').eq(4).text();
				if (valid!="No aplica") {
					var cant = parseFloat($('.'+Idfila+'').find('td').eq(3).text())
					var im = parseFloat($('.'+Idfila+'').find('td').eq(4).text());
					importe = (cant*im);
					for (var i = 0; i < arrayChacks.length; i++) {
						if (numId==arrayChacks[i]) {
							arrayImportes[i]=importe;
							break;
						}
					}
				}
			}

			//Se calcula y se muetra el total de la venta y los importes
			$("#total_final").text("$"+calcularTotalYImportes(arraySubTotales));
		}else{
			//Se calcula y se muetra el total de la venta
			$("#total_final").text("$"+calcularTotal(arraySubTotales));
		}

		//Calcular nuevo subtotal con importe
		var subActual = parseFloat($('.'+Idfila+'').find('td').eq(6).text());
		$('.'+Idfila+'').find('td').eq(6).text((subActual+importe));

		//Mostrar modal para restar numero de productos
		$("#ModalCantidadRestar").modal('hide');
	});

	//Calcular total de la venta
	function calcularTotal(arregloSubTotales) {
		var suma = 0;
		//Se suma unu a una, todos los subtotales almacenados en el arraySubTotales
		for (var i = 0; i < arregloSubTotales.length; i++) {
			suma+=arregloSubTotales[i];
		}
		//Se regresa el total de la suma
		return suma;
	}

	function calcularTotalYImportes(arregloSubTotales) {
		var suma = 0;
		if (arrayImportes.length>0) {
			for (var i = 0; i < arregloSubTotales.length; i++) {
				suma+=(arregloSubTotales[i]);
			}
			for (var i = 0; i < arrayImportes.length; i++) {
				suma+=(arrayImportes[i]);
			}
		}
		return suma;
	}

	function obtenerTodos(arrayIds,venta_factura) {

		//Se devuelven todos los productos al Stock, ne caso de ser solo una factura
		if (venta_factura==1) {
			for (var i = 0; i < arrayIds.length; i++) {
				var pk_producto = $('.'+arrayIds[i]+'').find('td').eq(0).text();
				var cant_producto = parseFloat($('.'+arrayIds[i]+'').find('td').eq(3).text());
				//Aumentar al Stock del producto
				$.ajax({
					url:"../controladores/obtenerProductoEscaner.php",
					type:"post",
					data:{pk_producto:pk_producto,cantProducto_sum:cant_producto},
					cache: false,
					success: function(data) {
						console.log(data);
					}
				});
			}
		}

		var pk_cliente = $("#pk_cliente").val();
		var cantPago = parseFloat($("#cantidadPago").val());
		var cambio=0;
		var totalFinal = 0;
		if (arrayImportes.length>0) {
			totalFinal = calcularTotalYImportes(arraySubTotales);
			cambio = parseFloat(cantPago-totalFinal);
		}else{
			totalFinal = calcularTotal(arraySubTotales);
			cambio = parseFloat(cantPago-totalFinal);
		}
		
		if (pk_cliente!="") {
			
			if (cantPago>=totalFinal) {
				//INSERTAR CON DATOS DE CLIENTE
				$.ajax({
					url:'../controladores/registrarVenta.php',
					type: 'POST',
					data:{pk_usuario:<?php echo $_SESSION['pk_admin']; ?>,total:totalFinal,pk_cliente:pk_cliente,cantPago:cantPago,cambio:cambio,factura:venta_factura},
					cache: false,
					success: function(resultado){
						
						var pk_venta = "";
						if (resultado!="false") {
							pk_venta=resultado;

							//INSERTAR A LA TABLA DE "Venta_Producto", DETALLES DE VENTA
							for (var i = 0; i < arrayIds.length; i++) {
								var pk_producto = $('.'+arrayIds[i]+'').find('td').eq(0).text();
								var cant_producto = parseFloat($('.'+arrayIds[i]+'').find('td').eq(3).text());
								var cant_importe = 0;
								var numId = "check"+arrayIds[i].split("fila")[1];
								if($("#"+numId).is(":checked")) {
									var imp = parseFloat($('.'+arrayIds[i]+'').find('td').eq(4).text());
									cant_importe = (cant_producto*imp);
								}
								
								$.ajax({
									url:'../controladores/insertarVentaProducto.php',
									type: 'POST',
									data:{cant_producto:cant_producto,cant_importe:cant_importe,pk_producto:pk_producto,pk_venta:pk_venta},
									cache: false,
									success: function(resultado){
									}
								});
							}

							//Eliminar todo el contenido de la tabla
							eliminarTodoFilas();
							
							//Reiniciar la variable contador para las filas de la tabla
							cont=0;
							//Se limpian los campos
							$("#pk_cliente").val('');
							$("#cantidadPago").val('');

							//Limpiar los datos de los arreglos
							arrayIds.length=0;
							arraySubTotales.length=0;

							swal({
								position: 'top-center',
								type: 'success',
								title: 'Venta realizada con exito!!',
								showConfirmButton: false,
								timer: 3000
							});

							if (venta_factura==0) {
								var url = 'ticket.php?pk_venta='+pk_venta;
								window.open(url, '_blank');
							}else{
								var url = 'factura.php?pk_venta='+pk_venta+"&view=printer";
								window.open(url, '_blank');
							}
							
							window.location.href = "ventas.php";
							
						}else{
							alert(resultado);
						}
					}
				});
			}else{
				alert("La cantidad con la que se esta pagando es menor a la que se debe!");
			}
		}else{
			//INSERTAR SIN DATOS DEL CLIENTE
			if (cantPago>=totalFinal) {
				$.ajax({
					url:'../controladores/registrarVenta.php',
					type: 'POST',
					data:{pk_usuario:<?php echo $_SESSION['pk_admin']; ?>,total:totalFinal,cantPago:cantPago,cambio:cambio,factura:venta_factura},
					cache: false,
					success: function(resultado){
						var pk_venta="";
						if (resultado!="false") {
							pk_venta=resultado;
							for (var i = 0; i < arrayIds.length; i++) {
								var pk_producto = $('.'+arrayIds[i]+'').find('td').eq(0).text();
								var cant_producto = parseFloat($('.'+arrayIds[i]+'').find('td').eq(3).text());
								var cant_importe = 0;
								var numId = "check"+arrayIds[i].split("fila")[1];
								if($("#"+numId).is(":checked")) {
									var imp = parseFloat($('.'+arrayIds[i]+'').find('td').eq(4).text());
									cant_importe = (cant_producto*imp);
								}
								
								$.ajax({
									url:'../controladores/insertarVentaProducto.php',
									type: 'POST',
									data:{cant_producto:cant_producto,cant_importe:cant_importe,pk_producto:pk_producto,pk_venta:pk_venta},
									cache: false,
									success: function(resultado){
									}
								});
							}
							
							//Eliminar todo el contenido de la tabla
							eliminarTodoFilas();
							//Limpiar los datos de los arreglos
							arrayIds.length=0;
							arraySubTotales.length=0;
							arrayImportes.length=0;
							arrayChacks.length=0;
							//Reiniciar la variable contador para las filas de la tabla
							cont=0;
							//Se limpian los campos
							$("#pk_cliente").val('');
							$("#cantidadPago").val('');

							swal({
								position: 'top-center',
								type: 'success',
								title: 'Venta realizada con exito!!',
								showConfirmButton: false,
								timer: 3000
							});

							if (venta_factura==0) {
								var url = 'ticket.php?pk_venta='+pk_venta;
								window.open(url, '_blank');
							}else{
								var url = 'factura.php?pk_venta='+pk_venta+"&view=printer";
								window.open(url, '_blank');
							}

							window.location.href = "ventas.php";

						}else{
							alert(resultado);
						}
						
					}
				});
			}else{
				alert("La cantidad con la que se esta pagando es menor a la que se debe!");
			}
			
		}
	}

</script>
<script>
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
	<script type="text/javascript" src="../js/sweetalert.min.js"></script>
	<!-- //for bootstrap working -->
</body>

</html>