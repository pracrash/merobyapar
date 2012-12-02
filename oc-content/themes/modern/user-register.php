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
        <script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('jquery.validate.min.js') ; ?>"></script>
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
        <?php UserForm::js_validation() ; ?>

        <div id="classified">

            <?php //jquery_social_share(); ?>
            <?php osc_current_web_theme_path('header-open.php') ; ?>
            <?php osc_current_web_theme_path('inc.search.php') ; ?>
            <?php osc_current_web_theme_path('header-close.php') ; ?>

            <div id="container">
                
                <div id="lf_column">
                    <?php osc_current_web_theme_path('categorylist.php') ; ?>
                </div>
                <div id="mid_column_clr_rt">
                    <div class="silver_box_lite">
                        <div class="wh_curve_box">
                            <h1><?php _e('Register an account for free', 'modern') ; ?></h1>
                            <ul id="error_list"></ul>
                            <div class="user_forms">
                                <form name="register" id="register" action="<?php echo osc_base_url(true) ; ?>" method="post" >
                                    <input type="hidden" name="page" value="register" />
                                    <input type="hidden" name="action" value="register_post" />

                                    <fieldset>
                                        <label for="name"><?php _e('Name', 'modern') ; ?></label> <?php UserForm::name_text(); ?><br />
                                        <label for="password"><?php _e('Password', 'modern') ; ?></label> <?php UserForm::password_text(); ?><br />
                                        <label for="password"><?php _e('Re-type password', 'modern') ; ?></label> <?php UserForm::check_password_text(); ?><br />
                                        <p id="password-error" style="display:none;">
                                            <?php _e('Passwords don\'t match', 'modern') ; ?>.
                                        </p>
                                        <label for="email"><?php _e('E-mail', 'modern') ; ?></label> <?php UserForm::email_text() ; ?><br />
                                        <input type="checkbox" id="termsncondition" name="termsncondition" value="1" style="width:15px;"/>
                                        <a href="index.php?page=page&id=25"><?php _e('Accept terms and conditions', 'modern') ; ?></a>
                                        <!--label for="termsncondition"--><!--/label--><br />
                                        <?php osc_run_hook('user_register_form') ; ?>
                                        <?php osc_show_recaptcha('register'); ?>
                                        <p>
                                            <button type="submit"><?php _e('Register', 'modern') ; ?></button></p>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="ads_3">
            <?php horiz_long_advertisement(); ?>
        </div>
        <div class="ads_3">
            <?php osc_current_web_theme_path('g_ads_horiz.php') ; ?>
        </div>
        <?php osc_current_web_theme_path('footer.php') ; ?>
    </div>
</html>