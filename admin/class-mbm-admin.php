<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MBM_Admin {

	private string $plugin_name;
	private string $version;

	public function __construct( string $plugin_name, string $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	public function enqueue_styles(): void {
		wp_enqueue_style(
			$this->plugin_name,
			MBM_WP_ADMIN_TOOLKIT_URL . 'admin/css/mbm-wp-admin-toolkit-admin.css',
			array(),
			$this->version
		);
	}

	public function enqueue_scripts(): void {
		wp_enqueue_script(
			$this->plugin_name,
			MBM_WP_ADMIN_TOOLKIT_URL . 'admin/js/mbm-wp-admin-toolkit-admin.js',
			array( 'jquery' ),
			$this->version,
			true
		);
	}
}
