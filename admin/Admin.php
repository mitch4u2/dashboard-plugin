<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    foursites-dashboard-plugin
 * @subpackage foursites-dashboard-plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    foursites-dashboard-plugin
 * @subpackage foursites-dashboard-plugin/admin
 * @author     Mohamed Hajjej <mohamed.hajjej@esprit.tn>
 */

namespace admin;

class Admin{

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
	 * The callback of this plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $callback    The current version of this plugin.
	 */
	public $callback;

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
		$this->callback = new AdminCallbacks();

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
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/FSDP-admin.css', array(), $this->version, 'all' );

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
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/FSDP-admin.js', array( 'jquery' ), $this->version, true );
	}

	public function toolbar_jira( $wp_admin_bar ) {
		$slug='';
		$url = site_url();
		if (is_page()) {
			$slug = '&slug='.basename(get_permalink());
		}

		$args = array(
			'id'    => 'my_page',
			'title' => 'Create a Ticket',
			'href'  => $url.'/wp-admin/admin.php?page=create_issue'.$slug,
			'meta'  => array( 'class' => 'my-toolbar-page' ),
		);
		$wp_admin_bar->add_node( $args );
	}



	public function display_admin_page()
	{
		//require_once( dirname( __FILE__ ) . '/curl.php' );
		add_menu_page(
			'Jira Tickets',//page title
			'Foursites',//menu title
			'manage_options',//capability
			'jira_tickets',//menu slug
			array($this->callback, 'showPageJira'),//function
			'dashicons-tickets-alt',//icon url
			'3.0'//position in the menu
		);
		add_submenu_page(
			'jira_tickets',//parent slug
			'Settings',//page title
			'Settings',//menu title
			'manage_options',//capability
			'jira_settings',//menu slug
			array($this->callback,'showSettingsPage')//function
		);
		add_submenu_page(
			'jira_tickets',//parent slug
			'Create Issue',//page title
			'Create Issue',//menu title
			'manage_options',//capability
			'create_issue',//menu slug
			array($this->callback,'showCreatePage')//function
		);
		add_menu_page(
			'User Role',//page title
			'User Role',//menu title
			'manage_options',//capability
			'user_role',//menu slug
			array($this->callback, 'showPageUserRole'),//function
			'dashicons-groups',//icon url
			'4.0'//position in the menu
		);
	}


	public function settings_link( $links )
	{
		$settings_link = '<a href="admin.php?page=jira_tickets">Settings</a>';
		array_push($links, $settings_link);
		return $links;
	}

	function load_ajax(){
		//global $wpdb;
		//$pa = intval($_POST["page"]);
		$pa = 'hello my bRother';
		echo $pa;
		wp_die();
	}

	function load_issue(){
		//global $wpdb;
		$pa = $_POST["key"];
		echo User::getIssue($pa);
		wp_die();
	}

	function FsdpSettingLogin(){
		register_setting('jira_user_login', 'login' );
		add_settings_section( 'jira-setting-section', 'Login Form','', 'jira_settings_login' );
		add_settings_field( 'setting-form', '',array($this->callback, 'loginForm') , 'jira_settings_login', 'jira-setting-section');
	}
	function FsdpSettingSignin(){
		register_setting('jira_user_signin', 'signin' );
		add_settings_section( 'jira-setting-section', 'Signin Form','' , 'jira_settings_signin' );
		add_settings_field( 'setting-form', '',array($this->callback, 'signinForm') , 'jira_settings_signin', 'jira-setting-section');
	}
	function FsdpSettingCreate(){
		register_setting('jira_user_create', 'create' );
		add_settings_section( 'jira-setting-section', 'Create Form','' , 'jira_settings_create' );
		add_settings_field( 'setting-form', '',array($this->callback, 'createForm') , 'jira_settings_create', 'jira-setting-section');
	}

	function FsdpSettingUpdate(){
		register_setting('jira_user_update', 'update' );
		add_settings_section( 'jira-setting-section', 'update Form','' , 'jira_settings_update' );
		add_settings_field( 'setting-form', '',array($this->callback, 'updateForm') , 'jira_settings_update', 'jira-setting-section');
	}

	function login() {
		status_header(200);
		User::loginSession($_POST['username'],$_POST['password']);
	}
	function signin() {
		status_header(200);
		User::signin($_POST['username'],$_POST['password'],$_POST['name'],$_POST['email']);
	}
	function create() {
		status_header(200);
		User::create($_POST['summary'],$_POST['description'],$_POST['type'],$_POST['priority'],$_POST['page']);
	}
	function update() {
		status_header(200);
		User::update($_POST['issue'],$_POST['summary'],$_POST['description'],$_POST['type'],$_POST['priority']);
	}

}