<html>
	<head>
		<title>SIAS-New application</title>
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

		$sid = $_GET["sid"];
		$sname = $_GET["sname"];

		// ERROR you can't add anymore
		echo "You can't add any more internship applications, you already have 3 applications <br>";
		echo "<a href='page.php?username=".$sname."&password=".$sid."'>Back</a>". "<br>";
	
		echo "<a href='index.php'>Log out</a>";
	?>
	</div>
	</body>
	
</html>