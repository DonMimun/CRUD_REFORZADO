<?php

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si el campo g-recaptcha-response está presente en el POST
    if (isset($_POST['g-recaptcha-response'])) {
        $recaptcha_response = $_POST['g-recaptcha-response'];

        // Verifica el reCAPTCHA
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_secret = '6LeKzLApAAAAAEMaZzfuSX7q2tRj3DX7Rs96PB90'; // Reemplaza con tu clave secreta privada de reCAPTCHA

        // Crear los datos a enviar en la solicitud POST
        $recaptcha_data = array(
            'secret' => $recaptcha_secret,
            'response' => $recaptcha_response
        );

        // Configurar la solicitud POST
        $recaptcha_options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => http_build_query($recaptcha_data)
            )
        );

        // Hacer la solicitud POST y obtener la respuesta
        $recaptcha_context  = stream_context_create($recaptcha_options);
        $recaptcha_result = file_get_contents($recaptcha_url, false, $recaptcha_context);
        $recaptcha_response = json_decode($recaptcha_result);

        // Verificar la respuesta de reCAPTCHA
        if ($recaptcha_response->success == true) {
            // El reCAPTCHA se ha validado correctamente, continuar con el procesamiento del formulario de inicio de sesión

            // Incluir el archivo de conexión a la base de datos
            include("conexion.php");

            session_start();

            if ( !isset($_POST['username'], $_POST['password']) ) {

                // Los campos están vacíos, por lo que se finaliza la ejecución.
                $_SESSION["message"] = "Por favor, complete los campos";
                $_SESSION["color_msg"] = "success";
                header('location:../login.php');
                exit();
            }

            // Se crea una condición donde se extrae id y contraseña del usuario que se haya indicado
            $sql = 'SELECT id, password, cargo FROM usuarios WHERE username = ?';
            if ($stmt = $conexion->prepare($sql)) {
                
                // Comprobación del usuario
                $stmt->bindParam(1, $_POST['username'], PDO::PARAM_STR);
                $stmt->execute();

                // Se almacena el resultado
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

                // Condición: si hay datos, entonces...
                if ($resultado) {

                    $id = $resultado['id'];
                    $password = $resultado['password'];
                    $cargo = $resultado['cargo'];

                    // El usuario existe, ahora se hace una comprobación de la contraseña
                    if (password_verify($_POST['password'], $password)) {

                        // Contraseña correcta
                        // Se crea la sesión
                        session_regenerate_id();
                        $_SESSION['loggedin'] = TRUE;
                        $_SESSION['name'] = $_POST['username'];
                        $_SESSION['id'] = $id;
                        $_SESSION['cargo'] = $cargo;

                        // Redirige al usuario a index.php
                       header('Location: ../index.php');
                        exit(); 


                    } else {

                        // Contraseñas no coinciden
                        $mensaje = "Usuario o contraseña incorrectos";
                        $color_msg = "danger";
            
                        // redireccionamiento al login con mensaje de notificación en la URL
                        header("Location: ../login.php?msg=" . urlencode($mensaje) . "&color=" . urlencode($color_msg));
                        exit(); // terminar la ejecución del script después de la redirección;
                    }
                } else {
                    // Usuario incorrecto, no se especifica cuál es el error para mayor protección y 
                    // dificultar al atacante saber si existe el usuario o no
                        $mensaje = "Usuario o contraseña incorrectos";
                        $color_msg = "danger";
            
                        // redireccionamiento al login con mensaje de notificación en la URL
                        header("Location: ../login.php?msg=" . urlencode($mensaje) . "&color=" . urlencode($color_msg));
                        exit(); // terminar la ejecución del script después de la redirección;
                    
                }

            }
        } else {

            // El reCAPTCHA no se validó, muestra un mensaje de error o toma otras medidas según sea necesario
            $mensaje = "Por favor, completa el reCAPTCHA";
            $color_msg = "danger";

            // redireccionamiento al login con mensaje de notificación en la URL
            header("Location: ../login.php?msg=" . urlencode($mensaje) . "&color=" . urlencode($color_msg));
            exit(); // terminar la ejecución del script después de la redirección
        }
    } else {

        // El campo g-recaptcha-response no está presente en el POST, lo que indica un posible intento de abuso
            
        $mensaje = "Por favor, completa el reCAPTCHA";
        $color_msg = "danger";

            // redireccionamiento al login con mensaje de notificación en la URL
            header("Location: ../login.php?msg=" . urlencode($mensaje) . "&color=" . urlencode($color_msg));
            exit(); // terminar la ejecución del script después de la redirección
    }
}
?>
