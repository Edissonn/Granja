<?php

class Conexion{
	public function conectar(){
		$usuarios="root";
		$contrasenia="root";
		$host="localhost";
		$bd="punto_venta";
		$conexion=new PDO("mysql:host=$host;dbname=$bd",$usuarios,$contrasenia);
		return $conexion;
	}
}

?>