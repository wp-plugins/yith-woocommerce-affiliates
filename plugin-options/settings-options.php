<?php
/**
 * General settings page
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Affiliates
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

return apply_filters(
	'yith_wcaf_general_settings',
	array(
		'settings' => array_merge(
			array(

				'general-options' => array(
					'title' => __( 'General', 'yith-wcaf' ),
					'type' => 'title',
					'desc' => '',
					'id' => 'yith_wcaf_general_options'
				),

				'general-referral-var' => array(
					'title' => __( 'Referral var name', 'yith-wcaf' ),
					'type' => 'text',
					'desc' => __( 'Select name of referral var used to store referral token in query var', 'yith-wcaf' ),
					'id' => 'yith_wcaf_referral_var_name',
					'css' => 'min-width: 300px;',
					'default' => 'ref',
					'desc_tip' => true
				),

				'general-options-end' => array(
					'type'  => 'sectionend',
					'id'    => 'yith_wcaf_cookie_options'
				),
			),

			array(

				'cookie-options' => array(
					'title' => __( 'Cookie', 'yith-wcaf' ),
					'type' => 'title',
					'desc' => '',
					'id' => 'yith_wcaf_general_options'
				),

				'cookie-referral-name' => array(
					'title' => __( 'Referral cookie name', 'yith-wcaf' ),
					'type' => 'text',
					'desc' => __( 'Select name for cookie that will store referral token. This name should be as unique as possible, so to avoid collision with other plugins: If you change this setting, all cookies created before will no longer be effective', 'yith-wcaf' ),
					'id' => 'yith_wcaf_referral_cookie_name',
					'css' => 'min-width: 300px;',
					'default' => 'yith_wcaf_referral_token',
					'desc_tip' => true
				),

				'cookie-referral-expiration' => array(
					'title' => __( 'Referral cookie exp.', 'yith-wcaf' ),
					'type' => 'number',
					'desc' => __( 'Number of seconds before referral cookie expires', 'yith-wcaf' ),
					'id' => 'yith_wcaf_referral_cookie_expire',
					'css' => 'min-width: 100px;',
					'default' => WEEK_IN_SECONDS,
					'custom_attributes' => array(
						'min' => 1,
						'max' => 9999999,
						'step' => 1
					),
					'desc_tip' => true
				),

				'cookie-options-end' => array(
					'type'  => 'sectionend',
					'id'    => 'yith_wcaf_cookie_options'
				),
			),

			array(

				'pages-options' => array(
					'title' => __( 'Affiliate pages', 'yith-wcaf' ),
					'type' => 'title',
					'desc' => '',
				),

				'page-dashboard-options' => array(
					'title' => __( 'Affiliate dashboard page', 'yith-wcaf' ),
					'desc'     => __( 'Page contents:', 'woocommerce' ) . ' [' . apply_filters( 'yith_wcaf_affiliate_dashboard_shortcode_tag', 'yith_wcaf_affiliate_dashboard' ) . ']',
					'type' => 'single_select_page',
					'id' => 'yith_wcaf_dashboard_page_id',
					'default'  => '',
					'class'    => 'wc-enhanced-select',
					'css'      => 'max-width:300px;',
					'desc_tip' => true,
				),

				'pages-options-end' => array(
					'type'  => 'sectionend',
					'id'    => 'yith_wcaf_cookie_options'
				),

			),

			array(

				'referral-registration-options' => array(
					'title' => __( 'Referral registration', 'yith-wcaf' ),
					'type'  => 'title',
					'id'    => 'yith_wcaf_referral_registration_options'
				),

				'referral-registration-form' => array(
					'title' => __( 'Registration form', 'yith-wcaf' ),
					'type' => 'select',
					'desc' => __( 'Select the form that should be used to register an affiliate. Plugin registration form can be printed with [yith_wcaf_registration_form] and it is automatically added to affiliate dashboard', 'yith-wcaf' ),
					'options' => array(
						'any' => __( 'Any registration form', 'yith-wcaf' ),
						'plugin' => __( 'Plugin registration form', 'yith-wcaf' )
					),
					'id' => 'yith_wcaf_referral_registration_form_options',
					'css' => 'min-width: 300px;',
					'desc_tip' => true
				),

				'referral-registration-show-name-field' => array(
					'title' => __( 'Show Name field', 'yith-wcaf' ),
					'type' => 'checkbox',
					'desc' => __( 'Show "First Name" field on registration form', 'yith-wcaf' ),
					'id' => 'yith_wcaf_referral_registration_show_name_field',
					'default' => 'yes'
				),

				'referral-registration-show-surname-field' => array(
					'title' => __( 'Show Surname field', 'yith-wcaf' ),
					'type' => 'checkbox',
					'desc' => __( 'Show "Last Name" field on registration form', 'yith-wcaf' ),
					'id' => 'yith_wcaf_referral_registration_show_surname_field',
					'default' => 'yes'
				),

				'referral-registration-options-end' => array(
					'type'  => 'sectionend',
					'id'    => 'yith_wcaf_referral_registration_options'
				),

			),

			array(

				'commission-options' => array(
					'title' => __( 'Commissions', 'yith-wcaf' ),
					'type' => 'title',
					'desc' => '',
					'id' => 'yith_wcaf_commission_options'
				),

				'commission-general-rate' => array(
					'title' => __( 'General rate', 'yith-wcaf' ),
					'type' => 'number',
					'desc' => sprintf( '%s "<a href="%s">%s</a>" %s', __( 'General rate to apply to affiliates;', 'yith-wcaf' ), esc_url( add_query_arg( array( 'page' => 'yith_wcaf_panel', 'tab' => 'rates' ), admin_url( 'admin.php' ) ) ), __( 'Rate Panel', 'yith-wcaf' ), __( ' can be used to specify rates per user/product', 'yith-wcaf' ) ),
					'id' => 'yith_wcaf_general_rate',
					'css' => 'max-width: 50px;',
					'default' => 0,
					'custom_attributes' => array(
						'min' => 0,
						'max' => 100,
						'step' => 'any'
					)
				),

				'commission-avoid-auto-referral' => array(
					'title' => __( 'Avoid auto commission', 'yith-wcaf' ),
					'type' => 'checkbox',
					'desc' => __( 'Prevent affiliate from getting commissions from his/her own sales', 'yith-wcaf' ),
					'id' => 'yith_wcaf_commission_avoid_auto_referral',
					'default' => 'yes'
				),

				'commission-exclude-tax' => array(
					'title' => __( 'Exclude tax from commissions', 'yith-wcaf' ),
					'type' => 'checkbox',
					'desc' => __( 'Exclude tax from referral commission calculation', 'yith-wcaf' ),
					'id' => 'yith_wcaf_commission_exclude_tax',
					'default' => 'yes'
				),

				'commission-exclude-discount' => array(
					'title' => __( 'Exclude discount from commissions', 'yith-wcaf' ),
					'type' => 'checkbox',
					'desc' => __( 'Exclude discounts from referral commission calculation', 'yith-wcaf' ),
					'id' => 'yith_wcaf_commission_exclude_discount',
					'default' => 'yes'
				),

				'commission-options-end' => array(
					'type'  => 'sectionend',
					'id'    => 'yith_wcaf_commission_options'
				),

			)
		)
	)
);