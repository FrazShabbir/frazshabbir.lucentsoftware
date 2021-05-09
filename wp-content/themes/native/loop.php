<?php
/**
* Loop template.
*
* @package WordPress
* @subpackage Native Theme
* @since 1.0
*/
?>
	<?php
	// show navigation tools when possibile
	if ($wp_query->max_num_pages > 1) :
	?>
	<ul class="pagination">
		<li><?php posts_nav_link('</li>
		<li>&mdash;</li>
		<li>'); ?></li>
	</ul>
	<?php endif; ?>
	
	<?php
	if(is_archive()) {
		$page_title	= '<h1>' . sprintf(__('All post written in %s', 'native'), get_the_date('F Y')) . '</h1>';
			if(is_category()) {
				$page_title	= '<h1>' . sprintf(__('Category: %s', 'native'), single_cat_title('', false)) . '</h1>';
			} elseif(is_tag()) {
				$page_title	= '<h1>' . sprintf(__('Tag: %s', 'native'), single_tag_title('', false)) . '</h1>';
			} elseif(is_author()) {
				$page_title	= '<h1>' . sprintf(__('All post by %s', 'native'), get_the_author()) . '</h1>';
			}
	} elseif(is_search()) {
		$page_title	= '<h1>' . sprintf(__('Search results for %s', 'native'), get_search_query()) . '</h1>';
	} else {
		$page_title = '';	
	}
	?>

	<?php echo $page_title; ?>


	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	
	
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if(!is_attachment()) { ?>
		<header class="clearfix">
			<div class="date">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
					<span class="m"><?php echo get_the_time('M'); ?></span>
					<span class="d"><?php echo get_the_time('j'); ?></span>
					<span class="y"><?php echo get_the_time('Y'); ?></span>
				</a>
				</div>
			<div class="title">
				<h1><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php if(get_the_title() != '') { echo the_title(); } else { _e('- no title set -','native'); } ?></a></h1>
				<p>
					<span class="genericon author-post"><?php the_author_posts_link() ?></span>
					<a href="<?php the_permalink(); ?>#comments" title="<?php the_title_attribute(); ?>" class="genericon comments-post"><?php comments_number(__('No comments','native'), __('One comment','native'), __('% comments','native'));?></a>
				</p>
			</div>
		</header>
		<?php } ?>
		<?php if(has_post_thumbnail()) : ?>
		<figure class="cover">
			<?php the_post_thumbnail(); ?>
		</figure>
		<?php endif; ?>

		<?php
		// for archives and search results show the_excerpt
		if(is_archive() || is_search()) {
			the_excerpt();
		} else {
		// for all the rest
			the_content();
			wp_link_pages(array('before'=>'<p class="pagination">' . __('Pages:','native') . ' ','after'=>'</p>'));
		}; ?>

		
		<?php
		$format = get_post_format();
		get_template_part( 'format', $format );
		?>

		<footer>
			<div class="postmetadata">
				<?php if(has_category()) : ?><span class="genericon category-post"><?php the_category(', '); ?></span><?php endif; ?>
				<?php if(has_tag()) : ?><span class="genericon tag-post"><?php the_tags(' '); ?></span><?php endif; ?>
			</div>
		</footer>
	</article>
	
	<?php if(!is_attachment()) { ?>
		<?php comments_template('', true); ?>
	<?php } ?>
		
	<?php endwhile; else: ?>
	<div class="page">
		<h2><?php _e('Not found','native'); ?></h2>
		<p class="result info"><?php _e('Oh ops! This page seems to not exist. Try another.','native'); ?></p>
	</div>
	<?php endif; ?>

	<?php
	// show navigation tools when possibile
	if ($wp_query->max_num_pages > 1) :
	?>
	<ul class="pagination">
		<li><?php posts_nav_link('</li>
		<li>&mdash;</li>
		<li>'); ?></li>
	</ul>
	<?php endif; ?>