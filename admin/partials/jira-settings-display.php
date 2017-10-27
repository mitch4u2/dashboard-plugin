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

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div id="med">
<h1>LOGIN</h1>
Hello
</div>
<?php settings_errors(); ?>

<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
	<?php settings_fields( 'jira_user_login' ) ?>
	<?php do_settings_sections( 'jira_settings_login' ); ?>
	<?php submit_button( 'Login', $type = 'primary', $name = 'submit', $wrap = true, $other_attributes = null ) ?>

</form>


<h1>SIGNIN</h1>

<?php settings_errors(); ?>

<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
	<?php settings_fields( 'jira_user_signin' ) ?>
	<?php do_settings_sections( 'jira_settings_signin' ); ?>
	<?php submit_button( 'Signin', $type = 'primary', $name = 'submit', $wrap = true, $other_attributes = null ) ?>
</form>