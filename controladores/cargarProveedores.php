<?php
session_start();
if(!isset($_SESSION['pk_admin']) && !isset($_SESSION['nombre_admin']))
{
	header("location:../admin/index.php");
}else{
	require_once("../conexion.php");

	$obj_conexion = new Conexion();
	$conexion = $obj_conexion->conectar();

	$sql = "SELECT pk_provedor,nombre_provedor FROM provedor WHERE estado=1";

	$result = $conexion->prepare($sql);

	if (!$result->execute()) return false;

	if ($result->rowCount() > 0) {
		while ($row = $result->fetch()) {
			$arreglo["data"][]=$row;
		}
		echo json_encode($arreglo);
	}else{
		echo "No hay proveedores registrados!";
	}
	$result->closeCursor();
}


?>