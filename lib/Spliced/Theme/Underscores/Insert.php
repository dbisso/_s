<?php
namespace Spliced\Theme\Underscores;

class Insert {
	static $_hooker;
	static $m;

	function bootstrap( $hooker = null ) {
		if ( $hooker ) {
			if ( !method_exists( $hooker, 'hook' ) )
				throw new \BadMethodCallException( 'Class ' . get_class( $hooker ) . ' has no hook() method.', 1 );

			self::$_hooker = $hooker;
			self::$_hooker->hook( __CLASS__, '_s' );
		} else {
			throw new \BadMethodCallException( 'Hooking class for theme not specified.' , 1 );
		}
	}

	function after_paragraph( $count, $content, $insertion ) {
		return self::insert_after_tag( 'p', $count, $content, $insertion );
	}

	function after_tag( $tag, $count, $content, $insertion ) {
		if ( !function_exists( 'mb_convert_encoding' ) ) {
			trigger_error( 'Function insert_after_paragraph requires the PHP mbstring extension' );
			return $content;
		}

		libxml_use_internal_errors( true ); // Hide HTML DOM errors
		$dom = new \DomDocument( '1.0', 'utf-8' );

		// Convert encoding to preserve entities
		if ( !empty( $content ) && $dom->loadHTML( mb_convert_encoding( (string) $content, 'HTML-ENTITIES', 'UTF-8' ) ) ) {
			$xp      = new \DOMXPath( $dom );
			$p_nodes = $xp->query( '//' . $tag );
			$count   = (int) $count;

			if ( $p_nodes->length > 0 ) {
				$nth_plus_one_p_node = $p_nodes->item( $count );

				if ( is_object( $nth_plus_one_p_node ) ) {
					// Create a new \DomDocument to hold out last image node
					$ins = new \DomDocument( '1.0', 'utf-8' );
					$ins->loadHTML( mb_convert_encoding( "<html><body>$insertion</body></html>", 'HTML-ENTITIES', 'UTF-8' ) );

					foreach ( $ins->getElementsByTagName( 'body' )->item( 0 )->childNodes as $key => $node ) {
						$ins_node = $dom->importNode( $node );
						$nth_plus_one_p_node->parentNode->insertBefore( $ins_node, $nth_plus_one_p_node );
					}
				}
			}

			return $dom->saveHTML();
		}
	}

	public function post_content( $slug ) {
		$post = self::include_post( $slug );
		if ( current_user_can( 'edit_post', $post->ID ) ) {
			$meta = '<span class="edit"><a class="post-edit-link" href="' . get_edit_post_link( $post->ID ) . '" title="' . sprintf( esc_attr__( 'Edit %1$s', '_s' ), $post_type->labels->singular_name ) . '">' . __( 'Edit', '_s' ) . '</a></span>';
		}

		if ( !empty( $meta )  ) $meta = '<p class="entry-meta">' . $meta . '</p>';

		return apply_filters( 'the_content' , $post->post_content ) . $meta;
	}

	/**
	 * Get a single, published post by its slug
	 *
	 * @param  string $slug Post slug (post_name)
	 * @return object       Post object
	 */
	public function include_post( $slug ) {
		static $posts = array();

		if ( isset( $posts[$slug] ) ) return $posts[$slug];

		$args = array(
		  'name' => $slug,
		  'post_status' => 'publish',
		  'post_type' => 'any',
		  'showposts' => 1,
		);

		$post = get_posts( $args );
		$post = $post[0];

		$posts[$slug] = $post;

		return $post;
	}
}



