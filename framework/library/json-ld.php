<?php
/**
 * JSON-LD handler.
 *
 * @package Designer-Library
 * @since 2.2.0
 */

namespace Designer\Framework\Library;

class Json_Ld{

	/**
	 * The JSON formatted as a PHP array
	 *
	 * @static
	 * @access public
	 * @var array
	 */
	public static $params = [];

	/**
	 * Constructor.
	 *
	 * @access public
	 * @param string $context An ID for this constructor. All common contexts will be grouped on output.
	 * @param array  $params  An array of params we want in the JSON-LD.
	 */
	public function __construct( $context, $params ) {

		// Add params.
		$this->add_params( $context, $params );

		// Print JSON-LD in the footer.
		add_action( 'wp_footer', [ $this, 'print_json' ], 110 );
	}

	/**
	 * Adds the items to the current context, removing duplicates.
	 *
	 * @access public
	 * @since 2.2.0
	 * @param string $context The context (ID).
	 * @param array  $params  An array of parameters.
	 * @return void
	 */
	public function add_params( $context, $params ) {

		// Make sure context exists.
		if ( ! isset( self::$params[ $context ] ) ) {
			self::$params[ $context ] = [];
		}

		foreach ( $params as $key => $val ) {
			if ( is_array( $val ) ) {
				if ( ! isset( self::$params[ $context ][ $key ] ) ) {
					self::$params[ $context ][ $key ] = $val;
				} else {
					self::$params[ $context ][ $key ] = array_merge_recursive( (array) self::$params[ $context ][ $key ], $val );
				}
				self::$params[ $context ][ $key ] = array_intersect_key(
					self::$params[ $context ][ $key ],
					array_unique( array_map( 'serialize', self::$params[ $context ][ $key ] ) )
				);
			} else {
				self::$params[ $context ][ $key ] = $val;
			}
		}
	}

	/**
	 * Prints the JSON-LD scripts.
	 *
	 * @access public
	 * @since 2.2.0
	 */
	public function print_json() {
		if ( empty( self::$params ) ) {
			return;
		}

		foreach ( self::$params as $context => $args ) {
			echo '<script type="application/ld+json">';
			echo wp_json_encode( $args );
			echo '</script>';

			// Unset the context to avoid loops.
			unset( self::$params[ $context ] );
		}
	}
}
