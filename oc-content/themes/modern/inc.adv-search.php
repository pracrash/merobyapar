<script type="text/javascript">
    $(document).ready(function() {
        $(".advanced").hide();
        //$(".basicLink").hide();
        $('.advancedLink').click(function() {
            $('.advanced').animate({
                height: 'toggle'
            }, 500			
        );
            $(".advancedLink").hide();
        });
        $('.basicLink').click(function() {
            $('.basic').animate({
                height: 'toggle'
            }, 500			
        );
            $(".advanced").hide();
            $(".advancedLink").show();
        });
    });


    $(document).ready(function(){
        //$("#multiselect_sCategory").multiselect();

        $("#advanced").css("display","none");
        $(".usertype").click(function(){
            if ($('input[name=b_company]:checked').val() == "1" ) {
                $("#advanced").slideDown("fast"); //Slide Down Effect
            } else {
                $("#advanced").slideUp("fast");	//Slide Up Effect
            }
        });
    });
</script>
<style>
    .chzn-container {
    top: 0px !important;
}
#header #search_box input[type="submit"], button.btn_search{
    top: 0px !important;
    right: 50px !important;
}

select {
    width: 20px;
}


</style>
<div class="filters" style="position:relative">
<!--<a href="#" class="postfreeads">Post Free Ads</a>-->
    <form action="<?php echo osc_base_url(true); ?>" method="get" onsubmit="return doSearch()" id="search_box">
        <input type="hidden" name="page" value="search" />
        <input type="hidden" name="sOrder" value="<?php echo osc_search_order(); ?>" />
        <input type="hidden" name="iOrderType" value="<?php $allowedTypesForSorting = Search::getAllowedTypesForSorting() ; echo $allowedTypesForSorting[osc_search_order_type()]; ?>" />
        <?php foreach(osc_search_user() as $userId) { ?>
        <input type="hidden" name="sUser[]" value="<?php echo $userId; ?>" />
        <?php } ?>
        <div id="basic">
            <fieldset class="box location">            

                <div style="float:left;width:380px;">
                    <!--<p class="whitecolor"><strong><?php _e('Your search', 'modern'); ?></strong> -->

                    <input type="text" name="sPattern" id="query" value="<?php echo osc_esc_html( osc_search_pattern() ); ?>" style="width:300px;" />
                    <div id="search-example" style="display:none"></div>
                    </p>
                </div>
                    <button type="submit" class="btn_search"><?php _e('Search', 'modern') ; ?></button>
            </fieldset>
        </div>
        <div class="advanced" style="display:none;">
            <fieldset>
                <?php if( osc_images_enabled_at_items() ) { ?>
                <div style="float:left; width:250px;overflow:hidden;padding-right:5px;">
                    <h6><strong><?php _e('Show only', 'modern') ; ?></strong></h6>

                    <ul>
                        <li>
                            <input type="checkbox" name="bPic" id="withPicture" value="1" <?php echo (osc_search_has_pic() ? 'checked="checked"' : ''); ?> />
                            <label for="withPicture"><?php _e('Listings with pictures', 'modern') ; ?></label>
                        </li>
                    </ul>
                    <!--h3 class="whitecolor"><strong><?php _e('Location', 'modern') ; ?></strong></h3-->
                    <?php _e('City', 'modern'); ?></strong>
                    <!-- <input type="text" id="sCity" name="sCity" value="<?php echo osc_esc_html( osc_search_city() ); ?>" /> -->
                    <?php $aCities = City::newInstance()->listAll(); ?>
                    <?php if(count($aCities) > 0 ) { ?>
                    <select name="sCity" id="sCity" style="width: 20px;">
                        <option value="">All Cities</option>
                            <?php foreach($aCities as $city) { ?>
                                <option value="<?php echo $city['s_name'] ; ?>"><?php echo $city['s_name'] ; ?></option>
                            <?php } ?>
                    </select>
                    <?php } ?>
                </div>
                <?php } ?>
                <?php if( osc_price_enabled_at_items() ) { ?>
                <div style="float:left; width:250px;">
                    <h6><?php _e('Price', 'modern') ; ?></h6>
                    <div><?php _e('Min', 'modern') ; ?>.</div>
                    <input type="text" id="priceMin" name="sPriceMin" value="<?php echo osc_search_price_min() ; ?>" size="6" maxlength="6" />
                    <div><?php _e('Max', 'modern') ; ?>.</div>
                    <input type="text" id="priceMax" name="sPriceMax" value="<?php echo osc_search_price_max() ; ?>" size="6" maxlength="6" />
                </div>
                <?php } ?>
                <?php osc_get_non_empty_categories(); ?>
                <?php if ( osc_count_categories() ) { ?>
                <div style="float:left; width:250px;">
                    <h6><?php _e('Category', 'modern') ; ?></h6>
                    <ul>
                            <?php // RESET CATEGORIES IF WE USED THEN IN THE HEADER ?>
                            <?php osc_goto_first_category() ; ?>
                            <?php while(osc_has_categories()) { ?>
                        <li class="parent">
                            <input class="parent" type="checkbox" id="cat<?php echo osc_category_id(); ?>" name="sCategory[]" value="<?php echo osc_category_id(); ?>" <?php $parentSelected=false; if (in_array(osc_category_id(), osc_search_category()) || in_array(osc_category_slug()."/", osc_search_category()) || in_array(osc_category_slug(), osc_search_category()) || count(osc_search_category())==0 ) { echo 'checked="checked"'; $parentSelected=true;} ?> /> <label for="cat<?php echo osc_category_id(); ?>"><strong><?php echo osc_category_name(); ?></strong></label>
                                    <?php if(osc_count_subcategories() > 0) { ?>
                            <ul class="sub">
                                            <?php while(osc_has_subcategories()) { ?>
                                <li>
                                    <input type="checkbox" id="cat<?php echo osc_category_id(); ?>" name="sCategory[]" value="<?php echo osc_category_id(); ?>"  <?php if( $parentSelected || in_array(osc_category_id(), osc_search_category()) || in_array(osc_category_slug()."/", osc_search_category()) || in_array(osc_category_slug(), osc_search_category()) || count(osc_search_category())==0 ) {echo 'checked="checked"';} ?> />
                                    <label for="cat<?php echo osc_category_id(); ?>"><strong><?php echo osc_category_name(); ?></strong></label>
                                </li>
                                            <?php } ?>
                            </ul>
                                    <?php } ?>
                        </li>
                            <?php } ?>
                    </ul>
                </div>
                    <?php      if(osc_search_category_id()) {
                        //osc_run_hook('search_form', osc_search_category_id()) ;
                    } else {
                        //osc_run_hook('search_form') ;
                    }
                    ?>
                <?php } ?>
                <a href="#" class="basicLink">Basic</a>
            </fieldset>
        </div>
        
        <div style="float: right;position: relative;top: -36px;"><a href="#" class="advancedLink">Advanced</a> </div>
        
    </form>
    
    <?php //osc_alert_form() ; ?>
</div>