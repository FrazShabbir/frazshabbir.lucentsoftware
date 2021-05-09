<?php
/**
* The Footer widget areas.
*
* @package WordPress
* @subpackage Native Theme
* @since 1.0
*/
?>
<?php if(!dynamic_sidebar() && (is_active_sidebar( 'footer-left-sidebar') || is_active_sidebar( 'footer-center-sidebar') || is_active_sidebar( 'footer-right-sidebar'))) : ?>
<section class="footer clearfix">
	<?php if(is_active_sidebar( 'footer-left-sidebar')) : ?>
	<ul>
		<?php dynamic_sidebar('footer-left-sidebar'); ?>
	</ul>
	<?php endif; ?>
	<?php if(is_active_sidebar( 'footer-center-sidebar')) : ?>
	<ul>
		<?php dynamic_sidebar('footer-center-sidebar'); ?>
	</ul>
	<?php endif; ?>
	<?php if(is_active_sidebar( 'footer-right-sidebar')) : ?>
	<ul>
		<?php dynamic_sidebar('footer-right-sidebar'); ?>
	</ul>
	<?php endif; ?>
</section>
<?php endif; ?>