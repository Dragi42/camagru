<html>
	<head>
		<title>Settings</title>
	</head>
	<body>
		<div class="container">
			<div class="starter-template">
				<h2>Change your Login</h2>
				<form action="../../modules/account/modify_login.php" method="POST" id="loginform">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputlogin" class="control-label">New Login</label>
								<input type="text" name="loginform-login" class="form-control" value="<?= isset($_SESSION['inputs']['login']) ? $_SESSION['inputs']['login'] : ''; ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="inputpassword">Password</label>
								<input type="password" name="loginform-password" class="form-control" value="<?= isset($_SESSION['inputs']['password']) ? $_SESSION['inputs']['password'] : ''; ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="inputcpassword">Confirm Password</label>
								<input type="password" name="loginform-cpassword" class="form-control" value="<?= isset($_SESSION['inputs']['cpassword']) ? $_SESSION['inputs']['cpassword'] : ''; ?>">
							</div>
						</div>
						<button type="submit" class="btn btn-primary">Change Login</button>
					</div>
				</form>
			</div>
			<div class="starter-template">
				<h2>Change your password</h2>
				<form action="../../modules/account/modify_password.php" method="POST" id="passwordform">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputpassword">Old Password</label>
								<input type="password" name="pwform-password" class="form-control" value="<?= isset($_SESSION['inputs']['password']) ? $_SESSION['inputs']['password'] : ''; ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="inputnewpassword">New Password</label>
								<input type="password" name="pwform-newpassword" class="form-control" value="<?= isset($_SESSION['inputs']['newpassword']) ? $_SESSION['inputs']['newpassword'] : ''; ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="inputcpassword">Confirm Password</label>
								<input type="password" name="pwform-cpassword" class="form-control" value="<?= isset($_SESSION['inputs']['cpassword']) ? $_SESSION['inputs']['cpassword'] : ''; ?>">
							</div>
						</div>
						<button type="submit" class="btn btn-primary">Change Password</button>
					</div>
				</form>
			</div>
			<div class="starter-template">
				<h2>Change your E-mail address</h2>
				<form action="../../modules/account/modify_mail.php" method="POST" id="mailform">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputmail">Mail</label>
								<input type="email" name="mailform-mail" class="form-control" value="<?= isset($_SESSION['inputs']['mail']) ? $_SESSION['inputs']['mail'] : ''; ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="inputpassword">Password</label>
								<input type="password" name="mailform-password" class="form-control" value="<?= isset($_SESSION['inputs']['password']) ? $_SESSION['inputs']['password'] : ''; ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="inputcpassword">Confirm Password</label>
								<input type="password" name="mailform-cpassword" class="form-control" value="<?= isset($_SESSION['inputs']['cpassword']) ? $_SESSION['inputs']['cpassword'] : ''; ?>">
							</div>
						</div>
						<button type="submit" class="btn btn-primary">Change Mail</button>
					</div>
				</form>
			</div>
			<div class="starter-template">
				<h2>Send mail notification after you reveived a comment.</h2>
				<form action="../../modules/account/notif.php" method="POST" id="notifform">
					<div class="row">
						<div class="col-md-12">
							<button type="submit" class="btn btn-primary">Notification: <?= $_SESSION['notification'] == 1 ? "ON" : "OFF"; ?></button>
						</div>
					</div>
				</form>
			</div>
<!--				<h2>Debug :<h2>
				<?= var_dump($_SESSION); ?>-->
		</div>
		<script src="./js/settings.js"></script>
	</body>
</html>
