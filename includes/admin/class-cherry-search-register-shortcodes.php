<?php
/**
 * Registered plugins shortcodes.
 *
 * @package    Blank_Plugin
 * @subpackage Admin
 * @author     Cherry Team
 * @license    GPL-3.0+
 * @copyright  2012-2016, Cherry Team
 */

// If class `Cherry_Search_Register_Shortcodes` doesn't exists yet.
if ( ! class_exists( 'Cherry_Search_Register_Shortcodes' ) ) {

	/**
	 * Cherry_Search_Register_Shortcodes class.
	 */
	class Cherry_Search_Register_Shortcodes extends Cherry_Search_Settings {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var object
		 * @access private
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
			parent::__construct();
			cherry_search()->get_core()->init_module( 'cherry5-insert-shortcode', array() );

			$this->register_shortcodes();
		}

		/**
		 * Render plugin options page.
		 *
		 * @since 1.0.0
		 * @access private
		 * @return void
		 */
		private function register_shortcodes() {
			unset(
				$this->settings['change_standard_search'],
				$this->tabs['notices'],
				$this->tabs['submite_buttons'],
				$this->settings['negative_search'],
				$this->settings['server_error']
			);

			foreach ( $this->tabs as $key => $value ) {
				unset( $value['scroll'] );

				$this->tabs[ $key ] = $value;
			}

			if ( function_exists( 'cherry5_register_shortcode' ) ) {
				cherry5_register_shortcode(
					array(
						'title'       => esc_html__( 'Cherry Search', 'cherry-search' ),
						'icon'        => '<span class="dashicons dashicons-search"></span>',
						'slug'        => CHERRY_SEARCH_SLUG,
						'shortcodes'  => array(
							array(
								'title'       => esc_html__( 'Search Form', 'cherry-search' ),
								'icon'        => '<span class="dashicons dashicons-menu"></span>',
								'slug'        => 'cherry_search_form',
								'options'     => array_merge( $this->component_tab, $this->tabs, $this->settings ),
							),
						),
					)
				);
			}
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
	if ( ! function_exists( 'cherry_search_register_shortcodes' ) ) {

		/**
		 * Returns instanse of the plugin class.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		function cherry_search_register_shortcodes() {
			return Cherry_Search_Register_Shortcodes::get_instance();
		}

		cherry_search_register_shortcodes();
	}
}
