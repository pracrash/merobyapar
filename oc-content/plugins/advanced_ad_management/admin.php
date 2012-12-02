<?php 
    $advanced_ad_management_plugin_data = Plugins::getInfo('advanced_ad_management/index.php');
    
    if(Params::getParam('addExistingAds') == 1){
    $conn = getConnection();
    $allItem = $conn->osc_dbFetchResults("SELECT DISTINCT * FROM %st_item_description", DB_TABLE_PREFIX);
    $dao_preference = new Preference(); 
    foreach($allItem as $itemB) {
        $r_secret = '';
        $r_secret = osc_genRandomPassword();
        $conn->osc_dbExec("REPLACE INTO %st_item_adManage_limit (fk_i_item_id, r_secret, r_times) VALUES (%d, '%s', %d)", DB_TABLE_PREFIX, $itemB['fk_i_item_id'], $r_secret, 0 );
    }
    $dao_preference->update(array("s_value" => '1'), array("s_section" => "plugin-item_advanced_ad_management", "s_name" => "advanced_ad_management_installed")) ;
    unset($dao_preference) ;
    echo '<script>location.href="' . osc_admin_base_url(true) . '?page=plugins&action=renderplugin&file=advanced_ad_management/admin.php"</script>';
    }// end of the addExistingAds section
    
    
    //Master setting for expired days.
    //Jesse's Ad Expiration plugin.
     $days = '';
    if(Params::getParam('days') != ''){
	$days = Params::getParam('days');
    }
    else {
    $conn = getConnection();
    $data=$conn->osc_dbFetchResult("SELECT * FROM %st_category", DB_TABLE_PREFIX);
    $days=$data['i_expiration_days'];
    }

    if( Params::getParam('option') == 'update' )
    {
	if($days>999)$days=999; // Set maximum days as per the sql structure of the field: i_expiration_days = int(3)

	$conn = getConnection();
	$conn->osc_dbExec("UPDATE %st_category SET i_expiration_days = '%s'", DB_TABLE_PREFIX, $days);

	osc_add_flash_ok_message(__('Ad expiration successfully set for all categories'),'admin');

	echo '<script>location.href="'.osc_admin_render_plugin_url('advanced_ad_management/admin.php?mUpdated=1').'"</script>';
    }
    //end Ad Expiration section
      
    $expire_days            = '';
    $dao_preference = new Preference();
    if(Params::getParam('expire') != '') {
        $expire_days  = Params::getParam('expire');
    } else {
        $expire_days  = (osc_advanced_ad_management_expire() != '') ? osc_advanced_ad_management_expire() : '' ;
    }
    
    $payPost            = '';
    $dao_preference = new Preference();
    if(Params::getParam('payPost') != '') {
        $payPost  = Params::getParam('payPost');
    } else {
        $payPost  = (osc_advanced_ad_management_payperpost() != '') ? osc_advanced_ad_management_payperpost() : '' ;
    }
    
    $rTimes            = '';
    $dao_preference = new Preference();
    if(Params::getParam('rTimes') != '') {
        $rTimes  = Params::getParam('rTimes');
    } else {
        $rTimes  = (osc_advanced_ad_management_repubTimes() != '') ? osc_advanced_ad_management_repubTimes() : '' ;
    }
    
    $freeTimes            = '';
    $dao_preference = new Preference();
    if(Params::getParam('freeTimes') != '') {
        $freeTimes  = Params::getParam('freeTimes');
    } else {
        $freeTimes  = (osc_item_advanced_ad_management_freeRepubs() != '') ? osc_item_advanced_ad_management_freeRepubs() : '' ;
    }
    
    $adEmailEx            = '';
    $dao_preference = new Preference();
    if(Params::getParam('adEmailEx') != '') {
        $adEmailEx  = Params::getParam('adEmailEx');
    } else {
        $adEmailEx  = (osc_item_advanced_ad_management_adEmailEx() != '') ? osc_item_advanced_ad_management_adEmailEx() : '' ;
    }
    
    $deleteDays            = '';
    $dao_preference = new Preference();
    if(Params::getParam('deleteDays') != '') {
        $deleteDays  = Params::getParam('deleteDays');
    } else {
        $deleteDays  = (osc_item_advanced_ad_management_deleteDays() != '') ? osc_item_advanced_ad_management_deleteDays() : '' ;
    }
    
    if( Params::getParam('option') == 'stepone' ) {
        $dao_preference->update(array("s_value" => $expire_days), array("s_section" => "plugin-item_advanced_ad_management", "s_name" => "advanced_ad_management_expire")) ;
        $dao_preference->update(array("s_value" => $payPost), array("s_section" => "plugin-item_advanced_ad_management", "s_name" => "advanced_ad_management_payperpost")) ;
        $dao_preference->update(array("s_value" => $rTimes), array("s_section" => "plugin-item_advanced_ad_management", "s_name" => "advanced_ad_management_repubTimes")) ;
        $dao_preference->update(array("s_value" => $freeTimes), array("s_section" => "plugin-item_advanced_ad_management", "s_name" => "advanced_ad_management_freeRepubs")) ;
        $dao_preference->update(array("s_value" => $adEmailEx), array("s_section" => "plugin-item_advanced_ad_management", "s_name" => "advanced_ad_management_expireEmail")) ;
        $dao_preference->update(array("s_value" => $deleteDays), array("s_section" => "plugin-item_advanced_ad_management", "s_name" => "advanced_ad_management_deleteDays")) ;
        echo '<div style="text-align:center; font-size:22px; background-color:#00bb00;"><p>' . __('Settings Saved', 'advanced_ad_management') . '.</p></div>';
    }
    unset($dao_preference) ;

