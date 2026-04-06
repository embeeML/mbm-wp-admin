<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MBM_WP_Admin_Toolkit {

	protected string $plugin_name = 'mbm-wp-admin-toolkit';
	protected string $version;

	public function __construct() {
		$this->version = MBM_WP_ADMIN_TOOLKIT_VERSION;
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	private function load_dependencies(): void {
		require_once MBM_WP_ADMIN_TOOLKIT_DIR . 'admin/class-mbm-admin.php';
		require_once MBM_WP_ADMIN_TOOLKIT_DIR . 'public/class-mbm-public.php';
	}

	private function set_locale(): void {
		add_action( 'init', function () {
			load_plugin_textdomain(
				'mbm-wp-admin-toolkit',
				false,
				dirname( plugin_basename( MBM_WP_ADMIN_TOOLKIT_FILE ) ) . '/languages/'
			);
		} );
	}

	private function define_admin_hooks(): void {
		$admin = new MBM_Admin( $this->plugin_name, $this->version );

		add_action( 'admin_enqueue_scripts', array( $admin, 'enqueue_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $admin, 'enqueue_scripts' ) );
	}

	private function define_public_hooks(): void {
		$public = new MBM_Public( $this->plugin_name, $this->version );

		add_action( 'wp_enqueue_scripts', array( $public, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $public, 'enqueue_scripts' ) );
	}

	public function run(): void {
		// Plugin is bootstrapped via constructor hooks.
	}
}
