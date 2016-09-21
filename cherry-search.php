<?php
/**
 * Plugin Name: Cherry Search
 * Plugin URI:  http://www.cherryframework.com/
 * Description: A plugin for WordPress.
 * Version:     1.0.0
 * Author:      Cherry Team
 * Text Domain: cherry-search
 * License:     GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path: /languages
 *
 * @package Cherry_Search
 * @author  Cherry Team
 * @version 1.0.0
 * @license GPL-3.0+
 * @copyright  2012-2016, Cherry Team
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

// If class `Cherry_Search` doesn't exists yet.
if ( ! class_exists( 'Cherry_Search' ) ) {

	/**
	 * Sets up and initializes the Cherry Search.
	 */
	class Cherry_Search {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @access private
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * A reference to an instance of cherry framework core class.
		 *
		 * @since 1.0.0
		 * @access private
		 * @var   object
		 */
		private $core = null;

		/**
		 * Sets up needed actions/filters for the plugin to initialize.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function __construct() {
			// Set the constants needed by the plugin.
			$this->constants();

			// Internationalize the text strings used.
			add_action( 'plugins_loaded', array( $this, 'lang' ), 1 );

			// Load the admin files.
			add_action( 'plugins_loaded', array( $this, 'admin' ), 2 );

			// Load the installer core.
			add_action( 'after_setup_theme', require( trailingslashit( __DIR__ ) . 'cherry-framework/setup.php' ), 0 );

			// Load the core functions/classes required by the rest of the plugin.
			add_action( 'after_setup_theme', array( $this, 'get_core' ), 1 );

			// Laad the modules.
			add_action( 'after_setup_theme', array( 'Cherry_Core', 'load_all_modules' ), 2 );

			// Initialization of modules.
			add_action( 'after_setup_theme', array( $this, 'init_modules' ), 3 );

			// Register public assets.
			add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ), 10 );

			// Load public-facing StyleSheets.
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 11 );

			// Load public-facing JavaScripts.
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 12 );
		}

		/**
		 * Defines constants for the plugin.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function constants() {

			/**
			 * Set the version number of the plugin.
			 *
			 * @since 1.0.0
			 */
			define( 'CHERRY_SEARCH_VERSION', '1.0.0' );

			/**
			 * Set the slug of the plugin.
			 *
			 * @since 1.0.0
			 */
			define( 'CHERRY_SEARCH_SLUG', basename( dirname( __FILE__ ) ) );

			/**
			 * Set constant path to the plugin directory.
			 *
			 * @since 1.0.0
			 */
			define( 'CHERRY_SEARCH_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

			/**
			 * Set constant path to the plugin URI.
			 *
			 * @since 1.0.0
			 */
			define( 'CHERRY_SEARCH_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );
		}

		/**
		 * Loads the core functions. These files are needed before loading anything else in the
		 * plugin because they have required functions for use.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return object
		 */
		public function get_core() {

			/**
			 * Fires before loads the plugin's core.
			 *
			 * @since 1.0.0
			 */
			do_action( 'cherry_search_core_before' );

			global $chery_core_version;

			if ( null !== $this->core ) {
				return $this->core;
			}

			if ( 0 < sizeof( $chery_core_version ) ) {
				$core_paths = array_values( $chery_core_version );
				require_once( $core_paths[0] );
			} else {
				die( 'Class Cherry_Core not found' );
			}

			$this->core = new Cherry_Core( array(
				'base_dir' => CHERRY_SEARCH_DIR . 'cherry-framework',
				'base_url' => CHERRY_SEARCH_URI . 'cherry-framework',
				'modules'  => array(
					'cherry-js-core' => array(
						'autoload' => true,
					),
					'cherry-toolkit' => array(
						'autoload' => false,
					),
					'cherry-utility' => array(
						'autoload' => false,
					),
					'cherry-ui-elements' => array(
						'autoload' => false,
					),
					'cherry-interface-builder' => array(
						'autoload' => false,
					),
					'cherry-handler' => array(
						'autoload' => false,
					),
				),
			) );

			return $this->core;
		}

		/**
		 * Run initialization of modules.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function init_modules() {
			/*if ( is_admin() ) {

			}*/
		}

		/**
		 * Loads admin files.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function admin() {
			if ( is_admin() ) {
				require_once( CHERRY_SEARCH_DIR . 'includes/admin/class-cherry-search-admin.php' );
			}else{
				require_once( CHERRY_SEARCH_DIR . 'includes/public/class-cherry-search.php' );
			}
		}

		/**
		 * Loads the translation files.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function lang() {
			load_plugin_textdomain( 'cherry-search', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}

		/**
		 * Register assets.
		 *
		 * @since 1.0.0
		 */
		public function register_assets() {
			// Register stylesheets.
			wp_register_style( 'cherry-search', esc_url( CHERRY_SEARCH_URI . 'assets/css/min/cherry-search.min.css' ), array(), CHERRY_SEARCH_VERSION, 'all' );

			// Register JavaScripts.
			wp_register_script( 'cherry-search',esc_url( CHERRY_SEARCH_URI . 'assets/js/min/cherry-search.min.js' ), array( 'cherry-js-core' ), CHERRY_SEARCH_VERSION, true );
		}

		/**
		 * Enqueue public-facing stylesheets.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function enqueue_styles() {
			wp_enqueue_style( 'cherry-search' );
		}

		/**
		 * Enqueue public-facing JavaScripts.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function enqueue_scripts() {
			wp_enqueue_script( 'cherry-search' );
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
}

cherry_search();
