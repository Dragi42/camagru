<html>
	<head>
		<title>Sign up/Sign in</title>
	</head>
	<body>
		<div class="container">
			<div class="starter-template">

				<?php	if(array_key_exists('errors', $_SESSION)):	?>
					<div class="alert alert-danger">
						<?= implode('<br>', $_SESSION['errors']); ?>
					</div>
				<?php endif; ?>
				<?php	if(array_key_exists('success', $_SESSION)): ?>
					<div class="alert alert-success">
						Le compte à bien été créé, un e-mail de confirmation vous à été envoyé.
					</div>
				<?php endif; ?>
				<?php	if(array_key_exists('logged', $_SESSION)): ?>
					<div class="alert alert-success">
						Connexion effectuée
					</div>
				<?php endif; ?>


				<form action="/?module=account&action=create" method="POST">
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
								<input type="password" name="password" class="form-control" id="inputpassword" value="<?= isset($_SESSION['inputs']['password']) ? $_SESSION['inputs']['password'] : ''; ?>">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputmail">Mail</label>
								<input type="email" name="mail" class="form-control" id="inputmail" value="<?= isset($_SESSION['inputs']['mail']) ? $_SESSION['inputs']['mail'] : ''; ?>">
							</div>
							<button type="submit" class="btn btn-primary">Create</button>
						</div>
					</div>
				</form>
			</div>
			<div class="starter-template">
				<form action="/?module=account&action=login" method="POST">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputlogin">Login</label>
								<input type="text" name="login" class="form-control" id="inputlogin" value="<?= isset($_SESSION['inputs']['login']) ? $_SESSION['inputs']['login'] : ''; ?>">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputpassword">Password</label>
								<input type="password" name="password" class="form-control" id="inputpassword" value="<?= isset($_SESSION['inputs']['password']) ? $_SESSION['inputs']['password'] : ''; ?>">
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
</html>
