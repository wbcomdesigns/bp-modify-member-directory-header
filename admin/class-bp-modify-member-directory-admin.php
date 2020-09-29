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
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

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
		wp_register_style( 'font_awesome_css', plugin_dir_url( __FILE__ ) . 'css/font-awesome.min.css', array(), $this->version, 'all' );
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

		if ( ! wp_script_is( 'jquery-ui-accordion', 'enqueued' ) ) {
			wp_enqueue_script( 'jquery-ui-accordion' );
		}

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/bp-modify-member-directory-admin.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Register admin menu page for plugin
	 *
	 * @since    1.0.0
	 * @access   public
	 * @author   Wbcom Designs
	 */
	public function bpmmd_admin_menu() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bp_Xprofile_Export_Import_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bp_Xprofile_Export_Import_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if ( empty( $GLOBALS['admin_page_hooks']['wbcomplugins'] ) ) {
			add_menu_page( esc_html__( 'WB Plugins', 'bp-xprofile-export-import' ), esc_html__( 'WB Plugins', 'bp-xprofile-export-import' ), 'manage_options', 'wbcomplugins', array( $this, 'bp_modify_profile_directory_setting_page' ), 'dashicons-lightbulb', 59 );
			add_submenu_page( 'wbcomplugins', esc_html__( 'General', 'bp-xprofile-export-import' ), esc_html__( 'General', 'bp-xprofile-export-import' ), 'manage_options', 'wbcomplugins' );
		}

		add_submenu_page( 'wbcomplugins', esc_html__( 'BP Modify Member Directory/Header', 'bp-xprofile-export-import' ), esc_html__( 'BP Modify Member Directory/Header', 'bp-xprofile-export-import' ), 'manage_options', 'bpxp-member-export-import', array( $this, 'bp_modify_profile_directory_setting_page' ) );

	}


	/**
	 * Callback function for bp member xprofile export import settings page.
	 *
	 * @since    1.0.0
	 * @param    string $current       The current tab.
	 */
	public function bp_modify_profile_directory_setting_page() {
		$current = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'bpmmd_general_settings';
		?>
		<div class="wrap">
		<div class="blpro-header">
			<?php echo do_shortcode( '[wbcom_admin_setting_header]' ); ?>
			<h1 class="wbcom-plugin-heading">
				<?php esc_html_e( 'BuddyPress Member Export Import Settings', 'bp-xprofile-export-import' ); ?>
			</h1>
		</div>
		<div class="wbcom-admin-settings-page">
		<?php
		$bpmmd_tabs = array(
			'bpmmd_general_settings' => __( 'General', BPMMD_TEXT_DOMAIN ),
			'bpmmd_faq'              => __( 'FAQ', BPMMD_TEXT_DOMAIN ),
		);

		$tab_html = '<div class="wbcom-tabs-section"><h2 class="nav-tab-wrapper">';
		foreach ( $bpmmd_tabs as $bpmmd_tab => $bpmmd_name ) {
			$class     = ( $bpmmd_tab == $current ) ? 'nav-tab-active' : '';
			$tab_html .= '<a class="nav-tab ' . $class . '" href="admin.php?page=bpxp-member-export-import&tab=' . $bpmmd_tab . '">' . $bpmmd_name . '</a>';
		}
		$tab_html .= '</h2></div>';
		echo $tab_html;
		$this->bpmmd_plugin_option_pages();
		echo '</div>'; /* closing of div class wbcom-admin-settings-page */
		echo '</div>'; /* closing div class wrap */
	}


	/**
	 * Get desired options page file at admin settings end.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @author   Wbcom Designs
	 */
	public function bpmmd_plugin_option_pages() {
		if ( isset( $_GET['tab'] ) ) {
			$bpxp_tab = sanitize_text_field( $_GET['tab'] );
		} else {
			$bpxp_tab = 'general';
		}
		$this->bpmmd_include_admin_setting_tabs( $bpxp_tab );
	}

	/**
	 * Include setting template.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @author   Wbcom Designs
	 */
	public function bpmmd_include_admin_setting_tabs( $current ) {
		$bpmmd = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : $current;
		switch ( $bpmmd ) {
			case 'bpmmd_general_settings':
				$this->bpmmd_general_settings_section();
				break;
			case 'bpmmd_faq':
				$this->bpmmd_faq_section();
				break;
			default:
				$this->bpmmd_general_settings_section();
				break;
		}
	}


	public function bpmmd_general_settings_section() {
		include BPMMD_PLUGIN_PATH . 'admin/partials/bp-modify-member-directory-genral-display.php';

	}

	public function bpmmd_faq_section() {
		include BPMMD_PLUGIN_PATH . 'admin/partials/bp-modify-member-directory-faq-display.php';
	}

}
