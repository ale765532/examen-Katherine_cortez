<?php
require 'conexion.php';

// 1. LÓGICA DE ELIMINACIÓN
if (isset($_GET['eliminar_id'])) {
    $id = $_GET['eliminar_id'];
    $stmt = $pdo->prepare("DELETE FROM peliculas WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit;
}

// 2. LÓGICA DE CONSULTA CON BUSCADOR (Cláusula LIKE)
if (isset($_GET['buscar']) && !empty(trim($_GET['buscar']))) {
    $termino = "%" . trim($_GET['buscar']) . "%";
    $stmt = $pdo->prepare("SELECT * FROM peliculas WHERE titulo LIKE ?");
    $stmt->execute([$termino]);
} else {
    $stmt = $pdo->query("SELECT * FROM peliculas");
}
$peliculas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Películas Completo</title>
</head>
<body style="text-align: center; font-family: Arial, sans-serif; background-color: #f4f4f9; padding: 20px;">

    <h1>Catálogo de Películas</h1>
     
    <!-- Botones de Navegación -->
    <div style="margin-bottom: 20px;">
        <a href="agregar.php"><button style="padding: 10px 15px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Añadir Nueva Película</button></a>
        <a href="api/peliculas.php" target="_blank"><button style="padding: 10px 15px; background: #333; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">API REST</button></a>
    </div>

    <!-- Formulario del Buscador -->
    <form method="GET" style="margin-bottom: 30px;">
        <input type="text" name="buscar" placeholder="Buscar película por título..." value="<?php echo isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : ''; ?>" style="padding: 10px; width: 300px; border: 1px solid #ccc; border-radius: 4px;">
        <button type="submit" style="padding: 10px 15px; background: #333; color: white; border: none; border-radius: 4px; cursor: pointer;">Buscar</button>
        <?php if (isset($_GET['buscar']) && !empty($_GET['buscar'])): ?>
            <a href="index.php"><button type="button" style="padding: 10px 15px; background: #9e9e9e; color: white; border: none; border-radius: 4px; cursor: pointer;">Limpiar Filtro</button></a>
        <?php endif; ?>
    </form>

    <!-- Tabla HTML Centrada -->
    <table border="1" cellpadding="12" cellspacing="0" style="margin: 0 auto; min-width: 750px; border-collapse: collapse; background: white; box-shadow: 0 4px 8px rgba(0,0,0,0.05); border-radius: 8px; overflow: hidden; border: 1px solid #ddd;">
        <thead>
            <tr style="background-color: #333; color: white;">
                <th>ID</th>
                <th>Título</th>
                <th>Director</th>
                <th>Género</th>
                <th>Año</th>
                <th>Duración</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($peliculas)): ?>
                <tr><td colspan="7" style="color: #777; font-style: italic;">No se encontraron películas en el catálogo.</td></tr>
            <?php else: ?>
                <?php foreach ($peliculas as $pelicula): ?>
                    <tr>
                        <td><strong><?php echo $pelicula['id']; ?></strong></td>
                        <td><?php echo htmlspecialchars($pelicula['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($pelicula['director']); ?></td>
                        <td><span style="background: #e0e0e0; padding: 4px 8px; border-radius: 4px; font-size: 14px;"><?php echo htmlspecialchars($pelicula['genero']); ?></span></td>
                        <td><?php echo $pelicula['anio']; ?></td>
                        <td><?php echo $pelicula['duracion']; ?> min</td>
                        <td>
                            <a href="editar.php?id=<?php echo $pelicula['id']; ?>" style="color: #2196F3; font-weight: bold; text-decoration: none;">Modificar</a> | 
                            <a href="index.php?eliminar_id=<?php echo $pelicula['id']; ?>" onclick="return confirm('¿Seguro que deseas eliminar esta película?');" style="color: #f44336; font-weight: bold; text-decoration: none;">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
