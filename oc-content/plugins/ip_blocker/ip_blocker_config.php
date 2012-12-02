<?php



    $conn = getConnection();
    $data=$conn->osc_dbFetchResults("SELECT INET_NTOA(ip) FROM %st_ip_blocker", DB_TABLE_PREFIX);

    if(count($data)>0) {
	foreach($data as $data2) {
	    $ip[] = $data2['INET_NTOA(ip)']; // populate IP array
	}
    }

    if( Params::getParam('option') == 'update' )
    {
	$newip = '';
	if(Params::getParam('newip') != ''){
	    $newip = Params::getParam('newip');

	    // First, check to see if IP already is in our database table....
	    if(count($ip)>0)
	    {
		if(array_search($newip, $ip)!==FALSE){
		    osc_add_flash_error_message(__('IP already exists in database'),'admin');
		}
		else {
		    $conn->osc_dbExec("INSERT INTO %st_ip_blocker (ip) VALUES (INET_ATON('%s'))", DB_TABLE_PREFIX, $newip);
		    osc_add_flash_ok_message(__('New IP successfully added'),'admin');
	    	}
	    }
	    else {
		$conn->osc_dbExec("INSERT INTO %st_ip_blocker (ip) VALUES (INET_ATON('%s'))", DB_TABLE_PREFIX, $newip);
		osc_add_flash_ok_message(__('New IP successfully added'),'admin');
	    }
	}
	else {
		osc_add_flash_error_message(__('No IP entered'),'admin');
	}

	echo '<script>location.href="'.osc_admin_render_plugin_url('ip_blocker/ip_blocker_config.php').'"</script>';

    }


    if( Params::getParam('option') == 'delete' )
    {
	$deleteip = '';
	if(Params::getParam('deleteip') != ''){
	    $deleteip = Params::getParam('deleteip');

	    for($index=0; $index<count($deleteip); $index++)
	    {
		$conn->osc_dbExec("DELETE FROM %st_ip_blocker WHERE ip=INET_ATON('%s')", DB_TABLE_PREFIX, $deleteip[$index]);
	    }
	    osc_add_flash_ok_message(__('Deletion Complete - '.count($deleteip).' deleted'),'admin');
	} else {
	    osc_add_flash_error_message(__('No IP addresses were selected for deletion'),'admin');
	}
	echo '<script>location.href="'.osc_admin_render_plugin_url('ip_blocker/ip_blocker_config.php').'"</script>';
    }

?>


<div style="border: 1px solid #ccc; background: #eee; ">
    <form name="ipblocker" action="<?php echo osc_admin_base_url(true); ?>" method="POST" enctype="multipart/form-data" >
	<input type="hidden" name="page" value="plugins" />
	<input type="hidden" name="action" value="renderplugin" />
	<input type="hidden" name="file" value="ip_blocker/ip_blocker_config.php" />
	<input type="hidden" name="option" value="update" />

        <fieldset>
	    <legend><h2>IP Blocker</h2></legend>
	    Enter IP address to block:
	    <br /><br />
	    <b>IP:</b> <input type="text" name="newip" id="newip" size="20" maxlength="20" value="" /> (<i>Example: 192.168.32.5</i>)
	    <br /><br />
	    <button type="submit">Submit</button>
	</fieldset>
    </form>



    <form name="ipdisplay" action="<?php echo osc_admin_base_url(true); ?>" method="POST" enctype="multipart/form-data" >
	<input type="hidden" name="page" value="plugins" />
	<input type="hidden" name="action" value="renderplugin" />
	<input type="hidden" name="file" value="ip_blocker/ip_blocker_config.php" />
	<input type="hidden" name="option" value="delete" />

        <fieldset>
	    <legend><h2>Blocked IP Addresses</h2></legend>


	    <?php
		if(count($ip)==0) {
		    echo 'No saved IP addresses';
		} else {
		    for($index=0; $index<count($ip); $index++)
		    {
			echo '<input type="checkbox" name="deleteip[]" value="'.$ip[$index].'" />'.$ip[$index].'<br />';
		    } ?>	    
	    <button type="submit">Delete Selected</button>
	    <?php } ?>

	</fieldset>
    </form>




</div>