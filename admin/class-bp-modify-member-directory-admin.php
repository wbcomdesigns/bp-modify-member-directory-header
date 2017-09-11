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

			foreach($bpmpd_fields_get_db['0'] as $merged_loop_value){
				$mergerd_loop_array = array_merge($mergerd_loop_array,$merged_loop_value);
			}

			$mergerd_single_array = array();

			foreach($bpmpd_fields_get_db['1'] as $merged_single_value){
				$mergerd_single_array = array_merge($mergerd_single_array,$merged_single_value);
			}?>

		<div class="bpmpd-setting-page">

			<h1 class="bpmpd-page-title">

				<?php _e('BP Modify Member Directory/Header Setting Page', $this->plugin_name);?>

			</h1>

			<h4><?php _e('(A). Select fields from each group to show on members loop page',$this->plugin_name);?>
			</h4>

			<form method="post" action="">
				<?php wp_nonce_field('bpmpd_fields_nonce_action','bpmpd_fields_nonce_value'); 
				
				if(!empty($profile_groups)):
					$i=1;
					foreach( $profile_groups as $profile_group):?>
						<h5><?php echo "($i). Field Group : "; echo $profile_group->name; ?></h5>
						<?php if (!empty($profile_group->fields)):?>
								<ul class="bpmpd-fields">
								<?php foreach ($profile_group->fields as $field):?>
									
									<li>
										<input type="checkbox" name="<?php echo $profile_group->id?>-loop[]" value="<?php echo $field->id; ?>" <?php echo (isset($bpmpd_fields_get_db['0']) && in_array($field->id,$mergerd_loop_array))?'checked':'';?>>
										<?php echo $field->name;?>

									</li>
								<?php endforeach;?>

								</ul>

							<?php endif; $i++;?>

					<?php endforeach;?>

						<h4><?php _e('(B.) Select fields from each group to show on single members page',$this->plugin_name);?>
						</h4>

						<?php $j=1;
							foreach( $profile_groups as $profile_group):?>

							<h5><?php echo "($j). Field Group : "; echo $profile_group->name; ?></h5>

						<?php if (!empty($profile_group->fields)):?>

								<ul class="bpmpd-fields">

								<?php foreach ($profile_group->fields as $field):?>

									<li>
										<input type="checkbox" name="<?php echo $profile_group->id;?>-single[]" value="<?php echo $field->id; ?>" <?php echo (isset($bpmpd_fields_get_db['1']) && in_array($field->id,$mergerd_single_array))?'checked':'';?>><?php echo $field->name;?>
									</li>

								<?php endforeach;?>

								</ul>

							<?php endif; $j++;?>

					<?php endforeach;?>

				  <?php endif;?>

				  <div class="bpmpd-submit">

				  	<input type="submit" name="bpmpd-fields-submit" value="Save" class="button-primary">

				  </div>

				</form>
				
		</div>
	<?php 
	}
}
