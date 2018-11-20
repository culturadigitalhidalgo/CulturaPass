<?php
/**
 * List, Box AJAX
 * Name: Cartelera Digital
 * Author's: Eliel Trigueros Hernandez, Omar Oliver Rodriguez, Eloy Monter Hernández
 * Author URI: http://cultura.hidalgo.gob.mx
 * @since Versión 3.0, revisión 3. Enero/2018
 * @since Versión 4.0, revisión 4 Abril/2018
*/

$ios = $_GET['ios'];

require ('../../../../../wp-load.php');
//$hoy = date('Y-m-d', strtotime('-1 day')) ; // resta 1 día fecha del servidor esta mal esta adelantado un dia
$hoy = date ( 'Y-m-d' , strtotime ( date("Y-m-d", strtotime("now")) )  ); //Usar si la fecha esta bien
$txtTexto=trim($_POST['Texto']);
$txtTexto = strip_tags($txtTexto); 
$selFecha =$_POST['Fecha'];
$selDisciplina =$_POST['Disciplina'];
$selRecinto =$_POST['Recinto'];
$selEvento =$_POST['Evento'];

if($selRecinto != 0){
$argsR = array(
		'post_type'      => 'infraestructura',
		'order'          => 'ASC',
		'posts_per_page' => -1,
		'meta_query' => array(
		          array(
		              'key' => 'recinto', 
		              'value' => $selRecinto,
		              'compare' => '=='
		          ))
		);

	$recintos = new WP_Query($argsR);
	$selRecintosT = Array($selRecinto);
	foreach ( $recintos->posts as $res ) {
		$selRecintosT[] = $res->ID;
	}
}

if ($txtTexto!="") {
	$args = array(
	'post_type'      => 'eventos',
	's'           => $txtTexto,
	'order'          => 'DESC',
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'meta_query'    => array()
	
	);
}else{
	$args = array(
	'post_type'      => 'eventos',
	'order'          => 'DESC',
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'meta_query'    => array()
	
	);
}
if($selDisciplina!='0'){
  array_push($args['meta_query'], array(
      array(
             array(
                 'key' => 'disciplina', 
                 'value' => $selDisciplina, 
                 'compare' => '==',
      )),
  ));
}
if($selRecinto != '0'){
  array_push($args['meta_query'], array(
      array(
             array(
                 'key' => 'lugar', 
                 'value' =>  $selRecintosT,
				 'compare' => 'IN'
      )),
    ));
}
if($selEvento != 'Eventos' AND $selEvento != ''){
  array_push($args['meta_query'], array(
      array(
             array(
                 'key' => 'evento_por_tiempo',  
                 'value' =>  $selEvento,
				 'compare' => '=='
      )),
    ));
}

$metaQuery = count($args['meta_query']);
if ($metaQuery>=2) {
	array_push($args['meta_query'], array(
      'relation'  => 'AND',
      ));
}

