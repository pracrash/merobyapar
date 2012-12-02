</div> <!--container close-->

<div class="clear"></div>
<!-- /header -->
<?php

    //osc_show_widgets('header') ;

    $breadcrumb = osc_breadcrumb('&raquo;', false);
    if( $breadcrumb != '') { ?>
    <div>
        
        <?php echo $breadcrumb; ?>
        <div class="clear"></div>
    </div>
<?php
    }
?>