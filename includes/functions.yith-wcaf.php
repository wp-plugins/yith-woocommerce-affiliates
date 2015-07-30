<?php
/**
 * Utility functions
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Affiliates
 * @version 1.0.0
 */

/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if( ! function_exists( 'yith_wcaf_locate_template' ) ){
	/**
	 * Locate template for Affiliate plugin
	 *
	 * @param $filename string Template name (with or without extension)
	 * @param $section string Subdirectory where to search
	 * @return string Found template
	 */
	function yith_wcaf_locate_template( $filename, $section = '' ){
		$ext = strpos( $filename, '.php' ) === false ? '.php' : '';

		$template_name      = $section . '/' . $filename . $ext;
		$template_path      = WC()->template_path() . 'yith-wcaf/';
		$default_path       = YITH_WCAF_DIR . 'templates/';

		if( defined( 'YITH_WCAF_PREMIUM' ) ){
			$premium_template   = str_replace( '.php', '-premium.php', $template_name );
			$located_premium    = wc_locate_template( $premium_template, $template_path, $default_path );
			$template_name      = file_exists( $located_premium ) ?  $premium_template : $template_name;
		}

		return wc_locate_template( $template_name, $template_path, $default_path );
	}
}

if( ! function_exists( 'yith_wcaf_get_template' ) ){
	/**
	 * Get template for Affiliate plugin
	 *
	 * @param $filename string Template name (with or without extension)
	 * @param $args mixed Array of params to use in the template
	 * @param $section string Subdirectory where to search
	 */
	function yith_wcaf_get_template( $filename, $args = array(), $section = '' ){
		$ext = strpos( $filename, '.php' ) === false ? '.php' : '';

		$template_name      = $section . '/' . $filename . $ext;
		$template_path      = WC()->template_path() . 'yith-wcaf/';
		$default_path       = YITH_WCAF_DIR . 'templates/';

		if( defined( 'YITH_WCAF_PREMIUM' ) ){
			$premium_template   = str_replace( '.php', '-premium.php', $template_name );
			$located_premium    = wc_locate_template( $premium_template, $template_path, $default_path );
			$template_name      = file_exists( $located_premium ) ?  $premium_template : $template_name;
		}

		wc_get_template( $template_name, $args, $template_path, $default_path );
	}
}