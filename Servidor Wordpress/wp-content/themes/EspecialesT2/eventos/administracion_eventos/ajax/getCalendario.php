<?php
require('../../../../../../wp-load.php');

$db = new wpdb('cultura','rP6dTF6C.JmD6FF,','cultura','localhost');

$selFInicio =$_POST['fInicio'];
$selFFin =$_POST['fFin'];

$fInicio= str_replace('-','',$selFInicio);
$fFin= str_replace('-','',$selFFin);

$allPost = $db->get_results("SELECT ID, T1.meta_value AS NoFechas, T2.meta_value AS Fecha FROM wp_posts T0
	INNER JOIN wp_postmeta T1 ON T0.ID = T1.post_id  
	INNER JOIN wp_postmeta T2 ON T0.ID = T2.post_id  
    WHERE T0.post_type='eventos' AND T1.meta_key='fechas' AND T2.meta_key like 'fechas_%_fecha' AND (T2.meta_value BETWEEN '".$fInicio."' AND '".$fFin."')");
       
	foreach ($allPost as $obj) {
		for ($x=0; $x < $obj->NoFechas; $x++) {
				$allPostF[] = $db->get_results("SELECT DISTINCT ID, meta_value AS NoHorarios FROM wp_posts
				INNER JOIN wp_postmeta ON wp_posts.ID = wp_postmeta.post_id  
				WHERE ID=".$obj->ID." AND meta_key = 'fechas_".$x."_horarios' order by ID ");
					for ($i=0; $i < $allPostF[$x][0]->NoHorarios; $i++) {
							$allPostFH[] = $db->get_results("SELECT DISTINCT T0.ID, T0.post_title, T0.post_status, T0.guid, T1.meta_value AS Fecha, T2.meta_value AS Horario FROM wp_posts T0
							INNER JOIN wp_postmeta T1 ON T0.ID = T1.post_id  
							INNER JOIN wp_postmeta T2 ON T0.ID = T2.post_id  
							WHERE ID=".$obj->ID." AND T1.meta_key='fechas_".$x."_fecha' AND T2.meta_key='fechas_".$x."_horarios_".$i."_horario' order by ID ");
					}
		}
	}

	foreach ($allPostFH as $obj) {
		
		$fecha_echo = substr_replace($obj[0]->Fecha, '-', 4, 0);
		$fecha_echo = substr_replace($fecha_echo, '-', 7, 0); 
		if($obj[0]->post_status == 'publish')
		$colorFondo='#71B631';
		else if($obj[0]->post_status == 'pending')
		$colorFondo='#ffbb3f';
		else
		$colorFondo='#E73C4E';
		
		$dataMientras[] = Array('title'=>$obj[0]->post_title,'title2'=>$obj[0]->post_title.'|'.$fecha_echo,'start'=>$fecha_echo.'T'.$obj[0]->Horario,'link'=>str_replace("#038;", "", $obj[0]->guid), 'color'=>$colorFondo);
	}




function cmp($a, $b)
{
    return strcmp($a["title2"], $b["title2"]);
}
usort($dataMientras, "cmp");

$mientras = '';
foreach ($dataMientras as $filadata) {
	if ($mientras != $filadata[title2]){
		$data[] = Array('title'=>$filadata[title],'start'=>$filadata[start],'link'=>$filadata[link], 'color'=>$filadata[color]);
	}
	$mientras = $filadata[title2];
}



foreach($data as $p){
	//print_r($p);
	//echo "<br><br>";

}


