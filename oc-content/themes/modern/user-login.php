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
ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
    <head>
        <?php osc_current_web_theme_path('head.php') ; ?>
        <meta name="robots" content="noindex, nofollow" />
        <meta name="googlebot" content="noindex, nofollow" />

        <!-- carousel css/js -->
        <style type="text/css">
<?php $cssurl = 'oc-content/plugins/carousel_for_osclass/css/slideshow.css' ;
include($cssurl) ; ?>
        </style>

        <script type='text/javascript' src="<?php echo osc_base_url() . 'oc-content/plugins/carousel_for_osclass/js/jCarouselLite.js'; ?>">
        </script>

        <script type='text/javascript'>
<?php
//used for enabling auto speed in carousel.
$autospeed = ',
            auto: ' . $scrolldelay . ' ,
            speed: 1100,';?>


                jQuery(document).ready(function(){


                    /* featured listings slider */
                    jQuery(".carouselSlider").jCarouselLite({
                        btnNext: ".nextCarousel",
                        btnPrev: ".prevCarousel",
                        //scroll: 2, //this works
                        visible: <?php echo $items; ?>,
                        hoverPause:true<?php if($autosp == 1) { echo $autospeed; } else { echo ',';} ?>
                        vertical: <?php if($vert == 1) { echo 'true';} else { echo 'false';} ?>
                        //easing: "easeOutQuint" // for different types of easing, see easing.js
                    });

                });
        </script>
    </head>
    <body>
        <div id="classified">

            <?php osc_current_web_theme_path('header-open.php') ; ?>
            <?php osc_current_web_theme_path('inc.search.php') ; ?>
            <?php osc_current_web_theme_path('header-close.php') ; ?>

            <div id="container">

                <div id="lf_column">
                    <?php osc_current_web_theme_path('categorylist.php') ; ?>

                    <div class="silver_box_lite">
                        <div class="wh_curve_box">
                            <h1>Most Viewed</h1>
                            <?php popular_ads_start(); ?>
                            <ul class="most_viewed_list">
                                <?php while ( osc_has_items() ) { ?>
                                <li><a href="<?php echo osc_item_url() ; ?>"><?php echo osc_item_title() ; ?></a> <span>(<?php echo osc_item_views(); ?> views)</span></li>
                                <?php } ?>
                            </ul>
                            <?php popular_ads_end(); ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <?php vertical_rightbar_advertisement(); ?>
                </div>

                <div id="mid_column_clr_rt">

                    <div class="silver_box_lite">
                        <div class="wh_curve_box">
                            <h1><?php _e('Access to your account', 'modern'); ?></h1>
                            <div class="user_forms">
                                <form action="<?php echo osc_base_url(true); ?>" method="post" >
                                    <input type="hidden" name="page" value="login" />
                                    <input type="hidden" name="action" value="login_post" />
                                    <fieldset style="padding:10px 15px;">
                                        <p><label for="email"><?php _e('E-mail', 'modern'); ?></label> <?php UserForm::email_login_text() ; ?></p>

                                        <p>
                                            <label for="password"><?php _e('Password', 'modern'); ?></label> <?php UserForm::password_login_text() ; ?></p>
                                        <p class="checkbox"><label for="rememberMe">&nbsp;</label> <?php UserForm::rememberme_login_checkbox();?> <?php _e('Remember me', 'modern') ; ?></p>
                                        <p><label>&nbsp;</label><button type="submit"><?php _e("Log in", 'modern');?></button></p>

                                        <div class="more-login">
                                            <a href="<?php echo osc_register_account_url() ; ?>"><?php _e("Register for a free account", 'modern') ; ?></a> · <a href="<?php echo osc_recover_user_password_url() ; ?>"><?php _e("Forgot password?", 'modern') ; ?></a>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div> <div class="clear"></div></div>

                    <div class="clear"></div>
                </div>
                <div class="ads_3">
                    <?php horiz_long_advertisement(); ?>
                </div>
                <div class="ads_3">
                    <?php osc_current_web_theme_path('g_ads_horiz.php') ; ?>
                </div>
            </div>
            <?php osc_current_web_theme_path('footer.php') ; ?>
</html>