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

    </head>
    <body>
        <div id="classified">

            <?php //jquery_social_share(); ?>
            <?php osc_current_web_theme_path('header-open.php') ; ?>
            <?php osc_current_web_theme_path('inc.search.php') ; ?>
            <?php osc_current_web_theme_path('header-close.php') ; ?>

            <!--section id="top_features_scroll">
            <?php //if (function_exists('carousel')) {carousel();} ?>
            </section-->

            <section id="container">
                <div class="silver_box_lite">
                    <div class="wh_curve_box">
                        <h1><?php _e('Hotels And Restaurants List', 'modern') ; ?></h1>
                        <div class='alpha_container'>
                            <?php 
                                $hnrCompanyList = list_hnr(); 
                                foreach($hnrCompanyList as $hnrCompany) {
                                    echo '<a href="'.osc_base_url(TRUE).'?page=user&action=pub_profile&id='.$hnrCompany['pk_i_id'].'">'.$hnrCompany['s_name'].'</a><br /><br />';
                                }
                            
                            ?>
                            <div class="clear"></div></div>
                    </div>
                    <div class="clear"></div>

                </div>

            </section>
            <section class="ads_3">
                <?php horiz_long_advertisement(); ?>
            </section>
            <section class="ads_3">
                <?php osc_current_web_theme_path('g_ads_horiz.php') ; ?>
            </section>
            <?php osc_current_web_theme_path('footer.php') ; ?>
            <!-- </div> -->
</html>