<?php

//control, tienen que estar logueado para poder acceder
if (!isset($_SESSION['loggedin'])) {
    
	header("location: ../login.php");
	exit();
}

include("conexion.php");

// obtencion a traves de GET, si no existe por defecto la página a 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

// Numero a motrar por pagina
$records_per_page = 5;

// Preparacion de sentencia y obtener los registros, se usa limit para determinaar las paginas
$stmt = $conexion->prepare('SELECT * FROM productos ORDER BY id_p LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

// Guardar los registros en una variable
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// obtener todos los productos, esto es para poder poner boton anterior y siguiente
$num_contacts = $conexion->query('SELECT COUNT(*) FROM productos')->fetchColumn();

?>