<?php

    include("recursos/conexion.php"); 
    session_start();

	// se llama a la sesion.

	// si la sesion no esta activa, es reenviado a login
	if (!isset($_SESSION['loggedin'])) {
		
		echo'sesion cerrada';
		header("location: login.php");
		exit();
	}
    // Extrayendo la información a partir de la ID
    $stmt = $conexion->prepare('SELECT password, email, cargo FROM usuarios WHERE id = :id');

    // Enlazar el parámetro :id con el valor de $_SESSION['id']
    $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);

    // Ejecutar la consulta preparada
    $stmt->execute();

    // Vincular las columnas de resultado a variables
    $stmt->bindColumn('password', $password);
    $stmt->bindColumn('email', $email);
	$stmt->bindColumn('cargo', $cargo);

    // Obtener los resultados
    $stmt->fetch();


?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Pagina perfil</title>

		<!-- proteccion contra ataques XXS -->
		<meta http-equiv="Content-Security-Policy" content="
			style-src 'self' https://use.fontawesome.com https://cdnjs.cloudflare.com 'unsafe-inline';
			font-src 'self' https://use.fontawesome.com https://cdnjs.cloudflare.com;
		">


		<link href="recursos/estiloindex.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
        <link rel="stylesheet" href="recursos/estilonav.css">
    </head>
	<body class="loggedin">

        <?php include("navbar.php"); ?>

		<div class="content">
			<h2>Datos de Perfil</h2>
			<div>
				<p class="info">Esta es la informacion de su cuenta:</p>
				<table>
					<tr>
						<td>Usuario:</td>
						<td><?=htmlspecialchars($_SESSION['name'], ENT_QUOTES)?></td>
					</tr>
					<tr>
						<td>Contraseña:</td>
						<td><?=htmlspecialchars($password, ENT_QUOTES)?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?=htmlspecialchars($email, ENT_QUOTES)?></td>
					</tr>
					<tr>
						<td>Nivel:</td>
						<td><?=htmlspecialchars($cargo, ENT_QUOTES)?></td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>