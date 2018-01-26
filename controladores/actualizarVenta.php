<?php
session_start();

//Se establece la zona horaria por defecto
date_default_timezone_set("America/Bahia_Banderas");

require_once('../conexion.php');
$obj_conexion = new Conexion();
$conexion = $obj_conexion->conectar();

if (isset($_SESSION['pk_admin']) && isset($_SESSION['nombre_admin']) && isset($_POST['pk_venta'])) {

	//Insertar con datos de usuario
	if (isset($_POST['pk_cliente'])) {
		$pk_usuario = $_POST['pk_usuario'];
		$total = $_POST['total'];
		$estado = 1;
		$pk_cliente = $_POST['pk_cliente'];
		$factura = $_POST['factura'];

		$sql = "UPDATE venta SET fecha=NOW(),hora=NOW(),total=?,estado=?,fk_usuario=?,fk_cliente=?,factura=? WHERE pk_venta=?";
		$insertar_venta = $conexion->prepare($sql);
		$insertar_venta -> bindParam(1,$total);
		$insertar_venta -> bindParam(2,$estado);
		$insertar_venta -> bindParam(3,$pk_usuario);
		$insertar_venta -> bindParam(4,$pk_cliente);
		$insertar_venta -> bindParam(5,$factura);
		$insertar_venta -> bindParam(6,$_POST['pk_venta']);
		$insertar_venta -> execute();
		if ($insertar_venta->rowCount()>0){
			echo "true";
		}else{
			echo "false";
		}
		$insertar_venta->closeCursor();
	}else if(!isset($_POST['pk_cliente'])){
		//Insertar sin datos de usuario
		$pk_usuario = $_POST['pk_usuario'];
		$total = $_POST['total'];
		$estado = 1;
		$factura = $_POST['factura'];

		$sql = "UPDATE venta SET fecha=NOW(),hora=NOW(),total=?,estado=?,fk_usuario=?,factura=? WHERE pk_venta=?";
		$insertar_venta = $conexion->prepare($sql);
		$insertar_venta -> bindParam(1,$total);
		$insertar_venta -> bindParam(2,$estado);
		$insertar_venta -> bindParam(3,$pk_usuario);
		$insertar_venta -> bindParam(4,$factura);
		$insertar_venta -> bindParam(5,$_POST['pk_venta']);
		$insertar_venta -> execute();
		if ($insertar_venta->rowCount()>0){
			echo "true";
		}else{
			echo "false";
		}
		$insertar_venta->closeCursor();
	}
}
?>