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
		add_menu_page(
			'Jira Tickets',//page title
			'Foursites',//menu title
			'manage_options',//capability
			'jira_tickets',//menu slug
			array($this->callback, 'showPageJira'),//function
			'data:image/svg+xml;base64,' . base64_encode ("<svg id='Laag_1' data-name='Laag 1' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 134.81 140.94'><defs><style>.cls-1{fill:#FFA500;}</style></defs><title>beeldmerk-white</title><path class='cls-1' d='M38,21.75a53.74,53.74,0,0,1,8.36-4.67h0a51.87,51.87,0,0,1,21.2-4.37,51.72,51.72,0,0,1,21.28,4.37,53,53,0,0,1,8.29,4.67H116.7l-.09-.1c-.15-.16-.28-.33-.42-.49s-.47-.56-.73-.83A67.15,67.15,0,0,0,94.11,5.44,65.1,65.1,0,0,0,67.59,0,65.77,65.77,0,0,0,41,5.44,66.76,66.76,0,0,0,19.55,20.32c-.28.29-.54.59-.79.9l-.39.46-.07.08Z'/><path class='cls-1' d='M96.83,119.29a53.47,53.47,0,0,1-8.14,4.56,51.32,51.32,0,0,1-21.1,4.37,51.92,51.92,0,0,1-21.2-4.37,53,53,0,0,1-17.18-12.11A57.08,57.08,0,0,1,15.72,87H1.84A67.65,67.65,0,0,0,5.23,98.27,70,70,0,0,0,19.54,120.6,66.83,66.83,0,0,0,41,135.5a65.79,65.79,0,0,0,26.61,5.44,65.15,65.15,0,0,0,26.52-5.44,66.54,66.54,0,0,0,21.36-15c.27-.29.53-.59.78-.9l.27-.31Z'/><path class='cls-1' d='M129.67,42.59h0a72.57,72.57,0,0,0-4.43-9.11h-15.8a57.59,57.59,0,0,1,7.69,14,61.38,61.38,0,0,1,3.56,14.76H14.12a60.22,60.22,0,0,1,3.64-14.74,57.9,57.9,0,0,1,7.83-14.07H9.73A72,72,0,0,0,0,70.47c0,.59,0,1.17.07,1.75,0,.32,0,.63.05.95l.09,2.48H120.94A60.79,60.79,0,0,1,117,93.39a58.59,58.59,0,0,1-7.85,14.17h15.88a73.54,73.54,0,0,0,4.6-9.49,74.72,74.72,0,0,0,5.13-27.78A74,74,0,0,0,129.67,42.59Z'/></svg>"),//icon
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
	//Testing Aajax
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
		add_settings_section( 'jira-setting-section', '','', 'jira_settings_login' );
		add_settings_field( 'setting-form', '',array($this->callback, 'loginForm') , 'jira_settings_login', 'jira-setting-section');
	}
	function FsdpSettingAutoLogin()
	{
		status_header(200);
		$user_id = get_current_user_id();
			if ( (bool) $user_id)
			{
				$havemetauser = get_user_meta($user_id, '_jira_user', true);
				$havemetapass = get_user_meta($user_id, '_jira_password', true);
				if (($havemetauser) && ($havemetapass)) {
					User::loginSession($havemetauser,$havemetapass);
				}
			}
	}

	function FsdpSettingKillSession()
	{
		status_header(200);
		$user_id = get_current_user_id();
			if ( (bool) $user_id)
			{
				$havemetauser = get_user_meta($user_id, '_jira_user', true);
				$havemetapass = get_user_meta($user_id, '_jira_password', true);
				if (($havemetauser) && ($havemetapass)) {
					User::loginSession($havemetauser,$havemetapass);
				}
			}
	}

	function FsdpSettingSignin()
	{
		register_setting('jira_user_signin', 'signin' );
		add_settings_section( 'jira-setting-section', '','' , 'jira_settings_signin' );
		add_settings_field( 'setting-form', '',array($this->callback, 'signinForm') , 'jira_settings_signin', 'jira-setting-section');
	}
	function FsdpSettingCreateIssue()
	{
		register_setting('jira_issue_create', 'createIssue' );
		add_settings_section( 'jira-setting-section', '','' , 'jira_settings_create' );
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
		User:: loginSession($_POST['username'],$_POST['password']);
		//User::login('mohamed','qrt235234@#$%!');

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
		$id = $_POST['id'];
		$role = new Role($id,$_POST['name'],array());
		$role->CreateRole();
		wp_redirect( "admin.php?page=user_role" .'&role='.$id );
	}

	function renameRole()
	{
		status_header(200);
		$role = new Role($_POST['id'],$_POST['name'],array());
		$role->RenameRole();
	}

}