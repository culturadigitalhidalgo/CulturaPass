<?php
/*
Plugin Name: Infraestructura SC
Plugin URI: http://cichidalgo.ddns.net/
Description: Infraestructura Secretaria de Cultura del estado de Hidalgo
Version: 1.0
Author: Eliel Trigueros Hernandez
Author URI: http://cichidalgo.ddns.net/
Text Domain: Infraestructura SC
License: Eliel Trigueros Hernandez

Nota: despues de subir el plugin, es necesario actualizar los enlaces permanentes, si no nunca va a tomar nuestro archive ni el single.
*/

/* Infraestructura SC */
if ( ! function_exists('infraestructura_post_type') ) {

// Register Custom Post Type
function infraestructura_post_type() {

	$labels = array(
		'name'                  => _x( 'Infraestructura', 'Post Type General Name', 'infraestructura' ),
		'singular_name'         => _x( 'Infraestructura', 'Post Type Singular Name', 'infraestructura' ),
		'menu_name'             => __( 'Infraestructura', 'infraestructura' ),
		'name_admin_bar'        => __( 'Post Type infraestructura', 'infraestructura' ),
		'archives'              => __( 'Item Archives', 'infraestructura' ),
		'parent_item_colon'     => __( 'Superior:', 'infraestructura' ),
		'all_items'             => __( 'Ver todos la infraestructura', 'infraestructura' ),
		'add_new_item'          => __( 'Agregar nueva infraestructura', 'infraestructura' ),
		'add_new'               => __( 'Agregar infraestructura', 'infraestructura' ),
		'new_item'              => __( 'Agregar infraestructura', 'infraestructura' ),
		'edit_item'             => __( 'Editar infraestructura', 'infraestructura' ),
		'update_item'           => __( 'Actualizar infraestructura', 'infraestructura' ),
		'view_item'             => __( 'Ver infraestructura', 'infraestructura' ),
		'search_items'          => __( 'Buscar infraestructura', 'infraestructura' ),
		'not_found'             => __( 'Sin elementos', 'infraestructura' ),
		'not_found_in_trash'    => __( 'Sin elementos in trash', 'infraestructura' ),
		'featured_image'        => __( 'Imagen predeterminada', 'infraestructura' ),
		'set_featured_image'    => __( 'Enviar imagen predeterminada', 'infraestructura' ),
		'remove_featured_image' => __( 'Borrar imagen predeterminada', 'infraestructura' ),
		'use_featured_image'    => __( 'Usar esta imagen predeterminada', 'infraestructura' ),
		'insert_into_item'      => __( 'Insertar dentro del item', 'infraestructura' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'infraestructura' ),
		'items_list'            => __( 'Lista de elementos', 'infraestructura' ),
		'items_list_navigation' => __( 'Navegar en la lista de elementos', 'infraestructura' ),
		'filter_items_list'     => __( 'Filtrar lista de elementos', 'infraestructura' ),
	);
	$capabilities = array(
		'edit_post'             => 'editar_post_infraestructura',
		'read_post'             => 'leer_post_infraestructura',
		'delete_post'           => 'borrar_post_infraestructura',
		'edit_posts'            => 'editar_varios_posts_infraestructura',//*
		'edit_others_posts'     => 'editar_otros_posts_infraestructura',//*
		'publish_posts'         => 'publicar_posts_infraestructura',//*
		'read_private_posts'    => 'leer_private_posts_infraestructura',//*
	);
	$args = array(
		'label'                 => __( 'Infraestructura', 'infraestructura' ),
		'description'           => __( 'Catálogo de infraestructura', 'infraestructura' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'author', 'editor', 'thumbnail', 'custom-fields', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 20,
		'menu_icon'             => 'dashicons-admin-multisite',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		//'capabilities'          => $capabilities,
		'capability_type'       => 'infraestructura',
		'map_meta_cap'    => true,
	);
	register_post_type( 'infraestructura', $args );

}
add_action( 'init', 'infraestructura_post_type', 0 );

}


/* Categorias de infraestructura*/

if ( ! function_exists( 'infraestructura_taxonomy' ) ) {

// Register Custom Taxonomy
function infraestructura_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Categorias de infraestructura', 'Taxonomy General Name', 'infraestructura' ),
		'singular_name'              => _x( 'Categorias de infraestructura', 'Taxonomy Singular Name', 'infraestructura' ),
		'menu_name'                  => __( 'Categorias de infraestructura', 'infraestructura' ),
		'all_items'                  => __( 'Todas las categorias de infraestructura', 'infraestructura' ),
		'parent_item'                => __( 'Superior', 'infraestructura' ),
		'parent_item_colon'          => __( 'Superior:', 'infraestructura' ),
		'new_item_name'              => __( 'Nueva categoría', 'infraestructura' ),
		'add_new_item'               => __( 'Agregar nueva categoría', 'infraestructura' ),
		'edit_item'                  => __( 'Editar categoría', 'infraestructura' ),
		'update_item'                => __( 'Actualizar categoría', 'infraestructura' ),
		'view_item'                  => __( 'Ver categoría', 'infraestructura' ),
		'separate_items_with_commas' => __( 'Separar categorías por coma', 'infraestructura' ),
		'add_or_remove_items'        => __( 'Agregar o eliminar categorías', 'infraestructura' ),
		'choose_from_most_used'      => __( 'Escoger la mas usada', 'infraestructura' ),
		'popular_items'              => __( 'eventos populares', 'infraestructura' ),
		'search_items'               => __( 'Buscar eventos', 'infraestructura' ),
		'not_found'                  => __( 'No encontrados', 'infraestructura' ),
		'no_terms'                   => __( 'Sin eventos', 'infraestructura' ),
		'items_list'                 => __( 'Lista de eventos', 'infraestructura' ),
		'items_list_navigation'      => __( 'Items list navigation', 'infraestructura' ),
	);
	$rewrite = array(
		'slug'                       => 'categorias_infraestructura',
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'categorias_infraestructura', 'infraestructura', $args );

}
add_action( 'init', 'infraestructura_taxonomy', 0 );

}

?>
