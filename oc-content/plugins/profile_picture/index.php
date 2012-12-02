<?php
/*
Plugin Name: Profile Picture
Plugin URI: http://www.osclass.org
Description: Allows users to upload profile pictures
Version: 1.1
Author: Jesse - turbinejesse@gmail.com
Author URI: http://www.osclass.org/
Short Name: Profile_Picture
*/

function profile_picture_install() {
    $conn = getConnection();
    $conn->autocommit(false);
    try {
        $path = osc_plugin_resource('profile_picture/struct.sql');
        $sql = file_get_contents($path);
        $conn->osc_dbImportSQL($sql);
        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
        echo $e->getMessage();
    }
    $conn->autocommit(true);
}



function profile_picture_uninstall() {
    $conn = getConnection();
    $conn->autocommit(false);
    try {
	$conn->osc_dbExec('DROP TABLE %st_profile_picture', DB_TABLE_PREFIX);
	$conn->commit();
	} catch (Exception $e) {
	    $conn->rollback();
	    echo $e->getMessage();
	}
    $conn->autocommit(true);
}



function profile_picture_upload() {


// Configuration - Your Options ///////////////////////////////////////////////////////

    $width = '120';
    $height = ''; // height is optional. If you use a height, *MAKE SURE* it's proportional to the WIDTH

    $allowed_filetypes = array('.jpg','.gif','.bmp','.png'); // These will be the types of file that will pass the validation.
    $max_filesize = 524288; // Maximum filesize in BYTES (currently 0.5MB).
    $upload_path = osc_plugins_path().'profile_picture/images/';

    $button_text = 'Upload';

    ////// ***** No modifications below here should be needed ***** /////////////////////

    // First, check to see if user has existing profile picture...
    $user_id = osc_logged_user_id();//osc_item_user_id(); // the user id of the user profile we're at
    $conn = getConnection();
    $result=$conn->osc_dbFetchResult("SELECT user_id, pic_ext FROM %st_profile_picture WHERE user_id = '%d' ", DB_TABLE_PREFIX, $user_id);

    if($result>0) //if picture exists
    {
        echo '<script language="javascript">function ShowDiv(){document.getElementById("HiddenDiv").style.display = \'\';}</script>';

        $modtime = filemtime($upload_path.'profile'.$user_id.$result['pic_ext']); //ensures browser cache is refreshed if newer version of picture exists
        echo '<img src="'.osc_base_url() . 'oc-content/plugins/profile_picture/images/profile'.$user_id.$result['pic_ext'].'?'.$modtime.'" width="'.$width.'" height="'.$height.'">'; // display picture
    }

    if( osc_is_web_user_logged_in() ) {
    //if(osc_item_user_id() == osc_logged_user_id()) {

        if($result>0) {
            echo '<br><a href="javascript:ShowDiv()">Upload New Picture</a>';
            echo '<div id="HiddenDiv" style="display:none;">'; // hides form if user already has a profile picture and displays a link to form instead
        }
        $url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        echo '
		<form name="newad" method="post" enctype="multipart/form-data"  action="'.$url.'" style="width:245px !important;">
		    <input type="file" name="userfile" id="file"><br>
		    <input name="Submit" type="submit" value="'.$button_text.'">
		</form>
	    '; //echo
        if($result>0) echo '</div>';
    //} //if id's match
    } //if logged-in


    if(isset($_POST['Submit'])) // ignore this, since if we are here, the form was obviously submitted already
    {
        $filename = $_FILES['userfile']['name']; // Get the name of the file (including file extension).
        $ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); // Get the extension from the filename.

        // Check if the filetype is allowed, if not DIE and inform the user.
        if(!in_array($ext,$allowed_filetypes))
            die('The file you attempted to upload is not allowed.');

        // Now check the filesize, if it is too large then DIE and inform the user.
        if(filesize($_FILES['userfile']['tmp_name']) > $max_filesize)
            die('The file you attempted to upload is too large.');

        // Check if we can upload to the specified path, if not DIE and inform the user.
        if(!is_writable($upload_path)) {
            die('You cannot upload to the specified directory, please CHMOD it to 777.');
        }
        // Upload the file to your specified path.
        if(move_uploaded_file($_FILES['userfile']['tmp_name'],$upload_path . 'profile'.$user_id.$ext)) {
            //create thumbnail
                $normal_path = $path = osc_plugins_path().'profile_picture/images/thumbnail' . $user_id .$ext;

                //$size = explode('x', osc_thumbnail_dimensions()) ;
                $sourceimage = osc_plugins_path().'profile_picture/images/profile' . $user_id .$ext;
                ImageResizer::fromFile($sourceimage)->resizeTo(35, 35)->saveToFile($path) ;
            if($result==0) {
                $conn->osc_dbExec("INSERT INTO %st_profile_picture (user_id, pic_ext) VALUES ('%d', '%s')", DB_TABLE_PREFIX, $user_id, $ext);
            }
            else {
                $conn->osc_dbExec("UPDATE %st_profile_picture SET pic_ext = '%s' WHERE user_id = '%d' ", DB_TABLE_PREFIX, $ext, $user_id);
            }
            //echo '<meta http-equiv="refresh" content="0; ,URL='.$url.'">';
            //header("Location: ".$url);
            echo "<script>document.location.href='".$url."'</script>";
        }

        else {
            echo 'There was an error during the file upload.  Please try again.'; // It failed :(.
        }
    }


} // end profile_picture_upload()





