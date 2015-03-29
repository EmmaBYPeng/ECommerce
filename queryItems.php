<?php
	$conn=mysqli_connect('sophia.cs.hku.hk','bpeng','Emma1993') or die ('Failed to Connect '.mysqli_error($conn));
	mysqli_select_db($conn, 'bpeng') or die ('Failed to Access DB'.mysqli_error($conn));

	$query = 'select * from catalog limit '.$_GET['lastRecord'].', 2';
	$result = mysqli_query($conn, $query) or die ('Failed to query '. mysqli_error($conn));

	$json = array();
	while($row=mysqli_fetch_array($result)) {

		$json[]=array('itemID'=>$row['itemID'], 'itemName'=>$row['itemName'], 'itemDescription'=>$row['itemDescription'], 'itemImage'=>$row['itemImage'],'itemPrice'=>$row['itemPrice']);
	}
	print json_encode(array('Item'=>$json));
?>
