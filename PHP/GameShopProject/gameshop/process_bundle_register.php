<?php
	// connect to db
	$db = mysqli_connect("localhost", "root", "", "is") or die("Unable to connect to db");
	
	$pavadinimas = $_POST['pavadinimas'];
	$kaina = $_POST['kaina'];
	$nuoroda = "nuoroda";
	$turimasKiekis = $_POST['turimasKiekis'];
	$parduotasKiekis = $_POST['parduotasKiekis'];
	$nuolaida = $_POST['nuolaida'];

	$sql = "INSERT INTO zaidimu_rinkinys (pavadinimas, kaina, virselio_nuoroda, turimas_kiekis, parduotas_kiekis, fk_nuolaida)
	VALUES ('$pavadinimas', '$kaina', '$nuoroda', '$turimasKiekis', '$parduotasKiekis', '$nuolaida' )";
	$resutl = mysqli_query($db, $sql);
	
	header('Location: http://localhost/gameshop/bundle_edit.php');

?>