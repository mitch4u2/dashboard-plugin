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
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/FSDP-admin.css', array(), $this->version, 'all' );
		/*echo '<pre>';
		var_dump( $this->plugin_path );
		echo '</pre>';*/
		//die();


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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/FSDP-admin.js', array( 'jquery' ), $this->version, false );

	}
	public function display_admin_page()
	{
		//require_once( dirname( __FILE__ ) . '/curl.php' );
		add_menu_page(
			'Jira Tickets',//page title
			'Jira Tickets',//menu title
			'manage_options',//capability
			'jira_tickets',//menu slug
			array($this, 'showPageJira'),//function
			'dashicons-tickets-alt',//icon url
			'3.0'//position in the menu
		);
		add_submenu_page(
			'jira_tickets',//parent slug
			'Settings',//page title
			'Settings',//menu title
			'manage_options',//capability
			'jira_settings',//menu slug
			array($this,'showSettingsPage')//function
		);
		add_menu_page(
			'User Role',//page title
			'User Role',//menu title
			'manage_options',//capability
			'user_role',//menu slug
			array($this, 'showPageUserRole'),//function
			'dashicons-groups',//icon url
			'4.0'//position in the menu
		);
	}
	public function showPageJira()
	{
		include plugin_dir_path(__FILE__ ).'partials/FSDP-admin-display.php';
	}
	public function showSettingsPage()
	{
		include plugin_dir_path(__FILE__ ).'partials/jira-settings-display.php';
	}
	public function showPageUserRole()
	{
		include plugin_dir_path(__FILE__ ).'partials/FSDP-admin-display.php';
	}

	public function settings_link( $links )
	{
		$settings_link = '<a href="admin.php?page=jira_tickets">Settings</a>';
		array_push($links, $settings_link);
		return $links;
	}

	function FsdpSettingLogin(){
		register_setting('jira_user_login', 'login' );
		add_settings_section( 'jira-setting-section', 'Setting Form',array($this, 'jira_setting_section') , 'jira_settings_login' );
		add_settings_field( 'setting-form', '',array($this, 'loginForm') , 'jira_settings_login', 'jira-setting-section');
	}
	function FsdpSettingSignin(){
		register_setting('jira_user_signin', 'signin' );
		add_settings_section( 'jira-setting-section', 'Setting Form',array($this, 'jira_setting_section') , 'jira_settings_signin' );
		add_settings_field( 'setting-form', '',array($this, 'signinForm') , 'jira_settings_signin', 'jira-setting-section');
	}

	function jira_setting_section(){

	}

	function loginForm(){
		$options = get_option( 'login');
		$checked = (@$options == 1 ? 'checked' : '');
		if (isset($_GET['error'])) {
			echo "<label><b>Username or password is wrong</b></label><br>";
			echo $_GET['error'];}
			echo '
			<label>
			<input type="checkbox" id="login" name="login" value="" '.$checked.' />
			Activate the custom header
			</label><br>
			<label>
			<input type="text" id="username" name="username" value="" placeholder="username or email" required />
			Username
			</label><br>
			<label>
			<input type="password" id="password" name="password" value="" /*pattern="(?=^.{8,}$)((?=.*\d)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"*/ required/>

			Password
			</label><br>
			<a href="http://jira.foursites.nl/secure/ForgotLoginDetails.jspa" target="_blank">forget my password</a>
			<input type="hidden" name="action" value="login_form">
			';
		}

		function signinForm(){
			$options = get_option( 'signin');
			$checked = (@$options == 1 ? 'checked' : '');
		/*if (!empty($result)) {
			echo $result;
		}*/
		if (isset($_GET['info'])) {
			echo "<label><b>Username or password is wrong</b></label><br>";
			echo $_GET['info'];}
		echo '
		<label>
		<input type="checkbox" id="signin" name="signin" value="Mr anderson Welcome Back we missed you" '.$checked.' />
		Activate the custom header
		</label><br>
		<label>
		<input type="text" id="username" name="username" value="" placeholder="username" required/>
		Username
		</label><br>
		<label>
		<input type="text" id="name" name="name" value="" placeholder="name" required/>
		name
		</label><br>
		<label>
		<input type="email" id="email" name="email" value="" placeholder="email" required/>
		Email
		</label><br>
		<label>
		<input type="password" id="password" name="password" value="" pattern="(?=^.{8,}$)((?=.*\d)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required/>
		Password
		</label><br>
		<input type="hidden" name="action" value="signin_form">
		';
	}


	function login() {
		status_header(200);
		$user = new User('','');
		$user->login($_POST['username'],$_POST['password']);


	}
	function signin() {
		status_header(200);
		$user = new User('','');
		$user->signin($_POST['username'],$_POST['password'],$_POST['name'],$_POST['email']);
	}

}