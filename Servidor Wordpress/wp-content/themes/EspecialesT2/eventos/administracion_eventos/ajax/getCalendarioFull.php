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
							//echo  "AND T1.meta_key='fechas_".$x."_fecha' AND T2.meta_key='fechas_".$x."_horarios_".$i."_horario'<br>";
					}
		}
	}

	//print_r($allPostF);

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
			
		//echo $obj[0]->ID."----".$obj[0]->Fecha."----".$obj[0]->Horario."----".$obj[0]->post_title."----".$obj[0]->post_status."----".$obj[0]->guid."<br>";
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

echo json_encode($data);
 
/* :(
 * require('../../../../../../wp-load.php');

$db = new wpdb('cultura','rP6dTF6C.JmD6FF,','cultura','localhost');

$selFInicio =$_POST['fInicio'];
$selFFin =$_POST['fFin'];

$fInicio= str_replace('-','',$selFInicio);
$fFin= str_replace('-','',$selFFin);

$data1 = Array();
$allPost = $db->get_results("SELECT ID, meta_key, meta_value FROM wp_posts
	INNER JOIN wp_postmeta ON wp_posts.ID = wp_postmeta.post_id  
    WHERE wp_posts.post_type='eventos' AND meta_key='fechas' AND (post_status='publish' OR post_status='pending' OR post_status='draft')");

foreach ($allPost as $obj) {
	for ($x=0; $x < $obj->meta_value; $x++) {			
			$data1[] = $db->get_results("SELECT T1.ID, T1.post_title, T1.post_status, T1.guid, T2.meta_key, T2.meta_value AS Fecha FROM wp_posts AS T1
				INNER JOIN wp_postmeta T2 ON T1.ID = T2.post_id  
				WHERE T1.ID=".$obj->ID." AND T2.meta_key = 'fechas_".$x."_fecha' order by T1.ID");
	}
}

foreach ($data1 as $obj2){
	if ($obj2[0]->Fecha>=$fInicio && $obj2[0]->Fecha<=$fFin) {
	
	$fecha_horario = Array();
	$fecha_horario_f = Array();
	$fechas=get_field('fechas', $obj2[0]->ID);
		foreach ($fechas as $fecha){
			$fecha_horario[] = $obj2[0]->ID.'|'.$fecha[fecha].'|'.$fecha[horarios][0][horario];
        }
     
        $fecha_horario_f = array_unique($fecha_horario);
    	
		$fecha_echo = substr_replace($obj2[0]->Fecha, '-', 4, 0); 
		
		$fecha_echo = substr($fecha_echo, 0, -2);
		//$fecha_echo = wordwrap($obj2[0]->Fecha, 4, "-", 1);
		//$fecha_echo = wordwrap($fecha_echo, 7, "*", 7);
		//$fecha_echo = str_replace("*", "-", $fecha_echo);
		if($obj2[0]->post_status == 'publish')
		$colorFondo='#71B631';
		else if($obj2[0]->post_status == 'pending')
		$colorFondo='#ffbb3f';
		else
		$colorFondo='#E73C4E';
		for ($i=0; $i < count($fecha_horario_f); $i++) {
			$hora = explode("|", $fecha_horario_f[$i]);
			preg_match_all('!\d+!', $hora[1], $fechaDia);
				
			$fechaDia2 = implode(' ', $fechaDia[0]);
			
			$dataMientras[] = Array('title'=>$obj2[0]->post_title,'title2'=>$obj2[0]->post_title.'|'.$fecha_horario_f[$i],'start'=>$fecha_echo.'-','link'=>str_replace("#038;", "", $obj2[0]->guid), 'color'=>$colorFondo, 'hora'=>$hora[2], 'dia'=>$fechaDia2);
		}
	}
}

function cmp($a, $b)
{
    return strcmp($a["title2"], $b["title2"]);
}
usort($dataMientras, "cmp");

$mientras = '';
$data = Array(); 
foreach ($dataMientras as $filadata) {
	if ($mientras != $filadata[title2]){
		$data[] = Array('title'=>$filadata[title],'start'=>$filadata[start].$filadata[dia].'T'.$filadata[hora],'link'=>$filadata[link], 'color'=>$filadata[color]);
	}
	$mientras = $filadata[title2];
}
echo json_encode($data);*/
?>
