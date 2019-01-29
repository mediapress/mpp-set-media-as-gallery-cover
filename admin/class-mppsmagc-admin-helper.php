<?php
// Exit if file access directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class MPPSMAGCover_Admin_Settings_Helper
 */
class MPPSMAGCover_Admin_Settings_Helper {

	/**
	 * The constructor.
	 */
	public function __construct() {
		add_action( 'mpp_admin_register_settings', array( $this, 'register_settings' ) );
	}

	/**
	 * Register settings
	 *
	 * @param MPP_Admin_Settings_Page $page Page object.
	 */
	public function register_settings( $page ) {

		$panel   = $page->get_panel( 'addons' );
		$section = $panel->add_section( 'mppsmagc-settings', __( 'Set Media As Cover', 'mpp-set-media-as-gallery-cover' ) );

		$fields = array(
			array(
				'name'    => 'mppsmagc_button_ui_places',
				'label'   => __( 'Where to show set cover button?', 'mpp-set-media-as-gallery-cover' ),
				'type'    => 'multicheck',
				'options' => array(
					'single_media'   => __( 'Single Media Page', 'mpp-set-media-as-gallery-cover' ),
					'lightbox'       => __( 'Lightbox', 'mpp-set-media-as-gallery-cover' ),
					'single_gallery' => __( 'Single Gallery', 'mpp-set-media-as-gallery-cover' ),
					'gallery_home'   => __( 'Gallery home', 'mpp-set-media-as-gallery-cover' ),
				),
			),
		);

		$section->add_fields( $fields );
	}
}

new MPPSMAGCover_Admin_Settings_Helper();

