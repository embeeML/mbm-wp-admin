<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MBM_Dashboard {

	public function __construct() {
		add_action( 'wp_dashboard_setup', array( $this, 'remove_widgets' ), 999 );
		add_action( 'wp_dashboard_setup', array( $this, 'add_welcome_widget' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_widget_styles' ) );
	}

	// -------------------------------------------------------------------------
	// Remove default dashboard widgets based on settings
	// -------------------------------------------------------------------------

	public function remove_widgets(): void {
		$widgets = [
			'mbm_dashboard_remove_primary'       => [ 'dashboard_primary',       'dashboard', 'side'   ],
			'mbm_dashboard_remove_quick_press'   => [ 'dashboard_quick_press',   'dashboard', 'side'   ],
			'mbm_dashboard_remove_recent_drafts' => [ 'dashboard_recent_drafts', 'dashboard', 'side'   ],
			'mbm_dashboard_remove_activity'      => [ 'dashboard_activity',      'dashboard', 'normal' ],
			'mbm_dashboard_remove_elementor'     => [ 'e-dashboard-overview',    'dashboard', 'normal' ],
		];

		foreach ( $widgets as $setting_key => $args ) {
			if ( MBM_Settings::get( $setting_key ) ) {
				remove_meta_box( $args[0], $args[1], $args[2] );
			}
		}
	}

	// -------------------------------------------------------------------------
	// Add custom welcome widget
	// -------------------------------------------------------------------------

	public function add_welcome_widget(): void {
		wp_add_dashboard_widget(
			'mbm_welcome_widget',
			get_bloginfo( 'name' ),
			array( $this, 'render_welcome_widget' )
		);
	}

	public function render_welcome_widget(): void {
		$message   = MBM_Settings::get( 'mbm_dashboard_welcome_message' );
		$site_name = get_bloginfo( 'name' );
		$admin_url = admin_url();
		?>
		<div class="mbm-welcome-widget">
			<p><?php echo wp_kses_post( $message ); ?></p>
			<hr />
			<p>
				<strong>Quick Links</strong>
			</p>
			<ul>
				<li>
					<a href="<?php echo esc_url( $admin_url . 'edit.php' ); ?>">
						📝 Posts
					</a>
				</li>
				<li>
					<a href="<?php echo esc_url( $admin_url . 'edit.php?post_type=page' ); ?>">
						📄 Pages
					</a>
				</li>
				<li>
					<a href="<?php echo esc_url( $admin_url . 'upload.php' ); ?>">
						🖼 Media
					</a>
				</li>
			</ul>
		</div>
		<?php
	}

	// -------------------------------------------------------------------------
	// Widget styles — scoped to dashboard only
	// -------------------------------------------------------------------------

	public function enqueue_widget_styles( string $hook ): void {
		if ( $hook !== 'index.php' ) return;

		wp_add_inline_style( 'wp-admin', '
			.mbm-welcome-widget ul {
				margin: 0;
				padding: 0;
				list-style: none;
			}
			.mbm-welcome-widget ul li {
				margin-bottom: 6px;
			}
			.mbm-welcome-widget ul li a {
				text-decoration: none;
				font-weight: 500;
			}
			.mbm-welcome-widget hr {
				margin: 12px 0;
				border: none;
				border-top: 1px solid #eee;
			}
		' );
	}
}