<?php

namespace admin;
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
<h1>USER ROLE EDITOR FOURSITES</h1>

<h2>Add Role</h2>


<select class="role" data-url="<?php echo admin_url( 'admin-ajax.php' ); ?>">
	<?php
	echo wp_dropdown_roles();
	?>
</select>
<div class="desc">

</div>


<table border="1">
<tbody>
<tr>
<td>Capabilities Categories</td>
<td>Capabilities</td>
<td>Actions</td>
</tr>
<tr>
<td rowspan="3">33</td>
<td>


<div class="container">
  <ul class="tags" id="tags">
  </ul>

  <ul class="tags green">
    <li><a href="#">Design <span>23</span></a></li>
    <li><a href="#">Illustration <span>42</span></a></li>
    <li><a href="#">Component <span>108</span></a></li>
    <li><a href="#">Misc <span>12</span></a></li>
  </ul>

  <ul class="tags blue">
    <li><a href="#">Infrastructure <span>31</span></a></li>
    <li><a href="#">Application <span>33</span></a></li>
    <li><a href="#">Mobile <span>65</span></a></li>
    <li><a href="#">Desktop <span>160</span></a></li>
  </ul>
</div>


</td>
<td rowspan="3">
<button type="">Create</button><br>
<button type="">Delete</button><br>
<button type="">Update</button>
</td>
</tr>
<tr>
<td rowspan="2">Ungranted Capabilities</td>
</tr>
</tbody>
</table>



<dl>
	<?php foreach (get_editable_roles() as $role_name => $role_info): ?>
		<dt><?php echo $role_name ?></dt>
		<dd>
			<ul>
				<?php foreach ($role_info['capabilities'] as $capability => $_): ?>
					<li><?php echo $capability ?></li>
				<?php endforeach; ?>
			</ul>
		</dd>
	<?php endforeach; ?>
</dl>


<h1>Create Role</h1>

<?php settings_errors(); ?>

<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
	<?php settings_fields( 'user_role_create' ) ?>
	<?php do_settings_sections( 'user_role_settings_create' ); ?>
	<?php submit_button( 'Add', $type = 'primary', $name = 'submit', $wrap = true, $other_attributes = null ) ?>
</form>

<h1>Delete Role</h1>

<?php settings_errors(); ?>

<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
	<?php settings_fields( 'user_role_delete' ) ?>
	<?php do_settings_sections( 'user_role_settings_delete' ); ?>
	<?php submit_button( 'Delete', $type = 'primary', $name = 'submit', $wrap = true, $other_attributes = null ) ?>
</form>

<h1>Rename Role</h1>

<?php settings_errors(); ?>

<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
	<?php settings_fields( 'user_role_rename' ) ?>
	<?php do_settings_sections( 'user_role_settings_rename' ); ?>
	<?php submit_button( 'Rename', $type = 'primary', $name = 'submit', $wrap = true, $other_attributes = null ) ?>
</form>

<script>
/*	(function( $ ) {
		$( ".role" ).change(function() {
  $(".desc").html($(this).val());
});
	})( jQuery );*/
</script>
