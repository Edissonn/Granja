<?php
session_start();
if (isset($_SESSION['pk_admin']) && isset($_SESSION['nombre_admin'])) {

	include('../conexion.php');
	$obj_conexion = new Conexion();
	$conexion = $obj_conexion->conectar();

	//Se valida si se ha recibido una imagen desde el envio del formulario
	if ($_FILES['file_img']['tmp_name'] != null) {

		//Validar si ya hay un registro con el mismo nombre y codigo de barras en la base de datos
		$sql_validar = "SELECT pk_producto FROM producto WHERE (nombre=? OR codigo_barras=?) AND fk_unidad=?";
		$validarPro = $conexion->prepare($sql_validar);
		$validarPro->bindParam(1,$_POST['nombre']);
		$validarPro->bindParam(2,$_POST['codigo']);
		$validarPro->bindParam(3,$_POST['unidad_medida']);
		$validarPro->execute();
		if ($validarPro->rowCount()==0) {

			//Obtener todos los datos enviados del formulario
			$nombre = $_POST['nombre'];
			$codigo = $_POST['codigo'];
			$precio = $_POST['precio'];
			$categoria = $_POST['categoria'];
			$importe = $_POST['importe'];
			$ganancia = $_POST['precioProveedor'];
			$unidad = $_POST['unidad_medida'];
			$cant_producto = $_POST['cantidadProducto'];
			$provedor = $_POST['proveedor'];
			$stok = "0";
			$estado = "1";

			//Proceso para subir la imagen al servidor
			$anio = date("Y");
			$mes = date("m");
			$dia = date("d");
			$hora = date("H");
			$minuto = date("m");
			$segundo = date("s");
			$NombreOriginal = "";
			$ruta = "../img_productos/";
			foreach ($_FILES as $key) {
				if ($key['error'] == UPLOAD_ERR_OK) {
					$NombreOriginal = $anio.$mes.$dia.$hora.$minuto.$segundo.$key['name'];
					$ruta_absoluta = $ruta.$NombreOriginal;
					$temporal = $key['tmp_name'];
					$tipo = $key['type'];
					if (!(strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png"))) {
						echo "
						<meta http-equiv='REFRESH' content='0 ; url=../admin/index.php'>
						<script>alert('Solo se aceptan imagenes JPEG, JPG, PNG!!, vuelva a intertarlo de nuevo.');</script>";
					}else{
						$rutaDestino = $ruta.$NombreOriginal;

						move_uploaded_file($temporal, $rutaDestino);

						$sql = "";
						if ($provedor=="") {
							$sql="INSERT INTO producto VALUES(NULL,?,?,?,?,?,?,?,?,?,?,NULL,?)";
						}else{
							$sql="INSERT INTO producto VALUES(NULL,?,?,?,?,?,?,?,?,?,?,?,?)";
						}

						$insert_usuarios=$conexion->prepare($sql);
						if ($provedor=="") {

							$insert_usuarios-> bindParam(1,$nombre);

							$insert_usuarios-> bindParam(2,$NombreOriginal);

							$insert_usuarios-> bindParam(3,$codigo);
							$insert_usuarios-> bindParam(4,$precio);
							$insert_usuarios-> bindParam(5,$categoria);
							$insert_usuarios-> bindParam(6,$stok);
							$insert_usuarios-> bindParam(7,$importe);
							$insert_usuarios-> bindParam(8,$ganancia);
							$insert_usuarios-> bindParam(9,$unidad);
							$insert_usuarios-> bindParam(10,$cant_producto);
							$insert_usuarios-> bindParam(11,$estado);

						}else{

							$insert_usuarios-> bindParam(1,$nombre);

							$insert_usuarios-> bindParam(2,$NombreOriginal);

							$insert_usuarios-> bindParam(3,$codigo);
							$insert_usuarios-> bindParam(4,$precio);
							$insert_usuarios-> bindParam(5,$categoria);
							$insert_usuarios-> bindParam(6,$stok);
							$insert_usuarios-> bindParam(7,$importe);
							$insert_usuarios-> bindParam(8,$ganancia);
							$insert_usuarios-> bindParam(9,$unidad);
							$insert_usuarios-> bindParam(10,$cant_producto);
							$insert_usuarios-> bindParam(11,$provedor);
							$insert_usuarios-> bindParam(12,$estado);
							
						}
					//Se ejecuta la peticion a la base de datos
						$insert_usuarios->execute();

						if ($insert_usuarios->rowCount()>0){
							echo "<html>
							<head>
								<meta http-equiv = 'REFRESH' content='0 ; ../admin/index.php'>
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
								<meta http-equiv = 'REFRESH' content='0 ; url=../admin/index.php'>
							</head>
							<body>

								<script>
									alert('No se guardaron los datos :(');
								</script>
							</body>
							</html>
							";
						}
						$insert_usuarios->closeCursor();
					}
				}
			}
		}else{
			echo "
			<meta http-equiv='REFRESH' content='0 ; url=../admin/index.php'>
			<script>alert('El producto \"".$_POST['nombre']."\" ya se encuentra registrado en el sistema!!');</script>";
		}
	}
}else{
	header("location: ../admin/index.php");
}

?>