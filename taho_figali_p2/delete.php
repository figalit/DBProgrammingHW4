<html>
	<head>
		<title>SIAS-Home</title>
	</head>

	<body>
	<div style="width:400px; height: 200px; margin:0 auto; position: fixed; top: 50%; left: 50%; margin-top:-100px; margin-left:-200px">
	<?php
		$dbhost = 'localhost';
		$dbuser = 'figali.taho';
		$dbpass = 'fob6r5.o';
		$dbName = "figali_taho";
		$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbName);

		// check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
	 	// echo 'Connected successfully <br>';

		$sid = $_GET["sid"];
		$cid = $_GET["cid"];
		$sname = $_GET["sname"];
		
		
		$sql = "DELETE 
			FROM apply
			WHERE sid = '$sid' AND cid = '$cid'; ";
		$result = $conn->query($sql);
		if(!$result){
			die('Couldnt delete application');
		}
		else{
			echo "Successfully deleted application to ". $cid. "<br>";
		}
		echo "<a href='page.php?username=".$sname."&password=".$sid."'>Back</a>". "<br>";
		echo "<a href='index.php'>Log out</a> <br>";
	?>
	</div>
	</body>
	
</html>
