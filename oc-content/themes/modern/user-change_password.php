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
                    <div class="wh_curve_box">
                        <h1><?php _e('User account manager', 'modern') ; ?></h1>
                        <div class="user_account">
                            <div id="sidebar">
                                <?php echo osc_private_user_menu() ; ?>
                            </div>

                            <div id="main" class="modify_profile">
                                <h2><?php _e('Change your password', 'modern') ; ?></h2>
                                <form action="<?php echo osc_base_url(true) ; ?>" method="post">
                                    <input type="hidden" name="page" value="user" />
                                    <input type="hidden" name="action" value="change_password_post" />
                                    <fieldset>
                                        <p>
                                            <label for="password"><?php _e('Current password', 'modern') ; ?> *</label>
                                            <input type="password" name="password" id="password" value="" />
                                        </p>
                                        <p>
                                            <label for="new_password"><?php _e('New password', 'modern') ; ?> *</label>
                                            <input type="password" name="new_password" id="new_password" value="" />
                                        </p>
                                        <p>
                                            <label for="new_password2"><?php _e('Repeat new password', 'modern') ; ?> *</label>
                                            <input type="password" name="new_password2" id="new_password2" value="" />
                                        </p>
                                        <div style="clear:both;"></div>
                                        <button type="submit"><?php _e('Update', 'modern') ; ?></button>
                                    </fieldset>
                                </form>
                                <div class="clear"></div>
                            </div>

                            <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <div  class="ads_3">
                <img src="<?php echo osc_current_web_theme_url('images/long_ads.png') ; ?>" />
            </div>
            <div  class="ads_3">
                <?php osc_current_web_theme_path('g_ads_horiz.php') ; ?>
            </div>
        </div>
        <?php osc_current_web_theme_path('footer.php') ; ?>

</html>