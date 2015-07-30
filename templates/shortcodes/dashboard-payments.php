<?php
/**
 * Affiliate Dashboard
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

<div class="yith-wcaf yith-wcaf-payments woocommerce">

	<?php wc_print_notices() ?>

	<div class="filters">
		<form>
			<div class="filters-row">
				<input type="text" class="datepicker" name="from" placeholder="<?php _e( 'From:', 'yith-wcaf' ) ?>" value="<?php echo esc_attr( $from )?>"/>
				<input type="text" class="datepicker" name="to" placeholder="<?php _e( 'To:', 'yith-wcaf' ) ?>" value="<?php echo esc_attr( $to )?>"/>
			</div>
			<div class="button-row">
				<input type="submit" value="<?php _e( 'Filter', 'yith-wcaf' ) ?>"/>
				<?php if( $filter_set ): ?>
					<a href="<?php echo $dashboard_clicks_link ?>"><?php _e( 'Reset', 'yith-wcaf' ) ?></a>
				<?php endif; ?>
			</div>
		</form>
	</div>

	<table class="shop_table">
		<thead>
		<tr>
			<th class="column-id">
				<a class="<?php echo ( $ordered == 'id' ) ? 'ordered to-order-' . strtolower( $to_order )  : '' ?>" href="<?php echo esc_url( add_query_arg( array( 'orderby' => 'ID', 'order' => $to_order ) ) ) ?>"><?php _e( 'ID', 'yith-wcaf' ) ?></a>
			</th>
			<th class="column-status">
				<a class="<?php echo ( $ordered == 'status' ) ? 'ordered to-order-' . strtolower( $to_order )  : '' ?>" href="<?php echo esc_url( add_query_arg( array( 'orderby' => 'status', 'order' => $to_order ) ) ) ?>"><?php _e( 'Status', 'yith-wcaf' ) ?></a>
			</th>
			<th class="column-amount">
				<a class="<?php echo ( $ordered == 'amount' ) ? 'ordered to-order-' . strtolower( $to_order )  : '' ?>" href="<?php echo esc_url( add_query_arg( array( 'orderby' => 'amount', 'order' => $to_order ) ) ) ?>"><?php _e( 'Amount', 'yith-wcaf' ) ?></a>
			</th>
			<th class="column-created_at">
				<a class="<?php echo ( $ordered == 'created_at' ) ? 'ordered to-order-' . strtolower( $to_order )  : '' ?>" href="<?php echo esc_url( add_query_arg( array( 'orderby' => 'created_at', 'order' => $to_order ) ) ) ?>"><?php _e( 'Created at', 'yith-wcaf' ) ?></a>
			</th>
			<th class="column-completed_at">
				<a class="<?php echo ( $ordered == 'completed_at' ) ? 'ordered to-order-' . strtolower( $to_order )  : '' ?>" href="<?php echo esc_url( add_query_arg( array( 'orderby' => 'completed_at', 'order' => $to_order ) ) ) ?>"><?php _e( 'Completed at', 'yith-wcaf' ) ?></a>
			</th>
		</tr>
		</thead>
		<tbody>
		<?php if( ! empty( $payments ) ): ?>
			<?php foreach( $payments as $payment ): ?>
				<tr>
					<td class="column-id">#<?php echo esc_attr( $payment['ID'] ) ?></td>
					<td class="column-status"><a href="<?php echo esc_url( add_query_arg( 'status', $payment['status'] ) ) ?>"><?php echo esc_attr( YITH_WCAF_Payment_Handler()->get_readable_status( $payment['status'] ) ) ?></a></td>
					<td class="column-amount"><?php echo wc_price( $payment['amount'] )?></td>
					<td class="column-create_at"><?php echo esc_attr( date_i18n( wc_date_format(), strtotime( $payment['created_at'] ) ) ) ?></td>
					<td class="column-completed_at"><?php echo esc_attr( date_i18n( wc_date_format(), strtotime( $payment['completed_at'] ) ) ) ?></td>
				</tr>
			<?php endforeach; ?>
		<?php else: ?>
			<tr>
				<td class="empty-set" colspan="6"><?php _e( 'Sorry! There are no registered payments yet', 'yith-wcaf' ) ?></td>
			</tr>
		<?php endif; ?>
		</tbody>
	</table>

	<?php if( ! empty( $page_links ) ): ?>
		<nav class="woocommerce-pagination">
			<?php echo $page_links ?>
		</nav>
	<?php endif; ?>
</div>