<?php
/**
* Eventos AJAX
* Author's: Eliel Trigueros Hernandez, Omar Oliver Rodriguez, Eloy Monter Hernández
* Author URI: http://cultura.hidalgo.gob.mx
* @since Versión 2.0, revisión 2. Mayo/2017
* @since Versión 3.0, revisión 3. Enero/2018
* @since Versión 4.0, revisión 4. Abril/2018
*/
require ('../../../../../wp-load.php');

$selFecha =$_POST['selFecha'];
$selFecha_input =$_POST['selFecha_input'];
$selDisciplina =$_POST['Disciplina'];
//$selCategorias =$_POST['Categorias'];
//$selCosto =$_POST['Costo'];
//$selRecinto =$_POST['Recinto'];
$selOrganiza =$_POST['Organiza'];
$selMunicipios =$_POST['Municipios'];
$selPublico =$_POST['Publico'];

$meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");

if(empty($selFecha_input)){
	$selFecha_input = $meses[date('n')-1]. ", ".date('Y') ;
}

if ($selFecha == "M"){
//mes	
$porciones = str_replace(",", "", $selFecha_input); 
$porciones = explode(" ", $porciones);
$val=1;
foreach ($meses as $mes){
	if($porciones[0] == $mes){
		if(strlen($val) == 1){
		$porciones[0]="0".$val;
		}else{
		$porciones[0]=$val;
		}
	}
	$val++;
}

$array_fechas_actual = array ();
for ($i = 1; $i <= 31; $i++) {
  if (strlen($i)==1) {
    $array_fechas_actual[] = $porciones[1]."-".$porciones[0]."-0".$i;
  }else{
    $array_fechas_actual[] = $porciones[1]."-".$porciones[0]."-".$i;
  }
}

}else if ($selFecha == "D"){
//dia

$porciones = str_replace(",", "", $selFecha_input); 
$porciones = explode(" ", $porciones);
$val=1;
foreach ($meses as $mes){
	if($porciones[1] == $mes){
		if(strlen($val) == 1){
		$porciones[1]="0".$val;
		}else{
		$porciones[1]=$val;
		}
	}
	$val++;
}
if (strlen($porciones[0])==1) {
  $porciones[0]="0".$porciones[0];
}
$array_fechas_actual = array ($porciones[2]."-".$porciones[1]."-".$porciones[0]);

}

/*if($selRecinto != 0){
$argsR = array(
		'post_type'      => 'infraestructura',
		'order'          => 'ASC',
		'posts_per_page' => -1,
		'post_status' => 'publish',
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
}*/

if($selMunicipios != '0'){
$argsR = array(
    'post_type'      => 'infraestructura',
    'order'          => 'ASC',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'meta_query' => array(
              array(
                  'key' => 'municipio', 
                  'value' => $selMunicipios, 
                  'compare' => '=='
              ))
    );

  $municipios = new WP_Query($argsR);
  $selMunicipiosT = Array($selMunicipios);
  foreach ( $municipios->posts as $res ) {
    $selMunicipiosT[] = $res->ID;
  }
}

