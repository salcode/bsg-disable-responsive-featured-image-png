<?php
/**
 * Plugin Name: Bootstrap Genesis Disable Responsive Images for Featured Image pngs
 * Plugin URI: https://github.com/salcode/bsg-disable-responsive-featured-image-png
 * Description: Why the heck would we disable responsive images for featured images that are pngs? You can read about it in my post <a href="https://salferrarello.com/wordpress-responsive-images-increased-page-size/">WordPress Responsive Images Increased Page Size</a>.
 * Version: 0.1.0
 * Author: Sal Ferrarello
 * Author URI: http://salferrarello.com/
 * Text Domain: bsg-disable-responsive-featured-image-png
 * Domain Path: /languages
 *
 * @package bsg-disable-responsive-featured-image-png
 */

add_filter( 'wp_calculate_image_srcset', 'bsg_disable_responsive_featured_image_png_wp_calculate_image_srcset', 10, 5 );

/**
 * Filters an image's 'srcset' array to be blank on pngs that are the featured image.
 *
 * @param array  $sources {
 *     One or more arrays of source data to include in the 'srcset'.
 *
 *     @type array $width {
 *         @type string $url        The URL of an image source.
 *         @type string $descriptor The descriptor type used in the image candidate string,
 *                                  either 'w' or 'x'.
 *         @type int    $value      The source width if paired with a 'w' descriptor, or a
 *                                  pixel density value if paired with an 'x' descriptor.
 *     }
 * }
 * @param array  $size_array    Array of width and height values in pixels (in that order).
 * @param string $image_src     The 'src' of the image.
 * @param array  $image_meta    The image meta data as returned by 'wp_get_attachment_metadata()'.
 * @param int    $attachment_id Image attachment ID or 0.
 * @return array $sources       See first param $sources for this function.
 */
function bsg_disable_responsive_featured_image_png_wp_calculate_image_srcset( $sources, $size_array, $image_src, $image_meta, $attachment_id ) {

	$theme = wp_get_theme();
	if ( 'Bootstrap Genesis' !== $theme->name ) {
		return $sources;
	}

	if (
		isset( $size_array[0] )
		&& isset( $size_array[1] )
		&& 1170 === $size_array[0]
		&&  630 === $size_array[1]
		&& '.png' === substr( $image_src, -4 )
	) {
		// Disable srcset responsive images on this image.
		return array();
	}

	return $sources;
}
