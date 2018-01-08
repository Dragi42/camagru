<html>
	<head>
		<meta charset='utf-8'>
		<title>Camagru - Log in</title>
		<link rel='stylesheet' type='text/css' href='./style/index.css' />
	</head>
	<body>
		<div class='box'>
			<form action='./modeles/auth/auth.php' method='POST' class='form'>
			<h2>Already have any account ?</h2>
				<label>Login:</label>
				<input class='input' type='text' name='login' value=''>
				<label>Password:</label>
				<input class='input' type='password' name='password' value=''><br />
				<button class='button' type='submit' name='submit' value='OK'>Login</button>
			</form>
			<hr>
			<form action='./modeles/create/create.php' method='POST' class='form'>
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
	</body>
</html>
