<?php
/**
 * MBM WP Admin Toolkit
 *
 * @package           MBM_WP_Admin_Toolkit
 * @author            Matthew Boyles Media
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       MBM WP Admin Toolkit
 * Plugin URI:        https://matthewboyles.dev/mbm-wp-admin-toolkit
 * Description:       A WordPress admin toolkit plugin.
 * Version:           1.0.0
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * Author:            Matthew Boyles Media
 * Author URI:        https://matthewboyles.dev
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       mbm-wp-admin-toolkit
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MBM_WP_ADMIN_TOOLKIT_VERSION', '1.0.0' );
define( 'MBM_WP_ADMIN_TOOLKIT_FILE', __FILE__ );
define( 'MBM_WP_ADMIN_TOOLKIT_DIR', plugin_dir_path( __FILE__ ) );
define( 'MBM_WP_ADMIN_TOOLKIT_URL', plugin_dir_url( __FILE__ ) );

require_once MBM_WP_ADMIN_TOOLKIT_DIR . 'includes/class-mbm-activator.php';
require_once MBM_WP_ADMIN_TOOLKIT_DIR . 'includes/class-mbm-deactivator.php';
require_once MBM_WP_ADMIN_TOOLKIT_DIR . 'includes/class-mbm-wp-admin-toolkit.php';

register_activation_hook( __FILE__, array( 'MBM_Activator', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'MBM_Deactivator', 'deactivate' ) );

function mbm_wp_admin_toolkit_run() {
	$plugin = new MBM_WP_Admin_Toolkit();
	$plugin->run();
}

mbm_wp_admin_toolkit_run();
