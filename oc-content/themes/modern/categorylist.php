<div class="silver_box_lite">
    <div class="wh_curve_box">
        <h1>Browse Category</h1>

        <div id="multimenu">
            <?php osc_goto_first_category() ; ?>

            <?php while ( osc_has_categories() ) { ?>
            <ul id="multimenuList">
                <li><a class="category <?php echo osc_category_slug() ; ?>" href="<?php echo osc_search_category_url() ; ?>"><?php echo osc_category_name() ; ?> <span>(<?php echo osc_category_total_items() ; ?>)</span></a>
                        <?php
                        if ( osc_count_subcategories() > 0 ) {
                            echo "<ul>";
                            while ( osc_has_subcategories() ) {
                                ?>
                                <li><a href="<?php echo osc_search_category_url() ; ?>"><?php echo osc_category_name() ; ?> <span>(<?php echo osc_category_total_items() ; ?>)</span></a> </li>
                            <?php 
                            }
                            echo "</ul>";
                        }
                        ?>
                </li>
                
                <div class="clear"></div>
            </ul>
            <?php } ?>
            <script type="text/javascript">
                // JavaScript Document

                startList = function() {
                    if (document.all&&document.getElementById) {
                        navRoot = document.getElementById("multimenuList");
                        for (i=0; i<navRoot.childNodes.length; i++) {
                            node = navRoot.childNodes[i];
                            if (node.nodeName=="li") {
                                node.onmouseover=function() {
                                    this.className+=" over";
                                }
                                node.onmouseout=function() {
                                    this.className=this.className.replace(" over", "");
                                }
                            }
                        }
                    }
                }
                window.onload=startList;
            </script>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<!--<div class="silver_box_lite">
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
</div>-->

<div class="silver_box_lite">
    <div class="wh_curve_box">
        <div class="relative">
            <a href="#" title="Locations" class="dropdown" style="width:170px;text-decoration:none;background-color:#CCCCCC;"><span>Select Location</span></a>
            <div id="dropdown1" class="dropdown-menu">
                <?php while(osc_has_list_cities() ) { ?>
                <a href="<?php echo osc_list_city_url() ; ?>" title="<?php echo osc_list_city_name() ; ?>"><?php echo osc_list_city_name() ; ?> <!-- (<?php //echo osc_list_city_items() ; ?>) --></a>

                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php vertical_rightbar_advertisement(); ?>