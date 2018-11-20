<?php  
/* 
* CULTMX-ESWS
* 
* @category Web Service 
* @Listado general de recintos disponibles en el sistema
* @author Centro de Cultura Digital del Estado de Hidalgo SC <cic.innovacion@gmail.com>
* @copyleft Algunos derechos reservados Centro de Cultura Digital del Estado de Hidalgo SC
* @since Versión 1.0, revisión 1. Junio/2018
* @versión 1.0 
*/

require('../../../../../wp-load.php');
$args = array(
'post_type'      => 'infraestructura',
'order'          => 'ASC',
'posts_per_page' => -1,
'meta_query' => array(
          array(
              'key' => 'tipo_recinto', 
              'value' => 'Recinto', //7923
              'compare' => '=='
          ))
);

$recintos = new WP_Query($args);

$array_CULTMX_ESWS = Array();
foreach ( $recintos->posts as $res ) {
	$TELS_EC = get_field('telefono_infraestructura', $res->ID);
	$EMAILS_EC = get_field('correo_infraestructura', $res->ID);
	$URL_EC = get_field('sitio_web', $res->ID);
	$ESTADO = 'Hidalgo';
	$CIUDAD = get_field('localidad', $res->ID);
	$DEL_MPIO = get_field('municipio', $res->ID);
	$COLONIA = get_field('colonia', $res->ID);
	$DIRECCION = get_field('calle', $res->ID).' '.get_field('numero', $res->ID);
	$CP = get_field('codigo_postal', $res->ID);
	$LATITUD_GMAPS = get_field('latitud', $res->ID);	
	$LONGITUD_GMAPS = get_field('longitud', $res->ID);

//revisar estos
	$DIA_HORA_EC = get_field('horario_servicio_biblioteca', $res->ID);
	$CONTACTO_EC = get_field('facebook', $res->ID).', '.get_field('twitter', $res->ID);
	$IMG_MUESTRA_EC = get_field('place_header', $res->ID);
	



	$array_CULTMX_ESWS[] = Array
	(
	 	'ID' => $res->ID,
	 	'NOMBRE' => $res->post_title,
		'TELS_EC' => $TELS_EC,
		'EMAILS_EC' => $EMAILS_EC,
		'URL_EC' => $URL_EC,
		'CONTACTO_EC' => $CONTACTO_EC,
		'RESENA_GRAL' => $res->post_content,
		'ESTADO' => $ESTADO,
		'CIUDAD' => $CIUDAD,
		'DEL_MPIO' => $DEL_MPIO,
		'CP' => $CP,
		'COLONIA' => $COLONIA,
		'DIRECCION' => $DIRECCION,
		'IMG_MUESTRA_EC' => $IMG_MUESTRA_EC,
		'LATITUD_GMAPS' => $LATITUD_GMAPS,
		'LONGITUD_GMAPS' => $LONGITUD_GMAPS,
		'DIA_HORA_EC' => $DIA_HORA_EC,
		'FCH_MODIFICACION' => $res->post_modified

/*
{"ID":14536,"id":14536,"title":"Centro de las Artes de Hidalgo_fuente","filename":"centro_artes_banner.jpg","url":"http:\/\/cultura.hidalgo.gob.mx\/wp-content\/uploads\/2017\/04\/centro_artes_banner.jpg","alt":"Cultura, Hidalgo, Recintos, Patrimonio, Ex-convento, escuela, arte","author":"9","description":"","caption":"","name":"centro_artes_banner","date":"2017-08-22 15:46:48","modified":"2017-08-22 16:06:27","mime_type":"image\/jpeg","type":"image","icon":"http:\/\/cultura.hidalgo.gob.mx\/wp-includes\/images\/media\/default.png","width":1200,"height":444,"sizes":{"thumbnail":"http:\/\/cultura.hidalgo.gob.mx\/wp-content\/uploads\/2017\/04\/centro_artes_banner.jpg","thumbnail-width":150,"thumbnail-height":56,"medium":"http:\/\/cultura.hidalgo.gob.mx\/wp-content\/uploads\/2017\/04\/centro_artes_banner.jpg","medium-width":300,"medium-height":111,"medium_large":"http:\/\/cultura.hidalgo.gob.mx\/wp-content\/uploads\/2017\/04\/centro_artes_banner.jpg","medium_large-width":768,"medium_large-height":284,"large":"http:\/\/cultura.hidalgo.gob.mx\/wp-content\/uploads\/2017\/04\/centro_artes_banner.jpg","large-width":1024,"large-height":379,"interes-thumb":"http:\/\/cultura.hidalgo.gob.mx\/wp-content\/uploads\/2017\/04\/centro_artes_banner.jpg","interes-thumb-width":45,"interes-thumb-height":17,"servicios-thumb":"http:\/\/cultura.hidalgo.gob.mx\/wp-content\/uploads\/2017\/04\/centro_artes_banner.jpg","servicios-thumb-width":85,"servicios-thumb-height":31,"noticias-thumb":"http:\/\/cultura.hidalgo.gob.mx\/wp-content\/uploads\/2017\/04\/centro_artes_banner.jpg","noticias-thumb-width":80,"noticias-thumb-height":30,"conoce-thumb":"http:\/\/cultura.hidalgo.gob.mx\/wp-content\/uploads\/2017\/04\/centro_artes_banner.jpg","conoce-thumb-width":35,"conoce-thumb-height":13,"catnoticias-thumb":"http:\/\/cultura.hidalgo.gob.mx\/wp-content\/uploads\/2017\/04\/centro_artes_banner.jpg","catnoticias-thumb-width":500,"catnoticias-thumb-height":185,"categoria-thumb":"http:\/\/cultura.hidalgo.gob.mx\/wp-content\/uploads\/2017\/04\/centro_artes_banner.jpg","categoria-thumb-width":230,"categoria-thumb-height":85,"shop_thumbnail":"http:\/\/cultura.hidalgo.gob.mx\/wp-content\/uploads\/2017\/04\/centro_artes_banner.jpg","shop_thumbnail-width":180,"shop_thumbnail-height":67,"shop_catalog":"http:\/\/cultura.hidalgo.gob.mx\/wp-content\/uploads\/2017\/04\/centro_artes_banner.jpg","shop_catalog-width":300,"shop_catalog-height":111,"shop_single":"http:\/\/cultura.hidalgo.gob.mx\/wp-content\/uploads\/2017\/04\/centro_artes_banner.jpg","shop_single-width":600,"shop_single-height":222}}
*/
	);

}

header("Content-Type: application/json; charset=UTF-8");
echo json_encode($array_CULTMX_ESWS);

?>
