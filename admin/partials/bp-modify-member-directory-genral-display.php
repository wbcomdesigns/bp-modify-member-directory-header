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

$profile_groups = BP_XProfile_Group::get( array( 'fetch_fields' => true ) );

// Submitting form on admin page and saving to DB

if ( isset( $_POST['bpmpd-fields-submit'] ) && check_admin_referer( 'bpmpd_fields_nonce_action', 'bpmpd_fields_nonce_value' ) ) :
	$bpmpd_fields_loops = array();

	if ( ! empty( $profile_groups ) ) {
		foreach ( $profile_groups as $profile_group ) {
			$bpmpd_fields_loops[ $profile_group->id ] = isset( $_POST[ $profile_group->id . '-loop' ] ) ? wp_unslash( $_POST[ $profile_group->id . '-loop' ] ) : array();
		}
	}

	if ( is_array( $bpmpd_fields_loops ) ) {
		foreach ( $bpmpd_fields_loops as $loop_key => $bpmpd_fields_loop ) {
			foreach ( $bpmpd_fields_loop as $loop_key_1 => $loop_value ) {
				filter_var( $bpmpd_fields_loops[ $loop_key ][ $loop_key_1 ], FILTER_SANITIZE_NUMBER_INT );
			}
		}
	}

	$bpmpd_fields_single_members = array();

	if ( ! empty( $profile_groups ) ) {
		foreach ( $profile_groups as $profile_group ) {
			$bpmpd_fields_single_members[ $profile_group->id ] = isset( $_POST[ $profile_group->id . '-single' ] ) ? wp_unslash( $_POST[ $profile_group->id . '-single' ] ) : array();
		}
	}

	if ( is_array( $bpmpd_fields_single_members ) ) {
		foreach ( $bpmpd_fields_single_members as $single_key => $bpmpd_fields_single_member ) {
			foreach ( $bpmpd_fields_single_member as $single_key_1 => $single_value_ ) {
				filter_var( $bpmpd_fields_single_members[ $single_key ][ $single_key_1 ], FILTER_SANITIZE_NUMBER_INT );
			}
		}
	}

	// Updating database

	$bpmpd_fields_db = array();
	array_push( $bpmpd_fields_db, $bpmpd_fields_loops );
	array_push( $bpmpd_fields_db, $bpmpd_fields_single_members );
	update_option( $this->plugin_name, $bpmpd_fields_db );

endif;
?>

<?php
$bpmpd_fields_get_db = get_option( $this->plugin_name );

  $mergerd_loop_array = array();
if ( ! empty( $bpmpd_fields_get_db ) ) {
	foreach ( $bpmpd_fields_get_db['0'] as $merged_loop_value ) {
		$mergerd_loop_array = array_merge( $mergerd_loop_array, $merged_loop_value );
	}

	$mergerd_single_array = array();

	foreach ( $bpmpd_fields_get_db['1'] as $merged_single_value ) {
		$mergerd_single_array = array_merge( $mergerd_single_array, $merged_single_value );
	}
}
?>
<div class="wbcom-tab-content">
  <form method="post" action="" class="bpmmd-general-settings">
	<?php wp_nonce_field( 'bpmpd_fields_nonce_action', 'bpmpd_fields_nonce_value' ); ?>
	<h2 class="members-loop"><?php _e( 'Select fields from each group to show on members loop page', 'bp-modify-member-directory' ); ?>
	</h2>
	<table class="form-table" >
	<?php
	if ( ! empty( $profile_groups ) ) :
		$i = 1;
		foreach ( $profile_groups as $profile_group ) :
			?>
		<tr>
		  <th scope="row"><label class="field-description" >
			<?php
			_e( 'Field Group : ', 'bp-modify-member-directory' );
			echo $profile_group->name;
			?>
		  </label></th>
		  <td>
			<?php if ( ! empty( $profile_group->fields ) ) : ?>
			  <table class="bpmpd-fields">
				<?php foreach ( $profile_group->fields as $field ) : ?>
				<tr>
				  <td>
					<input type="checkbox" name="<?php echo $profile_group->id; ?>-loop[]" value="<?php echo $field->id; ?>" <?php echo ( isset( $bpmpd_fields_get_db['0'] ) && in_array( $field->id, $mergerd_loop_array ) ) ? 'checked' : ''; ?>>
					<?php echo $field->name; ?>
				  </td>
				</tr>
			  <?php endforeach; ?>

			  </table>

				<?php
			  endif;
			$i++;
			?>
		  </td>
		</tr>
		<?php endforeach; ?>
	</table>
	<br>
	<br>
	<h2><?php _e( 'Select fields from each group to show on single members page', 'bp-modify-member-directory' ); ?>
	</h2>
	<table class="form-table" >
		<?php
		$j = 1;
		foreach ( $profile_groups as $profile_group ) :
			?>
		  <tr>
			<th scope="row"><label class="field-description" >
			<?php
			_e( 'Field Group : ', 'bp-modify-member-directory' );
			echo $profile_group->name;
			?>
			</label></th>
			<td>
			<?php if ( ! empty( $profile_group->fields ) ) : ?>
			  <table class="bpmpd-fields">
				<?php foreach ( $profile_group->fields as $field ) : ?>
				<tr>
				  <td>
					<input type="checkbox" name="<?php echo $profile_group->id; ?>-single[]" value="<?php echo $field->id; ?>" <?php echo ( isset( $bpmpd_fields_get_db['1'] ) && in_array( $field->id, $mergerd_single_array ) ) ? 'checked' : ''; ?>><?php echo $field->name; ?>
				  </td>
				</tr>
			  <?php endforeach; ?>
			  </table>
				<?php
			  endif;
			$j++;
			?>
			</td>
		  </tr>
		<?php endforeach; ?>
	  </table>
  <?php endif; ?>
	<div class="submit">
	  <input type="submit" name="bpmpd-fields-submit" value="<?php _e( 'Save Settings', 'bp-modify-member-directory' ); ?>" class="button-primary">
  </div>
</form>
</div>
