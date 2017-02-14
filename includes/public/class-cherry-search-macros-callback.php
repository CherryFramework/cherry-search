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
	class Cherry_Search_Macros_Callback extends Cherry_Search_Settings_Manager {

		/**
		 * The attributes of the shortcode.
		 *
		 * @since 1.0.0
		 * @access private
		 * @var   object
		 */
		private $args = array();

		/**
		 * The array contains the values that will replace the macros..
		 *
		 * @since 1.0.0
		 * @var array
		 */
		public $variable = array(
			'thumbnail'     => '{{{data.thumbnail}}}',
			'title'         => '{{{data.title}}}',
			'content'       => '{{{data.content}}}',
			'author'        => '{{{data.author}}}',
			'link'          => '{{{data.link}}}',
			'placeholder'   => '',
			'reader_text'   => '',
			'wrapper_class' => '',
			'form_class'    => '',
			'input_id'      => '',
			'action'        => '',
		);

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
		public function __construct( $args = array() ) {
			$this->args            = $args;
			$this->template_manager = new Cherry_Template_Manager( cherry_search()->get_core() );

			$this->set_variable();
		}

		/**
		 * Sets the value of variables.
		 *
		 * @since  1.0.0
		 * @access private
		 * @return void
		 */
		private function set_variable() {
			// Value macro $$ACTION$$
			$this->variable['action']        = get_home_url();
			// Value macro $$PLACEHOLDER$$
			$this->variable['placeholder']   = $this->args['search_placeholder_text'];
			// Value macro $$READER_TEXT$$
			$this->variable['reader_text']   = apply_filters( 'cherry_search_reader_text', esc_html__( 'Search for:', 'cherry-search' ) );
			// Value macro $$WRAPPER_CLASS$$
			$this->variable['wrapper_class'] = apply_filters( 'cherry_search_wrapper_class', $this->get_wrapper_class() );
			// Value macro $$WRAPPER_CLASS$$
			$this->variable['form_class']    = apply_filters( 'cherry_search_form_class', $this->get_form_class() );
			// Value macro $$INPUT_ID$$
			$this->variable['input_id']      = apply_filters( 'cherry_search_input_id', $this->get_input_id() );
			// Value macro $$SETTINGS$$
			$this->variable['settings']      = apply_filters( 'cherry_search_query_settings', $this->get_query_settings() );
		}

		/**
		 * Handler macro %%INPUT%%.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return string
		 */
		public function get_input() {
			return $this->template_manager->loader->get_template_by_name( 'search-form-input' );
		}

		/**
		 * Handler macro %%SUBMIT%%.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return string
		 */
		public function get_submit() {
			if ( $this->args['search_button_icon'] || $this->args['search_button_text'] ) {

				return $this->template_manager->parser->parsed_template( 'search-form-submit', new self( $this->args ) );
			} else {
				return;
			}
		}

		/**
		 * Handler macro %%ICON%%.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return string
		 */
		public function get_icon() {
			$class = $this->args['search_button_icon'];

			if ( $class ) {

				if ( apply_filters( 'cherry_search_icon_prefix', true ) ) {

					preg_match( '/^\w+/', $class, $prefix );
					$class = $prefix[0] . ' ' . $class;
				}

				return sprintf( apply_filters( 'cherry_search_icon', '<span class="cherry-search__icon %s"></span>' ), esc_attr( $class ) );
			} else {
				return;
			}
		}

		/**
		 * Handler macro %%SUBMIT_TEXT%%.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return string
		 */
		public function get_submit_text() {
			$text = $this->args['search_button_text'];

			if ( $text ) {

				return sprintf( apply_filters( 'cherry_search_submite_text', '<span class="cherry-search__submite_text">%s</span>' ), esc_html( $text ) );
			} else {
				return;
			}
		}

		/**
		 * Handler macro %%RESULTS_LIST%%.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return string
		 */
		public function get_results_list() {
			return $this->template_manager->parser->parsed_template( 'search-form-results-list', new self( $this->args ) );
		}

		/**
		 * Handler macro %%SPINNER%%.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return string
		 */
		public function get_spinner() {
			$spinner_holder = apply_filters( 'cherry_search_spinner_holder', '<div class="cherry-search__spinner_holder">%s</div>' );
			$spinner        = apply_filters( 'cherry_search_spinner', '<div class="cherry-search__spinner"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div>' );

			return sprintf( $spinner_holder, $spinner );
		}

		/**
		 * Handler macro %%THUMBNAIL%%.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return string
		 */
		public function get_thumbnail() {
			$output = '';
			$thumbnail_visible = filter_var( $this->args['thumbnail_visible'], FILTER_VALIDATE_BOOLEAN );

			if ( $thumbnail_visible ) {
				$thumbnail_html = apply_filters( 'cherry_search_thumbnail_html', '<span class="cherry-search__item-thumbnail">%s</span>' );
				$output = sprintf( $thumbnail_html, $this->variable['thumbnail'] );
			}

			return $output;
		}

		/**
		 * Handler macro $$WRAPPER_CLASS$$.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return string
		 */
		public function get_wrapper_class() {
			$output = ( 'get_product_search_form' === current_filter() ) ? 'wc-search-form' : '' ;
			return $output;
		}

		/**
		 * Handler macro $$FORM_CLASS$$.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return string
		 */
		public function get_form_class() {
			$output = ( 'get_product_search_form' === current_filter() ) ? 'woocommerce-product-search' : '' ;
			return $output;
		}

		/**
		 * Handler macro $$INPUT_ID$$.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return string
		 */
		public function get_input_id() {
			$output = ( 'get_product_search_form' === current_filter() ) ? 'id="woocommerce-product-search-field"' : '' ;
			return $output;
		}

		/**
		 * Handler macro $$SETTINGS$$.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return string
		 */
		public function get_query_settings() {
			$query_key = array(
				'search_source',
				'results_order',
				'results_order_by',
				'exclude_source_post_format',
				'exclude_source_category',
				'exclude_source_tags',
			);
			$query_settings = array();

			foreach ( $query_key as $key ) {
				if ( ! empty( $this->args[ $key ] ) ) {
					$query_settings[ $key ] = $this->args[ $key ];
				}
			}

			return json_encode( $query_settings );
		}
	}
}
