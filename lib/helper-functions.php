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

/**
 * Get the default accent color.
 *
 * @since 1.3.0
 *
 * @return string Hex value of the default color.
 */
function koala_get_default_accent_color() {
	return '#00a0af';
}

/**
 * Generate a hex value that has appropriate contrast
 * against the inputted value.
 *
 * @since 1.3.0
 *
 * @return string Hex color code for contrasting color.
 */
function koala_color_contrast( $color ) {

	$hexcolor = str_replace( '#', '', $color );
	$red      = hexdec( substr( $hexcolor, 0, 2 ) );
	$green    = hexdec( substr( $hexcolor, 2, 2 ) );
	$blue     = hexdec( substr( $hexcolor, 4, 2 ) );

	$luminosity = ( ( $red * 0.2126 ) + ( $green * 0.7152 ) + ( $blue * 0.0722 ) );

	return ( $luminosity > 128 ) ? '#000000' : '#ffffff';

}
