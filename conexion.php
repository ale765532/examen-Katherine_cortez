<?php
$host = 'localhost';
$db   = 'cine_completo'; // Nombre de tu nueva base de datos actualizada
$user = 'root'; 
$pass = '';     
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error crítico de conexión: " . $e->getMessage());
}
?>

