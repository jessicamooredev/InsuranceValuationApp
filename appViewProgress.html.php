<html lang="en">
<head>
<title>View Valuation Progress</title>
</head>
<body>
<div id="progressbar"></div>
<p id="demo"></p>
<script>
	 function reqListener () 
	 {
      console.log(this.responseText);
    }
	var oReq = new XMLHttpRequest(); //New request object
    oReq.onload = function() 
	{
        //This is where you handle what to do with the response.
        //The actual data is found on this.responseText
		document.getElementById("demo").innerHTML = typeof this.responseText;
		
		var data=0;
		alert(data);
		if(this.responseText== "1")
		{
			alert("if statement");
			data=1;
		}
		if(this.responseText == "2")
		{
			alert("if statement");
			data=2;
		}
		if((this.responseText) =="3")
		{
			alert("if statement");
			data=3;		
		}
		$("#progressbar").progressbar({
			max:3,
			value:data
			});
		
    };
	
    oReq.open("get", "get-data.php", true);
    //                               ^ Don't block the rest of the execution.
    //                                 Don't wait until the request finishes to 
    //                                 continue.
    oReq.send();
</script> 
</body>
</html>