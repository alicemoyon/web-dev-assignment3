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
		
function displayCustomers () {
	
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
		
// Displaying Customers info from db
$sql = "SELECT customerName, city, country, phone FROM classicmodels.customers ORDER BY country";
$result = mysqli_query($conn, $sql);

if (!$result) {
	throw new Exception("SQL query failed: " . mysqli_error($conn));
}
	
if (mysqli_num_rows($result) > 0) {
	
	echo "<div id=\"customers\">";
	echo "<h2>Customers</h2>";
    // output data of each row
	$countryArray = [];
    while($row = mysqli_fetch_assoc($result)) {
		if (in_array($row["country"], $countryArray)){
			echo "<p><span class = 'cust_name'>" . $row["customerName"] . ", </span>" . $row["city"] . ", " . $row["country"] . ", " . $row["phone"] . "</p>";
		} else {
			array_push($countryArray, $row["country"]);
			echo "<h3 class=\"country\">" . $row["country"] . "</h3>";
			echo "<p><span class = 'cust_name'>" . $row["customerName"] . ", </span>" . $row["city"] . ", " . $row["country"] . ", " . $row["phone"] . "</p>";
		}
//        echo "<p><span class = 'cust_name'>" . $row["customerName"] . ", </span>" . $row["city"] . ", " . $row["country"] . ", " . $row["phone"] . "</p>";
    }

	echo "</div>";
} else {
    echo "<p>Uh oh! There aren't any customers in the database</p>";
	echo "<p>This doesn't seem right, please contact your Database Administrator</p>";
}
// Close connection
mysqli_close($conn);

}
		
try {
	displayCustomers();
}
		
catch(Exception $e) {
	echo "<div class=\"error\"><p>Error: " . $e->getMessage() . " </p><p class=\"error\">Your database connection failed, please contact your database administrator with the error details above and go grab a cup of coffee while she fixes it for you</p></div>";
}		

?>
	</main>
	<?php include("includes/footer.php");?>
</body>

</html>
