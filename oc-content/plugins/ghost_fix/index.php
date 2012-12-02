<?php
/*
Plugin Name: Ghostbuster
Plugin URI: http://www.osclass.org/
Description: Git rid of the pesky ghost ads.
Version: 1.0
Author: JChapman
Author URI: http://forums.osclass.org/index.php?action=profile;u=1728
Author Email: siouxfallsrummages@gmail.com
Short Name: ghostAds
Plugin update URI: http://www.osclass.org/
*/

require('ModelGhost.php');

function fix_admin_menu () {
   if( OSCLASS_VERSION < '2.4.0') {
   	echo '<h3><a href="#">Ghostbuster</a></h3><ul>';
      	    	 	 
      echo '<li class="" ><a href="' . osc_admin_render_plugin_url('ghost_fix/config.php') . '" > &raquo; '. __('Ghostbuster', 'ghost_fix') . '</a></li>';
      echo '</ul>';
   } else {
      echo '<li id="ghostbuster"><h3><a href="#">Ghostbuster</a></h3><ul>';
      	    	 	 
      echo '<li class="" ><a href="' . osc_admin_render_plugin_url('ghost_fix/config.php') . '" > &raquo; '. __('Ghostbuster', 'ghost_fix') . '</a></li>';
      echo '</ul></li>';
   }
}

    // This is needed in order to be able to activate the plugin
    osc_register_plugin(osc_plugin_path(__FILE__), '') ;

    // This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall','') ;
    
    // Add link in admin menu page
    osc_add_hook('admin_menu', 'fix_admin_menu') ;
?>