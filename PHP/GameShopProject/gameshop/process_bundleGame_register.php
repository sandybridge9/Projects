<?php
	// connect to db
	$db = mysqli_connect("localhost", "root", "", "is") or die("Unable to connect to db");
	
	$kolekcija = $_POST['kolekcija'];
	$zaidimas = $_POST['zaidimas'];
	// $nuoroda = "nuoroda";
	// $turimasKiekis = $_POST['turimasKiekis'];
	// $parduotasKiekis = $_POST['parduotasKiekis'];
	// $nuolaida = $_POST['nuolaida'];

	$sql = "INSERT INTO zaidimu_rinkinys_zaidimas (fk_zaidimu_rinkinys, fk_zaidimas)
	VALUES ('$kolekcija', '$zaidimas')";
	$resutl = mysqli_query($db, $sql);
	
	header('Location: http://localhost/gameshop/bundleGame_edit.php');

?>