get_posts(
$args=array(
    'post_type'      => 'eventos',
    'posts_per_page' => '-1',
    'post_status' => 'publish',
    'meta_query'    => array()
	)
);
/*if($selCosto!='0'){
  array_push($args['meta_query'], array(
      array(
             array(
                 'key' => 'tipo_entrada', 
                 'value' => $selCosto, 
                 'compare' => '==',
      )),
  ));
}*/
if($selPublico != '0'){
  array_push($args['meta_query'], array(
      array(
             array(
                 'key' => 'publico', 
                 'value' => $selPublico, 
                 'compare' => '==',
      )),
  ));
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
if($selOrganiza!='4'){
  array_push($args['meta_query'], array(
      array(
             array(
                 'key' => 'tipo_organismo', 
                 'value' => $selOrganiza, 
                 'compare' => '==',
      )),
  ));
}
if($selMunicipios!='0'){
  array_push($args['meta_query'], array(
      array(
             array(
                 'key' => 'lugar', 
                 'value' => $selMunicipiosT, 
                 'compare' => 'IN',
      )),
    ));
}
/*if($selRecinto!='0'){
  array_push($args['meta_query'], array(
      array(
             array(
                 'key' => 'lugar', 
                 'value' => $selRecintosT, 
                 'compare' => 'IN',
      )),
    ));
}*/
/*if($selCategorias!='0'){
  array_push($args['meta_query'], array(
      array(
             array(
                 'key' => 'categoria', 
                 'value' => $selCategorias, 
                 'compare' => 'LIKE',
      )),
    ));
}*/

$metaQuery = count($args['meta_query']);
if ($metaQuery>=2) {
  array_push($args['meta_query'], array(
      'relation'  => 'AND',
      ));
}

$posts1 = get_posts($args);
$array_de_resultados = Array(); 

foreach( $posts1 as $post ){
	$ID = get_the_ID();
	$array_de_fechas = Array(); 
	
	if( have_rows('fechas') ){
			while( have_rows('fechas') ){
				the_row();
				$array_de_fechas[] = get_sub_field('fecha',false);
			}
		}
	
	$result = array_intersect($array_fechas_actual, $array_de_fechas);

	if (!empty($result)) {
		$array_de_resultados[] = [$ID, reset($result)];
		$bandera=1;
	}//hubo resultado
} //end foreach

if($bandera == 0){
    echo '<div class="msj_error">No existen resultados con los parámetros aplicados</div>';
}else{
	
foreach ($array_de_resultados as $clave => $fila){
	$fech[$clave] = $fila['1'];
}
array_multisort($fech, SORT_ASC, $array_de_resultados);

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

foreach( $posts as $post ){
	$ID = get_the_ID();
	
//	echo "TIPO: ".get_field('tipo_de_evento', $ID);
//	echo "PERIODO: ".get_field('subeventos', $ID);

/*
	// Ruta de la imagen destacada
	$imgDestacada[0] = get_field('img_app', $ID);	
	if (empty($imgDestacada)) {
		if ( has_post_thumbnail() ) {
			$thumbID = get_post_thumbnail_id( $ID );
			$imgDestacada = wp_get_attachment_image_src( $thumbID, 'medium' ); 
		}else{
			$imgDestacada[0] = '/wp-content/gallery/sinImagen.jpg';
		}
	}
	
	*/	
		// Ruta de la imagen destacada (miniatura y otros tamaños)
		
		// Ruta de la imagen destacada
	$imgDestacada[0] = get_field('img_app', $ID);	
	if (empty($imgDestacada[0])) {
		if ( has_post_thumbnail() ){
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
    $tipo_entrada=get_field('tipo_entrada', $ID);
    $organiza=get_field('tipo_organismo', $ID);
		?>
    <div class="cartelera-digital" style="position:relative">
			<span class="thumb">
        <a href="<?php echo get_permalink($ID); ?>" title="<?php the_title();?>" target="_blank">
          <?php
            echo '<img src="'.$imgDestacada[0].'"alt="'.$post->post_title.'">';
            if ($organiza=='Independiente'){
              echo '<div style="position:absolute; top:0;">';
              echo '<img border="0" src="../wp-content/themes/EspecialesT2/eventos/cintillo.png" width="300" height="300"/>';
              echo '</div>';
            }
          ?>
          </a>
      </span>
      <br>
      <br>
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
      <span>
        <?php
        echo $diciplina.' / '.$cat_e;
        echo '<br>';
        echo '<b>'.$municipio.' | '.$tipo_entrada.'</b>';
        ?>              
      </span>
      <br>

      </div>
            <span class="title"><a href="<?php echo get_permalink($ID); ?>" title="<?php the_title();?>"><?php the_title();?></a></span><br>
            <!--<span class="lugares"><?php //get_field('lugar'); ?></span>-->
            
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
        
		<?php 
        // EMH Fechas y horas
    $fechaActual = date("Y-m-d");
    $fchActual = strtotime($fechaActual);
        if( have_rows('fechas') ):
          //echo "Tiene fechas";
        echo "<br><span id='span".$ID."'' class='fecha'>";
        $ban=0;
        echo "<b>Próximas fechas: </b></br>";
            while( have_rows('fechas') ): the_row(); 
            $fechaEvnto = get_sub_field('fecha', false, false);
            $fch = strtotime($fechaEvnto);

            if ($fch>=$fchActual) {
              $ban++;
              the_sub_field('fecha'); echo "&nbsp;";
                if( have_rows('horarios') ): 
                    while( have_rows('horarios') ): the_row();
                  the_sub_field('horario'); ?> h
                    <?php endwhile; 
                    endif;
            }
            endwhile; 
            ?>
        </span>
            <?php
              if ($ban==0) {
                  echo "<script>jQuery('#span".$ID."').html('<b>Evento concluído</b><br>');</script>";
                  while( have_rows('fechas') ): the_row(); 
                    $fechaEvnto = get_sub_field('fecha', false, false);
                    $fch = strtotime($fechaEvnto);
                      //if ($fch>=$fchActual) {
                        the_sub_field('fecha'); echo "&nbsp;";
                        if( have_rows('horarios') ): 
                          while( have_rows('horarios') ): the_row();
                            the_sub_field('horario'); ?> h
                            <?php endwhile; 
                        endif;
                    //}
                  endwhile;
              }
            ?>
		<?php endif;?>     
        
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
} //end foreach
}//else de bandera
?>
