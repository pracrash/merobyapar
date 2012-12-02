<?php
    /*
     *      OSCLass – software for creating and publishing online classified
     *                           advertising platforms
     *
     *                        Copyright (C) 2010 OSCLASS
     *
     *       This program is free software: you can redistribute it and/or
     *     modify it under the terms of the GNU Affero General Public License
     *     as published by the Free Software Foundation, either version 3 of
     *            the License, or (at your option) any later version.
     *
     *     This program is distributed in the hope that it will be useful, but
     *         WITHOUT ANY WARRANTY; without even the implied warranty of
     *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *             GNU Affero General Public License for more details.
     *
     *      You should have received a copy of the GNU Affero General Public
     * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
     */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
    <head>
        <?php osc_current_web_theme_path('head.php') ; ?>
        <meta name="robots" content="noindex, nofollow" />
        <meta name="googlebot" content="noindex, nofollow" />

        <!-- only item-post.php -->
        <script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('jquery.validate.min.js') ; ?>"></script>
        <?php ItemForm::location_javascript_new(); ?>
        <?php if(osc_images_enabled_at_items()) ItemForm::photos_javascript(); ?>
        <script type="text/javascript">
            function uniform_input_file(){
                photos_div = $('div.photos');
                $('div',photos_div).each(
                function(){
                    if( $(this).find('div.uploader').length == 0  ){
                        divid = $(this).attr('id');
                        if(divid != 'photos'){
                            divclass = $(this).hasClass('box');
                            if( !$(this).hasClass('box') & !$(this).hasClass('uploader') & !$(this).hasClass('row')){
                                $("div#"+$(this).attr('id')+" input:file").uniform({fileDefaultText: fileDefaultText,fileBtnText: fileBtnText});
                            }
                        }
                    }
                }
            );
            }

            setInterval("uniform_plugins()", 250);
            function uniform_plugins() {

                var content_plugin_hook = $('#plugin-hook').text();
                content_plugin_hook = content_plugin_hook.replace(/(\r\n|\n|\r)/gm,"");
                if( content_plugin_hook != '' ){

                    var div_plugin_hook = $('#plugin-hook');
                    var num_uniform = $("div[id*='uniform-']", div_plugin_hook ).size();
                    if( num_uniform == 0 ){
                        if( $('#plugin-hook input:text').size() > 0 ){
                            $('#plugin-hook input:text').uniform();
                        }
                        if( $('#plugin-hook select').size() > 0 ){
                            $('#plugin-hook select').uniform();
                        }
                    }
                }
            }
<?php if(osc_locale_thousands_sep()!='' || osc_locale_dec_point() != '') { ?>
    $().ready(function(){
        $("#price").blur(function(event) {
            var price = $("#price").attr("value");
    <?php if(osc_locale_thousands_sep()!='') { ?>
                while(price.indexOf('<?php echo osc_esc_js(osc_locale_thousands_sep());  ?>')!=-1) {
                    price = price.replace('<?php echo osc_esc_js(osc_locale_thousands_sep());  ?>', '');
                }
    <?php }; ?>
    <?php if(osc_locale_dec_point()!='') { ?>
                var tmp = price.split('<?php echo osc_esc_js(osc_locale_dec_point())?>');
                if(tmp.length>2) {
                    price = tmp[0]+'<?php echo osc_esc_js(osc_locale_dec_point())?>'+tmp[1];
                }
    <?php }; ?>
                $("#price").attr("value", price);
            });
        });
<?php }; ?>
        </script>
        <!-- end only item-post.php -->
        <!-- favicons
