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

    $aCountries = __get('aCountries');
    //customize Head
    function customHead(){
        ?>
       <script type="text/javascript">
            $(document).ready(function(){
                // dialog delete
                $("#dialog-location-delete").dialog({
                    autoOpen: false,
                    modal: true,
                    title: '<?php echo osc_esc_js( __('Delete location') ); ?>'
                });
            });

            var base_url           = '<?php echo osc_admin_base_url(); ?>';
            var s_close            = '<?php echo osc_esc_js(_e('Close')); ?>';
            var s_view_more        = '<?php echo osc_esc_js(_e('View more')); ?>';
            var addText            = '<?php echo osc_esc_js(_e('Add')); ?>';
            var cancelText         = '<?php echo osc_esc_js(_e('Cancel')); ?>';
            var editText           = '<?php echo osc_esc_js(_e('Edit')); ?>';
            var editNewCountryText = '<?php echo osc_esc_js(__('Edit country')) ; ?>';
            var addNewCountryText  = '<?php echo osc_esc_js(__('Add new country')) ; ?>';
            var editNewRegionText  = '<?php echo osc_esc_js(__('Edit region')) ; ?>';
            var addNewRegionText   = '<?php echo osc_esc_js(__('Add new region')) ; ?>';
            var editNewCityText    = '<?php echo osc_esc_js(__('Edit city')) ; ?>';
            var addNewCityText     = '<?php echo osc_esc_js(__('Add new city')) ; ?>';

            // dialog delete function
            function delete_dialog(item_id, item_type) {
                $("#dialog-location-delete input[name='type']").attr('value', item_type);
                $("#dialog-location-delete input[name='id']").attr('value', item_id);
                $("#dialog-location-delete").dialog('open');
                return false;
            }
        </script>
        <script type="text/javascript" src="<?php echo osc_current_admin_theme_js_url('location.js') ; ?>"></script>
        <?php
    }
    osc_add_hook('admin_header','customHead');

    function addHelp(){
        echo '<h3>What does a red highlight mean?</h3>';
        echo '<p>This is where I would provide help to the user on how everything in my admin panel works. Formatted HTML works fine in here too.
    Red highlight means that the listing has been marked as spam.</p>';
    }
    osc_add_hook('help_box','addHelp');

    osc_add_hook('admin_page_header','customPageHeader');
    function customPageHeader(){ ?>
        <h1><?php _e('Settings') ; ?>
            <a href="#" class="btn ico ico-32 ico-help float-right"></a>
        </h1>
<?php
    }

    function customPageTitle($string) {
        return __('Locations');
    }
    osc_add_filter('admin_title', 'customPageTitle');
    osc_current_admin_theme_path('parts/header.php') ; ?>
<!-- container -->
<h1 class="render-title"><?php _e('Locations') ; ?></h1>
<?php osc_show_flash_message('admin') ; ?>
        </div>
    </div>
<!-- grid close -->
<!-- /settings form -->
<div id="d_add_country" class="lightbox_country location has-form-actions hide">
        <form action="<?php echo osc_admin_base_url(true); ?>" method="post" accept-charset="utf-8" id="d_add_country_form">
            <div><small id="c_code_error" class="hide"><?php _e('Country code should have two characters'); ?></small></div>
            <input type="hidden" name="page" value="settings" />
            <input type="hidden" name="action" value="locations" />
            <input type="hidden" name="type" value="add_country" />
            <input type="hidden" name="c_manual" value="1" />
            <label><?php _e('Country code'); ?>: </label><br />
            <input type="text" id="c_country" name="c_country" value="" /><br />
            <p>
                <label><?php _e('Country'); ?>: </label><br />
                <input type="text" id="country" name="country" value="" />
            </p>
             <div class="form-actions">
                <div class="wrapper">
                    <button class="btn btn-red close-dialog" ><?php echo osc_esc_html( __('Cancel') ) ; ?></button>
                    <button type="submit" class="btn btn-submit" ><?php echo osc_esc_html( __('Add country') ) ; ?></button>
                </div>
            </div>
        </form>
