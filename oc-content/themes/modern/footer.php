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

osc_show_widgets('footer');
$sQuery = osc_esc_js(osc_get_preference('keyword_placeholder', 'modern_theme'));
?>
<!-- footer -->

<div id="footer" class="clearall">
<div id="socialLinks">
            <!-- <a class="twit" href="#">Twitter</a> -->
            <a class="fb" href="http://www.facebook.com/merobyapar" target="_blank">Facebook</a>
            <!-- <a class="youtube" href="#">YouTube</a> -->
            <a class="sendemal" href="<?php echo osc_contact_url(); ?>">Send Email</a>
            <a class="rss" href="/feed">RSS</a>
        </div>

    <p>Mero Byapar Pvt. Ltd. &nbsp;&nbsp; Archal Bot, Pokhara, Nepal &nbsp;&nbsp; Tel: 977-061-21855</p>
        
        <a href="<?php echo osc_contact_url(); ?>"><?php _e('Contact Us', 'modern') ; ?></a>
        <?php osc_reset_static_pages() ; ?>
        <?php while( osc_has_static_pages() ) { ?>
        | <a href="<?php echo osc_static_page_url() ; ?>"><?php echo osc_static_page_title() ; ?></a>
        <?php } ?>
        &nbsp;| &nbsp;<a href="/feed">RSS</a>
        <?php
        if( osc_get_preference('footer_link', 'modern_theme') ) {
        }
        ?><br />

        Copyright &copy; 2012 Mero Byapar Pvt. Ltd. &nbsp; All rights reserved.<br />
    <div class="clearall"></div>
    <p class="contentFooter"></p>
</div>

<!-- /footer -->

<!-- /container -->
<script type="text/javascript">
    var sQuery = '<?php echo $sQuery ; ?>' ;
    function doSearch() {
        if($('input[name=sPattern]').val() == sQuery || ( $('input[name=sPattern]').val() != '' && $('input[name=sPattern]').val().length < 3 ) ) {
            $('input[name=sPattern]').css('background', '#FFC6C6');
            $('#search-example').text('<?php echo osc_esc_js( __('Your search must be at least three characters long','modern') ) ; ?>')
            return false;
        }
        return true;
    }
</script>
<?php osc_run_hook('footer') ; ?>