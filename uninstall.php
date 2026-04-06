<?php
/**
 * Fired when the plugin is uninstalled.
 * Removes all plugin options and data from the database.
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'mbm_wp_admin_toolkit_version' );
