<?php

session_start();	
if (isset($_POST['password']) && isset($_POST['user'])) {

	include('conexion.php');
	$obj_conexion=new Conexion();
	$conexion=$obj_conexion->conectar();

	$password = $_POST['password'];
	$user = $_POST['user'];

	$sql = "SELECT * FROM usuarios WHERE nombre=? AND contrasenia=?";
	$statemnet = $conexion->prepare($sql);
	$statemnet->bindParam(1, $user);
	$statemnet->bindParam(2, $password);
	$statemnet->execute();
	$res = $statemnet->fetch();
	if ($res) {
		$_SESSION['id_usuarios'] = $res['id_usuarios'];
		$_SESSION['nombre'] = $res['nombre'];
		header("location: products.php");
	}else{
		header("location: index.php");
	}

}else{
	header("location: index.php");
}
?>