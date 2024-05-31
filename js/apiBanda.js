/*
document.addEventListener('DOMContentLoaded', function () {
  document.getElementById("pulsa").addEventListener("click", function () {

    fetch('../bandaSonora.json')
      .then(response => response.json()) // Parseamos la respuesta como JSON
      .then(data => {
        // Obtener la lista de compositores del JSON
        const compositores = data.compositores;

        // Obtener un índice aleatorio para seleccionar un compositor aleatorio
        const indiceCompositorAleatorio = aleatorio(compositores.length);
        // Obtener el compositor aleatorio
        const compositorAleatorio = compositores[indiceCompositorAleatorio];

        // Obtener la lista de bandas sonoras del compositor aleatorio
        const bandaSonoras = compositorAleatorio.bandaSonoras;

        // Obtener un índice aleatorio para seleccionar una banda sonora aleatoria
        const indiceBandaSonoraAleatoria = aleatorio(bandaSonoras.length);
        // Obtener la banda sonora aleatoria
        const bandaSonoraAleatoria = bandaSonoras[indiceBandaSonoraAleatoria];
        // Obtener el source de la banda sonora aleatoria

        // Imprimir la banda sonora aleatoria
        console.log("Banda sonora aleatoria:", compositorAleatorio.compositor + " - " + bandaSonoraAleatoria.titulo);
      });
  });
});
*/document.addEventListener('DOMContentLoaded', function () {
  let randomSelection = null;

  document.getElementById("pulsa1").addEventListener("click", function () {
    fetch('../bandaSonora.json')
      .then(response => response.json())
      .then(data => {
        randomSelection = getRandomBandaSonora(data.compositores);

        // Reproducir música en cubo3
        const musicPlayer = document.getElementById('music-player');
        musicPlayer.src = randomSelection.bandaSonora.source;

        // Manejo de errores de carga
        musicPlayer.onerror = function () {
          console.error('Error al cargar el recurso de medios:', musicPlayer.src);
          alert('Error al cargar el recurso de medios. Por favor, inténtalo de nuevo.');
        };

        musicPlayer.play()
          .catch(error => {
            console.error('Error al reproducir el recurso de medios:', error);
            alert('Error al reproducir el recurso de medios. Por favor, inténtalo de nuevo.');
          });
      })
      .catch(error => {
        console.error('Error al cargar el JSON:', error);
        alert('Error al cargar el JSON. Por favor, verifica la URL y el formato del archivo.');
      });
  });

  document.getElementById("pulsa2").addEventListener("click", function () {
    if (randomSelection) {
      document.getElementById('cubo1').innerText = randomSelection.compositor;
      document.getElementById('cubo2').innerText = randomSelection.bandaSonora.titulo;
    } else {
      alert('Primero debes cargar una banda sonora con el botón "Banda".');
    }
  });

  function getRandomBandaSonora(compositores) {
    const randomComposer = compositores[Math.floor(Math.random() * compositores.length)];
    const randomBandaSonora = randomComposer.bandaSonoras[Math.floor(Math.random() * randomComposer.bandaSonoras.length)];
    return {
      compositor: randomComposer.compositor,
      bandaSonora: randomBandaSonora
    };
  }
});
/*
function aleatorio(ale) {
  return Math.floor(Math.random() * ale);
}
*/