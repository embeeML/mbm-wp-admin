<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MBM_Permissions {

	public function __construct() {
		add_action( 'admin_init', array( $this, 'restrict_admin_access' ) );
		add_action( 'admin_init', array( $this, 'restrict_elementor_access' ) );
	}

	// -------------------------------------------------------------------------
	// Block direct URL access for Editor role
	// -------------------------------------------------------------------------

	private function is_editor_user(): bool {
		$user = wp_get_current_user();

		if ( ! $user || empty( $user->roles ) ) {
			return false;
		}

		return in_array( 'editor', $user->roles, true );
	}

	public function restrict_admin_access(): void {
		if ( ! $this->is_editor_user() ) {
			return;
		}

		$blocked_pages = [
			'mbm_permissions_block_plugins_php'   => 'plugins.php',
			'mbm_permissions_block_theme_editor'  => 'theme-editor.php',
			'mbm_permissions_block_plugin_editor' => 'plugin-editor.php',
		];

		$current_page = basename( $_SERVER['PHP_SELF'] );

		foreach ( $blocked_pages as $setting_key => $page ) {
			if ( ! MBM_Settings::get( $setting_key ) ) continue;

			if ( $current_page === $page ) {
				wp_safe_redirect( admin_url() );
				exit;
			}
		}

		// Block themes.php and related pages if themes menu is hidden
		if ( MBM_Settings::get( 'mbm_menu_hide_themes' ) ) {
			$blocked_theme_pages = [
				'themes.php',
				'customize.php',
				'nav-menus.php',
				'widgets.php',
			];

			if ( in_array( $current_page, $blocked_theme_pages, true ) ) {
				wp_safe_redirect( admin_url() );
				exit;
			}
		}

		// Block options-general.php and all settings subpages
		if ( MBM_Settings::get( 'mbm_menu_hide_settings' ) ) {
			$blocked_settings_pages = [
				'options-general.php',
				'options-writing.php',
				'options-reading.php',
				'options-discussion.php',
				'options-media.php',
				'options-permalink.php',
				'options-privacy.php',
			];

			if ( in_array( $current_page, $blocked_settings_pages, true ) ) {
				wp_safe_redirect( admin_url() );
				exit;
			}
		}
	}

	// -------------------------------------------------------------------------
	// Block Elementor settings pages for Editor role
	// -------------------------------------------------------------------------

	public function restrict_elementor_access(): void {
		if ( ! $this->is_editor_user() ) {
			return;
		}

		if ( ! MBM_Settings::get( 'mbm_menu_hide_elementor' ) ) {
			return;
		}

		if ( ! isset( $_GET['page'] ) ) {
			return;
		}

		$blocked_elementor_pages = [
			'elementor',
			'elementor-getting-started',
			'elementor-system-info',
			'elementor-tools',
			'elementor-license',
		];

		$current_page = sanitize_key( wp_unslash( $_GET['page'] ) );

		if ( in_array( $current_page, $blocked_elementor_pages, true ) ) {
			wp_safe_redirect( admin_url() );
			exit;
		}
	}
}