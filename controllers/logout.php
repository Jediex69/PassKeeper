<?php
// Inicia la sesión actual para poder destruirla.
session_start();

// Elimina todos los datos de sesión del usuario.
session_destroy();

// Redirige al inicio después de cerrar sesión.
header("Location: ../index.php");
