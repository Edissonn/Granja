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
}elseif (isset($_SESSION['pk_admin']) && isset($_SESSION['nombre_admin']) && isset($_POST['day']) && isset($_POST['hora']) && isset($_POST['minutos']) && isset($_POST['turno'])) {

	$array_dias = ['l' => 'Lunes', 'm' => 'Martes', 'mi' => 'Miercoles', 'j' => 'Jueves', 'v' => 'Viernes', 's' => 'Sabado', 'd' => 'Domingo'];
	$array_diasSelected = [];
	foreach ($array_dias as $key => $value) {
		foreach ($_POST['day'] as $val) {
			if ($key==$val) {
				array_push($array_diasSelected, $val);
			}
		}
	}
	$horas = $_POST['hora'];
	$minutos = $_POST['minutos'];
	$turno = $_POST['turno'];

	$res = writeConfCortes($array_diasSelected, $horas, $minutos, $turno);
	if ($res=="true") {
		echo "<html>
		<head>	
			<meta http-equiv = 'REFRESH' content='0 ; url=../admin/config.php'>
		</head>
		<body>

			<script>
				alert('Los cambios han sido guardados con exito :)');
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
}else{
	echo "<html>
	<head>	
		<meta http-equiv = 'REFRESH' content='0 ; url=../admin/config.php'>
	</head>
	<body>
	</body>
	</html>";
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

function writeConfCortes($days, $hora, $minuto, $turno)
{
	$arrayJSON = ['days' => $days, 'hora' => $hora, 'minuto' => $minuto, 'turno' => $turno];
	if (fopen('../admin/confCortes.txt', 'w+')) {
		$archivo = fopen('../admin/confCortes.txt', 'w+');
		fwrite($archivo, json_encode($arrayJSON));
		return "true";
	}else{
		return "false";
	}
}
?>