
<?php
/* Esta función se utiliza para depurar o limpiar una entrada de datos antes de su uso. */ 
function depurar($entrada) {
    /* función de PHP que convierte caracteres especiales en entidades HTML. Esta línea de código asegura 
    que los datos de entrada no contengan caracteres que puedan interpretarse como código HTML.*/ 
    $salida = htmlspecialchars($entrada); 
    /*  función de PHP que elimina espacios en blanco */ 
    $salida = trim($salida);
    return $salida;
}
?>