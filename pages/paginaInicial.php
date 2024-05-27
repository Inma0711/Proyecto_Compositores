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
    <script src="../js/registroCompositor.js" defer></script>
    <title>Document</title>
</head>
<body>
<div class="boton" id="boton">
    <i class="fa-solid fa-bars fa-2xl" style="color: #ffffff" id="boton"></i>
   </div>
   <div class="aside" id="aside">
    <a href="paginaInicial.php" class="item_aside">
     <i class="fa-solid fa-house fa-2xl" style="color: #ffffff"></i>
    </a>
    <a href="registroCompositores.php" class="item_aside">
     <i class="fa-solid fa-pen-nib fa-2xl" style="color: #ffffff"></i>
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
    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        // Generar la tabla HTML
        echo "<table border='1' width='100%'>";
        echo "<tr class='table-header'><th>Compositor</th><th>Música</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr class='table-row'><td>" . $row["compositor"] . "</td><td>" . $row["musica"] . "</td></tr>";
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