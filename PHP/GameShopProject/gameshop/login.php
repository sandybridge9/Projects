<!DOCTYPE html>
<html>
	<head>
		<title>Game shop login</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	<head>
	
	<body>
	<div class="header">
		<h2>Login</h2>
	</div>
		<div class="login_form">
			<form action="process_login.php" method="POST">
				<div class="input-group">
					<label>Vartotojo vardas:</label>
					<input type="text" id="prisijungimo_vardas" name="prisijungimo_vardas" />
				</div>
				<div class="input-group">
					<label>Slaptažodis:</label>
					<input type="password" id="slaptazodis" name="slaptazodis" />
				</div>
					<div class="input-group">
					<input type="submit" id="login_button" name="login_button" value="Login" />
				</div>
			</form>
		</div>
		
	</body>
</html>