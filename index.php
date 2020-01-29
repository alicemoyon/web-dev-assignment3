<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Classic Models Co. - Intranet</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<?php //include("includes/customError.php");?>
</head>

<body>
	<header>
		<?php include("includes/navigation.php");?>
	</header>
	<main>
		<?php
		
function dbProdlines() {
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
		
// Displaying Product Lines from db
$sql = "SELECT productLine, textDescription FROM classicmodels.productlines";
$result = mysqli_query($conn, $sql);

if (!$result) {
	throw new Exception("SQL query failed: " . mysqli_error($conn));
}
echo "<div id=\"products\">";
echo "<div id=\"prodlines\">";
echo "<h2>Product Lines</h2>";
		
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
		$line = $row["productLine"];
        echo "<h3 class = 'prodline' onclick=\"prodlineDetails('" . $line . "')\">" . $row["productLine"] . "</h3><p class = 'prodline-desc'>" . $row["textDescription"] . "</p>";
    }

} else {
    echo "<p>Uh oh! There aren't any product lines in the database</p>";
	echo "<p>This doesn't seem right, please contact your Database Administrator</p>";
}
echo "</div></div>";

// Close connection
mysqli_close($conn);
	
}
		
try {
	dbProdlines();
}
		
catch(Exception $e) {
	echo "<div class=\"error\"><p>Error: " . $e->getMessage() . " </p><p class=\"error\">Your database connection failed, please contact your database administrator with the error details above and go grab a cup of coffee while she fixes it for you</p></div>";
}

?>
		<script>
			function prodlineDetails(line) {
				var xhttp = new XMLHttpRequest();
				xhttp.open("GET", "getProductsInfo.php?q=" + line, true);
				xhttp.send();
				xhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						document.getElementById("products").innerHTML = this.responseText;
					};

				}
			};

		</script>

	</main>
		<?php include("includes/footer.php");?>

</body>

</html>
