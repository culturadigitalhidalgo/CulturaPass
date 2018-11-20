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
$args = array(
'post_type' => 'infraestructura',
'orderby' => 'title',
'order' => 'ASC',
'posts_per_page' => -1,
'meta_query' => array(
          array(
              'key' => 'tipo_recinto', 
              'value' => 'Recinto', //7923
              'compare' => '=='
          ))
);

$recintos = new WP_Query($args);
//print_r($recintos);
echo '<option value="0">Todos los recintos</option>';
foreach ( $recintos->posts as $res ) {
	echo '<option value="'.$res->ID.'">'.$res->post_title.'</option>';
		/*$args2 = array(
		'post_type'      => 'infraestructura',
		'order'          => 'ASC',
		'posts_per_page' => -1,
		'meta_query' => array(
		          array(
		              'key' => 'recinto', 
		              'value' => $res->ID, //7923
		              'compare' => '=='
		          ))
		);
		$hijos = new WP_Query($args2);
			foreach ( $hijos->posts as $hijo ) {
				echo '<option value="'.$hijo->ID.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$hijo->post_title.'</option>';
			}*/
}
?>

