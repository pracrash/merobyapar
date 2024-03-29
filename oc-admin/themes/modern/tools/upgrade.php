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

    $perms = osc_save_permissions() ;
    $ok    = osc_change_permissions() ;

    //customize Head
    function customHead(){
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#steps_div").hide() ;
            });
        <?php
        $perms = osc_save_permissions() ;
        $ok    = osc_change_permissions() ;
        foreach($perms as $k => $v) {
            @chmod($k, $v) ;
        }
        if( $ok ) {
        ?>
            $(function() {
                var steps_div = document.getElementById('steps_div') ;
                steps_div.style.display = '';
                var steps = document.getElementById('steps') ;
                var version = <?php echo osc_version() ; ?> ;
                var fileToUnzip = '';
                steps.innerHTML += '<?php echo osc_esc_js( sprintf( __('Checking for updates (Current version %s)'), osc_version() )) ; ?>' ;

                $.getJSON("http://osclass.org/latest_version.php?callback=?", function(data) {
                    if(data.version <= version) {
                        steps.innerHTML += '<?php echo osc_esc_js( __('Congratulations! Your OSClass installation is up to date!')) ; ?>';
                    } else {
                        steps.innerHTML += '<?php echo osc_esc_js( __('New version to update:')) ; ?> ' + data.version + "<br />" ;
                        <?php if(Params::getParam('confirm')=='true') {?>
                            steps.innerHTML += '<img id="loading_image" src="<?php echo osc_current_admin_theme_url('images/loading.gif') ; ?>" /><?php echo osc_esc_js(__('Upgrading your OSClass installation (this could take a while):')); ?>' ;

                            var tempAr = data.url.split('/') ;
                            fileToUnzip = tempAr.pop() ;
                            $.get('<?php echo osc_admin_base_url(true) ; ?>?page=ajax&action=upgrade' , function(data) {
                                var loading_image = document.getElementById('loading_image') ;
                                loading_image.style.display = "none" ;
                                steps.innerHTML += data+"<br />" ;
                            });
                        <?php } else { ?>
                            steps.innerHTML += '<input type="button" value="<?php echo osc_esc_html( __('Upgrade')) ; ?>" onclick="window.location.href=\'<?php echo osc_admin_base_url(true); ?>?page=tools&action=upgrade&confirm=true\';" />' ;
                        <?php } ?>
                    }
                });
            });
        <?php } ?>
        </script>
        <?php
    }
    osc_add_hook('admin_header','customHead');

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
        <h1><?php _e('Tools') ; ?>
            <a href="#" class="btn ico ico-32 ico-help float-right"></a>
        </h1>
    <?php
    }

    function customPageTitle($string) {
        return sprintf(__('Upgrade &raquo; %s'), $string);
    }
    osc_add_filter('admin_title', 'customPageTitle');

    osc_current_admin_theme_path( 'parts/header.php' ) ; ?>
<div id="backup-setting">
    <!-- settings form -->
                    <div id="backup-settings">
                        <h2 class="render-title"><?php _e('Upgrade') ; ?></h2>
                        <form>
                            <fieldset>
                            <div class="form-horizontal">
                            <div class="form-row">
                                <div class="tools upgrade">
                                <?php if( $ok ) { ?>
                                    <p class="text">
                                        <?php printf( __('Your OSClass installation can be auto-upgraded. Please, backup your database and the folder oc-content before attempting to upgrade your OSClass installation. You can also upgrade OSClass manaully, more information in the %s'), '<a href="http://doc.osclass.org/">Wiki</a>') ; ?>
                                    </p>
                                <?php } else { ?>
                                    <p class="text">
                                        <?php _e('Your OSClass installation can not be auto-upgraded. Files and folders need to be writable. You could apply write permissions via SSH with the command "chmod -R a+w *" (without quotes) or via a FTP client, it depends on the program so we can not provide more information. You could also upgrade OSClass downloading the upgrade package, unzip it and replace the files on your server with the ones on the package.') ; ?>
                                    </p>
                                <?php } ?>
                                    <div id="steps_div">
                                        <div id="steps">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <!-- /settings form -->
</div>
<?php osc_current_admin_theme_path( 'parts/footer.php' ) ; ?>                