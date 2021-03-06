<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package _s
 */
use Spliced\Theme\Underscores as T;
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="inner">
			<div id="tertiary" class="widget-area" role="complementary">
				<?php do_action( 'before_sidebar' ); ?>
				<?php dynamic_sidebar( 'footer' ) ?>
			</div><!-- #secondary .widget-area -->
			<div class="site-info">
				<?php printf( __( 'Site by %1$s.', '_s' ), '<a href="http://spliced.co/" rel="designer">Spliced</a>' ); ?>
			</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon .site-footer -->
</div><!-- #page .hfeed .site -->

<?php wp_footer(); ?>

</body>
</html>