<?php

session_start();
if ($_SESSION['logged_on_user'])
	header("location: home.php");
include("header.php");

if ($_SESSION['created'] == 1) {
	echo "<html><h2 style='color: green; text-align: center;'>Account created Succefully !</h2><hr></html>";
	$_SESSION['created'] = 0;
}

if ($_SESSION['created'] == -1) {
	echo "<html><h2 style='color: red; text-align: center;'>Confirm Password or Password doesn't match</h2><hr></html>";
	$_SESSION['created'] = 0;
}

if ($_SESSION['created'] == -2) {
	echo "<html><h2 style='color: red; text-align: center;'>Account already used</h2><hr></html>";
	$_SESSION['created'] = 0;
}

if ($_SESSION['created'] == -3) {
	echo "<html><h2 style='color: red; text-align: center;'>Please complete the form</h2><hr></html>";
	$_SESSION['created'] = 0;
}

echo "<html>
	<head>
		<meta charset='utf-8'>
		<title>Camagru - Log in</title>
		<link rel='stylesheet' type='text/css' href='css/index.css' />
	</head>
	<body>
		<div class='box'>
			<form action='Database/auth/auth.php' method='POST' class='container'>
			<h2>Already have any account ?</h2>
				<label>Login:</label>
				<input class='input' type='text' name='login' value=''>
				<label>Password:</label>
				<input class='input' type='password' name='password' value=''><br />
				<button class='button' type='submit' name='submit' value='OK'>Login</button>
			</form>
			<hr>
			<form action='Database/create/create.php' method='POST' class='container'>
			<h2>Create a new account and join us !</h2>
				<label>Login:</label>
				<input class='input' type='text' name='login' value=''>
				<label>E-mail:</label>
				<input class='input' type='mail' name='mail' value=''>
				<label>Password:</label>
				<input class='input' type='password' name='passwd' value=''>
				<label>Confirm Password:</label>
				<input class='input' type='password' name='cpasswd' value=''><br />
				<button class='button' type='submit' name='submit' value='OK'>Create</button>
			</form>
		</div>
		<div id='footer'>
			<hr />
			<p>@2017 dpaunovi</p>
		</div>
	</body>
</html>";
?>
