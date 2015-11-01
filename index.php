<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	session_start();
	if(!isset($_SESSION['error'])){
		$_SESSION['error']='';
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Survey Form</title>
	<style type="text/css">
		*{
			font-family: arial, sans-serif;
		}
		#container{
			background-color: darkgrey;
			margin: 0 auto;
			width: 1000px;
			text-align: right;
			padding-right: 0px;
		}
		input{
			margin-right: 500px;

		}
		h1{
			text-align: left;
		}
		#login{
			margin: 20px 0 0 0;
		}
		.submit{
			margin: 0 600px 0 0;
			background-color: lightblue;
			border-color: lightblue;
			border-radius: 7px;
		}
		img{
			display: inline-block;
		}
		form{
			display: inline-block;
		}
		#errArea{
			border-color: rgb(240,120,100);
			margin: 0 auto;
		}
		.errText{
			margin-top: 5px;
			line-height: 18px;
			color: rgb(200,100,100);
			text-align: center;
		}
		.registered{
			margin-top: 5px;
			color: green;
			text-align: center;
			border-color: solid rgb(100,250,150) 1px;
		}
	</style>
</head>
<body>
<div id="container">
<div id="errArea">
	<?= $_SESSION['error'];?>
	<?php unset($_SESSION['error']);?>
</div>
	<h1>Welcome to THE WALL</h1>
	<h1>Register here:</h1>
	<form action="./process.php" method="post">
		<div>
			<input type='hidden' name='action' value='add' />
			<label for="fname">First name: </label>
			<input type="text" name="fname" placeholder="First name" value="Crunchy">
		</div>
		<div>
			<label for="lname">Last name: </label>
			<input type="text" name="lname" placeholder="Last name" value="Krab">
		</div>
		<div>
			<label for="email">Email: </label>
			<input type="text" name="email" placeholder="email" value="john@fasdmail.com">
		</div>
		<div>
			<label for="password">Password: </label>
			<input type="password" name="password" value="turnip21">
		</div>
		<div>
			<label for="confirm">Confirm Password: </label>
			<input type="password" name="confirm" value="turnip21">
		</div>
		<label for="file">Submit a profile picture!</label>
		<input name="file" type="file">
		<div><input class="submit" type="submit" name="Submit"></div>
	</form>
	<h1>Login:</h1>
	<div id="login">
		<form action="./process.php" method="post">
			<div>
				<label for="email">Email: </label>
				<input type="text" name="email" placeholder="email" value="john@fasdmail.com">
			</div>
			<div>
				<label for="password">Password: </label>
				<input type="password" name="password" value="turnip21">
			</div>
			<div>
				<input type='hidden' name='action' value='login' />
				<input class="submit" type="submit" name="Log in" value="Log in">
			</div>
		</form>
	</div>
</div>
</body>
</html>