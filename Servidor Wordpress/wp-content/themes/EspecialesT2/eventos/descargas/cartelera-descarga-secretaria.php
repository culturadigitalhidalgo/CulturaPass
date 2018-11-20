<?php
/*
*Eventos*
Name: Cartelera Digital
Author's: Eliel Trigueros Hernandez, Omar Oliver Rodriguez, Eloy Monter Hernández
Author URI: http://cultura.hidalgo.gob.mx
Version: 1.0
*/
?>
<html>
<head>
<meta charset="utf-8">
<style type="text/css">
.cartelera-digital{
	display:inline-block; width:350px; margin:8px; height:auto; vertical-align: text-top; cursor:pointer;
	font-family:'graphik-medium', sans-serif;
}
.thumb{max-width:350px;}
.thumb img{width:100%; height:auto;}
.title{font-weight: bold; font-size: 1.5em; padding:8px 0px;}
.cartelera-digital .lugar, .cartelera-digital .fecha, .cartelera-digital .persona{margin:8px 0px !important;}
</style>
</head>

<body>

<?php //imprimir lista de eventos
$today = date('Ymd');

$args = array (
    'post_type'		=> 'eventos',
	'numberposts'	=> 10,
	'order'          => 'DESC',
/*	'meta_key'		=> 'tipo_de_evento',
	'meta_value'	=> 'Sub - Evento'
	*/
/*    'meta_query' => array(
		array(
	        'key'		=> 'fechas',
	        'compare'	=> '>=',
	        'value'		=> $today,
	    )
    ),*/
);

$DateEvent = the_sub_field('fecha_inicio').the_sub_field('fecha') ;

// get posts
$posts = get_posts($args);
if( $posts ): ?>
	<?php foreach( $posts as $post ): 
		setup_postdata( $post );
		
		$ID=get_the_ID();
		
		// Ruta de la imagen destacada (miniatura y otros tamaños)
		$imagen_destacada = get_the_post_thumbnail( $ID, 'medium');
		
		if (empty($imagen_destacada)) {
			$imagen_destacada = '<img src="/wp-content/gallery/sinImagen.jpg">';
		}else{
			$imagen_destacada = get_the_post_thumbnail( $ID, 'medium');
		}
		
		
		// Ruta de la imagen destacada (miniatura y otros tamaños)
		if ( has_post_thumbnail() ) :
			$thumbID = get_post_thumbnail_id( $ID );
			$imgDestacada = wp_get_attachment_image_src( $thumbID, 'medium' ); 
		
		else:
		$imgDestacada[0] = '/wp-content/gallery/sinImagen.jpg';
		endif;
		
		?>
        <div class="cartelera-digital">
        	<span class="thumb"><?php echo '<img src="'.$imgDestacada[0].'"alt="'.$post->post_title.'">';?></span><br><br>
            <span><?php echo get_field('disciplina', $ID);?> / </span><br>
            <span class="title"><?php the_title(); ?></span><br>
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
        
		<?php 
        // EMH Fechas y horas
        if( have_rows('fechas') ): ?>
        <br><span class="fecha">
        <?php 
            while( have_rows('fechas') ): the_row(); ?>
            <?php the_sub_field('fecha'); ?>
            <?php 
                if( have_rows('horarios') ): ?>
                <?php 
                    while( have_rows('horarios') ): the_row();?>
                    <?php the_sub_field('horario'); ?> h
                    <?php endwhile; ?>
                    
                <?php endif;?>
            <?php endwhile;?>
        </span>
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
            
	<?php endforeach; ?>
	<?php wp_reset_postdata(); ?>
<?php endif; ?>

</body>
</html>
