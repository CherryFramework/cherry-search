<?php
/**
 * Sets up the admin functionality for the plugin.
 *
 * @package    Cherry_Search
 * @subpackage Admin
 * @author     Cherry Team
 * @license    GPL-3.0+
 * @copyright  2012-2016, Cherry Team
 */

// If class `Cherry_Search_Admin` doesn't exists yet.
if ( ! class_exists( 'Cherry_Search_Admin' ) ) {

	/**
	 * Cherry_Search_Admin class.
	 */
	class Cherry_Search_Admin {

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

			// Initialization of modules.
			$this->init_modules();

			// Include libraries from the `includes/admin`
			add_action( 'init', array( $this, 'includes' ), 9999 );

			// Load the admin menu.
			add_action( 'admin_menu', array( $this, 'menu' ) );

			// Load admin stylesheets.
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );

			// Load admin JavaScripts.
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

			// Set default options
			add_action( 'admin_init', array( $this, 'set_default_settings' ) );
		}

		/**
		 * Include libraries from the `includes/admin`.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function includes() {

			// Include plugin settings and ajax handlers.
			require_once( trailingslashit( CHERRY_SEARCH_DIR ) . 'includes/admin/class-cherry-search-settings.php' );
			require_once( trailingslashit( CHERRY_SEARCH_DIR ) . 'includes/admin/class-cherry-search-ajax-handlers.php' );

			// Include plugin pages.
			require_once( trailingslashit( CHERRY_SEARCH_DIR ) . 'includes/admin/pages/class-cherry-search-settings-page.php' );

			// Include plugin shortcode.
			require_once( trailingslashit( CHERRY_SEARCH_DIR ) . 'includes/admin/class-cherry-search-register-shortcodes.php' );
		}

		/**
		 * Register the admin menu.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function menu() {
			global $submenu;

			add_menu_page(
				esc_html__( 'Cherry Search', 'cherry-search' ),
				esc_html__( 'Cherry Search', 'cherry-search' ),
				'edit_theme_options',
				'cherry-search',
				'',
				'dashicons-search',
				100
			);

			add_submenu_page(
				'cherry-search',
				esc_html__( 'Settings', 'cherry-search' ),
				esc_html__( 'Settings', 'cherry-search' ),
				'edit_theme_options',
				'cherry-search-settings-page',
				array( 'Cherry_Search_Settings_Page', 'get_instance' )
			);

			unset( $submenu['cherry-search'][0] );
		}

		/**
		 * Write default settings to database.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function set_default_settings() {
			$cherry_search_settings = Cherry_Search_Settings::get_instance();
			$cherry_search_settings -> set_default_settings();
		}

		/**
		 * Check current plugin page.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return bool
		 */
		public static function is_plugin_page() {
			$screen = get_current_screen();

			return ( ! empty( $screen->base ) && false !== strpos( $screen->base, CHERRY_SEARCH_SLUG ) ) ? true : false ;
		}

		/**
		 * Run initialization of modules.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function init_modules() {
			cherry_search()->get_core()->init_module( 'cherry-utility', array() );
			cherry_search()->get_core()->init_module( 'cherry-interface-builder', array() );
		}
		/**
		 * Enqueue admin stylesheets.
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  string $hook The current admin page.
		 * @return void
		 */
		public function enqueue_styles( $hook ) {
			if ( self::is_plugin_page() ) {
				wp_enqueue_style(
					'cherry-search-admin',
					esc_url( CHERRY_SEARCH_URI . 'assets/admin/css/min/cherry-search-admin.min.css' ),
					array(), CHERRY_SEARCH_VERSION,
					'all'
				);
			}
		}

		/**
		 * Enqueue admin JavaScripts.
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  string $hook The current admin page.
		 * @return void
		 */
		public function enqueue_scripts( $hook ) {
			if ( self::is_plugin_page() ) {
				wp_enqueue_script(
					'cherry-search-admin',
					esc_url( CHERRY_SEARCH_URI . 'assets/admin/js/min/cherry-search-admin.min.js' ),
					array( 'cherry-js-core', 'cherry-handler-js' ),
					CHERRY_SEARCH_VERSION,
					true
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

}

if ( ! function_exists( 'cherry_search_admin' ) ) {

	/**
	 * Returns instanse of the plugin class.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	function cherry_search_admin() {
		return Cherry_Search_Admin::get_instance();
	}

	cherry_search_admin();
}
