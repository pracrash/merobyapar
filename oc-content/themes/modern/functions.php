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

define('MODERN_THEME_VERSION', '3.0');

if( !OC_ADMIN ) {
    if( !function_exists('add_close_button_action') ) {
        function add_close_button_action() {
            echo '<script type="text/javascript">';
            echo '$(".flashmessage .ico-close").click(function(){';
            echo '$(this).parent().hide();';
            echo '});';
            echo '</script>';
        }
        osc_add_hook('footer', 'add_close_button_action') ;
    }
}

function theme_modern_actions_admin() {
    switch( Params::getParam('action_specific') ) {
        case('settings'):
            $footerLink = Params::getParam('footer_link');
            osc_set_preference('keyword_placeholder', Params::getParam('keyword_placeholder'), 'modern_theme');
            osc_set_preference('footer_link', ($footerLink ? '1' : '0'), 'modern_theme');

            osc_add_flash_ok_message(__('Theme settings updated correctly', 'modern'), 'admin');
            header('Location: ' . osc_admin_render_theme_url('oc-content/themes/modern/admin/settings.php')); exit;
            break;
        case('upload_logo'):
            $package = Params::getFiles('logo');
            if( $package['error'] == UPLOAD_ERR_OK ) {
                if( move_uploaded_file($package['tmp_name'], WebThemes::newInstance()->getCurrentThemePath() . "images/logo.jpg" ) ) {
                    osc_add_flash_ok_message(__('The logo image has been uploaded correctly', 'modern'), 'admin');
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again", 'modern'), 'admin');
                }
            } else {
                osc_add_flash_error_message(__("An error has occurred, please try again", 'modern'), 'admin');
            }
            header('Location: ' . osc_admin_render_theme_url('oc-content/themes/modern/admin/header.php')); exit;
            break;
        case('remove'):
            if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/logo.jpg" ) ) {
                @unlink( WebThemes::newInstance()->getCurrentThemePath() . "images/logo.jpg" );
                osc_add_flash_ok_message(__('The logo image has been removed', 'modern'), 'admin');
            } else {
                osc_add_flash_error_message(__("Image not found", 'modern'), 'admin');
            }
            header('Location: ' . osc_admin_render_theme_url('oc-content/themes/modern/admin/header.php')); exit;
            break;
    }
}
osc_add_hook('init_admin', 'theme_modern_actions_admin');
osc_admin_menu_appearance(__('Manage Header Logo', 'modern'), osc_admin_render_theme_url('oc-content/themes/modern/admin/header.php'), 'header_modern');
osc_admin_menu_appearance(__('Search Tag Settings', 'modern'), osc_admin_render_theme_url('oc-content/themes/modern/admin/settings.php'), 'settings_modern');

if( !function_exists('logo_header') ) {
    function logo_header() {
        $html = '<img border="0" alt="' . osc_page_title() . '" src="' . osc_current_web_theme_url('images/logo.jpg') . '" />';
        if( file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/logo.jpg" ) ) {
            return $html;
        } else {
            return osc_page_title();
        }
    }
}

// install update options
if( !function_exists('modern_theme_install') ) {
    function modern_theme_install() {
        osc_set_preference('keyword_placeholder', __('ie. Search Keywords', 'modern'), 'modern_theme');
        osc_set_preference('version', MODERN_THEME_VERSION, 'modern_theme');
        osc_set_preference('footer_link', true, 'modern_theme');
    }
}

if(!function_exists('check_install_modern_theme')) {
    function check_install_modern_theme() {
        $current_version = osc_get_preference('version', 'modern_theme');
        //check if current version is installed or need an update<
        if( !$current_version ) {
            modern_theme_install();
        }
    }
}
check_install_modern_theme();


