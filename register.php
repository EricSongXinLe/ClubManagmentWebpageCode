<?php include('server.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Sign up</title>
	<link rel="stylesheet" type="text/css" href="bootstrap.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class = "bg-light">
	<div class="navbar navbar-light bg-white px-3">
		<div class="container">
			<a class="navbar-brand">Sign in</a>
		</div>
	</div>
	<form method = "post" action="register.php">
		<?php include('errors.php'); ?>
		<div class="input-group">
			<label>Username</label>
			<input type = "text" name="username" value="<?php echo $username; ?>">
		</div>
		<div class="input-group">
			<label>Email</label>
			<input type = "text" name="email" value="<?php echo $email; ?>">
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type = "password" name="password_1">
		</div>
		<div class="input-group">
			<label>Confirm Password</label>
			<input type = "password" name="password_2">
		</div>
		<div>
			<button type="submit" name="register" class="btn btn-outline-danger">Sign up</button>
		</div>
		<p>
			Already a member? <a href = "login.php">Sign in</a>
		</p>
	</form>
</body>
</html>