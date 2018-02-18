	<?php

/**
 * Provide a Settings area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    foursites-dashboard-plugin
 * @subpackage foursites-dashboard-plugin/admin/partials
 */
?>



<ul class="nav nav-tabs">
	<li class="active"><a href="#tab-1">Manage Settings</a></li>
	<li class=""><a href="#tab-2">Updates</a></li>
	<li class=""><a href="#tab-3">About</a></li>
</ul>

<div class="tab-content">
	<div id="tab-1" class="tab-pane active">



		<ul class="nav-form">
		<li class="login">

		<?php settings_errors(); ?>
		<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
			<?php settings_fields( 'jira_user_login' ); ?>
			<?php do_settings_sections( 'jira_settings_login' ); ?><br>
			<?php /*submit_button( 'Login', $type = 'login100-form-btn', $name = 'submit', $wrap = true, $other_attributes = null );*/ ?>
			<div class="container-login100-form-btn">
				<button type="submit" name="submit" id="submit" class="login100-form-btn" value="Login">
					login
				</button>
			</div>
		</form>
		</li>
		<li class="signin" style="display: none">
		<?php settings_errors(); ?>
		<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
			<?php settings_fields( 'jira_user_signin' ); ?>
			<?php do_settings_sections( 'jira_settings_signin' ); ?>
			<div class="container-login100-form-btn">
				<button type="submit" name="submit" id="submit" class="login100-form-btn" value="Signin">
					Signin
				</button>
			</div>
		</form>
		</li>
		</ul>

	</div>

	<div id="tab-2" class="tab-pane"><h3>Updates</h3></div>
	<div id="tab-3" class="tab-pane"><h3>About</h3></div>
</div>








