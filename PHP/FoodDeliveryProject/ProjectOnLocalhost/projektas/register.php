<!DOCTYPE html>
<html>
	<head>
		<title>Maisto užsakymų svetainės registracija</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	<head>
	
	<body>
	<div class="header">
		<h2>Naujo Vartotojo registracijos forma</h2>
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
					<label>Prisijungimo vardas:</label>
					<input type="text" id="prisijungimo_vardas" name="prisijungimo_vardas" />
				</div>
				<div class="input-group">
					<label>Slaptažodis:</label>
					<input type="password" id="slaptazodis" name="slaptazodis" />
				</div>
				<div class="input-group">
					<input type="submit" id="register_button" name="register_button" value="Registruotis" />
				</div>
			</form>
		</div>
		
	</body>
</html>