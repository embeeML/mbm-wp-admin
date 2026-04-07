<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MBM_Activator {

	public static function activate(): void {
		if ( ! get_option( 'mbm_wp_admin_toolkit_version' ) ) {
			update_option( 'mbm_wp_admin_toolkit_version', MBM_WP_ADMIN_TOOLKIT_VERSION );

			// Write all defaults to DB on first activation
			foreach ( MBM_Settings::$defaults as $key => $value ) {
				// add_option won't overwrite if it already exists
				add_option( $key, $value );
			}
		}

		flush_rewrite_rules();
	}
}