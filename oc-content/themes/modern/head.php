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
?>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />

<title><?php echo meta_title() ; ?></title>
<meta name="title" content="<?php echo osc_esc_html(meta_title()); ?>" />
<?php if( meta_description() != '' ) { ?>
<meta name="description" content="<?php echo osc_esc_html(meta_description()); ?>" />
<?php } ?>
<?php if( function_exists('meta_keywords') ) { ?>
    <?php if( meta_keywords() != '' ) { ?>
<meta name="keywords" content="<?php echo osc_esc_html(meta_keywords()); ?>" />
    <?php } ?>
<?php } ?>
<?php if( osc_get_canonical() != '' ) { ?>
<link rel="canonical" href="<?php echo osc_get_canonical(); ?>"/>
<?php } ?>
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Expires" content="Fri, Jan 01 1970 00:00:00 GMT" />

<!-- favicons
        ================================================== -->
<meta name="apple-mobile-web-app-capable" content="yes" />
<link rel="shortcut icon" href="<?php echo osc_current_admin_theme_url('images/favicon-48.png'); ?>">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo osc_current_admin_theme_url('images/favicon-144.png'); ?>">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo osc_current_admin_theme_url('images/favicon-114.png'); ?>">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo osc_current_admin_theme_url('images/favicon-72.png'); ?>">
<link rel="apple-touch-icon-precomposed" href="<?php echo osc_current_admin_theme_url('images/favicon-57.png'); ?>">

<!-- css -->
<link rel="stylesheet" type="text/css" href="<?php echo osc_current_web_theme_url('bootstrap.min.css') ; ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo osc_current_web_theme_js_url('chosen/chosen.css') ; ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo osc_current_web_theme_styles_url('custom.css') ; ?>" />
<link href="<?php echo osc_current_web_theme_url('style.css') ; ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo osc_current_web_theme_url('tabs.css') ; ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo osc_current_web_theme_url('global.css') ; ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo osc_current_web_theme_url('reset.css') ; ?>" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="<?php echo osc_current_web_theme_url('css/login/front.css') ; ?>" />
<!-- <link rel="stylesheet" type="text/css" href="<?php echo osc_current_web_theme_url('css/login/tipsy.css') ; ?>" /> -->

<script type="text/javascript">
    var fileDefaultText = '<?php echo osc_esc_js( __('No file selected', 'modern') ) ; ?>';
    var fileBtnText     = '<?php echo osc_esc_js( __('Choose File', 'modern') ) ; ?>';
</script>
<!-- js -->
<script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('jquery.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('jquery-ui.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('jquery.uniform.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('tabber-minimized.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('global.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('chosen/chosen.min.js') ; ?>"></script>

<script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('login/jquery.pop.js') ; ?>"></script>
<!-- <script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('login/jquery.tipsy.js') ; ?>"></script> -->

<script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('image_preview/main.js') ; ?>"></script>

<script type="text/javascript">
    $(".chzn-select").chosen();
    $(".chzn-select-deselect").chosen({allow_single_deselect:true});
</script>

<script type="text/javascript">
    $(document).ready(function() {
    
        $(".signin").click(function(e) {
            e.preventDefault();
            $("fieldset#signin_menu").toggle();
            $(".signin").toggleClass("menu-open");
        });

        $("fieldset#signin_menu").mouseup(function() {
            return false
        });
        $(document).mouseup(function(e) {
            if($(e.target).parent("a.signin").length==0) {
                $(".signin").removeClass("menu-open");
                $("fieldset#signin_menu").hide();
            }
        });

    });


    $(document).ready(function() {
        /* for keeping track of what's "open" */
        var activeClass = 'dropdown-active', showingDropdown, showingMenu, showingParent;
        /* hides the current menu */
        var hideMenu = function() {
            if(showingDropdown) {
                showingDropdown.removeClass(activeClass);
                showingMenu.hide();
            }
        };

        /* recurse through dropdown menus */
        $('.dropdown').each(function() {
            /* track elements: menu, parent */
            var dropdown = $(this);
            var menu = dropdown.next('div.dropdown-menu'), parent = dropdown.parent();
            /* function that shows THIS menu */
            var showMenu = function() {
                hideMenu();
                showingDropdown = dropdown.addClass('dropdown-active');
                showingMenu = menu.show();
                showingParent = parent;
            };
            /* function to show menu when clicked */
            dropdown.bind('click',function(e) {
                if(e) e.stopPropagation();
                if(e) e.preventDefault();
                showMenu();
            });
            /* function to show menu when someone tabs to the box */
            dropdown.bind('focus',function() {
                showMenu();
            });
        });

        /* hide when clicked outside */
        $(document.body).bind('click',function(e) {
            if(showingParent) {
                var parentElement = showingParent[0];
                if(!$.contains(parentElement,e.target) || !parentElement == e.target) {
                    hideMenu();
                }
            }
        });
    });

//    $(function() {
//        $('#newpost').tipsy({gravity: 'n'},{fade: true}); // nw | n | ne | w | e | sw | s | se
//    }
</script>

<!--[if lt IE 9]>
    <script src="js/html5.js"></script>
<![endif]-->

<?php osc_run_hook('header') ; ?>