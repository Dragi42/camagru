<html>
	<head>
		<meta charset='utf-8'>
		<title>Camagru - Log in</title>
	</head>
	<body>
		<div class='box'>
			<form action='./modeles/auth/auth.php' method='POST' class='log_form'>
			<h2>Already have any account ?</h2>
				<label>Login:</label>
				<input class='input' type='text' name='login' value='' required>
				<label>Password:</label>
				<input class='input' type='password' name='password' value='' required><br />
				<button class='button' type='submit' name='submit' value='OK' required>Login</button>
			</form>
			<hr>
			<form action='./modeles/create/create.php' method='POST' class='log_form'>
			<h2>Create a new account and join us !</h2>
				<label>Login:</label>
				<input class='input' type='text' name='login' value='' required>
				<label>E-mail:</label>
				<input class='input' type='mail' name='mail' value='' required>
				<label>Password:</label>
				<input class='input' type='password' name='passwd' value='' required>
				<label>Confirm Password:</label>
				<input class='input' type='password' name='cpasswd' value='' required><br />
				<button class='button' type='submit' name='submit' value='OK' required>Create</button>
			</form>
		</div>
	</body>
</html>
