<?php
/**
 * Cherry Search.
 *
 * @package    Cherry_Template_Manager
 * @subpackage Admin
 * @author     Cherry Team
 * @license    GPL-3.0+
 * @copyright  2012-2016, Cherry Team
 */

// If class `Cherry_Template_Manager` doesn't exists yet.
if ( ! class_exists( 'Cherry_Template_Manager' ) ) {

	/**
	 * Cherry_Template_Manager class.
	 */
	class Cherry_Template_Manager{

		/**
		 * Retrieve a *.tmpl file content.
		 *
		 * @since  1.0.0
		 * @param  string $name  File name.
		 * @access protected
		 * @return string
		 */
		protected function get_template_by_name( $name ) {
			$file       = '';
			$upload_dir = wp_upload_dir();
			$upload_dir = trailingslashit( $upload_dir['basedir'] );
			$default    = CHERRY_SEARCH_DIR . 'templates/' . $name . '.tmpl';
			$subdir     = 'templates/' . CHERRY_SEARCH_SLUG . '/' . $name . '.tmpl';

			if ( file_exists( $upload_dir . $subdir ) ) {
				$file = $upload_dir . $subdir;
			} elseif ( $theme_template = locate_template( $subdir ) ) {
				$file = $theme_template;
			} else {
				$file = $default;
			}

			if ( ! empty( $file ) ) {
				return self::get_contents( $file );
			}else{
				return false;
			}
		}

		/**
		 * Read template (static).
		 *
		 * @since  1.0.0
		 * @return bool|WP_Error|string - false on failure, stored text on success.
		 */
		public static function get_contents( $file ) {

			if ( ! function_exists( 'WP_Filesystem' ) ) {
				include_once( ABSPATH . '/wp-admin/includes/file.php' );
			}

			WP_Filesystem();
			global $wp_filesystem;

			// Check for existence.
			if ( ! $wp_filesystem->exists( $file ) ) {
				return false;
			}

			// Read the file.
			$content = $wp_filesystem->get_contents( $file );

			if ( ! $content ) {
				// Return error object.
				return new WP_Error( 'reading_error', 'Error when reading file' );
			}

			return $content;
		}

		/**
		 * Callback to replace macros with data.
		 *
		 * @since 1.0.0
		 * @param array $matches Founded macros.
		 * @access protected
		 */
		protected function replace_callback( $matches ) {

			if ( ! is_array( $matches ) ) {
				return;
			}

			if ( empty( $matches ) ) {
				return;
			}

			$item   = trim( $matches[0], '%%' );
			$arr    = explode( ' ', $item, 2 );
			$macros = strtolower( $arr[0] );
			$attr   = isset( $arr[1] ) ? shortcode_parse_atts( $arr[1] ) : array();

			$callback = array( $this, 'get_' + $macros );

			if ( ! is_callable( $callback ) || ! isset( $this->post_data[ $macros ] ) ) {
				return;
			}

			if ( ! empty( $attr ) ) {

				// Call a WordPress function.
				return call_user_func( $callback, $attr );
			}

			return call_user_func( $callback );
		}
	}
}
