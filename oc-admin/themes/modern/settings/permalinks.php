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

    //customize Head
    function customHead(){
        echo '<script type="text/javascript" src="'.osc_current_admin_theme_js_url('jquery.validate.min.js').'"></script>';
        ?>
<script type="text/javascript">
            $(document).ready(function(){
                // Code for form validation
                $("form[name=permalinks_form]").validate({
                    rules: {
                        rewrite_item_url: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_page_url: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_cat_url: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_search_url: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_search_country: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_search_region: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_search_city: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_search_city_area: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_search_category: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_search_user: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_search_pattern: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_contact: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_feed: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_language: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_item_mark: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_item_send_friend: {s
                            required: true,
                            minlength: 1
                        },
						//added by shakeelstha
						/*rewrite_watchlist: {
                            required: true,
                            minlength: 1
                        }, */
                        rewrite_item_contact: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_item_activate: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_item_edit: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_item_delete: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_item_resource_delete: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_user_login: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_user_dashboard: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_user_logout: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_user_register: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_user_activate: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_user_activate_alert: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_user_profile: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_user_items: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_user_alerts: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_user_recover: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_user_forgot: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_user_change_password: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_user_change_email: {
                            required: true,
                            minlength: 1
                        },
                        rewrite_user_change_email_confirm: {
                            required: true,
                            minlength: 1
                        }
                    },
                    messages: {
                        rewrite_item_url: {
                            required: "<?php echo osc_esc_js( __("Listings url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Listings url: this field is required")); ?>."
                        },
                        rewrite_page_url: {
                            required: "<?php echo osc_esc_js( __("Page url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Page url: this field is required")); ?>."
                        },
                        rewrite_cat_url: {
                            required: "<?php echo osc_esc_js( __("Categories url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Categories url: this field is required")); ?>."
                        },
                        rewrite_search_url: {
                            required: "<?php echo osc_esc_js( __("Search url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Search url: this field is required")); ?>."
                        },
                        rewrite_search_country: {
                            required: "<?php echo osc_esc_js( __("Search country: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Search country: this field is required")); ?>."
                        },
                        rewrite_search_region: {
                            required: "<?php echo osc_esc_js( __("Search region: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Search region: this field is required")); ?>."
                        },
                        rewrite_search_city: {
                            required: "<?php echo osc_esc_js( __("Search city: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Search city: this field is required")); ?>."
                        },
                        rewrite_search_city_area: {
                            required: "<?php echo osc_esc_js( __("Search city area: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Search city area: this field is required")); ?>."
                        },
                        rewrite_search_category: {
                            required: "<?php echo osc_esc_js( __("Search category: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Search category: this field is required")); ?>."
                        },
                        rewrite_search_user: {
                            required: "<?php echo osc_esc_js( __("Search user: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Search user: this field is required")); ?>."
                        },
                        rewrite_search_pattern: {
                            required: "<?php echo osc_esc_js( __("Search pattern: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Search pattern: this field is required")); ?>."
                        },
                        rewrite_contact: {
                            required: "<?php echo osc_esc_js( __("Contact url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Contact url: this field is required")); ?>."
                        },
                        rewrite_feed: {
                            required: "<?php echo osc_esc_js( __("Feed url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Feed url: this field is required")); ?>."
                        },
                        rewrite_language: {
                            required: "<?php echo osc_esc_js( __("Language url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Language url: this field is required")); ?>."
                        },
                        rewrite_item_mark: {
                            required: "<?php echo osc_esc_js( __("Listing mark url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Listing mark url: this field is required")); ?>."
                        },
                        rewrite_item_send_friend: {
                            required: "<?php echo osc_esc_js( __("Listing send friend url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Listing send friend url: this field is required")); ?>."
                        },
						/*rewrite_watchlist: {//added by shakeelstha on 20 july 2012
                            required: "<?php echo osc_esc_js( __("Watchlist url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Watchlist url: this field is required")); ?>."
                        }, */
                        rewrite_item_contact: {
                            required: "<?php echo osc_esc_js( __("Listing contact url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Listing contact url: this field is required")); ?>."
                        },
                        rewrite_item_new: {
                            required: "<?php echo osc_esc_js( __("New listing url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("New listing url: this field is required")); ?>."
                        },
                        rewrite_item_activate: {
                            required: "<?php echo osc_esc_js( __("Activate listing url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Activate listing url: this field is required")); ?>."
                        },
                        rewrite_item_edit: {
                            required: "<?php echo osc_esc_js( __("Edit listing url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Edit listing url: this field is required")); ?>."
                        },
                        rewrite_item_delete: {
                            required: "<?php echo osc_esc_js( __("Delete listing url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Delete listing url: this field is required")); ?>."
                        },
                        rewrite_item_resource_delete: {
                            required: "<?php echo osc_esc_js( __("Delete listing resource url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Delete listing resource url: this field is required")); ?>."
                        },
                        rewrite_user_login: {
                            required: "<?php echo osc_esc_js( __("Login url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Login url: this field is required")); ?>."
                        },
                        rewrite_user_dashboard: {
                            required: "<?php echo osc_esc_js( __("User dashboard url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("User dashboard url: this field is required")); ?>."
                        },
                        rewrite_user_logout: {
                            required: "<?php echo osc_esc_js( __("Logout url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Logout url: this field is required")); ?>."
                        },
                        rewrite_user_register: {
                            required: "<?php echo osc_esc_js( __("User register url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("User register url: this field is required")); ?>."
                        },
                        rewrite_user_activate: {
                            required: "<?php echo osc_esc_js( __("Activate user url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Activate user url: this field is required")); ?>."
                        },
                        rewrite_user_activate_alert: {
                            required: "<?php echo osc_esc_js( __("Activate alert url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Activate aler url: this field is required")); ?>."
                        },
                        rewrite_user_profile: {
                            required: "<?php echo osc_esc_js( __("User profile url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("User profile url: this field is required")); ?>."
                        },
                        rewrite_user_items: {
                            required: "<?php echo osc_esc_js( __("User listings url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("User listings url: this field is required")); ?>."
                        },
                        rewrite_user_alerts: {
                            required: "<?php echo osc_esc_js( __("User alerts url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("User alerts url: this field is required")); ?>."
                        },
                        rewrite_user_recover: {
                            required: "<?php echo osc_esc_js( __("Recover user url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Recover user url: this field is required")); ?>."
                        },
                        rewrite_user_forgot: {
                            required: "<?php echo osc_esc_js( __("User forgot url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("User forgot url: this field is required")); ?>."
                        },
                        rewrite_user_change_password: {
                            required: "<?php echo osc_esc_js( __("Change password url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Change password url: this field is required")); ?>."
                        },
                        rewrite_user_change_email: {
                            required: "<?php echo osc_esc_js( __("Change email url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Change email url: this field is required")); ?>."
                        },
                        rewrite_user_change_email_confirm: {
                            required: "<?php echo osc_esc_js( __("Change email confirm url: this field is required")); ?>.",
                            minlength: "<?php echo osc_esc_js( __("Change email confirm url: this field is required")); ?>."
                        }
                    },
                    wrapper: "li",
                    errorLabelContainer: "#error_list",
                    invalidHandler: function(form, validator) {
                        $('html,body').animate({ scrollTop: $('h1').offset().top }, { duration: 250, easing: 'swing'});
                    }
                });
            });

            function showhide() {
                $("#inner_rules").toggle();
                if($("#show_hide a").html()=='<?php _e('Show rules'); ?>') {
                    $("#show_hide a").html('<?php _e('Hide rules'); ?>');
                    resetLayout();
                } else {
                    $("#show_hide a").html('<?php _e('Show rules'); ?>')
                }
            }

            $(function() {
                $("#rewrite_enabled").click(function(){
                    $("#custom_rules").toggle();
                });
            });
        </script>
        <?php
    }
    osc_add_hook('admin_header','customHead');

    function render_offset(){
        return 'row-offset';
    }
    osc_add_hook('admin_page_header','customPageHeader');

    function addHelp(){
        echo '<h3>What does a red highlight mean?</h3>';
        echo '<p>This is where I would provide help to the user on how everything in my admin panel works. Formatted HTML works fine in here too.
    Red highlight means that the listing has been marked as spam.</p>';
    }
    osc_add_hook('help_box','addHelp');

    function customPageHeader(){ ?>
        <h1><?php _e('Settings') ; ?>
            <a href="#" class="btn ico ico-32 ico-help float-right"></a>
        </h1>
    <?php
    }

    function customPageTitle($string) {
        return sprintf(__('Permalinks &raquo; %s'), $string);
    }
    osc_add_filter('admin_title', 'customPageTitle');

    osc_current_admin_theme_path( 'parts/header.php' ) ; ?>
