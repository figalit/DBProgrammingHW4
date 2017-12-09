<html>
	<head>
		<title>SIAS-Login</title>
	</head>

	<body>
	<div style="width:400px; height: 200px; margin:0 auto; position: fixed; top: 50%; left: 50%; margin-top:-100px; margin-left:-200px">
		<form action="page.php" method="get" onsubmit="return checkValidUsernamePasword()">

			<!-- <label for="username">Username</label>  -->
			<center>Username: <input type="text" id="username" name="username">	<br /><br />
			
			<!-- <label for="password">Password</label>  -->
			Password: <input type="text" id="password" name="password">	<br /><br />
			
			<input id="login" value="Submit" type="submit"> </button>
			</center>
		</form>
	</div>

	<script type="text/javascript">
		function checkValidUsernamePasword(){
			var username = document.getElementById("username").value;
			var password = document.getElementById("password").value;

			if( username == "" && password == ""){
				alert("Enter username and password!");
			}else if(username == ""){
				alert("Enter username!");
			}else if(password == ""){
				alert("Enter password!");
			}	
			location.href="index.php";
		}
	</script>
	</body>
</html>
