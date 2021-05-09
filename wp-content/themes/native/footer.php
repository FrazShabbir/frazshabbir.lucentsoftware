<?php
/**
* Footer template
*
* @package WordPress
* @subpackage Native Theme
* @since 1.0
*/
?>
			</section><!-- #content-->
			<?php get_sidebar(); ?>
		</div> <!--#wrapper-->
			
		<?php
		//hoook above footer
		//native_above_footer();
		
		//settare eventuale sidebar footer
		?>
	</div><!-- .container-->
</div> <!-- #container-->


<footer id="pre-footer">
	<?php get_sidebar('footer'); ?>
</footer>

<footer id="footer" class="clearfix">
	<p class="alignleft">Copyright &copy; <?php bloginfo('name'); ?><br>
	<?php bloginfo('description'); ?></p>
	<p class="alignright">
	<?php _e("Built on", "native");?> <a href="<?php _e("http://themes.designedby.it/native/", "native"); ?>" title="Native Parent Theme">Native Parent Theme</a></p>
</footer>
<?php
//hoook belove site
//native_belove_site();

?>


<a href="#" title="Torna su" id="backtop" class="rounded">^</a>

<?php get_template_part('includes/foot'); ?>