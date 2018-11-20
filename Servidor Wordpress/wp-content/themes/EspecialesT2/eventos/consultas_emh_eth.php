<?php
/*
Name: Cartelera Independiente
Author: Eloy Monter Hernández
Author URI: http://eloymonter.com/
Version: 1.0
*/
?>

<?php 

/* Registros con valor  de un select / radio / check
$posts = get_posts(array(
	'posts_per_page'	=> -1,
	'post_status'		=> 'draft',
	'post_type'			=> 'patrimonio_pci',
	'meta_key'		=> 'pci_riesgo',
	'meta_value'	=> '4'
));*/

/* Registros por fecha 
$posts = get_posts(array(
	'posts_per_page'	=> -1,
	'post_status'		=> 'draft',
	'post_type'			=> 'patrimonio_pci',
	'year'				=> '2018',
	'monthnum'			=> '3',
	'day'				=> '5'
));*/

// Registros con campo vacío
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
));*/

$posts = get_posts(array(
	'posts_per_page'	=> -1,
	'post_status'		=> 'draft',
	'post_type'			=> 'patrimonio_pci',
	'meta_key' 			=> 'pci_img',
	'meta-value'		=> '',
	'meta-compare'		=> '!='
));


// Imprimir lista ordenada de títulos con permalink
if( $posts ): ?>
	
	<ol>
	<?php foreach( $posts as $post ): 
		setup_postdata( $post );
		?>
		<li>
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</li>
	<?php endforeach; ?>
	</ol>
	<?php wp_reset_postdata(); ?>
<?php endif; ?>