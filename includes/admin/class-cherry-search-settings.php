<?php
/**
 * Plugin settings.
 *
 * @package    Cherry_Search
 * @subpackage Admin
 * @author     Cherry Team
 * @license    GPL-3.0+
 * @copyright  2012-2016, Cherry Team
 */

// If class `Cherry_Search_Settings` doesn't exists yet.
if ( ! class_exists( 'Cherry_Search_Settings' ) ) {

	/**
	 * Cherry_Search_Settings class.
	 */
	class Cherry_Search_Settings {

		/**
		 * Form on settings page.
		 *
		 * @since 1.0.0
		 * @var array
		 * @access protected
		 */
		protected $form = null;

		/**
		 * Section on settings page.
		 *
		 * @since 1.0.0
		 * @var array
		 * @access protected
		 */
		protected $section = null;

		/**
		 * Tab component on settings page.
		 *
		 * @since 1.0.0
		 * @var array
		 * @access protected
		 */
		protected $component_tab = null;

		/**
		 * Tabs on settings page.
		 *
		 * @since 1.0.0
		 * @var array
		 * @access protected
		 */
		protected $tabs = null;

		/**
		 * Info section on settings page.
		 *
		 * @since 1.0.0
		 * @var array
		 * @access protected
		 */
		protected $info = null;

		/**
		 * Settings section on settings page.
		 *
		 * @since 1.0.0
		 * @var array
		 * @access protected
		 */
		protected $settings = null;

		/**
		 * Submit buttons on settings page.
		 *
		 * @since 1.0.0
		 * @var array
		 * @access protected
		 */
		protected $buttons = null;

		/**
		 * Instance of the class Cherry_Utility.
		 *
		 * @since 1.0.0
		 * @var object
		 * @access private
		 */
		private $utility = null;

		/**
		 * HTML spinner.
		 *
		 * @since 1.0.0
		 * @var string
		 * @access private
		 */
		private $spinner = '<span class="loader-wrapper"><span class="loader"></span></span>';

		/**
		 * Dashicons.
		 *
		 * @since 1.0.0
		 * @var string
		 * @access private
		 */
		private $button_icon = '<span class="dashicons dashicons-yes icon"></span>';

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
			$this->utility = cherry_search()->get_core()->modules['cherry-utility']->utility;

			$this->set_settings();
		}


		/**
		 * Function set phugin settings.
		 *
		 * @since 1.0.0
		 * @access private
		 * @return void
		 */
		private function set_settings() {
			$this->form = array(
				'chery-search-settings-form' => array(),
			);

			$this->section = array(
				'search_settings_section' => array(
					'type'          => 'section',
					'parent'        => 'chery-search-settings-form',
					'title'         => '<span class="dashicons dashicons-search"></span>' . esc_html__( 'Cherry Search Settings', 'cherry-search' ),
				),
			);

			$this->component_tab = array(
				'search_settings_tab'   => array(
					'type'           => 'component-tab-vertical',
					'parent'         => 'search_settings_section',
				),
			);

			$this->tabs = array(
				'main'            => array(
					'parent'          => 'search_settings_tab',
					'scroll'          => true,
					'title'           => esc_html__( 'Main Settings', 'cherry-search' ),
				),
				'query_settings'  => array(
					'parent'          => 'search_settings_tab',
					'scroll'          => true,
					'title'           => esc_html__( 'Search Query Settings', 'cherry-search' ),
				),
				'visual_settings' => array(
					'parent'          => 'search_settings_tab',
					'title'           => esc_html__( 'Visual Tuning', 'cherry-search' ),
				),
				'submite_buttons' => array(
					'parent'          => 'search_settings_section',
				),
			);

			$this->info = array(
				'form_html'  => array(
					'type'       => 'html',
					'parent'     => 'main',
					'class'      => 'cherry-control form-button',
					'html'       => sprintf(
						esc_html__( 'If you want to add to the list tion site, you can do several sposoboma.%3$s With the aid shortcode %s, adding it to the content pages or posts. So you can do it with the aid of php code %s.%3$s Alternatively, you can enable the option "Change standard search" and the plugin will automatically replace the default WordPress search on your site.', 'cherry-search' ),
						'<code class ="cherry-code-example">' . htmlspecialchars ( '[ ... ]' ). '</code>',
						'<code class ="cherry-code-example">' . htmlspecialchars ( '<?php ... ?>' ). '</code>',
						'<br/>'
					),
				),
			);

			$this->settings = array(
//Main Settings
				'change_standard_search'  => array(
					'type'                    => 'switcher',
					'parent'                  => 'main',
					'title'                   => esc_html__( 'Change standard search.', 'cherry-search' ),
					//'description'           => esc_html__( 'Analogue of the regular HTML radio buttons.', 'cherry-search' ),
					'value'                   => $this->get_setting( 'change_standard_search', true ),
					'toggle'                  => array(
						'true_toggle'             => 'Yes',
						'false_toggle'            => 'No',
					),
				),
				'search_button_text'      => array(
					'type'                    => 'text',
					'parent'                  => 'main',
					'title'                   => esc_html__( 'Search button text.', 'cherry-search' ),
					//'description'           => esc_html__( 'Description text.', 'cherry-search' ),
					'value'                   => $this->get_setting( 'search_button_text', '' ),
					'placeholder'             => esc_html__( 'Search', 'cherry-search' ),
					'class'                   => '',
					'label'                   => '',
				),
				'search_placeholder_text' => array(
					'type'                    => 'text',
					'parent'                  => 'main',
					'title'                   => esc_html__( 'Caption / Placeholder text.', 'cherry-search' ),
					//'description'           => esc_html__( 'Description text.', 'cherry-search' ),
					'value'                   => $this->get_setting( 'search_placeholder_text', 'Search &hellip;' ),
					'placeholder'             => esc_html__( '', 'cherry-search' ),
					'class'                   => '',
					'label'                   => '',
				),
//Search Query Settings
				'search_source' => array(
					'type'          => 'select',
					'parent'        => 'query_settings',
					'title'         => esc_html__( 'Search Source.', 'cherry-search' ),
					//'description' => esc_html__( 'Description select.', 'cherry-search' ),
					'multiple'      => true,
					'filter'        => true,
					'value'         => $this->get_setting( 'search_source', array( 'post', 'page', ) ),
					'options'       => $this->get_search_source(),
					'placeholder'   => esc_html__( 'Selected search source.', 'cherry-search' ),
					'label'         => '',
					'class'         => '',
				),
				'exclude_source_category' => array(
					'type'          => 'select',
					'parent'        => 'query_settings',
					'title'         => esc_html__( 'Exclude category from source.', 'cherry-search' ),
					//'description' => esc_html__( 'Description select.', 'cherry-search' ),
					'multiple'      => true,
					'filter'        => true,
					'value'         => $this->get_setting( 'exclude_source_category', '' ),
					'options'       => $this->utility->satellite->get_terms_array(),
					'placeholder'   => esc_html__( 'Not selected categories.', 'cherry-search' ),
					'label'         => '',
					'class'         => '',
				),
				'exclude_source_tags' => array(
					'type'          => 'select',
					'parent'        => 'query_settings',
					'title'         => esc_html__( 'Exclude tags from source.', 'cherry-search' ),
					//'description' => esc_html__( 'Description select.', 'cherry-search' ),
					'multiple'      => true,
					'filter'        => true,
					'value'         => $this->get_setting( 'exclude_source_tags', '' ),
					'options'       => $this->utility->satellite->get_terms_array('post_tag'),
					'placeholder'   => esc_html__( 'Not selected tags.', 'cherry-search' ),
					'label'         => '',
					'class'         => '',
				),
				'exclude_source_post_format' => array(
					'type'          => 'select',
					'parent'        => 'query_settings',
					'title'         => esc_html__( 'Exclude post format from source.', 'cherry-search' ),
					//'description' => esc_html__( 'Description select.', 'cherry-search' ),
					'multiple'      => true,
					'filter'        => true,
					'value'         => $this->get_setting( 'exclude_source_post_format', '' ),
					'options'       => $this->utility->satellite->get_terms_array('post_format'),
					'placeholder'   => esc_html__( 'Not selected post formats.', 'cherry-search' ),
					'label'         => '',
					'class'         => '',
				),
				'search_source_display'  => array(
					'type'                    => 'switcher',
					'parent'                  => 'query_settings',
					'title'                   => esc_html__( 'Display search source in your website.', 'cherry-search' ),
					//'description'           => esc_html__( 'Analogue of the regular HTML radio buttons.', 'cherry-search' ),
					'value'                   => $this->get_setting( 'search_source_display', true ),
					'toggle'                  => array(
						'true_toggle'             => 'Yes',
						'false_toggle'            => 'No',
					),
				),
				'limit_query'             => array(
					'type'                    => 'stepper',
					'parent'                  => 'query_settings',
					'title'                   => esc_html__( 'Limit query suggestion.', 'cherry-search' ),
					//'description'           => esc_html__( 'Adds a number input used to define numeric values.', 'cherry-search' ),
					'value'                   => $this->get_setting( 'limit_query', 0 ),
					'max_value'               => 500,
					'min_value'               => 0,
					'step_value'              => 1,
				),
				'results_order'           => array(
					'type'                    => 'radio',
					'parent'                  => 'query_settings',
					'title'                   => esc_html__( 'Search results items order', 'cherry-search' ),
					//'description'           => esc_html__( 'Adds radio buttons group. Lets user select one option from the list.', 'cherry-search' ),
					'value'                   => $this->get_setting( 'results_order', 'asc' ),
					'options'                 => array(
						'asc'   => array(
							'label' => esc_html__( 'Asc', 'cherry-search' ),
						),
						'desc'  => array(
							'label' => esc_html__( 'Desc', 'cherry-search' ),
						),
					),
				),
				'results_order_by'        => array(
					'type'                    => 'radio',
					'parent'                  => 'query_settings',
					'title'                   => esc_html__( 'Search results order by', 'cherry-search' ),
					//'description'           => esc_html__( 'Adds radio buttons group. Lets user select one option from the list.', 'cherry-search' ),
					'value'                   => $this->get_setting( 'results_order_by', 'date' ),
					'options'                 => array(
						'date'   => array(
							'label'  => esc_html__( 'Date', 'cherry-search' ),
						),
						'title'  => array(
							'label'  => esc_html__( 'Title', 'cherry-search' ),
						),
						'autohr' => array(
							'label'  => esc_html__( 'Author', 'cherry-search' ),
						),
					),
				),
//Visual Tuning
				'limit_description_word' => array(
					'type'                    => 'stepper',
					'parent'                  => 'visual_settings',
					'title'                   => esc_html__( 'Limit search result description.', 'cherry-search' ),
					//'description'           => esc_html__( 'Adds a number input used to define numeric values.', 'cherry-search' ),
					'value'                   => $this->get_setting( 'limit_description_word', 0 ),
					'max_value'               => 500,
					'min_value'               => 0,
					'step_value'              => 1,
				),
				'result_area_height' => array(
					'type'                    => 'stepper',
					'parent'                  => 'visual_settings',
					'title'                   => esc_html__( 'Result area height.', 'cherry-search' ),
					//'description'           => esc_html__( 'Adds a number input used to define numeric values.', 'cherry-search' ),
					'value'                   => $this->get_setting( 'result_area_height', 0 ),
					'max_value'               => 500,
					'min_value'               => 0,
					'step_value'              => 1,
				),
				'enable_scroll'          => array(
					'type'                    => 'switcher',
					'parent'                  => 'visual_settings',
					'title'                   => esc_html__( 'Enable Scroll.', 'cherry-search' ),
					//'description'           => esc_html__( 'Analogue of the regular HTML radio buttons.', 'cherry-search' ),
					'value'                   => $this->get_setting( 'enable_scroll', true ),
					'toggle'                  => array(
						'true_toggle'  => 'Yes',
						'false_toggle' => 'No',
					),
				),
				/*'show_hide_effect' => array(
					'type'          => 'select',
					'parent'        => 'visual_settings',
					'title'         => esc_html__( 'Result area effect.', 'cherry-search' ),
					//'description' => esc_html__( 'Description select.', 'cherry-search' ),
					'multiple'      => false,
					'filter'        => true,
					'value'         => $this->get_setting( 'show_hide_effect', 'fade' ),
					'options'  => array(
						'fade' => esc_html__( 'fade.', 'cherry-search' ),
						'down' => esc_html__( 'down.', 'cherry-search' ),
					),
					'placeholder'   => 'Select',
					'label'         => '',
					'class'         => '',
				),*/
			);

			$this->buttons = array(
			//Submite buttons
				'cherry-reset-buttons'  => array(
					'type'          => 'button',
					'parent'        => 'submite_buttons',
					'content'       => '<span class="text">' . esc_html__( 'Reset', 'cherry-search' ) . '</span>' . $this->spinner . $this->button_icon,
					'view_wrapping' => false,
					'form'          => 'chery-search-settings-form',
					'formaction'    => '',
				),
				'cherry-save-buttons'  => array(
					'type'          => 'button',
					'parent'        => 'submite_buttons',
					'style'         => 'success',
					'content'       => '<span class="text">' . esc_html__( 'Save', 'cherry-search' ) . '</span>' . $this->spinner . $this->button_icon,
					'view_wrapping' => false,
					'form'          => 'chery-search-settings-form',
					'formaction'    => '',
				),
			);
		}

		/**
		 * Get icons set.
		 *
		 * @since 1.0.0
		 * @access private
		 * @return array
		 */
		private function get_search_source() {
			$sources = get_post_types();
			$exude = array( 'revision', 'nav_menu_item' );

			if ( $sources ) {
				foreach ( $sources as $key => $value ) {
					if ( in_array( $key, $exude ) ){
						unset( $sources[ $key ] );
					} else {
						$sources[ $key ] = ucfirst( $value );
					}
				}
			}
			return $sources;
		}

		/**
		 * Get plugin setting.
		 *
		 * @since 1.0.0
		 * @access private
		 * @return array
		 */
		private function get_setting( $options_id, $default_value ) {
			$settings = get_option( CHERRY_SEARCH_SLUG, false );

			if ( $settings && isset( $settings[ $options_id ] ) ) {
				return $settings[ $options_id ];
			}else{
				return $default_value;
			}
		}

		/**
		 * Save plugin settings.
		 *
		 * @since 1.0.0
		 * @access protected
		 * @return void
		 */
		protected function save_setting( $key = false, $data = array() ) {
			if ( ! empty( $data ) && is_array( $data ) && $key) {
				update_option( $key, $data );
			}
		}

		/**
		 * Get default plugin settings.
		 *
		 * @since 1.0.0
		 * @access private
		 * @return array
		 */
		private function get_default_settings() {
			$settings = $this->settings;
			$default_settungs = array();

			foreach ( $settings as $key => $value ) {
				$default_settungs[ $key ] = $value['value'];
			}

			return $default_settungs;
		}

		/**
		 * Set default plugin settings.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return array
		 */
		public function set_default_settings() {
			$default_settungs = $this->get_default_settings();

			$this->save_setting( CHERRY_SEARCH_SLUG . '-default' , $default_settungs );

			return $default_settungs;
		}

		/**
		 * Reset settings option to default.
		 *
		 * @since 1.0.0
		 * @access protected
		 * @return array
		 */
		protected function reset_setting() {
			$default_settungs = get_option( CHERRY_SEARCH_SLUG . '-default', false );

			if ( ! $default_settungs ){
				$default_settungs = $this->set_default_settings();
			}

			$this->save_setting( CHERRY_SEARCH_SLUG, $default_settungs );

			return $default_settungs;
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
