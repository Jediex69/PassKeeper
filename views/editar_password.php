<?php
// Inicia sesión y carga las dependencias necesarias.
session_start();
require_once '../config/db.php';
require_once '../config/crypto.php';
require_once '../models/password_model.php';
require_once '../models/categoria_model.php';

// Protege la página para usuarios autenticados.
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$id_pass = $_GET['id'];
$id_user = $_SESSION['usuario_id'];

// Obtiene los datos de la contraseña y verifica pertenencia al usuario.
$datos = obtenerPasswordPorId($conn, $id_pass, $id_user);
if (!$datos) {
    die("Contraseña no encontrada.");
}

// Descifra la contraseña para poder editarla en texto plano.
$pass_real = descifrar($datos['password_cifrada']);
$categorias = listarCategorias($conn, $id_user);
?>
<?php require 'layout/header.php'; ?>

<!-- Formulario para editar una credencial existente. -->
<h2>Editar Credencial</h2>
<form action="../controllers/procesar_edicion_password.php" method="post">
    <input type="hidden" name="id_pass" value="<?php echo htmlspecialchars($datos['id'], ENT_QUOTES, 'UTF-8'); ?>">

    <label>Nombre del sitio:</label><br>
    <input type="text" name="nombre_sitio" value="<?php echo htmlspecialchars($datos['nombre_sitio'], ENT_QUOTES, 'UTF-8'); ?>" required><br><br>

    <label>URL:</label><br>
    <input type="url" name="url_sitio" value="<?php echo htmlspecialchars($datos['url_sitio'], ENT_QUOTES, 'UTF-8'); ?>" required><br><br>

    <label>Contraseña:</label><br>
    <input type="password" id="password_plana" name="password_plana" value="<?php echo htmlspecialchars($pass_real, ENT_QUOTES, 'UTF-8'); ?>" required>
    <button type="button" class="toggle-password" onclick="togglePasswordVisibility('password_plana', this)">Mostrar</button><br><br>

    <label>Categoría:</label><br>
    <select name="id_categoria">
        <!-- Genera opciones de categoría y marca la actual como seleccionada. -->
        <?php while ($cat = $categorias->fetch_assoc()): ?>
            <option value="<?php echo htmlspecialchars($cat['id'], ENT_QUOTES, 'UTF-8'); ?>" <?php echo ($cat['id'] == $datos['id_categoria']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($cat['nombre_categoria'], ENT_QUOTES, 'UTF-8'); ?>
            </option>
        <?php endwhile; ?>
    </select><br><br>

    <button type="submit">Guardar Cambios</button>
</form>

<script>
// Alterna la visibilidad del campo de contraseña.
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

<!-- Enlace para volver al panel sin guardar cambios. -->
<a href="dashboard.php">Cancelar</a>
<?php require 'layout/footer.php'; ?>