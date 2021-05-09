<?php
/**
* General settings NEEDED for theme
*
* @package WordPress
* @subpackage Native Theme
* @since 1.0
*/

// supports for languages
// @since Native 1.0
function native_setup() {
	load_theme_textdomain( 'native', FALSE, basename( dirname( __FILE__ ) ) . '/lang' );
	// set content default width
	// @since Native 1.0
	if (!isset($content_width)) $content_width = 960;
	
	// set visual editor
	// @since Native 1.0
	add_editor_style('assets/css/editor_style.css');
	
	// add special theme supports
	// @since Native 1.0
	
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');
		
	add_theme_support('custom-header', array(
		'default-image'          => '',
		'random-default'         => true,
		'width'                  => 1200, //960,
		'height'                 => 313, //250,
		'flex-height'            => false,
		'flex-width'             => false,
		'default-text-color'     => '000',
		'header-text'            => false,
		'uploads'                => true,
		'wp-head-callback'       => '',
		'admin-head-callback'    => '',
		'admin-preview-callback' => ''
	));
	
	add_theme_support('custom-background', array(
		'default-color'          => 'FFFFFF',
		'default-image'          => '',
		'wp-head-callback'       => '_custom_background_cb',
		'admin-head-callback'    => '',
		'admin-preview-callback' => ''
	));
	
	add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));

	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(300,250,true);
	
	add_theme_support('automatic-feed-links');
	
	/***** NAVIGATION *****/
	// menu generation
	// @since Native 1.0
	register_nav_menus(array(
		'top' => __('Top menu','native'),
		'main' => __('Main menu','native'),
	));
}
add_action('after_setup_theme', 'native_setup');


/***** STYLESHEETS *****/
// sets stylesheets used in the theme and appropriated path
// wp_enqueue_style( $handle, $src, $deps, $ver, $media );
// @since Native 1.0
if (!function_exists('native_styles')) {
	function native_styles() {
	
		// used to set optional controls for IE
		//global $wp_styles;
	
		// main style - default style css of wordpress, if you want to use this just uncomment it :)
		//wp_enqueue_style('style', get_stylesheet_uri());
		
		// load reset.css
		wp_enqueue_style('reset', get_template_directory_uri() . '/assets/css/reset.css', '', '', 'screen');
		
		// load common.css
		wp_enqueue_style('common', get_template_directory_uri() . '/assets/css/common.css', '', '1.0', 'screen');

		// load custom.css
		wp_enqueue_style('custom', get_template_directory_uri() . '/assets/css/custom.css', '', '1.0', 'screen');
		
		// load validate.css
		wp_enqueue_style('validate', get_template_directory_uri() . '/assets/css/validate.css', '', '1.0', 'screen');
		
		// load ie.css
		// wp_enqueue_style('ie', get_template_directory_uri() . '/assets/css/ie.css', '', '', 'screen');
		// $wp_styles->add_data( 'ie', 'conditional', 'lte IE 7' );
	
	}

	// Register with hook 'wp_enqueue_scripts', which can be used for front end CSS and JavaScript
	add_action('wp_enqueue_scripts', 'native_styles');
}

/***** JAVASCRIPTS *****/
// sets stylesheets used in the theme and appropriated path
// wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer )
// @since Native 1.0
if (!function_exists('native_js')) {
	function native_js() {

		/*
		* Adds JavaScript to pages with the comment form to support
		* sites with threaded comments (when in use).
		*/
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
		
		// loads jquery from online source
		wp_enqueue_script('jq', 'http://code.jquery.com/jquery.js');
		
		// load modernizr.js
		wp_enqueue_script('modernizr', get_template_directory_uri() . '/assets/js/modernizr.js');
		
		// load functions.js
		wp_enqueue_script('js-functions', get_template_directory_uri() . '/assets/js/functions.js');
		
		// load jquery.fitvids.js
		wp_enqueue_script('jq-fixvid', get_template_directory_uri() . '/assets/js/jquery.fitvids.js',array('jq'),'',true);

		// load fitvids.js
		wp_enqueue_script('fixvid', get_template_directory_uri() . '/assets/js/fitvids.js',array('jq','jq-fixvid'),'',true);

	?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5shiv.js"></script>
<![endif]-->
<!--[if IE]>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/excanvas.js"></script>
<![endif]-->
	<?php
	
	}
	
	add_action('wp_enqueue_scripts', 'native_js');
}

/***** WP TITLE *****/
// wp title style
// @since Native 1.0
//if (is_home () ) { bloginfo('name'); } elseif (is_category() || is_tag()) { single_cat_title(); } elseif (is_single() || is_page()) { single_post_title(); } else { wp_title('',true); }

function native_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'native' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'native_wp_title', 10, 2 );

/***** SIDEBARS *****/
// sidebars generation
// @since Native 1.0
function native_widgets() {
	register_sidebar(array(
		'name' => __('Right Hand Sidebar','native'),
		'id' => 'right-sidebar',
		'description' => __('Widgets in this area will be shown on the right-hand side.','native'),
		'before_title' => '<h1>',
		'after_title' => '</h1>'
	));
	register_sidebar(array(
		'name' => __('Footer left Sidebar','native'),
		'id' => 'footer-left-sidebar',
		'description' => __('Widgets in this area will be shown on the footer in the left side.','native'),
		'before_title' => '<h1>',
		'after_title' => '</h1>'
	));
	register_sidebar(array(
		'name' => __('Footer center Sidebar','native'),
		'id' => 'footer-center-sidebar',
		'description' => __('Widgets in this area will be shown on the footer in the center.','native'),
		'before_title' => '<h1>',
		'after_title' => '</h1>'
	));
	register_sidebar(array(
		'name' => __('Footer right Sidebar','native'),
		'id' => 'footer-right-sidebar',
		'description' => __('Widgets in this area will be shown on the footer in the right side.','native'),
		'before_title' => '<h1>',
		'after_title' => '</h1>'
	));
}
add_action('widgets_init','native_widgets');

if (!function_exists('native_comments')) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own native_comments(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Native 1.0
 */
function native_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'native' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'native' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class('clearfix'); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf('<cite class="fn">%1$s %2$s</cite>',
						// If current post author is also comment author, make it known visually.
						($comment->user_id === $post->post_author) ? '<span> ' . __('Post author', 'native') . '</span>' : '',
						get_comment_author_link()
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'native'); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php
					printf( ' <a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'native' ), get_comment_date(), get_comment_time() )
					);
				?>
				<?php comment_text(); ?>
				<?php edit_comment_link( __('Edit', 'native'), '<p class="edit-link">', '</p>'); ?>
			</section><!-- .comment-content -->

			<div class="reply clearfix">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'native' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

if (!function_exists('native_style_404')) {
	function native_style_404() {
	
		$header_image = get_header_image();
		
		if (!empty($header_image)) { ?>
		
		<style type="text/css">
			BODY.error404 {background-image:url(<?php echo esc_url( $header_image ); ?>)!important; background-position:center top!important; background-size:contain; background-repeat:no-repeat!important; background-attachment:fixed!important;}
			BODY.error404 .container { margin-top:250px;}
			@media screen and (max-width: 480px) {
				BODY.error404 { background-size:auto 100px!important;}
				BODY.error404 H3 { background-color:rgba(51,51,51,0.5); }
				BODY.error404 .container { margin-top:100px; }			
			}
		</style>
		
		<?php
		}
	
	}
	
	add_action('wp_head', 'native_style_404');
}