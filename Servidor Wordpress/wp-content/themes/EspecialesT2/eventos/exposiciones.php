<?php
/*
*Eventos*
Name: Exposiciones temporales
Author's: Eliel Trigueros Hernandez, Omar Oliver Rodriguez, Eloy Monter Hernández
Author URI: http://cultura.hidalgo.gob.mx
* @since Versión 1.0, revisión 1. Julio/2017
* @since Versión 2.0, revisión 2. Abril/2018
*/
?>

<style type="text/css">
.cartelera-digital{
	display:inline-block; width:350px; margin:8px; height:auto; vertical-align: text-top;
	font-family:'graphik-medium', sans-serif;
}
.thumb{max-width:350px;}
.thumb img{width:100%; height:auto;}
.title{font-weight: bold; font-size: 1.5em; padding:8px 0px;}
.cartelera-digital .lugar, .cartelera-digital .fecha, .cartelera-digital .persona{margin:8px 0px !important;}
</style>

<?php
$hoy = date("Y-m-d", strtotime("now"));
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
				'key' => 'evento_por_tiempo', 
                'value' => 'Temporal', 
                'compare' => '==',
      )),
  ));

$events = new WP_Query($args);
?>

<div style="width:100%; margin:0 auto;" id="resultado_sc" align="center">

<?php
foreach ($events->posts as $post){	

$array_de_fechas = Array();

	//fechas
	//if( have_rows('fechas') ){
	//		while( have_rows('fechas') ){
	//			the_row();
	//			$array_de_fechas[] = get_sub_field('fecha',false);
	//		}
	//	}
	//fechas
	
//periodo - comprobar que estan vigentes
 
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
			
	$ID = get_the_ID();
	
//	echo "TIPO: ".get_field('tipo_de_evento', $ID);
//	echo "PERIODO: ".get_field('subeventos', $ID);
	   // Ruta de la imagen destacada (miniatura y otros tamaños)
		if ( has_post_thumbnail() ){
			$thumbID = get_post_thumbnail_id( $ID );
			$imgDestacada = wp_get_attachment_image_src( $thumbID, 'medium' ); 
		
		}else{
			$imgDestacada[0] = get_field('img_app', $ID);
			if(empty($imgDestacada[0]))
				$imgDestacada[0] = '/wp-content/gallery/sinImagen.jpg';			
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
		?>
        <div class="cartelera-digital">
			<span class="thumb"><a href="<?php echo get_permalink($ID); ?>" title="<?php the_title();?>"><?php echo '<img src="'.$imgDestacada[0].'"alt="'.$post->post_title.'">';?></a></span><br><br>
      <div class="app_tax" 
            <?php 
        if(get_field('disciplina', $ID) == "Artes Visuales")
          echo 'style="background:#334A5F;"';
        if(get_field('disciplina', $ID) == "Danza")
          echo 'style="background:#2A94D6;"';
        if(get_field('disciplina', $ID) == "Música")
          echo 'style="background:#77698c;"';
        if(get_field('disciplina', $ID) == "Literatura")
          echo 'style="background:#4EB1CB;"'; 
        if(get_field('disciplina', $ID) == "Cine")
          echo 'style="background:#CF5C60;"';
        if(get_field('disciplina', $ID) == "Teatro")
          echo 'style="background:#4AB471;"';
        if(get_field('disciplina', $ID) == "Gastronomía")
          echo 'style="background:#F3AE4E;"';
        if(get_field('disciplina', $ID) == "Patrimonio Cultural")
          echo 'style="background:#D96383;"';
      ?>
            >
            <span><?php echo get_field('disciplina', $ID);?> / <?php echo $cat_e;?></span><br>
      </div>
            <span class="title"><a href="<?php echo get_permalink($ID); ?>" title="<?php the_title();?>"><?php the_title();?></a></span><br>
            <span class="lugar"><?php get_field('lugar'); ?></span>
            
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
        
<!--
		<?php 
        // EMH Fechas y horas
    //$fechaActual = date("Y-m-d");
    //$fchActual = strtotime($fechaActual);
      //  if( have_rows('fechas') ): ?>
        <br><span class="fecha">
        <?php 
        //    while( have_rows('fechas') ): the_row(); 
          //  $fechaEvnto = get_sub_field('fecha', false, false);
//            $fch = strtotime($fechaEvnto);

  //          if ($fch>=$fchActual) {
    //          the_sub_field('fecha'); echo "&nbsp;";
      //          if( have_rows('horarios') ): 
        //            while( have_rows('horarios') ): the_row();
          //        the_sub_field('horario'); ?> h
                    <?php //endwhile; 
                    //endif;
            //}
            //endwhile; ?>
        </span>
		<?php //endif;?>     
-->
        
        <?php // EMH Personas
		if( get_field('persona_AC') ): ?>
			<br><span class="persona">
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
        
		<?php // EMH Lugar
        $post_object = get_field('lugar');
        if( $post_object ): 
            // override $post
            $post = $post_object;
            setup_postdata( $post ); 
            ?>
            <br><span class="lugar"><?php the_title(); ?></span><br>
        <?php endif; ?>
        
        <?php if( get_field('lugar_evento') == 'Otro' ): ?>
                <br><span><?php echo get_field('otro_lugar', $ID)?></span><br>
			<?php endif; ?>
            
        </div>
<?php
				break;
			}//if es fecha esta en operiodo o no
		}//foreach de fechas        
} //end foreach
?>
</div> <!-- DIV resultado_sc-->
