<?php

setlocale(LC_ALL,"es_ES");

$args = array(
'post_type'      => 'eventos',
'order'          => 'ASC',
'posts_per_page' => -1,
		'meta_query' => array(
            array(
                'key' => 'evento_principal', 
                'value' => $ID, //9820
                'compare' => '=='
            ))
		);

$events = new WP_Query($args);

$array_de_fechas= array();
foreach ($events->posts as $post){
	
	if( have_rows('fechas') ){
		while( have_rows('fechas') ){
			the_row();
			$array_de_fechas[] = get_sub_field('fecha',false);
		}
	}
}

$unique_fechas = array_unique($array_de_fechas);
sort($unique_fechas);
?>
<html>
<head>
	<title></title>
</head>
<body>
	<div class="tab">
		<?php
			for ($i=0; $i < count($unique_fechas); $i++) {
				$fchTab = str_replace("-", "", $unique_fechas[$i]);
				$tabID = substr($fchTab, -4);
				$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
				$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				echo "<button class='tablinks' id='tb".$tabID."' onclick=\"setDia(event, '".$tabID."');\">".$dias[date('w', strtotime($unique_fechas[$i]))]." ".strftime("%e", strtotime($unique_fechas[$i])).", ".$meses[(int)strftime("%m", strtotime($unique_fechas[$i]))-1]."</button>";
			}
			/*for ($i=0; $i < count($unique_fechas); $i++) {
				$fchTab = str_replace("-", "", $unique_fechas[$i]);
				$tabID = substr($fchTab, -4);
				$fecha = strftime("%A %e", strtotime($unique_fechas[$i]));
				echo "<button class='tablinks' id='tb".$tabID."' onclick=\"setDia(event, '".$tabID."');\">".$fecha."</button>";
			}*/
	  	?>
	</div>
	<div style="clear:both"></div>
	<?php
		for ($i=0; $i < count($unique_fechas); $i++) {
			$fchTab = str_replace("-", "", $unique_fechas[$i]);
			$tabID = substr($fchTab, -4);
			echo "<div id='".$tabID."' class='tabcontent'>";
			  foreach ($events->posts as $post){
			  	if( have_rows('fechas') ){
					while( have_rows('fechas') ){
						the_row();
						$array_de_fechas_temp[] = get_sub_field('fecha',false);
					}
				}


				if(in_array($unique_fechas[$i],$array_de_fechas_temp)) {
					
					// Ruta de la imagen destacada
					$imagen_destacada = get_field('img_app', $post->ID);	
					if (empty($imagen_destacada)) {	
						$imagen_destacada = get_the_post_thumbnail( $post->ID, 'medium');
						if (empty($imagen_destacada)) {
							$imagen_destacada = '<img width="300" height="300" class="attachment-medium size-medium wp-post-image" src="/wp-content/gallery/sinImagen.jpg">';
						}else{
							$imagen_destacada = get_the_post_thumbnail( $post->ID, 'medium');
						}
					}else{
						$imagen_destacada = '<img width="300" height="300" class="attachment-medium size-medium wp-post-image" src="'.$imagen_destacada.'">';
					}
					$lugar=get_field('lugar', $post->ID);
					?>
						<div class="calendar_tabs"> 
						   <div class="calendar_thumbnail"><!-- imagen destacada -->
						   	<?php
						   	if(isset( $app ) AND isset( $ios )){
								echo "<a href='/eventos/".$post->post_name."/?app=1&ios=1' title='".$post->post_title."'>".$imagen_destacada."</a>";
							}else if(isset($app)){
								echo "<a href='/eventos/".$post->post_name."/?app=1' title='".$post->post_title."'>".$imagen_destacada."</a>";
							}else if(isset($ios)){
								echo "<a href='/eventos/".$post->post_name."/?ios=1' title='".$post->post_title."'>".$imagen_destacada."</a>";
							}else{
								echo "<a href='".$post->guid."' title='".$post->post_title."'>".$imagen_destacada."</a>";
							}
						    ?>
						   </div>
						   
						   <div class="calendar_data"><!-- tabla con datos -->
						   	<table width="100%" border="0">
						           <tr>
						             <td><?php echo $post->post_title; ?></td>
						           </tr>
						           <tr>
						             <td>
						             	<?php 
						             		if(get_field('lugar_evento') == 'Otro'){ 
                								echo get_field('otro_lugar', $post->ID);
											}else{
												echo $lugar->post_title;
											}
										?>
									 </td>
						           </tr>
						           <tr>
						             <td>
						             	<?php 
						             	while( have_rows('fechas') ): the_row();
                							if (get_sub_field('fecha',false) == $unique_fechas[$i]){								
                								if(have_rows('horarios') ):
                								    while( have_rows('horarios') ): the_row();
                								    the_sub_field('horario');
                								    echo " h ";
                								    endwhile;
                								endif;
											}
                						endwhile;
                						?>
                					 </td>
						           </tr>
						           <tr>
						             <td><?php 
						             if (get_field('tipo_entrada') == 'Cuota de recuperación') {
						             	echo "Cuota de recuperación: $".get_field('costo_entrada', $post->$ID).".00"; 
						             }else if( get_field('tipo_entrada') == 'Inscripción'){
						             	echo "Costo de inscripción: $".get_field('costo_entrada', $post->$ID).".00"; 
						             }else if(get_field('tipo_entrada') == 'Bono'){
						             	echo "Bono: $".get_field('costo_entrada', $post->$ID).".00"; 
						             }else if(get_field('tipo_entrada') == 'Gratuito'){
						             	echo "Entrada libre"; 
						             }else if(get_field('tipo_entrada') == 'Boleto de cortesía'){
						             	echo "Boleto de cortesía"; 
						             }
						              ?></td>
						           </tr>
						       </table>
						
						   </div>
						</div>
					<?php
				}
				$array_de_fechas_temp = array();
			  }
			  
			echo "</div>";
		}
	?>
</body>
</html>
<style type="text/css">
	/* Style the tab */
	@media (max-width : 320px) {
		div.tab {
			max-width : 250px;
		}
	}
	div.tab {
		display: block;
		float: left;
	    overflow: hidden;
	    border: 1px solid #ccc;
	    background-color: #f1f1f1;
	}
	
	/* Style the buttons inside the tab */
	div.tab button {
	    background-color: inherit;
	    float: left;
	    border: none;
	    outline: none;
	    cursor: pointer;
	    padding: 14px 16px;
	    transition: 0.3s;
	}
	
	/* Change background color of buttons on hover */
	div.tab button:hover {
	    background-color: #ddd;
	}
	
	/* Create an active/current tablink class */
	div.tab button.active {
	    background-color: #ccc;
	}
	
	/* Style the tab content */
	.tabcontent {
	    display: none;
	    padding: 6px 12px;
	    border: 1px solid #ccc;
	    border-top: none;
	    float:left;
	}

</style>

<script type="text/javascript">

	jQuery('document').ready(function(){
		setTab();
	});

	function setDia(evt, dia) {
    var i, tabcontent, tablinks;

    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    document.getElementById(dia).style.display = "block";
    evt.currentTarget.className += " active";
	}
	
	function setTab(){
		//var d = new Date();
		//$(".calendar_tabs").each(function(){
        //	    setDia(event, '21'); jQuery('#tb21').addClass('active');
        //});
		id = jQuery('.tablinks').first().attr('id');
		setDia(event, id.substr(id.length - 4));
		jQuery('#'+id).addClass('active');
	}
</script>
