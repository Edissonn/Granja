<?php
session_start();
date_default_timezone_set("America/Bahia_Banderas");

require_once('../conexion.php');
$obj_conexion = new Conexion();
$conexion = $obj_conexion->conectar();

$fecha = date('Y-m-d');

if ((isset($_SESSION['pk_admin']) || isset($_SESSION['pk_usuario'])) && (isset($_SESSION['nombre_admin']) || isset($_SESSION['nombre_user'])) && !isset($_POST['pk_corcaja']) && !isset($_POST['caja'])) {

	//$pk_usuario = isset($_SESSION['pk_admin']) ? $_SESSION['pk_admin'] : $_SESSION['pk_usuario'];

	if (validarPrimeraVez($conexion)>0) {
		$fechas = BusscarAnteriores($conexion, $fecha);
		if (count($fechas)>0) {
			foreach ($fechas as $value) {
				insertar($conexion, $value['fecha'], $value['fecha']);
			}
		}
	}else{
		insertar($conexion, $fecha, $fecha);
	}

	//Cargar cortes de caja
	$sql1 = "SELECT * FROM corte_caja WHERE status=0";
	$cortes_pendientes = $conexion->prepare($sql1);
	$cortes_pendientes->execute();
	$res_cortes = $cortes_pendientes->fetchAll();
	foreach ($res_cortes as $value) {
		echo '<tr>
		<td>
			<strong style="color: black;">'.$value['pk_corcaja'].'</strong>
		</td>
		<td>
			<strong style="color: black;">Sistema</strong>
		</td>
		<td>
			<strong style="color: black;">'.$value['hora'].'</strong>
		</td>
		<td>
			<strong style="color: black;">'.$value['fecha_corte'].'</strong>
		</td>
		<td>
			<strong style="color: black;">'.$value['fecha_venta'].'</strong>
		</td>
		<td>
			<strong style="color: black;">----</strong>
		</td>
		<td>
			<button class="btn btn-success" data-toggle="modal" data-target="#modalCortes" id="'.$value['pk_corcaja'].'" onclick="infoMontos(this.id);">Confirmar corte de caja</button>
		</td>
	</tr>';
}
$cortes_pendientes->closeCursor();

}

if ((isset($_SESSION['pk_admin']) || isset($_SESSION['pk_usuario'])) && (isset($_SESSION['nombre_admin']) || isset($_SESSION['nombre_user'])) && isset($_POST['pk_corcaja']) && !isset($_POST['caja'])) {
	
	$pk_corcaja = $_POST['pk_corcaja'];
	echo ObtenerMontos($conexion, $pk_corcaja);

}

if ((isset($_SESSION['pk_admin']) || isset($_SESSION['pk_usuario'])) && (isset($_SESSION['nombre_admin']) || isset($_SESSION['nombre_user'])) && isset($_POST['caja']) && isset($_POST['pk_corcaja'])) {

	$pk_usuario = isset($_SESSION['pk_admin']) ? $_SESSION['pk_admin'] : $_SESSION['pk_usuario'];
	$status=1;

	$sql = "UPDATE corte_caja SET cant_caja=?, fk_usuario=?, status=? WHERE pk_corcaja=?";
	$insertCorteCaja = $conexion->prepare($sql);
	$insertCorteCaja->bindParam(1,$_POST['caja']);
	$insertCorteCaja->bindParam(2,$pk_usuario);
	$insertCorteCaja->bindParam(3,$status);
	$insertCorteCaja->bindParam(4,$_POST['pk_corcaja']);
	$insertCorteCaja->execute();
	if ($insertCorteCaja->rowCount()>0) {
		echo "true";
	}
	$insertCorteCaja->closeCursor();
}

function ObtenerMontos($conexion, $pk_corcaja)
{
	//Monto de ventas totales en efectivo
	$sql1 = "SELECT SUM(v.total) AS ventas_totales FROM venta v WHERE v.fecha=(SELECT fecha_venta FROM corte_caja WHERE pk_corcaja=?) AND v.tipo_pago=1";
	$venntas_efectivo = $conexion->prepare($sql1);
	$venntas_efectivo->bindParam(1,$pk_corcaja);
	$venntas_efectivo->execute();
	$monto_efectivo = $venntas_efectivo->fetch()['ventas_totales'];
	$venntas_efectivo->closeCursor();

	//Monto de ventas totales con tarjeta
	$sql2 = "SELECT SUM(v.total) AS ventas_totales FROM venta v WHERE v.fecha=(SELECT fecha_venta FROM corte_caja WHERE pk_corcaja=?) AND v.tipo_pago=2";
	$venntas_tarjeta = $conexion->prepare($sql2);
	$venntas_tarjeta->bindParam(1,$pk_corcaja);
	$venntas_tarjeta->execute();
	$monto_tarjeta = $venntas_tarjeta->fetch()['ventas_totales'];
	$venntas_tarjeta->closeCursor();

	if ($monto_efectivo==null) {
		$monto_efectivo = 0;
	}
	if ($monto_tarjeta==null) {
		$monto_tarjeta = 0;
	}

	$total = ($monto_efectivo+$monto_tarjeta);
	$valores = ['monto_efectivo' => $monto_efectivo, 'monto_tarjeta' => $monto_tarjeta, 'total' => $total];
	return json_encode($valores);
	
}

function BusscarAnteriores($conexion, $fecha)
{	
	$sql = "SELECT MAX(fecha_corte) AS last_date FROM corte_caja";
	$max_fecha = $conexion->prepare($sql);
	$max_fecha->execute();
	$res_last = $max_fecha->fetch();

	//Obtener los dias faltantes de reaizacion de corte de caja
	$sql = "SELECT DISTINCT fecha FROM venta WHERE fecha>?";
	$fechas = $conexion->prepare($sql);
	$fechas->bindParam(1, $res_last['last_date']);
	$fechas->execute();
	$res_fechas = $fechas->fetchAll();
	return $res_fechas;

	$fechas->closeCursor();
	$max_fecha->closeCursor();
}

function insertar($conexion, $fecha, $fecha_venta)
{
	$status = 0;
	$ganancias = 0;
	
	$sql = "SELECT SUM(total) AS ventas_totales FROM venta WHERE fecha=?";
	$ganancias_actuales = $conexion->prepare($sql);
	$ganancias_actuales->bindParam(1, $fecha);
	$ganancias_actuales->execute();
	$res = $ganancias_actuales->fetch();

	$sql = "INSERT INTO corte_caja VALUES(NULL,now(),?,now(),?,NULL,NULL,?)";
	$validator = $conexion->prepare($sql);
	$validator->bindParam(1, $fecha_venta);
	$validator->bindParam(2, $res['ventas_totales']);
	$validator->bindParam(3, $status);
	$validator->execute();
	$ganancias_actuales->closeCursor();
	$validator->closeCursor();
}

function validarPrimeraVez($conexion)
{
	$sql = "SELECT COUNT(pk_corcaja) AS num FROM corte_caja";
	$validator = $conexion->prepare($sql);
	$validator->execute();
	return $validator->fetch()['num'];
	$validator->closeCursor();
}
?>