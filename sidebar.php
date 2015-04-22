<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package _s
 */
use Spliced\Theme\Underscores as T;

?>
<div id="secondary" class="widget-area" role="complementary">
	<?php do_action( 'before_sidebar' ); ?>
	<?php dynamic_sidebar( 'sidebar-1' ) ?>
</div><!-- #secondary .widget-area -->