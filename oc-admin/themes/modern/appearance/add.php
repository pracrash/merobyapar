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

    function addHelp(){
        echo '<h3>What does a red highlight mean?</h3>';
        echo '<p>This is where I would provide help to the user on how everything in my admin panel works. Formatted HTML works fine in here too.
    Red highlight means that the listing has been marked as spam.</p>';
    }
    osc_add_hook('help_box','addHelp');

    osc_add_hook('admin_page_header','customPageHeader');
    function customPageHeader(){ ?>
        <h1><?php _e('Appearance') ; ?>
            <a href="#" class="btn ico ico-32 ico-help float-right"></a>
        </h1>
<?php
    }

    function customPageTitle($string) {
        return sprintf(__('Add theme &raquo; %s'), $string);
    }
    osc_add_filter('admin_title', 'customPageTitle');

    osc_current_admin_theme_path('parts/header.php') ; ?>
    <!-- themes list -->
    <div class="appearance">
        <h2 class="render-title"><?php _e('Add new theme') ; ?></h2>
            <div id="upload-themes" class="ui-osc-tabs-panel">
                <div class="form-horizontal">
                <?php if( is_writable( osc_themes_path() ) ) { ?>
                    <div class="flashmessage flashmessage-info flashmessage-inline" style="display: block;">
                        <p class="info"><?php printf( __('Download more themes at %s'), '<a href="https://sourceforge.net/projects/osclass/files/Themes/" target="_blank">Sourceforge</a>') ; ?></p>
                    </div>
                    <form class="separate-top" action="<?php echo osc_admin_base_url(true) ; ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="add_post" />
                        <input type="hidden" name="page" value="appearance" />
                        <div class="form-row">
                            <div class="form-label"><?php _e('Theme package (.zip)') ; ?></div>
                            <div class="form-controls">
                                <div class="form-label-checkbox"><input type="file" name="package" id="package" /></div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <input type="submit" value="<?php echo osc_esc_html( __('Upload') ) ; ?>" class="btn btn-submit" />
                        </div>
                    </form>
                <?php } else { ?>
                    <div class="flashmessage flashmessage-error">
                        <a class="btn ico btn-mini ico-close" href="#">×</a>
                        <p><?php _e('Cannot install a new theme') ; ?></p>
                    </div>
                    <p class="text">
                        <?php _e('The theme folder is not writable on your server and you cannot upload themes from the administration panel. Please make the theme folder writable') ; ?>
                    </p>
                    <p class="text">
                        <?php _e('To make the directory writable under UNIX execute this command from the shell:') ; ?>
                    </p>
                    <pre>chmod a+w <?php echo osc_themes_path() ; ?></pre>
                <?php } ?>
                </div>
            </div>
            <div id="market_installer" class="has-form-actions hide">
                <form action="" method="post">
                    <input type="hidden" name="market_code" id="market_code" value="" />
                    <div class="osc-modal-content-market">
                        <img src="" id="market_thumb" class="float-left"/>
                        <table class="table" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr class="table-first-row">
                                    <td><?php _e('Name') ; ?></td>
                                    <td><span id="market_name"><?php _e("Loading data"); ?></span></td>
                                </tr>
                                <tr class="even">
                                    <td><?php _e('Version') ; ?></td>
                                    <td><span id="market_version"><?php _e("Loading data"); ?></span></td>
                                </tr>
                                <tr>
                                    <td><?php _e('Author') ; ?></td>
                                    <td><span id="market_author"><?php _e("Loading data"); ?></span></td>
                                </tr>
                                <tr class="even">
                                    <td><?php _e('URL') ; ?></td>
                                    <td><a id="market_url" href="#"><?php _e("Download manually"); ?></span></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="clear"></div>
                    </div>
                    <div class="form-actions">
                        <div class="wrapper">
                            <button id="market_cancel" class="btn btn-red" ><?php echo osc_esc_html( __('Cancel') ) ; ?></button>
                            <button id="market_install" class="btn btn-submit" ><?php echo osc_esc_html( __('Continue install') ) ; ?></button>
                        </div>
                    </div>
                </form>
            </div>
        <script>
        $(function() {
            $("#market_cancel").on("click", function(){
                $(".ui-dialog-content").dialog("close");
                return false;
            });

            $("#market_install").on("click", function(){
                $(".ui-dialog-content").dialog("close");
                //$(".ui-dialog-content").dialog({title:'Downloading...'}).html('Please wait until the download is completed');
                $('<div id="downloading"><div class="osc-modal-content">Please wait until the download is completed</div></div>').dialog({title:'Installing...',modal:true});
                $.getJSON(
                "<?php echo osc_admin_base_url(true); ?>?page=ajax&action=market",
                {"code" : $("#market_code").attr("value")},
                function(data){
                    $("#downloading .osc-modal-content").html(data.message);
                    setTimeout(function(){
                      $(".ui-dialog-content").dialog("close");  
                  },1000);
                });
                return false;
            });

            $.getJSON(
                "<?php echo osc_admin_base_url(true); ?>?page=ajax&action=local_market",
                {"section" : "themes"},
                function(data){
                    $("#market_themes").html(" ");
                    if(data!=null && data.themes!=null) {
                        for(var i=0;i<data.themes.length;i++) {
                            var description = $(data.themes[i].s_description).text();
                            dots = '';
                            if(description.length > 80){
                                dots = '...';
                            }
                            var imgsrc = '<?php echo osc_current_admin_theme("img/marketblank.jpg"); ?>';
                            if(data.themes[i].s_image!=null) {
                                imgsrc = data.themes[i].s_image;
                            }
                            $("#market_themes").append('<div class="theme">'
                                +'<div class="theme-stage">'
                                    +'<img src="'+imgsrc+'" title="'+data.themes[i].s_title+'" alt="'+data.themes[i].s_title+'" />'
                                    +'<div class="theme-actions">'
                                        +'<a href="#'+data.themes[i].s_slug+'" class="btn btn-mini btn-green market-popup"><?php _e('Install') ; ?></a>'
                                        +'<a target="_blank" href="'+data.themes[i].s_preview+'" class="btn btn-mini btn-blue"><?php _e('Preview') ; ?></a>'
                                    +'</div>'
                                +'</div>'
                                +'<div class="theme-info">'
                                    +'<h3>'+data.themes[i].s_title+' '+data.themes[i].s_version+' <?php _e('by') ; ?> <a target="_blank" href="">'+data.themes[i].s_contact_name+'</a></h3>'
                                +'</div>'
                                +'<div class="theme-description">'
                                    +description.substring(0,80)+dots
                                +'</div>'
                            +'</div>');
                        }
                    }
                    $("#market_themes").append('<div class="clear"></div>');
                }
            );
        });

        $('.market-popup').live('click',function(){
            $.getJSON(
                "<?php echo osc_admin_base_url(true); ?>?page=ajax&action=check_market",
                {"code" : $(this).attr('href').replace('#','')},
                function(data){
                    if(data!=null) {
                        $("#market_thumb").attr('src',data.s_thumbnail);
                        $("#market_code").attr("value", data.s_slug);
                        $("#market_name").html(data.s_title);
                        $("#market_version").html(data.s_version);
                        $("#market_author").html(data.s_contact_name);
                        $("#market_url").attr('href',data.s_source_file);

                        $('#market_installer').dialog({
                            modal:true,
                            title: '<?php echo osc_esc_js( __('OSClass Market') ) ; ?>',
                            width:485
                        });
                    }
                }
            );
            return false;
        });        
        </script>
    </div>
    <!-- /themes list -->
<?php osc_current_admin_theme_path('parts/footer.php') ; ?>