<?php
/**
 * List, Box AJAX 2
 * Author's: Eliel Trigueros Hernandez
 * @since Versión 1.0, revisión 1 Febrero/2018
*/
$ios = $_GET['ios'];
require ('../../../../../wp-load.php');
$txtTexto=trim($_POST['Texto']);
$txtTexto = strip_tags($txtTexto); 
$selMunicipio = $_POST['Municipio'];
$selRiesgo = $_POST['Riesgo'];
$selAmbito = $_POST['Ambito'];
$selAo = $_POST['Ao'];
if ($txtTexto!="") {
  $args = array(
    'post_type'      => 'patrimonio_pci',
    's'           => $txtTexto,
    'order'          => 'DESC',
    'post_status' => 'draft',
    'posts_per_page' => '-1',
    'meta_query'    => array()
  );
}else{
  $args = array(
    'post_type'      => 'patrimonio_pci',
    'order'          => 'DESC',
    'post_status' => 'draft',
    'posts_per_page' => '-1',
    'meta_query'    => array()
  );
}
if($selMunicipio!='0'){
  array_push($args['meta_query'], array(
      array(
             array(
                 'key' => 'pci_municipio', 
                 'value' => $selMunicipio, 
                 'compare' => '==',
      )),
  ));
}

if($selRiesgo!='0'){
  array_push($args['meta_query'], array(
      array(
             array(
                 'key' => 'pci_riesgo', 
                 'value' => $selRiesgo, 
                 'compare' => '==',
      )),
  ));
}

if($selAmbito!='0'){
  array_push($args['meta_query'], array(
      array(
             array(
                 'key' => 'pci_ambito', 
                 'value' => $selAmbito, 
                 'compare' => '==',
      )),
  ));
}

if($selAo!='0'){
  array_push($args['meta_query'], array(
      array(
             array(
                 'key' => 'pci_year_registro', 
                 'value' => $selAo, 
                 'compare' => '==',
      )),
  ));
}

$metaQuery = count($args['meta_query']);
if ($metaQuery>=2) {
	array_push($args['meta_query'], array(
      'relation'  => 'AND',
      ));
}
$query_pci = new WP_Query($args);
$contador = 0;
while ($query_pci->have_posts()) {
	$query_pci->the_post();    	
  $contador++;
}
echo $contador.' resultados en: ';
?>
