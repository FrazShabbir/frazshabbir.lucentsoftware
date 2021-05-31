<?php
/**
 * Cross-sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cross-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $cross_sells ) : ?>
	<div class="cross-sells">
		<h2><?php esc_html_e( 'You may be interested in&hellip;', 'rehub-theme' ) ?></h2>
		<div class="products rh-flex-eq-height column_woo col_wrap_two">
			<?php foreach ( $cross_sells as $cross_sell ) : ?>
				<?php
				 	$post_object = get_post( $cross_sell->get_id() );
					setup_postdata( $GLOBALS['post'] = $post_object );
					wc_get_template_part( 'content', 'product' ); ?>
			<?php endforeach; ?>
		</div>
	</div>
<?php endif;
wp_reset_postdata();