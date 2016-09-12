<?php
/**
 * Sets up the plugin option page.
 *
 * @package    Cherry_Search
 * @subpackage Admin
 * @author     Cherry Team
 * @license    GPL-3.0+
 * @copyright  2002-2016, Cherry Team
 */

// If class `Cherry_Search_Options_Page` doesn't exists yet.
if ( ! class_exists( 'Cherry_Search_Options_Page' ) ) {

	/**
	 * Cherry_Search_Options_Page class.
	 */
	class Cherry_Search_Options_Page {

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
			$this->render_page();
		}

		/**
		 * Render plugin options page.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function render_page() {
			$this->builder->register_section(
				array(
					'option_section' => array(
						'type'				=> 'section',
						'scroll'			=> true,
						'title'				=> __( '<span class="dashicons dashicons-admin-settings"></span> Option Section', 'cherry-search' ),
						'description'		=> esc_html__( 'Elements formed with modules cherry-ui-elements and cherry-interface-builder.', 'cherry-search' ),
					),
				)
			);

			$this->builder->register_form(
				array(
					'option_form' => array(
						'type'				=> 'form',
						'parent'			=> 'option_section',
						'action'			=> 'my_action.php',
					),
				)
			);

			$this->builder->register_settings(
				array(
					'ui_elements' => array(
						'type'				=> 'settings',
						'parent'			=> 'option_form',
						'title'				=> __( '<span class="dashicons dashicons-admin-generic"></span> UI Elements', 'cherry-search' ),
						'description'		=> esc_html__( 'UI element created with the module cherry-ui-elements.', 'cherry-search' ),
					),
					'bi_elements' => array(
						'type'				=> 'settings',
						'parent'			=> 'option_form',
						'title'				=> __( '<span class="dashicons dashicons-admin-generic"></span> Interface Builder Element', 'cherry-search' ),
						'description'		=> esc_html__( 'Interface element created with the module cherry-interface-builder.', 'cherry-search' ),
					),
				)
			);

			$this->builder->register_control(
				array(
					'checkbox' => array(
						'type'			=> 'checkbox',
						'parent'		=> 'ui_elements',
						'title'			=> esc_html__( 'Checkbox', 'cherry-search' ),
						'description'	=> esc_html__( 'Description checkbox.', 'cherry-search' ),
						'class'			=> '',
						'value'			=> array(
							'checkbox' => 'true',
						),
						'options'		=> array(
							'checkbox' => esc_html__( 'Check Me', 'cherry-search' ),
						),
					),
					'checkbox_multi' => array(
						'type'			=> 'checkbox',
						'parent'		=> 'ui_elements',
						'title'			=> esc_html__( 'Multi Checkbox', 'cherry-search' ),
						'description'	=> esc_html__( 'Description multi checkbox.', 'cherry-search' ),
						'class'			=> '',
						'value'			=> array(
							'checkbox-0' => 'false',
							'checkbox-1' => 'false',
							'checkbox-2' => 'false',
							'checkbox-3' => 'true',
							'checkbox-4' => 'true',
						),
						'options'		=> array(
							'checkbox-0' => array(
								'label' => esc_html__( 'Check Me #1', 'cherry-search' ),
							),
							'checkbox-1' => esc_html__( 'Check Me #2', 'cherry-search' ),
							'checkbox-2' => esc_html__( 'Check Me #3', 'cherry-search' ),
							'checkbox-3' => esc_html__( 'Check Me #4', 'cherry-search' ),
							'checkbox-4' => esc_html__( 'Check Me #5', 'cherry-search' ),
						),
					),
					'colorpicker' => array(
						'type'			=> 'colorpicker',
						'parent'		=> 'ui_elements',
						'title'			=> esc_html__( 'Color Picker', 'cherry-search' ),
						'description'	=> esc_html__( 'Description color picker.', 'cherry-search' ),
						'class'			=> '',
						'value'			=> '#3da3ce',
						'label'			=> '',
					),
					'icon' => array(
						'type'					=> 'iconpicker',
						'parent'				=> 'ui_elements',
						'title'					=> esc_html__( 'Icon Picker', 'cherry-search' ),
						'description'			=> esc_html__( 'Description icon picker.', 'cherry-search' ),
						'value'					=> 'fa-wordpress',
						'icon_data'				=> array(
							'icon_set'		=> 'cherryWidgetFontAwesome',
							'icon_css'		=> esc_url( CHERRY_SEARCH_URI . 'assets/css/min/font-awesome.min.css' ),
							'icon_base'		=> 'fa',
							'icon_prefix'	=> 'fa-',
							'icons'			=> $this->get_icons_set(),
						),
					),
					'media_image' => array(
						'type'					=> 'media',
						'parent'				=> 'ui_elements',
						'title'					=> esc_html__( 'Choose Image', 'cherry-search' ),
						'description'			=> esc_html__( 'Description choose image.', 'cherry-search' ),
						'value'					=> '',
						'multi_upload'			=> false,
						'library_type'			=> 'image',
						'upload_button_text'	=> esc_html__( 'Choose Media', 'cherry-search' ),
						'class'					=> '',
						'label'					=> '',
					),
					'media_multi_image' => array(
						'type'					=> 'media',
						'parent'				=> 'ui_elements',
						'title'					=> esc_html__( 'Multi Choose Image', 'cherry-search' ),
						'description'			=> esc_html__( 'Description multi choose image.', 'cherry-search' ),
						'value'					=> '',
						'multi_upload'			=> true,
						'library_type'			=> 'image',
						'upload_button_text'	=> esc_html__( 'Choose Media', 'cherry-search' ),
						'class'					=> '',
						'label'					=> '',
					),
					'media_video' => array(
						'type'					=> 'media',
						'parent'				=> 'ui_elements',
						'title'					=> esc_html__( 'Choose Video', 'cherry-search' ),
						'description'			=> esc_html__( 'Description choose video.', 'cherry-search' ),
						'value'					=> '',
						'multi_upload'			=> false,
						'library_type'			=> 'video',
						'upload_button_text'	=> esc_html__( 'Choose Media', 'cherry-search' ),
						'class'					=> '',
						'label'					=> '',
					),
					'radio' => array(
						'type'					=> 'radio',
						'parent'				=> 'ui_elements',
						'title'					=> esc_html__( 'Radio Button', 'cherry-search' ),
						'description'			=> esc_html__( 'Adds radio buttons group. Lets user select one option from the list.', 'cherry-search' ),
						'value'					=> 'radio-2',
						'options'				=> array(
							'radio-1' => array(
								'label' => 'Radio #1',
							),
							'radio-2' => array(
								'label' => 'Radio #2',
							),
							'radio-3' => array(
								'label' => 'Radio #3',
							),
						),
						'class'					=> '',
						'label'					=> '',
					),
					'radio_image' => array(
						'type'			=> 'radio',
						'parent'				=> 'ui_elements',
						'title'			=> esc_html__( 'Image Radio Button', 'cherry-search' ),
						'description'	=> esc_html__( 'Adds image based radio buttons group. Behaves as HTML radio buttons.', 'cherry-search' ),
						'value'			=> 'grid-layout',
						'class'			=> '',
						'display_input'	=> false,
						'options'	=> array(
							'grid-layout' => array(
								'label'		=> esc_html__( 'Grid', 'cherry-search' ),
								'img_src'	=> CHERRY_SEARCH_URI . 'assets/img/svg/list-layout-grid.svg',
							),
							'masonry-layout' => array(
								'label'		=> esc_html__( 'Masonry', 'cherry-search' ),
								'img_src'	=> CHERRY_SEARCH_URI . 'assets/img/svg/list-layout-masonry.svg',
							),
							'justified-layout' => array(
								'label'		=> esc_html__( 'Justified', 'cherry-search' ),
								'img_src'	=> CHERRY_SEARCH_URI . 'assets/img/svg/list-layout-justified.svg',
							),
							'cascading-grid-layout' => array(
								'label'		=> esc_html__( 'Cascading grid', 'cherry-search' ),
								'img_src'	=> CHERRY_SEARCH_URI . 'assets/img/svg/list-layout-cascading-grid.svg',
							),
							'list-layout' => array(
								'label'		=> esc_html__( 'List', 'cherry-search' ),
								'img_src'	=> CHERRY_SEARCH_URI . 'assets/img/svg/list-layout-listing.svg',
							),
						),
					),
					'select' => array(
						'type'			=> 'select',
						'parent'				=> 'ui_elements',
						'title'			=> esc_html__( 'Select', 'cherry-search' ),
						'description'	=> esc_html__( 'Description select.', 'cherry-search' ),
						'multiple'		=> false,
						'filter'		=> true,
						'value'			=> 'select-8',
						'options'		=> array(
							'select-1'	=> 'select 1',
							'select-2'	=> 'select 2',
							'select-3'	=> 'select 3',
							'select-4'	=> 'select 4',
							'select-5'	=> 'select 5',
							'optgroup-1'	=> array(
								'label' => 'Group 1',
								'group_options' => array(
									'select-6'	=> 'select 6',
									'select-7'	=> 'select 7',
									'select-8'	=> 'select 8',
								),
							),
							'optgroup-2'	=> array(
								'label' => 'Group 2',
								'group_options' => array(
									'select-9'	=> 'select 9',
									'select-10'	=> 'select 10',
									'select-11'	=> 'select 11',
								),
							),
						),
						'placeholder'	=> 'Select',
						'label'			=> '',
						'class'			=> '',
					),
					'multi_select' => array(
						'type'			=> 'select',
						'parent'				=> 'ui_elements',
						'title'			=> esc_html__( 'Multi Select', 'cherry-search' ),
						'description'	=> esc_html__( 'Description multi select.', 'cherry-search' ),
						'multiple'		=> true,
						'filter'		=> true,
						'value'			=> array( 'select-2', 'select-4' ),
						'options'		=> array(
							'select-1'	=> 'select 1',
							'select-2'	=> 'select 2',
							'select-3'	=> 'select 3',
							'select-4'	=> 'select 4',
							'select-5'	=> 'select 5',
						),
						'placeholder'	=> 'Select',
						'label'			=> '',
						'class'			=> '',
					),
					'slider' => array(
						'type'					=> 'slider',
						'parent'				=> 'ui_elements',
						'title'					=> esc_html__( 'Slider', 'cherry-search' ),
						'description'			=> esc_html__( 'Draggable slider with stepper. Used to define some numeric value.', 'cherry-search' ),
						'value'					=> 250,
						'max_value'				=> 500,
						'min_value'				=> 0,
						'step_value'			=> 1,
						'class'					=> '',
						'label'					=> '',
					),
					'stepper' => array(
						'type'					=> 'stepper',
						'parent'				=> 'ui_elements',
						'title'					=> esc_html__( 'Stepper', 'cherry-search' ),
						'description'			=> esc_html__( 'Adds a number input used to define numeric values.', 'cherry-search' ),
						'value'					=> 150,
						'max_value'				=> 400,
						'min_value'				=> 0,
						'step_value'			=> 1,
						'class'					=> '',
						'label'					=> '',
					),
					'switcher' => array(
						'type'					=> 'switcher',
						'parent'				=> 'ui_elements',
						'title'					=> esc_html__( 'Switcher', 'cherry-search' ),
						'description'			=> esc_html__( 'Analogue of the regular HTML radio buttons.', 'cherry-search' ),
						'value'					=> 'false',
						'toggle'				=> array(
							'true_toggle'	=> 'On',
							'false_toggle'	=> 'Off',
						),
						'style'					=> 'normal',
						'class'					=> '',
						'label'					=> '',
					),
					'text' => array(
						'type'					=> 'text',
						'parent'				=> 'ui_elements',
						'title'					=> esc_html__( 'Text', 'cherry-search' ),
						'description'			=> esc_html__( 'Description text.', 'cherry-search' ),
						'value'					=> '',
						'placeholder'			=> esc_html__( 'Input Text', 'cherry-search' ),
						'class'					=> '',
						'label'					=> '',

					),
					'textarea' => array(
						'type'					=> 'textarea',
						'parent'				=> 'ui_elements',
						'title'					=> esc_html__( 'Text Area', 'cherry-search' ),
						'description'			=> esc_html__( 'Description text area.', 'cherry-search' ),
						'value'					=> '',
						'placeholder'			=> esc_html__( 'Input Text', 'cherry-search' ),
						'rows'					=> '10',
						'cols'					=> '20',
						'class'					=> '',
						'label'					=> '',
					),
				)
			);

			$this->builder->register_html(
				array(
					'form_html' => array(
						'type'				=> 'html',
						'parent'			=> 'ui_elements',
						'class'				=> 'cherry-control form-button',
						'html'				=> '<div id="cherry-projects-save-options" class="custom-button save-button"><span>' . esc_html__( 'Save', 'cherry-search' ) . '</span></div><div id="cherry-projects-restore-options" class="custom-button restore-button"><span>' . esc_html__( 'Restore', 'cherry-search' ) . '</span></div>',
					),
				)
			);

			$this->builder->register_component(
				array(
					'accordion' => array(
						'type'				=> 'component-accordion',
						'parent'			=> 'bi_elements',
						'title'				=> esc_html__( 'Component accordion', 'cherry-search' ),
						'description'		=> esc_html__( 'Component Description', 'cherry-search' ),
					),
					'toggle' => array(
						'type'				=> 'component-toggle',
						'parent'			=> 'bi_elements',
						'title'				=> esc_html__( 'Component Toggle', 'cherry-search' ),
						'description'		=> esc_html__( 'Component Description', 'cherry-search' ),
					),
					'tab_vertical' => array(
						'type'				=> 'component-tab-vertical',
						'parent'			=> 'bi_elements',
						'title'				=> esc_html__( 'Component Vertical Tab', 'cherry-search' ),
						'description'		=> esc_html__( 'Component Description', 'cherry-search' ),
					),
					'tab_horizontal' => array(
						'type'				=> 'component-tab-horizontal',
						'parent'			=> 'bi_elements',
						'title'				=> esc_html__( 'Component Horizontal Tab', 'cherry-search' ),
						'description'		=> esc_html__( 'Component Description', 'cherry-search' ),
					),
				)
			);

			$this->builder->register_settings(
				array(
					'tab_vertical_1' => array(
						'parent'			=> 'tab_vertical',
						'title'				=> esc_html__( 'Tab #1', 'cherry-search' ),
						'description'		=> esc_html__( 'First tab description.', 'cherry-search' ),
					),
					'tab_vertical_2' => array(
						'parent'			=> 'tab_vertical',
						'title'				=> esc_html__( 'Tab #2', 'cherry-search' ),
						'description'		=> esc_html__( 'Second tab description.', 'cherry-search' ),
					),
					'tab_vertical_3' => array(
						'parent'			=> 'tab_vertical',
						'title'				=> esc_html__( 'Tab #3', 'cherry-search' ),
						'description'		=> esc_html__( 'Third tab description.', 'cherry-search' ),
					),
					'tab_vertical_4' => array(
						'parent'			=> 'tab_vertical',
						'title'				=> esc_html__( 'Tab #4', 'cherry-search' ),
						'description'		=> esc_html__( 'Fourth tab description.', 'cherry-search' ),
					),

					'tab_horizontal_1' => array(
						'parent'			=> 'tab_horizontal',
						'title'				=> esc_html__( 'Tab #1', 'cherry-search' ),
						'description'		=> esc_html__( 'First tab description.', 'cherry-search' ),
					),
					'tab_horizontal_2' => array(
						'parent'			=> 'tab_horizontal',
						'title'				=> esc_html__( 'Tab #2', 'cherry-search' ),
						'description'		=> esc_html__( 'Second tab description.', 'cherry-search' ),
					),
					'tab_horizontal_3' => array(
						'parent'			=> 'tab_horizontal',
						'title'				=> esc_html__( 'Tab #3', 'cherry-search' ),
						'description'		=> esc_html__( 'Third tab description.', 'cherry-search' ),
					),
					'tab_horizontal_4' => array(
						'parent'			=> 'tab_horizontal',
						'title'				=> esc_html__( 'Tab #4', 'cherry-search' ),
						'description'		=> esc_html__( 'Fourth tab description.', 'cherry-search' ),
					),

					'accordion_1' => array(
						'parent'			=> 'accordion',
						'title'				=> esc_html__( 'Accordion child #1', 'cherry-search' ),
						'description'		=> esc_html__( 'First acordion child description.', 'cherry-search' ),
					),
					'accordion_2' => array(
						'parent'			=> 'accordion',
						'title'				=> esc_html__( 'Accordion child #2', 'cherry-search' ),
						'description'		=> esc_html__( 'Second acordion child description.', 'cherry-search' ),
					),
					'accordion_3' => array(
						'parent'			=> 'accordion',
						'title'				=> esc_html__( 'Accordion child #3', 'cherry-search' ),
						'description'		=> esc_html__( 'Third acordion child description.', 'cherry-search' ),
					),
					'accordion_4' => array(
						'parent'			=> 'accordion',
						'title'				=> esc_html__( 'Accordion child #4', 'cherry-search' ),
						'description'		=> esc_html__( 'Fourth acordion child description.', 'cherry-search' ),
					),

					'toggle_1' => array(
						'parent'			=> 'toggle',
						'title'				=> esc_html__( 'Toggle child #1', 'cherry-search' ),
						'description'		=> esc_html__( 'First toggle child child description.', 'cherry-search' ),
					),
					'toggle_2' => array(
						'parent'			=> 'toggle',
						'title'				=> esc_html__( 'Toggle child #2', 'cherry-search' ),
						'description'		=> esc_html__( 'Second toggle child child description.', 'cherry-search' ),
					),
					'toggle_3' => array(
						'parent'			=> 'toggle',
						'title'				=> esc_html__( 'Toggle child #3', 'cherry-search' ),
						'description'		=> esc_html__( 'Third toggle child child description.', 'cherry-search' ),
					),
					'toggle_4' => array(
						'parent'			=> 'toggle',
						'title'				=> esc_html__( 'Toggle child #4', 'cherry-search' ),
						'description'		=> esc_html__( 'Fourth toggle child child description.', 'cherry-search' ),
					),
				)
			);

			$this->builder->register_control(
				array(
					'checkbox_2' => array(
						'type'			=> 'checkbox',
						'parent'		=> 'tab_vertical_1',
						'title'			=> esc_html__( 'Checkbox', 'cherry-search' ),
						'description'	=> esc_html__( 'Description checkbox.', 'cherry-search' ),
						'class'			=> '',
						'value'			=> array(
							'checkbox' => 'true',
						),
						'options'		=> array(
							'checkbox' => esc_html__( 'Check Me', 'cherry-search' ),
						),
					),
					'checkbox_multi_2' => array(
						'type'			=> 'checkbox',
						'parent'		=> 'tab_vertical_1',
						'title'			=> esc_html__( 'Multi Checkbox', 'cherry-search' ),
						'description'	=> esc_html__( 'Description multi checkbox.', 'cherry-search' ),
						'class'			=> '',
						'value'			=> array(
							'checkbox-0' => 'true',
							'checkbox-1' => 'false',
							'checkbox-2' => 'false',
							'checkbox-3' => 'true',
							'checkbox-4' => 'true',
						),
						'options'		=> array(
							'checkbox-0' => esc_html__( 'Check Me #1', 'cherry-search' ),
							'checkbox-1' => esc_html__( 'Check Me #2', 'cherry-search' ),
							'checkbox-2' => esc_html__( 'Check Me #3', 'cherry-search' ),
							'checkbox-3' => esc_html__( 'Check Me #4', 'cherry-search' ),
							'checkbox-4' => esc_html__( 'Check Me #5', 'cherry-search' ),
						),
					),
					'colorpicker_2' => array(
						'type'			=> 'colorpicker',
						'parent'		=> 'tab_vertical_1',
						'title'			=> esc_html__( 'Color Picker', 'cherry-search' ),
						'description'	=> esc_html__( 'Description color picker.', 'cherry-search' ),
						'class'			=> '',
						'value'			=> '#3da3ce',
						'label'			=> '',
					),
					'icon_2' => array(
						'type'					=> 'iconpicker',
						'parent'				=> 'tab_vertical_1',
						'title'					=> esc_html__( 'Icon Picker', 'cherry-search' ),
						'description'			=> esc_html__( 'Description color picker.', 'cherry-search' ),
						'value'					=> 'fa-wordpress',
						'icon_data'				=> array(
							'icon_set'		=> 'cherryWidgetFontAwesome',
							'icon_css'		=> esc_url( CHERRY_SEARCH_URI . 'assets/css/min/font-awesome.min.css' ),
							'icon_base'		=> 'fa',
							'icon_prefix'	=> 'fa-',
							'icons'			=> $this->get_icons_set(),
						),
					),

					'media_image_2' => array(
						'type'					=> 'media',
						'parent'				=> 'tab_vertical_2',
						'title'					=> esc_html__( 'Choose Image', 'cherry-search' ),
						'description'			=> esc_html__( 'Description choose image.', 'cherry-search' ),
						'value'					=> '',
						'multi_upload'			=> false,
						'library_type'			=> 'image',
						'upload_button_text'	=> esc_html__( 'Choose Media', 'cherry-search' ),
						'class'					=> '',
						'label'					=> '',
					),
					'media_multi_image_2' => array(
						'type'					=> 'media',
						'parent'				=> 'tab_vertical_2',
						'title'					=> esc_html__( 'Multi Choose Image', 'cherry-search' ),
						'description'			=> esc_html__( 'Description multi choose image.', 'cherry-search' ),
						'value'					=> '',
						'multi_upload'			=> true,
						'library_type'			=> 'image',
						'upload_button_text'	=> esc_html__( 'Choose Media', 'cherry-search' ),
						'class'					=> '',
						'label'					=> '',
					),
					'media_video_2' => array(
						'type'					=> 'media',
						'parent'				=> 'tab_vertical_2',
						'title'					=> esc_html__( 'Choose Video', 'cherry-search' ),
						'description'			=> esc_html__( 'Description choose video.', 'cherry-search' ),
						'value'					=> '',
						'multi_upload'			=> false,
						'library_type'			=> 'video',
						'upload_button_text'	=> esc_html__( 'Choose Media', 'cherry-search' ),
						'class'					=> '',
						'label'					=> '',
					),
					'radio_2' => array(
						'type'					=> 'radio',
						'parent'				=> 'tab_vertical_2',
						'title'					=> esc_html__( 'Radio Button', 'cherry-search' ),
						'description'			=> esc_html__( 'Adds radio buttons group. Lets user select one option from the list.', 'cherry-search' ),
						'value'					=> 'radio-1',
						'options'				=> array(
							'radio-1' => array(
								'label' => 'Radio #1',
							),
							'radio-2' => array(
								'label' => 'Radio #2',
							),
							'radio-3' => array(
								'label' => 'Radio #3',
							),
						),
						'class'					=> '',
						'label'					=> '',
					),

					'radio_image_2' => array(
						'type'			=> 'radio',
						'parent'		=> 'tab_vertical_3',
						'title'			=> esc_html__( 'Image Radio Button', 'cherry-search' ),
						'description'	=> esc_html__( 'Adds image based radio buttons group. Behaves as HTML radio buttons.', 'cherry-search' ),
						'value'			=> 'grid-layout',
						'class'			=> '',
						'display_input'	=> false,
						'options'	=> array(
							'grid-layout' => array(
								'label'		=> esc_html__( 'Grid', 'cherry-search' ),
								'img_src'	=> CHERRY_SEARCH_URI . 'assets/img/svg/list-layout-grid.svg',
							),
							'masonry-layout' => array(
								'label'		=> esc_html__( 'Masonry', 'cherry-search' ),
								'img_src'	=> CHERRY_SEARCH_URI . 'assets/img/svg/list-layout-masonry.svg',
							),
							'justified-layout' => array(
								'label'		=> esc_html__( 'Justified', 'cherry-search' ),
								'img_src'	=> CHERRY_SEARCH_URI . 'assets/img/svg/list-layout-justified.svg',
							),
							'cascading-grid-layout' => array(
								'label'		=> esc_html__( 'Cascading grid', 'cherry-search' ),
								'img_src'	=> CHERRY_SEARCH_URI . 'assets/img/svg/list-layout-cascading-grid.svg',
							),
							'list-layout' => array(
								'label'		=> esc_html__( 'List', 'cherry-search' ),
								'img_src'	=> CHERRY_SEARCH_URI . 'assets/img/svg/list-layout-listing.svg',
							),
						),
					),
					'select_2' => array(
						'type'			=> 'select',
						'parent'		=> 'tab_vertical_3',
						'title'			=> esc_html__( 'Select', 'cherry-search' ),
						'description'	=> esc_html__( 'Description select.', 'cherry-search' ),
						'multiple'		=> false,
						'filter'		=> true,
						'value'			=> 'select-8',
						'options'		=> array(
							'select-1'	=> 'select 1',
							'select-2'	=> 'select 2',
							'select-3'	=> 'select 3',
							'select-4'	=> 'select 4',
							'select-5'	=> 'select 5',
							'optgroup-1'	=> array(
								'label' => 'Group 1',
								'group_options' => array(
									'select-6'	=> 'select 6',
									'select-7'	=> 'select 7',
									'select-8'	=> 'select 8',
								),
							),
							'optgroup-2'	=> array(
								'label' => 'Group 2',
								'group_options' => array(
									'select-9'	=> 'select 9',
									'select-10'	=> 'select 10',
									'select-11'	=> 'select 11',
								),
							),
						),
						'placeholder'	=> 'Select',
						'label'			=> '',
						'class'			=> '',
					),
					'multi_select_2' => array(
						'type'			=> 'select',
						'parent'		=> 'tab_vertical_3',
						'title'			=> esc_html__( 'Multi Select', 'cherry-search' ),
						'description'	=> esc_html__( 'Description multi select.', 'cherry-search' ),
						'multiple'		=> true,
						'filter'		=> true,
						'value'			=> array( 'select-2', 'select-4' ),
						'options'		=> array(
							'select-1'	=> 'select 1',
							'select-2'	=> 'select 2',
							'select-3'	=> 'select 3',
							'select-4'	=> 'select 4',
							'select-5'	=> 'select 5',
						),
						'placeholder'	=> 'Select',
						'label'			=> '',
						'class'			=> '',
					),
					'slider_2' => array(
						'type'			=> 'slider',
						'parent'		=> 'tab_vertical_3',
						'title'			=> esc_html__( 'Slider', 'cherry-search' ),
						'description'	=> esc_html__( 'Draggable slider with stepper. Used to define some numeric value.', 'cherry-search' ),
						'value'			=> 250,
						'max_value'		=> 500,
						'min_value'		=> 0,
						'step_value'	=> 1,
						'class'			=> '',
						'label'			=> '',
					),

					'stepper_2' => array(
						'type'					=> 'stepper',
						'parent'				=> 'tab_vertical_4',
						'title'					=> esc_html__( 'Stepper', 'cherry-search' ),
						'description'			=> esc_html__( 'Adds a number input used to define numeric values.', 'cherry-search' ),
						'value'					=> 150,
						'max_value'				=> 400,
						'min_value'				=> 0,
						'step_value'			=> 1,
						'class'					=> '',
						'label'					=> '',
					),
					'switcher_2' => array(
						'type'					=> 'switcher',
						'parent'				=> 'tab_vertical_4',
						'title'					=> esc_html__( 'Switcher', 'cherry-search' ),
						'description'			=> esc_html__( 'Analogue of the regular HTML radio buttons.', 'cherry-search' ),
						'value'				=> 'true',
						'toggle'			=> array(
							'true_toggle'	=> 'On',
							'false_toggle'	=> 'Off',
						),
						'style'				=> 'normal',
						'class'					=> '',
						'label'					=> '',
					),
					'text_2' => array(
						'type'					=> 'text',
						'parent'				=> 'tab_vertical_4',
						'title'					=> esc_html__( 'Text', 'cherry-search' ),
						'description'			=> esc_html__( 'Description text.', 'cherry-search' ),
						'value'					=> '',
						'placeholder'			=> esc_html__( 'Input Text', 'cherry-search' ),
						'class'					=> '',
						'label'					=> '',
					),
					'textarea_2' => array(
						'type'					=> 'textarea',
						'parent'				=> 'tab_vertical_4',
						'title'					=> esc_html__( 'Text Area', 'cherry-search' ),
						'description'			=> esc_html__( 'Description text area.', 'cherry-search' ),
						'value'					=> '',
						'placeholder'			=> esc_html__( 'Input Text', 'cherry-search' ),
						'rows'					=> '10',
						'cols'					=> '20',
						'class'					=> '',
						'label'					=> '',
					),
				)
			);

			$this->builder->register_control(
				array(
					'checkbox_3' => array(
						'type'			=> 'checkbox',
						'parent'		=> 'tab_horizontal_4',
						'title'			=> esc_html__( 'Checkbox', 'cherry-search' ),
						'description'	=> esc_html__( 'Description checkbox.', 'cherry-search' ),
						'class'			=> '',
						'value'			=> array(
							'checkbox' => 'true',
						),
						'options'		=> array(
							'checkbox' => esc_html__( 'Check Me', 'cherry-search' ),
						),
					),
					'checkbox_multi_3' => array(
						'type'			=> 'checkbox',
						'parent'		=> 'tab_horizontal_4',
						'title'			=> esc_html__( 'Multi Checkbox', 'cherry-search' ),
						'description'	=> esc_html__( 'Description multi checkbox.', 'cherry-search' ),
						'class'			=> '',
						'value'			=> array(
							'checkbox-0' => 'true',
							'checkbox-1' => 'false',
							'checkbox-2' => 'false',
							'checkbox-3' => 'true',
							'checkbox-4' => 'true',
						),
						'options'		=> array(
							'checkbox-0' => esc_html__( 'Check Me #1', 'cherry-search' ),
							'checkbox-1' => esc_html__( 'Check Me #2', 'cherry-search' ),
							'checkbox-2' => esc_html__( 'Check Me #3', 'cherry-search' ),
							'checkbox-3' => esc_html__( 'Check Me #4', 'cherry-search' ),
							'checkbox-4' => esc_html__( 'Check Me #5', 'cherry-search' ),
						),
					),
					'colorpicker_3' => array(
						'type'			=> 'colorpicker',
						'parent'		=> 'tab_horizontal_4',
						'title'			=> esc_html__( 'Color Picker', 'cherry-search' ),
						'description'	=> esc_html__( 'Description color picker.', 'cherry-search' ),
						'class'			=> '',
						'value'			=> '#3da3ce',
						'label'			=> '',
					),
					'icon_3' => array(
						'type'					=> 'iconpicker',
						'parent'				=> 'tab_horizontal_4',
						'title'					=> esc_html__( 'Icon Picker', 'cherry-search' ),
						'description'			=> esc_html__( 'Description color picker.', 'cherry-search' ),
						'value'					=> 'fa-wordpress',
						'icon_data'				=> array(
							'icon_set'		=> 'cherryWidgetFontAwesome',
							'icon_css'		=> esc_url( CHERRY_SEARCH_URI . 'assets/css/min/font-awesome.min.css' ),
							'icon_base'		=> 'fa',
							'icon_prefix'	=> 'fa-',
							'icons'			=> $this->get_icons_set(),
						),
					),

					'media_image_3' => array(
						'type'					=> 'media',
						'parent'				=> 'tab_horizontal_3',
						'title'					=> esc_html__( 'Choose Image', 'cherry-search' ),
						'description'			=> esc_html__( 'Description choose image.', 'cherry-search' ),
						'value'					=> '',
						'multi_upload'			=> false,
						'library_type'			=> 'image',
						'upload_button_text'	=> esc_html__( 'Choose Media', 'cherry-search' ),
						'class'					=> '',
						'label'					=> '',
					),
					'media_multi_image_3' => array(
						'type'					=> 'media',
						'parent'				=> 'tab_horizontal_3',
						'title'					=> esc_html__( 'Multi Choose Image', 'cherry-search' ),
						'description'			=> esc_html__( 'Description multi choose image.', 'cherry-search' ),
						'value'					=> '',
						'multi_upload'			=> true,
						'library_type'			=> 'image',
						'upload_button_text'	=> esc_html__( 'Choose Media', 'cherry-search' ),
						'class'					=> '',
						'label'					=> '',
					),
					'media_video_3' => array(
						'type'					=> 'media',
						'parent'				=> 'tab_horizontal_3',
						'title'					=> esc_html__( 'Choose Video', 'cherry-search' ),
						'description'			=> esc_html__( 'Description choose video.', 'cherry-search' ),
						'value'					=> '',
						'multi_upload'			=> false,
						'library_type'			=> 'video',
						'upload_button_text'	=> esc_html__( 'Choose Media', 'cherry-search' ),
						'class'					=> '',
						'label'					=> '',
					),
					'radio_3' => array(
						'type'					=> 'radio',
						'parent'				=> 'tab_horizontal_3',
						'title'					=> esc_html__( 'Radio Button', 'cherry-search' ),
						'description'			=> esc_html__( 'Adds radio buttons group. Lets user select one option from the list.', 'cherry-search' ),
						'value'					=> 'radio-1',
						'options'				=> array(
							'radio-1' => array(
								'label' => 'Radio #1',
							),
							'radio-2' => array(
								'label' => 'Radio #2',
							),
							'radio-3' => array(
								'label' => 'Radio #3',
							),
						),
						'class'					=> '',
						'label'					=> '',
					),

					'radio_image_3' => array(
						'type'			=> 'radio',
						'parent'		=> 'tab_horizontal_2',
						'title'			=> esc_html__( 'Image Radio Button', 'cherry-search' ),
						'description'	=> esc_html__( 'Adds image based radio buttons group. Behaves as HTML radio buttons.', 'cherry-search' ),
						'value'			=> 'grid-layout',
						'class'			=> '',
						'display_input'	=> false,
						'options'	=> array(
							'grid-layout' => array(
								'label'		=> esc_html__( 'Grid', 'cherry-search' ),
								'img_src'	=> CHERRY_SEARCH_URI . 'assets/img/svg/list-layout-grid.svg',
							),
							'masonry-layout' => array(
								'label'		=> esc_html__( 'Masonry', 'cherry-search' ),
								'img_src'	=> CHERRY_SEARCH_URI . 'assets/img/svg/list-layout-masonry.svg',
							),
							'justified-layout' => array(
								'label'		=> esc_html__( 'Justified', 'cherry-search' ),
								'img_src'	=> CHERRY_SEARCH_URI . 'assets/img/svg/list-layout-justified.svg',
							),
							'cascading-grid-layout' => array(
								'label'		=> esc_html__( 'Cascading grid', 'cherry-search' ),
								'img_src'	=> CHERRY_SEARCH_URI . 'assets/img/svg/list-layout-cascading-grid.svg',
							),
							'list-layout' => array(
								'label'		=> esc_html__( 'List', 'cherry-search' ),
								'img_src'	=> CHERRY_SEARCH_URI . 'assets/img/svg/list-layout-listing.svg',
							),
						),
					),
					'select_3' => array(
						'type'			=> 'select',
						'parent'		=> 'tab_horizontal_2',
						'title'			=> esc_html__( 'Select', 'cherry-search' ),
						'description'	=> esc_html__( 'Description select.', 'cherry-search' ),
						'multiple'		=> false,
						'filter'		=> true,
						'value'			=> 'select-8',
						'options'		=> array(
							'select-1'	=> 'select 1',
							'select-2'	=> 'select 2',
							'select-3'	=> 'select 3',
							'select-4'	=> 'select 4',
							'select-5'	=> 'select 5',
							'optgroup-1'	=> array(
								'label' => 'Group 1',
								'group_options' => array(
									'select-6'	=> 'select 6',
									'select-7'	=> 'select 7',
									'select-8'	=> 'select 8',
								),
							),
							'optgroup-2'	=> array(
								'label' => 'Group 2',
								'group_options' => array(
									'select-9'	=> 'select 9',
									'select-10'	=> 'select 10',
									'select-11'	=> 'select 11',
								),
							),
						),
						'placeholder'	=> 'Select',
						'label'			=> '',
						'class'			=> '',
					),
					'multi_select_3' => array(
						'type'			=> 'select',
						'parent'		=> 'tab_horizontal_2',
						'title'			=> esc_html__( 'Multi Select', 'cherry-search' ),
						'description'	=> esc_html__( 'Description multi select.', 'cherry-search' ),
						'multiple'		=> true,
						'filter'		=> true,
						'value'			=> array( 'select-2', 'select-4' ),
						'options'		=> array(
							'select-1'	=> 'select 1',
							'select-2'	=> 'select 2',
							'select-3'	=> 'select 3',
							'select-4'	=> 'select 4',
							'select-5'	=> 'select 5',
						),
						'placeholder'	=> 'Select',
						'label'			=> '',
						'class'			=> '',
					),
					'slider_3' => array(
						'type'			=> 'slider',
						'parent'		=> 'tab_horizontal_2',
						'title'			=> esc_html__( 'Slider', 'cherry-search' ),
						'description'	=> esc_html__( 'Draggable slider with stepper. Used to define some numeric value.', 'cherry-search' ),
						'value'			=> 250,
						'max_value'		=> 500,
						'min_value'		=> 0,
						'step_value'	=> 1,
						'class'			=> '',
						'label'			=> '',
					),

					'stepper_3' => array(
						'type'					=> 'stepper',
						'parent'				=> 'tab_horizontal_1',
						'title'					=> esc_html__( 'Stepper', 'cherry-search' ),
						'description'			=> esc_html__( 'Adds a number input used to define numeric values.', 'cherry-search' ),
						'value'					=> 150,
						'max_value'				=> 400,
						'min_value'				=> 0,
						'step_value'			=> 1,
						'class'					=> '',
						'label'					=> '',
					),
					'switcher_3' => array(
						'type'					=> 'switcher',
						'parent'				=> 'tab_horizontal_1',
						'title'					=> esc_html__( 'Switcher', 'cherry-search' ),
						'description'			=> esc_html__( 'Analogue of the regular HTML radio buttons.', 'cherry-search' ),
						'value'				=> 'true',
						'toggle'			=> array(
							'true_toggle'	=> 'On',
							'false_toggle'	=> 'Off',
						),
						'style'				=> 'normal',
						'class'					=> '',
						'label'					=> '',
					),
					'text_3' => array(
						'type'					=> 'text',
						'parent'				=> 'tab_horizontal_1',
						'title'					=> esc_html__( 'Text', 'cherry-search' ),
						'description'			=> esc_html__( 'Description text.', 'cherry-search' ),
						'value'					=> '',
						'placeholder'			=> esc_html__( 'Input Text', 'cherry-search' ),
						'class'					=> '',
						'label'					=> '',
					),
					'textarea_3' => array(
						'type'					=> 'textarea',
						'parent'				=> 'tab_horizontal_1',
						'title'					=> esc_html__( 'Text Area', 'cherry-search' ),
						'description'			=> esc_html__( 'Description text area.', 'cherry-search' ),
						'value'					=> '',
						'placeholder'			=> esc_html__( 'Input Text', 'cherry-search' ),
						'rows'					=> '10',
						'cols'					=> '20',
						'class'					=> '',
						'label'					=> '',
					),
				)
			);

			$this->builder->register_control(
				array(
					'checkbox_4' => array(
						'type'			=> 'checkbox',
						'parent'		=> 'accordion_1',
						'title'			=> esc_html__( 'Checkbox', 'cherry-search' ),
						'description'	=> esc_html__( 'Description checkbox.', 'cherry-search' ),
						'class'			=> '',
						'value'			=> array(
							'checkbox' => 'true',
						),
						'options'		=> array(
							'checkbox' => esc_html__( 'Check Me', 'cherry-search' ),
						),
					),
					'checkbox_multi_4' => array(
						'type'			=> 'checkbox',
						'parent'		=> 'accordion_1',
						'title'			=> esc_html__( 'Multi Checkbox', 'cherry-search' ),
						'description'	=> esc_html__( 'Description multi checkbox.', 'cherry-search' ),
						'class'			=> '',
						'value'			=> array(
							'checkbox-0' => 'true',
							'checkbox-1' => 'false',
							'checkbox-2' => 'false',
							'checkbox-3' => 'true',
							'checkbox-4' => 'true',
						),
						'options'		=> array(
							'checkbox-0' => esc_html__( 'Check Me #1', 'cherry-search' ),
							'checkbox-1' => esc_html__( 'Check Me #2', 'cherry-search' ),
							'checkbox-2' => esc_html__( 'Check Me #3', 'cherry-search' ),
							'checkbox-3' => esc_html__( 'Check Me #4', 'cherry-search' ),
							'checkbox-4' => esc_html__( 'Check Me #5', 'cherry-search' ),
						),
					),
					'colorpicker_4' => array(
						'type'			=> 'colorpicker',
						'parent'		=> 'accordion_1',
						'title'			=> esc_html__( 'Color Picker', 'cherry-search' ),
						'description'	=> esc_html__( 'Description color picker.', 'cherry-search' ),
						'class'			=> '',
						'value'			=> '#3da3ce',
						'label'			=> '',
					),
					'icon_4' => array(
						'type'					=> 'iconpicker',
						'parent'				=> 'accordion_1',
						'title'					=> esc_html__( 'Icon Picker', 'cherry-search' ),
						'description'			=> esc_html__( 'Description color picker.', 'cherry-search' ),
						'value'					=> 'fa-wordpress',
						'icon_data'				=> array(
							'icon_set'		=> 'cherryWidgetFontAwesome',
							'icon_css'		=> esc_url( CHERRY_SEARCH_URI . 'assets/css/min/font-awesome.min.css' ),
							'icon_base'		=> 'fa',
							'icon_prefix'	=> 'fa-',
							'icons'			=> $this->get_icons_set(),
						),
					),

					'media_image_4' => array(
						'type'					=> 'media',
						'parent'				=> 'accordion_2',
						'title'					=> esc_html__( 'Choose Image', 'cherry-search' ),
						'description'			=> esc_html__( 'Description choose image.', 'cherry-search' ),
						'value'					=> '',
						'multi_upload'			=> false,
						'library_type'			=> 'image',
						'upload_button_text'	=> esc_html__( 'Choose Media', 'cherry-search' ),
						'class'					=> '',
						'label'					=> '',
					),
					'media_multi_image_4' => array(
						'type'					=> 'media',
						'parent'				=> 'accordion_2',
						'title'					=> esc_html__( 'Multi Choose Image', 'cherry-search' ),
						'description'			=> esc_html__( 'Description multi choose image.', 'cherry-search' ),
						'value'					=> '',
						'multi_upload'			=> true,
						'library_type'			=> 'image',
						'upload_button_text'	=> esc_html__( 'Choose Media', 'cherry-search' ),
						'class'					=> '',
						'label'					=> '',
					),
					'media_video_4' => array(
						'type'					=> 'media',
						'parent'				=> 'accordion_2',
						'title'					=> esc_html__( 'Choose Video', 'cherry-search' ),
						'description'			=> esc_html__( 'Description choose video.', 'cherry-search' ),
						'value'					=> '',
						'multi_upload'			=> false,
						'library_type'			=> 'video',
						'upload_button_text'	=> esc_html__( 'Choose Media', 'cherry-search' ),
						'class'					=> '',
						'label'					=> '',
					),
					'radio_4' => array(
						'type'					=> 'radio',
						'parent'				=> 'accordion_2',
						'title'					=> esc_html__( 'Radio Button', 'cherry-search' ),
						'description'			=> esc_html__( 'Adds radio buttons group. Lets user select one option from the list.', 'cherry-search' ),
						'value'					=> 'radio-1',
						'options'				=> array(
							'radio-1' => array(
								'label' => 'Radio #1',
							),
							'radio-2' => array(
								'label' => 'Radio #2',
							),
							'radio-3' => array(
								'label' => 'Radio #3',
							),
						),
						'class'					=> '',
						'label'					=> '',
					),

					'radio_image_4' => array(
						'type'			=> 'radio',
						'parent'		=> 'accordion_3',
						'title'			=> esc_html__( 'Image Radio Button', 'cherry-search' ),
						'description'	=> esc_html__( 'Adds image based radio buttons group. Behaves as HTML radio buttons.', 'cherry-search' ),
						'value'			=> 'grid-layout',
						'class'			=> '',
						'display_input'	=> false,
						'options'	=> array(
							'grid-layout' => array(
								'label'		=> esc_html__( 'Grid', 'cherry-search' ),
								'img_src'	=> CHERRY_SEARCH_URI . 'assets/img/svg/list-layout-grid.svg',
							),
							'masonry-layout' => array(
								'label'		=> esc_html__( 'Masonry', 'cherry-search' ),
								'img_src'	=> CHERRY_SEARCH_URI . 'assets/img/svg/list-layout-masonry.svg',
							),
							'justified-layout' => array(
								'label'		=> esc_html__( 'Justified', 'cherry-search' ),
								'img_src'	=> CHERRY_SEARCH_URI . 'assets/img/svg/list-layout-justified.svg',
							),
							'cascading-grid-layout' => array(
								'label'		=> esc_html__( 'Cascading grid', 'cherry-search' ),
								'img_src'	=> CHERRY_SEARCH_URI . 'assets/img/svg/list-layout-cascading-grid.svg',
							),
							'list-layout' => array(
								'label'		=> esc_html__( 'List', 'cherry-search' ),
								'img_src'	=> CHERRY_SEARCH_URI . 'assets/img/svg/list-layout-listing.svg',
							),
						),
					),
					'select_4' => array(
						'type'			=> 'select',
						'parent'		=> 'accordion_3',
						'title'			=> esc_html__( 'Select', 'cherry-search' ),
						'description'	=> esc_html__( 'Description select.', 'cherry-search' ),
						'multiple'		=> false,
						'filter'		=> true,
						'value'			=> 'select-8',
						'options'		=> array(
							'select-1'	=> 'select 1',
							'select-2'	=> 'select 2',
							'select-3'	=> 'select 3',
							'select-4'	=> 'select 4',
							'select-5'	=> 'select 5',
							'optgroup-1'	=> array(
								'label' => 'Group 1',
								'group_options' => array(
									'select-6'	=> 'select 6',
									'select-7'	=> 'select 7',
									'select-8'	=> 'select 8',
								),
							),
							'optgroup-2'	=> array(
								'label' => 'Group 2',
								'group_options' => array(
									'select-9'	=> 'select 9',
									'select-10'	=> 'select 10',
									'select-11'	=> 'select 11',
								),
							),
						),
						'placeholder'	=> 'Select',
						'label'			=> '',
						'class'			=> '',
					),
					'multi_select_4' => array(
						'type'			=> 'select',
						'parent'		=> 'accordion_3',
						'title'			=> esc_html__( 'Multi Select', 'cherry-search' ),
						'description'	=> esc_html__( 'Description multi select.', 'cherry-search' ),
						'multiple'		=> true,
						'filter'		=> true,
						'value'			=> array( 'select-2', 'select-4' ),
						'options'		=> array(
							'select-1'	=> 'select 1',
							'select-2'	=> 'select 2',
							'select-3'	=> 'select 3',
							'select-4'	=> 'select 4',
							'select-5'	=> 'select 5',
						),
						'placeholder'	=> 'Select',
						'label'			=> '',
						'class'			=> '',
					),
					'slider_4' => array(
						'type'			=> 'slider',
						'parent'		=> 'accordion_3',
						'title'			=> esc_html__( 'Slider', 'cherry-search' ),
						'description'	=> esc_html__( 'Draggable slider with stepper. Used to define some numeric value.', 'cherry-search' ),
						'value'			=> 250,
						'max_value'		=> 500,
						'min_value'		=> 0,
						'step_value'	=> 1,
						'class'			=> '',
						'label'			=> '',
					),

					'stepper_4' => array(
						'type'					=> 'stepper',
						'parent'				=> 'accordion_4',
						'title'					=> esc_html__( 'Stepper', 'cherry-search' ),
						'description'			=> esc_html__( 'Adds a number input used to define numeric values.', 'cherry-search' ),
						'value'					=> 150,
						'max_value'				=> 400,
						'min_value'				=> 0,
						'step_value'			=> 1,
						'class'					=> '',
						'label'					=> '',
					),
					'switcher_4' => array(
						'type'					=> 'switcher',
						'parent'				=> 'accordion_4',
						'title'					=> esc_html__( 'Switcher', 'cherry-search' ),
						'description'			=> esc_html__( 'Analogue of the regular HTML radio buttons.', 'cherry-search' ),
						'value'				=> 'true',
						'toggle'			=> array(
							'true_toggle'	=> 'On',
							'false_toggle'	=> 'Off',
						),
						'style'				=> 'normal',
						'class'					=> '',
						'label'					=> '',
					),
					'text_4' => array(
						'type'					=> 'text',
						'parent'				=> 'accordion_4',
						'title'					=> esc_html__( 'Text', 'cherry-search' ),
						'description'			=> esc_html__( 'Description text.', 'cherry-search' ),
						'value'					=> '',
						'placeholder'			=> esc_html__( 'Input Text', 'cherry-search' ),
						'class'					=> '',
						'label'					=> '',
					),
					'textarea_4' => array(
						'type'					=> 'textarea',
						'parent'				=> 'accordion_4',
						'title'					=> esc_html__( 'Text Area', 'cherry-search' ),
						'description'			=> esc_html__( 'Description text area.', 'cherry-search' ),
						'value'					=> '',
						'placeholder'			=> esc_html__( 'Input Text', 'cherry-search' ),
						'rows'					=> '10',
						'cols'					=> '20',
						'class'					=> '',
						'label'					=> '',
					),
				)
			);

			$this->builder->register_control(
				array(
					'checkbox_5' => array(
						'type'			=> 'checkbox',
						'parent'		=> 'toggle_4',
						'title'			=> esc_html__( 'Checkbox', 'cherry-search' ),
						'description'	=> esc_html__( 'Description checkbox.', 'cherry-search' ),
						'class'			=> '',
						'value'			=> array(
							'checkbox' => 'true',
						),
						'options'		=> array(
							'checkbox' => esc_html__( 'Check Me', 'cherry-search' ),
						),
					),
					'checkbox_multi_5' => array(
						'type'			=> 'checkbox',
						'parent'		=> 'toggle_4',
						'title'			=> esc_html__( 'Multi Checkbox', 'cherry-search' ),
						'description'	=> esc_html__( 'Description multi checkbox.', 'cherry-search' ),
						'class'			=> '',
						'value'			=> array(
							'checkbox-0' => 'true',
							'checkbox-1' => 'false',
							'checkbox-2' => 'false',
							'checkbox-3' => 'true',
							'checkbox-4' => 'true',
						),
						'options'		=> array(
							'checkbox-0' => esc_html__( 'Check Me #1', 'cherry-search' ),
							'checkbox-1' => esc_html__( 'Check Me #2', 'cherry-search' ),
							'checkbox-2' => esc_html__( 'Check Me #3', 'cherry-search' ),
							'checkbox-3' => esc_html__( 'Check Me #4', 'cherry-search' ),
							'checkbox-4' => esc_html__( 'Check Me #5', 'cherry-search' ),
						),
					),
					'colorpicker_5' => array(
						'type'			=> 'colorpicker',
						'parent'		=> 'toggle_4',
						'title'			=> esc_html__( 'Color Picker', 'cherry-search' ),
						'description'	=> esc_html__( 'Description color picker.', 'cherry-search' ),
						'class'			=> '',
						'value'			=> '#3da3ce',
						'label'			=> '',
					),
					'icon_5' => array(
						'type'					=> 'iconpicker',
						'parent'				=> 'toggle_4',
						'title'					=> esc_html__( 'Color Picker', 'cherry-search' ),
						'description'			=> esc_html__( 'Description color picker.', 'cherry-search' ),
						'value'					=> 'fa-wordpress',
						'icon_data'				=> array(
							'icon_set'		=> 'cherryWidgetFontAwesome',
							'icon_css'		=> esc_url( CHERRY_SEARCH_URI . 'assets/css/min/font-awesome.min.css' ),
							'icon_base'		=> 'fa',
							'icon_prefix'	=> 'fa-',
							'icons'			=> $this->get_icons_set(),
						),
					),

					'media_image_5' => array(
						'type'					=> 'media',
						'parent'				=> 'toggle_3',
						'title'					=> esc_html__( 'Choose Image', 'cherry-search' ),
						'description'			=> esc_html__( 'Description choose image.', 'cherry-search' ),
						'value'					=> '',
						'multi_upload'			=> false,
						'library_type'			=> 'image',
						'upload_button_text'	=> esc_html__( 'Choose Media', 'cherry-search' ),
						'class'					=> '',
						'label'					=> '',
					),
					'media_multi_image_5' => array(
						'type'					=> 'media',
						'parent'				=> 'toggle_3',
						'title'					=> esc_html__( 'Multi Choose Image', 'cherry-search' ),
						'description'			=> esc_html__( 'Description multi choose image.', 'cherry-search' ),
						'value'					=> '',
						'multi_upload'			=> true,
						'library_type'			=> 'image',
						'upload_button_text'	=> esc_html__( 'Choose Media', 'cherry-search' ),
						'class'					=> '',
						'label'					=> '',
					),
					'media_video_5' => array(
						'type'					=> 'media',
						'parent'				=> 'toggle_3',
						'title'					=> esc_html__( 'Choose Video', 'cherry-search' ),
						'description'			=> esc_html__( 'Description choose video.', 'cherry-search' ),
						'value'					=> '',
						'multi_upload'			=> false,
						'library_type'			=> 'video',
						'upload_button_text'	=> esc_html__( 'Choose Media', 'cherry-search' ),
						'class'					=> '',
						'label'					=> '',
					),
					'radio_5' => array(
						'type'					=> 'radio',
						'parent'				=> 'toggle_3',
						'title'					=> esc_html__( 'Radio Button', 'cherry-search' ),
						'description'			=> esc_html__( 'Adds radio buttons group. Lets user select one option from the list.', 'cherry-search' ),
						'value'					=> 'radio-1',
						'options'				=> array(
							'radio-1' => array(
								'label' => 'Radio #1',
							),
							'radio-2' => array(
								'label' => 'Radio #2',
							),
							'radio-3' => array(
								'label' => 'Radio #3',
							),
						),
						'class'					=> '',
						'label'					=> '',
					),

					'radio_image_5' => array(
						'type'			=> 'radio',
						'parent'		=> 'toggle_2',
						'title'			=> esc_html__( 'Image Radio Button', 'cherry-search' ),
						'description'	=> esc_html__( 'Adds image based radio buttons group. Behaves as HTML radio buttons.', 'cherry-search' ),
						'value'			=> 'grid-layout',
						'class'			=> '',
						'display_input'	=> false,
						'options'	=> array(
							'grid-layout' => array(
								'label'		=> esc_html__( 'Grid', 'cherry-search' ),
								'img_src'	=> CHERRY_SEARCH_URI . 'assets/img/svg/list-layout-grid.svg',
							),
							'masonry-layout' => array(
								'label'		=> esc_html__( 'Masonry', 'cherry-search' ),
								'img_src'	=> CHERRY_SEARCH_URI . 'assets/img/svg/list-layout-masonry.svg',
							),
							'justified-layout' => array(
								'label'		=> esc_html__( 'Justified', 'cherry-search' ),
								'img_src'	=> CHERRY_SEARCH_URI . 'assets/img/svg/list-layout-justified.svg',
							),
							'cascading-grid-layout' => array(
								'label'		=> esc_html__( 'Cascading grid', 'cherry-search' ),
								'img_src'	=> CHERRY_SEARCH_URI . 'assets/img/svg/list-layout-cascading-grid.svg',
							),
							'list-layout' => array(
								'label'		=> esc_html__( 'List', 'cherry-search' ),
								'img_src'	=> CHERRY_SEARCH_URI . 'assets/img/svg/list-layout-listing.svg',
							),
						),
					),
					'select_5' => array(
						'type'			=> 'select',
						'parent'		=> 'toggle_2',
						'title'			=> esc_html__( 'Select', 'cherry-search' ),
						'description'	=> esc_html__( 'Description select.', 'cherry-search' ),
						'multiple'		=> false,
						'filter'		=> true,
						'value'			=> 'select-8',
						'options'		=> array(
							'select-1'	=> 'select 1',
							'select-2'	=> 'select 2',
							'select-3'	=> 'select 3',
							'select-4'	=> 'select 4',
							'select-5'	=> 'select 5',
							'optgroup-1'	=> array(
								'label' => 'Group 1',
								'group_options' => array(
									'select-6'	=> 'select 6',
									'select-7'	=> 'select 7',
									'select-8'	=> 'select 8',
								),
							),
							'optgroup-2'	=> array(
								'label' => 'Group 2',
								'group_options' => array(
									'select-9'	=> 'select 9',
									'select-10'	=> 'select 10',
									'select-11'	=> 'select 11',
								),
							),
						),
						'placeholder'	=> 'Select',
						'label'			=> '',
						'class'			=> '',
					),
					'multi_select_5' => array(
						'type'			=> 'select',
						'parent'		=> 'toggle_2',
						'title'			=> esc_html__( 'Multi Select', 'cherry-search' ),
						'description'	=> esc_html__( 'Description multi select.', 'cherry-search' ),
						'multiple'		=> true,
						'filter'		=> true,
						'value'			=> array( 'select-2', 'select-4' ),
						'options'		=> array(
							'select-1'	=> 'select 1',
							'select-2'	=> 'select 2',
							'select-3'	=> 'select 3',
							'select-4'	=> 'select 4',
							'select-5'	=> 'select 5',
						),
						'placeholder'	=> 'Select',
						'label'			=> '',
						'class'			=> '',
					),
					'slider_5' => array(
						'type'			=> 'slider',
						'parent'		=> 'toggle_2',
						'title'			=> esc_html__( 'Slider', 'cherry-search' ),
						'description'	=> esc_html__( 'Draggable slider with stepper. Used to define some numeric value.', 'cherry-search' ),
						'value'			=> 250,
						'max_value'		=> 500,
						'min_value'		=> 0,
						'step_value'	=> 1,
						'class'			=> '',
						'label'			=> '',
					),

					'stepper_5' => array(
						'type'					=> 'stepper',
						'parent'				=> 'toggle_1',
						'title'					=> esc_html__( 'Stepper', 'cherry-search' ),
						'description'			=> esc_html__( 'Adds a number input used to define numeric values.', 'cherry-search' ),
						'value'					=> 150,
						'max_value'				=> 400,
						'min_value'				=> 0,
						'step_value'			=> 1,
						'class'					=> '',
						'label'					=> '',
					),
					'switcher_5' => array(
						'type'					=> 'switcher',
						'parent'				=> 'toggle_1',
						'title'					=> esc_html__( 'Switcher', 'cherry-search' ),
						'description'			=> esc_html__( 'Analogue of the regular HTML radio buttons.', 'cherry-search' ),
						'value'				=> 'true',
						'toggle'			=> array(
							'true_toggle'	=> 'On',
							'false_toggle'	=> 'Off',
						),
						'style'				=> 'normal',
						'class'					=> '',
						'label'					=> '',
					),
					'text_5' => array(
						'type'					=> 'text',
						'parent'				=> 'toggle_1',
						'title'					=> esc_html__( 'Text', 'cherry-search' ),
						'description'			=> esc_html__( 'Description text.', 'cherry-search' ),
						'value'					=> '',
						'placeholder'			=> esc_html__( 'Input Text', 'cherry-search' ),
						'class'					=> '',
						'label'					=> '',
					),
					'textarea_5' => array(
						'type'					=> 'textarea',
						'parent'				=> 'toggle_1',
						'title'					=> esc_html__( 'Text Area', 'cherry-search' ),
						'description'			=> esc_html__( 'Description text area.', 'cherry-search' ),
						'value'					=> '',
						'placeholder'			=> esc_html__( 'Input Text', 'cherry-search' ),
						'rows'					=> '10',
						'cols'					=> '20',
						'class'					=> '',
						'label'					=> '',
					),
				)
			);

			$this->builder->render();
		}

		/**
		 * Get icons set
		 *
		 * @return array
		 */
		private function get_icons_set() {
			ob_start();

			include CHERRY_SEARCH_DIR . 'assets/fonts/icons.json';

			$json = ob_get_clean();
			$result = array();
			$icons = json_decode( $json, true );

			foreach ( $icons['icons'] as $icon ) {
				$result[] = $icon['id'];
			}

			return $result;
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
