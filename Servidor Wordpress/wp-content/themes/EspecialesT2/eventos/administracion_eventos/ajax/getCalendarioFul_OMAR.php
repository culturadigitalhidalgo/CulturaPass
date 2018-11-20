<?php 
require('../../../../../../wp-load.php');

$db = new wpdb('cultura','rP6dTF6C.JmD6FF,','cultura','localhost');

$selFInicio =$_POST['fInicio'];
$selFFin =$_POST['fFin'];


$fInicio= str_replace('-','',$selFInicio);
$fFin= str_replace('-','',$selFFin);

/*quitar despues*/
$fInicio= '20171101';
$fFin= '20171122';
/*quitar despues*/

$data1 = Array();
$allPost = $db->get_results("SELECT DISTINCT ID, T1.meta_value AS NoFechas FROM wp_posts T0
	INNER JOIN wp_postmeta T1 ON T0.ID = T1.post_id  
	INNER JOIN wp_postmeta T2 ON T0.ID = T2.post_id  
    WHERE T0.post_type='eventos' AND T1.meta_key='fechas' AND T2.meta_key like 'fechas_%_fecha' AND (T2.meta_value BETWEEN '".$fInicio."' AND '".$fFin."')");

	foreach ($allPost as $obj) {
		for ($x=0; $x < $obj->NoFechas; $x++) {
				$allPostF[] = $db->get_results("SELECT DISTINCT ID, meta_value AS NoHorarios FROM wp_posts
				INNER JOIN wp_postmeta ON wp_posts.ID = wp_postmeta.post_id  
				WHERE ID=".$obj->ID." AND meta_key = 'fechas_".$x."_horarios' order by ID ");
					for ($i=0; $i < $allPostF[$x][0]->NoHorarios; $i++) {
							$allPostFH[] = $db->get_results("SELECT DISTINCT T0.ID, T1.meta_value AS Fecha, T2.meta_value AS Horario FROM wp_posts T0
							INNER JOIN wp_postmeta T1 ON T0.ID = T1.post_id  
							INNER JOIN wp_postmeta T2 ON T0.ID = T2.post_id  
							WHERE ID=".$obj->ID." AND T1.meta_key='fechas_".$x."_fecha' AND T2.meta_key='fechas_".$x."_horarios_".$i."_horario' order by ID ");
							//echo  "AND T1.meta_key='fechas_".$x."_fecha' AND T2.meta_key='fechas_".$x."_horarios_".$i."_horario'<br>";
					}
		}
	}

	//print_r($allPostF);

	foreach ($allPostFH as $obj) {
		echo $obj[0]->ID."----".$obj[0]->Fecha."----".$obj[0]->Horario."<br>";
	}
