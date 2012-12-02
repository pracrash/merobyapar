<?php
/*
Plugin Name: Template Generator
Plugin URI: http://www.osclass.org
Description: Generates an HTML ad template that can be used elsewhere, like eBay or Craigslist
Version: 1.1
Author: Jesse - TurbineJesse@gmail.com
Author URI: http://www.osclass.org/
Short Name: template_generator
*/


    function template_generator_user_menu() {
  	echo '<li class="template" ><a href="' . osc_render_file_url(osc_plugin_folder(__FILE__) . 'user_template_generator.php') . '" ><i class="icon-user"></i> ' . __('Generate HTML Template', 'template_generator') . '</a></li>';
    }

   
    // This is needed in order to be able to activate the plugin
    osc_register_plugin(osc_plugin_path(__FILE__), '') ;

    // This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', '') ;

    // Add link in user menu page
    osc_add_hook('user_menu', 'template_generator_user_menu') ;
    
?>