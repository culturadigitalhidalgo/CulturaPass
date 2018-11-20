<?php  
/* 
* Carteles
* 
* @category Carteles
* @author Centro de Información Cultural del Estado de Hidalgo CECULTAH <cic.innovacion@gmail.com>
* @copyleft Algunos derechos reservados Centro de Información Cultural del Estado de Hidalgo SC
* @since Versión 1.0, revisión 1. Marzo/2017
* @versión 1.0 
*/
require ('../../../../../wp-load.php');
$posts = get_posts(array(
    'post_type'   => 'eventos',
    'post_status' => 'publish',
    'meta_key' => 'tipo_organismo',
	'meta_value' => '2',
    'posts_per_page' => -1
    )
);

foreach($posts as $p){
	$publico[] = get_post_meta($p->ID,"publico",true);
}

$resultado = array_unique($publico);
echo '<option value="0">Todos los públicos</option>';

foreach ($resultado as $valor) {
   echo '<option value="'.$valor.'">'.$valor.'</option>';
}

?>