</div>
<!-- End form add country -->
<!-- Form edit country -->
<div id="d_edit_country" class="lightbox_country location has-form-actions hide">
        <form action="<?php echo osc_admin_base_url(true); ?>" method="post" accept-charset="utf-8" id="d_edit_country_form">
            <input type="hidden" name="page" value="settings" />
            <input type="hidden" name="action" value="locations" />
            <input type="hidden" name="type" value="edit_country" />
            <input type="hidden" name="country_code" value="" />
            <p>
                <label><?php _e('Country'); ?>: </label><br />
                <input type="text" id="e_country" name="e_country" value="" />
            </p>
            <div class="form-actions">
                <div class="wrapper">
                    <button class="btn btn-red close-dialog" ><?php echo osc_esc_html( __('Cancel') ) ; ?></button>
                    <button type="submit" class="btn btn-submit" ><?php echo osc_esc_html( __('Edit country') ) ; ?></button>
                </div>
            </div>
        </form>
</div>
<!-- End form edit country -->
<!-- Form add region -->
<div id="d_add_region" class="lightbox_country location has-form-actions hide">
    <div style="padding: 14px;">
        <form action="<?php echo osc_admin_base_url(true); ?>" method="post" accept-charset="utf-8" id="d_add_region_form">
            <input type="hidden" name="page" value="settings" />
            <input type="hidden" name="action" value="locations" />
            <input type="hidden" name="type" value="add_region" />
            <input type="hidden" name="country_c_parent" value="" />
            <input type="hidden" name="country_parent" value="" />
            <input type="hidden" name="r_manual" value="1" />
            <table>
                <tr>
                    <td><?php _e('Region'); ?>: </td>
                    <td><input type="text" id="region" name="region" value="" /></td>
                </tr>
            </table>
            <div class="form-actions">
                <div class="wrapper">
                    <button class="btn btn-red close-dialog" ><?php echo osc_esc_html( __('Cancel') ) ; ?></button>
                    <button type="submit" class="btn btn-submit" ><?php echo osc_esc_html( __('Add region') ) ; ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- End form add region -->
<!-- Form edit region -->
<div id="d_edit_region" class="lightbox_country location has-form-actions hide">
    <div style="padding: 14px;">
        <form action="<?php echo osc_admin_base_url(true); ?>" method="post" accept-charset="utf-8" id="d_edit_region_form">
            <input type="hidden" name="page" value="settings" />
            <input type="hidden" name="action" value="locations" />
            <input type="hidden" name="type" value="edit_region" />
            <input type="hidden" name="region_id" value="" />
            <table>
                <tr>
                    <td><?php _e('Region'); ?>: </td>
                    <td><input type="text" id="e_region" name="e_region" value="" /></td>
                </tr>
            </table>
            <div class="form-actions">
                <div class="wrapper">
                    <button class="btn btn-red close-dialog" ><?php echo osc_esc_html( __('Cancel') ) ; ?></button>
                    <button type="submit" class="btn btn-submit" ><?php echo osc_esc_html( __('Edit region') ) ; ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- End form edit region -->
<!-- Form edit city -->
<div id="d_add_city" class="lightbox_country location has-form-actions hide">
    <div style="padding: 14px;">
        <form action="<?php echo osc_admin_base_url(true); ?>" method="post" accept-charset="utf-8" id="d_add_city_form">
            <input type="hidden" name="page" value="settings" />
            <input type="hidden" name="action" value="locations" />
            <input type="hidden" name="type" value="add_city" />
            <input type="hidden" name="country_c_parent" value="" />
            <input type="hidden" name="country_parent" value="" />
            <input type="hidden" name="region_parent" value="" />
            <input type="hidden" name="ci_manual" value="1" />
            <table>
                <tr>
                    <td><?php _e('City'); ?>: </td>
                    <td><input type="text" id="city" name="city" value="" /></td>
                </tr>
            </table>
            <div class="form-actions">
                <div class="wrapper">
                    <button class="btn btn-red close-dialog" ><?php echo osc_esc_html( __('Cancel') ) ; ?></button>
                    <button type="submit" class="btn btn-submit" ><?php echo osc_esc_html( __('Add city') ) ; ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- End form add city -->
