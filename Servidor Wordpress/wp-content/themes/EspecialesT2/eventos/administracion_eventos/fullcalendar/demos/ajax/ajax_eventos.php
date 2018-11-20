<?php 
//include_once('../conexion.php');
require('../../../../../wp-load.php');

$db = new wpdb('sigeh','wQ:6N3.q2LJ7HMY:','sigeh','localhost');


$query="SELECT DISTINCT T1.ID, T1.post_name AS link, T1.post_title AS Titulo, DATE_FORMAT(T2.meta_value, '%Y-%m-%d') AS Fecha, T3.meta_value AS E1, T4.meta_value AS E2, T5.meta_value AS E3 FROM wp_posts AS T1
        INNER JOIN wp_postmeta T2 ON T1.ID = T2.post_id
        INNER JOIN wp_postmeta T3 ON T1.ID = T3.post_id
        INNER JOIN wp_postmeta T4 ON T1.ID = T4.post_id
        INNER JOIN wp_postmeta T5 ON T1.ID = T5.post_id
        WHERE T1.post_type='eventos' AND T2.meta_key='fech_ev' AND T3.meta_key='evaluacion1' AND T4.meta_key='evaluacion2' AND T5.meta_key='evaluacion3';";
        $rows = $db->get_results($query);
        $data=Array();
        for ($i=0; $i < count($rows) ; $i++) {
        	if(($rows[$i]->E1==1 && $rows[$i]->E2==1) || ($rows[$i]->E1==1 && $rows[$i]->E3==1) || ($rows[$i]->E2==1 && $rows[$i]->E3==1)) {
				$data[] = Array('title'=>$rows[$i]->Titulo,'start'=>$rows[$i]->Fecha,'link'=>"http://sigeh.hidalgo.gob.mx/?eventos=".$rows[$i]->link,'E1'=>$rows[$i]->E1,'E2'=>$rows[$i]->E2,'E3'=>$rows[$i]->E3);
            }
        }

	//print_r($rows);
	echo json_encode($data);


?>
