<?php //var_dump_value($all_product_categories);  ?>
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
		<div class='group'>
		    <h3>
		        <span class="dashicons dashicons-category"></span> 
		        <a href="#"><?php _e( 'Group Name', 'wdo-woohover' ); ?></a> 
		    </h3>
		    <div>
		        <div class='accordion content'>
		        	<table class="form-table">
		        	    <tr>
		        	        <td style="width:30%">
		        	            <strong><?php _e( 'Group Name', 'wdo-woohover' ); ?></strong>
		        	        </td>

		        	        <td style="width:30%">
		        	            <input type="text" class="groupname widefat form-control"> 
		        	        </td>

		        	        <td style="width:40%">
		        	            <p class="description"><?php _e( 'Name the group.This would be shown on accordion title for your reference.', 'wdo-woohover' ); ?></p>
		        	        </td>
		        	    </tr>

		        	    <tr>
		        	        <td>
		        	            <strong><?php _e( 'Product Category', 'wdo-woohover' ); ?></strong>
		        	        </td>
		        	        <td>
		        	            <select class="productcategory form-control">
		        	            	<option value=""><?php _e( 'Select Product Category', 'wdo-woohover' ); ?></option>
		        	            	<?php foreach ($all_product_categories as $cat):
		                                $total_count = ( $this->wp_get_cat_postcount($cat->term_id) == '0') ? $cat->count : $this->wp_get_cat_postcount($cat->term_id) ;
		                             ?>
		        	            		<option value="<?php echo $cat->term_id; ?>"><?php echo $cat->name; ?> (<?php echo $total_count; ?>)</option>
		        	            	<?php endforeach ?> 
		        	                
		        	            </select>
		        	        </td>
		        	        <td>
		        	            <p class="description"><?php _e( 'Select woocommerce product category whose products you want to display.', 'wdo-woohover' ); ?></p>
		        	        </td>
		        	    </tr>
		        	    <tr>
		        	        <td>
		        	            <strong><?php _e( 'Select Hover Effect', 'wdo-woohover' ); ?></strong>
		        	        </td>
		        	        <td>
		        	            <select class="producthovereffect form-control widefat">
		        	              <option value="effect1">Effect1</option>
		        	              <option value="effect2">Effect2</option>
		        	              <option value="effect3">Effect3</option>
		        	              <option value="effect4">Effect4</option>
		        	              <option value="effect5">Effect5</option>
		        	              <option value="effect6">Effect6</option>
		        	              <option value="effect7">Effect7</option>
		        	              <option value="effect8">Effect8</option>
		        	              <option value="effect9">Effect9</option>
		        	              <option value="effect10">Effect10</option>
		        	               
		        	            </select>
		        	        </td>
		        	        <td>
		        	            <p class="description"><?php _e( 'Select hover effect which you want to use over all products of selected categroy.', 'wdo-woohover' ); ?></p>
                        			<a style="font-weight: 700;text-decoration: none;color: #428bca;" href="https://demo.webdevocean.com/hover-effects-for-woocommerce-products/" target="_blank"><?php _e( 'PRO Version 150+ Effects', 'wdo-woohover' ); ?></a>
		        	        </td>
		        	    </tr>

		        	    <tr>
		        	        <td>
		        	            <strong><?php _e( 'Hover Animation Direction', 'wdo-woohover' ); ?></strong>
		        	        </td>
		        	        <td>
		        	            <select class="animationdirection form-control widefat">
		        	              <option value="left_to_right"><?php _e( 'Left To Right', 'la-captionhover' ); ?></option>
		        	              <option value="right_to_left"><?php _e( 'Right To Left', 'la-captionhover' ); ?></option>
		        	              <option value="top_to_bottom"><?php _e( 'Top To Bottom', 'la-captionhover' ); ?></option>
		        	              <option value="bottom_to_top"><?php _e( 'Bottom To Top', 'la-captionhover' ); ?></option>
		        	               
		        	            </select>
		        	        </td>
		        	        <td>
		        	            <p class="description"><?php _e( 'Select direction for the animation when hover over product.', 'wdo-woohover' ); ?></p>
		        	        </td>
		        	    </tr>

		        	    <tr>
                            <td>
                                <strong><?php _e( 'Products View', 'wdo-woohover' ); ?></strong>
                            </td>
                            <td>
                                <select class="productsview form-control">
                                    <option value="grid">Grid</option>
                                    <option value="woo-slider">Slider (PRO Feature)</option>
                                </select>  
                            </td>
                            <td>
                                <p class="description"><?php _e( 'Select how you want to display products of selected category.', 'wdo-woohover' ); ?></p>
                            </td>
                        </tr>

                        <tr class="slides-row">
                            <td>
                                <label><?php _e( 'Number of Slides to Show (PRO Feature)', 'wdo-woohover' ); ?></label>
                                <select class="slidestoshow form-control widefat">
                                  <option value="1">1</option>
                                  <option value="2">2</option>
                                  <option value="3">3</option>
                                  <option value="4">4</option>
                                </select>
                                <p class="description"><?php _e( 'The number of products you want to show on the screen when slider starts.', 'wdo-woohover' ); ?></p>
                            </td>
                            <td>
                                <label><?php _e( 'Show Navigation Arrows (PRO Feature)', 'wdo-woohover' ); ?></label>
                                <select class="showarrows form-control widefat">
                                  <option value="true">Yes</option>
                                  <option value="false">No</option>
                                </select>
                                <p class="description"><?php _e( 'Select want to show navigation arrows.', 'wdo-woohover' ); ?></p>
                            </td>
                            <td>
                                <label><?php _e( 'Show Navigation Dots (PRO Feature)', 'wdo-woohover' ); ?></label>
                                <select class="showdots form-control widefat">
                                  <option value="true">Yes</option>
                                  <option value="false">No</option>
                                </select>
                                <p class="description"><?php _e( 'Select want to show navigation dots.', 'wdo-woohover' ); ?></p>
                            </td>
                        </tr>

		        	    <tr class="grid-row">
		        	        <td>
		        	            <strong><?php _e( 'Products Per Row', 'wdo-woohover' ); ?></strong>
		        	        </td>
		        	        <td>
		        	            <select class="imagesperrow form-control">
		        	                <option value="12">1</option>
		        	                <option value="6">2</option>
		        	                <option value="4">3</option>
		        	                <option value="3">4</option>
		        	            </select>
		        	        </td>
		        	        <td>
		        	            <p class="description"><?php _e( 'Select how many products you want to show in a row.', 'wdo-woohover' ); ?></p>
		        	        </td>
		        	    </tr>
		        	    
		        	</table>

		        	<h4>Styling</h4>
		        	<hr>
		        	<table class="form-table">
		        	    <tr>
		        	        <td style="width:30%">
		        	            <strong><?php _e( 'Product Title Font Size (PRO Feature)', 'wdo-woohover' ); ?>
		        	        </td>
		        	        <td style="width:30%">
		        	            <input type="number" class="wootitlefontsize widefat form-control" value="20s">
		        	        </td>
		        	        <td style="width:40%">
		        	            <p class="description"><?php _e( 'Give font-size for the product title.', 'wdo-woohover' ); ?></p>
		        	        </td>
		        	    </tr>

		        	    <tr>
		        	        <td>
		        	            <strong><?php _e( 'Short Description Font Size (PRO Feature)', 'wdo-woohover' ); ?>
		        	        </td>
		        	        <td>
		        	            <input type="number" class="woodescfontsize widefat form-control" value="14">
		        	        </td>
		        	        <td>
		        	            <p class="description"><?php _e( 'Give font-size for the product shortdescription.', 'wdo-woohover' ); ?></p>
		        	        </td>
		        	    </tr>

		        	    <tr>
		        	        <td>
		        	            <strong><?php _e( 'Other Details Font Size (PRO Feature)', 'wdo-woohover' ); ?>
		        	        </td>
		        	        <td>
		        	            <input type="number" class="metafontsize widefat form-control" value="12">
		        	        </td>
		        	        <td>
		        	            <p class="description"><?php _e( 'Give font-size for the product details shown other than title and description.', 'wdo-woohover' ); ?></p>
		        	        </td>
		        	    </tr>

		        	    <tr>
		        	        <td>
		        	            <strong><?php _e( 'Border Width (PRO Feature)', 'wdo-woohover' ); ?>
		        	        </td>
		        	        <td>
		        	            <input type="number" class="woobordersize widefat form-control" value="0">
		        	        </td>
		        	        <td>
		        	            <p class="description"><?php _e( 'Set width for the product shown.', 'wdo-woohover' ); ?></p>
		        	        </td>
		        	    </tr>

		        	    <tr>
		        	        <td>
		        	            <strong><?php _e( 'Title Background Color (PRO Feature)', 'wdo-woohover' ); ?></strong>
		        	        </td>

		        	        <td>
		        	            <input type="text" class="wootitlebg widefat form-control" value="rgba(0, 0, 0, 0)"> 
		        	        </td>

		        	        <td>
		        	            <p class="description"><?php _e( 'Choose background color for title.', 'wdo-woohover' ); ?></p>
		        	        </td>
		        	    </tr>

		        	    <tr>
		        	        <td>
		        	            <strong><?php _e( 'Content Background Color (PRO Feature)', 'wdo-woohover' ); ?></strong>
		        	        </td>

		        	        <td>
		        	            <input type="text" class="woocontentbg widefat form-control" value="#135796"> 
		        	        </td>

		        	        <td>
		        	            <p class="description"><?php _e( 'Choose background color for product details to be shown.', 'wdo-woohover' ); ?></p>
		        	        </td>
		        	    </tr>

		        	    <tr>
		        	        <td>
		        	            <strong><?php _e( 'Sale Badge Background Color (PRO Feature)', 'wdo-woohover' ); ?></strong>
		        	        </td>

		        	        <td>
		        	            <input type="text" class="woosalebadgebg widefat form-control" value="#000"> 
		        	        </td>

		        	        <td>
		        	            <p class="description"><?php _e( 'Choose background color for sale badge', 'wdo-woohover' ); ?></p>
		        	        </td>
		        	    </tr>

		        	    <tr>
		        	        <td>
		        	            <strong><?php _e( 'Border Color (PRO Feature)', 'wdo-woohover' ); ?></strong>
		        	        </td>

		        	        <td>
		        	            <input type="text" class="woobordercolor widefat form-control" value="#fff"> 
		        	        </td>

		        	        <td>
		        	            <p class="description"><?php _e( 'Choose color for border for the product.', 'wdo-woohover' ); ?></p>
		        	        </td>
		        	    </tr>

		        	    <tr>
		        	        <td>
		        	            <strong><?php _e( 'Product Content Color (PRO Feature)', 'wdo-woohover' ); ?></strong>
		        	        </td>

		        	        <td>
		        	            <input type="text" class="contentcolor widefat form-control" value="#fff"> 
		        	        </td>

		        	        <td>
		        	            <p class="description"><?php _e( 'Choose color for the content of color such as title,short description,price etc.', 'wdo-woohover' ); ?></p>
		        	        </td>
		        	    </tr>
		        	    
		        	</table>

		        </div>
		         
				<span class="moreimages">
		    		<button class="button addnewgroup"><b title="Add New" class="dashicons dashicons-plus-alt"></b><?php _e( 'Add New Group', 'wdo-woohover' ); ?></button>
		    		<button class="button removegroup"><span class="dashicons dashicons-dismiss" title="Delete"></span><?php _e( 'Remove Group', 'wdo-woohover' ); ?></button>
					<button class="button-primary fullshortcode pull-right" id="1"><?php _e( 'Get Shortcode', 'wdo-woohover' ); ?></button>
		    	</span>
		    </div>
		</div>
	</div>
	<button class="btn btn-success save-meta"><?php _e( 'Save Changes', 'la-captionhover' ); ?></button></br>
</div>
<h2 style="text-align: center;background: #370f97;padding: 15px 20px;width: 50%;margin: 2em auto;"><a style="text-decoration: none;color: #fff;width: 100%;display: block;" href="https://webdevocean.com/product/image-hover-effects-woocommerce-products/">Get PRO Version</a></h2>