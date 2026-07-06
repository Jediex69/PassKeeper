<?php
// Inicia sesión y carga la base de datos y el modelo de categorías.
session_start();
require_once '../config/db.php';
require_once '../models/categoria_model.php';

// Redirige a login si el usuario no está autenticado.
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['usuario_id'];

// Obtiene las categorías del usuario para mostrar en el formulario.
$res_cats = listarCategorias($conn, $user_id);
$hayCategorias = ($res_cats->num_rows > 0);
$nombreSitio = trim($_GET['nombre_sitio'] ?? '');
$urlSitio = trim($_GET['url_sitio'] ?? '');
$categoriaSeleccionada = trim($_GET['id_categoria'] ?? '');
?>
<?php require 'layout/header.php'; ?>

<!-- Encabezado de la página de creación de credenciales. -->
<h2>Añadir nueva credencial</h2>
<?php if (!$hayCategorias): ?>
    <!-- Mensaje si aún no hay categorías creadas. -->
    <p style="color:red">Debes crear al menos una categoría antes de añadir una contraseña</p>
    <a href="categorias.php">Crear categoria</a>
<?php else: ?>
    <?php if (isset($_GET['error']) && $_GET['error'] === 'missing_fields'): ?>
        <p style="color:red;">Debes completar todos los campos obligatorios.</p>
    <?php endif; ?>
    <!-- Formulario para capturar datos de la nueva contraseña. -->
    <form action="../controllers/procesar_password.php" method="post">
        <label>Nombre del sitio:</label>
        <input type="text" name="nombre_sitio" value="<?php echo htmlspecialchars($nombreSitio, ENT_QUOTES, 'UTF-8'); ?>" required><br>

        <label>URL:</label>
        <input type="url" name="url_sitio" placeholder="https://..." value="<?php echo htmlspecialchars($urlSitio, ENT_QUOTES, 'UTF-8'); ?>" required><br>

        <label>Contraseña del sitio:</label>
        <input type="password" id="password_cifrada" name="password_cifrada" required>
        <button type="button" class="toggle-password" onclick="togglePasswordVisibility('password_cifrada', this)">Mostrar</button><br>

        <label>Categoría:</label>
        <select name="id_categoria" required>
            <option value="" <?php echo ($categoriaSeleccionada === '') ? 'selected' : ''; ?> disabled>Selecciona una categorí­a</option>
            <!-- Opciones generadas desde la consulta de categorías. -->
            <?php while ($cat = $res_cats->fetch_assoc()): ?>
                <option value="<?php echo htmlspecialchars($cat['id'], ENT_QUOTES, 'UTF-8'); ?>" <?php echo ($categoriaSeleccionada === (string) $cat['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($cat['nombre_categoria'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endwhile; ?>
        </select><br>
        <button type="submit">Guardar Contraseña</button>
    </form>
<?php endif; ?>

<!-- Enlace para regresar al panel principal. -->
<a href="dashboard.php">Volver</a>

<script>
// Alterna la visibilidad del campo de contraseña en el formulario.
function togglePasswordVisibility(inputId, button) {
    const input = document.getElementById(inputId);
    if (!input) return;
    if (input.type === 'password') {
        input.type = 'text';
        button.textContent = 'Ocultar';
    } else {
        input.type = 'password';
        button.textContent = 'Mostrar';
    }
}
</script>

<?php require 'layout/footer.php'; ?>
