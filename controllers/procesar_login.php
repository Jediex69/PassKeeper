<?php
// Inicia la sesión para poder registrar los datos del usuario autenticado.
session_start();

// Conexión a la base de datos y modelo de usuario.
require_once '../config/db.php';
require_once '../models/user_model.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Normaliza las entradas del formulario.
    $email = trim($_POST['email'] ?? '');
    $password_candidata = trim($_POST['contraseña'] ?? '');

    // Validación básica de datos antes de consultar la base de datos.
    if ($email === '' || $password_candidata === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../views/login.php?error=1");
        exit();
    }

    // Obtiene el usuario por email y compara la contraseña con el hash.
    $usuario = obtenerUsuarioPorEmail($conn, $email);

    if ($usuario && password_verify($password_candidata, $usuario['password_master'])) {
        // Regenera el ID de sesión por seguridad y guarda los datos del usuario.
        session_regenerate_id(true);
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['usuario_rol'] = $usuario['rol'];

        header("Location: ../views/dashboard.php");
        exit();
    }

    // Usuario o contraseña incorrectos, regresa al formulario de login.
    header("Location: ../views/login.php?error=1");
    exit();
}
?>