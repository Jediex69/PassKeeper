<?php require 'layout/header.php'; ?>
<h2>Iniciar Sesión</h2>

<?php
// Muestra mensaje de error si las credenciales no coinciden.
if (isset($_GET['error'])) {
    echo "<p style='color:red;'>Credenciales incorrectas.</p>";    
}

// Muestra confirmación tras un registro exitoso.
if (isset($_GET['msg']) && $_GET['msg'] == 'registered') {
    echo "<p style='color:green;'>Registro completado. ¡Ya puedes entrar!</p>";
}
?>

<!-- Formulario de inicio de sesión con email y contraseña. -->
<form action="../controllers/procesar_login.php" method="post">
    <fieldset>
        <legend>Accede a tu área personal</legend>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contraseña" required>
        <button type="button" class="toggle-password" onclick="togglePasswordVisibility('contrasena', this)">Mostrar</button><br>
    </fieldset>
    <button type="submit">Entrar</button>
</form>

<!-- Enlace a la página de registro para nuevos usuarios. -->
<p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>

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
<?php require 'layout/footer.php'; ?>