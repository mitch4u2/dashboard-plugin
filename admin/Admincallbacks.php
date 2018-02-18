<?php


/**
*This class ntain all the callbacks
*/

namespace Admin;

class AdminCallbacks
{
	public function showSettingsPage()
	{
		include plugin_dir_path(__FILE__ ).'partials/jira-settings-display.php';
	}
	public function showPageJira()
	{
		include plugin_dir_path(__FILE__ ).'partials/FSDP-admin-display.php';
	}
	public function showCreatePage()
	{
		include plugin_dir_path(__FILE__ ).'partials/jira-create-display.php';
	}
	public function showPageUserRole()
	{
		include plugin_dir_path(__FILE__ ).'partials/UserRole-display.php';
	}

	public function loginForm()
	{

		settings_errors();
		$options = get_option( 'login');
		if (isset($_GET['code']))
		{
			//echo $_GET['code'];
			echo'
			<div class="notice notice-error is-dismissible">
			<p><strong>Username or password is incorrect</strong></p>
			</div>
			';
		}
		echo '
	

		<div class="limiter">
		<div class="wrap-login100">
				<form class="login100-form validate-form">
					<span class="login100-form-logo">
					</span>
					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" type="text" id="username"  name="username" placeholder="Username" required>
						<span class="focus-input100" data-placeholder="&#xf110;"></span>
						
					</div>


		<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" id="password" name="password" placeholder="Password" required autocomplete="new-password">
						<span class="focus-input100" data-placeholder="&#xf160;"></span>
					</div>
		
		<a class="txt1" href="http://jira.foursites.nl/secure/ForgotLoginDetails.jspa">
							Forgot Password?
						</a>&nbsp;
						<a class="txt1 signinform">
							signin >
						</a>
						</form></div></div>
		
		<input type="hidden" name="action" value="login_form">
		';
	}

	public function signinForm()
	{
		//$options = get_option( 'signin');
		$info = $_GET['info'];
		if (isset($info))
		{
			if ($info === '201')
			{
				echo'
				<div class="notice notice-success is-dismissible">
				<p><strong>Profile created Succesfully</strong></p>
				</div>
				';
			}
			else
			{
				echo'
				<div class="notice notice-error is-dismissible">
				<p><strong>your Request is Invalid</strong></p>
				</div>
				';
			}
		}
		echo '

		<div class="limiter">
		<div class="wrap-login100">
				<form class="login100-form validate-form">

				<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" type="text" id="username"  name="username" placeholder="Username" required>
						<span class="focus-input100" data-placeholder="&#xf110;"></span>
						
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Enter name">
						<input class="input100" type="text" id="name"  name="name" placeholder="Name" required>
						<span class="focus-input100" data-placeholder="&#xf484;"></span>
						
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Enter email">
						<input class="input100" type="email" id="email"  name="email" placeholder="Email" required>
						<span class="focus-input100" data-placeholder="&#xf466;"></span>
						
					</div>

		<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" id="password" name="password" placeholder="Password" pattern="(?=^.{8,}$)((?=.*\d)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required autocomplete="new-password">
						<span class="focus-input100" data-placeholder="&#xf160;"></span>
					</div>
					<a class="txt1 signinform">
							< login
						</a>
		<input type="hidden" name="action" value="signin_form">
		';
	}

	public function updateIssueForm()
	{
		$options = get_option( 'create');
		if (isset($_GET['info']))
		{
			echo "<label><b>Username or password is wrong</b></label><br>";
			echo $_GET['info'];
		}
		$pages = get_pages();
		echo '
		<label>
		Summary<br>
		<textarea rows="2" cols="50" class="sum" name="summary" value="" required></textarea>
		</label><br>
		<label>
		Description<br>
		<textarea rows="4" cols="50" class="description name="description" value="" placeholder="description" required></textarea>
		</label><br>

		<label>
		<select id="type" name="type">
		<option value="Bug">Bug</option>
		<option value="New Feature">New Feature</option>
		</select>
		Issue type
		</label><br>
		<label>
		<select id="priority" name="priority">
		<option value="Major">Major</option>
		<option value="Blocker">Blocker</option>
		<option value="Critical">Critical</option>
		<option value="Minor">Minor</option>
		<option value="Trivial">Trivial</option>
		</select>
		Priority
		</label><br>
		<input type="hidden" id="issue" class="issue" name="issue" value="">
		<input type="hidden" name="action" value="update_issue_form">
		';
	}

	public function createIssueForm()
	{
		$options = get_option( 'create');
		$slug='';
		if (isset($_GET['slug']))
		{
			$slug = $_GET['slug'];
		}
		if (isset($_GET['info']))
		{
			echo "<label><b>Username or password is wrong</b></label><br>";
			echo $_GET['info'];
		}
		$pages = get_pages();
		echo '
		<label class="tt3">
		Summary<br>
		
			<textarea class="input101" rows="3" cols="50" id="summary" name="summary" value="" placeholder="summary" required></textarea>
					
		</label><br>
		<label class="tt3">
		Description<br>
		
						<textarea class="input101" rows="4" cols="50" id="description" name="description" value="" placeholder="description" required></textarea>
				
		</label><br>
		<div class="row">
		<label class="tt3">Page<br>
		<select class="input101" name="page">
		';
		foreach ($pages as $page)
		{
			if ( $page->post_name === $slug )
			{
				$selected = 'selected="selected"';
			}
			else
			{
				$selected='';
			}
			echo "<option value=". $page->ID ." " .$selected. ">$page->post_name</option>";
		}
		echo '
		"<option value="other">Other</option>"
		</select>
		</label><br>
		<label class="tt3">Issue Type <br>
		<select class="input101" name="type">
		<option value="Bug">Bug</option>
		<option value="New Feature">New Feature</option>
		</select>
		</label><br>
		</div>
		<div class="row">
		<label class="tt3">Priority
		<select class="input101" name="priority">
		<option value="Major">Major</option>
		<option value="Blocker">Blocker</option>
		<option value="Critical">Critical</option>
		<option value="Minor">Minor</option>
		<option value="Trivial">Trivial</option>
		</select>
		</label><br>
		<label>
		<input type="date" id="date" name="date" value="" placeholder="date" required/>
		Due date
		</label><br>
		</div>
		<input type="hidden" name="action" value="create_issue_form">
		';
	}

	public function commentIssueForm()
	{
		echo
		'
		<textarea name="comment" id="comment" cols="30" rows="3" placeholder="Add comment..." required></textarea>
		<input type="hidden" id="issuekeycomment" name="issuekeycomment" value=" ">
		<input type="hidden" name="action" value="comment_issue_form">';
	}

	public function createRoleForm()
	{
		echo
		'
		<label>
		<input type="text" name="id" id="id" placeholder="Role Name" reauired>
		Role Name:
		</label><br>
		<input type="text" name="name" id="name" placeholder="Role Display Name" required>
		Role Display Name:
		</label><br>
		<input type="hidden" name="action" value="create_role_form">';
	}

	public function renameRoleForm()
	{
		echo '<label>
		<select name="id">';
		foreach (get_editable_roles() as $role_name => $role_info)
		{
			if (($role_name != 'administrator') && ($role_name != 'author') && ($role_name != 'contributor') && ($role_name != 'editor') && ($role_name != 'subscriber'))
			{
				echo "<option value=". $role_name ." >$role_name</option>";
			}
		}
		echo '</select> Choose a Role to Delete</label>
		<label>
		<input type="text" id="name" name="name" reauired>
		New Display Name
		</label>
		<input type="hidden" name="action" value="rename_role_form">';
	}


}