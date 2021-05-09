<?php
/**
* Header template.
*
* @package WordPress
* @subpackage Native Theme
* @since 1.0
*/

get_template_part('includes/head');
?>


<div id="container">	
	<header id="header" class="container">
	<?php if ( has_nav_menu( 'top' ) ) : ?>
		<nav>
			<a href="#nav-top" class="mobile toggle-nav"><?php _e('Navigation','native'); ?></a>
			<?php wp_nav_menu(array(
				'theme_location'  => 'top',
				'container'       => 'ul',
				'container_class' => 'clearfix',
				'container_id'    => 'nav-top',
				'after'           => '',
				'depth'           => 1,
				'walker'					=> ''
			)); ?>
		</nav><!-- .main-navigation -->
		<?php endif; ?>

		<div class="hgroup">
			<h1><a href="<?php echo esc_url(home_url()); ?>"><?php bloginfo('name'); ?></a></h1>
			<h2><?php bloginfo('description'); ?></h2>
		</div>
		
	</header>

	<?php $header_image = get_header_image();
	if ( ! empty( $header_image ) ) : ?>
	<figure class="header">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /></a>
	</figure>
	<?php endif; ?>
		
	<div class="container">
	<?php if ( has_nav_menu( 'main' ) ) : ?>
		<?php wp_nav_menu(array(
			'theme_location'  => 'main',
			'container'       => 'nav',
			'container_class' => 'clearfix',
			'container_id'    => 'nav',
			'before'					=> '<h2>',
			'after'						=> '</h2>',
			'walker'					=> '' // to add the menu description write "new Description_Walker" in place of '' into this line
		)); ?><!-- .main-navigation -->
		<?php endif; ?>
		
		<div id="wrapper" class="row clearfix">
		
			<section id="content">
