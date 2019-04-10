<?php
	// connect to db
	$db = mysqli_connect("localhost", "root", "", "it") or die("Unable to connect to db");
	
	$pavadinimas = $_POST['pavadinimas'];
	$fasuote = $_POST['fasuote'];
	$kaina = $_POST['kaina'];
	$svoris = $_POST['svoris'];
	$nuotrauka = $_POST['nuotrauka'];

	$sql = "INSERT INTO preke (pavadinimas, fasuote, kaina, svoris, nuotrauka)
	VALUES ('$pavadinimas', '$fasuote', '$kaina', '$svoris', '$nuotrauka')";
	$resutl = mysqli_query($db, $sql);
	
	// DISCORD
    //$curl = curl_init("https://discordapp.com/api/webhooks/489411996090105866/6slpJgdl8WJZ2hR28OIUbQlvPc5rlT7SYQ7RyiGTigsikBJvw-2-9EilUCp4cF9G2hb7");
    //curl_setopt($curl, CURLOPT_POST, 1);
    //curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array("content" => "Parduotuvėje jau galite įsigyti **".$pavadinimas."** žaidimą vos už **".$kaina."** eurus !! ")));    
    //curl_exec($curl);
    //curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array("content" => "@everyone")));
    //curl_exec($curl);
	// DISCORD
	
	echo "
			<script type='text/javascript'>
			var answer = confirm (\"Sėkmingai pridėjote produktą\")
			if (answer)
			window.location = 'http://localhost/projektas/index.php';
			else
			window.location = 'http://localhost/gameshop/index.php';
			</script>";

?>