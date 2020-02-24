<html>  
<head>
<title>Add a new photo</title>
<link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
<meta charset=utf-8 />
<style>
  article, aside, figure, footer, header, hgroup, 
  menu, nav, section { display: block; }
</style>
<script>
	function readURL(input) {
		if(input.files && input.files[0]) {
			var reader = new FileReader();
			
			reader.onload = function (e) {
				$("#blah")
					.attr('src', e.target.result)
					.width(150)
					.height(200);
			};
			reader.readAsDataURL(input.files[0]);
		}
	}
</script>
</head>
<body>

	<h1>Add a new photo</h1>
	<div>  
	<a href="appMainMenu.html">Main Menu</a>
	<a href="appAddItem.html">Add a new item</a>
	<a href="">View Valuation Progress</a>
	<a href="appViewValue.html.php">View Value</a>
	</div>
	
	<h1 class="">Add a new photo and description</h1>
	<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?> " method="POST" autocomplete="off" >
	<input type="hidden" name="MAX_FILE_SIZE" value="1000000000000000" />
	<input name="userfile" type="file" onchange="readURL(this);" />
	<div>
	<img id="blah" src="#" alt="your image" />
	</div>
	<label class="" for="photoDesc">Photo Description</label>
	<input type="text" name="photoDesc" id="photoDesc" pattern="[a-zA-Z\.\s\,]+" title="Can consist of letters" placeholder="can be overview, jewel close-up, hallmark" required /><br><br>
	<br>
	<input type="submit" value="submit" />
	</form>

<?php

// check if a file was submitted
if(!isset($_FILES['userfile']))
{
    echo '<p>Please select a file</p>';
}
else
{
    try {
    $msg= upload();  //this will upload your image
    echo $msg;  //Message showing success or failure.
    }
    catch(Exception $e) {
    echo $e->getMessage();
    echo 'Sorry, could not upload file';
    }
}

// the upload function

function upload() {
    
	require('../connect_db.php');
    $maxsize = 1000000000000000; //

    //check associated error code
    if($_FILES['userfile']['error']==UPLOAD_ERR_OK) {

        //check whether file is uploaded with HTTP POST
        if(is_uploaded_file($_FILES['userfile']['tmp_name'])) {    

            //checks size of uploaded image on server side
            if( $_FILES['userfile']['size'] < $maxsize) {  
  
               //checks whether uploaded file is of image type
              //if(strpos(mime_content_type($_FILES['userfile']['tmp_name']),"image")===0) {
                 $finfo = finfo_open(FILEINFO_MIME_TYPE);
                if(strpos(finfo_file($finfo, $_FILES['userfile']['tmp_name']),"image")===0) {    

                    // prepare the image for insertion
                    $imgData =addslashes (file_get_contents($_FILES['userfile']['tmp_name']));
					
                    // put the image in the db...
                    // database connection
                   // mysqli_connect($host, $user, $pass) OR DIE (mysqli_error());

                    // select the db
                    //mysqli_select_db ($db) OR DIE ("Unable to select db".mysqli_error());
					
					$itemQ = "SELECT MAX(itemId) as maxId FROM item";
					$result = mysqli_query($dbc,$itemQ);
					$row = mysqli_fetch_assoc($result);
					$maxNo = $row['maxId'];
                    // our sql query
                    $sql = "INSERT INTO photo
                    (image, name, description, itemID)
                    VALUES
                    ('{$imgData}', '{$_FILES['userfile']['name']}', '$_POST[photoDesc]', $maxNo );";

                    // insert the image
					if(!mysqli_query($dbc,$sql))
					{
						die ("An error in the SQL query:" . mysqli_error($dbc));
					}				
                    //mysql_query($sql) or die("Error in Query: " . mysql_error());
                    $msg='<p>Image successfully saved in database</p>
							<p>Add another or return to main menu</p>';
                }
                else
                    $msg="<p>Uploaded file is not an image.</p>";
            }
             else {
                // if the file is not less than the maximum allowed, print an error
                $msg='<div>File exceeds the Maximum File limit</div>
                <div>Maximum File limit is '.$maxsize.' bytes</div>
                <div>File '.$_FILES['userfile']['name'].' is '.$_FILES['userfile']['size'].
                ' bytes</div><hr />';
                }
        }
        else
            $msg="File not uploaded successfully.";

    }
    else {
        $msg= file_upload_error_message($_FILES['userfile']['error']);
    }
    return $msg;
}

// Function to return error message based on error code

function file_upload_error_message($error_code) {
    switch ($error_code) {
        case UPLOAD_ERR_INI_SIZE:
            return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
        case UPLOAD_ERR_FORM_SIZE:
            return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
        case UPLOAD_ERR_PARTIAL:
            return 'The uploaded file was only partially uploaded';
        case UPLOAD_ERR_NO_FILE:
            return 'No file was uploaded';
        case UPLOAD_ERR_NO_TMP_DIR:
            return 'Missing a temporary folder';
        case UPLOAD_ERR_CANT_WRITE:
            return 'Failed to write file to disk';
        case UPLOAD_ERR_EXTENSION:
            return 'File upload stopped by extension';
        default:
            return 'Unknown upload error';
    }
}

?>
</body>
</html>