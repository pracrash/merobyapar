<?php
/*
Plugin Name: Advanced Ad Management
Plugin URI: http://forums.osclass.org/development/repost-an-expired-ad/
Description: Ad management options for ad republishing, expiration notices, automatic ad deletion and more!
Version: 1.1
Author: Jesse & JChapman
Author URI: http://www.osclass.org/
Short Name: advanced_ad_management

The plans of the diligent lead to profit as 
surely as haste leads to poverty. Proverbs 21:5
*/



   function advanced_ad_management_install () {
      $conn = getConnection() ;
      $path = osc_plugin_resource('advanced_ad_management/struct.sql') ;
      $sql  = file_get_contents($path) ;
      $conn->osc_dbImportSQL($sql) ;
        
      osc_set_preference('advanced_ad_management_expire', '4', 'plugin-item_advanced_ad_management', 'INTEGER');
      osc_set_preference('advanced_ad_management_payperpost', '1', 'plugin-item_advanced_ad_management', 'INTEGER');
      osc_set_preference('advanced_ad_management_repubTimes', '5', 'plugin-item_advanced_ad_management', 'INTEGER');
      osc_set_preference('advanced_ad_management_installed', '0', 'plugin-item_advanced_ad_management', 'INTEGER');
      osc_set_preference('advanced_ad_management_freeRepubs', '0', 'plugin-item_advanced_ad_management', 'INTEGER');
      osc_set_preference('advanced_ad_management_expireEmail', '1', 'plugin-item_advanced_ad_management', 'INTEGER');
      osc_set_preference('advanced_ad_management_deleteDays', '0', 'plugin-item_advanced_ad_management', 'INTEGER');
      //used for email template
      $conn->osc_dbExec("INSERT IGNORE INTO %st_pages (s_internal_name, b_indelible, dt_pub_date) VALUES ('email_ad_expire', 1, NOW() )", DB_TABLE_PREFIX);
      $conn->osc_dbExec("INSERT IGNORE INTO %st_pages_description (fk_i_pages_id, fk_c_locale_code, s_title, s_text) VALUES (%d, '%s', '{WEB_TITLE} - Your ad {ITEM_TITLE} is about to expire.', '<p>Hi {CONTACT_NAME}!</p>\r\n<p> </p>\r\n<p>Your ad is about to expire, click on the link if you would like to extend your ad {REPUBLISH_URL}</p><p> </p>\r\n<p>This is an automatic email, Please do not respond to this email.</p>\r\n<p> </p>\r\n<p>Thanks</p>\r\n<p>{WEB_TITLE}</p>')", DB_TABLE_PREFIX, $conn->get_last_id(), osc_language());
      $conn->osc_dbExec("INSERT IGNORE INTO %st_pages (s_internal_name, b_indelible, dt_pub_date) VALUES ('email_ad_expired', 1, NOW() )", DB_TABLE_PREFIX);
      $conn->osc_dbExec("INSERT IGNORE INTO %st_pages_description (fk_i_pages_id, fk_c_locale_code, s_title, s_text) VALUES (%d, '%s', '{WEB_TITLE} - Your ad {ITEM_TITLE} has expired.', '<p>Hi {CONTACT_NAME}!</p>\r\n<p> </p>\r\n<p>Your ad has expired. You may renew your ad by clicking on the link {REPUBLISH_URL}. Otherwise your ad will be permanently deleted in {PERM_DELETED} days</p><p> </p>\r\n<p>This is an automatic email, Please do not respond to this email.</p>\r\n<p> </p>\r\n<p>Thanks</p>\r\n<p>{WEB_TITLE}</p>')", DB_TABLE_PREFIX, $conn->get_last_id(), osc_language());       
   }
   
   function advanced_ad_management_uninstall () {
      $conn = getConnection() ;
      // Remove the table we added for our plugin
      $conn->osc_dbExec('DROP TABLE %st_item_adManage_limit', DB_TABLE_PREFIX) ;
      $conn->osc_dbExec('DROP TABLE %st_item_adManage_log', DB_TABLE_PREFIX) ;
      // Delete preference rows we added
      osc_delete_preference('advanced_ad_management_expire', 'plugin-item_advanced_ad_management');
      osc_delete_preference('advanced_ad_management_payperpost', 'plugin-item_advanced_ad_management');
      osc_delete_preference('advanced_ad_management_repubTimes', 'plugin-item_advanced_ad_management');
      osc_delete_preference('advanced_ad_management_istalled', 'plugin-item_advanced_ad_management');
      osc_delete_preference('advanced_ad_management_freeRepubs', 'plugin-item_advanced_ad_management');
      osc_delete_preference('advanced_ad_management_expireEmail', 'plugin-item_advanced_ad_management');
      osc_delete_preference('advanced_ad_management_deleteDays', 'plugin-item_advanced_ad_management');
      //remove email template
      $page_id = $conn->osc_dbFetchResult("SELECT * FROM %st_pages WHERE s_internal_name = 'email_ad_expire'", DB_TABLE_PREFIX);
      $conn->osc_dbExec("DELETE FROM %st_pages_description WHERE fk_i_pages_id = %d", DB_TABLE_PREFIX, $page_id['pk_i_id']);
      $id_page = $conn->osc_dbFetchResult("SELECT * FROM %st_pages WHERE s_internal_name = 'email_ad_expired'", DB_TABLE_PREFIX);
      $conn->osc_dbExec("DELETE FROM %st_pages_description WHERE fk_i_pages_id = %d", DB_TABLE_PREFIX, $id_page['pk_i_id']);
      
      $conn->osc_dbExec("DELETE FROM %st_pages WHERE s_internal_name = 'email_ad_expire'", DB_TABLE_PREFIX);      
      $conn->osc_dbExec("DELETE FROM %st_pages WHERE s_internal_name = 'email_ad_expired'", DB_TABLE_PREFIX);
   }
   
   function item_advanced_ad_management_posted($catId= '', $itemId) {
      $conn = getConnection() ;
      $r_secret = '';
      $r_secret = osc_genRandomPassword();
      $conn->osc_dbExec("REPLACE INTO %st_item_adManage_limit (fk_i_item_id, r_secret, r_times) VALUES (%d, '%s', %d)", DB_TABLE_PREFIX, $itemId, $r_secret, 0 );
   }
   
   
   // HELPER
    function osc_advanced_ad_management_expire() {
        return(osc_get_preference('advanced_ad_management_expire', 'plugin-item_advanced_ad_management')) ;
    }
    function osc_advanced_ad_management_payperpost() {
        return(osc_get_preference('advanced_ad_management_payperpost', 'plugin-item_advanced_ad_management')) ;
    }
    function osc_advanced_ad_management_paypalPaypost() {
        return(osc_get_preference('pay_per_post', 'paypal')) ;
    }
    function osc_advanced_ad_management_repubTimes() {
        return(osc_get_preference('advanced_ad_management_repubTimes', 'plugin-item_advanced_ad_management')) ;
    }
    function osc_item_advanced_ad_management_installed() {
        return(osc_get_preference('advanced_ad_management_installed', 'plugin-item_advanced_ad_management')) ;
    }
    function osc_item_advanced_ad_management_freeRepubs() {
        return(osc_get_preference('advanced_ad_management_freeRepubs', 'plugin-item_advanced_ad_management')) ;
    }
    function osc_item_advanced_ad_management_adEmailEx() {
        return(osc_get_preference('advanced_ad_management_expireEmail', 'plugin-item_advanced_ad_management')) ;
    }
    function osc_item_advanced_ad_management_deleteDays() {
        return(osc_get_preference('advanced_ad_management_deleteDays', 'plugin-item_advanced_ad_management')) ;
    }
    
    //Helper to display either publish [date] or re-publish [date]
    function aam_pub_repub_date() {
       $conn = getConnection() ;
       $rePubTime = $conn->osc_dbFetchResult("SELECT * FROM %st_item_adManage_limit WHERE fk_i_item_id = '%d'", DB_TABLE_PREFIX, osc_item_id());
       if($rePubTime['r_times']>=1) {
            return (string) __('Republished Date: ','advanced_ad_management') . osc_format_date(osc_item_pub_date());
       } else {
            return (string) __('Published Date: ','advanced_ad_management') . osc_format_date(osc_item_pub_date());
       }
    }
    
   // function for displaying the link in the users area 
   function republish_url() {
   
      $conn = getConnection() ;
      $pCats = $conn->osc_dbFetchResult("SELECT * FROM %st_plugin_category WHERE s_plugin_name = '%s' AND fk_i_category_id = '%d'", DB_TABLE_PREFIX, 'advanced_ad_management', osc_item_category_id());
      $pCatCount = count($pCats);

      $advanced_ad_management_url = '';
      $rSecret   = $conn->osc_dbFetchResult("SELECT * FROM %st_item_adManage_limit WHERE fk_i_item_id = '%d'", DB_TABLE_PREFIX, osc_item_id());

      if(($rSecret['r_times'] < osc_advanced_ad_management_repubTimes() || osc_advanced_ad_management_repubTimes() == 0) && $pCatCount != 0 ){
         if(osc_item_is_expired()) {
            $advanced_ad_management_url =  '<span>|</span> <a href="'. osc_base_url() . 'oc-content/plugins/advanced_ad_management/item_republish.php?repub=republish&id=' . osc_item_id() . '&rSecret=' . $rSecret['r_secret'] . '">' . __('Republish Ad','advanced_ad_management') . '</a>';
         }
      }
      return $advanced_ad_management_url;
   }
         
   function item_advanced_ad_management_admin_menu(){
      if( OSCLASS_VERSION < '2.4.0') {
         echo '<h3><a href="#">Advanced Ad Management</a></h3><ul>';
      	    	 	 
           echo '<li class="" ><a href="' . osc_admin_render_plugin_url('advanced_ad_management/admin.php') . '" > &raquo; '. __('Configure', 'advanced_ad_management') . '</a></li>' .
           '<li class="" ><a href="' . osc_admin_render_plugin_url('advanced_ad_management/help.php') . '" >&raquo; ' . __('F.A.Q. / Help', 'advanced_ad_management') . '</a></li>';
           echo '</ul>';
     } else {
        echo '<li id="AAM"><h3><a href="#">Advanced Ad Management</a></h3><ul>';
      	    	 	 
           echo '<li class="" ><a href="' . osc_admin_render_plugin_url('advanced_ad_management/admin.php') . '" > &raquo; '. __('Configure', 'advanced_ad_management') . '</a></li>' .
           '<li class="" ><a href="' . osc_admin_render_plugin_url('advanced_ad_management/help.php') . '" >&raquo; ' . __('F.A.Q. / Help', 'advanced_ad_management') . '</a></li>';
           echo '</ul></li>';
     }
   }
   
   /**
     * Return the date the item expires
     * 
     * @return string  
     */
   function osc_expire_date($itemId) {
            $item = Item::newInstance()->findByPrimaryKey($itemId);
            $category = Category::newInstance()->findByPrimaryKey( $item['fk_i_category_id'] ) ;
            $expiration = $category['i_expiration_days'];
            if($expiration <= 9){ return FALSE; }
            else{
                $expiration = $expiration - osc_advanced_ad_management_expire();
                $date_expiration = strtotime(date("Y-m-d", strtotime( $item['dt_pub_date'] )) . " +$expiration day");
                if($date_expiration == strtotime(date("Y-m-d"))) {
                   return TRUE; //date('Y-m-d', $date_expiration) . ' - ' . date("Y-m-d");
                } else {
                   return FALSE;
                }
                
            }
   }
      
   /** This function is modelled after the one found in hItems.php
     *
     * Return true if item is expired, else return false
     * 
     * @return boolean  
     */
    function item_is_expired($itemId,$delExpire=0) {
        if( $itemId['b_premium'] ) {
            return false;
        } else {
            $category = Category::newInstance()->findByPrimaryKey( $itemId['fk_i_category_id'] ) ;
            $expiration = $category['i_expiration_days'];

            if($expiration == 0){ return false; }
            else{
                $expiration = $expiration + $delExpire;
                $date_expiration = strtotime(date("Y-m-d H:i:s", strtotime( $itemId['dt_pub_date'] )) . " +$expiration day");
                $now             = strtotime(date('Y-m-d H:i:s'));

                if( $date_expiration < $now ) { return true; }
                else { return false; }
            }
        }
    }
   
   function item_advanced_ad_management_cron() {
   	$conn = getConnection() ;
   	$conn->osc_dbExec("INSERT %st_item_adManage_log (fk_i_item_id, log_date, error_action) VALUES ('%d', '%s', '%s')", DB_TABLE_PREFIX, 000, date('Y-m-d H:i:s'), 'Cron job started.');

      $allItems = $conn->osc_dbFetchResults("SELECT * FROM %st_item", DB_TABLE_PREFIX);
      
      foreach($allItems as $itemA) {      	
      	
         $pCats = $conn->osc_dbFetchResult("SELECT * FROM %st_plugin_category WHERE s_plugin_name = '%s' AND fk_i_category_id = '%d'", DB_TABLE_PREFIX, 'advanced_ad_management', $itemA['fk_i_category_id']);
         $pCatCount = count($pCats);
         
         $repub = $conn->osc_dbFetchResult("SELECT * FROM %st_item_adManage_limit WHERE fk_i_item_id = %d", DB_TABLE_PREFIX, $itemA['pk_i_id']);
         
         //send almost expired email
         if(osc_expire_date($itemA['pk_i_id']) == TRUE && $pCatCount != 0 ) {            
            item_expire_email($itemA['pk_i_id'], $repub['r_secret'], osc_advanced_ad_management_expire() );
            $conn->osc_dbExec("INSERT %st_item_adManage_log (fk_i_item_id, log_date, error_action) VALUES ('%d', '%s', '%s')", DB_TABLE_PREFIX, $itemA['pk_i_id'], date('Y-m-d H:i:s'), 'Ad about to expire email sent. Successful' );
         } else{
         	$conn->osc_dbExec("INSERT %st_item_adManage_log (fk_i_item_id, log_date, error_action) VALUES ('%d', '%s', '%s')", DB_TABLE_PREFIX, $itemA['pk_i_id'], date('Y-m-d H:i:s'), 'Ad not expired.');
         }
         
         //send expired email
         if(osc_item_advanced_ad_management_adEmailEx() == 1) {
            if(item_is_expired($itemA)) {
               $exEmailed = $conn->osc_dbFetchResult("SELECT * FROM %st_item_adManage_limit WHERE fk_i_item_id= '%d'", DB_TABLE_PREFIX, $itemA['pk_i_id']);
               if($exEmailed['ex_email'] != 1) {
                  item_expired_email($itemA['pk_i_id'], $repub['r_secret'], osc_item_advanced_ad_management_deleteDays() );
                  $conn->osc_dbExec("UPDATE %st_item_adManage_limit SET ex_email = '%d' WHERE fk_i_item_id = '%d'", DB_TABLE_PREFIX, 1, $itemA['pk_i_id']);
                  $conn->osc_dbExec("INSERT %st_item_adManage_log (fk_i_item_id, log_date, error_action) VALUES ('%d', '%s', '%s')", DB_TABLE_PREFIX, $itemA['pk_i_id'], date('Y-m-d H:i:s'), 'Expired email sent. Successful');
               }// end check of expired email has been sent.
            }// end of is item expired check.
            else {
            	$conn->osc_dbExec("INSERT %st_item_adManage_log (fk_i_item_id, log_date, error_action) VALUES ('%d', '%s', '%s')", DB_TABLE_PREFIX, $itemA['pk_i_id'], date('Y-m-d H:i:s'), 'Ad not expired for expired email.');
            }
         }// end of if expired email enabled
         
         //delete expired ads
         if(osc_item_advanced_ad_management_deleteDays() != 0){
           if($pCatCount != 0){
            if(item_is_expired($itemA, osc_item_advanced_ad_management_deleteDays())){
              
               $item   = Item::newInstance()->listWhere("i.pk_i_id = '%s' AND ((i.s_secret = '%s') OR (i.fk_i_user_id = '%d'))", $itemA['pk_i_id'], $itemA['s_secret'], $itemA['fk_i_user_id']);
               if (count($item) == 1) {
                  $mItems = new ItemActions(false);
                  $success = $mItems->delete($item[0]['s_secret'], $item[0]['pk_i_id']);
                  if($success) {
                     $conn->osc_dbExec("INSERT %st_item_adManage_log (fk_i_item_id, log_date, error_action) VALUES ('%d', '%s', '%s')", DB_TABLE_PREFIX, $itemA['pk_i_id'], date('Y-m-d H:i:s'), 'Cron item deleted. Successful.');
                  } else {
                     $conn->osc_dbExec("INSERT %st_item_adManage_log (fk_i_item_id, log_date, error_action) VALUES ('%d', '%s', '%s')", DB_TABLE_PREFIX, $itemA['pk_i_id'], date('Y-m-d H:i:s'), 'Cron item could not be deleted.');
                     $conn->osc_dbExec("INSERT %st_item_adManage_log (fk_i_item_id, log_date, error_action) VALUES ('%d', '%s', '%s')", DB_TABLE_PREFIX, $itemA['pk_i_id'], date('Y-m-d H:i:s'), 'secret ' . $item[0]['s_secret'] . ' itemId ' . $item[0]['pk_i_id'] );
                  } // end success 
               }// end count of items that need to be deleted.
               $conn->osc_dbExec("INSERT %st_item_adManage_log (fk_i_item_id, log_date, error_action) VALUES ('%d', '%s', '%s')", DB_TABLE_PREFIX, $itemA['pk_i_id'], date('Y-m-d H:i:s'), 'Cron item could not be deleted item not found.'); 
            }// end of if item is expired past set expired date
            else {
            	$conn->osc_dbExec("INSERT %st_item_adManage_log (fk_i_item_id, log_date, error_action) VALUES ('%d', '%s', '%s')", DB_TABLE_PREFIX, $itemA['pk_i_id'], date('Y-m-d H:i:s'), 'Ad not deleted.');
            }
           }// end check if item is in pCatCount
         }// end check if deleteDays is not equal to zero.
         
      }//end of foreach
      $conn->osc_dbExec("INSERT %st_item_adManage_log (fk_i_item_id, log_date, error_action) VALUES ('%d', '%s', '%s')", DB_TABLE_PREFIX, 000, date('Y-m-d H:i:s'), 'Cron complete.');
    }  
   
   
   /**
     * Send email to users when their ad is about to expire
     * 
     * @param array $item
     * @param string $r_secret
     * @param integer $expire_days
     *
     * @dynamic tags
     *
     * '{CONTACT_NAME}', '{ITEM_TITLE}',
     * '{WEB_TITLE}', '{REPUBLISH_URL}', '{EXPIRE_DAYS}'
     */
     
    function item_expire_email($itemId, $r_secret, $expire_days = '') {
        $mPages = new Page() ;
        $aPage = $mPages->findByInternalName('email_ad_expire') ;
        $locale = osc_current_user_locale() ;
        $content = array();
        if(isset($aPage['locale'][$locale]['s_title'])) {
            $content = $aPage['locale'][$locale];
        } else {
            $content = current($aPage['locale']);
        }
        
        $item = Item::newInstance()->findByPrimaryKey($itemId);
        
        $secret = '';
        
        $secret = '&secret=' . $item['s_secret'];
              
    
        $republish_url1    = osc_base_url() . 'oc-content/plugins/advanced_ad_management/item_republish.php?id=' . $item['pk_i_id'] . '&repub=republish&rSecret=' . $r_secret . $secret ;
        $republish_url    = '<a href="' . $republish_url1 . '" >' . $republish_url1 . '</a>';

        $words   = array();
        $words[] = array('{CONTACT_NAME}', '{ITEM_TITLE}', '{WEB_TITLE}', '{REPUBLISH_URL}', '{EXPIRE_DAYS}');
        $words[] = array($item['s_contact_name'], $item['s_title'], osc_page_title(), $republish_url, $expire_days) ;

        $title = osc_mailBeauty($content['s_title'], $words) ;
        $body  = osc_mailBeauty($content['s_text'], $words) ;

        $emailParams =  array('subject'  => $title
                             ,'to'       => $item['s_contact_email']
                             ,'to_name'  => $item['s_contact_name']
                             ,'body'     => $body
                             ,'alt_body' => $body);

        osc_sendMail($emailParams);
    }
    
    /**
     * Send email to users when their ad has expired
     * 
     * @param array $item
     * @param string $r_secret
     * @param integer $permDeleted
     *
     * @dynamic tags
     *
     * '{CONTACT_NAME}', '{ITEM_TITLE}',
     * '{WEB_TITLE}', '{REPUBLISH_URL}', '{PERM_DELETED}'
     */
     
    function item_expired_email($itemId, $r_secret, $permDeleted) {
        $mPages = new Page() ;
        $aPage = $mPages->findByInternalName('email_ad_expired') ;
        $locale = osc_current_user_locale() ;
        $content = array();
        if(isset($aPage['locale'][$locale]['s_title'])) {
            $content = $aPage['locale'][$locale];
        } else {
            $content = current($aPage['locale']);
        }
        
        $item = Item::newInstance()->findByPrimaryKey($itemId);
        
        $secret = '';
        
        $secret = '&secret=' . $item['s_secret'];
              
        
        $republish_url1    = osc_base_url() . 'oc-content/plugins/advanced_ad_management/item_republish.php?id=' . $item['pk_i_id'] . '&repub=republish&rSecret=' . $r_secret . $secret ;
        $republish_url    = '<a href="' . $republish_url1 . '" >' . $republish_url1 . '</a>';

        $words   = array();
        $words[] = array('{CONTACT_NAME}', '{ITEM_TITLE}', '{WEB_TITLE}', '{REPUBLISH_URL}', '{PERM_DELETED}');
        $words[] = array($item['s_contact_name'], $item['s_title'], osc_page_title(), $republish_url, $permDeleted) ;

        $title = osc_mailBeauty($content['s_title'], $words) ;
        $body  = osc_mailBeauty($content['s_text'], $words) ;

        $emailParams =  array('subject'  => $title
                             ,'to'       => $item['s_contact_email']
                             ,'to_name'  => $item['s_contact_name']
                             ,'body'     => $body
                             ,'alt_body' => $body);

        osc_sendMail($emailParams);
    }
    
    function item_advanced_ad_management_delete($itemId){
       $conn = getConnection();
       $conn->osc_dbExec("DELETE FROM %st_item_adManage_limit WHERE fk_i_item_id = '%d' ", DB_TABLE_PREFIX, $itemId);
    }
    
    function advanced_ad_management_config() {
       osc_admin_render_plugin(osc_plugin_path(dirname(__FILE__)) . '/admin.php') ;
    }
    
    function advanced_ad_management_footer() {
       ?>
       <script type="text/javascript">
       $(document).ready(function(){
          
		  var payPost = $("#payPost").val();
		  if(payPost =='1') {
		  	$("#freeTimes").removeAttr('disabled');
		  }else{
		  	$("#freeTimes").attr('disabled','disabled');
		  }
		  
        $("#payPost").change(function(){
            var payPost_id = $(this).val();
            if(payPost_id == '1') {
            	$("#freeTimes").removeAttr('disabled');
            }
            else {
            	$("#freeTimes").attr('disabled','disabled');
            }
        });
        
        $("#deleteDays").change(function(){
           //alert('<?php _e("All ads that have been expired for ' + $(this).val() + ' days will be deleted immediately!","advanced_ad_management");?>');
        });
       });
       </script>
       <?php
    }
    
    // This is needed in order to be able to activate the plugin
    osc_register_plugin(osc_plugin_path(__FILE__), 'advanced_ad_management_install') ;
    osc_add_hook(__FILE__ . "_configure", 'advanced_ad_management_config');
    // This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'advanced_ad_management_uninstall') ;

    // Add the help to the menu
    osc_add_hook('admin_menu', 'item_advanced_ad_management_admin_menu');
    // Add cron
    osc_add_hook('cron_daily', 'item_advanced_ad_management_cron');
    // run after item is posted
    osc_add_hook('item_form_post','item_advanced_ad_management_posted');
    // run hook when item is deleted
    osc_add_hook('delete_item','item_advanced_ad_management_delete');
    // add javascript to the footer
    osc_add_hook('admin_footer','advanced_ad_management_footer');
?>