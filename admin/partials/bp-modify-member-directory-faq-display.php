<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Bp_Modify_Member_Directory
 * @subpackage Bp_Modify_Member_Directory/admin/partials
 */

?>

<div class="wbcom-tab-content">
<div id="bpmmd_faq_accordion">
	<h3><?php esc_html_e( 'Is this plugin requires another plugin?', 'bp-modify-member-directory' ); ?></h3>
	<div>
		<p>
			<?php esc_html_e( 'Yes, this plugin requires BuddyPress plugin.', 'bp-modify-member-directory' ); ?>
		</p>
	</div>
	<h3><?php esc_html_e( 'What does this plugin work?', 'bp-modify-member-directory' ); ?></h3>
	<div>
		<p>
			<?php esc_html_e( 'This plugin adds option for admin to select which xprofile field will be displayed inside members loop and on profile header.', 'bp-modify-member-directory' ); ?>
		</p>
	</div>
	<h3><?php esc_html_e( 'How to display some xprofile field inside BuddyPress members loop?', 'bp-modify-member-directory' ); ?></h3>
	<div>
		<p>
			<?php esc_html_e( 'This plugin includes settings to display xprofile fields with field group name, here you can enable those fields which you want to display inside members loop.', 'bp-modify-member-directory' ); ?>
		</p>
	</div>
	<h3><?php esc_html_e( 'How to display some xprofile field on BuddyPress single page profile header?', 'bp-modify-member-directory' ); ?></h3>
	<div>
		<p>
			<?php esc_html_e( 'This plugin includes settings to display xprofile fields with field group name, here you can enable those fields which you want to display on BuddyPress single page profile header.', 'bp-modify-member-directory' ); ?>
		</p>
	</div>
	<h3><?php esc_html_e( 'Where do I ask for support?', 'bp-modify-member-directory' ); ?></h3>
	<div>
		<p>
			<?php
			/* translators: %s: http://wbcomdesigns.com/contact */
			$text = sprintf(
				__( 'Please visit <a href="%s"  rel="nofollow" target="_blank">Wbcom Designs</a> for any query related to plugin and BuddyPress..' ),
				__( 'http://wbcomdesigns.com/contact' )
			);
			echo wp_kses_post( $text );
			?>
		</p>
	</div>
</div>
</div>
