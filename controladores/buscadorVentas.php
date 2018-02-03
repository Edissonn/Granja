<?php 
session_start();

require_once("../conexion.php");

$obj_conexion = new Conexion();
$conexion = $obj_conexion->conectar();

if ((isset($_SESSION['pk_admin']) || isset($_SESSION['pk_usuario'])) && (isset($_SESSION['nombre_admin']) || isset($_SESSION['nombre_user'])) && isset($_POST['array'])) {

	//Se recojen los valores a buscar para la consulta
	$valores_buscar = json_decode($_POST['array'], true);
	$sql = null;

	if (!empty($valores_buscar['noVenta']) && !empty($valores_buscar['cliente']) && !empty($valores_buscar['fechaVenta']) && !empty($valores_buscar['producto_id'])) {

		$sql = "SELECT v.pk_venta, c.nombre_cliente, CONCAT(u.nombre,' ',u.apellidos) AS nombre_usuario, v.total, vp.cant_importe, v.fecha, DATE_FORMAT(v.hora,'%r') AS hora, v.estado FROM venta AS v LEFT JOIN cliente AS c ON c.pk_cliente=v.fk_cliente LEFT JOIN usuario AS u ON u.pk_usuario=v.fk_usuario LEFT JOIN venta_producto AS vp ON vp.fk_venta=v.pk_venta LEFT JOIN producto p ON p.pk_producto=vp.fk_producto WHERE v.pk_venta=? AND v.fecha=? AND p.nombre=? AND c.nombre_cliente=? AND v.factura=0 GROUP BY v.pk_venta";
		$statement = $conexion->prepare($sql);
		$statement->bindParam(1,$valores_buscar['noVenta']);
		$statement->bindParam(2,$valores_buscar['fechaVenta']);
		$statement->bindParam(3,$valores_buscar['producto_id']);
		$statement->bindParam(4,$valores_buscar['cliente']);

		if (!$statement->execute()) return false;

		if ($statement->rowCount() > 0) {
			while ($row = $statement->fetch()) {
				$arreglo["data"][]=$row;
			}
			echo json_encode($arreglo);
		}else{
			echo "false";
		}
		$statement->closeCursor();

	}else if (!empty($valores_buscar['noVenta']) && !empty($valores_buscar['cliente']) && !empty($valores_buscar['fechaVenta'])) {

		$sql = "SELECT v.pk_venta, c.nombre_cliente, CONCAT(u.nombre,' ',u.apellidos) AS nombre_usuario, v.total, vp.cant_importe, v.fecha, DATE_FORMAT(v.hora,'%r') AS hora, v.estado FROM venta AS v LEFT JOIN cliente AS c ON c.pk_cliente=v.fk_cliente LEFT JOIN usuario AS u ON u.pk_usuario=v.fk_usuario LEFT JOIN venta_producto AS vp ON vp.fk_venta=v.pk_venta LEFT JOIN producto p ON p.pk_producto=vp.fk_producto WHERE v.pk_venta=? AND v.fecha=? AND c.nombre_cliente=? AND v.factura=0 GROUP BY v.pk_venta";
		$statement = $conexion->prepare($sql);
		$statement->bindParam(1,$valores_buscar['noVenta']);
		$statement->bindParam(2,$valores_buscar['fechaVenta']);
		$statement->bindParam(3,$valores_buscar['cliente']);

		if (!$statement->execute()) return false;

		if ($statement->rowCount() > 0) {
			while ($row = $statement->fetch()) {
				$arreglo["data"][]=$row;
			}
			echo json_encode($arreglo);
		}else{
			echo "false";
		}
		$statement->closeCursor();

	}else if (!empty($valores_buscar['noVenta']) && !empty($valores_buscar['cliente'])) {
		
		$sql = "SELECT v.pk_venta, c.nombre_cliente, CONCAT(u.nombre,' ',u.apellidos) AS nombre_usuario, v.total, vp.cant_importe, v.fecha, DATE_FORMAT(v.hora,'%r') AS hora, v.estado FROM venta AS v LEFT JOIN cliente AS c ON c.pk_cliente=v.fk_cliente LEFT JOIN usuario AS u ON u.pk_usuario=v.fk_usuario LEFT JOIN venta_producto AS vp ON vp.fk_venta=v.pk_venta LEFT JOIN producto p ON p.pk_producto=vp.fk_producto WHERE v.pk_venta=? AND c.nombre_cliente=? AND v.factura=0 GROUP BY v.pk_venta";
		$statement = $conexion->prepare($sql);
		$statement->bindParam(1,$valores_buscar['noVenta']);
		$statement->bindParam(2,$valores_buscar['cliente']);

		if (!$statement->execute()) return false;

		if ($statement->rowCount() > 0) {
			while ($row = $statement->fetch()) {
				$arreglo["data"][]=$row;
			}
			echo json_encode($arreglo);
		}else{
			echo "false";
		}
		$statement->closeCursor();

	}else if (!empty($valores_buscar['noVenta']) && !empty($valores_buscar['producto_id'])) {
		
		$sql = "SELECT v.pk_venta, c.nombre_cliente, CONCAT(u.nombre,' ',u.apellidos) AS nombre_usuario, v.total, vp.cant_importe, v.fecha, DATE_FORMAT(v.hora,'%r') AS hora, v.estado FROM venta AS v LEFT JOIN cliente AS c ON c.pk_cliente=v.fk_cliente LEFT JOIN usuario AS u ON u.pk_usuario=v.fk_usuario LEFT JOIN venta_producto AS vp ON vp.fk_venta=v.pk_venta LEFT JOIN producto p ON p.pk_producto=vp.fk_producto WHERE v.pk_venta=? AND p.nombre=? AND v.factura=0 GROUP BY v.pk_venta";
		$statement = $conexion->prepare($sql);
		$statement->bindParam(1,$valores_buscar['noVenta']);
		$statement->bindParam(2,$valores_buscar['producto_id']);

		if (!$statement->execute()) return false;

		if ($statement->rowCount() > 0) {
			while ($row = $statement->fetch()) {
				$arreglo["data"][]=$row;
			}
			echo json_encode($arreglo);
		}else{
			echo "false";
		}
		$statement->closeCursor();

	}else if (!empty($valores_buscar['noVenta']) && !empty($valores_buscar['fechaVenta'])) {
		
		$sql = "SELECT v.pk_venta, c.nombre_cliente, CONCAT(u.nombre,' ',u.apellidos) AS nombre_usuario, v.total, vp.cant_importe, v.fecha, DATE_FORMAT(v.hora,'%r') AS hora, v.estado FROM venta AS v LEFT JOIN cliente AS c ON c.pk_cliente=v.fk_cliente LEFT JOIN usuario AS u ON u.pk_usuario=v.fk_usuario LEFT JOIN venta_producto AS vp ON vp.fk_venta=v.pk_venta LEFT JOIN producto p ON p.pk_producto=vp.fk_producto WHERE v.pk_venta=? AND v.fecha=? AND v.factura=0 GROUP BY v.pk_venta";
		$statement = $conexion->prepare($sql);
		$statement->bindParam(1,$valores_buscar['noVenta']);
		$statement->bindParam(2,$valores_buscar['fechaVenta']);

		if (!$statement->execute()) return false;

		if ($statement->rowCount() > 0) {
			while ($row = $statement->fetch()) {
				$arreglo["data"][]=$row;
			}
			echo json_encode($arreglo);
		}else{
			echo "false";
		}
		$statement->closeCursor();

	}else if (!empty($valores_buscar['noVenta'])) {
		
		$sql = "SELECT v.pk_venta, c.nombre_cliente, CONCAT(u.nombre,' ',u.apellidos) AS nombre_usuario, v.total, vp.cant_importe, v.fecha, DATE_FORMAT(v.hora,'%r') AS hora, v.estado FROM venta AS v LEFT JOIN cliente AS c ON c.pk_cliente=v.fk_cliente LEFT JOIN usuario AS u ON u.pk_usuario=v.fk_usuario LEFT JOIN venta_producto AS vp ON vp.fk_venta=v.pk_venta LEFT JOIN producto p ON p.pk_producto=vp.fk_producto WHERE v.pk_venta=? AND v.factura=0 GROUP BY v.pk_venta";
		$statement = $conexion->prepare($sql);
		$statement->bindParam(1,$valores_buscar['noVenta']);

		if (!$statement->execute()) return false;

		if ($statement->rowCount() > 0) {
			while ($row = $statement->fetch()) {
				$arreglo["data"][]=$row;
			}
			echo json_encode($arreglo);
		}else{
			echo "false";
		}
		$statement->closeCursor();

	}else if (!empty($valores_buscar['cliente']) && !empty($valores_buscar['fechaVenta']) && !empty($valores_buscar['producto_id'])) {
		
		$sql = "SELECT v.pk_venta, c.nombre_cliente, CONCAT(u.nombre,' ',u.apellidos) AS nombre_usuario, v.total, vp.cant_importe, v.fecha, DATE_FORMAT(v.hora,'%r') AS hora, v.estado FROM venta AS v LEFT JOIN cliente AS c ON c.pk_cliente=v.fk_cliente LEFT JOIN usuario AS u ON u.pk_usuario=v.fk_usuario LEFT JOIN venta_producto AS vp ON vp.fk_venta=v.pk_venta LEFT JOIN producto p ON p.pk_producto=vp.fk_producto WHERE v.fecha=? AND p.nombre=? AND c.nombre_cliente=? AND v.factura=0 GROUP BY v.pk_venta";
		$statement = $conexion->prepare($sql);
		$statement->bindParam(1,$valores_buscar['fechaVenta']);
		$statement->bindParam(2,$valores_buscar['producto_id']);
		$statement->bindParam(3,$valores_buscar['cliente']);

		if (!$statement->execute()) return false;

		if ($statement->rowCount() > 0) {
			while ($row = $statement->fetch()) {
				$arreglo["data"][]=$row;
			}
			echo json_encode($arreglo);
		}else{
			echo "false";
		}
		$statement->closeCursor();

	}else if (!empty($valores_buscar['cliente']) && !empty($valores_buscar['producto_id'])) {
		
		$sql = "SELECT v.pk_venta, c.nombre_cliente, CONCAT(u.nombre,' ',u.apellidos) AS nombre_usuario, v.total, vp.cant_importe, v.fecha, DATE_FORMAT(v.hora,'%r') AS hora, v.estado FROM venta AS v LEFT JOIN cliente AS c ON c.pk_cliente=v.fk_cliente LEFT JOIN usuario AS u ON u.pk_usuario=v.fk_usuario LEFT JOIN venta_producto AS vp ON vp.fk_venta=v.pk_venta LEFT JOIN producto p ON p.pk_producto=vp.fk_producto WHERE p.nombre=? AND c.nombre_cliente=? AND v.factura=0 GROUP BY v.pk_venta";
		$statement = $conexion->prepare($sql);
		$statement->bindParam(1,$valores_buscar['producto_id']);
		$statement->bindParam(2,$valores_buscar['cliente']);

		if (!$statement->execute()) return false;

		if ($statement->rowCount() > 0) {
			while ($row = $statement->fetch()) {
				$arreglo["data"][]=$row;
			}
			echo json_encode($arreglo);
		}else{
			echo "false";
		}
		$statement->closeCursor();

	}else if (!empty($valores_buscar['fechaVenta']) && !empty($valores_buscar['producto_id'])) {
		
		$sql = "SELECT v.pk_venta, c.nombre_cliente, CONCAT(u.nombre,' ',u.apellidos) AS nombre_usuario, v.total, vp.cant_importe, v.fecha, DATE_FORMAT(v.hora,'%r') AS hora, v.estado FROM venta AS v LEFT JOIN cliente AS c ON c.pk_cliente=v.fk_cliente LEFT JOIN usuario AS u ON u.pk_usuario=v.fk_usuario LEFT JOIN venta_producto AS vp ON vp.fk_venta=v.pk_venta LEFT JOIN producto p ON p.pk_producto=vp.fk_producto WHERE v.fecha=? AND p.nombre=? AND v.factura=0 GROUP BY v.pk_venta";
		$statement = $conexion->prepare($sql);
		$statement->bindParam(1,$valores_buscar['fechaVenta']);
		$statement->bindParam(2,$valores_buscar['producto_id']);

		if (!$statement->execute()) return false;

		if ($statement->rowCount() > 0) {
			while ($row = $statement->fetch()) {
				$arreglo["data"][]=$row;
			}
			echo json_encode($arreglo);
		}else{
			echo "false";
		}
		$statement->closeCursor();

	}else if (!empty($valores_buscar['producto_id'])) {
		
		$sql = "SELECT v.pk_venta, c.nombre_cliente, CONCAT(u.nombre,' ',u.apellidos) AS nombre_usuario, v.total, vp.cant_importe, v.fecha, DATE_FORMAT(v.hora,'%r') AS hora, v.estado FROM venta AS v LEFT JOIN cliente AS c ON c.pk_cliente=v.fk_cliente LEFT JOIN usuario AS u ON u.pk_usuario=v.fk_usuario LEFT JOIN venta_producto AS vp ON vp.fk_venta=v.pk_venta LEFT JOIN producto p ON p.pk_producto=vp.fk_producto WHERE p.nombre=? AND v.factura=0 GROUP BY v.pk_venta";
		$statement = $conexion->prepare($sql);
		$statement->bindParam(1,$valores_buscar['producto_id']);

		if (!$statement->execute()) return false;

		if ($statement->rowCount() > 0) {
			while ($row = $statement->fetch()) {
				$arreglo["data"][]=$row;
			}
			echo json_encode($arreglo);
		}else{
			echo "false";
		}
		$statement->closeCursor();

	}else if (!empty($valores_buscar['cliente']) && !empty($valores_buscar['fechaVenta'])) {
		
		$sql = "SELECT v.pk_venta, c.nombre_cliente, CONCAT(u.nombre,' ',u.apellidos) AS nombre_usuario, v.total, vp.cant_importe, v.fecha, DATE_FORMAT(v.hora,'%r') AS hora, v.estado FROM venta AS v LEFT JOIN cliente AS c ON c.pk_cliente=v.fk_cliente LEFT JOIN usuario AS u ON u.pk_usuario=v.fk_usuario LEFT JOIN venta_producto AS vp ON vp.fk_venta=v.pk_venta LEFT JOIN producto p ON p.pk_producto=vp.fk_producto WHERE v.fecha=? AND c.nombre_cliente=? AND v.factura=0 GROUP BY v.pk_venta";
		$statement = $conexion->prepare($sql);
		$statement->bindParam(1,$valores_buscar['fechaVenta']);
		$statement->bindParam(2,$valores_buscar['cliente']);

		if (!$statement->execute()) return false;

		if ($statement->rowCount() > 0) {
			while ($row = $statement->fetch()) {
				$arreglo["data"][]=$row;
			}
			echo json_encode($arreglo);
		}else{
			echo "false";
		}
		$statement->closeCursor();

	}else if (!empty($valores_buscar['cliente'])) {
		
		$sql = "SELECT v.pk_venta, c.nombre_cliente, CONCAT(u.nombre,' ',u.apellidos) AS nombre_usuario, v.total, vp.cant_importe, v.fecha, DATE_FORMAT(v.hora,'%r') AS hora, v.estado FROM venta AS v LEFT JOIN cliente AS c ON c.pk_cliente=v.fk_cliente LEFT JOIN usuario AS u ON u.pk_usuario=v.fk_usuario LEFT JOIN venta_producto AS vp ON vp.fk_venta=v.pk_venta LEFT JOIN producto p ON p.pk_producto=vp.fk_producto WHERE c.nombre_cliente=? AND v.factura=0 GROUP BY v.pk_venta";
		$statement = $conexion->prepare($sql);
		$statement->bindParam(1,$valores_buscar['cliente']);

		if (!$statement->execute()) return false;

		if ($statement->rowCount() > 0) {
			while ($row = $statement->fetch()) {
				$arreglo["data"][]=$row;
			}
			echo json_encode($arreglo);
		}else{
			echo "false";
		}
		$statement->closeCursor();

	}else if (!empty($valores_buscar['fechaVenta'])) {
		
		$sql = "SELECT v.pk_venta, c.nombre_cliente, CONCAT(u.nombre,' ',u.apellidos) AS nombre_usuario, v.total, vp.cant_importe, v.fecha, DATE_FORMAT(v.hora,'%r') AS hora, v.estado FROM venta AS v LEFT JOIN cliente AS c ON c.pk_cliente=v.fk_cliente LEFT JOIN usuario AS u ON u.pk_usuario=v.fk_usuario LEFT JOIN venta_producto AS vp ON vp.fk_venta=v.pk_venta LEFT JOIN producto p ON p.pk_producto=vp.fk_producto WHERE v.fecha=? AND v.factura=0 GROUP BY v.pk_venta";
		$statement = $conexion->prepare($sql);
		$statement->bindParam(1,$valores_buscar['fechaVenta']);

		if (!$statement->execute()) return false;

		if ($statement->rowCount() > 0) {
			while ($row = $statement->fetch()) {
				$arreglo["data"][]=$row;
			}
			echo json_encode($arreglo);
		}else{
			echo "false";
		}
		$statement->closeCursor();

	}

}else if ((isset($_SESSION['pk_admin']) || isset($_SESSION['pk_usuario'])) && (isset($_SESSION['nombre_admin']) || isset($_SESSION['nombre_user'])) && isset($_POST['venta_id'])) {
	$sql = "SELECT p.nombre,p.codigo_barras,p.precio,p.importe,vp.cant_producto,(p.precio*vp.cant_producto) AS subtotal,vp.cant_importe FROM venta v, producto p, venta_producto vp WHERE v.pk_venta=vp.fk_venta AND p.pk_producto=vp.fk_producto AND v.pk_venta=? AND v.factura=0 GROUP BY vp.pk_vp";
	$statement = $conexion->prepare($sql);
	$statement->bindParam(1,$_POST['venta_id']);
	$statement->execute();
	if ($statement->rowCount()>0) {
		echo json_encode($statement->fetchAll());
	}else{
		echo "false";
	}
	$statement->closeCursor();
}else{
	echo "false";
}

?>