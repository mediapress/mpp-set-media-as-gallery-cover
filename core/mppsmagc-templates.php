<?php
/**
 * Template Tags.
 *
 * @package mpp-set-media-as-gallery-cover
 */

// Exit if file access directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render Set Cover button.
 *
 * @param int  $media_id item_id.
 * @param bool $wrapper use link wrapper.
 */
function mppsmagc_set_cover_button( $media_id, $wrapper = true ) {
	echo mppsmagc_get_set_cover_button( $media_id, $wrapper );
}

/**
 * Get set as cover button.
 *
 * @param int  $item_id Item id.
 * @param bool $wrapper use link wrapper.
 *
 * @return string
 */
function mppsmagc_get_set_cover_button( $item_id, $wrapper = true ) {
	// if already set as cover, do not show.
	$media = mpp_get_media( $item_id );
	// check if we should show the button.
	if ( ! $media || 'photo' !== $media->type || mpp_get_gallery_cover_id( $media->gallery_id ) == $media->id ) {
		return '';
	}

	$label = __( 'Set Cover', 'mpp-set-media-as-gallery-cover' );

	$css_class = 'mppsmagc-cover-link';

	$link = sprintf( '<a href="#" class="mppsmagc-cover-btn %s" data-item-id="%s" data-nonce="%s">%s</a>', $css_class, $item_id, wp_create_nonce( 'mppsmagc_set_cover' ), $label );

	if ( $wrapper ) {
		return sprintf( '<div class="generic-button %s">', $css_class . '-btn' ) . $link . '</div>';
	} else {
		return $link;
	}
}
