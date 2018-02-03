<?php
session_start();
require_once('../conexion.php');
$obj_conexion = new Conexion();
$conexion = $obj_conexion->conectar();

//Eliminar la vanta y todos sus productos asociados
if ((isset($_SESSION['pk_admin']) || isset($_SESSION['pk_usuario'])) && (isset($_SESSION['nombre_admin']) || isset($_SESSION['nombre_user'])) && isset($_POST['pk_venta_del'])) {

	$sql_0 = "DELETE FROM venta_producto WHERE fk_venta=?";
	$delete_vp = $conexion->prepare($sql_0);
	$delete_vp -> bindParam(1,$_POST['pk_venta_del']);
	$delete_vp -> execute();
	if ($delete_vp->rowCount()>0) {
		$sql_1 = "DELETE FROM venta WHERE pk_venta=?";
		$delete_v = $conexion->prepare($sql_1);
		$delete_v -> bindParam(1,$_POST['pk_venta_del']);
		$delete_v -> execute();
		if ($delete_v->rowCount()>0) {
			echo "true";
		}else{
			echo "false";
		}
	}else{
		echo "false";
	}
}

//eliminar solo los productos asociados a la venta en la tabla venta_producto
if ((isset($_SESSION['pk_admin']) || isset($_SESSION['pk_usuario'])) && (isset($_SESSION['nombre_admin']) || isset($_SESSION['nombre_user'])) && isset($_POST['pk_venta_p'])) {

	$sql = "DELETE FROM venta_producto WHERE fk_venta=?";
	$delete_vp = $conexion->prepare($sql);
	$delete_vp -> bindParam(1,$_POST['pk_venta_p']);
	$delete_vp -> execute();
	if ($delete_vp->rowCount()>0) {
		echo "true";
	}else{
		echo "false";
	}
}