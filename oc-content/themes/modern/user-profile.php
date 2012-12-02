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

$locales   = __get('locales') ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
    <head>
        <?php osc_current_web_theme_path('head.php') ; ?>
        <meta name="robots" content="noindex, nofollow" />
        <meta name="googlebot" content="noindex, nofollow" />
        <script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('jquery.multiselect.min.js') ; ?>"></script>
        <link href="<?php echo osc_current_web_theme_url('jquery.multiselect.css') ; ?>" rel="stylesheet" type="text/css" />
        <?php if(osc_images_enabled_at_items()) ItemForm::photos_javascript(); ?>
        <script type="text/javascript">

            $(document).ready(function(){
                $("#multiselect_sCategory").multiselect();
            });

            $(document).ready(function(){
                //$("#multiselect_sCategory").multiselect();

                // Check usertype on document ready and display or hide
                // company info as per the usertype
                if($("input:radio[name=b_company]:checked").val() == '0') {
                    $("#companyextrafield").css("display","none");
                }
                $(".usertype").click(function(){
                    if ($('input[name=b_company]:checked').val() == "1" ) {
                        $("#companyextrafield").slideDown("fast"); //Slide Down Effect
                    } else {
                        $("#companyextrafield").slideUp("fast");	//Slide Up Effect
                    }
                });
            });            
        </script>
        <?php if(osc_images_enabled_at_items()) ItemForm::photos_javascript(); ?>
        <script type="text/javascript">
            function uniform_input_file(){
                photos_div = $('div.photos');
                $('div',photos_div).each(
                function(){
                    if( $(this).find('div.uploader').length == 0  ){
                        divid = $(this).attr('id');
                        //if(divid != 'aphotos'){
                            divclass = $(this).hasClass('box');
                            if( !$(this).hasClass('box') & !$(this).hasClass('uploader') & !$(this).hasClass('row')){
                                $("div#"+$(this).attr('id')+" input:file").uniform({fileDefaultText: fileDefaultText,fileBtnText: fileBtnText});
                            }
                        //}
                    }
                }
            );
            }
        </script>
    </head>
    <body>
        <div id="classified">

            <?php osc_current_web_theme_path('header-open.php') ; ?>
            <?php osc_current_web_theme_path('inc.search.php') ; ?>
            <?php osc_current_web_theme_path('header-close.php') ; ?>

            <!-- <div  id="top_features_scroll">
            <?php //if (function_exists('carousel')) {carousel();} ?>
		</div> -->

            <div  id="container">
                <div class="silver_box_lite">
                    <div class="wh_curve_box user_account">
                        <h1><?php _e('User account manager', 'modern') ; ?></h1>
                        <div id="sidebar">
                            <?php echo osc_private_user_menu() ; ?>
                        </div>
                        <div id="main" class="modify_profile">
                            <h2><?php _e('Update your profile', 'modern') ; ?></h2>
                            <?php UserForm::location_javascript(); ?>
                            <div id="profilepic">
                                <?php profile_picture_upload(); ?>
                            </div>
                            <form action="<?php echo osc_base_url(true) ; ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="page" value="user" />
                                <input type="hidden" name="action" value="profile_post" />
                                <fieldset>
                                    <div class="row">
                                        <label for="name"><?php _e('Name/Company', 'modern') ; ?></label>
                                        <?php UserForm::name_text(osc_user()) ; ?>
                                    </div>
                                    <div class="row">
                                        <label for="email"><?php _e('E-mail', 'modern') ; ?></label>
                                        <span class="update">
                                            <input type="text" value="<?php echo osc_user_email() ; ?>" readonly="readonly"/>
                                        </span>
                                    </div>
                                    <div class="row">
                                        <label for="user_type"><?php _e('User type', 'modern') ; ?></label>
                                        Individual<input type="radio" name="b_company" value="0" class="usertype" style="width: 20px;"
                                        <?php if(osc_company() == 0) { echo " checked"; } ?>
                                                      />
                                        Company<input type="radio" name="b_company" value="1" class="usertype" style="width: 20px;"
                                                        <?php if(osc_company() == 1) { echo " checked"; } ?>
                                                      />
                                        <?php //UserForm::is_company_select(osc_user()) ; ?>
                                    </div>
                                    <div class="row">
                                        <label for="phoneMobile"><?php _e('Cell phone', 'modern') ; ?></label>
                                        <?php UserForm::mobile_text(osc_user()) ; ?>
                                    </div>
                                    <div class="row">
                                        <label for="phoneLand"><?php _e('Phone', 'modern') ; ?></label>
                                        <?php UserForm::phone_land_text(osc_user()) ; ?>
                                    </div>
                                    <!--<div class="row">
                                        <label for="country"><?php _e('Country', 'modern') ; ?> </label>
                                        <?php UserForm::country_select(osc_get_countries(), osc_user()) ; ?>
                                    </div>-->
                                    <div class="row">
                                        <label for="region"><?php _e('Region', 'modern') ; ?> </label>
                                        <?php UserForm::region_select(osc_get_regions(), osc_user()) ; ?>
                                    </div>
                                    <div class="row">
                                        <label for="city"><?php _e('City', 'modern') ; ?> </label>
                                        <?php UserForm::city_select(osc_get_cities(), osc_user()) ; ?>
                                    </div>
                                    <div class="row" style="margin-top: 15px;">
                                        <label for="city_area"><?php _e('City area', 'modern') ; ?></label>
                                        <?php UserForm::city_area_text(osc_user()) ; ?>
                                    </div>
                                    <div class="row">
                                        <label for="address"><?php _e('Address', 'modern') ; ?></label>
                                        <?php UserForm::address_text(osc_user()) ; ?>
                                    </div>
                                    <div class="row">
                                        <label for="webSite"><?php _e('Website', 'modern') ; ?></label>
                                        <?php UserForm::website_text(osc_user()) ; ?>
                                    </div>
                                    <div id="companyextrafield">
                                        <div class="row">
                                            <label for="category"><?php _e('Select Item Category', 'modern') ; ?></label>
                                            <?php chosen_multi_select_standard(osc_user_categories()) ; ?>
                                        </div>
                                        <div class="row">
                                            <label for="description"><?php _e('Description', 'modern') ; ?></label>
                                            <?php UserForm::multilanguage_info($locales, osc_user()); ?>
                                        </div>
                                        <div class="row">
                                            <label for="photos"><?php _e('Photos', 'modern'); ?></label>
                                            <strong>Click On Image to Delete</strong><br />
                                            <?php
                                                $companyPics = osc_user_company_pics();
                                                //print_r($companyPics);
                                                foreach($companyPics as $companyPic) {
                                                    echo '<a href="#" class="delImage" id="'.$companyPic['pk_i_id'].'"><img src="'. osc_base_url() . $companyPic['s_path']. $companyPic['pk_i_id'].'_company_thumbnail.'.$companyPic['s_extension'].'" width="100" height="100" title="Delete Image" /></a>';
                                                }
                                            ?>
                                            
                                            <div class="box photos" style="float:left;margin-left:150px;">
                                                <div id="photos">
                                                </div>
                                                <br /><a href="#" onclick="addNewPhoto(); uniform_input_file(); return false;"><i class="icon-add"></i> <?php _e('Add new photo', 'modern'); ?></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="youtube"><?php _e('Youtube Link', 'modern') ; ?></label>
                                            <?php UserForm::youtube_area_text(osc_user_youtube()) ; ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <button type="submit"><?php _e('Update', 'modern') ; ?></button>
                                    </div>
                                    <?php osc_run_hook('user_form') ; ?>
                                </fieldset>
                            </form>

                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <div  class="ads_3">
                <?php horiz_long_advertisement(); ?>
            </div>
            <div  class="ads_3">
                <?php osc_current_web_theme_path('g_ads_horiz.php') ; ?>
            </div>
        </div>
        <?php osc_current_web_theme_path('footer.php') ; ?>

</html>

<script>
    $(document).ready(function(){
        $('.delImage').click(function(e){
            e.preventDefault();
            if (window.confirm('Are you sure you want to delete this image?')){
                var id = this.id;
                $.ajax ({
                    type: "POST",
                    url: "<?php echo osc_base_url(true)?>",
                    data: "page=user&action=deleteCompanyImage&id="+id,
                    cache: false,
                    async: false,
                    success: function() {
                        location.reload();
                    }
                });
            };
        });
        // other codes will come here
   });
</script>