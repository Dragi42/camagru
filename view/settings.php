<html>
	<head>
		<title>Settings</title>
	</head>
	<body>
		<div class="container">

				<?php	if(array_key_exists('errors', $_SESSION)):	?>
					<div class="alert alert-danger">
						<?= implode('<br>', $_SESSION['errors']); ?>
					</div>
				<?php endif; ?>
				<?php	if(array_key_exists('success', $_SESSION)): ?>
					<div class="alert alert-success">
						<?= $_SESSION['success']; ?>
					</div>
				<?php endif; ?>

			<div class="starter-template">
				<h2>Change your Login</h2>
				<form action="modeles/account/modify_login.php" method="POST" id="loginform">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputlogin" class="control-label">New Login</label>
								<input type="text" name="login" class="form-control" id="inputlogin" value="<?= isset($_SESSION['inputs']['login']) ? $_SESSION['inputs']['login'] : ''; ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="inputpassword">Password</label>
								<input type="password" name="password" class="form-control" id="inputpassword" value="<?= isset($_SESSION['inputs']['password']) ? $_SESSION['inputs']['password'] : ''; ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="inputcpassword">Confirm Password</label>
								<input type="password" name="cpassword" class="form-control" id="inputcpassword" value="<?= isset($_SESSION['inputs']['cpassword']) ? $_SESSION['inputs']['cpassword'] : ''; ?>">
							</div>
							<button type="submit" class="btn btn-primary">Change Login</button>
						</div>
					</div>
				</form>
			</div>
<!--			<div class="starter-template">
				<h2>Change your password</h2>
				<form action="/?module=account&action=modify_password" method="POST">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputpassword">Old Password</label>
								<input type="password" name="password" class="form-control" id="inputpassword" value="<?= isset($_SESSION['inputs']['password']) ? $_SESSION['inputs']['password'] : ''; ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="inputnewpassword">New Password</label>
								<input type="password" name="newpassword" class="form-control" id="inputnewpassword" value="<?= isset($_SESSION['inputs']['newpassword']) ? $_SESSION['inputs']['newpassword'] : ''; ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="inputcpassword">Confirm Password</label>
								<input type="password" name="cpassword" class="form-control" id="inputcpassword" value="<?= isset($_SESSION['inputs']['cpassword']) ? $_SESSION['inputs']['cpassword'] : ''; ?>">
							</div>
							<button type="submit" class="btn btn-primary">Change Password</button>
						</div>
					</div>
				</form>
			</div>
			<div class="starter-template">
				<h2>Change your E-mail address</h2>
				<form action="/?module=account&action=modify_mail" method="POST">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputmail">Mail</label>
								<input type="email" name="mail" class="form-control" id="inputmail" value="<?= isset($_SESSION['inputs']['mail']) ? $_SESSION['inputs']['mail'] : ''; ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="inputpassword">Password</label>
								<input type="password" name="password" class="form-control" id="inputpassword" value="<?= isset($_SESSION['inputs']['password']) ? $_SESSION['inputs']['password'] : ''; ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="inputcpassword">Confirm Password</label>
								<input type="password" name="cpassword" class="form-control" id="inputcpassword" value="<?= isset($_SESSION['inputs']['cpassword']) ? $_SESSION['inputs']['cpassword'] : ''; ?>">
							</div>
							<button type="submit" class="btn btn-primary">Change Mail</button>
						</div>
					</div>
				</form>

			</div>-->
				<h2>Debug :<h2>
				<?= var_dump($_SESSION); ?>
		</div>
		<script src="./js/settings.js"></script>
	</body>
</html>
