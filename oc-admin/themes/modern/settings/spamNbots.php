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

    function render_offset(){
        return 'row-offset';
    }

    function addHelp(){
        echo '<h3>What does a red highlight mean?</h3>';
        echo '<p>This is where I would provide help to the user on how everything in my admin panel works. Formatted HTML works fine in here too.
    Red highlight means that the listing has been marked as spam.</p>';
    }
    osc_add_hook('help_box','addHelp');

    osc_add_hook('admin_page_header','customPageHeader');
    function customPageHeader() { ?>
        <h1><?php _e('Settings'); ?>
            <a href="#" class="btn ico ico-32 ico-help float-right"></a>
        </h1>
    <?php
    }

    function customPageTitle($string) {
        return sprintf(__('Spam and bots &raquo; %s'), $string);
    }
    osc_add_filter('admin_title', 'customPageTitle');

    osc_current_admin_theme_path( 'parts/header.php' ) ; ?>
<div id="spam-setting">
    <h2 class="render-title"><?php _e('Spam and bots'); ?></h2>
    <div id="akismet-settings">
        <h2 class="render-title"><?php _e('Akismet') ; ?></h2>
        <p><?php _e("Akismet is a hosted web service that saves you time by automatically detecting comment and trackback spam. It's hosted on our servers, but we give you access to it through plugins and our API."); ?></p>
        <form name="settings_form" action="<?php echo osc_admin_base_url(true) ; ?>" method="post">
            <input type="hidden" name="page" value="settings" />
            <input type="hidden" name="action" value="akismet_post" />
            <fieldset>
            <div class="form-horizontal">
                <div class="form-row">
                    <div class="form-label"><?php _e('Akismet API Key'); ?></div>
                    <div class="form-controls">
                        <input type="text" class="input-large" name="akismetKey" value="<?php echo ( osc_akismet_key() ? osc_esc_html( osc_akismet_key() ) : '' ) ; ?>" />
                        <?php
                            $akismet_status = View::newInstance()->_get('akismet_status') ;
                            $alert_msg      = '' ;
                            $alert_type     = 'error' ;
                            switch($akismet_status) {
                                case 1:
                                    $alert_type = 'ok' ;
                                    $alert_msg  = __('This key is valid') ;
                                break;
                                case 2:
                                    $alert_type = 'error' ;
                                    $alert_msg  = __('The key you entered is invalid. Please double-check it') ;
                                break;
                                case 3:
                                    $alert_type = 'warning' ;
                                    $alert_msg  = sprintf(__('Akismet is disabled, please enter an API key. <a href="%s" target="_blank">(Get your key)</a>'), 'http://akismet.com/get/') ; ;
                                break;
                            }
                        ?>
                        <div class="flashmessage flashmessage-inline flashmessage-<?php echo $alert_type ; ?> separate-top-medium">
                            <p><?php echo $alert_msg ; ?></p>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <input type="submit" id="submit_akismet" value="<?php echo osc_esc_html( __('Save changes') ) ; ?>" class="btn btn-submit" />
                </div>
            </div>
            </fieldset>
        </form>
    </div>
    <div id="recaptcha-settings" class="separate-top">
        <h2 class="render-title"><?php _e('reCAPTCHA') ; ?></h2>
        <p><?php printf(__('reCAPTCHA helps prevent automated abuse of your site by using a CAPTCHA to ensure that only humans perform certain actions. <a href="%s" target="_blank">Get your key</a>'), 'http://www.google.com/recaptcha/whyrecaptcha') ; ?></p>
        <form name="settings_form" action="<?php echo osc_admin_base_url(true) ; ?>" method="post">
            <input type="hidden" name="page" value="settings" />
            <input type="hidden" name="action" value="recaptcha_post" />
            <fieldset>
                <div class="form-horizontal">
                <div class="form-row">
                    <div class="form-label"><?php _e('reCAPTCHA Public key'); ?></div>
                    <div class="form-controls">
                        <input type="text" class="input-large" name="recaptchaPubKey" value="<?php echo (osc_recaptcha_public_key() ? osc_esc_html( osc_recaptcha_public_key() ) : ''); ?>" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label"><?php _e('reCAPTCHA Private key'); ?></div>
                    <div class="form-controls">
                        <input type="text" class="input-large" name="recaptchaPrivKey" value="<?php echo (osc_recaptcha_private_key() ? osc_esc_html( osc_recaptcha_private_key() ) : ''); ?>" />
                    </div>
                </div>
                <?php if( osc_recaptcha_public_key() != '' ) { ?>
                <div class="form-row">
                    <div class="form-label"><?php _e('If you see the reCAPTCHA form it means that you have correctly entered the public key') ; ?></div>
                    <div class="form-controls">
                        <?php
                        require_once( osc_lib_path() . 'recaptchalib.php' ) ;
                        $publickey = osc_recaptcha_public_key() ;
                        echo recaptcha_get_html($publickey, false) ;
                        ?>
                    </div>
                </div>
                <?php }; ?>
                <div class="form-actions">
                    <input type="submit" id="submit_recaptcha" value="<?php echo osc_esc_html( __('Save changes') ) ; ?>" class="btn btn-submit" />
                </div>
            </div>
            </fieldset>
        </form>
    </div>
</div>
<?php osc_current_admin_theme_path( 'parts/footer.php' ) ; ?>                