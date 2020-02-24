<?php require('../connect_db.php');
session_start();
$loginMessage="";
if(isset($_POST['loginName']) && isset($_POST['password']) )
{
	$att = $_SESSION['attempts'];
	
	$sql = "SELECT loginName,password FROM valuator
			WHERE loginName = '$_POST[loginName]'
			AND password = '$_POST[password]' ";
			
	if (!mysqli_query($dbc,$sql))
	{
		echo "Error in query " . mysqli_error($dbc);
	}
	else
	{
		if(mysqli_affected_rows($dbc) == 0)
		{
			$att++;
			
			if($att <= 3)
			{
				$_SESSION['attempts'] = $att;
				builldPage($att);
				
				$loginMessage = "<h2>No record found with the login name and password combination 
									- Please try again.</h2> ";
			}
			else 
			{
				$loginMessage = "<h2>Sorry - you have used all your attempts</h2>
									<br><h2>Shutting down...</h2> ";
			}
		}
		else
		{
			$valt = "SELECT valuatorId FROM valuator
					WHERE loginName = '$_POST[loginName]' ";
			if(!$result = mysqli_query($dbc,$valt))
			{
				echo "Error in query " . mysqli_error($dbc);
			}
			
			while($row = mysqli_fetch_array($result))
			{
				$_SESSION['valtid'] = $row['valuatorId'];
				echo $_SESSION['valtid'];
			}
		echo "<body>
				<form class='' action='clientLogin.php'>
				<div>
				<h2>Login successful!</h2>
				<input type='button' value='Main Menu' onclick='window.location = \"clientMainMenu.html\"'>
				</div></form> ";
		}
	}
}
else
{
	$att = 1;
	$_SESSION['attempts'] = $att;
	buildPage($att);
}
function buildPage($att)
{
	echo "<body>
			<form class='' action='clientLogin.php' method='POST' autocomplete='off'>
			<h1 class=''>Insurance Company</h1>
			<div>
			<label>Login Name: <input type='text' name='loginName' id='loginName'/></label><br>
			<label>Password: <input type='password' name='password' id='password'/></label><br>
			<input type='submit' value='login'>
			</div></form> ";
}
mysqli_close($dbc);
?>
<html>
<head><title>Logging in</title>
</head>
<body>
<form action="clientLogin.php" form class="" method="POST">
<?php echo $loginMessage;?>
</form>
</body>
</html>