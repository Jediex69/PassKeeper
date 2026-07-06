<?php
// Carga la conexión y el modelo de usuarios.
require_once '../config/db.php';
require_once '../models/user_model.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Normaliza las entradas del formulario.
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password_plana = trim($_POST['contraseña'] ?? '');

    // Validar campos obligatorios.
    if ($nombre === '' || $email === '' || $password_plana === '') {
        header("Location: ../views/registro.php?error=3");
        exit();
    }

    // Validar formato de email.
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../views/registro.php?error=4");
        exit();
    }

    // Validar contraseña segura.
    $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
    if (!preg_match($regex, $password_plana)) {
        header("Location: ../views/registro.php?error=2");
        exit();
    }

    // Comprobar si el email ya está registrado.
    $usuarioExistente = obtenerUsuarioPorEmail($conn, $email);
    if ($usuarioExistente) {
        header("Location: ../views/registro.php?error=1");
        exit();
    }

    // Generar hash seguro de la contraseña.
    $password_hash = password_hash($password_plana, PASSWORD_DEFAULT);

    // Registrar el usuario y redirigir al login en caso de éxito.
    if (registrarUsuario($conn, $nombre, $email, $password_hash)) {
        header("Location: ../views/login.php?msg=registered");
        exit();
    }

    // Mensaje genérico si el registro falla.
    echo "Error al registrar el usuario. Es posible que el email ya exista.";
}
?>