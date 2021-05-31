<!-- Logo section -->
<div class="logo_section_wrap<?php if (rehub_option('rehub_logo_inmenu') !='') {echo ' hideontablet';}?>">
    <div class="rh-container">
        <div class="logo-section header_clean_style clearfix pt0 pb0">                      
            <?php if(rehub_option('rehub_ads_top')) : ?><div class="mediad"><?php echo do_shortcode(rehub_option('rehub_ads_top')); ?></div><?php endif; ?>                      
        </div>
    </div>
</div>
<!-- /Logo section -->  
<!-- Main Navigation -->
<div class="main-nav<?php if (rehub_option('rehub_sticky_nav') ==true){echo ' rh-stickme';}?><?php echo ''.$header_menuline_style;?>">  
    <div class="rh-container<?php if (rehub_option('rehub_sticky_nav') && rehub_option('rehub_logo_sticky_url') !=''){echo ' rh-flex-center-align logo_insticky_enabled';}?>"> 
	    <?php 
	        if (rehub_option('rehub_sticky_nav') && rehub_option('rehub_logo_sticky_url') !='') {
	            echo '<a href="'.get_home_url().'" class="logo_image_insticky"><img src="'.rehub_option('rehub_logo_sticky_url').'" alt="'.get_bloginfo( "name" ).'" /></a>';                
	        }             
	    ?>    
        <?php wp_nav_menu( array( 'container_class' => 'top_menu', 'container' => 'nav', 'theme_location' => 'primary-menu', 'fallback_cb' => 'add_menu_for_blank', 'walker' => new Rehub_Walker ) ); ?>
        <div class="responsive_nav_wrap"><?php do_action('rh_mobile_menu_panel'); ?></div>
        <div class="search-header-contents"><?php get_search_form() ?></div>
    </div>
</div>
<!-- /Main Navigation -->