<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MBM_Menu_Control {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'remove_menus' ), 999 );
	}

	// -------------------------------------------------------------------------
	// Remove admin menu items for Editor role
	// -------------------------------------------------------------------------

	public function remove_menus(): void {
		if ( current_user_can( 'administrator' ) ) return;

		$menus = [
			'mbm_menu_hide_plugins'   => 'plugins.php',
			'mbm_menu_hide_themes'    => 'themes.php',
			'mbm_menu_hide_tools'     => 'tools.php',
			'mbm_menu_hide_settings'  => 'options-general.php',
			'mbm_menu_hide_comments'  => 'edit-comments.php',
			'mbm_menu_hide_elementor' => 'elementor',
		];

		foreach ( $menus as $setting_key => $slug ) {
			if ( MBM_Settings::get( $setting_key ) ) {
				remove_menu_page( $slug );
			}
		}

		// Submenus tied to Appearance — only removed if themes menu is hidden
		if ( MBM_Settings::get( 'mbm_menu_hide_themes' ) ) {
			remove_submenu_page( 'themes.php', 'widgets.php' );
			remove_submenu_page( 'themes.php', 'nav-menus.php' );
			remove_submenu_page( 'themes.php', 'customize.php' );
		}
	}
}