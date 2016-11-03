<?php
/**
 * Sets up the plugin option page.
 *
 * @package    Cherry_Search
 * @subpackage Admin
 * @author     Cherry Team
 * @license    GPL-3.0+
 * @copyright  2012-2016, Cherry Team
 */

// If class `Cherry_Search_Settings_Page` doesn't exists yet.
if ( ! class_exists( 'Cherry_Search_Settings_Page' ) ) {

	/**
	 * Cherry_Search_Settings_Page class.
	 */
	class Cherry_Search_Settings_Page extends Cherry_Search_Settings {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var object
		 */
		private static $instance = null;

		/**
		 * Instance of the class Cherry_Interface_Builder.
		 *
		 * @since 1.0.0
		 * @var object
		 */
		private $builder = null;

		/**
		 * Class constructor.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function __construct() {
			$this->builder = cherry_search()->get_core()->modules['cherry-interface-builder'];

			parent::__construct();
			$this->render_page();
		}

		/**
		 * Build plugin options page.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function render_page( $render = true ) {

			$this->builder->register_form( $this->form );

			$this->builder->register_section( $this->section );

			$this->builder->register_component( $this->component_tab );

			$this->builder->register_settings( $this->tabs );

			$this->builder->register_html( $this->info );

			$this->builder->register_control( $this->settings );

			$this->builder->register_control( $this->buttons );

			$this->builder->render();
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
