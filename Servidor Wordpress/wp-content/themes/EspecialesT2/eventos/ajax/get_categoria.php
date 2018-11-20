<?php  
/* 
* Categoria
* 
* @category Cartegoria
* @author Centro de Información Cultural del Estado de Hidalgo CECULTAH <cic.innovacion@gmail.com>
* @copyleft Algunos derechos reservados Centro de Información Cultural del Estado de Hidalgo SC
* @since Versión 1.0, revisión 1. Marzo/2017
* @versión 1.0 
*/
require ('../../../../../wp-load.php');
$categories = get_terms(array(
    'taxonomy' => 'categorias_eventos',
    'hide_empty' => false
));

echo '<option value="0">Todas las categorías</option>';
foreach ( $categories as $cat ) {
	echo '<option value="'.$cat->term_id.'">'.$cat->name.'</option>';
}

?>
