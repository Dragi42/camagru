<html>
	<head>
		<title>Sign up/Sign in</title>
	</head>
	<body>
		<div class="container">
			<div class="starter-template">
			<form action="./modules/account/resetpwd.php?token=<?= $_GET['token']; ?>" method="POST" id="sign-in">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputpassword">New password</label>
								<input type="password" name="form-password" class="form-control" id="inputpassword">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputcpassword">Confirm New Password</label>
								<input type="password" name="form-cpassword" class="form-control" id="inputcpassword">
							</div>
						</div>
						<button type="submit" class="btn btn-primary">Change password</button>
					</div>
				</form>
				<h2>Debug :<h2>
				<?= var_dump($_SESSION); ?>
			</div>
		</div>
	</body>
<!--	<script src='./js/account.js'></script>-->
</html>
