<?php
session_start();
if ((isset($_SESSION['pk_admin']) || isset($_SESSION['pk_usuario'])) && (isset($_SESSION['nombre_admin']) || isset($_SESSION['nombre_user']))) {

	require_once("../conexion.php");

	$obj_conexion = new Conexion();
	$conexion = $obj_conexion->conectar();

	$sql = "SELECT v.pk_venta, c.nombre_cliente, CONCAT(u.nombre,' ',u.apellidos) AS nombre_usuario, v.total, vp.cant_importe, v.fecha, DATE_FORMAT(v.hora,'%r') AS hora, v.estado FROM venta AS v LEFT JOIN cliente AS c ON c.pk_cliente=v.fk_cliente LEFT JOIN usuario AS u ON u.pk_usuario=v.fk_usuario LEFT JOIN venta_producto AS vp ON vp.fk_venta=v.pk_venta LEFT JOIN producto p ON p.pk_producto=vp.fk_producto WHERE v.factura=1 GROUP BY v.pk_venta";

	$result = $conexion->prepare($sql);

	if (!$result->execute()) return false;

	if ($result->rowCount() > 0) {
		while ($row = $result->fetch()) {
			$arreglo["data"][]=$row;
		}
		echo json_encode($arreglo);
	}else{
		echo "No hay facturas registradas!";
	}
	$result->closeCursor();

}else{
	echo "false";
}
?>