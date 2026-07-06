<?php
define('METODO', 'AES-256-CTR');

// Sustituir por una clave segura en el entorno local/producción.
// No subir claves reales al repositorio.
define('LLAVE_SECRETA', 'TU_CLAVE_SECRETA_AQUI');

function cifrar($dato) {
    $ivLength = openssl_cipher_iv_length(METODO);
    $iv = random_bytes($ivLength);

    $cifrado = openssl_encrypt($dato, METODO, LLAVE_SECRETA, OPENSSL_RAW_DATA, $iv);

    return base64_encode($iv) . ':' . base64_encode($cifrado);
}

function descifrar($dato_cifrado) {
    $partes = explode(':', $dato_cifrado, 2);

    if (count($partes) !== 2) {
        return false;
    }

    $iv = base64_decode($partes[0]);
    $cifrado = base64_decode($partes[1]);

    return openssl_decrypt($cifrado, METODO, LLAVE_SECRETA, OPENSSL_RAW_DATA, $iv);
}
?>