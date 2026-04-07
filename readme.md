=== MBM WP Admin Toolkit ===
Contributors: matthewboylesmedia
Tags: admin, dashboard, branding, permissions, client-site
Requires at least: 6.0
Tested up to: 6.7
Stable tag: 1.0.0
Requires PHP: 8.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Toolkit for branding, dashboard cleanup, menu visibility control, and editor access restrictions.

== Description ==

MBM WP Admin Toolkit is designed for agencies and site owners who need a cleaner, safer WordPress admin experience for Editor users.

It provides one settings screen with tabs for Branding, Dashboard, Menus, and Permissions.

== Core Functions and Modules ==

= Plugin bootstrap =

* Loads plugin constants and hooks from main plugin file.
* Registers activation and deactivation callbacks.
* Boots the main loader class and module classes.

= Settings module =

Settings are managed through the MBM Toolkit admin page.

Main responsibilities:
* Defines defaults for all plugin options.
* Registers and sanitizes settings values.
* Handles settings form submission.
* Handles login logo upload/removal.
* Renders tabbed settings UI.

= Branding module =

Branding functions:
* Replace WordPress login logo.
* Change login logo link target (site home URL).
* Change login logo title text (site name).
* Customize admin footer text.
* Customize admin bar background color.
* Optionally remove WordPress logo from admin bar.

= Dashboard module =

Dashboard functions:
* Remove selected core dashboard widgets.
* Remove Elementor dashboard overview widget (if enabled).
* Add a custom welcome widget with quick admin links.
* Inject lightweight dashboard-only widget styling.

= Menu control module =

Menu functions (Editor role only):
* Hide Plugins menu.
* Hide Appearance/Themes related menus.
* Hide Tools menu.
* Hide Settings menu.
* Hide Comments menu.
* Hide Elementor top-level menu.

= Permissions module =

Access restriction functions (Editor role only):
* Block direct access to plugin/theme editor pages.
* Block direct access to plugins.php when enabled.
* Block direct access to themes/customizer/menu/widget pages when enabled.
* Block direct access to settings pages when enabled.
* Block selected Elementor admin pages when enabled.

= Activation module =

On first activation:
* Stores plugin version option.
* Seeds all default settings options.
* Flushes rewrite rules.

On deactivation:
* Flushes rewrite rules.

== How To Use ==

1. Install and activate the plugin.
2. In wp-admin, open MBM Toolkit.
3. Configure each tab:
	* Branding: set logo, admin bar color, footer text, and WP logo visibility.
	* Dashboard: toggle widget removals and set the welcome message.
	* Menus: choose which menus to hide from Editor users.
	* Permissions: enforce URL-level blocking for sensitive pages.
4. Click Save Settings.
5. Test with an Editor account to confirm the intended experience.

== Recommended Workflow ==

* Configure settings while logged in as Administrator.
* Use a separate Editor test user to validate restrictions.
* If using Elementor, verify both menu hiding and direct URL blocking.
* Keep a backup of logo assets before replacing/removing.

== Notes ==

* Menu and permission restrictions currently target Editor users.
* Admin users are not restricted by this plugin.
* Footer text allows basic HTML.

== Installation ==

1. Upload the plugin folder to /wp-content/plugins/.
2. Activate through the Plugins menu.
3. Go to MBM Toolkit in wp-admin to configure options.

== Frequently Asked Questions ==

= Who is affected by menu and permission restrictions? =

Editor users only.

= Will this plugin remove data on deactivation? =

No. Deactivation does not delete saved options.

= How do I reset settings quickly? =

Disable and re-enable does not reset options. Remove options manually from the database if you need a full reset.

== Changelog ==

= 1.0.0 =
* Initial release.
* Added module and usage documentation.
