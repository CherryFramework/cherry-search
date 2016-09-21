<?php
/**
 * Cherry Search.
 *
 * @package    Cherry_Search
 * @subpackage Admin
 * @author     Cherry Team
 * @license    GPL-3.0+
 * @copyright  2012-2016, Cherry Team
 */

// If class `Cherry_Search` doesn't exists yet.
if ( ! class_exists( 'Cherry_Search' ) ) {

	/**
	 * Cherry_Search class.
	 */
	class Cherry_Search {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var object
		 */
		private static $instance = null;

		/**
		 * Class constructor.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function __construct() {
			$replace_search_flag = get_option( 'change_standard_search', true );

			if ( $replace_search_flag ) {
				add_filter( $tag, $function_to_add, 10, 1 );
			}
		}

		/**
		 * .
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function replace_standard_search() {

		}
		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return object
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}
	}
}

if ( ! function_exists( 'cherry_search' ) ) {

	/**
	 * Returns instanse of the plugin class.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	function cherry_search() {
		return Cherry_Search::get_instance();
	}

	cherry_search();
}
