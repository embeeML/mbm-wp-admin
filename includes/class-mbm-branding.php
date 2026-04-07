<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MBM_Branding {

	public function __construct() {
		add_action( 'login_enqueue_scripts', array( $this, 'login_logo' ) );
		add_filter( 'login_headerurl',       array( $this, 'login_logo_url' ) );
		add_filter( 'login_headertext',      array( $this, 'login_logo_title' ) );
		add_filter( 'admin_footer_text',     array( $this, 'footer_text' ) );
		add_action( 'admin_head',            array( $this, 'admin_bar_style' ) );
		add_action( 'admin_bar_menu',        array( $this, 'maybe_remove_wp_logo' ), 999 );
	}

	// -------------------------------------------------------------------------
	// Login page logo
	// -------------------------------------------------------------------------

	public function login_logo(): void {
		$logo_url = MBM_WP_ADMIN_TOOLKIT_URL . 'admin/images/login-logo.png';

		// Only output if the logo file actually exists
		if ( ! file_exists( MBM_WP_ADMIN_TOOLKIT_DIR . 'admin/images/login-logo.png' ) ) {
			return;
		}
		?>
		<style>
			#login h1 a {
				background-image: url('<?php echo esc_url( $logo_url ); ?>');
				background-size: contain;
				background-repeat: no-repeat;
				background-position: center;
				width: 200px;
				height: 80px;
			}
		</style>
		<?php
	}

	public function login_logo_url(): string {
		return home_url();
	}

	public function login_logo_title(): string {
		return get_bloginfo( 'name' );
	}

	// -------------------------------------------------------------------------
	// Admin footer text
	// -------------------------------------------------------------------------

	public function footer_text(): string {
		$text = MBM_Settings::get( 'mbm_branding_footer_text' );
		return wp_kses_post( $text );
	}

	// -------------------------------------------------------------------------
	// Admin bar background color
	// -------------------------------------------------------------------------

	public function admin_bar_style(): void {
		$color = MBM_Settings::get( 'mbm_branding_admin_bar_color' );

		// Bail if somehow empty or not a valid hex
		if ( empty( $color ) || ! preg_match( '/^#[a-fA-F0-9]{3,6}$/', $color ) ) {
			return;
		}
		?>
		<style>
			#wpadminbar {
				background: <?php echo esc_attr( $color ); ?> !important;
			}
		</style>
		<?php
	}

	// -------------------------------------------------------------------------
	// Optionally remove WP logo from admin bar
	// -------------------------------------------------------------------------

	public function maybe_remove_wp_logo( \WP_Admin_Bar $wp_admin_bar ): void {
		if ( ! MBM_Settings::get( 'mbm_branding_remove_wp_logo' ) ) {
			return;
		}

		$wp_admin_bar->remove_node( 'wp-logo' );
	}
}