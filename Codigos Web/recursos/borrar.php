<?php

include("conexion.php");

session_start();

if (!isset($_SESSION['loggedin'])) {
    
	header("location: ../login.php");
	exit;
}

if($_SESSION['cargo'] !== 'administrador'){

    $_SESSION["message"] = "Permisos insuficientes, Contacte con un administrador si se trata de un error";
    $_SESSION["color_msg"] = "danger";
    header("location: ../index.php");
	exit;
}

// comprobar la existencia de que llega la id a traves de get
if (isset($_GET['id'])) {
    // Comprobacion de que existe le producto con la id recibida
    $stmt = $conexion->prepare('SELECT * FROM productos WHERE id_p = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        
        $_SESSION["message"] = "El producto no existe";
        $_SESSION["color_msg"] = "danger";
        header('location:../index.php');
        exit();
    }
    // eliminar producto
    $stmt = $conexion->prepare('DELETE FROM productos WHERE id_p = ?');
    $stmt->execute([$_GET['id']]);

    $_SESSION["message"] = "Producto borrado con exito";
    $_SESSION["color_msg"] = "success";
    header('location:../index.php');
    exit();
    
} else {
    exit('ID no especificado');
}