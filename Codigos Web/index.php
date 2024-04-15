<?php
// se llama a la sesion.
session_start();
// si la sesion no esta activa, es reenviado a login
if (!isset($_SESSION['loggedin'])) {
    
	header("location: login.php");
	exit;
}

include("recursos/conexion.php");


?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Inicio</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">

    	<!-- proteccion contra ataques XXS -->

		<meta http-equiv="Content-Security-Policy" content="
		style-src 'self' https://use.fontawesome.com https://cdn.jsdelivr.net ;
		...  ">


		<!-- link de bootstrap -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

		<!-- estilos -->
		<link rel="stylesheet" href="recursos/estilonav.css">
        <link rel="stylesheet" href="recursos/estiloindex.css">

    </head>
	<body class="loggedin">
<?php include("navbar.php"); ?>
		<div class="content">
			<h2>Pagina Principal</h2>
			<div class="d-flex justify-content-between align-items-center">
			
				<p >Usuario: <?=htmlspecialchars($_SESSION['name'], ENT_QUOTES)?></p>
				
				<?php if($_SESSION['cargo'] == 'administrador'): ?>
				<a href="crearproducto.php" class="btn btn-success">Añadir producto</a>
				<?php endif ?>
			</div>
			<div class="row d-flex justify-content-center">
            		<!-- venta de notificacion -->
            		<?php if(isset($_SESSION['message'])) { ?> 

						<div class="alert alert-<?= $_SESSION['color_msg']; ?> alert-dismissible fade show" role="alert">
							<?= $_SESSION['message'] ?>
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
						
						<?php unset($_SESSION['message']); // Limpiar la variable de sesión sin cerrar sesion ?>

					<?php } ?>

				<!-- Se incluyen las funciones para obtener los datos, esto es porque no queria 
				tener un index muy extenso mezclando todo. Al separar las acciones en otro archivo
				tengo una mejor administracion de las tablas -->

				<?php include('recursos/teblacontenido.php'); ?>

				<!-- mostrar tabla de contenidos -->
				<div class="col-md-15">
					<table class="table table-bordered" >

						<!-- venta de notificacion -->

						<?php if(isset($_SESSION['message'])) { ?> 
							<div class="alert alert-<?= $_SESSION['color_msg']; ?> alert-dismissible fade show" role="alert">
								<?= $_SESSION['message'] ?>
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
                    	<?php } ?>

						<h4 class=" mb-3 text-center p-2">Datos de trabajadores</h4>
						
						<div class="tablebody">
							<thead class="text-center">
								<tr>
									<th>Nombre</th>
									<th>Precio</th>
									<th>Stock</th>
									<?php if($_SESSION['cargo'] == 'administrador'): ?>
									<th class="col-sm-3">Acciones</th>
									<?php endif ?>
								</tr>
							</thead>
							<!-- en body realizamos la consulta a la base de datos -->
							<tbody>

								<?php foreach ($contacts as $contact): ?>

								<tr>
									<td><?=$contact['nombre_p']?></td>
									<td><?=$contact['precio']?></td>
									<td><?=$contact['stock']?></td>
									<?php if($_SESSION['cargo'] == 'administrador'): ?>
									<td class= "text-center btn-block">
										<a href="actualizarproducto.php?id=<?php echo $contact['id_p'] ?>" class="btn btn-warning text-white btn-sm mb-1" ><i class="fas fa-screwdriver"></i> Editar</a>
										<?php include('recursos/botonborrar.php'); ?>
									</td>
									<?php endif ?>
								</tr>
								
								<?php endforeach; ?>

							</tbody>
						</div>
						</table>

						<!-- paginacion de los resultados -->
						
						<div class="mb-2 d-flex justify-content-between">
							<?php if ($page > 1): ?>
							<a class="btn btn-warning btn-sm" href="index.php?page=<?=$page-1?>"><i class="fas fa-reply"></i></a>
							<?php endif; ?>
							<?php if ($page*$records_per_page < $num_contacts): ?>
							<a class="btn btn-warning btn-sm" href="index.php?page=<?=$page+1?>"><i class="fas fa-share"></i></a>
							<?php endif; ?>
						</div>
				</div>
		
		
		
		</div>



        </div>

		<!-- scripts de bootstrap -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

	</body>
</html>