$events = new WP_Query($args);
$bandera = 0;
foreach ($events->posts as $post){
		$ID=get_the_ID();
		$event_id=get_the_ID();

if($selEvento == 'Eventos' ){	//solo eventos	
	if ((get_field('tipo_de_evento', $event_id) == 'Sub - Evento') || (get_field('subeventos', $event_id) <> 1) || (get_field('evento_por_tiempo', $event_id) == 'Eventos') ){
	$array_de_fechas = Array(); 
	//fechas
	if( have_rows('fechas') ){
			while( have_rows('fechas') ){
				the_row();
				$array_de_fechas[] = get_sub_field('fecha',false);
			}
		}
	$datetime1 = new DateTime($hoy);
	
	foreach($array_de_fechas as $date){	
		$datetime2 = new DateTime($date);
		$interval = $datetime1->diff($datetime2);
		$intervalo = $interval->format('%R%a');
		if($selFecha == 3){
		if($intervalo >= 0){
			$bandera = 1;
			
	// Ruta de la imagen destacada
	$imgDestacada[0] = get_field('img_app', $ID);	
	if (empty($imgDestacada[0])) {
		if ( has_post_thumbnail() ) {
			$thumbID = get_post_thumbnail_id( $ID );
			$imgDestacada = wp_get_attachment_image_src( $thumbID, 'medium' ); 
		}else{
			$imgDestacada[0] = '/wp-content/gallery/sinImagen.jpg';
		}
	}
		//Obtener categorias
		$cat_e = get_field('categoria', $ID);
		$cat_e_a = array();
		foreach ( $cat_e as $cat_ele ) {
			$cat_e_a[] = $cat_ele->name;
		}
		//print_r($cat_e_a);
		$cat_e = join( ", ", $cat_e_a );
		//Obtener categorias
		
	//Obtener diciplina
	$diciplina = get_field('disciplina', $ID);
	$lugar=get_field('lugar', $ID);
	$municipio=get_field('municipio', $lugar->ID);
		?>
        
<!-- BODY -->        
        <div class="app_android">
        	
        	<?php
			if(isset($ios)){
				echo '<span class="thumb"><a href="'.get_permalink($event_id).'?app=1&ios=1" title="'.$post->post_title.'"><img src="'.$imgDestacada[0].'"alt="'.$post->post_title.'"></a></span>';
			}else{
				echo '<span class="thumb"><a href="'.get_permalink($event_id).'?app=1" title="'.$post->post_title.'"><img src="'.$imgDestacada[0].'"alt="'.$post->post_title.'"></a></span>';
			}
			?>
            
            <div class="app_tax" 
            <?php 
				if($diciplina == "Artes Visuales")
					echo 'style="background:#334A5F;"';
				if($diciplina == "Danza")
					echo 'style="background:#2A94D6;"';
				if($diciplina == "Música")
					echo 'style="background:#77698c;"';
				if($diciplina == "Literatura")
					echo 'style="background:#4EB1CB;"';	
				if($diciplina == "Cine")
					echo 'style="background:#CF5C60;"';
				if($diciplina == "Teatro")
					echo 'style="background:#4AB471;"';
				if($diciplina == "Gastronomía")
					echo 'style="background:#F3AE4E;"';
				if($diciplina == "Patrimonio Cultural")
					echo 'style="background:#D96383;"';
			?>
            >
            <span>
            	<?php
            	echo $diciplina;?> / <?php echo $cat_e;//echo $on_draught = join( ", ", $draught_links );
            	echo '<br>';
            	echo '<b>'.$municipio.'</b>';
            	?>            	
            </span>
            </div>
            
            <div class="app_data">
            <?php
             if(isset($ios)){
				echo '<span class="app_title"><a href="'.get_permalink($event_id).'?app=1&ios=1">'.$post->post_title.'</a></span>';
			}else{
				echo '<span class="app_title"><a href="'.get_permalink($event_id).'?app=1">'.$post->post_title.'</a></span>';
			}
			?>
            <?php // EMH Personas
            if( get_field('persona_AC') ): ?>
                <span class="app_persona">
            <?php
                $persona_AC=get_field('persona_AC', $ID);
                foreach ($persona_AC as $persona){
                    echo '<span>'.$persona['persona']->post_title.'</span>';
                }
                echo '<span>'.get_field('imparte', $ID).'</span>';
                ?>         
                </span>
            <?php endif; ?>     
            
			<div class="event_data">
        <?php
        	$date_f = new DateTime($date);
		?>
        <span itemprop="startDate" content="<?php echo $date; ?>"><?php //echo $date_f->format('F j');?></span>
        <span itemprop="endDate" content="<?php echo $date_f->format('F j'); ?>"></span>
        
        <?php
		/*Solo debe mostrar la hora del dia dehoy o del filtro que se aplico*/
                while( have_rows('fechas') ): the_row();
                
                if (get_sub_field('fecha',false) == $date){
                if($selFecha=='3'){
                 the_sub_field('fecha'); echo "&nbsp;";
                }
                
                    if( have_rows('horarios') ):
                
                        while( have_rows('horarios') ): the_row();
                        the_sub_field('horario');
                        echo " h";
                        endwhile;
                     endif;
				 }
                endwhile;
/*Solo debe mostrar la hora del dia dehoy o del filtro que se aplico*/
                ?>
            </span>
        <?php // EMH Lugar
            $post_object = get_field('lugar');
            if( $post_object ): 
                // override $post
                $post = $post_object;
                setup_postdata( $post ); 
                ?>
                <span class="app_lugar"><?php the_title(); ?></span>
            <?php endif; ?>
            
            <?php if( get_field('lugar_evento') == 'Otro' ): ?>
                <span class="app_lugar"><?php echo get_field('otro_lugar', $ID)?></span>
            <?php endif; ?>
            
		</div><!--app_fecha-->
	</div><!--app_data-->
</div><!--app_android-->
		
<?php			
			break;
}//este es del if de intervalo
			
			
}else{ //if $selFecha			
			
		if ($intervalo == $selFecha){
			$bandera = 1;
	// Ruta de la imagen destacada
	$imgDestacada[0] = get_field('img_app', $ID);	
	if (empty($imgDestacada[0])) {
		if ( has_post_thumbnail() ) {
			$thumbID = get_post_thumbnail_id( $ID );
			$imgDestacada = wp_get_attachment_image_src( $thumbID, 'medium' ); 
		}else{
			$imgDestacada[0] = '/wp-content/gallery/sinImagen.jpg';
		}
	}

		//Obtener categorias
		$cat_e = get_field('categoria', $ID);
		$cat_e_a = array();
		foreach ( $cat_e as $cat_ele ) {
			$cat_e_a[] = $cat_ele->name;
		}
		//print_r($cat_e_a);
		$cat_e = join( ", ", $cat_e_a );
		//Obtener categorias
		
	//Obtener diciplina
	$diciplina = get_field('disciplina', $ID);
	$lugar=get_field('lugar', $ID);
	$municipio=get_field('municipio', $lugar->ID);
		?>
        
<!-- BODY -->        
        <div class="app_android">
        	
        	<?php 
        	if(isset($ios)){
					echo '<span class="thumb"><a href="'.get_permalink($event_id).'?app=1&ios=1" title="'.$post->post_title.'"><img src="'.$imgDestacada[0].'"alt="'.$post->post_title.'"></a></span>';
			}else{
					echo '<span class="thumb"><a href="'.get_permalink($event_id).'?app=1" title="'.$post->post_title.'"><img src="'.$imgDestacada[0].'"alt="'.$post->post_title.'"></a></span>';
			}
			?>
            
            <div class="app_tax" 
            <?php 
				if($diciplina == "Artes Visuales")
					echo 'style="background:#334A5F;"';
				if($diciplina == "Danza")
					echo 'style="background:#2A94D6;"';
				if($diciplina == "Música")
					echo 'style="background:#77698c;"';
				if($diciplina == "Literatura")
					echo 'style="background:#4EB1CB;"';	
				if($diciplina == "Cine")
					echo 'style="background:#CF5C60;"';
				if($diciplina == "Teatro")
					echo 'style="background:#4AB471;"';
				if($diciplina == "Gastronomía")
					echo 'style="background:#F3AE4E;"';
				if($diciplina == "Patrimonio Cultural")
					echo 'style="background:#D96383;"';
			?>
            >
            <span>
            	<?php
            	echo $diciplina;?> / <?php echo $cat_e;//echo $on_draught = join( ", ", $draught_links );
            	echo '<br>';
            	echo '<b>'.$municipio.'</b>';
            	?>            	
            </span>
            </div>
            
            <div class="app_data">
            <?php
            if(isset($ios)){
				echo '<span class="app_title"><a href="'.get_permalink($event_id).'?app=1&ios=1">'.$post->post_title.'</a></span>';
			}else{
				echo '<span class="app_title"><a href="'.get_permalink($event_id).'?app=1">'.$post->post_title.'</a></span>';
			}
			?>
            
			<?php // EMH Personas
            if( get_field('persona_AC') ): ?>
                <span class="app_persona">
            <?php
                $persona_AC=get_field('persona_AC', $ID);
                foreach ($persona_AC as $persona){
                    echo '<span>'.$persona['persona']->post_title.'</span>';
                }
                echo '<span>'.get_field('imparte', $ID).'</span>';
                //	}
                ?>         
                </span>
            <?php endif; ?>     
            
			<div class="event_data">
            
        <?php
        $date_f = new DateTime($date);
		?>
        <span itemprop="startDate" content="<?php echo $date; ?>"><?php //echo $date_f->format('F j');?></span>
        <span itemprop="endDate" content="<?php echo $date_f->format('F j'); ?>"></span>
        
		<?php
/*Solo debe mostrar la hora del dia dehoy o del filtro que se aplico*/
                while( have_rows('fechas') ): the_row();
                
                if (get_sub_field('fecha',false) == $date){
                if($selFecha=='3'){
                 the_sub_field('fecha'); echo "&nbsp;";
                }
                    if( have_rows('horarios') ):
                
                        while( have_rows('horarios') ): the_row();
                        the_sub_field('horario');
                        echo " h";
                        endwhile;
                     endif;
				 }
                endwhile;
/*Solo debe mostrar la hora del dia dehoy o del filtro que se aplico*/
                ?>
                
            </span>
            
            <?php // EMH Lugar
            $post_object = get_field('lugar');
            if( $post_object ): 
                // override $post
                $post = $post_object;
                setup_postdata( $post ); 
                ?>
                <span class="app_lugar"><?php the_title(); ?></span>
            <?php endif; ?>
            
            <?php if( get_field('lugar_evento') == 'Otro' ): ?>
                <span class="app_lugar"><?php echo get_field('otro_lugar', $ID)?></span>
            <?php endif; ?>
            
		</div><!--app_fecha-->
	</div><!--app_data-->
</div><!--app_android-->
		
<?php			
			break;
			}
			
		}//else $selFecha			
	}//foreach fecha de hoy
  }//if Sub - Evento
}//solo eventos

if($selEvento == 'Convocatoria' ){	//solo convocatorias	

	if ((get_field('tipo_de_evento', $event_id) == 'Sub - Evento') || (get_field('subeventos', $event_id) <> 1) || (get_field('evento_por_tiempo', $event_id) == 'Convocatoria') ){
	
	$array_de_fechas = Array(); 
    if( have_rows('periodo') ){
		
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
	}
	//periodo
	
	$datetime1 = new DateTime($hoy);
	
	foreach($array_de_fechas as $date){	
		$datetime2 = new DateTime($date);
		$interval = $datetime1->diff($datetime2);
		$intervalo = $interval->format('%R%a');
		if($selFecha == 3){
		echo "futuras";
		//echo "pasado mañana";
			$bandera = 1;
			
	// Ruta de la imagen destacada
	$imgDestacada[0] = get_field('img_app', $ID);	
	if (empty($imgDestacada[0])) {
		if ( has_post_thumbnail() ) {
			$thumbID = get_post_thumbnail_id( $ID );
			$imgDestacada = wp_get_attachment_image_src( $thumbID, 'medium' ); 
		}else{
			$imgDestacada[0] = '/wp-content/gallery/sinImagen.jpg';
		}
	}

		//Obtener categorias
		$cat_e = get_field('categoria', $ID);
		$cat_e_a = array();
		foreach ( $cat_e as $cat_ele ) {
			$cat_e_a[] = $cat_ele->name;
		}
		//print_r($cat_e_a);
		$cat_e = join( ", ", $cat_e_a );
		//Obtener categorias
		
		
	//Obtener diciplina
	$diciplina = get_field('disciplina', $ID);
	$lugar=get_field('lugar', $ID);
	$municipio=get_field('municipio', $lugar->ID);
		?>
        
<!-- BODY -->        
        <div class="app_android">
        	
        	<?php
			if(isset($ios)){
				echo '<span class="thumb"><a href="'.get_permalink($event_id).'?app=1&ios=1" title="'.$post->post_title.'"><img src="'.$imgDestacada[0].'"alt="'.$post->post_title.'"></a></span>';
			}else{
				echo '<span class="thumb"><a href="'.get_permalink($event_id).'?app=1" title="'.$post->post_title.'"><img src="'.$imgDestacada[0].'"alt="'.$post->post_title.'"></a></span>';
			}
			?>
            
            <div class="app_tax" 
            <?php 
				if($diciplina == "Artes Visuales")
					echo 'style="background:#334A5F;"';
				if($diciplina == "Danza")
					echo 'style="background:#2A94D6;"';
				if($diciplina == "Música")
					echo 'style="background:#77698c;"';
				if($diciplina == "Literatura")
					echo 'style="background:#4EB1CB;"';	
				if($diciplina == "Cine")
					echo 'style="background:#CF5C60;"';
				if($diciplina == "Teatro")
					echo 'style="background:#4AB471;"';
				if($diciplina == "Gastronomía")
					echo 'style="background:#F3AE4E;"';
				if($diciplina == "Patrimonio Cultural")
					echo 'style="background:#D96383;"';
			?>
            >
            <span>
            	<?php
            	echo $diciplina;?> / <?php echo $cat_e;//echo $on_draught = join( ", ", $draught_links );
            	echo '<br>';
            	echo '<b>'.$municipio.'</b>';
            	?>            	
            </span>
            </div>
            
            <div class="app_data">
            <?php
             if(isset($ios)){
				echo '<span class="app_title"><a href="'.get_permalink($event_id).'?app=1&ios=1">'.$post->post_title.'</a></span>';
			}else{
				echo '<span class="app_title"><a href="'.get_permalink($event_id).'?app=1">'.$post->post_title.'</a></span>';
			}			
            
             ?>
            
			<?php // EMH Personas
            if( get_field('persona_AC') ): ?>
                <span class="app_persona">
            <?php
                $persona_AC=get_field('persona_AC', $ID);
                foreach ($persona_AC as $persona){
                    echo '<span>'.$persona['persona']->post_title.'</span>';
                }
                echo '<span>'.get_field('imparte', $ID).'</span>';
                //	}
                ?>         
                </span>
            <?php endif; ?>
        
        	<div class="event_data">
            
			<?php 
            // EMH Fechas y horas
            ?>
        <?php
        $date_f = new DateTime($date);
		?>
        <span itemprop="startDate" content="<?php echo $date; ?>"><?php //echo $date_f->format('F j');?></span>
        <span itemprop="endDate" content="<?php echo $date_f->format('F j'); ?>"></span>

            <?php //EMH Fecha de tipo periódo
        if( have_rows('periodo') ):
            while( have_rows('periodo') ) : the_row(); 
                ?>
                </br>
                <span class="fecha"><?php the_sub_field('fecha_inicio'); ?></span> - <span class="fecha"><?php the_sub_field('fecha_cierre'); ?></span>
                <?php
            endwhile;
        endif;
        ?>  
            </span>

            <?php // EMH Lugar
            $post_object = get_field('lugar');
            if( $post_object ): 
                // override $post
                $post = $post_object;
                setup_postdata( $post ); 
                ?>
                
                <span class="app_lugar"><?php the_title(); ?></span>
            <?php endif; ?>
            
            <?php if( get_field('lugar_evento') == 'Otro' ): ?>
                <span class="app_lugar"><?php echo get_field('otro_lugar', $ID)?></span>
            <?php endif; ?>
            
		</div><!--app_fecha-->
	</div><!--app_data-->
</div><!--app_android-->
		
<?php			
			break;
}else{ //if $selFecha
		if ($intervalo == $selFecha){
			//echo $intervalo;
			//echo "mañana";
			$bandera = 1;
			
	// Ruta de la imagen destacada
	$imgDestacada[0] = get_field('img_app', $ID);	
	if (empty($imgDestacada[0])) {
		if ( has_post_thumbnail() ) {
			$thumbID = get_post_thumbnail_id( $ID );
			$imgDestacada = wp_get_attachment_image_src( $thumbID, 'medium' ); 
		}else{
			$imgDestacada[0] = '/wp-content/gallery/sinImagen.jpg';
		}
	}

		//Obtener categorias
		$cat_e = get_field('categoria', $ID);
		$cat_e_a = array();
		foreach ( $cat_e as $cat_ele ) {
			$cat_e_a[] = $cat_ele->name;
		}
		//print_r($cat_e_a);
		$cat_e = join( ", ", $cat_e_a );
		//Obtener categorias
		
		
	//Obtener diciplina
	$diciplina = get_field('disciplina', $ID);
	$lugar=get_field('lugar', $ID);
	$municipio=get_field('municipio', $lugar->ID);
		?>
        
<!-- BODY -->        
        <div class="app_android">
        	
        	<?php 
        	if(isset($ios)){
				echo '<span class="thumb"><a href="'.get_permalink($event_id).'?app=1&ios=1" title="'.$post->post_title.'"><img src="'.$imgDestacada[0].'"alt="'.$post->post_title.'"></a></span>';
			}else{
				echo '<span class="thumb"><a href="'.get_permalink($event_id).'?app=1" title="'.$post->post_title.'"><img src="'.$imgDestacada[0].'"alt="'.$post->post_title.'"></a></span>';
			}
			?>
            
            <div class="app_tax" 
            <?php 
				if($diciplina == "Artes Visuales")
					echo 'style="background:#334A5F;"';
				if($diciplina == "Danza")
					echo 'style="background:#2A94D6;"';
				if($diciplina == "Música")
					echo 'style="background:#77698c;"';
				if($diciplina == "Literatura")
					echo 'style="background:#4EB1CB;"';	
				if($diciplina == "Cine")
					echo 'style="background:#CF5C60;"';
				if($diciplina == "Teatro")
					echo 'style="background:#4AB471;"';
				if($diciplina == "Gastronomía")
					echo 'style="background:#F3AE4E;"';
				if($diciplina == "Patrimonio Cultural")
					echo 'style="background:#D96383;"';
			?>
            >
            <span>
            	<?php
            	echo $diciplina;?> / <?php echo $cat_e;//echo $on_draught = join( ", ", $draught_links );
            	echo '<br>';
            	echo '<b>'.$municipio.'</b>';
            	?>            	
            </span>
            </div>
            
            <div class="app_data">
            <?php
            if(isset($ios)){
				echo '<span class="app_title"><a href="'.get_permalink($event_id).'?app=1&ios=1">'.$post->post_title.'</a></span>';
			}else{
				echo '<span class="app_title"><a href="'.get_permalink($event_id).'?app=1">'.$post->post_title.'</a></span>';
			}
			?>
            
			<?php // EMH Personas
            if( get_field('persona_AC') ): ?>
                <span class="app_persona">
            <?php
                $persona_AC=get_field('persona_AC', $ID);
                foreach ($persona_AC as $persona){
                    echo '<span>'.$persona['persona']->post_title.'</span>';
                }
                echo '<span>'.get_field('imparte', $ID).'</span>';
                //	}
                ?>         
                </span>
            <?php endif; ?>     
            
			
        
        	<div class="event_data">
            
			<?php 
            // EMH Fechas y horas
            ?>
        <?php
        $date_f = new DateTime($date);
		?>
        <span itemprop="startDate" content="<?php echo $date; ?>"><?php //echo $date_f->format('F j');?></span>
        <span itemprop="endDate" content="<?php echo $date_f->format('F j'); ?>"></span>
        <?php //ETH Los sub-eventos y eventos que no tienen sub-eventos no tiene periodo
			//EMH Fecha de tipo periódo
            if( have_rows('periodo') ):
                while( have_rows('periodo') ) : the_row(); 
                    ?>
           
                    <?php the_sub_field('fecha_inicio'); ?> - <?php the_sub_field('fecha_cierre'); ?>
                    <?php
                endwhile;
            endif;
            ?>
            <?php
/*Solo debe mostrar la hora del dia dehoy o del filtro que se aplico*/
                while( have_rows('fechas') ): the_row();
                
                if (get_sub_field('fecha',false) == $date){
                if($selFecha=='3'){
                 the_sub_field('fecha'); echo "&nbsp;";
                }
                    if( have_rows('horarios') ):
                
                        while( have_rows('horarios') ): the_row();
                        the_sub_field('horario');
                        echo " h";
                        endwhile;
                     endif;
				 }
                endwhile;
/*Solo debe mostrar la hora del dia dehoy o del filtro que se aplico*/
                ?>
                
            </span>

            <?php // EMH Lugar
            $post_object = get_field('lugar');
            if( $post_object ): 
                // override $post
                $post = $post_object;
                setup_postdata( $post ); 
                ?>
                <span class="app_lugar"><?php the_title(); ?></span>
            <?php endif; ?>
            
            <?php if( get_field('lugar_evento') == 'Otro' ): ?>
                <span class="app_lugar"><?php echo get_field('otro_lugar', $ID)?></span>
            <?php endif; ?>
            
		</div><!--app_fecha-->
	</div><!--app_data-->
</div><!--app_android-->
		
<?php			
			break;
			}
			
			
}//else $selFecha			
	}//foreach fecha de hoy
  }//if Sub - Evento
}//solo convocatorias






if($selEvento == 'Temporal' ){	//solo Temporal	

	if ((get_field('tipo_de_evento', $event_id) == 'Sub - Evento') || (get_field('subeventos', $event_id) <> 1) || (get_field('evento_por_tiempo', $event_id) == 'Temporal') ){
	
	
	$array_de_fechas = Array(); 
	//periodo
    if( have_rows('periodo') ){
		
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
	}
	//periodo
	
	$datetime1 = new DateTime($hoy);
	
	foreach($array_de_fechas as $date){	
		$datetime2 = new DateTime($date);
		$interval = $datetime1->diff($datetime2);
		$intervalo = $interval->format('%R%a');
		//echo $intervalo." - ".$ID." -".$post->post_title."<br>";
		if($selFecha == 3){
		//echo "futuras";
		//echo "pasado mañana";
			$bandera = 1;

	// Ruta de la imagen destacada
	$imgDestacada[0] = get_field('img_app', $ID);	
	if (empty($imgDestacada[0])) {
		if ( has_post_thumbnail() ) {
			$thumbID = get_post_thumbnail_id( $ID );
			$imgDestacada = wp_get_attachment_image_src( $thumbID, 'medium' ); 
		}else{
			$imgDestacada[0] = '/wp-content/gallery/sinImagen.jpg';
		}
	}	
			//Obtener categorias
			$cat_e = get_field('categoria', $ID);
			$cat_e_a = array();
			foreach ( $cat_e as $cat_ele ) {
				$cat_e_a[] = $cat_ele->name;
			}
			//print_r($cat_e_a);
			$cat_e = join( ", ", $cat_e_a );
			//Obtener categorias
		
		
			//Obtener diciplina
			$diciplina = get_field('disciplina', $ID);
	$lugar=get_field('lugar', $ID);
	$municipio=get_field('municipio', $lugar->ID);
		?>
        
			<!-- BODY -->        
			        <div class="app_android">
			        	
			        	<?php
						if(isset($ios)){
							echo '<span class="thumb"><a href="'.get_permalink($event_id).'?app=1&ios=1" title="'.$post->post_title.'"><img src="'.$imgDestacada[0].'"alt="'.$post->post_title.'"></a></span>';
						}else{
							echo '<span class="thumb"><a href="'.get_permalink($event_id).'?app=1" title="'.$post->post_title.'"><img src="'.$imgDestacada[0].'"alt="'.$post->post_title.'"></a></span>';
						}
						?>
			            
			            <div class="app_tax" 
			            <?php 
							if($diciplina == "Artes Visuales")
								echo 'style="background:#334A5F;"';
							if($diciplina == "Danza")
								echo 'style="background:#2A94D6;"';
							if($diciplina == "Música")
								echo 'style="background:#77698c;"';
							if($diciplina == "Literatura")
								echo 'style="background:#4EB1CB;"';	
							if($diciplina == "Cine")
								echo 'style="background:#CF5C60;"';
							if($diciplina == "Teatro")
								echo 'style="background:#4AB471;"';
							if($diciplina == "Gastronomía")
								echo 'style="background:#F3AE4E;"';
							if($diciplina == "Patrimonio Cultural")
								echo 'style="background:#D96383;"';
						?>
			            >
			            <span>
           				 	<?php
           				 	echo $diciplina;?> / <?php echo $cat_e;//echo $on_draught = join( ", ", $draught_links );
           				 	echo '<br>';
           				 	echo '<b>'.$municipio.'</b>';
           				 	?>            	
           				</span>
			            </div>
			            
			            <div class="app_data">
			            <?php
			             if(isset($ios)){
							echo '<span class="app_title"><a href="'.get_permalink($event_id).'?app=1&ios=1">'.$post->post_title.'</a></span>';
						}else{
							echo '<span class="app_title"><a href="'.get_permalink($event_id).'?app=1">'.$post->post_title.'</a></span>';
						}
									             
			            ?>
			            
						<?php // EMH Personas
			            if( get_field('persona_AC') ): ?>
			                <span class="app_persona">
			            <?php
			                $persona_AC=get_field('persona_AC', $ID);
			                foreach ($persona_AC as $persona){
			                    echo '<span>'.$persona['persona']->post_title.'</span>';
			                }
			                echo '<span>'.get_field('imparte', $ID).'</span>';
			                //	}
			                ?>         
			                </span>
			            <?php endif; ?>
			        
			        	<div class="event_data">
			            
						<?php 
			            // EMH Fechas y horas
			            ?>
			        <?php
			        $date_f = new DateTime($date);
					?>
			        <span itemprop="startDate" content="<?php echo $date; ?>"><?php //echo $date_f->format('F j');?></span>
			        <span itemprop="endDate" content="<?php echo $date_f->format('F j'); ?>"></span>
			            <?php //EMH Fecha de tipo periódo
			        if( have_rows('periodo') ):
			            while( have_rows('periodo') ) : the_row(); 
			                ?>
			                </br>
			                <span class="fecha"><?php the_sub_field('fecha_inicio'); ?></span> - <span class="fecha"><?php the_sub_field('fecha_cierre'); ?></span>
			                <?php
			            endwhile;
			        endif;
			        
			        ?>
			                
			            </span>         
			            <?php // EMH Lugar
			            $post_object = get_field('lugar');
			            if( $post_object ): 
			                // override $post
			                $post = $post_object;
			                setup_postdata( $post ); 
			                ?>
			                
			                <span class="app_lugar"><?php the_title(); ?></span>
			            <?php endif; ?>
			            
			            <?php if( get_field('lugar_evento') == 'Otro' ): ?>
			                <span class="app_lugar"><?php echo get_field('otro_lugar', $ID)?></span>
			            <?php endif; ?>
			            
					</div><!--app_fecha-->
				</div><!--app_data-->
			</div><!--app_android-->
					
			<?php			
			break;
			
}else{ //if $selFecha			
		
		if ($intervalo == $selFecha){
			//echo $intervalo;
			//echo "mañana";
			$bandera = 1;
			
	// Ruta de la imagen destacada
	$imgDestacada[0] = get_field('img_app', $ID);	
	if (empty($imgDestacada[0])) {
		if ( has_post_thumbnail() ) {
			$thumbID = get_post_thumbnail_id( $ID );
			$imgDestacada = wp_get_attachment_image_src( $thumbID, 'medium' ); 
		}else{
			$imgDestacada[0] = '/wp-content/gallery/sinImagen.jpg';
		}
	}

		//Obtener categorias
		$cat_e = get_field('categoria', $ID);
		$cat_e_a = array();
		foreach ( $cat_e as $cat_ele ) {
			$cat_e_a[] = $cat_ele->name;
		}
		//print_r($cat_e_a);
		$cat_e = join( ", ", $cat_e_a );
		//Obtener categorias
		
		
	//Obtener diciplina
	$diciplina = get_field('disciplina', $ID);
	$lugar=get_field('lugar', $ID);
	$municipio=get_field('municipio', $lugar->ID);
		?>
        
<!-- BODY -->        
        <div class="app_android">
        	
        	<?php 
        	if(isset($ios)){
				echo '<span class="thumb"><a href="'.get_permalink($event_id).'?app=1&ios=1" title="'.$post->post_title.'"><img src="'.$imgDestacada[0].'"alt="'.$post->post_title.'"></a></span>';
			}else{
				echo '<span class="thumb"><a href="'.get_permalink($event_id).'?app=1" title="'.$post->post_title.'"><img src="'.$imgDestacada[0].'"alt="'.$post->post_title.'"></a></span>';
			}
			?>
            
            <div class="app_tax" 
            <?php 
				if($diciplina == "Artes Visuales")
					echo 'style="background:#334A5F;"';
				if($diciplina == "Danza")
					echo 'style="background:#2A94D6;"';
				if($diciplina == "Música")
					echo 'style="background:#77698c;"';
				if($diciplina == "Literatura")
					echo 'style="background:#4EB1CB;"';	
				if($diciplina == "Cine")
					echo 'style="background:#CF5C60;"';
				if($diciplina == "Teatro")
					echo 'style="background:#4AB471;"';
				if($diciplina == "Gastronomía")
					echo 'style="background:#F3AE4E;"';
				if($diciplina == "Patrimonio Cultural")
					echo 'style="background:#D96383;"';
			?>
            >
            <span>
            	<?php
            	echo $diciplina;?> / <?php echo $cat_e;//echo $on_draught = join( ", ", $draught_links );
            	echo '<br>';
            	echo '<b>'.$municipio.'</b>';
            	?>            	
            </span>
            </div>
            
            <div class="app_data">
            <?php
            if(isset($ios)){
				echo '<span class="app_title"><a href="'.get_permalink($event_id).'?app=1&ios=1">'.$post->post_title.'</a></span>';
			}else{
				echo '<span class="app_title"><a href="'.get_permalink($event_id).'?app=1">'.$post->post_title.'</a></span>';
			}
			?>
            
			<?php // EMH Personas
            if( get_field('persona_AC') ): ?>
                <span class="app_persona">
            <?php
                $persona_AC=get_field('persona_AC', $ID);
                foreach ($persona_AC as $persona){
                    echo '<span>'.$persona['persona']->post_title.'</span>';
                }
                echo '<span>'.get_field('imparte', $ID).'</span>';
                //	}
                ?>         
                </span>
            <?php endif; ?>     
            
        	<div class="event_data">
            
			<?php 
            // EMH Fechas y horas
            ?>
        <?php
        $date_f = new DateTime($date);
		?>
        <span itemprop="startDate" content="<?php echo $date; ?>"><?php //echo $date_f->format('F j');?></span>
        <span itemprop="endDate" content="<?php echo $date_f->format('F j'); ?>"></span>
        <?php //ETH Los sub-eventos y eventos que no tienen sub-eventos no tiene periodo
			//EMH Fecha de tipo periódo
            if( have_rows('periodo') ):
                while( have_rows('periodo') ) : the_row(); 
                    ?>
           
                    <?php the_sub_field('fecha_inicio'); ?> - <?php the_sub_field('fecha_cierre'); ?>
                    <?php
                endwhile;
            endif;
            ?>
        
            <?php
/*Solo debe mostrar la hora del dia dehoy o del filtro que se aplico*/
                while( have_rows('fechas') ): the_row();
                
                if (get_sub_field('fecha',false) == $date){
                if($selFecha=='3'){
                 the_sub_field('fecha'); echo "&nbsp;";
                }
                    if( have_rows('horarios') ):
                
                        while( have_rows('horarios') ): the_row();
                        the_sub_field('horario');
                        echo " h";
                        endwhile;
                     endif;
				 }
                endwhile;
/*Solo debe mostrar la hora del dia dehoy o del filtro que se aplico*/
                ?>
                
            </span>
        
            <?php // EMH Lugar
            $post_object = get_field('lugar');
            if( $post_object ): 
                // override $post
                $post = $post_object;
                setup_postdata( $post ); 
                ?>
                <span class="app_lugar"><?php the_title(); ?></span>
            <?php endif; ?>
            
            <?php if( get_field('lugar_evento') == 'Otro' ): ?>
                <span class="app_lugar"><?php echo get_field('otro_lugar', $ID)?></span>
            <?php endif; ?>
            
		</div><!--app_fecha-->
	</div><!--app_data-->
</div><!--app_android-->
		
<?php			
			break;
			}
			
			
}//else $selFecha			
	}//foreach fecha de hoy

  }//if Sub - Evento
}//solo Temporal





if($selEvento == 'Permanente' ){	//solo Permanente	

	if ((get_field('tipo_de_evento', $event_id) == 'Sub - Evento') || (get_field('subeventos', $event_id) <> 1) || (get_field('evento_por_tiempo', $event_id) == 'Permanente') ){
	
	$array_de_fechas = Array(); 

    if( have_rows('periodo') ){
		
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
	}
	//periodo
	
	$datetime1 = new DateTime($hoy);
	
	foreach($array_de_fechas as $date){	
		$datetime2 = new DateTime($date);
		$interval = $datetime1->diff($datetime2);
		$intervalo = $interval->format('%R%a');
		
		//echo $intervalo." - ".$ID." -".$post->post_title."<br>";
		
		
		if($selFecha == 3){
		//echo "futuras";

			$bandera = 1;
			
	// Ruta de la imagen destacada
	$imgDestacada[0] = get_field('img_app', $ID);	
	if (empty($imgDestacada[0])) {
		if ( has_post_thumbnail() ) {
			$thumbID = get_post_thumbnail_id( $ID );
			$imgDestacada = wp_get_attachment_image_src( $thumbID, 'medium' ); 
		}else{
			$imgDestacada[0] = '/wp-content/gallery/sinImagen.jpg';
		}
	}

		//Obtener categorias
		$cat_e = get_field('categoria', $ID);
		$cat_e_a = array();
		foreach ( $cat_e as $cat_ele ) {
			$cat_e_a[] = $cat_ele->name;
		}
		//print_r($cat_e_a);
		$cat_e = join( ", ", $cat_e_a );
		//Obtener categorias
		
		
	//Obtener diciplina
	$diciplina = get_field('disciplina', $ID);
	$lugar=get_field('lugar', $ID);
	$municipio=get_field('municipio', $lugar->ID);
		?>
        
<!-- BODY -->        
        <div class="app_android">
        	
        	<?php
			if(isset($ios)){
				echo '<span class="thumb"><a href="'.get_permalink($event_id).'?app=1&ios=1" title="'.$post->post_title.'"><img src="'.$imgDestacada[0].'"alt="'.$post->post_title.'"></a></span>';
			}else{
				echo '<span class="thumb"><a href="'.get_permalink($event_id).'?app=1" title="'.$post->post_title.'"><img src="'.$imgDestacada[0].'"alt="'.$post->post_title.'"></a></span>';
			}
			?>
            
            <div class="app_tax" 
            <?php 
				if($diciplina == "Artes Visuales")
					echo 'style="background:#334A5F;"';
				if($diciplina == "Danza")
					echo 'style="background:#2A94D6;"';
				if($diciplina == "Música")
					echo 'style="background:#77698c;"';
				if($diciplina == "Literatura")
					echo 'style="background:#4EB1CB;"';	
				if($diciplina == "Cine")
					echo 'style="background:#CF5C60;"';
				if($diciplina == "Teatro")
					echo 'style="background:#4AB471;"';
				if($diciplina == "Gastronomía")
					echo 'style="background:#F3AE4E;"';
				if($diciplina == "Patrimonio Cultural")
					echo 'style="background:#D96383;"';
			?>
            >
            <span>
            	<?php
            	echo $diciplina;?> / <?php echo $cat_e;//echo $on_draught = join( ", ", $draught_links );
            	echo '<br>';
            	echo '<b>'.$municipio.'</b>';
            	?>            	
            </span>
            </div>
            
            <div class="app_data">
            <?php
             if(isset($ios)){
				echo '<span class="app_title"><a href="'.get_permalink($event_id).'?app=1&ios=1">'.$post->post_title.'</a></span>';
			}else{
				echo '<span class="app_title"><a href="'.get_permalink($event_id).'?app=1">'.$post->post_title.'</a></span>';
			}
			             
             ?>
            
			<?php // EMH Personas
            if( get_field('persona_AC') ): ?>
                <span class="app_persona">
            <?php
                $persona_AC=get_field('persona_AC', $ID);
                foreach ($persona_AC as $persona){
                    echo '<span>'.$persona['persona']->post_title.'</span>';
                }
                echo '<span>'.get_field('imparte', $ID).'</span>';
                //	}
                ?>         
                </span>
            <?php endif; ?>     
            
        	<div class="event_data">
            
			<?php 
            // EMH Fechas y horas
            ?>
        <?php
        $date_f = new DateTime($date);
		?>
        <span itemprop="startDate" content="<?php echo $date; ?>"><?php //echo $date_f->format('F j');?></span>
        <span itemprop="endDate" content="<?php echo $date_f->format('F j'); ?>"></span>
        
        <?php //EMH Fecha de tipo periódo
        if( have_rows('periodo') ):
            while( have_rows('periodo') ) : the_row(); 
                ?>
                </br>
                <span class="fecha"><?php the_sub_field('fecha_inicio'); ?></span> - <span class="fecha"><?php the_sub_field('fecha_cierre'); ?></span>
                <?php
            endwhile;
        endif;
        
        ?>
                
            </span>
        
        <?php // EMH Lugar
            $post_object = get_field('lugar');
            if( $post_object ): 
                // override $post
                $post = $post_object;
                setup_postdata( $post ); 
                ?>
                
                <span class="app_lugar"><?php the_title(); ?></span>
            <?php endif; ?>
            
            <?php if( get_field('lugar_evento') == 'Otro' ): ?>
                <span class="app_lugar"><?php echo get_field('otro_lugar', $ID)?></span>
            <?php endif; ?>
            
		</div><!--app_fecha-->
	</div><!--app_data-->
</div><!--app_android-->
		
<?php			
			break;
			
}else{ //if $selFecha			

		if ($intervalo == $selFecha){
			//echo $intervalo;
			//echo "mañana";
			$bandera = 1;
			
	// Ruta de la imagen destacada
	$imgDestacada[0] = get_field('img_app', $ID);	
	if (empty($imgDestacada[0])) {
		if ( has_post_thumbnail() ) {
			$thumbID = get_post_thumbnail_id( $ID );
			$imgDestacada = wp_get_attachment_image_src( $thumbID, 'medium' ); 
		}else{
			$imgDestacada[0] = '/wp-content/gallery/sinImagen.jpg';
		}
	}

		//Obtener categorias
		$cat_e = get_field('categoria', $ID);
		$cat_e_a = array();
		foreach ( $cat_e as $cat_ele ) {
			$cat_e_a[] = $cat_ele->name;
		}
		//print_r($cat_e_a);
		$cat_e = join( ", ", $cat_e_a );
		//Obtener categorias
			
	//Obtener diciplina
	$diciplina = get_field('disciplina', $ID);
	$lugar=get_field('lugar', $ID);
	$municipio=get_field('municipio', $lugar->ID);
		?>
        
<!-- BODY -->        
        <div class="app_android">
        	
        	<?php 
        	if(isset($ios)){
				echo '<span class="thumb"><a href="'.get_permalink($event_id).'?app=1&ios=1" title="'.$post->post_title.'"><img src="'.$imgDestacada[0].'"alt="'.$post->post_title.'"></a></span>';
			}else{
				echo '<span class="thumb"><a href="'.get_permalink($event_id).'?app=1" title="'.$post->post_title.'"><img src="'.$imgDestacada[0].'"alt="'.$post->post_title.'"></a></span>';
			}
			?>
            
            <div class="app_tax" 
            <?php 
				if($diciplina == "Artes Visuales")
					echo 'style="background:#334A5F;"';
				if($diciplina == "Danza")
					echo 'style="background:#2A94D6;"';
				if($diciplina == "Música")
					echo 'style="background:#77698c;"';
				if($diciplina == "Literatura")
					echo 'style="background:#4EB1CB;"';	
				if($diciplina == "Cine")
					echo 'style="background:#CF5C60;"';
				if($diciplina == "Teatro")
					echo 'style="background:#4AB471;"';
				if($diciplina == "Gastronomía")
					echo 'style="background:#F3AE4E;"';
				if($diciplina == "Patrimonio Cultural")
					echo 'style="background:#D96383;"';
			?>
            >
            <span>
            	<?php
            	echo $diciplina;?> / <?php echo $cat_e;//echo $on_draught = join( ", ", $draught_links );
            	echo '<br>';
            	echo '<b>'.$municipio.'</b>';
            	?>            	
            </span>
            </div>
            
            <div class="app_data">
            <?php
            if(isset($ios)){
				echo '<span class="app_title"><a href="'.get_permalink($event_id).'?app=1&ios=1">'.$post->post_title.'</a></span>';
			}else{
				echo '<span class="app_title"><a href="'.get_permalink($event_id).'?app=1">'.$post->post_title.'</a></span>';
			}
			?>
            
			<?php // EMH Personas
            if( get_field('persona_AC') ): ?>
                <span class="app_persona">
            <?php
                $persona_AC=get_field('persona_AC', $ID);
                foreach ($persona_AC as $persona){
                    echo '<span>'.$persona['persona']->post_title.'</span>';
                }
                echo '<span>'.get_field('imparte', $ID).'</span>';
                //	}
                ?>         
                </span>
            <?php endif; ?>     
            
        	<div class="event_data">
            
			<?php 
            // EMH Fechas y horas
            ?>
        <?php
        $date_f = new DateTime($date);
		?>
        <span itemprop="startDate" content="<?php echo $date; ?>"><?php //echo $date_f->format('F j');?></span>
        <span itemprop="endDate" content="<?php echo $date_f->format('F j'); ?>"></span>
        <?php //ETH Los sub-eventos y eventos que no tienen sub-eventos no tiene periodo
			//EMH Fecha de tipo periódo
            if( have_rows('periodo') ):
                while( have_rows('periodo') ) : the_row(); 
                    ?>
           
                    <?php the_sub_field('fecha_inicio'); ?> - <?php the_sub_field('fecha_cierre'); ?>
                    <?php
                endwhile;
            endif;
            ?>
        
            <?php
/*Solo debe mostrar la hora del dia dehoy o del filtro que se aplico*/
                while( have_rows('fechas') ): the_row();
                
                if (get_sub_field('fecha',false) == $date){
                if($selFecha=='3'){
                 the_sub_field('fecha'); echo "&nbsp;";
                }
                    if( have_rows('horarios') ):
                
                        while( have_rows('horarios') ): the_row();
                        the_sub_field('horario');
                        echo " h";
                        endwhile;
                     endif;
				 }
                endwhile;
/*Solo debe mostrar la hora del dia dehoy o del filtro que se aplico*/
                ?>
                
            </span>

            <?php // EMH Lugar
            $post_object = get_field('lugar');
            if( $post_object ): 
                // override $post
                $post = $post_object;
                setup_postdata( $post ); 
                ?>
                <span class="app_lugar"><?php the_title(); ?></span>
            <?php endif; ?>
            
            <?php if( get_field('lugar_evento') == 'Otro' ): ?>
                <span class="app_lugar"><?php echo get_field('otro_lugar', $ID)?></span>
            <?php endif; ?>
            
		</div><!--app_fecha-->
	</div><!--app_data-->
</div><!--app_android-->
		
<?php			
			break;
			}
			
			
}//else $selFecha			
			
	}//foreach fecha de hoy

  }//if Sub - Evento
}//solo Permanente

}//foreach post

if($bandera == 0){
    echo '<div class="msj_error">No existen resultados con los parámetros aplicados</div>';
}
?>