<div id="mail-setting">
    <!-- settings form -->
                    <div id="mail-settings">
                        <h2 class="render-title"><?php _e('Permalinks') ; ?></h2>
                        <?php //_e('By default OSClass uses web URLs which have question marks and lots of numbers in them. However, OSClass offers you friendly urls. This can improve the aesthetics, usability, and forward-compatibility of your links'); ?>
                        <ul id="error_list"></ul>
                        <form name="settings_form" action="<?php echo osc_admin_base_url(true) ; ?>" method="post">
                            <input type="hidden" name="page" value="settings" />
                            <input type="hidden" name="action" value="permalinks_post" />
                            <fieldset>
                            <div class="form-horizontal">
                            <div class="form-row">
                                <div class="form-label"><?php _e('Enable friendly urls'); ?></div>
                                <div class="form-controls">
                                    <div class="form-label-checkbox"><input type="checkbox" <?php echo ( osc_rewrite_enabled() ? 'checked="checked"' : '' ) ; ?> name="rewrite_enabled" id="rewrite_enabled" value="1" />
                                    </div>
                                </div>
                            </div>
                                
                            <div id="custom_rules" <?php if( !osc_rewrite_enabled() ) { echo 'class="hide"'; } ?>>
                                <div id="show_hide" ><a href="#" onclick="javascript:showhide();"><?php _e('Show rules'); ?></a></div>
                                <div id="inner_rules" class="hide">


                                    <div class="form-row">
                                        <div class="form-label"><?php _e('Listing URL:') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_item_url" value="<?php echo osc_esc_html(osc_get_preference('rewrite_item_url')); ?>" />
                                            <div class="help-box">
                                                <?php echo sprintf(__('Accepted keywords: %s'), '{ITEM_ID},{ITEM_TITLE},{CATEGORIES}') ; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('Page URL:') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_page_url" value="<?php echo osc_esc_html(osc_get_preference('rewrite_page_url')); ?>" />
                                            <div class="help-box">
                                                <?php echo sprintf(__('Accepted keywords: %s'), '{PAGE_ID}, {PAGE_SLUG}') ; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('Category URL:') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_cat_url" value="<?php echo osc_esc_html(osc_get_preference('rewrite_cat_url')); ?>" />
                                            <div class="help-box">
                                                <?php echo sprintf(__('Accepted keywords: %s'), '{CATEGORY_ID},{CATEGORY_NAME},{CATEGORIES}') ; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('Search URL:') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_search_url" value="<?php echo osc_esc_html(osc_get_preference('rewrite_search_url')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('Search keyword country') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_search_country" value="<?php echo osc_esc_html(osc_get_preference('rewrite_search_country')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('Search keyword region') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_search_region" value="<?php echo osc_esc_html(osc_get_preference('rewrite_search_region')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('Search keyword city') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_search_city" value="<?php echo osc_esc_html(osc_get_preference('rewrite_search_city')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('Search keyword city area') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_search_city_area" value="<?php echo osc_esc_html(osc_get_preference('rewrite_search_city_area')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('Search keyword category') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_search_category" value="<?php echo osc_esc_html(osc_get_preference('rewrite_search_category')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('Search keyword user') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_search_user" value="<?php echo osc_esc_html(osc_get_preference('rewrite_search_user')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('Search keyword pattern') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_search_pattern" value="<?php echo osc_esc_html(osc_get_preference('rewrite_search_pattern')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('Contact') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_contact" value="<?php echo osc_esc_html(osc_get_preference('rewrite_contact')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('Feed') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_feed" value="<?php echo osc_esc_html(osc_get_preference('rewrite_feed')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('Language') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_language" value="<?php echo osc_esc_html(osc_get_preference('rewrite_language')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('Listing mark') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_item_mark" value="<?php echo osc_esc_html(osc_get_preference('rewrite_item_mark')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('Listing send friend') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_item_send_friend" value="<?php echo osc_esc_html(osc_get_preference('rewrite_item_send_friend')); ?>" />
                                        </div>
                                    </div>
									<!--added by shakeelstha on 20 july 2012-->
									<!-- <div class="form-row">
                                        <div class="form-label"><?php _e('Watch List') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_watchlist" value="<?php echo osc_esc_html(osc_get_preference('rewrite_watchlist')); ?>" />
                                        </div>
                                    </div> -->
									<!---------------------------------------->
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('Listing contact') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_item_contact" value="<?php echo osc_esc_html(osc_get_preference('rewrite_item_contact')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('Listing new') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_item_new" value="<?php echo osc_esc_html(osc_get_preference('rewrite_item_new')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('Listing activate') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_item_activate" value="<?php echo osc_esc_html(osc_get_preference('rewrite_item_activate')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('Listing edit') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_item_edit" value="<?php echo osc_esc_html(osc_get_preference('rewrite_item_edit')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('Listing delete') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_item_delete" value="<?php echo osc_esc_html(osc_get_preference('rewrite_item_delete')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('Listing resource delete') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_item_resource_delete" value="<?php echo osc_esc_html(osc_get_preference('rewrite_item_resource_delete')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('User login') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_user_login" value="<?php echo osc_esc_html(osc_get_preference('rewrite_user_login')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('User dashboard') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_user_dashboard" value="<?php echo osc_esc_html(osc_get_preference('rewrite_user_dashboard')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('User logout') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_user_logout" value="<?php echo osc_esc_html(osc_get_preference('rewrite_user_logout')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('User register') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_user_register" value="<?php echo osc_esc_html(osc_get_preference('rewrite_user_register')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('User activate') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_user_activate" value="<?php echo osc_esc_html(osc_get_preference('rewrite_user_activate')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('User activate alert') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_user_activate_alert" value="<?php echo osc_esc_html(osc_get_preference('rewrite_user_activate_alert')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('User profile') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_user_profile" value="<?php echo osc_esc_html(osc_get_preference('rewrite_user_profile')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('User listings') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_user_items" value="<?php echo osc_esc_html(osc_get_preference('rewrite_user_items')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('User alerts') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_user_alerts" value="<?php echo osc_esc_html(osc_get_preference('rewrite_user_alerts')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('User recover') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_user_recover" value="<?php echo osc_esc_html(osc_get_preference('rewrite_user_recover')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('User forgot') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_user_forgot" value="<?php echo osc_esc_html(osc_get_preference('rewrite_user_forgot')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('User change password') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_user_change_password" value="<?php echo osc_esc_html(osc_get_preference('rewrite_user_change_password')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('User change email') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_user_change_email" value="<?php echo osc_esc_html(osc_get_preference('rewrite_user_change_email')); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label"><?php _e('User change email confirm') ; ?></div>
                                        <div class="form-controls">
                                            <input type="text" class="input-large" name="rewrite_user_change_email_confirm" value="<?php echo osc_esc_html(osc_get_preference('rewrite_user_change_email_confirm')); ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" id="save_changes" value="<?php echo osc_esc_html( __('Save changes') ) ; ?>" class="btn btn-submit" />
                            </div>
                        </div>
                        </fieldset>
                    </form>
                </div>
                <!-- /settings form -->
</div>
<?php osc_current_admin_theme_path( 'parts/footer.php' ) ; ?>