================================================== -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <link rel="shortcut icon" href="<?php echo osc_current_admin_theme_url('images/favicon-48.png'); ?>">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo osc_current_admin_theme_url('images/favicon-144.png'); ?>">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo osc_current_admin_theme_url('images/favicon-114.png'); ?>">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo osc_current_admin_theme_url('images/favicon-72.png'); ?>">
        <link rel="apple-touch-icon-precomposed" href="<?php echo osc_current_admin_theme_url('images/favicon-57.png'); ?>">
    </head>
    <body>
        <div id="classified">

            <?php //jquery_social_share(); ?>
            <?php osc_current_web_theme_path('header-open.php') ; ?>
            <?php osc_current_web_theme_path('inc.search.php') ; ?>
            <?php osc_current_web_theme_path('header-close.php') ; ?>

            <div id="container">
                <div class="content user_account">

                    <div class="silver_box_lite">
                        <div class="wh_curve_box">
                            <h1>
                                <?php _e('Publish a listing', 'modern'); ?>
                            </h1>

                            <div id="sidebar">
                                <?php echo osc_private_user_menu() ; ?>
                            </div>
                            <div id="main" class="modify_profile">
                                
                                <ul id="error_list"></ul>
                                <form name="item" action="<?php echo osc_base_url(true);?>" method="post" enctype="multipart/form-data">
                                    <fieldset>
                                        <input type="hidden" name="action" value="item_add_post" />
                                        <input type="hidden" name="page" value="item" />
                                        <div class="box general_info">
                                            <h2><?php _e('General Information', 'modern'); ?></h2>
                                            <div class="row">
                                                <label for="catId"><?php _e('Category', 'modern'); ?> *</label>
                                                <?php ItemForm::category_select(null, null, __('Select a category', 'modern')); ?>
                                            </div>
                                            <!-- <div class="row"> -->
                                            <div class="row input-description-wide">
                                                <?php ItemForm::multilanguage_title_description(); ?>
                                            </div>

                                            <?php if( osc_price_enabled_at_items() ) { ?>
                                            <div class="box price">
                                                <label for="price" style="margin-left: -20px;"><?php _e('Price', 'modern'); ?> <?php ItemForm::currency_select(); ?></label>
                                                    <?php ItemForm::price_input_text(); ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <?php if( osc_images_enabled_at_items() ) { ?>
                                        <div class="row">
                                            <label for="photos"><?php _e('Photos', 'modern'); ?></label>
                                            <strong>&nbsp;</strong><br />
                                            <div class="box photos">
                                                <div id="photos">
                                                </div>
                                                <br /><a href="#" onclick="addNewPhoto(); uniform_input_file(); return false;"><i class="icon-add"></i> <?php _e('Add new photo', 'modern'); ?></a>
                                            </div>
                                        </div>
                                        <?php } ?>

                                        <div class="box location">
                                            <h2><?php _e('Listing Location', 'modern'); ?></h2>
                                            <!--<div class="row">
                                                <label for="countryId"><?php _e('Country', 'modern'); ?></label>
                                                <?php ItemForm::country_select(osc_get_countries(), osc_user()) ; ?>
                                            </div>-->
                                            <div class="row" style="margin-top: 15px;">
                                                <label for="regionId"><?php _e('Region', 'modern'); ?></label>
                                                <?php UserForm::region_select(osc_get_regions(), osc_user()) ; ?>
                                            </div>
                                            <div class="row">
                                                <label for="city"><?php _e('City', 'modern'); ?></label>
                                                <?php ItemForm::city_text(osc_user()) ; ?>
                                                <?php //UserForm::city_select(osc_get_cities(), osc_user()) ; ?>
                                            </div>
                                            <!--<div class="row">
                                                <label for="city"><?php _e('City Area', 'modern'); ?></label>
                                                <?php ItemForm::city_area_text(osc_user()) ; ?>
                                            </div>-->
                                            <div class="row">
                                                <label for="address"><?php _e('Address', 'modern'); ?></label>
                                                <?php ItemForm::address_text(osc_user()) ; ?>
                                            </div>
                                        </div>
                                        <!-- seller info -->
                                        <?php if(!osc_is_web_user_logged_in() ) { ?>
                                        <div class="box seller_info">
                                            <h2><?php _e("Seller's information", 'modern'); ?></h2>
                                            <div class="row">
                                                <label for="contactName"><?php _e('Name', 'modern'); ?></label>
                                                    <?php ItemForm::contact_name_text() ; ?>
                                            </div>
                                            <div class="row">
                                                <label for="contactEmail"><?php _e('E-mail', 'modern'); ?> *</label>
                                                    <?php ItemForm::contact_email_text() ; ?>
                                            </div>
                                            <div class="row">
                                                <div style="width: 120px;text-align: right;float:left;">
                                                        <?php ItemForm::show_email_checkbox() ; ?>
                                                </div>
                                                <label for="showEmail" style="width: 250px;"><?php _e('Show e-mail on the listing page', 'modern'); ?></label>
                                            </div>
                                        </div>
                                        <?php }; ?>
                                        <?php ItemForm::plugin_post_item(); ?>
                                        <?php if( osc_recaptcha_items_enabled() ) {?>
                                        <div class="box">
                                            <div class="row">
                                                    <?php osc_show_recaptcha(); ?>
                                            </div>
                                        </div>
                                        <?php }?>
                                        <div class="clear"></div>
                                        <button  type="submit"><?php _e('Publish', 'modern'); ?></button>
                                    </fieldset>
                                </form>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div  class="ads_3">
            <img src="<?php echo osc_current_web_theme_url('images/long_ads.png') ; ?>" />
        </div>
        <div  class="ads_3">
            <?php osc_current_web_theme_path('g_ads_horiz.php') ; ?>
        </div>
        <?php osc_current_web_theme_path('footer.php') ; ?>
        <!-- </div> -->
</html>