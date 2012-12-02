<?php 
/**
 * Get if user is on item edit page
 *
 * @return boolean
 */
function osc_is_item_edit_page() {
    $location = Rewrite::newInstance()->get_location();
    $section = Rewrite::newInstance()->get_section();
    if($location=='item' && $section=='item_edit') {
        return true;
    }
    return false;
}

if(!osc_is_publish_page() && !osc_is_item_edit_page()) {

    $osclassItems = View::newInstance()->_get('items');
/*
$search1 = new search();
if($itemPage) {
   $pCategory = Category::newInstance()->findRootCategory(osc_item_category_id() );
   
   
   $search1->addCategory($pCategory['pk_i_id']);                   
   //$search1->addCategory(osc_item_category_id ());
   
   $search1->limit (0, $itemLimit);
} */
    //added by shakeelstha
    $search = new search();
    // Moved the addCategory out of the if statement below;
    // Removed osc_item_category_id() and replaced with $_GET['sCategory'] to grab the current category id.
    $search->addCategory($_GET['sCategory']);

    if($itemPage) {
        $pCategory = Category::newInstance()->findRootCategory(osc_item_category_id() );
        $search->limit (0, $itemLimit);
    }

    if($picOnly == 1 ) {
        $search->withPicture(true);
    }
    if($premOnly == 1) {
        $search->addConditions(sprintf("b_premium_scroller = %d", 1));
    }
    //$search1->order('b_premium');
    $search->order(sprintf('%st_item.b_premium_scroller DESC, %st_item.dt_pub_date', DB_TABLE_PREFIX, DB_TABLE_PREFIX), 'DESC', '');

    $search->limit(0,20);

    //echo $search1;
    $aItems = $search->doSearch();
    $iTotalItems = $search->count();
    $aCount = count($aItems);
    //echo "Count :::::".$aCount;
    View::newInstance()->_exportVariableToView('items', $aItems);
    ?>

<div id="carousel">

        <?php //echo 'total ' . $iTotalItems;
        if($aCount >= $items) {?>
    <!--added by shakeelstha to hide slider if no premium ads for a particular category-->
    <div class="shadowblock_out">
        <div id="list">
                    <?php if (osc_carousel_arrows()) { ?>
            <div class="prevCarousel"></div>
                    <?php } ?>
            <div class="carouselSlider">
                <ul>

                            <?php if($premOnly == 0) { ?>
                                <?php $class = "even"; ?>
                                <?php while ( osc_has_items() ) { ?>
                    <li>   <span class="feat_left">

                                            <?php //if(osc_item_is_premium_scroller()) { _e('Premium Ad', 'carousel_for_osclass');}else {echo '<br />';}?>
                                            <?php if( osc_count_item_resources() ) { ?>

                            <a href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_item_title() ; ?>" >
                                <img src="<?php echo osc_resource_thumbnail_url() ; ?>" width="75px" height="56px" title="<?php echo osc_item_title() ; ?>" alt="<?php echo osc_item_title() ; ?>" />
                            </a>
                            
                                            <?php } else { ?>
                            <a href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_item_title() ; ?>"><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" alt="<?php echo osc_item_title() ; ?>" width="75px" height="56px" title="<?php echo osc_item_title() ; ?>"/></a>
                                            <?php } ?>
                                            
                            <div class="clr"></div>
                                            <?php if( osc_price_enabled_at_items() ) { if($price == 1) {?><div class="price_sm"><?php echo osc_item_formated_price() ; ?></div><?php }} ?>
                            <div class="clr"></div>

                            <a href="<?php echo osc_item_url() ; ?>"><?php echo substr(osc_item_title(),0,15) ; ?></a>

                        </span>
                        
                    </li>

                                    <?php $class = ($class == 'even') ? 'odd' : 'even' ; ?>
                                <?php } ?>

                                <?php //Premium Items only ?>

                            <?php  }else { ?>
                                <?php $class = "even"; ?>
                                <?php while ( osc_has_items() ) { ?>
                                    <?php if(osc_item_is_premium_scroller()) { ?>
                    <li>   <span class="feat_left">

                                                <?php if( osc_count_item_resources() ) { ?>

                            <div style="float:left;">
                            <a href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_item_title() ; ?>" >
                                <img src="<?php echo osc_resource_thumbnail_url() ; ?>" width="75" height="56" title="<?php echo osc_item_title() ; ?>" alt="<?php echo osc_item_title() ; ?>" style="margin:0 10px 10px " />
                            </a>
                                                <?php } else { ?>
                            <a href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_item_title() ; ?>"><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" alt="<?php echo osc_item_title() ; ?>" width="75" height="56" title="<?php echo osc_item_title() ; ?>" style="margin:0 10px 10px "/></a>
                            </div>
                                                <?php } ?>
                                                <div style="float:left; vertical-align:text-top">
                            
                                                
                            <div class="clr"></div>

                            <a href="<?php echo osc_item_url() ; ?>" class="pname"><?php echo substr(osc_item_title(),0,15) ; ?></a><div class="clr"></div>
                            
                                                <?php if( osc_price_enabled_at_items() ) { if($price == 1) {?>Price: <span class="price_sm"><?php echo osc_item_formated_price() ; ?></span><?php }} ?>
                            <div class="clr"></div>
                            <a href="<?php echo osc_item_url() ; ?>" class="view_details">View Details</a>
                            </div>
                        </span>
                        
                    </li>
                                    <?php } /* ends premium item if statement */?>

                                    <?php $class = ($class == 'even') ? 'odd' : 'even' ; ?>
                                <?php } ?>
                            <?php /*osc_reset_premiums();*/ }  ?>
                </ul>

            </div> <!-- /slider -->
                    <?php if (osc_carousel_arrows()) { ?>
            <div class="nextCarousel"></div>
                    <?php } ?>
        </div>
    </div><!-- /shadowblock_out -->
        <?php } else { echo ''; } ?>


    <div class="clr"></div>


</div>
    <?php
    View::newInstance()->_exportVariableToView('items', $osclassItems);
    if(osc_is_home_page()) {
        $latestSearch = new Search();
        $latestSearch->limit (0, osc_get_preference('maxLatestItems@home', 'osclass'));
        $latestItems = $latestSearch->getLatestItems();

        View::newInstance()->_exportVariableToView('items', $latestItems);
    }
}
?>
