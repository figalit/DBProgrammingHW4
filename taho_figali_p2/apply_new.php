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

		
		// SELECT DISTINCT cid FROM (select distinct count(sid) as cnt, cid from apply group by cid) AS A WHERE cnt <= 2 
		// and cid not in (SELECT distinct cid from apply where sid='21000001');
		// PROCEED to adding a new application. 
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


		// "SELECT cid, cname FROM company NATURAL JOIN 
		// 					(SELECT DISTINCT cid  FROM 
		// 						(SELECT DISTINCT COUNT(sid) as cnt, cid, quota 
		// 						FROM company NATURAL JOIN apply
		// 						GROUP BY cid) AS temp 
		// 					 WHERE cnt < quota AND cid NOT IN (SELECT DISTINCT cid
		// 														FROM apply 
		// 													  	WHERE sid = '$sid') ) AS M
		// 						UNION 
		// 						SELECT  DISTINCT cid, cname
		// 						FROM (SELECT DISTINCT cid, cname, quota 
		// 								FROM company 
		// 								WHERE quota > 0 AND cid NOT IN (SELECT cid FROM apply)
		// 							) as other_table ;";
		
		$result_companies = $conn->query($sql_select_unchosen_companies);
		if ($result_companies->num_rows > 0) {
			// output data of each company
			while($row = $result_companies->fetch_assoc()) {
				echo "" . $row["cid"]. " - " . $row["cname"]. "<br>";
			}
		} else {
			echo "No more companies to apply to! <br>";
		}
		echo "<a href='page.php?username=".$sname."&password=".$sid."'>Back</a><br>";
		echo "<a href='index.php'>Log out</a>";
	?>

	<form action="insert.php" method="get">
		Enter new application cid: <input type="text" id="cid" name="cid">	<br /><br />
		<input type="hidden" id="sid" name="sid" value='<?php echo "$sid";?>' >	<br /><br />
		<input type="hidden" id="sname" name="sname" value='<?php echo "$sname";?>' >	<br /><br />
		<input id="login" value="Submit" type="submit"> </button>
	</form>
	</div>
	</body>
	
</html>
