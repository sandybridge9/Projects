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
			<form action="process_register.php" method="POST">
			<div class="input-group">
					<label>Vardas:</label>
					<input type="text" id="vardas" name="vardas" />
				</div>
				<div class="input-group">
					<label>Pavardė:</label>
					<input type="text" id="pavarde" name="pavarde" />
				</div>
				<div class="input-group">
					<label>Gimimo data:</label>
					<input type="date" id="gimimo_data" name="gimimo_data" />
				</div>
				<div class="input-group">
					<label>Prisijungimo vardas:</label>
					<input type="text" id="prisijungimo_vardas" name="prisijungimo_vardas" />
				</div>
				<div class="input-group">
					<label>El. Paštas:</label>
					<input type="text" id="el_pastas" name="el_pastas" />
				</div>
				<div class="input-group">
					<label>Slaptažodis:</label>
					<input type="password" id="slaptazodis" name="slaptazodis" />
				</div>
					<div class="input-group">
					<input type="submit" id="login_button" name="login_button" value="Register" />
				</div>
			</form>
		</div>
		
	</body>
</html>