<?php // Thanks to _CONEJO and trains58554 for helping with this plugin

    
    if(Params::getParam('plugin_action')=='done') {
        $subject = Params::getParam('subject');
        $messagesend = Params::getParam('message');
        
            $users = User::newInstance()->listAll();
			
      
         $bcc = '';
        foreach($users as $user) {
            $bcc .= $user['s_email'];
            if($user!=end($users)) {
                $bcc .= ",";
            }
        }
		
          $params = array(
            'subject' => $subject
            ,'to' => osc_contact_email()
            ,'to_name' => osc_page_title()
            ,'body' => $messagesend
            ,'alt_body' => strip_tags($messagesend)
            ,'add_bcc' => $bcc
        ) ;

        osc_sendMail($params) ;
        
        // Show a flash message informing our users that the email was sent
        osc_add_flash_ok_message(__('Your email has been sent', 'osclassmail'),'admin');
        
    }

?>
<script type="text/javascript">
tinyMCE.init({
        mode : "textareas",
        theme : "advanced",
        plugins : "emotions,spellchecker,advhr,insertdatetime,preview,fullpage,save,table,template", 
                
        // Theme options - button# indicated the row# only
        theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,|,justifyleft,justifycenter,justifyright,fontselect,fontsizeselect,formatselect",
        theme_advanced_buttons2 : "cut,copy,paste,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,anchor,image,|,code,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "insertdate,inserttime,|,spellchecker,advhr,,removeformat,|,sub,sup,|,charmap,emotions,template,table,save,fullpage",      
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true
});
</script>
<div id="settings_form" style="border: 1px solid #ccc; background: #eee; ">
    <div style="padding: 20px;">
        <div style="float: left; width: 100%;">
            <fieldset>
                <legend><?php _e('OSClass Mail Sender', 'osclassmail'); ?></legend>
                <form name="osclassmail_form" id="moreedit_form" action="<?php echo osc_admin_base_url(true); ?>" method="POST" enctype="multipart/form-data" >
                    <input type="hidden" name="page" value="plugins" />
                    <input type="hidden" name="action" value="renderplugin" />
                    <input type="hidden" name="file" value="<?php echo osc_plugin_folder(__FILE__); ?>osclassmail.php" />
                    <input type="hidden" name="plugin_action" value="done" />
                    <div style="float: left; width: 50%;">
                        <label><?php _e('Subject', 'osclassmail'); ?></label><input type="text" name="subject" id="subject" value="" />
                        <br/>
                        <textarea name="message" id="message" rows="30" cols="" > 
                        </textarea>
                        <br/>
                        <span style="float:right;"><button type="submit" style="float: right;"><?php _e('Send Mail', 'osclassmail');?></button></span>
                        <br/>
                    </div>
                    <div style="float: left; width: 50%;">
                        <label><?php _e('Keep your users informed and up to date with a News letters, Updates, website status, or even a deal of the day, So add your content, click send and enjoy.','osclassmail'); ?>
                        <br/>

                    </div>
                    <br/>
                    <div style="clear:both;"></div>
                </form>
            </fieldset>
        </div>
        <div style="clear: both;"></div>										
    </div>
</div>