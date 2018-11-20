<?php
/*
* Eventos
* Name: Cartelera Digital
* Author's: Eliel Trigueros Hernandez, Omar Oliver Rodriguez, Eloy Monter Hernández
* Author URI: http://cultura.hidalgo.gob.mx
* @since Versión 2.0, revisión 2 Enero/2018
* @since Versión 3.0, revisión 3 Abril/2018
*/
$ios = $_GET['ios'];  
?>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../wp-content/themes/EspecialesT2/eventos/style_android.css">
	<?php wp_head(); ?>
	<script src="../wp-content/themes/EspecialesT2/eventos/slick/slick.min.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" type="text/css" href="../wp-content/themes/EspecialesT2/eventos/slick/slick.css">
	<link rel="stylesheet" type="text/css" href="../wp-content/themes/EspecialesT2/eventos/slick/slick-theme.css"> 
    
<script type="text/javascript">
function mostrar(){
	var div3 = document.getElementById('filter');
	if(div3.style.display == 'block'){
          div3.style.display = 'none';
          jQuery('#filtros').prop('value', 'Buscar'); 
          
       }else{
          div3.style.display = 'block';
          jQuery('#filtros').prop('value', 'Ocultar'); 
         }
}
</script>

</head>
<body>
<div class="filter_box">
   <div class="header_box">
	   <img class="logo" src="../wp-content/themes/EspecialesT2/eventos/gob.png" />
	   <img class="escudo" src="../wp-content/themes/EspecialesT2/eventos/escudo.png" />
	   <input class="btn_filtrar" type="submit" name="submit" onclick="mostrar()" value="Buscar" id="filtros">
	</div>
	<div id="filter" style="display:none;">
   	<!-- insertar formulario de filtro-->
   	<input id="txtTexto" placeholder="Buscar evento">
   		<select id="selEvento" name="selEvento">
			<option value="Eventos" selected>Eventos</option>
			<option value="Temporal">Exposiciones temporales</option>
			<option value="Permanente">Actividades permanentes</option>
			<option value="Convocatoria">Convocatoria</option>
		</select>
		<select id="selFecha" name="selFecha">
			<option value="0" selected>Hoy</option>
			<option value="1">Mañana</option>
			<option value="2">Pasado mañana</option>
			<option value="3">Futuras</option>
		</select>
		<select id="selDisciplina" name="selDisciplina"></select>
		<select id="selRecinto" name="selRecinto"></select>
		<input type="submit" name="submit" value="Filtrar" id="submit" onclick="get_list_box_ajax();get_Bread();">
   </div>   
</div>
<?php
$args = array(
'post_type'      => 'eventos',
'order'          => 'DESC',
'posts_per_page' => -1,
'post_status' => 'publish',
'meta_query'    => array()
);


array_push($args['meta_query'], array(
	array(
		array(
				'key' => 'slider', 
                'value' => 1, 
                'compare' => '==',
      )),
  ));

$events = new WP_Query($args);

?>
	
<section class="regular_sc slider">

<?php
$hoy = date("Y-m-d", strtotime("now"));
foreach ($events->posts as $post){
	
	$array_de_fechas = Array(); 
	$event_id=$post->ID;
	
if (get_field('tipo_de_evento', $event_id) == 'Evento'){
	
	if( have_rows('fechas') ){
			while( have_rows('fechas') ){
				the_row();
				$array_de_fechas[] = get_sub_field('fecha',false);
			}
		}
    
	if( have_rows('periodo') ){//periodo
		while( have_rows('periodo') ){
			the_row();
			$fecha_inicio = get_sub_field('fecha_inicio',false);
			$fecha_cierre = get_sub_field('fecha_cierre',false);
		}
		$begin = new DateTime( $fecha_inicio );
		$end = new DateTime( $fecha_cierre );
		$end = $end->modify( '+1 day' ); 
		
		$interval = new DateInterval('P1D');
		$daterange = new DatePeriod($begin, $interval ,$end);

		foreach($daterange as $date){
			$array_de_fechas[]= $date->format("Y-m-d");
		}
	}//periodo
	
	$datetime1 = new DateTime($hoy);
	
	foreach($array_de_fechas as $date){	
		$datetime2 = new DateTime($date);
		$interval = $datetime1->diff($datetime2);
		$intervalo = $interval->format('%R%a');
		if ($intervalo >= 0){
			//imagen destacada
			$imagen_destacada = get_field('encabezado', $event_id);
			if (empty($imagen_destacada)) {
				$imagen_destacada = '/wp-content/gallery/sinImagen.jpg';
			}else{
				$imagen_destacada = get_field('encabezado', $event_id);
			}
			//imagen destacada
			?>
			<div class="CCA1">
				 <?php
                    if (isset($ios)){
					echo '<a href="'.get_permalink($event_id).'?app=1&ios=1" title="'.$post->post_title.'"><img src="'.$imagen_destacada.'"></a>';
					}else{
	                echo '<a href="'.get_permalink($event_id).'?app=1" title="'.$post->post_title.'"><img src="'.$imagen_destacada.'"></a>';
					}
					?>	 
				
			</div>
			<?php
			break;
			}
	}
}//If evento	
}//foreach
?>
</section>
<!--veda
<section class="regular_sc slider">
			<div class="CCA1">
				 <img src="/wp-content/gallery/VEDA_D _2.png" style="max-width:100%">
			</div>
