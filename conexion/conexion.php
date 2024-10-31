
<?php	
	$conexion = mysqli_connect("localhost", "root", "", "inventario");
	if (!$conexion) {
		die("No se pudo conectar a la base de datos");
	}
	
	function conectar() {
		$conexion = mysqli_connect("localhost", "root", "", "inventario");
		if (!$conexion) {
			die("No se pudo conectar a la base de datos");
		}
		return $conexion;
	}
	
	function consultar($conexion, $query) {
		$resultado = mysqli_query($conexion, $query);
		if (!$resultado) {
			die("No se pudo ejecutar la consulta");
		}
		return $resultado;
	}
	
	function cerrarConexion($conexion) {
		mysqli_close($conexion);
	}
?>

