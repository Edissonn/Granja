<?php
session_start();
if (isset($_SESSION['pk_admin']) && isset($_SESSION['nombre_admin'])) {
	require_once('../conexion.php');
	$obj_conexion = new Conexion();
	$conexion = $obj_conexion->conectar();


	$pk_cliente = $_POST['pkCliente'];
	$nombre = $_POST['nombreCliente'];
	$edad = $_POST['edadCliente'];
	$telefonocel = $_POST['telefonoCliente'];
	$telefono = $_POST['telCliente'];
	$nombre_local = $_POST['nombre_localCliente'];
	$localidad = $_POST['localidadCliente'];
	$calle_ave = $_POST['calle_aveCliente'];
	$descripcion = $_POST['descripcionCliente'];

	$sql = "UPDATE cliente SET nombre_cliente=?,edad=?,telefono_cel=?,telefono_casa=?,nombre_local=?,	fk_localidad=?,calle_ave=?,descripccion=? WHERE pk_cliente=?";
	$actializarCliente = $conexion->prepare($sql);
	$actializarCliente -> bindParam(1,$nombre);
	$actializarCliente -> bindParam(2,$edad);
	$actializarCliente -> bindParam(3,$telefonocel);
	$actializarCliente -> bindParam(4,$telefono);
	$actializarCliente -> bindParam(5,$nombre_local);
	$actializarCliente -> bindParam(6,$localidad);
	$actializarCliente -> bindParam(7,$calle_ave);
	$actializarCliente -> bindParam(8,$descripcion);
	$actializarCliente -> bindParam(9,$pk_cliente);

	$actializarCliente -> execute();
	$resultado = $actializarCliente->rowCount();


	if ($resultado>0) 
	{
		echo "<html>
		<head>
			<meta http-equiv = 'REFRESH' content='0 ; url=../admin/cliente.php'>
		</head>
		<body >
			<script>
				alert('Datos Actualizados Con Exito');
			</script>
		</body>
		</html>
		";
	}else{
		echo "<html>
		<head>	
			<meta http-equiv = 'REFRESH' content='0 ; url=../admin/cliente.php'>
		</head>
		<body>

			<script>
				alert('No se Actualizaron los datos :(');
			</script>
		</body>
		</html>
		";
	}
	$actializarCliente->closeCursor();
}