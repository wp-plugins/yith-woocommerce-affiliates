<?php
/**
 * Rate Admin Panel
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
?>

<div id="yith_wcaf_panel_rate">
	<form id="plugin-fw-wc" class="general-rate-table" method="post">

		<h3><?php _e( 'User rates', 'yith-wcaf' ) ?></h3>
		<div class="yith-users-new-commission">
			<h4><?php _e( 'Add new user commission', 'yith-wcaf' ) ?></h4>
			<input type="hidden" name="yith_new_affiliate_rate[affiliate]" class="yith-users-select wc-product-search" data-action="json_search_affiliates" value="" data-placeholder="<?php _e( 'Search for an affiliate&hellip;', 'yith-wcaf' ); ?>" style="max-width: 300px;" />
			<input type="number" name="yith_new_affiliate_rate[rate]" class="yith-users-commission" min="0" max="100" step="any" value="" style="max-width: 50px;" />
			<input type="submit" class="yith-users-commission-submit button button-primary" value="<?php echo esc_attr( __( 'Add Commission', 'yith-wcaf' ) ) ?>" />
		</div>

		<?php $user_rates_table->display() ?>

		<div class="clear separator"></div>

		<h3><?php _e( 'Product rates', 'yith-wcaf' ) ?></h3>
		<div class="yith-products-new-commission">
			<h4><?php _e( 'Add new product commission', 'yith-wcaf' ) ?></h4>
			<input type="hidden" name="yith_new_product_rate[product]" class="yith-products-select wc-product-search" value="" data-placeholder="<?php _e( 'Search for a product&hellip;', 'yith-wcaf' ); ?>" style="max-width: 300px;" />
			<input type="number" name="yith_new_product_rate[rate]" class="yith-products-commission" min="0" max="100" step="any" value="" style="max-width: 50px;" />
			<input type="submit" class="yith-products-commission-submit button button-primary" value="<?php echo esc_attr( __( 'Add Commission', 'yith-wcaf' ) ) ?>" />
		</div>

		<?php $product_rates_table->display() ?>

	</form>
</div>