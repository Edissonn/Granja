<?php
session_start();
if (isset($_SESSION['pk_admin']) && isset($_SESSION['nombre_admin'])) {
	//Se establece la zona horaria por defecto
	date_default_timezone_set("America/Bahia_Banderas");

	require_once('../conexion.php');
	$obj_conexion = new Conexion();
	$conexion = $obj_conexion->conectar();

	//Insertar con datos de usuario
	if (isset($_POST['pk_producto']) && isset($_POST['pk_venta'])) {

		$cant_producto = $_POST['cant_producto'];
		$cant_importe = $_POST['cant_importe'];
		$pk_producto = $_POST['pk_producto'];
		$pk_venta = $_POST['pk_venta'];

		$sql = "INSERT INTO venta_producto VALUES(NULL,?,?,?,?)";
		$insertar_ventaP = $conexion->prepare($sql);
		$insertar_ventaP -> bindParam(1,$cant_producto);
		$insertar_ventaP -> bindParam(2,$cant_importe);
		$insertar_ventaP -> bindParam(3,$pk_producto);
		$insertar_ventaP -> bindParam(4,$pk_venta);
		$insertar_ventaP -> execute();
		if ($insertar_ventaP->rowCount()>0){
			echo "true";
		}else{
			echo "false";
		}
		$insertar_ventaP->closeCursor();
	}
}