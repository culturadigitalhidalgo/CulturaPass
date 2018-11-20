<?php  
/* 
* Carteles
* 
* @category Carteles
* @author Centro de Información Cultural del Estado de Hidalgo CECULTAH <cic.innovacion@gmail.com>
* @copyleft Algunos derechos reservados Centro de Información Cultural del Estado de Hidalgo SC
* @since Versión 2.0, revisión 2. Enero/2018
* @versión 2.0 
*/

require('../../../../../../wp-load.php');
//get_header();

$selFInicio =$_POST['fInicio'];
$selFFin =$_POST['fFin'];

$fInicio= str_replace('-','',$selFInicio);
$fFin= str_replace('-','',$selFFin);

$db = new wpdb('cultura','rP6dTF6C.JmD6FF,','cultura','localhost');

//$data = array();

$allPost = $db->get_results("SELECT DISTINCT T4.post_title AS Title, T1.post_id AS ID, T1.meta_value AS Fecha, T2.meta_value AS Horario, T3.meta_value AS Lugar FROM wp_postmeta AS T1
	INNER JOIN wp_postmeta T2 ON T1.post_id = T2.post_id
	INNER JOIN wp_postmeta T3 ON T1.post_id = T3.post_id
    INNER JOIN wp_posts T4 ON T1.post_id = T4.ID
	WHERE (T1.meta_key like 'fechas_%_fecha' AND (T1.meta_value BETWEEN '".$fInicio."' AND '".$fFin."') AND T2.meta_key like 'fechas_%_horarios_%_horario' AND T3.meta_key='lugar') 
	AND T4.post_status='publish' AND T4.post_type='eventos' ORDER BY Fecha ASC, Horario ASC");

$fecha_horario = array();
	$b=0;
	for ($i=0; $i < count($allPost); $i++) { 
		for ($j=0; $j < count($allPost); $j++) { 
			if (($allPost[$i]->Fecha.$allPost[$i]->Horario == $allPost[$j]->Fecha.$allPost[$j]->Horario)) {
				if ($b>0) {
					$fechax = substr_replace($allPost[$i]->Fecha, '-', 4, 0); 
					$fechax = substr_replace($fechax, '-', 7, 0);
					$fecha_horario[] = $allPost[$i]->ID."|".$allPost[$i]->Title."|".$fechax."|".$allPost[$i]->Horario;
				}
				$b++;
			}
		}
		$b=0;
	}

$fecha_horario_f = array_unique($fecha_horario);

$fecha_horario_final = array();
foreach ($fecha_horario_f as $fila) {
	list($ID, $Title, $Fecha, $Horario) = explode('|', $fila);
	$fecha_horario_final[$Fecha.$Horario][] = "<a href='http://cultura.hidalgo.gob.mx/wp-admin/post.php?post=".$ID."&action=edit' target='_blank'>".$Title."</a>  |  ".$Fecha."  |  ".$Horario;
    //$fecha_horario_final[$Fecha.$Horario][] = $Title."  |  ".$Fecha."  |  ".$Horario;
}

echo "<h1>Eventos repetidos misma fecha y hora.</h1><br>";
foreach ($fecha_horario_final as $fila) {
	echo "<div class='fh'>";
    for ($i=0; $i < count($fila); $i++) { 
    	echo $fila[$i]."<br>";
    }
    echo "</div>";
}

echo "<h1>Eventos repetidos misma fecha, hora y lugar.</h1><br>";

$fecha_horario_fecha = array();
	$b=0;
	for ($i=0; $i < count($allPost); $i++) { 
		for ($j=0; $j < count($allPost); $j++) { 
			if (($allPost[$i]->Fecha.$allPost[$i]->Horario.$allPost[$i]->Lugar == $allPost[$j]->Fecha.$allPost[$j]->Horario.$allPost[$j]->Lugar)) {
				if ($b>0) {
					$fechax = substr_replace($allPost[$i]->Fecha, '-', 4, 0); 
					$fechax = substr_replace($fechax, '-', 7, 0);					
					$fecha_horario_fecha[] = $allPost[$i]->ID."|".$allPost[$i]->Title."|".$fechax."|".$allPost[$i]->Horario."|".$allPost[$i]->Lugar;
				}
				$b++;
			}
		}
		$b=0;
	}

$fecha_horario_fecha_f = array_unique($fecha_horario_fecha);

$fecha_horario_fecha_final = array();
foreach ($fecha_horario_fecha_f as $fila) {
	list($ID, $Title, $Fecha, $Horario, $Lugar) = explode('|', $fila);
	$PostTitle = $db->get_results("SELECT post_title FROM wp_posts WHERE ID='".$Lugar."'");
	$fecha_horario_fecha_final[$Fecha.$Horario.$Lugar][] = "<a href='http://cultura.hidalgo.gob.mx/wp-admin/post.php?post=".$ID."&action=edit' target='_blank'>".$Title."</a>  |  ".$Fecha."  |  ".$Horario."  |  ".$PostTitle[0]->post_title;
    //$fecha_horario_fecha_final[$Fecha.$Horario.$Lugar][] = $Title."  |  ".$Fecha."  |  ".$Horario."  |  ".$PostTitle[0]->post_title;
}

foreach ($fecha_horario_fecha_final as $fila) {
	echo "<div class='fhl'>";
    for ($i=0; $i < count($fila); $i++) { 
    	echo $fila[$i]."<br>";
    }
    echo "</div>";
}

?>



