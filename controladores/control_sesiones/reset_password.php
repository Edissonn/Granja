<?php
require_once('encryption.php');
require_once('desencryption.php');

//Se agrega la conexion de PDO
require_once('../../conexion.php');
//Se crea la instancia y el objeto de la clase conexion, para ejecutar las peticiones a la base de datos
$obj_conexion = new Conexion();
$conexion = $obj_conexion->conectar();

if (isset($_POST['correo'])) {

	$sql = "SELECT pk_usuario,correo, CONCAT(nombre,' ',apellidos) AS nombre FROM usuario WHERE correo=?";
	$statement  = $conexion->prepare($sql);
	$statement->bindParam(1,$_POST['correo']);
	$statement->execute();
	if ($statement->rowCount()>0) {

		$res = $statement->fetchAll();
		$correo = $res[0]['correo'];
		$nombre = $res[0]['nombre'];
		$encryp_pkusuario = encrypt($res[0]['pk_usuario']);
		$new_password = encrypt(generaPass());
		$email = encrypt($res[0]['correo']);

		$link = 'http://universitytests.esy.es/Granja/controladores/control_sesiones/reset_password.php?resciv='.$new_password.'&uspk='.$encryp_pkusuario.'&emcor='.$email;
		$mensaje = '<html>
		<head>
			<title>Restablece tu contraseña</title>
		</head>
		<body>
			<h1>Hola: '.$nombre.'</h1>
			<p>Hemos recibido una petición para restablecer la contraseña de tu cuenta.</p>
			<p>Si hiciste esta petición, haz clic en el siguiente enlace, si no hiciste esta petición puedes ignorar este correo.</p>
			<p>
				<strong>Haga click sobre este enlace para restablecer tu contraseña</strong><br>
				<a href="'.$link.'"> Restablecer contraseña </a>
			</p>
		</body>
		</html>';

		$cabeceras = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$cabeceras .= 'From: El Paraiso <jumper_linkin@hotmail.com>' . "\r\n";
    	//Se envia el correo al usuario
		mail($correo, "Recuperar contraseña", $mensaje, $cabeceras);
		
	}else{
		echo "El correo no pertenece a ningun usuario del sistema!";
	}
}else if (isset($_GET['resciv']) && isset($_GET['uspk']) && isset($_GET['emcor'])) {

	$pk_usuario = decrypt($_GET['uspk']);
	$pass = decrypt($_GET['resciv']);
	$correo = decrypt($_GET['emcor']);

	$sql = "UPDATE usuario SET contrasenia=? WHERE pk_usuario=?";
	$statement  = $conexion->prepare($sql);
	$statement->bindParam(1,$pass);
	$statement->bindParam(2,$pk_usuario);
	$statement->execute();
	if ($statement->rowCount()>0) {
		$mensaje = '<html>
		<head>
			<title>Restablece tu contraseña</title>
		</head>
		<body>
			<h1>Hola: '.$nombre.'</h1>
			<p>Hemos actualizado su contraseña exitosamente!</p>
			<p>
				Su nueva contraseña es: 
				<strong>'.$pass.'</strong><br>
			</p>
			<p>Ahora puede iniciar sesion con esta contraseña he ir al panel de configuracion y actualizarla por una personalizada.</p>
		</body>
		</html>';

		$cabeceras = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$cabeceras .= 'From: El Paraiso <jumper_linkin@hotmail.com>' . "\r\n";
    	//Se envia el correo al usuario
		mail($correo, "Recuperar contraseña", $mensaje, $cabeceras);
	}else{
		echo "Error al actualizar la contraseña!";
	}
}

//Funcion para generar el token de la session
function generaPass(){
	$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
	$longitudCadena=strlen($cadena);
	$pass = "";
	$longitudPass=8;
	for($i=1 ; $i<=$longitudPass ; $i++){
		$pos=rand(0,$longitudCadena-1);
		$pass .= substr($cadena,$pos,1);
	}
	return $pass;
}
?>