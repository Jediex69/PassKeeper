<?php
// Reinicia sesión para acceder a los datos del usuario actual.
session_start();

// Conexión y modelo de categorías.
require_once '../config/db.php';
require_once '../models/categoria_model.php';

// Si no hay sesión activa, redirige al login.
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../views/login.php");
    exit();
}

// Verifica que venga un ID válido por GET antes de borrar.
if (isset($_GET['id'])) {
    $id_categoria = trim($_GET['id']);
    if ($id_categoria !== '' && ctype_digit($id_categoria) && (int)$id_categoria > 0) {
        eliminarCategoria($conn, (int)$id_categoria, $_SESSION['usuario_id']);
    }
}

// Tras intentar borrar, vuelve a la lista de categorías.
header("Location: ../views/categorias.php");
exit();