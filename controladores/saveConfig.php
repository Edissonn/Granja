<?php
session_start();
if(isset($_SESSION['pk_admin']) && isset($_SESSION['nombre_admin']) && isset($_POST['time_activity']))
{
	$base = 60;
	$timeSession = ($_POST['time_activity']*$base);
	if (write($timeSession)=="true") {
		echo "<html>
		<head>	
			<meta http-equiv = 'REFRESH' content='0 ; url=../admin/config.php'>
		</head>
		<body>

			<script>
				alert('El tiempo de session ha sido gurdado con exito!');
			</script>
		</body>
		</html>
		";
	}else{
		echo "<html>
		<head>	
			<meta http-equiv = 'REFRESH' content='0 ; url=../admin/config.php'>
		</head>
		<body>

			<script>
				alert('Opps, ha ocurrido un error al guardar los cambiso :(');
			</script>
		</body>
		</html>
		";
	}
}

function write($time_activity)
{
	if (fopen('../admin/timeSession.txt', 'w+')) {
		$archivo = fopen('../admin/timeSession.txt', 'w+');
		fwrite($archivo, $time_activity);
		return "true";
	}else{
		return "false";
	}
}
?>