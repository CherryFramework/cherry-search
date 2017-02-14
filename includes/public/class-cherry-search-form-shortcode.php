<?php
/**
 * Cherry Search shortcode.
 *
 * @package    Cherry_Search
 * @subpackage Admin
 * @author     Cherry Team
 * @license    GPL-3.0+
 * @copyright  2012-2016, Cherry Team
 */

// If class `Cherry_Search_Shortcode` doesn't exists yet.
if ( ! class_exists( 'Cherry_Search_Shortcode' ) ) {
	/**
	 * Cherry_Search_Shortcode class.
	 */
	class Cherry_Search_Shortcode {

		/**
		 * Shortcode name.
		 *
		 * @since 1.0.0
		 * @var   string
		 */
		private $name = 'cherry_search_form';

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var object
		 */
		private static $instance = null;

		/**
		 * Sets up our actions/filters.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function __construct() {
			// Register shortcode on 'init'.
			add_action( 'init', array( $this, 'register_shortcode' ) );
		}

		/**
		 * Registers the [$this->name] shortcode.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function register_shortcode( $search_form ) {
			/**
			 * Filters a shortcode name.
			 *
			 * @since 1.0.0
			 * @param string $this->name Shortcode name.
			 */

			add_shortcode( $this->name, array( $this, 'do_shortcode' ) );
		}

		/**
		 * The shortcode function.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return string
		 */
		public function do_shortcode( $args = array(), $content = null, $shortcode = '' ) {
			return cherry_get_search_form( false, $args );
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

if ( ! function_exists( 'cherry_search_form_shortcode' ) ) {

	/**
	 * Returns instanse of the plugin class.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	function cherry_search_form_shortcode() {
		return Cherry_Search_Shortcode::get_instance();
	}

	cherry_search_form_shortcode();
}
