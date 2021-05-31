<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php 
global $post;
if (isset($aff_link) && $aff_link == '1') {
    $link = rehub_create_affiliate_link ();
    $target = ' rel="nofollow" target="_blank"';
}
else {
    $link = get_the_permalink();
    $target = '';  
}
?>  
<?php
$disable_meta = (isset($disable_meta)) ? $disable_meta : '';
$disable_price = (isset($disable_price)) ? $disable_price : '';
$exerpt_count = (isset($exerpt_count)) ? $exerpt_count : '';
$enable_btn = (isset($enable_btn)) ? $enable_btn : '';
$image_padding = (isset($image_padding) && $image_padding) ? ' padd20' : '';
?>
<?php
$dealcat = '';       
if(rehub_option('enable_brand_taxonomy') == 1){ 
    $dealcats = wp_get_post_terms($post->ID, 'dealstore', array("fields" => "all")); 
    if( ! empty( $dealcats ) && ! is_wp_error( $dealcats ) ) {
        $dealcat = $dealcats[0];                   
    }                               
}
?>
<article class="col_item column_grid rh-heading-hover-color rh-bg-hover-color rh-cartbox no-padding"> 
    <div class="button_action abdposright pr5 pt5">
        <div class="floatleft mr5">
            <?php $wishlistadded = esc_html__('Added to wishlist', 'rehub-theme');?>
            <?php $wishlistremoved = esc_html__('Removed from wishlist', 'rehub-theme');?>
            <?php echo RH_get_wishlist($post->ID, '', $wishlistadded, $wishlistremoved);?>  
        </div>                                                           
    </div>     
    <figure class="mb20 position-relative text-center<?php echo esc_attr($image_padding);?>"><?php echo re_badge_create('tablelabel'); ?>             
        <a href="<?php echo ''.$link;?>"<?php echo ''.$target;?>><?php wpsm_thumb ('medium_news') ?></a>
    </figure>
    <?php do_action( 'rehub_after_grid_column_figure' ); ?>
    <div class="content_constructor pb10 pr20 pl20">
        <div class="mb5"><?php rehub_format_score('small') ?></div> 
        <h3 class="mb15 mt0 font110 mobfont100 fontnormal lineheight20"><a href="<?php echo ''.$link;?>"<?php echo ''.$target;?>><?php the_title();?></a></h3>
        <?php $custom_notice = get_post_meta($post->ID, '_notice_custom', true);?>
        <?php 
            if($custom_notice){
                echo '<div class="rh_custom_notice mb10 lineheight20 fontbold font90 rehub-sec-color">'.esc_html($custom_notice).'</div>';
            }
            elseif (!empty($dealcat)) {
                $dealcat_notice = get_term_meta($dealcat->term_id, 'cashback_notice', true );
                if($dealcat_notice){
                    echo '<div class="rh_custom_notice mb10 lineheight20 fontbold font90 rehub-sec-color">'.esc_html($dealcat_notice).'</div>';
                }
            } 
        ?>                 
        <?php do_action( 'rehub_after_grid_column_title' ); ?> 
        <?php if($exerpt_count && $exerpt_count !='0'):?>                      
        <div class="mb15 greycolor lineheight20 font90">                                 
            <?php kama_excerpt('maxchar='.$exerpt_count.''); ?>                       
        </div> 
        <?php endif?>
        <div class="rh-flex-center-align mb10">
            <?php if($disable_meta !='1'):?>
                <div class="post-meta mb0">
                    <?php meta_all( false, false, false, true); ?>
                    <div class="store_for_grid">
                        <?php WPSM_Postfilters::re_show_brand_tax('list');?>
                    </div>               
                </div>
            <?php endif?>
            <?php if($disable_price !='1'):?>
            <div class="rh-flex-right-align">
                <?php rehub_generate_offerbtn('showme=price&wrapperclass=pricefont110 rehub-main-font rehub-main-color mobpricefont100 fontbold mb0 lineheight20');?>            
            </div>
            <?php endif?>               
        </div> 
        <?php if($enable_btn):?>
        <div class="columngridbtn">
            <?php rehub_generate_offerbtn('showme=button&wrapperclass=mb10');?>            
        </div>
        <?php endif?>
    </div>                                   
</article>