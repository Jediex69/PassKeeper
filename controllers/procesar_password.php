<?php
// Inicia la sesión para acceder al usuario actual.
session_start();

// Carga de dependencias: base de datos, cifrado y modelo de contraseñas.
require_once '../config/db.php';
require_once '../config/crypto.php';
require_once '../models/password_model.php';

// Si el usuario no está autenticado, redirige al login.
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../views/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Normaliza los valores enviados desde el formulario.
    $nombre_sitio = trim($_POST['nombre_sitio'] ?? '');
    $url_sitio = trim($_POST['url_sitio'] ?? '');
    $pass_plana = trim($_POST['password_cifrada'] ?? '');
    $id_categoria = trim($_POST['id_categoria'] ?? '');
    $id_usuario = $_SESSION['usuario_id'];

    // Validar campos obligatorios.
    if ($nombre_sitio === '' || $url_sitio === '' || $pass_plana === '' || $id_categoria === '') {
        $query = http_build_query([
            'error' => 'missing_fields',
            'nombre_sitio' => $nombre_sitio,
            'url_sitio' => $url_sitio,
            'id_categoria' => $id_categoria,
        ]);
        header("Location: ../views/crear_password.php?$query");
        exit();
    }

    // Validar que la categoría sea un ID numérico válido.
    if (!ctype_digit($id_categoria) || (int)$id_categoria <= 0) {
        die("Error: Categoría inválida.");
    }

    // Validar URL cuando se proporciona.
    if ($url_sitio !== '' && !filter_var($url_sitio, FILTER_VALIDATE_URL)) {
        die("Error: URL inválida.");
    }

    // Cifrar la contraseña antes de guardarla en la base de datos.
    $pass_cifrada = cifrar($pass_plana);

    // Insertar la nueva contraseña usando el modelo.
    if (insertarPassword($conn, $nombre_sitio, $url_sitio, $pass_cifrada, $id_usuario, (int)$id_categoria)) {
        header("Location: ../views/dashboard.php?msg=created");
        exit();
    }

    // Mostrar error si la inserción falla.
    echo "Error al guardar la contraseña.";
}
?>
