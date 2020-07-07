<?php

//funcion para capturar los errores en logs 
function error($numero,$texto){ 
    $ddf = fopen('error.log','a'); 
    fwrite($ddf,"[".date("r")."] Error $numero:$texto\r\n"); 
    fclose($ddf); 
}
//para usarlo en las funciones:
//set_error_handler('error');

?>