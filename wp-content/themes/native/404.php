<?php
/**
* 404 page template.
*
* @package WordPress
* @subpackage Native Theme
* @since 1.0
*/

get_template_part('includes/head');
?>

<h3><?php bloginfo('name'); ?></h3>

<div class="container">

<div class="hgroup">
	<h1><?php _e('Oops!','native'); ?></h1>
	<h2><?php _e('Error 404! Page not found!','native'); ?></h2>
</div>

<section>
	<p><?php _e('You may search a new item down here...','native'); ?></p>
	<?php get_search_form(); ?>
	<p><?php _e('... or sail through navigation voices','native'); ?></p>
	<?php wp_nav_menu(array('depth' => 1)); ?>
</section>

</div>

<?php get_template_part('includes/foot'); ?>