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

osc_get_premiums(10);
if(osc_count_premiums() > 0) {
    ?>
<!-- <h1>Sponsored Ads Listing</h1> -->
    <?php $class = "even" ; ?>


    <?php while(osc_has_premiums()) { ?>

        <?php if( osc_images_enabled_at_items() ) { ?>
<div class="latest_listing_items">
    <!-- <div id="premium_img"></div> -->
                <?php if(osc_count_premium_resources()) { ?>

    <a href="<?php echo osc_resource_thumbnail_url() ; ?>" class="preview" title="<?php echo osc_item_title(); ?>" alt="<?php echo osc_item_title(); ?>">
        <img src="<?php echo osc_resource_thumbnail_url() ; ?>" width="75" height="56" title="<?php echo osc_item_title(); ?>" alt="<?php echo osc_item_title(); ?>" />
    </a>

                <?php } else { ?>
    <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" title="<?php echo osc_item_title(); ?>" alt="<?php echo osc_item_title(); ?>">
                <?php } ?>

            <?php } ?>

    <div class="latest_listing_items_jist">
       <h3>Price:
<em><?php if( osc_price_enabled_at_items() ) { echo osc_premium_formated_price() ; ?> </em></h3>
        <h2>
            <a href="<?php echo osc_premium_url() ; ?>"><?php echo osc_highlight( strip_tags( osc_premium_title() ) ); ?></a></span><span style="float:right;">
        </h2>&nbsp;&nbsp;&nbsp;<?php _e("<span class='sponsored'>Sponsored ad</span>", "modern"); ?>
        <p>Posted by <a href="<?php echo osc_user_public_profile_url( osc_item_user_id() ); ?>" ><?php echo osc_item_contact_name(); ?></a></p>
        
         - <?php } echo osc_premium_city(); ?> (<?php echo osc_premium_region(); ?>) - <?php echo osc_format_date(osc_premium_pub_date()); ?>
        <p><?php echo osc_highlight( strip_tags( osc_premium_description_extract() ) ) ; ?></p>
        <div class="clear"></div>
    </div>
            <?php $class = ($class == 'even') ? 'odd' : 'even' ; ?>
</div>

    <?php } ?>


<?php } ?>
<!-- <h1>Normal Ads Listing</h1> -->


<?php $class = "even" ; ?>
<?php while(osc_has_items()) { ?>
    <?php if(osc_item_is_premium() == 0) { ?>
<div class="latest_listing_items">

            <?php if( osc_images_enabled_at_items() ) { ?>

                <?php //if( osc_item_is_premium() ){ ?>
    <!-- <div id="premium_img"></div> -->
                <?php //}?>

                <?php if( osc_count_item_resources() ) { ?>

    <a href="<?php echo osc_resource_thumbnail_url() ; ?>" class="preview" title="<?php echo osc_item_title(); ?>" alt="<?php echo osc_item_title(); ?>">
        <img src="<?php echo osc_resource_thumbnail_url() ; ?>" width="75" height="56" title="<?php echo osc_item_title(); ?>" alt="<?php echo osc_item_title(); ?>" />
    </a>
                <?php } else { ?>
    <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" alt="" title="" />
                <?php } ?>

            <?php } ?>
    <div class="latest_listing_items_jist">
    <h3>Price: <em> <?php echo osc_item_formated_price() ; ?> </em></h3> 
        <h2><a href="<?php echo osc_item_url() ; ?>"><?php echo osc_item_title() ; ?></a><em> (<?php echo osc_item_views(); ?> views)</em></h2>
        <p>Posted by <a href="<?php echo osc_user_public_profile_url( osc_item_user_id() ); ?>" ><?php echo osc_item_contact_name(); ?></a></p>
                <?php if( osc_price_enabled_at_items() ) { ?>
        - <?php } echo osc_item_city(); ?> (<?php echo osc_item_region();?>) - <?php echo osc_format_date(osc_item_pub_date()); ?>
        <p><?php echo osc_highlight( strip_tags( osc_item_description_extract() ) ) ; ?></p>
        <div class="clear"></div>
    </div>
            <?php $class = ($class == 'even') ? 'odd' : 'even' ; ?>
            
</div>
    <?php } }?>
	