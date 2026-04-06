<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MBM_Activator {

	public static function activate(): void {
		// Set default options, create tables, flush rewrite rules, etc.
		if ( ! get_option( 'mbm_wp_admin_toolkit_version' ) ) {
			update_option( 'mbm_wp_admin_toolkit_version', MBM_WP_ADMIN_TOOLKIT_VERSION );
		}

		flush_rewrite_rules();
	}
}
