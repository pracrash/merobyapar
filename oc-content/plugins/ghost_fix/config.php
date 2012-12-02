<fieldset>
<?php 
$removeSet = (Params::getParam('remove'))? Params::getParam('remove') : '';
$conn = getConnection() ;
$items = $conn->osc_dbFetchResults("SELECT * FROM %st_item WHERE pk_i_id NOT IN (SELECT fk_i_item_id FROM %st_item_description)", DB_TABLE_PREFIX, DB_TABLE_PREFIX);
$itemStats = $conn->osc_dbFetchResults("SELECT * FROM %st_item_stats WHERE fk_i_item_id NOT IN (SELECT fk_i_item_id FROM %st_item_description)", DB_TABLE_PREFIX, DB_TABLE_PREFIX);
$itemLocations = $conn->osc_dbFetchResults("SELECT * FROM %st_item_location WHERE fk_i_item_id NOT IN (SELECT fk_i_item_id FROM %st_item_description)", DB_TABLE_PREFIX, DB_TABLE_PREFIX);
$itemResources = $conn->osc_dbFetchResults("SELECT * FROM %st_item_resource WHERE fk_i_item_id NOT IN (SELECT fk_i_item_id FROM %st_item_description)", DB_TABLE_PREFIX, DB_TABLE_PREFIX);
//$itemOffer = $conn->osc_dbFetchResults("SELECT * FROM %st_offer_button WHERE item_id NOT IN (SELECT fk_i_item_id FROM %st_item_description)", DB_TABLE_PREFIX, DB_TABLE_PREFIX);
$itemOffer_opts = $conn->osc_dbFetchResults("SELECT * FROM %st_offer_item_options WHERE fk_i_item_id NOT IN (SELECT fk_i_item_id FROM %st_item_description)", DB_TABLE_PREFIX, DB_TABLE_PREFIX);
$itemMetas = $conn->osc_dbFetchResults("SELECT * FROM %st_item_meta WHERE fk_i_item_id NOT IN (SELECT fk_i_item_id FROM %st_item_description)", DB_TABLE_PREFIX, DB_TABLE_PREFIX);
$itemComments = $conn->osc_dbFetchResults("SELECT * FROM %st_item_comment WHERE fk_i_item_id NOT IN (SELECT fk_i_item_id FROM %st_item_description)", DB_TABLE_PREFIX, DB_TABLE_PREFIX);
$itemPayPublishs = $conn->osc_dbFetchResults("SELECT * FROM %st_paypal_publish WHERE fk_i_item_id NOT IN (SELECT fk_i_item_id FROM %st_item_description)", DB_TABLE_PREFIX, DB_TABLE_PREFIX);
$itemPayPremiums = $conn->osc_dbFetchResults("SELECT * FROM %st_paypal_premium WHERE fk_i_item_id NOT IN (SELECT fk_i_item_id FROM %st_item_description)", DB_TABLE_PREFIX, DB_TABLE_PREFIX);
$itemStats_ibfk = $conn->osc_dbFetchResults("SELECT * FROM %st_item_stats_ibfk_1 WHERE fk_i_item_id NOT IN (SELECT fk_i_item_id FROM %st_item_description)", DB_TABLE_PREFIX, DB_TABLE_PREFIX);
$itemAdManage = $conn->osc_dbFetchResults("SELECT * FROM %st_item_adManage_limit WHERE fk_i_item_id NOT IN (SELECT fk_i_item_id FROM %st_item_description)", DB_TABLE_PREFIX, DB_TABLE_PREFIX);
$itemElitpayPublish = $conn->osc_dbFetchResults("SELECT * FROM %st_elitpay_publish WHERE fk_i_item_id NOT IN (SELECT fk_i_item_id FROM %st_item_description)", DB_TABLE_PREFIX, DB_TABLE_PREFIX);
$itemProducts = $conn->osc_dbFetchResults("SELECT * FROM %st_item_products_attr WHERE fk_i_item_id NOT IN (SELECT fk_i_item_id FROM %st_item_description)", DB_TABLE_PREFIX, DB_TABLE_PREFIX);
$itemBuySell = $conn->osc_dbFetchResults("SELECT * FROM %st_item_buysell WHERE fk_i_item_id NOT IN (SELECT fk_i_item_id FROM %st_item_description)", DB_TABLE_PREFIX, DB_TABLE_PREFIX);


$ghostCount = count($items);
$statsCount = count($itemStats);
$locationCount = count($itemLocations);
$resourceCount = count($itemLocations);
//$offerCount = count($itemOffer);
$offerOptCount = count($itemOffer_opts);
$metaCount = count($itemMetas);
$commentCount = count($itemComments);
$payPubCount = count($itemPayPublishs);
$payPremCount = count($itemPayPremiums);
$itemStats_ibfkCount = count($itemStats_ibfk);
$itemAdManageCount = count($itemAdManage);
$itemElitpayPublishCount = count($itemElitpayPublish);
$itemProductsCount = count($itemProducts);
$itemBuySellCount = count($itemBuySell);

$ghostCount = $ghostCount + $statsCount + $locationCount + $resourceCount + $offerOptCount + $metaCount + $commentCount + $payPubCount + $payPremCount + $itemAdManageCount + $itemElitepayPublishCount + $itemProductsCount + $itemBuySellCount;
//$ghostCount = 5;

