<?php
session_start();  
$custid = $_SESSION['custId'];
$itemid = $_SESSION['itemid'];

require('../connect_db.php');
 
$sql = "SELECT progress FROM valued
	  WHERE customerId = $custid
	  AND itemId = $itemid ";
$result = mysqli_query($dbc,$sql);
if(!$result)
{
	die ("An error in the SQL query:" . mysqli_error($dbc));
}
while ($row = mysqli_fetch_array($result))
	{
		$progress = $row['progress'];
		echo json_encode($progress);
	}	
mysqli_close($dbc);
?>