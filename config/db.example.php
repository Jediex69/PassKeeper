<?php
// Parámetros de conexión a la base de datos.
// Copia este archivo como db.php y adapta los valores a tu entorno local.

$host = "localhost";
$user = "root";
$pass = "";
$db = "passkeeper_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>