<?php
/**
 * Ajax action handler.
 *
 * @package mpp-set-media-as-gallery-cover
 */

// Exit if file access directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class MPSMAGCover_Ajax_Handler
 */
class MPSMAGCover_Ajax_Handler {

	/**
	 * The constructor.
	 */
	public function __construct() {
		$this->setup();
	}

	/**
	 * Handler function provide callback to process ajax request
	 */
	public function setup() {
		add_action( 'wp_ajax_mppsmagc_set_cover', array( $this, 'process' ) );
	}

	/**
	 * Mark item featured or un featured
	 */
	public function process() {

		check_ajax_referer( 'mppsmagc_set_cover', 'nonce' );

		$media_id = isset( $_POST['media_id'] ) ? absint( $_POST['media_id'] ) : 0;

		$media = mpp_get_media( $media_id );

		if ( ! $media || 'photo' !== $media->type ) {
			wp_send_json_error( array(
				'message' => __( 'Invalid action.', 'mpp-set-media-as-gallery-cover' ),
			) );
		}


		if ( empty( $media_id ) || ! mppsmagc_user_can_set_cover( $media_id ) ) {
			wp_send_json_error( array(
				'message' => __( 'Action not allowed.', 'mpp-set-media-as-gallery-cover' ),
			) );
		}

		mpp_update_gallery_cover_id( $media->gallery_id, $media_id );
		wp_send_json_success( array(
			'message' => __( 'Cover set.', 'mpp-set-media-as-gallery-cover' ),
		) );
	}
}

new MPSMAGCover_Ajax_Handler();
