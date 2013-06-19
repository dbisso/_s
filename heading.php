<?php
/**
 * Headings for posts
 * @package _s
 * @since _s 1.0
 */
use Spliced\Theme\Underscores as T;
?>
<?php if ( is_singular() ): ?>
<header class="entry-header">
	<h1 class="entry-title"><?php the_title(); ?></h1>
</header><!-- .entry-header -->
<?php else : ?>
<header class="entry-header">
	<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', '_s' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
</header><!-- .entry-header -->
<?php endif ?>