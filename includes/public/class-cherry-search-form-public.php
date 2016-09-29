<?php
/**
 * Cherry Search.
 *
 * @package    Cherry_Search_Form_Public
 * @subpackage Admin
 * @author     Cherry Team
 * @license    GPL-3.0+
 * @copyright  2012-2016, Cherry Team
 */

// If class `Cherry_Search_Form_Public` doesn't exists yet.
if ( ! class_exists( 'Cherry_Search_Form_Public' ) ) {

	/**
	 * Cherry_Search_Form_Public class.
	 */
	class Cherry_Search_Form_Public{

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var object
		 */
		private static $instance = null;

		/**
		 * Plugin settings.
		 *
		 * @since 1.0.0
		 * @var array
		 */
		private $settings = null;

		/**
		 * Module сherry template мanager.
		 *
		 * @since 1.0.0
		 * @var object
		 */
		private $template_manager = null;

		/**
		 * Class constructor.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function __construct() {
			$this->template_manager = Cherry_Template_Manager::get_instance();

			$this->settings = $this->get_setting( 'change_standard_search' );
			$change_standard_search = filter_var( $this->settings[ 'change_standard_search' ], FILTER_VALIDATE_BOOLEAN );

			if ( $change_standard_search ) {
				add_filter( 'get_search_form', array( $this, 'build_search_form' ), 10, 1 );
			}
		}

		/**
		 * Get plugin setting.
		 *
		 * @since 1.0.0
		 * @access private
		 * @return array
		 */
		private function get_setting() {
			$settings = get_option( CHERRY_SEARCH_SLUG, false );

			if ( ! $settings ) {
				$settings = get_option( CHERRY_SEARCH_SLUG . '-default', false );
			}

			return $settings;
		}

		/**
		 * .
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function build_search_form( $search_form = null ) {
			return $this->template_manager->parser->parsed_template( 'search-form', Cherry_Search_Macros_Callback::get_instance( $this->settings ) );
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

if ( ! function_exists( 'cherry_search_form_public' ) ) {

	/**
	 * Returns instanse of the plugin class.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	function cherry_search_form_public() {
		return Cherry_Search_Form_Public::get_instance();
	}
	cherry_search_form_public();
}

if ( ! function_exists( 'ge_cherry_search_form' ) ) {

	/**
	 * Returns search form html.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	function get_cherry_search_form() {
		return cherry_search_form_public()->build_search_form();
	}
}
