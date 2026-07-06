<?php
// Inicia la sesión para comprobar si el usuario está autenticado.
session_start();
require_once '../config/db.php';
require_once '../models/user_model.php';

// Solo los administradores pueden acceder a esta página.
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}

// Obtiene la lista completa de usuarios para mostrar en la tabla.
$resultado = listarUsuarios($conn);
?>
<?php require 'layout/header.php'; ?>

<!-- Mensaje de bienvenida para el administrador autenticado. -->
<p>Bienvenido, <strong><?php echo htmlspecialchars($_SESSION['usuario_nombre'], ENT_QUOTES, 'UTF-8'); ?></strong></p>
<h2>Gestión de Usuarios</h2>

<!-- Notificación de operación exitosa al eliminar un usuario. -->
<?php if (isset($_GET['msg']) && $_GET['msg'] == 'usuario_eliminado'): ?>
    <p style="color: green;">El usuario ha sido eliminado correctamente.</p>
<?php endif; ?>

<!-- Tabla que muestra todos los usuarios registrados. -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['rol'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                    <!-- Solo muestra acciones para otros usuarios, no para el propio administrador. -->
                    <?php if ($row['id'] != $_SESSION['usuario_id']): ?>
                        <a href="editar_usuario.php?id=<?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>">Editar</a> |
                        <a href="../controllers/borrar_usuario.php?id=<?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>"
                            onclick="return confirm('¿Estás seguro de eliminar a este usuario?')">Eliminar</a>
                    <?php else: ?>
                        <strong>(Tú)</strong>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php require 'layout/footer.php'; ?>