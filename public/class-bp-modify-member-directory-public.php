<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Bp_Modify_Member_Directory
 * @subpackage Bp_Modify_Member_Directory/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Bp_Modify_Member_Directory
 * @subpackage Bp_Modify_Member_Directory/public
 * @author     Wbcom Designs <<admin@wbcomdesigns.com>>
 */
class Bp_Modify_Member_Directory_Public {

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
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bp-modify-member-directory-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/bp-modify-member-directory-public.js', array( 'jquery' ), $this->version, false );

	}
	/**
	 * Showing xprofile field on members loop page
	 */
	public function member_loop_modification_function() {

		$profile_groups      = BP_XProfile_Group::get( array( 'fetch_fields' => true ) );
		$bpmpd_fields_get_db = get_option( $this->plugin_name );
		$mergerd_loop_array  = array();

		if ( ! empty( $bpmpd_fields_get_db ) && ! empty( $bpmpd_fields_get_db[0] ) ) {
			foreach ( $bpmpd_fields_get_db['0'] as $merged_loop_value ) {
				$mergerd_loop_array = array_merge( $mergerd_loop_array, $merged_loop_value );
			}
		}?>

		<div class="bpmpd-fields-loop">
					<div class="bpmpd-fields-loop-inner">
			<?php
			if ( ! empty( $profile_groups ) ) {

					global $wpdb;
					$user_id                    = bp_get_member_user_id();
					$xprofile_data_tbl          = $wpdb->prefix . 'bp_xprofile_data';
					$get_usr_fields_id_qry      = "SELECT field_id FROM $xprofile_data_tbl WHERE user_id=$user_id";
					$xprofile_usr_fields_id     = $wpdb->get_results( $get_usr_fields_id_qry );
					$xprofile_usr_fields_id_arr = array();

				if ( ! empty( $xprofile_usr_fields_id ) ) {
					foreach ( $xprofile_usr_fields_id as $key => $value ) {
						$xprofile_usr_fields_id_arr[] = $value->field_id;
					}
				}

				foreach ( $profile_groups as $profile_group ) {

					foreach ( $profile_group->fields as $profile_field ) {

						if ( in_array( $profile_field->id, $mergerd_loop_array ) && in_array( $profile_field->id, $xprofile_usr_fields_id_arr ) ) {
							$profile_data = bp_get_member_profile_data( 'field=' . $profile_field->name );
							if ( ! empty( $profile_data ) ) {
								?>
									<div><span class="member-field-name members-<?php echo isset( $profile_field->name ) ? sanitize_title( $profile_field->name ) : ''; ?>"><?php echo $profile_field->name . ' : '; ?></span>
										<span class="member-field-value members-value-<?php echo $profile_field->name; ?>">
										<?php bp_member_profile_data( 'field=' . $profile_field->name ); ?>
										</span>
									</div>
									<?php
							}
						}
					}
				}
			}
			?>
			</div>
		</div>
			<?php
	}

	/**
	 * Showing xprofile field on members loop page
	 */
	public function buddyboss_member_loop_modification_function() {

		$profile_groups      = BP_XProfile_Group::get( array( 'fetch_fields' => true ) );
		$bpmpd_fields_get_db = get_option( $this->plugin_name );
		$mergerd_loop_array  = array();

		if ( ! empty( $bpmpd_fields_get_db ) && ! empty( $bpmpd_fields_get_db[0] ) ) {
			foreach ( $bpmpd_fields_get_db['0'] as $merged_loop_value ) {
				$mergerd_loop_array = array_merge( $mergerd_loop_array, $merged_loop_value );
			}
		}
		?>

		<div class="bpmpd-fields-loop">
			<div class="bpmpd-fields-loop-inner">
			<?php
			if ( ! empty( $profile_groups ) ) {
				global $wpdb;
				$user_id                    = bp_get_member_user_id();
				$xprofile_data_tbl          = $wpdb->prefix . 'bp_xprofile_data';
				$get_usr_fields_id_qry      = "SELECT field_id FROM $xprofile_data_tbl WHERE user_id=$user_id";
				$xprofile_usr_fields_id     = $wpdb->get_results( $get_usr_fields_id_qry );
				$xprofile_usr_fields_id_arr = array();

				if ( ! empty( $xprofile_usr_fields_id ) ) {
					foreach ( $xprofile_usr_fields_id as $key => $value ) {
						$xprofile_usr_fields_id_arr[] = $value->field_id;
					}
				}

				foreach ( $profile_groups as $profile_group ) {
					foreach ( $profile_group->fields as $profile_field ) {
						if ( in_array( $profile_field->id, $mergerd_loop_array ) && in_array( $profile_field->id, $xprofile_usr_fields_id_arr ) ) {
							$profile_data = bp_get_member_profile_data( 'field=' . $profile_field->name );
							if ( ! empty( $profile_data ) ) {

								?>
								<?php if ( 'socialnetworks' != $profile_field->type ) { ?>
										<div><span class="member-field-name  members-<?php echo isset( $profile_field->name ) ? sanitize_title( $profile_field->name ) : ''; ?>"><?php echo $profile_field->name . ' : '; ?></span>
											<span class="member-field-value members-value-<?php echo isset( $profile_field->name ) ? sanitize_title( $profile_field->name ) : ''; ?>">
												<?php bp_member_profile_data( 'field=' . $profile_field->name ); ?>
											</span>
										</div>
									<?php
								} else {
									$providers              = bp_xprofile_social_network_provider();
									$original_option_values = maybe_unserialize( BP_XProfile_ProfileData::get_value_byid( $profile_field->id, $user_id ) );
									if ( isset( $original_option_values ) && ! empty( $original_option_values ) && is_array( $original_option_values ) ) {
										?>
										<div class="social-networks-wrap">
											<?php
											foreach ( $original_option_values as $key => $original_option_value ) {
												if ( '' !== $original_option_value ) {
													$key = bp_social_network_search_key( $key, $providers );
													?>
													<span class="social <?php echo esc_attr( $providers[ $key ]->value ); ?> "><a target="_blank" data-balloon-pos="up" data-balloon="<?php echo esc_attr( $providers[ $key ]->name ); ?> " href="<?php echo esc_url( $original_option_value ); ?>"><?php echo $providers[ $key ]->svg; ?></a></span>
													<?php
												}
											}
											?>
										</div>
										<?php
									}
								}
							}
						}
					}
				}
			}
			?>
			</div>
		</div>
		<?php
	}

		/*
		*   Showing xprofile fieds on memeber's header cover image
		*/
	public function member_header_modification_function() {

		$profile_groups       = BP_XProfile_Group::get( array( 'fetch_fields' => true ) );
		$bpmpd_fields_get_db  = get_option( $this->plugin_name );
		$mergerd_member_array = array();

		if ( ! empty( $bpmpd_fields_get_db ) && ! empty( $bpmpd_fields_get_db['1'] ) ) {

			foreach ( $bpmpd_fields_get_db['1'] as $merged_member_value ) {
				$mergerd_member_array = array_merge( $mergerd_member_array, $merged_member_value );
			}
		}
		?>

		<div class="bpmpd-fields-member">
					<div class="bpmpd-fields-member-inner">
		<?php
		if ( ! empty( $profile_groups ) ) {

				global $wpdb;
				$user_id = bp_displayed_user_id();

				$xprofile_data_tbl      = $wpdb->prefix . 'bp_xprofile_data';
				$get_usr_fields_id_qry  = "SELECT field_id FROM $xprofile_data_tbl WHERE user_id=$user_id";
				$xprofile_usr_fields_id = $wpdb->get_results( $get_usr_fields_id_qry );

				$xprofile_usr_fields_id_arr = array();

			if ( ! empty( $xprofile_usr_fields_id ) ) {
				foreach ( $xprofile_usr_fields_id as $key => $value ) {
					$xprofile_usr_fields_id_arr[] = $value->field_id;
				}
			}

			foreach ( $profile_groups as $profile_group ) {

				foreach ( $profile_group->fields as $profile_field ) {

					if ( in_array( $profile_field->id, $mergerd_member_array ) && in_array( $profile_field->id, $xprofile_usr_fields_id_arr ) ) {
						$profile_data = bp_get_member_profile_data( 'field=' . $profile_field->name );
						if ( ! empty( $profile_data ) ) {
							?>
									<div><span class=members-<?php echo $profile_field->name; ?>><?php echo $profile_field->name . ' : '; ?></span>
										<span class=members-value-<?php echo $profile_field->name; ?>>
															<?php bp_member_profile_data( 'field=' . $profile_field->name ); ?>
										</span>
									</div>
							<?php
						}
					}
				}
			}
		}
		?>
			</div>
		</div>
		<?php
	}
}
