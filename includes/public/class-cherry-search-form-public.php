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
		 * @since 1.0.0
		 * @var object
		 */
		private static $instance = null;

		/**
		 * The number of search forms on the page.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    number
		 */
		private static $count = 0;

		/**
		 * Templates for search list.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    string
		 */
		private static $js_templates = '';

		/**
		 * Styles for the search form.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    array
		 */
		private static $dinamic_css = array();

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
		 * @var    array
		 */
		private $messages = array();

		/**
		 * Search button icon.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    string
		 */
		private $search_button_icon = '';

		/**
		 * Class constructor.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function __construct() {
			add_action( 'pre_get_posts', array( $this, 'set_search_query' ) );

			$change_standard_search = filter_var( $this->get_setting( 'change_standard_search' ), FILTER_VALIDATE_BOOLEAN );

			if ( $change_standard_search ) {
				add_filter( 'get_search_form', array( $this, 'build_search_form' ), 0 );
				add_filter( 'get_product_search_form', array( $this, 'build_search_form' ), 11 );
			}

			add_action( 'get_footer', array( $this, 'set_css_style' ) );
			add_action( 'wp_print_footer_scripts', array( $this, 'print_js_template' ), 0 );
		}

		/**
		 * Trigger function set_query_settings.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function set_search_query( $query ) {
			if ( ! is_admin() && $query->is_search && ! empty( $_GET['settings'] ) ) {
				$form_settings = stripcslashes( $_GET['settings'] );
				$form_settings = json_decode( $form_settings );
				$form_settings = get_object_vars( $form_settings );

				$this->set_query_settings( $form_settings );

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
		public function build_search_form( $search_form = null, $args = array() ) {

			if ( null === $this->template_manager ) {
				$this->template_manager = new Cherry_Template_Manager( cherry_search()->get_core() );
			}

			$this->get_settings();
			$this->settings['id'] = ++self::$count;
			$this->settings       = ! empty( $args ) ?  wp_parse_args( $args, $this->settings ) : $this->settings ;

			$wrapper_html = apply_filters( 'cherry_search_shortcode_wrapper', '<div id="cherry-search-wrapper-%1$s" class="cherry-search-wrapper" data-args=\'' . json_encode( $this->settings ) . '\'>%2$s</div>' );
			$form_html    = $this->template_manager->parser->parsed_template( 'search-form', new Cherry_Search_Macros_Callback( $this->settings ) );

			$this->search_button_icon      = $this->settings['search_button_icon'];
			$this->messages['serverError'] = esc_html( $this->settings['server_error'] );

			$this->add_js_template( $this->settings );
			$this->add_css_style( $this->settings );

			// Load public-facing StyleSheets.
			$this->enqueue_styles();
			$this->enqueue_scripts();

			return sprintf( $wrapper_html, $this->settings['id'], $form_html );
		}
		/**
		 * Generate search form style.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function add_css_style( $args = array() ) {
			$enable_scroll = filter_var( $args['enable_scroll'], FILTER_VALIDATE_BOOLEAN );
			if ( $enable_scroll ) {
				$id         = $args['id'];
				$max_height = $args['result_area_height'];

				self::$dinamic_css[ $id ] = array(
					'selector' => '#cherry-search-wrapper-' . $id . ' .cherry-search__results-list',
					'options'  => array(
						'overflow-y' => 'auto',
						'max-height' => $max_height . 'px',
					),
				);
			}
		}

		/**
		 * Generate search form style.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function set_css_style() {
			if ( ! empty( self::$dinamic_css ) ) {
				$dynamic_css = cherry_search()->get_core()->init_module( 'cherry-dynamic-css', array() );
				foreach ( self::$dinamic_css as $value ) {
					$dynamic_css->add_style( $value['selector'], $value['options'] );
				}
			}
		}

		/**
		 * Get JS template to print.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function add_js_template( $args = array() ) {
			$name = 'search-form-results-item';
			$output = '';

			$content = trim( $this->template_manager->parser->parsed_template( $name, new Cherry_Search_Macros_Callback( $args ) ) );
			$output .= sprintf(
				'<script type="text/html" id="tmpl-%1$s-%2$s">%3$s</script>',
				$name,
				$args['id'],
				$content
			);

			self::$js_templates .= $output;
		}

		/**
		 * Get JS template to print.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function print_js_template() {
			echo self::$js_templates;
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
	function cherry_get_search_form( $echo = true, $args = array() ) {
		$form = cherry_search_form_public()->build_search_form( null, $args );
		if ( $echo ) {
			echo $form;
		} else {
			return $form;
		}
	}
}
