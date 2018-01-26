<?php
session_start();
if (isset($_SESSION['pk_admin']) && isset($_SESSION['nombre_admin']) && isset($_POST['pk_cliente'])) {
	include('../conexion.php');
	$obj_conexion = new Conexion();
	$conexion = $obj_conexion->conectar();

	$sql = "UPDATE cliente SET estado=0 WHERE pk_cliente=?";
	$statement = $conexion->prepare($sql);
	$statement->bindParam(1,$_POST['pk_cliente']);
	$statement->execute();
	if ($statement->rowCount()>0) {
		echo "true";
	}else{
		echo "false";
	}
	$statement->closeCursor();
}else{
	echo "false";
}
?>