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

    function addHelp(){
        echo '<h3>What does a red highlight mean?</h3>';
        echo '<p>This is where I would provide help to the user on how everything in my admin panel works. Formatted HTML works fine in here too.
    Red highlight means that the listing has been marked as spam.</p>';
    }
    osc_add_hook('help_box','addHelp');

    function customPageHeader(){ ?>
        <h1><?php _e('Listings') ; ?>
            <a href="#" class="btn ico ico-32 ico-help float-right"></a>
       </h1>
<?php
    }
    osc_add_hook('admin_page_header','customPageHeader');

    function customPageTitle($string) {
        return sprintf(__('Reported listings &raquo; %s'), $string);
    }
    osc_add_filter('admin_title', 'customPageTitle');

    //customize Head
    function customHead() { ?>
        <script type="text/javascript">
            // autocomplete users
            $(document).ready(function(){
                // check_all bulkactions
                $("#check_all").change(function(){
                    var isChecked = $(this+':checked').length;
                    $('.col-bulkactions input').each( function() {
                        if( isChecked == 1 ) {
                            this.checked = true;
                        } else {
                            this.checked = false;
                        }
                    });
                });
                
                // dialog delete
                $("#dialog-item-delete").dialog({
                    autoOpen: false,
                    modal: true,
                    title: '<?php echo osc_esc_js( __('Delete listing') ); ?>'
                });

                // dialog bulk actions
                $("#dialog-bulk-actions").dialog({
                    autoOpen: false,
                    modal: true
                });
                $("#bulk-actions-submit").click(function() {
                    $("#datatablesForm").submit();
                });
                $("#bulk-actions-cancel").click(function() {
                    $("#datatablesForm").attr('data-dialog-open', 'false');
                    $('#dialog-bulk-actions').dialog('close');
                });
                // dialog bulk actions function
                $("#datatablesForm").submit(function() {
                    if( $("#bulk_actions option:selected").val() == "" ) {
                        return false;
                    }

                    if( $("#datatablesForm").attr('data-dialog-open') == "true" ) {
                        return true;
                    }

                    $("#dialog-bulk-actions .form-row").html($("#bulk_actions option:selected").attr('data-dialog-content'));
                    $("#bulk-actions-submit").html($("#bulk_actions option:selected").text());
                    $("#datatablesForm").attr('data-dialog-open', 'true');
                    $("#dialog-bulk-actions").dialog('open');
                    return false;
                });
                // /dialog bulk actions
            });
            
            // dialog delete function
            function delete_dialog(item_id) {
                $("#dialog-item-delete input[name='id[]']").attr('value', item_id);
                $("#dialog-item-delete").dialog('open');
                return false;
            }
        </script>
        <?php
    }
    osc_add_hook('admin_header','customHead');

    $aData      = __get('aItems') ;
    $url_spam   = __get('url_spam') ;
    $url_bad    = __get('url_bad') ;
    $url_rep    = __get('url_rep') ;
    $url_off    = __get('url_off') ;
    $url_exp    = __get('url_exp') ;
    $url_date   = __get('url_date') ;

    $sort       = Params::getParam('sort');
    $direction  = Params::getParam('direction');

    osc_current_admin_theme_path( 'parts/header.php' ) ; ?>
