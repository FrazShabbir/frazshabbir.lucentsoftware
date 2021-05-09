<?php 
	/**
	* Plugin Main Class
	*/
	class WDO_Woo_Hover_Effects {
		
		function __construct()  
		{
			add_action( "admin_menu", array($this,'wdo_woo_hover_admin_menu'));
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_options_page_scripts' ) );
			add_action('wp_ajax_wdo_save_woohover_options', array($this, 'save_plugin_options'));
			add_shortcode( 'woo-hover-effects', array($this,'render_woo_hover_effects') );
		} 

		function wdo_woo_hover_admin_menu(){
			add_menu_page( 'Hover Effects For WooCommerce', 'Hover Effects For WooCommerce', 'manage_options', 'woo_hover_effects', array($this,'wdo_render_menu_page'), 'dashicons-image-filter' );
		}

		function wp_get_cat_postcount($id) {
		    $cat = get_category($id);
		    $count = (int) $cat->count;
		    $taxonomy = 'product_cat';
		    $args = array(
		        'child_of' => $id,
		    );
		    $tax_terms = get_terms($taxonomy,$args);
		    foreach ($tax_terms as $tax_term) {
		        $count +=$tax_term->count;
		    }

		    return $count;
		}

		function wdo_render_menu_page(){
			$saved_effects = get_option( 'wdo_woo_hover_options' );
			// wdo_dump_variable($saved_effects);
			 $args = array(
			     'taxonomy'   => "product_cat",
			     'number'     => $number,
			     'orderby'    => $orderby,
			     'order'      => $order,
			     'hide_empty' => $hide_empty,
			     'include'    => $ids
			 );
			$all_product_categories = get_terms( $args ); 
			if ( isset($saved_effects) && $saved_effects != null ) { ?>
				<div class="wdo-hover-container">
					<?php if ( !class_exists( 'WooCommerce' ) ): ?>
						<input type="text"id="plugin-alert" value="A text field" style="opacity: 0;">
						<div class="alert alert-primary"  role="alert">
						  Image Hover Effects For WooCommerce requires <a class="alert-link" href="https://wordpress.org/plugins/woocommerce/" target="_blank">WooCommerce</a> plugin to be installed and activated on your site.
						</div>
					<?php endif ?>
					<div class="se-pre-con"></div>
					<div class="se-saved-con"></div>
					<div class="overlay-message">
					    <p><?php _e( 'Changes Saved..!', 'la-fronteditor' ); ?></p>
					</div> 
					<h1 class="main-heading">Hover Effects For WooCommerce</h1>
					<p class="plugin-description">An easy way to display your products with animated hover effects</p>
					<div class='accordion category-clone'>
			<?php foreach ($saved_effects as $product) {
					include 'includes/admin-settings.php';
				} ?>
					</div>
					<button class="btn btn-success save-meta"><?php _e( 'Save Changes', 'la-captionhover' ); ?></button></br>
				</div>
				<h2 style="text-align: center;background: #370f97;padding: 15px 20px;width: 50%;margin: 2em auto;"><a style="text-decoration: none;color: #fff;width: 100%;display: block;" href="https://webdevocean.com/product/image-hover-effects-woocommerce-products/">Get PRO Version</a></h2>
			<?php
			} else {
				include 'includes/initial-settings.php';
			}
				
		}

		// Admin Options Page 
		function admin_options_page_scripts($slug){
			if( $slug=='toplevel_page_woo_hover_effects' ){
				wp_enqueue_media();
				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_script( 'wdo-woo-admin-js', plugins_url( 'admin/admin.js', __FILE__ ), array('jquery', 'jquery-ui-accordion','wp-color-picker'));
				wp_enqueue_style( 'wdo-ui-css', plugins_url( 'admin/jquery-ui.min.css', __FILE__ ));
				wp_enqueue_style( 'wdo-woo-style-css', plugins_url( 'admin/style.css', __FILE__ ));
				wp_localize_script( 'wdo-woo-admin-js', 'laAjax', array( 
					'url' => admin_url( 'admin-ajax.php' ),
					'nonce' => wp_create_nonce('wdo-ajax-nonce')
				));
			}
		}

		function save_plugin_options(){
			$nonce = $_REQUEST['nonce'];
			$sanitized_fields = array();
			$all_data = array();
			if ( isset($_REQUEST['posts']) && wp_verify_nonce( $nonce, 'wdo-ajax-nonce' ) ) {
				foreach ($_REQUEST['posts'] as $post) {
					$sanitized_fields['group_name'] = sanitize_text_field( $post['group_name'] );
					$sanitized_fields['product_category'] = sanitize_text_field( $post['product_category'] );
					$sanitized_fields['images_per_row'] = sanitize_text_field( $post['images_per_row'] );
					$sanitized_fields['product_hover_effect'] = sanitize_text_field( $post['product_hover_effect'] );
					$sanitized_fields['animation_direction'] = sanitize_text_field( $post['animation_direction'] );
					$sanitized_fields['shortcode'] = sanitize_text_field( $post['shortcode'] );
					$all_data[] = $sanitized_fields;
				}
			} else {
				die(0); 
			}
			
			update_option( 'wdo_woo_hover_options', $all_data );
		}

		function render_woo_hover_effects($atts){
			$saved_effects = get_option( 'wdo_woo_hover_options' );
			include 'includes/render-woo-hover.php';
		}
	} 

 ?>