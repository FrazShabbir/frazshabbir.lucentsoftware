<?php
/**
 * Rehub Framework Helper Functions
 *
 * @package ReHub\Functions
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//////////////////////////////////////////////////////////////////
// Logger function
//////////////////////////////////////////////////////////////////
function rh_logger( $value, $variable = '' ) {
	if ( true === WP_DEBUG ) {
		if ( is_array( $value ) || is_object( $value ) ) {
			error_log( $variable .' = '. print_r( $value, true ) );
		} 
		else {
			error_log( $variable .' = '. $value );
		}
	}
}

//////////////////////////////////////////////////////////////////
// File System function
//////////////////////////////////////////////////////////////////
function rf_filesystem( $method = 'get_content', $file_path, $content = '' ){
  if( empty( $file_path ) )
    return;
  
  global $wp_filesystem;
  
  if( empty( $wp_filesystem ) ) {
    require_once ( ABSPATH . '/wp-admin/includes/file.php' );
    WP_Filesystem();
  }
  if( $method == 'get_content' ){
    $result = $wp_filesystem->get_contents( $file_path );
    if( $result && !is_wp_error( $result ) ){
      return $result;
    }else{
      $result = file_get_contents($file_path);
      if($result) {
        return $result;
      }else{
        return;
      }
    }
  }elseif( $method == 'put_content' ){
    $result = $wp_filesystem->put_contents( $file_path, $content, FS_CHMOD_FILE );
    if( !is_wp_error( $result ) ){
      return true;
    }else{
      return;
    }
  }else{
    return;
  }
}

//////////////////////////////////////////////////////////////////
// Get post types
//////////////////////////////////////////////////////////////////
if(!function_exists('rh_get_post_type_formeta')){
function rh_get_post_type_formeta() {
	$def_p_types = REHub_Framework::get_option('rehub_ptype_formeta');
	$def_p_types = (!empty($def_p_types[0])) ? (array) $def_p_types : array( 'post' );
	unset($def_p_types['product']);
	return $def_p_types;
}
}

//////////////////////////////////////////////////////////////////
// include files in plugin but check grandchild and child theme
//////////////////////////////////////////////////////////////////
if(!function_exists('rf_locate_template')){
function rf_locate_template($template_names, $load = false, $require_once = true) {
    $located = '';
    foreach ( (array) $template_names as $template_name ) {
        if ( !$template_name )
            continue;
        if(defined( 'RH_GRANDCHILD_DIR' ) && file_exists(RH_GRANDCHILD_DIR . $template_name)){
            $located = RH_GRANDCHILD_DIR . '/' . $template_name;
            break;            
        }
        if ( file_exists(get_stylesheet_directory() . '/' . $template_name)) {
            $located = get_stylesheet_directory() . '/' . $template_name;
            break;
        } elseif ( file_exists(RH_FRAMEWORK_ABSPATH . '/' . $template_name) ) {
            $located = RH_FRAMEWORK_ABSPATH . '/' . $template_name;
            break;
        }
    } 
    if ( $load && '' != $located )
        load_template( $located, $require_once );
      
    return $located;
}
}

//////////////////////////////////////////////////////////////////
// MAIL FUNCTION
//////////////////////////////////////////////////////////////////
if(!function_exists('rh_send_message_eml')){
	function rh_send_message_eml($user_email, $title, $message, $message_headers) {
		return wp_mail( $user_email, wp_specialchars_decode( $title ), $message, $message_headers );
	}
}

//////////////////////////////////////////////////////////////////
// GET IP
//////////////////////////////////////////////////////////////////
if(!function_exists('rh_framework_user_ip')){
function rh_framework_user_ip() {
	foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
		if (array_key_exists($key, $_SERVER) === true) {
			$ip = $_SERVER[$key];
	        if(strpos($ip, ',') !== false) {
	            $ip = explode(',', $ip);
	            $ip = $ip[0];
	        }	
	        if($ip){substr_replace($ip,0,-1);} //GDRP        		
			return esc_attr($ip);
		}
	}
	return '127.0.0.3';
}
}

//////////////////////////////////////////////////////////////////
// POST VIEW FUNCTION
//////////////////////////////////////////////////////////////////

if (REHub_Framework::get_option('post_view_disable') !='1') {
    add_action('wp_enqueue_scripts', 'rehub_postview_enqueue');
    if (!function_exists('rehub_postview_enqueue')){
        function rehub_postview_enqueue() {
            global $post;
            if ( is_single() ) {     
                wp_register_script( 'rehub-postview', RH_FRAMEWORK_URL . '/assets/js/postviews.js', array( 'jquery' ) );
                wp_localize_script( 'rehub-postview', 'postviewvar', array('rhpost_ajax_url' => RH_FRAMEWORK_URL . '/includes/rehub_ajax.php', 'post_id' => intval($post->ID)));
                wp_enqueue_script ( 'rehub-postview');      
            }
        } 
    }    
} 

if (!function_exists('RH_get_post_views')){
    function RH_get_post_views($postid=''){
        if (isset($postid)){
            $post_id = $postid;
        }
        else{
            $post_id = get_the_ID();
        }
        return get_post_meta ($post_id,'rehub_views',true);
    }
}



//////////////////////////////////////////////////////////////////
// FAVORITE RELOAD FUNCTION
//////////////////////////////////////////////////////////////////
if (REHub_Framework::get_option('wish_cache_enabled')) {
    add_action('wp_enqueue_scripts', 're_wish_cache_enabled');
    if (!function_exists('re_wish_cache_enabled')){
        function re_wish_cache_enabled() {
            $user_id = is_user_logged_in() ? get_current_user_id() : '0';
            wp_localize_script( 'rehub', 'wishcached', array('rh_ajax_url' => RH_FRAMEWORK_URL . '/includes/rehub_ajax.php', 'userid' => $user_id)); 
        } 
    } 
}

//////////////////////////////////////////////////////////////////
// RENDER ELEMENTOR TEMPLATE
//////////////////////////////////////////////////////////////////
if (!function_exists('wpsm_rh_elementor_box')){
    function wpsm_rh_elementor_box ($atts){
        $atts = shortcode_atts(
            array(
                'id' => '',
                'cache' => '',
                'expire' => 24,
                'clean' => '',
                'css' => false,
                'ajax' => ''
            ), $atts);        
        if(!class_exists('\Elementor\Plugin')){
            return '';
        }
        if(!isset($atts['id']) || empty($atts['id'])){
            return '';
        }

        $post_id = $atts['id'];
        if(!empty($atts['ajax'])){
            wp_enqueue_style( 'elementor-frontend' );
            $response = '<div class="el-ajax-load-block el-ajax-load-block-'.$post_id.'"></div>';          
        }        
        elseif(!empty($atts['cache'])){
            $transient_name = 'RH_ELEMENTOR_TRANSIENT_'.$atts['id'];
            if($atts['clean'] == true) delete_transient($transient_name);
            $with_css = (!empty($atts['css'])) ? true : false;
            $response = get_transient( $transient_name );

            if($response === false){
                $response = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($post_id, $with_css);
                $cache_time = $atts['expire'] * HOUR_IN_SECONDS;
                set_transient( $transient_name, $response, $cache_time);
            }
            if(!$with_css){
                $css_file = new \Elementor\Core\Files\CSS\Post($post_id);
                $css_file->enqueue();
            } 
            if ($response && strpos( $response, 're_carousel' ) !== false ) {
                wp_enqueue_script('owlcarousel');
            }
            if ($response && strpos( $response, 'elementor-invisible' ) !== false ) {
                $response = str_replace('elementor-invisible', '', $response);
            } 
            if ($response && strpos( $response, 'elementor-counter' ) !== false ) {
                $response = str_replace('elementor-widget-counter', 'rhhidden', $response);

            }                                               
        }else{
            $response = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($post_id);
        }
        return $response;
    }
}

add_action( 'wp_ajax_rh_el_ajax_hover_load', 'rh_el_ajax_hover_load');
add_action( 'wp_ajax_nopriv_rh_el_ajax_hover_load', 'rh_el_ajax_hover_load');
function rh_el_ajax_hover_load() {
    check_ajax_referer( 'ajaxed-nonce', 'security' );
    if(!class_exists('\Elementor\Plugin')){
        echo 'fail';
    }    
    $post_id = intval($_POST['post_id']);
    $shortcode_content = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($post_id, true);
    if($shortcode_content){
        echo $shortcode_content;
    }else{
        echo 'fail';
    }
    wp_die();
}

//////////////////////////////////////////////////////////////////
// Allow heading in term description
//////////////////////////////////////////////////////////////////
remove_filter('pre_term_description', 'wp_filter_kses');


//////////////////////////////////////////////////////////////////
// Social Share function
//////////////////////////////////////////////////////////////////
if( !function_exists('rehub_social_share') ) {
function rehub_social_share($small = '', $favorite = '', $rh_favorite = '', $type = '', $wishlistids='')
{   
    global $post;
    if ($small == 'minimal') {
        $small_class = ' social_icon_inimage small_social_inimage';
        $text_fb = $text_tw = '';
    }
    elseif ($small =='row') {
        $small_class = ' row_social_inpost';
        $text_fb = 'Facebook';
        $text_tw = '';
    }
    elseif ($small == 'flat') {
        $text_fb = $text_tw = $small_class = '';
    }    
    else {
        $small_class = ' social_icon_inimage';
    }
    $output ='';
    $output .='<div class="social_icon '.$small_class.'">';
    if ($favorite == '1' && function_exists('RH_get_wishlist')) {
        $wishlistadd = esc_html__('Save', 'rehub-theme');
        $wishlistadded = esc_html__('Saved', 'rehub-theme');
        $wishlistremoved = esc_html__('Removed', 'rehub-theme');      
        $output .='<div class="favour_in_row favour_btn_red">'.RH_get_wishlist($post->ID, $wishlistadd, $wishlistadded, $wishlistremoved).'</div>';
    }
    if ($rh_favorite == '1' && function_exists('RH_get_wishlist')) {
        $output .= RH_get_wishlist($post->ID);
    }    
    if($type=='user' && function_exists('bp_core_get_user_domain')){
      $link = bp_core_get_user_domain(bp_displayed_user_id());
      $image = bp_get_displayed_user_avatar('type=full&html=false');
      $title = get_the_title().' - '.get_bloginfo('name' );
    }
    else{
      $link = get_permalink();
      $image = WPSM_image_resizer::get_post_thumb_static();
      $title = get_the_title();
    }
    if($wishlistids){
      $link = $link.'?wishlistids='.$wishlistids;
    }
    $output .= do_action('rh_social_inimage_before');
    $output .= '<span data-href="https://www.facebook.com/sharer/sharer.php?u='.urlencode($link).'" class="fb share-link-image" data-service="facebook"><i class="fab fa-facebook"></i></span>';
    $output .='<span data-href="https://twitter.com/share?url='.urlencode($link).'&text='.urlencode(html_entity_decode($title, ENT_COMPAT, 'UTF-8')).'" class="tw share-link-image" data-service="twitter"><i class="fab fa-twitter"></i></span>';
    $output .='<span data-href="https://pinterest.com/pin/create/button/?url='.urlencode($link).'&amp;media='.$image.'&amp;description='.urlencode($title).'" class="pn share-link-image" data-service="pinterest"><i class="fab fa-pinterest-p"></i></span>';
    //$output .='<span data-href="whatsapp://send?&text='.urlencode(html_entity_decode($title, ENT_COMPAT, 'UTF-8')).' - '.urlencode($link).'" data-action="share/whatsapp/share" class="wa share-link-image" data-service="whatsapp"><i class="fab fa-whatsapp"></i></span>';    
    if ($small =='row' || $small =='flat' ) {
        $output .='<span data-href="mailto:?subject='.urlencode(html_entity_decode($title, ENT_COMPAT, 'UTF-8')).'&body='.__('Check out:', 'rehub-theme').' '.urlencode($link).' - '.urlencode(html_entity_decode(get_bloginfo("name"), ENT_COMPAT, 'UTF-8')).'" class="in share-link-image" data-service="email"><i class="far fa-envelope"></i></span>';    
        //$output .='<span data-href="https://www.linkedin.com/shareArticle?mini=true&url='.urlencode($link).'&title='.urlencode(html_entity_decode($title, ENT_COMPAT, 'UTF-8')).'&source='.urlencode(html_entity_decode(get_bloginfo("name"), ENT_COMPAT, 'UTF-8')).'" class="in share-link-image" data-service="linkedin"><i class="fab fa-linkedin"></i></span>';
    }
    $output .= do_action('rh_social_inimage_after');
    $output .='</div>';         
    return $output; 
}
}


//////////////////////////////////////////////////////////////////
// RH Hot metter and wishlist
//////////////////////////////////////////////////////////////////

if (!function_exists('RHgetHotLike')){
function RHgetHotLike( $post_id ) {
    if (REHub_Framework::get_option('exclude_hotmeter') =='1') {
        return false;
    } 
    $max_temp = (REHub_Framework::get_option('hot_max')) ? REHub_Framework::get_option('hot_max') : 10;
    $min_temp = (REHub_Framework::get_option('hot_min')) ? REHub_Framework::get_option('hot_min') : -10; 
   
    $like_count = get_post_meta( $post_id, "post_hot_count", true ); // get post likes
    if ( ( !$like_count ) || ( $like_count && $like_count == "0" ) ) { // no votes, set up empty variable
        $temp = '0';
    } elseif ( $like_count && $like_count != "0" ) { // there are votes!
        $temp = esc_attr( $like_count );
    }
    if ($temp >= $max_temp){
        $icontemp = '<i class="fas fa-fire"></i> ';
    }
    elseif ($temp <= $min_temp) {
        $icontemp = '<i class="far snowflake"></i> ';
    }
    else {
        $icontemp = '';
    }
    $onlyuser_class = REHub_Framework::get_option('thumb_only_users');
    $loginurl = '';
    if($onlyuser_class == 1){
        if (is_user_logged_in()){
            $onlyuser_class = '';
        }
        else{
            if(REHub_Framework::get_option('custom_login_url')){
                $urllogin = REHub_Framework::get_option('custom_login_url');
                $loginurl = ' data-type="url" data-customurl="'.esc_url($urllogin).'"';
            }else{
                $loginurl = '';
            }
            $onlyuser_class = ' act-rehub-login-popup restrict_for_guests';
        }
    }   
    $output = '<div class="hotmeter_wrap"><div class="hotmeter"><span class="table_cell_hot first_cell"><span id="temperatur'.$post_id.'" class="temperatur';
    if ($temp < 0) :
        $output .= ' cold_temp';
    endif;
    $output .= '">'.$icontemp.$temp.'<span class="gradus_icon"></span></span></span> ';
    $output .= '<span class="table_cell_hot cell_minus_hot">';
    if ( RH_AlreadyHot( $post_id ) ) { // already liked, set up unlike addon
        $output .= '<button class="hotminus alreadyhot" alt="'.__('Vote down', 'rehub-theme').'" title="'.__('Vote down', 'rehub-theme').'" data-post_id="'.$post_id.'" data-informer="'.$temp.'"></button>';
    } else { // normal like button
        $output .= '<button class="hotminus'.$onlyuser_class.'"'.$loginurl.' alt="'.__('Vote down', 'rehub-theme').'" title="'.__('Vote down', 'rehub-theme').'" data-post_id="'.$post_id.'" data-informer="'.$temp.'"></button>';
    }
    $output .= '</span><span class="table_cell_hot cell_plus_hot">';
    if ( RH_AlreadyHot( $post_id ) ) { // already liked, set up unlike addon
        $output .= '<button class="hotplus alreadyhot" alt="'.__('Vote up', 'rehub-theme').'" title="'.__('Vote up', 'rehub-theme').'" data-post_id="'.$post_id.'" data-informer="'.$temp.'"></button>';
    } else { // normal like button
        $output .= '<button class="hotplus'.$onlyuser_class.'"'.$loginurl.' alt="'.__('Vote up', 'rehub-theme').'" title="'.__('Vote up', 'rehub-theme').'" data-post_id="'.$post_id.'" data-informer="'.$temp.'"></button>';
    }
    $output .= '</span>';
    $output .= '<span id="textinfo'.$post_id.'" class="textinfo table_cell_hot"></span>';

    $output .= '<div class="table_cell_hot fullwidth_cell">';
    if ($temp >= $max_temp) :
        $temp = $max_temp;
    elseif ($temp <= $min_temp) :
        $temp = $min_temp;
    endif;
    $output .= '<div id="fonscale'.$post_id.'" class="fonscale">';      
    $output .= '<div id="scaleperc'.$post_id.'" class="scaleperc';
    if ($temp < 0) :
        $output .= ' cold_bar';
    endif;
    $output .= '" style="width:';
    if ($temp >= 0) :
        $output .= ''.($temp / $max_temp * 100).'%">';
    else:
        $output .= ''.($temp / $min_temp * 100).'%">';
    endif;
    $output .= '</div></div></div></div></div>';    

    return $output;
}
}

if (!function_exists('RH_AlreadyHot')){
function RH_AlreadyHot( $post_id ) { // test if user liked before
    
    if ( is_user_logged_in() ) { // user is logged in
        global $current_user;
        $user_id = $current_user->ID; // current user
        $meta_USERS = get_post_meta( $post_id, "_user_liked" ); // user ids from post meta
        $liked_USERS = ""; // set up array variable     
        if ( count( $meta_USERS ) != 0 ) { // meta exists, set up values
            $liked_USERS = $meta_USERS[0];
        }       
        if( !is_array( $liked_USERS ) ) // make array just in case
            $liked_USERS = array();         
        if ( in_array( $user_id, $liked_USERS ) ) { // True if User ID in array
            return true;
        }
        return false;       
    } 
    else { // user is anonymous, use IP address for voting  
        $meta_IPS = get_post_meta($post_id, "_user_IP"); // get previously voted IP address
        $ip = rh_framework_user_ip(); // Retrieve current user IP
        $liked_IPS = ""; // set up array variable
        if ( count( $meta_IPS ) != 0 ) { // meta exists, set up values
            $liked_IPS = $meta_IPS[0];
        }
        if ( !is_array( $liked_IPS ) ) // make array just in case
            $liked_IPS = array();
        if ( in_array( $ip, $liked_IPS ) ) { // True is IP in array
            return true;
        }
        return false;
    }   
}
}

if (!function_exists('RHF_get_wishlist')){
function RHF_get_wishlist( $post_id, $wishlistadd = '',$wishlistadded = '', $wishlistremoved = '' ) { 
    if(REHub_Framework::get_option('wishlist_disable') == 1){return;}   
    $like_count = get_post_meta( $post_id, "post_wish_count", true ); // get post likes
    if ( ( !$like_count ) || ( $like_count && $like_count == "0" ) ) { // no votes, set up empty variable
        $temp = '0';
    } elseif ( $like_count && $like_count != "0" ) { // there are votes!
        $temp = esc_attr( $like_count );
    }
    $alreadyclass = ( RH_AlreadyWish( $post_id ) ) ? ' alreadyhot' : '';
    $output = '<div class="heart_thumb_wrap">';
    $onlyuser_class = REHub_Framework::get_option('wish_only_users');
    $loginurl = '';
    if($onlyuser_class == 1){
        if (is_user_logged_in()){
            $onlyuser_class = '';
        }
        else{
            if(REHub_Framework::get_option('custom_login_url')){
                $urllogin = REHub_Framework::get_option('custom_login_url');
                $loginurl = ' data-type="url" data-customurl="'.esc_url($urllogin).'"';
            }            
            $onlyuser_class = ' act-rehub-login-popup restrict_for_guests';
        }
    }else{
        $onlyuser_class = '';
    } 
    $outputtext = $wishlistpage = $wishlisted = '';
    if (REHub_Framework::get_option('wishlistpage') !=''){
        $wishlistpage = esc_url(get_the_permalink((int)REHub_Framework::get_option('wishlistpage')));
        $wishlisted = ' wishlisted';
    }
    if ($wishlistadd) {
        $outputtext .= '<span class="ml5 rtlmr5 wishaddwrap" id="wishadd'.$post_id.'">'; 
        $outputtext .= $wishlistadd.'</span>';        
    }  
    if ($wishlistadded) {
        $outputtext .= '<span class="ml5 rtlmr5 wishaddedwrap" id="wishadded'.$post_id.'">'; 
        $outputtext .= $wishlistadded.'</span>';        
    } 
    if ($wishlistremoved) {
        $outputtext .= '<span class="ml5 rtlmr5 wishremovedwrap" id="wishremoved'.$post_id.'">'; 
        $outputtext .= $wishlistremoved.'</span> ';        
    }     
    $output .= '<span class="flowhidden cell_wishlist">';   
        if ( RH_AlreadyWish( $post_id ) ) { // already liked, set up unlike addon
            $output .= '<span class="alreadywish heartplus'.$wishlisted.'" data-post_id="'.$post_id.'" data-informer="'.$temp.'" data-wishlink="'.$wishlistpage.'">'.$outputtext.'</span>';
        } else {
            $output .= '<span class="heartplus'.$onlyuser_class.'"'.$loginurl.' data-post_id="'.$post_id.'" data-informer="'.$temp.'">'.$outputtext.'</span>';
        }   
    $output .= '</span>';
    $output .= '<span id="wishcount'.$post_id.'" class="thumbscount'; 
    $output .= '">'.$temp.'</span> ';                
    $output .= '</div>';    

    return $output;
}
}

if (!function_exists('RH_AlreadyWish')){
function RH_AlreadyWish( $post_id ) { // test if user liked before
    
    if ( is_user_logged_in() ) { // user is logged in
        global $current_user;
        $user_id = $current_user->ID; // current user
        $meta_USERS = get_post_meta( $post_id, "_user_wished" ); // user ids from post meta
        $liked_USERS = ""; // set up array variable     
        if ( !empty($meta_USERS) && count( $meta_USERS ) != 0 ) { // meta exists, set up values
            $liked_USERS = $meta_USERS[0];
        }       
        if( !is_array( $liked_USERS ) ) // make array just in case
            $liked_USERS = array();         
        if ( in_array( $user_id, $liked_USERS ) ) { // True if User ID in array
            return true;
        }
        return false;       
    } 
    else { // user is anonymous, use IP address for voting  
        $meta_IPS = get_post_meta($post_id, "_userwish_IP"); // get previously voted IP address
        $ip = rh_framework_user_ip(); // Retrieve current user IP
        $liked_IPS = ""; // set up array variable
        if ( count( $meta_IPS ) != 0 ) { // meta exists, set up values
            $liked_IPS = $meta_IPS[0];
        }
        if ( !is_array( $liked_IPS ) ) // make array just in case
            $liked_IPS = array();
        if ( in_array( $ip, $liked_IPS ) ) { // True is IP in array
            return true;
        }
        return false;
    }   
}
}