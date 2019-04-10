<?php
	// connect to db
	$db = mysqli_connect("localhost", "root", "", "it") or die("Unable to connect to db");
	
	$vardas = $_POST['vardas'];
	$pavarde = $_POST['pavarde'];
	$prisijungimo_vardas = $_POST['prisijungimo_vardas'];
	$slaptazodis = $_POST['slaptazodis'];
	$vartotojo_lygis = "vartotojas";

	$resutl = mysqli_query($db, "INSERT INTO vartotojas (vardas, pavarde, prisijungimo_vardas, slaptazodis, vartotojo_lygis)
	VALUES ('$vardas', '$pavarde', '$prisijungimo_vardas', '$slaptazodis', '$vartotojo_lygis')");
	header('Location: http://localhost/projektas/index.php');

?>