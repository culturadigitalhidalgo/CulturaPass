<?php  
/* 
* GET Estadisticas
* 
* @category GET Estadisticas
* @author Centro de Información Cultural del Estado de Hidalgo CECULTAH <cic.innovacion@gmail.com>
* @copyleft Algunos derechos reservados Centro de Información Cultural del Estado de Hidalgo SC
* @since Versión 1.0, revisión 1. Junio/2017
* @versión 1.0 
*/

require('../../../../../../wp-load.php');
//get_header();

$selFInicio =$_POST['fInicio'];
$selFFin =$_POST['fFin'];

$fInicio= str_replace('-','',$selFInicio);
$fFin= str_replace('-','',$selFFin);

$db = new wpdb('cultura','rP6dTF6C.JmD6FF,','cultura','localhost');

//$data = array();

$allPost = $db->get_results("SELECT ID, meta_key, meta_value FROM wp_posts
	INNER JOIN wp_postmeta ON wp_posts.ID = wp_postmeta.post_id  
    WHERE wp_posts.post_type='eventos' AND post_status='publish' AND meta_key='fechas'");

foreach ($allPost as $obj) {
	for ($x=0; $x < $obj->meta_value; $x++) {
			$data[] = $db->get_results("SELECT ID, meta_key, meta_value FROM wp_posts
				INNER JOIN wp_postmeta ON wp_posts.ID = wp_postmeta.post_id  
				WHERE ID=".$obj->ID." AND meta_key = 'fechas_".$x."_fecha' order by ID ");

	}
}


//print_r($data);
$array_de_resultados = Array(); 
foreach ($data as $obj2){
	if ($obj2[0]->meta_value>=$fInicio && $obj2[0]->meta_value<=$fFin) {
		$array_de_resultados[] = [$obj2[0]->ID, $obj2[0]->meta_value];
		//echo "<li>".$obj2[0]->ID."----".$obj2[0]->meta_value."</li>";
	}
}
/*
Para ordenar
foreach ($array_de_resultados as $clave => $fila){
	$fech[$clave] = $fila['1'];
}
array_multisort($fech, SORT_ASC, $array_de_resultados);

print_r ($array_de_resultados);
*/
$myarray = Array(); 
foreach ($array_de_resultados as $fila){
	$myarray[] = $fila[0];
}

$posts = get_posts(
	array(
    'post_type' => 'eventos',
	'posts_per_page' => -1,
	'orderby' => 'post__in', 
	'post__in'      => $myarray
	)
);
//Disciplina
$field = get_field_object('field_58f699c7a77a5');
$arreglo_t_disciplinas = $field[choices];

foreach($posts as $p){
	$disciplina[] = get_post_meta($p->ID,"disciplina",true);
}

$disciplina = array_count_values($disciplina);

$disciplina_resultado = array_merge($arreglo_t_disciplinas, $disciplina);

foreach ($disciplina_resultado as $key => $rest) {
    if (!is_int($rest)){
		$disciplina_resultado[$key] = 0;
	}
}

//Data
$datos = Array();
$total = 0;
//foreach($disciplina_resultado as $key => $value) {
	//$total = $total + $value;
//	$datos[] = "['".$key."', ".$value."]";
///}
//solo los que tiene disciplina
foreach($disciplina as $key => $value) {
	$total = $total + $value;
	$datos[] = "['".$key."', ".$value."]";
}
//Data

?>
<div>
<?php echo "TOTAL DE EVENTOS: ".$total; ?>
</div>

<div class="chart">
	<div class="chart_title">
		<h3>Eventos por tipo de disciplina</h3>
	</div>

	<div id="disciplina" class="chart_graphic">
	</div>

	<div class="chart_table">
		<table>
			<tr>
				<th>Concepto</th>
				<th>Cantidad</th> 
				<th>porcentaje</th>
			</tr>
			<?php
			foreach($disciplina_resultado as $key => $value) {
				echo "<tr>";
					echo "<td>".$key."</td>";
					echo "<td>".$value."</td>";
					echo "<td>".round((($value*100)/$total),2)."</td>";
				echo "<tr>";
			}
			?>
		</table>
	</div>
</div>

<div style="clear:both;"></div>

<script>
Highcharts.chart('disciplina', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45
        }
    },
    title: {
		text: '',
		style: {
			display: 'none'
		}
	},
	subtitle: {
		text: '',
		style: {
			display: 'none'
		}
	},
    plotOptions: {
        pie: {
            innerSize: 100,
            depth: 45
        }
    },
    series: [{
        name: 'Cantidad de eventos',
        data: [<?php echo join($datos, ',') ?>],
        
    }]
});

