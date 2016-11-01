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
	class Cherry_Search_Macros_Callback extends Cherry_Search_Settings_Manager{

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @access private
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * The array contains the values that will replace the macros..
		 *
		 * @since 1.0.0
		 * @var array
		 */
		public $variable = array(
			'thumbnail' => '{{{data.thumbnail}}}',
			'title'     => '{{{data.title}}}',
			'content'   => '{{{data.content}}}',
			'author'    => '{{{data.author}}}',
			'link'      => '{{{data.link}}}',
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
		public function __construct() {
			$this->template_manager = Cherry_Template_Manager::get_instance();
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
			//Value macro $$PLACEHOLDER$$
			$this->variable['placeholder'] = $this->get_setting( 'search_placeholder_text' );
			//Value macro $$READER_TEXT$$
			$this->variable['reader_text'] = apply_filters( 'cherry_search_reader_text', esc_html__( 'Search for:', 'cherry-search' ) );
		}

		/**
		 * Handler macro %%INPUT%%.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return string
		 */
		public function get_input() {
			$output = $this->template_manager->loader->get_template_by_name( 'search-form-input' );

			return $output;
		}

		/**
		 * Handler macro %%SUBMIT%%.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return string
		 */
		public function get_submit() {
			if ( $this->get_setting( 'search_button_icon' ) || $this->get_setting( 'search_button_text' ) ) {

				return $this->template_manager->parser->parsed_template( 'search-form-submit', self::get_instance() );
			}else{
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
			$class = $this->get_setting( 'search_button_icon' );

			if ( $class ) {

				if ( apply_filters( 'cherry_search_icon_prefix', true ) ) {

					preg_match( '/^\w+/', $class, $prefix );
					$class = $prefix[0] . ' ' . $class;
				}

				return sprintf( apply_filters( 'cherry_search_icon', '<span class="cherry-search__icon %s"></span>' ), $class );
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
			$text = $this->get_setting( 'search_button_text' );

			if ( $text ) {

				return sprintf( apply_filters( 'cherry_search_submite_text', '<span class="screen-reader-text">%s</span>' ), $text );
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
			return $this->template_manager->parser->parsed_template( 'search-form-results-list', self::get_instance() );
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
			$thumbnail_visible = filter_var( $this->get_setting( 'thumbnail_visible' ), FILTER_VALIDATE_BOOLEAN ) ;

			if ( $thumbnail_visible ) {
				$thumbnail_html = apply_filters( 'cherry_search_thumbnail_html', '<span class="cherry-search__item-thumbnail">%s</span>' );
				$output = sprintf( $thumbnail_html, $this->variable['thumbnail'] );
			}

			return $output;
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
				self::$instance = new self();
			}

			return self::$instance;
		}

	}
}
