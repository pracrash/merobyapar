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

    $categories = __get('categories');

    function addHelp(){
        echo '<h3>What does a red highlight mean?</h3>';
        echo '<p>This is where I would provide help to the user on how everything in my admin panel works. Formatted HTML works fine in here too.
    Red highlight means that the listing has been marked as spam.</p>';
    }
    osc_add_hook('help_box','addHelp');

    function customPageHeader() { ?>
        <h1><?php _e('Categories'); ?>
            <a href="#" class="btn ico ico-32 ico-help float-right"></a>
            <a href="<?php echo osc_admin_base_url(true) ; ?>?page=categories&amp;action=add_post_default" class="btn btn-green ico ico-32 ico-add-white float-right"><?php _e('Add'); ?></a>
    </h1>
<?php
    }
    osc_add_hook('admin_page_header','customPageHeader');

    function customPageTitle($string) {
        return sprintf(__('Categories &raquo; %s'), $string);
    }
    osc_add_filter('admin_title', 'customPageTitle');

    //customize Head
    function customHead() { ?>
        <script type="text/javascript" src="<?php echo osc_current_admin_theme_url('js/jquery.ui.nestedSortable.js') ; ?>"></script>
        <script type="text/javascript" src="<?php echo osc_current_admin_theme_url('js/tabber-minimized.js') ; ?>"></script>
        <script type="text/javascript">
            document.write('<style type="text/css">.tabber{ display:none ; }</style>');
        </script>
        <style>
            .placeholder {
                background-color: #cfcfcf;
            }
            .footest .category_div {
                opacity: 0.8;
            }
            .list-categories li {
                opacity: 1 !important;
            }
            .category_div {
                background: #ffffff;
            }
            .alert-custom {
                background-color: #FDF5D9;
                border-bottom: 1px solid #EEDC94;
                color: #404040;
            }
            .cat-hover{
                background-color:#fffccc !important;
                background:#fffccc;
            }
        </style>
        <script type="text/javascript">
            $(function() {
                $('.category_div').live('mouseenter',function(){
                    $(this).addClass('cat-hover');
                }).live('mouseleave',function(){
                    $(this).removeClass('cat-hover');
                });
                var list_original = '' ;

                $('.sortable').nestedSortable({
                    disableNesting: 'no-nest',
                    forcePlaceholderSize: true,
                    handle: '.handle',
                    helper: 'clone',
                    listType: 'ul',
                    items: 'li',
                    maxLevels: 2,
                    opacity: .6,
                    placeholder: 'placeholder',
                    revert: 250,
                    tabSize: 25,
                    tolerance: 'pointer',
                    toleranceElement: '> div',
                    create: function(event, ui) {
                    },
                    start: function(event, ui) { 
                        list_original = $('.sortable').nestedSortable('serialize') ;
                        $(ui.helper).addClass('footest');
                        $(ui.helper).prepend("<div style='opacity: 1 !important; padding:5px;' class='alert-custom'><?php _e('Note: You need to expand the category if you want to make it a subcategory.'); ?></div>");
                    },
                    stop: function(event, ui) { 
                        var list = '' ;
                        list = $('.sortable').nestedSortable('serialize') ;
                        var array_list = $('.sortable').nestedSortable('toArray') ;
                        var l = array_list.length ;
                        for(var k = 0; k < l; k++ ) {
                            if( array_list[k].item_id == $(ui.item).find('div').attr('category_id') ) {
                                if( array_list[k].parent_id == 'root' ) {
                                    $(ui.item).closest('.toggle').show() ;
                                }
                                break ;
                            }
                        }
                        if( !$(ui.item).parent().hasClass('sortable') ) {
                            $(ui.item).parent().addClass('subcategory') ;
                        }
                        if(list_original != list) {
                            $.ajax({
                                url: "<?php echo osc_admin_base_url(true) . "?page=ajax&action=categories_order&" ; ?>" + list,
                                context: document.body,
                                success: function(res){
                                    var ret = eval( "(" + res + ")") ;
                                    var message = "" ;
                                    if( ret.error ) {
                                        $(".jsMessage p").attr('class', 'error') ;
                                        message += ret.error ;
                                    }
                                    if( ret.ok ){
                                        $(".jsMessage p").attr('class', 'ok') ;
                                        message += ret.ok ;
                                    }

                                    $(".jsMessage").show() ;
                                    $(".jsMessage p").html(message) ;
                                },
                                error: function(){
                                    $(".jsMessage").fadeIn("fast") ;
                                    $(".jsMessage p").attr('class', '') ;
                                    $(".jsMessage p").html("<?php _e('Ajax error, try again.') ; ?>") ;
                                }
                            }) ;

                            list_original = list ;
                        }
                    }
                }) ;

                $(".toggle").bind("click", function(e) {
                    var list = $(this).parents('li').find('ul');
                    var li   = $(this).closest('li');
                    if( $(this).hasClass('status-collapsed') ) {
                        $(li).removeClass('no-nest');
                        $(list).show();
                        $(this).removeClass('status-collapsed').addClass('status-expanded');
                        $(this).html('-');
                    } else {
                        $(li).addClass('no-nest');
                        $(list).hide();
                        $(this).removeClass('status-expanded').addClass('status-collapsed');
                        $(this).html('+');
                    }
                }) ;

                // dialog delete
                $("#dialog-delete-category").dialog({
                    autoOpen: false,
                    modal: true
                });
                $("#category-delete-submit").click(function() {
                    var id  = $("#dialog-delete-category").attr('data-category-id');
                    var url  = '<?php echo osc_admin_base_url(true); ?>?page=ajax&action=delete_category&id=' + id ;

                    $.ajax({
                        url: url,
                        context: document.body,
                        success: function(res) {
                            var ret = eval( "(" + res + ")") ;
                            var message = "" ;
                            if( ret.error ) {
                                message += ret.error ;
                                $(".jsMessage p").attr('class', 'error') ;
                            }
                            if( ret.ok ) {
                                message += ret.ok;
                                $(".jsMessage p").attr('class', 'ok') ;

                                $('#list_'+id).fadeOut("slow") ;
                                $('#list_'+id).remove() ;
                            }

                            $(".jsMessage").show() ;
                            $(".jsMessage p").html(message) ;
                        },
                        error: function() {
                            $(".jsMessage").show() ;
                            $(".jsMessage p").attr('class', '') ;
                            $(".jsMessage p").html("<?php _e('Ajax error, try again.'); ?>") ;
                        }
                    });
                    $('#dialog-delete-category').dialog('close');
                    $('body,html').animate({
                        scrollTop: 0
                    }, 500);
                    return false;
                });
            });

            list_original = $('.sortable').nestedSortable('serialize') ;

            function show_iframe(class_name, id) {
                if($('.content_list_'+id+' .iframe-category').length == 0){
                    $('.iframe-category').remove() ;
                    var name = 'frame_'+ id ;
                    var id_  = 'frame_'+ id ;
                    var url  = '<?php echo osc_admin_base_url(true) ; ?>?page=ajax&action=category_edit_iframe&id=' + id ;
                    $.ajax({
                        url: url,
                        context: document.body,
                        success: function(res){
                            $('div.' + class_name).html(res);
                            $('div.' + class_name).fadeIn("fast");
                        }
                    });
                } else {
                    $('.iframe-category').remove() ;
                }
                return false;
            }

            function delete_category(id) {
                $("#dialog-delete-category").attr('data-category-id', id);
                $("#dialog-delete-category").dialog('open');
                return false ;
            }

            function enable_cat(id) {
                var enabled ;

                $(".jsMessage").fadeIn("fast") ;
                $(".jsMessage p").attr('class', '') ;
                $(".jsMessage p").html("<img height='16' width='16' src='<?php echo osc_current_admin_theme_url('images/spinner_loading.gif');?>'> <?php _e('This action can take a while.') ; ?>") ;

                if( $('div[category_id=' + id + ']').hasClass('disabled') ) {
                    enabled = 1 ;
                } else {
                    enabled = 0 ;
                }

                var url  = '<?php echo osc_admin_base_url(true); ?>?page=ajax&action=enable_category&id=' + id + '&enabled=' + enabled ;
                $.ajax({
                    url: url,
                    context: document.body,
                    success: function(res) {
                        var ret = eval( "(" + res + ")");
                        var message = "" ;
                        if(ret.error) {
                            message += ret.error ;
                            $(".jsMessage p").attr('class', 'error') ;
                        }
                        if(ret.ok) {
                            if( enabled == 0 ) {
                                $('div[category_id=' + id + ']').addClass('disabled') ;
                                $('div[category_id=' + id + ']').removeClass('enabled') ;
                                $('div[category_id=' + id + ']').find('a.enable').text('<?php _e('Enable') ; ?>') ;
                                for(var i = 0; i < ret.affectedIds.length; i++) {
                                    id =  ret.affectedIds[i].id ;
                                    $('div[category_id=' + id + ']').addClass('disabled') ;
                                    $('div[category_id=' + id + ']').removeClass('enabled') ;
                                    $('div[category_id=' + id + ']').find('a.enable').text('<?php _e('Enable') ; ?>') ;
                                }
                            } else {
                                $('div[category_id=' + id + ']').removeClass('disabled') ;
                                $('div[category_id=' + id + ']').addClass('enabled') ;
                                $('div[category_id=' + id + ']').find('a.enable').text('<?php _e('Disable'); ?>') ;

                                for(var i = 0; i < ret.affectedIds.length; i++) {
                                    id =  ret.affectedIds[i].id ;
                                    $('div[category_id=' + id + ']').removeClass('disabled') ;
                                    $('div[category_id=' + id + ']').addClass('enabled') ;
                                    $('div[category_id=' + id + ']').find('a.enable').text('<?php _e('Disable'); ?>') ;
                                }
                            }

                            message += ret.ok ;
                            $(".jsMessage p").attr('class', 'ok') ;
                        }

                        $(".jsMessage").show();
                        $(".jsMessage p").html(message);
                    },
                    error: function(){
                        $(".jsMessage").show() ;
                        $(".jsMessage p").attr('class', '') ;
                        $(".jsMessage p").html("<?php _e('Ajax error, try again.') ; ?>") ;
                    }
                }) ;
            }
        </script>
        <?php
    }
    osc_add_hook('admin_header','customHead');

    $users      = __get('users') ;
    $stat       = __get('stat') ;
    $categories = __get('categories') ;
    $countries  = __get('countries') ;
    $regions    = __get('regions') ;
    $cities     = __get('cities') ;
    $withFilters= __get('withFilters') ;

    $iDisplayLength = __get('iDisplayLength');

    $aData      = __get('aItems') ;
