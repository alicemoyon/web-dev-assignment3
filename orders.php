<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Classic Models Co. - Intranet</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<header>
		<?php include("includes/navigation.php");?>
	</header>
	<main>
		<?php
		
function getOrders() {
	

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classicmodels";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
     throw new Exception("Connection failed: " . mysqli_connect_error());
}

echo "<div id=\"orders\">";	
	

// Retrieve orders with status of In Process
	
echo "<h2>Orders in process</h2>";
$sql1 = "SELECT orderNumber, orderDate, status FROM classicmodels.orders WHERE status = 'In Process'";
$result1 = mysqli_query($conn, $sql1);
if (!$result1) {
	throw new Exception("SQL query failed: " . mysqli_error($conn));
}
	
// Display the order tables
if (mysqli_num_rows($result1) > 0) {

	echo "<table id='inprocess'><tr><th>Order Number</th><th>Order Date</th><th>Status</th></tr>";
    // output data of each row
    while($row = mysqli_fetch_assoc($result1)) {
		$order = $row["orderNumber"];
		echo "<tr><td class=\"order\" onclick=\"orderDetails('" . $order . "')\" >".$row["orderNumber"]."</td><td>".$row["orderDate"]."</td><td>".$row["status"]."</td></tr>";
    }
	echo "</table>";
} else {
    echo "<p class=\"centre_error\">There are currently no orders in process</p>";
	echo "<p class=\"centre_error\">If this doesn't sound right, please contact your Database Administrator</p>";
}

// Retrieve all cancelled orders	
	
echo "<h2>Cancelled orders</h2>";
	
$sql2 = "SELECT orderNumber, orderDate, status FROM classicmodels.orders WHERE status = 'Cancelled'";
$result2 = mysqli_query($conn, $sql2);

if (!$result2) {
	throw new Exception("SQL query failed: " . mysqli_error($conn));
}
		
if (mysqli_num_rows($result2) > 0) {
	echo "<table id='cancelled'><tr><th>Order Number</th><th>Order Date</th><th>Status</th></tr>";
    // output data of each row
    while($row = mysqli_fetch_assoc($result2)) {
		$order = $row["orderNumber"];
		echo "<tr><td class=\"order\" onclick=\"orderDetails('" . $order . "')\" >".$row["orderNumber"]."</td><td>".$row["orderDate"]."</td><td>".$row["status"]."</td></tr>";
    }
	echo "</table>";
} else {
    echo "<p class=\"centre_error\">There are currently no cancelled orders in the system</p>";
	echo "<p class=\"centre_error\">If this doesn't sound right, please contact your Database Administrator</p>";
}

// Retrieve the 20 most recents orders
	
echo "<h2>Recent orders</h2>";

$sql3 = "SELECT orderNumber, orderDate, status FROM classicmodels.orders ORDER BY orderDate DESC LIMIT 20";
$result3 = mysqli_query($conn, $sql3);
	
if (!$result3) {
	throw new Exception("SQL query failed: " . mysqli_error($conn));
}
	
if (mysqli_num_rows($result3) > 0) {

	echo "<table id='recent'><tr><th>Order Number</th><th>Order Date</th><th>Status</th></tr>";
    // output data of each row
    while($row = mysqli_fetch_assoc($result3)) {
		$order = $row["orderNumber"];
		echo "<tr><td class=\"order\" onclick=\"orderDetails('" . $order . "')\" >".$row["orderNumber"]."</td><td>".$row["orderDate"]."</td><td>".$row["status"]."</td></tr>";
    }
	echo "</table>";
	
} else {
    echo "<p class=\"error\">Cannot retrieve the 20 most recent orders.</p>";
	echo "<p class=\"error\">Please contact your Database Administrator</p>";
}
	
echo "</div>";

// Close connection
mysqli_close($conn);

}
		
try {
	getOrders();
}
		
catch(Exception $e) {
	echo "<div class=\"error\"><p>Error: " . $e->getMessage() . " </p><p class=\"error\">Your database connection failed, please contact your database administrator with the error details above and go grab a cup of coffee while she fixes it for you</p></div>";
}
	
?>
		<script>
			function orderDetails(order) {
				var xhttp = new XMLHttpRequest();
				xhttp.open("GET", "getOrderInfo.php?q=" + order, true);
				xhttp.send();
				xhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						document.getElementById("orders").innerHTML = this.responseText;
					};
				}
			};

		</script>
	</main>
	<?php include("includes/footer.php");?>
</body>

</html>
