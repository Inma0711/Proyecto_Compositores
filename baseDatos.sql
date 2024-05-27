CREATE TABLE compositores (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100)
);

CREATE TABLE peliculas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(100),
  compositor_id INT,
  FOREIGN KEY (compositor_id) REFERENCES compositores(id)
);

/*----------------CONSULTAS-------------------*/
SELECT compositores.nombre AS compositor, peliculas.titulo AS pelicula
FROM compositores
INNER JOIN peliculas ON compositores.id = peliculas.compositor_id;