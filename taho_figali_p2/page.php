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

		$username = $_GET["username"];
		$password = $_GET["password"];
		
		if($username == "" && $password == ""){
			// echo "<script type='text/jscript'>alert('Your username and pass are empty')</script>";
			echo "<a href='index.php'>Go back</a>";
		}else if($username == ""){
			// echo "<script type='text/jscript'>alert('Your username is empty')</script>";
			echo "<a href='index.php'>Go back</a>";
		}else if($password == ""){
			// echo "<script type='text/jscript'>alert('Your pass is empty')</script>";
			echo "<a href='index.php'>Go back</a>";
		}else{
			$val_check = "SELECT * FROM student WHERE sname = '$username' AND sid = '$password';";
			$res = $conn->query($val_check);

			if($res->num_rows == 0){
				echo "<script type='text/jscript'>alert('There is something wrong with email or pass. Please re-enter')</script>";
				echo "<a href='index.php'>Go back</a>";
			}
			else{

				$sql = "SELECT cid, cname, quota, sname 
						FROM apply NATURAL JOIN company NATURAL JOIN student
						WHERE sname = '$username' AND sid = '$password'; ";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
					// output data of each row
					while($row = $result->fetch_assoc()) {
						echo "" . $row["cid"]. " ---- company name: " . $row["cname"]. " ---- total quota: " . $row['quota']. " ";
						echo "<a href='delete.php?sname=".$username."&sid=".$password."&cid=".$row[cid]."' >Cancel</a> ". "<br>";
					}
				} else{
					echo "You have currently no applications <br>";
				}
				
				$sql2 = "SELECT DISTINCT sid 
						FROM apply 
						WHERE 2 >= ALL(
									SELECT DISTINCT COUNT(cid) as a 
									FROM apply 
									WHERE sid = '$password');";
				$result2 = $conn->query($sql2);

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
				
				if($result2->num_rows > 0 && $result_companies->num_rows > 0){
					echo "<a href='apply_new.php?sname=".$username."&sid=".$password."' >Apply for new internship</a> ". "<br>";
				}else{
					echo "<a href='cant_apply_new.php?sname=".$username."&sid=".$password."' >Apply for new internship</a> ". "<br>";
				}
				echo "<a href='index.php'>Log out</a>";
			}
		}
		
	?>
	

	</div>
	</body>
	
</html>
