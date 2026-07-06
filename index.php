<?php
// Inicia la sesión para comprobar si el usuario ya está autenticado.
session_start();

// Si el usuario ya ha iniciado sesión, redirige directamente al panel.
if (isset($_SESSION['usuario_id'])) {
    header("Location: views/dashboard.php");
    exit();
}

// Carga el encabezado común de la aplicación.
require 'views/layout/header.php';
?>

<section>
    <h1>Asegura tu mundo digital</h1>
    <p>La forma más sencilla y segura de gestionar todas tus contraseñas en un solo lugar con cifrado basado en AES-256 para la protección de credenciales almacenadas.</p>
    <div>
        <a href="views/registro.php">Empezar ahora</a>
    </div>
</section>
<section class="articulos">
    <article>
        <div class="contenido">
            <h3>Cifrado AES-256</h3>
            <p>Tus datos se cifran antes de guardarse, garantizando que solo tú puedas verlos. AES‑256 es una variante del estándar de cifrado AES (Advanced Encryption Standard) que utiliza claves de 256 bits, lo que lo convierte en uno de los métodos de cifrado más seguros y utilizados en el mundo. Es un algoritmo de cifrado simétrico por bloques, adoptado como estándar por el gobierno de EE. UU. en 2002. Usa bloques de datos de 128 bits y permite claves de 128, 192 o 256 bits; la versión de 256 bits es la más robusta.</p>
        </div>
        <img src="assets/cripto.png">
    </article>

    <article>
        <div class="contenido">
            <h3>Organización</h3>
            <p>Clasifica tus credenciales por categorías personalizadas: Trabajo, Redes Sociales, Bancos, Email, Tiendas Online y muchas más. Mantén tus contraseñas perfectamente organizadas mediante un sistema intuitivo de etiquetado que te permite encontrar cualquier credencial en cuestión de segundos. No perderás tiempo buscando esa contraseña importante cuando la necesites; con nuestro potente sistema de búsqueda y filtrado, todo lo que necesitas estará siempre a tu alcance, ordenado y categorizado exactamente como prefieras.</p>
        </div>
        <img src="assets/organizacion.jpg">
    </article>

    <article>
        <div class="contenido">
            <h3>Acceso Total</h3>
            <p>Gestiona, edita y elimina tus contraseñas de forma intuitiva, segura y rápida desde cualquier dispositivo, en cualquier momento y desde cualquier lugar del mundo. Nuestra interfaz es completamente responsive y se adapta perfectamente tanto a dispositivos móviles como a pantallas de escritorio, asegurando una experiencia de usuario fluida y agradable. Controla completamente tu bóveda de contraseñas con funcionalidades avanzadas que te permiten actualizar tus credenciales al instante, sin complicaciones ni procesos innecesarios.</p>
        </div>
        <img src="assets/acceso.jpg">
    </article>
</section>
<?php require 'views/layout/footer.php'; ?>