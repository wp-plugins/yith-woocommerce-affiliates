<?php
/**
 * Rate Handler class
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

if ( ! class_exists( 'YITH_WCAF_Rate_Handler' ) ) {
	/**
	 * WooCommerce Rate Handler
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Rate_Handler {
		/**
		 * Single instance of the class for each token
		 *
		 * @var \YITH_WCAF_Rate_Handler
		 * @since 1.0.0
		 */
		protected static $instance = null;

		/* === HELPER METHODS === */

		/**
		 * Get rate for an affiliate or a product
		 *
		 * @param $affiliate int|mixed Affiliate ID or affiliate array
		 * @param $product int|\WC_Product|bool Product id or product object
		 * @return float Rate (product specific rate, if any; otherwise, affiliate specific rate, if any; otherwise, general rate)
		 * @since 1.0.0
		 */
		public function get_rate( $affiliate = false, $product = false ){
			// get user id
			if( is_numeric( $affiliate ) ){
				$affiliate_id = $affiliate;
			}
			elseif( isset( $affiliate['ID'] ) ){
				$affiliate_id = $affiliate['ID'];
			}
			else{
				$affiliate_id = false;
			}

			// get product id
			if( is_numeric( $product ) ){
				$product_id = $product;
			}
			elseif( is_object( $product ) && isset( $product->id ) && get_post_type( $product->id ) == 'product' ){
				$product_id = $product->id;
			}
			else{
				$product_id = false;
			}

			$general_rate = get_option( 'yith_wcaf_general_rate' );
			$affiliate = YITH_WCAF_Affiliate_Handler()->get_affiliate_by_id( $affiliate_id );
			$product_rates = get_option( 'yith_wcaf_product_rates', 0 );

			if( $product_id && isset( $product_rates[ $product_id ] ) ){
				return doubleval( $product_rates[ $product_id ] );
			}
			elseif( $affiliate_id && is_numeric( $affiliate[ 'rate' ] ) ){
				return doubleval(  $affiliate[ 'rate' ] );
			}
			else{
				return doubleval( $general_rate );
			}
		}

		/**
		 * Return corrected rate for persistent commission calculation
		 *
		 * @param $rate double Original rate
		 * @return double Corrected rate
		 * @since 1.0.0
		 */
		public function get_persistent_rate( $rate ) {
			$persistent_rate = get_option( 'yith_wcaf_persistent_rate' );

			return doubleval( $persistent_rate * (double) $rate / 100 );
		}

		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WCAF_Rate_Handler
		 * @since 1.0.0
		 */
		public static function get_instance(){
			$self = __CLASS__ . ( class_exists( __CLASS__ . '_Premium' ) ? '_Premium' : '' );

			if( is_null( $self::$instance ) ){
				$self::$instance = new $self;
			}

			return $self::$instance;
		}
	}
}

/**
 * Unique access to instance of YITH_WCAF_Rate_Handler class
 *
 * @return \YITH_WCAF_Rate_Handler
 * @since 1.0.0
 */
function YITH_WCAF_Rate_Handler(){
	return YITH_WCAF_Rate_Handler::get_instance();
}