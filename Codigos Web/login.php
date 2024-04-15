<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="recursos/estilologin.css">

    <!-- proteccion csp y xss  -->
    <meta http-equiv="Content-Security-Policy" content="
        script-src 'self' https://www.google.com/recaptcha/api.js https://www.google.com https://www.gstatic.com https://recaptcha.net https://cdn.jsdelivr.net;
        style-src 'self' https://use.fontawesome.com https://cdn.jsdelivr.net;
    ">


    <!-- link de bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <title>Login</title>
</head>
<body>
    <section>
        <div class="contenedor">
            <div class="formulario">

            <!-- mensaje de notificación -->
            <?php if(isset($_GET['msg']) && isset($_GET['color'])) { ?> 
                <div class="alert alert-<?php echo $_GET['color']; ?> alert-dismissible fade show" role="alert">
                    <?php echo $_GET['msg']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>

                <form action="recursos/loginscript.php" method="post">
                    <h2>Iniciar Sesión</h2>

                    <div class="input-contenedor">
                        
                        <input type="text" required name="username" autocomplete="off">
                        <label for="#"><i class="fas fa-user-astronaut"></i> Nombre </i></label>
                    </div>

                    <div class="input-contenedor">
                        <input type="password" required name="password">
                        <label for="#"><i class="fas fa-globe-europe"></i> Contraseña</label>
                    </div>

                    <div class="d-flex justify-content-center align-items-center mb-3 recaptcha-container">
                        <div class="g-recaptcha" data-sitekey="6LeKzLApAAAAAMOtqyGbZpSrZnr_eqwUkAKGXKsC"></div>
                    </div>                    

                    <div>

                        <button class="my-custom-btn">Iniciar</button>

                        <div class="registrar">
                            <p> No tengo cuenta: <a href="registro.php">Crear</a></p>
                        </div>
                    </div>
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