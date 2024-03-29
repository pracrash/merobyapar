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
        <h1><?php _e('Listing') ; ?>
            <a href="<?php echo osc_admin_base_url(true) . '?page=settings&action=comments' ; ?>" class="btn ico ico-32 ico-engine float-right"><?php _e('Settings'); ?></a>
            <a href="#" class="btn ico ico-32 ico-help float-right"></a>
        </h1>
<?php
    }
    osc_add_hook('admin_page_header','customPageHeader');

    function customPageTitle($string) {
        return sprintf(__('Comments &raquo; %s'), $string);
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
                $("#dialog-comment-delete").dialog({
                    autoOpen: false,
                    modal: true
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
                $("#dialog-comment-delete input[name='id']").attr('value', item_id);
                $("#dialog-comment-delete").dialog('open');
                return false;
            }
        </script>
        <?php
    }
    osc_add_hook('admin_header','customHead');
    
    $aData = __get('aComments');

    osc_current_admin_theme_path( 'parts/header.php' ) ; ?>
<h2 class="render-title"><?php _e('Comments') ; ?></h2>
<div class="relative">
    <div id="listing-toolbar">
        <div class="float-right">
            <?php if(Params::getParam('showAll') == true) { ?>
            <a href="<?php echo osc_admin_base_url(true) . '?page=comments&showAll=off'; ?>" class="btn btn-red"><?php _e('Hidden comments');?></a>
            <?php } else { ?>
            <a href="<?php echo osc_admin_base_url(true) . '?page=comments'; ?>" class="btn btn-blue"><?php _e('All comments');?></a>
            <?php } ?>
        </div>
    </div>
    
    <form class="" id="datatablesForm" action="<?php echo osc_admin_base_url(true) ; ?>" method="post" data-dialog-open="false">
        <input type="hidden" name="page" value="comments" />
        <input type="hidden" name="action" value="bulk_actions" />
        <div id="bulk-actions">
            <label>
                <select id="bulk_actions" name="bulk_actions" class="select-box-extra">
                    <option value=""><?php _e('Bulk actions') ; ?></option>
                    <option value="delete_all" data-dialog-content="<?php printf(__('Are you sure you want to %s the selected comments?'), strtolower(__('Delete'))); ?>"><?php _e('Delete') ; ?></option>
                    <option value="activate_all" data-dialog-content="<?php printf(__('Are you sure you want to %s the selected comments?'), strtolower(__('Activate'))); ?>"><?php _e('Activate') ; ?></option>
                    <option value="deactivate_all" data-dialog-content="<?php printf(__('Are you sure you want to %s the selected comments?'), strtolower(__('Deactivate'))); ?>"><?php _e('Deactivate') ; ?></option>
                    <option value="disable_all" data-dialog-content="<?php printf(__('Are you sure you want to %s the selected comments?'), strtolower(__('Block'))); ?>"><?php _e('Block') ; ?></option>
                    <option value="enable_all" data-dialog-content="<?php printf(__('Are you sure you want to %s the selected comments?'), strtolower(__('Unblock'))); ?>"><?php _e('Unblock') ; ?></option>
                </select> <input type="submit" id="bulk_apply" class="btn" value="<?php echo osc_esc_html( __('Apply') ) ; ?>" />
            </label>
        </div>
        <div class="table-contains-actions">
            <table class="table" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th class="col-bulkactions"><input id="check_all" type="checkbox" /></th>
                        <th><?php _e('Author') ; ?></th>
                        <th><?php _e('Comment') ; ?></th>
                        <th class="col-date"><?php _e('Date') ; ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php if(count($aData['aaData'])>0) : ?>
                <?php foreach( $aData['aaData'] as $key => $array) : ?>
                    <?php 
                    $aC = $aData['aaObject'][$key]; 
                    $class = ''; 
                    if(!$aC['b_enabled'] || !$aC['b_active'] || $aC['b_spam']) $class = 'status-spam'; 
                    ?>
                    <tr class="<?php echo $class; ?>">
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
                <?php endforeach;?>
                <?php else : ?>
                    <tr>
                        <td colspan="4" class="text-center">
                        <p><?php _e('No data available in table') ; ?></p>
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
            <div id="table-row-actions"></div> <!-- used for table actions -->
        </div>
    </form>
</div>
<?php 
    function showingResults(){
        $aData = __get('aComments');
        echo '<ul class="showing-results"><li><span>'.osc_pagination_showing((Params::getParam('iPage')-1)*$aData['iDisplayLength']+1, ((Params::getParam('iPage')-1)*$aData['iDisplayLength'])+count($aData['aaData']), $aData['iTotalDisplayRecords'], $aData['iTotalRecords']).'</span></li></ul>' ;
    }
    osc_add_hook('before_show_pagination_admin','showingResults');
    osc_show_pagination_admin($aData);
?>
<form id="dialog-comment-delete" method="get" action="<?php echo osc_admin_base_url(true); ?>" id="display-filters" class="has-form-actions hide" title="<?php echo osc_esc_html(__('Delete comment')); ?>">
    <input type="hidden" name="page" value="comments" />
    <input type="hidden" name="action" value="delete" />
    <input type="hidden" name="id" value="" />
    <div class="form-horizontal">
        <div class="form-row">
            <?php _e('Are you sure you want to delete this comment?'); ?>
        </div>
        <div class="form-actions">
            <div class="wrapper">
            <a class="btn" href="javascript:void(0);" onclick="$('#dialog-comment-delete').dialog('close');"><?php _e('Cancel'); ?></a>
            <input id="comment-delete-submit" type="submit" value="<?php echo osc_esc_html( __('Delete') ); ?>" class="btn btn-red" />
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
<?php osc_current_admin_theme_path( 'parts/footer.php' ); ?>