# MBM WP Admin Toolkit

Toolkit for branding, dashboard cleanup, menu visibility control, and editor access restrictions.

## Plugin Info

- Version: 1.0.0
- Requires WordPress: 6.0+
- Tested up to: 6.7
- Requires PHP: 8.0+
- License: GPLv2 or later
- License URL: https://www.gnu.org/licenses/gpl-2.0.html
- Tags: admin, dashboard, branding, permissions, client-site

## Description

MBM WP Admin Toolkit is designed for agencies and site owners who need a cleaner, safer WordPress admin experience for Editor users.

The plugin provides one settings screen with tabs for Branding, Dashboard, Menus, and Permissions.

## Installation

1. Upload the plugin folder to /wp-content/plugins/.
2. Activate MBM WP Admin Toolkit from the Plugins screen.
3. Open MBM Toolkit in wp-admin.
4. Configure settings and save.

## Core Functions and Modules

### Plugin Bootstrap

- Loads plugin constants and hooks from the main plugin file.
- Registers activation and deactivation callbacks.
- Boots the main loader class and module classes.

### Settings Module

Settings are managed from the MBM Toolkit admin page.

- Defines defaults for all plugin options.
- Registers and sanitizes settings values.
- Handles settings form submission.
- Handles login logo upload and removal.
- Renders a tabbed settings UI.

### Branding Module

- Replaces the WordPress login logo.
- Changes login logo URL target to the site home URL.
- Changes login logo title text to the site name.
- Customizes admin footer text.
- Customizes admin bar background color.
- Optionally removes the WordPress logo from the admin bar.

### Dashboard Module

- Removes selected core dashboard widgets.
- Removes Elementor dashboard overview widget (when enabled).
- Adds a custom welcome widget with quick admin links.
- Injects lightweight dashboard-only styling.

### Menu Control Module

Applies to Editor users only.

- Hides Plugins menu.
- Hides Appearance and Themes related menus.
- Hides Tools menu.
- Hides Settings menu.
- Hides Comments menu.
- Hides Elementor top-level menu.

### Permissions Module

Applies to Editor users only.

- Blocks direct access to plugin and theme editor pages.
- Blocks direct access to plugins.php when enabled.
- Blocks direct access to themes/customizer/menu/widget pages when enabled.
- Blocks direct access to WordPress settings pages when enabled.
- Blocks selected Elementor admin pages when enabled.

### Activation and Deactivation

On first activation:

- Stores plugin version option.
- Seeds all default settings options.
- Flushes rewrite rules.

On deactivation:

- Flushes rewrite rules.

## How to Use

1. Open MBM Toolkit in wp-admin.
2. Configure each tab:
- Branding: Set logo, admin bar color, footer text, and WordPress logo visibility.
- Dashboard: Toggle widget removals and set the welcome message.
- Menus: Choose which menus to hide from Editor users.
- Permissions: Enforce URL-level blocking for sensitive pages.
3. Click Save Settings.
4. Test with an Editor account to confirm behavior.

## Recommended Workflow

- Configure settings while logged in as Administrator.
- Use a separate Editor test account to verify restrictions.
- If Elementor is installed, test both menu hiding and direct URL blocking.
- Keep a backup of logo assets before replacing or removing.

## Notes

- Menu and permission restrictions target Editor users.
- Administrator users are not restricted by these controls.
- Footer text supports basic HTML.

## FAQ

### Who is affected by menu and permission restrictions?

Editor users.

### Will this plugin remove data on deactivation?

No. Deactivation does not delete saved options.

### How do I reset settings quickly?

Disable and re-enable does not reset options. Remove options manually from the database for a full reset.

## Changelog

### 1.0.0

- Initial release.
- Added module and usage documentation.