</script>


<?php
//Disciplina


//Publico

$field = get_field_object('field_58f69a8bf78e4');
$arreglo_t_publico = $field[choices];

foreach($posts as $p){
	$publico[] = get_post_meta($p->ID,"publico",true);
}

$publico = array_count_values($publico);

$publico_resultado = array_merge($arreglo_t_publico, $publico);

foreach ($publico_resultado as $key => $rest) {
    if (!is_int($rest)){
		$publico_resultado[$key] = 0;
	}
}

//Data
$datos = Array();
//foreach($publico_resultado as $key => $value) {
	
//	$datos[] = "['".$key."', ".$value."]";
//}
//solo los que tiene disciplina
foreach($publico as $key => $value) {
	
	$datos[] = "['".$key."', ".$value."]";
}
//Data
?>
<div class="chart">
	<div class="chart_title">
		<h3>Eventos por tipo de público</h3>
	</div>

	<div id="publico" class="chart_graphic">
	</div>

	<div class="chart_table">
		<table>
			<tr>
				<th>Concepto</th>
				<th>Cantidad</th> 
				<th>porcentaje</th>
			</tr>
			<?php
			foreach($publico_resultado as $key => $value) {
				echo "<tr>";
					echo "<td>".$key."</td>";
					echo "<td>".$value."</td>";
					echo "<td>".round((($value*100)/$total),2)."</td>";
				echo "<tr>";
			}
			?>
		</table>
	</div>
</div>
<div style="clear:both;"></div>
<script>
Highcharts.chart('publico', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45
        }
    },
   title: {
		text: '',
		style: {
			display: 'none'
		}
	},
	subtitle: {
		text: '',
		style: {
			display: 'none'
		}
	},
    plotOptions: {
        pie: {
            innerSize: 100,
            depth: 45
        }
    },
    series: [{
        name: 'Cantidad de eventos',
        data: [<?php echo join($datos, ',') ?>],
        
    }]
});

</script>


<?php
//Recinto
$argsR = array(
'post_type'      => 'infraestructura',
'order'          => 'ASC',
'posts_per_page' => -1
);

$recintos = new WP_Query($argsR);

//lugar
/*
$field = get_field_object('field_5919cb13198e1');
$arreglo_t_lugar = $field[choices];

foreach($posts as $p){
	$lugar[] = get_post_meta($p->ID,"lugar_evento",true);
}
$lugar = array_count_values($lugar);

$lugares = Array();
foreach($lugar as $key => $lugar_1){
	$lugares[] = "'".$key."'";
}
$lugar_resultado = array_merge($arreglo_t_lugar, $lugar);
*/
//lugar
//////////$lugar_e = Array();
$lugar_e_t_x = Array();
$lugar222 = 0;
$lugarotro = 0;
$lugarorganismo = 0;
foreach($posts as $p){
	
	if( get_post_meta($p->ID,"lugar_evento",true) == 'Secretaría de Cultura'){
		//////////$lugar_e[] = get_field('lugar',$p->ID)->post_title;
		
		//buscar si es infraestrutura si es sumar a un recinto
		
		$valorpu = get_field('lugar',$p->ID)->ID;
		foreach ( $recintos->posts as $res ) {
			if (get_field('tipo_recinto', $valorpu) == 'Infraestructura'){
				$lugar_e_t_x[] = "ID".$res->ID;
				
			}else{
				$lugar_e_t_x[] = "ID".$valorpu;
			}
		break;
		}
		//buscar si es infraestrutura si es sumar a un recinto		
		
		//echo "ID".get_field('lugar',$p->ID)->ID."  -  ".$p->post_title;
		//echo "<br>";
		$lugar222++;
	}elseif( get_post_meta($p->ID,"lugar_evento",true) == 'Organismo independiente'){
		$lugarorganismo++;
	}elseif( get_post_meta($p->ID,"lugar_evento",true) == 'Otro'){
		$lugarotro++;
	}	
}
//echo "<br>";
//print_r ($lugar_e_t_x);
//echo "<br>";
//////////$lugar_e_t = array_count_values($lugar_e);
$lugar_e_t_t = array_count_values($lugar_e_t_x);

//todos los recintos

//////////$arreglo_t_recinto_title = Array(); 
$arreglo_t_recinto_ID = Array(); 
//////////foreach ( $recintos->posts as $res ) {
	//////////$arreglo_t_recinto_title[$res->post_title] = $res->post_title;
