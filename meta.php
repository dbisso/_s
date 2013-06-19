<?php
/**
 * @package _s
 * @since _s 1.0
 */
use Spliced\Theme\Underscores as T;
?>
<footer class="entry-meta">
	<?php
		/* translators: used between list items, there is a space after the comma */
		$category_list = get_the_category_list( __( ', ', '_s' ) );

		/* translators: used between list items, there is a space after the comma */
		$tag_list = get_the_tag_list( '', __( ', ', '_s' ) );

		if ( ! T\categorized_blog() ) {
			// This blog only has 1 category so we just need to worry about tags in the meta text
			if ( '' != $tag_list ) {
				$meta_text = __( 'Tags: %2$s.', '_s' );
			} else {
				$meta_text = '';
			}
		} else {
			// But this blog has loads of categories so we should probably display them here
			if ( '' != $tag_list ) {
				$meta_text = __( 'Posted in %1$s and tagged %2$s.', '_s' );
			} else {
				$meta_text = __( 'This entry was posted in %1$s.', '_s' );
			}
		} // end check for categories on this blog

		printf(
			$meta_text,
			$category_list,
			$tag_list,
			get_permalink(),
			the_title_attribute( 'echo=0' )
		);
	?>
	<?php if ( 'post' == get_post_type() ) : ?>
		<?php T\posted_on(); ?>
	<?php endif; ?>

	<?php edit_post_link( __( 'Edit', '_s' ), '<span class="edit-link">', '</span>' ); ?>
</footer><!-- .entry-meta -->