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
    </head>
    <body>
	<div id="classified">

	<?php //jquery_social_share(); ?>
        <?php osc_current_web_theme_path('header-open.php') ; ?>
		<?php osc_current_web_theme_path('inc.search.php') ; ?>
		<?php osc_current_web_theme_path('header-close.php') ; ?>
		 
     	<!-- <div  id="top_features_scroll">
			<?php //if (function_exists('carousel')) {carousel();} ?>
		</div> -->
		
		<div  id="container">
        <div class="content error" style="text-align: center;">
            <h1><?php //_e('Page not found', 'modern') ; ?></h1>
			<br/>
			<img src="<?php echo osc_current_admin_theme_url('images/404.png'); ?>">
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