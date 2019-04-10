<!DOCTYPE html>
<html>
	<head>
		<title>Užsakymo sukūrimas</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	<head>
	
	<body>
	<div class="header">
		<h2>Užsakymo sukūrimo forma</h2>
	</div>
		<div class="login_form">
			<form action="make_order.php" method="POST">
				<div class="input-group">
					<label>Adresas:</label>
					<input type="text" id="adresas" name="adresas" />
				</div>
				<div class="input-group">
					<label>Miestas:</label>
					<input type="text" id="miestas" name="miestas" />
				</div>
				<div class="input-group">
					<label>Kortelės numeris:</label>
					<input type="text" id="zzz" name="zzz" />
				</div>
				<div class="input-group">
					<label>Kortelės galiojimo data:</label>
					<input type="text" id="zzzz" name="zzzz" />
				</div>
				<div class="input-group">
					<label>Kortelės CVV kodas:</label>
					<input type="password" id="zzzzz" name="zzzzz" />
				</div>
				<div>
					<label>Mokėjimo tipas:</label>
					<select name="mokėjimo_tipas" required>
					<option selected disabled>Mokėjimas</option>	
					<option value="grynais">Grynais atsiimant</option>
					<option value="kortele">Kortele</option>
					</select>
				</div>
				<div class="input-group">
					<input style="background-color: green;" type="submit" id="order" name="order" value="Užsakyti prekes" />
				</div>
			</form>
		</div>
		
	</body>
</html>