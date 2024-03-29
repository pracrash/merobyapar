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

    $numItemsPerCategory = __get('numItemsPerCategory');
    $numItems            = __get('numItems');
    $numUsers            = __get('numUsers');
    $newsList            = __get('newsList');
    $twitterRSS          = __get('twitterRSS');

    osc_add_filter('render-wrapper','render_offset');
    function render_offset() {
        return 'row-offset';
    }

    osc_add_hook('admin_page_header','customPageHeader');
    function customPageHeader() { ?>
        <h1><?php _e('Dashboard') ; ?></h1>
    <?php
    }

    function customPageTitle($string) {
        return sprintf(__('Dashboard &raquo; %s'), $string);
    }
    osc_add_filter('admin_title', 'customPageTitle');

    function customHead() {
        $items = __get('item_stats');
        $users = __get('user_stats');
        ?>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">
            google.load('visualization', '1', {'packages':['corechart']});
            google.setOnLoadCallback(drawChartListing);
            google.setOnLoadCallback(drawChartUser);

            function drawChartListing() {
                var data = new google.visualization.DataTable();
                data.addColumn('string', '<?php _e('Date') ; ?>');
                data.addColumn('number', '<?php _e('Listings') ; ?>');
                data.addColumn({type:'boolean',role:'certainty'});
                <?php $k = 0 ;
                echo "data.addRows(" . count($items) . ");" ;
                foreach($items as $date => $num) {
                    echo "data.setValue(" . $k . ', 0, "' . $date . '");';
                    echo "data.setValue(" . $k . ", 1, " . $num . ");";
                    $k++ ;
                }
                $k = 0 ;
                ?>

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.AreaChart(document.getElementById('placeholder-listing'));
                chart.draw(data, {
                    colors:['#058dc7','#e6f4fa'],
                        areaOpacity: 0.1,
                        lineWidth:3,
                        hAxis: {
                        gridlines:{
                            color: '#333',
                            count: 3
                        },
                        viewWindow:'explicit',
                        showTextEvery: 2,
                        slantedText: false,
                        textStyle:{
                            color: '#058dc7',
                            fontSize: 10
                        }
                        },
                        vAxis: {
                            gridlines:{
                                color: '#DDD',
                                count: 4,
                                style: 'dooted'
                            },
                            viewWindow:'explicit',
                            baselineColor:'#bababa'

                        },
                        pointSize: 6,
                        legend: 'none',
                        chartArea:{
                            left:10,
                            top:10,
                            width:"95%",
                            height:"88%"
                        }
                    });
            }

            function drawChartUser() {
                var data = new google.visualization.DataTable();
                data.addColumn('string', '<?php _e('Date') ; ?>');
                data.addColumn('number', '<?php _e('Users') ; ?>');
                data.addColumn({type:'boolean',role:'certainty'});
                <?php $k = 0 ;
                echo "data.addRows(" . count($users) . ");" ;
                foreach($users as $date => $num) {
                    echo "data.setValue(" . $k . ', 0, "' . $date . '");';
                    echo "data.setValue(" . $k . ", 1, " . $num . ");";
                    $k++ ;
                }
                $k = 0 ;
                ?>

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.AreaChart(document.getElementById('placeholder-user'));
                chart.draw(data, {
                    colors:['#058dc7','#e6f4fa'],
                    areaOpacity: 0.1,
                    lineWidth:3,
                    hAxis: {
                    gridlines:{
                        color: '#333',
                        count: 3
                    },
                    viewWindow:'explicit',
                    showTextEvery: 2,
                    slantedText: false,
                    textStyle:{
                        color: '#058dc7',
                        fontSize: 10
                    }
                    },
                    vAxis: {
                        gridlines:{
                            color: '#DDD',
                            count: 4,
                            style: 'dooted'
                        },
                        viewWindow:'explicit',
                        baselineColor:'#bababa'

                    },
                    pointSize: 6,
                    legend: 'none',
                    chartArea:{
                        left:10,
                        top:10,
                        width:"95%",
                        height:"88%"
                    }
                });
            }

            $(document).ready(function() {
                $("#widget-box-stats-select").bind('change', function () {
                    if( $(this).val() == 'users' ) {
                        $('#widget-box-stats-listings').css('visibility', 'hidden');
                        $('#widget-box-stats-users').css('visibility', 'visible');
                    } else {
                        $('#widget-box-stats-users').css('visibility', 'hidden');
                        $('#widget-box-stats-listings').css('visibility', 'visible');
                    }
                });
            });
        </script>
<?php
    }
    osc_add_hook('admin_header', 'customHead');

    osc_current_admin_theme_path( 'parts/header.php' ); ?>
