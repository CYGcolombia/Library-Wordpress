<?php
/*
 * Plugin Name:       Skillate Demo Importer 
 * Plugin URI:        https://www.themeum.com/
 * Description:       Skillate Demo Importer Plugin
 * Version: 		  1.0.8
 * Author:            Themeum.com
 * Author URI:        https://themeum.com/
 * Text Domain:       merlin-wp 
 * Requires at least: 5.0
 * Tested up to: 	  5.8
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

defined( 'ABSPATH' ) || exit;

define( 'SKILLATE_DEMO_IMPORTER_URL', plugin_dir_url(__FILE__) );
define( 'SKILLATE_DEMO_IMPORTER_PATH', plugin_dir_path(__FILE__) );



/* -------------------------------------------
*   Require file
* -------------------------------------------- */
function skillate_demo_import_require_file(){
	require_once SKILLATE_DEMO_IMPORTER_PATH. '/merlin/vendor/autoload.php';
	require_once SKILLATE_DEMO_IMPORTER_PATH. '/merlin/class-merlin.php';
	require_once SKILLATE_DEMO_IMPORTER_PATH. '/merlin-config.php';
}
add_action('init', 'skillate_demo_import_require_file');


/* -------------------------------------------
*   Skillate Demo Content
* -------------------------------------------- */
function skillate_local_import_files() {
	return array(
		array(
			'import_file_name'             => 'Demo Import',
			'local_import_file'            => SKILLATE_DEMO_IMPORTER_PATH. 'merlin/demo/content.xml',
			'local_import_widget_file'     => SKILLATE_DEMO_IMPORTER_PATH. 'merlin/demo/widgets.wie',
			'local_import_customizer_file' => SKILLATE_DEMO_IMPORTER_PATH. 'merlin/demo/customizer_data.dat',
			'import_preview_image_url'     => 'https://www.themeum.com/wp-content/uploads/2020/01/skillate-thumb-1.jpg',
			'import_notice'                => __( 'Import Skillate Demo Data', 'skillate' ),
			'preview_url'                  => 'https://www.themeum.com/product/skillate/',
		),
	);
}
add_filter( 'merlin_import_files', 'skillate_local_import_files' ); 


/* -------------------------------------------
*   Setup Menu after import complete
* -------------------------------------------- */
function prefix_merlin_after_import_setup() {

	$main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
	set_theme_mod( 'nav_menu_locations', array(
			'primary'  => $main_menu->term_id,
		)
	);

	// Assign front page and posts page (blog page).
	$front_page_id = get_page_by_title( 'Home' );
	$blog_page_id  = get_page_by_title( 'Blog' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );
	update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'merlin_after_all_import', 'prefix_merlin_after_import_setup' );


