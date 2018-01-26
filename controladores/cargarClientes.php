<?php
session_start();
if(!isset($_SESSION['pk_admin']) && !isset($_SESSION['nombre_admin']))
{
	header("location:../admin/index.php");
}else{
	require_once("../conexion.php");

	$obj_conexion = new Conexion();
	$conexion = $obj_conexion->conectar();

	$sql = "SELECT c.pk_cliente, c.nombre_cliente, c.edad, c.telefono_cel, c.telefono_casa, c.nombre_local, l.nombre, c.calle_ave, c.descripccion FROM cliente c, localidad l WHERE l.pk_localidad=c.fk_localidad AND estado=1";

	$result = $conexion->prepare($sql);

	if (!$result->execute()) return false;

	if ($result->rowCount() > 0) {
		while ($row = $result->fetch()) {
			$arreglo["data"][]=$row;
		}
		echo json_encode($arreglo);
	}else{
		echo "No hay clientes registrados!";
	}
	$result->closeCursor();
}


?>