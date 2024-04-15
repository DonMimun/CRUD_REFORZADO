<?php

include("conexion.php");

session_start();

// Verifica si los datos del formulario han sido enviados
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {

    $mensaje = "Por favor complete el formulario de registro";
    $color_msg = "danger";

    // redireccionamiento al login con mensaje de notificación en la URL
    header("Location: ../registro.php?msg=" . urlencode($mensaje) . "&color=" . urlencode($color_msg));
    exit(); // terminar la ejecución del script después de la redirección;

}

// Verifica si hay campos vacíos en el formulario
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {

    $mensaje = "Por favor complete todos los campos del formulario de registro";
    $color_msg = "danger";

    // redireccionamiento al login con mensaje de notificación en la URL
    header("Location: ../registro.php?msg=" . urlencode($mensaje) . "&color=" . urlencode($color_msg));
    exit(); // terminar la ejecución del script después de la redirección;
}

// Validación de la dirección de correo electrónico
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

    $mensaje = "Correo electrónico no válido";
    $color_msg = "danger";

    // redireccionamiento al login con mensaje de notificación en la URL
    header("Location: ../registro.php?msg=" . urlencode($mensaje) . "&color=" . urlencode($color_msg));
    exit(); // terminar la ejecución del script después de la redirección;
    
}

// Validación del nombre de usuario para no permitir caracteres especiales
if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {

    $mensaje = "Los caracteres especiales no están permitidos en el nombre de usuario";
    $color_msg = "danger";

    // redireccionamiento al login con mensaje de notificación en la URL
    header("Location: ../registro.php?msg=" . urlencode($mensaje) . "&color=" . urlencode($color_msg));
    exit(); // terminar la ejecución del script después de la redirección;
}

// Validación de la longitud de la contraseña
if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {

    $mensaje = "La contraseña debe tener entre 5 y 20 caracteres";
    $color_msg = "danger";

    // redireccionamiento al login con mensaje de notificación en la URL
    header("Location: ../registro.php?msg=" . urlencode($mensaje) . "&color=" . urlencode($color_msg));
    exit(); // terminar la ejecución del script después de la redirección;
}

// Verificación del reCAPTCHA
if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
    // La clave secreta de reCAPTCHA (proporcionada por Google)
    $secretKey = '6LeKzLApAAAAAEMaZzfuSX7q2tRj3DX7Rs96PB90';

    // URL de la API de verificación de reCAPTCHA
    $url = 'https://www.google.com/recaptcha/api/siteverify';

    // Parámetros para enviar a la API de verificación de reCAPTCHA
    $data = array(
        'secret' => $secretKey,
        'response' => $_POST['g-recaptcha-response']
    );

    // Inicializa una nueva solicitud cURL
    $ch = curl_init($url);

    // Configura las opciones de la solicitud cURL
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Ejecuta la solicitud cURL y obtiene la respuesta
    $response = curl_exec($ch);

    // Cierra la sesión cURL
    curl_close($ch);

    // Decodifica la respuesta JSON
    $responseData = json_decode($response);

    // Verifica si el reCAPTCHA ha sido verificado correctamente
    if ($responseData && $responseData->success) {
        // El reCAPTCHA ha sido verificado correctamente, procede con el registro del usuario

        // Verifica si el nombre de usuario ya existe en la base de datos
        $stmt = $conexion->prepare('SELECT id, password FROM usuarios WHERE username = ?');
        $stmt->bindParam(1, $_POST['username'], PDO::PARAM_STR);
        $stmt->execute();

        // Verifica si el nombre de usuario ya existe
        if ($stmt->rowCount() > 0) {

            // Nombre de usuario existente, notifica al usuario
            $mensaje = "El nombre de usuario ya está en uso, por favor, elija otro nombre";
            $color_msg = "danger";
        
            // redireccionamiento al login con mensaje de notificación en la URL
            header("Location: ../registro.php?msg=" . urlencode($mensaje) . "&color=" . urlencode($color_msg));
            exit(); // terminar la ejecución del script después de la redirección;

        } else {
            // El nombre de usuario no existe, procede con el registro del usuario

            // Prepara la consulta para insertar un nuevo usuario en la base de datos
            $stmt = $conexion->prepare('INSERT INTO usuarios (username, password, email) VALUES (?, ?, ?)');
            $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash de la contraseña
            $stmt->bindParam(1, $_POST['username'], PDO::PARAM_STR);
            $stmt->bindParam(2, $passwordHash, PDO::PARAM_STR);
            $stmt->bindParam(3, $_POST['email'], PDO::PARAM_STR);

            // Ejecuta la consulta para insertar el nuevo usuario
            if ($stmt->execute()) {

            $mensaje = "¡Usuario registrado con éxito! Ahora puedes iniciar sesión";
            $color_msg = "success";
        
            // redireccionamiento al login con mensaje de notificación en la URL
            header("Location: ../login.php?msg=" . urlencode($mensaje) . "&color=" . urlencode($color_msg));
            exit(); // terminar la ejecución del script después de la redirección;
                
            } else {

                $mensaje = "Error al registrar el usuario";
                $color_msg = "danger";
            
                // redireccionamiento al login con mensaje de notificación en la URL
                header("Location: ../registro.php?msg=" . urlencode($mensaje) . "&color=" . urlencode($color_msg));
                exit(); // terminar la ejecución del script después de la redirección;
            }
        }
    } else {
        
        // El reCAPTCHA no se verificó correctamente
        $mensaje = "Por favor, completa la verificación de reCAPTCHA";
        $color_msg = "danger";
    
        // redireccionamiento al login con mensaje de notificación en la URL
        header("Location: ../registro.php?msg=" . urlencode($mensaje) . "&color=" . urlencode($color_msg));
        exit(); // terminar la ejecución del script después de la redirección;
    }
} else {

    // No se recibió ninguna respuesta de reCAPTCHA
    $mensaje = "Por favor, completa la verificación de reCAPTCHA";
    $color_msg = "danger";

    // redireccionamiento al login con mensaje de notificación en la URL
    header("Location: ../registro.php?msg=" . urlencode($mensaje) . "&color=" . urlencode($color_msg));
    exit(); // terminar la ejecución del script después de la redirección;
}
?>
