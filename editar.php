<?php
require 'conexion.php';
$error = "";

if (!isset($_GET['id'])) { header("Location: index.php"); exit; }
$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM peliculas WHERE id = ?");
$stmt->execute([$id]);
$pelicula = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pelicula) { die("La película solicitada no existe."); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $director = trim($_POST['director']);
    $genero = isset($_POST['genero']) ? trim($_POST['genero']) : ""; 
    $anio = trim($_POST['anio']);
    $duracion = trim($_POST['duracion']);

    if (empty($titulo) || empty($director) || empty($genero) || empty($anio) || empty($duracion)) {
        $error = "No puedes dejar campos obligatorios vacíos.";
    } else {
        $stmt = $pdo->prepare("UPDATE peliculas SET titulo = ?, director = ?, genero = ?, anio = ?, duracion = ? WHERE id = ?");
        $stmt->execute([$titulo, $director, $genero, $anio, $duracion, $id]);
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Película</title> 
</head>
<body style="text-align: center; font-family: Arial, sans-serif; background-color: #f4f4f9; padding: 20px;">

    <h1>Modificar Película</h1>
    <a href="index.php" style="text-decoration: none; color: #2196F3; font-weight: bold;">Cancelar y Volver</a><br><br>

    <?php if ($error): ?><p style="color:red; font-weight:bold;"><?php echo $error; ?></p><?php endif; ?>

    <form method="POST" style="background: white; max-width: 450px; margin: 0 auto; padding: 25px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: left;">
        
        <label style="font-weight: bold;">Título:</label><br>
        <input type="text" name="titulo" value="<?php echo htmlspecialchars($pelicula['titulo']); ?>" style="width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;"><br>

        <label style="font-weight: bold;">Director:</label><br>
        <input type="text" name="director" value="<?php echo htmlspecialchars($pelicula['director']); ?>" style="width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;"><br>

        <label style="font-weight: bold;">Género:</label><br>
        <div style="margin-top: 5px; margin-bottom: 15px; background: #fafafa; padding: 12px; border: 1px dashed #ccc; border-radius: 4px; line-height: 1.8;">
            <input type="radio" id="accion" name="genero" value="Acción/Aventuras" <?php echo ($pelicula['genero'] === 'Acción/Aventuras') ? 'checked' : ''; ?>>
            <label for="accion">Acción/Aventuras</label><br>

            <input type="radio" id="terror" name="genero" value="Terror" <?php echo ($pelicula['genero'] === 'Terror') ? 'checked' : ''; ?>>
            <label for="terror">Terror</label><br>

            <input type="radio" id="romantica" name="genero" value="Romántica" <?php echo ($pelicula['genero'] === 'Romántica') ? 'checked' : ''; ?>>
            <label for="romantica">Romántica</label><br>

            <input type="radio" id="drama" name="genero" value="Drama" <?php echo ($pelicula['genero'] === 'Drama') ? 'checked' : ''; ?>>
            <label for="drama">Drama</label><br>

            <input type="radio" id="comedia" name="genero" value="Comedia" <?php echo ($pelicula['genero'] === 'Comedia') ? 'checked' : ''; ?>>
            <label for="comedia">Comedia</label><br>

            <input type="radio" id="otro" name="genero" value="Otro" <?php echo ($pelicula['genero'] === 'Otro') ? 'checked' : ''; ?>>
            <label for="otro">Otro</label>
        </div>

        <label style="font-weight: bold;">Año de Estreno:</label><br>
        <input type="number" name="anio" value="<?php echo $pelicula['anio']; ?>" style="width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;"><br>

        <label style="font-weight: bold;">Duración (min):</label><br>
        <input type="number" name="duracion" value="<?php echo $pelicula['duracion']; ?>" style="width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;"><br>

        <button type="submit" style="background-color: #2196F3; color: white; padding: 12px 25px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold; width: 100%;">Actualizar Película</button>
    </form>

</body>
</html>
