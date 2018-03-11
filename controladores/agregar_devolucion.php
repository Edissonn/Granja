<?php 
require_once('../conexion.php');
$objet_conexion = new Conexion();
$conexion = $objet_conexion->conectar();

$obtener_producto = $conexion->prepare("SELECT * FROM producto WHERE estado=1 AND importe>0");
$obtener_producto->execute();
if ($obtener_producto->rowCount()>0) {
	echo '<tr id="fila_dev_'.$_POST['cont'].'">
	<td>
		<select class="form-control pk_producto_devolucion" name="pk_producto_devolucion[]">
			<option value="">Selecciona un producto</option>';
			$res_productos = $obtener_producto->fetchAll();
			foreach ($res_productos as $value) {
				echo '<option value="'.$value['pk_producto'].'">'.$value['nombre'].'</option>';
			}
			echo '
		</select>
	</td>
	<td>
		<input type="number" min="1" name="cant_em_devolucion[]" class="form-control cant_em_devolucion">
	</td>
	<td>
		<input type="number" min="1" name="cant_ef_devolucion[]" class="form-control cant_ef_devolucion">
	</td>
	<td>
		<button class="btn btn-warning" onclick="elminar_filas_devolucion(\'fila_dev_'.$_POST['cont'].'\')">Eliminar</button>
	</td>
</tr>';

}
$obtener_producto->closeCursor();
?>