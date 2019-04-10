<?php
	// connect to db
	$db = mysqli_connect("localhost", "root", "", "is") or die("Unable to connect to db");
	
	$vardas = $_POST['vardas'];
	$pavarde = $_POST['pavarde'];
	$gimimo_data = $_POST['gimimo_data'];
	$prisijungimo_vardas = $_POST['prisijungimo_vardas'];
	$slaptazodis = $_POST['slaptazodis'];
	$el_pastas = $_POST['el_pastas'];
	$vartotojo_lygis = "registruotas_vartotojas";

	mysqli_query($db, "INSERT INTO vartotojas (vardas, pavarde, gimimo_data, prisijungimo_vardas, slaptazodis, el_pastas, vartotojo_lygis)
	VALUES ('$vardas', '$pavarde', '$gimimo_data', '$prisijungimo_vardas', '$slaptazodis', '$el_pastas', '$vartotojo_lygis')");

	$user_id = $profile['id'];//mysqli_insert_id();
	mysqli_query($db, "INSERT INTO vartotojo_profilis (fk_vartotojas) VALUES ('$user_id');
	VALUES (')");
	header('Location: http://localhost/gameshop/index.php');

?>