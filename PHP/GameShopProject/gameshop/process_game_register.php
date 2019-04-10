<?php
	// connect to db
	$db = mysqli_connect("localhost", "root", "", "is") or die("Unable to connect to db");
	
	$pavadinimas = $_POST['pavadinimas'];
	$isleidimo_data = $_POST['isleidimo_data'];
	$kaina = $_POST['kaina'];
	$aprasymas = $_POST['aprasymas'];
	$virselio_nuoroda = $_POST['virselio_nuoroda'];
	$turimas_kiekis = $_POST['turimas_kiekis'];
	$parduotas_kiekis = $_POST['parduotas_kiekis'];
	$fk_kurejas = $_POST['fk_kurejas'];

	$sql = "INSERT INTO zaidimas (pavadinimas, isleidimo_data, kaina, aprasymas, virselio_nuoroda, turimas_kiekis, parduotas_kiekis, fk_kurejas)
	VALUES ('$pavadinimas', '$isleidimo_data', '$kaina', '$aprasymas', '$virselio_nuoroda', '$turimas_kiekis', '$parduotas_kiekis', '$fk_kurejas' )";
	$resutl = mysqli_query($db, $sql);
	
	// DISCORD
    $curl = curl_init("https://discordapp.com/api/webhooks/489411996090105866/6slpJgdl8WJZ2hR28OIUbQlvPc5rlT7SYQ7RyiGTigsikBJvw-2-9EilUCp4cF9G2hb7");
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array("content" => "Parduotuvėje jau galite įsigyti **".$pavadinimas."** žaidimą vos už **".$kaina."** eurus !! ")));    
    curl_exec($curl);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array("content" => "@everyone")));
    curl_exec($curl);
	// DISCORD
	
	echo "
			<script type='text/javascript'>
			var answer = confirm (\"Sėkmingai pridėjote naujienlaiškį\")
			if (answer)
			window.location = 'http://localhost/gameshop/admin_games_data_edit.php';
			else
			window.location = 'http://localhost/gameshop/admin_games_data_edit.php';
			</script>";

?>