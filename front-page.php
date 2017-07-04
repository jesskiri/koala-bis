<?php
/**
 * Koala
 *
 * This file adds the front page to the Koala Theme.
 *
 * @package Koala
 * @author  Y des femmes Montréal
 * @license GPL-2.0+
 * @link    http://www.ydesfemmesmtl.org
 */

add_action( 'genesis_meta', 'koala_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 * @since 1.0.0
 */
function koala_home_genesis_meta() {

	if ( is_active_sidebar( 'home-section-1' ) || is_active_sidebar( 'home-section-2' ) || is_active_sidebar( 'home-section-3' ) || is_active_sidebar( 'home-section-4' ) || is_active_sidebar( 'home-section-5' ) || is_active_sidebar( 'home-section-6' ) || is_active_sidebar( 'home-section-7' ) || is_active_sidebar( 'home-section-8' ) ) {

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
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Add homepage widgets.
		add_action( 'genesis_loop', 'koala_homepage_widgets' );

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
function koala_homepage_widgets() {

	echo '<h2 class="screen-reader-text">' . __( 'Main Content', 'koala' ) . '</h2>';

	genesis_widget_area( 'home-section-1', array(
		'before' => '<div class="home-odd home-section-1 widget-area"><div class="full-height"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'home-section-2', array(
		'before' => '<div class="home-even home-section-2 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-section-3', array(
		'before' => '<div class="home-odd home-section-3 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-section-4', array(
		'before' => '<div class="home-even home-section-4 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-section-5', array(
		'before' => '<div class="home-odd home-section-5 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-section-6', array(
		'before' => '<div class="home-odd home-section-6 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-section-7', array(
		'before' => '<div class="home-odd home-section-7 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-section-8', array(
		'before' => '<div class="home-odd home-section-8 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

// Run the Genesis loop.
genesis();
