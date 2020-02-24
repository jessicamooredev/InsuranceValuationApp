<?php 
session_start();
$custid = $_SESSION['custId'];
require ('../connect_db.php');

$sql = "SELECT  itemId, itemType, itemMaterial FROM item 
		WHERE customerId = $custid ";
if(!$result = mysqli_query($dbc, $sql))
{
	echo "Error in querying database " . mysqli_error($dbc);
}
mysqli_close($dbc);
?>
<html>
<head><title>View Value</title>
</head>
<body>
<form action="appViewValue.php" method="POST">
	<select name="items">
		<option value="selectItem">Select item</option>
		<?php
		while ($row = mysqli_fetch_array($result))
		{
			echo "<option value='" .$row['itemId'] ."'>'". $row['itemMaterial'] . " " . $row['itemType'] . "'</option>";
		}
		?>
	</select>
	<input type="submit" value="view value"/>
</form>
</body>
</html>