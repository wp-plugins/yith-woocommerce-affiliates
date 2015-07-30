<?php
/**
 * Affiliate class
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

if ( ! class_exists( 'YITH_WCAF_Affiliate' ) ) {
	/**
	 * WooCommerce Affiliate
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Affiliate {

		/**
		 * Single instance of the class for each token
		 *
		 * @var mixed
		 * @since 1.0.0
		 */
		protected static $instances = array();

		/**
		 * Referral token variable name
		 *
		 * @var string
		 * @since 1.0.0
		 */
		protected $_ref_name = 'ref';

		/**
		 * Referral token variable name
		 *
		 * @var string
		 * @since 1.0.0
		 */
		protected $_ref_cookie_name = 'yith_wcaf_referral_token';

		/**
		 * Referral token variable name
		 *
		 * @var string
		 * @since 1.0.0
		 */
		protected $_ref_cookie_exp = WEEK_IN_SECONDS;

		/**
		 * Affiliate token
		 *
		 * @var string
		 * @since 1.0.0
		 */
		protected $_token;

		/**
		 * Token origin (query-string, cookie)
		 *
		 * @var string
		 * @since 1.0.0
		 */
		protected $_token_origin;

		/**
		 * Affiliate user
		 *
		 * @var array
		 * @since 1.0.0
		 */
		protected $_affiliate;

		/**
		 * Affiliate user
		 *
		 * @var \WP_User
		 * @since 1.0.0
		 */
		protected $_user;

		/**
		 * Affiliate rate
		 *
		 * @var float
		 * @since 1.0.0
		 */
		protected $_rate;

		/**
		 * Constructor method
		 *
		 * @return \YITH_WCAF_Affiliate
		 * @since 1.0.0
		 */
		public function __construct( $token = null ) {
			// retrieve options
			$this->_retrieve_options();

			// init affiliate object
			$this->_retrieve_token( $token );
			$this->_retrieve_user();
			$this->_retrieve_affiliate();

			// register checkout handling
			add_action( 'woocommerce_checkout_order_processed', array( $this, 'process_checkout_handling' ), 10, 1 );

			// register order completed/processing handling
			add_action( 'woocommerce_order_status_completed', array( $this, 'register_persistent_affiliate' ), 10, 1 );
			add_action( 'woocommerce_order_status_processing', array( $this, 'register_persistent_affiliate' ) );
		}

		/* === HELPER METHODS === */

		/**
		 * Return current ref variable name
		 *
		 * @return string Ref variable name
		 * @since 1.0.0
		 */
		public function get_ref_name() {
			if( ! empty( $this->_ref_name ) ){
				return $this->_ref_name;
			}

			return 'ref';
		}

		/**
		 * Return currently set token
		 *
		 * @return string|bool Current token; false if none set
		 * @since 1.0.0
		 */
		public function get_token() {
			if( ! empty( $this->_token ) ){
				return $this->_token;
			}

			return false;
		}

		/**
		 * Return token origin (cookie/query-string/constructor)
		 *
		 * @return string|bool Current token origin; false if none set
		 * @since 1.0.0
		 */
		public function get_token_origin() {
			if( ! empty( $this->_token_origin ) ){
				return $this->_token_origin;
			}

			return false;
		}

		/**
		 * Return current affiliate user
		 *
		 * @return WP_User|bool Current affiliate user; false if none set
		 * @since 1.0.0
		 */
		public function get_user() {
			if( ! empty( $this->_user ) ){
				return $this->_user;
			}

			return false;
		}

		/**
		 * Return current affiliate data
		 *
		 * @return mixed Current affiliate user; false if none set
		 * @since 1.0.0
		 */
		public function get_affiliate() {
			if( ! empty( $this->_affiliate ) ){
				return $this->_affiliate;
			}

			return false;
		}

		/* === INIT METHODS === */

		/**
		 * Init class attributes for admin options
		 *
		 * @return void
		 * @since 1.0.0
		 */
		protected function _retrieve_options(){
			$this->_ref_name = get_option( 'yith_wcaf_referral_var_name', $this->_ref_name );
			$this->_ref_cookie_name = get_option( 'yith_wcaf_referral_cookie_name', $this->_ref_cookie_name );
			$this->_ref_cookie_exp = get_option( 'yith_wcaf_referral_cookie_expire', $this->_ref_cookie_exp );
		}

		/**
		 * Init class attribute for token
		 *
		 * @param $token string Token to be used, instead of retrieved one
		 * @return void
		 * @since 1.0.0
		 */
		protected function _retrieve_token( $token ){
			if( is_null( $token ) ){
				if( isset( $_GET[ $this->_ref_name ] ) && $_GET[ $this->_ref_name ] != '' ){
					$token = $_GET[ $this->_ref_name ];

					// sets cookie for referrer id
					setcookie( $this->_ref_cookie_name, $_GET[ $this->_ref_name ], time() + intval( $this->_ref_cookie_exp ), COOKIEPATH, COOKIE_DOMAIN, false, true );

					// sets token origin as query-string
					$this->_token_origin = 'query-string';
				}
				elseif( isset( $_COOKIE[ $this->_ref_cookie_name ] ) ){
					$token = $_COOKIE[ $this->_ref_cookie_name ];

					// sets token origin as cookie
					$this->_token_origin = 'cookie';
				}
				else{
					$token = false;
					$this->_token_origin = false;
				}
			}
			else{
				$this->_token_origin = 'constructor';
			}

			if( ! YITH_WCAF_Affiliate_Handler()->is_valid_token( $token ) ){
				$token = false;
			}

			$this->_token = $token;
		}

		/**
		 * Init class attribute for token-related user
		 *
		 * @return void
		 * @since 1.0.0
		 */
		protected function _retrieve_user(){
			if( empty( $this->_token ) ){
				return;
			}

			$this->_user = YITH_WCAF_Affiliate_Handler()->get_user_by_token( $this->_token );
		}

		/**
		 * Init class attribute for token-related affiliate
		 *
		 * @return void
		 * @since 1.0.0
		 */
		protected function _retrieve_affiliate(){
			if( empty( $this->_token ) ){
				return;
			}

			$this->_affiliate = YITH_WCAF_Affiliate_Handler()->get_affiliate_by_token( $this->_token );
		}

		/* === AFFILIATE TOTAL METHODS === */

		/**
		 * Get affiliate total earnings
		 *
		 * @param $update bool Whether to update affiliate object before fetching earnings
		 * @return float Total earnings
		 * @since 1.0.0
		 */
		public function get_total( $update = false ){
			if( $update ){
				$this->_retrieve_affiliate();
			}

			if( ! $this->_affiliate ){
				return 0;
			}

			return (float) $this->_affiliate['earnings'];
		}

		/**
		 * Update affiliate total earning
		 *
		 * @param $amount float Value to sum to total affiliate earnings (a relative float value)
		 * @return void
		 * @since 1.0.0
		 */
		public function update_total( $amount ) {
			if( ! $this->_affiliate ){
				return;
			}

			$total_user_commissions = $this->_affiliate['earnings'];
			$total_user_commissions += (float) $amount;
			$total_user_commissions = $total_user_commissions > 0 ? $total_user_commissions : 0;

			YITH_WCAF_Affiliate_Handler()->update( $this->_affiliate['ID'], array( 'earnings' => $total_user_commissions ) );
			$this->_affiliate['earnings'] = $total_user_commissions;
		}

		/* === CHECKOUT HANDLING METHODS === */

		/**
		 * Process checkout handling, registering order meta data
		 *
		 * @param $order_id int Order id
		 * @return void
		 * @since 1.0.0
		 */
		public function process_checkout_handling( $order_id ) {
			$affiliate_token = $this->_affiliate['token'];

			if( empty( $this->_token ) ){
				return;
			}

			// create order commissions
			YITH_WCAF_Commission_Handler()->create_order_commissions( $order_id, $affiliate_token, $this->_token_origin );
			
			// register hit
			update_post_meta( $order_id, '_yith_wcaf_click_id', YITH_WCAF_Click_Handler()->get_last_hit() );

			// delete token cookie
			$this->delete_cookie_after_process();
		}

		/**
		 * Register persistent affiliate, if option enabled
		 *
		 * @param $order_id int Order id
		 * @return void
		 * @since 1.0.0
		 */
		public function register_persistent_affiliate( $order_id ) {
			if( $this->_persistent_calculation != 'yes' ){
				return;
			}

			$order = wc_get_order( $order_id );
			$customer = $order->customer_user;
			$referral = get_post_meta( $order_id, '_yith_wcaf_referral', true );

			if( ! $customer || ! $referral ){
				return;
			}

			update_user_meta( $customer, '_yith_wcaf_persistent_token', $referral );
		}

		/**
		 * Delete cookie after an order is processed with current token
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function delete_cookie_after_process() {
			setcookie( $this->_ref_cookie_name, '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN, false, true );
		}

		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WCAF_Affiliate
		 * @since 1.0.0
		 */
		public static function get_instance( $token = null ){

			/*
			 * When creating class from token, an instance is correctly set to token index
			 * Otherwise, if class loads automatically token from REQUEST, instance will be stored under 0 index
			 */

			$self = __CLASS__ . ( class_exists( __CLASS__ . '_Premium' ) ? '_Premium' : '' );

			if( ! isset( $self::$instances[ $token ] ) || is_null( $self::$instances[ $token ] ) ){
				$self::$instances[ $token ] = new $self;
			}

			return $self::$instances[ $token ];
		}
	}
}

/**
 * Unique access to instance of YITH_WCAF_Affiliate class
 *
 * @param $token string Unique affiliate token
 * @return \YITH_WCAF_Affiliate
 * @since 1.0.0
 */
function YITH_WCAF_Affiliate( $token = null ){
	return YITH_WCAF_Affiliate::get_instance( $token );
}