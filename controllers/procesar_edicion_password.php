<?php
// Inicia la sesión para acceder al usuario autenticado.
session_start();

// Carga la conexión, la configuración de cifrado y el modelo de contraseñas.
require_once '../config/db.php';
require_once '../config/crypto.php';
require_once '../models/password_model.php';

// Si el usuario no está logueado, redirige al login.
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../views/login.php");
    exit();
}

// Procesa el formulario solo en peticiones POST.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_pass = trim($_POST['id_pass'] ?? '');
    $nombre = trim($_POST['nombre_sitio'] ?? '');
    $url = trim($_POST['url_sitio'] ?? '');
    $password_plana = trim($_POST['password_plana'] ?? '');
    $id_cat = trim($_POST['id_categoria'] ?? '');
    $id_user = $_SESSION['usuario_id'];

    // Validar campos obligatorios y valores numéricos.
    if ($id_pass === '' || !ctype_digit($id_pass) || $nombre === '' || $password_plana === '' || $id_cat === '' || !ctype_digit($id_cat)) {
        die("Error: Datos incompletos o inválidos.");
    }

    // Solo validar URL si se ha proporcionado una.
    if ($url !== '' && !filter_var($url, FILTER_VALIDATE_URL)) {
        die("Error: URL inválida.");
    }

    // Cifra la contraseña nueva antes de almacenarla.
    $pass_cifrada = cifrar($password_plana);

    // Actualiza la credencial usando el modelo.
    if (actualizarPassword($conn, (int)$id_pass, $nombre, $url, $pass_cifrada, (int)$id_cat, $id_user)) {
        header("Location: ../views/dashboard.php?msg=updated");
        exit();
    }

    // Error en la actualización si la operación falla.
    echo "Error al actualizar.";
}
