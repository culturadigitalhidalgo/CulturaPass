<?php
/*
*Eventos*
Name: Cartelera Digital
Author's: Eliel Trigueros Hernandez, Omar Oliver Rodriguez, Eloy Monter Hernández
Author URI: http://cultura.hidalgo.gob.mx
Version: 1.0
*/
?>
<form method="post" action="/administracion-de-eventos/"  target="_blank">
<input type="hidden" name="usuario" value="<?php echo $WP_User->ID; ?>"/>
<input type="submit" value="Administración de eventos" />
</form>
