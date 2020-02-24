<?php  
session_start();
$custid = $_SESSION['custId'];
require ('../connect_db.php');
$items = $_POST['items'];

$message = "Has yet to be valued
			<form action='appMainMenu.html' method='POST'>
			<input type='submit' value='return to main menu'>
			</form> ";
			echo $message;
$sql = "SELECT value FROM valued 
		WHERE customerId = $custid 
		AND itemId = $_POST[items] ";
$result= mysqli_query($dbc,$sql);

if($result)
{ 	
	//output data of each row
	while($row = mysqli_fetch_assoc($result)) 
	{ echo "while";
		$message = "value: " . $row["value"] . " <br> " .
				"<form action='appInsure.html' method='POST'>
				<input type='submit' value='Insure'>
				</form> ";
				echo $message;
				
	}
}

mysqli_close($dbc);
?>
<html>
<head><title>View Value</title>
</head>

<body>
<div>
	<a href="appMainMenu.html">Main Menu</a>
	<a href="appAddItem.html">Add a new item</a>
	<a href="">View Valuation Progress</a>
	<a href="appViewValue.html.php">View Value</a>
	<?php echo $message;?>
</div>
</body>
</html>
