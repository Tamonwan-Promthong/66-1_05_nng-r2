<?php
	ob_start();
	session_start();
	if(isset($_GET['orderId'])) {
		$orderId = $_GET['orderId'];
		echo $orderId;
	}
	$Line = $_GET["Line"];
	$_SESSION["strProductID"][$Line] = "";
	$_SESSION["strQty"][$Line] = "";
	header("location: editBuying.php?id=" . $orderId);
?>