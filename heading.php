<?php
/**
 * Headings for posts
 * @package _s
 * @since _s 1.0
 */
use Spliced\Theme\Underscores as T;
?>
<?php if ( is_single() ): ?>
<header class="entry-header">
	<h1 class="entry-title"><?php the_title(); ?></h1>

	<div class="entry-meta">
		<?php T\posted_on(); ?>
	</div><!-- .entry-meta -->
</header><!-- .entry-header -->
<?php else: ?>
<header class="entry-header">
	<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', '_s' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

	<?php if ( 'post' == get_post_type() ) : ?>
	<div class="entry-meta">
		<?php T\posted_on(); ?>
	</div><!-- .entry-meta -->
	<?php endif; ?>
</header><!-- .entry-header -->
<?php endif ?>