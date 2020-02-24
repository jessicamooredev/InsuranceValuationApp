<?php
require('../connect_db.php');

$sql ="INSERT INTO customer (firstName,lastName,age,address,phoneNumber,loginName,password,policyType,discount,email,insurancePremium)
VALUES ('$_POST[firstName]','$_POST[lastName]','$_POST[age]','$_POST[address]','$_POST[phoneNo]','$_POST[loginName]','$_POST[password]','$_POST[policyType]','$_POST[discount]','$_POST[email]','$_POST[insurancePremium]')";

if(!mysqli_query($dbc,$sql))
{
	die("An error in the SQL query: " . mysqli_error($dbc));
}
$alrMessage = "<br> A record has been added for " . $_POST['firstName'] . $_POST['lastName'] . " ";

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