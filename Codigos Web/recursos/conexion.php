<?php


    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'administrador';
    $DATABASE_PASS = 'admin';
    $DATABASE_NAME = 'cuentas';

    try {
    
        $conexion = new PDO ('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    
    }catch (PDOException $e) {
        // si falla la conexion nos dara un mensaje de error y cual fue el error
        print "La conexion fallo: " . $e->getMessage() . "<br/>";
        die();
    }


?>