<div id="dashboard">
<div class="grid-system">
    <div class="grid-row grid-first-row grid-50">
        <div class="row-wrapper">
            <div class="widget-box">
                <div class="widget-box-title"><h3><?php _e('Listings by category') ; ?></h3></div>
                <div class="widget-box-content">
                    <?php
                    $countEvent = 1;
                    if( !empty($numItemsPerCategory) ) { ?>
                    <table class="table" cellpadding="0" cellspacing="0">
                        <tbody>
                        <?php
                        $even = false;
                        foreach($numItemsPerCategory as $c) {?>
                            <tr<?php if($even == true){ $even = false; echo ' class="even"'; } else { $even = true; } if($countEvent == 1){ echo ' class="table-first-row"';} ?>>
                                <td><a href="<?php echo osc_admin_base_url(true); ?>?page=items&amp;catId=<?php echo $c['pk_i_id'] ; ?>"><?php echo $c['s_name'] ; ?></a></td>
                                <td><?php echo $c['i_num_items'] . "&nbsp;" . ( ( $c['i_num_items'] == 1 ) ? __('Listing') : __('Listings') ); ?></td>
                            </tr>
                            <?php foreach($c['categories'] as $subc) {?>
                                <tr<?php if($even == true){ $even = false; echo ' class="even"'; } else { $even = true; } ?>>
                                    <td class="children-cat"><a href="<?php echo osc_admin_base_url(true); ?>?page=items&amp;catId=<?php echo $subc['pk_i_id'];?>"><?php echo $subc['s_name'] ; ?></a></td>
                                    <td><?php echo $subc['i_num_items'] . " " . ( ( $subc['i_num_items'] == 1 ) ? __('Listing') : __('Listings') ); ?></td>
                                </tr>
                            <?php
                            $countEvent++;
                            }
                            ?>
                        <?php
                        $countEvent++;
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php } else { ?>
                        <?php _e("There aren't any uploaded listing yet") ; ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="grid-row grid-50">
        <div class="row-wrapper">
            <div class="widget-box">
                <div class="widget-box-title"><h3><?php _e('Statistics'); ?> <select id="widget-box-stats-select" class="widget-box-selector select-box-big input-medium"><option value="listing"><?php _e('New listings'); ?></option><option value="users"><?php _e('New users'); ?></option></select></h3></div>
                <div class="widget-box-content widget-box-content-stats" style="overflow-y: visible;">
                    <div id="widget-box-stats-listings" class="widget-box-stats">
                        <b class="stats-title"><?php _e('New listings'); ?></b>
                        <div class="stats-detail"><?php printf(__('Total number of listings: %s'), $numItems); ?></div>
                        <div id="placeholder-listing" class="graph-placeholder"></div>
                        <a href="<?php echo osc_admin_base_url(true); ?>?page=stats&amp;action=items" class="btn"><?php _e('Listing statistics'); ?></a>
                    </div>
                    <div id="widget-box-stats-users" class="widget-box-stats" style="visibility: hidden;">
                        <b class="stats-title"><?php _e('New users'); ?></b>
                        <div class="stats-detail"><?php printf(__('Total number of users: %s'), $numUsers); ?></div>
                        <div id="placeholder-user" class="graph-placeholder"></div>
                        <a href="<?php echo osc_admin_base_url(true); ?>?page=stats&amp;action=users" class="btn"><?php _e('User statistics'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--<div class="grid-row grid-first-row grid-50">
        <div class="row-wrapper">
            <div class="widget-box  widget-box-project">
                <div class="widget-box-title"><h3><?php _e('OSClass'); ?></h3></div>
                <div class="widget-box-content widget-box-content-no-wrapp">
                    <h4 class="first-title"><?php _e('Newsletter'); ?></h4>
                    <form name="subscribe_form" action="http://osclass.org/" method="post" class="dash-widget-form">
                        <input type="hidden" name="subscribe" value="submit" />
                        <input type="hidden" name="return_path" value="<?php echo osc_admin_base_url(); ?>" />
                        <input type="hidden" name="source" value="osclass" />
                        <fieldset>
                            <div class="form">
                                <p>
                                    <?php _e('Want the latest tips and updates delivered to your inbox? <strong>Sign up now!</strong>'); ?>
                                </p>
                                <div class="form-row">
                                    <div class="form-controls">
                                        <input type="text" class="xlarge" name="email" value="">
                                        <input type="submit" class="btn btn-mini" name="submit" value="<?php echo osc_esc_html(__('Subscribe')); ?>" />
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                    <h4><?php _e('Donate'); ?></h4>
                    <form name="_xclick" action="https://www.paypal.com/in/cgi-bin/webscr" method="post" class="dash-widget-form">
                        <input type="hidden" name="cmd" value="_donations">
                        <input type="hidden" name="rm" value="2">
                        <input type="hidden" name="business" value="info@osclass.org">
                        <input type="hidden" name="item_name" value="OSClass project">
                        <input type="hidden" name="return" value="http://osclass.org/paypal/">
                        <input type="hidden" name="currency_code" value="USD">
                        <input type="hidden" name="lc" value="US" />
                        <input type="hidden" name="custom" value="<?php echo osc_admin_base_url(); ?>?donation=successful">
                        <fieldset>
                            <div class="form">
                                <p><?php _e('OSClass is a free, open-source project, sustained by the community. Money received from donations will be used to further the development and improve the project.'); ?></p>
                                <div class="form-row">
                                    <div class="form-controls">
                                        <select name="amount" class="input-medium">
                                            <option value="50">50$</option>
                                            <option value="25">25$</option>
                                            <option value="10" selected>10$</option>
                                            <option value="5">5$</option>
                                            <option value=""><?php _e('Custom'); ?></option>
                                        </select><input type="submit" class="btn btn-mini" name="submit" value="<?php echo osc_esc_html(__('Donate', 'modern')); ?>">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
     <div class="grid-row grid-50">
        <div class="row-wrapper">
            <div class="widget-box">
                <div class="widget-box-title"><h3><?php _e('Latest news'); ?></h3></div>
                <div class="widget-box-content widget-box-content-no-wrapp">
                    <h4 class="first-title"><?php _e('Blog'); ?></h4>
                    <?php if( is_array($newsList) ) { ?>
                        <ul class="list-latests">
                        <?php foreach ($newsList as $list) { ?>
                        <?php $new = ( strtotime($list['pubDate']) > strtotime('-1 week') ? true : false ) ; ?>
                            <li>
                                <a href="<?php echo $list['link'] ; ?>" target="_blank"><?php echo $list['title'] ; ?></a>
                                <?php if( $new ) { ?>
                                    <span style="color:red; font-size:10px; font-weight:bold;"><?php _e('new') ; ?></span>
                                <?php } ?>
                            </li>
                        <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <?php _e('Unable to fetch news from OSClass. Please try again later') ; ?>
                    <?php } ?>
                    <h4><?php _e('Twitter'); ?></h4>
                    <?php if( is_array($twitterRSS) ) { ?>
                        <ul class="list-latests">
                        <?php foreach( $twitterRSS as $tweet ) { ?>
                            <li><a href="<?php echo $tweet['link']; ?>" target="_blank"><?php echo str_replace('osclass: ', '', $tweet['title']); ?></a></li>
                        <?php } ?>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div> -->
    <div class="clear"></div>
</div>
</div>
<?php osc_current_admin_theme_path( 'parts/footer.php' ) ; ?>