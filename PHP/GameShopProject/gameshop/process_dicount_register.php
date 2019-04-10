<?php
	// connect to db
	$db = mysqli_connect("localhost", "root", "", "is") or die("Unable to connect to db");
	
	$pavadinimas = $_POST['pavadinimas'];
	$kiekis = $_POST['kiekis'];
	$kodas = $_POST['kodas'];
	//$id = 2;

	

	$sql = "INSERT INTO nuolaida (pavadinimas, kiekis)
	VALUES ('$pavadinimas', '$kiekis')";
	$resutl = mysqli_query($db, $sql);

	$sql2 = "SELECT * FROM nuolaida";
	$result2 = mysqli_query($db, $sql2);
	while($row = mysqli_fetch_assoc($result2))
	{
		if($row['pavadinimas'] == $pavadinimas){
			$id = $row['id'];
			//echo"ohayo";
		}
	}
	$sql3 = "INSERT INTO nuolaidos_kuponas (kodas, fk_nuolaida)
	VALUES ('$kodas', '$id')";
	$resut3 = mysqli_query($db, $sql3);

	
	header('Location: http://localhost/gameshop/discount_edit.php');

?>