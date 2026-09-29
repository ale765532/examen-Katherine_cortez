<?php
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); 
    echo json_encode(["error" => "Método no permitido."]);
    exit;
}


require '../conexion.php'; 

try {
    $stmt = $pdo->query("SELECT * FROM peliculas");
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($resultados);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error interno en el servidor: " . $e->getMessage()]);
}
?>
