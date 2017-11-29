<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that inc attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    foursites-dashboard-plugin
 * @subpackage foursites-dashboard-plugin/inc
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    foursites-dashboard-plugin
 * @subpackage foursites-dashboard-plugin/inc
 * @author     Mohamed Hajjej <mohamed.hajjej@esprit.tn>
 */

namespace inc;

class FSDP {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PLUGIN_VERSION' ) ) {
			$this->version = PLUGIN_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'foursites-dashboard-plugin';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Loader. Orchestrates the hooks of the plugin.
	 * - I18n. Defines internationalization functionality.
	 * - FSDP_Admin. Defines all hooks for the admin area.
	 * - FSDP_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'inc/class-FSDP-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'inc/class-FSDP-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'adm/Admin.php';
		//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'pub/Front.php';
		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/Public.php';

		$this->loader = new Loader();



		/*register_setting('jira_user', 'email' );
		add_settings_section( 'jira-setting-section', 'Setting Form', 'jira_setting_section', 'jira_settings' );
		add_settings_field( 'setting-form', 'jira-setting-form', 'showSettingsPage', 'jira_settings', 'jira-setting-section');
		*/


	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new \admin\Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'display_admin_page');
		$this->loader->add_action( 'admin_bar_menu', $plugin_admin, 'toolbar_jira',999 );

		$this->loader->add_action( 'admin_init', $plugin_admin, 'FsdpSettingLogin' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'FsdpSettingSignin' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'FsdpSettingCreateIssue' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'FsdpSettingUpdateIssue' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'FsdpSettingCommentIssue' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'FsdpSettingCreateRole' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'FsdpSettingRenameRole' );


		$this->loader->add_action( 'admin_post_nopriv_login_form', $plugin_admin, 'login' );
		$this->loader->add_action( 'admin_post_login_form', $plugin_admin, 'login' );

		$this->loader->add_action( 'admin_post_nopriv_signin_form', $plugin_admin, 'signin' );
		$this->loader->add_action( 'admin_post_signin_form', $plugin_admin, 'signin' );

		$this->loader->add_action( 'admin_post_nopriv_create_issue_form', $plugin_admin, 'createIssue' );
		$this->loader->add_action( 'admin_post_create_issue_form', $plugin_admin, 'createIssue' );

		$this->loader->add_action( 'admin_post_nopriv_update_issue_form', $plugin_admin, 'updateIssue' );
		$this->loader->add_action( 'admin_post_update_issue_form', $plugin_admin, 'updateIssue' );

		$this->loader->add_action( 'admin_post_nopriv_comment_issue_form', $plugin_admin, 'commentIssue' );
		$this->loader->add_action( 'admin_post_comment_issue_form', $plugin_admin, 'commentIssue' );

		$this->loader->add_action( 'admin_post_nopriv_create_role_form', $plugin_admin, 'createRole' );
		$this->loader->add_action( 'admin_post_create_role_form', $plugin_admin, 'createRole' );

		$this->loader->add_action( 'admin_post_nopriv_rename_role_form', $plugin_admin, 'renameRole' );
		$this->loader->add_action( 'admin_post_rename_role_form', $plugin_admin, 'renameRole' );

		//Testing ajax button
		$this->loader->add_action( 'wp_ajax_nopriv_load_ajax', $plugin_admin, 'load_ajax' );
		$this->loader->add_action( 'wp_ajax_load_ajax', $plugin_admin, 'load_ajax' );

		$this->loader->add_action( 'wp_ajax_nopriv_load_issue', $plugin_admin, 'load_issue' );
		$this->loader->add_action( 'wp_ajax_load_issue', $plugin_admin, 'load_issue' );

		$this->loader->add_action( 'wp_ajax_nopriv_update_caps', $plugin_admin, 'update_caps' );
		$this->loader->add_action( 'wp_ajax_update_caps', $plugin_admin, 'update_caps' );

		$this->loader->add_action( 'wp_ajax_nopriv_delete_role', $plugin_admin, 'delete_role' );
		$this->loader->add_action( 'wp_ajax_delete_role', $plugin_admin, 'delete_role' );

		$this->loader->add_action( 'wp_ajax_nopriv_load_role', $plugin_admin, 'load_role' );
		$this->loader->add_action( 'wp_ajax_load_role', $plugin_admin, 'load_role' );

		$this->loader->add_action( 'wp_ajax_nopriv_load_admin_role', $plugin_admin, 'load_admin_role' );
		$this->loader->add_action( 'wp_ajax_load_admin_role', $plugin_admin, 'load_admin_role' );




		/*$this->loader->add_action( 'admin_post_nopriv_signin_form', $plugin_admin, 'prefix_send_email_to_admin' );
		$this->loader->add_action( 'admin_post_signin_form', $plugin_admin, 'prefix_send_email_to_admin' );*/

		//$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'display_admin_page' );
		$this->loader->add_filter( 'plugin_action_links_foursites-dashboard-plugin/foursites-dashboard-plugin.php',$plugin_admin,'settings_link');

	}


	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new \front\Front( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}
	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}