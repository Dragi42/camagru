<html>
	<head>
		<title>Sign up/Sign in</title>
	</head>
	<body>
		<div class="container">
			<div class="starter-template">
				<form action="./?module=account&action=create" method="POST" id="sign-up">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="inputlogin">Login</label>
								<input type="text" name="cform-login" class="form-control" id="inputlogin" value="<?= isset($_SESSION['inputs']['cform-login']) ? $_SESSION['inputs']['cform-login'] : ''; ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="inputpassword">Password</label>
								<input type="password" name="cform-password" class="form-control" id="inputpassword" value="<?= isset($_SESSION['inputs']['cform-password']) ? $_SESSION['inputs']['cform-password'] : ''; ?>">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputmail">Mail</label>
								<input type="text" name="cform-mail" class="form-control" id="inputmail" value="<?= isset($_SESSION['inputs']['cform-mail']) ? $_SESSION['inputs']['cform-mail'] : ''; ?>">
							</div>
							<button type="submit" class="btn btn-primary">Create</button>
						</div>
					</div>
				</form>
			</div>
			<div class="starter-template">
				<form action="./?module=account&action=login" method="POST" id="sign-in">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputlogin">Login</label>
								<input type="text" name="lform-login" class="form-control" id="inputlogin" value="<?= isset($_SESSION['inputs']['lform-login']) ? $_SESSION['inputs']['lform-login'] : ''; ?>">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputpassword">Password</label>
								<input type="password" name="lform-password" class="form-control" id="inputpassword" value="<?= isset($_SESSION['inputs']['lform-password']) ? $_SESSION['inputs']['lform-password'] : ''; ?>">
							</div>
							<button type="submit" class="btn btn-primary">Log in</button>
						</div>
						</div>
					</div>
				</form>
				<h2>Debug :<h2>
				<?= var_dump($_SESSION); ?>
			</div>
		</div>
	</body>
<!--	<script src='./js/account.js'></script>-->
</html>