function chosen_city_select() {
    View::newInstance()->_exportVariableToView('list_cities', Search::newInstance()->listCities('%%%%', '>=', 'city_name ASC') ) ;

    if( osc_count_list_cities() > 0 ) {
        echo '<select name="sRegion" data-placeholder="' . __('Select a region...', 'twitter') . '" style="width: 100px;" class="chzn-select"">' ;
        echo '<option></option>' ;
        while( osc_has_list_cities() ) {
            echo '<option value="' . osc_list_city_name() . '">' . osc_list_city_name() . '</option>' ;
        }
        echo '</select>' ;
    }

    View::newInstance()->_erase('list_cities') ;
}

	/*----------added by shakeelstha on 27th July 2012 for feching subcategories from one category, has been called in search.php------------------*/
if( !function_exists('get_categoriesHierarchy') ) {
    function get_categoriesHierarchy( ) {
        $location = Rewrite::newInstance()->get_location() ;
        $section  = Rewrite::newInstance()->get_section() ;

        if ( $location != 'search' ) {
            return false ;
        }

        $category_id = osc_search_category_id() ;

        if(count($category_id) > 1) {
            return false;
        }

        $category_id = (int) $category_id[0] ;

        $categoriesHierarchy = Category::newInstance()->hierarchy($category_id) ;

        foreach($categoriesHierarchy as &$category) {
            $category['url'] = get_category_url($category) ;
        }

        return $categoriesHierarchy ;
    }
}


if( !function_exists('get_subcategories') ) {
    function get_subcategories( ) {
        $location = Rewrite::newInstance()->get_location() ;
        $section  = Rewrite::newInstance()->get_section() ;

        if ( $location != 'search' ) {
            return false ;
        }

        $category_id = osc_search_category_id() ;

        if(count($category_id) > 1) {
            return false ;
        }

        $category_id = (int) $category_id[0] ;

        $subCategories = Category::newInstance()->findSubcategories($category_id) ;

        foreach($subCategories as &$category) {
            $category['url'] = get_category_url($category) ;
        }

        return $subCategories ;
    }
}


if ( !function_exists('get_category_url') ) {
    function get_category_url( $category ) {
        $path = '';
        if ( osc_rewrite_enabled() ) {
            if ($category != '') {
                $category = Category::newInstance()->hierarchy($category['pk_i_id']) ;
                $sanitized_category = "" ;
                for ($i = count($category); $i > 0; $i--) {
                    $sanitized_category .= $category[$i - 1]['s_slug'] . '/' ;
                }
                $path = osc_base_url() . $sanitized_category ;
            }
        } else {
            $path = sprintf( osc_base_url(true) . '?page=search&sCategory=%d', $category['pk_i_id'] ) ;
        }

        return $path;
    }
}

if ( !function_exists('get_category_num_items') ) {
    function get_category_num_items( $category ) {
        $category_stats = CategoryStats::newInstance()->countItemsFromCategory($category['pk_i_id']) ;

        if( empty($category_stats) ) {
            return 0 ;
        }

        return $category_stats;
    }
}
	/*************************************************************************************************************/
	/***********added by shakeelstha for repurpose theme like search***********************************/
function chosen_select_standard() {
    View::newInstance()->_exportVariableToView('categories', Category::newInstance()->toTree() ) ;

    if( osc_count_categories() > 0 ) {
        echo '<select name="sCategory" data-placeholder="' . __('Select a category...', 'modern') . '" style="width: auto;" class="chzn-select"">' ;
        echo '<option></option>' ;
        while( osc_has_categories() ) {
            echo '<option value="' . osc_category_id() . '">' . osc_category_name() . '</option>' ;
            if( osc_count_subcategories() > 0 ) {
                while( osc_has_subcategories() ) {
                    echo '<option value="' . osc_category_id() . '">&nbsp;&nbsp;&nbsp;&nbsp;' . osc_category_name() . '</option>' ;
                }
            }
        }
        echo '</select>' ;
    }

    View::newInstance()->_erase('categories') ;
}
	/************added by shakeelstha for printing category name of item*****************/
