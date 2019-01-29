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
 * Check if current user can set media as cover.
 *
 * @param int $media_id media id.
 * @param int $gallery_id gallery id.
 *
 * @return bool
 */
function mppsmagc_user_can_set_cover( $media_id, $gallery_id = 0 ) {

	$can     = false;
	$user_id = get_current_user_id();
	$media   = mpp_get_media( $media_id );
	if ( ! $gallery_id ) {
		$gallery_id = $media->gallery_id;
	}

	if ( empty( $user_id ) || empty( $media ) || 'photo' !== $media->type ) {
		return false;
	}

	// do not use === here, the values can be str/int.
	if ( is_super_admin() ) {
		$can = true;
	} elseif ( $media->user_id == $user_id ) {
		$can = true;
	} elseif ( 'groups' === $media->component && function_exists( 'bp_is_active' ) && bp_is_active( 'groups' ) && groups_is_user_admin( $user_id, $media->component_id ) ) {
		$can = true;
	}

	return apply_filters( 'mppsmagc_user_can_set_cover', $can, $media );
}


/**
 * Is button enabled on this screen.
 *
 * @return bool
 */
function mppsmagc_is_button_enabled_screen() {

	$screens = mpp_get_option( 'mppsmagc_button_ui_places', array() );

	if ( mpp_is_single_media() ) {
		return array_key_exists( 'single_media', $screens );
	} elseif ( mpp_is_single_gallery() ) {
		return array_key_exists( 'single_gallery', $screens );
	} elseif ( array_key_exists( 'gallery_home', $screens ) && mpp_is_gallery_home() ) {
		return true;
	}

	return false;
}
