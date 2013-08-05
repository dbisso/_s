<?php
/**
 * Provides auto-hooking for filters, actions and shortcodes
 * @version 3.0.0
 * @author Dan Bissonnet <dan@danisadesigner.com>
 */
namespace DBisso\Util;

class Hooker {
	var $hooked_class;
	var $added_hooks = array();

	function __construct( $hooked_class = null, $hook_prefix = null ){
		// If a class is specified in the constructor, kick things off
		// otherwise we wait for the hook() method to be called.
		if ( $hooked_class ) $this->hook( $hooked_class, $hook_prefix );
	}

	public function hook( $hooked_class = null, $hook_prefix = null ) {
		$this->hooked_class = $hooked_class;
		$this->class_reflector = new \ReflectionClass( $this->hooked_class );

		$methods = $this->class_reflector->getMethods();

		foreach ( $methods as $method ) {
			$method_parts  = $this->parse_method_name( $method->name );

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

		return $this;
	}

	private function parse_method_name( $name ){
		$is_theme_hook = false;

		if ( preg_match( '|^(_?[^_]+_)(.*)$|', $name, $matches ) ) {
			$hook_type = trim( $matches[1], '_' ); //Methods prefixed with _ are always hooked
			$hook_name = $matches[2];

			if ( !in_array( $hook_type , array( 'action', 'filter', 'shortcode' ) ) ) return false;

			return compact( 'hook_type', 'hook_name' );
		}

		return false;
	}

	private function add_hook( $hook_type, $hook_name, $method_name, $priority = 10, $args = 99 ){
		if ( !in_array( $hook_type , array( 'action', 'filter', 'shortcode' ) ) ) return;

		switch ( $hook_type ) {
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

	public function get_hooks( $type = null ) {
		return $type ? $this->added_hooks[$type] : $this->added_hooks;
	}
}
