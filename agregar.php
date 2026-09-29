<?php
require 'conexion.php';
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $director = trim($_POST['director']);
    $genero = isset($_POST['genero']) ? trim($_POST['genero']) : ""; 
    $anio = trim($_POST['anio']);
    $duracion = trim($_POST['duracion']);

    // Validación obligatoria de los 5 campos del examen
    if (empty($titulo) || empty($director) || empty($genero) || empty($anio) || empty($duracion)) {
        $error = "Todos los campos son obligatorios. Por favor, completa el formulario.";
    } else {
        // Consulta preparada con 4 signos de interrogación para los valores informativos
        $stmt = $pdo->prepare("INSERT INTO peliculas (titulo, director, genero, anio, duracion) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$titulo, $director, $genero, $anio, $duracion]);
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Película</title>
</head>
<body style="text-align: center; font-family: Arial, sans-serif; background-color: #f4f4f9; padding: 20px;">

    <h1>Añadir Nueva Película</h1>
    <a href="index.php" style="text-decoration: none; color: #2196F3; font-weight: bold;">Volver al catálogo</a><br><br>

    <?php if ($error): ?>
        <p style="color:red; font-weight:bold;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" style="background: white; max-width: 450px; margin: 0 auto; padding: 25px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: left;">
        
        <label style="font-weight: bold; color: #333;">Título de la Película:</label><br>
        <input type="text" name="titulo" style="width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;"><br>

        <label style="font-weight: bold; color: #333;">Director:</label><br>
        <input type="text" name="director" style="width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;"><br>

        <label style="font-weight: bold; color: #333;">Género de la Película:</label><br>
        <div style="margin-top: 5px; margin-bottom: 15px; background: #fafafa; padding: 12px; border: 1px dashed #ccc; border-radius: 4px; line-height: 1.8;">
            <input type="radio" id="accion" name="genero" value="Acción/Aventuras" checked>
            <label for="accion">Acción/Aventuras</label><br>

            <input type="radio" id="terror" name="genero" value="Terror">
            <label for="terror">Terror</label><br>

            <input type="radio" id="romantica" name="genero" value="Romántica">
            <label for="romantica">Romántica</label><br>

            <input type="radio" id="drama" name="genero" value="Drama">
            <label for="drama">Drama</label><br>

            <input type="radio" id="comedia" name="genero" value="Comedia">
            <label for="comedia">Comedia</label><br>

            <input type="radio" id="otro" name="genero" value="Otro">
            <label for="otro">Otro</label>
        </div>

        <label style="font-weight: bold; color: #333;">Año de Estreno:</label><br>
        <input type="number" name="anio" style="width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;"><br>

        <label style="font-weight: bold; color: #333;">Duración (en minutos):</label><br>
        <input type="number" name="duracion" style="width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;"><br>

        <div style="text-align: center;">
            <button type="submit" style="background-color: #4CAF50; color: white; padding: 12px 25px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold; width: 100%;">Guardar Película</button>
        </div>
    </form>

</body>
</html>
