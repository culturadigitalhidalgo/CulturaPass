<?php  
/* 
* Municipios
* @category Municipios
* Author's: Eliel Trigueros Hernandez
* Author URI: http://cultura.hidalgo.gob.mx
* @since Versión 1.0, revisión 1. Abril/2018
*/
require ('../../../../../wp-load.php');
$posts = get_posts(array(
    'post_type'   => 'eventos',
    'post_status' => 'publish',
    'posts_per_page' => -1
    )
);

foreach($posts as $p){
	$lugar=get_field('lugar', $p->ID);
    $municipios[]=get_field('municipio', $lugar->ID);
	//$publico[] = get_post_meta($p->ID,"publico",true);
}

$resultado = array_filter(array_unique($municipios), "strlen");
echo '<option value="0">Todos los municipios</option>';
sort($resultado);
foreach ($resultado as $valor) {
   echo '<option value="'.$valor.'">'.$valor.'</option>';
}
?>