<?php
session_start();
?>
<HTML>
<HEAD>
<TITLE>Items to be valued</TITLE>
</HEAD>
<link rel="stylesheet" href="" type="text/css">
</head>

	<a href="clientMainMenu.html">Main Menu</a>
	<br>
	<a href="">View Previous Valuations</a>	
	<br>
	<a href="">Logout</a>	 

<form name="valuation" class="" action="clientItems2BValued.php" onsubmit="return confirmCheck()" method="post" autocomplete="off" >
<h1>Item Details</h1>
<?php
require ( '../connect_db.php');

//selecting all fields from the table to populate the empty text boxes assigned to each
$sql = "SELECT itemId, itemCategory, itemType, itemMaterial, itemAccessory, customerId FROM item
		WHERE valued = 0 
		LIMIT 1 ";
if(!$result = mysqli_query($dbc, $sql))//if the connection is not successful
{
	die('Error in querying the database' . mysqli_error($dbc));
}
$count = mysqli_num_rows($result);
if($count>=1)
{
	while($row = mysqli_fetch_array($result))
	{
		//gives fields of the table temporary variable names to add to a string of variables
		$itemId = $row['itemId'];
		$category = $row['itemCategory'];
		$type = $row['itemType'];
		$material = $row['itemMaterial'];
		$access = $row['itemAccessory'];
		$cust = $row['customerId'];
		$_SESSION['itemid'] = $itemId;	
	}  
}
else
{
	echo "<h2>No more items to be valued</h2><br>";
		//gives fields of the table temporary variable names to add to a string of variables
		$itemId = 'null';
		$category = ' ';
		$type = ' ';
		$material =' ';
		$access = ' ';
		$cust = ' ';
		$_SESSION['itemid'] = $itemId;	
	
}
	
mysqli_close($dbc);
?>
<?php 
require ( '../connect_db.php');
$final_width_of_image = 100; 
function show_photo($dbc)
{
	$item = $_SESSION['itemid']; //has to be declared in function, not outside, cant see it otherwise
	$q = "SELECT image, itemId
		  FROM photo
		  WHERE itemID =$item ";
	$r = mysqli_query( $dbc, $q );
	if($r)
	{
		while ( $row = mysqli_fetch_array($r, MYSQLI_ASSOC))
		{
			  echo '<html>
					<head>
					<style>
					img{
						border: 1px solid #ddd;
						border-radius: 4px;
						padding: 5px;
						width: 150px;
					}
					img:hover {
						box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
					}
					</style>
					</head>
					<body>
					<h2>Thumbnail Image</h2>
					<p>Click on the image to enlarge it.</p>
					
					<a target="_blank" href="data:image/jpeg;base64,' . base64_encode( $row['image'] ) . '">
					<img src="data:image/jpeg;base64,' . base64_encode( $row['image'] ) . '" alt="insurance valuation image" style="width:150px"/>
					</a>
					</body>
					</html>';
		}
	}
	else {echo '<p>' . mysqli_error($dbc). '</p>';}
}
	
show_photo($dbc);
mysqli_close($dbc);
?>
<table>
<tr>
	
	<td></td> <td> <input type ="hidden" name="addid" id ="addid" value="<?php echo $itemId;?>"></td><tr>
	
	<td><label>Item Category</td> <td> <input type ="text" name="addcate" id ="addcate" value="<?php echo $category;?>" disabled> </label></td><tr>
	<td><label>Item Type</td> <td> <input type ="text" name="addtype" id ="addtype" value="<?php echo $type;?>" disabled> </label></td><tr>
	<td><label>Item Material</td> <td> <input type ="text" name="addmate" id ="addmate" value="<?php echo $material;?>" disabled> </label></td><tr>
	<td><label>Item Accessory</td> <td> <input type ="text" name="addacc" id ="addacc" value="<?php echo $access;?>" disabled> </label></td><tr>
	<td></td> <td> <input type ="hidden" name="custID" id ="custID" value="<?php echo $cust;?>"></td><tr>
	
	<td><label>Calculations</td> <td> <input type ="text" name="calc" id ="calc" > </label></td><tr>
	<td><label>Value</td> <td> <input type ="text" name="value" id ="value" > </label></td><tr>
	
	<td><label>Valuation Complete?</td> <td> 
	<input type="checkbox" name="valued" id="valued" value="1"> </label></td><tr>
	</table>
	<input type="submit" value="Save Value"/><br>
	<input type="reset" value="Clear" name="reset"/>
</body>
</HTML>
