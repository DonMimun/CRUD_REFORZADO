<?php

//control, tienen que estar logueado para poder acceder
if (!isset($_SESSION['loggedin'])) {
    
	header("location: login.php");
	exit();
}

?>

<header>
    <div class="logo"> <a href="index.php"><i class="fab fa-monero "></i>imunLand</a></div>
    <nav class="navtop">

    </nav>
    <a href="perfil.php" class="btn"><button>Perfil <i class="fas fa-user-astronaut"></i></button></a>
    <a href="recursos/cerrarsesion.php" class="btn"><button>Salir <i class="fas fa-rocket"></i></button></a>
</header>