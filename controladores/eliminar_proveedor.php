<?php
session_start();
if (isset($_SESSION['pk_admin']) && isset($_SESSION['nombre_admin'])) {
	include('../conexion.php');
	$obj_conexion = new Conexion();
	$conexion = $obj_conexion->conectar();

	$sql = "UPDATE provedor SET estado=0 WHERE pk_provedor=?";
	$statement = $conexion->prepare($sql);
	$statement->bindParam(1,$_POST['pk_provedor']);
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