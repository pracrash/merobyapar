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
ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
    <head>
        <?php osc_current_web_theme_path('head.php') ; ?>
        <?php if( osc_count_items() == 0 || Params::getParam('iPage') > 0 || stripos($_SERVER['REQUEST_URI'], 'search') ) { ?>
        <meta name="robots" content="noindex, nofollow" />
        <meta name="googlebot" content="noindex, nofollow" />
        <?php } else { ?>
        <meta name="robots" content="index, follow" />
        <meta name="googlebot" content="index, follow" />
        <?php } ?>
        <style type="text/css">
            ul.sub {
                padding-left: 20px;
            }
            .chbx{
                width:15px; height:15px;
                display: inline;
                padding:8px 3px;
                background-repeat:no-repeat;
                cursor: pointer;
            }
            .chbx span{
                width:13px; height:13px;
                display: inline-block;
                border:solid 1px #bababa;
                border-radius:2px;
                -moz-border-radius:2px;
                -webkit-border-radius:2px;
            }
            .chbx.checked{
                background-image:url('<?php echo osc_current_web_theme_url('images/checkmark.png'); ?>');
            }
            .chbx.semi-checked{
                background-image:url('<?php echo osc_current_web_theme_url('images/checkmark-partial.png'); ?>');
            }
        </style>
        <script type="text/javascript">
            $(document).ready(function(){
                $('li.parent').each(function() {
                    var totalInputSub = $(this).find('ul.sub>li>input').size();
                    var totalInputSubChecked = $(this).find('ul.sub>li>input:checked').size();

                    $(this).find('ul.sub>li>input').each(function(){
                        $(this).hide();
                        var id = $(this).attr('id');
                        id = id+'_';
                        if( $(this).is(':checked') ){
                            var aux = $('<div class="chbx checked"><span></span></div>').attr('id', id);
                            $(this).before(aux);
                        } else {
                            var aux = $('<div class="chbx"><span></span></div>').attr('id', id);
                            $(this).before(aux);
                        }
                    });

                    var input = $(this).find('input.parent');
                    $(input).hide();
                    var id = $(input).attr('id');
                    id = id+'_';
                    if(totalInputSub == totalInputSubChecked) {
                        if(totalInputSub == 0) {
                            if( $(this).find("input[name='sCategory[]']:checked").size() > 0) {
                                var aux = $('<div class="chbx checked"><span></span></div>').attr('id', id);
                                $(input).before(aux);
                            } else {
                                var aux = $('<div class="chbx"><span></span></div>').attr('id', id);
                                $(input).before(aux);
                            }
                        } else {
                            var aux = $('<div class="chbx checked"><span></span></div>').attr('id', id);
                            $(input).before(aux);
                        }
                    }else if(totalInputSubChecked == 0) {
                        // no input checked
                        var aux = $('<div class="chbx"><span></span></div>').attr('id', id);
                        $(input).before(aux);
                    }else if(totalInputSubChecked < totalInputSub) {
                        var aux = $('<div class="chbx semi-checked"><span></span></div>').attr('id', id);
                        $(input).before();
                    }
                });

                $('li.parent').prepend('<span style="width:6px;display:inline-block;" class="toggle">+</span>');
                $('ul.sub').toggle();

                $('span.toggle').click(function(){
                    $(this).parent().find('ul.sub').toggle();
                    if($(this).text()=='+'){
                        $(this).html('-');
                    } else {
                        $(this).html('+');
                    }
                });

                $("li input[name='sCategory[]']").change( function(){
                    var id = $(this).attr('id');
                    $(this).click();
                    $('#'+id+'_').click();
                });

                $('div.chbx').click( function() {
                    var isChecked       = $(this).hasClass('checked');
                    var isSemiChecked   = $(this).hasClass('semi-checked');

                    if(isChecked) {
                        $(this).removeClass('checked');
                        $(this).next('input').attr('checked', false);
                    } else if(isSemiChecked) {
                        $(this).removeClass('semi-checked');
                        $(this).next('input').attr('checked', false);
                    } else {
                        $(this).addClass('checked');
                        $(this).next('input').attr('checked', true);
                    }

                    // there are subcategories ?
                    if($(this).parent().find('ul.sub').size()>0) {
                        if(isChecked){
                            $(this).parent().find('ul.sub>li>div.chbx').removeClass('checked');
                            $(this).parent().find('ul.sub>li>input').attr('checked', false);
                        } else if(isSemiChecked){
                            // if semi-checked -> check-all
                            $(this).parent().find('ul.sub>li>div.chbx').removeClass('checked');
                            $(this).parent().find('ul.sub>li>input').attr('checked', false);
                            $(this).removeClass('semi-checked');
                        } else {
                            $(this).parent().find('ul.sub>li>div.chbx').addClass('checked');
                            $(this).parent().find('ul.sub>li>input').attr('checked', true);
                        }
                    } else {
                        // is subcategory checkbox or is category parent without subcategories
                        var parentLi = $(this).closest('li.parent');

                        // subcategory
                        if($(parentLi).find('ul.sub').size() > 0) {
                            var totalInputSub           = $(parentLi).find('ul.sub>li>input').size();
                            var totalInputSubChecked    = $(parentLi).find('ul.sub>li>input:checked').size();

                            var input    = $(parentLi).find('input.parent');
                            var divInput = $(parentLi).find('div.chbx').first();

                            $(input).attr('checked', false);
                            $(divInput).removeClass('checked');
                            $(divInput).removeClass('semi-checked');

                            if(totalInputSub == totalInputSubChecked) {
                                $(divInput).addClass('checked');
                                $(input).attr('checked', true);
                            }else if(totalInputSubChecked == 0) {
                                // no input checked;
                            }else if(totalInputSubChecked < totalInputSub) {
                                $(divInput).addClass('semi-checked');
                            }
                        } else {
                            // parent category
                        }
                    }
                });
            });
        </script>
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
            <?php osc_current_web_theme_path('header-open.php') ; ?>
            <?php osc_current_web_theme_path('inc.adv-search.php') ; ?>
            <?php osc_current_web_theme_path('header-close.php') ; ?>


            <div id="top_features_scroll">
                <?php if (function_exists('carousel')) {carousel();} ?>
            </div>
            <div id="container">
                <div id="lf_column">
                    <?php osc_current_web_theme_path('categorylist.php') ; ?>
                </div>
                <div id="mid_column_clr_rt">

                    <div class="silver_box_lite">
                        <div class="wh_curve_box">
                            <h1>
                                <?php echo search_title(); ?> | <?php echo osc_search_total_items() ?> results
                            </h1>
                            <div style="padding:20px;">
                                <div id="list_head">
                                    <div class="inner">

                                        <p class="see_by">
                                            <?php _e('Sort by', 'modern'); ?>:
                                            <?php $i = 0 ; ?>
                                            <?php $orders = osc_list_orders();
                                            foreach($orders as $label => $params) {
                                                $orderType = ($params['iOrderType'] == 'asc') ? '0' : '1'; ?>
                                                <?php if(osc_search_order() == $params['sOrder'] && osc_search_order_type() == $orderType) { ?>
                                            <a class="current" href="<?php echo osc_update_search_url($params) ; ?>"><?php echo $label; ?></a>
                                                <?php } else { ?>
                                            <a href="<?php echo osc_update_search_url($params) ; ?>"><?php echo $label; ?></a>
                                                <?php } ?>
                                                <?php if ($i != count($orders)-1) { ?>
                                            <span>|</span>
                                                <?php } ?>
                                                <?php $i++ ; ?>
                                            <?php } ?>
                                        </p>
                                    </div>
                                </div>
                                <?php if(osc_count_items() == 0) { ?>
                                <p class="empty" ><?php printf(__('There are no results matching "%s"', 'modern'), osc_search_pattern()) ; ?></p>
                                <?php } else { ?>
                                    <?php
                                    //$searchstyle = $_GET['style'];
                                    require(osc_search_show_as() == 'list' ? 'search_list.php' : 'search_gallery.php') ; ?>
                                <?php } ?>
                                <div class="paginate" >
                                    <?php echo osc_search_pagination(); ?>
                                </div>
                                <?php
                                    $usersWithCategories = osc_user_by_category(Params::getParam('sCategory'));
                                    $companies = 1;
                                    echo '<h2>Companies selling similar</h2>';
                                    /*echo '<table>
                                        <tr>';
                                            foreach($usersWithCategories as $userWithCategory) {
                                                $userInfo = User::newInstance()->findByPrimaryKey($userWithCategory['fk_i_user_id']);

                                                echo '<td style="text-align:center;">'.profile_picture_show($userWithCategory['fk_i_user_id']).'<a href="'.  osc_base_url(true).'?page=user&action=pub_profile&id='.$userInfo['pk_i_id'].'" >'.$userInfo['s_name'].'</a></td>';
                                                if($companies == 5)
                                                    break;
                                                $companies++;
                                            }
                                    echo '</tr>
                                    </table>';*/
                                    echo '<div style="width:100%">';
                                    foreach($usersWithCategories as $userWithCategory) {
                                        $userInfo = User::newInstance()->findByPrimaryKey($userWithCategory['fk_i_user_id']);
                                        echo '<div id="something" style="width:125px; height:125;float:left;padding-right:10px;">
                                            ';
                                        profile_picture_show($userWithCategory['fk_i_user_id']);
                                        echo '<br /><a href="'.  osc_base_url(true).'?page=user&action=pub_profile&id='.$userInfo['pk_i_id'].'" >'.$userInfo['s_name'].'</a>
                                        </div>';
                                    }
                                    echo '</div>';
                                ?>

                                <?php $footerLinks = osc_search_footer_links(); ?>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                </div>





                <script type="text/javascript">
                    $(function() {
                        function log( message ) {
                            $( "<div/>" ).text( message ).prependTo( "#log" );
                            $( "#log" ).attr( "scrollTop", 0 );
                        }

                        $( "#sCity" ).autocomplete({
                            source: "<?php echo osc_base_url(true); ?>?page=ajax&action=location",
                            minLength: 2,
                            select: function( event, ui ) {
                                log( ui.item ?
                                    "<?php _e('Selected', 'modern'); ?>: " + ui.item.value + " aka " + ui.item.id :
                                    "<?php _e('Nothing selected, input was', 'modern'); ?> " + this.value );
                            }
                        });
                    });

                    function checkEmptyCategories() {
                        var n = $("input[id*=cat]:checked").length;
                        if(n>0) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                </script>
            </div>

            <div class="ads_3">
                <?php horiz_long_advertisement(); ?>
            </div>
            <div class="ads_3">
                <?php osc_current_web_theme_path('g_ads_horiz.php') ; ?>
            </div>
            <?php osc_current_web_theme_path('footer.php') ; ?>
        </div>
    </body>
</html>