<?php

// Starts here

function getOrderInfo() {
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classicmodels";
$orderNum = $_GET['q'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    throw new Exception("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM orders WHERE orderNumber='" . $orderNum . "'";

$result = $conn->query($sql);

if (!$result) {
	throw new Exception("SQL query failed: " . mysqli_error($conn));
}

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		echo "<h2>Details for order no. " .$row["orderNumber"]. "</h2>";
        echo "<table id='order_info'><tr><th>Order Date:</th><td>".$row["orderDate"]."</td></tr><tr><th>Date Required:</th><td>".$row["requiredDate"]."</td></tr><tr><th>Date Shipped:</th><td>".$row["shippedDate"]."</td></tr><tr><th>Status:</th><td>".$row["status"]."</td></tr><tr><th>Comments:</th><td>".$row["comments"]."</td></tr><tr><th>Customer Number:</th><td>".$row["customerNumber"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p class=\"centre_error\">Cannot find details for order no. " . $orderNum . "</p>";
	echo "<p class=\"centre_error\">If this doesn't sound right, please contact your Database Administrator</p>";
}
$conn->close();

}

try {
	getOrderInfo();
}
		
catch(Exception $e) {
	echo "<div class=\"error\"><p>Error: " . $e->getMessage() . " </p><p class=\"error\">Your database connection failed, please contact your database administrator with the error details above and go grab a cup of coffee while she fixes it for you</p></div>";
}

?>