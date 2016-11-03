<?php
/**
 * Cherry Search.
 *
 * @package    Cherry_Search_Settings_Manager
 * @subpackage Admin
 * @author     Cherry Team
 * @license    GPL-3.0+
 * @copyright  2012-2016, Cherry Team
 */

// If class `Cherry_Search_Settings_Manager` doesn't exists yet.
if ( ! class_exists( 'Cherry_Search_Settings_Manager' ) ) {

	/**
	 * Cherry_Search_Settings_Manager class.
	 */
	class Cherry_Search_Settings_Manager{

		/**
		 * Plugin settings.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    array
		 */
		public $settings = null;

		/**
		 * Plugin settings default.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    array
		 */
		public $settings_default = null;

		/**
		 * Sistem message.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    array
		 */
		public $search_query = array();

		/**
		 * Get plugin settings.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return array
		 */
		public function get_settings() {
			$this->settings         = get_option( CHERRY_SEARCH_SLUG, false );
			$this->settings_default = get_option( CHERRY_SEARCH_SLUG . '-default', false );
			$this->settings         = wp_parse_args( $this->settings, $this->settings_default );
		}

		/**
		 * Get plugin setting.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return array
		 */
		public function get_setting( $id ) {
			if ( ! $this->settings || empty( $this->settings ) ) {
				$this->get_settings();
			}

			if ( array_key_exists($id, $this->settings) ) {
				return $this->settings[ $id ];
			} else {
				return;
			}
		}

		/**
		 * Function set search query settings.
		 *
		 * @since 1.0.0
		 * @access private
		 * @return void
		 */
		protected function set_query_settings() {
			$search_source= $this->get_setting( 'search_source' );

			$this->search_query['cache_results']    = true;
			$this->search_query['post_type']        = ! $search_source ? 'any' : $search_source ;
			$this->search_query['order']            = $this->get_setting( 'results_order' );
			$this->search_query['orderby']          = $this->get_setting( 'results_order_by' );
			$this->search_query['tax_query']        = array(
				array(
					'relation' => 'AND',
					array(
						'taxonomy' => 'post_format',
						'field'    => 'slug',
						'operator' => 'NOT IN',
						'terms'    => $this->get_setting( 'exclude_source_post_format' ),
					),
					array(
						'taxonomy' => 'category',
						'field'    => 'slug',
						'operator' => 'NOT IN',
						'terms'    => $this->get_setting( 'exclude_source_category' ),
					),
					array(
						'taxonomy' => 'post_tag',
						'field'    => 'slug',
						'operator' => 'NOT IN',
						'terms'    => $this->get_setting( 'exclude_source_tags' ),
					),
				)
			);
		}
	}
}
