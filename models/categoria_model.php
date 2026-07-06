<?php

// Obtiene todas las categorías del usuario actual.
function listarCategorias($conn, $id_usuario) {
    $sql = "SELECT * FROM categorias WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    return $stmt->get_result();
}

// Inserta una nueva categoría para el usuario especificado.
function crearCategoria($conn, $nombre, $id_usuario) {
    $sql = "INSERT INTO categorias (nombre_categoria, id_usuario) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nombre, $id_usuario);
    return $stmt->execute();
}

// Elimina una categoría solo si pertenece al usuario actual.
function eliminarCategoria($conn, $id_cat, $id_usuario) {
    $sql = "DELETE FROM categorias WHERE id = ? AND id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_cat, $id_usuario);
    return $stmt->execute();
}
?>