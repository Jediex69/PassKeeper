<?php

// Devuelve el usuario registrado según su correo electrónico.
function obtenerUsuarioPorEmail($conn, $email) {
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Lista todos los usuarios con datos básicos para el panel de administración.
function listarUsuarios($conn) {
    $sql = "SELECT id, nombre, email, rol FROM usuarios";
    $resultado = $conn->query($sql);
    return $resultado;
}

// Elimina un usuario de la base de datos por su ID.
function eliminarUsuario($conn, $id) {
    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// Inserta un nuevo usuario con rol 'user' y su contraseña cifrada.
function registrarUsuario($conn, $nombre, $email, $password_hash) {
    $sql = "INSERT INTO usuarios (nombre, email, password_master, rol) VALUES (?, ?, ?, 'user')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre, $email, $password_hash);
    return $stmt->execute();
}

// Obtiene los datos públicos de un usuario por su ID.
function obtenerUsuarioPorId($conn, $id) {
    $sql = "SELECT id, nombre, email, rol FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Actualiza nombre, email y rol del usuario identificado por ID.
function actualizarUsuario($conn, $id, $nombre, $email, $rol) {
    $sql = "UPDATE usuarios SET nombre = ?, email = ?, rol = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $email, $rol, $id);
    return $stmt->execute();
}
?>