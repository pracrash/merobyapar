<?php
/*
Plugin Name: IP Blocker
Plugin URI: http://www.osclass.org
Description: Blocks specified IP addresses from accessing your site
Version: 1.0
Author: Jesse - TurbineJesse@gmail.com
Author URI: http://www.osclass.org/
Short Name: ipblocker
*/



function ip_blocker_install() {
    $conn = getConnection();
    $conn->autocommit(false);
    try {
        $path = osc_plugin_resource('ip_blocker/struct.sql');
        $sql = file_get_contents($path);
        $conn->osc_dbImportSQL($sql);
        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
        echo $e->getMessage();
    }
    $conn->autocommit(true);
}



function ip_blocker_uninstall() {
    $conn = getConnection();
    $conn->autocommit(false);
    try {
	$conn->osc_dbExec('DROP TABLE %st_ip_blocker', DB_TABLE_PREFIX);
	$conn->commit();
	} catch (Exception $e) {
	    $conn->rollback();
	    echo $e->getMessage();
	}
    $conn->autocommit(true);
}


    function ip_blocker_admin_menu() {
        echo '<h3><a href="#">IP Blocker</a></h3>

        <ul>
            <li><a href="' . osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'ip_blocker_config.php') . '">&raquo; ' . __('Configure', 'ipblocker') . '</a><li>
        </ul>';
    }




function block_ip() {

    $conn = getConnection();
    $data=$conn->osc_dbFetchResults("SELECT INET_NTOA(ip) FROM %st_ip_blocker", DB_TABLE_PREFIX);

    if(count($data)>0) {
	foreach($data as $data2) {
	    $blocked[] = $data2['INET_NTOA(ip)']; // populate IP array
	}

	if (in_array($_SERVER['REMOTE_ADDR'],$blocked)) header('Location: '.osc_base_url() . 'oc-content/plugins/ip_blocker/blocked.php');
    }

//$blocked[0]="50.132.75.47"; // IP in the form of "127.0.0.1" or whatever




}


   
    // This is needed in order to be able to activate the plugin
    osc_register_plugin(osc_plugin_path(__FILE__), 'ip_blocker_install') ;

    // This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'ip_blocker_uninstall') ;

    // Add the help to the menu
    osc_add_hook('admin_menu', 'ip_blocker_admin_menu');

    // Run block_ip function before HTML is displayed on page
    osc_add_hook('before_html', 'block_ip');
    
?>