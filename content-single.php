<?php
/**
 * @package _s
 */
use Spliced\Theme\Underscores as T;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php get_template_part( 'heading', get_post_type() ); ?>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', '_s' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php get_template_part( 'meta', get_post_type() ) ?>

</article><!-- #post-<?php the_ID(); ?> -->
