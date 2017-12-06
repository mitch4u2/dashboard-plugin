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
<h1 id="apopo">USER ROLE EDITOR FOURSITES</h1>

<h2>Add Role</h2>

<table border="1">
	<tbody>
		<tr>
			<td><select class="role" data-url="<?php echo admin_url( 'admin-ajax.php' ); ?>">
				<?php
				echo wp_dropdown_roles();
				?>
			</select></td>
			<td><div align="center" class="ui-widget">
				<label for="roles">Roles: </label>
				<input id="roles">
			</div></td>
			<td>SOMETHING</td>
		</tr>
		<tr>
			<td>Capabilities Categories</td>
			<td>Capabilities</td>
			<td>Actions</td>
		</tr>
		<tr>
			<td rowspan="3">

				<ul class="homes-list">
					<li data-cat='General' class="single-storey">General <span>12/<b></b> capabilities</span></li>
					<li data-cat='Themes' class="double-storey">Themes <span>6/<b></b> capabilities</span></li>
					<li data-cat='Posts' class="house-and-land">Posts <span>13/<b></b> capabilities</span></li>
					<li data-cat='Pages' class="develop-subdivide">Pages <span>11/<b></b> capabilities</span></li>
					<li data-cat='Plugins' class="land-estate">Plugins <span>5/<b></b> capabilities</span></li>
					<li data-cat='Users' class="apartments">Users <span>6/<b></b> capabilities</span></li>
					<li data-cat='Custom' class="luxury-homes">Custom <span>8/<b></b> capabilities</span></li>
				</ul>

			</td>
			<td class="fbox">


				<div class="container">
					<ul class="tags green drop origin" id="tags">
					</ul>

					<!-- <ul class="tags green">
						<li><a href="#">Design <span>23</span></a></li>
						<li><a href="#">Illustration <span>42</span></a></li>
						<li><a href="#">Component <span>108</span></a></li>
						<li><a href="#">Misc <span>12</span></a></li>
					</ul>
						-->
					<!-- <ul class="tags blue" id="deprecated">
					</ul> -->
				</div>


			</td>
			<td rowspan="3">
				<button class='button button-primary update-caps' data-url="<?php echo admin_url( 'admin-ajax.php' ); ?>" >Update</button><br><br>
				<button class='button button-primary create' >Create</button><br><br>
				<button class='button button-primary delete-role' data-url="<?php echo admin_url( 'admin-ajax.php' ); ?>" >Delete</button><br><br>
				<button class='button button-primary rename-role' data-url="<?php echo admin_url( 'admin-ajax.php' ); ?>" >Rename</button><br><br>
			</td>
		</tr>
		<tr>
			<td rowspan="2" class="fbox">

				<div class="container">
					<ul class="tags drop origin" id="ungrantedtags">
					</ul>

					<!-- <ul class="tags green">
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
					</ul> -->

				</div>
			</td>
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


<div id="myModal" class="modalrename" >
	<!-- Modal content -->
	<div class="modal-content">
		<span class="close3">&times;</span>
		<h1 class='modaltitle'>Rename Role</h1>

		<?php settings_errors(); ?>
		<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
			<?php settings_fields( 'user_role_rename' ) ?>
			<?php do_settings_sections( 'user_role_settings_rename' ); ?>
			<?php submit_button( 'Rename', $type = 'primary', $name = 'submit', $wrap = true, $other_attributes = null ) ?>
		</form>
	</div>
</div>



<div id="myModal" class="modalrole" >
	<!-- Modal content -->
	<div class="modal-content">
		<span class="close3">&times;</span>
		<h1 class='modaltitle'>Create Role</h1>

		<?php settings_errors(); ?>
		<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
			<?php settings_fields( 'user_role_create' ) ?>
			<?php do_settings_sections( 'user_role_settings_create' ); ?>
			<?php submit_button( 'Add', $type = 'primary', $name = 'submit', $wrap = true, $other_attributes = null ) ?>
		</form>
	</div>
</div>






<script>
/*	(function( $ ) {
		$( ".role" ).change(function() {
  $(".desc").html($(this).val());
});
})( jQuery );*/
</script>