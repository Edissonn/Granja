<?php
session_start();

if (isset($_SESSION['pk_admin']) && isset($_SESSION['nombre_admin']) && isset($_GET['pk_venta']) && isset($_SESSION['time_incative']) && isset($_SESSION['time_login'])) {

	//Se valida el tiempo de inactividad de la session
	$current_sinIn = (time() - $_SESSION['time_login']);
	if ($current_sinIn > $_SESSION['time_incative']) {
		session_destroy();
		header('location: ../index.php');
	}else{
		$_SESSION['time_login'] = time();
	}

	$pk_venta =  $_GET['pk_venta'];

	require_once("../conexion.php");

	$obj_conexion = new Conexion();
	$conexion = $obj_conexion->conectar();

	//Consulta para sacar los datos de la venta
	$sql_venta = "SELECT v.pk_venta, c.nombre_cliente, CONCAT(u.nombre,' ',u.apellidos) AS nombre_usuario, v.total, vp.cant_importe, v.fecha, DATE_FORMAT(v.hora,'%r') AS hora, v.estado FROM venta AS v LEFT JOIN cliente AS c ON c.pk_cliente=v.fk_cliente LEFT JOIN usuario AS u ON u.pk_usuario=v.fk_usuario LEFT JOIN venta_producto AS vp ON vp.fk_venta=v.pk_venta LEFT JOIN producto p ON p.pk_producto=vp.fk_producto WHERE v.pk_venta=? AND v.factura=1 GROUP BY v.pk_venta";
	$statement_venta = $conexion->prepare($sql_venta);
	$statement_venta->bindParam(1, $pk_venta);
	$statement_venta->execute();
	$res_venta = $statement_venta->fetchAll();

	//Consulta para sacar todos los prodcutos vendidios en X o Y venta
	$sql_vp = "SELECT p.nombre,p.codigo_barras,p.precio,p.importe,vp.cant_producto,((vp.cant_producto*p.precio)+vp.cant_importe) AS subtotal,vp.cant_importe FROM venta v, producto p, venta_producto vp WHERE v.pk_venta=vp.fk_venta AND p.pk_producto=vp.fk_producto AND v.pk_venta=? AND v.factura=1 GROUP BY vp.pk_vp";
	$statement_vp = $conexion->prepare($sql_vp);
	$statement_vp->bindParam(1,$pk_venta);
	$statement_vp->execute();
	$res_vp = $statement_vp->fetchAll();

}else {
	header("location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Factura</title>
	<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />

	<style>@import url(http://fonts.googleapis.com/css?family=Bree+Serif);
	body, h1, h2, h3, h4, h5, h6{
		font-family: 'Bree Serif', serif;
	}
</style>
</head>
<body>
	<?php
	if (count($res_venta)>0) {
		?>
		<div class="jumbotron">
			<div class="container">
				<div class="col-xs-6">
					<h1>
						<img width="280px" height="200px" src="../img/logoP.jpeg" />
					</h1>
				</div>
				<div class="col-xs-6 text-right">
					<h1>FACTURA</h1>
					<h1>
						<small>
							#00<?php echo $res_venta[0]['pk_venta']; ?>
						</small>
					</h1>
				</div>

				<hr/>

				<div class="row">
					<div class="col-xs-7">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4>De: <a style="cursor: pointer;"><?php echo $res_venta[0]['nombre_usuario']; ?></a></h4>
							</div>
							<div class="panel-body">Vendedor</div>
						</div>
					</div>
					<div class="col-xs-5 text-right">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4>Para : <a style="cursor: pointer;">
									<?php
									if (!empty($res_venta[0]['nombre_cliente'])) {
										echo $res_venta[0]['nombre_cliente'];
									}else{
										?>
										<input type="text" required="" placeholder="Escribe el nmbre del Cliente" class="form-control">
										<?php
									}
									?>
								</a></h4>
							</div>
							<div class="panel-body">Cliente</div>
						</div>
					</div>
				</div>

				<table class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th>
								<h4>Producto</h4>
							</th>
							<th>
								<h4>Unidad / Cantidad</h4>
							</th>
							<th>
								<h4>Precio / Unitario</h4>
							</th>
							<th>
								<h4>Importe</h4>
							</th>
							<th>
								<h4>Importe / pagar</h4>
							</th>
							<th>
								<h4>Sub-Total</h4>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($res_vp as $result) {
							?>
							<tr>
								<td><?php echo $result['nombre']; ?></td>
								<td class=" text-right "><?php echo $result['cant_producto']; ?></td>
								<td class=" text-right ">$<?php echo $result['precio']; ?></td>
								<td class=" text-right ">$<?php echo $result['importe']; ?></td>
								<td class=" text-right ">$<?php echo $result['cant_importe']; ?></td>
								<td class=" text-right ">$<?php echo $result['subtotal']; ?></td>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>

				<div class="row text-right">
					<div class="col-xs-3 col-xs-offset-7">
						<strong>
							Sub Total:
							Impuestos (IVA 16%):
							Total:
						</strong>
					</div>
					<div class="col-xs-2">
						<strong>
							$<?php echo $res_venta[0]['total']; ?>
						</strong>
					</div>
				</div>

				<div class="row">
					<div class = "col-xs-5">
						datos bancarios
						<div class="col-xs-7">
							datos de contacto
						</div>
					</div>

					<div class="panel panel-info">
						<div class="panel-heading">
							<h4>
								Datos bancarios
							</h4>
						</div>
						<div class="panel-body">
							Su nombre
							Nombre del banco
							SWIFT: -------
							Número de cuenta: 12345678
							IBAN: ------
						</div>
					</div>
				</div>

				<div class="span7">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h4>
								Datos de contacto
							</h4>
							<div class=" panel-body ">
								Email: usted@ejemplo.com
								Móvil: +92123456789
								Twitter: <a href="#"> http: //www. suweb.com/author/usted / </a>
								<h4>
									<small>
										El pago debe ser por transferencia bancaria
									</small>
								</h4>
							</div>
						</div>
					</div>
				</div>
				<?php
				if (!isset($_GET['view'])) {
					?>
					<div align="center">
						<button class="btn btn-success btn-lg" id="btn_venta" style="width: 350px">Realizar Venta</button>
						<button class="btn btn-warning btn-lg" id="btn_edit" style="width: 350px">Editar Factura</button>
						<button class="btn btn-danger btn-lg" id="btn_unventa" style="width: 350px">Cancelar Factura</button>
					</div>
					<?php
				}
				?>
				
			</div>
		</div>
		<?php
	}else{
		?>
		<div class="jumbotron">
			<div class="container">
				<div align="center">
					<h1>Esta factura ya ha sido realizada como venta o ha sido eliminada!!</h1>
				</div>
			</div>
		</div>
		<?php
	}
	?>
	<script type="text/javascript" src="../js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript">
		<?php
		if (!isset($_GET['view'])) {
			?>
			$(document).ready(function() {

			//Realizar venta atravez de la factura
			$("#btn_venta").click(function() {
				$.ajax({
					url: "../controladores/registrarVenta.php",
					type: "post",
					cache: false,
					data:{pk_venta:<?php echo $res_venta[0]['pk_venta']; ?>},
					success: function(data){
						if (data=="true") {
							alert("Vanta realizada con exito!");
							window.close();
						}else if (data=="false"){
							alert("Ha ocurrido un erro al realizar la venta!");
						}else{
							alert(data);
						}
					}
				});
			});

			//Eliminar los regustros de venta, a travez de la factura
			$("#btn_unventa").click(function() {
				$.ajax({
					url: "../controladores/eliminarFactura.php",
					type: "post",
					cache: false,
					data:{pk_venta_del:<?php echo $res_venta[0]['pk_venta']; ?>},
					success: function(data){
						if (data=="true") {
							alert("Factura cancelada con exito!");
							window.close();
						}else{
							alert("Ha ocurrido un erro al cancelar dicha factura!");
						}
					}
				});
			});

			//Editar la factura, y enviar toda la informacion para editar la factura
			$("#btn_edit").click(function() {
				var array_codB = [];
				var array_cantP = [];
				<?php
				foreach ($res_vp as $result) {
					?>
					array_codB.push(<?php echo $result['codigo_barras']; ?>);
					array_cantP.push(<?php echo $result['cant_producto']; ?>);
					<?php
				}
				?>
				var url = 'editar_factura.php?pk_venta=<?php echo $res_venta[0]['pk_venta']; ?>&codbarr='+array_codB.toString()+'&cantP='+array_cantP.toString()+'&cliente=<?php echo $res_venta[0]['nombre_cliente']; ?>';
				window.open(url, '_blank');
				window.close();
			});

		});
			<?php	
		}
		?>
		
	</script>
</body>
</html>