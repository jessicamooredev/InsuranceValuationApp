<?php require('../connect_db.php');
session_start();
$loginMessage="";
if(isset($_POST['loginName']) && isset($_POST['passWord']) )
{
	$att = $_SESSION['attempts'];
	
	$sql = "SELECT loginName,password FROM customer 
			WHERE loginName = '$_POST[loginName]'
			AND password = '$_POST[passWord]' ";
			
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
				buildPage($att);
				
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
			//$_SESSION['user'] = $_POST['loginName'];
			//echo $_SESSION['user'];
			$cust = "SELECT customerId FROM customer
					WHERE loginName = '$_POST[loginName]'";
			if(!$result = mysqli_query($dbc, $cust))
			{
				echo "Error in query " . mysqli_error($dbc);
			}

				while($row = mysqli_fetch_array($result))
				{
					//$_SESSION['user'] = $_POST['loginName'];
					$_SESSION['custId'] = $row['customerId']; 
					echo $_SESSION['custId'];
				}
			echo "<body>
				  <form class='' action='appLogin.php'>
				  <div>
				  <h2>Login successful!</h2>
				  <input type='button' value='Main Menu' onclick = 'window.location = \"appMainMenu.html\"'>
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
		<form class='' action='appLogin.php' method='POST' autocomplete='off'>
		<h1 class=''> Insurance Valuation App</h1>
		<div>
		<label>Login Name: <input type='text' name='loginName' id='loginName'/></label><br>
		<label>Password: <input type='password' name='passWord' id='passWord'/></label>
		<input type='submit' value='login'>
		</div></form> ";
}
mysqli_close($dbc);
?>
<html>
<head><title>Logging In</title>
</head>
<body>
<form action="appLogin.php" form class="" method="POST">
<?php echo $loginMessage;?>
</form>
</body>
</html>