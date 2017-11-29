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
 * @author     Mohamed Hajjej <mohamed.hajjej@foursites.nl>
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
		//wp_enqueue_style('e2b-admin-ui-css','http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/base/jquery-ui.css',false,"1.9.0",false);

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
		wp_enqueue_script("jquery-ui-draggable");
		wp_enqueue_script("jquery-ui-droppable");
		wp_enqueue_script("jquery-ui-sortable");
		wp_enqueue_script("jquery-ui-autocomplete");


		//wp_enqueue_script($this->plugin_name,'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js', array('jquery'), '1.8.6');
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

	function load_ajax()
	{
		$pa = 'hello my bRother';
		echo $pa;
		wp_die();
	}

	function load_issue()
	{
		$pa = $_POST["key"];
		echo User::getIssue($pa);
		wp_die();
	}

	function update_caps()
	{

		$id = $_POST["id"];

		$granted = json_encode($_POST["granted"], true);
		$granted = str_replace('[','',$granted);
		$granted = str_replace(']','',$granted);
		$granted = str_replace('"','',$granted);

		$ungranted = json_encode($_POST["ungranted"], true);
		$ungranted = str_replace('[','',$ungranted);
		$ungranted = str_replace(']','',$ungranted);
		$ungranted = str_replace('"','',$ungranted);

		$grantedarr = explode(",", $granted);
		$ungrantedarr = explode(",", $ungranted);

		if ( (!empty($id)) && (!empty($grantedarr)) )
		{
		$role = new Role($id,'',$grantedarr);
		echo $role->AddCap();
		}
		if ( (!empty($id)) && (!empty($ungrantedarr)) )
		{
		$role = new Role($id,'',$ungrantedarr);
		echo $role->RemoveCap();
		}
		wp_die();
	}

	function load_role()
	{
		$role = new Role($_POST["id"],'',array());
		echo $role->ViewRole();
		wp_die();
	}

	function load_admin_role()
	{
		$role = new Role('administrator','',array());
		echo $role->ViewRole();
		wp_die();
	}
	function delete_role()
	{
		$role = new Role($_POST['id'],'',array());
		echo $role->DeleteRole();
		wp_die();
	}

	function FsdpSettingLogin()
	{
		register_setting('jira_user_login', 'login' );
		add_settings_section( 'jira-setting-section', 'Login Form','', 'jira_settings_login' );
		add_settings_field( 'setting-form', '',array($this->callback, 'loginForm') , 'jira_settings_login', 'jira-setting-section');
	}
	function FsdpSettingSignin()
	{
		register_setting('jira_user_signin', 'signin' );
		add_settings_section( 'jira-setting-section', 'Signin Form','' , 'jira_settings_signin' );
		add_settings_field( 'setting-form', '',array($this->callback, 'signinForm') , 'jira_settings_signin', 'jira-setting-section');
	}
	function FsdpSettingCreateIssue()
	{
		register_setting('jira_issue_create', 'createIssue' );
		add_settings_section( 'jira-setting-section', 'Create Issue Form','' , 'jira_settings_create' );
		add_settings_field( 'setting-form', '',array($this->callback, 'createIssueForm') , 'jira_settings_create', 'jira-setting-section');
	}

	function FsdpSettingUpdateIssue()
	{
		register_setting('jira_issue_update', 'updateIssue' );
		add_settings_section( 'jira-setting-section', 'Update Issue Form','' , 'jira_settings_update' );
		add_settings_field( 'setting-form', '',array($this->callback, 'updateIssueForm') , 'jira_settings_update', 'jira-setting-section');
	}

	function FsdpSettingCommentIssue()
	{
		register_setting('jira_issue_comment', 'commentIssue' );
		add_settings_section( 'user-role-setting-section', '','' , 'jira_settings_comment' );
		add_settings_field( 'setting-form', '',array($this->callback, 'commentIssueForm') , 'jira_settings_comment', 'user-role-setting-section');
	}

	function FsdpSettingCreateRole()
	{
		register_setting('user_role_create', 'createRole' );
		add_settings_section( 'jira-setting-section', 'Create role form','' , 'user_role_settings_create' );
		add_settings_field( 'setting-form', '',array($this->callback, 'createRoleForm') , 'user_role_settings_create', 'jira-setting-section');
	}

	function FsdpSettingRenameRole()
	{
		register_setting('user_role_rename', 'renameRole' );
		add_settings_section( 'jira-setting-section', 'Rename role form','' , 'user_role_settings_rename' );
		add_settings_field( 'setting-form', '',array($this->callback, 'renameRoleForm') , 'user_role_settings_rename', 'jira-setting-section');
	}

	function change_role_name()
	{
 		/*global $wp_roles;

	    if ( ! isset( $wp_roles ) )
	        $wp_roles = new WP_Roles();

	    //You can list all currently available roles like this...
	    //$roles = $wp_roles->get_names();
	    //print_r($roles);

	    //You can replace "administrator" with any other role "editor", "author", "contributor" or "subscriber"...
	    $wp_roles->roles['administrator']['name'] = 'Owner';
	    $wp_roles->role_names['administrator'] = 'Owner';*/
	}

	function login()
	{
		status_header(200);
		User::loginSession($_POST['username'],$_POST['password']);
	}
	function signin()
	{
		status_header(200);
		User::signin($_POST['username'],$_POST['password'],$_POST['name'],$_POST['email']);
	}
	function createIssue()
	{
		status_header(200);
		User::create($_POST['summary'],$_POST['description'],$_POST['type'],$_POST['priority'],$_POST['page']);
	}
	function updateIssue()
	{
		status_header(200);
		User::update($_POST['issue'],$_POST['summary'],$_POST['description'],$_POST['type'],$_POST['priority']);
	}
	function commentIssue()
	{
		status_header(200);
		User::comment($_POST['issuekeycomment'],$_POST['comment']);
	}
	function createRole()
	{
		status_header(200);
		$role = new Role($_POST['id'],$_POST['name'],array());
		$role->CreateRole();
	}

	function renameRole()
	{
		status_header(200);
		$role = new Role($_POST['id'],$_POST['name'],array());
		$role->RenameRole();
	}

}