<?php require 'layout/header.php'; ?>

<!-- Título de la página de registro. -->
<h2>Crear una cuenta</h2>

<!-- Mensajes de error opcionales según la validación del registro. -->
<?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
    <p style="color: red">El usuario ya existe. Inicia sesión</p>
<?php endif; ?>
<?php if (isset($_GET['error']) && $_GET['error'] == 2): ?>
    <p style="color: red">La contraseña no es segura. Debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un símbolo.</p>
<?php endif; ?>

<!-- Formulario de registro que envía los datos al controlador. -->
<form action="../controllers/procesar_registro.php" method="post">
    <fieldset>
        <legend>Datos de inicio de sesión</legend>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contraseña" required>
        <button type="button" class="toggle-password" onclick="togglePasswordVisibility('contrasena', this)">Mostrar</button><br>
    </fieldset>
    <button type="submit">Registrarse</button>
</form>

<!-- Enlace para usuarios que ya tienen cuenta. -->
<p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>

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

