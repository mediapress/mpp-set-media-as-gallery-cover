<?php
/**
 * View hooks.
 *
 * @package mpp-set-media-as-gallery-cover
 */

// Exit if access directly over web.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class MPPSMAGCover_Views_Helper
 */
class MPPSMAGCover_Views_Helper {

	/**
	 * The constructor.
	 */
	public function __construct() {
		$this->setup();
	}

	/**
	 * Call back to various hooks
	 */
	public function setup() {
		// add buttons.
		add_action( 'mpp_media_meta', array( $this, 'add_media_ui' ) );
		add_action( 'mpp_lightbox_media_action_before_link', array( $this, 'add_lightbox_ui' ) );

		add_filter( 'mpp_get_media_class', array( $this, 'modify_media_class' ) );
	}

	/**
	 * Attach button to media to set as cover.
	 *
	 * @return string
	 */
	public function add_media_ui() {

		$media = mpp_get_media();

		if ( ! mppsmagc_is_button_enabled_screen() || ! mppsmagc_user_can_set_cover( $media->id ) ) {
			return '';
		}

		mppsmagc_set_cover_button( $media->id );
	}

	/**
	 * Add button in lightbox.
	 *
	 * @return string
	 */
	public function add_lightbox_ui() {

		$media   = mpp_get_media();
		$screens = mpp_get_option( 'mppsmagc_button_ui_places', array() );

		if ( ! array_key_exists( 'lightbox', $screens ) || ! mppsmagc_user_can_set_cover( $media->id ) ) {
			return '';
		}

		mppsmagc_set_cover_button( $media->id, false );
	}

	/**
	 * Modify media class
	 */
	public function modify_media_class( $class ) {
		$media = mpp_get_current_media();

		if ( $media && mpp_get_gallery_cover_id( $media->gallery_id ) == $media->id ) {
			$class .= ' gallery-cover';
		}

		return $class;
	}
}

new MPPSMAGCover_Views_Helper();
