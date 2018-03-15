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
<table class="optable">
    <tr class="firstrow">
        <td class="selrole">
            <select class="role input102" data-url="<?php echo admin_url( 'admin-ajax.php' ); ?>">
                <?php
                echo wp_dropdown_roles();
                ?>
            </select>
        </td>
        <td align="center">
            <button class='login102-form-btn update-caps' data-url="<?php echo admin_url( 'admin-ajax.php' ); ?>" >Update</button>
            <button class='login102-form-btn create' >Create</button>
            <button class='login102-form-btn delete-role' data-url="<?php echo admin_url( 'admin-ajax.php' ); ?>" >Delete</button>
            <button class='login102-form-btn rename-role' data-url="<?php echo admin_url( 'admin-ajax.php' ); ?>" >Rename</button>
        </td>

        <td>
            <div style="height:100%;" class="ui-widget">
                <input  style="height:100%;" placeholder="Search Roles" class="input101" id="roles">
            </div>
        </td>

    </tr>


</table>
<table  class="roletable">
    <tr>
        <td class="tablist" rowspan="3">
            <ul class="homes-list">
                <li data-cat='All' class="all active">All <span>68/<b></b> capabilities</span></li>
                <li data-cat='General' class="single-storey">General <span>12/<b></b> capabilities</span></li>
                <li data-cat='Themes' class="double-storey">Themes <span>6/<b></b> capabilities</span></li>
                <li data-cat='Posts' class="house-and-land">Posts <span>13/<b></b> capabilities</span></li>
                <li data-cat='Pages' class="develop-subdivide">Pages <span>11/<b></b> capabilities</span></li>
                <li data-cat='Plugins' class="land-estate">Plugins <span>5/<b></b> capabilities</span></li>
                <li data-cat='Users' class="apartments">Users <span>6/<b></b> capabilities</span></li>
               <!--  <li data-cat='Custom' class="luxury-homes">Custom <span>8/<b></b> capabilities</span></li> -->
            </ul>
        </td>
        <td class="fbox greentab">
            <div class="container">
                <ul class="tags green drop origin" id="tags"></ul>
            </div>
        </td>
    </tr>

    
    <tr class="boxescat">
        <td colspan="2" class="fbox redtab">
            <div class="container">
                <ul class="tags drop origin" id="ungrantedtags">
                </ul>
            </div>
        </td>
    </tr>

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
    <div class="modal-content addrole">
        <span class="close3">&times;</span>
        <h1 class='tt1'>Create Role</h1>
        <hr>
        <?php settings_errors(); ?>
        <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
            <?php settings_fields( 'user_role_create' ) ?>
            <?php do_settings_sections( 'user_role_settings_create' ); ?>
            <hr>
            <button type="submit" name="submit" id="submit" class="login101-form-btn" value="Create">
                   Add Role
                </button>

           <br><br><br>
        </form>
    </div>
</div>
<script>
/*  (function( $ ) {
$( ".role" ).change(function() {
$(".desc").html($(this).val());
});
})( jQuery );*/
</script>