<?php
/*
Plugin Name: JQuery Social Share
Plugin URI: http://www.osclass.org/
Description: JQuery social share plugin allows you to easily share your add social media share buttons and popular social bookmark buttons to your web site.
Version: 1.0
Author: RajaSekar
Author URI: http://www.osclass.org/
Short Name: JQuery Social Share
Plugin update URI: http://www.osclass.org/files/plugins
*/

function jquery_social_share_menu() {
    echo '<h3><a href="#">JQuery Social Share</a></h3>
    <ul>
        <li><a href="'.osc_admin_render_plugin_url("jquery_social_share/help.php").'?section=types">&raquo; ' . __('F.A.Q. / Help', 'Ad Manager') . '</a></li>
    </ul>';
}

function jquery_social_share_head(){
echo '<script type="text/javascript" src="'.osc_base_url().'oc-content/plugins/jquery_social_share/js/jquery.easing.js"></script>';
echo '<script type="text/javascript" src="'.osc_base_url().'oc-content/plugins/jquery_social_share/js/jquery.social.share.1.1.min.js"></script>';
echo '<link href="'.osc_base_url().'oc-content/plugins/jquery_social_share/css/style.css" rel="stylesheet" type="text/css" />';
echo '<script>
    $(document).ready(function($){
$("#social-share").dcSocialShare();
});
	</script>';
}
 function jquery_social_share_configure() {
        osc_admin_render_plugin(osc_plugin_path(dirname(__FILE__)) . '/help.php') ;
    }

function jquery_social_share(){
  echo '<div id="social-share"></div>';
}

osc_add_hook(osc_plugin_path(__FILE__) . '_configure', 'jquery_social_share_configure');
// Admin menu
osc_add_hook('admin_menu', 'jquery_social_share_menu');
// add javascript
osc_add_hook('header', 'jquery_social_share_head') ;
?>