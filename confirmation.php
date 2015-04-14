<? session_start();?>

<!DOCTYPE html>
<html>
<head>
	<title>Confirmation</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div id="title">
		<h1>You have successfully purchased the Following Books: </h1>
	</div>

	<ul style="list-style: none;">
		<?php 
			$conn=mysqli_connect('sophia.cs.hku.hk','bpeng','Emma1993') or die ('Failed to Connect '.mysqli_error($conn));
			mysqli_select_db($conn, 'bpeng') or die ('Failed to Access DB'.mysqli_error($conn)); 

			$subtotal = 0;

			if (isset($_SESSION['shoppingCart'])) {
				$str = implode(",", $_SESSION['shoppingCart']);

				$query = 'select * from catalog where itemID in (' . $str . ')';
				$result = mysqli_query($conn, $query) or die ('Failed to query '. mysqli_error($conn));

				while($row=mysqli_fetch_array($result)) {
					$quantity = $_SESSION['itemQuantity'][$row['itemID']]; 
					$subtotal += $row['itemPrice'] * $quantity;

					print "<li>" . "<div class=\"item\">";
					print "<h3>" . $row['itemName'] . "</h3>";
					print "<p>" . $row["itemDescription"] . "</p><br>";
					print "<p>Price: " . $row["itemPrice"] . "HKD</p><br>";
					print "<p>Quantity: " . $quantity . "</p><br>";
					print "<img src=\"" . $row["itemImage"] . "\" width=\"120\" heigth=\"100\"><br>";
					print "</div>";
					print "</li>";
				}
			}
		?>
	</ul>
</body>
</html>