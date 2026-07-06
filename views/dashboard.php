<?php
// Inicia la sesión y carga las dependencias necesarias.
session_start();
require_once '../config/db.php';
require_once '../config/crypto.php';
require_once '../models/password_model.php';

// Protege la página para usuarios autenticados.
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['usuario_id'];

// Obtiene las contraseñas cifradas del usuario.
$resultado = listarPasswords($conn, $user_id);
$hayPasswords = ($resultado->num_rows > 0);
?>
<?php require 'layout/header.php'; ?>

<!-- Mensaje de bienvenida al usuario autenticado. -->
<p>Bienvenido, <strong><?php echo htmlspecialchars($_SESSION['usuario_nombre'], ENT_QUOTES, 'UTF-8'); ?></strong></p>
<?php if ($_SESSION['usuario_rol'] === 'admin'): ?>
    <!-- Aviso para accesos administrativos. -->
    <div style="background: #fff3cd; padding: 15px; border: 1px solid #ffeeba; margin-bottom: 20px; border-radius: 5px;">
        <strong>Modo Administrador:</strong>
        <a href="admin.php">Gestionar usuarios del sistema</a>
    </div>
<?php endif; ?>

<h2>Mis contraseñas guardadas</h2>

<!-- Mensajes de confirmación para operaciones sobre credenciales. -->
<?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
    <p style="color: red;">Credencial eliminada con éxito.</p>
<?php endif; ?>
<?php if (isset($_GET['msg']) && $_GET['msg'] == 'updated'): ?>
    <p style="color: green;">Credencial actualizada con éxito.</p>
<?php endif; ?>
<?php if (isset($_GET['msg']) && $_GET['msg'] == 'created'): ?>
    <p style="color: green;">Credencial guardada con éxito.</p>
<?php endif; ?>


<?php if (!$hayPasswords): ?>
    <p>No tienes credenciales almacenadas todaví­a.</p>
<?php else: ?>
    <!-- Tabla con contraseñas cifradas y acciones disponibles. -->
    <table border="1" style="width: 100%; text-align: left; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>Sitio</th>
                <th>Categorí­a</th>
                <th>URL</th>
                <th>Cifrado (BD)</th>
                <th>Contraseña real</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $resultado->fetch_assoc()):

                // Descifra la contraseña almacenada para mostrarla bajo demanda.
                $pass_real = descifrar($row['password_cifrada']);
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nombre_sitio'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre_categoria'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                        <a href="<?php echo htmlspecialchars($row['url_sitio'], ENT_QUOTES, 'UTF-8'); ?>"
                            target="_blank"
                            rel="noopener noreferrer">
                            >Abrir enlace
                        </a>
                    </td>
                    <td><small><code><?php echo htmlspecialchars($row['password_cifrada'], ENT_QUOTES, 'UTF-8'); ?></code></small></td>
                    <td>
                        <!-- Muestra la contraseña real solo al hacer clic en el botón. -->
                        <span class="masked-password">••••••••</span>
                        <span class="real-password" style="display:none;"><?php echo htmlspecialchars($pass_real, ENT_QUOTES, 'UTF-8'); ?></span>
                        <button type="button" class="toggle-password" onclick="togglePasswordVisibility(this)">Mostrar</button>
                    </td>
                    <td>
                        <a href="editar_password.php?id=<?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>">Editar</a> |
                        <a href="../controllers/borrar_password.php?id=<?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>" onclick="return confirm('¿Estás seguro de eliminar la contraseña?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php endif; ?>

<script>
// Alterna la visibilidad de la contraseña en cada fila.
function togglePasswordVisibility(button) {
    var cell = button.closest('td');
    if (!cell) return;
    var masked = cell.querySelector('.masked-password');
    var real = cell.querySelector('.real-password');
    if (!masked || !real) return;

    if (real.style.display === 'none') {
        real.style.display = '';
        masked.style.display = 'none';
        button.textContent = 'Ocultar';
    } else {
        real.style.display = 'none';
        masked.style.display = '';
        button.textContent = 'Mostrar';
    }
}
</script>

<?php require 'layout/footer.php'; ?>
