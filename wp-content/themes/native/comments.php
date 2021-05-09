<?php
/**
* Comments template.
*
* @package WordPress
* @subpackage Native Theme
* @since 1.0
*/
?>

<section class="comments">
	<?php
	if ( post_password_required() ) { ?>
		<p class="result info"><?php _e("This post is password protected. Enter the password to view comments.", "native"); ?></p>
	<?php
		echo("</section>");
		return;
	}
	?>
	
	<?php if (have_comments()) : ?>
	<h4 id="comments"><?php comments_number(__('No comments','native'), __('One comment','native'), __('% comments','native'));?></h4>
	<ol class="commentlist">
	<?php wp_list_comments(array('callback' => 'native_comments', 'style' => 'ol')); ?>
	</ol>
	
	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
	
	<?php else : // this is displayed if there are no comments so far ?>
		<?php if ( comments_open() ) :
			// If comments are open, but there are no comments.
		?>
			<p class="result info"><?php _e('No comments yet. Be the first to leave a comment.', 'native'); ?></p>
		<?php
		else : // comments are closed
			if (!is_page()) :
		?>
		<p class="result info"><?php _e('Comments are closed.', 'native'); ?></p>
		<?php
			endif;
		endif;
	endif; ?>

	<?php comment_form(); ?>
</section>

