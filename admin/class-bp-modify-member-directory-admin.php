<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Bp_Modify_Member_Directory
 * @subpackage Bp_Modify_Member_Directory/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Bp_Modify_Member_Directory
 * @subpackage Bp_Modify_Member_Directory/admin
 * @author     Wbcom Designs <<admin@wbcomdesigns.com>>
 */
class Bp_Modify_Member_Directory_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bp_Modify_Member_Directory_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bp_Modify_Member_Directory_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_register_style( 'font_awesome_css', plugin_dir_url( __FILE__ ) .'css/font-awesome.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'font_awesome_css' );
		wp_enqueue_style( 'jquery-ui-css', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bp-modify-member-directory-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bp_Modify_Member_Directory_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bp_Modify_Member_Directory_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if ( !wp_script_is( 'jquery-ui-accordion', 'enqueued' ) ) {
			wp_enqueue_script( 'jquery-ui-accordion' );
		}

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/bp-modify-member-directory-admin.js', array( 'jquery' ), $this->version, false );
	}

	/*
	*	Adding Options page
	*/
	public function admin_menu_link_function(){

		add_options_page('BP Modify Member', 'BP Modify Member', 'manage_options', 'bp-modify-member-directory', array(&$this, 'bp_modify_profile_directory_function'));
	}
	/*
	*  Creating listing of profile fields
	*/
	public function bp_modify_profile_directory_function(){
		$tab = isset($_GET['tab']) ? $_GET['tab'] : 'bpmmd_general_settings'; ?>
		<div id="wpbody-content" class="bpmmd-setting-page" aria-label="Main content" tabindex="0">
			<div class="wrap">
				<div class="bpmmd-header">
					<div class="bpmmd-extra-actions">
						<button type="button" class="button button-secondary" onclick="window.open('https://wbcomdesigns.com/contact/', '_blank');"><i class="fa fa-envelope" aria-hidden="true"></i> <?php _e( 'Email Support', BPMMD_TEXT_DOMAIN )?></button>
						<button type="button" class="button button-secondary" onclick="window.open('https://wbcomdesigns.com/helpdesk/article-categories/bp-modify-member-directory/', '_blank');"><i class="fa fa-file" aria-hidden="true"></i> <?php _e( 'User Manual', BPMMD_TEXT_DOMAIN )?></button>
						<button type="button" class="button button-secondary" onclick="window.open('https://wordpress.org/support/plugin/bp-modify-member-directory/reviews/', '_blank');"><i class="fa fa-star" aria-hidden="true"></i> <?php _e( 'Rate Us on WordPress.org', BPMMD_TEXT_DOMAIN )?></button>
					</div>
				</div>
				<h1><?php _e('BP Modify Member Directory/Header Settings', BPMMD_TEXT_DOMAIN ); ?></h1>
				<?php $this->bpmmd_plugin_settings_tabs($tab); ?>
	<?php
	}

	public function bpmmd_plugin_settings_tabs( $current ){
		$bpmmd_tabs = array(
				'bpmmd_general_settings' => __('General', BPMMD_TEXT_DOMAIN),
				'bpmmd_faq' => __('FAQ', BPMMD_TEXT_DOMAIN)
			);

			$tab_html =  '<h2 class="nav-tab-wrapper">';
			foreach( $bpmmd_tabs as $bpmmd_tab => $bpmmd_name ){
				$class = ($bpmmd_tab == $current) ? 'nav-tab-active' : '';
				$tab_html .=  '<a class="nav-tab '.$class.'" href="admin.php?page=bp-modify-member-directory&tab=' . $bpmmd_tab . '">' . $bpmmd_name . '</a>';
			}
			$tab_html .= '</h2>';
			echo $tab_html;
			$this->bpmmd_include_admin_setting_tabs($current);
	}

	public function bpmmd_include_admin_setting_tabs( $current ) {
	    $bpmmd = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : $current;
	    switch($bpmmd){
	        case 'bpmmd_general_settings'	: 	$this->bpmmd_general_settings_section();
	            								break;
	        case 'bpmmd_faq'             	:	$this->bpmmd_faq_section();
	               								break;
	        default                     	:  	$this->bpmmd_general_settings_section();
	            								break;
	    }
	}

	public function bpmmd_general_settings_section() {

		$profile_groups = BP_XProfile_Group::get(array('fetch_fields'=>true));

		// Submitting form on admin page and saving to DB

		if(isset($_POST['bpmpd-fields-submit']) && check_admin_referer('bpmpd_fields_nonce_action','bpmpd_fields_nonce_value')):
			$bpmpd_fields_loops = array();

			if(!empty($profile_groups)){
				foreach ($profile_groups as $profile_group) {
					$bpmpd_fields_loops[$profile_group->id] =	isset($_POST[$profile_group->id.'-loop'])? wp_unslash($_POST[$profile_group->id.'-loop']) : array();
				}
			}

			if(is_array($bpmpd_fields_loops)){
				foreach ($bpmpd_fields_loops as $loop_key => $bpmpd_fields_loop) {
					foreach($bpmpd_fields_loop as $loop_key_1 => $loop_value){
						filter_var($bpmpd_fields_loops[$loop_key][$loop_key_1], FILTER_SANITIZE_NUMBER_INT);
					}
				}
			}

			$bpmpd_fields_single_members = array();

			if(!empty($profile_groups)){
				foreach ($profile_groups as $profile_group) {
					$bpmpd_fields_single_members[$profile_group->id] =	isset($_POST[$profile_group->id.'-single'])? wp_unslash($_POST[$profile_group->id.'-single']) : array();
				}
			}

			if(is_array($bpmpd_fields_single_members)){
				foreach ($bpmpd_fields_single_members as $single_key => $bpmpd_fields_single_member) {
					foreach($bpmpd_fields_single_member as $single_key_1 => $single_value_){
						filter_var($bpmpd_fields_single_members[$single_key][$single_key_1], FILTER_SANITIZE_NUMBER_INT);
					}
				}
			}

			// Updating database

			$bpmpd_fields_db =array();
			array_push($bpmpd_fields_db, $bpmpd_fields_loops);
			array_push($bpmpd_fields_db, $bpmpd_fields_single_members);
			update_option($this->plugin_name,$bpmpd_fields_db);

		endif;?>

		<?php $bpmpd_fields_get_db = get_option($this->plugin_name);

			$mergerd_loop_array = array();
			if( !empty( $bpmpd_fields_get_db ) ) {
				foreach($bpmpd_fields_get_db['0'] as $merged_loop_value){
					$mergerd_loop_array = array_merge($mergerd_loop_array,$merged_loop_value);
				}

				$mergerd_single_array = array();

				foreach($bpmpd_fields_get_db['1'] as $merged_single_value){
					$mergerd_single_array = array_merge($mergerd_single_array,$merged_single_value);
				}
			}
			?>
			<form method="post" action="" class="bpmmd-general-settings">
				<?php wp_nonce_field('bpmpd_fields_nonce_action','bpmpd_fields_nonce_value'); ?>
				<h2><?php _e('Select fields from each group to show on members loop page',$this->plugin_name);?>
				</h2>
				<table class="form-table" >
				<?php
				if(!empty($profile_groups)):
					$i=1;
					foreach( $profile_groups as $profile_group): ?>
						<tr>
							<th scope="row"><label class="field-description" ><?php _e( 'Field Group : ', BPMMD_TEXT_DOMAIN ); echo $profile_group->name; ?></label></th>
							<td>
								<?php if (!empty($profile_group->fields)):?>
									<table class="bpmpd-fields">
									<?php foreach ($profile_group->fields as $field):?>
										<tr>
											<td>
												<input type="checkbox" name="<?php echo $profile_group->id?>-loop[]" value="<?php echo $field->id; ?>" <?php echo (isset($bpmpd_fields_get_db['0']) && in_array($field->id,$mergerd_loop_array))?'checked':'';?>>
												<?php echo $field->name;?>
											</td>
										</tr>
									<?php endforeach; ?>

									</table>

								<?php endif; $i++; ?>
							</td>
						</tr>
					<?php endforeach;?>
				</table>
				<h2><?php _e('Select fields from each group to show on single members page', BPMMD_TEXT_DOMAIN ); ?>
				</h2>
				<table class="form-table" >
					<?php $j=1;
						foreach( $profile_groups as $profile_group ): ?>
							<tr>
								<th scope="row"><label class="field-description" ><?php _e( 'Field Group : ', BPMMD_TEXT_DOMAIN ); echo $profile_group->name; ?></label></th>
								<td>
								<?php if (!empty($profile_group->fields)):?>
									<table class="bpmpd-fields">
									<?php foreach ($profile_group->fields as $field): ?>
										<tr>
											<td>
												<input type="checkbox" name="<?php echo $profile_group->id;?>-single[]" value="<?php echo $field->id; ?>" <?php echo (isset($bpmpd_fields_get_db['1']) && in_array($field->id,$mergerd_single_array))?'checked':'';?>><?php echo $field->name;?>
											</td>
										</tr>
									<?php endforeach; ?>
									</table>
								<?php endif; $j++;?>
								</td>
							</tr>
					<?php endforeach;?>
			  	</table>
		  	<?php endif;?>
		  	<div class="bpmpd-submit">
			  	<input type="submit" name="bpmpd-fields-submit" value="<?php _e( 'Save', BPMMD_TEXT_DOMAIN ); ?>" class="button-primary">
			</div>
		</form>
	<?php }

	public function bpmmd_faq_section() { ?>
		<div id="bpmmd_faq_accordion">
			<h3><?php _e( 'Is this plugin requires another plugin?', BPMMD_TEXT_DOMAIN ); ?></h3>
			<div>
				<p>
					<?php _e( 'Yes, this plugin requires BuddyPress plugin.', BPMMD_TEXT_DOMAIN ); ?>
				</p>
			</div>
			<h3><?php _e( 'What does this plugin work?', BPMMD_TEXT_DOMAIN ); ?></h3>
			<div>
				<p>
					<?php _e( 'This plugin adds option for admin to select which xprofile field will be displayed inside members loop and on profile header.', BPMMD_TEXT_DOMAIN ); ?>
				</p>
			</div>
			<h3><?php _e( 'How to display some xprofile field inside BuddyPress members loop?', BPMMD_TEXT_DOMAIN ); ?></h3>
			<div>
				<p>
					<?php _e( 'This plugin includes settings to display xprofile fields with field group name, here you can enable those fields which you want to display inside members loop.', BPMMD_TEXT_DOMAIN ); ?>
				</p>
			</div>
			<h3><?php _e( 'How to display some xprofile field on BuddyPress single page profile header?', BPMMD_TEXT_DOMAIN ); ?></h3>
			<div>
				<p>
					<?php _e( 'This plugin includes settings to display xprofile fields with field group name, here you can enable those fields which you want to display on BuddyPress single page profile header.', BPMMD_TEXT_DOMAIN ); ?>
				</p>
			</div>
			<h3><?php _e( 'Where do I ask for support?', BPMMD_TEXT_DOMAIN ); ?></h3>
			<div>
				<p>
					<?php _e( 'Please visit <a href="http://wbcomdesigns.com/contact" rel="nofollow" target="_blank">Wbcom Designs</a> for any query related to plugin and BuddyPress.', BPMMD_TEXT_DOMAIN ); ?>
				</p>
			</div>
		</div>
	<?php }

}
