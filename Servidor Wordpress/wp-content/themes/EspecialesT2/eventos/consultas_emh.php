<?php
/*
Name: Cartelera Independiente
Author: Eloy Monter Hernández
Author URI: http://eloymonter.com/
Version: 1.0
*/
?>

<?php 

/* Registros dentro de un Array
$posts = get_post ( array(
	'posts_per_page' => -1,
	'post_type'      => 'Agentes',
	'meta_key'       => 'becas_y_estimulos',
	'meta_query'     => array(
		array(
		'key'     => 'nombre_de_la_beca_o_estimulo',
		'value'   => '5',
		)
	)
));*/


//Registros con valor  de un select / radio / check
$posts = get_posts(array(
	'posts_per_page'	=> -1,
	'post_status'		=> 'publish',
	'post_type'			=> 'Agentes',
	'meta_key'		=> 'disciplina',
	'meta_value'	=> '1'
));

/*Registros por fecha 
$posts = get_posts(array(
	'posts_per_page'	=> -1,
	'post_status'		=> 'draft',
	'post_type'			=> 'patrimonio_pci',
	'year'				=> '2018',
	'monthnum'			=> '3',
	'day'				=> '20'
));*/

/* Registros con campo vacío
/*$posts = get_posts(array(
	'posts_per_page'	=> -1,
	'post_status'		=> 'draft',
	'post_type'			=> 'patrimonio_pci',
	'meta_query' => array(
		array(
			'key' => 'pci_description',
			'compare' => '=',
		)
	)
));

$posts = get_posts(array(
	'posts_per_page'	=> -1,
	'post_status'		=> 'publish',
	'post_type'			=> 'Agentes',
	'meta_key' 			=> 'pci_img',
	'meta-value'		=> '',
	'meta-compare'		=> '!='
));*/


// Imprimir lista ordenada de títulos con permalink
if( $posts ): ?>
	
	<ol>
	<?php foreach( $posts as $post ): 
		setup_postdata( $post );
		?>
		<li>
        <b><?php the_title();?></b><br>
        <?php the_field('ac_nac_municipio');?>&#32;/&#32; <?php the_field('disciplina'); ?><br>
        <?php the_content(); ?>

        
			<!--<a href="<?php //the_permalink(); ?>"><?php //the_title(); ?></a>-->
		</li>
	<?php endforeach; ?>
	</ol>
	<?php wp_reset_postdata(); ?>
<?php endif; ?>