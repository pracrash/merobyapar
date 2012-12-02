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

$sQuery = osc_get_preference('keyword_placeholder', 'modern_theme');
?>

<form action="<?php echo osc_base_url(true) ; ?>" method="get" id="search_box" style="position:relative">
    <!--<a href="#" class="postfreeads">Post Free Ads</a>-->
    <input type="hidden" name="page" value="search" />
    <fieldset>
        <input class="keywords" type="text" name="sPattern" value=""/>
        <?php //chosen_select_standard() ; ?>
        <?php //chosen_region_select() ; ?>
        <button type="submit" class="btn_search"><?php _e('Search', 'modern') ; ?></button>
    </fieldset>
</form>