//////////}
foreach ( $recintos->posts as $res ) {
	$arreglo_t_recinto_ID["ID".$res->ID] = "ID".$res->ID;
}

//echo "<br>";
//echo "Secretaria: ".$lugar222;
//print_r ($arreglo_t_recinto_ID);
//echo "<br>";
//echo "Organismos: ".$lugarorganismo;
//echo "<br>";
//echo "Otros: ".$lugarotro;
//echo "<br>";
//NOTA: Jamas, Nunca se puede merguear arreglo con apuntadores numericos
//////////$lugar_resultado_merge = array_merge($arreglo_t_recinto_title, $lugar_e_t);
$lugar_resultado_merge_t = array_merge($arreglo_t_recinto_ID, $lugar_e_t_t);


//////////foreach ($lugar_resultado_merge as $key_m => $rest_m) {
    //////////if (!is_int($rest_m)){
		//////////$lugar_resultado_merge[$key_m] = 0;
	//////////}
//////////}


foreach ($lugar_resultado_merge_t as $key_m_t => $rest_m_t) {
    if (!is_int($rest_m_t)){
		$lugar_resultado_merge_t[$key_m_t] = 0;
	}
}

$myarrayXT = Array(); 
foreach ($lugar_resultado_merge_t as $key_filaXT => $filaXT){
	foreach ( $recintos->posts as $res ) {
		if( str_replace("ID", "", $key_filaXT) == $res->ID AND get_field('tipo_recinto',$res->ID) == 'Recinto'){
			$myarrayXT[] = Array($res->post_title, $filaXT, get_field('municipio',$res->ID)); 
		}
	}		
}

//echo "<br>";
//print_r ($myarrayXT);

//Data
$categorias = Array();
$datos = Array();
foreach($myarrayXT as $valueXT) {
	if ($valueXT[1] > 0){
		$categorias[] = "'".$valueXT[0]."'";
		$datos[] = $valueXT[1];
	}
}


//Data
?>
<div class="chart">
	<div class="chart_title">
		<h3>Eventos por tipo de recinto - Infraestructura de la Secretaría de Cultura</h3>
	</div>

	<div id="recinto" class="chart_graphic">
	</div>

	<div class="chart_table">
		<table>
			<tr>
				<th>Concepto</th>
				<th>Cantidad</th> 
				<th>porcentaje</th>
			</tr>
			<?php
			foreach($myarrayXT as $valueXT) {
				echo "<tr>";
					echo "<td>".$valueXT[0]."</td>";
					echo "<td>".$valueXT[1]."</td>";
					echo "<td>".round((($valueXT[1]*100)/$total),2)."</td>";
				echo "<tr>";
			}
			?>
		</table>
	</div>
</div>
<div style="clear:both;"></div>
<script>
var colors = Highcharts.getOptions().colors,
    categories = ['Otros','Secretaría de Cultura'],
    data = [{
        y: <?php echo $lugarotro; ?>,
        color: colors[0],
        drilldown: {
            name: 'Otros',
            categories: ['Otros'],
            data: [<?php echo $lugarotro; ?>],
            color: colors[0]
        }
    }, {
        y: <?php echo $lugar222; ?>,
        color: colors[3],
        drilldown: {
            name: 'Secretaría de Cultura',
            categories: [<?php echo join($categorias, ',') ?>],
            data: [<?php echo join($datos, ',') ?>],
            color: colors[3]
        }
    }
    ],
    browserData = [],
    versionsData = [],
    i,
    j,
    dataLen = data.length,
    drillDataLen,
    brightness;


// Build the data arrays
for (i = 0; i < dataLen; i += 1) {

    // add browser data
    browserData.push({
        name: categories[i],
        y: data[i].y,
        color: data[i].color
    });

    // add version data
    drillDataLen = data[i].drilldown.data.length;
    for (j = 0; j < drillDataLen; j += 1) {
        brightness = 0.2 - (j / drillDataLen) / 5;
        versionsData.push({
            name: data[i].drilldown.categories[j],
            y: data[i].drilldown.data[j],
            color: Highcharts.Color(data[i].color).brighten(brightness).get()
        });
    }
}

