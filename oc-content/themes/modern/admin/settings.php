<?php if( !osc_get_preference('footer_link', 'modern_theme') ) { ?>
<form name="_xclick" action="https://www.paypal.com/in/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_donations">
    <input type="hidden" name="business" value="info@osclass.org">
    <input type="hidden" name="item_name" value="OSClass project">
    <input type="hidden" name="return" value="<?php echo osc_admin_render_theme_url('oc-content/themes/modern/admin/settings.php'); ?>">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="lc" value="US" />
    <!--<div id="flashmessage" class="flashmessage flashmessage-inline flashmessage-warning" style="color: #505050; display: block; ">
        <p><?php _e('I would like to contribute to the development of OSClass with a donation of', 'modern'); ?> <select name="amount" class="input-medium">
            <option value="50">50$</option>
            <option value="25">25$</option>
            <option value="10" selected>10$</option>
            <option value="5">5$</option>
            <option value=""><?php _e('Custom', 'modern'); ?></option>
        </select><input type="submit" class="btn btn-mini" name="submit" value="<?php echo osc_esc_html(__('Donate', 'modern')); ?>"></p>
    </div> -->
</form>
<?php } ?>
<h2 class="render-title <?php echo (osc_get_preference('footer_link', 'modern_theme') ? '' : 'separate-top'); ?>"><?php _e('Search Field Default Tag', 'modern'); ?></h2>
<form action="<?php echo osc_admin_render_theme_url('oc-content/themes/modern/admin/settings.php'); ?>" method="post">
    <input type="hidden" name="action_specific" value="settings" />
    <fieldset>
        <div class="form-horizontal">
            <div class="form-row">
                <div class="form-label"><?php _e('Search placeholder', 'modern'); ?></div>
                <div class="form-controls"><input type="text" class="xlarge" name="keyword_placeholder" value="<?php echo osc_esc_html( osc_get_preference('keyword_placeholder', 'modern_theme') ); ?>"></div>
            </div>
            <!-- <div class="form-row">
                <div class="form-label"><?php _e('Footer link', 'modern'); ?></div>
                <div class="form-controls">
                    <div class="form-label-checkbox"><input type="checkbox" name="footer_link" value="1" <?php echo (osc_get_preference('footer_link', 'modern_theme') ? 'checked' : ''); ?> > <?php _e('I want to help OSClass linking to <a href="http://osclass.org/" target="_blank">osclass.org</a> from my site with the following text:', 'modern'); ?></div>
                    <span class="help-box"><?php _e('This website is proudly using the <a title="OSClass web" href="http://osclass.org/">classifieds scripts</a> software <strong>OSClass</strong>', 'modern'); ?></span>
                </div>
            </div> -->
            <div class="form-actions">
                <input type="submit" value="<?php _e('Save changes', 'modern'); ?>" class="btn btn-submit">
            </div>
        </div>
    </fieldset>
</form>