function profile_picture_show($user_id = 0, $width = 0, $height = 0){

   // Configuration - Your Options ///////////////////////////////////////////////////////

    if($width == 0) {
        $width = '120';
        $height = ''; // height is optional. If you use a height, *MAKE SURE* it's proportional to the WIDTH
    } else {
        $width = '100';
        $height = '100'; // height is optional. If you use a height, *MAKE SURE* it's proportional to the WIDTH
    }


    ////// ***** No modifications below here should be needed ***** /////////////////////

    // First, check to see if user has existing profile picture...
        if($user_id == 0)
            $user_id = osc_logged_user_id(); // the user id of the user profile we're at
	$conn = getConnection();
	
	
	$result=$conn->osc_dbFetchResult("SELECT user_id, pic_ext FROM %st_profile_picture WHERE user_id = '%d' ", DB_TABLE_PREFIX, $user_id);

	if($result>0) //if picture exists
	{
	    $upload_path = osc_plugins_path().'profile_picture/images/';
	    $modtime = filemtime($upload_path.'profile'.$user_id.$result['pic_ext']); //ensures browser cache is refreshed if newer version of picture exists
	    // This is the picture HTML code displayed on page
	    echo '<img src="'.osc_base_url() . 'oc-content/plugins/profile_picture/images/profile'.$user_id.$result['pic_ext'].'?'.$modtime.'" width="'.$width.'" height="'.$height.'" class="imgBrd">'; // display picture
	}
	else{
	    echo '<img src="'.osc_base_url() . 'oc-content/plugins/profile_picture/no_picture.jpg" width="'.$width.'" height="'.$height.'" class="imgBrd">';
	}
} //end profile_picture_show()


function profile_picture_show_on_header(){

   // Configuration - Your Options ///////////////////////////////////////////////////////

    $width = '35';
    $height = ''; // height is optional. If you use a height, *MAKE SURE* it's proportional to the WIDTH

    ////// ***** No modifications below here should be needed ***** /////////////////////

    // First, check to see if user has existing profile picture...
	$user_id = osc_logged_user_id(); // the user id of the user profile we're at
	$conn = getConnection();
	
	
	$result=$conn->osc_dbFetchResult("SELECT user_id, pic_ext FROM %st_profile_picture WHERE user_id = '%d' ", DB_TABLE_PREFIX, $user_id);

	if($result>0) //if picture exists
	{
	    $upload_path = osc_plugins_path().'profile_picture/images/';
	    $modtime = filemtime($upload_path.'profile'.$user_id.$result['pic_ext']); //ensures browser cache is refreshed if newer version of picture exists
	    // This is the picture HTML code displayed on page
	    echo '<img src="'.osc_base_url() . 'oc-content/plugins/profile_picture/images/thumbnail'.$user_id.$result['pic_ext'].'?'.$modtime.'" width="'.$width.'" height="'.$height.'">'; // display picture
	}
	else{
	    echo '<img src="'.osc_base_url() . 'oc-content/plugins/profile_picture/no_picture.jpg" width="'.$width.'" height="'.$height.'">';
	}
} //end profile_picture_show_on_header()



    // This is needed in order to be able to activate the plugin
    osc_register_plugin(osc_plugin_path(__FILE__), 'profile_picture_install') ;
    // This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'profile_picture_uninstall') ;


?>