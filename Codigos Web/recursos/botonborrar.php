<?php

//control, tienen que estar logueado para poder acceder
if (!isset($_SESSION['loggedin'])) {
    
	header("location: ../login.php");
	exit();
}

?>

<!-- esta en un archivo a parte para no sobre cargar el index y hacer la gestion mas compleja -->

<!-- Enlace del botón de borrar -->
<a href="#" class="btn btn-danger btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#confirmDelete<?=$contact['id_p']?>"><i class="fas fa-meteor"></i> Borrar</a>

<!-- Modal de confirmación -->
<div class="modal fade" id="confirmDelete<?=$contact['id_p']?>" tabindex="-1" aria-labelledby="confirmDeleteLabel<?=$contact['id_p']?>" aria-hidden="true" data-bs-backdrop="static" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel<?=$contact['id_p']?>">Confirmar eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar el producto?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="recursos/borrar.php?id=<?=$contact['id_p']?>" class="btn btn-danger">Eliminar</a>
            </div>
        </div>
    </div>
</div>
