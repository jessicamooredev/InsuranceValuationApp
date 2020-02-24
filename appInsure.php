<?php 
session_start();
$custid = $_SESSION['custId'];
echo $custid;
require ('../connect_db.php');

$sql = "SELECT email FROM customer WHERE customerId = $custid ";
$result = mysqli_query($dbc,$sql);

if(mysqli_num_rows($result) > 0)
{
	while($row = mysqli_fetch_assoc($result))
	{
		$email = $row["email"]; 
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: sender@sender.com' . "\r\n";
		$subject = 'RE: Change in premium regarding recent valuation';
		$message = 'This email is automated and notifies you that there is a change
		to your policy and premium, due to a recent valuation on one of your 
		personal valuables. An insurance consultant has been notified with regards
		to contacting you through email or over the phone to verify these changes.
		With thanks,
		Insurance Valuation App.';
		mail($email,$subject,$message,$headers);
		$output = "Email sent";
	}
}

mysqli_close($dbc);
?>
<html>
<head><title>Insure Item</title>
</head>
<body>
	<div>
	<a href="appMainMenu.html">Main Menu</a>
	<a href="appAddItem.html">Add a new item</a>
	<a href="">View Valuation Progress</a>
	<a href="appViewValue.html.php">View Value</a>
	</div>
	
	<form action="appMainMenu.html" method="POST">
	<?php $output;?>
	<br>
	<input type="submit" value="Return to main menu">
	</form>
</body>
</html>