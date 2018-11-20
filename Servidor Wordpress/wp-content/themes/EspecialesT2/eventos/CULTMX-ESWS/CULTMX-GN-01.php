<?php  
/* 
* CULTMX-ESWS
* 
* @category Web Service 
* @Listado general de actividades disponibles en el sistema
* @author Centro de Cultura Digital del Estado de Hidalgo SC <cic.innovacion@gmail.com>
* @copyleft Algunos derechos reservados Centro de Cultura Digital del Estado de Hidalgo SC
* @since Versión 1.0, revisión 1. Junio/2018
* @versión 1.0 
*/

require('../../../../../wp-load.php');

$selFInicio =$_GET['fInicio'];
$selFFin =$_GET['fFin'];

$fInicio= str_replace('-','',$selFInicio);
$fFin= str_replace('-','',$selFFin);

$db = new wpdb('cultura','rP6dTF6C.JmD6FF,','cultura','localhost');

$allPost = $db->get_results("SELECT ID, meta_key, meta_value FROM wp_posts
	INNER JOIN wp_postmeta ON wp_posts.ID = wp_postmeta.post_id  
    WHERE wp_posts.post_type='eventos' AND post_status='publish' AND meta_key='fechas'");

foreach ($allPost as $obj) {
	for ($x=0; $x < $obj->meta_value; $x++) {
			$data[] = $db->get_results("SELECT ID, meta_key, meta_value FROM wp_posts
				INNER JOIN wp_postmeta ON wp_posts.ID = wp_postmeta.post_id  
				WHERE ID=".$obj->ID." AND meta_key = 'fechas_".$x."_fecha' order by ID ");

	}
}

$array_de_resultados = Array(); 
foreach ($data as $obj2){
	if ($obj2[0]->meta_value>=$fInicio && $obj2[0]->meta_value<=$fFin) {
		$array_de_resultados[] = [$obj2[0]->ID, $obj2[0]->meta_value];
	}
}

$myarray = Array(); 
foreach ($array_de_resultados as $fila){
	$myarray[] = $fila[0];
}

get_posts(
	$args=array(
    'post_type' => 'eventos',
	'posts_per_page' => -1,
	'orderby' => 'post__in', 
	'post__in'      => $myarray
	)
);

$posts = get_posts($args);

$array_CULTMX_ESWS = Array();
foreach($posts as $post){
	$fechaEvento1 = Array();
	$ID_EC = get_field('lugar', $post->ID)->ID;
	$NOM_EC = get_field('lugar', $post->ID)->post_title;
	$AUTOR_ACT = get_field('imparte', $post->ID);
	
	$personas = get_field('persona_AC', $post->ID);
		$personas_a = array();
		foreach ( $personas as $personas_ele ) {
			$personas_a[] = $personas_ele['persona']->post_title;
		}
		
		if(!empty($personas_a))
			$REPARTO_ACT = join( ", ", $personas_a);
		else
			$REPARTO_ACT = 0;

	$URL_ACT = get_field('sitio_oficial_del_evento', $post->ID);
	$TIPO_PUBLICO = get_field('publico', $post->ID);
	$IMG_MUESTRA_ACT = get_field('encabezado', $post->ID);
	$IMG_MUESTRA_480 = get_field('img_app', $post->ID);
	$CANCELADO_ACT = (get_field('estatus', $post->ID) == 'Cancelado') ? 'Sí' : 0;

	$tipo_entrada = get_field('tipo_entrada', $post->ID);
	switch ($tipo_entrada) {
		case 'Cuota de recuperación':
		    $PRECIOS_ACT = 'Cuota de recuperación-'.get_field('costo_entrada', $post->ID);
		    break;
		case 'Inscripción':
		    $PRECIOS_ACT = 'Inscripción-'.get_field('costo_entrada', $post->ID);
		    break;
		case 'Bono':
		    $PRECIOS_ACT = 'Bono-'.get_field('costo_entrada', $post->ID);
		    break;
		default:
			$PRECIOS_ACT = 0;
	}
		$cat_e = get_field('categoria', $post->ID);
		$cat_e_a = array();
		foreach ( $cat_e as $cat_ele ) {
			$cat_e_a[] = $cat_ele->name;
		}
		$cat_e = join( ", ", $cat_e_a );
	
	$PALABRAS_CLAVE_ACT = get_field('disciplina', $post->ID).', '.$cat_e;
	
	$TEMAS = get_field('disciplina', $post->ID);
	
	$array_de_fechas = Array(); 
    if( have_rows('periodo') ){
        while( have_rows('periodo') ){
           	the_row();
           	$fecha_inicio = get_sub_field('fecha_inicio',false);
			$fecha_cierre = get_sub_field('fecha_cierre',false);
        }

        $begin = new DateTime( $fecha_inicio );
		$end = new DateTime( $fecha_cierre );
		$end = $end->modify( '+1 day' ); 
		
		$interval = new DateInterval('P1D');
		$daterange = new DatePeriod($begin, $interval ,$end);

		foreach($daterange as $date){
			//$array_de_fechas[]= $date->format("Y-m-d");

            $fechaEvento = $date->format("Y-m-d");
            $hinicio = '00:00:00';
            $hinicio1 = $fechaEvento.' '.$hinicio;
			$hfinal = date('H:i:s', strtotime ( '+24 hour' , strtotime ( $hinicio1 ) ) );
            $fechaEvento1[] = $fechaEvento.', '.$fechaEvento.', '.$hinicio.', '.$hfinal;
		}
		
    }else if( have_rows('fechas') ){
        while( have_rows('fechas') ){
        	the_row(); 
            $fechaEvento = get_sub_field('fecha', false);
            if( have_rows('horarios') ){
            	while( have_rows('horarios') ){
                  	the_row();
                  	$hinicio = get_sub_field('horario', false);
                  	$hinicio1 = $fechaEvento.' '.get_sub_field('horario', false);
                  	//$hfinal = strtotime($hinicio);
					$hfinal = date('H:i:s', strtotime ( '+1 hour' , strtotime ( $hinicio1 ) ) );
               		$fechaEvento1[] = $fechaEvento.', '.$fechaEvento.', '.$hinicio.', '.$hfinal;
               	} 
            }
        }
    }

	asort($fechaEvento1);
	$FECHA_HORA_ACT = join( "|", $fechaEvento1 );

	$array_CULTMX_ESWS[] = Array
	 	(
	 	'ID' => $post->ID,
	 	'TITULO_ACT' => $post->post_title,
	 	'ID_EC' => $ID_EC,
	 	'NOM_EC' => $NOM_EC,
	 	'AUTOR_ACT' => $AUTOR_ACT,
	 	'REPARTO_ACT' => $REPARTO_ACT,
	 	'URL_ACT' => $URL_ACT,
	 	'TIPO_PUBLICO' => $TIPO_PUBLICO,
		'FECHA_HORA_ACT' => $FECHA_HORA_ACT,
		'PRECIOS_ACT' => $PRECIOS_ACT,
		'IMG_MUESTRA_ACT' => $IMG_MUESTRA_ACT,
		'IMG_MUESTRA_480' => $IMG_MUESTRA_480,
		'IMG_MUESTRA_600' => $IMG_MUESTRA_480,
		'PALABRAS_CLAVE_ACT' => $PALABRAS_CLAVE_ACT,
		'RESENA_ACT_TEXT' => $post->post_content,
		'CANCELADO_ACT' => $CANCELADO_ACT,
		'TEMAS' => $TEMAS,
		'FCH_MODIFICACION' => $post->post_modified
		);

}

header("Content-Type: application/json; charset=UTF-8");
echo json_encode($array_CULTMX_ESWS);

?>
