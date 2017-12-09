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

		$cid = $_GET["cid"];
		$sid = $_GET["sid"];
		$sname = $_GET["sname"];

		// $sql_select_unchosen_companies = "SELECT cid FROM (SELECT cid FROM company NATURAL JOIN 
		// 						(SELECT DISTINCT cid  FROM 
		// 							(SELECT DISTINCT COUNT(sid) as cnt, cid, quota 
		// 							FROM company NATURAL JOIN apply
		// 							GROUP BY cid) AS temp 
		// 						 WHERE cnt < quota AND cid NOT IN (SELECT DISTINCT cid
		// 															FROM apply 
		// 														  	WHERE sid = '$sid') ) AS M
		// 							UNION 
		// 							SELECT  DISTINCT cid
		// 							FROM (SELECT DISTINCT cid, cname, quota 
		// 									FROM company 
		// 									WHERE quota > 0 AND cid NOT IN (SELECT cid FROM apply)
		// 								) as other_table ) as u WHERE cid = '$cid';";

		$sql_select_unchosen_companies = "SELECT cid, cname 
										  FROM company NATURAL JOIN 
											 (SELECT DISTINCT cid
											  FROM company 
											  WHERE cid NOT IN (SELECT cid 
											  					FROM apply 
											  					WHERE sid = '$sid' 
											  					UNION 
											  					SELECT cid 
											  					FROM (	SELECT DISTINCT cid,quota 
											  							FROM company NATURAL JOIN (SELECT DISTINCT count(sid) AS cnt, cid 							FROM apply 
											  														GROUP BY cid) AS kk 
											  							WHERE cnt >= quota
											  						  ) AS M
											  					)  
											  UNION 
											  SELECT DISTINCT cid 
											  FROM (SELECT cid, quota 
											  		FROM company 
											  		WHERE quota > 0 AND cid NOT IN (SELECT cid 
											  										FROM apply )
											  	   ) AS t
											  )AS temp2 ;";
		
		$result_companies = $conn->query($sql_select_unchosen_companies);
		if ($result_companies->num_rows > 0) {
	
			$sql = "INSERT INTO apply (sid, cid) VALUES ('$sid', '$cid'); ";
			$result = $conn->query($sql);
			if(!$result){
				die('Couldnt add application');
			}else{
				echo "Application to $cid added successfully <br>";
			}
		}

		echo "<a href='page.php?username=".$sname."&password=".$sid."'>Back</a> <br>";
		echo "<a href='index.php'>Log out</a> <br>";
	?>	
	</div>
	</body>
	
</html>
