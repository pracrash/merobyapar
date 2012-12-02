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
        <meta name="robots" content="index, follow" />
        <meta name="googlebot" content="index, follow" />
        <link rel="stylesheet" type="text/css" href="<?php echo osc_current_web_theme_js_url('chosen/bootstrap.min.css') ; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo osc_current_web_theme_js_url('chosen/chosen.css') ; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo osc_current_web_theme_styles_url('custom.css') ; ?>" />

        <script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('jquery.js') ; ?>"></script>
        <script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('jquery.validate.min.js') ; ?>"></script>
        <script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('global.js') ; ?>"></script>
        <script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('chosen/chosen.min.js') ; ?>"></script>


        <!-- favicons
================================================== -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <link rel="shortcut icon" href="<?php echo osc_current_admin_theme_url('images/favicon-48.png'); ?>">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo osc_current_admin_theme_url('images/favicon-144.png'); ?>">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo osc_current_admin_theme_url('images/favicon-114.png'); ?>">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo osc_current_admin_theme_url('images/favicon-72.png'); ?>">
        <link rel="apple-touch-icon-precomposed" href="<?php echo osc_current_admin_theme_url('images/favicon-57.png'); ?>">

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
                </div>

                <div id="mid_column_clr_rt">
                    <div class="silver_box_lite">
                        <div class="wh_curve_box">
                            <h1><?php _e('Contact us', 'modern') ; ?></h1>
                            <div class="user_forms">
                                <ul id="error_list"></ul>
                                <?php ContactForm::js_validation() ; ?>
                                <form action="<?php echo osc_base_url(true) ; ?>" method="post" name="contact" id="contact">
                                    <input type="hidden" name="page" value="contact" />
                                    <input type="hidden" name="action" value="contact_post" />
                                    <fieldset>
                                        <label for="subject"><?php _e('Subject', 'modern') ; ?> </label> <?php ContactForm::the_subject() ; ?><br />
                                        <label for="message"><?php _e('Message', 'modern') ; ?> </label> <?php ContactForm::your_message() ; ?><br />
                                        <label for="yourName"><?php _e('Your name', 'modern') ; ?> </label> <?php ContactForm::your_name() ; ?><br />
                                        <label for="yourEmail"><?php _e('Your e-mail address', 'modern') ; ?> </label> <?php ContactForm::your_email(); ?><br />
                                        <?php osc_show_recaptcha(); ?>
                                        <br/>
                                        <button type="submit"><?php _e('Send', 'modern') ; ?></button>
                                        <?php osc_run_hook('user_register_form') ; ?>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div></div>
            </div>
            <div class="ads_3">
                <?php horiz_long_advertisement(); ?>
            </div>
            <div class="ads_3">
                <?php osc_current_web_theme_path('g_ads_horiz.php') ; ?>
            </div>
            <?php osc_current_web_theme_path('footer.php') ; ?>
            <!-- </div> -->
</html>