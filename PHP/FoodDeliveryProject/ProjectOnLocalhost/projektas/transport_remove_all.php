<!DOCTYPE html>
<?php session_start();
	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == false){
		die("Negalima");
	}else{
		if($_SESSION['user_level'] != "isveziotojas"){
			echo "<script type='text/javascript'>
				var answer = confirm (\"Neturite teisių šiai funkcijai\")
				if (answer)
				window.location = 'http://localhost/projektas/index.php';
				else
				window.location = 'http://localhost/projektas/index.php';

		</script>";
		}else{
		$db=mysqli_connect("localhost", "root", "", "it");
		if(!$db){die ("Negaliu prisijungti prie MySQL:" .mysqli_error($dbc)); }
		}
	} ?>
<html>
	<head>
		<title>Maisto užsakymų svetainė</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	<head>
	
	<body>
	<div class= "title">
			<a href ="index.php"> Maisto užsakymų svetainė </a>
		</div>
		<div>		
		<?php
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			
		if(isset($_POST['begin'])){
			$userId = $_SESSION['user_id'];
			$sqlTransportas = "SELECT * FROM transportas WHERE vairuotojo_id = ".$userId."";
			$resultTransportas = mysqli_query($db, $sqlTransportas);
			$rowTransportas = mysqli_fetch_assoc($resultTransportas);
			$transportoId = $rowTransportas['id'];
			$talpa = $rowTransportas['talpa'];

			$sql = "SELECT * FROM transportuojama_preke WHERE transporto_id = ".$transportoId."";
			$result = mysqli_query($db, $sql);

			$prekiuSvoris = 0;

			while($row = mysqli_fetch_assoc($result)){

				$prekesId = $row['prekes_id'];
				$uzsakymoId = $row['uzsakymo_id'];
				
				$sql1 = "SELECT * FROM preke WHERE id = ".$prekesId."";
				$result1 = mysqli_query($db, $sql1);
				$preke = mysqli_fetch_assoc($result1);
				$prekesSvoris = $preke['svoris'];

				$kiekis = $row['kiekis'];

				$prekiuSvoris = $prekiuSvoris + ($kiekis * $prekesSvoris);
			}
			if($prekiuSvoris <= $talpa){
				$sql2 = "SELECT * FROM transportuojama_preke WHERE transporto_id = ".$transportoId."";
				$result2 = mysqli_query($db, $sql2);
				while($row = mysqli_fetch_assoc($result2)){

					$prekesId = $row['prekes_id'];
					$uzsakymoId = $row['uzsakymo_id'];

					$result = mysqli_query($db, "DELETE from uzsakyta_preke WHERE prekes_id = ".$prekesId." AND uzsakymo_id = ".$uzsakymoId."");
				}
			}/*else{
				echo "
				<script type='text/javascript'>
				var answer = confirm (\"Per didelis prekių svoris šiai transporto priemonei. Padidinkite priemonės talpą arba sumažinkite prekių svorį.\")
				if (answer)
				window.location = 'http://localhost/projektas/transporting_list.php';
				else
				window.location = 'http://localhost/projektas/transporting_list.php';
				</script>";
			}
			echo "
			<script type='text/javascript'>
			var answer = confirm (\"Sėkmingai pašalinote prekę iš krepšelio\")
			if (answer)
			window.location = 'http://localhost/projektas/cart.php';
			else
			window.location = 'http://localhost/projektas/index.php';
			</script>";*/
		}
	}	
	?>	
	</body>
</html>