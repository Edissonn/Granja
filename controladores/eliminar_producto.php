<?php
session_start();
if (isset($_SESSION['pk_admin']) && isset($_SESSION['nombre_admin']) && isset($_POST['pk_producto'])) {
	include('../conexion.php');
	$obj_conexion = new Conexion();
	$conexion = $obj_conexion->conectar();

	$sql = "UPDATE producto SET estado=0 WHERE pk_producto=?";
	$statement = $conexion->prepare($sql);
	$statement->bindParam(1,$_POST['pk_producto']);
	$statement->execute();
	if ($statement->rowCount()>0) {
		echo "true";
	}else{
		echo "false";
	}
	$statement->closeCursor();
}
?>