if( !function_exists('osc_item_category_url') ) {
    function osc_item_category_url($category_id) {
        View::newInstance()->_erase('subcategories') ;
        View::newInstance()->_erase('categories') ;
        View::newInstance()->_exportVariableToView('category', Category::newInstance()->findByPrimaryKey($category_id) ) ;
        $url = osc_search_category_url() ;
        View::newInstance()->_erase('category') ;

        return $url ;
    }
}


	/********************added by shakeelstha for multiple category select for userprofile page***************/

function chosen_multi_select_standard($user_categories) {
    View::newInstance()->_exportVariableToView('categories', Category::newInstance()->toTree() ) ;

    if( osc_count_categories() > 0 ) {
        //echo '<select id="multiselect_sCategory" name="multiselect_sCategory" multiple="multiple">' ;
        /*** Use [] in multiselect_sCategory to make it an array while passing through POST .. by prakash ***/
        echo '<select id="multiselect_sCategory" name="multiselect_sCategory[]" multiple="multiple">' ;

        while( osc_has_categories() ) {
            $selected = '';
            foreach($user_categories as $user_category) {
                if($user_category['fk_i_category_id'] == osc_category_id()) {
                    $selected = 'selected="selected"';
                    break;
                }
            }
            echo '<option value="' . osc_category_id() . '" '.$selected.'>' . osc_category_name() . '</option>' ;
                /*if( osc_count_subcategories() > 0 ) {
                    while( osc_has_subcategories() ) {
                        echo '<option value="' . osc_category_name() . '">&nbsp;&nbsp;&nbsp;&nbsp;' . osc_category_name() . '</option>' ;
                    }
                } */
        }
        echo '</select>' ;
    }

    View::newInstance()->_erase('categories') ;
}

if( !function_exists('list_shops') ) {
    function list_shops() {
        $conn = getConnection();
        $alphabet = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        foreach ($alphabet as $letter) {
            $companylist=User::newInstance()->findByUserType("1", $letter);
            if(count($companylist) >0) {
                echo "<div class='alphaList'><h3 class='letterTitle'>$letter</h3><ul>"."";
                echo '<li><a href=index.php?page=user&action=pub_profile&id='.$companylist['pk_i_id'].'>'.$companylist['s_name'].'</a></li><li></li><li></li>';
                echo "</ul></div>";
            }else {
            
            }       
        }
    }
}

if( !function_exists('list_hnr') ) {
    function list_hnr() {
        $conn = getConnection();

        $result=$conn->osc_dbFetchResults("SELECT u.pk_i_id, u.s_name FROM ".DB_TABLE_PREFIX."t_user u, ".DB_TABLE_PREFIX."t_user_sell_category s WHERE s.fk_i_category_id = '%d' AND u.pk_i_id=s.fk_i_user_id ", '205');
        
        return $result;
    }
}

if( !function_exists('list_event') ) {
    function list_event() {
        $conn = getConnection();
        
        $result=$conn->osc_dbFetchResults("SELECT u.pk_i_id, u.s_name FROM ".DB_TABLE_PREFIX."t_user u, ".DB_TABLE_PREFIX."t_user_sell_category s WHERE s.fk_i_category_id = '%d' AND u.pk_i_id=s.fk_i_user_id ", '204');
        
        return $result;
    }
}

