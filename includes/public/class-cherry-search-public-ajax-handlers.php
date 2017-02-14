<?php
/**
 * Sets ajax handlers for search result.
 *
 * @package    Cherry_Search
 * @subpackage Public
 * @author     Cherry Team
 * @license    GPL-3.0+
 * @copyright  2012-2016, Cherry Team
 */

// If class `Cherry_Search_Public_Ajax_Handlers` doesn't exists yet.
if ( ! class_exists( 'Cherry_Search_Public_Ajax_Handlers' ) ) {

	/**
	 * Cherry_Search_Public_Ajax_Handlers class.
	 */
	class Cherry_Search_Public_Ajax_Handlers extends Cherry_Search_Settings_Manager {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var object
		 */
		private static $instance = null;

		/**
		 * Sistem message.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    array
		 */
		public $sys_messages = null;

		/**
		 * Class constructor.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function __construct() {
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
					'id'           => 'cherry_search_public_action',
					'action'       => 'cherry_search_public_action',
					'is_public'    => true,
					'callback'     => array( $this , 'searchQuery' ),
					'type'         => 'GET',
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
		public function searchQuery() {
			if ( empty( $_GET['data'] ) ) {
				return;
			}

			$data                           = $_GET['data'];
			$limit_query                    = ( int ) $data['limit_query'];

			$this->search_query['s']        = urldecode( $data['value'] );
			$this->search_query['nopaging'] = false;
			$this->search_query['posts_per_page'] = $limit_query + 1;
			$this->set_query_settings( $data );

			$search = new WP_Query( $this->search_query );
			$response = array(
				'error'      => false,
				'post_count' => 0,
				'message'    => '',
				'posts'       => null,
			);

			if ( is_wp_error( $search ) ) {
				$response['error']   = true;
				$response['message'] = esc_html( $data['server_error'] );

				return $response;
			}

			if ( empty( $search->post_count ) ) {
				$response['message'] = esc_html( $data['negative_search'] );

				return $response;
			}

			$after             = '&hellip;';
			$length            = ( int ) $data['limit_content_word'];
			$thumbnail_visible = filter_var( $data['thumbnail_visible'], FILTER_VALIDATE_BOOLEAN );
			$title_visible     = filter_var( $data['title_visible'], FILTER_VALIDATE_BOOLEAN );
			$author_visible    = filter_var( $data['author_visible'], FILTER_VALIDATE_BOOLEAN );

			$author_prefix     = esc_html( $data['author_prefix'] );
			$author_html       = apply_filters( 'cherry_search_author_html', '<span>%1$s </span> <em>%2$s</em>' );

			$more_button_html  = apply_filters( 'cherry_search_more_button_html', '<li class="cherry-search__more-button">%s</li>' );
			$more_button_text  = esc_html( $data['more_button'] );
			$more_button       = sprintf( $more_button_html, $more_button_text );

			$response['posts']      = array();
			$response['post_count'] = $search->post_count;
			$response['more_posts'] = ( $limit_query < $search->post_count ) ? true : false ;

			foreach ( $search->posts as $key => $value ) {

				if ( 0 !== $length ) {
					$content = strip_shortcodes( $value->post_content );
					$content = wp_trim_words( $content, $length, $after );
				} else {
					$content = '';
				}

				$response['posts'][ $key ] = array(
					'content'   => $content,
					'title'     => ( true === $title_visible ) ? $value->post_title : '',
					'link'      => esc_url( get_post_permalink( $value->ID ) ),
					'thumbnail' => ( true === $thumbnail_visible ) ? $this->get_post_thumbnail( $value->ID, $value->post_title ) : '',
					'author'    => ( true === $author_visible ) ? sprintf( $author_html, $author_prefix, get_author_name( $value->post_author ) ) : '',
				);

				if ( $key >= $limit_query - 1 ) {
					$response['posts']['more_button'] = $more_button;
					break;
				}
			}
			return $response;
		}

		/**
		 * Return post thumbnail.
		 *
		 * @since 1.0.0
		 * @access private
		 * @return string
		 */
		private function get_post_thumbnail( $posy_id, $title ) {
			$thumbnail_size = apply_filters( 'cherry_search_thumbnail_size', 'thumbnail' );
			$output_html = get_the_post_thumbnail( $posy_id, $thumbnail_size );

			if ( ! $output_html ) {
				$args = apply_filters( 'cherry_search_placeholder', array(
					'width'      => 150,
					'height'     => 150,
					'background' => '000',
					'foreground' => 'fff',
					'title'      => $title,
				) );

				$args      = array_map( 'urlencode', $args );
				$base_url  = 'http://fakeimg.pl';
				$format    = '<img src="%1$s/%2$sx%3$s/%4$s/%5$s/?text=%6$s" alt="%7$s" >';

				$output_html = sprintf(
					$format,
					$base_url, $args['width'], $args['height'], $args['background'], $args['foreground'], $args['title'], $args['title']
				);
			}

			return $output_html;
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

if ( ! function_exists( 'cherry_search_public_ajax_handlers' ) ) {

	/**
	 * Returns instanse of the plugin class.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	function cherry_search_public_ajax_handlers() {
		return Cherry_Search_Public_Ajax_Handlers::get_instance();
	}

	cherry_search_public_ajax_handlers();
}
