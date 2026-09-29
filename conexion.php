<?php
$host_actual = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? '';

// 1. Si estamos dentro del contenedor de Docker (puerto 8080)
if (strpos($host_actual, '8080') !== false) {
    $host = 'db';              // En Docker el host de la BD se llama 'db'
    $db   = 'cine_completo';
    $user = 'root';
    $pass = '';
}
// 2. Si estamos en XAMPP local (localhost normal)
elseif (strpos($host_actual, 'localhost') !== false || $host_actual === '127.0.0.1') {
    $host = 'localhost';
    $db   = 'cine_completo';
    $user = 'root';
    $pass = '';
}
// 3. Si estamos en la nube (InfinityFree)
else {
    $host = 'sql104.infinityfree.com';
    $db   = 'if0_42974924_cine';
    $user = 'if0_42974924';
    $pass = 'TU_CONTRASEÑA_INFINITYFREE'; // Pon aquí tu contraseña real
}


$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error crítico de conexión: " . $e->getMessage());
}
?>
