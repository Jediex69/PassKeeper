<?php
// Inicia la sesión para acceder al identificador del usuario autenticado.
session_start();

// Conexión a la base de datos y modelo de contraseñas.
require_once '../config/db.php';
require_once '../models/password_model.php';

// Solo los usuarios logueados pueden eliminar credenciales.
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../views/login.php");
    exit();
}

if (isset($_GET['id'])) {
    // Normaliza y valida el ID recibido por GET.
    $id_pass = trim($_GET['id']);
    if ($id_pass === '' || !ctype_digit($id_pass) || (int)$id_pass <= 0) {
        header("Location: ../views/dashboard.php");
        exit();
    }

    // Eliminación segura: solo borra si pertenece al usuario actual.
    if (eliminarPassword($conn, (int)$id_pass, $_SESSION['usuario_id'])) {
        header("Location: ../views/dashboard.php?msg=deleted");
        exit();
    }

    // Si falla la operación, mostrar un error simple.
    echo "Error al borrar la credencial.";
} else {
    // Sin ID, redirige al panel sin hacer nada.
    header("Location: ../views/dashboard.php");
    exit();
}
?>