function drawCategory($category,$isSubcategory = false){
    if( count($category['categories']) > 0 ) { $has_subcategories = true ; } else { $has_subcategories = false ; }
?>
    <div class="category_div <?php echo ( $category['b_enabled'] == 1 ? 'enabled' : 'disabled' ) ; ?>" category_id="<?php echo $category['pk_i_id'] ; ?>" >
    <div class="category_row">
        <div class="handle ico ico-32 ico-droppable"></div>
        <div class="ico-childrens">
            <?php
        if($isSubcategory){
            echo '<span class="toggle status-expanded">-</span>';
        } else {
            if( $has_subcategories ) {
                echo '<span class="toggle status-collapsed">+</span>';
            } else {
                echo '<span class="toggle status-expanded">-</span>';
            }
        }
        ?>
        </div>
        <div class="name-cat" id="<?php echo 'quick_edit_' . $category['pk_i_id'] ; ?>">
            <?php echo '<span class="name">'.$category['s_name'].'</span>'; ?>
        </div>
        <div class="actions-cat">
            <a onclick="show_iframe('content_list_<?php echo $category['pk_i_id'];?>','<?php echo $category['pk_i_id'] ; ?>');"><?php _e('Edit') ; ?></a>
            &middot;
            <a class="enable" onclick="enable_cat('<?php echo $category['pk_i_id']; ?>')"><?php $category['b_enabled'] == 1 ? _e('Disable') : _e('Enable'); ?></a> 
            &middot;
            <a onclick="delete_category(<?php echo $category['pk_i_id']; ?>)"><?php _e('Delete') ; ?></a>
        </div>
    </div>
    <div class="edit content_list_<?php echo $category['pk_i_id'] ; ?>"></div>
</div>
<?php
} //End drawCategory
?>
<?php osc_current_admin_theme_path( 'parts/header.php' ) ; ?>

            <!-- right container -->
            <div class="right">
                <!-- categories form -->
                <div class="categories">
                    <div class="flashmessage flashmessage-info">
                        <p class="info"><?php _e('Drag&drop the categories to reorder them the way you like. Click on edit link to edit the category') ; ?></p>
                    </div>
                    <div class="list-categories">
                        <ul class="sortable">
                        <?php foreach($categories as $category) { ?>
                        <?php
                            if( count($category['categories']) > 0 ) { $has_subcategories = true ; } else { $has_subcategories = false ; }
                        ?>
                            <li id="list_<?php echo $category['pk_i_id'] ; ?>" class="category_li <?php echo ( $category['b_enabled'] == 1 ? 'enabled' : 'disabled' ) ; ?> <?php if($has_subcategories) { echo 'no-nest'; } ?>" >

                                <?php drawCategory($category); ?>
                                <?php if($has_subcategories) { ?>
                                    <ul class="subcategory subcategories-<?php echo $category['pk_i_id'] ; ?> hide">
                                    <?php foreach($category['categories'] as $category) {?>
                                        <li id="list_<?php echo $category['pk_i_id'] ; ?>" class="category_li <?php echo ( $category['b_enabled'] == 1 ? 'enabled' : 'disabled' ) ; ?>" >
                                            <?php drawCategory($category,true); ?>
                                        </li>
                                    <?php } ?>
                                    </ul>
                                <?php } ?>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="clear"></div>
                </div>
                <!-- /categories form -->
            </div>
            <!-- /right container -->
            <div id="dialog-delete-category" title="<?php echo osc_esc_html(__('Delete category')); ?>" class="has-form-actions hide" data-category-id="">
                <div class="form-horizontal">
                    <div class="form-row">
                        <?php _e('<strong>WARNING</strong>: This will also delete the listings under that category. This action cannot be undone. Are you sure you want to continue?'); ?>
                    </div>
                    <div class="form-actions">
                        <div class="wrapper">
                            <a class="btn" href="javascript:void(0);" onclick="$('#dialog-delete-category').dialog('close');"><?php _e('Cancel'); ?></a>
                            <a id="category-delete-submit" href="javascript:void(0);" class="btn btn-red" ><?php echo osc_esc_html( __('Delete') ); ?></a>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
<?php osc_current_admin_theme_path('parts/footer.php') ; ?>