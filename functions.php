<?php
/**
 * Koala.
 *
 * This file adds the functions to the Koala Theme.
 *
 * @package Koala
 * @author  Jessica Boily
 * @license GPL-2.0+
 * @link
 */

// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Setup Theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

// Set Localization (do not remove).
add_action( 'after_setup_theme', 'koala_localization_setup' );
function koala_localization_setup(){
	load_child_theme_textdomain( 'koala', get_stylesheet_directory() . '/languages' );
}

// Add the theme helper functions.
include_once( get_stylesheet_directory() . '/lib/helper-functions.php' );

// Add Image upload to WordPress Theme Customizer.
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Include Section Image CSS.
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Koala' );
define( 'CHILD_THEME_URL', 'http://www.ydesfemmesmtl.org/' );
define( 'CHILD_THEME_VERSION', '0.1' );

// Enqueue scripts and styles.
add_action( 'wp_enqueue_scripts', 'parallax_enqueue_scripts_styles' );
function parallax_enqueue_scripts_styles() {

	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'koala-google-fonts', '//fonts.googleapis.com/css?family=Cormorant+Garamond:400,400i,700,700i|Quicksand:400,500', array(), CHILD_THEME_VERSION );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'koala-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menus' . $suffix . '.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'koala-responsive-menu',
		'genesis_responsive_menu',
		koala_responsive_menu_settings()
	);

}

// Define our responsive menu settings.
function koala_responsive_menu_settings() {

	$settings = array(
		'mainMenu'    => __( 'Menu', 'koala' ),
		'subMenu'     => __( 'Submenu', 'koala' ),
		'menuClasses' => array(
			'combine' => array(
				'.nav-header',
				'.nav-primary',
			),
		),
	);

	return $settings;

}

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

// Add accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Rename menus.
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Before Content Menu', 'koala' ), 'secondary' => __( 'Footer Menu', 'koala' ) ) );

// Remove output of primary navigation right extras.
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

// Remove navigation meta box.
add_action( 'genesis_theme_settings_metaboxes', 'koala_remove_genesis_metaboxes' );
function koala_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {
	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );
}

// Reposition the primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_nav' );

// Reposition the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 7 );

// Reduce the secondary navigation menu to one level depth.
add_filter( 'wp_nav_menu_args', 'koala_secondary_menu_args' );
function koala_secondary_menu_args( $args ){

	if( 'secondary' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;

	return $args;

}

// Unregister layout settings.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Unregister secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'flex-height'     => true,
	'width'           => 720,
	'height'          => 140,
	'header-selector' => '.site-title a',
	'header-text'     => false,
) );

// Add support for structural wraps.
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'footer-widgets',
	'footer',
) );

// Modify the size of the Gravatar in the author box.
// add_filter( 'genesis_author_box_gravatar_size', 'koala_author_box_gravatar' );
// function koala_author_box_gravatar( $size ) {
// 	return 88;
// }

// Modify the size of the Gravatar in the entry comments.
// add_filter( 'genesis_comment_list_args', 'koala_comments_gravatar' );
// function koala_comments_gravatar( $args ) {
//
// 	$args['avatar_size'] = 60;
//
// 	return $args;
//
// }

// Add body class if primary navigation is active.
add_filter( 'body_class', 'koala_body_classes' );
function koala_body_classes( $classes ) {

	if ( has_nav_menu( 'primary' ) ) {
		$classes[] = 'nav-primary-active';
	}

	return $classes;

}

// KOALA Featured image as background-image

function koala_featured_as_background() {
	global $post;

	$featured_img_url = get_the_post_thumbnail_url($post->ID, 'full');

	if ($featured_img_url)
	echo '<style> .entry {background-image:url('. $featured_img_url.');} </style>';
}


// Add support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 1 );

// Add support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Relocate after entry widget.
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_after_entry', 'genesis_after_entry_widget_area', 5 );

// Register homepage widget areas.
genesis_register_sidebar( array(
	'id'          => 'home-section-1',
	'name'        => __( 'Home Section 1', 'koala' ),
	'description' => __( 'This is the home section 1 section.', 'koala' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-section-2',
	'name'        => __( 'Home Section 2', 'koala' ),
	'description' => __( 'This is the home section 2 section.', 'koala' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-section-3',
	'name'        => __( 'Home Section 3', 'koala' ),
	'description' => __( 'This is the home section 3 section.', 'koala' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-section-4',
	'name'        => __( 'Home Section 4', 'koala' ),
	'description' => __( 'This is the home section 4 section.', 'koala' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-section-5',
	'name'        => __( 'Home Section 5', 'koala' ),
	'description' => __( 'This is the home section 5 section.', 'koala' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-section-6',
	'name'        => __( 'Home Section 6', 'koala' ),
	'description' => __( 'This is the home section 6 section.', 'koala' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-section-7',
	'name'        => __( 'Home Section 7', 'koala' ),
	'description' => __( 'This is the home section 7 section.', 'koala' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-section-8',
	'name'        => __( 'Home Section 8', 'koala' ),
	'description' => __( 'This is the home section 8 section.', 'koala' ),
) );

// Register Familles widget areas.
genesis_register_sidebar( array(
	'id'          => 'familles-intro',
	'name'        => __( 'Familles Intro', 'koala' ),
	'description' => __( 'This is the Familles intro section.', 'koala' ),
) );
genesis_register_sidebar( array(
	'id'          => 'familles-temoignage',
	'name'        => __( 'Familles témoignage', 'koala' ),
	'description' => __( 'This is the Familles témoignage section.', 'koala' ),
) );
genesis_register_sidebar( array(
	'id'          => 'familles-faits',
	'name'        => __( 'Familles Faits Saillants', 'koala' ),
	'description' => __( 'This is the Faits Saillants section.', 'koala' ),
) );
genesis_register_sidebar( array(
	'id'          => 'familles-qui',
	'name'        => __( 'Familles Qui sont-elles?', 'koala' ),
	'description' => __( 'This is the Qui sont-elles? section.', 'koala' ),
) );
genesis_register_sidebar( array(
	'id'          => 'familles-resultats',
	'name'        => __( 'Familles Résultats', 'koala' ),
	'description' => __( 'This is the Familles Résultats section.', 'koala' ),
) );
genesis_register_sidebar( array(
	'id'          => 'familles-frequentation',
	'name'        => __( 'Familles Fréquentation', 'koala' ),
	'description' => __( 'This is the Familles Fréquentation section.', 'koala' ),
) );
genesis_register_sidebar( array(
	'id'          => 'familles-enjeux',
	'name'        => __( 'Familles Enjeux sociaux', 'koala' ),
	'description' => __( 'This is the Familles Enjeux section.', 'koala' ),
) );
