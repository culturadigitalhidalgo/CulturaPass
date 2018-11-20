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
//echo $allPost[$i]->Title." ".get_the_time('Y-m-d',$allPost[$i]->ID)." creada<br>";
//echo $allPost[$i]->Title." ".get_the_modified_date('Y-m-d',$allPost[$i]->ID)." modificada<br><hr>";
$fInicio= str_replace('-','',$selFInicio);
$fFin= str_replace('-','',$selFFin);

$db = new wpdb('cultura','rP6dTF6C.JmD6FF,','cultura','localhost');


$allPost = $db->get_results("SELECT DISTINCT T2.post_title AS Title, T1.post_id AS ID, T3.display_name AS Autor, T4.meta_value AS Direccion, DATE_FORMAT(T1.meta_value, '%Y-%m-%d') AS Fecha FROM wp_postmeta AS T1
    INNER JOIN wp_posts T2 ON T1.post_id = T2.ID
    INNER JOIN wp_users T3 ON T2.post_author = T3.ID
    INNER JOIN wp_usermeta T4 ON T3.ID = T4.user_id
	WHERE ((T1.meta_key like 'fechas_%_fecha' OR T1.meta_key like 'periodo_%_fecha_inicio') AND (T1.meta_value BETWEEN '".$fInicio."' AND '".$fFin."') AND T4.meta_key='description') 
	AND T2.post_type='eventos' ORDER BY Autor ASC");
	
	$rojasGeneral=0; $amarillasGeneral=0; $verdesGeneral=0; $direcciones = array(); $datosDireccion = array(); $rojasDireccion=0;

	for ($i=0; $i < count($allPost); $i++) {
		$direcciones[] =  "['".$allPost[$i]->Direccion."']";
		$datetime1 = new DateTime(get_the_date('Y-m-d',$allPost[$i]->ID));
		$datetime2 = new DateTime($allPost[$i]->Fecha);
		$interval = $datetime1->diff($datetime2);
	
		if ($interval->format('%a')>30) {
			$verdesGeneral++;
		}else if ($interval->format('%a')>8 && $interval->format('%a')<30) {
			$amarillasGeneral++;
		}else if ($interval->format('%a')<9) {
			$rojasGeneral++;
		}
	}

	$dir = array_unique($direcciones);

	for ($j=0; $j < count($dir); $j++) {
		$rojas=0; $amarillas=0; $verdes=0; 
		for ($i=0; $i < count($allPost); $i++) {
			if($dir[$j] == $allPost[$i]->Direccion){
				$datetime1 = new DateTime(get_the_date('Y-m-d',$allPost[$i]->ID));
				$datetime2 = new DateTime($allPost[$i]->Fecha);
				$interval = $datetime1->diff($datetime2);
				if ($interval->format('%a')>30) {
					$verdes++;
				}else if ($interval->format('%a')>8 && $interval->format('%a')<30) {
					$amarillas++;
				}else if ($interval->format('%a')<9) {
					$rojas++;
				}
				$dir[$j] =  array($verdes, $amarillas, $rojas);
			}
		}
	}	

//print_r($dir);

	$datosGeneral[] = "['Más de 30 días de anticipación', ".$verdesGeneral."]";
	$datosGeneral[] = "['Entre 29 y 9 días de anticipación', ".$amarillasGeneral."]";
	$datosGeneral[] = "['Menor a 8 días de anticipación', ".$rojasGeneral."]";

?>
<div id="graficaGeneral" calss="chart_graphic" style="margin: 0 auto"></div>
<script type="text/javascript">
	Highcharts.setOptions({
	     colors: ['#6dbd45', '#ee3b4b', '#edcf3e']
	    });
	Highcharts.chart('graficaGeneral', {
	    chart: {
	        plotBackgroundColor: null,
	        plotBorderWidth: null,
	        plotShadow: false,
	        type: 'pie'
	    },
	    title: {
	        text: 'Intervalo entre fecha de publicación y fecha del evento'
	    },
	    plotOptions: {
	        pie: {
	            allowPointSelect: true,
	            cursor: 'pointer',
	            dataLabels: {
	                enabled: true,
	                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
	                style: {
	                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
	                }
	            }
	        }
	    },
	    series: [{
	        name: 'Cantidad',
	        colorByPoint: true,
	        data: [<?php echo join($datosGeneral, ',') ?>]
	    }]
	});
</script>
<!-- todo esto se comento porque no funciona; no dio tiempo de arreglarlo para el premio a la inovacion
<div id="graficaDireccion" calss="chart_graphic" style="margin: 0 auto"></div>
<script >
Highcharts.chart('graficaDireccion', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Estatus por dirección'
    },
    xAxis: {
        categories: [<?php //echo join($dir, ',') ?>]
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Intervalo entre fecha de publicación y fecha del evento'
        }
    },
    tooltip: {
        pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
        shared: true
    },
    plotOptions: {
        column: {
            stacking: 'percent'
        }
    },
    series: [{
        name: 'Mas de 30 días de anticipación',
        data: [5, 3, 4]
    }, {
        name: 'Entre 29 y 9 días de anticipación',
        data: [2, 2, 3]
    }, {
        name: 'Menor a 8 días de anticipación',
        data: [3, 4, 4]
    }]
});
</script>-->
<?php
/*
	for ($i=0; $i < count($allPost); $i++) {
		$content="<div id='divContent' ";
		$datetime1 = new DateTime(get_the_date('Y-m-d',$allPost[$i]->ID));
		$datetime2 = new DateTime($allPost[$i]->Fecha);
		$interval = $datetime1->diff($datetime2);
		if ($interval->format('%a')>30) {
			$content .= "style='background:#D8F6CE' >Evento: ".$allPost[$i]->Title." ".get_the_date('Y-m-d',$allPost[$i]->ID)." | ".$allPost[$i]->Fecha." Diferencia: ".$interval->format('%a')." Dirección: ".$allPost[$i]->Direccion."</div><br>";
		}else if ($interval->format('%a')>8 && $interval->format('%a')<30) {
			$content .= "style='background:#F5F6CE' >Evento: ".$allPost[$i]->Title." ".get_the_date('Y-m-d',$allPost[$i]->ID)." | ".$allPost[$i]->Fecha." Diferencia: ".$interval->format('%a')." Dirección: ".$allPost[$i]->Direccion."</div><br>";
		}else if ($interval->format('%a')<9) {
			$content .= "style='background:#F6CECE' >Evento: ".$allPost[$i]->Title." ".get_the_date('Y-m-d',$allPost[$i]->ID)." | ".$allPost[$i]->Fecha." Diferencia: ".$interval->format('%a')." Dirección: ".$allPost[$i]->Direccion."</div><br>";
		}
		echo $content;
	}
*/
?>
