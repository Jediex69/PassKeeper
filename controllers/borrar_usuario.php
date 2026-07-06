<?php
// Inicia la sesión para obtener información del usuario autenticado.
session_start();

// Carga la conexión y el modelo de usuarios.
require_once '../config/db.php';
require_once '../models/user_model.php';

// Solo el administrador puede acceder a esta acción.
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: ../views/dashboard.php");
    exit();
}

if (isset($_GET['id'])) {
    // Validar el ID recibido por GET.
    $id_a_borrar = trim($_GET['id']);
    if ($id_a_borrar === '' || !ctype_digit($id_a_borrar) || (int)$id_a_borrar <= 0) {
        header("Location: ../views/admin.php");
        exit();
    }

    $id_a_borrar = (int)$id_a_borrar;
    $mi_id = $_SESSION['usuario_id'];

    // Evitar que el admin se borre a sí mismo.
    if ($id_a_borrar === $mi_id) {
        die("Error: No puedes borrar tu propia cuenta de administrador.");
    }

    // Ejecutar el borrado usando el modelo.
    if (eliminarUsuario($conn, $id_a_borrar)) {
        header("Location: ../views/admin.php?msg=usuario_eliminado");
        exit();
    }

    // Si el borrado falla, mostrar un mensaje de error.
    echo "Error al eliminar el usuario.";
} else {
    // Sin ID válido, regresar al panel de administración.
    header("Location: ../views/admin.php");
    exit();
}
?>