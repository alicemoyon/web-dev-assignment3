<?php

// Starts here

function getProductsInfo() {
	
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classicmodels";
$prodline = $_GET['q'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    throw new Exception("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM products WHERE productLine='" . $prodline . "' ORDER BY productCode";

$result = $conn->query($sql);
if (!$result) {
	throw new Exception("SQL query failed: " . mysqli_error($conn));
}

echo "<h2>" . $prodline . "</h2>";
	
if ($result->num_rows > 0) {
    echo "<table id='products'><tr><th>Product Code</th><th>Product Name</th><th>Scale</th><th>Vendor</th><th>Description</th><th>Quantity in Stock</th><th>Buy Price</th><th>MRSP</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["productCode"]."</td><td>".$row["productName"]."</td><td>".$row["productScale"]."</td><td>".$row["productVendor"]."</td><td class=\"desc\">".$row["productDescription"]."</td><td>".$row["quantityInStock"]."</td><td>".$row["buyPrice"]."</td><td>".$row["MSRP"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p class=\"centre_error\">Uh oh! There are no products in the " . $prodline . " product line</p>";
	echo "<p class=\"centre_error\">If this doesn't sound right, please contact your Database Administrator</p>";
}
$conn->close();
	
}

try {
	getProductsInfo();
}
		
catch(Exception $e) {
	echo "<div class=\"error\"><p>Error: " . $e->getMessage() . " </p><p class=\"error\">Your database connection failed, please contact your database administrator with the error details above and go grab a cup of coffee while she fixes it for you</p></div>";
}

?>
