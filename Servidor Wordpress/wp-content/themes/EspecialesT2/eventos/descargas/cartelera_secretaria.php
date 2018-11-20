<?php
/*
*Eventos*
Name: Cartelera Digital
Author's: Eliel Trigueros Hernandez, Omar Oliver Rodriguez, Eloy Monter Hernández
Author URI: http://cultura.hidalgo.gob.mx
* @since Versión 2.0, revisión 2. Mayo/2017
*/

$nombre_archivo = "cartelera_secretaria.html"; 


$fp=fopen($nombre_archivo,"w+");
$contenido = '';

$data = file_get_contents("http://cultura.hidalgo.gob.mx/cartelera-descarga-secretaria/");
fwrite($fp,$data);
fclose($fp);

header ("Content-Disposition: attachment; filename=".$nombre_archivo."");
header ("Content-Type: application/octet-stream");
header ("Content-Length: ".filesize($nombre_archivo));
readfile($nombre_archivo); 
 ?>
