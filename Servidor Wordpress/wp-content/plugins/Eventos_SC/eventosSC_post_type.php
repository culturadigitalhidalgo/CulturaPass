<?php
/*
Plugin Name: Eventos SC
Plugin URI: http://cichidalgo.ddns.net/
Description: Eventos Secretaria de Cultura del estado de Hidalgo
Version: 1.0
Author: Eliel Trigueros Hernandez
Author URI: http://cichidalgo.ddns.net/
Text Domain: Eventos SC
License: Eliel Trigueros Hernandez

Nota: despues de subir el plugin, es necesario actualizar los enlaces permanentes, si no nunca va a tomar nuestro archive ni el single.
*/

/* Eventos SC */
if ( ! function_exists('eventos_post_type') ) {

// Register Custom Post Type
function eventos_post_type() {

	$labels = array(
		'name'                  => _x( 'Eventos', 'Post Type General Name', 'eventos' ),
		'singular_name'         => _x( 'Eventos', 'Post Type Singular Name', 'eventos' ),
		'menu_name'             => __( 'Eventos', 'eventos' ),
		'name_admin_bar'        => __( 'Post Type eventos', 'eventos' ),
		'archives'              => __( 'Item Archives', 'eventos' ),
		'parent_item_colon'     => __( 'Superior:', 'eventos' ),
		'all_items'             => __( 'Ver todos los eventos', 'eventos' ),
		'add_new_item'          => __( 'Agregar nuevo evento', 'eventos' ),
		'add_new'               => __( 'Agregar evento', 'eventos' ),
		'new_item'              => __( 'Agregar evento', 'eventos' ),
		'edit_item'             => __( 'Editar evento', 'eventos' ),
		'update_item'           => __( 'Actualizar evento', 'eventos' ),
		'view_item'             => __( 'Ver evento', 'eventos' ),
		'search_items'          => __( 'Buscar evento', 'eventos' ),
		'not_found'             => __( 'Sin elementos', 'eventos' ),
		'not_found_in_trash'    => __( 'Sin elementos in trash', 'eventos' ),
		'featured_image'        => __( 'Imagen predeterminada', 'eventos' ),
		'set_featured_image'    => __( 'Enviar imagen predeterminada', 'eventos' ),
		'remove_featured_image' => __( 'Borrar imagen predeterminada', 'eventos' ),
		'use_featured_image'    => __( 'Usar esta imagen predeterminada', 'eventos' ),
		'insert_into_item'      => __( 'Insertar dentro del item', 'eventos' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'eventos' ),
		'items_list'            => __( 'Lista de elementos', 'eventos' ),
		'items_list_navigation' => __( 'Navegar en la lista de elementos', 'eventos' ),
		'filter_items_list'     => __( 'Filtrar lista de elementos', 'eventos' ),
	);
	$capabilities = array(
		'edit_post'             => 'editar_post_eventos',
		'read_post'             => 'leer_post_eventos',
		'delete_post'           => 'borrar_post_eventos',
		'edit_posts'            => 'editar_varios_posts_eventos',//*
		'edit_others_posts'     => 'editar_otros_posts_eventos',//*
		'publish_posts'         => 'publicar_posts_eventos',//*
		'read_private_posts'    => 'leer_private_posts_eventos',//*
	);
	$args = array(
		'label'                 => __( 'Eventos', 'eventos' ),
		'description'           => __( 'Catálogo de eventos', 'eventos' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'author', 'editor', 'thumbnail', 'custom-fields', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_in_rest'       	=> true,
		'rest_base'          	=> 'eventos',
		'menu_position'         => 20,
		'menu_icon'             => 'dashicons-calendar-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		//'capabilities'          => $capabilities,
		'capability_type'       => 'eventos',
		'map_meta_cap'    => true,
	);
	register_post_type( 'eventos', $args );

}
add_action( 'init', 'eventos_post_type', 0 );

}


/* Categorias de eventos*/

if ( ! function_exists( 'eventos_taxonomy' ) ) {

// Register Custom Taxonomy
function eventos_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Categorias de eventos', 'Taxonomy General Name', 'eventos' ),
		'singular_name'              => _x( 'Categorias de eventos', 'Taxonomy Singular Name', 'eventos' ),
		'menu_name'                  => __( 'Categorias de eventos', 'eventos' ),
		'all_items'                  => __( 'Todas las categorias de eventos', 'eventos' ),
		'parent_item'                => __( 'Superior', 'eventos' ),
		'parent_item_colon'          => __( 'Superior:', 'eventos' ),
		'new_item_name'              => __( 'Nueva categoría', 'eventos' ),
		'add_new_item'               => __( 'Agregar nueva categoría', 'eventos' ),
		'edit_item'                  => __( 'Editar categoría', 'eventos' ),
		'update_item'                => __( 'Actualizar categoría', 'eventos' ),
		'view_item'                  => __( 'Ver categoría', 'eventos' ),
		'separate_items_with_commas' => __( 'Separar categorías por coma', 'eventos' ),
		'add_or_remove_items'        => __( 'Agregar o eliminar categorías', 'eventos' ),
		'choose_from_most_used'      => __( 'Escoger la mas usada', 'eventos' ),
		'popular_items'              => __( 'eventos populares', 'eventos' ),
		'search_items'               => __( 'Buscar eventos', 'eventos' ),
		'not_found'                  => __( 'No encontrados', 'eventos' ),
		'no_terms'                   => __( 'Sin eventos', 'eventos' ),
		'items_list'                 => __( 'Lista de eventos', 'eventos' ),
		'items_list_navigation'      => __( 'Items list navigation', 'eventos' ),
	);
	$rewrite = array(
		'slug'                       => 'categorias_eventos',
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
	register_taxonomy( 'categorias_eventos', 'eventos', $args );

}
	add_action( 'init', 'eventos_taxonomy', 0 );

}


function submenu_reportes() {
add_submenu_page(
		'edit.php?post_type=eventos',			// $parent_slug
		'Reportes',								// $page_title
		'Reportes',								// $menu_title
		'custom_menu_events',					// $capability
		'Reportes',								// $menu_slug
		'reportes'								// $function
		);
}

function reportes(){
		include 'reportes.php';	
}

add_action('admin_menu', 'submenu_reportes');	
?>
