<?php
namespace admin;
/**
 * Provide a admin area view for the plugin
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



<h1 class="ttl">Create a ticket</h1>
<?php settings_errors(); ?>

<div class="createform">
	<h1 class="tt2">FILL YOUR ISSUE HERE</h1>
<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
	<?php settings_fields( 'jira_issue_create' ); ?>
	<?php do_settings_sections( 'jira_settings_create' ); ?>
	<?php submit_button( 'Create', $type = 'primary', $name = 'submit', $wrap = true, $other_attributes = null ) ?>
</form>
</div>