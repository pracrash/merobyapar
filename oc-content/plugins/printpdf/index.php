<?php
/*
Plugin Name: Print PDF
Plugin URI: http://www.osclass.org/
Description: Create a PDF ready to print and share offline
Version: 1.3
Author: OSClass
Author URI: http://www.osclass.org/
Short Name: printpdf
Plugin update URI: printpdf
*/


    function printpdf_install() {
        @mkdir(osc_content_path().'uploads/printpdf/');
        $conn= getConnection();
        osc_set_preference('upload_path', osc_content_path().'uploads/printpdf/', 'printpdf', 'STRING');
        $conn->commit();
    }

    function printpdf_uninstall() {
        $conn= getConnection();
        osc_delete_preference('upload_path', 'printpdf');
        $conn->commit();
        $files = glob(osc_get_preference('upload_path', 'printpdf')."*.pdf");
        foreach($files as $f) {
            @unlink($f);
        }
        @rmdir(osc_get_preference('upload_path', 'printpdf'));
    }
    

    
    function printpdf_admin_menu() {
        echo '<h3><a href="#">Print PDF</a></h3>
        <ul> 
            <li><a href="' . osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'conf.php') . '">&raquo; ' . __('Settings', 'printpdf') . '</a></li>
            <li><a href="' . osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'help.php') . '">&raquo; ' . __('Help', 'printpdf') . '</a></li>
        </ul>';
    }
    
    function printpdf_delete_item($itemId) {
        $files = glob(osc_get_preference('upload_path', 'printpdf').$itemId."_*");
        foreach($files as $f) {
            @unlink($f);
        }
    }
    //added by shakeelstha
	function printpdf_edit_delete_item($item) {
		$files = glob(osc_get_preference('upload_path', 'printpdf').$item['pk_i_id']."_*");
        foreach($files as $f) {
            @unlink($f);
        }
    }
    
    function printpdf_generatePDF($data, $id = '') {
        include "fpdf/pdf_rotation.php";
        if($id!='') {
            $filename = $id."_".md5($data)."_".osc_get_preference("code_size", "printpdf").".png";
        } else {
            $filename = md5($data)."_".osc_get_preference("code_size", "printpdf").".png";
        }
        $filename = osc_get_preference('upload_path', 'printpdf').$filename;
        printpdf::png($data, $filename, 'M', osc_get_preference("code_size", "printpdf"), 2);
    }
    
    
    function show_printpdf() {
        echo '<a href="'.osc_base_url().'oc-content/plugins/'.osc_plugin_folder(__FILE__).'/download.php?item='.osc_item_id().'" class="printpdf_link" >'.__('Download PDF', 'printpdf').'</a>';
    }
    
    
    function printpdf_shorturl($url)  {  
        $ch = curl_init();  
        $timeout = 5;  
        curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
        $data = curl_exec($ch);  
        curl_close($ch);  
        return $data;  
    }    
    
    /**
     * ADD HOOKS
     */
    osc_register_plugin(osc_plugin_path(__FILE__), 'printpdf_install');
    osc_add_hook(osc_plugin_path(__FILE__)."_uninstall", 'printpdf_uninstall');
    
    // DELETE ITEM
    osc_add_hook('delete_item', 'printpdf_delete_item');
    //osc_add_hook('edited_item', 'printpdf_delete_item');
	//added by shakeelstha
	osc_add_hook('edited_item', 'printpdf_edit_delete_item');
    // FANCY MENU

    osc_add_hook('admin_menu', 'printpdf_admin_menu');
    
?>
