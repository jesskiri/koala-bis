<?php
/**
 * Template Name: Familles
 *
 * This file adds the familles page to the Koala Theme.
 *
 * @package Koala
 * @author  Y des femmes Montréal
 * @license GPL-2.0+
 * @link    http://www.ydesfemmesmtl.org
 */

add_action( 'genesis_meta', 'koala_familles_genesis_meta' );
/**
 * Add widget support for familles. If no widgets active, display the default loop.
 *
 * @since 1.0.0
 */
function koala_familles_genesis_meta() {

	if ( is_active_sidebar( 'familles-section-1' )) {

		// Enqueue koala script.
		add_action( 'wp_enqueue_scripts', 'koala_enqueue_koala_script' );

		// Add koala-home body class.
		add_filter( 'body_class', 'koala_body_class' );

		// Force full width content layout.
		add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

		// Remove primary navigation.
		remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_nav' );

		// Remove breadcrumbs.
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs');

		// Remove the default Genesis loop.
		// remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Add homepage widgets.
		add_action( 'genesis_loop', 'koala_familles_widgets' );

		//Featured image as background
		add_action( 'wp_head', 'koala_featured_as_background', 99);

	}
}

// Remove skip link for primary navigation.
add_filter( 'genesis_skip_links_output', 'koala_skip_links_output' );
function koala_skip_links_output( $links ) {

	if ( isset( $links['genesis-nav-primary'] ) ) {
		unset( $links['genesis-nav-primary'] );
	}

	return $links;

}

// Add front page scripts.
function koala_enqueue_koala_script() {

	if ( ! wp_is_mobile() ) {
		wp_enqueue_script( 'koala-script', get_stylesheet_directory_uri() . '/js/koala.js', array( 'jquery' ), '1.0.0' );
	}

}

// Define koala-home body class.
function koala_body_class( $classes ) {

	$classes[] = 'koala-home';

	return $classes;

}

// Add markup for homepage widgets.
function koala_familles_widgets() {

	echo '<h2 class="screen-reader-text">' . __( 'Main Content', 'koala' ) . '</h2>';

	genesis_widget_area( 'familles-intro', array(
		'before' => '<div class="home-odd familles-intro widget-area"><div class="full-height"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'familles-temoignage', array(
		'before' => '<div class="home-even familles-temoignage widget-area"><div class="full-height"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'familles-faits', array(
		'before' => '<div class="home-odd familles-faits widget-area"><div class="full-height"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'familles-qui', array(
		'before' => '<div class="home-even familles-qui widget-area"><div class="full-height"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'familles-resultats', array(
		'before' => '<div class="home-odd familles-resultats widget-area"><div class="full-height"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'familles-frequentation', array(
		'before' => '<div class="home-even familles-frequentation widget-area"><div class="full-height"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'familles-enjeux', array(
		'before' => '<div class="home-odd familles-enjeux widget-area"><div class="full-height"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );
}

// Run the Genesis loop.
genesis();
