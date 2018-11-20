<?php
/**
 * List, Box AJAX
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
$bandera = 0;	

	echo '<div class="SC_content">';
	while ($query_pci->have_posts()) {
		$query_pci->the_post();
		$ID1 = get_the_ID();		
    	$ambito = get_field('pci_ambito');
		$sinImg = get_field('pci_img');
		echo '<span class="pci_inter">'.'<a href="'.get_permalink($ID1).'?app=1">';
		if (empty($sinImg)) echo '<img src="http://cultura.hidalgo.gob.mx/wp-content/themes/EspecialesT2/patrimonio/assets/no_img.png"/>';
		else echo '<img src="'.$sinImg.'"/>';			
		echo '<span class="pci_data" ';
			  if($ambito == "Tradiciones y expresiones orales")	echo 'style="background:#084469;"';
			  if($ambito == "Artes del espectáculo") echo 'style="background:#f37920;"';
			  if($ambito == "Usos sociales, rituales y actos festivos")	echo 'style="background:#8dc546;"';
			  if($ambito == "Conocimientos y usos relacionados con la naturaleza y el universo")echo 'style="background:#f4ac27;"'; 
			  if($ambito == "Técnicas artesanales tradicionales")	echo 'style="background:#8b183c;"';
    echo '><span class="pci_ref"><span class="pci_mun">'.get_field('pci_municipio').'</span>'.$ambito.'</span><span class="title">'.get_the_title().'</span>';				
		echo '</span></a></span>';
		$bandera = 1;
	}
	echo '</div>';

if($bandera == 0) echo '<div class="msj_error">No existen resultados con los parámetros aplicados</div>';
?>
