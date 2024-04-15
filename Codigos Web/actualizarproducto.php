<?php

session_start();

include ('recursos/conexion.php') ;

//control, tienen que estar logueado para poder acceder
if (!isset($_SESSION['loggedin'])) {
    
	header("location: login.php");
	exit();
}

if($_SESSION['cargo'] !== 'administrador'){

    $_SESSION["message"] = "Permisos insuficientes, Contacte con un administrador si se trata de un error";
    $_SESSION["color_msg"] = "danger";
    header("location: index.php");
	exit;
}

// Comprobacion de que los campos no esten vacios
if (isset($_GET['id'])) {

    //obtención de los datos originales
    $stmt = $conexion->prepare('SELECT * FROM productos WHERE id_p = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$contact) {
        
        $_SESSION["message"] = "Producto inexistente";
        $_SESSION["color_msg"] = "danger";
        header('location:index.php');
        
        exit();
    }
}

if (!empty($_POST)) {
        
    // Configuracion de variables a insertar
    
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];


    if (!is_numeric($precio) || !preg_match('/^\d+(\.\d{1,2})?$/', $precio)) {

        $_SESSION["message"] = "El campo precio tiene que ser un valor numerico y usar el punto para indicar decimales (ej. 10.99)";
        $_SESSION["color_msg"] = "danger";
        header('location:crearproducto.php');
        exit();

    }elseif(!is_string($nombre)) {

        $_SESSION["message"] = "El campo nombre tiene que ser una cadena de texto";
        $_SESSION["color_msg"] = "danger";
        header('location:crearproducto.php');
        exit();

    }elseif(!is_numeric($stock)) {

        $_SESSION["message"] = "El campo stock tiene que ser un valor numerico";
        $_SESSION["color_msg"] = "danger";
        header('location:crearproducto.php');
        exit();
    }


    // insertar los datos a la BD
    $stmt = $conexion->prepare('UPDATE productos SET nombre_p = ?, precio = ?, stock = ? WHERE id_p = ?');
    $stmt->execute([$nombre, $precio, $stock, $id]);

    // mensaje de notificacion de guardado
    $_SESSION["message"] = "Producto Actualizado con exito";
    $_SESSION["color_msg"] = "success";
    header('location:index.php');
    exit();

}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Actualizar</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
        
        <!-- proteccion contra ataques XXS -->
        <meta http-equiv="Content-Security-Policy" content="
		style-src 'self' https://use.fontawesome.com https://cdn.jsdelivr.net ;
		...  ">

		<!-- link de bootstrap -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

		<link rel="stylesheet" href="recursos/estilonav.css">
        <link rel="stylesheet" href="recursos/estilocreate-update.css">
    </head>
	<body class="loggedin">
        <?php include("navbar.php"); ?>

        <section>
            <div class="contenedor">
                <div class="contact-form">

                    <!-- venta de notificacion -->

                    <?php if(isset($_SESSION['message'])) { ?> 
                        <div class="alert alert-<?= $_SESSION['color_msg']; ?> alert-dismissible fade show" role="alert">
                            <?= $_SESSION['message'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <?php unset($_SESSION['message']); // Limpiar la variable de sesión sin cerrar sesion ?>
                        
                    <?php } ?>

                    <h2>Actualizar producto</h2>
                    <form action="actualizarproducto.php" method="post">

                        <p>
                            <label>ID (no editable)</label>
                            <input type="numbre" name="id" value="<?=$contact['id_p']?>" readonly>
                        </p>
                        <p>
                            <label>Nombre Producto</label>
                            <input type="text" name="nombre" value="<?=$contact['nombre_p']?>" autocomplete="off" required>
                        </p>
                        <p>
                            <label>Precio</label>
                            <input type="number" step="0.01" name="precio" value="<?=$contact['precio']?>" autocomplete="off" required>
                        </p>
                        <p>
                            <label>Stock</label>
                            <input type="text" name="stock" value="<?=$contact['stock']?>" autocomplete="off" required>
                        </p>
                        <p class="block">
                            <button> Actualizar </button>
                        </p>
                    </form>
                </div>
            </div>
        </section>

           <!-- scripts de bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    </body>
</html>
