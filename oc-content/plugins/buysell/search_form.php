<?php 
    /**
     * OSClass – software for creating and publishing online classified advertising platforms
     *
     * Copyright (C) 2010 OSCLASS
     *
     * This program is free software: you can redistribute it and/or modify it under the terms
     * of the GNU Affero General Public License as published by the Free Software Foundation,
     * either version 3 of the License, or (at your option) any later version.
     *
     * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
     * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
     * See the GNU Affero General Public License for more details.
     *
     * You should have received a copy of the GNU Affero General Public
     * License along with this program. If not, see <http://www.gnu.org/licenses/>.
     */
?>
<div class="row one_input">
    <h6><?php _e("Offer type", 'buysell') ; ?></h6>
    <?php $buysell_types = __get('buysell_types') ; ?>
    <select name="buysell_type" id="buysell_type" style="width: 200px;" class="chzn-select">
        <option value="ALL" ><?php _e('All', 'buysell') ; ?></option>
        <?php foreach($buysell_types as $k => $v) { ?>
        <option value="<?php echo $k ; ?>" <?php if (Params::getParam('buysell_type') == $k) { echo "selected" ; } ?>><?php echo $v ; ?></option>
        <?php } ?>
    </select>
</div>
<style>
.chzn-select{ width:200px !important;}
</style>