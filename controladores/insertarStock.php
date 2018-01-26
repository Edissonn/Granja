<?php
session_start();
if (isset($_SESSION['pk_admin']) && isset($_SESSION['nombre_admin']) && isset($_POST['pk_producto']) && isset($_POST['pk_proveedor']) && isset($_POST['cantidadProveedor'])) {
	require_once('../conexion.php');
	$obj_conexion = new Conexion();
	$conexion = $obj_conexion->conectar();

	$sql1 = "INSERT INTO producto_provedor VALUES(NULL,?,?,NOW(),?)";
	$sentencia1 = $conexion->prepare($sql1);
	$sentencia1->bindParam(1,$_POST['pk_producto']);
	$sentencia1->bindParam(2,$_POST['pk_proveedor']);
	$sentencia1->bindParam(3,$_POST['cantidadProveedor']);
	$sentencia1->execute();
	if ($sentencia1->rowCount()>0) {
		$sql2 = "UPDATE producto SET stok=(stok+?) WHERE pk_producto=?";
		$sentencia2 = $conexion->prepare($sql2);
		$sentencia2->bindParam(1,$_POST['cantidadProveedor']);
		$sentencia2->bindParam(2,$_POST['pk_producto']);
		$sentencia2->execute();
		if ($sentencia2->rowCount()>0) {
			echo "<html>
			<head>
				<meta http-equiv = 'REFRESH' content='0 ; ../admin/index.php'>
			</head>
			<body >
				<script>
					alert('Stock aumentado con exito!');
				</script>
			</body>
			</html>
			";
		}
	}else{
		echo "<html>
		<head>
			<meta http-equiv = 'REFRESH' content='0 ; ../admin/index.php'>
		</head>
		<body >
			<script>
				alert('Error al aumentar Stock!');
			</script>
		</body>
		</html>
		";
	}
	$sentencia1->closeCursor();
}else{
	echo "<html>
		<head>
			<meta http-equiv = 'REFRESH' content='0 ; ../admin/index.php'>
		</head>
		<body >
			<script>
				alert('Error al aumentar Stock!');
			</script>
		</body>
		</html>
		";
}
?>