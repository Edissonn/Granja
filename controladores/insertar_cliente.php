<?php
session_start();
if (isset($_SESSION['pk_admin']) && isset($_SESSION['nombre_admin']) && isset($_POST['nombre'])) {
	require_once('../conexion.php');
	$obj_conexion = new Conexion();
	$conexion = $obj_conexion->conectar();


	$nombre = $_POST['nombre'];
	$edad = $_POST['edad'];
	$telefonocel = $_POST['telefono'];
	$telefono = $_POST['tel'];
	$nombre_local = $_POST['nombre_local'];
	$localidad = $_POST['localidad'];
	$calle_ave = $_POST['calle_ave'];
	$descripcion = $_POST['descripcion'];
	$estado = "1";

	$sql = "INSERT INTO cliente VALUES(NULL,?,?,?,?,?,?,?,?,?)";
	$insert_usuarios = $conexion->prepare($sql);
	$insert_usuarios -> bindParam(1,$nombre);
	$insert_usuarios -> bindParam(2,$edad);
	$insert_usuarios -> bindParam(3,$telefonocel);
	$insert_usuarios -> bindParam(4,$telefono);
	$insert_usuarios -> bindParam(5,$nombre_local);
	$insert_usuarios -> bindParam(6,$localidad);
	$insert_usuarios -> bindParam(7,$calle_ave);
	$insert_usuarios -> bindParam(8,$descripcion);
	$insert_usuarios -> bindParam(9,$estado);

	$insert_usuarios -> execute();
	$resultado = $insert_usuarios->rowCount();


	if ($resultado>0) 
	{
		echo "<html>
		<head>
			<meta http-equiv = 'REFRESH' content='0 ; url=../admin/cliente.php'>
		</head>
		<body >
			<script>
				alert('Datos Guardados Con Exito');
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
				alert('No se guardaron los datos :(');
			</script>
		</body>
		</html>
		";
	}
}