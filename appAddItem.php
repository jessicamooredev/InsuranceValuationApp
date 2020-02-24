<?php
session_start();  
$custid = $_SESSION['custId'];
require('../connect_db.php');

$sql = "INSERT INTO item (itemCategory, itemType, itemMaterial, itemAccessory, customerId, valued)
VALUES ('$_POST[itemCategory]', '$_POST[itemType]', '$_POST[itemMaterial]', '$_POST[itemAccessory]', $custid, 0) ";

if(!mysqli_query($dbc,$sql))
{
	die ("An error in the SQL query:" . mysqli_error($dbc));
}

$alrMessage = "<br> A record has been added for " . $_POST['itemCategory'] . " ";
mysqli_close($dbc);
?>
<html>
<body>
	<form action="appAddPhoto.php" form class="">
		<?php echo $alrMessage;?>
		<input type="submit" value="add photo and description"/>
	</form>
</body>
</html>