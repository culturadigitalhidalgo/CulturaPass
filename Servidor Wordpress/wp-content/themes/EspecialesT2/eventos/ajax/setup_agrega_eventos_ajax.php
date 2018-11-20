<?php
/**
 *Eventos AJAX
*/
require ('../../../../../wp-load.php');
$selDisciplina =$_POST['Disciplina'];
$selCategorias =$_POST['Categorias'];
$selCosto =$_POST['Costo'];
$selRecinto =$_POST['Recinto'];
$selPublico =$_POST['Publico'];

$args=array(
    'post_type'      => 'eventos',
    'posts_per_page' => '-1',
    'post_status' => 'publish'
);

if($selCategorias!='0'){
  $args['tax_query'] = array(
      array(
           'taxonomy' => 'categorias_eventos',
           'terms' => $selCategorias
     )
  );
}

if($selCosto!='0' && $selPublico!='0' && $selDisciplina !='0' && $selRecinto !='0'){
  $args['meta_query'] = array(
      'relation'  => 'AND',
      array(
             array(
                 'key' => 'tipo_entrada', 
                 'value' => $selCosto, 
                 'compare' => '==',
      )),
      array(
             array(
                 'key' => 'publico', 
                 'value' => $selPublico, 
                 'compare' => '==',
      )),
      array(
             array(
                 'key' => 'disciplina', 
                 'value' => $selDisciplina, 
                 'compare' => '==',
      )),
      array(
             array(
                 'key' => 'lugar', 
                 'value' => $selRecinto, 
                 'compare' => '==',
      ))
    );
}else if($selCosto!='0' && $selPublico!='0' && $selDisciplina !='0'){
  $args['meta_query'] = array(
      'relation'  => 'AND',
      array(
             array(
                 'key' => 'tipo_entrada', 
                 'value' => $selCosto, 
                 'compare' => '==',
      )),
      array(
             array(
                 'key' => 'publico', 
                 'value' => $selPublico, 
                 'compare' => '==',
      )),
      array(
             array(
                 'key' => 'disciplina', 
                 'value' => $selDisciplina, 
                 'compare' => '==',
      )),
    );
}else if($selCosto!='0' && $selPublico!='0' && $selRecinto !='0'){
  $args['meta_query'] = array(
      'relation'  => 'AND',
      array(
             array(
                 'key' => 'tipo_entrada', 
                 'value' => $selCosto, 
                 'compare' => '==',
      )),
      array(
             array(
                 'key' => 'publico', 
                 'value' => $selPublico, 
                 'compare' => '==',
      )),
      array(
             array(
                 'key' => 'lugar', 
                 'value' => $selRecinto, 
                 'compare' => '==',
      )),
    );
}else if($selCosto!='0' && $selDisciplina!='0' && $selRecinto !='0'){
  $args['meta_query'] = array(
      'relation'  => 'AND',
      array(
             array(
                 'key' => 'tipo_entrada', 
                 'value' => $selCosto, 
                 'compare' => '==',
      )),
      array(
             array(
                 'key' => 'disciplina', 
                 'value' => $selDisciplina, 
                 'compare' => '==',
      )),
      array(
             array(
                 'key' => 'lugar', 
                 'value' => $selRecinto, 
                 'compare' => '==',
      )),
    );
}else if($selPublico!='0' && $selDisciplina!='0' && $selRecinto !='0'){
  $args['meta_query'] = array(
      'relation'  => 'AND',
      array(
             array(
                 'key' => 'publico', 
                 'value' => $selPublico, 
                 'compare' => '==',
      )),
      array(
             array(
                 'key' => 'disciplina', 
                 'value' => $selDisciplina, 
                 'compare' => '==',
      )),
      array(
             array(
                 'key' => 'lugar', 
                 'value' => $selRecinto, 
                 'compare' => '==',
      )),
    );
}else if($selCosto!='0' && $selPublico!='0'){
  $args['meta_query'] = array(
      'relation'  => 'AND',
      array(
             array(
                 'key' => 'tipo_entrada', 
                 'value' => $selCosto, 
                 'compare' => '==',
      )),
      array(
             array(
                 'key' => 'publico', 
                 'value' => $selPublico, 
                 'compare' => '==',
      )),
    );
}else if($selCosto!='0' && $selDisciplina!='0'){
  $args['meta_query'] = array(
      'relation'  => 'AND',
      array(
             array(
                 'key' => 'tipo_entrada', 
                 'value' => $selCosto, 
                 'compare' => '==',
      )),
      array(
             array(
                 'key' => 'disciplina', 
                 'value' => $selDisciplina, 
                 'compare' => '==',
      ))
    );
}else if($selCosto!='0' && $selRecinto!='0'){
  $args['meta_query'] = array(
      'relation'  => 'AND',
      array(
             array(
                 'key' => 'tipo_entrada', 
                 'value' => $selCosto, 
                 'compare' => '==',
      )),
      array(
             array(
                 'key' => 'lugar', 
                 'value' => $selRecinto, 
                 'compare' => '==',
      ))
    );
}else if($selPublico!='0' && $selDisciplina!='0'){
  $args['meta_query'] = array(
      'relation'  => 'AND',
      array(
             array(
                 'key' => 'publico', 
                 'value' => $selPublico, 
                 'compare' => '==',
      )),
      array(
             array(
                 'key' => 'disciplina', 
                 'value' => $selDisciplina, 
                 'compare' => '==',
      ))
    );
}else if($selPublico!='0' && $selRecinto!='0'){
  $args['meta_query'] = array(
      'relation'  => 'AND',
      array(
             array(
                 'key' => 'publico', 
                 'value' => $selPublico, 
                 'compare' => '==',
      )),
      array(
             array(
                 'key' => 'lugar', 
                 'value' => $selRecinto, 
                 'compare' => '==',
      ))
    );
}else if($selDisciplina!='0' && $selRecinto!='0'){
  $args['meta_query'] = array(
      'relation'  => 'AND',
      array(
             array(
                 'key' => 'disciplina', 
                 'value' => $selDisciplina, 
                 'compare' => '==',
      )),
      array(
             array(
                 'key' => 'lugar', 
                 'value' => $selRecinto, 
                 'compare' => '==',
      ))
    );
}else if($selCosto!='0'){
  $args['meta_query'] = array(
      array(
             array(
                 'key' => 'tipo_entrada', 
                 'value' => $selCosto, 
                 'compare' => '==',
      )),
  );
}else if($selPublico!='0'){
  $args['meta_query'] = array(
      array(
             array(
                 'key' => 'publico', 
                 'value' => $selPublico, 
                 'compare' => '==',
      )),
  );
}else if($selDisciplina!='0'){
  $args['meta_query'] = array(
      array(
             array(
                 'key' => 'disciplina', 
                 'value' => $selDisciplina, 
                 'compare' => '==',
      )),
  );
}else if($selRecinto!='0'){
  $args['meta_query'] = array(
      array(
             array(
                 'key' => 'lugar', 
                 'value' => $selRecinto, 
                 'compare' => '==',
      )),
    );
}

