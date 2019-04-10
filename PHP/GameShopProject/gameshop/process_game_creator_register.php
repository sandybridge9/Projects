<?php
	// connect to db
	$db = mysqli_connect("localhost", "root", "", "is") or die("Unable to connect to db");
	
	$pavadinimas = $_POST['pavadinimas'];

	$resutl = mysqli_query($db, "INSERT INTO kurejas (pavadinimas)
	VALUES ('$pavadinimas')");
	header('Location: http://localhost/gameshop/admin_developer_data_edit.php');

?>