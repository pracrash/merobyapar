<?php
/*
Plugin Name: OSClass mail
Plugin URI: 
Description: This plugin is for mail all user at once
Version: 1.0
Author: Randy Hough
Author URI:
Short Name: osclassmail
*/

    function osclassmail_admin_menu() {
        echo '<h3><a href="#">OsClass Mail</a></h3>
        <ul> 
            <li><a href="' . osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'osclassmail.php') . '">&raquo; ' . __('Create Mail', 'osclassmail') . '</a><li>
			<li><a href="' . osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'help.php') . '">&raquo; ' . __('Help', 'osclassmail') . '</a></li>
        </ul>';
    }

	// This is needed in order to be able to activate the plugin
    osc_register_plugin(osc_plugin_path(__FILE__), 'osclassmail_install');

    // Add the help to the menu
    osc_add_hook('admin_menu', 'osclassmail_admin_menu');

    // No more hooks were needed
    
?>