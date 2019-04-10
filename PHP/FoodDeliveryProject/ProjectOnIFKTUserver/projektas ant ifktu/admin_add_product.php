<!DOCTYPE html>
<html>
	<head>
		<title>Naujo produkto registracija</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	<head>
	
	<body>
	<div class="header">
		<h2>Naujo produkto registracijos forma</h2>
	</div>
		<div class="login_form">
			<form action="add_product.php" method="POST">
				<div class="input-group">
					<label>Pavadinimas:</label>
					<input type="text" id="pavadinimas" name="pavadinimas" />
				</div>
				<div class="input-group">
					<label>Fasuotė:</label>
					<input type="text" id="fasuote" name="fasuote" />
				</div>
				<div class="input-group">
					<label>Kaina(€)(Sveikieji skaičiai):</label>
					<input type="text" id="kaina" name="kaina" />
				</div>
				<div class="input-group">
					<label>Svoris(g.):</label>
					<input type="text" id="svoris" name="svoris" />
				</div>
				<div class="input-group">
					<label>Nuotraukos nuoroda:</label>
					<input type="text" id="nuotrauka" name="nuotrauka" />
				</div>
				<div class="input-group">
					<input type="submit" id="add_product_button" name="add_product_button" value="Pridėti produktą" />
				</div>
			</form>
		</div>
		
	</body>
</html>