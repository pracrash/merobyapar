<div>
    <ul class="breadcrumb">
        <li class="first-child"><a href="<?php echo osc_base_url() ; ?>">Mero Byapar</a></li>
        <li class="raquo">&raquo;</li>
        <li class="last-child" >Generate HTML Template</li>
    </ul>
    <div class="clear"></div>
</div>
<div class="content user_account">
    <div class="silver_box_lite">
        <div class="wh_curve_box">
            <h1>
                Generate HTML Template
            </h1>
            <div id="sidebar">
                <?php echo osc_private_user_menu(); ?>
            </div>
            <div id="main">

                <?php

                $item_id = '';
                if($_POST['item_selection'] != '') {
                    $item_id = $_POST['item_selection'];
                }

                $user_id = osc_logged_user_id();

                $conn = getConnection();

                // First, get the id numbers of all user's items (we'll use those to get the title of the ads next)
                $results = $conn->osc_dbFetchResults("SELECT pk_i_id FROM %st_item WHERE fk_i_user_id = %d", DB_TABLE_PREFIX, $user_id);

                // Second, get the respective item titles (since they're in a seperate database table)
                foreach($results as $result) {
                    $desc = $conn->osc_dbFetchResult("SELECT s_title FROM %st_item_description WHERE fk_i_item_id = %d", DB_TABLE_PREFIX, $result['pk_i_id']);
                    $item_title[] = $desc['s_title'];
                    $result_id[] = $result['pk_i_id'];
                }

                array_multisort($item_title, $result_id); // sorts arrays

                echo '<form name="selection" action="'.osc_render_file_url(osc_plugin_folder(__FILE__) . 'user_template_generator.php').'" method="post"><select name="item_selection" onChange="document.forms[\'selection\'].submit()">';
                echo '<option selected>Select an ad...</option>';
                for($index=0;$index<count($item_title);$index++) {
                    echo '<option value="'.$result_id[$index].'"';
                    if($result_id[$index]==$item_id) { echo ' Selected'; }
                    echo '>'.$item_title[$index].'</option>';
                }
                echo '</select></form>';
                ?>

                <?php

                // if a selection has been made...
                if($_POST['item_selection'] != '') {
                    $item_id = $_POST['item_selection']; // get ID of selected item

                    $conn = getConnection();

                    $result_item = $conn->osc_dbFetchResult("SELECT dt_pub_date, dt_mod_date, fk_i_category_id, i_price, fk_c_currency_code, b_premium FROM %st_item WHERE pk_i_id = %d", DB_TABLE_PREFIX, $item_id);
                    $result_desc = $conn->osc_dbFetchResult("SELECT fk_c_locale_code, s_title, s_description FROM %st_item_description WHERE fk_i_item_id = %d", DB_TABLE_PREFIX, $item_id); //Get active status of item
                    $result_location = $conn->osc_dbFetchResult("SELECT s_country, s_region, s_city FROM %st_item_location WHERE fk_i_item_id = %d", DB_TABLE_PREFIX, $item_id); //Get active status of item

                    $item_array[] = array('fk_i_item_id'=>$item_id, 'pk_i_id'=>$item_id, 'fk_i_category_id'=>$result_item['fk_i_category_id'],
                        'locale'=>array('en_US'=>array('fk_i_item_id'=>$item_id, 's_title'=>$result_desc['s_title'])));

                    View::newInstance()->_exportVariableToView('items', $item_array);

                    $URL = osc_item_url('',$item_id); // Store URL for current item

                    // Opening table statement
                    $line1  = '<table width="600" cellpadding="0" cellspacing="0" align="center">';
                    $line1 .= '<tr><td background="'.osc_base_url().'oc-content/plugins/template_generator/images/topblue.png" height="41" align="right"><font color="lavenderblush" face="verdana" size="2">Powered By:</font> <a href="'.osc_base_url().'"><font size="2" color="blue" face="verdana">'.meta_title().'</font></a>&nbsp;&nbsp;&nbsp;</td></tr>';

                    // Display Title
                    $line2 = '<tr><td background="'.osc_base_url().'oc-content/plugins/template_generator/images/bakblue.png" align="center"><p><font size="5" face="verdana" color="lavenderblush">'.$result_desc['s_title'].'</font></p></td></tr>';

                    // Get & store all the image data for the current item
                    if( osc_count_item_resources() > 0 ) {
                        $line3 = '<tr><td background="'.osc_base_url().'oc-content/plugins/template_generator/images/bakblue.png"><table width="500" frame="box" cellpadding="10" bgcolor="white" align="center"><tr><td align="center">';

                        $index=0;
                        while(osc_has_item_resources()) {
                            $line4[$index] = ' <a href="'.$URL.'" target="new"><img src="'.osc_resource_path().osc_resource_id().'_thumbnail.'.osc_resource_extension().'" width="110" border="0"></a>';

                            $index++;
                        }
                        $line5 = '</tr></td></table></td></tr>';
                    }

                    $line6  = '<tr><td background="'.osc_base_url().'oc-content/plugins/template_generator/images/bakblue.png" height="20"></td></tr>';
                    $line6 .= '<tr><td background="'.osc_base_url().'oc-content/plugins/template_generator/images/bakblue.png"><table width="500" frame="box" cellpadding="10" bgcolor="white" align="center"><tr><td><b>Description:</b><br> '.$result_desc['s_description'].'</tr></td></table></td></tr>';

                    $line7  = '<tr><td background="'.osc_base_url().'oc-content/plugins/template_generator/images/bakblue.png" height="20"></td></tr>';
                    $line7 .= '<tr><td background="'.osc_base_url().'oc-content/plugins/template_generator/images/bakblue.png"><table width="500" frame="box" cellpadding="10" bgcolor="#444444" align="center"><tr><td><table width="100%">';
                    $line7 .= '<tr><td><font color="lavenderblush"><b>Price:</b></font></td><td><font color="lavenderblush">'.osc_format_price($result_item['i_price']).'</font></td><td><font color="lavenderblush"><b>Listed Date:</b></font></td><td><font color="lavenderblush">'.$result_item['dt_pub_date'].'</font></td></tr>';
                    $line7 .= '<tr><td><font color="lavenderblush"><b>Location:</b></font></td><td><font color="lavenderblush">'.$result_location['s_city'].', '.$result_location['s_region'].'</font></td><td><font color="lavenderblush"><b>Country:</b></font></td><td><font color="lavenderblush">'.$result_location['s_country'].'</font></td></tr>';
                    $line7 .= '</table></tr></td></table></td></tr>';

                    $line8 = '<tr><td background="'.osc_base_url().'oc-content/plugins/template_generator/images/bottomblue.png" height="41" align="center"><a href="'.$URL.'" target="new"><font face="verdana" color="yellow" size="4">Click For Full Ad Details</font></a></td></tr></table>'; // Closing table statement


                    //GLOBAL $data;
                    $data = $line1.$line2.$line3;
                    for($index=0;$index<count($line4);$index++) {
                        $data .= $line4[$index];
                    }
                    $data .= $line5.$line6.$line7.$line8;


                    echo '<iframe name="my_iframe" width="100%" height="600"></iframe>';

                    echo '<form name="preview" action="'.osc_base_url().'oc-content/plugins/template_generator/preview.php" method="post" target="my_iframe">';
                    echo "<input type='hidden' name='data' id='data' value='".$data."' />";
                    echo '</form>';
                    echo '<script language="javascript" type="text/javascript">document.preview.submit();</script>';   // auto-submit form

                } //end if post item_selection
                ?>



            </div>

            <div class="clear"></div>
        </div></div>
    <!-- end main -->
</div> <!-- end user_account -->
