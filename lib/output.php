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

add_action( 'wp_enqueue_scripts', 'koala_css' );
/**
 * Checks the settings for the images and background colors for each image.
 * If any of these value are set the appropriate CSS is output.
 *
 * @since 1.3.0
 */
function koala_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$opts = apply_filters( 'koala_images', array( '1', '3', '5' ) );
	$link_color = get_theme_mod( 'koala_link_color', koala_get_default_accent_color() );
	$menu_link_color = get_theme_mod( 'koala_menu_link_color', koala_get_default_accent_color() );
	$accent_color = get_theme_mod( 'koala_accent_color', koala_get_default_accent_color() );
	$site_header_color = get_theme_mod( 'koala_site_header_color', koala_get_default_accent_color() );
	$nav_primary_color = get_theme_mod( 'koala_nav_primary_color', koala_get_default_accent_color() );
	$footer_color = get_theme_mod( 'koala_footer_color', koala_get_default_accent_color() );


	$settings = array();

	foreach( $opts as $opt ){
		$settings[$opt]['image'] = preg_replace( '/^https?:/', '', get_option( $opt .'-image', sprintf( '%s/images/bg-%s.jpg', get_stylesheet_directory_uri(), $opt ) ) );
	}

	$css = '';

	foreach ( $settings as $section => $value ) {

		$background = $value['image'] ? sprintf( 'background-image: url(%s);', $value['image'] ) : '';

		$css .= ( ! empty( $section ) && ! empty( $background ) ) ? sprintf( '.home-section-%s { %s }', $section, $background ) : '';

	}

	$css .= ( koala_get_default_accent_color() !== $accent_color ) ? sprintf( '

		button:focus,
		button:hover,
		input[type="button"]:focus,
		input[type="button"]:hover,
		input[type="reset"]:focus,
		input[type="reset"]:hover,
		input[type="submit"]:focus,
		input[type="submit"]:hover,
		.archive-pagination li a:focus,
		.archive-pagination li a:hover,
		.archive-pagination .active a,
		.button:focus,
		.button:hover,
		.footer-widgets,
		.pricing-table a.button:focus,
		.pricing-table a.button:hover {
			background-color: %1$s;
			color: %2$s;
		}

		.footer-widgets a,
		.footer-widgets a:focus,
		.footer-widgets a:hover,
		.footer-widgets p {
			color: %2$s !important;
		}

		hr,
		.footer-widgets a.button,
		.footer-widgets button,
		.footer-widgets input[type="button"],
		.footer-widgets input[type="reset"],
		.footer-widgets input[type="submit"],
		.footer-widgets .widget-title {
			border-color: %2$s;
			color: %2$s !important;
		}

		.footer-widgets a.button:focus,
		.footer-widgets a.button:hover,
		.footer-widgets button:focus,
		.footer-widgets button:hover,
		.footer-widgets input[type="button"]:focus,
		.footer-widgets input[type="button"]:hover,
		.footer-widgets input[type="reset"]:focus,
		.footer-widgets input[type="reset"]:hover,
		.footer-widgets input[type="submit"]:focus,
		.footer-widgets input[type="submit"]:hover {
			background-color: #fff;
			border-color: #fff;
			color: #000 !important;
		}

		.pricing-table a.button:focus,
		.pricing-table a.button:hover {
			border-color: %1$s;
			color: %2$s !important;
		}

		', $accent_color, koala_color_contrast( $accent_color ) ) : '';

	$css .= ( koala_get_default_accent_color() !== $menu_link_color ) ? sprintf( '

		a,
		.entry-title a:focus,
		.entry-title a:hover,
		.home-odd .featured-content .entry-title a:focus,
		.home-odd .featured-content .entry-title a:hover {
			color: %1$s;
		}

		', $link_color ) : '';

	$css .= ( koala_get_default_accent_color() !== $link_color ) ? sprintf( '

		.genesis-nav-menu a:focus,
		.genesis-nav-menu a:hover,
		.genesis-nav-menu .current-menu-item > a,
		.genesis-nav-menu .sub-menu a:focus,
		.genesis-nav-menu .sub-menu a:hover,
		.genesis-nav-menu .sub-menu .current-menu-item > a:focus,
		.genesis-nav-menu .sub-menu .current-menu-item > a:hover,
		.genesis-responsive-menu button:focus,
		.genesis-responsive-menu button:hover,
		.menu-toggle:focus,
		.menu-toggle:hover,
		.site-header .widget-area a:focus,
		.site-header .widget-area a:hover,
		.site-footer a:hover,
		.site-footer a:focus {
			color: %1$s;
		}

		', $menu_link_color ) : '';

		$css .= ( koala_get_default_accent_color() !== $site_header_color ) ? sprintf( '

		.site-header,
		.site-header .sub-menu {
			background-color: %1$s;
		}

			', $site_header_color ) : '';

		$css .= ( koala_get_default_accent_color() !== $nav_primary_color ) ? sprintf( '

		.nav-primary,
		.nav-primary .wrap,
		.nav-primary .sub-menu {
			background-color: %1$s;
		}

				', $nav_primary_color ) : '';

		$css .= ( koala_get_default_accent_color() !== $footer_color ) ? sprintf( '

		.site-footer {
			background-color: %1$s;
		}

				', $footer_color ) : '';

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}

}
