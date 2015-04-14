<? session_start();?>

<!DOCTYPE html>
<html>
<head>
	<title>Checkout</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div id="title">
		<h1>Your Shopping Cart:</h1>
	</div>

	<ul style="list-style: none;">
		<?php 
			$conn=mysqli_connect('sophia.cs.hku.hk','bpeng','Emma1993') or die ('Failed to Connect '.mysqli_error($conn));
			mysqli_select_db($conn, 'bpeng') or die ('Failed to Access DB'.mysqli_error($conn)); 

			$subtotal = 0;

			if (isset($_SESSION['shoppingCart']) && !empty($_SESSION['shoppingCart'])) {
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
					print "<img src=\"" . $row["itemImage"] . "\" width=\"120\" heigth=\"100\" class=\"image\"><br>";
					print "</div>";
					print "</li>";
				}
			}
		?>
	</ul>

	<div id="SubTotal">
		<div class="otherTitle">
			<?php
				print "<h1>Subtotal: " . $subtotal . " hkd</h1>"; 
			?>
		</div>
	</div>

	<div id="Comfirmation">
		<div class="otherTitle">
			<h1>Confirmation:</h1>
		</div>

		<div class="form">
			<form method="post" action="confirmation.php">
				<fieldset>
					<span>User Name: </span><input type="text" name="userName"><br>
					<span>Email: </span><input type="text" name="email"><br>
					<span>Credit Card Number: </span><input type="text" name="cardNum"><br>
					<span>Security Code: </span><input type="password" name="expireDate"><br>
					<span>Expire Date: </span><input type="date" name="expireDate"><br>
					<span>Billing Address: </span><input type="text" name="address"><br>
				</fieldset>
				<input type="submit" value="Confirm Purchase">
			</form>
		</div>
	</div>
</body>
</html>