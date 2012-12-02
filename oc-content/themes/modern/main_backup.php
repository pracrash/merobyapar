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

            <?php jquery_social_share(); ?>
            <?php osc_current_web_theme_path('header-open.php') ; ?>
            <?php osc_current_web_theme_path('inc.search.php') ; ?>
            <?php osc_current_web_theme_path('header-close.php') ; ?>

            <div id="top_features_scroll">
                <?php if (function_exists('carousel')) {carousel();} ?>
            </div>
            <div id="container">
                <div id="lf_column">
                    <div class="silver_box_lite">
                        <div class="wh_curve_box">
                            <h1>Browse Category</h1>
                            <ul class="categories">
                                <?php osc_goto_first_category() ; ?>

                                <?php while ( osc_has_categories() ) { ?>
                                <div class="category">
                                    <li><a class="category <?php echo osc_category_slug() ; ?>" href="<?php echo osc_search_category_url() ; ?>"><?php echo osc_category_name() ; ?></a> <span>(<?php echo osc_category_total_items() ; ?>)</span></li>
                                </div>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="silver_box_lite">
                        <div class="wh_curve_box">
                            <h1>Most Viewed</h1>
                            <?php popular_ads_start(); ?>
                            <ul class="most_viewed_list">
                                <?php while ( osc_has_items() ) { ?>
                                <li><a href="<?php echo osc_item_url() ; ?>"><?php echo osc_item_title() ; ?></a>
                                    <span>(<?php echo osc_item_views(); ?> views)</span></li>
                                <?php } ?>
                            </ul>
                            <?php popular_ads_end(); ?>
                        </div>
                    </div>
                    <?php vertical_rightbar_advertisement(); ?>
                </div> 

                <div id="mid_column_clr_rt">
                    <div class="silver_box_lite">
                        <div class="wh_curve_box">
                            <h1><a href="/feed" class="rss_icon"><img src="<?php echo osc_current_web_theme_url('images/rss_icon.png') ; ?>" /></a>Latest Listing</h1>

                            <?php if( osc_count_latest_items() == 0) { ?>
                            <p class="empty"><?php _e('No Latest Listings', 'modern') ; ?></p>
                            <?php } else { ?>
                                <?php $class = "even"; ?>
                            <div class="latest_listing_items">

                                    <?php while ( osc_has_latest_items() ) { ?>
                                        <?php if( osc_item_is_premium() ) { ?>
                                            <?php if( osc_images_enabled_at_items() ) { ?>

                                                <?php if( osc_count_item_resources() ) { ?>

                                <a href="<?php echo osc_resource_thumbnail_url() ; ?>" class="preview" title="<?php echo osc_item_title(); ?>" alt="<?php echo osc_item_title(); ?>">
                                    <img src="<?php echo osc_resource_thumbnail_url() ; ?>" width="75" height="56" title="<?php echo osc_item_title(); ?>" alt="<?php echo osc_item_title(); ?>" />
                                </a>
                                                <?php } else { ?>
                                <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" title="<?php echo osc_item_title(); ?>" alt="<?php echo osc_item_title(); ?>">
                                                <?php } ?>

                                            <?php } ?>
                                <div class="latest_listing_items_jist">
                                    <h2><a href="<?php echo osc_item_url() ; ?>"><?php echo osc_item_title() ; ?></a><em> (<?php echo osc_item_views(); ?> views)</em></h2>

                                    &nbsp;&nbsp;&nbsp;<?php _e("Sponsored ad", "modern"); ?>

                                    <p><a href="<?php echo osc_item_category_url(osc_item_category_id()) ; ?>"><?php echo osc_item_category() ; ?></a></p>
                                    <h3><em> <?php echo osc_item_formated_price() ; ?> </em></h3>
                                    <p>Posted by <a href="<?php echo osc_user_public_profile_url( osc_item_user_id() ); ?>" ><?php echo osc_item_contact_name(); ?></a></p>
                                                <?php if( osc_price_enabled_at_items() ) { ?>
                                    <p> - <?php } echo osc_item_city(); ?> (<?php echo osc_item_region();?>) - <?php echo osc_format_date(osc_item_pub_date()); ?></p>
                                    <p><?php echo osc_highlight( strip_tags( osc_item_description_extract() ) ) ; ?></p>
                                </div>

                                            <?php $class = ($class == 'even') ? 'odd' : 'even' ; ?>
                                        <?php } } ?>

                                    <?php while ( osc_has_latest_items() ) { ?>
                                        <?php //for($i=0;$i<osc_count_latest_items(); $i++){ ?>

                                        <?php if( osc_item_is_not_premium() ) { ?>
                                            <?php if( osc_images_enabled_at_items() ) { ?>
                                                <?php if( osc_count_item_resources() ) { ?>

                                <a href="<?php echo osc_resource_thumbnail_url() ; ?>" class="preview" title="<?php echo osc_item_title(); ?>" alt="<?php echo osc_item_title(); ?>">
                                    <img src="<?php echo osc_resource_thumbnail_url() ; ?>" width="75" height="56" title="<?php echo osc_item_title(); ?>" alt="<?php echo osc_item_title(); ?>" />
                                </a>
                                                <?php } else { ?>
                                <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" title="<?php echo osc_item_title(); ?>" alt="<?php echo osc_item_title(); ?>">
                                                <?php } ?>

                                            <?php } ?>
                                <div class="latest_listing_items_jist">
                                    <h2><a href="<?php echo osc_item_url() ; ?>"><?php echo osc_item_title() ; ?></a><em> (<?php echo osc_item_views(); ?> views)</em></h2>
                                    <p>Posted by <a href="<?php echo osc_user_public_profile_url( osc_item_user_id() ); ?>" ><?php echo osc_item_contact_name(); ?></a></p>
                                                <?php if( osc_price_enabled_at_items() ) { ?>
                                    <h3><em> <?php echo osc_item_formated_price() ; ?> </em></h3> - <?php } echo osc_item_city(); ?> (<?php echo osc_item_region();?>) - <?php echo osc_format_date(osc_item_pub_date()); ?>
                                    <p><?php echo osc_highlight( strip_tags( osc_item_description_extract() ) ) ; ?></p>
                                </div>

                                <?php $class = ($class == 'even') ? 'odd' : 'even' ; ?>

                                        <?php } } ?>
                                    <?php if( osc_count_latest_items() == osc_max_latest_items() ) { ?>
                                <p class='pagination'><?php echo osc_search_pagination(); ?></p>
                                <br />
                                <p class="see_more_link clear" align="right"><a href="<?php echo osc_search_show_all_url();?>"><strong><?php _e("See all", 'modern'); ?> &raquo;</strong></a> &nbsp;&nbsp; </p>
                                <br />
                                    <?php } ?>
                            </div>
                            
                                <?php View::newInstance()->_erase('items') ; ?>
                            <?php } ?>

                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

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