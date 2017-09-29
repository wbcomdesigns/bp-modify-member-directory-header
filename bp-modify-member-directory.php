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
 * @since             1.0.0
 * @package           Bp_Modify_Member_Directory
 *
 * @wordpress-plugin
 * Plugin Name:       BP Modify Member Directory/Header
 * Plugin URI:        https://wbcomdesigns.com/plugins/bp-modify-member-directory/
 * Description:       It will add option for admin to select which xprofile field will be displayed inside member loop and on profile header
 * Version:           1.0.0
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

/**
 *  Checking for buddypress whether it is active or not
 */
if (!in_array('buddypress/bp-loader.php', apply_filters('active_plugins', get_option('active_plugins')))) {
	 $active_plugins =  apply_filters('active_plugins', get_option('active_plugins'));
	 $bp_filter_plugin = plugin_basename(__FILE__);
	 $bp_filter_key = array_search($bp_filter_plugin,$active_plugins);
	 if(isset($bp_filter_key) && in_array($bp_filter_plugin, $active_plugins)) {
	 	unset($active_plugins[$bp_filter_key]);
	 	add_action('admin_notices', 'buddypress_for_bp_modify_not_active_notice');
	 	update_option('active_plugins', $active_plugins);
	 	if(isset($_GET['activate']))
	 		unset($_GET['activate']);
	 }
	 return;
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

function buddypress_for_bp_modify_not_active_notice() {?>
    <div class="error notice">
        <p><?php _e('To work BP Modify Member Directory, BuddyPress should be activated', 'bp-modify-member-directory');?></p>
    </div>
<?php }

/**
 * Adding setting link on plugin listing page
 */
add_filter('plugin_action_links_'.plugin_basename(__FILE__),'bp_modify_member_plugin_actions', 10, 2);

/**
 * @desc Adds the Settings link to the plugin activate/deactivate page
 */
function bp_modify_member_plugin_actions($links, $file) {
	$settings_link = '<a href="' . admin_url("admin.php?page=bp-modify-member-directory") . '">' . __('Settings', 'bp-modify-member-directory') . '</a>';
	array_unshift($links, $settings_link); // before other links
	return $links;
}

run_bp_modify_member_directory();
