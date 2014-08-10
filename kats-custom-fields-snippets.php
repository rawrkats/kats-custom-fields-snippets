<?php
/*
Plugin Name: Kat's Custom Field Snippets
Description: Load custom field values with predefined snippets
Plugin URI: http://about.me/katsnell
Author: Kat Snell
Author URI: http://about.me/katsnell
Version: 1.0
License: GPL2
Text Domain: kfcs
Domain Path: Domain Path
*/
$version = time();
/*

    Copyright (C) Year  Kat Snell  Email

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


add_action( 'init', 'kcfs_register_post_type' );
/**
 * Register a Snippet post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function kcfs_register_post_type() {
	$labels = array(
		'name'               => _x( 'Snippets', 'post type general name', 'kfcs' ),
		'singular_name'      => _x( 'Snippet', 'post type singular name', 'kfcs' ),
		'menu_name'          => _x( 'Snippets', 'admin menu', 'kfcs' ),
		'name_admin_bar'     => _x( 'Snippet', 'add new on admin bar', 'kfcs' ),
		'add_new'            => _x( 'Add New', 'Snippet', 'kfcs' ),
		'add_new_item'       => __( 'Add New Snippet', 'kfcs' ),
		'new_item'           => __( 'New Snippet', 'kfcs' ),
		'edit_item'          => __( 'Edit Snippet', 'kfcs' ),
		'view_item'          => __( 'View Snippet', 'kfcs' ),
		'all_items'          => __( 'All Snippets', 'kfcs' ),
		'search_items'       => __( 'Search Snippets', 'kfcs' ),
		'parent_item_colon'  => __( 'Parent Snippets:', 'kfcs' ),
		'not_found'          => __( 'No Snippets found.', 'kfcs' ),
		'not_found_in_trash' => __( 'No Snippets found in Trash.', 'kfcs' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'snippet' ),
		'capability_type'    => 'page',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor' )
	);

	register_post_type( 'Snippet', $args );
}


function kcfs_assets() {
	global $hook, $version;
	wp_enqueue_script( 'kcfs', plugins_url() .'/kats-custom-fields-snippets/kcfs.js', 'jquery', $version, false );
	wp_enqueue_style( 'kcfs', plugins_url() .'/kats-custom-fields-snippets/kcfs.css');
}

add_action('admin_enqueue_scripts','kcfs_assets');

function kcfs_admin_showsnippetpanel() {
	add_thickbox();
	?>
	<div id="kcfs-list" style="display:none;">
     <div class="wrap">
     	<h2>Snippets<a class="add-new-h2" href="<?php echo admin_url('post-new.php?post_type=snippet') ?>">Add New</a></h2>

     <ul id="kcfs-ul-list">
     <?php
	// call some kind of modal that prints the following:
	$type = 'Snippet';
	$args=array(
	  'post_type' => $type,
	  'post_status' => 'publish',
	  'posts_per_page' => -1,
	  'caller_get_posts'=> 1
	  );
	$my_query = null;
	$kcfslist = array();
	$my_query = new WP_Query($args);
	if( $my_query->have_posts() ) {
		while ($my_query->have_posts()) {
			$my_query->the_post();
			?>
			<li data-text="<?php the_content() ?>"> <?php the_title(); ?> <button class="kcfs-load-snippet button button-small" >Load</button> <button class="kcfs-append-snippet button button-small" >Append</button></li>
			<?php
		}
	}
	wp_reset_query();  // Restore global post data stomped by the_post()
	?>
	</ul>
	</div>
	</div>
	<?php
}

add_action('in_admin_footer', 'kcfs_admin_showsnippetpanel');
