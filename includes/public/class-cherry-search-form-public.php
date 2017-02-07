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
	class Cherry_Search_Form_Public extends Cherry_Search_Settings_Manager {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private static $instance = null;

		/**
		 * Module сherry template мanager.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private $template_manager = null;

		/**
		 * Service messages.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private $messages = array();

		/**
		 * Search button icon.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private $search_button_icon = false;

		/**
		 * Class constructor.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function __construct() {
			add_action( 'pre_get_posts', array( $this, 'set_search_query' ) );

			$change_standard_search   = filter_var( $this->get_setting( 'change_standard_search' ), FILTER_VALIDATE_BOOLEAN );
			$this->search_button_icon = $this->get_setting( 'search_button_icon' );

			if ( $change_standard_search ) {
				add_filter( 'get_search_form', array( $this, 'build_search_form' ), 0 );
				add_filter( 'get_product_search_form', array( $this, 'build_search_form' ), 11 );
			}
		}

		/**
		 * Trigger function set_query_settings.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function set_search_query( $query ) {
			if ( ! is_admin() && $query->is_search ) {
				$this->set_query_settings();
				$query->query_vars = array_merge( $query->query_vars, $this->search_query );
			}
		}

		/**
		 * Build Search Sorm.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return string
		 */
		public function build_search_form( $search_form = null ) {
			if ( null === $this->template_manager ) {
				$this->template_manager = new Cherry_Template_Manager( cherry_search()->get_core() );
			}

			$this->messages['serverError'] = esc_html( $this->get_setting( 'server_error' ) );

			// Load public-facing StyleSheets.
			$this->enqueue_styles();

			add_action( 'get_footer', array( $this, 'set_css_style' ) );
			add_action( 'wp_print_footer_scripts', array( $this, 'enqueue_scripts' ), 0 );
			add_action( 'wp_print_footer_scripts', array( $this, 'print_js_template' ), 0 );

			//$tmpl_name = ( 'get_product_search_form' === current_filter() ) ? 'wc-search-form' : 'search-form' ;

			return $this->template_manager->parser->parsed_template( 'search-form', Cherry_Search_Macros_Callback::get_instance() );
		}

		/**
		 * Generate search form style.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function set_css_style() {
			$enable_scroll = filter_var( $this->get_setting( 'enable_scroll' ), FILTER_VALIDATE_BOOLEAN );

			if ( $enable_scroll ) {
				$dynamic_css = cherry_search()->get_core()->init_module( 'cherry-dynamic-css', array() );
				$max_height = $this->get_setting( 'result_area_height' );

				$dynamic_css->add_style(
					'.cherry-search__results-list',
					array(
						'overflow-y' => 'auto',
						'max-height' => $max_height . 'px',
					)
				);
			}
		}

		/**
		 * Get JS template to print.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function print_js_template() {
			$template_names = array(
				'search-form-results-item'
			);
			$output = '';

			foreach ( $template_names as $name ) {
				$content = trim( $this->template_manager->parser->parsed_template( $name, Cherry_Search_Macros_Callback::get_instance() ) );
				$output .= sprintf(
					'<script type="text/html" id="tmpl-%1$s">%2$s</script>',
					$name,
					$content
				);
			}

			echo $output;
		}

		/**
		 * Enqueue public-facing stylesheets.
		 *
		 * @since 1.0.0
		 * @access private
		 * @return void
		 */
		private function enqueue_styles() {
			if ( $this->search_button_icon ) {
				wp_enqueue_style( 'font-awesome' );
			}
			wp_enqueue_style( 'cherry-search' );
		}

		/**
		 * Enqueue public-facing JavaScripts.
		 *
		 * @since 1.0.0
		 * @access private
		 * @return void
		 */
		public function enqueue_scripts() {
			wp_enqueue_script( 'cherry-search' );
			wp_localize_script( 'cherry-search', 'cherrySearchMessages', $this->messages );
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

if ( ! function_exists( 'cherry_get_search_form' ) ) {

	/**
	 * Returns search form html.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	function cherry_get_search_form( $echo = true ) {
		$form = cherry_search_form_public()->build_search_form();
		if ( $echo ) {
			echo $form;
		} else {
			return $form;
		}
	}
}
