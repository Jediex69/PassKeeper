<?php

// Recupera todas las contraseñas del usuario, junto con el nombre de su categoría.
function listarPasswords($conn, $id_usuario) {
    $sql = "SELECT p.*, c.nombre_categoria 
            FROM passwords p
            INNER JOIN categorias c ON p.id_categoria = c.id
            WHERE p.id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    return $stmt->get_result();
}

// Inserta una nueva credencial cifrada para el usuario y su categoría.
function insertarPassword($conn, $nombre_sitio, $url_sitio, $pass_cifrada, $id_usuario, $id_categoria) {
    $sql = "INSERT INTO passwords (nombre_sitio, url_sitio, password_cifrada, id_usuario, id_categoria) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $nombre_sitio, $url_sitio, $pass_cifrada, $id_usuario, $id_categoria);
    return $stmt->execute();
}

// Borra una contraseña solo si pertenece al usuario autenticado.
function eliminarPassword($conn, $id_pass, $id_usuario) {
    $sql = "DELETE FROM passwords WHERE id = ? AND id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_pass, $id_usuario);
    return $stmt->execute();
}

// Obtiene una credencial específica del usuario por su ID.
function obtenerPasswordPorId($conn, $id_pass, $id_usuario) {
    $sql = "SELECT * FROM passwords WHERE id = ? AND id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_pass, $id_usuario);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Actualiza los datos de una contraseña existente del usuario.
function actualizarPassword($conn, $id_pass, $nombre, $url, $pass_cifrada, $id_cat, $id_user) {
    $sql = "UPDATE passwords 
            SET nombre_sitio = ?, url_sitio = ?, password_cifrada = ?, id_categoria = ? 
            WHERE id = ? AND id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiii", $nombre, $url, $pass_cifrada, $id_cat, $id_pass, $id_user);
    return $stmt->execute();
}
?>