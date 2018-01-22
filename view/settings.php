<?php
	session_start();
?>

<html>
	<head>
		<title>Camagru - Settings</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
		<style>
			body {	padding-top: 40px; }
			.starter-template {	.padding-top: 40px; }
		</style>
	</head>
	<body>
		<div class="container">
			<div class="starter-template">

				<?php	if(array_key_exists('errors', $_SESSION)):	?>
					<div class="alert alert-danger">
						<?= implode('<br>', $_SESSION['errors']); ?>
					</div>
				<?php endif; ?>

				<form action="modify_password.php" method="POST">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="inputlogin">Login</label>
								<input type="text" name="login" class="form-control" id="inputlogin" value="<?= isset($_SESSION['inputs']['login']) ? $_SESSION['inputs']['login'] : ''; ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="inputpassword">Password</label>
								<input type="text" name="password" class="form-control" id="inputpassword" value="<?= isset($_SESSION['inputs']['password']) ? $_SESSION['inputs']['password'] : ''; ?>">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputmail">Mail</label>
								<input type="text" name="mail" class="form-control" id="inputmail" value="<?= isset($_SESSION['inputs']['mail']) ? $_SESSION['inputs']['mail'] : ''; ?>">
							</div>
							<button type="submit" class="btn btn-primary">Create</button>
						</div>
					</div>
				</form>
				<h2>Debug :<h2>
				<?= var_dump($_SESSION); ?>
			</div>
		</div>
		<script src="js/settings.js"></script>
	</body>
</html>

<?php

	unset($_SESSION['inputs']);
	unset($_SESSION['errors']);

?>
