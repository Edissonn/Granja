<?php 
//Validar si han llegado los datos desde el formulario
if (isset($_POST['user']) && isset($_POST['pass'])) {

	//Se establece la zona horaria por defecto
	date_default_timezone_set("America/Bahia_Banderas");

	//Se incluye el archivo de conexion.php
	require_once("../../conexion.php");

	//Se almacenan los valores recibidos
	$user = $_POST['user'];
	$pass = $_POST['pass'];

	//Se crea la instancia y el objeto para la conexion a la base de datos
	$objet_conexion = new Conexion();
	$conexion = $objet_conexion->conectar();

	//Preparar la consulta de login
	$sql = "SELECT * FROM usuario WHERE correo=? AND contrasenia=?";
	$sentencia = $conexion->prepare($sql);
	//Se pasan los parametros a la consulta (user, pass)
	$sentencia->bindParam(1,$user);
	$sentencia->bindParam(2,$pass);
	$sentencia->execute();
	//Se valida si se encontro un resultado
	if ($sentencia->rowCount()>0) {
		//Se establece el iniciador de session para los usuarios
		session_start();
		//Recojer resultado de la consulta en un arreglo
		$arrayRes = $sentencia->fetchAll();

		//Comprobar que tipo de usuario es, para iniciar Session de usuario o administrador
		if ($arrayRes[0]["tipo_usuario"]=="1") {
			//Inicio session admin, y se manda el nombre completo y su PK
			$nombre = $arrayRes[0]['nombre']." ".$arrayRes[0]['apellidos'];
			$_SESSION['nombre_admin'] = $nombre;
			$_SESSION['pk_admin'] = $arrayRes[0]['pk_usuario'];
			$_SESSION['time_login'] = time();
			$_SESSION['time_incative'] = 600;
			header("location: ../../admin/index.php");
		}else{
			//Inicio session usuario, y se manda el nombre completo y su PK
			$nombre = $arrayRes[0]['nombre']." ".$arrayRes[0]['apellidos'];
			$_SESSION['nombre_user'] = $nombre;
			$_SESSION['pk_usuario'] = $arrayRes[0]['pk_usuario'];
			$_SESSION['time_login'] = time();
			$_SESSION['time_incative'] = 600;
			header("location: ../../user/index.php");
		}
	}else{
		//Si no hay resultado, redireccione al index.php
		echo "Datos Incorrectos!";
	}
	$sentencia->closeCursor();

}else{
	//Si no hay datos, se redirecciona automaticamente al index.php
	header("location: ../../index.php");
}
?>