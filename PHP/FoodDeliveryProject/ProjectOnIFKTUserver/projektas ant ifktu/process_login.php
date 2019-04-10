<?php

	session_start();
	// values passed via login page
	
	$db = mysqli_connect("localhost", "tadlau", "veel0bo6shiuJ3Ch", "tadlau") or die("Unable to connect to db");
	
	$prisijungimo_vardas = $_POST['prisijungimo_vardas'];
	$slaptazodis = $_POST['slaptazodis'];
	
	// prevent mysql injection
	$prisijungimo_vardas = stripcslashes($prisijungimo_vardas);
	$slaptazodis = stripcslashes($slaptazodis);
	
	$prisijungimo_vardas = mysqli_real_escape_string($db, $prisijungimo_vardas);
	$slaptazodis = mysqli_real_escape_string($db, $slaptazodis);
	
	// connect to the db
	
	$result = mysqli_query($db, "select * from vartotojas where prisijungimo_vardas = '$prisijungimo_vardas' and slaptazodis = '$slaptazodis'") or die("Unable to find the usser ".mysql_error());
	
	$row = mysqli_fetch_array($result);
	if($row['prisijungimo_vardas' == $prisijungimo_vardas] && $row['slaptazodis'] = $slaptazodis){
		echo"login success user level ".$row['vartotojo_lygis'];
		$_SESSION['loggedin'] = true;
		$_SESSION['username'] = $prisijungimo_vardas;
		$_SESSION['user_id'] = $row['id'];
		$_SESSION['user_level'] = $row['vartotojo_lygis'];
		header('Location: /index.php');
	}else{
		echo"login failed";
		header('Location: /index.php');
	}

?>