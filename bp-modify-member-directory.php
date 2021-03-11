<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.wbcomdesigns.com/
 * @since             1.0.1
 * @package           Bp_Modify_Member_Directory
 *
 * @wordpress-plugin
 * Plugin Name:       BP Modify Member Directory/Header
 * Plugin URI:        https://wbcomdesigns.com/plugins/bp-modify-member-directory/
 * Description:       It will add option for admin to select which xprofile field will be displayed inside member loop and on profile header
 * Version:           1.1.0
 * Author:            Wbcom Designs
 * Author URI:        http://www.wbcomdesigns.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bp-modify-member-directory
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'BPMMD_TEXT_DOMAIN' ) ) {
	define( 'BPMMD_TEXT_DOMAIN', 'bp-modify-member-directory' );
}
if ( ! defined( 'BPMMD_PLUGIN_VERSION' ) ) {
	define( 'BPMMD_PLUGIN_VERSION', '1.1.0' );
}
if ( ! defined( 'BPMMD_PLUGIN_FILE' ) ) {
	define( 'BPMMD_PLUGIN_FILE', __FILE__ );
}
if ( ! defined( 'BPMMD_PLUGIN_URL' ) ) {
	define( 'BPMMD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}
if ( ! defined( 'BPMMD_PLUGIN_PATH' ) ) {
	define( 'BPMMD_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-bp-modify-member-directory.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_bp_modify_member_directory() {
	$plugin = new Bp_Modify_Member_Directory();
	$plugin->run();
}

add_action( 'plugins_loaded', 'bp_modify_member_directory_init' );
/**
 * Checking for buddypress whether it is active or not
 *
 * @since    1.0.0
 */
function bp_modify_member_directory_init() {
	if ( ! class_exists( 'BuddyPress' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';

		deactivate_plugins( plugin_basename( __FILE__ ) );
		add_action( 'admin_notices', 'bp_modify_member_directory_plugin_admin_notice' );

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		return;
	} else {
		run_bp_modify_member_directory();
	}

}

/**
 * Function to show admin notice when BuddyPress is deactivate.
 */
function bp_modify_member_directory_plugin_admin_notice() {
	$bpmdh_plugin = 'BP Modify Member Directory/Header';
	$bp_plugin    = 'BuddyPress';

	echo '<div class="error"><p>'
	/* translators: BP Modify Member Directory/Header and BuddyPress */
	. sprintf( esc_html__( '%1$s is ineffective as it requires %2$s to be installed and active.', 'bp-modify-member-directory' ), '<strong>' . esc_html( $bpmdh_plugin ) . '</strong>', '<strong>' . esc_html( $bp_plugin ) . '</strong>' )
	. '</p></div>';
	if ( isset( $_GET['activate'] ) ) {
		unset( $_GET['activate'] );
	}
}

/**
 * Adding setting link on plugin listing page
 */
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'bp_modify_member_plugin_actions', 10, 2 );

/**
 * Adds the Settings link to the plugin activate/deactivate page.
 */
function bp_modify_member_plugin_actions( $links, $file ) {
	$settings_link = '<a href="' . admin_url( 'admin.php?page=bp-modify-directory' ) . '">' . __( 'Settings', 'bp-modify-member-directory' ) . '</a>';
	array_unshift( $links, $settings_link ); // before other links.
	return $links;
}