if($removeSet == 1 && $ghostCount != 0) {

   foreach ($itemBuySell as $item_buySell) {
		$conn->osc_dbExec("DELETE FROM %st_item_buysell WHERE fk_i_item_id = '%d'", DB_TABLE_PREFIX, $item_buySell['fk_i_item_id']);		
	}
   
   foreach ($itemProducts as $item_products) {
		$conn->osc_dbExec("DELETE FROM %st_item_products_attr WHERE fk_i_item_id = '%d'", DB_TABLE_PREFIX, $item_products['fk_i_item_id']);		
	}
   foreach ($itemElitpayPublish as $item_elitpayPublish) {
		$conn->osc_dbExec("DELETE FROM %st_elitpay_publish WHERE fk_i_item_id = '%d'", DB_TABLE_PREFIX, $item_elitpayPublish['fk_i_item_id']);		
	}
   foreach ($itemAdManage as $item_adManage) {
		$conn->osc_dbExec("DELETE FROM %st_item_adManage_limit WHERE fk_i_item_id = '%d'", DB_TABLE_PREFIX, $item_adManage['fk_i_item_id']);		
	}
	foreach ($itemStats_ibfk as $itemStat_ibfk) {
		$conn->osc_dbExec("DELETE FROM %st_item_stats_ibfk_1 WHERE fk_i_item_id = '%d'", DB_TABLE_PREFIX, $itemStat['fk_i_item_id']);		
	}
	foreach ($itemStats as $itemStat) {
		$conn->osc_dbExec("DELETE FROM %st_item_stats WHERE fk_i_item_id = '%d'", DB_TABLE_PREFIX, $itemStat['fk_i_item_id']);		
	}
	foreach ($itemLocations as $itemLocation) {
		$conn->osc_dbExec("DELETE FROM %st_item_location WHERE fk_i_item_id = '%d'", DB_TABLE_PREFIX, $itemLocation['fk_i_item_id']);		
	}
	foreach ($itemResources as $itemResource) {
		$conn->osc_dbExec("DELETE FROM %st_item_resource WHERE fk_i_item_id = '%d'", DB_TABLE_PREFIX, $itemresource['fk_i_item_id']);		
	}
	foreach ($itemOffer_opts as $itemOffer_opt) {
		$conn->osc_dbExec("DELETE FROM %st_offer_item_options WHERE fk_i_item_id = '%d'", DB_TABLE_PREFIX, $itemOffer_opt['fk_i_item_id']);		
	}
	foreach ($itemMetas as $itemMeta) {
		$conn->osc_dbExec("DELETE FROM %st_item_meta WHERE fk_i_item_id = '%d'", DB_TABLE_PREFIX, $itemMeta['fk_i_item_id']);		
	}
	foreach ($itemComments as $itemComment) {
		$conn->osc_dbExec("DELETE FROM %st_item_comment WHERE fk_i_item_id = '%d'", DB_TABLE_PREFIX, $itemComment['fk_i_item_id']);		
	}
	foreach ($itemPremPublishs as $itemPayPrem) {
		$conn->osc_dbExec("DELETE FROM %st_paypal_premium WHERE fk_i_item_id = '%d'", DB_TABLE_PREFIX, $itemPayPrem['fk_i_item_id']);		
	}
	foreach ($itemPayPublishs as $itemPayPub) {
		$conn->osc_dbExec("DELETE FROM %st_paypal_publish WHERE fk_i_item_id = '%d'", DB_TABLE_PREFIX, $itemPayPub['fk_i_item_id']);		
	}
	foreach ($items as $item) {
		$conn->osc_dbExec("DELETE FROM %st_item WHERE pk_i_id = '%d'", DB_TABLE_PREFIX, $item['pk_i_id']);
		//$itemErrors = $itemErrors . ',' . $conn->get_errno();	
	}
   
	// HACK TO DO A REDIRECT
   echo '<script>location.href="' . osc_admin_render_plugin_url('ghost_fix/config.php') . '"</script>';  
}

echo '<h2>' . __('Ghostbuster','ghost_fix') . '</h2>';
echo __('You currently have ','ghost_fix') . $ghostCount . __(' ghost ads.', 'ghost_fix') . '<br /><br />';
echo __('Ghost ads in stats table ','ghost_fix') . $statsCount . '<br />';
echo __('Ghost ads in meta table ','ghost_fix') . $metaCount . '<br />';
echo __('Ghost ads in locations table ','ghost_fix') . $locationCount . '<br />';
echo __('Ghost ads in resources table ','ghost_fix') . $resourceCount . '<br />';
echo __('Ghost ads in comments table ','ghost_fix') . $commentCount . '<br />';
//echo __('ghost ads in offer_button table ','ghost_fix') . $offerCount . '<br />';
echo __('Ghost ads in offer_item_options table ','ghost_fix') . $offerOptCount . '<br />';
echo __('Ghost ads in paypal_publish table ','ghost_fix') . $payPubCount . '<br />';
echo __('Ghost ads in item_adManage_limit table ','ghost_fix') . $itemAdManageCount . '<br />';
echo __('Ghost ads in elitpay_publish table ','ghost_fix') . $itemElitpayPublishCount . '<br />';
echo __('Ghost ads in item_products_attr table ','ghost_fix') . $itemProductsCount . '<br />';
echo __('Ghost ads in item_buysell table ','ghost_fix') . $itemBuySellCount . '<br />';

//echo 'testing ' . ModelGhost::newInstance()->error(); 

echo '<br />';

if($ghostCount == '0') {
	echo '<h3>' . __('You are ghost free!','ghost_fix') . '</h3>';
} else {
	foreach ($items as $item) {
		echo __('Ghost ad number ', 'ghost_fix') . $item['pk_i_id'] . '<br />';
	}
}

if($ghostCount != '0') {
	echo '<br />';
	echo '<a href="' . osc_admin_render_plugin_url('ghost_fix/config.php?remove=1') . '" > '. __('Remove Ghost Ads', 'ghost_fix') . '</a>';
}
?>
</fieldset>

