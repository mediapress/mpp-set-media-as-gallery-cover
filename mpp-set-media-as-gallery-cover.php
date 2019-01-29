<?php
/**
 * Plugin Name: MediaPress Set Media as Gallery Cover
 * Description: Let user set a photo as gallery cover. It is a utility plugin.
 * Plugin URI: https://buddydev.com/plugins/mpp-set-media-as-gallery-cover/
 * Author: BuddyDev
 * Author URI: https://buddydev.com/
 * Version: 1.0.0
 *
 * Text Domain: mpp-featured-content
 * Domain Path: /languages
 */

// Exit if file access directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class MPP_Set_Media_As_Gallery_Cover
 */
class MPP_Set_Media_As_Gallery_Cover {

	/**
	 * Class instance
	 *
	 * @var MPP_Set_Media_As_Gallery_Cover
	 */
	private static $instance = null;

	/**
	 * Plugin directory path
	 *
	 * @var string
	 */
	private $path;

	/**
	 * Plugin directory url
	 *
	 * @var string
	 */
	private $url;

	/**
	 * The constructor.
	 */
	private function __construct() {

		$this->path = plugin_dir_path( __FILE__ );
		$this->url  = plugin_dir_url( __FILE__ );

		$this->setup();
	}

	/**
	 * Get class instance
	 *
	 * @return MPP_Set_Media_As_Gallery_Cover
	 */
	public static function get_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Setup callbacks to mediapress hooks
	 */
	public function setup() {
		add_action( 'mpp_loaded', array( $this, 'load' ) );
		add_action( 'mpp_enqueue_scripts', array( $this, 'load_assets' ) );
		add_action( 'mpp_init', array( $this, 'load_text_domain' ) );
	}

	/**
	 * Load plugins other files
	 */
	public function load() {

		if ( ! function_exists( 'buddypress' ) ) {
			return;
		}

		$files = array(
			'core/mppsmagc-functions.php',
			'core/mppsmagc-templates.php',
			'core/class-mppsmagc-ajax-handler.php',
			'core/class-mppsmagc-view-helper.php',
		);

		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
			$files[] = 'admin/class-mppsmagc-admin-helper.php';
		}

		foreach ( $files as $file ) {
			require_once $this->path . $file;
		}
	}

	/**
	 * Loads plugin assets
	 */
	public function load_assets() {

		if ( ! function_exists( 'buddypress' ) ) {
			return;
		}


		wp_register_script( 'mpp-set-media-as-gallery-cover', $this->url . 'assets/js/mpp-set-media-as-gallery-cover.js', array( 'jquery' ) );

		wp_localize_script( 'mpp-set-media-as-gallery-cover', 'MPPSMAGCover', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		) );

		wp_enqueue_script( 'mpp-set-media-as-gallery-cover' );
	}

	/**
	 * Load plugin language file
	 */
	public function load_text_domain() {
		load_plugin_textdomain( 'mpp-set-media-as-gallery-cover', false, basename( dirname( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Return plugin directory path
	 *
	 * @return string
	 */
	public function get_path() {
		return $this->path;
	}

	/**
	 * Return plugin directory url
	 *
	 * @return string
	 */
	public function get_url() {
		return $this->url;
	}
}

/**
 * Class instance
 *
 * @return MPP_Set_Media_As_Gallery_Cover
 */
function mpp_set_media_as_gallery_cover() {
	return MPP_Set_Media_As_Gallery_Cover::get_instance();
}

mpp_set_media_as_gallery_cover();