if( !function_exists('vertical_rightbar_advertisement') ) {
    function vertical_rightbar_advertisement() {
        ?>
<script type='text/javascript'>
    jQuery(document).ready(function(){
        /* featured listings slider */
        jQuery(".v_sidebar_ads").jCarouselLite({
            btnNext: ".nextCarousel",
            btnPrev: ".prevCarousel",
            //scroll: 2, //this works
            visible: 1,
            hoverPause:true,
            auto: 5000 ,
            speed: 1100,
            vertical: true        //easing: "easeOutQuint" // for different types of easing, see easing.js
        });
    });
</script>
        <?php
        $folder = opendir(osc_base_path()."oc-content/themes/modern/vertical_sidebar_advertisement");
        //// Use 'opendir(".")' if the PHP file is in the same folder as your images.
        //Or set a relative path 'opendir("../path/to/folder")'.
        $pic_types = array("jpg", "jpeg");
        $index = array();
        $total=0;
        while ($file = readdir ($folder)) {
            if(in_array(substr(strtolower($file), strrpos($file,".") + 1),$pic_types)) {
                array_push($index,$file);
                $total++;
            }
        }
        shuffle($index);
        closedir($folder);
        ?>
<a href="#" class="prev">&nbsp</a>
<div class="v_sidebar_ads">
    <ul>
                <?php
                for($i=0;$i<$total; $i++) {
                    ?>
        <li style="overflow: hidden; float: left; width: 230px; height: 175px;"><img src="<?php echo osc_current_web_theme_url('vertical_sidebar_advertisement')."/".$index[$i]; ?>"/></li>
                    <?php
                    }
                    ?>
    </ul>
</div>
<a href="#" class="next">&nbsp</a>
    <?php
    }
}

if( !function_exists('horiz_long_advertisement') ) {
    function horiz_long_advertisement() {

        $folder = opendir(osc_base_path()."oc-content/themes/modern/horiz_long_advertisement");
        //// Use 'opendir(".")' if the PHP file is in the same folder as your images.
        //Or set a relative path 'opendir("../path/to/folder")'.
        $pic_types = array("jpg", "jpeg");
        $index = array();
        $total=0;
        while ($file = readdir ($folder)) {
            if(in_array(substr(strtolower($file), strrpos($file,".") + 1),$pic_types)) {
                array_push($index,$file);
                $total++;
            }
        }
        $i = array_rand($index, 1);
        closedir($folder);
        ?>

<div class="h_long_ads">

            <?php

            ?>
    <img src="<?php echo osc_current_web_theme_url('horiz_long_advertisement')."/".$index[$i]; ?>"/>
            <?php

            ?>

</div>

    <?php
    }
}

if( !function_exists('banner_advertisement') ) {
    function banner_advertisement() {

        $folder = opendir(osc_base_path()."oc-content/themes/modern/banner_advertisement");
        //// Use 'opendir(".")' if the PHP file is in the same folder as your images.
        //Or set a relative path 'opendir("../path/to/folder")'.
        $pic_types = array("jpg", "jpeg");
        $index = array();
        $total=0;
        while ($file = readdir ($folder)) {
            if(in_array(substr(strtolower($file), strrpos($file,".") + 1),$pic_types)) {
                array_push($index,$file);
                $total++;
            }
        }
        $i = array_rand($index, 1);
        closedir($folder);
        ?>

<div class="h_long_ads">

            <?php

            ?>
    <img src="<?php echo osc_current_web_theme_url('banner_advertisement')."/".$index[$i]; ?>"/>
            <?php

            ?>

</div>

    <?php
    }
}
if( !function_exists('get_profile_pic') ) {
    function get_profile_pic($profileid) {
        $width = '150';
        $height = '';
        $conn = getConnection();


        $result=$conn->osc_dbFetchResult("SELECT user_id, pic_ext FROM %st_profile_picture WHERE user_id = '%d' ", DB_TABLE_PREFIX, $profileid);

        if($result>0) //if picture exists
        {
            echo '<img src="'.osc_base_url() . 'oc-content/plugins/profile_picture/images/profile'.$profileid.$result['pic_ext'].'" width="'.$width.'" height="'.$height.'" class="imgBrd">';
        }else{
            echo '<img src="'.osc_base_url() . 'oc-content/plugins/profile_picture/no_picture.jpg" width="'.$width.'" height="'.$height.'" class="imgBrd">';
        }
    }
}
?>
<?php osc_remove_hook('item_detail', 'voting_item_detail_user'); ?>