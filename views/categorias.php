<?php
// Inicia sesión y carga dependencias necesarias.
session_start();
require_once '../config/db.php';
require_once '../models/categoria_model.php';

// Protege el acceso solo para usuarios autenticados.
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['usuario_id'];

// Procesa la creación de una nueva categoría enviada por POST.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre_cat'])) {
    $nombre = trim($_POST['nombre_cat']);
    if (!empty($nombre)) {
        crearCategoria($conn, $nombre, $user_id);

        header("Location: categorias.php?status=success");
        exit();
    }
}

// Recupera las categorías del usuario para mostrarlas en la tabla.
$resultado = listarCategorias($conn, $user_id);
?>
<?php require 'layout/header.php'; ?>

<!-- Título principal y descripción del área de categorías. -->
<h2>Mis Categorías</h2>
<p>Organiza tus contraseñas creando grupos (ej: Trabajo, Personal, Bancos).</p>

<!-- Formulario para crear una nueva categoría. -->
<form action="categorias.php" method="post" style="margin-bottom: 20px;">
    <input type="text" name="nombre_cat" placeholder="Nombre de la categoría..." required>
    <button type="submit">Añadir Categoría</button>
</form>

<!-- Tabla que lista las categorías del usuario. -->
<table border="1" style="width: 50%; text-align: left;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre de Categoría</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($cat = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($cat['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($cat['nombre_categoria'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                    <!-- Enlace seguro para eliminar la categoría con confirmación del usuario. -->
                    <a href="../controllers/borrar_categoria.php?id=<?php echo htmlspecialchars($cat['id'], ENT_QUOTES, 'UTF-8'); ?>"
                     onclick="return confirm('¿Eliminar esta categoría y sus contraseñas asociadas?')">Eliminar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php require 'layout/footer.php'; ?>