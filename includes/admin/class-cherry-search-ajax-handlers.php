<?php
/**
 * Sets ajax handlers for page settings.
 *
 * @package    Cherry_Search
 * @subpackage Admin
 * @author     Cherry Team
 * @license    GPL-3.0+
 * @copyright  2012-2016, Cherry Team
 */

// If class `Cherry_Search_Ajax_Handlers` doesn't exists yet.
if ( ! class_exists( 'Cherry_Search_Ajax_Handlers' ) ) {

	/**
	 * Cherry_Search_Ajax_Handlers class.
	 */
	class Cherry_Search_Ajax_Handlers extends Cherry_Search_Settings {

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
			parent::__construct();

			$this->init_handlers();
		}

		/**
		 * Function inited module `cherry-handler`.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function init_handlers() {
			cherry_search()->get_core()->init_module(
				'cherry-handler' ,
				array(
					'id'           => 'cherry_search_save_setting',
					'action'       => 'cherry_search_save_setting',
					'capability'   => 'manage_options',
					'callback'     => array( $this , 'ajax_save_setting' ),
					'sys_messages' => array(
						'invalid_base_data' => esc_html__( 'Unable to process the request without nonche or server error', 'cherry-search' ),
						'no_right'          => esc_html__( 'No right for this action', 'cherry-search' ),
						'invalid_nonce'     => esc_html__( 'Stop CHEATING!!!', 'cherry-search' ),
						'access_is_allowed' => esc_html__( 'Options save successfully.','cherry-search' ),
					),
				)
			);

			cherry_search()->get_core()->init_module(
				'cherry-handler' ,
				array(
					'id'           => 'cherry_search_reset_setting',
					'action'       => 'cherry_search_reset_setting',
					'capability'   => 'manage_options',
					'callback'     => array( $this , 'ajax_reset_setting' ),
					'sys_messages' => array(
						'invalid_base_data' => esc_html__( 'Unable to process the request without nonche or server error', 'cherry-search' ),
						'no_right'          => esc_html__( 'No right for this action', 'cherry-search' ),
						'invalid_nonce'     => esc_html__( 'Stop CHEATING!!!', 'cherry-search' ),
						'access_is_allowed' => esc_html__( 'Options reset successfully','cherry-search' ),
					),
				)
			);
		}

		/**
		 * Handler for save settings option.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function ajax_save_setting() {
			if ( ! empty( $_POST['data'] ) ) {
				$this->save_setting( CHERRY_SEARCH_SLUG, $_POST['data'] );
			}
		}

		/**
		 * Handler for reset settings option to default.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return string
		 */
		public function ajax_reset_setting() {
			return $this->reset_setting();
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

if ( ! function_exists( 'cherry_search_ajax_handlers' ) ) {

	/**
	 * Returns instanse of the plugin class.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	function cherry_search_ajax_handlers() {
		return Cherry_Search_Ajax_Handlers::get_instance();
	}

	cherry_search_ajax_handlers();
}
