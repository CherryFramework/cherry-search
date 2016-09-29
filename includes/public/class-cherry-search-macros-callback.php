<?php
/**
 * Cherry search template macros callback.
 *
 * @package    Cherry_Search
 * @subpackage Admin
 * @author     Cherry Team
 * @license    GPL-3.0+
 * @copyright  2012-2016, Cherry Team
 */

// If class `Cherry_Search_Macros_Callback` doesn't exists yet.
if ( ! class_exists( 'Cherry_Search_Macros_Callback' ) ) {

	/**
	 * Cherry_Search_Macros_Callback class.
	 */
	class Cherry_Search_Macros_Callback {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @access private
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Plugin settings.
		 *
		 * @since 1.0.0
		 * @access private
		 * @var   array
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
		public function __construct( $args ) {
			$this->settings = $args;
			$this->template_manager = Cherry_Template_Manager::get_instance();
		}

		public function get_input() {
			$content = $this->template_manager->loader->get_template_by_name( 'search-form-input' );

			return $content;
		}

		public function get_submit() {
			$content = $this->template_manager->loader->get_template_by_name( 'search-form-submit' );

			return $content;
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return object
		 */
		public static function get_instance( $args = null ) {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self( $args );
			}

			return self::$instance;
		}

	}
}
