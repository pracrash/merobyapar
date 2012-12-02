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

    $maintenance = file_exists( osc_base_path() . '.maintenance');

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
    function customPageHeader(){ ?>
        <h1><?php _e('Tools') ; ?>
            <a href="#" class="btn ico ico-32 ico-help float-right"></a>
        </h1>
    <?php
    }

    function customPageTitle($string) {
        return sprintf(__('Maintenance &raquo; %s'), $string);
    }
    osc_add_filter('admin_title', 'customPageTitle');

    osc_current_admin_theme_path( 'parts/header.php' ) ; ?>
<div id="backup-setting">
    <!-- settings form -->
                    <div id="backup-settings">
                        <h2 class="render-title"><?php _e('Maintenance') ; ?></h2>
                        <form>
                            <fieldset>
                            <div class="form-horizontal">
                            <div class="form-row">
                                <?php _e('While in maintenance mode, users can not access your website. Useful if you need to make some changes on your website. Use the following button to toggle ON/OFF maintenance mode.') ; ?>
                                <div class="help-box">
                                    <?php printf( __('Maintenance mode is: <strong>%s</strong>'), ($maintenance ? __('ON') : __('OFF') ) ) ; ?>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="button" value="<?php echo ( $maintenance ? osc_esc_html( __('Disable maintenance mode') ) : osc_esc_html( __('Enable maintenance mode') ) ) ; ?>" onclick="window.location.href='<?php echo osc_admin_base_url(true) ; ?>?page=tools&amp;action=maintenance&amp;mode=<?php echo ( $maintenance ? 'off' : 'on' ) ; ?>';" class="btn btn-submit" />
                            </div>
                        </div>
                        </fieldset>
                    </form>
                </div>
                <!-- /settings form -->
</div>
<?php osc_current_admin_theme_path( 'parts/footer.php' ) ; ?>                