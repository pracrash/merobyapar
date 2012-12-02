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

osc_show_flash_message() ;

?>
<?php scrolltop(); ?>
<div id="tp_links">
    <div class="wrap">
        <!-- <div class="tp_lft_links">
            <a href="">MERO BYAPAR</a>
        </div> 
        <div class="tp_lf_links">            
            <div class="relative">
                <a href="#" title="Locations" id="dd1" class="dropdown" style="width:170px;text-decoration:none;"><span>Select Location</span></a>
                <div id="dropdown1" class="dropdown-menu">
                    <?php while(osc_has_list_cities() ) { ?>
                    <a href="<?php echo osc_list_city_url() ; ?>" title="<?php echo osc_list_city_name() ; ?>"><?php echo osc_list_city_name() ; ?> (<?php echo osc_list_city_items() ; ?>)</a>

                    <?php } ?>
                </div>
            </div>           
        </div>-->
        <div class="tp_rt_links">
            <!-- <div id="user_menu"> -->
            <?php if(osc_users_enabled()) { ?>
                <?php if( osc_is_web_user_logged_in() ) { ?>
                    <?php profile_picture_show_on_header(); ?><a href="index.php?page=user&action=profile"><?php echo sprintf(__('%s', 'modern'), osc_logged_user_name()); ?></a>
            <a href="<?php echo osc_user_dashboard_url() ; ?>"><?php _e('Dashboard', 'modern') ; ?></a>
                    <?php
                    if(Params::getParam('facebook_login') !== 'true') { ?>
                        <a href="<?php echo osc_user_logout_url() ; ?>"><?php _e('Logout', 'modern') ; ?></a>
                    <?php
                    }else {
                        fb_logout() ;
                    } ?>

            <div id="form_publish">
                <strong class="publish_button">
                    <a id="newpost" href="<?php echo osc_item_post_url() ; ?>" title="Post a new listing"><?php _e('New Post', 'modern'); ?></a>
                </strong>

            </div>
                <?php } else { ?>
            <div class="first logged">
                <!-- <div class="first"> -->
                        <?php if(osc_user_registration_enabled()) { ?>

                <a class="register" href="<?php echo osc_register_account_url() ; ?>"><?php _e('Create New Account', 'modern'); ?></a>
                        <?php }; ?>

                        <?php fbc_button(); ?>
                <!--------------------added by shakeelstha for twitter like login------------------------->
                <div id="topnav" class="topnav" style="margin-right:10px;">
                    <!--Have an account?--> <a href="login" class="signin"><span>Sign in</span></a>
                </div>
            </div>
            <fieldset id="signin_menu">
                <form method="post" id="signin" action="<?php echo osc_base_url(true) ; ?>">
                    <p>
                        <input type="hidden" name="page" value="login" />
                        <input type="hidden" name="action" value="login_post" />
                        <label for="email"><?php _e('Username or email', 'modern') ; ?></label><br />

                                <?php UserForm::email_login_text() ; ?><br/>
                    </p>
                    <p>
                        <label for="password"><?php _e('Password', 'modern') ; ?></label><br />

                                <?php UserForm::password_login_text() ; ?>
                    </p>
                    <p class="remember">
                        <button type="submit" id="signin_submit" value="Sign in" tabindex="6"><?php _e('Sign in', 'modern') ; ?></button>
                                <?php UserForm::rememberme_login_checkbox();?><label for="rememberMe"><?php _e('Remember me', 'modern') ; ?></label>
                    </p>
                    <p class="forgot"> <a id="resend_password_link" href="<?php echo osc_recover_user_password_url() ; ?>"><?php _e("Forgot password?", 'modern');?></a></p>

                </form>
            </fieldset>

                <?php } ?>
            <?php } ?>

        </div>
    </div>
</div>
<!-- container -->
<div class="container">
    <!-- header -->

    <div id="header">
        <div id="tp_main_adverts"><?php banner_advertisement(); ?></div>
        <div id="logo">
            <h1>Classified</h1>
            <a id="logo" href="<?php echo osc_base_url() ; ?>"><?php echo logo_header(); ?></a>

            <div id="menu1">
                <div class="relative">
                    <a href="#" title="Locations" id="dd1" class="dropdown" style="width:170px;text-decoration:none;"><span>Select Location</span></a>
                    <div id="dropdown1" class="dropdown-menu">
                        <?php while(osc_has_list_cities() ) { ?>
                        <a href="<?php echo osc_list_city_url() ; ?>" title="<?php echo osc_list_city_name() ; ?>"><?php echo osc_list_city_name() ; ?> <!-- (<?php //echo osc_list_city_items() ; ?>) --></a>

                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <ul id="navigation" class="clearall">
            <li><a href="<?php echo osc_base_url() ; ?>">Home</a></li>
            <li><a href="index.php?page=page&id=21">About Us</a></li>
            <li><a href="index.php?page=shop">Shops</a></li>
            <!--<li><a href="index.php?page=hnr">Hotels &amp; Restaurants</a></li>
            <li><a href="index.php?page=event">Events</a></li>-->
            <li><a href="<?php echo osc_contact_url(); ?>"><?php _e('Contact Us', 'modern') ; ?></a></li>
        </ul>