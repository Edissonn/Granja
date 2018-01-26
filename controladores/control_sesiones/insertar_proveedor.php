<?php

$obj_conexion = new Conexion();
$conexion = $obj_conexion->conectar();

$nombre = $_POST['nombre'];

$sql = "INSERT INTO provedor VALUES(NULL,?)";
$insert_usuarios = $conexion->prepare($sql);
$insert_usuarios -> bindParam(1,$nombre);

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
