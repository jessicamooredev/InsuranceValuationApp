<?php 
require ('../connect_db.php');

$sql = "INSERT INTO valuator (firstName,lastName,address,phoneNo,email,PPSN,loginName,password)
VALUES ('$_POST[firstName]','$_POST[lastName]','$_POST[address]','$_POST[phoneNo]','$_POST[email]','$_POST[ppsn]','$_POST[loginName]','$_POST[password]')";

if(!mysqli_query($dbc,$sql))
{
	die("An error in the SQL query: " . mysqli_error($dbc));
}
$alrMessage = "<br> A record has been added for " . $_POST['firstName'] . " " . $_POST['lastName'] . " ";

mysqli_close($dbc);
?>
<html>
<body>
	<form action="clientMainMenu.html" form class="" method="POST">
	<?php echo $alrMessage;?>
	<input type="submit" value="return to main menu">
	</form>
</body>
</html>