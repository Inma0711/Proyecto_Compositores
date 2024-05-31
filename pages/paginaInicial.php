<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/paginaInicial.css">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
      integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <?php require '../includes/conexion.php' ?>
    <script src="../js/aside.js" defer></script>
    <title>Document</title>
</head>
<body>
<div class="boton" id="boton">
    <i class="fa-solid fa-bars fa-2xl" style="color: #ffffff" id="boton"></i>
   </div>
   <div class="aside" id="aside">
   <a href="" class="item_aside">
     <i class="fa-solid fa-house fa-2xl" style="color: #ffffff"></i>
    </a>
    <a href="registroCompositores.php" class="item_aside">
     <i class="fa-solid fa-pen-nib fa-2xl" style="color: #ffffff"></i>
    </a>
    <a href="bandaApi.html" class="item_aside">
     <i class="fa-solid fa-music fa-2xl" style="color: #ffffff"></i>
    </a>
   </div>

<?php
// Consulta SQL para obtener los compositores y sus músicas
$sql = "
    SELECT compositores.nombre AS compositor, peliculas.titulo AS musica
    FROM compositores
    JOIN peliculas ON compositores.id = peliculas.compositor_id
";
$result = $conexion->query($sql);
?>
<div class="container">
    <div class="borde_dentro">
        <h1>Lista de Compositores y sus Músicas</h1>
        <div class="table-container">
            <?php
            
            // Manejar la eliminación
            if (isset($_POST['delete'])) {
                $compositor_id = $_POST['compositor_id'];
                $pelicula_id = $_POST['pelicula_id'];

                // Eliminar la música
                $sql_delete_pelicula = "DELETE FROM peliculas WHERE id = ? AND compositor_id = ?";
                $stmt_pelicula = $conexion->prepare($sql_delete_pelicula);
                $stmt_pelicula->bind_param("ii", $pelicula_id, $compositor_id);
                if ($stmt_pelicula->execute()) {
                   "<script>console.log('Música eliminada correctamente');</script>";
                } else {
                    echo "Error al eliminar película: " . $stmt_compositor->error . "</p>";
                }
                $stmt_pelicula->close();

                // Eliminar el compositor si ya no tiene más películas
                $sql_check_compositor = "SELECT COUNT(*) AS conteo FROM peliculas WHERE compositor_id = ?";
                $stmt_check = $conexion->prepare($sql_check_compositor);
                $stmt_check->bind_param("i", $compositor_id);
                $stmt_check->execute();
                $result_check = $stmt_check->get_result();
                $row_check = $result_check->fetch_assoc();
                if ($row_check['conteo'] == 0) {
                    $sql_delete_compositor = "DELETE FROM compositores WHERE id = ?";
                    $stmt_compositor = $conexion->prepare($sql_delete_compositor);
                    $stmt_compositor->bind_param("i", $compositor_id);
                    if ($stmt_compositor->execute()) {
                        "<script>console.log('Compositor eliminado correctamente');</script>";
                    } else {
                        echo "Error al eliminar el compositor: " . $stmt_compositor->error . "</p>";
                    }
                    $stmt_compositor->close();
                }
                $stmt_check->close();
            }

            // Consulta SQL para obtener los compositores y sus músicas
            $sql = "
                SELECT compositores.id AS compositor_id, compositores.nombre AS compositor, peliculas.id AS pelicula_id, peliculas.titulo AS musica
                FROM compositores
                JOIN peliculas ON compositores.id = peliculas.compositor_id
            ";
            $result = $conexion->query($sql);

            // Verificar si hay resultados
            if ($result && $result->num_rows > 0) {
                // Generar la tabla HTML
                echo "<table border='1' width='100%'>";
                echo "<tr class='table-header'><th>Compositor</th><th>Música</th><th>Acciones</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr class='table-row'>";
                    echo "<td>" . $row["compositor"] . "</td>";
                    echo "<td>" . $row["musica"] . "</td>";

                    // Botón de borrar
                    echo "<td>
                        <form action='' method='post' onsubmit='return confirm(\"¿Seguro que deseas eliminar este registro?\");'>
                            <input type='hidden' name='compositor_id' value='" . $row["compositor_id"] . "'>
                            <input type='hidden' name='pelicula_id' value='" . $row["pelicula_id"] . "'>
                            <button type='submit' name='delete' class='botoncito'>Borrar</button>
                        </form>
                    </td>";

                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<div class='no-results'>No se encontraron resultados.</div>";
            }

            // Cerrar la conexión
            $conexion->close();
            ?>
        </div>
    </div>
</div>

</body>
</html>