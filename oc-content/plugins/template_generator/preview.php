<?php

    $data = '';
    if($_POST['data'] != ''){
	$data = trim(stripslashes($_POST['data']));

	echo $data;
?>

<script type="text/javascript">
function SelectAll(id)
{
    document.getElementById(id).focus();
    document.getElementById(id).select();
}
</script>

<?php
	echo '<br><br><i>Click anywhere in the box to select all</i><br><textarea id="code" rows="6" cols="70" onClick="SelectAll(\'code\');">'.$data.'</textarea>';
    }

?>