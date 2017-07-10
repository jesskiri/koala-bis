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

add_action( 'customize_register', 'koala_customizer' );
/**
 * Add the theme settings and options to the Customizer.
 *
 * @since 1.0.0
 */
function koala_customizer() {

	global $wp_customize;

	$images = apply_filters( 'koala_images', array( '1', '3', '5' ) );

	$wp_customize->add_section(
		'koala-settings',
		array(
			'title'    => __( 'Background Images', 'koala' ),
			'priority' => 35,
		)
	);

	foreach( $images as $image ){

		$wp_customize->add_setting(
			$image .'-image',
			array(
				'default'  => sprintf( '%s/images/bg-%s.jpg', get_stylesheet_directory_uri(), $image ),
				'type'     => 'option',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				$image .'-image',
				array(
					'label'    => sprintf( __( 'Featured Section %s Image:', 'koala-pro' ), $image ),
					'section'  => 'koala-settings',
					'settings' => $image .'-image',
					'priority' => $image+1,
				)
			)
		);

	}

	// Link color.
	$wp_customize->add_setting(
		'koala_link_color',
		array(
			'default'           => koala_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'koala_link_color',
			array(
				'description' => __( 'Change the color for content links, the hover color for linked titles, and more.', 'koala' ),
				'label'       => __( 'Link Color', 'koala' ),
				'section'     => 'colors',
				'settings'    => 'koala_link_color',
			)
		)
	);

	// Menu Link color.
	$wp_customize->add_setting(
		'koala_menu_link_color',
		array(
			'default'           => koala_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'koala_menu_link_color',
			array(
				'description' => __( 'Change the hover color for menu links and links in the footer area.', 'koala' ),
				'label'       => __( 'Menu Link Color', 'koala' ),
				'section'     => 'colors',
				'settings'    => 'koala_menu_link_color',
			)
		)
	);

	// Accent color.
	$wp_customize->add_setting(
		'koala_accent_color',
		array(
			'default'           => koala_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'koala_accent_color',
			array(
				'description' => __( 'Change the hover color for buttons, the footer widget background color, and more.', 'koala' ),
				'label'       => __( 'Accent Color', 'koala' ),
				'section'     => 'colors',
				'settings'    => 'koala_accent_color',
			)
		)
	);

	//Site Header color.
	$wp_customize->add_setting(
		'koala_site_header_color',
		array(
			'default'           => koala_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'koala_site_header_color',
			array(
				'description' => __( 'Change the  color for site header', 'koala' ),
				'label'       => __( 'Site Header Color', 'koala' ),
				'section'     => 'colors',
				'settings'    => 'koala_site_header_color',
			)
		)
	);

	// Nav-primary color.
	$wp_customize->add_setting(
		'koala_nav_primary_color',
		array(
			'default'           => koala_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'koala_nav_primary_color',
			array(
				'description' => __( 'Change the  color for primary menu', 'koala' ),
				'label'       => __( 'Nav primary menu', 'koala' ),
				'section'     => 'colors',
				'settings'    => 'koala_nav_primary_color',
			)
		)
	);

	// Footer color.
	$wp_customize->add_setting(
		'koala_footer_color',
		array(
			'default'           => koala_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'koala_footer_color',
			array(
				'description' => __( 'Change the  color for footer', 'koala' ),
				'label'       => __( 'Footer Color', 'koala' ),
				'section'     => 'colors',
				'settings'    => 'koala_footer_color',
			)
		)
	);

}
