<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

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

    Class ItemActions
    {
        private $manager = null;
        var $is_admin ;
        var $data;

        function __construct($is_admin) {
            $this->is_admin = $is_admin ;
            $this->manager = Item::newInstance() ;   
        }

        /**
         * @return boolean
         */
        public function add()
        {
            $success     = true;
            $aItem       = $this->data;
            
            $code        = osc_genRandomPassword();
            $flash_error = '';

            // Requires email validation?
            $has_to_validate = (osc_moderate_items() != -1) ? true : false ;

            // Check status
            $active = $aItem['active'];

            // Sanitize
            foreach(@$aItem['title'] as $key=>$value) {
                $aItem['title'][$key] = strip_tags( trim ( $value ) );
            }

            $aItem['price']    = !is_null($aItem['price']) ? strip_tags( trim( $aItem['price'] ) ) : $aItem['price'];
            $contactName       = osc_sanitize_name( strip_tags( trim( $aItem['contactName'] ) ) );
            $contactEmail      = strip_tags( trim( $aItem['contactEmail'] ) );
            $aItem['cityArea'] = osc_sanitize_name( strip_tags( trim( $aItem['cityArea'] ) ) );
            $aItem['address']  = osc_sanitize_name( strip_tags( trim( $aItem['address'] ) ) );

            // Anonymous
            $contactName = (osc_validate_text($contactName,3))? $contactName : __("Anonymous");

            // Validate
            if ( !$this->checkAllowedExt($aItem['photos']) ) {
                $flash_error .= _m("Image with an incorrect extension.") . PHP_EOL;
            }
            if ( !$this->checkSize($aItem['photos']) ) {
                $flash_error .= _m("Image is too big. Max. size") . osc_max_size_kb() ." Kb" . PHP_EOL;
            }

            $title_message = '';
            foreach(@$aItem['title'] as $key => $value) {
                if( osc_validate_text($value, 1) && osc_validate_max($value, 100) ) {
                    $title_message = '';
                    break;
                }

                $title_message .=
                    (!osc_validate_text($value, 1) ? _m("Title too short.") . PHP_EOL : '' ) .
                    (!osc_validate_max($value, 100) ? _m("Title too long.") . PHP_EOL : '' );
            }
            $flash_error .= $title_message;

            $desc_message = '';
            foreach(@$aItem['description'] as $key => $value) {
                if( osc_validate_text($value, 3) &&  osc_validate_max($value, 5000) )  {
                    $desc_message = '';
                    break;
                }

                $desc_message .=
                    (!osc_validate_text($value, 3) ? _m("Description too short.") . PHP_EOL : '' ) .
                    (!osc_validate_max($value, 5000) ? _m("Description too long."). PHP_EOL : '' );
            }
            $flash_error .= $desc_message;

            $flash_error .=
                ((!osc_validate_category($aItem['catId'])) ? _m("Category invalid.") . PHP_EOL : '' ) .
                ((!osc_validate_number($aItem['price'])) ? _m("Price must be a number.") . PHP_EOL : '' ) .
                ((!osc_validate_max($aItem['price'], 15)) ? _m("Price too long.") . PHP_EOL : '' ) .
                ((!osc_validate_max($contactName, 35)) ? _m("Name too long.") . PHP_EOL : '' ) .
                ((!osc_validate_email($contactEmail)) ? _m("Email invalid.") . PHP_EOL : '' ) .
                ((!osc_validate_text($aItem['countryName'], 3, false)) ? _m("Country too short.") . PHP_EOL : '' ) .
                ((!osc_validate_max($aItem['countryName'], 50)) ? _m("Country too long.") . PHP_EOL : '' ) .
                ((!osc_validate_text($aItem['regionName'], 3, false)) ? _m("Region too short.") . PHP_EOL : '' ) .
                ((!osc_validate_max($aItem['regionName'], 50)) ? _m("Region too long.") . PHP_EOL : '' ) .
                ((!osc_validate_text($aItem['cityName'], 3, false)) ? _m("City too short.") . PHP_EOL : '' ) .
                ((!osc_validate_max($aItem['cityName'], 50)) ? _m("City too long.") . PHP_EOL : '' ) .
                ((!osc_validate_text($aItem['cityArea'], 3, false)) ? _m("Municipality too short.") . PHP_EOL : '' ) .
                ((!osc_validate_max($aItem['cityArea'], 50)) ? _m("Municipality too long.") . PHP_EOL : '' ) .
                ((!osc_validate_text($aItem['address'], 3, false)) ? _m("Address too short.") . PHP_EOL : '' ) .
                ((!osc_validate_max($aItem['address'], 100)) ? _m("Address too long.") . PHP_EOL : '' ) .
                ((((time() - Session::newInstance()->_get('last_submit_item')) < osc_items_wait_time()) && !$this->is_admin) ? _m("Too fast. You should wait a little to publish your ad.") . PHP_EOL : '' );

            $_meta = Field::newInstance()->findByCategory($aItem['catId']);
            $meta = Params::getParam("meta");
            foreach($_meta as $_m) {
                $meta[$_m['pk_i_id']] = (isset($meta[$_m['pk_i_id']]))?$meta[$_m['pk_i_id']]:'';
            }
            if($meta!='' && count($meta)>0) {
                $mField = Field::newInstance();
                foreach($meta as $k => $v) {
                    if($v=='') {
                        $field = $mField->findByPrimaryKey($k);
                        if($field['b_required']==1) {
                            $flash_error .= sprintf(_m("%s field is required."), $field['s_name']);
                        }
                    }
                }
            };

            // hook pre add or edit
            osc_run_hook('pre_item_post') ;

            // Handle error
            if ($flash_error) {
                return $flash_error;
            } else {
                if($aItem['price']!='') {
                    $aItem['currency'] = $aItem['currency'];
                } else {
                    $aItem['currency'] = NULL;
                }

                $this->manager->insert(array(
                    'fk_i_user_id'          => $aItem['userId'],
                    'dt_pub_date'           => date('Y-m-d H:i:s'),
                    'fk_i_category_id'      => $aItem['catId'],
                    'i_price'               => $aItem['price'],
                    'fk_c_currency_code'    => $aItem['currency'],
                    's_contact_name'        => $contactName,
                    's_contact_email'       => $contactEmail,
                    's_secret'              => $code,
                    'b_active'              => ($active=='ACTIVE'?1:0),
                    'b_enabled'             => 1,
                    'b_show_email'          => $aItem['showEmail']
                ));

                if(!$this->is_admin) {
                    // Track spam delay: Session
                    Session::newInstance()->_set('last_submit_item', time()) ;
                    // Track spam delay: Cookie
                    Cookie::newInstance()->set_expires( osc_time_cookie() ) ;
                    Cookie::newInstance()->push('last_submit_item', time()) ;
                    Cookie::newInstance()->set() ;
                }

                $itemId = $this->manager->dao->insertedId();
                Log::newInstance()->insertLog('item', 'add', $itemId, current(array_values($aItem['title'])), $this->is_admin?'admin':'user', $this->is_admin?osc_logged_admin_id():osc_logged_user_id());

                // update dt_expiration at t_item
                $_category = Category::newInstance()->findByPrimaryKey($aItem['catId']);
                // update dt_expiration 
                $i_expiration_days = $_category['i_expiration_days'];
                $dt_expiration = Item::newInstance()->updateExpirationDate($itemId, $i_expiration_days);
                
                Params::setParam('itemId', $itemId);

                // INSERT title and description locales
                $this->insertItemLocales('ADD', $aItem['title'], $aItem['description'], $itemId );
                // INSERT location item
                // when id location is null, check locations_name
//                if($aItem['countryId']==''){
//                    $aItem['countryId'] = Country::newInstance();
//                }

                $location = array(
                    'fk_i_item_id'      => $itemId,
                    'fk_c_country_code' => $aItem['countryId'],
                    's_country'         => $aItem['countryName'],
                    'fk_i_region_id'    => $aItem['regionId'],
                    's_region'          => $aItem['regionName'],
                    'fk_i_city_id'      => $aItem['cityId'],
                    's_city'            => $aItem['cityName'],
                    's_city_area'       => $aItem['cityArea'],
                    's_address'         => $aItem['address']
                );

                $locationManager = ItemLocation::newInstance();
                $locationManager->insert($location);

                $this->uploadItemResources( $aItem['photos'] , $itemId ) ;

                /**
                 * META FIELDS
                 */
                if($meta!='' && count($meta)>0) {
                    $mField = Field::newInstance();
                    foreach($meta as $k => $v) {
                        $mField->replace($itemId, $k, $v);
                    }
                }
                osc_run_hook('item_form_post', $aItem['catId'], $itemId);
                
                // We need at least one record in t_item_stats
                $mStats = new ItemStats();
                $mStats->emptyRow($itemId);

                $item = $this->manager->findByPrimaryKey($itemId);
                $aItem['item'] = $item;

                osc_run_hook('after_item_post') ;

                Session::newInstance()->_set('last_publish_time', time());
                if(!$this->is_admin) {
                    $this->sendEmails($aItem);
                }
                if($active=='INACTIVE') {
                    return 1;
                } else {
                    $aAux = array(
                        'fk_i_user_id'      => $aItem['userId'],
                        'fk_i_category_id'  => $aItem['catId'],
                        'fk_c_country_code' => $location['fk_c_country_code'],
                        'fk_i_region_id'    => $location['fk_i_region_id'],
                        'fk_i_city_id'      => $location['fk_i_city_id']
                    );
                    $this->_increaseStats($aAux);
                    return 2;
                }
            }
            return $success;
        }

        function edit() {
            $aItem       = $this->data;
            $flash_error = '';

            // Sanitize
            foreach(@$aItem['title'] as $key=>$value) {
                $aItem['title'][$key] = strip_tags( trim ( $value ) );
            }

            $aItem['price']    = !is_null($aItem['price']) ? strip_tags( trim( $aItem['price'] ) ) : $aItem['price'];
            $aItem['cityArea'] = osc_sanitize_name( strip_tags( trim( $aItem['cityArea'] ) ) );
            $aItem['address']  = osc_sanitize_name( strip_tags( trim( $aItem['address'] ) ) );

            // Validate
            if ( !$this->checkAllowedExt($aItem['photos']) ) {
                $flash_error .= _m("Image with an incorrect extension.") . PHP_EOL;
            }
            if ( !$this->checkSize($aItem['photos']) ) {
                $flash_error .= _m("Image is too big. Max. size") . osc_max_size_kb() . " Kb" . PHP_EOL;
            }

            $title_message  = '';
            $td_message     = '';
            foreach(@$aItem['title'] as $key => $value) {
                if( osc_validate_text($value, 1) && osc_validate_max($value, 100) ) {
                    $td_message = '';
                    break;
                }

                $td_message .=
                    (!osc_validate_text($value, 1) ? _m("Title too short.") . PHP_EOL : '' ) .
                    (!osc_validate_max($value, 100) ? _m("Title too long.") . PHP_EOL : '' );
            }
            $flash_error .= $td_message;

            $desc_message = '';
            foreach(@$aItem['description'] as $key => $value) {
                if( osc_validate_text($value, 3) &&  osc_validate_max($value, 5000) )  {
                    $desc_message = '';
                    break;
                }

                $desc_message .=
                    (!osc_validate_text($value, 3) ? _m("Description too short.") . PHP_EOL : '' ) .
                    (!osc_validate_max($value, 5000) ? _m("Description too long."). PHP_EOL : '' );
            }
            $flash_error .= $desc_message;

            $flash_error .=
                ((!osc_validate_category($aItem['catId'])) ? _m("Category invalid.") . PHP_EOL : '' ) .
                ((!osc_validate_number($aItem['price'])) ? _m("Price must be a number.") . PHP_EOL : '' ) .
                ((!osc_validate_max($aItem['price'], 15)) ? _m("Price too long.") . PHP_EOL : '' ) .
                ((!osc_validate_text($aItem['countryName'], 3, false)) ? _m("Country too short.") . PHP_EOL : '' ) .
                ((!osc_validate_max($aItem['countryName'], 50)) ? _m("Country too long.") . PHP_EOL : '' ) .
                ((!osc_validate_text($aItem['regionName'], 3, false)) ? _m("Region too short.") . PHP_EOL : '' ) .
                ((!osc_validate_max($aItem['regionName'], 50)) ? _m("Region too long.") . PHP_EOL : '' ) .
                ((!osc_validate_text($aItem['cityName'], 3, false)) ? _m("City too short.") . PHP_EOL : '' ) .
                ((!osc_validate_max($aItem['cityName'], 50)) ? _m("City too long.") . PHP_EOL : '' ) .
                ((!osc_validate_text($aItem['cityArea'], 3, false)) ? _m("Municipality too short.") . PHP_EOL : '' ) .
                ((!osc_validate_max($aItem['cityArea'], 50)) ? _m("Municipality too long.") . PHP_EOL : '' ) .
                ((!osc_validate_text($aItem['address'], 3, false))? _m("Address too short.") . PHP_EOL : '' ) .
                ((!osc_validate_max($aItem['address'], 100)) ? _m("Address too long.") . PHP_EOL : '' );

            
            $_meta = Field::newInstance()->findByCategory($aItem['catId']);
            $meta = Params::getParam("meta");
            foreach($_meta as $_m) {
                $meta[$_m['pk_i_id']] = (isset($meta[$_m['pk_i_id']]))?$meta[$_m['pk_i_id']]:'';
            }
            if($meta!='' && count($meta)>0) {
                $mField = Field::newInstance();
                foreach($meta as $k => $v) {
                    if($v=='') {
                        $field = $mField->findByPrimaryKey($k);
                        if($field['b_required']==1) {
                            $flash_error .= sprintf(_m("%s field is required."), $field['s_name']);
                        }
                    }
                }
            };

            // hook pre add or edit
            osc_run_hook('pre_item_post') ;
            
            // Handle error
            if ($flash_error) {
                return $flash_error ;
            } else {
                $location = array(
                    'fk_c_country_code' => $aItem['countryId'],
                    's_country'         => $aItem['countryName'],
                    'fk_i_region_id'    => $aItem['regionId'],
                    's_region'          => $aItem['regionName'],
                    'fk_i_city_id'      => $aItem['cityId'],
                    's_city'            => $aItem['cityName'],
                    's_city_area'       => $aItem['cityArea'],
                    's_address'         => $aItem['address']
                );  
                
                $locationManager = ItemLocation::newInstance();
                $old_item_location = $locationManager->findByPrimaryKey($aItem['idItem']);
                
                $locationManager->update( $location, array( 'fk_i_item_id' => $aItem['idItem'] ) );

                $old_item = $this->manager->findByPrimaryKey( $aItem['idItem'] ) ;
                
                if($aItem['userId'] != '') {
                    $user = User::newInstance()->findByPrimaryKey( $aItem['userId'] );
                    $aItem['userId']      = $aItem['userId'];
                    $aItem['contactName'] = $user['s_name'] ;
                    $aItem['contactEmail'] = $user['s_email'];
                } else {
                    $aItem['userId']      = NULL;
                }

                if($aItem['price']!='') {
                    $aItem['currency'] = $aItem['currency'];
                } else {
                    $aItem['currency'] = NULL;
                }

                $aUpdate = array(
                    'dt_mod_date'         => date('Y-m-d H:i:s')
                    ,'fk_i_category_id'   => $aItem['catId']
                    ,'i_price'            => $aItem['price']
                    ,'fk_c_currency_code' => $aItem['currency']
                ) ;

                // only can change the user if you're an admin
                if( $this->is_admin ) {
                    $aUpdate['fk_i_user_id']    = $aItem['userId'] ;
                    $aUpdate['s_contact_name']  = $aItem['contactName'] ;
                    $aUpdate['s_contact_email'] = $aItem['contactEmail'] ;
                }

                $result = $this->manager->update( $aUpdate, array('pk_i_id'  => $aItem['idItem'],
                                                                  's_secret' => $aItem['secret'] ) ) ;
                // UPDATE title and description locales
                $this->insertItemLocales( 'EDIT', $aItem['title'], $aItem['description'], $aItem['idItem'] );
                // UPLOAD item resources
                $this->uploadItemResources( $aItem['photos'], $aItem['idItem'] ) ;

                Log::newInstance()->insertLog('item', 'edit', $aItem['idItem'], current(array_values($aItem['title'])), $this->is_admin?'admin':'user', $this->is_admin?osc_logged_admin_id():osc_logged_user_id());
                /**
                 * META FIELDS
                 */
                if($meta!='' && count($meta)>0) {
                    $mField = Field::newInstance();
                    foreach($meta as $k => $v) {
                        $mField->replace($aItem['idItem'], $k, $v);
                    }
                }

                $oldIsExpired = osc_isExpired($old_item['dt_expiration']);
                $newIsExpired = $oldIsExpired;

                $dt_expiration = $old_item['dt_expiration'];
                // recalculate dt_expiration t_item
                if( $result==1 && $old_item['fk_i_category_id'] != $aItem['catId'] ) {
                    $_category = Category::newInstance()->findByPrimaryKey($aItem['catId']);
                    // update dt_expiration 
                    $i_expiration_days = $_category['i_expiration_days'];
                    $dt_expiration = Item::newInstance()->updateExpirationDate($aItem['idItem'], $i_expiration_days);
                    $newIsExpired = osc_isExpired($dt_expiration);
                }

                // Recalculate stats related with items
                $this->_updateStats($result, $old_item, $oldIsExpired, $old_item_location, $aItem, $newIsExpired, $location);

                unset($old_item) ;

                osc_run_hook('item_edit_post', $aItem['catId'], $aItem['idItem']);
                return $result;
            }

            return 0;
        }

        /**
         * Increment or decrement stats related with items. 
         *
         * User item stats, Category item stats,
         *  country item stats, region item stats, city item stats
         * 
         * @param type $result
         * @param type $old_item
         * @param type $oldIsExpired
         * @param type $old_item_location
         * @param type $aItem
         * @param type $newIsExpired
         * @param type $location 
         */
        private function _updateStats($result, $old_item, $oldIsExpired, $old_item_location, $aItem, $newIsExpired, $location)
        {
            if($result==1 && $old_item['b_enabled']==1 && $old_item['b_active']==1 && $old_item['b_spam']==0) {
                // if old item is expired and new item is not expired.
                if($oldIsExpired && !$newIsExpired) {
                    // increment new item stats (user, category, location_stats)
                    if( is_numeric($aItem['userId']) ) {
                        User::newInstance()->increaseNumItems( $aItem['userId'] ) ;
                    }
                    CategoryStats::newInstance()->increaseNumItems($aItem['catId']) ;
                    CountryStats::newInstance()->increaseNumItems($location['fk_c_country_code']);
                    RegionStats::newInstance()->increaseNumItems($location['fk_i_region_id']);
                    CityStats::newInstance()->increaseNumItems($location['fk_i_city_id']);
                }
                // if old is not expired and new is expired
                if(!$oldIsExpired && $newIsExpired) {
                    // decrement new item stats (user, category, location_stats)
                    if( is_numeric($old_item['fk_i_user_id']) ) {
                        User::newInstance()->decreaseNumItems( $old_item['fk_i_user_id'] ) ;
                    }
                    CategoryStats::newInstance()->decreaseNumItems($aItem['catId']) ;
                    CountryStats::newInstance()->decreaseNumItems($location['fk_c_country_code']);
                    RegionStats::newInstance()->decreaseNumItems($location['fk_i_region_id']);
                    CityStats::newInstance()->decreaseNumItems($location['fk_i_city_id']);
                }
                // if old item is not expired and new item is not expired
                if(!$oldIsExpired && !$newIsExpired) {
                    // Update user stats - if old user diferent to actual user, update user stats
                    if($old_item['fk_i_user_id'] != $aItem['userId']) {
                        if( is_numeric($old_item['fk_i_user_id']) ) {
                            User::newInstance()->decreaseNumItems( $old_item['fk_i_user_id'] ) ;
                        }
                        if( is_numeric($aItem['userId']) ) {
                            User::newInstance()->increaseNumItems( $aItem['userId'] ) ;
                        }
                    }
                    // Update category numbers
                    if($old_item['fk_i_category_id'] != $aItem['catId']) {
                        CategoryStats::newInstance()->increaseNumItems($aItem['catId']) ;
                        CategoryStats::newInstance()->decreaseNumItems($old_item['fk_i_category_id']) ;
                    }
                    // Update location stats
                    if($old_item_location['fk_c_country_code'] != $location['fk_c_country_code']) {
                        CountryStats::newInstance()->decreaseNumItems($old_item_location['fk_c_country_code']);
                        CountryStats::newInstance()->increaseNumItems($location['fk_c_country_code']);
                    }
                    if($old_item_location['fk_i_region_id'] != $location['fk_i_region_id']) {
                        RegionStats::newInstance()->decreaseNumItems($old_item_location['fk_i_region_id']);
                        RegionStats::newInstance()->increaseNumItems($location['fk_i_region_id']);
                    }
                    if($old_item_location['fk_i_city_id'] != $location['fk_i_city_id']) {
                        CityStats::newInstance()->decreaseNumItems($old_item_location['fk_i_city_id']);
                        CityStats::newInstance()->increaseNumItems($location['fk_i_city_id']);
                    }
                }
                // if old and new items are expired [nothing to do]
                // if($oldIsExpired && $newIsExpired) { }
            } 
        }

        /**
         * Activates an item.
         * Set s_enabled value to 1, for a given item id
         *
         * @param int $id
         * @return bool
         */
        public function activate( $id, $secret = NULL )
        {
            $aWhere = array();
            if( $secret == NULL ) {
                $item[0] = $this->manager->findByPrimaryKey( $id ) ;
                $aWhere = array('pk_i_id' => $id);
            } else {
                $item = $this->manager->listWhere("i.s_secret = '%s' AND i.pk_i_id = '%s' ", $secret, $id);
                $aWhere = array('s_secret' => $secret, 'pk_i_id' => $id);
            }

            if($item[0]['b_enabled']==1 && $item[0]['b_active']==0) {
                
                $result = $this->manager->update(
                    array('b_active' => 1),
                    $aWhere
                );

                // updated correctly
                if($result == 1) {
                    osc_run_hook( 'activate_item', $id );
                    // b_enabled == 1 && b_active == 1
                    if($item[0]['b_spam']==0 && !osc_isExpired($item[0]['dt_expiration'])) {
                        $this->_increaseStats($item[0]);
                    }

                    return true;
                }
                return false;
            } else {
                return -1;
            }
        }

        /**
         * Deactivates an item
         * Set s_active value to 0, for a given item id
         *
         * @param int $id
         * @return bool
         */
        public function deactivate($id)
        {
            $result = $this->manager->update(
                array('b_active' => 0),
                array('pk_i_id' => $id)
            );

            // updated correctly
            if($result == 1) {
                osc_run_hook( 'deactivate_item', $id );
                $item = $this->manager->findByPrimaryKey($id);
                if($item['b_enabled']==1 && $item['b_spam']==0 && !osc_isExpired($item['dt_expiration'])) {
                    $this->_decreaseStats($item);
                }
                return true;
            }
            return false;
        }

        /**
         * Enable an item
         * Set s_enabled value to 1, for a given item id
         *
         * @param int $id
         * @return bool
         */
        public function enable($id) 
        {
            $result = $this->manager->update(
                array('b_enabled' => 1),
                array('pk_i_id' => $id)
            );

            // updated correctly
            if($result == 1) {
                osc_run_hook( 'enable_item', $id );
                $item = $this->manager->findByPrimaryKey($id);
                if($item['b_active']==1 && $item['b_spam']==0 && !osc_isExpired($item['dt_expiration']) ) {
                    $this->_increaseStats($item);
                }
                return true;
            }
            return false;
        }

        /**
         * Disable an item.
         * Set s_enabled value to 0, for a given item id
         *
         * @param int $id
         * @return bool
         */
        public function disable($id) 
        {
            $result = $this->manager->update(
                array('b_enabled' => 0),
                array('pk_i_id' => $id)
            );

            // updated correctly
            if($result == 1) {
                osc_run_hook( 'disable_item', $id );
                $item = $this->manager->findByPrimaryKey($id);
                if($item['b_active']==1 && $item['b_spam']==0 && !osc_isExpired($item['dt_expiration'])) {
                   $this->_decreaseStats($item);
                }
                return true;
            }
            return false;
        }

        /**
         * Set premium value depending on $on, for a given item id
         *
         * @param int $id
         * @param bool $on
         * @return bool
         */
        public function premium($id, $on = true) 
        {
            $value = 0;
            if($on) {
                $value = 1;
            }

            $result = $this->manager->update(
                array('b_premium' => (int)$value)
                ,array('pk_i_id' => $id)
            );
            // updated correctly
            if($result == 1) {
                if($on) {
                    osc_run_hook("item_premium_on", $id);
                } else {
                    osc_run_hook("item_premium_off", $id);
                }
                return true;
            }
            return false;
        }

        /**
         * Set premium carousel value depending on $on, for a given item id
         *
         * @param int $id
         * @param bool $on
         * @return bool
         * @author shakeelstha
         */
        public function premium_carousel($id, $on = true)
        {
            $value = 0;
            if($on) {
                $value = 1;
            }

            $result = $this->manager->update(
                array('b_premium_scroller' => (int)$value)
                ,array('pk_i_id' => $id)
            );
            // updated correctly
            //echo "result : ".$result.">>>>on: ".$on;
            if($result == 1) {
                if($on) {
                    osc_run_hook("item_premium_carousel_on", $id);
                } else {
                    osc_run_hook("item_premium_carousel_off", $id);
                }
                return true;
            }
            return false;
        }

        /**
         * Set spam value depending on $on, for a given item id
         *
         * @param int $id
         * @param bool $on
         * @return bool
         */
        public function spam($id, $on = true) 
        {
            $item = $this->manager->findByPrimaryKey($id);
            if($on) {
                $result = $this->manager->update(
                    array('b_spam' => '1')
                    ,array('pk_i_id' => $id)
                );
            } else {
                $result = $this->manager->update(
                    array('b_spam' => '0')
                    ,array('pk_i_id' => $id)
                );
            }

            // updated corretcly
            if($result == 1) {
                if($on) {
                    osc_run_hook("item_spam_on", $id);
                } else {
                    osc_run_hook("item_spam_off", $id);
                }

                if($item['b_active']==1 && $item['b_enabled']==1 && !osc_isExpired($item['dt_expiration']) && $item['b_spam']==0) {
                    $this->_decreaseStats($item);
                } else if($item['b_active']==1 && $item['b_enabled']==1 && !osc_isExpired($item['dt_expiration']) && $item['b_spam']==1) {
                    $this->_increaseStats($item);
                }

                return true;
            }
            return false;
        }

        /**
         * Private function for increment stats.
         * tables: t_user/t_category_stats/t_country_stats/t_region_stats/t_city_stats
         * 
         * @param array item
         */
        private function _increaseStats($item)
        {
            if($item['fk_i_user_id']!=null) {
                User::newInstance()->increaseNumItems($item['fk_i_user_id']);
            }
            CategoryStats::newInstance()->increaseNumItems($item['fk_i_category_id']);
            CountryStats::newInstance()->increaseNumItems($item['fk_c_country_code']);
            RegionStats::newInstance()->increaseNumItems($item['fk_i_region_id']);
            CityStats::newInstance()->increaseNumItems($item['fk_i_city_id']);
        }

        /**
         * Private function for decrease stats.
         * tables: t_user/t_category_stats/t_country_stats/t_region_stats/t_city_stats
         * 
         * @param array item
         */
        private function _decreaseStats($item)
        {
            if($item['fk_i_user_id']!=null) {
                User::newInstance()->decreaseNumItems($item['fk_i_user_id']);
            }
            CategoryStats::newInstance()->decreaseNumItems($item['fk_i_category_id']);
            CountryStats::newInstance()->decreaseNumItems($item['fk_c_country_code']);
            RegionStats::newInstance()->decreaseNumItems($item['fk_i_region_id']);
            CityStats::newInstance()->decreaseNumItems($item['fk_i_city_id']);
        }

        /**
         * Delete an item, given s_secret and item id.
         *
         * @param <type> $secret
         * @param <type> $itemId
         */
         //actual function to delete the item from the table
        public function delete( $secret, $itemId )
        {
            $item = $this->manager->findByPrimaryKey($itemId) ;

            if( $item['s_secret'] == $secret ) {
                $this->deleteResourcesFromHD( $item['pk_i_id'] ) ;
                Log::newInstance()->insertLog( 'item', 'delete', $itemId, $item['s_title'], $this->is_admin ? 'admin' : 'user', $this->is_admin ? osc_logged_admin_id() : osc_logged_user_id() ) ;
                return $this->manager->deleteByPrimaryKey( $itemId ) ;
            }

            return false ;
        }
        
        /**
         * Delete an item, given s_secret and item id.
         *
         * @param <type> $secret
         * @param <type> $itemId
         */
         //actual function to delete the item from the table
        public function performDelete( $secret, $itemId ) {
            $item = $this->manager->findByPrimaryKey($itemId) ;
            
            if( $item['s_secret'] == $secret ) {
                $conn = getConnection();

                if($conn->osc_dbExec("INSERT INTO ".DB_TABLE_PREFIX."t_item_deleted SELECT * FROM ".DB_TABLE_PREFIX."t_item WHERE pk_i_id=".$itemId)) {
                    //->osc_dbFetchResults("SELECT u.pk_i_id, u.s_name FROM ".DB_TABLE_PREFIX."t_user u, ".DB_TABLE_PREFIX."t_user_sell_category s WHERE s.fk_i_category_id = '%d' AND u.pk_i_id=s.fk_i_user_id ", '205');
                    Log::newInstance()->insertLog( 'item', 'delete', $itemId, $item['s_title'], $this->is_admin ? 'admin' : 'user', $this->is_admin ? osc_logged_admin_id() : osc_logged_user_id() ) ;
                    return $this->manager->deleteByPrimaryKey( $itemId ) ;
                }
            }

            return false ;
        }


        /**
         * Set delete value depending on $on, for a given item id
         *
         * @param int $id
         * @param bool $on
         * @return bool
         */
         //dummy function to set the flag of b_deleted : added by shakeelstha
        public function delete_new_dummy_($secret, $itemId, $on = true)
        {
            $value = 0;
            if($on) {
                $value = 1;
            }

            $item = $this->manager->findByPrimaryKey($itemId) ;
            
            if( $item['s_secret'] == $secret ) {
                
                $result = $this->manager->update(
                array('b_deleted' => (int)$value)
                ,array('pk_i_id' => $itemId)
            );
            }
            
            // updated correctly
            if($result == 1) {
                if($on) {
                    osc_run_hook("item_delete_on", $itemId);
                } else {
                    osc_run_hook("item_delete_off", $itemId);
                }
               
                return true;
            }            
            return false;
        }

        /**
         * Delete resources from the hard drive
         * @param <type> $itemId
         */
        public function deleteResourcesFromHD( $itemId )
        {
            $resources = ItemResource::newInstance()->getAllResourcesFromItem($itemId);
            Log::newInstance()->insertLog('itemActions', 'deleteResourcesFromHD', $itemId, $itemId, $this->is_admin?'admin':'user', $this->is_admin?osc_logged_admin_id():osc_logged_user_id()) ;
            $log_ids = '';
            foreach($resources as $resource) {
                osc_deleteResource($resource['pk_i_id'], $this->is_admin);
                $log_ids .= $resource['pk_i_id'].",";
            }
            Log::newInstance()->insertLog('itemActions', 'deleteResourcesFromHD', $itemId, substr($log_ids,0, 250), $this->is_admin?'admin':'user', $this->is_admin?osc_logged_admin_id():osc_logged_user_id()) ;
        }

        /**
         * Mark an item
         * @param int $id
         * @param string $as
         */
        public function mark( $id, $as )
        {
            switch ($as) {
                case 'spam':
                    $column = 'i_num_spam';
                break;
                case 'badcat':
                    $column = 'i_num_bad_classified';
                break;
                case 'offensive':
                    $column = 'i_num_offensive';
                break;
                case 'repeated':
                    $column = 'i_num_repeated';
                break;
                case 'expired':
                    $column = 'i_num_expired';
                break;
            }

            ItemStats::newInstance()->increase( $column, $id ) ;
        }

        public function send_friend()
        {
            // get data for this function
            $aItem = $this->prepareDataForFunction( 'send_friend' );

            $item       = $aItem['item'];
            $s_title    = $aItem['s_title'];
            View::newInstance()->_exportVariableToView('item', $item);

            osc_run_hook('hook_email_send_friend', $aItem);
            $item_url   = osc_item_url();
            $item_url = '<a href="'.$item_url.'" >'.$item_url.'</a>';
            Params::setParam('item_url', $item_url );
            osc_add_flash_ok_message( sprintf(_m('We just sent your message to %s'), $aItem['friendName']) ) ;
            return true;
        }

        public function contact()
        {
            $flash_error = '';
            $aItem = $this->prepareDataForFunction( 'contact' );

            // check parameters
            if( !osc_validate_email($aItem['yourEmail'], true) ){
                $flash_error .= __("Invalid email address") . PHP_EOL;
            } else if( !osc_validate_text($aItem['message']) ){
                $flash_error .= __("Message: this field is required") . PHP_EOL;
            } else if ( !osc_validate_text($aItem['yourName']) ){
                $flash_error .= __("Your name: this field is required") . PHP_EOL;
            }

            if($flash_error != ''){
                return $flash_error ;
            } else {
                osc_run_hook('hook_email_item_inquiry', $aItem);
            }
        }

        /*
         *
         */
        public function add_comment()
        {
            $aItem  = $this->prepareDataForFunction('add_comment');

            $authorName     = trim($aItem['authorName']);
            $authorName     = strip_tags($authorName);
            $authorEmail    = trim($aItem['authorEmail']);
            $authorEmail    = strip_tags($authorEmail);
            $body           = trim($aItem['body']);
            $body           = strip_tags($body);
            $title          = $aItem['title'] ;
            $itemId         = $aItem['id'] ;
            $userId         = $aItem['userId'] ;
            $status_num     = -1;

            $item = $this->manager->findByPrimaryKey($itemId) ;
            View::newInstance()->_exportVariableToView('item', $item);
            $itemURL = osc_item_url() ;
            $itemURL = '<a href="'.$itemURL.'" >'.$itemURL.'</a>';

            Params::setParam('itemURL', $itemURL);

            if( !preg_match('|^.*?@.{2,}\..{2,3}$|', $authorEmail)) {
                Session::newInstance()->_setForm('commentAuthorName', $authorName);
                Session::newInstance()->_setForm('commentTitle', $title);
                Session::newInstance()->_setForm('commentBody', $body);
                return 3;
            }

            if( ($body == '') ) {
                Session::newInstance()->_setForm('commentAuthorName', $authorName);
                Session::newInstance()->_setForm('commentAuthorEmail', $authorEmail);
                Session::newInstance()->_setForm('commentTitle', $title);
                return 4;
            }

            $num_moderate_comments = osc_moderate_comments();
            if($userId==null) {
                $num_comments = 0;
            } else {
                $user         = User::newInstance()->findByPrimaryKey($userId);
                $num_comments = $user['i_comments'];
            }

            if ($num_moderate_comments == -1 || ($num_moderate_comments != 0 && $num_comments >= $num_moderate_comments)) {
                $status     = 'ACTIVE';
                $status_num = 2;
            } else {
                $status     = 'INACTIVE';
                $status_num = 1;
            }

            if (osc_akismet_key()) {
                require_once LIB_PATH . 'Akismet.class.php' ;
                $akismet = new Akismet(osc_base_url(), osc_akismet_key()) ;
                $akismet->setCommentAuthor($authorName) ;
                $akismet->setCommentAuthorEmail($authorEmail) ;
                $akismet->setCommentContent($body) ;
                $akismet->setPermalink($itemURL) ;

                $status = $akismet->isCommentSpam() ? 'SPAM' : $status ;
                if($status == 'SPAM') {
                    $status_num = 5;
                }
            }

            $mComments = ItemComment::newInstance();
            $aComment  = array('dt_pub_date'    => date('Y-m-d H:i:s')
                              ,'fk_i_item_id'   => $itemId
                              ,'s_author_name'  => $authorName
                              ,'s_author_email' => $authorEmail
                              ,'s_title'        => $title
                              ,'s_body'         => $body
                              ,'b_active'       => ($status=='ACTIVE' ? 1 : 0)
                              ,'b_enabled'      => 1
                              ,'fk_i_user_id'   => $userId);

            if( $mComments->insert($aComment) ) {
                $commentID = $mComments->dao->insertedId() ;
                if($status_num == 2 && $userId != null) { // COMMENT IS ACTIVE
                    $user = User::newInstance()->findByPrimaryKey($userId);
                    if( $user ) {
                        User::newInstance()->update( array( 'i_comments' => $user['i_comments'] + 1)
                                                    ,array( 'pk_i_id'    => $user['pk_i_id'] ) ) ;
                    }
                }

                //Notify admin
                if ( osc_notify_new_comment() ) {
                    osc_run_hook('hook_email_new_comment_admin', $aItem) ;
                }

                //Notify user
                if ( osc_notify_new_comment_user() ) {
                    osc_run_hook('hook_email_new_comment_user', $aItem) ;
                }

                osc_run_hook( 'add_comment', $commentID ) ;

                return $status_num ;
            }

            return -1;
        }

        /**
         * Return an array with all data necessary for do the action
         * @param <type> $action
         */
        private function prepareDataForFunction( $action )
        {
            $aItem = array();

            switch ( $action ){
                case 'send_friend':
                    $item = $this->manager->findByPrimaryKey( Params::getParam('id') );

                    $aItem['item']          = $item;
                    View::newInstance()->_exportVariableToView('item', $aItem['item']);
                    $aItem['yourName']      = Params::getParam('yourName');
                    $aItem['yourEmail']     = Params::getParam('yourEmail');

                    $aItem['friendName']    = Params::getParam('friendName');
                    $aItem['friendEmail']   = Params::getParam('friendEmail');

                    $aItem['s_title']       = $item['s_title'];
                    $aItem['message']       = Params::getParam('message');
                break;
                case 'contact':
                    $item = $this->manager->findByPrimaryKey( Params::getParam('id') );

                    $aItem['item']          = $item;
                    View::newInstance()->_exportVariableToView('item', $aItem['item']);
                    $aItem['id']            = Params::getParam('id') ;
                    $aItem['yourEmail']     = Params::getParam('yourEmail') ;
                    $aItem['yourName']      = Params::getParam('yourName') ;
                    $aItem['message']       = Params::getParam('message') ;
                    $aItem['phoneNumber']   = Params::getParam('phoneNumber') ;
                break;
                case 'add_comment':
                    $item = $this->manager->findByPrimaryKey( Params::getParam('id') );

                    $aItem['item']          = $item;
                    View::newInstance()->_exportVariableToView('item', $aItem['item']);
                    $aItem['authorName']     = Params::getParam('authorName') ;
                    $aItem['authorEmail']    = Params::getParam('authorEmail') ;
                    $aItem['body']           = Params::getParam('body') ;
                    $aItem['title']          = Params::getParam('title') ;
                    $aItem['id']             = Params::getParam('id') ;
                    $aItem['userId']         = Session::newInstance()->_get('userId');
                    if($aItem['userId'] == ''){
                        $aItem['userId'] = NULL;
                    }

                break;
                default:
            }
            return $aItem;
        }

        /**
         * Return an array with all data necessary for do the action (ADD OR EDIT)
         * @param <type> $is_add
         * @return array
         */
        public function prepareData( $is_add )
        {
            $aItem = array();

            // prepare user
            $userId = null ;
            if( $this->is_admin ) {
                if( Params::getParam('userId') != '' ) {
                    $userId = Params::getParam('userId');
                }
            } else {
                $userId = Session::newInstance()->_get('userId');
                if( $userId == '' ) {
                    $userId = NULL ;
                }
            }

            if( $is_add ) {   // ADD
                if($this->is_admin) {
                    $active = 'ACTIVE';
                } else {
                    if(osc_moderate_items()>0) { // HAS TO VALIDATE
                        if(!osc_is_web_user_logged_in()) { // NO USER IS LOGGED, VALIDATE
                            $active = 'INACTIVE';
                        } else { // USER IS LOGGED
                            if(osc_logged_user_item_validation()) { //USER IS LOGGED, BUT NO NEED TO VALIDATE
                                $active = 'ACTIVE';
                            } else { // USER IS LOGGED, NEED TO VALIDATE, CHECK NUMBER OF PREVIOUS ITEMS
                                $user = User::newInstance()->findByPrimaryKey(osc_logged_user_id());
                                if($user['i_items']<osc_moderate_items()) {
                                    $active = 'INACTIVE';
                                } else {
                                    $active = 'ACTIVE';
                                }
                            }
                        }
                    } else if(osc_moderate_items()==0 ){
                        if(osc_is_web_user_logged_in() && osc_logged_user_item_validation() ) {
                            $active = 'ACTIVE';
                        } else {
                            $active = 'INACTIVE';
                        }
                    } else {
                        $active = 'ACTIVE';
                    }
                }

                if ($userId != null) {
                    $data = User::newInstance()->findByPrimaryKey($userId);
                    $aItem['contactName']   = $data['s_name'];
                    $aItem['contactEmail']  = $data['s_email'];
                    Params::setParam('contactName', $data['s_name']);
                    Params::setParam('contactEmail', $data['s_email']);
                }else{
                    $aItem['contactName']   = Params::getParam('contactName');
                    $aItem['contactEmail']  = Params::getParam('contactEmail');
                }

                $aItem['active']        = $active;
                $aItem['userId']        = $userId;
            } else {          // EDIT
                $aItem['secret']    = Params::getParam('secret');
                $aItem['idItem']    = Params::getParam('id');

                if( $userId != null ) {
                    $data = User::newInstance()->findByPrimaryKey($userId);
                    $aItem['contactName']   = $data['s_name'];
                    $aItem['contactEmail']  = $data['s_email'];
                    Params::setParam('contactName', $data['s_name']);
                    Params::setParam('contactEmail', $data['s_email']);
                } else {
                    $aItem['contactName']   = Params::getParam('contactName');
                    $aItem['contactEmail']  = Params::getParam('contactEmail');
                }
                $aItem['userId']        = $userId;
            }

            // get params
            $aItem['catId']         = Params::getParam('catId');
            $aItem['countryId']     = Params::getParam('countryId');
            $aItem['country']       = Params::getParam('country');
            $aItem['region']        = Params::getParam('region');
            $aItem['regionId']      = Params::getParam('regionId');
            $aItem['city']          = Params::getParam('city');
            $aItem['cityId']        = Params::getParam('cityId');
            $aItem['price']         = (Params::getParam('price') != '') ? Params::getParam('price') : null;
            $aItem['cityArea']      = Params::getParam('cityArea');
            $aItem['address']       = Params::getParam('address');
            $aItem['currency']      = Params::getParam('currency');
            $aItem['showEmail']     = (Params::getParam('showEmail') != '') ? 1 : 0;
            $aItem['title']         = Params::getParam('title');
            $aItem['description']   = Params::getParam('description');
            $aItem['photos']        = Params::getFiles('photos');

            // check params

            $country = Country::newInstance()->findByCode($aItem['countryId']);
            if( count($country) > 0 ) {
                $countryId = $country['pk_c_code'];
                $countryName = $country['s_name'];
            } else {
                $countryId = null;
                $countryName = $aItem['country'];
            }
            $aItem['countryId']   = $countryId;
            $aItem['countryName']   = $countryName;

            if( $aItem['regionId'] != '' ) {
                if( intval($aItem['regionId']) ) {
                    $region = Region::newInstance()->findByPrimaryKey($aItem['regionId']);
                    if( count($region) > 0 ) {
                        $regionId = $region['pk_i_id'];
                        $regionName = $region['s_name'];
                    }
                }
            } else {
                $regionId = null;
                $regionName = $aItem['region'];
                if( $aItem['countryId'] != '' ) {
                    $auxRegion  = Region::newInstance()->findByName($aItem['region'], $aItem['countryId'] );
                    if($auxRegion){
                        $regionId   = $auxRegion['pk_i_id'];
                        $regionName = $auxRegion['s_name'];
                    }
                }
            }

            $aItem['regionId']      = $regionId ;
            $aItem['regionName']    = $regionName;

            if( $aItem['cityId'] != '' ) {
                if( intval($aItem['cityId']) ) {
                    $city = City::newInstance()->findByPrimaryKey($aItem['cityId']);
                    if( count($city) > 0 ) {
                        $cityId = $city['pk_i_id'];
                        $cityName = $city['s_name'];
                    }
                }
            } else {
                $cityId = null;
                $cityName = $aItem['city'];
                if( $aItem['countryId'] != '' ) {
                    $auxCity = City::newInstance()->findByName($aItem['city'], $aItem['regionId'] );
                    if($auxCity){
                        $cityId   = $auxCity['pk_i_id'];
                        $cityName = $auxCity['s_name'];
                    }
                }
            }

            $aItem['cityId']      = $cityId;
            $aItem['cityName']    = $cityName;

            if( $aItem['cityArea'] == '' ) {
                $aItem['cityArea'] = null;
            }

            if( $aItem['address'] == '' ) {
                $aItem['address'] = null;
            }

            if( !is_null($aItem['price']) ) {
                $price = str_replace(osc_locale_thousands_sep(), '', trim($aItem['price']));
                $price = str_replace(osc_locale_dec_point(), '.', $price);
                $aItem['price'] = $price*1000000;
                //$aItem['price'] = (float) $aItem['price'];
            }

            if( $aItem['catId'] == ''){
                $aItem['catId'] = 0;
            }

            if( $aItem['currency'] == '' ) {
                $aItem['currency'] = null;
            }

            $this->data = $aItem;
        }

        function insertItemLocales($type, $title, $description, $itemId )
        {
            foreach($title as $k => $_data){
                $_title         = $title[$k];
                $_description   = $description[$k];
                if($type == 'ADD'){
                    $this->manager->insertLocale($itemId, $k, $_title, $_description);
                }else if($type == 'EDIT'){
                    $this->manager->updateLocaleForce($itemId, $k, $_title, $_description) ;
                }
            }
        }

        private function checkSize($aResources)
        {
            $success = true;

            if($aResources != '') {
                // get allowedExt
                $maxSize = osc_max_size_kb() * 1024;
                foreach ($aResources['error'] as $key => $error) {
                    $bool_img = false;
                    if ($error == UPLOAD_ERR_OK) {
                        $size = $aResources['size'][$key];
                        if($size >= $maxSize){
                            $success = false;
                        }
                    }
                }
                if(!$success){
                    osc_add_flash_error_message( _m("One of the files you tried to upload exceeds the maximum size")) ;
                }
            }
            return $success;
        }

        private function checkAllowedExt($aResources)
        {
            $success = true;
            require LIB_PATH . 'osclass/mimes.php';
            if($aResources != '') {
                // get allowedExt
                $aMimesAllowed = array();
                $aExt = explode(',', osc_allowed_extension() );
                foreach($aExt as $ext){
                    if(isset($mimes[$ext])) {
                        $mime = $mimes[$ext];
                        if( is_array($mime) ){
                            foreach($mime as $aux){
                                if( !in_array($aux, $aMimesAllowed) ) {
                                    array_push($aMimesAllowed, $aux );
                                }
                            }
                        } else {
                            if( !in_array($mime, $aMimesAllowed) ) {
                                array_push($aMimesAllowed, $mime );
                            }
                        }
                    }
                }

                foreach ($aResources['error'] as $key => $error) {
                    $bool_img = false;
                    if ($error == UPLOAD_ERR_OK) {
                        // check mime file
                        $fileMime = $aResources['type'][$key] ;

                        if(in_array($fileMime,$aMimesAllowed)) {
                            $bool_img = true;
                        }
                        if(!$bool_img && $success) {$success = false;}
                    }
                }

                if(!$success){
                    osc_add_flash_error_message( _m("The file you tried to upload does not have a valid extension")) ;
                }
            }
            return $success;
        }

        public function uploadItemResources($aResources,$itemId)
        {
            if($aResources != '') {
                $wat = new Watermark();

                $itemResourceManager = ItemResource::newInstance() ;

                $numImagesItems = osc_max_images_per_item();
                $numImages = $itemResourceManager->countResources($itemId);
                foreach ($aResources['error'] as $key => $error) {
                    if($numImagesItems==0 || ($numImagesItems>0 && $numImages<$numImagesItems)) {
                        if ($error == UPLOAD_ERR_OK) {

                            $numImages++;

                            $tmpName = $aResources['tmp_name'][$key] ;
                            $itemResourceManager->insert(array(
                                'fk_i_item_id' => $itemId
                            )) ;
                            $resourceId = $itemResourceManager->dao->insertedId();

                            // Create normal size
                            $normal_path = $path = osc_content_path() . 'uploads/' . $resourceId . '.jpg' ;
                            $size = explode('x', osc_normal_dimensions()) ;
                            ImageResizer::fromFile($tmpName)->resizeTo($size[0], $size[1])->saveToFile($path) ;

                            if( osc_is_watermark_text() ) {
                                $wat->doWatermarkText( $path , osc_watermark_text_color(), osc_watermark_text() , 'image/jpeg' );
                            } elseif ( osc_is_watermark_image() ){
                                $wat->doWatermarkImage( $path, 'image/jpeg');
                            }

                            // Create preview
                            $path = osc_content_path(). 'uploads/' . $resourceId . '_preview.jpg' ;
                            $size = explode('x', osc_preview_dimensions()) ;
                            ImageResizer::fromFile($normal_path)->resizeTo($size[0], $size[1])->saveToFile($path) ;

                            // Create thumbnail
                            $path = osc_content_path(). 'uploads/' . $resourceId . '_thumbnail.jpg' ;
                            $size = explode('x', osc_thumbnail_dimensions()) ;
                            ImageResizer::fromFile($normal_path)->resizeTo($size[0], $size[1])->saveToFile($path) ;

                            if( osc_keep_original_image() ) {
                                $path = osc_content_path() . 'uploads/' . $resourceId.'_original.jpg' ;
                                move_uploaded_file($tmpName, $path) ;
                            }

                            $s_path = 'oc-content/uploads/' ;
                            $resourceType = 'image/jpeg' ;
                            $itemResourceManager->update(
                                                    array(
                                                        's_path'            => $s_path
                                                        ,'s_name'           => osc_genRandomPassword()
                                                        ,'s_extension'      => 'jpg'
                                                        ,'s_content_type'   => $resourceType
                                                    )
                                                    ,array(
                                                        'pk_i_id'       => $resourceId
                                                        ,'fk_i_item_id' => $itemId
                                                    )
                            ) ;
                            osc_run_hook('uploaded_file', ItemResource::newInstance()->findByPrimaryKey($resourceId));
                        }
                    }
                }
                unset($itemResourceManager);
            }
        }

        public function sendEmails($aItem){

            $item   = $aItem['item'];
            View::newInstance()->_exportVariableToView('item', $item);

            /**
             * Send email to non-reg user requesting item activation
             */
            if( Session::newInstance()->_get('userId') == '' && $aItem['active']=='INACTIVE' ) {
                osc_run_hook('hook_email_item_validation_non_register_user', $item);
            } else if ( $aItem['active']=='INACTIVE' ) { //  USER IS REGISTERED
                osc_run_hook('hook_email_item_validation', $item);
            } else if( Session::newInstance()->_get('userId') == '' ){ // USER IS NOT REGISTERED
                osc_run_hook('hook_email_new_item_non_register_user', $item);
            }

            /**
             * Send email to admin about the new item
             */
            if (osc_notify_new_item()) {
                osc_run_hook('hook_email_admin_new_item', $item);
            }
        }
    }

?>