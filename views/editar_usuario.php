<?php
// Inicia sesión y carga la conexión y el modelo de usuario.
session_start();
require_once '../config/db.php';
require_once '../models/user_model.php';

// Solo un administrador puede editar usuarios.
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}

$id_user = $_GET['id'] ?? null;
$user_data = obtenerUsuarioPorId($conn, $id_user);

if (!$user_data) {
    die("Usuario no encontrado.");
}
?>
<?php require 'layout/header.php'; ?>

<!-- Formulario para editar los datos básicos del usuario. -->
<h2>Editar Perfil de Usuario</h2>
<form action="../controllers/procesar_edicion_usuario.php" method="post">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($user_data['id'], ENT_QUOTES, 'UTF-8'); ?>">

    <label>Nombre:</label><br>
    <input type="text" name="nombre" value="<?php echo htmlspecialchars($user_data['nombre'], ENT_QUOTES, 'UTF-8'); ?>" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?php echo htmlspecialchars($user_data['email'], ENT_QUOTES, 'UTF-8'); ?>" required><br><br>

    <label>Rol del sistema:</label><br>
    <select name="rol">
        <option value="user" <?php if ($user_data['rol'] == 'user') echo 'selected'; ?>>Usuario Estándar</option>
        <option value="admin" <?php if ($user_data['rol'] == 'admin') echo 'selected'; ?>>Administrador</option>
    </select><br><br>

    <button type="submit">Guardar Cambios</button>
    <a href="admin.php">Cancelar</a>
</form>
<?php require 'layout/footer.php'; ?>