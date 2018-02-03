<?php
session_start();

//Se establece la zona horaria por defecto
date_default_timezone_set("America/Bahia_Banderas");

require_once('../conexion.php');
$obj_conexion = new Conexion();
$conexion = $obj_conexion->conectar();

if ((isset($_SESSION['pk_admin']) || isset($_SESSION['pk_usuario'])) && (isset($_SESSION['nombre_admin']) || isset($_SESSION['nombre_user'])) && !isset($_POST['pk_venta'])) {

	//Insertar con datos de usuario
	if (isset($_POST['pk_cliente'])) {
		$pk_usuario = $_POST['pk_usuario'];
		$total = $_POST['total'];
		$estado = 1;
		$pk_cliente = $_POST['pk_cliente'];
		$cantPago = $_POST['cantPago'];
		$cambio = $_POST['cambio'];
		$factura = $_POST['factura'];

		$sql = "INSERT INTO venta VALUES(NULL,NOW(),NOW(),?,?,?,?,?,?,?)";
		$insertar_venta = $conexion->prepare($sql);
		$insertar_venta -> bindParam(1,$total);
		$insertar_venta -> bindParam(2,$estado);
		$insertar_venta -> bindParam(3,$pk_usuario);
		$insertar_venta -> bindParam(4,$pk_cliente);
		$insertar_venta -> bindParam(5,$cantPago);
		$insertar_venta -> bindParam(6,$cambio);
		$insertar_venta -> bindParam(7,$factura);
		$insertar_venta -> execute();
		$resultado = $insertar_venta->rowCount();
		if ($resultado>0){
			$idAutoincrement = $conexion->lastInsertId();
			echo $idAutoincrement;
		}else{
			echo "false";
		}
		$insertar_venta->closeCursor();
	}else if(!isset($_POST['pk_cliente'])){
		//Insertar sin datos de usuario
		$pk_usuario = $_POST['pk_usuario'];
		$total = $_POST['total'];
		$estado = 1;
		$cantPago = $_POST['cantPago'];
		$cambio = $_POST['cambio'];
		$factura = $_POST['factura'];

		$sql = "INSERT INTO venta VALUES(NULL,NOW(),NOW(),?,?,?,NULL,?,?,?)";
		$insertar_venta = $conexion->prepare($sql);
		$insertar_venta -> bindParam(1,$total);
		$insertar_venta -> bindParam(2,$estado);
		$insertar_venta -> bindParam(3,$pk_usuario);
		$insertar_venta -> bindParam(4,$cantPago);
		$insertar_venta -> bindParam(5,$cambio);
		$insertar_venta -> bindParam(6,$factura);
		$insertar_venta -> execute();
		$resultado = $insertar_venta->rowCount();
		if ($resultado>0){
			$idAutoincrement = $conexion->lastInsertId();
			echo $idAutoincrement;
		}else{
			echo "false";
		}
		$insertar_venta->closeCursor();
	}
}

if ((isset($_SESSION['pk_admin']) || isset($_SESSION['pk_usuario'])) && (isset($_SESSION['nombre_admin']) || isset($_SESSION['nombre_user'])) && isset($_POST['pk_venta'])) {

	//Buscar en venta_producto los los PKs y cantidades correspondientes a la venta
		//Reccorres y buscar unu a uno, en la tabla de productos para ver si el Stock cubre la cantidad deseada
			//Si todas lac antidades de los productos se pueden cibrir con el Stock existente, realizar la compra
				//Ir a disminuir el stock de cada producto comprado
					//Actualizar el campo de factura a 0, en la tabla de venta
			//Si no, Informar al usuario en que producto no se cubre la cantidad requerida

	$sql_vp_p = "SELECT vp.cant_producto,vp.fk_producto,p.stok,p.nombre FROM venta_producto vp, producto p WHERE vp.fk_producto=p.pk_producto AND fk_venta=? AND pk_producto IN (SELECT venta_producto.fk_producto FROM venta_producto WHERE venta_producto.fk_venta=?) GROUP BY vp.fk_producto";
	$statement_vp = $conexion->prepare($sql_vp_p);
	$statement_vp->bindParam(1,$_POST['pk_venta']);
	$statement_vp->bindParam(2,$_POST['pk_venta']);
	$statement_vp->execute();

	$mensaje = "";
	if ($statement_vp->rowCount()>0) {
		$res_vp = $statement_vp->fetchAll();
		//Validar uno a uno las cantidades deceadas de los productos, contra el Stock de cada uno
		foreach ($res_vp as $resvp) {
			if ($resvp['cant_producto']>$resvp['stok']) {
				$mensaje = "No hay Stock suficiente para el producto: ".$resvp['nombre'].", solo quedan: ".$resvp['stok'];
				break;
			}
		}

		//Ir a disminuir el stock de cada producto adquirido
		if ($mensaje=="") {
			foreach ($res_vp as $resvp) {
				$sql_resStok = "UPDATE producto SET stok=(stok-?) WHERE pk_producto=?";
				$statement_p = $conexion->prepare($sql_resStok);
				$statement_p -> bindParam(1,$resvp['cant_producto']);
				$statement_p -> bindParam(2,$resvp['fk_producto']);
				$statement_p -> execute();
				$statement_p -> closeCursor();
			}

			//Actualizar el campo factura a 0, en la table venta
			$sql = "UPDATE venta SET factura=0 WHERE pk_venta=?";
			$update_factura = $conexion->prepare($sql);
			$update_factura -> bindParam(1,$_POST['pk_venta']);
			$update_factura -> execute();
			if ($update_factura->rowCount()>0) {
				echo "true";
			}else{
				echo "false";
			}
			$update_factura->closeCursor();
		}else{
			echo $mensaje;
		}
	}else{
		echo "false";
	}
	$statement_vp->closeCursor();
}