?>


    <fieldset style="border: 1px solid #ccc; padding-left:10px; padding-bottom: 10px; background: #eee; -moz-border-radius:20px; -webkit-border-radius:20px; border-radius: 20px;">
    <h2><?php _e('Advanced Ad Management Configuration', 'advanced_ad_management'); ?></h2> 
        <fieldset style="border: 1px solid #ccc; padding:10px; background: #ddd; -moz-border-radius:10px; -webkit-border-radius:10px; border-radius: 10px;">
        <legend><?php _e('Step 1','advanced_ad_management'); ?></legend>
        <?php if (!osc_item_advanced_ad_management_installed() ==1) { 
               echo '<a href="' . osc_admin_base_url(true) . '?page=plugins&action=renderplugin&file=advanced_ad_management/admin.php?addExistingAds=1">' . __('Click here to finish the install','advanced_ad_management') . '</a>';
          } else {_e('Done','advanced_ad_management');} ?>
        </fieldset> 
        
        <fieldset style="border: 1px solid #ccc; padding:10px; background: #ddd; -moz-border-radius:10px; -webkit-border-radius:10px; border-radius: 10px;">
        <legend><?php _e('Step 2','advanced_ad_management'); ?></legend>
        <?php $conn = getConnection();
        $pCats = $conn->osc_dbFetchResults("SELECT * FROM %st_plugin_category WHERE s_plugin_name = '%s'", DB_TABLE_PREFIX, 'advanced_ad_management');
        $catSet = count($pCats);
        if (($catSet < 1) && (osc_item_advanced_ad_management_installed() ==1) ) {?> 
               <a href="<?php echo osc_admin_base_url(true) . '?page=plugins&action=configure&plugin=advanced_ad_management/index.php'; ?>" ><?php _e('Configure which categories you want your users to be able to republish their ads in.','advanced_ad_management'); ?></a>
        <?php } else { ?>
               <a href="<?php echo osc_admin_base_url(true) . '?page=plugins&action=configure&plugin=advanced_ad_management/index.php'; ?>" ><?php _e('Manage which categories you want your users to be able to republish their ads in.','advanced_ad_management'); ?></a> <br />
               <?php echo $catSet . ' ' . __('categoreies allow users to republish ads','advanced_ad_management');?>
              <?php } ?>
        </fieldset>
    <?php $mUpdated = ''; $mUdated = Params::getParam('mUpdated'); ?>
   <form name="adexpiration" action="<?php echo osc_admin_base_url(true); ?>" method="POST" enctype="multipart/form-data" >
	<input type="hidden" name="page" value="plugins" />
	<input type="hidden" name="action" value="renderplugin" />
	<input type="hidden" name="file" value="advanced_ad_management/admin.php" />
	<input type="hidden" name="option" value="update" />
        <fieldset style="border: 1px solid #ccc; padding:10px; background: #ddd; -moz-border-radius:10px; -webkit-border-radius:10px; border-radius: 10px;">
        <legend><?php _e('Master Expire Settings','advanced_ad_management'); ?></legend>
        <?php echo __('This powerful feature will change the ad expiration settings for','advanced_ad_management') . ' <b>' . __('ALL','advanced_ad_management') . '</b> ' . __('categories and subcategories.','advanced_ad_management'); ?> <br /><br />
        <label for="days" style="font-weight: bold;"><?php _e('Enter ad expiration in days (0 = no expiration, max = 999 days)', 'advanced_ad_management'); ?></label>:<br />
        <input type="text" name="days" id="days" value="<?php echo $days; ?>" /><?php echo __('(currently set at ','advanced_ad_management') . $days . __(' days)','advanced_ad_management');?><?php if($mUpdated == 1) {echo ' <b>' . __('Updated', 'advanced_ad_management') . '</b>' ;} ?>
        <br />
        <br />
        <input type="submit" value="<?php _e('Save', 'advanced_ad_management'); ?>" onclick="javascript:return confirm('<?php _e('This action can not be undone. Are you sure you want to continue?', 'advanced_ad_management'); ?>')" /> 
        </fieldset>
    </form>
        
    <form action="<?php osc_admin_base_url(true); ?>" method="post">
    <input type="hidden" name="page" value="plugins" />
    <input type="hidden" name="action" value="renderplugin" />
    <input type="hidden" name="file" value="advanced_ad_management/admin.php" />
    <input type="hidden" name="option" value="stepone" />
        <fieldset style="border: 1px solid #ccc; padding:10px; background: #ddd; -moz-border-radius:10px; -webkit-border-radius:10px; border-radius: 10px;">
        <legend><?php echo _e('Item Republish Settings','advanced_ad_management'); ?></legend>
        <?php if(osc_item_advanced_ad_management_installed() ==1 && $catSet > 1) { ?>
        <label for="expire" style="font-weight: bold;"><?php _e('Number of days before item expires to send email?', 'advanced_ad_management'); ?></label><br />
        <span style="font-size:small;color:gray;"><?php _e('Note: emails will only be sent on categories with <br />expiration days greater then 10', 'advanced_ad_management'); ?>.</span><br />
        <input type="text" name="expire" value="<?php echo $expire_days; ?>" /> <?php _e('(default: 4)','advanced_ad_management'); ?>
        <br />
        <br />
        <label for="rTimes" style="font-weight: bold;"><?php _e('Number of times an ad can be republished? (0 = unlimited)', 'advanced_ad_management'); ?></label><br />
        <input type="text" name="rTimes" id="rTimes" value="<?php echo $rTimes; ?>" /><?php _e('(default: 5)','advanced_ad_management');?>
        <br />
        <br />
        <fieldset style="border: 1px solid #ccc; padding:10px; background: #ddd; -moz-border-radius:10px; -webkit-border-radius:10px; border-radius: 10px;">
        <legend><?php _e('Paypal republish settings','advanced_ad_management'); ?></legend>
        <?php if(osc_advanced_ad_management_paypalPaypost() == 1) { ?>
        <label for="payPost" style="font-weight: bold;"><?php _e('Require users to pay the same fee they paid to publish the ad?', 'advanced_ad_management'); ?></label>:<br />
        <select name="payPost" id="payPost"> 
        	<option <?php if($payPost == 1){echo 'selected="selected"';}?>value='1'>Yes</option>
        	<option <?php if($payPost == 0){echo 'selected="selected"';}?>value='0'>No</option>
        </select>
        <br />
        <br />
        <label for="freeTimes" style="font-weight: bold;"><?php _e('Number of free republishes before requiring fee to be paid?', 'advanced_ad_management'); ?></label>:<br />
        <span style="font-size:small;color:gray;"><?php _e('Note: This number should be smaller then the "Number of times an <br />ad can be republished" unless it is set to zero.', 'advanced_ad_management'); ?>.</span><br />
        <input type="text" name="freeTimes" id="freeTimes" value="<?php echo $freeTimes; ?>" /><?php _e('(0 = no free republishes)','advanced_ad_management');?>
        <?php } else{ _e('Enable Paypal Pay Per Post option to see these settings','advanced_ad_management');} ?>
        </fieldset>
        <?php } ?> 
        </fieldset>
        
        <fieldset style="border: 1px solid #ccc; padding:10px; background: #ddd; -moz-border-radius:10px; -webkit-border-radius:10px; border-radius: 10px;">
        <legend><?php _e('Ad Expiration Settings','advanced_ad_management'); ?></legend>
        <label for="adEmailEx" style="font-weight: bold;"><?php _e('Send an email once the ad has expired?', 'advanced_ad_management'); ?></label>:<br />
        <select name="adEmailEx" id="adEmailEx"> 
        	<option <?php if($adEmailEx == 1){echo 'selected="selected"';}?>value='1'>Yes</option>
        	<option <?php if($adEmailEx == 0){echo 'selected="selected"';}?>value='0'>No</option>
        </select>
        <br />
        <br />
        <label for="deleteDays" style="font-weight: bold;"><?php _e('Number of days until expired ads are deleted permanently?', 'advanced_ad_management'); ?></label>:<br />
        <span style="font-size:small;color:gray;"><?php _e('Note: If you have the number of days set ot zero you should edit the <br />email template "email_ad_expired" accordingly', 'advanced_ad_management'); ?>.</span><br />
        <input type="text" name="deleteDays" id="deleteDays" value="<?php echo $deleteDays; ?>" /><?php _e('(0 = never deleted)','advanced_ad_management');?>
        <br />       
        <br />
        </fieldset>
        <?php if(osc_item_advanced_ad_management_installed() ==1 && $catSet > 1) { ?>
        <input type="submit" value="<?php _e('Save', 'advanced_ad_management'); ?>" /> 
        <?php } ?>    
        <br />
        <?php echo __('Authors','advanced_ad_management') . ' ' . '<!-- <a target="_blank" href="' . $advanced_ad_management_plugin_data['plugin_uri'] . '<!-- "> -->' . $advanced_ad_management_plugin_data['author'] . '<!-- </a> -->'; ?>
    </fieldset> 
</form>

  