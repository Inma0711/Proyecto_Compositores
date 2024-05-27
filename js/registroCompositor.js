document.getElementById("boton").addEventListener("click", function() {
    let menu = document.querySelector(".aside");
    // La clase hidden se añade o se quita con cada click.
    menu.classList.toggle("hidden");
});

