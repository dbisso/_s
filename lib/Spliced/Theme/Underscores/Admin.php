<?php
namespace Spliced\Theme\Underscores;

class Admin {
	static $hooker;

	public function bootstrap( $hooker = null ) {
		if ( ! $hooker || ! method_exists( $hooker, 'hook' ) )
			throw new \BadMethodCallException( 'Bad Hooking Class. Check that \DBisso\Util\Hooker is loaded.', 1 );

		self::$hooker = $hooker->hook( __CLASS__, $hooker->hook_prefix );
	}

	function action_admin_enqueue_scripts() {}

	public function filter_custom_menu_order() {
		return true;
	}

	/**
	 * Hide certain admin menus for site admins
	 * @param  array  $menu_order current admin menu items
	 * @return array  Filtered menu items
	 */
	function filter_admin_menu() {
		global $menu, $submenu;
		static $wp_hook_priority = 13;

		remove_menu_page( 'link-manager.php' );

		$user = wp_get_current_user();

		$hidden_menus = array(
			'woodojo',
			'wpseo_dashboard',
			'edit.php?post_type=cfs',
			'edit-comments.php',
			'themes.php',
			'tools.php',
			'link-manager.php',
		);

		$hidden_options = array(
			'options-media.php',
			'options-permalink.php',
			'options-reading.php',
			'options-writing.php',
			'google-analytics-for-wordpress',
			'members-settings',
			'widget-css-classes-settings',
		);

		if ( in_array( 'site_admin', $user->roles ) ) {
			foreach ( $menu as $key => $menu_item ) {
				remove_menu_page( $menu_item );
			}

			foreach ( $hidden_options as $submenu_slug ) {
				remove_submenu_page( 'options-general.php', $submenu_slug );
			}
		}

		return $menu_order;
	}

	function action_wp_dashboard_setup() {
		wp_add_dashboard_widget( 'spliced_welcome', 'Welcome to your site', array( __CLASS__, 'widget_dashboard_welcome' ) );
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );

		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	}

	function widget_dashboard_welcome() {
		$user = wp_get_current_user();
		?>
		<h4>Hello <?php echo esc_html( get_user_meta( $user->id, 'nickname', true ) ) ?>,</h4>
		<p>Welcome to your site, built by <a href="http://spliced.co">Spliced Digital</a>.</p>
		<p>The site is currently under development so elements of the admin area may change, but feel free to explore the different areas.</p>
		<p>For example, try adding some temporary content if you like. (NB: it may get overridden during further development updates).</p>
		<p>If you have any questions, just <a href="mailto:admin@spliced.co">let us know</a></p>
		<p>Spliced Digital</p>
		<?php
	}
}