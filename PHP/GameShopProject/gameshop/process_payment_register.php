<?php
	// connect to db
	$db = mysqli_connect("localhost", "root", "", "is") or die("Unable to connect to db");
	
	$pavadinimas = $_POST['pavadinimas'];

	

	$sql = "INSERT INTO mokejimo_budas (pavadinimas)
	VALUES ('$pavadinimas')";
	$resutl = mysqli_query($db, $sql);

	
	header('Location: http://localhost/gameshop/payment_edit.php');

?>