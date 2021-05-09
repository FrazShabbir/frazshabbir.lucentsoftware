<div class="wdo-woo-hover-container">
  <div class="se-pre-con"></div>
  <div class="row">
  <?php  
    foreach ($saved_effects as $wdo_product) {
      if ($atts['id'] == $wdo_product['shortcode']) { 
        wp_enqueue_style( 'wdo-fontawesome-css', plugins_url( '../css/all.css',__FILE__ ));
        wp_enqueue_style( 'wdo-woo-hover-css', plugins_url( '../css/ihover.min.css',__FILE__ ));
        wp_enqueue_style( 'wdo-woo-bootstrap-css', plugins_url( '../css/bootstrap-grid.css',__FILE__ ));
        wp_enqueue_script( 'wdo-woo-front-js', plugins_url( '../js/wdo-front-woo.js', __FILE__ ), array('jquery'));

        $args = array(
              'posts_per_page' => -1, 
              'tax_query' => array(
                  'relation' => 'AND',
                  array(
                      'taxonomy' => 'product_cat', 
                      'field' => 'id',
                      'terms' => $wdo_product['product_category']
                  )
              ),
              'post_type' => 'product',
        );

        $products = new WP_Query( $args );
 
        if ($products->have_posts()) {
         while ( $products->have_posts() ) {
              $products->the_post();
              ?>
                  <div class="col-lg-<?php echo $wdo_product['images_per_row']; ?> col-md-6 col-xs-12">

                    <?php include 'templates/'.$wdo_product['product_hover_effect'].'.php'; ?>
                 
                  </div>
              <?php
          }
          wp_reset_query();
        }else{
          echo 'No post found in your selected category';
        }
           
      }
    }
   ?>
  </div>
</div>