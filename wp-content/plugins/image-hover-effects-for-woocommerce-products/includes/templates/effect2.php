<?php $woo_product = wc_get_product(); ?>
<div class="woo-hover-item square effect2">
	<a href="<?php the_permalink(); ?>" target="_blank">
		<div class="img">
			<?php if ( $woo_product->is_on_sale() ): ?>
				<span class="wdo-onsale">Sale!</span>
			<?php endif; ?>
		  <?php if (has_post_thumbnail( $products->$post->ID ) ): ?>
		    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
		  <img class="img-responsive" src="<?php echo $image[0]; ?>" alt="img">
		  <?php endif; ?>
		</div>
		<div class="info">
		    <h3><?php the_title(); ?></h3>
		    <p><?php echo wp_trim_words(  $products->post->post_excerpt, 10, '...' ); ?></p>
		    <span class="price"><?php echo $woo_product->get_price_html(); ?></span>
		    <i class="fas fa-cart-plus"></i>
		</div>
	</a>
</div>
