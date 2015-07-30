<?php
/**
 * General Stat Admin Panel
 *
 * @author  Your Inspiration Themes
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

<h3><?php echo $page_title ?></h3>

<div class="tablenav top">
	<div class="alignleft">
		<input type="text" name="_from" placeholder="<?php _e( 'From:', 'yith-wcaf' ) ?>" value="<?php echo esc_attr( $from ) ?>" class="date-picker" />
		<input type="text" name="_to" placeholder="<?php _e( 'To:', 'yith-wcaf' ) ?>" value="<?php echo esc_attr( $to ) ?>" class="date-picker" />
		<input type="submit" name="filter_action" id="post-query-submit" class="button" value="<?php _e( 'Filter', 'yith-wcaf' ) ?>" />
		<?php if( $need_reset ): ?>
			<a href="<?php echo $reset_link ?>" class="button"><?php _e( 'Reset', 'yith-wcaf' ) ?></a>
		<?php endif; ?>
	</div>
</div>
<table class="wc_status_table widefat">
	<thead>
	<tr>
		<th colspan="3">
			<?php _e( 'General stats', 'yith-wcaf' ) ?>
		</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td><?php _e( 'Total Commission', 'yith-wcaf' ) ?></td>
		<td class="help">
			<a href="#" class="help_tip" data-tip="<?php _e( 'Sum of all confirmed commissions so far', 'yith-wcaf' ) ?>">[?]</a>
		</td>
		<td><?php echo wc_price( $total_amount ) ?></td>
	</tr>
	<tr>
		<td><?php _e( 'Total Paid', 'yith-wcaf' ) ?></td>
		<td class="help">
			<a href="#" class="help_tip" data-tip="<?php _e( 'Sum of all paid commissions so far', 'yith-wcaf' ) ?>">[?]</a>
		</td>
		<td><?php echo wc_price( $total_paid ) ?></td>
	</tr>
	<tr>
		<td><?php _e( 'Number of hits', 'yith-wcaf' ) ?></td>
		<td class="help">
			<a href="#" class="help_tip" data-tip="<?php _e( 'Number of clicks', 'yith-wcaf' ) ?>">[?]</a>
		</td>
		<td><?php echo $total_clicks ?></td>
	</tr>
	<tr>
		<td><?php _e( 'Number of conversions', 'yith-wcaf' ) ?></td>
		<td class="help">
			<a href="#" class="help_tip" data-tip="<?php _e( 'Number of conversions', 'yith-wcaf' ) ?>">[?]</a>
		</td>
		<td><?php echo $total_conversions ?></td>
	</tr>
	<tr>
		<td><?php _e( 'Average conversion rate', 'yith-wcaf' ) ?></td>
		<td class="help">
			<a href="#" class="help_tip" data-tip="<?php _e( 'Average percentual conversion rate', 'yith-wcaf' ) ?>">[?]</a>
		</td>
		<td><?php echo $avg_conv_rate ?></td>
	</tr>
	</tbody>
</table>