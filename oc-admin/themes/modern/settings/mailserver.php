<?php
    /**
     * OSClass – software for creating and publishing online classified advertising platforms
     *
     * Copyright (C) 2010 OSCLASS
     *
     * This program is free software: you can redistribute it and/or modify it under the terms
     * of the GNU Affero General Public License as published by the Free Software Foundation,
     * either version 3 of the License, or (at your option) any later version.
     *
     * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
     * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
     * See the GNU Affero General Public License for more details.
     *
     * You should have received a copy of the GNU Affero General Public
     * License along with this program. If not, see <http://www.gnu.org/licenses/>.
     */

    //customize Head
    function customHead() { ?>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                $('select[name="mailserver_type"]').bind('change', function(){
                    if( $(this).val() == 'gmail' ) {
                        $('input[name="mailserver_host"]').val('smtp.gmail.com') ;
                        $('input[name="mailserver_host"]').attr('readonly', true) ;
                        $('input[name="mailserver_port"]').val('465') ;
                        $('input[name="mailserver_port"]').attr('readonly', true) ;
                        $('input[name="mailserver_username"]').val('') ;
                        $('input[name="mailserver_password"]').val('') ;
                        $('input[name="mailserver_ssl"]').val('ssl') ;
                        $('input[name="mailserver_auth"]').attr('checked', true) ;
                        $('input[name="mailserver_pop"]').attr('checked', false) ;
                    } else {
                        $('input[name="mailserver_host"]').attr('readonly', false) ;
                        $('input[name="mailserver_port"]').attr('readonly', false) ;
                    }
                }) ;

                $('#testMail').bind('click', function() {
                    $.ajax({
                        "url": "<?php echo osc_admin_base_url(true)?>?page=ajax&action=test_mail",
                        "dataType": 'json',
                        success: function(data) {
                            $('#testMail_message p').html(data.html) ;
                            $('#testMail_message').css('display', 'block') ;
                            if( data.status == 1 ) {
                                $('#testMail_message').addClass('ok');
                            } else {
                                $('#testMail_message').addClass('error');
                            }
                        }
                    }) ;
                }) ;
            }) ;
        </script>
        <?php
    }
    osc_add_hook('admin_header','customHead');

    function render_offset() {
        return 'row-offset';
    }

    function addHelp(){
        echo '<h3>What does a red highlight mean?</h3>';
        echo '<p>This is where I would provide help to the user on how everything in my admin panel works. Formatted HTML works fine in here too.
    Red highlight means that the listing has been marked as spam.</p>';
    }
    osc_add_hook('help_box','addHelp');

    osc_add_hook('admin_page_header','customPageHeader');
    function customPageHeader(){ ?>
        <h1><?php _e('Settings') ; ?>
            <a href="#" class="btn ico ico-32 ico-help float-right"></a>
        </h1>
    <?php
    }

    function customPageTitle($string) {
        return sprintf(__('Mail Settings &raquo; %s'), $string);
    }
    osc_add_filter('admin_title', 'customPageTitle');

    osc_current_admin_theme_path( 'parts/header.php' ) ; ?>
<div id="mail-setting">
    <!-- settings form -->
                    <div id="mail-settings">
                        <h2 class="render-title"><?php _e('Mail Settings') ; ?></h2>
                        <ul id="error_list"></ul>
                        <form name="settings_form" action="<?php echo osc_admin_base_url(true) ; ?>" method="post">
                            <input type="hidden" name="page" value="settings" />
                            <input type="hidden" name="action" value="mailserver_post" />
                            <fieldset>
                            <div class="form-horizontal">
                            <div class="form-row">
                                <div class="form-label"><?php _e('Server type'); ?></div>
                                <div class="form-controls">
                                    <select name="mailserver_type">
                                        <option value="custom" <?php echo (osc_mailserver_type() == 'custom') ? 'selected="true"' : '' ; ?>><?php _e('Custom Server') ; ?></option>
                                        <option value="gmail" <?php echo (osc_mailserver_type() == 'gmail') ? 'selected="true"' : '' ; ?>><?php _e('GMail Server') ; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-label"><?php _e('Hostname') ; ?></div>
                                <div class="form-controls">
                                    <input type="text" class="input-large" name="mailserver_host" value="<?php echo osc_esc_html(osc_mailserver_host()); ?>" />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-label"><?php _e('Server port') ; ?></div>
                                <div class="form-controls">
                                    <input type="text" class="input-large" name="mailserver_port" value="<?php echo osc_esc_html(osc_mailserver_port()); ?>" />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-label"><?php _e('Username') ; ?></div>
                                <div class="form-controls">
                                    <input type="text" class="input-large" name="mailserver_username" value="<?php echo osc_esc_html(osc_mailserver_username()); ?>" />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-label"><?php _e('Password') ; ?></div>
                                <div class="form-controls">
                                    <input type="text" class="input-large" name="mailserver_password" value="<?php echo osc_esc_html(osc_mailserver_password()); ?>" />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-label"><?php _e('Encryption') ; ?></div>
                                <div class="form-controls">
                                    <input type="text" class="input-medium" name="mailserver_ssl" value="<?php echo osc_esc_html(osc_mailserver_ssl()); ?>" />
                                    <?php _e('Options: blank, ssl or tls'); ?>
                                    <?php if( !@apache_mod_loaded('mod_ssl') ) { ?>
                                    <div class="flashmessage flashmessage-inline warning">
                                        <p><?php _e("Apache Module <b>mod_ssl</b> is not loaded") ; ?></p>
                                    </div>
                                    <?php } ?>                                    
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-label"><?php _e('SMTP'); ?></div>
                                <div class="form-controls">
                                    <div class="form-label-checkbox"><input type="checkbox" <?php echo ( osc_mailserver_auth() ? 'checked="checked"' : '' ) ; ?> name="mailserver_auth" value="1" />
                                    <?php _e('SMTP authentication enabled') ; ?></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-label"><?php _e('POP'); ?></div>
                                <div class="form-controls">
                                    <div class="form-label-checkbox"><input type="checkbox" <?php echo ( osc_mailserver_pop() ? 'checked="checked"' : '' ) ; ?> name="mailserver_pop" value="1" />
                                    <?php _e('Use POP before SMTP') ; ?></div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" id="save_changes" value="<?php echo osc_esc_html( __('Save changes') ) ; ?>" class="btn btn-submit" />
                            </div>
                        </div>
                        </fieldset>
                    </form>
                </div>
                <!-- /settings form -->
</div>
<?php osc_current_admin_theme_path( 'parts/footer.php' ) ; ?>                