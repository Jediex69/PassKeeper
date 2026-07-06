<?php
// Inicia la sesión para verificar el usuario actual.
session_start();

// Carga la conexión a la base de datos y el modelo de usuarios.
require_once '../config/db.php';
require_once '../models/user_model.php';

// Si no hay sesión activa, forzar el login.
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../views/login.php");
    exit();
}

// Solo los administradores pueden editar otros usuarios.
if ($_SESSION['usuario_rol'] !== 'admin') {
    exit("Acceso denegado");
}

// Solo procesar el formulario si viene por POST.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = trim($_POST['id'] ?? '');
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $rol = trim($_POST['rol'] ?? '');

    // Validar que todos los campos requeridos estén presentes.
    if ($id === '' || !ctype_digit($id) || $nombre === '' || $email === '' || $rol === '') {
        die("Error: Datos incompletos.");
    }

    // Validar formato de email.
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Error: Email inválido.");
    }

    // Validar que el rol sea uno de los permitidos.
    if (!in_array($rol, ['user', 'admin'], true)) {
        die("Error: Rol inválido.");
    }

    // Actualizar el usuario en la base de datos.
    if (actualizarUsuario($conn, (int)$id, $nombre, $email, $rol)) {
        header("Location: ../views/admin.php?msg=usuario_actualizado");
        exit();
    }

    // Mostrar un error simple si la actualización falló.
    echo "Error al actualizar el usuario.";
}
?>