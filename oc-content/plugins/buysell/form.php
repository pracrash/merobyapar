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
<label><?php _e("Offer type", 'buysell') ; ?></label>
<?php $buysell_types = __get('buysell_types') ; ?>
<select name="buysell_type" id="buysell_type">
    <?php foreach($buysell_types as $k => $v) { ?>
    <option value="<?php echo $k ; ?>" <?php if (@$detail['s_type'] == $k) { echo "selected" ; } ?>><?php echo $v ; ?></option>
    <?php } ?>
</select>