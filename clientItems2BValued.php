<?php
session_start();
$valtid = $_SESSION['valtid'];
//$itemId,$itemDescription,$calculations,$value,$customerId
require ( '../connect_db.php');
//if any changes submitted from the html, they will be updated to the table here
$sql = "INSERT INTO valued (calculationsDone, value, itemId, valuatorId, customerId, progress)
VALUES ('$_POST[calc]', '$_POST[value]', '$_POST[addid]', $valtid, '$_POST[custID]', '2' ) ";

if(!mysqli_query($dbc, $sql))//if the connection doesn't happen
{
	echo "Error in connection" . mysqli_error($dbc);
}		  
else
{
	if(mysqli_affected_rows($dbc)!= 0)//if any rows come back changed, this if statement will be entered
	{
		$insertMessage = mysqli_affected_rows($dbc)."record(s) updated <br>";
		$insertMessage = "CustomerID".$_POST['custID'].", with item ".$_POST['addid']." "." has been valued";
	}
	else
	{
		$insertMessage = "No records were changed";
	}
}
mysqli_close($dbc);
?>
<?php
require ( '../connect_db.php');

$chbxsql = "UPDATE item SET valued = '$_POST[valued]'
			WHERE itemId = '$_POST[addid]' ";

if (!mysqli_query($dbc, $chbxsql))
{
	echo "Error in connection for checkbox" . mysqli_error($dbc);
}
else
{
	if(mysqli_affected_rows($dbc)!= 0)//if any rows come back changed, this if statement will be entered
	{
		$chbxmessage = mysqli_affected_rows($dbc)."record(s) updated <br>";
	}
	else
	{
		$chbxmessage = "No records were changed";
	}
}
mysqli_close($dbc);
?>
<html>
<head>
<link rel="stylesheet" href="" type="text/css"><!--links to appropriate css file.--> 
</head>
<body>
<form action = "clientItems2BValued.html.php" method = "POST">
<br>
<?php echo $insertMessage;?>
<?php echo $chbxmessage;?><!--message depends on the action taken on the table and the changes carried out,if any.-->
<br>
<input type = "submit" value = "Return to Items to be valued">
</form>
</body>
</html>
						