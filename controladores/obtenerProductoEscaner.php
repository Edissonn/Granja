<?php
session_start();
require_once("../conexion.php");
$obj_conexion = new Conexion();
$conexion = $obj_conexion->conectar();

if((isset($_SESSION['pk_admin']) || isset($_SESSION['pk_usuario'])) && (isset($_SESSION['nombre_admin']) || isset($_SESSION['nombre_user'])) && isset($_POST['codigoBarras']) && isset($_POST['cantProducto']))
{

	$sql = "SELECT p.pk_producto,p.nombre,p.precio,p.importe,pro.nombre_provedor FROM producto p, provedor pro WHERE p.fk_provedor=pro.pk_provedor AND p.codigo_barras=? AND p.stok>=?";
	$result = $conexion->prepare($sql);
	$result->bindParam(1,$_POST['codigoBarras']);
	$result->bindParam(2,$_POST['cantProducto']);
	$result->execute();
	if ($result->rowCount()>0) {
		$resultado = $result->fetchAll();
		echo json_encode($resultado);
	}else{
		echo "false";
	}
	$result->closeCursor();
}

if((isset($_SESSION['pk_admin']) || isset($_SESSION['pk_usuario'])) && (isset($_SESSION['nombre_admin']) || isset($_SESSION['nombre_user'])) && isset($_POST['pk_producto']) && isset($_POST['cantProducto']))
{
	$sql = "UPDATE producto SET stok=(stok-?) WHERE pk_producto=?";
	$result = $conexion->prepare($sql);
	$result->bindParam(1,$_POST['cantProducto']);
	$result->bindParam(2,$_POST['pk_producto']);
	$result->execute();
	$result->closeCursor();
}


if((isset($_SESSION['pk_admin']) || isset($_SESSION['pk_usuario'])) && (isset($_SESSION['nombre_admin']) || isset($_SESSION['nombre_user'])) && isset($_POST['pk_producto']) && isset($_POST['cantProducto_sum']))
{
	$sql = "UPDATE producto SET stok=(stok+?) WHERE pk_producto=?";
	$result = $conexion->prepare($sql);
	$result->bindParam(1,$_POST['cantProducto_sum']);
	$result->bindParam(2,$_POST['pk_producto']);
	$result->execute();
	$result->closeCursor();
}


?>