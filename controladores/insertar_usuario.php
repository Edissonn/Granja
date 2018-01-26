<?php

if (isset($_POST['nombre']) && isset($_POST['apellidos']) && isset($_POST['correo']) && isset($_POST['contrasenia']) && isset($_POST['tipo_usuario'])) {
	require_once('../conexion.php');

	$obj_conexion = new Conexion();
	$conexion = $obj_conexion->conectar();

	$nombre = $_POST['nombre'];
	$apellido = $_POST['apellidos'];
	$correo = $_POST['correo'];
	$contrasenia = $_POST['contrasenia'];
	$tipo_usuario = $_POST['tipo_usuario'];

	$sql = "INSERT INTO usuario VALUES(NULL,?,?,?,?,?)";
	$insert_usuarios = $conexion->prepare($sql);
	$insert_usuarios -> bindParam(1,$nombre);
	$insert_usuarios -> bindParam(2,$apellido);
	$insert_usuarios -> bindParam(3,$correo);
	$insert_usuarios -> bindParam(4,$contrasenia);
	$insert_usuarios -> bindParam(5,$tipo_usuario);

	$insert_usuarios -> execute();
	$resultado = $insert_usuarios->rowCount();


	if ($resultado>0) 
	{
		echo "<html>
		<head>
			<meta http-equiv = 'REFRESH' content='0 ; url=../admin/index.php'>
		</head>
		<body >
			<script>
				alert('Datos Guardados Con Exito');
			</script>
		</body>
		</html>
		";
	// echo 'bien';
	}else{
		echo "<html>
		<head>	
			<meta http-equiv = 'REFRESH' content='0 ; url=../admin/index.php'>
		</head>
		<body>

			<script>
				alert('No se guardaron los datos :(');
			</script>
		</body>
		</html>
		";
	// echo 'mal';
	}

}else{

}
