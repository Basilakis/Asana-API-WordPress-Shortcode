<style type="text/css">
    .form label{width:200px;display: inline-block;}
</style>
<div class="wrap">
    <div id="icon-options-general" class="icon32"><br /></div>
    <h2>Asana settings</h2>

    <form method="post" action="<?php echo get_bloginfo('wpurl') . '/wp-admin/admin.php?page=update-settings'; ?>">
<div class="form">
<table>
    <tr>
        <td><label for="">Asana Access Token</label></td>
        <td><input name="access_token" type="text" id="access_token" style="width:500px;" value="<?php echo $settings['access_token']; ?>" />
        <span style="font-size:11px">
            You can get asana personal acess token from My profile settings, then got to Apps tab, then click on manage apps,
            finally click Create New Personal Access Token 

        </span>
        </td>
    </tr>
        <tr>
        <td></td>
        <td><?php
    submit_button('Save', 'button button-primary button-large', 'submit', false);
?></td>
    </tr>
</table>

</div>
    </form>
