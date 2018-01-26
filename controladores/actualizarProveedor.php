<?php
session_start();
if (isset($_SESSION['pk_admin']) && isset($_SESSION['nombre_admin'])) {
	require_once('../conexion.php');
	$obj_conexion = new Conexion();
	$conexion = $obj_conexion->conectar();


	$nombreProveedor = $_POST['nombreProveedor'];
	$pk_proveedor = $_POST['pk_proveedor'];

	$sql = "UPDATE provedor SET nombre_provedor=? WHERE pk_provedor=?";
	$updateProveedor = $conexion->prepare($sql);
	$updateProveedor -> bindParam(1,$nombreProveedor);
	$updateProveedor -> bindParam(2,$pk_proveedor);

	$updateProveedor -> execute();
	$resultado = $updateProveedor->rowCount();


	if ($resultado>0) 
	{
		echo "<html>
		<head>
			<meta http-equiv = 'REFRESH' content='0 ; url=../admin/proveedores.php'>
		</head>
		<body >
			<script>
				alert('Datos Actualizados Con Exito');
			</script>
		</body>
		</html>
		";
	// echo 'bien';
	}else{
		echo "<html>
		<head>	
			<meta http-equiv = 'REFRESH' content='0 ; url=../admin/proveedores.php'>
		</head>
		<body>

			<script>
				alert('No se actualizado los datos :(');
			</script>
		</body>
		</html>
		";
	}
	$updateProveedor->closeCursor();
}