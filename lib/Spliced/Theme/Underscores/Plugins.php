<?php
namespace Spliced\Theme\Underscores;

use DBisso\Util\HookerInterface;

class Plugins {
	public static $hooker;

	public function __construct( HookerInterface $hooker ) {
		$hooker->hook( __CLASS__, $hooker->hook_prefix );
	}

	// -------------------------------------------
	// =Plugin: Bisso Flexslider
	// -------------------------------------------

	// public function filter_bisso_flexslider_class( array $classes ) {
	// 	//Remove copy styling from embedded sliders
	// 	if ( is_front_page() ) {
	// 		$classes[] = 'be-full-bp0';
	// 	}

	// 	$classes[] = 'copy-naked';

	// 	return $classes;
	// }

	// public function filter_bisso_flexslider_caption_class( array $classes ) {
	// 	$classes[] = 'stack-foreground';
	// 	$classes[] = 'skin-dark-crystal';
	// 	return $classes;
	// }

	// public function filter_bisso_flexslider_slide_class( array $classes ) {
	// 	$classes[] = 'stack';
	// 	$classes[] = 'slide';
	// 	return $classes;
	// }

	// public function filter_bisso_flexslider_post_types( array $post_types ) {
	// 	if ( is_front_page() ) $post_types[] = 'page';

	// 	return $post_types;
	// }

	// -------------------------------------------
	// END Plugin: Bisso Flexslider
	// -------------------------------------------

	// -------------------------------------------
	// =Plugin: WordPress SEO
	// -------------------------------------------

	// public function filter_option_wpseo_titles ( array $value ) {
	// 	$user = wp_get_current_user();

	// 	if ( in_array( 'site_admin', $user->roles ) ) {
	// 		foreach ( get_post_types() as $type ) {
	// 			$value['hideeditbox-' . $type] = 'on';
	// 		}
	// 	}

	// 	return $value;
	// }

	/**
	 * Yoast Breadcrumbs
	 */
	// public function filter_wpseo_breadcrumb_links ( $links ) {
	// 	global $query;
	// 	return $links;
	// }

	// -------------------------------------------
	// END Plugin: WordPress SEO
	// -------------------------------------------

	// -------------------------------------------
	// =Plugin: Posts 2 Posts
	// -------------------------------------------

	// public function action_p2p_init() {
	// 	p2p_register_connection_type( array(
	// 		'name'     => 'a_to_b',
	// 		'from'     => self:://posttype1,
	// 		'to'       => self:://posttype2,
	// 		'sortable' => 'to'
	// 	) );
	// }

	// public function filter_p2p_new_post_args ( array $args, \P2P_Directed_Connection_Type $ctype, $from  ) {
	// 	global $cfs;
	// 	return $args;
	// }

	// -------------------------------------------
	// END Plugin: Posts 2 Posts
	// -------------------------------------------

	// -------------------------------------------
	// =Plugin: Spliced Limit Attachments
	// -------------------------------------------

	// public function filter_spliced_limit_attachments ( $post_type ) {
	// 	$limits = array(
	// 		self:://posttype => //limit,
	// 	);

	// 	if ( in_array( (string) $post_type, array_keys( $limits ) ) ) return $limits[$post_type];
	// }

	// -------------------------------------------
	// END Plugin: Spliced Limit Attachements
	// -------------------------------------------

	// -------------------------------------------
	// =Plugin: Custom Field Suite
	// -------------------------------------------

	// public function filter_cfs_field_types( array $field_types ) {
	// 	$field_types['//field_name']     = get_stylesheet_directory() . '/inc/cfs-fields.php';
	// 	return $field_types;
	// }

	// -------------------------------------------
	// END Plugin: Custom Field Suite
	// -------------------------------------------
}