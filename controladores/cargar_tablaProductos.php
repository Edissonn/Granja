<?php
//SELECT p.pk_producto,p.ruta_img,p.nombre,p.codigo_barras,c.nom_categoria,p.precio,p.importe,p.ganancia,p.stok,u.unidad,p.cant_producto FROM producto p, categoria c, unidad_medida u WHERE p.fk_categoria=c.pk_categoria AND p.fk_unidad=u.pk_unidad
session_start();
if(!isset($_SESSION['pk_admin']) && !isset($_SESSION['nombre_admin']))
{
	header("location:../admin/index.php");
}else{
	require_once("../conexion.php");

	$obj_conexion = new Conexion();
	$conexion = $obj_conexion->conectar();

	$sql = "SELECT p.pk_producto,p.ruta_img,p.nombre,p.codigo_barras,c.nom_categoria,p.precio,p.importe,p.precioProveedor,p.stok,u.unidad,p.cant_producto FROM producto p, categoria c, unidad_medida u WHERE p.fk_categoria=c.pk_categoria AND p.fk_unidad=u.pk_unidad AND p.estado=1";

	$result = $conexion->prepare($sql);

	if (!$result->execute()) return false;

	if ($result->rowCount() > 0) {
		while ($row = $result->fetch()) {
			$arreglo["data"][]=$row;
		}
		echo json_encode($arreglo);
	}else{
		echo "No hay piezas registradas!";
	}
	$result->closeCursor();
}


?>