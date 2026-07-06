<?php
// Inicia sesión si aún no se ha iniciado, necesario para verificar el estado de autenticación.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Metadatos y fuentes comunes para todas las páginas. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PassKeeper- Asegure su mundo digital</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <?php if (basename($_SERVER['PHP_SELF']) === 'index.php'): ?>
        <link rel="stylesheet" href="assets/styles.css">
    <?php else: ?>
        <link rel="stylesheet" href="../assets/styles.css">
    <?php endif; ?>
</head>

<body>
    <header>
        <?php
        // Detecta la página actual para ajustar rutas de recursos y enlaces.
        $pagina = basename($_SERVER['PHP_SELF']);
        $logueado = isset($_SESSION['usuario_id']);
        $logoSrc = $pagina === 'index.php' ? 'assets/logo.png' : '../assets/logo.png';
        $homeLink = $pagina === 'index.php' ? 'index.php' : '../index.php';
        ?>        
        <div class="header-inner">
            <!-- Logo fijo y navegación principal según el estado de sesión. -->
            <div class="logo">
                <img src="<?= $logoSrc ?>" alt="PassKeeper Logo">
            </div>
            <nav>
                <ul>
                    <?php if(!$logueado): ?>

                        <?php if($pagina === 'index.php'): ?>                        
                            <li><a href="views/login.php">Iniciar sesión</a></li>
                            <li><a href="views/registro.php">Registro</a></li>

                        <?php elseif ($pagina === 'login.php'): ?>                        
                            <li><a href="../index.php">Inicio</a></li>
                            <li><a href="registro.php">Registro</a></li>
                        <?php else: ?>                        
                            <li><a href="../index.php">Inicio</a></li>
                            <li><a href="login.php">Iniciar sesión</a></li>
                        <?php endif; ?>

                        <?php else: ?>
                            <li><a href="dashboard.php">Dashboard</a></li>
                            <li><a href="crear_password.php">Crear contraseña</a></li>
                            <li><a href="categorias.php">Categorias</a></li>
                            <li><a href="../controllers/logout.php">Cerrar sesión</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main>