</section>
-->
<div class="BreadCrombs">
<span id="bread">Eventos / Hoy / Todas las categorías / Todos los recintos</span>
</div>

<div id="list_box">
</div>	

<script type="text/javascript">
jQuery(document).on('ready', function() {	
	jQuery(".regular_sc").slick({
                dots: false,
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                prevArrow:"<img class='a-left control-c prev slick-prev' src='../wp-content/themes/EspecialesT2/eventos/slick/ant_verde.png'>",
                nextArrow:"<img class='a-right control-c next slick-next' src='../wp-content/themes/EspecialesT2/eventos/slick/next_verde.png'>",
    });
	getDisciplinas();
});

function getDisciplinas () {
	jQuery.ajax({
            url:   '../wp-content/themes/EspecialesT2/eventos/ajax/get_disciplinas.php',
            type:  'post',
            success:  function (response) {
                    jQuery("#selDisciplina").html(response);
                    getRecintos();
            }
    });
}
function getRecintos () {
	jQuery.ajax({
        url:   '../wp-content/themes/EspecialesT2/eventos/ajax/get_recintos.php',
        type:  'post',
        success:  function (response) {
                jQuery("#selRecinto").html(response);
				get_list_box_ajax();
        }
    });
}

function get_Bread(){
	var monthNames = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"]	;
	var f=new Date();
	var fSelecionada;
	var Evento = jQuery( "#selEvento option:selected" ).text();
	var Fecha = jQuery( "#selFecha option:selected" ).val();
	var Disciplina = jQuery( "#selDisciplina option:selected" ).text();
	var Recinto = jQuery( "#selRecinto option:selected" ).text();
	if (Fecha==0) {
		fSelecionada="Hoy";
	}else if(Fecha==1){
		fSelecionada = new Date();
		fSelecionada.setDate(fSelecionada.getDate() + 1);
		fSelecionada = fSelecionada.getDate()+" - "+monthNames[fSelecionada.getMonth()]+" - "+fSelecionada.getFullYear();
	}else if(Fecha==2){
		fSelecionada = new Date();
		fSelecionada.setDate(fSelecionada.getDate() + 2);
		fSelecionada = fSelecionada.getDate()+" - "+monthNames[fSelecionada.getMonth()]+" - "+fSelecionada.getFullYear();
	}else if(Fecha==3){
		fSelecionada="Futuras";
	}
	jQuery( "#bread" ).html(Evento+" / "+fSelecionada+" / "+Disciplina+" / "+Recinto);
}
function get_list_box_ajax() {
	var Texto = jQuery( "#txtTexto" ).val();
	var Evento = jQuery( "#selEvento option:selected" ).val();
	var Fecha = jQuery( "#selFecha option:selected" ).val();
	var Disciplina = jQuery( "#selDisciplina option:selected" ).val();
	var Recinto = jQuery( "#selRecinto option:selected" ).val();		
	var parametros = {
		"Evento" : Evento,
		"Fecha" : Fecha,
		"Disciplina" : Disciplina,
		"Recinto" : Recinto,
		"Texto" : Texto
	};
       
        jQuery.ajax({
                type: "POST",                
                <?php
                if (isset($ios)){
	            	echo 'url: "../wp-content/themes/EspecialesT2/eventos/ajax/list_box_ajax.php/?ios=1",';
				}else{
	            	echo 'url: "../wp-content/themes/EspecialesT2/eventos/ajax/list_box_ajax.php",';
				}
				?>                
                data: parametros,
                beforeSend: function () {
					var div3 = document.getElementById('filter');
			        div3.style.display = 'none';
                    jQuery("#list_box").html("<div class='msj_error'>Procesando, espere por favor...</div>");
            	},
                success: function(response){
			        jQuery('#filtros').prop('value', 'Buscar'); 
                    jQuery('#list_box').html(response).fadeIn();
                }
        });     
    }
</script>
       
	</body>
</html>