$events = get_posts($args);
?>    
 <section class="regular_sc slider">    
<?php 
if (!empty($events)) {
    foreach ($events as $post){
        $event_id=$post->ID;
        $imagen_destacada = get_the_post_thumbnail( $event_id, 'medium');
        if (empty($imagen_destacada)) {
            //$imagen_destacada = '<div class="tribe-events-event-image"><img width="632" height="632" src="/page/wp-content/uploads/2016/09/sinImagen.jpg" class="attachment-medium size-medium wp-post-image" alt="_mg_0653ach" srcset="http://192.168.100.100/page/wp-content/uploads/2016/12/MG_0653ach-632x632.jpg 632w, sizes="(max-width: 632px) 100vw, 632px"></div>';
            $imagen_destacada = '<img src="/wp-content/gallery/sinImagen.jpg">';
        }else{
            $imagen_destacada = get_the_post_thumbnail( $event_id, 'medium');
        }
    ?>
        <!--<div class="CCA1 fade">-->
            <div class="CCA1">
            
            <div class="view view-tenth">
                <?php echo $imagen_destacada; ?>

                <div class="mask">
                    <h2><?php echo $post->post_title; ?></h2>
                    <p><span>
                    <?php
                        $lugar=get_field('lugar', $event_id);
                        echo "<b>".$lugar->post_title."</b><br>";
                        
                        $fechas=get_field('fechas', $event_id);
                        foreach ($fechas as $fecha){
                            //print_r ($fecha);
                            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                            echo date("j ",  strtotime(str_replace('/','-',$fecha[fecha])));
                            //echo date("F",  strtotime(str_replace('/','-',$fecha[fecha])));
                            echo $meses[date("n",  strtotime(str_replace('/','-',$fecha[fecha])))-1];
                            echo date(", Y",  strtotime(str_replace('/','-',$fecha[fecha])));
                            echo "<br>";
                            
                            foreach ($fecha[horarios] as $horario){
                                echo $horario[horarios];
                                echo "&nbsp;";
                            }
                            echo "<br>";
                        }
    
                        //echo tribe_get_start_date($event_id, false, 'j F, Y')."&nbsp;&nbsp;".tribe_get_start_date($event_id, true, 'g:i a')." - ".tribe_get_end_date($event_id, true, 'g:i a');
                    ?>
                    </span></p>
                    <a href="<?php echo get_permalink($event_id); ?>" class="info">VER</a>
                </div>
            </div>
        </div>
    <?php
    }
}else{
    echo "No existen resultados con los parametros aplicados";
}
?>
 </section>
