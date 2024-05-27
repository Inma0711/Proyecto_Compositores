<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/registroCompositores.css">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
      integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <?php require '../includes/conexion.php' ?>
    <?php require '../includes/depurar.php' ?>
    <script src="../js/registroCompositor.js" defer></script>
    <title>Inicial</title>
</head>
<body>

<?php
// Verificar si se han enviado los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario y sanitizarlos
    $temp_compositor = depurar($_POST["nombre_compositor"]);
    $temp_pelicula = depurar($_POST["nombre_pelicula"]);
    $temp_pista_musica = $_FILES["pista_musica"]["name"]; // Obtener el nombre del archivo de la pista de música

    // Validación de nombre del compositor
    if (empty($temp_compositor)) {
        $err_compositor = "El nombre del compositor es obligatorio.";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $temp_compositor)) {
        $err_compositor = "El nombre del compositor solo puede contener letras y espacios.";
    }else {
        $nombre_compositor = $temp_compositor;
    }
    // Validación de nombre de la película
    if (empty($temp_pelicula)) {
        $err_pelicula = "El nombre de la música es obligatorio.";
    }else {
        $nombre_pelicula = $temp_pelicula;
    }

    // Validar y guardar la pista de música si se proporciona
    if (!empty($temp_pista_musica)) {
        // Mover el archivo de la pista de música al directorio de destino
        $directorio_destino = "ruta/del/directorio/destino/"; // Cambia esto por la ruta de tu directorio de destino
        $ruta_pista_musica = $directorio_destino . basename($temp_pista_musica);
        move_uploaded_file($_FILES["pista_musica"]["tmp_name"], $ruta_pista_musica);
    }
}
    if (isset($nombre_compositor) && isset($nombre_pelicula)) {
        $sql_check = "SELECT * FROM peliculas WHERE titulo = '$nombre_pelicula' AND compositor_id IN (SELECT id FROM compositores WHERE nombre = '$nombre_compositor')";
        $result = $conexion->query($sql_check);
    if ($result && $result->num_rows > 0) {
        // Si ya existe una película con ese título para el compositor, mostrar un mensaje de error
        $err_peli = "Ya existe una película con ese título para este compositor.";
    } else {
        // Si la película no existe, insertarla en la base de datos
        $sql1 = "INSERT INTO compositores (nombre) VALUES ('$nombre_compositor')";
        $conexion->query($sql1);
        // Obtener el ID del compositor recién insertado
        $compositor_id = $conexion->insert_id;
        $sql2 = "INSERT INTO peliculas (titulo, compositor_id) VALUES ('$nombre_pelicula', '$compositor_id')";
        $conexion->query($sql2);
        $correcto = "Se ha insertado correctamente";
    }
   }
?>

   <div class="boton" id="boton">
    <i class="fa-solid fa-bars fa-2xl" style="color: #ffffff" id="boton"></i>
   </div>
   <div class="aside" id="aside">
    <a href="paginaInicial.php" class="item_aside">
     <i class="fa-solid fa-house fa-2xl" style="color: #ffffff"></i>
    </a>
    <a href="" class="item_aside">
     <i class="fa-solid fa-pen-nib fa-2xl" style="color: #ffffff"></i>
    </a>
   </div>

   <div class="body">
    <div class="formulario_container">
        <form action="" method="post" id="registrar_compositor" enctype="multipart/form-data">
            <div class="borde_dentro">
                <h2 class="titulo">Compositores rexulones</h2>
                <div class="compositor_container">
                    <input type="text" id="nombre_compositor" name="nombre_compositor" placeholder="Compositor"><br><br>
                    <i class="fa-solid fa-user fa-xl" style="color: #ffffff"></i>
                    <?php if (isset($err_compositor)) echo $err_compositor ?>
                </div>
                <div class="compositor_container">
                    <input type="text" id="nombre_pelicula" name="nombre_pelicula" placeholder="Película" required><br><br>
                    <i class="fa-solid fa-film fa-xl" style="color: #ffffff"></i>
                    <?php if (isset($err_pelicula)) echo $err_pelicula ?>
                </div>
                <div class="compositor_container">
                    <input type="file" id="pista_musica" name="pista_musica" accept=".mp3, .wav">
                    <i class="fa-solid fa-music fa-xl" style="color: #ffffff"></i>
                </div>
            
                <input type="submit" class="register_boton" value="Insertar">
                <?php if (isset($err_peli)) echo "<p style='color: #ff0000; display: inline-block;'> <i class='fa-solid fa-circle-exclamation'></i> $err_peli</p>"; ?>
                <?php if (isset($correcto)) echo "<p style='color: #67ff39; display: inline-block;'> <i class='fa-solid fa-circle-exclamation'></i> $correcto</p>"?>

            </div>
        </form>
    </div>
</div>

</body>
</html>