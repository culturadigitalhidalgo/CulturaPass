<?php  
/* 
* Carteles
* 
* @category Carteles
* @author Centro de Información Cultural del Estado de Hidalgo CECULTAH <cic.innovacion@gmail.com>
* @copyleft Algunos derechos reservados Centro de Información Cultural del Estado de Hidalgo SC
* @since Versión 1.0, revisión 1. Julio/2017
* @versión 1.0 
*/

require('../../../../../../wp-load.php');
//get_header();

$selFInicio =$_POST['fInicio'];
$selFFin =$_POST['fFin'];

$fInicio= str_replace('-','',$selFInicio);
$fFin= str_replace('-','',$selFFin);

$db = new wpdb('cultura','rP6dTF6C.JmD6FF,','cultura','localhost');

$allPost = $db->get_results("SELECT DISTINCT T1.post_id AS ID, T1.meta_value AS Fecha, T2.meta_value AS Horario, T3.meta_value AS Lugar FROM wp_postmeta AS T1
	INNER JOIN wp_postmeta T2 ON T1.post_id = T2.post_id
	INNER JOIN wp_postmeta T3 ON T1.post_id = T3.post_id
	WHERE (T1.meta_key like 'fechas_%_fecha' AND (T1.meta_value BETWEEN '".$fInicio."' AND '".$fFin."') AND T2.meta_key like 'fechas_%_horarios_%_horario' AND T3.meta_key='lugar') ORDER BY Fecha ASC, Horario ASC");

//print_r($allPost);

//$allPost2 = $allPost;

//foreach ($allPost as $fila) {
//	foreach ($allPost as $fila2) {
//		//echo $fila->Fecha."----<br>";
//		if ($fila->Fecha.$fila->Horario == $fila2->Fecha.$fila2->Horario) {
//			echo $fila->post_id." ".$fila->Fecha." ".$fila->Horario." / ".$fila2->post_id." ".$fila2->Fecha." ".$fila2->Horario."<br>";
//		}
//	}
//}
$fecha_horario = Array();
$fecha_horario_lugar = Array();
foreach ($allPost as $fila) {
	foreach ($allPost as $fila2) {
		
		if ( (($fila->Fecha.$fila->Horario) == ($fila2->Fecha.$fila2->Horario)) and (($fila->Lugar) != ($fila2->Lugar)) ) {
			//echo "son iguales 2 fecha sy horarios";
			$fecha_horario[] = $fila->ID." ".$fila->Fecha." ".$fila->Horario." ".$fila->Lugar."  -/-  ".$fila2->ID." ".$fila2->Fecha." ".$fila2->Horario." ".$fila2->Lugar."<br>";
		}
		if ( (($fila->Fecha.$fila->Horario.$fila->Lugar) == ($fila2->Fecha.$fila2->Horario.$fila2->Lugar)) and (($fila->Lugar) == ($fila2->Lugar)) ) {
			//echo "son iguales 2 fecha sy horarios";
			$fecha_horario_lugar[] = $fila->ID." ".$fila->Fecha." ".$fila->Horario." ".$fila->Lugar."  -/-  ".$fila2->ID." ".$fila2->Fecha." ".$fila2->Horario." ".$fila2->Lugar."<br>";
		}
	}
}


print_r ($fecha_horario);
echo "----------------";
print_r ($fecha_horario_lugar);


?>