<!-- Form edit city -->
<div id="d_edit_city" class="lightbox_country location has-form-actions hide">
    <div style="padding: 14px;">
        <form action="<?php echo osc_admin_base_url(true); ?>" method="post" accept-charset="utf-8" id="d_edit_city_form">
            <input type="hidden" name="page" value="settings" />
            <input type="hidden" name="action" value="locations" />
            <input type="hidden" name="type" value="edit_city" />
            <input type="hidden" name="city_id" value="" />
            <table>
                <tr>
                    <td><?php _e('City'); ?>: </td>
                    <td><input type="text" id="e_city" name="e_city" value="" /></td>
                </tr>
            </table>
            <div class="form-actions">
                <div class="wrapper">
                    <button class="btn btn-red close-dialog" ><?php echo osc_esc_html( __('Cancel') ) ; ?></button>
                    <button type="submit" class="btn btn-submit" ><?php echo osc_esc_html( __('Edit city') ) ; ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php if(Params::getParam('country')!='' && Params::getParam('country_code')!='') { ?>
    <script type="text/javascript">
        <?php if(Params::getParam('country')!='' && Params::getParam('country_code')!='') { ?>
            show_region('<?php echo Params::getParam('country_code'); ?>', '<?php echo osc_esc_js(Params::getParam('country')); ?>');
            function hook_load_cities() {
            <?php if(Params::getParam('region')!='') { ?>
                show_city(<?php echo Params::getParam('region'); ?>);
            <?php }; ?>
            };
        <?php }; ?>
    </script>
<?php }; ?>
<!-- settings form -->
<div id="settings_form" class="locations">
<div class="grid-system">
    <div class="grid-row grid-first-row grid-33">
        <div class="row-wrapper">
            <div class="widget-box">
                <div class="widget-box-title"><h3><?php _e('Countries'); ?> <a id="b_new_country" class="btn float-right" href="javascript:void(0);"><?php _e('Add new'); ?></a></h3></div>
                <div class="widget-box-content">
                    <div id="l_countries">
                        <?php foreach( $aCountries as $country ) { ?>
                        <div>
                            <div class="float-left">
                                <div>
                                    <a class="close" onclick="return delete_dialog(\'' . $country['pk_c_code'] . '\', 'delete_country');" href="<?php echo osc_admin_base_url(true); ?>?page=settings&action=locations&type=delete_country&id=<?php echo $country['pk_c_code']; ?>">
                                        <img src="<?php echo osc_admin_base_url() ; ?>images/close.png" alt="<?php echo osc_esc_html(__('Close')); ?>" title="<?php echo osc_esc_html(__('Close')); ?>" />
                                    </a>
                                    <a class="edit" href="javascript:void(0);" style="padding-right: 15px;" onclick="edit_countries($(this));" data="<?php echo osc_esc_html($country['s_name']);?>" code="<?php echo $country['pk_c_code'];?>"><?php echo $country['s_name'] ; ?></a>
                                </div>
                            </div>
                            <div class="float-right">
                                <a class="view-more" href="javascript:void(0)" onclick="show_region('<?php echo $country['pk_c_code']; ?>', '<?php echo osc_esc_js($country['s_name']) ; ?>')"><?php _e('View more'); ?> &raquo;</a>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid-row grid-first-row grid-33">
        <div class="row-wrapper">
            <div class="widget-box">
                <div class="widget-box-title"><h3><?php _e('Regions') ; ?><a id="b_new_region" href="javascript:void(0);" class="btn float-right hide"><?php _e('Add new'); ?></a></h3></div>
                <div class="widget-box-content">
                    <div id="i_regions"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid-row grid-first-row grid-33">
        <div class="row-wrapper">
            <div class="widget-box">
                <div class="widget-box-title"><h3><?php _e('Cities') ; ?><a id="b_new_city" href="javascript:void(0);" class="btn float-right hide"><?php _e('Add new'); ?></a></h3></div>
                <div class="widget-box-content"><div id="i_cities"></div></div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <form id="dialog-location-delete" method="get" action="<?php echo osc_admin_base_url(true); ?>" id="display-filters" class="has-form-actions hide">
        <input type="hidden" name="page" value="settings" />
        <input type="hidden" name="action" value="locations" />
        <input type="hidden" name="type" value="" />
        <input type="hidden" name="id" value="" />
        <div class="form-horizontal">
            <div class="form-row">
                <?php _e('This action can not be undone. Items with this location associated will be deleted. Are you sure you want to continue?'); ?>
            </div>
            <div class="form-actions">
                <div class="wrapper">
                <a class="btn" href="javascript:void(0);" onclick="$('#dialog-location-delete').dialog('close');"><?php _e('Cancel'); ?></a>
                <input id="location-delete-submit" type="submit" value="<?php echo osc_esc_html( __('Delete') ); ?>" class="btn btn-red" />
                </div>
            </div>
        </div>
    </form>
<?php osc_current_admin_theme_path('parts/footer.php') ; ?>