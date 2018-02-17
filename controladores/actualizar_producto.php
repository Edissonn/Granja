<?php
session_start();
if (isset($_SESSION['pk_admin']) && isset($_SESSION['nombre_admin'])) {

	include('../conexion.php');
	$obj_conexion = new Conexion();
	$conexion = $obj_conexion->conectar();

	//Obtener todos los datos enviados del formulario
	$pk_productoP = $_POST['pk_productoP'];
	$nombreProducto = $_POST['nombreProducto'];
	$codigoProducto = $_POST['codigoProducto'];
	$precioProducto = $_POST['precioProducto'];
	$importeProducto = $_POST['importeProducto'];
	$unidadMProducto = $_POST['unidadMProducto'];
	$cantProducto = $_POST['cantProducto'];
	$categoriaProducto = $_POST['categoriaProducto'];
	$precioProveedorP = $_POST['precioProveedorP'];
	$proveedorProducto = $_POST['proveedorProducto'];


	$sql="UPDATE producto SET nombre=?,codigo_barras=?,precio=?,fk_categoria=?,importe=?,precioProveedor=?,	fk_unidad=?,cant_producto=?,fk_provedor=? WHERE pk_producto=?";


	$updateProducto=$conexion->prepare($sql);

	$updateProducto-> bindParam(1,$nombreProducto);
	$updateProducto-> bindParam(2,$codigoProducto);
	$updateProducto-> bindParam(3,$precioProducto);
	$updateProducto-> bindParam(4,$categoriaProducto);
	$updateProducto-> bindParam(5,$importeProducto);
	$updateProducto-> bindParam(6,$precioProveedorP);
	$updateProducto-> bindParam(7,$unidadMProducto);
	$updateProducto-> bindParam(8,$cantProducto);
	$updateProducto-> bindParam(9,$proveedorProducto);
	$updateProducto-> bindParam(10,$pk_productoP);
	//Se ejecuta la peticion a la base de datos
	$updateProducto->execute();

	if ($updateProducto->rowCount()>0){
		echo "<html>
		<head>
			<meta http-equiv = 'REFRESH' content='0 ; url=../admin/productos_nuevos.php'>
		</head>
		<body >
			<script>
				alert('Datos Actualizados Con Exito');
			</script>
		</body>
		</html>
		";
	}else{
		echo "<html>
		<head>	
			<meta http-equiv = 'REFRESH' content='0 ; url=../admin/productos_nuevos.php'>
		</head>
		<body>

			<script>
				alert('No se actualizaron los datos :(');
			</script>
		</body>
		</html>
		";
	}
	$updateProducto->closeCursor();
}else{
	header("location: ../admin/index.php");
}

?>