<?php
	include "include/config.php";
	
	$type = $_REQUEST['action'];
	if($type =="Logout"){		
		$_SESSION['user'] = "";
		header("location: login.php");	
	}
	
	/* ���ⶩ�� */
	







?>
<script language="javascript">


location.href = 'login.php';

</script>