<h2 class="render-title"><?php _e('Reported listings') ; ?></h2>
<div class="relative">
    <div id="listing-toolbar">
        <div class="float-right">
            <form method="get" action="<?php echo osc_admin_base_url(true); ?>"  class="inline select-items-per-page">
                <?php foreach( Params::getParamsAsArray('get') as $key => $value ) { ?>
                <?php if( $key != 'iDisplayLength' ) { ?>
                <input type="hidden" name="<?php echo $key; ?>" value="<?php echo osc_esc_html($value); ?>" />
                <?php } } ?>
                <select name="iDisplayLength" class="select-box-extra select-box-medium float-left" onchange="this.form.submit();" >
                    <option value="10"><?php printf(__('%d Listings'), 10); ?></option>
                    <option value="25" <?php if( Params::getParam('iDisplayLength') == 25 ) echo 'selected'; ?> ><?php printf(__('%d Listings'), 25); ?></option>
                    <option value="50" <?php if( Params::getParam('iDisplayLength') == 50 ) echo 'selected'; ?> ><?php printf(__('%d Listings'), 50); ?></option>
                    <option value="100" <?php if( Params::getParam('iDisplayLength') == 100 ) echo 'selected'; ?> ><?php printf(__('%d Listings'), 100); ?></option>
                </select>
            </form>
            <?php if($sort!='date') { ?>
            <a id="btn-reset-filters" class="btn btn-red" href="<?php echo osc_admin_base_url(true); ?>?page=items&action=items_reported"><?php _e('Reset filters'); ?></a>
            <?php } ?>
        </div>
    </div>
    <form class="" id="datatablesForm" action="<?php echo osc_admin_base_url(true) ; ?>" method="post">
        <input type="hidden" name="page" value="items" />
        <input type="hidden" name="action" value="bulk_actions" />
        <div id="bulk-actions">
            <label>
                <select id="bulk_actions" name="bulk_actions" class="select-box-extra">
                    <option value=""><?php _e('Bulk actions') ; ?></option>
                    <option value="delete_all" data-dialog-content="<?php printf(__('Are you sure you want to %s the selected items?'), strtolower(__('Delete'))); ?>"><?php _e('Delete') ; ?></option>
                    <option value="clear_all" data-dialog-content="<?php _e('Are you sure you want to clear all the reportings of the selected items?'); ?>"><?php _e('Clear All') ; ?></option>
                    <option value="clear_spam_all" data-dialog-content="<?php _e('Are you sure you want to clear the spam reportings of the selected items?'); ?>"><?php _e('Clear Spam') ; ?></option>
                    <option value="clear_bad_all" data-dialog-content="<?php _e('Are you sure you want to clear the misclassified reportings of the selected items?'); ?>"><?php _e('Clear Missclassified') ; ?></option>
                    <option value="clear_dupl_all" data-dialog-content="<?php _e('Are you sure you want to clear the duplicated reportings of the selected items?'); ?>"><?php _e('Clear Duplicated') ; ?></option>
                    <option value="clear_expi_all" data-dialog-content="<?php _e('Are you sure you want to clear the expired reportings of the selected items?'); ?>"><?php _e('Clear Expired') ; ?></option>
                    <option value="clear_offe_all" data-dialog-content="<?php _e('Are you sure you want to clear the offensive reportings of the selected items?'); ?>"><?php _e('Clear Offensive') ; ?></option>
                </select> <input type="submit" id="bulk_apply" class="btn" value="<?php echo osc_esc_html( __('Apply') ) ; ?>" />
            </label>
        </div>
        <div class="table-contains-actions">
            <table class="table" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th class="col-bulkactions"><input id="check_all" type="checkbox" /></th>
                        <th class="col-title"><?php _e('Title') ; ?></th>
                        <th><?php _e('User') ; ?></th>
                        <th class="<?php if($sort=='spam'){ if($direction=='desc'){ echo 'sorting_desc'; } else { echo 'sorting_asc'; } } ?>">
                            <a id="order_spam" href="<?php echo $url_spam; ?>"><?php _e('Spam') ; ?></a>
                        </th>
                        <th class="<?php if($sort=='bad'){ if($direction=='desc'){ echo 'sorting_desc'; } else { echo 'sorting_asc'; } } ?>">
                            <a id="order_bad" href="<?php echo $url_bad; ?>"><?php _e('Misclassified') ; ?>
                        </th>
                        <th class="<?php if($sort=='rep'){ if($direction=='desc'){ echo 'sorting_desc'; } else { echo 'sorting_asc'; } } ?>">
                            <a id="order_rep" href="<?php echo $url_rep; ?>"><?php _e('Duplicated') ; ?>
                        </th>
                        <th class="<?php if($sort=='exp'){ if($direction=='desc'){ echo 'sorting_desc'; } else { echo 'sorting_asc'; } } ?>">
                            <a id="order_exp" href="<?php echo $url_exp; ?>"><?php _e('Expired') ; ?>
                        </th>
                        <th class="<?php if($sort=='off'){ if($direction=='desc'){ echo 'sorting_desc'; } else { echo 'sorting_asc'; } } ?>">
                            <a id="order_off" href="<?php echo $url_off; ?>"><?php _e('Offensive') ; ?>
                        </th>
                        <th class="col-date <?php if($sort=='date'){ if($direction=='desc'){ echo 'sorting_desc'; } else { echo 'sorting_asc'; } } ?>">
                            <a id="order_date" href="<?php echo $url_date; ?>"><?php _e('Date') ; ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php if(count($aData['aaData'])>0) { ?>
                <?php foreach( $aData['aaData'] as $array) { ?>
                    <tr>
                    <?php foreach($array as $key => $value) { ?>
                        <?php if( $key==0 ) { ?>
                        <td class="col-bulkactions">
                        <?php } else { ?>
                        <td>
                        <?php } ?>
                        <?php echo $value; ?>
                        </td>
                    <?php } ?>
                    </tr>
                <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="9" class="text-center">
                        <p><?php _e('No data available in table') ; ?></p>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <div id="table-row-actions"></div> <!-- used for table actions -->
        </div>
    </form>
</div>
<?php 
    osc_show_pagination_admin($aData);
?>
<form id="dialog-item-delete" method="get" action="<?php echo osc_admin_base_url(true); ?>" id="display-filters" class="has-form-actions hide">
    <input type="hidden" name="page" value="items" />
    <input type="hidden" name="action" value="delete" />
    <input type="hidden" name="id[]" value="" />
    <div class="form-horizontal">
        <div class="form-row">
            <?php _e('Are you sure you want to delete this listing?'); ?>
        </div>
        <div class="form-actions">
            <div class="wrapper">
            <a class="btn" href="javascript:void(0);" onclick="$('#dialog-item-delete').dialog('close');"><?php _e('Cancel'); ?></a>
            <input id="item-delete-submit" type="submit" value="<?php echo osc_esc_html( __('Delete') ); ?>" class="btn btn-red" />
            </div>
        </div>
    </div>
</form>
<div id="dialog-bulk-actions" title="<?php _e('Bulk actions'); ?>" class="has-form-actions hide">
    <div class="form-horizontal">
        <div class="form-row"></div>
        <div class="form-actions">
            <div class="wrapper">
                <a id="bulk-actions-cancel" class="btn" href="javascript:void(0);"><?php _e('Cancel'); ?></a>
                <a id="bulk-actions-submit" href="javascript:void(0);" class="btn btn-red" ><?php echo osc_esc_html( __('Delete') ); ?></a>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
<?php osc_current_admin_theme_path( 'parts/footer.php' ) ; ?>