<?php
/**
 * Provides auto-hooking for filters, actions and shortcodes
 * @version 3.1.0
 * @author Dan Bissonnet <dan@danisadesigner.com>
 */
namespace DBisso\Util;

/**
 * \DBisso\Util\Hooker
 */
class Hooker {
	/**
	 * Reference to the class that is being parsed for hooks
	 * @var stdClass the Class object
	 */
	public $hooked_class;

	/**
	 * Stores a list of each method that has been hooked
	 * @var array
	 */
	public $added_hooks  = array();

	/**
	 * String to replace 'theme_' with in methods. Allows for
	 * namespacing of hooks for themes or plugins
	 *
	 * @var string
	 */
	public $hook_prefix;

	/**
	 * Array of prefixed 'theme hooks'. These methods are prefixed with 'theme_'
	 * which is replaced by the optional $hook_prefix property
	 *
	 * These are added at 'after_setup_theme' with a priority of 12
	 *
	 * @var array Theme prefixed hooks
	 */
	private $theme_hooks = array();

	/**
	 * Constructor method
	 * If a hooked class is specified then hook it automatically
	 *
	 * @param mixed  $hooked_class A class to hook
	 * @param string $hook_prefix  Optional hook prefix
	 */
	function __construct( $hooked_class = null, $hook_prefix = '' ){
		// If a class is specified in the constructor, kick things off
		// otherwise we wait for the hook() method to be called.
		if ( $hooked_class ) $this->hook( $hooked_class, $hook_prefix );
	}

	/**
	 * Parses the methods and kicks of the hooking process
	 * @param  stdClass $hooked_class The class being hooked
	 * @param  string   $hook_prefix  Optional prefix for custom theme or plugin hooks
	 * @return Hooker                 Returns the instance of the hooker class
	 */
	public function hook( $hooked_class = null, $hook_prefix = '' ) {
		$this->hooked_class = $hooked_class;
		$this->hook_prefix = $hook_prefix;
		$this->class_reflector = new \ReflectionClass( $this->hooked_class );

		$methods = $this->class_reflector->getMethods();

		foreach ( $methods as $method ) {
			$method_parts  = $this->parse_method_name( $method->name );

			// This method is not for hooking
			if ( !$method_parts )
				continue;

			$method_reflector = $this->class_reflector->getMethod( $method->name );
			$statics          = $method_reflector->getStaticVariables();
			$defaults         = array(
				'wp_hook_override' => $method_parts['hook_name'],
				'wp_hook_priority' => 10,
				'wp_hook_args' => 99,
				'hook_type' => $method_parts['hook_type'],
				'method' => $method->name,
			);

			$hook_data = array_merge( $defaults, $statics );

			if ( isset( $hook_data['wp_shortcode_name'] ) ) {
				$hook_data['wp_shortcode_name'] = preg_replace( '|_|', '-', $hook_name );
			}

			if ( $hook_data ){
				extract( $hook_data );

				$this->add_hook( $hook_type, $wp_hook_override, $method, $wp_hook_priority, $wp_hook_args );
			}
		}

		add_action( 'after_setup_theme', array( $this, 'add_theme_hooks' ), 12 );

		return $this;
	}

	/**
	 * Parse the method name to determine how to handle it
	 * @param  string $name Method name
	 * @return mixed        Array of hook type (action/filter/theme/shortcode)
	 *                      or false if not a valid hook method
	 */
	private function parse_method_name( $name ){
		if ( preg_match( '|^(_?[^_]+_)(.*)$|', $name, $matches ) ) {
			$hook_type = trim( $matches[1], '_' ); //Methods prefixed with _ are always hooked
			$hook_name = $matches[2];

			if ( !in_array( $hook_type , array( 'theme', 'action', 'filter', 'shortcode' ) ) ) return false;

			return compact( 'hook_type', 'hook_name' );
		}

		return false;
	}

	/**
	 * Adds the action / filter / shortcode using the appropriate function
	 * Theme hooks are deferred until after_setup_theme which calls this method again
	 *
	 * @param string  $hook_type   The hook type: theme|action|filter|shortcode
	 * @param string  $hook_name   The actual name of the hook
	 * @param string  $method_name The method name to be used as a callback
	 * @param integer $priority    The hook priority
	 * @param integer $args        The number of args
	 */
	private function add_hook( $hook_type, $hook_name, $method_name, $priority = 10, $args = 99 ){
		if ( !in_array( $hook_type , array( 'theme', 'action', 'filter', 'shortcode' ) ) ) return;

		switch ( $hook_type ) {
			case 'theme':
				$this->theme_hooks[] = array( $hook_name, $method_name, $priority, $args );
				break;
			case 'action':
				add_action( $hook_name , array( $this->hooked_class, $method_name ), $priority, $args );
				break;
			case 'filter':
				add_filter( $hook_name, array($this->hooked_class, $method_name), $priority, $args );
				break;
			case 'shortcode':
 				add_shortcode( preg_replace( '|_|', '-', $hook_name ), array( $this->hooked_class, $method_name ) );
				break;
		}

		$this->added_hooks[$hook_type][$hook_name][$priority][] = $method_name;
	}

	/**
	 * Adds any deffered theme hooks, prefixing them with $hook_prefix
	 *
	 * @return void
	 */
	public function add_theme_hooks(){
		if ( empty( $this->theme_hooks ) )
			return;

		try {
			$hook_prefix = isset( $this->hook_prefix ) ? $this->hook_prefix : $this->class_reflector->getStaticPropertyValue( 'wp_hook_prefix' );

			foreach ( $this->theme_hooks as $theme_hook ) {
				$method_parts = $this->parse_method_name( $theme_hook[0] );

				$args = array(
					$method_parts['hook_type'],
					"{$hook_prefix}_{$method_parts['hook_name']}",
					"theme_{$theme_hook[0]}",
					$theme_hook[2],
					$theme_hook[3],
				);

				call_user_method_array( 'add_hook', $this, $args );
			}
		} catch ( Exception $e ) {}
	}

	/**
	 * Getter function to retrieve added hooks
	 * @param  string $type Filter to only retrieve one type of filter
	 * @return array        Array of filters
	 */
	public function get_hooks( $type = null ) {
		return $type ? $this->added_hooks[$type] : $this->added_hooks;
	}
}
