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

<div id="settings_form" style="border: 1px solid #ccc; background: #eee; ">
    <div style="padding: 0 20px 20px;">
        <div>
           <fieldset>
                <legend>
                    <h1><?php _e('JQuery Social Share Help', 'JQuery Social Share'); ?></h1>
                </legend>
                <h2>
                    <?php _e('What is JQuery Social Share Plugin?', 'JQuery Social Share'); ?>
                </h2>
                <p>
                    <?php _e('JQuery social share plugin allows you to easily share your add social media share buttons and popular social bookmark buttons to your web site.', 'JQuery Social Share'); ?>
                </p>
                <h2>
                    <?php _e('How does JQuery Social Share Plugin work?', 'JQuery Social Share'); ?>
                </h2>
                <p>
                    <?php _e('In order to use JQuery Social Share Plugin, you should edit your theme files and add the following line of code you want to show social bookmark buttons', 'JQuery Social Share'); ?>:
                </p>
                <pre>
                    &lt;?php jquery_social_share(); ?&gt;
                </pre>
                <h2>
                <?php _e('Recommened Place', 'JQuery Social Share'); ?>
                </h2>
                <p>
                    <?php _e('Locate these line in your themes main.php', 'JQuery Social Share'); ?>.
                </p>
                <pre>
                    &ltbody&gt
                </pre>
                <p>
                    <?php _e('Replace the above line with this', 'JQuery Social Share'); ?>
                </p>
                <pre>
                    &ltbody&gt
    &lt;?php jquery_social_share(); ?&gt;
                </pre>
            </fieldset>
        </div>
    </div>
</div>
