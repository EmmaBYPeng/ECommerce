<? session_start(); ?>

<?php

	function addToCart($itemID) {
		if (!isset($_SESSION['shoppingCart'])) {
			$_SESSION['shoppingCart'] = array();
		}
		if (!in_array($itemID, $_SESSION['shoppingCart'])){
			array_push($_SESSION['shoppingCart'], $itemID);
		}
	}

	if (!empty($_GET)) {
		addToCart($_GET['itemID']);
	}

	$conn=mysqli_connect('sophia.cs.hku.hk','bpeng','Emma1993') or die ('Failed to Connect '.mysqli_error($conn));
	mysqli_select_db($conn, 'bpeng') or die ('Failed to Access DB'.mysqli_error($conn)); 
	
	if (isset($_SESSION['shoppingCart'])) {
		$str = implode(",", $_SESSION['shoppingCart']);

		$query = 'select * from catalog where itemID in (' . $str . ')';
		$result = mysqli_query($conn, $query) or die ('Failed to query '. mysqli_error($conn));
		//'.implode(",", $_SESSION['shoppingCart']).'
		//. substr($str, 0, strlen($str)-1) .

		$json = array();
		while($row=mysqli_fetch_array($result)) {

			$json[]=array('itemID'=>$row['itemID'], 'itemName'=>$row['itemName'], 'itemDescription'=>$row['itemDescription'], 
						  'itemImage'=>$row['itemImage'],'itemPrice'=>$row['itemPrice']);
		}

		print json_encode(array('Item'=>$json));
	} else {
		print "";
	}

?>