// Create the chart
Highcharts.chart('recinto', {
    chart: {
        type: 'pie'
    },
    title: {
		text: '',
		style: {
			display: 'none'
		}
	},
	subtitle: {
		text: '',
		style: {
			display: 'none'
		}
	},
    yAxis: {
        title: {
            text: ''
        }
    },
    plotOptions: {
        pie: {
            shadow: false,
            center: ['50%', '50%']
        }
    },
    tooltip: {
        valueSuffix: ''
    },
    series: [{
        name: 'Cantidad de eventos',
        data: browserData,
        size: '60%',
        dataLabels: {
            formatter: function () {
                return this.y > 5 ? this.point.name : null;
            },
            color: '#ffffff',
            distance: -30
        }
    }, {
        name: 'Cantidad de eventos',
        data: versionsData,
        size: '80%',
        innerSize: '60%',
        dataLabels: {
            formatter: function () {
                // display only if larger than 1
                return this.y > .5 ? '<b>' + this.point.name + '</b> ' : null;
            }
        },
        id: 'versions'
    }],
    responsive: {
        rules: [{
            condition: {
                maxWidth: 400
            },
            chartOptions: {
                series: [{
                    id: 'versions',
                    dataLabels: {
                        enabled: false
                    }
                }]
            }
        }]
    }
});
</script>
<?php
//Municipio

$datos = Array();
foreach($myarrayXT as $valueXT) {
	if ($valueXT[1] > 0){
		$datos[] = array($valueXT[2] => $valueXT[1]);
	}
}

$sumArray = array();
foreach ($datos as $k=>$subArray) {
  foreach ($subArray as $id=>$value) {
    $sumArray[$id]+=$value;
  }
}
//Data
$datos = Array();
foreach($sumArray as $key => $value) {
	$datos[] = "['".$key."', ".$value."]";
}
array_push($datos, "['Otros', ".$lugarotro."]" );
//Data
?>

<div class="chart">
	<div class="chart_title">
		<h3>Eventos por municipio - Infraestructura de la Secretaría de Cultura</h3>
	</div>

	<div id="municipio" class="chart_graphic">
	</div>

	<div class="chart_table">
		<table>
			<tr>
				<th>Concepto</th>
				<th>Cantidad</th> 
				<th>porcentaje</th>
			</tr>
			<?php
			foreach($sumArray as $key => $value) {
				echo "<tr>";
					echo "<td>".$key."</td>";
					echo "<td>".$value."</td>";
					echo "<td>".round((($value*100)/$total),2)."</td>";
				echo "<tr>";
			}
			?>
		</table>
	</div>
</div>



<script>
Highcharts.chart('municipio', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45
        }
    },
    title: {
		text: '',
		style: {
			display: 'none'
		}
	},
	subtitle: {
		text: '',
		style: {
			display: 'none'
		}
	},
    plotOptions: {
        pie: {
            innerSize: 100,
            depth: 45
        }
    },
    series: [{
        name: 'Cantidad de eventos',
        data: [<?php echo join($datos, ',') ?>],
        
    }]
});

</script>

<?php
/*print_r($posts);
foreach($posts as $p){
	$categoria[] = get_post_meta($p->ID,"categoria",true);
}*/
?>

<div style="clear:both;"></div>
<div class="chart">
	<div class="chart_title">
		<h3>Eventos por municipio y categoria de la Secretaría de Cultura</h3>
	</div>

		<div class="chart_table">
		<table>
			<tr>
				<th>ID</th>
				<th>Titulo</th> 
				<th>Categoria</th>
				<th>Municipio</th>
			</tr>
			<?php
			foreach($posts as $pp){
				//print_r( $pp );
				echo "<tr>";
					echo "<td>".$pp->ID."</td>";
					echo "<td>".$pp->post_title."</td>";
					echo "<td>";
					
					//print_r(get_field("categoria",$pp->ID)[0]->term_id);
					print_r ( get_the_category_by_ID( get_field("categoria",$pp->ID)[0]->term_id ) );
					 echo "</td>";
					echo "<td>"; 
					echo get_field("municipio",get_field("lugar",$pp->ID)->ID);
					echo "</td>";
					//get_field('municipio',$res->ID)
					//get_post_meta($pp->ID,"categoria",true)
					//echo "<td>".round((($value*100)/$total),2)."</td>";
				echo "<tr>";
				//$categoria[] = get_post_meta($p->ID,"categoria",true);
			}
			/*foreach($sumArray as $key => $value) {
				echo "<tr>";
					echo "<td>".$key."</td>";
					echo "<td>".$value."</td>";
					echo "<td>".round((($value*100)/$total),2)."</td>";
				echo "<tr>";
			}*/
			?>
		</table>
	</div>
</div>


