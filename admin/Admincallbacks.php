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
		$options = get_option( 'login');
		$checked = (@$options == 1 ? 'checked' : '');
		if (isset($_GET['code']))
		{
			echo "<label><b>Username or password is wrong</b></label><br>";
			echo $_GET['code'];
		}
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

	public function signinForm()
	{
		$options = get_option( 'signin');
		$checked = (@$options == 1 ? 'checked' : '');
		if (isset($_GET['info']))
		{
			echo "<label><b>Username or password is wrong</b></label><br>";
			echo $_GET['info'];
		}
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

	public function updateIssueForm()
	{
		$options = get_option( 'create');
		$checked = (@$options == 1 ? 'checked' : '');
		if (isset($_GET['info']))
		{
			echo "<label><b>Username or password is wrong</b></label><br>";
			echo $_GET['info'];
		}
		$pages = get_pages();
		echo '
		<label>
		<input type="checkbox" id="signin" name="signin" value="" '.$checked.' />
		Activate the custom header
		</label><br>
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
		$checked = (@$options == 1 ? 'checked' : '');
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
		<label>
		<input type="checkbox" id="signin" name="signin" value="" '.$checked.' />
		Activate the custom header
		</label><br>
		<label>
		Summary<br>
		<textarea rows="2" cols="50" id="summary" name="summary" value="" placeholder="summary" required></textarea>
		</label><br>
		<label>
		Description<br>
		<textarea rows="4" cols="50" id="description" name="description" value="" placeholder="description" required></textarea>
		</label><br>
		<label>
		<select name="page">
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
		Page
		</label><br>
		<label>
		<select name="type">
		<option value="Bug">Bug</option>
		<option value="New Feature">New Feature</option>
		</select>
		Issue type
		</label><br>
		<label>
		<select name="priority">
		<option value="Major">Major</option>
		<option value="Blocker">Blocker</option>
		<option value="Critical">Critical</option>
		<option value="Minor">Minor</option>
		<option value="Trivial">Trivial</option>
		</select>
		Priority
		</label><br>
		<label>
		<input type="date" id="date" name="date" value="" placeholder="date" required/>
		Due date
		</label><br>
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