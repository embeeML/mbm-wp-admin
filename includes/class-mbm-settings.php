<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MBM_Settings {

	private string $page_slug = 'mbm-toolkit-settings';
	private string $option_group = 'mbm_toolkit_options';

	/**
	 * Default config — edit these to match your standard setup.
	 * These are the fallback values used when get_option() finds nothing.
	 */
	public static array $defaults = [

		// Branding
		'mbm_branding_admin_bar_color' => '#1e1e2d',
		'mbm_branding_footer_text'     => 'Site built by <a href="https://matthewboyles.dev">Matthew Boyles Media</a>',
		'mbm_branding_remove_wp_logo'  => true,

		// Dashboard
		'mbm_dashboard_remove_primary'       => true,
		'mbm_dashboard_remove_quick_press'   => true,
		'mbm_dashboard_remove_recent_drafts' => true,
		'mbm_dashboard_remove_activity'      => true,
		'mbm_dashboard_remove_elementor'     => true,
		'mbm_dashboard_welcome_message'      => 'Welcome! Need help? Contact us anytime.',

		// Menus — applies to Editor role
		'mbm_menu_hide_plugins'       => true,
		'mbm_menu_hide_themes'        => true,
		'mbm_menu_hide_tools'         => true,
		'mbm_menu_hide_settings'      => true,
		'mbm_menu_hide_comments'      => true,
		'mbm_menu_hide_elementor'     => false,

		// Permissions — applies to Editor role
		'mbm_permissions_block_plugins_php'       => true,
		'mbm_permissions_block_theme_editor'      => true,
		'mbm_permissions_block_plugin_editor'     => true,
	];

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_tab_script' ) );
	}

	// -------------------------------------------------------------------------
	// Helper: get option with fallback to $defaults
	// -------------------------------------------------------------------------

	public static function get( string $key ) {
		$default = self::$defaults[ $key ] ?? null;
		return get_option( $key, $default );
	}

	// -------------------------------------------------------------------------
	// Menu registration
	// -------------------------------------------------------------------------

	public function add_settings_page(): void {
		add_menu_page(
			'MBM Toolkit',
			'MBM Toolkit',
			'manage_options',
			$this->page_slug,
			array( $this, 'render_page' ),
			'dashicons-admin-tools',
			3
		);
	}

	// -------------------------------------------------------------------------
	// Register all settings
	// -------------------------------------------------------------------------

	public function register_settings(): void {
		$sanitize_bool = 'absint';
		$sanitize_text = 'sanitize_text_field';
		$sanitize_html = 'wp_kses_post';

		$settings = [
			// Branding
			'mbm_branding_admin_bar_color' => $sanitize_text,
			'mbm_branding_footer_text'     => $sanitize_html,
			'mbm_branding_remove_wp_logo'  => $sanitize_bool,

			// Dashboard
			'mbm_dashboard_remove_primary'       => $sanitize_bool,
			'mbm_dashboard_remove_quick_press'   => $sanitize_bool,
			'mbm_dashboard_remove_recent_drafts' => $sanitize_bool,
			'mbm_dashboard_remove_activity'      => $sanitize_bool,
			'mbm_dashboard_remove_elementor'     => $sanitize_bool,
			'mbm_dashboard_welcome_message'      => $sanitize_text,

			// Menus
			'mbm_menu_hide_plugins'   => $sanitize_bool,
			'mbm_menu_hide_themes'    => $sanitize_bool,
			'mbm_menu_hide_tools'     => $sanitize_bool,
			'mbm_menu_hide_settings'  => $sanitize_bool,
			'mbm_menu_hide_comments'  => $sanitize_bool,
			'mbm_menu_hide_elementor' => $sanitize_bool,

			// Permissions
			'mbm_permissions_block_plugins_php'   => $sanitize_bool,
			'mbm_permissions_block_theme_editor'  => $sanitize_bool,
			'mbm_permissions_block_plugin_editor' => $sanitize_bool,
		];

		foreach ( $settings as $key => $callback ) {
			register_setting( $this->option_group, $key, [ 'sanitize_callback' => $callback ] );
		}
	}

	// -------------------------------------------------------------------------
	// Tab navigation script — pure JS, no extra dependencies
	// -------------------------------------------------------------------------

	public function enqueue_tab_script( string $hook ): void {
		if ( strpos( $hook, $this->page_slug ) === false ) return;

		wp_add_inline_script( 'jquery', "
			jQuery(function($) {
				$('.mbm-tab-link').on('click', function(e) {
					e.preventDefault();
					$('.mbm-tab-link').removeClass('nav-tab-active');
					$('.mbm-tab-panel').hide();
					$(this).addClass('nav-tab-active');
					$( $(this).data('target') ).show();
				});
				$('.mbm-tab-link:first').trigger('click');
			});
		" );
	}

	// -------------------------------------------------------------------------
	// Render settings page
	// -------------------------------------------------------------------------

	public function render_page(): void { ?>
		<div class="wrap">
			<h1>MBM WP Admin Toolkit</h1>

			<nav class="nav-tab-wrapper" style="margin-bottom: 0;">
				<a href="#" class="nav-tab mbm-tab-link" data-target="#mbm-tab-branding">Branding</a>
				<a href="#" class="nav-tab mbm-tab-link" data-target="#mbm-tab-dashboard">Dashboard</a>
				<a href="#" class="nav-tab mbm-tab-link" data-target="#mbm-tab-menus">Menus</a>
				<a href="#" class="nav-tab mbm-tab-link" data-target="#mbm-tab-permissions">Permissions</a>
			</nav>

			<form method="post" action="options.php" style="margin-top: 20px;">
				<?php settings_fields( $this->option_group ); ?>

				<?php $this->render_tab_branding(); ?>
				<?php $this->render_tab_dashboard(); ?>
				<?php $this->render_tab_menus(); ?>
				<?php $this->render_tab_permissions(); ?>

				<?php submit_button( 'Save Settings' ); ?>
			</form>
		</div>
	<?php }

	// -------------------------------------------------------------------------
	// Tab: Branding
	// -------------------------------------------------------------------------

	private function render_tab_branding(): void { ?>
		<div id="mbm-tab-branding" class="mbm-tab-panel" style="display:none;">
			<table class="form-table">

				<tr>
					<th scope="row">Admin Bar Color</th>
					<td>
						<input type="color" name="mbm_branding_admin_bar_color"
							value="<?php echo esc_attr( self::get( 'mbm_branding_admin_bar_color' ) ); ?>" />
						<p class="description">Background color of the WP admin bar.</p>
					</td>
				</tr>

				<tr>
					<th scope="row">Remove WP Logo</th>
					<td>
						<input type="checkbox" name="mbm_branding_remove_wp_logo" value="1"
							<?php checked( 1, self::get( 'mbm_branding_remove_wp_logo' ) ); ?> />
						<label>Remove the WordPress logo from the admin bar</label>
					</td>
				</tr>

				<tr>
					<th scope="row">Admin Footer Text</th>
					<td>
						<input type="text" name="mbm_branding_footer_text" class="large-text"
							value="<?php echo esc_attr( self::get( 'mbm_branding_footer_text' ) ); ?>" />
						<p class="description">Supports basic HTML (links, bold, etc).</p>
					</td>
				</tr>

			</table>
		</div>
	<?php }

	// -------------------------------------------------------------------------
	// Tab: Dashboard
	// -------------------------------------------------------------------------

	private function render_tab_dashboard(): void { ?>
		<div id="mbm-tab-dashboard" class="mbm-tab-panel" style="display:none;">
			<table class="form-table">

				<tr>
					<th scope="row">Remove Default Widgets</th>
					<td>
						<?php $widgets = [
							'mbm_dashboard_remove_primary'       => 'WordPress News & Events',
							'mbm_dashboard_remove_quick_press'   => 'Quick Draft',
							'mbm_dashboard_remove_recent_drafts' => 'Recent Drafts',
							'mbm_dashboard_remove_activity'      => 'Activity',
							'mbm_dashboard_remove_elementor'     => 'Elementor Overview',
						];
						foreach ( $widgets as $key => $label ) : ?>
							<label style="display:block; margin-bottom:6px;">
								<input type="checkbox" name="<?php echo esc_attr( $key ); ?>" value="1"
									<?php checked( 1, self::get( $key ) ); ?> />
								<?php echo esc_html( $label ); ?>
							</label>
						<?php endforeach; ?>
					</td>
				</tr>

				<tr>
					<th scope="row">Welcome Widget Message</th>
					<td>
						<textarea name="mbm_dashboard_welcome_message" class="large-text" rows="3"><?php
							echo esc_textarea( self::get( 'mbm_dashboard_welcome_message' ) );
						?></textarea>
						<p class="description">Shown in the custom welcome widget on the dashboard.</p>
					</td>
				</tr>

			</table>
		</div>
	<?php }

	// -------------------------------------------------------------------------
	// Tab: Menus
	// -------------------------------------------------------------------------

	private function render_tab_menus(): void { ?>
		<div id="mbm-tab-menus" class="mbm-tab-panel" style="display:none;">
			<p>These items will be hidden from <strong>Editor</strong> role users.</p>
			<table class="form-table">
				<tr>
					<th scope="row">Hide Menu Items</th>
					<td>
						<?php $menus = [
							'mbm_menu_hide_plugins'   => 'Plugins',
							'mbm_menu_hide_themes'    => 'Appearance / Themes',
							'mbm_menu_hide_tools'     => 'Tools',
							'mbm_menu_hide_settings'  => 'Settings',
							'mbm_menu_hide_comments'  => 'Comments',
							'mbm_menu_hide_elementor' => 'Elementor (top-level menu)',
						];
						foreach ( $menus as $key => $label ) : ?>
							<label style="display:block; margin-bottom:6px;">
								<input type="checkbox" name="<?php echo esc_attr( $key ); ?>" value="1"
									<?php checked( 1, self::get( $key ) ); ?> />
								<?php echo esc_html( $label ); ?>
							</label>
						<?php endforeach; ?>
					</td>
				</tr>
			</table>
		</div>
	<?php }

	// -------------------------------------------------------------------------
	// Tab: Permissions
	// -------------------------------------------------------------------------

	private function render_tab_permissions(): void { ?>
		<div id="mbm-tab-permissions" class="mbm-tab-panel" style="display:none;">
			<p>Hard-block direct URL access for <strong>Editor</strong> role users, even if menu items are visible.</p>
			<table class="form-table">
				<tr>
					<th scope="row">Block Direct Access</th>
					<td>
						<?php $blocks = [
							'mbm_permissions_block_plugins_php'   => 'plugins.php (Plugin management)',
							'mbm_permissions_block_theme_editor'  => 'theme-editor.php (Theme file editor)',
							'mbm_permissions_block_plugin_editor' => 'plugin-editor.php (Plugin file editor)',
						];
						foreach ( $blocks as $key => $label ) : ?>
							<label style="display:block; margin-bottom:6px;">
								<input type="checkbox" name="<?php echo esc_attr( $key ); ?>" value="1"
									<?php checked( 1, self::get( $key ) ); ?> />
								<?php echo esc_html( $label ); ?>
							</label>
						<?php endforeach; ?>
					</td>
				</tr>
			</table>
		</div>
	<?php }
}